<?php

namespace App\Http\Controllers;

use App\Models\InfoPost;

class InfoController extends Controller
{
    public static function getAll()
    {
        return view('allinfo', ['blocks' => InfoPost::all()]);
    }

    public static function getRow(int $id)
    {
        return view('info', ['info' => InfoPost::find($id)]);
    }
}
