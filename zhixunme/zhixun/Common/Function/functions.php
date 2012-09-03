<?php

//--------------String---------------
/**
 * 字符串截取
 * @param  <string> $str     原字符串
 * @param  <int>    $length  截取长度
 * @param  <int>    $start   开始截取位置
 * @param  <string> $charset 编码
 * @param  <bool>   $suffix  是否显示省略号
 * @return <string> 截取后的字符串
 */
function str_sub($str, $length, $start = 0, $charset = "utf-8", $suffix = true) {
    $string = new ZString();
    return $string->substr($str, $length, $start, $charset, $suffix);
}

/**
 * 将数据封装成JSONP格式
 * @param  <bool>  $ret   TRUE OR FALSE
 * @param  <mixed> $data  数据
 * @param  <int>   $count 数据个数
 * @param  <mixed> $sup   额外数据
 * @return <string> JSONP格式字符串
 */
function jsonp_encode($ret, $data = null, $count = null, $sup = null) {
    $str = new ZString();
    $jret = $ret ? 'true' : 'false';
    $jdata = isset($data) ? ',"data":' . $str->json_encode($data) : '';
    $jcount = isset($count) ? ',"count":' . $count : '';
    $jsup = isset($sup) ? ',"sup":' . $str->json_encode($sup) : '';
    $jsonp = $_REQUEST['jsoncallback'] . '({"ret":' . $jret . $jdata . $jcount . $jsup . '});';
    return $jsonp;
}

function build_id() {
    return (time() - 1339281934) . rand(0, 9);
}

/**
 * 任务天数过滤
 * @param <type> $days
 * @return <type>
 */
function filter_task_days($days) {
    if ($days < 1)
        return 1;
    if ($days > 30)
        return 30;
    return intval($days);
}

/**
 * 获取当期操作代码
 * @return <string>
 */
function current_action_code() {
    return GROUP_NAME . '/' . MODULE_NAME . '/' . ACTION_NAME;
}

/**
 * 自定义日期格式化
 * @param  <date> $date 日期
 * @return <string> 格式化结果
 */
function cdate_format($date) {
    if (empty($date))
        return null;
    if (empty($date))
        return null;
    $parse = date_parse($date);
    //将日期转化为时间戳
    $time = mktime($parse['hour'], $parse['minute'], $parse['second'], $parse['month'], $parse['day'], $parse['year']);
    $now = time(); //当前日期的时间戳
    $temp = $now - $time;
    if ($temp < 60) {
        return ($temp <= 0 ? 1 : $temp) . "秒前";
    } else if ($temp < 3600) {
        $m = (int) ($temp / 60);
        return $m . "分钟前";
    } else if ($temp < 86400) {
        $h = (int) ($temp / 3600);
        return $h . "小时前";
    } else {
        if ($parse['hour'] < 10) {
            $parse['hour'] = '0' . $parse['hour'];
        }
        if ($parse['minute'] < 10) {
            $parse['minute'] = '0' . $parse['minute'];
        }
        return $parse['month'] . '月' . $parse['day'] . '日' . ' ' . $parse['hour'] . ':' . $parse['minute'];
//        $d = (int)($temp / 86400);
//        if($d == 1){
//            return '昨天 '.$parse['hour'].':'.$parse['minute'];
//        }
//        else if( $d < 30 ){
//            return $d."天前";
//        }
//        else{
//            return $parse['month'].'月'.$parse['day'].'日'.' '.$parse['hour'].':'.$parse['minute'];
//        }
    }
}

/**
 * 去除时间的日期格式化
 * @param  <date> $date 日期
 * @return <string> 格式化结果
 */
function nt_date_format($date) {
    return substr($date, 0, 10);
}

/**
 * 任务状态格式化
 * @param <type> $status
 * @param <type> $date
 * @return string
 */
function status_format($status, $date) {
    if ($status == 1) {
        $time = time();
        $etime = get_time($date);
        $temp = $etime - $time;
        if ($temp <= 0)
            $string = '已过期';
        else {
            $day = (int) ($temp / 86400);
            $hour = (int) (($temp - $day * 86400) / 3600);
            if ($day != 0) {
                $string .= $day . '天';
            }
            if ($hour != 0) {
                $string .= $hour . '小时';
            }
            if ($day == 0 && $hour == 0) {
                $string = '即将截止投标';
            } else {
                $string .= ' 后截止投标';
            }
        }
    } else if ($status == 2) {
        $string = '已完成';
    } else {
        $string = '已过期';
    }
    return $string;
}

/**
 * 简历标题格式化
 * @param int $agent 是否代理（1是0否）
 * @param int $cate 类别（1全职2兼职）
 * @param int $resume_id 简历编号
 * @return string 
 */
function resume_title_format($agent, $cate, $resume_id) {
    if ($agent == 1) {
        $one = 'B';
    } else {
        $one = 'P';
    }
    if ($cate == 1) {
        $two = 'F';
    } else {
        $two = 'P';
    }
    return '简历' . $one . $two . $resume_id;
}

/**
 * 委托状态格式化
 * @param <type> $status
 * @param <int>  $side   3为接受委托方,其它为委托方
 */
function dstatus_format($status, $side) {
    $string = '已过期';
    if ($side == 3) {
        if ($status == 2) {
            $string = '待回复';
        } elseif ($status == 3) {
            $string = '已拒绝';
        } elseif ($status == 4) {
            $string = '已接受';
        }
    } else {
        if ($status == 1) {
            $string = '待处理';
        } elseif ($status == 2) {
            $string = '等待对方回复';
        } elseif ($status == 3) {
            $string = '对方已拒绝';
        } elseif ($status == 4) {
            $string = '对方已接受';
        }
    }
    return $string;
}

/**
 * 委托简历状态格式化
 * @param <int> $status
 * @return string
 */
function drs_format($status) {
    switch ($status) {
        case 5:$string = '简历未查看';
            break;
        case 1:$string = '简历未公开';
            break;
        case 2:$string = '简历已公开';
            break;
        case 4:$string = '已终止委托';
            break;
        case 3:$string = '已完成';
            break;
        default :$string = '状态值只能为1-5';
            break;
    }
    return $string;
}

/**
 * 工作年限格式化
 */
function exp_format($exp) {
    switch ($exp) {
        case 1 : $string = '1年以上';
            break;
        case 2 : $string = '3年以上';
            break;
        case 3 : $string = '5年以上';
            break;
        case 4 : $string = '8年以上';
            break;
        default : $string = '无';
            break;
    }
    return $string;
}

/**
 * 学历格式化
 */
function degree_format($degree) {
    switch ($degree) {
        case 1 : $string = '中专';
            break;
        case 2 : $string = '大专';
            break;
        case 3 : $string = '本科';
            break;
        case 4 : $string = '硕士';
            break;
        case 5 : $string = '博士';
            break;
        default : $string = '无';
            break;
    }
    return $string;
}

/**
 * 模块免费条数政策名称格式化
 * @param <string> $mfree
 * @return <string>
 */
function mfree_format($mfree) {
    return $mfree;
}

/**
 * 职称证书级别格式化
 * @param <int> $class
 */
function GC_C_format($class) {
    switch ($class) {
        case 1: $string = '助理';
            break;
        case 2: $string = '中级';
            break;
        case 3: $string = '高级';
            break;
    }
    return $string;
}

/**
 * 注册情况格式化
 * @param <int> $register_case
 * @return <string>
 */
function registerCase_format($register_case) {
    switch ($register_case) {
        case 1:$string = '初始注册';
            break;
        case 2:$string = '变更注册';
            break;
        case 3:$string = '重新注册';
            break;
    }
    return $string;
}

/**
 * 性别格式化
 */
function gender_format($gender) {
    switch ($gender) {
        case 0 : $string = '女';
            break;
        case 1 : $string = '男';
            break;
    }
    return $string;
}

/**
 * 职位薪资格式化
 */
function job_salary_format($salary) {
    switch ($salary) {
        case 0 : $string = '面议';
            break;
        case 2 : $string = '5～10';
            break;
        case 3 : $string = '10～20';
            break;
        case 4 : $string = '20～40';
            break;
        case 5 : $string = '40～99';
            break;
        case 6 : $string = '100 +';
            break;
        case 7 : $string = '0～1';
            break;
        case 8 : $string = '1～2';
            break;
        case 9 : $string = '2～3';
            break;
        case 10 : $string = '3～4';
            break;
        case 11 : $string = '4～5';
            break;
        default : $string = '面议';
    }
    return $string;
}

/**
 * 企业性质格式化
 * @param <type> $category
 * @return <type>
 */
function cc_format($category) {
    switch ($category) {
        case 1 : $string = '国有企业';
            break;
        case 2 : $string = '集体企业';
            break;
        case 3 : $string = '联营企业';
            break;
        case 4 : $string = '股份合作制企业';
            break;
        case 5 : $string = '私营企业';
            break;
        case 6 : $string = '个体户';
            break;
        case 7 : $string = '合伙企业';
            break;
        case 8 : $string = '有限责任公司';
            break;
        case 9 : $string = '股份有限公司';
            break;
    }
    return $string;
}

/**
 * 公司规模格式化
 * @param <int> $company_scale
 * @return string
 */
function company_scale_format($company_scale) {
    switch ($company_scale) {
        case 1:$string = '1-49人';
            break;
        case 2:$string = '50-99人';
            break;
        case 3:$string = '100-499人';
            break;
        case 4:$string = '500-999人';
            break;
        case 5:$string = '1000-2000人';
            break;
        case 6:$string = '2000-5000人';
            break;
        case 7:$string = '5000-10000人';
            break;
        case 8:$string = '10000人以上';
            break;
        default :$string = '1-49人';
    }
    return $string;
}

/**
 * 项目规模格式化
 * @param <int> $project_scale
 */
function project_scale_format($project_scale) {
    switch ($project_scale) {
        case 1 : $string = '0～100万';
            break;
        case 2 : $string = '100～300万';
            break;
        case 3 : $string = '300～500万';
            break;
        case 4 : $string = '500～800万';
            break;
        case 5 : $string = '800～1000万';
            break;
        case 6 : $string = '1000～2000万';
            break;
        case 7 : $string = '2000～5000万';
            break;
        case 8 : $string = '5000万以上';
            break;
        default : $string = '0～100万';
    }
    return $string;
}

/**
 * 年薪
 * @param  <int> $salary
 * @return <float>
 */
function year_salary($salary) {
    return job_salary_format($salary);
    //   $result = round($salary / 10000, 1);
    // return $result;
}

/**
 * 工作状态格式化
 * @param  <int> $state
 * @return <string>
 */
function jstate_format($state) {
    switch ($state) {
        case 1:$string = '不限';
            break;
        case 2:$string = '在职';
            break;
        case 3:$string = '退休';
            break;
        case 4:$string = '离职';
            break;
        default:$string = '不限';
    }
    return $string;
}

/**
 * 获取本周起始日期
 * @return string 
 */
function date_start_week() {
    $w = date_f('w', time());
    $x = $w ? $w - 1 : 6;
    return date_f('Y-m-d', strtotime('-' . $x . ' days')) . ' 00:00:00';
}

/**
 * 获取本周结束日期
 * @return string 
 */
function date_end_week() {
    $w = date_f('w', time());
    $x = $w ? $w - 1 : 6;
    return date_f('Y-m-d', strtotime('+' . (7 - $x) . ' days')) . ' 23:59:59';
}

/**
 * 获取本月起始日期
 * @return string 
 */
function date_start_month($month) {
    return date('Y-m-d', mktime(00, 00, 00, $month, 1));
}

/**
 * 获取本月结束日期
 * @return string 
 */
function date_end_month($month) {
    return date('Y-m-d', mktime(23, 59, 59, $month + 1, 0));
}

/**
 * 获取指定日期的时间戳
 * @param  <date> $date 日期
 * @return <int> 时间戳
 */
function get_time($date) {
    return strtotime($date);
//    $parse = date_parse($date);
//    //将日期转化为时间戳
//    return mktime($parse['hour'], $parse['minute'], $parse['second'], $parse['month'], $parse['day'], $parse['year']);
}

/**
 * 获取两个日期之间相差的天数
 * @param  <string> $start 起始日期
 * @param  <string> $end   终止日期
 * @return <int>
 */
function get_date_differ($start, $end) {
    $differ = strtotime($end) - strtotime($start);
    return ceil($differ / 86400);
}

//--------------Error---------------
/**
 * 获取ZERROR实例
 * @param  <int> $code 错误编号(默认为：ErrorMessage::$OPERATION_FAILED)
 * @return <ZError> ZERROR实例
 */
function E($code) {
    if (empty($code))
        $code = ErrorMessage::$OPERATION_FAILED;
    return new ZError($code);
}

/**
 * 判断是否ZERROR对象
 * @param  <mixed> $obj 对象
 * @return <bool> 是否ZERROR对象
 */
function is_zerror($obj) {
    if (!is_object($obj))
        return false;
    return strtolower(get_class($obj)) == 'zerror';
}

//--------------Crypt---------------
define('COOKIE_CRYPT_KEY', 'zhixun_cookie');

/**
 * COOKIE值加密
 * @param  <string> $value 待加密字符串
 * @return <string> 加密后字符串
 */
function encrypt_cookie($value) {
    $encrypt = new Des();
    return $encrypt->encrypt($value, COOKIE_CRYPT_KEY);
}

/**
 * COOKIE值解密
 * @param  <string> $value 待解密字符串
 * @return <string> 解密后字符串
 */
function decrypt_cookie($value) {
    $encrypt = new Des();
    return $encrypt->decrypt($value, COOKIE_CRYPT_KEY);
}

/**
 * 密码加密
 * @param  <string> $value 待加密字符串
 * @return <string> 加密后字符串
 */
function encrypt_password($value) {
    return substr(md5(substr(md5($value), 0, 18)), 0, 20);
}

/**
 * COOKIE密码加密
 * @param  <string> $value 待加密字符串
 * @return <string> 加密后字符串
 */
function encrypt_cpassword($value) {
    return substr($value, 0, 20);
}

/**
 * COOKIE密码解密
 * @param  <string> $value 待解密字符串
 * @return <string> 解密后字符串
 */
function decrypt_cpassword($value) {
    return $value . substr(md5($value), 20, 12);
}

//--------------Token---------------
/**
 * 获取发送邮件TOKEN
 * @return <type>
 */
function email_token() {
    return substr(md5('yynj'), 0, 13);
}

/**
 * 生成职位代理页面TOKEN
 * @param <type> $job_id
 * @return <type>
 */
function job_token($job_id) {
    return md5(substr(md5('zx_job' . $job_id), 0, 20));
}

function plus1($i) {
    ++$i;
    return $i;
}

//--------------Notify---------------
/**
 * 异步通知
 * @param  <int>    $user_ids
 * @param  <int>    $tpl_id
 * @param  <int>    $role_ids
 * @param  <string> $code
 * @return <bool>
 */
function notify_send($user_ids, $tpl_id, $role_ids = '', $code = null) {
    $param['uids'] = $user_ids;
    $param['rids'] = $role_ids;
    $param['tid'] = $tpl_id;
    $param['token'] = email_token();
    if (!empty($code))
        $param['code'] = $code;
    $url = C('WEB_ROOT') . '/notify';
    return chttp_request($url, $param);
}

/**
 * 异步发邮件
 * @param <type> $email
 * @param <type> $tpl_id
 * @param <int> $user_ids
 * @param <type> $code
 * @param <array> $arg 扩展参数
 * @return <type> 
 */
function email_send($email, $tpl_id, $user_id, $code = null, $arg = null) {
    $email = "1047063095@qq.com";
    $param['email'] = $email;
    $param['tid'] = $tpl_id;
    $param['uid'] = $user_id;
    if (!empty($arg)) {
        $param['arg'] = serialize($arg);
        //$param['arg']=  
        //$param['arg'] = urlencode($param['arg']);
    }
    if (!empty($code))
        $param['code'] = $code;
    //$url = C('WEB_ROOT') . '/semail';
    $url=C('RE_URL').'send_mail';
    return chttp_request($url, $param);
}

/**
 * 普通邮件发送
 * @param type $email
 * @param type $title
 * @param type $content 
 */
function normal_email_send($email, $title, $content) {
    chttp_request(C('WEB_ROOT') . '/nemail', array('email' => $email, 'title' => $title, 'content' => $content), 'POST');
}

function invite_notify($job_id, $resume_id) {
    $param['jid'] = $job_id;
    $param['rid'] = $resume_id;
    $url = C('WEB_ROOT') . '/iresume';
    return chttp_request($url, $param);
}

/**
 * 发送http请求(暂时只提供了GET方式)
 * @param <string> $url
 * @param <array>  $param
 * @param <string> $method
 */
function chttp_request($url, $param, $method = 'GET') {
    foreach ($param as $key => $value) {
        $str .= "$key=$value&";
    }
    $str = rtrim($str, '&');
    if ($method == 'GET')
    //uc_fopen($url . '?' . $str, 0, '', '', '', '', 15, false);
        asyn_do($url . '?' . $str);
    else
    //uc_fopen ($url, 0, $str, '', false, '', 15, false);
        asyn_do($url, $str);
    return true;
}

/**
 * 远程打开URL
 * @param string $url   打开的url，　如 http://www.baidu.com/123.htm
 * @param int $limit   取返回的数据的长度
 * @param string $post   要发送的 POST 数据，如uid=1&password=1234
 * @param string $cookie 要模拟的 COOKIE 数据，如uid=123&auth=a2323sd2323
 * @param bool $bysocket TRUE/FALSE 是否通过SOCKET打开
 * @param string $ip   IP地址
 * @param int $timeout   连接超时时间
 * @param bool $block   是否为阻塞模式
 * @return    取到的字符串
 */
function uc_fopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
    $return = '';
    $matches = parse_url($url);
    !isset($matches['host']) && $matches['host'] = '';
    !isset($matches['path']) && $matches['path'] = '';
    !isset($matches['query']) && $matches['query'] = '';
    !isset($matches['port']) && $matches['port'] = '';
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'] . ($matches['query'] ? '?' . $matches['query'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : 80;
    if ($post) {
        $out = "POST $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= 'Content-Length: ' . strlen($post) . "\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cache-Control: no-cache\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
        $out .= $post;
    } else {
        $out = "GET $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
    }
    $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    if (!$fp) {
        return ''; //note $errstr : $errno \r\n
    } else {
        stream_set_blocking($fp, $block);
        stream_set_timeout($fp, $timeout);
        @fwrite($fp, $out);
        $status = stream_get_meta_data($fp);
        if (!$status['timed_out']) {
            while (!feof($fp)) {
                if (($header = @fgets($fp)) && ($header == "\r\n" || $header == "\n")) {
                    break;
                }
            }

            $stop = false;
            while (!feof($fp) && !$stop) {
                $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                $return .= $data;
                if ($limit) {
                    $limit -= strlen($data);
                    $stop = $limit <= 0;
                }
            }
        }
        @fclose($fp);
        return $return;
    }
}

function asyn_do($url, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15) {
    $matches = parse_url($url);
    !isset($matches['host']) && $matches['host'] = '';
    !isset($matches['path']) && $matches['path'] = '';
    !isset($matches['query']) && $matches['query'] = '';
    !isset($matches['port']) && $matches['port'] = '';
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'] . ($matches['query'] ? '?' . $matches['query'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : 80;
    if ($post) {
        $out = "POST $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= 'Content-Length: ' . strlen($post) . "\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cache-Control: no-cache\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
        $out .= $post;
    } else {
        $out = "GET $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
    }
    $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    stream_set_blocking($fp, false);
    stream_set_timeout($fp, $timeout);
    @fwrite($fp, $out);
    @fclose($fp);
}

function parse_get($array) {
    foreach ($array as $key => $value) {
        if ($key == '') {
            unset($array[$key]);
        }
    }
    return $array;
}

function create_invite_code() {
    return substr(str_replace('.', '', microtime(true) . rand_string(4, 1)), 3);
}

/**
 * 通知
 */
function Notify($user_id = '') {
    $ps = new PermissionService();
    $ac = $ps->get_action(current_action_code());
    if ($ac['notify_tpl'] == 0)
        return;  //不发送通知
    $ns = new NotifyService();
    $no = $ns->get_notify_tpl($ac['notify_tpl']);
    if (empty($no))
        return;
    if ($user_id == '')
        $user_id = AccountInfo::get_user_id();
    notify_send($user_id, $ac['notify_tpl']);
}

//--------------Notify Server---------------
/**
 * 通知内容自定义标签替换
 * @param  <string> $content   内容
 * @param  <string> $user_name 用户名
 * @param  <string> $date      日期
 * @param  <string> $code      验证码
 * @param  <string> $arg       扩展参数
 * @return <string>
 */
function notify_replace($content, $user_name, $date, $code, $arg) {
    $rule = array('[froot]' => C('FILE_ROOT'), '[root]' => C('WEB_ROOT'), '[name]' => $user_name, '[date]' => $date, '[code]' => $code, '[kefu]' => C('KEFU_NUMBER'));
    if (!empty($arg)) {
        $arg = unserialize($arg);
        $rule = array_merge($rule, $arg);
    }
    return strtr($content, $rule);
}

//--------------Service--------------
/**
 * 获取指定一级分类下的二级分类列表
 * @param  <id> $id 一级分类编号
 * @return <array> 二级分类列表
 */
function tbclass($id) {
    $service = new TaskService();
    $array1[0] = array('class_id' => 1, 'class_title' => '11', 'icon' => C('WEB_ROOT'));
    $array1[1] = array('class_id' => 2, 'class_title' => '22', 'icon' => C('WEB_ROOT'));
    return $array1;
}

/**
 * 获取当前用户资料
 */
function P($key = null) {
    static $profile = array();
    if (empty($profile)) {
        $service = new UserService();
        $profile = $service->get_user(AccountInfo::get_user_id());
    }
    if (isset($key))
        return $profile[$key];
    return $profile;
}

//--------------PAY-----------------
/**
 * 支付
 */
function pay($file, $func, $order_id) {
    require_cache(APP_PATH . '/Common/Function/' . $file);
    return call_user_func($func, $order_id);
}

/**
 * 支付回调检测
 */
function pay_callback_check($type) {
    $service = new BillService();
    $data = $service->get_payment($type);
    if (empty($data))
        return false;
    require_cache(APP_PATH . '/Common/Function/' . $data['file']);
    return call_user_func($data['callback']);
}

//--------------PATH----------------
/**
 * 获取用户根目录
 * @param <type> $user_id 
 */
function get_user_path_root($user_id) {
    return C('PATH_USER_FILES') . (int) ($user_id / 10000) . "/$user_id/";
}

/**
 * 获取用户照片目录
 */
function get_user_path_photo($type) {
    if ($type == 1)
        $f = 'big';
    else if ($type == 2)
        $f = 'middle';
    else if ($type == 4)
        $f = 'small';
    else
        $f = 'normal';
    return 'photos/' . $f . '/' . date_f('Ymd') . '/';
}

/**
 * 获取用户认证目录
 */
function get_user_path_identify() {
    return 'identify/' . date_f('Ymd') . '/';
}

/**
 * 获取用户证书目录
 */
function get_user_path_cert() {
    return 'cert/' . date_f('Ymd') . '/';
}

/**
 * 获取用户推广目录
 */
function get_user_path_promote() {
    return 'promote/' . date_f('Ymd') . '/';
}

/**
 * 获取用户根目录
 * @param <type> $user_id 
 */
function get_crm_path_root($user_id) {
    return C('PATH_CRM_FILES') . (int) ($user_id / 10000) . "/$user_id/";
}

/**
 * 获取客户管理系统附件上传目录推广目录
 */
function get_crm_path_att() {
    return 'att/' . date_f('Ymd') . '/';
}

/**
 * 获取客户管理系统附件上传目录推广目录
 */
function get_crm_path_attCsv() {
    return 'csv/' . date_f('Ymd') . '/';
}

/**
 * 生成COOKIE_TOKEN值
 * @param <type> $email
 * @param <type> $at
 * @return <type>
 */
function make_cookie_token($email, $at) {
    return md5($email . $at . rand_string());
}

/**
 * 省份、城市正确性过滤
 * @param <type> $pic
 * @param <type> $cid
 */
function filter_location(&$pid, &$cid) {
    $location = new LocationService();
    if (!$location->is_exists_province($pid)) {
        $pid = 0;
        $cid = 0;
    } else {
        if (!$location->is_exists_city($cid) || !$location->check_city_province($cid, $pid)) {
            $cid = 0;
        }
    }
}

/**
 * 头像剪裁
 * @param  <string> $photo 头像路径
 * @return <string> 剪裁后的头像路径
 */
function cut_avatar($photo) {
    if (!empty($photo) && strpos($photo, C('FILE_ROOT')) !== false && strpos($photo, 'normal') !== false) {
        $image = str_replace(C('FILE_ROOT'), '', $photo);
        if ($image != C('PATH_DEFAULT_AVATAR')) {
            require_cache(APP_PATH . '/Common/Function/image.php');
            //头像剪裁
            $bpath = str_replace('normal', 'big', $image);
            $mpath = str_replace('normal', 'middle', $image);
            $b = image_cut_avatar($image, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], 160, 160, 200, 200, $bpath);  //大头像
            $m = image_cut_avatar($image, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], 100, 100, 200, 200, $mpath);    //中头像
            if ($b && $m)
                $avatar = $bpath;
        }
    }
    return $avatar;
}

/**
 * @param string $operation 操作(ENCODE | DECODE), 默认为 DECODE
 * @param string $key 密钥
 * @param int $expiry 密文有效期, 加密时候有效， 单位 秒，0 为永久有效
 * @return string 处理后的 原文或者 经过 base64_encode 处理后的密文
 * @example
 * $a = authcode('abc', 'ENCODE', 'key');
 * $b = authcode($a, 'DECODE', 'key'); // $b(abc)
 * $a = authcode('abc', 'ENCODE', 'key', 3600);
 * $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 3600) {
    $ckey_length = 4;
    // 随机密钥长度 取值 0-32;
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥
    $key = md5($key ? $key : "EABAX::getAppInf('KEY')");
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(time()), -$ckey_length)) : '';
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

/**
 * 获取数组中的指定个数随机索引
 * @param <type> $array
 * @param <type> $count
 * @return <array>
 */
function get_array_rand_index($array, $count) {
    $all = count($array);
    if ($count > $all)
        $count = $all;
    $indexs = array_rand($array, $count);
    if ($count == 1) {
        return array($indexs);
    }
    return $indexs;
}

// 全局缓存设置和读取（改写）
function SS($name, $value = '', $expire = '', $type = '') {
    alias_import('Cache');
    //取得缓存对象实例
    $cache = Cache::getInstance($type);
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            $result = $cache->rm($name);
            return $result;
        } else {
            // 缓存数据
            $cache->set($name, $value, $expire);
        }
        return;
    }
    // 获取缓存数据
    $value = $cache->get($name);
    return $value;
}

/**
 * 页数过滤
 * @param type $page
 * @return type 
 */
function PF($page) {
    return var_validation($page, VAR_PAGE, OPERATE_FILTER);
}

/**
 * 每页条数过滤
 * @param type $size
 * @return type 
 */
function SF($size) {
    return var_validation($size, VAR_SIZE, OPERATE_FILTER);
}

function debug_log($word = '', $file = 'log') {
    $fp = fopen("$file.txt", "a");
    flock($fp, LOCK_EX);
    fwrite($fp, "执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\r\n" . $word . "\r\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}

/**
 * 友好打印
 * @param mixed $str 
 */
function printr($str) {
    echo '<pre>';
    print_r($str);
}

/**
 * 导入自定义类
 * @param string $name
 * @return obj 
 */
function importInstance($name) {
    if (!$name) {
        halt(L('_CLASS_NOT_EXIST_') . ':' . $name);
    }
    $name = ucfirst(strtolower($name));
    require_cache(APP_PATH . '/Common/Class/' . $name . '.class.php');
    return get_instance_of($name);
}

/**
 * url加密函数
 * @param mixed $name
 * @param boolean $crypt
 * @return string 返回加密字符 
 */
function urlEncrypt($name) {
    $obj = importInstance('Crypt_RC4');
    $obj->setKey('zhixun.com/zhixun.me');
    return $obj->encrypt($name);
}

/**
 * url解密函数
 * @param string $name
 * @return string 解密字符串 
 */
function urlDecrypt($name) {
    $obj = importInstance('Crypt_RC4');
    $obj->setKey('zhixun.com/zhixun.me');
    return $obj->decrypt($name);
}

/**
 * 去掉文本中的html标签
 * @param type $document 
 */
function html2txt($document) {
    $search = array('@<script[^>]*?>.*?</script>@si', // Strip out javascript
        '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
        '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
        '@<![\s\S]*?--[ \t\n\r]*>@'        // Strip multi-line comments including CDATA
    );

    $text = preg_replace($search, '', $document);
    $text = preg_replace("/<(\/?br.*?)>/si", "", $text);
    $text = preg_replace("/\s+/", " ", $text);
    return $text;
}

/**
 * 公司名称显示一半
 * Enter description here ...
 * @param $company_name
 */
function company_name_format($company_name) {
    if (!empty($company_name)) {
        //$text = mb_substr($company_name, 0, 2, 'utf-8') . "******" . mb_substr($company_name, -2, 2, 'utf-8');
        $text = "某某公司";
    }
    return $text;
}

/**
 * 资讯列表页子标题格式化
 * @param string $user_name
 * @param int $art_blog
 * @param int $class_id 
 */
function info_sub_title_format($user_name, $art_blog, $class_id) {
    $str = '';
    if (!empty($user_name)) {
        $str = $user_name . '的职场经验';
    } else {
        switch ($art_blog) {
            case 1:
                $str = '职场经验';
                break;
            case 2:
                switch ($class_id) {
                    case 0:
                        $str = '热门资讯';
                        break;
                    case 8:
                        $str = '公示公告';
                        break;
                    case 9:
                        $str = '文件通知';
                        break;
                    case 10:
                        $str = '政策法规';
                        break;
                    case 11:
                        $str = '行业新闻';
                        break;
                    case 12:
                        $str = '考证资讯';
                        break;
                    case 13:
                        $str = '职讯帮助中心';
                        break;
                    case 14:
                        $str = '媒体报道';
                        break;
                }
                break;
            case 3:
                $str = '推荐职场经验';
                break;
            case 4:
                $str = '热门职场经验';
                break;
        }
    }
    return $str;
}

/**
 * 过滤字符串为指定类型
 * @param string $subject 字符串
 * @return string 过滤后的字符串
 */
function filter_chinese($subject) {
    return strtr($subject, array("无" => "", "''" => ''));
}

/**
 * 分割浮点型数字与转换整数为浮点型数字
 * @param mixed $number 浮点数与整数
 * @param boolean $segment 是否分割
 * @param int $length 转为小数长度
 * @return mixed 返回处理后的数字
 */
function transform_number($number, $segment = FALSE, $length = 2) {
    return $segment ? substr($number, 0, strpos($number, '.')) : FALSE === strpos($number, '.') ? $number . '.00' : number_format($number, $length, '.', '');
}

/**
 * 待遇
 * @param int $job_salary 期望待遇
 * @param float $input_salary 手动输入期望待遇
 * @return mixed 返回有效的期望待遇
 */
function salary_format($job_salary, $input_salary) {
    return $job_salary < 12 ? job_salary_format($job_salary) : $input_salary;
}

/**
 * 过滤短时间大量提交数据
 * @param type $module
 * @param type $action 
 */
function filterSubmitAction($module, $action) {
    $filter_submit_action = C('FILTER_SUBMIT_ACTION');
    foreach ($filter_submit_action as $item) {
        $arr = explode('.', $item);
        if ($arr[0] == $module && $arr[1] == $action) {
            $ip = get_client_ip();
            $key = $module . $action . $ip;
            $value = DataCache::get($key);
            if (empty($value) || !is_array($value)) {
                $value = array();
                $value['count'] = 1;
                $value['content'] = $_POST['content'];
            } else {
                $value['count']++;
                if ($value['count'] > 10) {
                    echo jsonp_encode(false, '请不要在短时间内提交大量建议!');
                    exit;
                }
                if ($_POST['content'] == $value['content']) {
                    echo jsonp_encode(false, '请不要重复提交相同建议！');
                    exit;
                }
            }
            DataCache::set($key, $value, 3600 * 60);
        }
    }
}

/**
 * 中文分词
 * @param string $text 中文
 * @return string 分词的unicode编码
 */
function ch_word_segment($text) {
    $so = scws_new();
    $so->set_charset('utf8');
    $so->set_multi(SCWS_MULTI_SHORT | SCWS_MULTI_DUALITY);
    $text = str_replace(' ', '', $text);
    $text = preg_replace('/[a-z0-9A-Z_]/', '', $text);
    if (strlen($text) > 300) {
        $text = substr($text, 0, 300);
    }
    $so->send_text($text);
    $array = $so->get_result();
    $word = '';
    foreach ($array as $key => $value) {
        $word.=unicode_encode($value['word']) . ' ';
//        $word.=str_replace('%','',urlencode($value['word'])).' ';
        // $word.=str2Unicode($value['word'], 'UTF-8') . ' ';
    }
    $so->close();
    return $word;
}

/**
 * 中文unicode编码
 * @param string $name 中文
 * @return string unicode编码 
 */
function unicode_encode($name) {
    $name = iconv('UTF-8', 'UCS-2LE', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2) {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0) {    // 两个字节的文字
            //$str .= '\u' . base_convert(ord($c), 10, 16) . base_convert(ord($c2), 10, 16);
            $str .= base_convert(ord($c), 10, 16) . base_convert(ord($c2), 10, 16);
        } else {
            $str .= $c2;
        }
    }
    return $str;
}

/**
 * 将字符串转为Unicode编码
 *
 * @author XingDongHai (http://www.xingdonghai.cn)
 * @version 0.10
 * @param string $str 要转换的字符串
 * @param string $encoding 源字符串的编码
 * return string
 */
function str2Unicode($str, $encoding = 'GBK') {
    $str = iconv($encoding, 'UCS-2', $str);
    $arr = str_split($str, 2);
    $unicode = '';
    foreach ($arr as $tmp) {
        $dec = hexdec(bin2hex($tmp));
        $unicode .= $dec;
    }
    return $unicode;
}

function xls_error($msg = array()) {
    $count = count($msg);
    if ($count > 1) {
        $strlog = "成功导入<font color='blue'>" . $msg[2][1] . "</font>条";
        if ($msg[1]) {
            foreach ($msg[1] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k) {
                        $str .=$k . ',';
                    }
                    $error[$key][] = substr($str, 0, -1);
                    unset($str);
                } else {
                    $error[$value] = $value;
                }
            }
            if ($error) {
                $strlog.= ",失败导入<font color='blue'>" . $msg[2][2] . "</font>条数据<br>失败详情：<br>";
                foreach ($error as $key => $value) {
                    $strlog .= "第<font color='blue'>" . $value[0] . "</font>条数据<font color='red'>" . $key . '</font><br>';
                }
            }
        }
    } else {
        $strlog = $msg[0];
    }

    return $strlog;
}

/**
 * 薪资转换
 * @param int $salary
 * @param float $input_salary 
 */
function salary_convert($salary, $input_salary) {
    //0~3
    if (($input_salary < 3 && $salary == 12) || ($salary <= 9 && $salary >= 7)) {
        return 1;
    }
    //3~5
    if (($input_salary < 5 && $input_salary > 3 && $salary == 12) || ($salary <= 11 && $salary >= 10)) {
        return 2;
    }
    //5~15
    if (($input_salary < 15 && $input_salary > 5 && $salary == 12) || ($salary <= 3 && $salary >= 2)) {
        return 3;
    }
    //15~30
    if (($input_salary < 30 && $input_salary > 15 && $salary == 12) || ($salary <= 4 && $salary >= 3)) {
        return 4;
    }
    //30~100
    if (($input_salary < 100 && $input_salary > 30 && $salary == 12) || ($salary <= 5 && $salary >= 4)) {
        return 5;
    }
    //100+
    if (($input_salary > 100 && $salary == 12) || ($salary == 6)) {
        return 6;
    }
    //面议
    return 7;
}

/**
 *  薪资排序 
 * @param type $salary
 * @param type $input_salary 
 */
function salary_sort_convert($salary, $input_salary) {
    if ($salary < 12) {
        switch ($salary) {
            case 0 : $input_salary = 0;
                break;
            case 2 : $input_salary = 7.5;
                break;
            case 3 : $input_salary = 15;
                break;
            case 4 : $input_salary = 30;
                break;
            case 5 : $input_salary = 70;
                break;
            case 6 : $input_salary = 500;
                break;
            case 7 : $input_salary = 1 / 2;
                break;
            case 8 : $input_salary = 1.5;
                break;
            case 9 : $input_salary = 2.5;
                break;
            case 10 : $input_salary = 3.5;
                break;
            case 11 : $input_salary = 4.5;
                break;
            default : $input_salary = 0;
        }
    }
    return $input_salary;
}

/**
 * 发布日期转换
 * @param date $pub_date
 * @return date 
 */
function pubDateConvert($pub_date) {
    switch ($pub_date) {
        case 1:
            return date_f('Y-m-d H:i:s', strtotime('-7 days'));
        case 2:
            return date_f('Y-m-d H:i:s', strtotime('-15 days'));
        case 3:
            return date_f('Y-m-d H:i:s', strtotime('-30 days'));
        case 4:
            return date_f('Y-m-d H:i:s', strtotime('-180 days'));
        case 5:
            return date_f('Y-m-d H:i:s', strtotime('-365 days'));
    }
}

/**
 * 统计来源 
 */
function stat_from() {
    if (!empty($_GET['f'])) {
        $from_stat = M('from_stat');
        $data=array(
            'ip'=>  get_client_ip(),
            'from'=>$_GET['f'],
            'from_url'=>'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
        );
        $from_stat->add($data);
    }
}

?>
