<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::get();
        return view('categories', compact('categories' ));
    }

    public function getCategory($code)
    {
        $category = Category::where('code', $code)->first();
        return view('category', compact('category')
        );
    }
}
