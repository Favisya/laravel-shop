<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }

    public static function createOrder()
    {
        return session(['orderId' => Order::create()->id]);
    }

    public static function isOrderIdExists(): bool
    {
        if(is_null(Order::getOrderId())) {
            return false;
        }

        return true;
    }

    public static function getOrderId()
    {
        return session('orderId');
    }

    public static function setIdToSession(int $orderId)
    {
        session(['orderId' => $orderId]);
    }

    public function saveOrder(string $name, string $phone, string $email)
    {
        $this->status = 1;
        $this->name   = $name;
        $this->phone  = $phone;
        $this->email  = $email;
        $this->save();

        session()->forget('orderId');
    }

    public function calculatePrice(): int
    {
        $price = 0;
        foreach ($this->products as $product) {
            $price += $product->getPriceForCount();
        }

        return $price;
    }
}
