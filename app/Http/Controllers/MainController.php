<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;

class MainController extends Controller
{
    private $labels = ['hit', 'new', 'recommend'];

    public function getMainPage(ProductsFilterRequest $request)
    {
        $products = $this->filterProducts($request)
            ->paginate(9)
            ->withPath('?' . $request->getQueryString());
        return view('index', compact('products'));
    }


    private function filterProducts(Request $request)
    {
        $productsQuery = Product::with('category');

        if ($request->filled('priceFrom')) {
            $productsQuery->where('price', '>=', $request->priceFrom);
        }

        if ($request->filled('priceTo')) {
            $productsQuery->where('price', '<=', $request->priceTo);
        }

        foreach ($this->labels as $label) {
            if ($request->has($label)) {
                $productsQuery->$label();
            }
        }

        return $productsQuery;
    }
}
