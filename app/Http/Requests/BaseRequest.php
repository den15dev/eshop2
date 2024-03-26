<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [];
    }

    public function flashSuccessMessage(string $message): void
    {
        if (!empty($message)) {
            $this->session()->flash('message', [
                'type' => 'success',
                'content' => $message,
                'align' => 'center',
            ]);
        }
    }
}
