<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $customer = Customer::find(Session::get('customer_id'));
        $customerOrders = Order::where('customer_id', $customer->id)->latest()->paginate(5);
        $totalOrders = Order::where('customer_id', $customer->id)->latest()->count();
        $totalDeliveredOrders = Order::where('customer_id', $customer->id)->where('order_status', 'delivered')->latest()->count();
        $totalSpend = Order::where('customer_id', $customer->id)->where('order_status', 'delivered')->latest()->sum('grand_total');
        return view('front.customer.dashboard', compact('customer', 'customerOrders', 'totalOrders', 'totalDeliveredOrders', 'totalSpend'));
    }

    public function logout()
    {
        Session::forget('customer_id');
        Session::forget('customer_name');
        Session::forget('active_tab');

        flash()->success('Logged out', 'You have been logged out successfully');
        return redirect()->route('home');
    }

    public function getImageUrl($request)
    {
        $image = $request->file('profile_img');
        $slug = Str::slug($request->name);
        $imageName = $slug.'-'.time().'.'.$image->getClientOriginalExtension();
        $directory = 'customer-profile-images/';
        $image->move($directory, $imageName);
        $imageUrl = $directory.$imageName;
        return $imageUrl;
    }

    public function profileUpdate(Request $request)
    {
        $customer = Customer::find(Session::get('customer_id'));
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->address = $request->address;
        if ($request->file('profile_img'))
        {
            if (file_exists($customer->profile_img))
            {
                unlink($customer->profile_img);
            }
            $imageUrl = $this->getImageUrl($request);
        }
        else
        {
            $imageUrl = $customer->profile_img;
        }
        $customer->profile_img = $imageUrl;
        $customer->save();

        return redirect()->back()->with('success', 'Profile update successfull');
    }

    public function storeActiveTab(Request $request)
    {
        $request->validate([
            'active_tab' => 'required|string',
        ]);

        // Store the active tab in session
        session(['active_tab' => $request->active_tab]);

        return response()->json(['message' => 'Active tab stored']);
    }

    public function passwordUpdate(Request $request)
    {
        // Validate input data
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'old_password.required' => 'The current password is required.',
            'password.required' => 'The new password is required.',
            'password.min' => 'The new password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);
        $customer = Customer::find(Session::get('customer_id'));

        if (password_verify($request->old_password, $customer->password))
        {
            $customer->password = bcrypt($request->password);
            $customer->save();

            flash()->success('Password update', 'Password change successfull');
            return redirect()->back();
        }
        else
        {
            flash()->error('Password update', 'Incorrect password');
            return redirect()->back();
        }
    }
}
