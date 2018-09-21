<?php

namespace core\lib\drive\log;

use core\lib\Config;

/**
 * 日志存系统文件
 */
class File
{
    public $path;   //日志存储位置

    public function __construct()
    {
        $conf = Config::get('OPTION', 'log');
        $this->path = $conf['path'];
    }

    /**
     * 写入日志
     * @param $message
     * @param string $file
     * @return bool|int
     */
    public function log($message, $file = 'log')
    {
        /**
         * 1.判断目录文件是否存在（没有则新建一个）
         * 2.写入日志
         */
        $path = $this->path . date('YmdH');
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        return file_put_contents($path . DS . $file . '.php', date('Y-m-d H:i:s') . " " .$message . PHP_EOL, FILE_APPEND);
    }
}