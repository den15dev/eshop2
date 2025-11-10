<?php

namespace App\Admin\Products\Requests;

use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;

class SkuRequest extends FormRequest
{
    use RequestHelper;


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rules = [];

        if ($this->has('available_from')) {
            $rules = array_merge($rules, [
                'available_from' => ['nullable', 'date'],
                'available_until' => ['nullable', 'date'],
            ]);
        }

        if ($this->has('sku')) {
            $rules = array_merge($rules, [
                'name.*' => ['nullable'],
                'name.' . app()->getFallbackLocale() => ['required'],
                'sku' => ['nullable'],
                'short_descr.*' => ['nullable'],
                'short_descr.' . app()->getFallbackLocale() => ['required'],
                'description.*' => ['nullable'],
                'description.' . app()->getFallbackLocale() => ['required'],
                'price' => ['required', 'numeric'],
                'currency_id' => ['required'],
                'discount' => ['nullable', 'int'],
                'promo_id' => ['nullable', 'int'],
            ]);
        }

        $image_rules = ['nullable', 'max:5120', 'dimensions:min_width=800,min_height=800,max_width=5000,max_height=5000'];

        if ($this->has('old_images')) {
            $rules = array_merge($rules, [
                'old_images' => ['nullable', 'json'],
                'new_images' => ['nullable', 'json'],
                'sku_code' => ['required', 'numeric'],
                'image' => $image_rules,
            ]);
        }

        if ($this->has('images')) {
            $rules = array_merge($rules, [
                'images.*' => $image_rules,
            ]);
        }

        if ($this->has('specs')) {
            $rules = array_merge($rules, [
                'specs.*.*' => ['nullable'],
                'specs.*.' . app()->getFallbackLocale() => ['required'],
            ]);
        }

        return $rules;
    }


    public function attributes(): array
    {
        return [
            'available_from' => __('admin/skus.available_from'),
            'available_until' => __('admin/skus.available_until'),
        ];
    }

    public function messages(): array
    {
        return [
            '*.' . app()->getFallbackLocale() . '.required' => __('admin/validation.field_is_required'),
            'specs.*.' . app()->getFallbackLocale() . '.required' => __('admin/validation.field_is_required'),
        ];
    }
}
