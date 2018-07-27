<?php


namespace Xervice\EventRabbitMq;


use Xervice\Core\Config\AbstractConfig;

class EventRabbitMqConfig extends AbstractConfig
{
    public const QUEUE_NAME = 'queue.name';

    public const EXCHANGE_NAME = 'exchange.name';

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->get(self::QUEUE_NAME, 'event');
    }

    /**
     * @return string
     */
    public function getExchangeName(): string
    {
        return $this->get(
            self::EXCHANGE_NAME,
            $this->getQueueName()
        );
    }
}