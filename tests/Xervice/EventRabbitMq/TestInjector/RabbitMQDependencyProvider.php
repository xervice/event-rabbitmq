<?php


namespace App\RabbitMQ;


use Xervice\EventRabbitMq\Business\Plugin\Listener\QueueListener;
use Xervice\EventRabbitMq\Business\Plugin\Queue\EventExchange;
use Xervice\EventRabbitMq\Business\Plugin\Queue\EventQueue;
use Xervice\RabbitMQ\RabbitMQDependencyProvider as XerviceRabbitMQDependencyProvider;

class RabbitMQDependencyProvider extends XerviceRabbitMQDependencyProvider
{
    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface[]
     */
    protected function getListener(): array
    {
        return [
            new QueueListener()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface[]
     */
    protected function getQueues(): array
    {
        return [
            new EventQueue()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface[]
     */
    protected function getExchanges(): array
    {
        return [
            new EventExchange()
        ];
    }

}