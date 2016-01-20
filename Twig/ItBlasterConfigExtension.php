<?php
namespace ItBlaster\SingleConfigBundle\Twig;

use ItBlaster\SingleConfigBundle\Model\Config;

/**
 * Class ItBlasterSingleConfigExtension
 * @package ItBlaster\SingleConfigBundle\Twig
 */
class ItBlasterSingleConfigExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('config', array($this, 'configValue')),
        );
    }

    /**
     * @param string $setting
     * @param null|string $locale
     * @return bool|string
     */
    public function configValue($setting, $locale = null)
    {
        return Config::get($setting, $locale);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'config';
    }
}