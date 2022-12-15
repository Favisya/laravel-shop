<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    protected $availableLocales = ['ru', 'en'];

    public function changeLocale($locale)
    {
        if (!in_array($locale, $this->availableLocales)) {
            $locale = config('app.locale');
        }
        Session::setToSession('locale', $locale);
        App::setLocale($locale);
        return redirect()->back();
    }
}
