<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return response()->json(['products' => $products], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        return response()->json(['product' => $product], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
