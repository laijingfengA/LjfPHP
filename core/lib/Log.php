<?php

namespace core\lib;

class Log
{
    static $class;

    /**
     * 1.确定日志的存储方式
     * 2.写日志
     */

    static public function init()
    {
        $drive = Config::get('DRIVE', 'log');    //确定存储方式
        $class = '\core\lib\drive\log\\' . $drive;          //拼接类名

        self::$class = new $class;
    }

    /**
     * 写入日志
     * @param $message
     * @param string $file
     */
    static public function log($message, $file = 'log')
    {
        self::$class->log($message, $file);
    }
}