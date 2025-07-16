<?php

namespace App\Http\Controllers;

use App\Models\ReturnAndRefund;
use Illuminate\Http\Request;

class ReturnAndRefundController extends Controller
{
    public function index()
    {
        $return = ReturnAndRefund::first();
        return view('admin.return.index', compact('return'));
    }

    public function update(Request $request)
    {
        $return = ReturnAndRefund::latest()->first();
        if ($return)
        {
            $return->return = $request->return;
            $return->save();
        }
        else
        {
            $return = new ReturnAndRefund();
            $return->return = $request->return;
            $return->save();
        }
        return redirect()->back()->with('success', 'Return And Refund update successfully');
    }

    public function page_view()
    {
        $return = ReturnAndRefund::first();
        return view('front.privacy.return', compact('return'));
    }
}
