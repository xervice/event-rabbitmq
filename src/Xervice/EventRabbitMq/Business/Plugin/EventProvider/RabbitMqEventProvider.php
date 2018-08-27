<?php


namespace Xervice\EventRabbitMq\Business\Plugin\EventProvider;


use DataProvider\EventDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use Xervice\Core\Plugin\AbstractBusinessPlugin;
use Xervice\Event\Business\Model\Provider\EventProviderInterface;

/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqBusinessFactory getFactory()
 */
class RabbitMqEventProvider extends AbstractBusinessPlugin implements EventProviderInterface
{
    /**
     * @param \DataProvider\EventDataProvider $eventDataProvider
     */
    public function provideEvent(EventDataProvider $eventDataProvider): void
    {
        $message = new RabbitMqMessageDataProvider();
        $message
            ->setExchange($this->getFactory()->createEventExchange())
            ->setMessage($eventDataProvider);

        $this->getFactory()->getRabbitMqFacade()->sendMessage($message);
    }
}