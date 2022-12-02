<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function getBasket()
    {
        $orderId = Order::getOrderId();
        if (!Order::isOrderIdExists()) {
            $orderId = Order::createOrder();
        }
        $order = Order::find($orderId);
        return view('basket', compact('order'));
    }

    public function getBasketPlace()
    {
        $orderId = Order::getOrderId();
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
        $orderId = Order::getOrderId();
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
            session()->flash('success', "Заказ передан в обработку");
        } else {
            session()->flash('warning', "Произошла ошибка");
        }

        return redirect()->route('index');
    }

    public function addToBasket(int $productId)
    {
        $orderId = Order::getOrderId();
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

        session()->flash('success', "Товар под именем {$order->products->last()->name} спешно добавлен");
        return redirect()->route('basket');
    }

    public function removeFromBasket(int $productId)
    {
        $orderId = Order::getOrderId();
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

        session()->flash('warning', "Товар под именем {$order->products->last()->name} был удален");
        return redirect()->route('basket');
    }
}
