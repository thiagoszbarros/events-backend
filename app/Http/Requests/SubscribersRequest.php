<?php

namespace App\Http\Requests;

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
