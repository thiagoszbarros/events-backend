<?php

namespace Tests\Feature;

use Tests\TestCase;

class HandlerTest extends TestCase
{
    public function testHandleExceptionInTesting(): void
    {
        $response = $this->get('api/handlerTest');

        $response->assertInternalServerError();
        $this->assertIsString($response->original['message']);
        $this->assertSame(
            $response->original['message'],
            'Opa! Esse teste passou.'
        );
        $this->assertNull($response->original['data']);
    }
}
