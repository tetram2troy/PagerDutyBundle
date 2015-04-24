<?php

namespace LaFourchette\PagerDutyBundle\Tests\Reporter;

use LaFourchette\PagerDutyBundle\Check\PagerDutyCheckInterface;
use LaFourchette\PagerDutyBundle\Reporter\PagerDutyReporter;
use Prophecy\Argument;
use ZendDiagnostics\Check\CheckInterface;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;

class MockCheck implements CheckInterface, PagerDutyCheckInterface
{
    public function check()
    {
    }
    public function getLabel()
    {
    }
    public function getPagerDutyAlias()
    {
    }
}

class PagerDutyReporterTest extends \PHPUnit_Framework_TestCase
{
    private $dut;

    private $mockFactory, $mockLogger, $mockCheck;

    public function setUp()
    {
        if (! interface_exists('\ZendDiagnostics\Check\CheckInterface')) {
            $this->markTestSkipped('Install liip/monitor-bundle to test this.');
        }

        $this->mockFactory = $this->prophesize('LaFourchette\PagerDutyBundle\Factory\EventFactory');
        $this->mockLogger  = $this->prophesize('Symfony\Component\HttpKernel\Log\LoggerInterface');
        $this->mockCheck = $this->prophesize('ZendDiagnostics\Check\CheckInterface');

        $this->dut = new PagerDutyReporter($this->mockFactory->reveal(), $this->mockLogger->reveal());
    }

    public function testOnAfterRunWithoutPagerDutyInterface()
    {
        $this->mockFactory->make(Argument::cetera())->shouldNotBeCalled();

        // Run test
        $this->dut->onAfterRun(
            $this->mockCheck->reveal(),
            new Success()
        );
    }

    public function testOnAfterRunWithPagerDutyInterface()
    {
        $mockEvent = $this->prophesize('PagerDuty\Event');
        $this->mockFactory->make(Argument::cetera())->shouldBeCalled()
            ->willReturn($mockEvent->reveal());
        $mockCheck = $this->prophesize('LaFourchette\PagerDutyBundle\Tests\Reporter\MockCheck');

        // Run test
        $this->dut->onAfterRun(
            $mockCheck->reveal(),
            new Failure()
        );
    }
}
