<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends AbstractItemModel
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'image',
        'price',
        'discription',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceForCount(): int
    {
        return $this->price * $this->pivot->count;
    }

    public function isImageExists(): bool
    {
        return $this->image === null;
    }
}
