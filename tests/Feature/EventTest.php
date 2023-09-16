<?php

namespace Tests\Feature;

use Mockery;
use Exception;
use Tests\TestCase;
use App\Models\Event;
use App\Interfaces\CRUD;
use Illuminate\Http\Response;
use App\Http\Requests\EventRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PaginationRequest;
use App\Http\Controllers\EventController;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index(): void
    {
        $response = $this->get('/api/events');

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
        $response = $this->post('/api/events', [
            'name' => fake()->name,
            'start_date' => now()->addDays(10)->format('Y-m-d'),
            'end_date' => now()->addDays(12)->format('Y-m-d'),
            'status' => 1,
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
            'Evento criado com sucesso.',
            $response->original['data']
        );
    }

    public function test_update(): void
    {
        $id = Event::factory()->create()->id;
        $name = fake()->name;
        $startDate = now()->addDays(11)->format('Y-m-d');
        $endDate = now()->addDays(13)->format('Y-m-d');
        $status = false;

        $response = $this->put('/api/events/' . $id, [
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $updatedEvent = Event::find($id);

        $this->assertSame(
            'array',
            gettype($response->original)
        );

        $this->assertSame(
            'string',
            gettype($response->original['data'])
        );

        $this->assertSame(
            'Evento atualizado com sucesso.',
            $response->original['data']
        );

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

        $this->assertSame(
            $updatedEvent->status,
            $status
        );
    }


    public function test_detele(): void
    {
        $id = Event::factory()->create()->id;

        $eventsBeforeDelete = Event::count();

        $response = $this->delete('/api/events/' . $id);

        $eventsAfterDelete = Event::count();

        $response->assertStatus(Response::HTTP_OK);

        $this->assertSame(
            'array',
            gettype($response->original)
        );

        $this->assertSame(
            'string',
            gettype($response->original['data'])
        );

        $this->assertSame(
            'Evento excluído com sucesso.',
            $response->original['data']
        );

        $this->assertSame(
            $eventsBeforeDelete - 1,
            $eventsAfterDelete
        );
    }

    public function test_event_controller_exceptions()
    {
        $event = Mockery::mock(CRUD::class);
        $log = new Log();
        $event->shouldReceive('index')
            ->andThrow(new Exception())
            ->shouldReceive('store')
            ->andThrow(new Exception())
            ->shouldReceive('update')
            ->andThrow(new Exception())
            ->shouldReceive('delete')
            ->andThrow(new Exception());

        $resultIndex = (new EventController($event, $log))->index(new PaginationRequest);
        $resultCreate = (new EventController($event, $log))->store(new EventRequest);
        $resultUpdate = (new EventController($event, $log))->update(new EventRequest, 1);
        $resultDelete = (new EventController($event, $log))->destroy(1);

        $this->assertSame(
            $resultIndex->original,
            ['data' => []]
        );

        $this->assertSame(
            $resultCreate->original,
            ['data' => 'Não foi possível criar o evento.']
        );

        $this->assertSame(
            $resultUpdate->original,
            ['data' => 'Não foi possível atualizar o evento.']
        );

        $this->assertSame(
            $resultDelete->original,
            ['data' => 'Não foi possível excluir o evento.']
        );
    }
}