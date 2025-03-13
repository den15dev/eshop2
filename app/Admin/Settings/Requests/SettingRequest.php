<?php

namespace App\Admin\Settings\Requests;

use App\Http\Requests\Admin\AjaxRequest;
use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    use RequestHelper;


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'val' => ['exclude_unless:data_type,integer', 'integer'],
        ];
    }


    public function ajaxRules(AjaxRequest $request): array
    {
        return [];
    }
}
