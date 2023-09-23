<?php

namespace Tests\Unit;

use App\Http\Controllers\EventController;
use App\Http\Requests\EventRequest;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\SubscriberRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function test_event_controller_exceptions()
    {
        $event = Mockery::mock(EventRepositoryInterface::class);
        $subscriber = Mockery::mock(SubscriberRepositoryInterface::class);
        $log = new Log();
        $event->shouldReceive('index')
            ->andThrow(new Exception())
            ->shouldReceive('store')
            ->andThrow(new Exception())
            ->shouldReceive('store')
            ->andThrow(new Exception())
            ->shouldReceive('update')
            ->andThrow(new Exception())
            ->shouldReceive('delete')
            ->andThrow(new Exception());

        $resultIndex = (new EventController($event, $subscriber, $log))->index();
        $resultShow = (new EventController($event, $subscriber, $log))->show(1);
        $resultCreate = (new EventController($event, $subscriber, $log))->store(new EventRequest);
        $resultUpdate = (new EventController($event, $subscriber, $log))->update(new EventRequest, 1);
        $resultDelete = (new EventController($event, $subscriber, $log))->destroy(1);

        $this->assertSame(
            $resultIndex->original,
            ['data' => []]
        );

        $this->assertSame(
            $resultShow->original,
            ['data' => 'Não foi possível obter o evento.']
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
