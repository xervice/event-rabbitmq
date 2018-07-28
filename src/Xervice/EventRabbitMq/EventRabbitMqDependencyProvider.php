<?php


namespace Xervice\EventRabbitMq;


use Xervice\Core\Dependency\DependencyProviderInterface;
use Xervice\Core\Dependency\Provider\AbstractProvider;

/**
 * @method \Xervice\Core\Locator\Locator getLocator()
 */
class EventRabbitMqDependencyProvider extends AbstractProvider
{
    public const RABBITMQ_CLIENT = 'rabbitmq.client';

    public const EVENT_FACADE = 'event.facade';

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $dependencyProvider
     */
    public function handleDependencies(DependencyProviderInterface $dependencyProvider): void
    {
        $dependencyProvider[self::RABBITMQ_CLIENT] = function (DependencyProviderInterface $dependencyProvider) {
            return $dependencyProvider->getLocator()->rabbitMQ()->client();
        };

        $dependencyProvider[self::EVENT_FACADE] = function (DependencyProviderInterface $dependencyProvider) {
            return $dependencyProvider->getLocator()->event()->facade();
        };
    }
}