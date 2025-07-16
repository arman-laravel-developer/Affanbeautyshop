<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Attribute_detail;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::latest()->get();
        return view('admin.attribute.manage', compact('attributes'));
    }

    public function create(Request $request)
    {
        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->save();

        flash()->success('Attribute add', 'Attribute add successfull');
        return redirect()->back();
    }

    public function edit($id)
    {
        $attribute = Attribute::find($id);

        return response()->json([
            'status' => 200,
            'attribute' => $attribute
        ]);
    }

    public function update(Request $request)
    {
        $attribute = Attribute::find($request->attribute_id);
        $attribute->name = $request->name;
        $attribute->save();

        flash()->success('Attribute update', 'Attribute update successfull');
        return redirect()->route('attribute.add');
    }

    public function delete($id)
    {
        $attribute = Attribute::find($id);
        $attribute_details = Attribute_detail::where('attribute_id', $attribute->id)->get();
        if ($attribute_details)
        {
            foreach ($attribute_details as $attribute_detail)
            {
                $attribute_detail->delete();
            }
        }
        $attribute->delete();

        flash()->success('Attribute delete', 'Attribute delete successfull');
        return redirect()->route('attribute.add');
    }

}
