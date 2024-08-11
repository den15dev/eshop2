<?php

namespace App\Modules\Common;

class CommonService
{
    public static int $db_query_cnt = 0;
    public static float $app_start_time;
    public static string $timezone = 'UTC';
}