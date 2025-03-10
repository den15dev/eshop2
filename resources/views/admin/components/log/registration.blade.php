<div class="log-day_entry_content">
    <span class="log-registration_text">
        {{ __('admin/log.entries.registration', [
            'name' => $data->name,
            'id' => $data->id,
//            'ip' => $data->ip ?? '',
        ]) }}
    </span>
</div>
