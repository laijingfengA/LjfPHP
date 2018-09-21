<?php

namespace app\controller\admin;

use core\Base;

class BaseController extends Base
{
    public function __construct()
    {
        self::getUserInfo();
    }

    /**
     * 获取用户信息
     */
    protected function getUserInfo()
    {
        header('Content-Type: text/html; charset=utf-8');

        if (empty($_COOKIE['passport_SSID']) || empty($_COOKIE['passport_CODE'])) {
            header("location: " . URL . "/admin/login/index");
            exit;
        }

        $passport_SSID = $_COOKIE['passport_SSID'];
        $passport_CODE = $_COOKIE['passport_CODE'];

        //todo 通过用户名去获取用户信息
        $userInfo = [
            'user_id' => 1001,
            'username' => 'test赖',
            'pwd' => '123456'
        ];

        //验证cookie是否正确
        if ($passport_CODE != md5($passport_SSID . md5($userInfo['pwd']))) {
            header("location: " . URL . "/admin/login/index");
            exit;
        }

        return $userInfo;
    }

    /**
     * 分页HTML
     * @param $now_page     当前页
     * @param $total_page   总页数
     * @param $page_url
     * @param int $data_count 总条数
     * @return string
     */
    protected function pages_ini($now_page, $total_page, $page_url, $data_count = 0)
    {
        if ($total_page <= 1) {
            return '';
        }
        //计算上一页和下一页
        $prev_page = $now_page > 1 ? $now_page - 1 : 1;
        $next_page = $total_page > $now_page ? $now_page + 1 : $now_page;
        //分页代码
        $string = "<div class=\"pageNav\">";
        if ($data_count > 0)
            $string .= "<span style=\"border: 0px none;\">共<strong class='js-total'>{$data_count}</strong>条记录</span>";
        //上一页
        if ($prev_page < $now_page) {
            $string .= "<a href=\"{$page_url}&page={$prev_page}\">上一页</a></li>";
        } else {
            $string .= "<a href=\"javascript:;\">上一页</a>";
        }
        for ($i = $now_page - 3; $i <= $now_page + 9; $i++) {
            if ($i > 0 && $i <= $total_page) {
                if ($i == $now_page) {
                    $string .= "<b>{$i}</b>";
                } else {
                    $string .= "<a href=\"{$page_url}&page={$i}\">{$i}</a>";
                }
            }
        }

        //下一页
        if ($next_page > $now_page) {
            $string .= "<a href=\"{$page_url}&page={$next_page}\">下一页</a>";
        } else {
            $string .= "<a href=\"javascript:;\">下一页</a>";
        }
        $string .= "</div>";
        return $string;
    }
}