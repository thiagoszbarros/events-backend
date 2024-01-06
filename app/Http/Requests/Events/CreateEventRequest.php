<?php

namespace App\Http\Requests\Events;

use Illuminate\Http\Request;

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
