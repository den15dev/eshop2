<?php

namespace App\Admin\Promos\Requests;

use App\Http\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;

class StorePromoRequest extends FormRequest
{
    use RequestHelper;


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            //
        ];
    }
}
