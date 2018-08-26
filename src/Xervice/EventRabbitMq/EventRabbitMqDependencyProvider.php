<?php


namespace Xervice\EventRabbitMq;


use Xervice\Core\Business\Model\Dependency\DependencyContainerInterface;
use Xervice\Core\Business\Model\Dependency\Provider\AbstractDependencyProvider;

class EventRabbitMqDependencyProvider extends AbstractDependencyProvider
{
    public const RABBITMQ_FACADE = 'rabbitmq.facade';

    public const EVENT_FACADE = 'event.facade';

    public function handleDependencies(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[self::RABBITMQ_CLIENT] = function (DependencyContainerInterface $container) {
            return $container->getLocator()->rabbitMQ()->facade();
        };

        $container[self::EVENT_FACADE] = function (DependencyContainerInterface $container) {
            return $container->getLocator()->event()->facade();
        };

        return $container;
    }
}