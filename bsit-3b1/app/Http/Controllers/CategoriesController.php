<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::orderBy('created_at', 'desc')->get();
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

        $category = new Category();
        
        $category->name = $request->name;
        $category->image = $filename;
        $category->save();

        return response()->json(['message' => 'Added'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $category = Category::find($id);

        if($request->image !== NULL) {

            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);

            if(Str::contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            }
            else if(Str::contains($exploded[0], 'jpg')) {
                $extension = 'jpg';
            }
            else {
                $extension = 'png';
            }

            $filename = Str::random(30) . '.' . $extension;

            $path = public_path() . '/' . $filename;

            file_put_contents($filename, $decoded);

            $category->name = $request->name;
            $category->image = $filename;
            $category->save();

            return response()->json(['message' => 'Updated Successfully'], 200);
        }
        else {
            $category->name = $request->name;
            $category->save();

            return response()->json(['message' => 'Updated Successfully'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }
}
