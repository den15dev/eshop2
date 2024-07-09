<?php

namespace App\Admin\Categories\Requests;

use App\Http\Requests\Admin\AjaxRequest;
use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
                'slug' => ['required', 'regex:/[a-z0-9-]/', Rule::unique('categories')->ignore($this->route('id'))],
            ]);
        }

        if ($this->has('image')) {
            $rules = array_merge($rules, [
                'image' => ['nullable', 'max:5120', 'dimensions:min_width=230,min_height=230,max_width=5000,max_height=5000'],
            ]);
        }

        return $rules;
    }


    public function ajaxRules(AjaxRequest $request): array
    {
        $rules = [];

        if (in_array($request->action, [
            'updateSpec',
            'storeSpec',
        ])) {
            $rules['args.fields.name.' . app()->getFallbackLocale()] = ['required'];
            $rules['args.fields.units.' . app()->getFallbackLocale()] = ['sometimes', 'required'];
            $rules['args.fields.sort'] = ['required', 'integer'];
        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            '*.' . app()->getFallbackLocale() . '.required' => __('admin/validation.field_is_required'),
            'args.fields.*.' . app()->getFallbackLocale() . '.required' => __('admin/validation.field_is_required'),
        ];
    }
}
