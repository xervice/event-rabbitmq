<?php


namespace Xervice\EventRabbitMq\Business\EventProvider;


use DataProvider\EventDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use Xervice\Core\Locator\AbstractWithLocator;
use Xervice\Event\Business\Provider\EventProviderInterface;

/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqFactory getFactory()
 */
class RabbitMqEventProvider extends AbstractWithLocator implements EventProviderInterface
{
    /**
     * @param \DataProvider\EventDataProvider $eventDataProvider
     *
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
     */
    public function provideEvent(EventDataProvider $eventDataProvider): void
    {
        $message = new RabbitMqMessageDataProvider();
        $message
            ->setExchange($this->getFactory()->createEventExchange())
            ->setMessage(
                json_encode(
                    $eventDataProvider->toArray()
                )
            );

        $this->getFactory()->getRabbitMqFacade()->sendMessage($message);
    }
}