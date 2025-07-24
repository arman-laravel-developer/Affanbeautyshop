<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\District;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingCost;
use App\Models\ShippingFree;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cart;
use Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartProducts = Cart::getContent();
        if (count($cartProducts) > 0) {
            foreach ($cartProducts as $cartProduct) {
                $product = Product::find($cartProduct->attributes->product_id);
                if ($product) {
                    if ($product->is_variant == 1) {
                        // যদি ভ্যারিয়েন্ট থাকে
                        foreach ($product->variants as $variant) {
                            if ($cartProduct->attributes->size == $variant->size_id) {
                                if ($cartProduct->quantity > $variant->qty) {
                                    $excessQuantity = $cartProduct->quantity - $variant->qty;
                                    if ($excessQuantity > 0) {
                                        Cart::update($cartProduct->id, [
                                            'quantity' => -$excessQuantity
                                        ]);
                                    }
                                    session()->flash('info', "The quantity for {$product->name} has been adjusted to the available stock.");
                                }
                                break;
                            }
                        }
                    } else {
                        // যদি কোনো ভ্যারিয়েন্ট না থাকে
                        if ($cartProduct->quantity > $product->stock) {
                            $excessQuantity = $cartProduct->quantity - $product->stock;
                            if ($excessQuantity > 0) {
                                Cart::update($cartProduct->id, [
                                    'quantity' => -$excessQuantity
                                ]);
                            }
                            session()->flash('info', "The quantity for {$product->name} has been adjusted to the available stock.");
                        }
                    }
                }
            }

            $districts = District::orderBy('name', 'asc')->get();
            $customer = Customer::find(Session::get('customer_id'));
            $shippingCosts = ShippingCost::orderBy('id', 'asc')->get();

            // Check if free shipping is active
            $shippingFree = ShippingFree::where('status', 1)->latest()->first();
            $isFreeShipping = false;
            $cartTotalQty = 0;
            $categoryCartQty = 0;

            // Calculate cart quantity and category-specific quantity
            foreach ($cartProducts as $cartProduct) {
                $cartTotalQty += $cartProduct->quantity;

                // Check if product matches the category in the shipping-free offer
                $product = Product::find($cartProduct->attributes->product_id);
                if ($product && $shippingFree && $shippingFree->type === 'category_wise') {
                    $productCategory = $product->category_id;
                    $parentCategoryId = $shippingFree->category_id;

                    $subcategories = Category::where('parent_id', $parentCategoryId)->pluck('id')->toArray();
                    $validCategories = array_merge([$parentCategoryId], $subcategories);

                    if (in_array($productCategory, $validCategories)) {
                        $categoryCartQty += $cartProduct->quantity;
                    }
                }
            }

            if ($shippingFree) {
    $currentDate = Carbon::today();
    $startDate = Carbon::parse($shippingFree->start_date);
    $endDate = Carbon::parse($shippingFree->end_date);

    if ($currentDate->between($startDate, $endDate)) {
        if ($shippingFree->type === 'any' && $cartTotalQty >= $shippingFree->qty) {
            $isFreeShipping = true;
        } elseif ($shippingFree->type === 'category_wise' && $categoryCartQty >= $shippingFree->qty) {
            $isFreeShipping = true;
        } elseif ($shippingFree->type === 'order_total') {
            $cartTotalAmount = $cartProducts->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            if ($cartTotalAmount >= $shippingFree->minimum_purchase) {
                $isFreeShipping = true;
            }
        }
    }
}


            return view('front.checkout.index', compact('districts', 'customer', 'shippingCosts', 'isFreeShipping'));
        } else {
            return redirect()->route('home')->with('error', 'Your cart is empty!');
        }
    }


}
