<?php

namespace App\Modules\Reviews\Requests;

use App\Http\Requests\RequestHelper;
use App\Modules\Reviews\Enums\TermOfUse;
use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    use RequestHelper;

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
        $terms = implode(',', array_column(TermOfUse::cases(), 'value'));

        $rules = [
            'mark' => ['required', 'numeric', 'max:5'],
            'sku_id' => ['required', 'numeric'],
            'term' => ['required', "in:{$terms}"],
            'pros' => ['nullable', 'max:1500'],
            'cons' => ['nullable', 'max:1500'],
            'comnt' => ['nullable', 'max:1500'],
        ];

        return $rules;
    }
}
