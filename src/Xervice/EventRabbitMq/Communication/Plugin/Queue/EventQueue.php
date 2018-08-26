<?php


namespace Xervice\EventRabbitMq\Communication\Plugin\Queue;


use Xervice\Core\Plugin\AbstractCommunicationPlugin;
use Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface;
use Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface;

/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqFactory getFactory()
 */
class EventQueue extends AbstractCommunicationPlugin implements QueueInterface
{
    /**
     * @param \Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface $queueProvider
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