<ul class="filters_spec-list">
    @php
        $id_prefix = $ismobile ? 'bnav_' : '';
    @endphp
    @foreach($data as $item)
        @php
            $elem_id = $id_prefix . $name . $item->id;
            $disabled = $loop->count == 1;
        @endphp
        <li @disabled($disabled)>
            <input class="form-check-input"
                   type="checkbox"
                   name="{{ $name }}[{{ $loop->index }}]"
                   value="{{ $item->id }}"
                   id="{{ $elem_id }}"
                   {{ $item->is_checked ? 'checked' : '' }} @disabled($disabled)>
            <label class="form-check-label" for="{{ $elem_id }}">
                {{ $item->name }} <span class="lightgrey-text"> ({{ $item->skus_num }})</span>
            </label>
        </li>
    @endforeach
</ul>