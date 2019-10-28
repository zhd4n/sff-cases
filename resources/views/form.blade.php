@extends('layouts.main')

@section('content')
    <div class="container pt-5">
        <form-component :case='@json(optional($case)->toArray())'></form-component>
    </div>
@endsection
