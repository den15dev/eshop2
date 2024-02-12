<?php

namespace App\Http\Requests\Site;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        if ($this->hasFile('user_image')) {
            $rules = [
                'user_image' => ['max:5120', 'dimensions:max_width=5000,max_height=5000'],
            ];
        } else if ($this->has('email')) {
            $rules = [
                'name' => ['required', 'string', 'min:2', 'max:100'],
                'email' => ['required', 'email:rfc,dns', 'max:100', Rule::unique(User::class)->ignore($this->user()->id)],
                'phone' => ['nullable', 'regex:/^\+?[0-9]{0,3}[\s-]{0,2}\(?[0-9]{3}\)?[\s-]{0,2}[0-9]{3}[\s-]?[0-9]{2}[\s-]?[0-9]{2}$/'],
                'address' => ['nullable', 'min:7', 'max:255'],
            ];

        } elseif ($this->has('new_password')) {
            $rules = [
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', Password::defaults(), 'confirmed'],
            ];
        }

        return $rules;
    }
}
