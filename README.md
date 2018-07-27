EventRabbitMq
=====================

[![Build Status](https://travis-ci.org/xervice/eventrabbitmq).svg?branch=master)](https://travis-ci.org/xervice/eventrabbitmq)


Installation
-----------------
```
composer require xervice/event-rabbitmq
```

Configuration
-----------------
To use RabbitMQ as event handler, you have to overwrite the event factory.

***EventFactory***
```php
<?php

namespace App\Event;

use Xervice\Event\EventFactory as XerviceEventFactory;
use Xervice\EventRabbitMq\Business\EventProvider\RabbitMqEventProvider;
use Xervice\Event\Business\Provider\EventProviderInterface;

class EventFactory extends XerviceEventFactory
{
    /**
     * @return \Xervice\Event\Business\Provider\EventProviderInterface
     */
    public function createEventProvider(): EventProviderInterface
    {
        return new RabbitMqEventProvider();
    }
}
```

Also you have to overwrite the RabbitMQDependencyProvider to define the Queue, Exchange and Listener to RabbitMQ.

***RabbitMQDependencyProvider***
```php
<?php

namespace App\RabbitMQ;

use Xervice\RabbitMQ\RabbitMQDependencyProvider as XerviceRabbitMQDependencyProvider;
use Xervice\EventRabbitMq\Business\Listener\QueueListener;
use Xervice\EventRabbitMq\Business\Queue\EventQueue;
use Xervice\EventRabbitMq\Business\Queue\EventExchange;

class RabbitMQDependencyProvider extends XerviceRabbitMQDependencyProvider
{
    /**
     * @return array
     */
    protected function getListener()
    {
        return [
            new QueueListener()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Queue\QueueInterface[]
     */
    protected function getQueues()
    {
        return [
            new EventQueue()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Exchange\ExchangeInterface[]
     */
    protected function getExchanges()
    {
        return [
            new EventExchange()
        ];
    }
}
```


Using
-----------------
There is no special using. After the configuration, all Events should be provided to RabbitMQ.