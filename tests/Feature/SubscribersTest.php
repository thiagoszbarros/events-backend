<?php

namespace Tests\Feature;

use App\Http\Controllers\SubscriberController;
use App\Http\Requests\SubscriberRequest;
use App\Interfaces\EventsSubscribersRepositoryInterface;
use App\Models\Event;
use App\Services\SubscriberService;
use Avlima\PhpCpfCnpjGenerator\Generator;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Mockery;
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

    public function test_subscriber_controller_exceptions()
    {
        $subscriber = Mockery::mock(SubscriberService::class);
        $eventSubscriber = Mockery::mock(EventsSubscribersRepositoryInterface::class);
        $log = new Log();
        $subscriber->shouldReceive('index')
            ->andThrow(new Exception())
            ->shouldReceive('store')
            ->andThrow(new Exception());

        $resultCreate = (new SubscriberController($subscriber, $eventSubscriber, $log))->store(new SubscriberRequest);

        $this->assertSame(
            $resultCreate->original,
            ['data' => 'Não foi possível realizar a subscrição.']
        );
    }
}
