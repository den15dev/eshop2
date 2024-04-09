<?php

namespace App\Modules\Shops\Actions;

class GetOpeningHoursForHumanAction
{
    /**
     * Create opening hours array of strings with days of week.
     *
     * @param array $opening_hours - e.g. [[9, 20], [9, 20], [9, 20], [9, 20], [10, 18], [], []]
     * @return array - e.g. ['Mo-Th: 9:00 - 20:00', 'Fr: 10:00 - 18:00', 'Sa, Su: closed']
     */
    public static function run(array $opening_hours): array
    {
        $days = [
            __('stores.weekdays.mo'),
            __('stores.weekdays.tu'),
            __('stores.weekdays.we'),
            __('stores.weekdays.th'),
            __('stores.weekdays.fr'),
            __('stores.weekdays.sa'),
            __('stores.weekdays.su'),
        ];

        $weekdays = [];

        foreach ($opening_hours as $num => $day_hours) {
            $weekdays[$days[$num]] = count($day_hours) ? $day_hours[0] . ':00' . ' - ' . $day_hours[1] . ':00' : __('stores.closed');
        }

        $hours_blocks = [];
        $ind = 0;

        foreach ($weekdays as $weekday => $hours) {
            if (key_exists($hours, $hours_blocks)) {
                $hours_blocks[$hours][$ind] = $weekday;
            } else {
                $hours_blocks[$hours] = [$ind => $weekday];
            }
            $ind++;
        }

        $human_blocks = [];

        foreach ($hours_blocks as $hours => $block_days) {
            if (count($block_days) > 2) {

                $human_block = null;
                $end_day = null;
                $num_days = 0;
                $prev_ind = 0;

                foreach ($block_days as $ind => $block_day) {

                    if ($ind - $prev_ind === 1) {
                        $end_day = $block_day;
                        $num_days++;
                    } else {
                        if ($end_day) {
                            if ($num_days > 2) {
                                $human_block .= '-' . $end_day . ', ' . $block_day;
                            } else {
                                $human_block .= ', ' . $end_day . ', ' . $block_day;
                            }
                            $num_days = 0;
                        } else if ($human_block) {
                            $human_block .= ', ' . $block_day;
                        } else {
                            $human_block = $block_day;
                            $num_days = 1;
                        }
                        $end_day = null;
                    }

                    $prev_ind = $ind;
                }

                if ($end_day) {
                    if ($num_days > 2) {
                        $human_block .= '-' . $end_day . ': ' . $hours;
                    } else {
                        $human_block .= ', ' . $end_day . ': ' . $hours;
                    }
                }

                $human_blocks[] = $human_block;

            } else if (count($block_days) > 1) {
                $human_blocks[] = implode(', ', $block_days) . ': ' . $hours;
            } else {
                $human_blocks[] = reset($block_days) . ': ' . $hours;
            }
        }

        return $human_blocks;
    }
}