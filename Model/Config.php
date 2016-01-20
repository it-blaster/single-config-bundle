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

    public static function get($config_name, $locale = null)
    {
        $configObject = new Config();

        if(self::$data === null) {
            $con = \Propel::getConnection();
            $query = '
                SELECT c.name, ci.value, ci.data
                FROM config_i18n ci iNNER JOIN config c ON c.id = ci.id';
            $stmt = $con->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as $k => $v) {
                self::$data [$v['locale']] [$v['name']] ['value'] = $v['value'];
                self::$data [$v['locale']] [$v['name']] ['data'] = $v['data'];
            }
        }

        if(isset(self::$data[$locale][$config_name]) && self::$data[$locale][$config_name]['value']) {
            $result = self::$data[$locale][$config_name];
        } else {
            if(isset(self::$data['en'][$config_name]) && self::$data['en'][$config_name]['value']) {
                $result = self::$data['en'][$config_name];
            } else {
                return false;
            }
        }

        $camelizedName = PropelInflector::camelize('get_'.$config_name);
        if(method_exists($configObject, $camelizedName)) {
            $configObject
                ->setLocale($locale)
                ->setName($config_name)
                ->setData($result['data'])
                ->setValue($result['value']);
            return $configObject->getData();
        } else {
            return $result['value'];
        }
    }

    /**
     * @return string
     */
    public function getData()
    {
        $camelizedName = PropelInflector::camelize('get_'.$this->getName());

        if(method_exists($this, $camelizedName)) {
            $result = $this->$camelizedName();
        } else {
            $result = parent::getData();
        }

        return $result;
    }
}
