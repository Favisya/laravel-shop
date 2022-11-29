<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public static function getHome()
    {
        return view('welcome');
    }
}
