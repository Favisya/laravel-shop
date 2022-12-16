<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Session;

class CurrencyController extends Controller
{
    public function changeCurrency($currencyCode)
    {
        Session::setToSession('OldCurrency', $currencyCode);
        $currency = Currency::byCode($currencyCode)->firstOrFail();
        Session::setToSession('currency', $currency->code);
        return redirect()->back();
    }
}
