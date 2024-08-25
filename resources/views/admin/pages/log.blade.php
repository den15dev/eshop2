@extends('admin.layout')

@section('page_title',  __('admin/log.log') . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/log.log'))

@section('main_content')
    <div>
        <div class="log-update-time">
            {{ __('admin/log.page_updated', ['num' => 30]) }}<br>
            {{ __('admin/log.updated') }}: <span id="logUpdateTime">{{ $current_time }}</span>
        </div>

        <div class="log-wrap">
            @foreach($log as $year => $year_block)
                @if($loop->index)
                    <div class="log-year_title">{{ $year }}</div>
                @endif

                <div class="log-year">
                    @foreach($year_block as $day => $day_block)
                        <div class="log-day">
                            <div class="log-day_title">{{ $day }}</div>

                            @foreach($day_block as $entry)
                                <div class="log-day_entry">
                                    <div class="log-day_entry_time">{{ $entry->time }}</div>
                                    @if($entry->type === 'error' && !$is_admin)
                                        <x-admin::log.error-guest />
                                    @else
                                        <x-dynamic-component :component="'admin::log.' . $entry->type" :data="$entry->data" />
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
