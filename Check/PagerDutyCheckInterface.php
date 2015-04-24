<?php

namespace LaFourchette\PagerDutyBundle\Check;

/**
 * Interface for PagerDuty compatible LiipMonitor checks.
 *
 * Please install liip/monitor-bundle to take advantage of this feature.
 */
interface PagerDutyCheckInterface
{
    /**
     * @return string Alias of the PagerDuty service to be triggered in case of failure.
     */
    public function getPagerDutyAlias();
}
