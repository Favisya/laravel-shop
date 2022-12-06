<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public static function setFlash(string $key, string $message)
    {
        session()->flash($key, $message);
    }

    public static function getItem(string $key)
    {
        return session($key);
    }

    public static function setToSession(string $key, $item): void
    {
        session([$key => $item]);
    }
}
