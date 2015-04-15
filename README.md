# PagerDutyBundle

[![Build Status](https://travis-ci.org/lafourchette/PagerDutyBundle.svg?branch=master)](https://travis-ci.org/lafourchette/PagerDutyBundle)

Trigger PagerDuty events easily from your Symfony2 application.

## A simple example
In your config.yml file:
```yaml
la_fourchette_pager_duty:
    services:
        my_service_alias: {key: "the 32 char GUID provided by PagerDuty"}
```

Then somewhere in your code where something really bad happens:
```php
$event = $this->get('la_fourchette_pager_duty.factory.event')
    ->make("my_service_alias", "something bad happened");

// @throw PagerDuty\EventException if PagerDuty API 500s
$event->trigger();
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