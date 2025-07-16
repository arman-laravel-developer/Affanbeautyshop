<?php

namespace App\Http\Controllers;

use App\Models\Privacy;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PrivacyController extends Controller
{
    public function index()
    {
        $privacy = Privacy::where('status', 1)->first();
        return view('admin.privacy.edit', compact('privacy'));
    }

    public function update(Request $request)
    {
        $privacy = Privacy::latest()->first();
        if ($privacy)
        {
            $privacy->privacy = $request->privacy;
            $privacy->condition = $request->condition;
            $privacy->save();
        }
        else
        {
            $privacy = new Privacy();
            $privacy->privacy = $request->privacy;
            $privacy->condition = $request->condition;
            $privacy->save();
        }
        return redirect()->back()->with('success', 'Privacy update successfully');
    }

    public function page_view()
    {
        $privacy = Privacy::where('status', 1)->first();
        return view('front.privacy.privacy', compact('privacy'));
    }

    public function condition_page_view()
    {
        $privacy = Privacy::where('status', 1)->first();
        return view('front.privacy.conditions', compact('privacy'));
    }
}

