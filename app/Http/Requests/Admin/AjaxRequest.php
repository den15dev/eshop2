<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AjaxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
//        return Auth::check() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [];

        if ($this->has('args.fields')) {
            $rules['args.fields.' . app()->getFallbackLocale()] = ['required'];
        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            'args.fields.*.required' => __('admin/validation.field_is_required'),
        ];
    }
}
