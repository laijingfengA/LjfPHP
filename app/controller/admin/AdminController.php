<?php

namespace app\controller\admin;

class AdminController extends BaseController
{
    /**
     * 仪表盘
     */
    public function index()
    {
        $this->display("admin/index.twig");
    }

    /**
     * 欢迎页
     */
    public function welcome()
    {
        $this->display("admin/welcome.twig");
    }
}