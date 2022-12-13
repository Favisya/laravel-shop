<?php

namespace App\Http\Middleware;

use App\Models\Order;
use App\Models\Session;
use Closure;
use Illuminate\Http\Request;

class BasketIsNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Order::isOrderIdExists() && (Order::getFullPrice() > 0)) {
            return $next($request);
        }

        Session::setFlash('warning', 'Ваша корзина пуста!');
        return redirect()->route('index');
    }
}
