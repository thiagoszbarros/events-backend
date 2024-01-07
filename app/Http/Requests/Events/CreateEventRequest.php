<?php

declare(strict_types=1);

namespace App\Http\Requests\Events;

use App\Http\Requests\Request;

class CreateEventRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'start_date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:today',
            ],
            'end_date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:start_date',
            ],
        ];
    }
}
