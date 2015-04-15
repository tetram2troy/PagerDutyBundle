<?php

namespace LaFourchette\PagerDutyBundle\Factory;

use LaFourchette\PagerDutyBundle\PagerDutyBundleException;
use PagerDuty\Event;

class EventFactory
{
    protected $serviceDefinitions;

    public function setServiceDefinitions(array $serviceDefinitions)
    {
        $this->serviceDefinitions = $serviceDefinitions;
    }

    public function make($serviceAlias, $description)
    {
        $serviceKey = $this->retrieveKeyFromAlias($serviceAlias);
        $event = new Event();
        $event->setServiceKey($serviceKey)->setDescription($description);

        return $event;
    }

    // service key found at https://<your subdomain>.pagerduty.com/services
    private function retrieveKeyFromAlias($serviceAlias)
    {
        if(! isset($this->serviceDefinitions[$serviceAlias])){
            throw new PagerDutyBundleException("Unknown service definition for \"$serviceAlias\", please check your configuration.");
        }
        return $this->serviceDefinitions[$serviceAlias]['key'];
    }
} 