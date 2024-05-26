<?php

namespace App\Admin\Products\Requests;

use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSkuRequest extends FormRequest
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
                'description.*' => ['nullable'],
                'description.' . app()->getFallbackLocale() => ['required'],
                'price' => ['required', 'numeric'],
                'currency_id' => ['required'],
                'discount' => ['nullable', 'int'],
                'promo_id' => ['nullable', 'int'],
            ]);
        }

        if ($this->has('images')) {
            $rules = array_merge($rules, [
                'old_images' => ['nullable', 'json'],
                'images' => ['nullable', 'json'],
                'image' => ['nullable', 'max:5120', 'dimensions:min_width=800,min_height=800,max_width=5000,max_height=5000'],
            ]);
        }

        return $rules;
    }


    public function attributes(): array
    {
        return [
            'available_from' => __('admin/products.available_from'),
            'available_until' => __('admin/products.available_until'),
        ];
    }

    public function messages(): array
    {
        return [
            '*.' . app()->getFallbackLocale() . '.required' => __('admin/validation.field_is_required'),
        ];
    }
}
