<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Models\Product;
use App\Models\Subscription;

class ProductController extends Controller
{
    public function getProduct($category, $productCode = null)
    {
        $product = Product::withTrashed()->byCode($productCode)->firstOrFail();
        return view('product', ['product' => $product]);
    }

    public function subscribeToProduct(SubscriptionRequest $request, Product $product)
    {
        Subscription::create([
            'email'      => $request->email,
            'product_id' => $product->id,
        ]);
        return redirect()->back()->with('success', 'Вам придет письмо, когда товар появиться');
    }
}
