<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class Request extends FormRequest
{
    protected function failedValidation(Validator $validator): Response
    {
        throw new HttpResponseException(
            new Response(
                [
                    'message' => implode($validator->errors()->all()),
                    'data' => null,
                ],
                Response::HTTP_BAD_REQUEST,
            )
        );
    }
}
