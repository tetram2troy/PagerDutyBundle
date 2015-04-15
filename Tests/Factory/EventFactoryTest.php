<?php

namespace LaFourchette\PagerDutyBundle\Tests\Factory;

use LaFourchette\PagerDutyBundle\Factory\EventFactory;
use LaFourchette\PagerDutyBundle\Tests\ProphecyTestCase;

class EventFactoryTest extends ProphecyTestCase
{
    public function testMakeUnknownService()
    {
        $dut = new EventFactory();

        $this->setExpectedException('LaFourchette\PagerDutyBundle\PagerDutyBundleException');
        $dut->make('foo', 'bar');
    }

    public function testMake()
    {
        $serviceKey = array_shift(str_split(md5('foobar'), 32));
        $dut = new EventFactory();
        $dut->setServiceDefinitions(array(
            'foo' => array('key' => $serviceKey)
        ));

        $event = $dut->make('foo', 'bar');

        $this->assertInstanceOf('PagerDuty\Event', $event);
        $this->assertSame($serviceKey, $event->getServiceKey());
        $this->assertSame('bar', $event->getDescription());
    }
} 