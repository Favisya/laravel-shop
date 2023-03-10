<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Models\Product;
use App\Models\Session;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function getBasket()
    {
        $order = (new Basket())->getOrder();
        return view('basket', compact('order'));
    }

    public function getBasketPlace()
    {
        $basket = new Basket();
        $order = $basket->getOrder();

        if (!$basket->countAvailable()) {
            Session::setFlash('warning', __('basket.notAvailableMore'));
            return redirect()->route('basket');
        }
        return view('order', compact('order'));
    }

    public function confirmPlace(Request $request)
    {
        $order = (new Basket())->saveOrder(
            $request->name,
            $request->phone,
            $request->email,
        );

        if ($order) {
            Session::setFlash('success', __('basket.youOrderConfirmed'));
        } else {
            Session::setFlash('warning', __('basket.youCantOrderMore'));
        }

        return redirect()->route('index');
    }

    public function addToBasket(Product $product)
    {
        $result = (new Basket(true))->addProduct($product);

        if (!$result) {
            Session::setFlash('warning', __('basket.youCantOrderMore'));
        } else {
            Session::setFlash('success', __('basket.added'));
        }

        return redirect()->route('basket');
    }

    public function removeFromBasket(Product $product)
    {
        (new Basket())->removeProduct($product);

        Session::setFlash('warning', __('basket.added'));

        return redirect()->route('basket');
    }
}
