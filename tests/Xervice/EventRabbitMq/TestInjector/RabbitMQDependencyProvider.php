<?php


namespace App\RabbitMQ;


use Xervice\EventRabbitMq\Business\Listener\QueueListener;
use Xervice\EventRabbitMq\Business\Queue\EventExchange;
use Xervice\EventRabbitMq\Business\Queue\EventQueue;
use Xervice\RabbitMQ\RabbitMQDependencyProvider as XerviceRabbitMQDependencyProvider;

class RabbitMQDependencyProvider extends XerviceRabbitMQDependencyProvider
{
    /**
     * @return array
     */
    protected function getListener(): array
    {
        return [
            new QueueListener()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Queue\QueueInterface[]
     */
    protected function getQueues(): array
    {
        return [
            new EventQueue()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Exchange\ExchangeInterface[]
     */
    protected function getExchanges(): array
    {
        return [
            new EventExchange()
        ];
    }

}