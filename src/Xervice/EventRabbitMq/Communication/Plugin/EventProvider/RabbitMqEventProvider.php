<?php


namespace Xervice\EventRabbitMq\Communication\Plugin\EventProvider;


use DataProvider\EventDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use Xervice\Core\Plugin\AbstractCommunicationPlugin;
use Xervice\Event\Business\Model\Provider\EventProviderInterface;

/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqCommunicationFactory getFactory()
 */
class RabbitMqEventProvider extends AbstractCommunicationPlugin implements EventProviderInterface
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