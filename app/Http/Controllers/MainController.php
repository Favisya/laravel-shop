<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function getMainPage()
    {
        $products = Product::get();
        return view('index', compact('products'));
    }
}
