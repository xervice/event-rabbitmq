<?php
namespace XerviceTest\EventRabbitMq;

use DataProvider\EventDataProvider;
use DataProvider\TestEventDataProvider;
use Xervice\Config\Business\XerviceConfig;
use Xervice\Core\Business\Model\Locator\Locator;
use Xervice\DataProvider\Business\DataProviderFacade;
use Xervice\DataProvider\DataProviderConfig;
use Xervice\Event\Business\EventFacade;
use Xervice\RabbitMQ\Business\RabbitMQFacade;

require_once __DIR__ . '/TestInjector/EventDependencyProvider.php';
require_once __DIR__ . '/TestInjector/EventBusinessFactory.php';
require_once __DIR__ . '/TestInjector/RabbitMQDependencyProvider.php';

class IntegrationTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        XerviceConfig::set(DataProviderConfig::FILE_PATTERN, '*.dataprovider.xml');
        $this->getDataProviderFacade()->generateDataProvider();
        XerviceConfig::set(DataProviderConfig::FILE_PATTERN, '*.testprovider.xml');
        $this->getDataProviderFacade()->generateDataProvider();
    }

    protected function _after()
    {
        $this->getDataProviderFacade()->cleanDataProvider();
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
     * @return \Xervice\DataProvider\Business\DataProviderFacade
     */
    private function getDataProviderFacade(): DataProviderFacade
    {
        return Locator::getInstance()->dataProvider()->facade();
    }

    /**
     * @return \Xervice\Event\Business\EventFacade
     */
    private function getEventFacade(): EventFacade
    {
        return Locator::getInstance()->event()->facade();
    }

    /**
     * @return \Xervice\RabbitMQ\Business\RabbitMQFacade
     */
    private function getRabbitMQFacade(): RabbitMQFacade
    {
        return Locator::getInstance()->rabbitMQ()->facade();
    }
}