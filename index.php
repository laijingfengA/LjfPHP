<?php

/**
 * 入口文件
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 */

date_default_timezone_set('PRC');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);                                            //根
define('CORE', ROOT . DS . 'core');                                 //核心
define('APP', ROOT . DS . 'app');                                   //MVC
define('MODULE', 'app');                                            //模块

$arr = explode('index.php/', $_SERVER['REQUEST_URI']);
define('WEB', '//' . $_SERVER['HTTP_HOST'] . $arr[0] . 'web');        //web,用于存放css、js、img和第三方的样式的目录
define('URL', '//' . $_SERVER['HTTP_HOST'] . $arr[0] . 'index.php');  //访问url
define('DEBUG', true);

include ROOT . DS . 'vendor' . DS . 'autoload.php';

//是否开始错误显示
if (DEBUG) {

    //引入错误展示类
    $whoops = new \Whoops\Run;
    $option = new \Whoops\Handler\PrettyPageHandler();
    $errorTitle = "出错啦~";
    $option->setPageTitle($errorTitle);
    $whoops->pushHandler($option);
    $whoops->register();

    ini_set('display_errors', 'on');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 'off');
    error_reporting(0);
}

include CORE . DS . 'common' . DS . 'function.php';    //函数库
include CORE . DS . 'Base.php';

//自动加载
spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    $filePath = ROOT . DS . $className . '.php';

    if (!is_file($filePath)) {
        exit('加载的' . $className . '不存在');
    }

    include $filePath;
});

\core\Base::run();      //启动