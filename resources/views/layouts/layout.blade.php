<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SS: @yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/starter-template.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('index')}}">@lang('main.onlineShop')</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li
                    @routeactive('index')
                >
                    <a href="{{route('index')}}">@lang('main.allProducts')</a>
                </li>

                <li
                    @routeactive('categor*')
                >
                    <a href="{{route('categories')}}">@lang('main.categories')</a>
                </li>

                <li
                    @routeactive('basket*')
                >
                    <a href="{{route('basket')}}">@lang('main.toCart')</a>
                </li>
                <li><a href="{{ route('reset') }}">@lang('main.resetProject')</a></li>
                <li><a href="{{ route('locale', __('main.setLang')) }}">@lang('main.setLang')</a></li>

                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >
                        {{ \App\Services\CurrencyOperations::getCurrencySymbol() }}
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach(\App\Models\Currency::get() as $currency)
                            <li><a href="{{ route('currency', $currency->code) }}"> {{ $currency->symbol }} </a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            @guest()
            <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{route('login')}}">@lang('main.login')</a></li>
            </ul>
            @endguest

            @auth()
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{route('doLogout')}}">@lang('main.logout')</a></li>
                </ul>

                @admin
                <ul class="nav navbar-nav navbar-right">
                <li><a href="{{route('home')}}">@lang('main.adminPanel')</a></li>
                </ul>
                @else
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{route('person.orders')}}">@lang('main.myOrders')</a></li>
                </ul>
                @endadmin
            @endauth

        </div>
    </div>
</nav>
<div class="container">
    <div class="starter-template">
        @if (\App\Models\Session::isInclude('success'))
        <p class="alert alert-success">{{session()->get('success')}}</p>
        @endif

        @if (\App\Models\Session::isInclude('warning'))
            <p class="alert alert-warning">{{session()->get('warning')}}</p>
        @endif

        @yield('content')
    </div>
</div>
</body>
</html>
