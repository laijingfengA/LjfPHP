<?php

namespace app\controller\admin;

use core\Base;
use PFinal\Cache\FileCache;
use PHPMailer\PHPMailer\PHPMailer;

class LoginController extends Base
{
    /**
     * 登录
     */
    public function index()
    {
        //验证登录
        if (isMethod() == 'post') {
            $user = post('user');
            $password = post('password');
            $vcode = post('vcode');

            $cache = new FileCache();
            $cacheCode = $cache->get($user . 'code');          //从缓存中获取

            if ($cacheCode != $vcode) {
                return ajaxMsg('20000', '验证码错误');
            }

            if ($user != 'admin' || $password != '123456') {
                return ajaxMsg('20000', '账号或密码错误');
            }

            //存cookie中
            setcookie("passport_SSID", $user, time() + 3600 * 24, '/LjfPHP/index.php/admin');  //24小时后过期
            setcookie("passport_CODE", md5($user . md5($password)), time() + 3600 * 24, '/LjfPHP/index.php/admin');  //24小时后过期

            return ajaxMsg('10000', URL . '/admin/admin/index');
        }

        $this->display('admin/login.twig');
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        setcookie("passport_SSID", "");
        setcookie("passport_CODE", "");

        header("location: " . URL . "/admin/login/index");
        exit;
    }

    /**
     * 发送邮件
     */
    public function sendEmail()
    {
        $username = request('username');
        $password = request('password');

        //用户信息
        $user = [
            'username' => 'admin',
            'email' => 'Your@email.com'
        ];

        if ($username != $user['username']) {
            return ajaxMsg('20000', '账号错误');
        }

        $mail = new PHPMailer();

        //服务器设置
//        $mail->SMTPDebug = 2;                               // 启用冗长的调试输出
        $mail->isSMTP();                                      // 设置邮件收件人使用SMTP
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.qq.com';                          // 指定主和备份SMTP服务器
        $mail->SMTPAuth = true;                               // 启用SMTP认证
        $mail->Username = '发邮件的邮箱@qq.com';               // SMTP用户名
        $mail->Password = 'osflxoadlkukbdif';                 // SMTP授权码
        $mail->SMTPSecure = 'tls';                            // 启用TLS加密，`SSL`也接受
        $mail->Port = 587;                                    // 连接到TCP端口

        $mail->setFrom('837293332@qq.com', '我是发送者');     //发送者
        $mail->addAddress($user['email']);                   //接受者

        $rand = rand(100000, 999999);                         //随机数

        $cache = new FileCache();
        $cache->set($username . 'code', $rand, 60);    //存入memcache中，put(key,val,有效时间单位是秒)

        //内容
        $mail->isHTML(true);                           // 将电子邮件格式设置为HTML
        $mail->Subject = "验证码：{$rand}（OA2018）";
        $mail->Body = "登录验证码: <b>{$rand}</b>,请注意密码安全";

        if (!$mail->send()) {
            return ajaxMsg('20000', '发送失败');
        }

        return ajaxMsg('10000', '发送成功');
    }
}