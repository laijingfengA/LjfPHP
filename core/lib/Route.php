<?php

namespace core\lib;

class Route
{
    public $controller = 'index';
    public $action = 'index';

    public function __construct()
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            return;
        }

        //用于取出index.php后面一串
        $arr1 = explode('index.php/', $_SERVER['REQUEST_URI']);

        if (count($arr1) < 2) {
            return;
        }

        $arr2 = explode('?', $arr1[1]);

        if (count($arr2) < 1) {
            return;
        }

        //$pathArr数组中，最后一个元素是方法名test，其他是控制器路径：admin/index
        $pathArr = explode('/', $arr2[0]);

        if (count($pathArr) < 1) {
            return;
        }

        switch (count($pathArr)) {
            case 0:
                break;
            case 1:
                $this->controller = !empty($pathArr[0]) ? $pathArr[0] : 'index';
                break;
            case 2:
                $this->action = array_pop($pathArr);
                $this->controller = $pathArr[0];
                break;
            default:
                $this->action = array_pop($pathArr);
                $this->controller = implode('/', $pathArr);
                break;
        }

        return;
    }
}