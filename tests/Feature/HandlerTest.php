<?php

namespace Tests\Feature;

use Tests\TestCase;

class HandlerTest extends TestCase
{
    public function testHandleExceptionInTesting(): void
    {
        $response = $this->get('api/handlerTest');

        $response->assertInternalServerError();
        $this->assertSame(
            $response->original['data'],
            'Opa! Esse teste passou.'
        );
    }
}
