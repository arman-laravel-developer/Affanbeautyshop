<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->get();
        return view('admin.size.manage', compact('sizes'));
    }

    public function create(Request $request)
    {
        $size = new Size();
        $size->name = $request->name;
        $size->save();

        flash()->success('Size add', 'Size add successfull');
        return redirect()->back();
    }

    public function edit($id)
    {
        $size = Size::find($id);

        return response()->json([
            'status' => 200,
            'size' => $size
        ]);
    }

    public function update(Request $request)
    {
        $size = Size::find($request->size_id);
        $size->name = $request->name;
        $size->save();

        flash()->success('Size update', 'Size update successfull');
        return redirect()->route('size.add');
    }

    public function delete($id)
    {
        $size = Size::find($id);
        $size->delete();

        flash()->success('Size delete', 'Size delete successfull');
        return redirect()->route('size.add');
    }
}
