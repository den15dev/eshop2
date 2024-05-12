<?php

namespace App\Admin\Products\Requests;

use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
    use RequestHelper;

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

        if ($this->has('name')) {
            $rules['name.*'] = ['nullable'];
            $rules['name.en'] = ['required'];
            $rules['brand'] = ['required', 'exists:brands,id'];
        }

        if ($this->has('category')) {
            $rules['category'] = ['required', 'exists:categories,id'];
        }

        return $rules;
    }
}
