<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function index()
    {
        return view('front.track.index');
    }

    public function result(Request $request)
    {
        $order = Order::where('order_code', $request->order_code)->first();
        $order_code = $request->order_code;
        return view('front.track.result', compact('order', 'order_code'));
    }
}
