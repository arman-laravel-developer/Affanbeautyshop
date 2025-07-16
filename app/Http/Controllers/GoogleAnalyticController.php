<?php

namespace App\Http\Controllers;

use App\Models\GoogleAnalytic;
use Illuminate\Http\Request;

class GoogleAnalyticController extends Controller
{
    public function index()
    {
        $googleSetup = GoogleAnalytic::latest()->first();
        return view('admin.setup-configaration.index', compact('googleSetup'));
    }

    public function update(Request $request)
    {
        $googleAnalyticId = $request->google_analytic_id;

        if ($googleAnalyticId)
        {
            $googleAnalytic = GoogleAnalytic::find($googleAnalyticId);
            if ($request->button == 1)
            {
                if ($request->facebook_pixel)
                {
                    $googleAnalytic->facebook_pixel = $request->facebook_pixel;
                }
                if ($request->facebook_pixel_status)
                {
                    $googleAnalytic->facebook_pixel_status = $request->facebook_pixel_status;
                }
                else
                {
                    $googleAnalytic->facebook_pixel_status = 2;
                }
            }
            if ($request->button == 2)
            {
                if ($request->google_analytics)
                {
                    $googleAnalytic->google_analytics = $request->google_analytics;
                }
                if ($request->google_analytics_status)
                {
                    $googleAnalytic->google_analytics_status = $request->google_analytics_status;
                }
                else
                {
                    $googleAnalytic->google_analytics_status = 2;
                }
            }
            if ($request->button == 3)
            {
                if ($request->tag_manager)
                {
                    $googleAnalytic->tag_manager = $request->tag_manager;
                }
                if ($request->tag_manager_status)
                {
                    $googleAnalytic->tag_manager_status = $request->tag_manager_status;
                }
                else
                {
                    $googleAnalytic->tag_manager_status = 2;
                }
            }

            $googleAnalytic->save();

            return redirect()->back()->with('success', 'Google Analytics Setup successfull');
        }
        else
        {
            $googleAnalytic = new GoogleAnalytic();
            $googleAnalytic->save();
            return redirect()->back()->with('success', 'Google Analytics Setup successfull');
        }
    }
}
