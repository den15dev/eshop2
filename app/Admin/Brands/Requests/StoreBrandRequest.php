<?php

namespace App\Admin\Brands\Requests;

use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
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
                'name' => ['required'],
                'slug' => ['required', 'regex:/[a-z0-9-]/', Rule::unique('brands')->ignore($this->route('id'))],
                'description.*' => ['nullable'],
                'description.' . app()->getFallbackLocale() => ['required'],
            ]);
        }

        if ($this->has('image')) {
            $rules = array_merge($rules, [
                'image' => ['nullable', 'mimes:svg,png', 'max:5120'],
            ]);
        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            '*.' . app()->getFallbackLocale() . '.required' => __('admin/validation.field_is_required'),
        ];
    }
}
