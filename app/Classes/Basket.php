<?php

namespace App\Classes;

use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use App\Models\Session;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Basket
{
    protected $order;

    public function __construct($createOrder = false)
    {
        $orderId = Session::getItem('orderId');
        if (is_null($orderId) && $createOrder) {
            $data = [];
            if (Auth::check()) {
                $data['userId'] = Auth::id();
            }

            $this->order = Order::findOrFail(Order::createOrder($data));
        } else {
            $this->order = Order::find($orderId);
        }
    }

    protected function getPivotRow($product)
    {
        return $this->order->products()->where('product_id', $product->id)->first()->pivot;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function saveOrder($name, $phone, $email)
    {
        if (!$this->countAvailable(true)) {
            return false;
        }
        Mail::to($email)->send(new OrderCreated($name, $this->order));

        return $this->order->saveOrder($name, $phone, $email);

    }

    public function addProduct(Product $product)
    {
        if ($this->order->products->contains($product->id)) {
            $pivotRow = $this->getPivotRow($product);
            $pivotRow->count++;
            if ($pivotRow->count > $product->count) {
                return false;
            }
            $pivotRow->update();
        } else {
            $this->order->products()->attach($product);
        }

        Order::changeFullPrice($product->price);

        return true;
    }

    public function removeProduct(Product $product)
    {
        if ($this->order->products->contains($product->id)) {
            $pivotRow = $this->getPivotRow($product);
            if ($pivotRow->count <= 1) {
                $this->order->products()->detach($product);
                if ($this->order->products->count() < 2) {
                    Session::deleteItem('orderId');
                }
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }
        }

        Order::changeFullPrice(-1*(Product::find($product->id)->price));
        Debugbar::info(Order::getFullPrice());
    }

    public function countAvailable($isUpdate = false): bool
    {
        foreach ($this->order->products as $product)
        {
            if ($product->count < $this->getPivotRow($product)->count) {
                return false;
            }

            if ($isUpdate) {
                $product->count -= $this->getPivotRow($product)->count;
            }

            if ($isUpdate) {
                $this->order->products->map->save();
            }
        }
        return true;
    }
}
