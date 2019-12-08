<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Sale;
use DB;

class OrdersController extends Controller
{
    public function index()
    {
        return Order::orderBy('created_at', 'desc')->where('state', 'approved')->get();
    }

    public function history($id)
    {
        return Sale::orderBy('created_at', 'desc')->where('user_id', $id)->get();
    }

    public function historyProducts($order_id)
    {
        return DB::table('orders')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->where('orders.order_id', $order_id)
                ->select('products.id', 'products.name', 'products.image', 'products.price')
                ->get();
    }

    public function profileHistory($id)
    {
        return DB::table('orders')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->where('orders.user_id', $id)
                ->select('orders.id', 'orders.order_id', 'orders.quantity', 'orders.status', 'orders.price', 'products.name', 'products.image')
                ->get();
    }
}
