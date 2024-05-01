<div class="dropdown index-table_per-page-dd">
    <div class="dropdown-btn">
        <span class="sm">{{ __('admin/index-page.on_page') }}: </span>{{ $list->firstWhere('is_active', true)->num }}
        <span class="icon-chevron-down xsmall"></span>
    </div>
    <ul class="dropdown-list dd-right">
        @foreach($list as $item)
            <li>
                @if($item->is_active)
                    <div class="dropdown-item active">{{ $item->num }} <span class="icon-check-lg"></span></div>
                @else
                    <div class="dropdown-item">{{ $item->num }}</div>
                @endif
            </li>
        @endforeach
    </ul>
</div>