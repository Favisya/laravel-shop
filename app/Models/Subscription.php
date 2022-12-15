<?php

namespace App\Models;

use App\Mail\SubscriptionMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;

class Subscription extends Model
{
    protected $fillable = ['email', 'product_id'];

    public function scopeByProductId($query, $product_id)
    {
        return $query->where('status', 0)->where('product_id', $product_id);
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function sendEmail(Product $product)
    {
        $subs = self::byProductId($product->id)->get();
        foreach ($subs as $sub) {
            Mail::to($sub->email)->send(New SubscriptionMail($product));
            $sub->status = 1;
            $sub->save();
        }
    }
}
