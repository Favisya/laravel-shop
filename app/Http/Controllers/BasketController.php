<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function getBasket()
    {
        $orderId = Session::getItem('orderId');
        if (!Order::isOrderIdExists()) {
            $orderId = Order::createOrder();
        }
        $order = Order::find($orderId);
        return view('basket', compact('order'));
    }

    public function getBasketPlace()
    {
        $orderId = Session::getItem('orderId');
        if (!Order::isOrderIdExists()) {
            return redirect()->route('basket');
        }
        $order = Order::Find($orderId);

        if ($order->calculatePrice() > 0) {
            return view('order', compact('order'));
        } else {
            return redirect()->route('basket');
        }
    }

    public function confirmPlace(Request $request)
    {
        $orderId = Session::getItem('orderId');
        if (!Order::isOrderIdExists()) {
            return redirect()->route('basket');
        }
        $order = Order::Find($orderId);
        $order->saveOrder(
            $request->name,
            $request->phone,
            $request->email
        );

        if ($order) {
            Session::setFlash('success', 'Заказ передан в обработку');
        } else {
            Session::setFlash('warning', 'Произошла ошибка');
        }

        return redirect()->route('index');
    }

    public function addToBasket(int $productId)
    {
        $orderId = Session::getItem('orderId');
        if (!Order::isOrderIdExists()) {
            $orderId = Order::createOrder();
        }

        $order = Order::find($orderId);

        if ($order->products->contains($productId)) {
            $pivotRow = $order
                ->products()
                ->where('product_id', $productId)
                ->first()
                ->pivot;

            $pivotRow->count++;
            $pivotRow->update();
        } else {
            $order->products()->attach($productId);
        }

        if (Auth::check()) {
            $order->user_id = Auth::id();
            $order->save();
        }

        $message = "Товар был успешно добавлен";
        Session::setFlash('success', $message);
        return redirect()->route('basket');
    }

    public function removeFromBasket(int $productId)
    {
        $orderId = Session::getItem('orderId');
        if (is_null($orderId)) {
            return redirect()->route('basket');
        }

        $order = Order::find($orderId);

        if ($order->products->contains($productId)) {
            $pivotRow = $order
                ->products()
                ->where('product_id', $productId)
                ->first()
                ->pivot;
            if ($pivotRow->count <= 1) {
                $order->products()->detach($productId);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }
        }
        $message = "Товар был удален";
        Session::setFlash('warning', $message);
        return redirect()->route('basket');
    }
}
