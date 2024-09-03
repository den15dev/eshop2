<?php

namespace App\Modules\Reviews\Requests;

use App\Http\Requests\RequestHelper;
use App\Modules\Reviews\Enums\TermOfUse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewRequest extends FormRequest
{
    use RequestHelper;


    public function authorize(): bool
    {
        return Auth::check();
    }


    public function rules(): array
    {
        return [
            'mark' => ['required', 'numeric', 'max:5'],
            'sku_id' => ['required', 'numeric'],
            'term' => ['required', Rule::enum(TermOfUse::class)],
            'pros' => ['nullable', 'max:1500'],
            'cons' => ['nullable', 'max:1500'],
            'comnt' => ['nullable', 'max:1500'],
        ];
    }
}
