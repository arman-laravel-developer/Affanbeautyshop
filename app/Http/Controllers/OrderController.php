<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\Models\GeneralSetting;
use App\Models\Variant;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Str;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Mail;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('admin.order.index', compact('orders'));
    }
    public function pending()
    {
        $orders = Order::where('order_status', 'pending')->orderBy('id', 'desc')->get();
        return view('admin.order.pending', compact('orders'));
    }
    public function in_completed()
    {
        $orders = Order::where('order_status', 'in_completed')->orderBy('id', 'desc')->get();
        return view('admin.order.in_completed', compact('orders'));
    }
    public function confirmed()
    {
        $orders = Order::where('order_status', 'confirmed')->orderBy('id', 'desc')->get();
        return view('admin.order.confirmed', compact('orders'));
    }
    public function proccessing()
    {
        $orders = Order::where('order_status', 'proccessing')->orderBy('id', 'desc')->get();
        return view('admin.order.proccessing', compact('orders'));
    }
    public function delivered()
    {
        $orders = Order::where('order_status', 'delivered')->orderBy('id', 'desc')->get();
        return view('admin.order.delivered', compact('orders'));
    }
    public function shipped()
    {
        $orders = Order::where('order_status', 'shipped')->orderBy('id', 'desc')->get();
        return view('admin.order.shipped', compact('orders'));
    }
    public function canceled()
    {
        $orders = Order::where('order_status', 'cancel')->orderBy('id', 'desc')->get();
        return view('admin.order.canceled', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::find($id);
        return view('admin.order.show', compact('order'));
    }

//    public function invoice($id)
//    {
//        $order = Order::find($id);
//        $setting = GeneralSetting::latest()->first();
//        // Convert the image to a base64 string
//        $imagePath = asset($setting->header_logo);
//        $imageData = base64_encode(file_get_contents($imagePath));
//        $imageSrc = 'data:image/png;base64,' . $imageData;
//
//        // Convert the image to a base64 string
//        $paidImagePath = asset('front/assets/images/paid.png');
//        $paidImageData = base64_encode(file_get_contents($paidImagePath));
//        $paidImageSrc = 'data:image/png;base64,' . $paidImageData;
//        // Convert the image to a base64 string
//
//        $unpaidImagePath = asset('front/assets/images/unpaid.png');
//        $unpaidImageData = base64_encode(file_get_contents($unpaidImagePath));
//        $unpaidImageSrc = 'data:image/png;base64,' . $unpaidImageData;
//
//        if (!$order) {
//            abort(404, 'Order not found');
//        }
//
//        $pdf = PDF::loadView('front.invoice.invoice', [
//            'order' => $order,
//            'imageSrc' => $imageSrc,
//            'paidImageSrc' => $paidImageSrc,
//            'unpaidImageSrc' => $unpaidImageSrc
//        ]);
//        $code = $order->order_code;
//        return $pdf->download("{$code}_invoice.pdf");
//
////        return view('front.invoice.invoice', [
////            'order' => $order,
////            'imageSrc' => $imageSrc,
////            'paidImageSrc' => $paidImageSrc,
////            'unpaidImageSrc' => $unpaidImageSrc
////        ]);
//
////        $pdf = App::make('dompdf.wrapper');
////        $pdf->loadHTML('<h1>Test</h1>');
////        return $pdf->stream();
//    }
    public function invoice($id)
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'UTF-8',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'default_font' => 'nikosh',
        ]);
        $order = Order::find($id);
        $setting = GeneralSetting::latest()->first();
        // Convert the image to a base64 string
        $imagePath = asset($setting->header_logo);
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        // Convert the image to a base64 string
        $paidImagePath = asset('front/assets/images/apaid.png');
        $paidImageData = base64_encode(file_get_contents($paidImagePath));
        $paidImageSrc = 'data:image/png;base64,' . $paidImageData;
        // Convert the image to a base64 string

        $unpaidImagePath = asset('front/assets/images/unpaid.png');
        $unpaidImageData = base64_encode(file_get_contents($unpaidImagePath));
        $unpaidImageSrc = 'data:image/png;base64,' . $unpaidImageData;

        if (!$order) {
            abort(404, 'Order not found');
        }
        $pdf = view('front.invoice.invoice', [
            'order' => $order,
            'imageSrc' => $imageSrc,
            'paidImageSrc' => $paidImageSrc,
            'unpaidImageSrc' => $unpaidImageSrc
        ])->render();
        $code = $order->order_code;
        $mpdf->WriteHTML($pdf);
//        $mpdf->Output();
        $mpdf->Output($code . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }





    public function store(Request $request)
    {
        $cartProducts = Cart::getContent();

        if (count($cartProducts) < 1)
        {
            flash()->error('error','Cart is empty!');
            return redirect()->route('all.products');
        }
        $quantity = $cartProducts->sum('quantity');

        if ($request->shipping ==  1)
        {
            $shipping_cost = $request->shipping_cost;
        }
        else
        {
            $shipping_cost = $request->shipping_cost;
        }
        $order_total = Cart::getTotal();

        $order = Order::where('order_status', 'in_completed')
            ->where('id', Session::get('order_id'))
            ->first();

        if (!$order) {
            $order = new Order();
        }
        $order->name = $request->name;
        $order->email = $request->email;
        $order->mobile = $request->mobile;
        $order->order_code = date('ymd-His') . '-' . rand(11111, 99999);
        if ($request->agree_to_create_account == 1)
        {
            $request->validate([
                'email' => [
                    'required',
                    'unique:customers'
                ],
                'mobile' => [
                    'required',
                    'unique:customers'
                ]
            ], [
                'email.required' => 'Email is required to create an account.',
                'email.unique' => 'This email is already registered. Please use a different email or log in.',
                'mobile.required' => 'Mobile number is required to create an account.',
                'mobile.unique' => 'This mobile number is already registered. Please use a different number or log in.',
            ]);
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->mobile = $request->mobile;
            $customer->password = bcrypt($request->mobile);
            $customer->save();
            Session::put('customer_id', $customer->id);
            Session::put('customer_name', $request->name);
        }elseif (Session::get('customer_id'))
        {
            $order->order_type = 'registered_customer';
            $order->customer_id = Session::get('customer_id');
        }
        else
        {
            $order->order_type = 'guest';
        }
        $order->grand_total = $order_total;
        $order->total_qty = $quantity;
        $order->alt_mobile = $request->alt_mobile;
        $order->address = $request->address;
        $order->shipping_cost = $shipping_cost;
        $order->order_note = $request->order_note;
        $order->city_id = $request->city_id;
        $order->payment_method = $request->payment_method;
        $order->order_status = 'in_completed';
        $order->delivery_status = 'pending';
        if ($request->payment_method == 1)
        {
            $order->payment_method = 'bkash';
            if ($request->sender_account_bkash)
            {
                $order->payment_status = 'proccessing';
            }
        } else if ($request->payment_method == 2)
        {
            $order->payment_method = 'nagad';
            if ($request->sender_account_nagad)
            {
                $order->payment_status = 'proccessing';
            }
        }
        else
        {
            $order->payment_method = 'cash on delivery';
            $order->payment_status = 'pending';
        }
        $order->save();
        if ($request->payment_method == 1)
        {
            $payment_history = new PaymentHistory();
            $payment_history->order_id = $order->id;
            $payment_history->payment_method = 'bkash';
            $payment_history->payment_status = 'proccessing';
            $payment_history->sender_account = $request->sender_account_bkash;
            $payment_history->amount = $order_total + $shipping_cost;
            $payment_history->tr_id = Str::random(10);
            $payment_history->save();

        } else if ($request->payment_method == 2)
        {
            $payment_history = new PaymentHistory();
            $payment_history->order_id = $order->id;
            $payment_history->payment_method = 'nagad';
            $payment_history->payment_status = 'proccessing';
            $payment_history->sender_account = $request->sender_account_nagad;
            $payment_history->amount = $order_total + $shipping_cost;
            $payment_history->tr_id = Str::random(10);
            $payment_history->save();
        }
        else
        {
            $payment_history = new PaymentHistory();
            $payment_history->order_id = $order->id;
            $payment_history->payment_method = 'cash on delivery';
            $payment_history->payment_status = 'pending';
            $payment_history->amount = $order_total + $shipping_cost;
            $payment_history->save();
        }
        $cartProducts = Cart::getContent();

        foreach ($cartProducts as $cartProduct) {
            // Check if the product with the specific color_id and size_id exists in the order details
            $orderDetail = OrderDetail::where('order_id', $order->id)
                ->where('product_id', $cartProduct->attributes->product_id)
                ->where('color_id', $cartProduct->attributes->color ?? null)
                ->where('size_id', $cartProduct->attributes->size ?? null)
                ->first();

            if ($orderDetail) {
                // If the order detail exists, update it (increase quantity if needed)
                $orderDetail->qty = $cartProduct->quantity; // Increment the quantity
                $orderDetail->price = $cartProduct->price;
                $orderDetail->discount = $cartProduct->attributes->discount;
                $orderDetail->discount_type = $cartProduct->attributes->discount_type;
                $orderDetail->color_id = $cartProduct->attributes->color ?? null;
                $orderDetail->size_id = $cartProduct->attributes->size ?? null;
                $orderDetail->save();
            } else {
                // If not exists, create a new record
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cartProduct->attributes->product_id,
                    'price' => $cartProduct->price,
                    'qty' => $cartProduct->quantity,
                    'discount' => $cartProduct->attributes->discount,
                    'discount_type' => $cartProduct->attributes->discount_type,
                    'color_id' => $cartProduct->attributes->color ?? null,
                    'size_id' => $cartProduct->attributes->size ?? null
                ]);
            }

            // Optionally remove the item from the cart after processing
            // Cart::remove($cartProduct->id);
        }

        //sent invoice
//        if ($request->email != null)
//        {
//            $this->sendOrderInvoice($order);
//        }
//        $this->sendOrderInvoiceToAdmin($order);

        Session::put('order_id', $order->id);
        return response()->json([
            'success' => true,
            'order_id' => $order->id
        ]);
//        flash()->success('Order place', 'Your order has been placed! thank you');
//        return redirect()->route('order.confirmation');

    }

    public function storeBtn(Request $request)
    {
        $order = Order::where('order_status', 'in_completed')
            ->where('id', Session::get('order_id'))
            ->first();

        if ($order) {
            $order->order_status = 'pending'; // Confirm the order
            $order->delivery_status = 'pending';
            $order->save();

            $cartProducts = Cart::getContent();

            $variant = null;

            foreach ($cartProducts as $cartProduct) {
                // Decrease stock in the products table
                $product = Product::find($cartProduct->attributes->product_id);
                if ($product) {
                    $product->num_of_sale += $cartProduct->quantity; // Increase the number of sales
                    $product->stock -= $cartProduct->quantity; // Decrease total product stock
                    $product->save();
                }

                // Decrease stock in the variants table (size-wise and color-wise)
                $variantQuery = Variant::where('product_id', $cartProduct->attributes->product_id);

                // If size_id and color_id both exist in the cart product attributes, filter by both
                if (isset($cartProduct->attributes->size) && isset($cartProduct->attributes->color_id)) {
                    $variant = $variantQuery->where('size_id', $cartProduct->attributes->size)
                        ->where('color_id', $cartProduct->attributes->color)
                        ->first();
                }
                // If only size_id exists, filter by size_id
                elseif (isset($cartProduct->attributes->size)) {
                    $variant = $variantQuery->where('size_id', $cartProduct->attributes->size)->first();
                }
                // If only color_id exists, filter by color_id
                elseif (isset($cartProduct->attributes->color)) {
                    $variant = $variantQuery->where('color_id', $cartProduct->attributes->color)->first();
                }

                if ($variant) {
                    $variant->qty -= $cartProduct->quantity; // Decrease variant stock
                    $variant->save();
                }

                // Remove product from the cart
                Cart::remove($cartProduct->id);
            }
        }
        return redirect()->route('order.confirmation')->with('success', 'Your order has been placed! Thank you.');
    }

    public function delete($id)
    {
        $order = Order::find($id);
        $orderDetails = OrderDetail::where('order_id', $order->id)->get();
        $paymentHistories = PaymentHistory::where('order_id', $order->id)->get();

        foreach ($orderDetails as $orderDetail)
        {
            $orderDetail->delete();
        }
        foreach ($paymentHistories as $paymentHistory)
        {
            $paymentHistory->delete();
        }
        $order->delete();

        flash()->success('Order Delete', 'Order delete successfully');
        return redirect()->back();
    }

    public function paymentStatusUpdate(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->payment_status = $request->payment_status;
        $order->save();

        //sent invoice
        if ($order->email != null)
        {
            $this->sendOrderInvoice($order);
        }

        return redirect()->back()->with('success', 'Payment status update successfull');
    }
    public function orderStatusUpdate(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->order_status = $request->order_status;
        $order->save();

        //sent invoice
        //sent invoice
        if ($order->email != null)
        {
            $this->sendOrderInvoice($order);
        }

        if ($request->order_status == 'cancel')
        {
            foreach ($order->orderDetails as $orderDetail)
            {
                // Decrease stock in the products table
                $product = Product::find($orderDetail->product_id);
                if ($product) {
                    $product->num_of_sale -= $orderDetail->qty; // Increase the number of sales
                    $product->stock += $orderDetail->qty; // Decrease total product stock
                    $product->save();
                }

                // Decrease stock in the variants table (size-wise)
                $variant = Variant::where('product_id', $orderDetail->product_id)
                    ->where('size_id', $orderDetail->size_id)
                    ->first();
                if ($variant) {
                    $variant->qty += $orderDetail->qty; // Decrease variant stock
                    $variant->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Order status update successfull');
    }

    public function orderConfirmation()
{
    $orderId = Session::get('order_id');

    if (!$orderId) {
        return redirect()->route('home')->with('error', 'No order found.');
    }

    $order = Order::find($orderId);

    // Forget the session after retrieving
    Session::forget('order_id');

    return view('front.pages.order-confirmation', compact('order'));
}


    function sendOrderInvoice($order)
    {
        if (env('MAIL_USERNAME') != null) {
            // Prepare email data
            $data['name'] = $order->name;
            $data['email'] = $order->email;
            $data['order'] = $order;

            // Convert the image to a base64 string
            $imagePath = asset('front/assets/images/fashionistha.png');
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageSrc = 'data:image/png;base64,' . $imageData;

            // Convert the image to a base64 string
            $paidImagePath = asset('front/assets/images/paid.png');
            $paidImageData = base64_encode(file_get_contents($paidImagePath));
            $paidImageSrc = 'data:image/png;base64,' . $paidImageData;
            // Convert the image to a base64 string

            $unpaidImagePath = asset('front/assets/images/unpaid.png');
            $unpaidImageData = base64_encode(file_get_contents($unpaidImagePath));
            $unpaidImageSrc = 'data:image/png;base64,' . $unpaidImageData;

            if (!$order) {
                abort(404, 'Order not found');
            }

            $pdf = PDF::loadView('front.invoice.invoice', [
                'order' => $order,
                'imageSrc' => $imageSrc,
                'paidImageSrc' => $paidImageSrc,
                'unpaidImageSrc' => $unpaidImageSrc
            ]);
            $code = $order->order_code;

            // Send mail with PDF attachment
            Mail::send('emails.order_summary', ['data' => $data], function ($message) use ($data, $pdf, $code) {
                $message->to($data['email'])->subject('Your Order Invoice');
                $message->attachData($pdf->output(), "{$code}_invoice.pdf");
            });
        }
    }

    function sendOrderInvoiceToAdmin($order)
    {
        $setting = GeneralSetting::latest()->first();

        // Check if mail configuration is available
        if (env('MAIL_USERNAME') != null) {
            // Prepare email data
            $data = [
                'name' => $order->name,
                'mobile' => $order->mobile,
                'email' => $setting->email,
                'order' => $order,
            ];
            $orderCode = $order->order_code;
            // Send mail with PDF attachment (if necessary)
            Mail::send('emails.order_summary_to_admin', ['data' => $data], function ($message) use ($data, $orderCode) {
                $message->to($data['email'])
                    ->subject('Your Order Invoice "' . $orderCode . '"');
            });
        }
    }

    public function fetchCourierReport($id)
    {
        $order = Order::findOrFail($id);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('BDCOURIER_API_KEY'),
                'Accept' => 'application/json',
            ])->post('https://bdcourier.com/api/courier-check', [
                'phone' => $order->mobile,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $courierData = $data['courierData'] ?? [];

                $result = [
                    'total_order' => $courierData['summary']['total_parcel'] ?? 0,
                    'total_delivered' => $courierData['summary']['success_parcel'] ?? 0,
                    'total_cancelled' => $courierData['summary']['cancelled_parcel'] ?? 0,
                    'couriers' => []
                ];

                foreach ($courierData as $courier => $info) {
                    if ($courier === 'summary') continue;

                    $result['couriers'][$courier] = [
                        'order' => $info['total_parcel'] ?? 0,
                        'delivered' => $info['success_parcel'] ?? 0,
                        'cancelled' => $info['cancelled_parcel'] ?? 0,
                        'success_rate' => $info['success_ratio'] ?? '0%',
                    ];
                }

                return response()->json(['success' => true, 'data' => $result]);
            }

        } catch (\Exception $e) {
            logger()->error("Courier API error: " . $e->getMessage());
        }

        return response()->json(['success' => false, 'message' => 'Failed to fetch data']);
    }
}
