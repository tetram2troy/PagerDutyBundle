<?php

namespace LaFourchette\PagerDutyBundle\Factory;

use LaFourchette\PagerDutyBundle\PagerDutyBundleException;
use PagerDuty\Event;

/**
 * Makes PagerDuty events.
 */
class EventFactory
{
    /**
     * @var array Array of service definitions.
     *
     * Shall contains:
     * [
     *    'serviceAlias': {key: 'serviceKey'}
     * ]
     */
    protected $serviceDefinitions;

    /**
     * @param array $serviceDefinitions
     */
    public function setServiceDefinitions(array $serviceDefinitions)
    {
        $this->serviceDefinitions = $serviceDefinitions;
    }

    /**
     * Factory method for PagerDuty\Event.
     *
     * @param string $serviceAlias ServiceAlias as defined in this bundle configuration.
     * @param string $description  Message to send to PagerDuty to explain the Event.
     *
     * @return Event
     */
    public function make($serviceAlias, $description)
    {
        $serviceKey = $this->retrieveKeyFromAlias($serviceAlias);
        $event = new Event();
        $event->setServiceKey($serviceKey)->setDescription($description);

        return $event;
    }

    /**
     * @param string $serviceAlias ServiceAlias as defined in this bundle configuration.
     *
     * @return string Service GUID key.
     *
     * @throws PagerDutyBundleException
     */
    private function retrieveKeyFromAlias($serviceAlias)
    {
        if (! isset($this->serviceDefinitions[$serviceAlias])) {
            throw new PagerDutyBundleException("Unknown service definition for \"$serviceAlias\", please check your configuration.");
        }

        return $this->serviceDefinitions[$serviceAlias]['key'];
    }
}
