<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventsSubscribers;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class EventTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index(): void
    {
        $response = $this->get('/api/events');

        $response->assertStatus(Response::HTTP_OK);

        $this->assertIsArray($response->original);

        $this->assertIsObject($response->original['data']);
    }

    public function test_show(): void
    {
        $id = Event::factory()->create()->id;

        $response = $this->get("/api/events/$id");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertIsArray($response->original);

        $this->assertIsObject($response->original['data']);

        $response = $this->get('/api/events/abc');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_store(): void
    {
        $response = $this->post('/api/events', [
            'name' => fake()->name,
            'start_date' => now()->addDays(10)->format('Y-m-d'),
            'end_date' => now()->addDays(12)->format('Y-m-d'),
            'status' => 1,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertIsArray($response->original);

        $this->assertIsString($response->original['message']);

        $this->assertSame(
            'Evento criado com sucesso.',
            $response->original['message']
        );

        $this->assertNull($response->original['data']);
    }

    public function test_update(): void
    {
        $id = Event::factory()->create()->id;
        $name = fake()->name;
        $startDate = now()->addDays(11)->format('Y-m-d');
        $endDate = now()->addDays(13)->format('Y-m-d');

        $response = $this->put("/api/events/$id", [
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $updatedEvent = Event::find($id);

        $this->assertSame(
            $updatedEvent->name,
            $name
        );

        $this->assertSame(
            $updatedEvent->start_date,
            $startDate
        );

        $this->assertSame(
            $updatedEvent->end_date,
            $endDate
        );

        $response = $this->put('/api/events/abc', [
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_delete(): void
    {
        $eventsBeforeNotDelete = Event::count();

        $response = $this->delete('/api/events/abc');

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertSame(
            $eventsBeforeNotDelete,
            Event::count()
        );

        $response = $this->delete('/api/events/abc123');

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertSame(
            $eventsBeforeNotDelete,
            Event::count()
        );

        $id = Event::factory()->create()->id;

        $eventsBeforeDelete = Event::count();

        $response = $this->delete("/api/events/$id");

        $eventsAfterDelete = Event::count();

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertSame(
            $eventsBeforeDelete - 1,
            $eventsAfterDelete
        );
    }

    public function test_subscribers(): void
    {
        $eventId = Event::factory()->create()->id;
        EventsSubscribers::create(
            [
                'event_id' => $eventId,
                'subscriber_id' => Subscriber::factory()->create()->id,
            ]
        );

        $response = $this->get("/api/subscribers?event_id=$eventId");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertIsArray($response->original);

        $this->assertIsObject($response->original['data']);

        $this->assertTrue(count($response->original['data']) >= 1);
    }
}
