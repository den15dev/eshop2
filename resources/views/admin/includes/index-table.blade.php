<div class="index-table_pref-cont mb-25">
    <x-admin::index-table.prefs.column-selector :list="$column_list" :cookie="$col_cookie_name" />
    <x-admin::index-table.prefs.per-page-dropdown :list="$per_page_list" />
</div>

<div class="index-table_wrap mb-4">
    <table class="table index-table mb-1">
        <thead>
            <tr>
                @foreach($current_columns as $column)
                    <td>
                        @if($column->show_name)
                            @if($column->order_by)
                                <div class="index-table_head-btn" data-id="{{ $column->id }}" data-sort-order="{{ $column->sort_order }}">
                                    {{ $column->name }}
                                    <svg class="index-table_sort-icon-{{ $column->sort_order ?? 'desc' }}{{ $column->sort_order ? ' active' : '' }}"><use href="#sortArrow"/></svg>
                                </div>
                            @else
                                {{ $column->name }}
                            @endif
                        @endif
                    </td>
                @endforeach
            </tr>
        </thead>

        <tbody>
        @foreach($items as $item)
            <tr>
                @foreach($current_columns as $column)
                    <td {!! $column->class_list ? 'class="' . $column->class_list . '"' : '' !!}>
                        @php
                            $prop = $column->id;
                        @endphp

                        @if($column->format)
                            {!! $column->format->get($item) !!}
                        @else
                            {{ $item->$prop ?: '-' }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>


    @if(!$items->count())
        <div class="index-table_not-found">
            {{ __('admin/products.no_products') }}
        </div>
    @endif
</div>

<div>
    {{ $items->hasPages() ? $items->links('common.pagination.results-shown') : '' }}
    {{ $items->onEachSide(1)->withPath(route('admin.' . $table_name . '.table'))->withQueryString()->links('common.pagination.page-links') }}
</div>