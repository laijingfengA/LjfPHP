<?php

/**
 * 公用函数库
 */

/**
 * 返回json数据
 * @param string $statusCoding
 * @param array $data
 */
function ajaxMsg($statusCoding = '20000', $data = array())
{
    $data = array(
        'flag' => intval($statusCoding / 10000),
        'msg' => getMsg($statusCoding),
        'errorCode' => $statusCoding,
        'data' => $data
    );

    echo json_encode($data);
    exit();
}

function getMsg($key, $lang = 'zh')
{
    #if(in_array($lan, array())){}
    $key = strval($key);
    return $lang($key);
}

function zh($key)
{
    $outArr = [
        '10000' => '成功',
        '20000' => '失败'
    ];

    return $outArr[$key];
}

/**
 * get接收参数
 * @param type $key
 * @param type $type
 * @return type
 */
function get($key = "", $type = "") {
    if ($key) {
        $result = isset($_GET[$key]) ? $_GET[$key] : "";
        switch ($type) {
            case 'trim':
                $result = trim(cleanXss($result));
                break;
            case 'int' :
                $result = intval($result);
            default:
                break;
        }
    } else {
        $result = cleanXss($_GET);
    }
    return$result;
}

/**
 * post接收参数
 * @param type $key
 * @param type $type
 * @return type
 */
function post($key = "", $type = "") {
    if ($key) {
        $result = isset($_POST[$key]) ? $_POST[$key] : "";
        switch ($type) {
            case 'trim':
                $result = trim(cleanXss($result));
                break;
            case 'int' :
                $result = intval($result);
                break;
            default:
                break;
        }
    } else {
        $result = cleanXss($_POST);
    }
    return $result;
}

/**
 * post和get都可以
 * @param string $key
 * @param string $type
 * @return int|string
 */
function request($key="", $type=""){
    if($key){
        $result = isset($_REQUEST[$key]) ? $_REQUEST[$key] : "";
        switch ($type) {
            case 'trim':
                $result = trim(cleanXss($result));
                break;
            case 'int' :
                $result = intval($result);
                break;
            default:
                break;
        }
    }else{
        $result = cleanXss($_REQUEST);
    }
    return $result;
}

/**
 * 将含有GBK的中文数组转为utf-8
 *
 * @param array $arr   数组
 * @param string $in_charset 原字符串编码
 * @param string $out_charset 输出的字符串编码
 * @return array
 */
function arrayIconv($arr, $in_charset="gbk", $out_charset="utf-8")
{
    $ret = eval('return '.iconv($in_charset,$out_charset,var_export($arr,true).';'));
    return $ret;
    // 这里转码之后可以输出json
    // return json_encode($ret);
}

/**
 * xss
 * @param type $val
 * @return type
 */
function cleanXss(& $val) {
    if (is_array($val)) {
        foreach ($val as $k => $v) {
            $val[$k] = cleanXss($v);
        }
    } else {
        $ra = array('script', 'javascript', 'vbscript', 'expression', 'applet', 'bgsound', 'onload', 'onunload', 'onchange', 'onsubmit', 'onreset', 'onselect', 'onblur', 'onfocus', 'onabort', 'onkeydown', 'onkeypress', 'onkeyup', 'onclick', 'ondblclick', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onunload');

        //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
        if (!get_magic_quotes_gpc()) {
            $val = addslashes($val);
        }

        $val = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $val);
        $val = str_replace($ra, '', $val);     //删除非打印字符，粗暴式过滤xss可疑字符串
    }
    return $val;
}

/**
 * 判断当前请求是POST还是GET
 * @return string
 */
function isMethod()
{
    if (isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST')) {
        return 'post';
    }

    return 'get';
}