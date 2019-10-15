<!doctype html>
<html lang="en">
<head>
    <title>SFF Cases</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">SFF Cases</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cases.create') }}">Add case</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown07">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
{{--            <form class="form-inline my-2 my-md-0">--}}
{{--                <input class="form-control" type="text" placeholder="Search" aria-label="Search">--}}
{{--            </form>--}}
        </div>
    </div>
</nav>

<div id="app" class="container pt-5">
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
</body>
</html>
