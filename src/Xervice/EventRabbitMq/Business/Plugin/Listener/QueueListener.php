<?php


namespace Xervice\EventRabbitMq\Business\Plugin\Listener;


use DataProvider\RabbitMqMessageCollectionDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use Xervice\RabbitMQ\Business\Model\Worker\Listener\AbstractListener;

/**
 * @method \Xervice\EventRabbitMq\Business\EventRabbitMqBusinessFactory getFactory()
 */
class QueueListener extends AbstractListener
{
    public function handleMessage(
        RabbitMqMessageCollectionDataProvider $collectionDataProvider,
        AMQPChannel $channel
    ): void {

        foreach ($collectionDataProvider->getMessages() as $message) {
            $event = $message->getMessage();

            if ($event->hasName()) {
                $this->getFactory()->getEventFacade()->eventToListener($event);
            }

            $this->sendAck($channel, $message);
        }
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->getFactory()->createEventQueue()->getName();
    }

    /**
     * @return int
     */
    public function getChunkSize(): int
    {
        return 1000;
    }
}