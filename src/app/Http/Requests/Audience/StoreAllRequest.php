<?php

namespace App\Http\Requests\Audience;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAllRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'phones' => 'required|array',
            # TODO validation phone number with +98 in start of phone number
            'phones.*' => [
                'required',
                new PhoneRule()
            ]
        ];
    }
}
