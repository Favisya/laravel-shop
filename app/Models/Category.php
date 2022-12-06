<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends AbstractItemModel
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'description', 'image'];
}
