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
            if ($request->type == 'any')
            {
                $shippingFreeAdd->category_id = null;
            }
            else
            {
                $shippingFreeAdd->category_id = $request->category_id;
            }
            $shippingFreeAdd->qty = $request->qty;
            $shippingFreeAdd->start_date = $start_date;
            $shippingFreeAdd->end_date = $end_date;
            $shippingFreeAdd->status = $request->status ? $request->status : 2;
            $shippingFreeAdd->save();
        } else {
            $shippingFree->type = $request->type;
            if ($request->type == 'any')
            {
                $shippingFree->category_id = null;
            }
            else
            {
                $shippingFree->category_id = $request->category_id;
            }
            $shippingFree->qty = $request->qty;
            $shippingFree->start_date = $start_date;
            $shippingFree->end_date = $end_date;
            $shippingFree->status = $request->status ? $request->status : 2;
            $shippingFree->save();
        }

        flash()->success('Shipping free offer', 'Shipping free offer updated successfully');
        return redirect()->back();
    }
}
