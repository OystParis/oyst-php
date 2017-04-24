<?php

namespace Oyst\Test;

use Guzzle;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystApiConfiguration;
use Oyst\Api\OystCatalogApi;
use Oyst\Api\OystOneClickApi;
use Oyst\Api\OystOrderApi;
use Oyst\Api\OystPaymentApi;
use Oyst\Classes\OystCategory;
use Oyst\Classes\OystPrice;
use Oyst\Classes\OystProduct;
use Oyst\Classes\OystSize;
use ReflectionMethod;

class ApiWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * DataProvider
     *
     * @return array
     */
    public function clientDataOk()
    {
        return array(
            array('Oyst\Api\OystCatalogApi', 'catalog', 'api_key', 'user_agent', 'preprod'),
            array('Oyst\Api\OystPaymentApi', 'payment', 'api_key', 'user_agent', 'preprod'),
            array('Oyst\Api\OystOrderApi', 'order', 'api_key', 'user_agent', 'preprod'),
            array('Oyst\Api\OystOneClickApi', 'oneclick', 'api_key', 'user_agent', 'preprod'),
            array('Oyst\Api\OystCatalogApi', 'catalog', 'api_key', 'user_agent', 'unknow_env'),
            array('Oyst\Api\OystPaymentApi', 'payment', 'api_key', 'user_agent', 'unknow_env'),
            array('Oyst\Api\OystOrderApi', 'order', 'api_key', 'user_agent', 'unknow_env'),
            array('Oyst\Api\OystOneClickApi', 'oneclick', 'api_key', 'user_agent', 'unknow_env')
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function clientDataException()
    {
        return array(
            array('unknown_entity', 'api_key', 'user_agent', 'preprod')
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function configurationData()
    {
        return array(
            array(OystApiClientFactory::ENTITY_CATALOG, OystApiClientFactory::ENV_TEST, 'catalog', 'test', 'https://localhost/catalog'),
            array(OystApiClientFactory::ENTITY_ORDER, OystApiClientFactory::ENV_TEST, 'order', 'test', 'https://localhost/order'),
            array(OystApiClientFactory::ENTITY_PAYMENT, OystApiClientFactory::ENV_TEST, 'payment', 'test', 'https://localhost/payment'),
            array(OystApiClientFactory::ENTITY_ONECLICK, OystApiClientFactory::ENV_TEST, 'oneclick', 'test', 'https://localhost/oneclick'),
            array('unknown_entity', OystApiClientFactory::ENV_TEST, null, 'test', null),
            array(OystApiClientFactory::ENTITY_CATALOG, 'unknown_env', 'catalog', 'prod', 'https://api.oyst.com/catalog'),
            array('unknown_entity', 'unknown_env', null, 'prod', null),
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function descriptionData()
    {
        return array(
            array('catalog'),
            array('order'),
            array('payment'),
            array('oneclick')
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function descriptionDataException()
    {
        return array(
            array('unknown_entity')
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function fakeData()
    {
        return array(
            array('api_key', 'user_agent')
        );
    }

    /**
     * @dataProvider clientDataOk
     */
    public function testOkGetClient($expectedClassName, $entityName, $apiKey, $userAgent, $env)
    {
        $clientApi = OystApiClientFactory::getClient($entityName, $apiKey, $userAgent, $env);

        $this->assertInstanceOf($expectedClassName, $clientApi);
    }

    /**
     * @dataProvider clientDataException
     * @expectedException Exception
     */
    public function testExceptionGetClient($entityName, $apiKey, $userAgent, $env)
    {
        OystApiClientFactory::getClient($entityName, $apiKey, $userAgent, $env);
    }

    /**
     * @dataProvider configurationData
     */
    public function testApiConfiguration($entityName, $env, $expectedEntity, $expectedEnv, $expectedApiUrl)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiConfiguration');
        $reflectionMethod->setAccessible(true);
        /** @var OystApiConfiguration $configuration */
        $configuration = $reflectionMethod->invoke(null, $entityName, $env);

        $this->assertEquals($configuration->getEntity(), $expectedEntity);
        $this->assertEquals($configuration->getEnvironment(), $expectedEnv);
        $this->assertEquals($configuration->getApiUrl(), $expectedApiUrl);
    }

    /**
     * @dataProvider descriptionData
     */
    public function testApiDescription($entityName)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiDescription');
        $reflectionMethod->setAccessible(true);
        $description = $reflectionMethod->invoke(null, $entityName);

        $this->assertInstanceOf('Guzzle\Service\Description\ServiceDescription', $description);
    }

    /**
     * @dataProvider descriptionDataException
     * @expectedException Exception
     */
    public function testExceptionApiDescription($entityName)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiDescription');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke(null, $entityName);
    }

    /**
     * @group ignore
     */
    static public function initClientTest($entityName, $fakeResponse)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiConfiguration');
        $reflectionMethod->setAccessible(true);
        $configuration = $reflectionMethod->invoke(null, $entityName, OystApiClientFactory::ENV_TEST);

        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiDescription');
        $reflectionMethod->setAccessible(true);
        $description = $reflectionMethod->invoke(null, $entityName);

        $baseUrl = $configuration->getApiUrl();
        $client  = new \Guzzle\Service\Client($baseUrl);
        $client->setDescription($description);

        $plugin = new Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($fakeResponse);
        $client->addSubscriber($plugin);

        return $client;
    }

    /**
     * @dataProvider fakeData
     */
    public function testAuthorizeOrder($apiKey, $userAgent)
    {
        $fakeResponse = new Guzzle\Http\Message\Response(200, array('Content-Type' => 'application/json'), '{"url": "http://localhost/success"}');
        $client = static::initClientTest(OystApiClientFactory::ENTITY_ONECLICK, $fakeResponse);

        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = new OystOneClickApi($client, $apiKey, $userAgent);
        $result = $oneClickApi->authorizeOrder('test', 666, 'test');

        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * @dataProvider fakeData
     */
    public function testPayment($apiKey, $userAgent)
    {
        $fakeResponse = new Guzzle\Http\Message\Response(200, array('Content-Type' => 'application/json'), '{"url": "http://localhost/success"}');
        $client = static::initClientTest(OystApiClientFactory::ENTITY_PAYMENT, $fakeResponse);

        $paymentApi = new OystPaymentApi($client, $apiKey, $userAgent);
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

        $this->assertEquals($paymentApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * @dataProvider fakeData
     */
    public function testPostProducts($apiKey, $userAgent)
    {
        $fakeResponse = new Guzzle\Http\Message\Response(200, array('Content-Type' => 'application/json'), '{"imported": 2}');
        $client = static::initClientTest(OystApiClientFactory::ENTITY_CATALOG, $fakeResponse);

        $products = array();
        $product = new OystProduct();
        $product->setRef('ma_ref');
        $product->setTitle('my title');
        $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
        $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
        $product->setImages(array('http://localhost'));

        $info = array(
            'meta'     => 'info en vrac',
            'subtitle' => 'test'
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
        $product->setRef('ma_ref');
        $product->setTitle('my title');
        $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
        $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
        $product->setImages(array('http://localhost'));

        $products[] = $product;

        $catalogApi = new OystCatalogApi($client, $apiKey, $userAgent);
        $result = $catalogApi->postProducts($products);

        $this->assertEquals($catalogApi->getLastHttpCode(), 200);
        $this->assertTrue(!is_null($result['imported']));
    }

    /**
     * @dataProvider fakeData
     */
    public function testDeleteProduct($apiKey, $userAgent)
    {
        $fakeResponse = new Guzzle\Http\Message\Response(404, array('Content-Type' => 'application/json'), '{"error": {"code": "CAT-404", "message": "product-not-found"}}');
        $client = static::initClientTest(OystApiClientFactory::ENTITY_CATALOG, $fakeResponse);

        $catalogApi = new OystCatalogApi($client, $apiKey, $userAgent);
        $result = $catalogApi->deleteProduct('1-1');

        $this->assertEquals($catalogApi->getLastHttpCode(), 404);
        $this->assertEquals($catalogApi->getLastError(), 'product-not-found');
        $this->assertTrue(is_null($result));
    }

    /**
     * @dataProvider fakeData
     */
    public function testNotifyImport($apiKey, $userAgent)
    {
        $fakeResponse = new Guzzle\Http\Message\Response(200, array('Content-Type' => 'application/json'), '{"import_id": "fake_uuid"}');
        $client = static::initClientTest(OystApiClientFactory::ENTITY_CATALOG, $fakeResponse);

        $catalogApi = new OystCatalogApi($client, $apiKey, $userAgent);
        $result = $catalogApi->notifyImport();

        $this->assertEquals($catalogApi->getLastHttpCode(), 200);
        $this->assertTrue(!is_null($result['import_id']));
    }

    /**
     * @dataProvider fakeData
     */
    public function testOkGetOrders($apiKey, $userAgent)
    {
        $json = '{"total_items": "400", "total_pages": "40", "orders": [{"id": 1, "product_reference": "ma_ref"}, {"id": 2, "product_amount": {"value": 5000, "currency": "EUR", "param_supp": "test"}}, {"id": 3, "param_supp": "test"}]}';
        $fakeResponse = new Guzzle\Http\Message\Response(200, array('Content-Type' => 'application/json'), $json);
        $client = static::initClientTest(OystApiClientFactory::ENTITY_ORDER, $fakeResponse);

        $orderApi = new OystOrderApi($client, $apiKey, $userAgent);
        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $orderApi->getOrders();

        $this->assertEquals($orderApi->getLastHttpCode(), 200);
        $this->assertEquals($result->get('totalItems'), '400');
        $this->assertEquals($result->get('totalPages'), '40');
        $this->assertEquals($result->get('unknownProperty'), null);
        $this->assertTrue(is_array($result->get('items')));
        $this->assertEquals(count($result->get('items')), 3);
    }

    /**
     * @dataProvider fakeData
     */
    public function testKoGetOrders($apiKey, $userAgent)
    {
        $fakeResponse = new Guzzle\Http\Message\Response(404, array('Content-Type' => 'application/json'), '{"statusCode": 404, "error": "Not Found"}');
        $client = static::initClientTest(OystApiClientFactory::ENTITY_ORDER, $fakeResponse);

        $orderApi = new OystOrderApi($client, $apiKey, $userAgent);
        $result = $orderApi->getOrders();

        $this->assertEquals($orderApi->getLastHttpCode(), 404);
        $this->assertEquals($orderApi->getLastError(), 'Not Found');
        $this->assertTrue(is_null($result));
    }
}
