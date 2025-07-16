<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class FrontProductController extends Controller
{
    public function show($id)
    {
        $product = Product::find($id);
        $relatedProducts = Product::where('status', 1)->where('category_id', $product->category_id)->take(24)->orderBy('id', 'asc')->get();
        $featuredProducts = Product::where('status', 1)->where('you_may_also', 1)->orderBy('id', 'asc')->get();
        return view('front.pages.show', compact('product', 'relatedProducts', 'featuredProducts'));
    }

    public function allProducts(Request $request)
    {
        $sort = $request->input('sort', 'latest');
        $categories = $request->input('categories', []);
        $sizes = $request->input('sizes', []);
        $brands = $request->input('brands', []);

        $query = Product::query();

        // Filter by categories and their descendants
        if (!empty($categories)) {
            $categoryIds = [];
            foreach ($categories as $categoryId) {
                $category = Category::find($categoryId);
                if ($category) {
                    $descendantIds = $category->descendants->pluck('id')->toArray();
                    $descendantIds[] = $category->id;
                    $categoryIds = array_merge($categoryIds, $descendantIds);
                }
            }
            $categoryIds = array_unique($categoryIds);
            $query->whereIn('category_id', $categoryIds);
        }

        // Filter by sizes
        if (!empty($sizes)) {
            // Join with variants table to filter by sizes
            $query->whereHas('variants', function ($q) use ($sizes) {
                $q->whereIn('size_id', $sizes);
            });
        }

        // Filter by brands
        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }

        // Apply sorting
        switch ($sort) {
            case 'popularity':
                $query->orderBy('num_of_sale', 'desc');
                break;
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        if ($request->ajax()) {
            return view('front.partials.all-products', compact('products'))->render();
        }

        $categories = Category::where('status', 1)->where('parent_id', 0)->get();
        $sizes = Size::all();
        $brands = Brand::all();

        return view('front.pages.products', compact('products', 'categories', 'sizes', 'brands'));
    }


    public function ajaxSearch(Request $request)
    {
        $query = $request->input('q');

        // Fetch products matching the query
        $products = Product::where('name', 'like', '%' . $query . '%')->get(['id','name']);

        // Return the names as a JSON response
        return response()->json($products);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $categories = $request->input('categories', []); // Array of category IDs
        $sizes = $request->input('sizes', []); // Array of size IDs
        $brands = $request->input('brands', []); // Array of brand IDs

        // Start building the product query
        $productQuery = Product::query();

        // Apply search filter by name or description
        if ($query) {
            $productQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            });
        }

        // Apply category filter if any category is selected
        if (!empty($categories)) {
            $categoryIds = [];
            foreach ($categories as $categoryId) {
                $category = Category::find($categoryId);
                if ($category) {
                    $descendantIds = $category->descendants->pluck('id')->toArray();
                    $descendantIds[] = $category->id;
                    $categoryIds = array_merge($categoryIds, $descendantIds);
                }
            }
            $categoryIds = array_unique($categoryIds);
            $productQuery->whereIn('category_id', $categoryIds);
        }

        // Apply size filter by checking variants
        if (!empty($sizes)) {
            $productQuery->whereHas('variants', function ($q) use ($sizes) {
                $q->whereIn('size_id', $sizes);
            });
        }

        // Apply brand filter if any brand is selected
        if (!empty($brands)) {
            $productQuery->whereIn('brand_id', $brands);
        }

        // Execute the query and get results
        $products = $productQuery->get();

        $categories = Category::where('status', 1)->where('parent_id', 0)->get();
        $sizes = Size::all();
        $brands = Brand::all();

        // Return the view with the search results
        return view('front.pages.search-results', compact('products', 'query', 'categories', 'sizes', 'brands'));
    }

}
