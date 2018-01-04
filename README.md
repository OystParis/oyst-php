# Oyst PHP API Wrapper

[![Build Status](https://travis-ci.org/oystparis/oyst-php.svg?branch=master)](https://travis-ci.org/oystparis/oyst-php)
[![Latest Stable Version](https://img.shields.io/badge/latest-2.0.1-green.svg)](https://github.com/oystparis/oyst-php/releases)
[![PHP >= 5.3](https://img.shields.io/badge/php-%3E=5.3-green.svg)](#)

You can sign up for an Oyst account at https://admin.free-pay.com.

## Installation

### Install using Composer

Add the repository
```
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/oystparis/oyst-php"
    }
  ]
```
Then run the composer installer: `composer require oyst/oyst-php`

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):
```php
require_once('vendor/autoload.php');
```

### Manual installation

You can download the [latest release](https://github.com/oystparis/oyst-php/releases). Then, run the composer install: `composer install --no-dev` to install dependencies.

Then, to use the bindings, include the `autoload.php` file.
```php
require_once('vendor/autoload.php');
```
## Quick start

Simple usage looks like:
```php
$userAgent = new \Oyst\Classes\OystUserAgent('MY_WEBSITE_NAME', 'MY_PACKAGE_VERSION', 'MY_PLATFORM_VERSION', 'PHP', phpversion());
$oystClient = new \Oyst\Api\OystApiClientFactory::getClient('oneclick', 'eFcaDouev63YVsJ3wM2ovY7ewCwrQMLHaw4tWHxXQT7cmErWKkZU4pTRt6npwb8p', $userAgent);
$oystClient->setNotifyUrl('https://1click-demo.sandbox.oyst.eu/notification.php');

// 1-click order
$product = '{
  "products":[{
      "amount_including_taxes":{
        "value":100,
        "currency":"EUR"
      },
      "images":[
        "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Rubik%27s_cube.svg/langfr-480px-Rubik%27s_cube.svg.png"
      ],
      "reference":"rubikscube",
      "title":"Rubiks Cube 3x3"
    }]
}';

$oystClient->authorizeOrder('rubikscube', 1, null, null, 1, $product);
```

## User guide

The class `OystApiClientFactory` is used to get the right client to communicate with the API.

**Note:** It would be interesting to process it the right way with an abstract method called by the parent like process()
which is called by a public method access such as exec() or start() for example.

```php
/** @var AbstractOystApiClient $apiWrapper */
$apiWrapper = OystApiClientFactory::getClient($entityName, $apiKey, OystUserAgent $userAgent, $environment, $url);
```

This method take several parameters as:

* **entityName** (constants available in `Oyst\Api\OystApiClientFactory`), could be:
    * catalog
    * order
    * payment
    * oneclick

* **apiKey**
    * The API key is the key that was given to you by Oyst (if you don't have one you can go to the https://admin.free-pay.com and create an account).

* **userAgent**
    * To know the origin of the request (PrestaShop / Magento / WooComerce / Elsewhere...).
    You have have to instantiate a new `Oyst\Classes\OystUserAgent`, the constructor will show you needed info, and pass it to `getClient`.

* **environment** (Optional, by default prod ; constants available in `Oyst\Api\OystApiClientFactory`), takes two values:
    * prod
    * preprod

* **url** (Optional)
    * The custom URL with which the APIs are to be called (if you don't want to use the default one set for the environment)



## Documentation

Please see https://one-click-api.readme.io for up-to-date documentation.

Moreover you can see the content of DSL files [description_[entityName].json](src/config) to know in details the payload for each API.
Theses files use [Guzzle Service Description](https://guzzle3.readthedocs.io/webservice-client/guzzle-service-descriptions.html).

## Development

Install dependencies: `composer install`

## Tests

Install dependencies as mentioned above (which will resolve PHPUnit), then you can run the test suite:

To run unit tests:
```bash
./vendor/bin/phpunit -c phpunit.xml.dist --testsuite unitary
./vendor/bin/phpunit -c phpunit.xml.dist --testsuite functional
```
