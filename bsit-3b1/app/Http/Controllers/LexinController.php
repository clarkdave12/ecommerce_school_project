<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class LexinController extends Controller
{
    public function productByCategory($category)
    {
        $products = Product::where('category_id', $category)->get();
        return response()->json($products);
    }

    public function productInfo($id) {

        $productInfo = Product::find($id);

        return response()->json($productInfo);
    }
}
