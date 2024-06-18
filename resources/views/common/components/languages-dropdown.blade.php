<div class="dropdown local-menu" data-type="language">
    <div class="dropdown-btn">
        <img src="{{ asset('img/flags/' . $curlang->id . '.svg') }}" alt="">
        {{ ucfirst($curlang->id) }}
        <span class="icon-chevron-down xsmall"></span>
    </div>
    <ul class="dropdown-list{{ $type == 'desktop' ? ' dd-right' : '' }}">
        @foreach($languages as $lang)
            <li>
                <div class="dropdown-item" data-item-id="{{ $lang->id }}"{!! !$loop->index ? ' data-is-current="true"' : '' !!}>
                    <img src="{{ asset('img/flags/' . $lang->id . '.svg') }}" alt="">
                    {{ $lang->name }}
                    @if($loop->index === 0)
                        <span class="icon-check-lg me-1{{ $type == 'mobile' ? ' va-1' : '' }}"></span>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>