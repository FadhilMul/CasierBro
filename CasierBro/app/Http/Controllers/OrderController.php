<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Request $request)
    {
        // Decode JSON data dari query string 'order'
        $orderData = $request->query('order') ? json_decode($request->query('order'), true) : [
            'items' => [],
            'discount' => 0,
            'subtotal' => 0,
        ];

        return view('order-confirmation', ['orderData' => $orderData]);
    }
}
