<?php

namespace App\Http\Controllers;

use App\Exports\FilteredSalesReportExport;
use App\Exports\ProductsByCategoryExport;
use App\Exports\ProductsExport;
use App\Exports\SalesReportExport;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportAnalysisController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        $grandTotal = Order::latest()->sum('grand_total');
        return view('admin.report.sales', compact('orders', 'grandTotal'));
    }

    public function salesReportExport()
    {
        return Excel::download(new SalesReportExport(), 'sales-report.xlsx');
    }

    public function FilteredSalesReportExport(Request $request)
    {
        // Get filters from request
        $order_status = $request->input('order_status');
        $payment_status = $request->input('payment_status');
        $created_at = $request->input('date_range');
        $dates = explode(' to ', $created_at);
        $start_date = $dates[0] ?? null;
        $end_date = $dates[1] ?? null;

        return Excel::download(new FilteredSalesReportExport($order_status, $payment_status, $start_date, $end_date), 'filtered-sales-report.xlsx');
    }

    public function salesWiseReport(Request $request)
    {
        $order_status = $request->input('order_status');
        $payment_status = $request->input('payment_status');
        $created_at = $request->input('date_range');
        $selectedDate = $request->input('date_range'); // Get the selected date from the form

        $query = Order::query();

        if ($order_status) {
            $query->where('order_status', $order_status);
        }

        if ($payment_status) {
            $query->where('payment_status', $payment_status);
        }

        if ($created_at) {
            $dates = explode(' to ', $created_at);
            $start_date = Carbon::parse($dates[0])->startOfDay();
            $end_date = Carbon::parse($dates[1])->endOfDay();

            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $orders = $query->get();
        $grandTotal = $query->sum('grand_total');


        return view('admin.report.sales-wise', compact('orders', 'order_status', 'payment_status', 'grandTotal', 'selectedDate'));
    }


    public function stock()
    {
        $categories = Category::where(['parent_id' => 0])->where('status', 1)->get();
        $categories_dropdown = "<option selected disabled> Select Category </option>";
        foreach ($categories as $cat)
        {
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->category_name." </option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat)
            {
                $categories_dropdown .= "<option value='".$sub_cat->id."'>&nbsp;&nbsp;---".$sub_cat->category_name." </option>";
            }
        }

        $products = Product::where('status', 1)->get();
        return view('admin.report.stock', compact('categories', 'categories_dropdown', 'products'));
    }

    public function exportProducts()
    {
        return Excel::download(new ProductsExport(), 'products-stock.xlsx');
    }

    public function categoryWiseStock(Request $request)
    {
        // Validate category_id is required
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $categories = Category::where(['parent_id' => 0])->where('status', 1)->get();
        $categories_dropdown = "<option selected disabled>Select Category</option>";
        foreach ($categories as $category)
        {
            if ($category->id == $request->category_id)
            {
                $selected = "selected";
            }
            else
            {
                $selected = "";
            }
            $categories_dropdown .="<option value='".$category->id."' ".$selected.">".$category->category_name."</option>";
            $sub_categories = Category::where(['parent_id' => $category->id])->get();
            foreach ($sub_categories as $sub_category)
            {
                if ($sub_category->id == $request->category_id)
                {
                    $selected = "selected";
                }
                else
                {
                    $selected = "";
                }
                $categories_dropdown .="<option value='".$sub_category->id."' ".$selected.">&nbsp;&nbsp;---".$sub_category->category_name."</option>";
            }
        }

        $category = Category::with('descendants')->find($request->category_id);
        $categoryIds = $category->descendants->pluck('id')->toArray();
        $categoryIds[] = $request->category_id;
        $products = Product::whereIn('category_id', $categoryIds)->where('status', 1)->get();
        return view('admin.report.category-wise', compact('products', 'categories_dropdown', 'category'));
    }


    public function exportProductsCategoryWise(Request $request)
    {
        return Excel::download(new ProductsByCategoryExport($request->category_id), 'category-wise-products.xlsx');
    }
}
