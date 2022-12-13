<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct($category, $productCode = null)
    {
        $product = Product::withTrashed()->byCode($productCode);
        Debugbar::info($product);
        return view('product', ['product' => $product]);
    }
}
