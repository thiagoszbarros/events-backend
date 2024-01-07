<?php

declare(strict_types=1);

namespace App\Http\Requests;

class Id extends Request
{
    public function prepareForValidation(): void
    {
        $this->parseAndSetIdValue();
    }

    public function rules(): array
    {
        return [
            'value' => [
                'required',
                'integer',
            ]
        ];
    }

    private function parseAndSetIdValue(): void
    {
        $id = $this->route(reset($this->route()->parameterNames));
        $this->merge([
            'value' => is_numeric($id) ? intval($id) : 0,
        ]);
    }
}
