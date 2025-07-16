<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function index()
    {
//        $cartProducts = Cart::getTotal();
//        dd($cartProducts);
        return view('front.cart.index');
    }
    public function addToCart(Request $request)
    {
        try {
            // Retrieve product by ID
            $product = Product::find($request->input('product_id'));

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
            }

            // Retrieve input values
            $size = $request->input('size');
            $color = $request->input('color');
            $quantity = $request->input('quantity');
            $discount = $request->input('discount');
            $discountType = $request->input('discountType');
            $price = $request->input('price');
            $thumbnailImage = $request->input('thumbnail_image', $product->thumbnail_img);

            // Retrieve current cart items
            $cartItems = Cart::getContent();
            $itemToUpdate = null;

            if ($color)
            {
                // Check if item with the same ID and size already exists in the cart
                foreach ($cartItems as $item) {
                    if ($item->attributes->product_id == $product->id && $item->attributes->color == $color) {
                        $itemToUpdate = $item;
                        break;
                    }
                }
            }
            elseif($size)
            {
                // Check if item with the same ID and size already exists in the cart
                foreach ($cartItems as $item) {
                    if ($item->attributes->product_id == $product->id && $item->attributes->size == $size) {
                        $itemToUpdate = $item;
                        break;
                    }
                }
            }
            else
            {
                // Check if item with the same ID and size already exists in the cart
                foreach ($cartItems as $item) {
                    if ($item->attributes->product_id == $product->id && $item->attributes->size == $size && $item->attributes->color == $color) {
                        $itemToUpdate = $item;
                        break;
                    }
                }
            }

            if ($itemToUpdate) {
                // Update quantity if item exists
                Cart::update($itemToUpdate->id, array(
                    'quantity' => $quantity, // Set quantity directly from the request
                ));
            } else {
                // Add new item to the cart
                Cart::add(array(
                    'id' => uniqid(), // Unique identifier for the new item
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'attributes' => array(
                        'product_id' => $product->id,
                        'size' => $size,
                        'color' => $color,
                        'discount' => $discount,
                        'discount_type' => $discountType,
                        'thumbnail_image' => $thumbnailImage,
                    ),
                ));
            }

            if ($request->button == 2)
            {
                return redirect()->route('checkout');
            }
            else
            {
                return response()->json(['success' => true, 'message' => 'Product added to cart.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function cartTotal()
    {
        // Calculate the total value of the cart
        $cartTotal = Cart::getTotal();

        // Return the total as a JSON response
        return response()->json(['success' => true, 'total' => $cartTotal]);
    }

    public function removeFromCart(Request $request, $productId)
    {
        try {
            // Remove the product from the cart
            Cart::remove($productId);

            // Get the updated total
            $total = Cart::getTotal();
            $cartCount = count(Cart::getContent());

            return response()->json(['success' => true, 'total' => $total, 'cartCount' => $cartCount]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function dropdown()
    {
        $cartProducts = Cart::getContent();
        $total = Cart::getTotal();
        $cartCount = count(Cart::getContent());
        return view('front.partials.cart-dropdown', compact('cartProducts', 'total', 'cartCount'));
    }

    public function updateSize(Request $request)
    {
        $cartProductId = $request->input('cart_product_id');
        $sizeId = $request->input('size_id');
        $productId = $request->input('product_id');

        // Retrieve the cart item
        $cartItem = Cart::get($cartProductId);
        if ($cartItem) {
            // Retrieve the new price from the variants table
            $variant = Variant::where('product_id', $productId)
                ->where('size_id', $sizeId)
                ->first();

            $product = Product::find($variant->product_id);
            $newPrice = $variant->price;

            if ($product->discount > 0) {
                if ($product->discount_type == 2) {
                    $newPrice = $variant->price - ($variant->price * ($product->discount / 100));
                } else {
                    $newPrice = $variant->price - $product->discount;
                }
            }

            // Check if the requested size already exists in another cart item
            foreach (Cart::getContent() as $item) {
                if ($item->id !== $cartProductId && $item->attributes->size == $sizeId && $item->attributes->product_id == $productId) {
                    // Remove the existing cart item with the same size
                    Cart::remove($item->id);
                    break;
                }
            }

            if ($variant) {

                if ($variant->qty == 0)
                {
                    Cart::remove($cartProductId);
                }
                // Update the size and price in the cart item attributes
                $attributes = $cartItem->attributes;
                $attributes['size'] = $sizeId; // Update the size_id attribute

                // Update the cart item with new attributes and price
                Cart::update($cartProductId, [
                    'attributes' => $attributes,
                    'price' => $newPrice // Update the price
                ]);

                return redirect()->back();
            }

            return response()->json(['success' => false, 'message' => 'Variant not found'], 404);
        }

        return response()->json(['success' => false], 400);
    }

    public function updateColor(Request $request)
    {
        $cartProductId = $request->input('cart_product_id');
        $colorId = $request->input('color_id');
        $productId = $request->input('product_id');

        // Retrieve the cart item
        $cartItem = Cart::get($cartProductId);
        if ($cartItem) {
            // Retrieve the new price from the variants table
            $variant = Variant::where('product_id', $productId)
                ->where('color_id', $colorId)
                ->first();

            $product = Product::find($variant->product_id);
            $newPrice = $variant->price;

            if ($product->discount > 0) {
                if ($product->discount_type == 2) {
                    $newPrice = $variant->price - ($variant->price * ($product->discount / 100));
                } else {
                    $newPrice = $variant->price - $product->discount;
                }
            }

            // Check if the requested size already exists in another cart item
            foreach (Cart::getContent() as $item) {
                if ($item->id !== $cartProductId && $item->attributes->color == $colorId && $item->attributes->product_id == $productId) {
                    // Remove the existing cart item with the same size
                    Cart::remove($item->id);
                    break;
                }
            }

            if ($variant) {

                if ($variant->qty == 0)
                {
                    Cart::remove($cartProductId);
                }
                // Update the size and price in the cart item attributes
                $attributes = $cartItem->attributes;
                $attributes['color'] = $colorId; // Update the size_id attribute

                // Update the cart item with new attributes and price
                Cart::update($cartProductId, [
                    'attributes' => $attributes,
                    'price' => $newPrice // Update the price
                ]);

                return redirect()->back();
            }

            return response()->json(['success' => false, 'message' => 'Variant not found'], 404);
        }

        return response()->json(['success' => false], 400);
    }

    public function updateQuantity(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $newQuantity = $request->input('quantity');

            Cart::update($productId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $newQuantity
                ),
            ));

            $cart = Cart::getContent();
            $subtotal = Cart::getSubTotal();
            $total = Cart::getTotal();
            $rowTotal = $cart[$productId]->price * $newQuantity;

            return response()->json([
                'success' => true,
                'subtotal' => $subtotal,
                'total' => $total,
                'rowTotal' => $rowTotal
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
