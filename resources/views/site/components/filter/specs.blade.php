<ul class="filters_spec-list">
    @php
        $id_prefix = $ismobile ? 'bnav_' : '';
    @endphp
    @foreach($data->values as $name => $qty)
        @php
            $elem_id = $id_prefix . 'specs' . $data->id . '_' . $loop->index;
            $disabled = $loop->count == 1;
        @endphp
        <li @disabled($disabled)>
            <input class="form-check-input"
                   type="checkbox"
                   name="specs[{{ $data->id }}][{{ $loop->index }}]"
                   value="{{ $name }}"
                   id="{{ $elem_id }}"
                    @disabled($disabled)>
            <label class="form-check-label" for="{{ $elem_id }}">
                {{ $name }} <span class="lightgrey-text"> ({{ $qty }})</span>
            </label>
        </li>
    @endforeach
</ul>