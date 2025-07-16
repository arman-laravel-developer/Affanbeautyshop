<?php

namespace App\Http\Controllers;

use App\Models\ShippingCost;
use Illuminate\Http\Request;

class ShippingCostController extends Controller
{
    public function index()
    {
        $shippingCosts = ShippingCost::all();
        return view('admin.shipping-cost.manage', compact('shippingCosts'));
    }

    public function create(Request $request)
    {
        $shippingCost = new ShippingCost();
        $shippingCost->address_name = $request->address_name;
        $shippingCost->city_id = $request->city_id;
        $shippingCost->shipping_cost = $request->shipping_cost;
        $shippingCost->save();

        return redirect()->back()->with('success', 'Shipping Cost add successfully');
    }

    public function edit($id)
    {
        $shippingCost = ShippingCost::find($id);

        return response()->json([
            'status' => 200,
            'shippingCost' => $shippingCost
        ]);
    }

    public function update(Request $request)
    {
        $shippingCost = ShippingCost::find($request->shipping_cost_id);
        $shippingCost->address_name = $request->address_name;
        $shippingCost->city_id = $request->city_id;
        $shippingCost->shipping_cost = $request->shipping_cost;
        $shippingCost->save();

        return redirect()->route('shipping-cost.manage')->with('success', 'Shipping Cost update successfully');
    }

    public function delete($id)
    {
        $shippingCost = ShippingCost::find($id);
        $shippingCost->delete();

        return redirect()->route('shipping-cost.manage')->with('success', 'Shipping Cost delete successfully');
    }
}
