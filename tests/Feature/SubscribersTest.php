<?php

namespace Tests\Feature;

use App\Models\Event;
use Avlima\PhpCpfCnpjGenerator\Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class SubscribersTest extends TestCase
{
    use DatabaseTransactions;

    public function test_store(): void
    {
        $event_id = Event::factory()->create()->id;
        $response = $this->post('/api/subscribers', [
            'event_id' => strval($event_id),
            'name' => fake()->name,
            'email' => fake()->safeEmail(),
            'cpf' => Generator::cpf(),
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertSame(
            'array',
            gettype($response->original)
        );

        $this->assertSame(
            'string',
            gettype($response->original['data'])
        );

        $this->assertSame(
            'Inscrição realizada com sucesso.',
            $response->original['data']
        );
    }

    public function test_subscribe_in_inactive_event(): void
    {
        $event = Event::factory()->create();
        $event->update(['status' => false]);

        $response = $this->post('/api/subscribers', [
            'event_id' => strval($event->id),
            'name' => fake()->name,
            'email' => fake()->safeEmail(),
            'cpf' => Generator::cpf(),
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertSame(
            'array',
            gettype($response->original)
        );

        $this->assertSame(
            'string',
            gettype($response->original['data'])
        );

        $this->assertSame(
            'Inscrição não realizada pois o evento está inativo.',
            $response->original['data']
        );
    }

    public function test_is_already_subscribed(): void
    {
        $event = Event::factory()->create();
        $subscriberName = fake()->name;
        $subscriberName = fake()->safeEmail();
        $subscriberCpf = Generator::cpf();

        $this->post('/api/subscribers', [
            'event_id' => strval($event->id),
            'name' => $subscriberName,
            'email' => $subscriberName,
            'cpf' => $subscriberCpf,
        ]);

        $response = $this->post('/api/subscribers', [
            'event_id' => strval($event->id),
            'name' => $subscriberName,
            'email' => $subscriberName,
            'cpf' => $subscriberCpf,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertSame(
            'array',
            gettype($response->original)
        );

        $this->assertSame(
            'string',
            gettype($response->original['data'])
        );

        $this->assertSame(
            'Inscrição não realizada por já ter sido realizada anteriormente.',
            $response->original['data']
        );
    }

    public function test_date_conflict(): void
    {
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();
        $subscriberName = fake()->name;
        $subscriberName = fake()->safeEmail();
        $subscriberCpf = Generator::cpf();

        $this->post('/api/subscribers', [
            'event_id' => strval($event1->id),
            'name' => $subscriberName,
            'email' => $subscriberName,
            'cpf' => $subscriberCpf,
        ]);

        $response = $this->post('/api/subscribers', [
            'event_id' => strval($event2->id),
            'name' => $subscriberName,
            'email' => $subscriberName,
            'cpf' => $subscriberCpf,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertSame(
            'array',
            gettype($response->original)
        );

        $this->assertSame(
            'string',
            gettype($response->original['data'])
        );

        $this->assertSame(
            'Inscrição não realizada por conflito de data com outro evento.',
            $response->original['data']
        );
    }
}
