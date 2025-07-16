<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Session;
use function Ramsey\Collection\offer;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the current and last month dates
        $currentMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();

        // Calculate orders for the current month
        $total_orders = Order::where('order_status', 'delivered')
            ->whereBetween('created_at', [$currentMonth, now()])
            ->count();

        // Calculate orders for the last month
        $last_month_orders = Order::where('order_status', 'delivered')
            ->whereBetween('created_at', [$lastMonth, $endOfLastMonth])
            ->count();

        // Calculate percentage change for delivered orders
        if ($last_month_orders > 0) {
            $percentage_delivered_change = (($total_orders - $last_month_orders) / $last_month_orders) * 100;
        } else {
            $percentage_delivered_change = $total_orders > 0 ? 100 : 0;
        }

        // Calculate pending orders for current and last month
        $total_pending_orders = Order::where('order_status', 'pending')
            ->whereBetween('created_at', [$currentMonth, now()])
            ->count();
        $last_month_pending_orders = Order::where('order_status', 'pending')
            ->whereBetween('created_at', [$lastMonth, $endOfLastMonth])
            ->count();

        // Calculate percentage change for pending orders
        if ($last_month_pending_orders > 0) {
            $percentage_pending_change = (($total_pending_orders - $last_month_pending_orders) / $last_month_pending_orders) * 100;
        } else {
            $percentage_pending_change = $total_pending_orders > 0 ? 100 : 0;
        }

        // Calculate canceled orders for current and last month
        $this_month_sell = Order::where('order_status', 'delivered')->whereBetween('created_at', [$currentMonth, now()])
            ->sum('grand_total');
        $last_month_sell = Order::where('order_status', 'delivered')->whereBetween('created_at', [$lastMonth, $endOfLastMonth])
            ->sum('grand_total');

        // Calculate percentage change for canceled orders
        if ($last_month_sell > 0) {
            $percentage_sell_change = (($this_month_sell - $last_month_sell) / $last_month_sell) * 100;
        } else {
            $percentage_sell_change = $this_month_sell > 0 ? 100 : 0;
        }

        $total_sell_amount = Order::where('order_status', 'delivered')->sum('grand_total');
        $total_order = Order::count();
        $total_products = Product::count();
        // Other data
        $top_products = Product::where('status', 1)->orderBy('num_of_sale', 'desc')->paginate(9);

        return view('admin.home.index', compact(
            'top_products',
            'total_orders',
            'percentage_delivered_change',
            'total_pending_orders',
            'percentage_pending_change',
            'this_month_sell',
            'percentage_sell_change',
            'total_sell_amount',
            'total_order',
            'total_products'
        ));
    }

    public function testMail(Request $request)
    {
        if (env('MAIL_USERNAME') != null) {
            $data['email'] = $request->email;

            Mail::send('emails.test-mail', ['data' => $data], function ($message) use ($data){
                $message->to($data['email'])->subject('test mail');
            });
        }

        flash()->success('Test Mail', 'Test mail send successfull');
        return redirect()->back();
    }

    public function customer()
    {
        $customers = Customer::latest()->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function customerLogin($id)
    {
        $customer = Customer::find($id);

        Session::put('customer_id', $customer->id);
        Session::put('customer_name', $customer->name);

        return redirect()->route('customer.dashboard')->with('success', 'You are logged in as a customer');
    }

    public function customerDelete($id)
    {
        $customer = Customer::find($id);
        if (file_exists($customer->profile_img))
        {
            unlink($customer->profile_img);
        }
        foreach ($customer->orders as $customerOrder)
        {
            foreach ($customerOrder->orderDetails as $orderDetail)
            {
                $orderDetail->delete();
            }
            $customerOrder->delete();
        }
        $customer->delete();

        return redirect()->back()->with('success', 'Customer Delete successfully');
    }

    public function contactFormShow()
    {
        $contactForms = ContactForm::latest()->paginate(20);
        return view('admin.contact-form.index', compact('contactForms'));
    }

    public function contactFormDetail($id)
    {
        $contactFormDetail = ContactForm::find($id);
        if ($contactFormDetail->read_status == 2)
        {
            $contactFormDetail->read_status = 1;
            $contactFormDetail->save();
        }
        return view('admin.contact-form.detail', compact('contactFormDetail'));
    }

    public function contactFormReplay(Request $request, $id)
    {
        $contactFormDetail = ContactForm::find($id);
        if ($contactFormDetail->replay_status == 2)
        {
            $contactFormDetail->replay_status = 1;
            $contactFormDetail->replay = $request->replay;
            $contactFormDetail->save();
            if (env('MAIL_USERNAME') != null) {
                $data['email'] = $request->toEmail;
                $data['replay'] = $request->replay;
                $data['subject'] = $request->subject;

                Mail::send('emails.replay-mail', ['data' => $data], function ($message) use ($data){
                    $message->to($data['email'])->subject($data['subject']);
                });
                flash()->success('Contact form replay', 'Contact form replay send successfull');
            }
        }
        flash()->success('Contact form replay', 'Contact form replay save successfull');
        return redirect()->back();
    }

    public function profile($id)
    {
        $user = User::find($id);
        return view('user.profile', compact('user'));
    }

    public function profileUpdate(Request $request,$id)
    {
        User::updateUser($request, $id);
        return redirect()->back()->with('success', 'User profile update successfull');
    }


}
