<?php


namespace Xervice\EventRabbitMq\Business\Plugin\Queue;


use Xervice\Core\Plugin\AbstractBusinessPlugin;
use Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface;
use Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface;

/**
 * @method \Xervice\EventRabbitMq\Business\EventRabbitMqBusinessFactory getFactory()
 */
class EventQueue extends AbstractBusinessPlugin implements QueueInterface
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