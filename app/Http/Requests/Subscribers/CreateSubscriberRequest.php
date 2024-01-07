<?php

declare(strict_types=1);

namespace App\Http\Requests\Subscribers;

use App\Http\Requests\Request;
use App\Rules\CPF;

class CreateSubscriberRequest extends Request
{
    public function rules(): array
    {
        return [
            'event_id' => [
                'bail',
                'required',
                'integer',
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
