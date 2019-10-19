<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\User;

use DB;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = DB::table('feedback')
                    ->join('products', 'feedback.product_id', '=', 'products.id')
                    ->join('users', 'feedback.user_id', '=', 'users.id')
                    ->select('feedback.comment', 'feedback.ratings', 'products.name', 'products.description', 'products.price', 'users.first_name', 'users.last_name')
                    ->get();
        return $data;
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
        return Feedback::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('feedback')
                    ->join('products', 'feedback.product_id', '=', 'products.id')
                    ->join('users', 'feedback.user_id', '=', 'users.id')
                    ->where('feedback.product_id', $id)
                    ->select('feedback.comment', 'feedback.ratings', 'users.first_name', 'users.last_name')
                    ->get();

        if(count($data) == 0) {
            return response()->json(['error' => 'No feedback for this product yet.'], 404);
        }

        return response()->json(['feedbacks' => $data], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
