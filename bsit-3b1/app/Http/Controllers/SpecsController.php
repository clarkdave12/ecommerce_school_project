<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specs;
use DB;

class SpecsController extends Controller
{
    public function index()
    {
        return DB::table('categories')
                ->join('products', 'categories.id', '=', 'products.category_id')
                ->join('specs', 'products.id', '=', 'specs.product_id')
                ->select('specs.id', 'specs.label')
                ->where('products.category_id', 2)
                ->get();
    }

    public function store(Request $request)
    {
        $s = new Specs();
        $s->product_id = $request->product_id;
        $s->specs = $request->specs;
        $s->label = $request->label;
        $s->save();

        return response()->json(['success', 'Specs Added'], 200);
    }

    public function show($id)
    {
        $s = Specs::where('product_id', $id)->get();
        
        return response()->json($s);
    }
}
