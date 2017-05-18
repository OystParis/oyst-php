<?php

namespace Oyst\Test\Controller;

use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystCatalogApi;
use Oyst\Test\TestSettings;

class ImportControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  TestSettings */
    private $settings;

    /** @var  OystCatalogApi */
    private $catalogApi;

    private function loadRequirements()
    {
        $this->settings = new TestSettings();
        $this->settings->load();

        /** @var OystCatalogApi $catalogApi */
        $this->catalogApi = OystApiClientFactory::getClient(
            OystApiClientFactory::ENTITY_CATALOG,
            $this->settings->getApiKey(),
            $this->settings->getUserAgent(),
            $this->settings->getEnv()
        );

        return $this;
    }

    public function testNotifyImport()
    {
        $this->loadRequirements();

        $result = $this->catalogApi->notifyImport();

        $this->assertTrue(isset($result['import_id']));
    }
}
