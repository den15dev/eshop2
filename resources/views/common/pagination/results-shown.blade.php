@if($paginator->total())
    <p class="small grey-text">
        {!! __('Showing') !!}
        {{ $paginator->firstItem() }}
        {!! __('to') !!}
        {{ $paginator->lastItem() }}
        {!! __('of') !!}
        {{ $paginator->total() }}
{{--        {!! __('results') !!}--}}
    </p>
@endif
