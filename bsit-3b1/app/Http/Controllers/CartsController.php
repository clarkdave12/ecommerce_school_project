<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use DB;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cart::all();
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
        $product = Product::find($request->product_id);
        $price = $product->price * $request->quantity;

        return Cart::create([
            'quantity' => $request->quantity,
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'price' => $price
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
        $cart = DB::table('carts')
                    ->join('products', 'carts.product_id', '=', 'products.id')
                    ->select('carts.id', 'products.image', 'products.name', 'carts.quantity', 'carts.price', 'carts.created_at')
                    ->where('carts.user_id', $id)
                    ->orderBy('carts.created_at', 'desc')
                    ->get();

        return $cart;
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
        $cart = Cart::find($id);

        $cart->delete();

        return response()->json(['Deleted' => $cart], 200);
    }

    public function clearCart($id)
    {
        $carts = Cart::where('user_id', $id)->get();

        foreach($carts as $cart)
        {
            
            $cart->delete();
        }

        return response()->json(['Success' => 'Payment Successfull'], 200);
    }
}
