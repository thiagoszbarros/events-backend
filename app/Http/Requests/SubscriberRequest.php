<?php

namespace App\Http\Requests;

use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;

class SubscriberRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => [
                'bail',
                'required',
                'string',
            ],
            'name' => [
                'bail',
                'required',
                'string'
            ],
            'email' => [
                'bail',
                'required',
                'email',
            ],
            'cpf' => [
                'bail',
                'required',
                'numeric',
                'digits:11',
                new CPF
            ]
        ];
    }
}
