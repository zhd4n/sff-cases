@extends('layouts.main')

@section('content')
    <div class="container pt-5">
        <form-component :case='@json($case ?? null)'></form-component>
    </div>
@endsection
