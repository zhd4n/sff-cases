@extends('layouts.main')

@section('content')
    <div class="ui main text container">
        <h1 class="ui header">Small Form Factor Cases</h1>

        <div class="ui divided items">
            @foreach($cases as $case)
                @php
                /** @var \App\Models\Parts\CasePart $case  */
                @endphp
                <div class="item">
                    <div class="image">
                        <a href="{{ route('cases.show', $case->slug) }}" class="ui image">
                            <img src="{{ $case->getFirstMediaUrl('gallery') }}" alt="{{ $case->title }} photo">
                        </a>
                    </div>
                    <div class="content">
                        <a href="{{ route('cases.show', $case->slug) }}" class="header">
                            {{ $case->title }}
                        </a>

                        <div class="meta">
                            <span class="price">$
                                {{ $case->formatted_price }}
                            </span>
                        </div>

                        <div class="description">
                            {{ $case->description }}
                        </div>

                        <div class="extra">
                            <a href="{{ route('cases.edit', $case) }}">
                                <i class="blue pencil icon"></i>
                            </a>
                            <a class="ajax-delete" href="{{ route('cases.delete', $case) }}">
                                <i class="red trash icon"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop
