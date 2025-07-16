<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('admin.brand.manage', compact('brands'));
    }

    public function getLogoUrl($request)
    {
        $slug = Str::slug($request->name);
        $logo = $request->file('logo');
        $logoName = $slug.'-'.time().'.'.$logo->getClientOriginalExtension();
        $directory = 'logo-images/';
        $logo->move($directory, $logoName);
        $logoUrl = $directory.$logoName;

        return $logoUrl;
    }

    public function create(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        if ($request->file('logo'))
        {
            $brand->logo = $this->getLogoUrl($request);
        }
        $brand->slug = Str::slug($request->name);
        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        $brand->save();

        flash()->success('Brand Add', 'Brand add successful');
        return redirect()->back();
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $brand->name = $request->name;
        if ($request->file('logo'))
        {
            if (file_exists($brand->logo))
            {
                unlink($brand->logo);
            }
            $logoUrl = $this->getLogoUrl($request);
        }
        else
        {
            $logoUrl = $brand->logo;
        }
        $brand->logo = $logoUrl;
        $brand->slug = Str::slug($request->name);
        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        $brand->save();

        flash()->success('Brand update', 'Brand update successful');
        return redirect()->route('brand.add');
    }

    public function delete($id)
    {
        $brand = Brand::find($id);
        if (file_exists($brand->logo))
        {
            unlink($brand->logo);
        }
        $brand->delete();

        flash()->success('Brand delete', 'Brand delete successful');
        return redirect()->back();

    }
}
