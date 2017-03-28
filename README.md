API Wrapper
======

- Catalog API
  ```
  OystApiClientFactory::createCatalogApiClient($apiKey, $userAgent);
  ```

- Order API
  ```
  OystApiClientFactory::createOrderApiClient($apiKey, $userAgent);
  ```

- Payment API
  ```
  OystApiClientFactory::createPaymentApiClient($apiKey, $userAgent);
  ```

- OneClick
  ```
  OystApiClientFactory::createOneClickApiClient($apiKey, $userAgent);
  ```

**NB:** The API key is the key that was given to you by Oyst (if you don't have one you can go to the [FreePay BackOffice](https://admin.free-pay.com/signup) and create an account).