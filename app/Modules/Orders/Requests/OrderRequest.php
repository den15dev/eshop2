<?php

namespace App\Modules\Orders\Requests;

use App\Modules\Orders\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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

        // For fake users to make orders
        $email_rules = ['nullable', 'max:255'];
        if (!preg_match('/@tmail.tst$/', $this->email)) $email_rules[] = 'email:rfc,dns';

        return [
            'name' => ['required', 'min:2', 'max:255'],
            'phone' => ['required', 'max:25', 'regex:' . $phone_num],
            'email' => $email_rules,
            'delivery_method' => ['required', 'in:delivery,self-delivery'],
            'payment_method' => [Rule::enum(PaymentMethod::class)],
            'delivery_address' => ['exclude_if:delivery_method,self-delivery', 'required', 'min:7'],
            'shop_id' => ['exclude_if:delivery_method,delivery', 'required', 'exists:shops,id'],
        ];
    }
}
