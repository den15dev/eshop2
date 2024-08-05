<ul class="admin-nav-list">
    <x-admin::navigation-item route="dashboard" icon="navStatisticsIcon" />
    <x-admin::navigation-item route="log" icon="navLogIcon" />
    <x-admin::navigation-item route="orders" icon="navOrderIcon" badge="{{ $new_orders_num }}" />
    <x-admin::navigation-item route="products" icon="navProductIcon" />
    <x-admin::navigation-item route="categories" icon="navCategoryIcon" />
    <x-admin::navigation-item route="brands" icon="navBrandIcon" />
    <x-admin::navigation-item route="promos" icon="navPromoIcon" />
    <x-admin::navigation-item route="users" icon="navUserIcon" />
    <x-admin::navigation-item route="reviews" icon="navReviewIcon" />
    <x-admin::navigation-item route="shops" icon="navStoreIcon" />
</ul>
