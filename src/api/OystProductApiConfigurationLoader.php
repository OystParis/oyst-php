<?php

class OystProductApiConfigurationLoader extends OystApiConfigurationLoader
{
    /**
     * @return array
     */
    final public function getMethodAddProducts()
    {
        return $this->getCatalogEndpoints()['addProducts'];
    }

    /**
     * @return array
     */
    final public function getMethodUpdateProducts()
    {
        return $this->getCatalogEndpoints()['updateProducts'];
    }

    /**
     * @return array
     */
    final public function getMethodGetProducts()
    {
        return $this->getCatalogEndpoints()['getProducts'];
    }

    /**
     * @return array
     */
    final public function getMethodDeleteProducts()
    {
        return $this->getCatalogEndpoints()['Products'];
    }
}
