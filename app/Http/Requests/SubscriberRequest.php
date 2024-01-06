<?php

namespace App\Http\Requests;

use App\Rules\CPF;
use App\Http\Requests\Request;

class SubscriberRequest extends Request
{
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
                'string',
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
                new CPF,
            ],
        ];
    }
}
