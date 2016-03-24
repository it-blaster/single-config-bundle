<?php
namespace ItBlaster\SingleConfigBundle\Twig;

use ItBlaster\SingleConfigBundle\Model\Config;
use ItBlaster\SingleConfigBundle\Service\ConfigService;

/**
 * Class ItBlasterSingleConfigExtension
 * @package ItBlaster\SingleConfigBundle\Twig
 */
class ItBlasterSingleConfigExtension extends \Twig_Extension
{
    /** @var ConfigService  */
    private $config;

    /**
     * ItBlasterSingleConfigExtension constructor.
     *
     * @param ConfigService $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

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
     * @param      $name
     * @param null $default
     *
     * @return mixed
     */
    public function configValue($name, $default = null)
    {
        return $this->config->get($name, $default);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'config';
    }
}