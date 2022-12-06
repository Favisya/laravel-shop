<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractItemModel extends Model
{
    public function isImageExists(): bool
    {
        return $this->image === null;
    }
}
