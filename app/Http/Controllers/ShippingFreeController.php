<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ShippingFree;
use Illuminate\Http\Request;

class ShippingFreeController extends Controller
{
    public function index()
    {
        $shippingFree = ShippingFree::latest()->first();
        $categories = Category::where('status', 1)->where('parent_id', 0)->get();
        return view('admin.offer.shipping-free', compact('shippingFree', 'categories'));
    }

    public function update(Request $request)
{
    $shippingFree = ShippingFree::latest()->first();

    // Separate start and end dates from date range
    if ($request->date_range) {
        [$start_date, $end_date] = explode(' - ', $request->date_range);
    } else {
        $start_date = null;
        $end_date = null;
    }

    if (empty($shippingFree)) {
        $shippingFreeAdd = new ShippingFree();
        $shippingFreeAdd->type = $request->type;

        // Handle category
        $shippingFreeAdd->category_id = $request->type === 'category_wise' ? $request->category_id : null;

        // Handle quantity and minimum purchase
        $shippingFreeAdd->qty = $request->type !== 'order_total' ? $request->qty : null;
        $shippingFreeAdd->minimum_purchase = $request->type === 'order_total' ? $request->minimum_purchase : null;

        $shippingFreeAdd->start_date = $start_date;
        $shippingFreeAdd->end_date = $end_date;
        $shippingFreeAdd->status = $request->status ? $request->status : 2;
        $shippingFreeAdd->save();
    } else {
        $shippingFree->type = $request->type;

        $shippingFree->category_id = $request->type === 'category_wise' ? $request->category_id : null;

        $shippingFree->qty = $request->type !== 'order_total' ? $request->qty : null;
        $shippingFree->minimum_purchase = $request->type === 'order_total' ? $request->minimum_purchase : null;

        $shippingFree->start_date = $start_date;
        $shippingFree->end_date = $end_date;
        $shippingFree->status = $request->status ? $request->status : 2;
        $shippingFree->save();
    }

    flash()->success('Shipping free offer', 'Shipping free offer updated successfully');
    return redirect()->back();
}
}
