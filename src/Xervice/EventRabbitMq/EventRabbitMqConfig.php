<?php
declare(strict_types=1);

namespace Xervice\EventRabbitMq;

use Xervice\Core\Business\Model\Config\AbstractConfig;

class EventRabbitMqConfig extends AbstractConfig
{
    public const QUEUE_NAME = 'event.queue.name';
    public const EXCHANGE_NAME = 'event.exchange.name';

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