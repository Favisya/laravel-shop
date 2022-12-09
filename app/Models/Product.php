<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'image',
        'price',
        'description',
        'category_id',
        'hit',
        'new',
        'recommend',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceForCount(): int
    {
        return $this->price * $this->pivot->count;
    }

    public function setNewAttribute($value)
    {
        $this->attributes['new'] = $value == 'on' ? 1 : 0;
    }

    public function setHitAttribute($value)
    {
        $this->attributes['hit'] = $value == 'on' ? 1 : 0;
    }

    public function setRecommendAttribute($value)
    {
        $this->attributes['recommend'] = $value == 'on' ? 1 : 0;
    }

    public function isHit(): bool
    {
        return $this->hit === 1;
    }

    public function isNew(): bool
    {
        return $this->new === 1;
    }

    public function isRecommend(): bool
    {
        return $this->recommend === 1;
    }
}
