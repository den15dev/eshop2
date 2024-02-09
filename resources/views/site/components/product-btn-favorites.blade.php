<div class="product-favorite-btn {{ $active ? 'active' : '' }}"
     data-id="{{ $id }}"
     {!! $active ? 'title="' . __('favorites.remove_title') . '"' : '' !!}>
    <span class="favorite-btn-icon {{ $active ? 'icon-heart-fill' : 'icon-heart' }}"></span>
    <span class="favorite-btn-text">{{ $active ? __('favorites.in_fav') : __('favorites.add_to_fav') }}</span>
</div>