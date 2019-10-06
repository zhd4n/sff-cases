@extends('layouts.main')

@php
/* @var \App\Models\Parts\CasePart $case */
@endphp

@section('content')
    <div class="ui grid">
        <div class="ui row product">
            <div class="ui four wide column">
                <img class="ui fluid image" src="{{ $case->getFirstMediaUrl('gallery') }}" alt="{{ $case->title }} photo">
            </div>
            <div class="ui seven wide column">
                <h1 class="ui header">{{ $case->title }}</h1>
                <div class="meta">
                    <span class="price">${{ $case->formatted_price }}</span>
                    <span class="link"><a href="#">Go to product page</a></span>
                </div>
                {{ $case->description }}
            </div>
            <div class="ui five wide column">
                <a href="{{ route('cases.edit', $case) }}" class="ui blue button">
                   <i class="pencil icon"></i> Edit
                </a>
                <a class="ajax-delete ui negative button" href="{{ route('cases.delete', $case) }}">
                    <i class="trash icon"></i>Delete
                </a>
                <h3 class="ui header">Specifications</h3>
                <div class="ui divided list">
                    @foreach ($case->sorted_properties as $k => $v)
                        <div class="item">
                            <div class="header">@lang("parts/case.$k")</div>
                            @if (is_array($v))
                                @foreach ($v as $subK => $subV)
                                    <div>
                                        @php
                                            $subV = $subV ?? 'n/a';

                                            if (! is_array($subV) && $subV !== 'n/a') {
                                                $subV = __("parts/case.$k.$subK.$subV");
                                            }

                                            if (is_array($subV)) {
                                                $subV = implode(', ', $subV);
                                            }
                                        @endphp

                                        @lang("parts/case.$k.$subK"): {{ $subV }}
                                    </div>
                                @endforeach
                            @else
                                @lang("parts/case.$k.$v")
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
