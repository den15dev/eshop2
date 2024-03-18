<ul class="filters_spec-list">
    @php
        $id_prefix = $ismobile ? 'bnav_' : '';
    @endphp
    @foreach($data->values as $spec_value)
        @php
            $elem_id = $id_prefix . 'specs' . $data->id . '_' . $loop->index;
            $disabled = $loop->count == 1;
        @endphp
        <li @disabled($disabled)>
            <input class="form-check-input"
                   type="checkbox"
                   name="specs[{{ $data->id }}][]"
                   value="{{ $spec_value->value }}"
                   id="{{ $elem_id }}"
                   {{ $spec_value->is_checked ? 'checked' : '' }} @disabled($disabled)>
            <label class="form-check-label" for="{{ $elem_id }}">
                {{ $spec_value->value . ($data->units ? ' ' . $data->units : '') }} <span class="lightgrey-text"> ({{ $spec_value->skus_num }})</span>
            </label>
        </li>
    @endforeach
</ul>