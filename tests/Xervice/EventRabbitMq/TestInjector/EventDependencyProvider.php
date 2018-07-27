<?php


namespace App\Event;


use Xervice\Event\EventDependencyProvider as XerviceEventDependencyProvider;
use XerviceTest\EventRabbitMq\Listener\TestListener;

class EventDependencyProvider extends XerviceEventDependencyProvider
{
    /**
     * @return array
     */
    protected function getListener(): array
    {
        return [
            'myevent' => [
                TestListener::class
            ]
        ];
    }
}