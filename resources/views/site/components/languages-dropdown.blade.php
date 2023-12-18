<div class="dropdown lang-menu{{ $type == 'mobile' ? ' mb-3' : '' }}">
    <div class="dropdown-btn">
        <img src="{{ get_image('img/flags/' . $curlang->id . '.svg', 'flag') }}" alt="">
        {{ ucfirst($curlang->id) }}
        <span class="icon-chevron-down xsmall"></span>
    </div>
    <ul class="dropdown-list{{ $type == 'desktop' ? ' dd-right' : '' }}">
        @foreach($languages as $lang)
            <li>
                <div data-lang-id="{{ $lang->id }}"{{ !$loop->index ? ' data-is-current="true"' : '' }}>
                    <img src="{{ get_image('img/flags/' . $lang->id . '.svg', 'flag') }}" alt="">
                    {{ $lang->name }}
                    @if($loop->index === 0)
                        <span class="icon-check-lg me-1{{ $type == 'mobile' ? ' va-1' : '' }}"></span>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>