<?php

namespace App\Admin\Log;

use App\Modules\Common\CommonService;
use Carbon\Carbon;

class LogService
{
    private const PREFIX = 'events';


    public static function getLog(): array
    {
        $log = [];
        $entries_stack = [];
        $files = array_reverse(glob(storage_path('logs') . '/' . self::PREFIX . '-*.log'));

        foreach ($files as $file) {
            $entries_stack = array_merge($entries_stack, self::parseDayEntries($file));
        }

        foreach ($entries_stack as $entry) {
            $year = $entry->datetime->tz(CommonService::$timezone)->year;
            $day = $entry->datetime->tz(CommonService::$timezone)->isToday()
                ? __('admin/logs.today')
                : $entry->datetime->tz(CommonService::$timezone)->isoFormat('D MMMM');

            $entry->time = $entry->datetime->tz(CommonService::$timezone)->isoFormat('H:mm:ss');

            $log[$year][$day][] = $entry;
        }

        return $log;
    }


    private static function parseDayEntries($filepath): array
    {
        $str = file_get_contents($filepath);

        $str_arr = explode("\n", trim($str));
        $day_log = [];
        $temp_entry = '';
        foreach ($str_arr as $part) {
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} [\d:]{7,8})] (local|production).INFO: (\{[\s\S]+)/', $part, $matches)) {
                if ($temp_entry !== '') {
                    $day_log[] = self::createNewEntry($temp_entry);
                }

                $temp_entry = new \stdClass();
                $temp_entry->datetime = Carbon::createFromDate($matches[1]);
                $temp_entry->message = $matches[3];

            } else {
                if ($temp_entry !== '') {
                    $temp_entry->message .= "\\n" . $part;
                }
            }
        }

        if (!empty($temp_entry)) {
            $day_log[] = self::createNewEntry($temp_entry);
        }

        return array_reverse($day_log);
    }


    private static function createNewEntry(\stdClass $temp_entry): \stdClass
    {
        $message = json_decode(trim($temp_entry->message));
        $new_entry = new \stdClass();
        $new_entry->datetime = $temp_entry->datetime;
        $new_entry->type = $message->type;
        $new_entry->data = $message->data;

        return $new_entry;
    }
}