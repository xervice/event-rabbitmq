<?php


namespace Xervice\EventRabbitMq\Communication\Plugin\Queue;
use Xervice\Core\Plugin\AbstractCommunicationPlugin;
use Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface;
use Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface;


/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqFactory getFactory()
 */
class EventExchange extends AbstractCommunicationPlugin implements ExchangeInterface
{
    /**
     * @param \Xervice\EventRabbitMq\Communication\Plugin\Queue\ExchangeProviderInterface $exchangeProvider
     *
     */
    public function declareExchange(ExchangeProviderInterface $exchangeProvider)
    {
        $exchangeProvider->declare(
            $this->getFactory()->createEventExchange()
        );
    }
}