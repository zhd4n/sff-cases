@extends('layouts.main')

@section('pageTitle')
    @isset($case)
        Edit {{ $case->title }}
    @else
        Add case
    @endisset
@endsection

@section('content')
    <div class="container pt-5">
        <form-component :case='@json(optional($case ?? null)->toArray())'></form-component>
    </div>
@endsection
