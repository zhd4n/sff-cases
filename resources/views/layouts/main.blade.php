<!doctype html>
<html lang="en">
<head>
    <title>
        @hasSection('pageTitle')
            @yield('pageTitle') — SFF Cases
        @else
            SFF Cases
        @endif
    </title>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

    <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">SFF Cases</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cases.create') }}">Add case</a>
                    </li>
                @endauth
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link disabled" href="#">Disabled</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>--}}
{{--                    <div class="dropdown-menu" aria-labelledby="dropdown07">--}}
{{--                        <a class="dropdown-item" href="#">Action</a>--}}
{{--                        <a class="dropdown-item" href="#">Another action</a>--}}
{{--                        <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                    </div>--}}
{{--                </li>--}}
            </ul>
{{--            <form class="form-inline my-2 my-md-0">--}}
{{--                <input class="form-control" type="text" placeholder="Search" aria-label="Search">--}}
{{--            </form>--}}
            @auth
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>

<div id="app">
{{--    @if($message = session('message'))--}}
{{--        <div class="ui icon message positive @if($message['status'] === 'error') negative @endif">--}}
{{--            <i class="check icon @if($message['status'] === 'error') x @endif"></i>--}}
{{--            <div class="content">--}}
{{--                <div class="header">--}}
{{--                    {{ \Illuminate\Support\Str::ucfirst($message['status']) }}--}}
{{--                </div>--}}
{{--                <p>{{ $message['message'] }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

    @yield('content')
</div>

</body>

<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

</html>
