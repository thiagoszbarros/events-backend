<?php

namespace Tests\Feature;

use Mockery;
use Exception;
use Tests\TestCase;
use App\Models\Event;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Interfaces\SubscriberInterface;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\SubscriberRequest;
use App\Http\Controllers\SubscriberController;
use App\Interfaces\EventsSubscribersInterface;

class SubscribersTest extends TestCase
{
    // use DatabaseTransactions;

    public function test_index(): void
    {
        $response = $this->get('/api/subscribers');

        $response->assertStatus(Response::HTTP_OK);

        $this->assertSame(
            'array',
            gettype($response->original)
        );

        $this->assertSame(
            'object',
            gettype($response->original['data'])
        );
    }

    public function test_store(): void
    {
        $event_id = Event::factory()->create()->id;
        $response = $this->post('/api/subscribers', [
            'event_id' => strval($event_id),
            'name' => fake()->name,
            'email' => fake()->safeEmail(),
            'cpf' => fake()->numerify('###########'),
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
            'Subscrição realizada com sucesso.',
            $response->original['data']
        );
    }

    public function test_subscriber_controller_exceptions()
    {
        $subscriber = Mockery::mock(SubscriberInterface::class);
        $eventSubscriber = Mockery::mock(EventsSubscribersInterface::class);
        $log = new Log();
        $subscriber->shouldReceive('index')
            ->andThrow(new Exception())
            ->shouldReceive('store')
            ->andThrow(new Exception());

        $resultIndex = (new SubscriberController($subscriber, $eventSubscriber, $log))->index(new PaginationRequest);
        $resultCreate = (new SubscriberController($subscriber, $eventSubscriber, $log))->store(new SubscriberRequest);

        $this->assertSame(
            $resultIndex->original,
            ['data' => []]
        );

        $this->assertSame(
            $resultCreate->original,
            ['data' => 'Não foi possível realizar a subscrição.']
        );
    }
}
