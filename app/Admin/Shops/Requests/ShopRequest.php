<?php

namespace App\Admin\Shops\Requests;

use App\Http\Requests\Admin\AjaxRequest;
use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    use RequestHelper;


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $lang_fb = app()->getFallbackLocale();

        $rules = [
            'name.*' => ['nullable'],
            'name.' . $lang_fb => ['required'],
            'sort' => ['required', 'numeric'],
            'address.*' => ['nullable'],
            'address.' . $lang_fb => ['required'],
            'location' => ['required', 'regex:/^[\d\.]{1,10},\s?[\d\.]{1,10}$/'],
            'opening_hours' => ['required'],
            'info.*' => ['nullable'],
            'info.' . $lang_fb => ['required'],
        ];

        return $rules;
    }


    public function ajaxRules(AjaxRequest $request): array
    {
        return [];
    }


    public function messages(): array
    {
        return [
            '*.' . app()->getFallbackLocale() . '.required' => __('admin/validation.field_is_required'),
        ];
    }
}
