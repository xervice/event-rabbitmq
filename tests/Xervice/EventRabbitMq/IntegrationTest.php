<?php
namespace XerviceTest\EventRabbitMq;

use DataProvider\EventDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use DataProvider\TestEventDataProvider;
use Xervice\Config\XerviceConfig;
use Xervice\Core\Locator\Locator;
use Xervice\DataProvider\DataProviderConfig;
use Xervice\DataProvider\DataProviderFacade;
use Xervice\Event\EventFacade;
use Xervice\RabbitMQ\RabbitMQFacade;

require_once __DIR__ . '/TestInjector/EventDependencyProvider.php';
require_once __DIR__ . '/TestInjector/EventFactory.php';
require_once __DIR__ . '/TestInjector/RabbitMQDependencyProvider.php';

class IntegrationTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        XerviceConfig::getInstance()->getConfig()->set(DataProviderConfig::FILE_PATTERN, '*.dataprovider.xml');
        $this->getDataProviderFacade()->generateDataProvider();
        XerviceConfig::getInstance()->getConfig()->set(DataProviderConfig::FILE_PATTERN, '*.testprovider.xml');
        $this->getDataProviderFacade()->generateDataProvider();
    }

    protected function _after()
    {
//        $this->getDataProviderFacade()->cleanDataProvider();
    }

    /**
     * @group Xervice
     * @group EventRabbitMq
     * @group Integration
     */
    public function testRabbitMqEvent()
    {
        $data = new TestEventDataProvider();
        $data->setData('RMQTest');

        ob_start();
        $this->getRabbitMQFacade()->init();

        $event = new EventDataProvider();
        $event
            ->setName('myevent')
            ->setMessage($data);
        $this->getEventFacade()->fireEvent($event);

        $event = new EventDataProvider();
        $event
            ->setName('noevent')
            ->setMessage($data);
        $this->getEventFacade()->fireEvent($event);

        $this->getRabbitMQFacade()->runWorker();

        $response = ob_get_contents();
        ob_end_clean();

        $this->assertEquals(
            'myevent==RMQTest',
            $response
        );
    }

    /**
     * @return \Xervice\DataProvider\DataProviderFacade
     */
    private function getDataProviderFacade(): DataProviderFacade
    {
        return Locator::getInstance()->dataProvider()->facade();
    }

    /**
     * @return \Xervice\Event\EventFacade
     */
    private function getEventFacade(): EventFacade
    {
        return Locator::getInstance()->event()->facade();
    }

    /**
     * @return \Xervice\RabbitMQ\RabbitMQFacade
     */
    private function getRabbitMQFacade(): RabbitMQFacade
    {
        return Locator::getInstance()->rabbitMQ()->facade();
    }
}