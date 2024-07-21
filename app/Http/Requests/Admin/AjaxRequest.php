<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AjaxRequest extends FormRequest
{
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
        return $this->getRequestInstance()?->ajaxRules($this) ?? [];
    }


    public function messages(): array
    {
        return $this->getRequestInstance()?->messages() ?? [];
    }


    private function getRequestInstance(): ?FormRequest
    {
        $requestClassName = 'App\\Admin\\' . ucfirst(Str::plural($this->service)) . '\\Requests\\' . ucfirst($this->service) . 'Request';

        return class_exists($requestClassName) ? new $requestClassName() : null;
    }
}
