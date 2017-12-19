<?php

namespace Oyst\Classes;

/**
 * Class OneClickCustomization
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickCustomization implements OystArrayInterface
{
    /**
     * @var array
     */
    private $cta;

    /**
     * @var array
     */
    private $logo;

    /**
     * @return array
     */
    public function getCta()
    {
        return $this->cta;
    }

    /**
     * @param string $label
     * @param string $url
     */
    public function setCta($label, $url)
    {
        $this->cta = array('label' => $label, 'url' => $url);
    }

    /**
     * @return array
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string|null $desktop
     * @param string|null $mobile
     */
    public function setLogo($desktop = null, $mobile = null)
    {
        $this->logo = array('desktop' => $desktop, 'mobile' => $mobile);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $customization = array(
            'cta' => $this->cta,
            'logo' => $this->logo,
        );

        return $customization;
    }
}
