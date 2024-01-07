<?php

declare(strict_types=1);

namespace App\Http\Requests\Subscribers;

use App\Http\Requests\Request;

class ListSubscribersByEventRequest extends Request
{
    public function rules(): array
    {
        return [
            'event_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
