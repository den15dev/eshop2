<div class="log-day_entry_content">
    <span class="log-error_red">{{ __('admin/logs.entries.error') }}</span><br>
    <span class="grey-text">{{ $data->message }}</span><br>
    <span>{{ $data->file }}: {{ $data->line }}</span><br>
    <span class="log-error_link">{{ $data->url }}</span>
</div>