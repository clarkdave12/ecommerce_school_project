<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specs;

class SpecsController extends Controller
{
    public function index()
    {
        //
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
        $s = Specs::where('product_id', 3)->get();
        
        return response()->json($s);
    }
}
