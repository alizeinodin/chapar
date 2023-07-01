<?php

namespace App\Http\Requests\Audience;

use Illuminate\Foundation\Http\FormRequest;

class StoreAudienceRequest extends FormRequest
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
            'audience_id' => 'required|exists:users,id',
        ];
    }
}
