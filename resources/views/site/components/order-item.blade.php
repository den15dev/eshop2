<tr>
    <td>{{ $index }}</td>
    <td class="order-table_image">
        <a href="{{ $item->sku->url }}">
            <img src="{{ $item->sku->getImage('tn') }}" alt="{{ $item->sku->name }}">
        </a>
    </td>
    <td class="order-table_description">
        <a href="{{ $item->sku->url }}" class="dark-link order-table_name">{{ $item->sku->name }}</a>
        <div class="order-table_prod-id-md">
            <span class="lightgrey-text">{{ __('orders.product_id') }}:</span> {{ $item->sku->id }}
        </div>
        <div class="order-table_price-sm">{!! $item->price_formatted !!}</div>
    </td>
    <td>{{ $item->sku->id }}</td>
    <td class="nowrap">{!! $item->price_formatted !!}</td>
    <td class="order-table_qty nowrap">{{ $item->quantity }}</td>
    <td class="nowrap">{!! $item->cost_formatted !!}</td>
</tr>