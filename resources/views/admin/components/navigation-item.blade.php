<li>
    <a href="{{ route('admin.' . $route) }}" class="admin-nav_item {{ active_link('admin.' . $route) }}">
        <svg class="admin-nav_icon"><use href="#{{ $icon }}"/></svg>
        <div class="admin-nav_title">{{ __('admin/layout.navigation.' . $route) }}</div>
    </a>
</li>