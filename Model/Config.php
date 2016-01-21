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

    public static function get($config_name)
    {
        if(self::$data === null) {
            $con = \Propel::getConnection();
            $query = 'SELECT c.name, c.value, c.data FROM config';
            $stmt = $con->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach ($result as $k => $v) {
                self::$data['name']= $v['value'];
            }
        }

        return isset(self::$data[$config_name]) && self::$data[$config_name]['value'] ?
            self::$data[$config_name] :
            false;
    }
}
