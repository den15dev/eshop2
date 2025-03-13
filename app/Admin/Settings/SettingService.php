<?php

namespace App\Admin\Settings;

use App\Modules\Settings\Enums\DataType;
use App\Modules\Settings\Models\Setting;

class SettingService
{
    public function updateBooleanSetting(string $setting_id, bool $is_checked): \stdClass
    {
        $setting = Setting::find($setting_id);
        $setting->val = $is_checked ? 'true' : 'false';
        $setting->save();

        $response = new \stdClass();
        $response->setting_id = $setting_id;
        $response->is_checked = $is_checked;
        $response->message = __('admin/settings.saved');

        return $response;
    }


    public function updateSetting(string $setting_id, string $val): void
    {
        $setting = Setting::find($setting_id);

        if ($setting->data_type === DataType::Array) {
            $setting->val = explode("\r\n", trim($val));
        } else {
            $setting->val = $val;
        }

        $setting->save();
    }
}
