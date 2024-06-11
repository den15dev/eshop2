<?php

namespace App\Admin\Categories\Requests;

use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCategoryRequest extends FormRequest
{
    use RequestHelper;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [];

        if ($this->has('name')) {
            $rules = array_merge($rules, [
                'name.*' => ['nullable'],
                'name.' . app()->getFallbackLocale() => ['required'],
            ]);
        }

        return $rules;
    }
}
