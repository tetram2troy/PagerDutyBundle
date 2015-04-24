<?php

namespace LaFourchette\PagerDutyBundle\Tests\Factory;

use LaFourchette\PagerDutyBundle\Factory\EventFactory;

class EventFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMakeUnknownService()
    {
        $dut = new EventFactory();

        $this->setExpectedException('LaFourchette\PagerDutyBundle\PagerDutyBundleException');
        $dut->make('foo', 'bar');
    }

    public function testMake()
    {
        $serviceKey = '3858f62230ac3c915f300c664312c63f';
        $dut = new EventFactory();
        $dut->setServiceDefinitions(array(
            'foo' => array('key' => $serviceKey),
        ));

        $event = $dut->make('foo', 'bar');

        $this->assertInstanceOf('PagerDuty\Event', $event);
        $this->assertSame($serviceKey, $event->getServiceKey());
        $this->assertSame('bar', $event->getDescription());
    }
}
