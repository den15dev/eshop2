<?php

namespace App\Modules\Log;

use Illuminate\Support\Facades\Log;

class LogService
{
    public static function writeEventLog(string $type, array $data): void
    {
        $log_obj = new \stdClass();
        $log_obj->type = $type;
        $log_obj->data = $data;
        $log_json = json_encode($log_obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Log::channel('events')->info($log_json);
    }
}