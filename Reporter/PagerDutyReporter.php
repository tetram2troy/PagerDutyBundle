<?php

namespace LaFourchette\PagerDutyBundle\Reporter;

use LaFourchette\PagerDutyBundle\Factory\EventFactory;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Runner\Reporter\ReporterInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use ZendDiagnostics\Check\CheckInterface;
use ZendDiagnostics\Result\ResultInterface;
use ZendDiagnostics\Result\Collection as ResultsCollection;

class PagerDutyReporter implements ReporterInterface
{
    private $pagerDuty;

    private $logger;

    public function __construct(EventFactory $pagerDuty, LoggerInterface $logger)
    {
        $this->pagerDuty = $pagerDuty;
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function onAfterRun(CheckInterface $check, ResultInterface $result, $checkAlias = null)
    {
        if ($result instanceof Failure) {
            try{
                $event = $this->pagerDuty->make($checkAlias, $result->getMessage());
                $event->trigger();
            } catch(\Exception $e) {
                $this->logger->alert($e);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function onStart(\ArrayObject $checks, $runnerConfig)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function onBeforeRun(CheckInterface $check, $checkAlias = null)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function onStop(ResultsCollection $results)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function onFinish(ResultsCollection $results)
    {
        return;
    }
} 