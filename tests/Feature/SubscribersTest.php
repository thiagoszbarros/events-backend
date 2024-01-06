<?php

namespace Tests\Feature;

use App\Models\Event;
use Avlima\PhpCpfCnpjGenerator\Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SubscribersTest extends TestCase
{
    use DatabaseTransactions;

    public function test_store(): void
    {
        $response = $this->post('/api/subscribers', [
            'event_id' => strval(Event::factory()->create()->id),
            'name' => fake()->name,
            'email' => fake()->safeEmail(),
            'cpf' => Generator::cpf(),
        ]);

        $response->assertCreated();
        $this->assertIsArray($response->original);
        $this->assertIsString($response->original['data']);
        $this->assertSame(
            $response->original['data'],
            'Inscrição realizada com sucesso.',
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

        $response->assertBadRequest();
        $this->assertIsArray($response->original);
        $this->assertIsString($response->original['data']);
        $this->assertSame(
            $response->original['data'],
            'Inscrição não realizada pois o evento está inativo.',
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

        $response->assertBadRequest();
        $this->assertIsArray($response->original);
        $this->assertIsString($response->original['data']);
        $this->assertSame(
            $response->original['data'],
            'Inscrição não realizada por já ter sido realizada anteriormente.',
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

        $response->assertBadRequest();
        $this->assertIsArray($response->original);
        $this->assertIsString($response->original['data']);
        $this->assertSame(
            $response->original['data'],
            'Inscrição não realizada por conflito de data com outro evento.',
        );
    }

    public function test_document_has_first_checker_digit_invalid(): void
    {
        $event = Event::factory()->create();
        $subscriberName = fake()->name;
        $subscriberName = fake()->safeEmail();
        $subscriberCpf = '12345678919';

        $response = $this->post('/api/subscribers', [
            'event_id' => strval($event->id),
            'name' => $subscriberName,
            'email' => $subscriberName,
            'cpf' => $subscriberCpf,
        ]);

        $response->assertBadRequest();
        $this->assertIsArray($response->original);
        $this->assertIsString($response->original['data']);
        $this->assertSame(
            $response->original['data'],
            'O primeiro dígito verificador do CPF não está correto.O segundo dígito verificador do CPF não está correto.',
        );
    }

    public function test_document_has_second_checker_digit_invalid(): void
    {
        $event = Event::factory()->create();
        $subscriberName = fake()->name;
        $subscriberName = fake()->safeEmail();
        $subscriberCpf = '12345678900';

        $response = $this->post('/api/subscribers', [
            'event_id' => strval($event->id),
            'name' => $subscriberName,
            'email' => $subscriberName,
            'cpf' => $subscriberCpf,
        ]);

        $response->assertBadRequest();
        $this->assertIsArray($response->original);
        $this->assertIsString($response->original['data']);
        $this->assertSame(
            $response->original['data'],
            'O segundo dígito verificador do CPF não está correto.',
        );
    }

    public function test_document_has_all_digits_equals(): void
    {
        $event = Event::factory()->create();
        $subscriberName = fake()->name;
        $subscriberName = fake()->safeEmail();
        $subscriberCpf = '99999999999';

        $response = $this->post('/api/subscribers', [
            'event_id' => strval($event->id),
            'name' => $subscriberName,
            'email' => $subscriberName,
            'cpf' => $subscriberCpf,
        ]);

        $response->assertBadRequest();
        $this->assertIsArray($response->original);
        $this->assertIsString($response->original['data']);
        $this->assertSame(
            $response->original['data'],
            'O CPF fornecido não possui 11 dígitos válidos ou contém todos os números iguais.',
        );
    }
}
