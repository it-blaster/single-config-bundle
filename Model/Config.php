<?php

namespace ItBlaster\SingleConfigBundle\Model;

use ItBlaster\SingleConfigBundle\Model\om\BaseConfig;
use Propel\PropelBundle\Util\PropelInflector;

class Config extends BaseConfig
{
    /**
     * @var array Вся база конфигов
     */
    public static $data;

    /**
     * Возвращает значение конфига по алиасу
     *
     * @param $config_name
     * @return bool
     */
    public static function get($config_name)
    {
        if(self::$data === null) {
            $con = \Propel::getConnection();
            $query = 'SELECT name, value FROM config';
            $stmt = $con->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach ($result as $k => $v) {
                self::$data[$v['name']]= $v['value'];
            }
        }

        return isset(self::$data[$config_name]) && self::$data[$config_name] ?
            self::$data[$config_name] :
            false;
    }

    /**
     * Устанавливает значение конфига
     *
     * @param $config_name
     * @param $config_value
     * @throws \Exception
     * @throws \PropelException
     */
    public static function set($config_name, $config_value)
    {
        $isset_config_value = self::get($config_name);
        if ($isset_config_value) {
            $config = ConfigQuery::create()->findOneByName($config_name);
        } else {
            $config = new Config();
            $config->setName($config_name)
                ->setValue($config_value)
                ->save();
        }
        self::$data[$config_name] = $config_value;
    }
}
