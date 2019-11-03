<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrdersController extends Controller
{
    public function index()
    {
        return Order::orderBy('created_at', 'desc')->where('state', 'approved')->get();
    }

    public function history($id)
    {
        return Order::orderBy('created_at', 'desc')->where('user_id', $id)->get();
    }
}
