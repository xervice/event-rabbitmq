<?php


namespace Xervice\EventRabbitMq\Communication\Plugin\Queue;


use Xervice\Core\Locator\AbstractWithLocator;
use Xervice\RabbitMQ\Core\ExchangeProviderInterface;
use Xervice\RabbitMQ\Exchange\ExchangeInterface;

/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqFactory getFactory()
 */
class EventExchange extends AbstractWithLocator implements ExchangeInterface
{
    /**
     * @param \Xervice\RabbitMQ\Core\ExchangeProviderInterface $exchangeProvider
     *
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
     */
    public function declareExchange(ExchangeProviderInterface $exchangeProvider)
    {
        $exchangeProvider->declare(
            $this->getFactory()->createEventExchange()
        );
    }
}