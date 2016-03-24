<?php
/**
 * Created by PhpStorm.
 * User: asmolin
 * Date: 24.03.16
 * Time: 16:44
 */

namespace ItBlaster\SingleConfigBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use ItBlaster\SingleConfigBundle\Entity\Config;


/**
 * Class ConfigService
 * @package ItBlaster\SingleConfigBundle\Service
 */
class ConfigService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $repository;

    private static $data;

    /**
     * ConfigService constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($name = null, $default = null)
    {
        if (self::$data === null) {
            $this->fillData();
        }

        if (!$name) {
            return self::$data;
        }

        return isset(self::$data[$name]) ? self::$data[$name] : $default;
    }

    private function fillData()
    {
        self::$data = [];

        $q = $this
            ->entityManager
            ->createQuery("select partial c.{id,name,value} from ItBlaster\SingleConfigBundle\Entity\Config c");

        $res = $q->execute(null, Query::HYDRATE_ARRAY);

        foreach ($res as $k => $v) {
            self::$data[$v['name']] = $v['value'];
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        if (self::$data === null) {
            $this->fillData();
        }
        self::$data[$name] = $value;

        $config = $this->getRepository()->findOneBy(['name' => $name]);
        if (!$config) {
            $config = new Config();
            $config->setName($name);
            $config->setTitle($name);
        }

        $config->setValue($value);

        $this->entityManager->persist($config);
        $this->entityManager->flush();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = $this->entityManager->getRepository('ItBlasterSingleConfigBundle:Config');
        }

        return $this->repository;
    }

}