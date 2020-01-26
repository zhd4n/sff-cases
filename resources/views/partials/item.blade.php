@php
    /** @var \App\Models\Parts\CasePart $case  **/
@endphp
<div class="col-sm-6 col-md-4 col-lg-3 mt-4">
    <div class="card">
        <a href="{{ route('cases.show', $case->slug) }}">
            <img src="{{ $case->getFirstMediaUrl('default', 'medium') }}" class="card-img-top" alt="{{ $case->title  }} photo">
        </a>
        <div class="card-body">
            <h3 class="h5 card-title">{{ $case->title }}</h3>
            <div class="card-text">
                <dl class="row no-gutters">
                    <dt class="col-sm-8 spec">
                        <span class="spec-inner">@lang("parts/case.size.volume")</span>
                    </dt>
                    <dd class="col-sm-4">{{ $case->properties['size']['volume'] ?? 'n/a' }}</dd>

                    <dt class="col-sm-8 spec">
                        <span class="spec-inner">@lang("parts/case.type")</span>
                    </dt>
                    <dd class="col-sm-4">{{ __("parts/case.type.".$case->properties['type']) }}</dd>
                </dl>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    ${{ $case->formatted_price }}
                </div>
                <div class="col text-right">
                    <a href="{{ route('cases.edit', $case) }}"><i class="far fa-edit"></i></a>
                    <a class="ajax-link" data-method="delete" href="{{ route('cases.delete', $case->id) }}"><i class="far text-danger fa-trash-alt"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
