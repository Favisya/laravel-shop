<?php

namespace App\Http\Controllers;

use App\Models\InfoPost;

class BioController extends Controller
{
    public static function getBio()
    {
        return view('bio');
    }
}
