<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->get();
        return view('admin.color.manage', compact('colors'));
    }

    public function create(Request $request)
    {
        $color = new Color();
        $color->name = $request->name;
        $color->color_code = $request->color_code;
        $color->save();

        flash()->success('Color Add', 'Color add successfull');
        return redirect()->back();
    }

    public function edit($id)
    {
        $color = Color::find($id);

        return response()->json([
            'status' => 200,
            'color' => $color
        ]);
    }

    public function update(Request $request)
    {
        $color = Color::find($request->color_id);
        $color->name = $request->name;
        $color->color_code = $request->color_code;
        $color->save();

        flash()->success('Color update', 'Color update successfull');
        return redirect()->back();
    }

    public function delete($id)
    {
        $color = Color::find($id);
        $color->delete();

        flash()->success('Color delete', 'Color delete successfull');
        return redirect()->back();
    }
}
