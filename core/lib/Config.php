<?php

namespace core\lib;

class Config
{
    static public $conf = array();

    /**
     * 引入配置文件中的单个配置
     * @param $name
     * @param $file
     * @return mixed
     * @throws \Exception
     */
    static public function get($name, $file)
    {
        /**
         * 1.判断配置文件是否存在
         * 2.判断配置是否存在
         * 3.缓存配置
         */

        if (isset(self::$conf[$file])) {
            return self::$conf[$file][$name];
        }

        $path = ROOT . DS . 'core' . DS . 'conf' . DS . $file . ".php";

        if (!is_file($path)) {
            throw new \Exception('找不到配置文件：' . $file);
        }

        $conf = include $path;

        if (!isset($conf[$name])) {
            throw new \Exception('找不到配置文件：' . $name);
        }

        self::$conf[$file] = $conf;
        return $conf[$name];
    }

    /**
     * 引入整个配置文件
     * @param $file
     * @return array
     * @throws \Exception
     */
    static public function all($file)
    {
        if (isset(self::$conf[$file])) {
            return self::$conf[$file];
        }

        $path = ROOT . DS . 'core' . DS . 'conf' . DS . $file . ".php";

        if (!is_file($path)) {
            throw new \Exception('找不到配置文件' . $file);
        }

        $conf = include $path;

        self::$conf[$file] = $conf;
        return $conf;
    }
}