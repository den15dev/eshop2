<?php

namespace App\Modules\Orders\Requests;

use App\Http\Requests\BaseRequest;
use App\Modules\Orders\Enums\PaymentMethod;
use Illuminate\Validation\Rule;

class OrderRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $phone_num = '/^\+?[0-9]{0,3}[\s-]{0,2}\(?[0-9]{3}\)?[\s-]{0,2}[0-9]{3}[\s-]?[0-9]{2}[\s-]?[0-9]{2}$/';

        $rules = [
            'name' => ['required', 'min:2', 'max:255'],
            'phone' => ['required', 'max:25', 'regex:' . $phone_num],
            'email' => ['nullable', 'email:rfc,dns', 'max:255'],
            'delivery_method' => ['required', 'in:delivery,self-delivery'],
            'payment_method' => [Rule::enum(PaymentMethod::class)],
        ];

        if ($this->input('delivery_method') === 'delivery') {
            $rules['delivery_address'] = ['required', 'min:7'];

        } elseif ($this->input('delivery_method') === 'self-delivery') {
            $rules['shop_id'] = ['required', 'exists:shops,id'];
        }

        return $rules;
    }
}
