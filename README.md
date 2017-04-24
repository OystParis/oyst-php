API Wrapper
===========

Build Status
------------
* Latest Release: [![Master Branch](https://travis-ci.org/OystParis/oyst-php.svg?branch=master)](https://travis-ci.org/OystParis/oyst-php)

The class `OystApiClientFactory` is used to get the right client to communicate with the api.
As we build one class => several methods request call, for now the abstract method is not used to process automatically.

**Note:** Should be interesting to process it the right way with an abstract method called by the parent like process()
which is called by a public method access like exec(), start() for example.. )
  
```php
OystApiClientFactory::getClient($entityName, $apiKey, $userAgent, env = 'prod');
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
  
* **env** (constants available in `OystApiClientFactory`), takes 3 values as:
    * prod
    * preprod
    * integration, (will never be available for merchant)
