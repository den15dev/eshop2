<nav class="breadcrumb-cont mb-3" aria-label="breadcrumb">
    <ol class="breadcrumb mt-0">
        @foreach($breadcrumb->parts as $part)
            @if($loop->last && $breadcrumb->active)
                <li class="breadcrumb-item active" aria-current="page">{{ $part['text'] }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $part['url'] }}" class="grey-link">{{ $part['text'] }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>