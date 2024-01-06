<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SubscribersRequest extends Request
{
    public function rules(): array
    {
        return [
            'event_id' => [
                'required',
                'string',
                'integer',
            ],
        ];
    }
}
