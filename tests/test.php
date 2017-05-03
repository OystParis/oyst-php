<?php

namespace Oyst\Test;

use Oyst\Api\AbstractOystApiClient;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystCatalogApi;
use Oyst\Api\OystOneClickApi;
use Oyst\Api\OystOrderApi;
use Oyst\Api\OystPaymentApi;
use Oyst\Classes\OystCategory;
use Oyst\Classes\OystPrice;
use Oyst\Classes\OystProduct;
use Oyst\Classes\OystSize;

function executeTest()
{
    if (!$loader = @include __DIR__ . '/../vendor/autoload.php') {
        die('Project dependencies missing');
    }

    $userAgent = 'Oyst PHP';
    $apiKey = 'api_key_preprod';
    $env = OystApiClientFactory::ENV_PREPROD;
    testAuthorizeOrder($apiKey, $userAgent, $env);
    testPayment($apiKey, $userAgent, $env);
    testPostProducts($apiKey, $userAgent, $env);
    testPutProduct($apiKey, $userAgent, $env);
    testDeleteProduct($apiKey, $userAgent, $env);
    // does not work two times in a row for now
    testNotifyImport($apiKey, $userAgent, $env);
    testGetOrders($apiKey, $userAgent, $env);
}

/**
 * @param string $apiKey
 * @param string $userAgent
 * @param string $env
 */
function testAuthorizeOrder($apiKey, $userAgent, $env)
{
    /** @var OystOneClickApi $oneClickApi */
    $oneClickApi = OystApiClientFactory::getClient(OystApiClientFactory::ENTITY_ONECLICK, $apiKey, $userAgent, $env);
    $result = $oneClickApi->authorizeOrder('test', 666, 'test');

    printTestResult($oneClickApi, $result);
}

/**
 * @param string $apiKey
 * @param string $userAgent
 * @param string $env
 */
function testPayment($apiKey, $userAgent, $env)
{
    /** @var OystPaymentApi $paymentApi */
    $paymentApi = OystApiClientFactory::getClient(OystApiClientFactory::ENTITY_PAYMENT, $apiKey, $userAgent, $env);
    $result = $paymentApi->payment(123, 'EUR', 3, array(
        'notification' => 'http://localhost.test',
        'cancel' => 'http://localhost.test',
        'error' => 'http://localhost.test',
        'return' => 'http://localhost.test',
    ), true, array(
        'addresses' => array(),
        'billing_addresses' => array(),
        'email' => 'test@oyst.com',
        'first_name' => 'Test',
        'language' => 'fr',
        'last_name' => 'Test',
        'phone' => '0100000000',
    ));

    printTestResult($paymentApi, $result);
}

/**
 * @param string $apiKey
 * @param string $userAgent
 * @param string $env
 */
function testPostProducts($apiKey, $userAgent, $env)
{
    /** @var OystCatalogApi $catalogApi */
    $catalogApi = OystApiClientFactory::getClient(OystApiClientFactory::ENTITY_CATALOG, $apiKey, $userAgent, $env);
    $products = array();
    $product = new OystProduct();
    $product->setRef('sku1');
    $product->setTitle('my title1');
    $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
    $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
    $product->setImages(array('http://localhost'));

    $info = array(
        'meta' => 'info misc.',
        'subtitle' => 'test',
    );
    $product->setAvailableQuantity(5);
    $product->setDescription('qdgsdfg');
    $product->setEan('my_ean');
    $product->setIsbn('my_isbn');
    $product->setActive(true);
    $product->setMaterialized(true);
    $product->setInformation($info);
    $product->setManufacturer('my manufacturer');
    $product->addRelatedProduct('ref_related');
    $product->setShortDescription('short description');
    $product->setSize(new OystSize(42, 42, 42));
    $product->addTag('test');
    $product->setUpc('my_upc');
    $product->setUrl('http://localhost');
    $products[] = $product;

    $product = new OystProduct();
    $product->setRef('sku2');
    $product->setTitle('my title2');
    $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
    $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
    $product->setImages(array('http://localhost'));

    $products[] = $product;

    $result = $catalogApi->postProducts($products);

    printTestResult($catalogApi, $result);
}

/**
 * @param string $apiKey
 * @param string $userAgent
 * @param string $env
 */
function testPutProduct($apiKey, $userAgent, $env)
{
    /** @var OystCatalogApi $catalogApi */
    $catalogApi = OystApiClientFactory::getClient(OystApiClientFactory::ENTITY_CATALOG, $apiKey, $userAgent, $env);
    $product = new OystProduct();
    $product->setRef('sku1');
    $product->setTitle('my title1');
    $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
    $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
    $product->setImages(array('http://localhost'));

    $info = array(
        'meta' => 'info misc.',
        'subtitle' => 'test',
    );
    $product->setAvailableQuantity(5);
    $product->setDescription('qdgsdfg');
    $product->setEan('my_ean');
    $product->setIsbn('my_isbn');
    $product->setActive(true);
    $product->setMaterialized(true);
    $product->setInformation($info);
    $product->setManufacturer('my manufacturer');
    $product->addRelatedProduct('ref_related');
    $product->setShortDescription('short description');
    $product->setSize(new OystSize(42, 42, 42));
    $product->addTag('test');
    $product->setUpc('my_upc');
    $product->setUrl('http://localhost');

    $result = $catalogApi->putProduct($product);

    printTestResult($catalogApi, $result);
}

/**
 * @param string $apiKey
 * @param string $userAgent
 * @param string $env
 */
function testDeleteProduct($apiKey, $userAgent, $env)
{
    /** @var OystCatalogApi $catalogApi */
    $catalogApi = OystApiClientFactory::getClient(OystApiClientFactory::ENTITY_CATALOG, $apiKey, $userAgent, $env);
    $result = $catalogApi->deleteProduct('sku1');

    printTestResult($catalogApi, $result);
}

/**
 * @param string $apiKey
 * @param string $userAgent
 * @param string $env
 */
function testNotifyImport($apiKey, $userAgent, $env)
{
    /** @var OystCatalogApi $catalogApi */
    $catalogApi = OystApiClientFactory::getClient(OystApiClientFactory::ENTITY_CATALOG, $apiKey, $userAgent, $env);
    $result = $catalogApi->notifyImport();

    printTestResult($catalogApi, $result);
}

/**
 * @param string $apiKey
 * @param string $userAgent
 * @param string $env
 */
function testGetOrders($apiKey, $userAgent, $env)
{
    /** @var OystOrderApi $orderApi */
    $orderApi = OystApiClientFactory::getClient(OystApiClientFactory::ENTITY_ORDER, $apiKey, $userAgent, $env);
    $result = $orderApi->getOrders();

    printTestResult($orderApi, $result);
}

/**
 * @param AbstractOystApiClient $clientApi
 * @param mixed                 $result
 */
function printTestResult($clientApi, $result)
{
    $debug = debug_backtrace();

    echo "=================" . PHP_EOL;
    echo ($debug[1]['function'] ?: "Test") . PHP_EOL;
    echo "=================" . PHP_EOL;
    var_dump($clientApi->getLastHttpCode(), $clientApi->getLastError(), $result);
}

executeTest();
