<?php


namespace Xervice\EventRabbitMq\Communication\Plugin\Queue;


use Xervice\Core\Locator\AbstractWithLocator;
use Xervice\RabbitMQ\Core\QueueProviderInterface;
use Xervice\RabbitMQ\Queue\QueueInterface;

/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqFactory getFactory()
 */
class EventQueue extends AbstractWithLocator implements QueueInterface
{
    /**
     * @param \Xervice\RabbitMQ\Core\QueueProviderInterface $queueProvider
     *
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
     */
    public function declareQueue(QueueProviderInterface $queueProvider)
    {
        $queueProvider->declare(
            $this->getFactory()->createEventQueue()
        );

        $queueProvider->bind(
            $this->getFactory()->createBindQueue()
        );
    }

}