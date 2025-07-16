<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Mail;


class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'password' => 'required|min:6',
            'email' => 'required|unique:customers',
            'mobile' => 'required|unique:customers'
        ]);
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->password = bcrypt($request->password);
        $customer->agree_to_policy = $request->policy;
        $customer->save();

        Session::put('customer_id', $customer->id);
        Session::put('customer_name', $request->name);

        flash()->success('Registration complete', 'You have been logged in successfull');
        return redirect()->route('customer.dashboard');
    }

    public function loginCheck(Request $request)
    {
        // Attempt to find the customer by email or mobile
        $customer = Customer::where('email', $request->email)->orWhere('mobile', $request->email)->first();
//        dd($customer);
        if ($customer) {
            // Check if the provided password matches the stored hashed password
            if (password_verify($request->password, $customer->password)) {
                // Store customer details in the session
                Session::put('customer_id', $customer->id);
                Session::put('customer_name', $customer->name);

                // Flash success message and redirect to dashboard
                flash()->success('Login successful', 'You have been logged in.');
                return redirect()->route('customer.dashboard');
            } else {
                // Flash error message for incorrect password
                flash()->error('Login unsuccessful', 'Your email or password is incorrect.');
                return redirect()->back();
            }
        } else {
            // Flash error message for not found customer
            flash()->error('Login unsuccessful', 'Your email or password is incorrect.');
            return redirect()->back();
        }
    }

    public function forget()
    {
        return view('front.pages.forget');
    }

    public function sendCode(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();
        $otp = rand(111111,999999);
        if ($customer) {

            $customer->verification_code  = bcrypt($otp);
            $customer->verification_code_send_time  = now();
            $customer->save();

            Session::put('temp_customer_id', $customer->id);

            if (env('MAIL_USERNAME') != null) {
                $data['name'] = $customer->name;
                $data['email'] = $customer->email;
                $data['otp'] = $otp;

                Mail::send('emails.otp', ['data' => $data], function ($message) use ($data){
                    $message->to($data['email'])->subject('Your Forget Password OTP');
                });
            }

            $maskedEmail = mask_email($customer->email);
            return redirect()->route('forget.verify')->with('message', "Forget password otp has been sent via $maskedEmail.<br> Please check your inbox or spam folder.");
        }
        else
        {
            flash()->error('Forget password', 'Customer not found!');
            return redirect()->back();
        }
    }

    public function resendOtp(Request $request)
    {
        $customer = Customer::find(Session::get('temp_customer_id'));
        $otp = rand(111111,999999);
        if ($customer) {

            $customer->verification_code  = bcrypt($otp);
            $customer->verification_code_send_time  = now();
            $customer->save();

            Session::put('temp_customer_id', $customer->id);

            if (env('MAIL_USERNAME') != null) {
                $data['name'] = $customer->name;
                $data['email'] = $customer->email;
                $data['otp'] = $otp;

                Mail::send('emails.otp', ['data' => $data], function ($message) use ($data){
                    $message->to($data['email'])->subject('Your Forget Password OTP');
                });
            }

            $maskedEmail = mask_email($customer->email);
            return redirect()->back()->with('message', "Forget password otp has been sent via $maskedEmail.<br>. Please check your inbox or spam folder");
        }
        else
        {
            flash()->error('Forget password', 'Customer not found!');
            return redirect()->back();
        }
    }

    public function verify()
    {
        if (Session::get('temp_customer_id'))
        {
            $customer = Customer::find(Session::get('temp_customer_id'));

            // Calculate the time difference in seconds between the current time and the last OTP sent time
            $timeNow = now();
            $otpSentTime = $customer->verification_code_send_time;
            $remainingTime = max(0, 30 - $timeNow->diffInSeconds($otpSentTime));
            return view('front.pages.verify', compact('customer', 'remainingTime'));
        }
        else
        {
            return redirect()->route('forget.password');
        }
    }

    public function otpCheck(Request $request)
    {
        $customer = Customer::find(Session::get('temp_customer_id'));
        if ($customer) {
            // Check if the provided password matches the stored hashed password
            if (password_verify($request->otp, $customer->verification_code)) {
                Session::forget('temp_customer_id');
                Session::put('new_customer_id', $customer->id);

                $customer->varification_code = null;
                $customer->verification_code_send_time = null;
                return redirect()->route('set.password');
            }
            else
            {
                return redirect()->back()->with('invaild_message', 'Invalid OTP');
            }
        }
        else
        {
            return redirect()->back()->with('invaild_message', 'Invalid OTP');
        }
    }

    public function setPassword()
    {
        if (Session::get('new_customer_id'))
        {
            return view('front.pages.set-password');
        }
        else
        {
            return redirect()->route('forget.password');
        }
    }

    public function savePassword(Request $request)
    {
        if (Session::get('new_customer_id'))
        {
            // Define validation rules and messages
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:6|confirmed',
            ], [
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 6 characters.',
                'password.confirmed' => 'The password confirmation does not match.',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // If validation passes, save the password
            $customer = Customer::find(Session::get('new_customer_id'));
            $customer->password = bcrypt($request->password); // Fix typo: 'passwrod' to 'password'
            $customer->save();

            // Clear session and set customer ID
            Session::forget('new_customer_id');
            Session::put('customer_id', $customer->id);

            // Redirect to customer dashboard
            return redirect()->route('customer.dashboard');
        }
        else
        {
            return redirect()->route('forget.password');
        }
    }


}
