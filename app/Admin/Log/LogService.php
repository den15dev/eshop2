<?php

namespace App\Admin\Log;

use Carbon\Carbon;

class LogService
{
    private const PREFIX = 'events';


    public static function getLog(): array
    {
        $log = [];
        $files = array_reverse(glob(storage_path('logs') . '/' . self::PREFIX . '-*.log'));

        foreach ($files as $file) {
            $date = substr(pathinfo($file, PATHINFO_FILENAME), strlen(self::PREFIX) + 1);
            $year = Carbon::parse($date)->year;
            $day = Carbon::parse($date)->isoFormat('D MMMM');

            $log[$year][$day] = self::parseDayEntries($file);
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
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} [\d:]{7,8})] local.INFO: (\{[\s\S]+)/', $part, $matches)) {
                if ($temp_entry !== '') {
                    $day_log[] = self::createNewEntry($temp_entry);
                    $temp_entry = '';
                }

                $temp_entry = new \stdClass();
                $date_time = explode(' ', $matches[1]);
                $temp_entry->date = $date_time[0];
                $temp_entry->time = $date_time[1];
                $temp_entry->message = $matches[2];

            } else {
                if ($temp_entry !== '') {
                    $temp_entry->message .= "\\n" . $part;
                }
            }
        }

        if (!empty($temp_entry)) {
            $day_log[] = self::createNewEntry($temp_entry);
        }

        return $day_log;
    }


    private static function createNewEntry(\stdClass $temp_entry): \stdClass
    {
        $message = json_decode(trim($temp_entry->message));
        $new_entry = new \stdClass();
        $new_entry->time = $temp_entry->time;
        $new_entry->type = $message->type;
        $new_entry->data = $message->data;

        return $new_entry;
    }
}