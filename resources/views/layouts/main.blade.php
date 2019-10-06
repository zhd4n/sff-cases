<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Site Properties -->
    <title>SFF DB</title>

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body>

<div class="ui fixed inverted menu">
    <div class="ui container">
        <a href="/" class="header item">
{{--            <img class="logo" src="{{ asset('img/logo.png') }}">--}}
            SFF CASES
        </a>
        <a href="{{ route('cases.index') }}" class="item"><i class="plus icon"></i> Add case</a>
{{--        <div class="ui simple dropdown item">--}}
{{--            Dropdown <i class="dropdown icon"></i>--}}
{{--            <div class="menu">--}}
{{--                <a class="item" href="#">Link Item</a>--}}
{{--                <a class="item" href="#">Link Item</a>--}}
{{--                <div class="divider"></div>--}}
{{--                <div class="header">Header Item</div>--}}
{{--                <div class="item">--}}
{{--                    <i class="dropdown icon"></i>--}}
{{--                    Sub Menu--}}
{{--                    <div class="menu">--}}
{{--                        <a class="item" href="#">Link Item</a>--}}
{{--                        <a class="item" href="#">Link Item</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <a class="item" href="#">Link Item</a>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>


<div class="ui main container">
    @if($message = session('message'))
        <div class="ui icon message positive @if($message['status'] === 'error') negative @endif">
            <i class="check icon @if($message['status'] === 'error') x @endif"></i>
            <div class="content">
                <div class="header">
                    {{ \Illuminate\Support\Str::ucfirst($message['status']) }}
                </div>
                <p>{{ $message['message'] }}</p>
            </div>
        </div>
    @endif


    @yield('content')
</div>

<div class="ui inverted vertical footer segment">
    <div class="ui center aligned container">
        <div class="ui stackable inverted divided grid">
            <div class="three wide column">
                <h4 class="ui inverted header">Group 1</h4>
                <div class="ui inverted link list">
                    <a href="#" class="item">Link One</a>
                    <a href="#" class="item">Link Two</a>
                    <a href="#" class="item">Link Three</a>
                    <a href="#" class="item">Link Four</a>
                </div>
            </div>
            <div class="three wide column">
                <h4 class="ui inverted header">Group 2</h4>
                <div class="ui inverted link list">
                    <a href="#" class="item">Link One</a>
                    <a href="#" class="item">Link Two</a>
                    <a href="#" class="item">Link Three</a>
                    <a href="#" class="item">Link Four</a>
                </div>
            </div>
            <div class="three wide column">
                <h4 class="ui inverted header">Group 3</h4>
                <div class="ui inverted link list">
                    <a href="#" class="item">Link One</a>
                    <a href="#" class="item">Link Two</a>
                    <a href="#" class="item">Link Three</a>
                    <a href="#" class="item">Link Four</a>
                </div>
            </div>
            <div class="seven wide column">
                <h4 class="ui inverted header">Footer Header</h4>
                <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
            </div>
        </div>
        <div class="ui inverted section divider"></div>
{{--        <img src="{{ asset('img/logo.png') }}" class="ui centered mini image">--}}
        <div class="ui horizontal inverted small divided link list">
            <a class="item" href="#">Site Map</a>
            <a class="item" href="#">Contact Us</a>
            <a class="item" href="#">Terms and Conditions</a>
            <a class="item" href="#">Privacy Policy</a>
        </div>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.7.8/dist/semantic.min.js"></script>
<script>
    jQuery('.ui.checkbox').checkbox();
</script>
</body>

</html>

