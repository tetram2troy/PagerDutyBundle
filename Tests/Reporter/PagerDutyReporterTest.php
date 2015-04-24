<?php

namespace LaFourchette\PagerDutyBundle\Tests\Reporter;

use LaFourchette\PagerDutyBundle\Reporter\PagerDutyReporter;
use Prophecy\Argument;
use ZendDiagnostics\Result\Success;

class PagerDutyReporterTest extends \PHPUnit_Framework_TestCase
{
    private $dut;

    private $mockFactory, $mockLogger, $mockCheck;

    public function setUp()
    {
        parent::setUp();

        if (! class_exists('ZendDiagnostics\Check\CheckInterface')) {
            $this->markTestSkipped('Install liip/monitor-bundle to test this.');
        }

        $this->mockFactory = $this->prophesize('LaFourchette\PagerDutyBundle\Factory\EventFactory');
        $this->mockLogger  = $this->prophesize('Symfony\Component\HttpKernel\Log\LoggerInterface');
        $this->mockCheck = $this->prophesize('ZendDiagnostics\Check\CheckInterface');

        $this->dut = new PagerDutyReporter($this->mockFactory->reveal(), $this->mockLogger->reveal());
    }

    public function testOnAfterRunAllGood()
    {
        $this->mockFactory->make(Argument::cetera())->shouldNotBeCalled();

        // Run test
        $this->dut->onAfterRun(
            $this->mockCheck->reveal(),
            new Success()
        );
    }
} 