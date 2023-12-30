<div class="dev-monitor">
    Load time: {{ number_format(microtime(true) - LARAVEL_START, 3) }} sec<br>
    DB queries: {{ \App\Modules\Common\CommonService::$db_query_cnt }}
</div>