<?php

namespace app\controller;

use app\model\Question;
use core\Base;
use core\lib\Log;

class IndexController extends Base
{
    public function index()
    {
//        Log::init();                     //初始化
//        Log::log("我打印一下");  //输出日志
//        exit;

        $data = "hello world";
        $test = [
            '001' => 'test001',
            '002' => 'test002',
            '003' => 'test003',
            '004' => 'test004',
            '005' => 'test005'
        ];

        //渲染模板
        $this->display('test/test.twig', [
            'data' => $data,
            'test' => $test
        ]);
    }

    public function select()
    {
        $model = new Question();
        $sql = "SELECT * FROM `laijingfeng_question`";
        $res = $model->query($sql);
        dump($res->fetchAll());
    }
}