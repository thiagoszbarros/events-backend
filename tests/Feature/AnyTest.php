<?php

namespace Tests\Feature;

use Tests\TestCase;

class AnyTest extends TestCase
{
    public function test_example(): void
    {
        $response = $this->get('/any');

        $response->assertNotFound();
        $this->assertSame(
            $response->original['message'],
            'Parece que você está perdido... Rota não encontrada.'
        );
    }
}
