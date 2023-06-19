<?php

namespace App\Http\Requests\SMS\SMSVerification;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
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
            'phone' => [
                'required',
                new PhoneRule(),
            ],
            'code' => 'required|integer|size:6',
        ];
    }
}
