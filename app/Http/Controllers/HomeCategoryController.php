<?php

namespace App\Http\Controllers;

use App\Models\HomeCategory;
use Illuminate\Http\Request;

class HomeCategoryController extends Controller
{
    public function update(Request $request)
    {
        // Retrieve the selected home categories from the form
        $homeCategories = $request->input('home_categories');

        // Clear the existing home categories first, then insert the new ones
        HomeCategory::truncate(); // Optional: remove this if you want to add without truncating

        // Loop through selected categories and insert them into the HomeCategory table
        foreach ($homeCategories as $categoryId) {
            HomeCategory::create([
                'category_id' => $categoryId
            ]);
        }

        flash()->success('Success', 'Home categories add successfully');
        return redirect()->back();
    }
}
