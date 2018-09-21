<?php

namespace core;

use core\lib\Route;

class Base
{
    /**
     * 框架启动
     */
    static public function run()
    {
        $route = new Route();
        $action = $route->action;
        $controller = $route->controller;

        //层级次数
        $count = substr_count($controller, '/');

        //给控制器名的首字母换大写
        if ($count > 0) {
            $controllerArr = explode('/', $controller);
            $end = array_pop($controllerArr);
            $end = ucfirst($end);
            array_push($controllerArr, $end);
            $controller = implode('/', $controllerArr);
        } else {
            $controller = ucfirst($controller);
        }

        $controllerPath = APP . DS . 'controller' . DS . $controller . 'Controller.php';

        if (is_file($controllerPath)) {
            include $controllerPath;
            $controllerClass = "\\" . MODULE . "\controller" . "\\" . "{$controller}Controller";
            $controllerClass = str_replace('/', '\\', $controllerClass);
            $class = new $controllerClass;
            $class->$action();
        } else {
            echo "your request file is not found<br>";
            echo $controller;
            exit();
        }
    }

    /**
     * 渲染模板
     */
    public function display($file, $array = array())
    {
        $filePath = APP . DS . 'views' . DS . $file;

        if (!is_file($filePath)) {
            throw new \Exception('渲染模板不存在', 500);
        }

        //使用Twig组件
        $loader = new \Twig_Loader_Filesystem(APP . DS . 'views');
        $twig = new \Twig_Environment($loader, array(
            'cache' => ROOT . DS . 'cache' . DS . "twig",
            'debug' => DEBUG
        ));

        $array = array_merge($array, [
            'WEB' => WEB,   //用于引入文件
            'URL' => URL    //用于拼接url
        ]);

        $template = $twig->load($file);
        $template->display($array);
    }
}