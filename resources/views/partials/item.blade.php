@php
    /** @var \App\Models\Parts\CasePart $case  **/
@endphp
<div class="col-sm-6 col-md-4 col-lg-3 mt-4">
    <div class="card">
        <a href="{{ route('cases.show', $case->slug) }}">
            <img src="{{ $case->getFirstMediaUrl('default', 'medium') }}" class="card-img-top" alt="{{ $case->title  }} photo">
        </a>
        <div class="card-body">
            <h3 class="h4 card-title">{{ $case->title }}</h3>
            <p class="card-text">
                {{ $case->properties['size']['volume'] ?? 'volume' }}<br>
                {{ $case->properties['type'] }}<br>
                {{ implode(', ', $case->properties['psu']['type']) }}
            </p>
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
