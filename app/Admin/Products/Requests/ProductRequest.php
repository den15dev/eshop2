<?php

namespace App\Admin\Products\Requests;

use App\Http\Requests\Admin\AjaxRequest;
use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    use RequestHelper;


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rules = [];

        if ($this->has('name')) {
            $rules = array_merge($rules, [
                'name.*' => ['nullable'],
                'name.' . app()->getFallbackLocale() => ['required'],
                'brand' => ['required'],
            ]);
        }

        if ($this->has('category')) {
            $rules = array_merge($rules, [
                'category' => ['required'],
            ]);
        }

        return $rules;
    }


    public function ajaxRules(AjaxRequest $request): array
    {
        $rules = [];

        if (in_array($request->action, [
            'updateSkuSpec',
            'updateAttribute',
            'updateVariant',
            'createAttribute',
            'createVariant',
        ])) {
            $rules['args.fields.' . app()->getFallbackLocale()] = ['required'];
        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            '*.' . app()->getFallbackLocale() . '.required' => __('admin/validation.field_is_required'),
            'args.fields.' . app()->getFallbackLocale() . '.required' => __('admin/validation.field_is_required'),
        ];
    }
}
