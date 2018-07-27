<?php


namespace Xervice\EventRabbitMq;


use DataProvider\RabbitMqExchangeDataProvider;
use DataProvider\RabbitMqQueueBindDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use Xervice\Core\Factory\AbstractFactory;
use Xervice\Event\EventFacade;
use Xervice\RabbitMQ\RabbitMQFacade;

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
     * @return \Xervice\RabbitMQ\RabbitMQFacade
     */
    public function getRabbitMqFacade(): RabbitMQFacade
    {
        return $this->getDependency(EventRabbitMqDependencyProvider::RABBITMQ_FACADE);
    }

    /**
     * @return \Xervice\Event\EventFacade
     */
    public function getEventFacade(): EventFacade
    {
        return $this->getDependency(EventRabbitMqDependencyProvider::EVENT_FACADE);
    }
}