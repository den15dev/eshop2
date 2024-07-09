<?php

namespace App\Admin\Promos\Requests;

use App\Http\Requests\Admin\AjaxRequest;
use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;

class PromoRequest extends FormRequest
{
    use RequestHelper;


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rules = [];

        $lang_fb = app()->getFallbackLocale();

        if ($this->has('name')) {
            $rules = array_merge($rules, [
                'starts_at' => ['required', 'date'],
                'ends_at' => ['required', 'date'],
                'name.*' => ['nullable'],
                'name.' . $lang_fb => ['required'],
                'discount' => ['required', 'integer', 'max:99'],
                'description.*' => ['nullable'],
                'description.' . $lang_fb => ['required'],
            ]);
        }

        if ($this->routeIs('admin.promos.store')) {
            $rules = array_merge($rules, [
                'image.*' => ['nullable', 'mimes:jpg,png', 'dimensions:width=1296,height=500'],
                'image.' . $lang_fb => ['required', 'mimes:jpg,png', 'dimensions:width=1296,height=500'],
            ]);

        } elseif ($this->routeIs('admin.promos.update') && $this->has('image')) {
            $rules = array_merge($rules, [
                'image.*' => ['nullable', 'mimes:jpg,png', 'dimensions:width=1296,height=500'],
            ]);
        }

        if ($this->has('sku_ids')) {
            $rules = array_merge($rules, [
                'sku_ids' => ['required', 'regex:/^[0-9,\- ]+$/'],
            ]);
        }

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
