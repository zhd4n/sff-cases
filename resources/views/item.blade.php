@extends('layouts.main')

@php
/* @var \App\Models\Parts\CasePart $case */
@endphp

@section('content')
    <header class="text-center p-5 mb-5 text-light bg-secondary">
        <h1 class="mb-3">{{ $case->title }}</h1>

        <ul class="list-inline small">
            @if($case->price)
                <li class="list-inline-item"><i class="fas fa-dollar-sign"></i> {{ $case->formatted_price }}</li>
            @endif

            @if($case->link)
                <li class="list-inline-item"><a href="{{ $case->link }}" class="text-light"><i class="fas fa-link"></i> Official website</a></li>
            @endif
        </ul>
    </header>
    <section class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="fotorama" data-nav="thumbs" data-allowfullscreen="true" data-arrows="false">

                @foreach ($case->getMedia() as $img)
                    <a href="{{ $img->getUrl('large') }}" data-full="{{ $img->getUrl('full') }}" data-thumb="{{ $img->getUrl('small') }}"></a>
                @endforeach
                </div>
            </div>
            <div class="col-sm-8">
                <h4 class="page-header">Description</h4>
                {{ $case->description }}

                <h4 class="page-header mt-5">Specifications</h4>
                @foreach($case->sorted_properties as $k => $v)
                    @if (is_array($v))
                        <h5>@lang("parts/case.$k")</h5>
                        <dl class="row no-gutters">
                        @foreach($v as $subK => $subV)
                            @php
                                $subV = $subV ?? 'n/a';

                                if (! is_array($subV) && $subV !== 'n/a') {
                                    $subV = __("parts/case.$k.$subK.$subV");
                                }

                                if (is_array($subV)) {
                                    $subV = implode(', ', array_map(function ($item) use ($k, $subK) {
                                        return __("parts/case.$k.$subK.$item");
                                    }, $subV));
                                }
                            @endphp
                            <dt class="col-sm-5 spec">
                                <span class="spec-inner">
                                @lang("parts/case.$k.$subK")
                                </span>
                            </dt>
                            <dd class="col-sm-7">{{ $subV }}</dd>
                        @endforeach
                        </dl>
                    @else
                        <dl class="row no-gutters">
                            <dt class="col-sm-5 spec">
                                <span class="spec-inner">
                                @lang("parts/case.$k")
                                </span>
                            </dt>
                            <dd class="col-sm-7">@lang("parts/case.$k.$v")</dd>
                        </dl>

                    @endif
                @endforeach
            </div>
        </div>
    </section>


{{--    <div class="ui grid">--}}
{{--        <div class="ui row product">--}}
{{--            <div class="ui four wide column">--}}
{{--                <img class="ui fluid image" src="{{ $case->getFirstMediaUrl('gallery') }}" alt="{{ $case->title }} photo">--}}
{{--            </div>--}}
{{--            <div class="ui seven wide column">--}}
{{--                <h1 class="ui header">{{ $case->title }}</h1>--}}
{{--                <div class="meta">--}}
{{--                    <span class="price">${{ $case->formatted_price }}</span>--}}
{{--                    <span class="link"><a href="#">Go to product page</a></span>--}}
{{--                </div>--}}
{{--                {{ $case->description }}--}}
{{--            </div>--}}
{{--            <div class="ui five wide column">--}}
{{--                <a href="{{ route('cases.edit', $case) }}" class="ui blue button">--}}
{{--                   <i class="pencil icon"></i> Edit--}}
{{--                </a>--}}
{{--                <a class="ajax-link ui negative button" data-method="delete" href="{{ route('cases.delete', $case) }}">--}}
{{--                    <i class="trash icon"></i>Delete--}}
{{--                </a>--}}
{{--                <h3 class="ui header">Specifications</h3>--}}
{{--                <div class="ui divided list">--}}
{{--                    @foreach ($case->sorted_properties as $k => $v)--}}
{{--                        <div class="item">--}}
{{--                            <div class="header">@lang("parts/case.$k")</div>--}}
{{--                            @if (is_array($v))--}}
{{--                                @foreach ($v as $subK => $subV)--}}
{{--                                    <div>--}}
{{--                                        @php--}}
{{--                                            $subV = $subV ?? 'n/a';--}}

{{--                                            if (! is_array($subV) && $subV !== 'n/a') {--}}
{{--                                                $subV = __("parts/case.$k.$subK.$subV");--}}
{{--                                            }--}}

{{--                                            if (is_array($subV)) {--}}
{{--                                                $subV = implode(', ', $subV);--}}
{{--                                            }--}}
{{--                                        @endphp--}}

{{--                                        @lang("parts/case.$k.$subK"): {{ $subV }}--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            @else--}}
{{--                                @lang("parts/case.$k.$v")--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
