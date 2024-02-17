<div class="filters-dropdown" data-collapsed="{{ $collapsed }}">
    <div class="filters-header">
        <div class="filters-chevron">
            <svg{!! $collapsed == 'off' ? ' class="down"' : '' !!}><use href="#sidebarChevron"/></svg>
        </div>
        <div class="filters-title">{{ $title }}</div>
    </div>
    <div class="{{ $ismobile ? 'filters-section' : 'filters-section-scroll scrollbar-thin' }}" {!! $collapsed == 'on' ? 'style="display: none"' : '' !!}>
        {{ $slot }}
    </div>
</div>