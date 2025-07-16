<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $about = AboutUs::latest()->first();
        return view('admin.about.index', compact('about'));
    }

    public function getImageUrl($request)
    {
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $directory = 'about-images/';
        $image->move($directory, $imageName);
        $imageUrl = $directory.$imageName;
        return $imageUrl;
    }

    public function create(Request $request)
    {

        $about = AboutUs::find($request->about_id);
        if ($about)
        {
            $about->who_we_are = $request->who_we_are;
            if ($request->file('image'))
            {
                if (file_exists($about->image))
                {
                    unlink($about->image);
                }
                $imageUrl = $this->getImageUrl($request);
            }
            else
            {
                $imageUrl = $about->image;
            }
            $about->image = $imageUrl;
            $about->save();
        }
        else
        {
            $about = new AboutUs();
            $about->save();
        }

        return redirect()->back()->with('success', 'About us update successfull');
    }
}
