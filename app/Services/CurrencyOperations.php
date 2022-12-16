<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Session;

class CurrencyOperations
{
    protected static $container;

    public static function loadContainer()
    {
        if (is_null(self::$container)) {
            foreach (Currency::get() as $currency) {
                self::$container[$currency->code] = $currency;
            }
        }
    }

    public static function getCurrencies()
    {
       return self::$container;
    }

    public static function convertCurrency(
        $sum,
        $originCurrencyCode = 'RUB',
        $targetCurrencyCode = null
        ): float|int {
        self::loadContainer();

        $originCurrency = self::$container[$originCurrencyCode];
        if (is_null($targetCurrencyCode)) {
            if (!Session::isInclude('currency')) {
                Session::setToSession('currency', 'RUB');
            }
            $targetCurrencyCode = Session::getItem('currency');
        }
        $targetCurrency = self::$container[$targetCurrencyCode]->first();
        //dd($targetCurrency->rate, $originCurrency->rate);
        return $sum * $targetCurrency->rate / $originCurrency->rate;
    }

    public static function getCurrencySymbol()
    {
        self::loadContainer();

        $currency = self::$container[Session::getItem('currency')];
        return $currency->symbol;
    }
}
