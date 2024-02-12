<div class="dropdown local-menu" data-type="currency">
    <div class="dropdown-btn" title="{{ $curcurr->name }}">
        {{ strtoupper($curcurr->id) }}
        <span class="icon-chevron-down xsmall"></span>
    </div>
    <ul class="dropdown-list">
        @foreach($currencies as $currency)
            <li>
                <div class="dropdown-item" data-item-id="{{ $currency->id }}"{!! !$loop->index ? ' data-is-current="true"' : '' !!} title="{{ $currency->name }}">
                    {{ strtoupper($currency->id) }}
                    @if($loop->index === 0)
                        <span class="icon-check-lg me-1{{ $type == 'mobile' ? ' va-1' : '' }}"></span>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>