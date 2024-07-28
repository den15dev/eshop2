<div class="log-day_entry_content">
    <span class="log-new-order_text">{!! __('admin/logs.entries.new-order', [
    'id' => $data->id,
    'name' => $data->name,
    'user_note' => $data->user_id ? '(id ' . $data->user_id . ')' : '',
    'cost' => $data->cost,
    ]) !!}</span>
</div>