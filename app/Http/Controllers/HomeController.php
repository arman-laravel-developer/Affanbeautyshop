<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\HomeCategory;
use App\Models\Privacy;
use App\Models\Product;
use App\Models\Size;
use App\Models\Slider;
use App\Models\Union;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Cart;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $homeCats = HomeCategory::pluck('category_id')->toArray();  // Get home categories
        // Fetch categories in the same order as in the $homeCats array
        $categoryWiseHomeViews = Category::whereIn('id', $homeCats)
            ->orderByRaw(\DB::raw("FIELD(id, " . implode(',', $homeCats) . ")"))
            ->get();

        $sliders = Slider::where('status', 1)->orderBy('id', 'desc')->get();
        $featuredProducts = Product::where('status', 1)->where('is_featured', 1)->orderBy('id', 'asc')->take(4)->get();
        $newArrivals = Product::where('status', 1)->latest()->paginate(10);
        $homeCategories = Category::where('status', 1)->where('parent_id', 0)->where('display_status', 1)->latest()->take(2)->get();

        if ($request->ajax()) {
            $view = view('front.home.new_arrivals', compact('newArrivals'))->render();
            return response()->json(['html' => $view]);
        }

        return view('front.home.home', compact('featuredProducts', 'newArrivals', 'homeCategories', 'categoryWiseHomeViews', 'sliders'));
    }

    public function category_product(Request $request, $id)
    {
        $category = Category::with('descendants')->find($id);
        $categoryIds = $category->descendants->pluck('id')->toArray();
        $categoryIds[] = $id;

        // Determine sorting order
        $sort = $request->input('sort', 'latest');
        $subCategories = $request->input('subcategories', []);
        $sizes = $request->input('sizes', []);
        $brands = $request->input('brands', []);

        $query = Product::whereIn('category_id', $categoryIds)->where('status', 1);

        if (!empty($subCategories)) {
            $query->whereIn('category_id', $subCategories);
        }

        if (!empty($sizes)) {
            $query->whereHas('variants', function($q) use ($sizes) {
                $q->whereIn('size_id', $sizes);
            });
        }

        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }

        switch ($sort) {
            case 'popularity':
                $query->orderBy('num_of_sale', 'desc');
                break;
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->latest(); // Fallback to latest
                break;
        }

        $category_products = $query->paginate(12);

        // Check if it's an AJAX request
        if ($request->ajax()) {
            return view('front.partials.product-list', compact('category_products'))->render();
        }

        $sizes = Size::all();
        $brands = Brand::all();
        return view('front.pages.category-products', compact('category', 'category_products', 'sizes', 'brands'));
    }

    public function aboutUs()
    {
        $about = AboutUs::latest()->first();
        return view('front.pages.about', compact('about'));
    }

    public function contactUs()
    {
        return view('front.pages.contact');
    }

    public function privacy()
    {
        $privacy = Privacy::latest()->first();
        return view('front.privacy.privacy', compact('privacy'));
    }

    public function condition()
    {
        $condition = Privacy::latest()->first();
        return view('front.privacy.conditions', compact('condition'));
    }

}
