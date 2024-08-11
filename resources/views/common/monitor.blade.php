<div class="dev-monitor">
    @php
        $commonService = \App\Modules\Common\CommonService::class;
    @endphp
    Load time: {{ number_format(microtime(true) - $commonService::$app_start_time, 3) }} sec<br>
    DB queries: {{ $commonService::$db_query_cnt }}
</div>