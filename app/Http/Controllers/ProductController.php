<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct($category, $product = null)
    {
        $product = Product::where('code', $product)->first();
        return view('product', ['product' => $product]);
    }
}
