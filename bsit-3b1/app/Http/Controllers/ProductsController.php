<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use DB;
use App\Popular;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return response()->json(['products' => $products], 200);
    }

    public function store(Request $request)
    {
        $exploded = explode(',', $request->image);
        $decoded = base64_decode($exploded[1]);

        if(Str::contains($exploded[0], 'jpeg')) {
            $extension = 'jpg';
        }
        else {
            $extension = 'png';
        }

        $filename = Str::random(30) . '.' . $extension;

        $path = public_path() . '/' . $filename;

        file_put_contents($filename, $decoded);

        return Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $filename
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        return response()->json(['product' => $product], 200);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if($request->image !== NULL) {
            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);

            if(Str::contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            }
            else {
                $extension = 'png';
            }

            $filename = Str::random(30) . '.' . $extension;

            $path = public_path() . '/' . $filename;

            file_put_contents($filename, $decoded);

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->image = $filename;
            $product->save();
        }
        else {
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->save();
        }

        return response()->json(['Message' => 'Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();

        return response()->json(['message' => 'Product Deleted'], 200);
    }

    public function productSearch(Request $request) 
    {
        return Product::where('name', 'like', '%' . $request->search . '%')->get();
    }

    public function newProducts()
    {
        return Product::orderBy('created_at', 'desc')->limit(8)->get();
    }

    public function getMostPopular()
    {
        return DB::table('populars')
                ->join('products', 'populars.product_id', '=', 'products.id')
                ->select('products.id', 'products.name', 'products.description', 'products.price', 'products.image', 'populars.sold')
                ->orderBy('populars.sold', 'desc')
                ->limit(10)
                ->get();
    }

    public function searchByCategory($id)
    {
        return Product::orderBy('created_at', 'desc')->where('category_id', $id)->get();
    }
}
