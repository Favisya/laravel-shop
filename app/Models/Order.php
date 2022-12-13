<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public static function createOrder()
    {
        $item = Order::create()->id;
        $key  = 'orderId';
        Session::setToSession($key, $item);
        return Session::getItem($key);
    }

    public static function isOrderIdExists(): bool
    {
        if(is_null(Session::getItem('orderId'))) {
            return false;
        }

        return true;
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

    public static function getFullPrice()
    {
        return Session::getItem('fullOrderSum', 0);
    }

    public static function changeFullPrice($productPrice): void
    {
        $sum = self::getFullPrice() + $productPrice;
        Session::setToSession('fullOrderSum', $sum);
    }

    public static function clearPrice()
    {
        Session::deleteItem('fullOrderSum');
    }
}
