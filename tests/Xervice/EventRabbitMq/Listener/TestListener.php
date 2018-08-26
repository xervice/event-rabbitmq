<?php


namespace XerviceTest\EventRabbitMq\Listener;


use DataProvider\EventDataProvider;
use Xervice\Event\Communication\Plugin\Listener\EventListenerInterface;

class TestListener implements EventListenerInterface
{
    /**
     * @param \DataProvider\EventDataProvider $dataProvider
     */
    public function handleEvent(EventDataProvider $dataProvider): void
    {
        echo $dataProvider->getName() . '==' . $dataProvider->getMessage()->getData();
    }
}