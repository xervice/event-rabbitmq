<?php


namespace Xervice\EventRabbitMq\Business;


use DataProvider\RabbitMqExchangeDataProvider;
use DataProvider\RabbitMqQueueBindDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;
use Xervice\Event\Business\EventFacade;
use Xervice\EventRabbitMq\EventRabbitMqDependencyProvider;
use Xervice\RabbitMQ\Business\RabbitMQFacade;

/**
 * @method \Xervice\EventRabbitMq\EventRabbitMqConfig getConfig()
 */
class EventRabbitMqBusinessFactory extends AbstractBusinessFactory
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
     * @return \Xervice\RabbitMQ\Business\RabbitMQFacade
     */
    public function getRabbitMqFacade(): RabbitMQFacade
    {
        return $this->getDependency(EventRabbitMqDependencyProvider::RABBITMQ_FACADE);
    }

    /**
     * @return \Xervice\Event\Business\EventFacade
     */
    public function getEventFacade(): EventFacade
    {
        return $this->getDependency(EventRabbitMqDependencyProvider::EVENT_FACADE);
    }
}