<?php


namespace Xervice\EventRabbitMq;


use DataProvider\RabbitMqExchangeDataProvider;
use DataProvider\RabbitMqQueueBindDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use Xervice\Core\Factory\AbstractFactory;
use Xervice\Event\EventFacade;
use Xervice\RabbitMQ\RabbitMQClient;

/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqConfig getConfig()
 */
class EventRabbitMqFactory extends AbstractFactory
{

    /**
     * @return \DataProvider\RabbitMqQueueBindDataProvider
     */
    public function createBindQueue(): RabbitMqQueueBindDataProvider
    {
        return (new RabbitMqQueueBindDataProvider())
            ->setQueue(
                $this->createEventQueue()
            )
            ->setExchange(
                $this->createEventExchange()
            );
    }

    public function createEventExchange(): RabbitMqExchangeDataProvider
    {
        return (new RabbitMqExchangeDataProvider())
            ->setName(
                $this->getConfig()->getExchangeName()
            )
            ->setAutoDelete(false)
            ->setType('fanout');
    }

    /**
     * @return \DataProvider\RabbitMqQueueDataProvider
     */
    public function createEventQueue(): RabbitMqQueueDataProvider
    {
        return (new RabbitMqQueueDataProvider())
            ->setName($this->getConfig()->getQueueName())
            ->setAutoDelete(false);
    }

    /**
     * @return \Xervice\RabbitMQ\RabbitMQClient
     */
    public function getRabbitMqClient(): RabbitMQClient
    {
        return $this->getDependency(EventRabbitMqDependencyProvider::RABBITMQ_CLIENT);
    }

    /**
     * @return \Xervice\Event\EventFacade
     */
    public function getEventFacade(): EventFacade
    {
        return $this->getDependency(EventRabbitMqDependencyProvider::EVENT_FACADE);
    }
}