<?php

require_once(__DIR__.'/../autoload.php');

$apiKey = 'api_key_for_preprod';

$oneClickApi = OystApiClientFactory::createOneClickApiClient($apiKey, 'Oyst Lib PHP');
$result = $oneClickApi->authorizeOrder('test', 'test', 666);
echo "<pre>";var_dump($result);
echo "===============================================";

$paymentApi = OystApiClientFactory::createPaymentApiClient($apiKey, 'Oyst Lib PHP');
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
echo "<pre>";var_dump($result);
echo "===============================================";

$apiKey = "api_key_for_integration";
$catalogApi = OystApiClientFactory::createCatalogApiClient($apiKey, 'Oyst Lib PHP');
$products = [];
$product = new OystProduct();
$product->setRef('ma_ref');
$product->setTitle('my title');
$product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
$product->setCategories([new OystCategory('cat_ref', 'cat title', true)]);
$product->setImages(['http://localhost']);

$info = new stdClass();
$info->meta = 'info en vrac';
$info->subTitle  = 42;
$info->param_underscored  = 'test';
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
$product->setCategories([new OystCategory('cat_ref', 'cat title', true)]);
$product->setImages(['http://localhost']);

$products[] = $product;

$result = $catalogApi->postProducts($products);
if (is_null($result)) {
    var_dump($catalogApi->getLastHttpCode(), $catalogApi->getLastError());
} else {
    echo "<pre>";var_dump($result);
}
//$result = $catalogApi->notifyImport();
//if (is_null($result)) {
//    var_dump($catalogApi->getLastHttpCode(), $catalogApi->getLastError());
//} else {
//    echo "<pre>";var_dump($result);
//}
//$orderApi = OystApiClientFactory::createOrderApiClient($apiKey, 'Oyst Lib PHP');
//$result = $orderApi->getOrders();
//echo "<pre>";var_dump(json_encode(json_decode($result, true), JSON_PRETTY_PRINT));
die;
