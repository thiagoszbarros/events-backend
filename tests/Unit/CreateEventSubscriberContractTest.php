<?php

namespace Tests\Unit;

use App\Contracts\Subscriber\CreateEventSubscriberContract;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\EventsSubscribersRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateEventSubscriberContractTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testEventStatusShouldBeActive()
    {
        $eventsSubscribers = Mockery::mock(EventsSubscribersRepositoryInterface::class);
        $eventsSubscribers->shouldReceive('findByEventIdAndSubscriverId')
            ->andReturn(null);

        $event = Mockery::mock(EventRepositoryInterface::class);
        $event->shouldReceive('hasDateConflict')
            ->andReturn(false);

        $contract = new CreateEventSubscriberContract(
            $eventsSubscribers,
            $event
        );

        $validation = $contract->validate(true, 1, 1);

        $this->assertTrue($validation->isValid);

        $validation = $contract->validate(false, 1, 1);

        $this->assertFalse($validation->isValid);
        $this->assertContains('Inscrição não realizada pois o evento está inativo.', $validation->errors);
    }

    public function testIsNotAlreadySubscribed()
    {
        $eventsSubscribers = Mockery::mock(EventsSubscribersRepositoryInterface::class);
        $eventsSubscribers->shouldReceive('findByEventIdAndSubscriverId')
            ->andReturn(null);

        $event = Mockery::mock(EventRepositoryInterface::class);
        $event->shouldReceive('hasDateConflict')
            ->andReturn(false);

        $validation = (new CreateEventSubscriberContract(
            $eventsSubscribers,
            $event
        ))->validate(true, 1, 1);

        $this->assertTrue($validation->isValid);
    }

    public function testIsAlreadySubscribed()
    {
        $eventsSubscribers = Mockery::mock(EventsSubscribersRepositoryInterface::class);
        $eventsSubscribers->shouldReceive('findByEventIdAndSubscriverId')
            ->andReturn(new stdClass);

        $event = Mockery::mock(EventRepositoryInterface::class);
        $event->shouldReceive('hasDateConflict')
            ->andReturn(false);

        $validation = (new CreateEventSubscriberContract(
            $eventsSubscribers,
            $event
        ))->validate(true, 1, 1);

        $this->assertFalse($validation->isValid);
        $this->assertContains('Inscrição não realizada por já ter sido realizada anteriormente.', $validation->errors);
    }

    public function testHasDateConflict()
    {
        $eventsSubscribers = Mockery::mock(EventsSubscribersRepositoryInterface::class);
        $eventsSubscribers->shouldReceive('findByEventIdAndSubscriverId')
            ->andReturn(null);
        $event = Mockery::mock(EventRepositoryInterface::class);
        $event->shouldReceive('hasDateConflict')
            ->andReturn(true);

        $validation = (new CreateEventSubscriberContract(
            $eventsSubscribers,
            $event
        ))->validate(true, 1, 1);

        $this->assertFalse($validation->isValid);
        $this->assertContains('Inscrição não realizada por conflito de data com outro evento.', $validation->errors);
    }

    public function testHasNotDateConflict()
    {
        $eventsSubscribers = Mockery::mock(EventsSubscribersRepositoryInterface::class);
        $eventsSubscribers->shouldReceive('findByEventIdAndSubscriverId')
            ->andReturn(null);
        $event = Mockery::mock(EventRepositoryInterface::class);
        $event->shouldReceive('hasDateConflict')
            ->andReturn(false);

        $validation = (new CreateEventSubscriberContract(
            $eventsSubscribers,
            $event
        ))->validate(true, 1, 1);

        $this->assertTrue($validation->isValid);
    }
}
