<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;

class SalesController extends Controller
{
    public function getSales($month, $year)
    {
        return Sale::whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();
    }
}
