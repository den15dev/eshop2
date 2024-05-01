<div class="catalog-prefs mb-4">
    <div class="dropdown catalog-prefs_sort">
        <div class="dropdown-btn" data-sort="{{ $prefs->sorting_active->sorting }}">
            {{ $prefs->sorting_active->description }}
            <span class="icon-chevron-down xsmall"></span>
        </div>
        <ul class="dropdown-list">
            @foreach($prefs->sorting as $sort_type)
                @if($sort_type->is_active)
                    <li>
                        <div class="dropdown-item active" data-sort="{{ $sort_type->sorting }}">
                            {{ $sort_type->description }} <span class="icon-check-lg"></span>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="dropdown-item" data-sort="{{ $sort_type->sorting }}">
                            {{ $sort_type->description }}
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="dropdown catalog-prefs_per-page">
        <div class="dropdown-btn">
            <span class="sm">{{ __('catalog.layout_settings.on_page') }} </span>{{ $prefs->per_page_num }}
            <span class="icon-chevron-down xsmall"></span>
        </div>
        <ul class="dropdown-list dd-right">
            @foreach($prefs->per_page as $per_page)
                @if($per_page->is_active)
                    <li>
                        <div class="dropdown-item active">{{ $per_page->num }} <span class="icon-check-lg"></span></div>
                    </li>
                @else
                    <li>
                        <div class="dropdown-item">{{ $per_page->num }}</div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="dropdown catalog-prefs_layout">
        <svg width="2" height="2" style="display: none">
            <symbol viewBox="0 0 22 22" id="catalogGrid">
                <path d="M13.2222 20.3333V13.8889C13.2222 13.5207 13.5207 13.2222 13.8889 13.2222H20.3333C20.7015 13.2222 21 13.5207 21 13.8889V20.3333C21 20.7015 20.7015 21 20.3333 21H13.8889C13.5207 21 13.2222 20.7015 13.2222 20.3333Z" />
                <path d="M1 20.3333V13.8889C1 13.5207 1.29848 13.2222 1.66667 13.2222H8.11111C8.4793 13.2222 8.77778 13.5207 8.77778 13.8889V20.3333C8.77778 20.7015 8.4793 21 8.11111 21H1.66667C1.29848 21 1 20.7015 1 20.3333Z" />
                <path d="M13.2222 8.11111V1.66667C13.2222 1.29848 13.5207 1 13.8889 1H20.3333C20.7015 1 21 1.29848 21 1.66667V8.11111C21 8.4793 20.7015 8.77778 20.3333 8.77778H13.8889C13.5207 8.77778 13.2222 8.4793 13.2222 8.11111Z" />
                <path d="M1 8.11111V1.66667C1 1.29848 1.29848 1 1.66667 1H8.11111C8.4793 1 8.77778 1.29848 8.77778 1.66667V8.11111C8.77778 8.4793 8.4793 8.77778 8.11111 8.77778H1.66667C1.29848 8.77778 1 8.4793 1 8.11111Z" />
            </symbol>

            <symbol viewBox="0 0 23 18" id="catalogList">
                <path d="M6.34036 1.73901H21.3404" />
                <path d="M1.34036 1.75206L1.35334 1.73764" />
                <path d="M1.34036 9.25205L1.35334 9.23764" />
                <path d="M1.34036 16.752L1.35334 16.7376" />
                <path d="M6.34036 9.239H21.3404" />
                <path d="M6.34036 16.739H21.3404" />
            </symbol>
        </svg>

        <div class="btn-icon {{ $prefs->layout === 1 ? 'active' : '' }}" id="catalogLayoutGrid">
            <svg viewBox="0 0 22 22">
                <use href="#catalogGrid"/>
            </svg>
        </div>
        <div class="btn-icon {{ $prefs->layout === 2 ? 'active' : '' }}" id="catalogLayoutList">
            <svg viewBox="0 0 23 18">
                <use href="#catalogList"/>
            </svg>
        </div>
    </div>
</div>