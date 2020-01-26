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

                                if (is_string($subV) && ! is_numeric($subV) && $subV !== 'n/a') {
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
@endsection
