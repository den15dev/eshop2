<?php

namespace App\Admin\Settings\Requests;

use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;

class SettingStoreRequest extends FormRequest
{
    use RequestHelper;


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => ['required', 'regex:/^[a-z0-9_]+$/'],
            'val' => ['required'],
            'name.en' => ['required'],
        ];
    }
}
