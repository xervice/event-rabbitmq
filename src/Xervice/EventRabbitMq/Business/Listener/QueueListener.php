<?php


namespace Xervice\EventRabbitMq\Business\Listener;


use DataProvider\EventDataProvider;
use DataProvider\RabbitMqMessageCollectionDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use Xervice\RabbitMQ\Worker\Listener\AbstractListener;

/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqFactory getFactory()
 */
class QueueListener extends AbstractListener
{
    public function handleMessage(
        RabbitMqMessageCollectionDataProvider $collectionDataProvider,
        AMQPChannel $channel
    ): void {

        foreach ($collectionDataProvider->getMessages() as $message) {
            $event = new EventDataProvider();
            $event->fromArray(
                json_decode(
                    $message->getMessage(),
                    true
                )
            );

            if ($event->hasName()) {
                $this->getFactory()->getEventFacade()->eventToListener($event);
            }

            $this->sendAck($channel, $message);
        }
    }

    /**
     * @return string
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
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