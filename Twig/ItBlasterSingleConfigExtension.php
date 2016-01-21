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
     * @return bool|string
     */
    public function configValue($setting)
    {
        return Config::get($setting);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'config';
    }
}