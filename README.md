# PagerDutyBundle

[![Build Status](https://travis-ci.org/lafourchette/PagerDutyBundle.svg?branch=master)](https://travis-ci.org/lafourchette/PagerDutyBundle)
[![Code Coverage](https://scrutinizer-ci.com/g/lafourchette/PagerDutyBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/lafourchette/PagerDutyBundle/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lafourchette/PagerDutyBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lafourchette/PagerDutyBundle/?branch=master)

Trigger PagerDuty events easily from your Symfony2 application.

## A simple example
In your config.yml file:
```yaml
la_fourchette_pager_duty:
    services:
        my_service_alias: {key: "the 32 char GUID provided by PagerDuty"}
```

You'll find the service GUID at ```https://<your subdomain>.pagerduty.com/services```

Then somewhere in your code where something really bad happens:
```php
$event = $this->get('la_fourchette_pager_duty.factory.event')
    ->make("my_service_alias", "something bad happened");

// @throw PagerDuty\EventException if PagerDuty API 500s
$event->trigger();
```

## LiipMonitor compatibility
If you're using liip/monitor-bundle, you're provided a "pagerduty" reporter which triggers PagerDuty on failures.
You're just required to implement the ```Check/PagerDutyCheckInterface```.
```bash
# Trigger pager duty on failed checks
app/console monitor:health --reporter=pagerduty
```

## Installation
First, add PagerDutyBundle to the list of dependencies inside your `composer.json`:
```json
{
    "require-dev": {
        "lafourchette/pager-duty-bundle": "~0.1"
    }
}
```
Then update your AppKernel.php:
```php
    public function registerBundles()
    {
        $bundles = array(
            ...
            new LaFourchette\PagerDutyBundle\LaFourchettePagerDutyBundle()
            ...
        );

        return $bundles;
    }
```
