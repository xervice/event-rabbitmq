<?php

namespace Xervice\EventRabbitMq\Business\Plugin\Queue;

use Xervice\Core\Plugin\AbstractBusinessPlugin;
use Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface;
use Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface;


/**
 * @method \Xervice\EventRabbitMq\Business\EventRabbitMqBusinessFactory getFactory()
 */
class EventExchange extends AbstractBusinessPlugin implements ExchangeInterface
{
    /**
     * @param \Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface $exchangeProvider
     */
    public function declareExchange(ExchangeProviderInterface $exchangeProvider)
    {
        $exchangeProvider->declare(
            $this->getFactory()->createEventExchange()
        );
    }
}