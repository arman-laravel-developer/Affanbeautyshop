<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Attribute_detail;
use Illuminate\Http\Request;

class AttributeDetailController extends Controller
{
    public function index($id)
    {
        $attribute_details = Attribute_detail::where('attribute_id', $id)->latest()->get();
        $attribute = Attribute::find($id);
        return view('admin.attribute.details', compact('attribute_details', 'attribute'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|integer|exists:attributes,id', // Assuming you have an `attributes` table
            'value' => 'required|string|unique:attribute_details,value',
        ]);

        $attribute_detail = new Attribute_detail();
        $attribute_detail->attribute_id = $request->attribute_id;
        $attribute_detail->value = $request->value;
        $attribute_detail->save();

        flash()->success('Attribute value', 'Attribute value add successfull');
        return redirect()->back();
    }

    public function edit($id)
    {
        $attribute_detail = Attribute_detail::find($id);

        return response()->json([
            'status' => 200,
            'attribute_detail' => $attribute_detail
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'value' => 'required|string|unique:attribute_details,value',
        ]);

        $attribute_detail = Attribute_detail::find($request->attribute_detail_id);
        $attribute_detail->value = $request->value;
        $attribute_detail->save();

        flash()->success('Attribute value', 'Attribute value update successfull');
        return redirect()->back();
    }
    

    public function delete($id)
    {
        $attribute_detail = Attribute_detail::find($id);
        $attribute_detail->delete();

        flash()->success('Attribute value', 'Attribute value delete successfull');
        return redirect()->back();
    }
}
