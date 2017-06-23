Oyst PHP API Wrapper
====================

Build Status
------------
Latest Release [![Master Branch](https://travis-ci.org/oystparis/oyst-php.svg?branch=master)](https://travis-ci.org/oystparis/oyst-php)

User Guide
----------
The class `OystApiClientFactory` is used to get the right client to communicate with the API.

**Note:** It would be interesting to process it the right way with an abstract method called by the parent like process()
which is called by a public method access such as exec() or start() for example.

```php
/** @var AbstractOystApiClient $apiWrapper */
$apiWrapper = OystApiClientFactory::getClient($entityName, $apiKey, $userAgent, $environment, $url);
```

This method take several parameters as:

* **entityName** (constants available in `OystApiClientFactory`), could be:
    * catalog
    * order
    * payment
    * oneclick

* **apiKey**
    * The API key is the key that was given to you by Oyst (if you don't have one you can go to the [FreePay BackOffice](https://admin.free-pay.com/signup) and create an account).

* **userAgent**
    * To know the origin of the request (PrestaShop vX.X.X / Magento vX.X.X / Elsewhere)

* **environment** (constants available in `OystApiClientFactory`), takes two values:
    * prod
    * preprod

* **url**
    * The custom URL with which the APIs are to be called (if you don't want to use the default one set for the environment)

Tests
-----
To run unit tests:
```php
vendor/bin/phpunit -c phpunit.xml.dist --testsuite unitary
vendor/bin/phpunit -c phpunit.xml.dist --testsuite functional
```

Documentation
-------------
See the content of the [description_[entityName].json](src/config) files to know in details the payload for each API.
