<?php

namespace App\Models;

use App\Services\CurrencyOperations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, Translateable;

    protected $fillable = [
        'id', 'code', 'name', 'name_en',
        'image', 'price', 'description',
        'description_en', 'category_id', 'hit',
        'new', 'recommend', 'count',
    ];

    public function scopeHit($query)
    {
        return $query->where('hit', 1);
    }

    public function scopeNew($query)
    {
        return $query->where('new', 1);
    }

    public function scopeRecommend($query)
    {
        return $query->where('recommend', 1);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

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

    public function isAvailable(): bool
    {
        return !$this->trashed() && $this->count > 0;
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

    public function getPriceAttribute($value)
    {
        $originCurrency = Session::getItem('currency') ?? 'RUB';
        return round(CurrencyOperations::convertCurrency($value, $originCurrency), 2);
    }
}
