<?php

/**
 * 数据编号
 */
define('VAR_ID', 'ZID');
/**
 * 年份
 */
define('VAR_YEAR', 'YEAR');
/**
 * 第几页
 */
define('VAR_PAGE', 'PAGE');
/**
 * 每页条数
 */
define('VAR_SIZE', 'SIZE');
/**
 * 普通字符串
 */
define('VAR_STRING', 'STRING');
/**
 * 邮箱
 */
define('VAR_EMAIL', 'EMAIL');
/**
 * 手机号码
 */
define('VAR_PHONE', 'PHONE');

/**
 * 检测固定电话是否合法 
 */
define('VAR_FIXED_PHONE', 'FIXED_PHONE');
/**
 * QQ
 */
define('VAR_QQ', 'QQ');
/**
 * 联系方式
 */
define('VAR_CONTACT', 'CONTACT');
/**
 * 密码
 */
define('VAR_PASSWORD', 'PASSWORD');
/**
 * 用户名
 */
define('VAR_USERNAME', 'USERNAME');
/**
 * 角色编号
 */
define('VAR_ROLEID', 'ROLEID');
/**
 * 任务状态
 */
define('VAR_TSTATUS', 'TSTATUS');
/**
 * 任务标题关键字
 */
define('VAR_TLIKE', 'TLIKE');
/**
 * 竞标内容
 */
define('VAR_BCONTENT', 'BCONTENT');
/**
 * 任务内容
 */
define('VAR_TCONTENT', 'TCONTENT');
/**
 * 任务标题
 */
define('VAR_TTITLE', 'TTITLE');
/**
 * 任务天数
 */
define('VAR_TDAYS', 'TDAYS');
/**
 * 客户端IP地址
 */
define('VAR_IP', 'IP');
/**
 * 注册验证码
 */
define('VAR_RVERIFYCODE', 'RVERIFYCODE');
/**
 * 登录验证码
 */
define('VAR_LVERIFYCODE', 'LVERIFYCODE');
/**
 * 单个文件路径
 */
define('VAR_SFILE', 'SFILE');
/**
 * 多个文件路径
 */
define('VAR_MFILE', 'MFILE');
/**
 * 日期
 */
define('VAR_DATE', 'DATE');
/**
 * 性别
 */
define('VAR_GENDER', 'GENDER');
/**
 * 姓名
 */
define('VAR_NAME', 'NAME');
/**
 * 身份证编号
 */
define('VAR_IDNUM', 'IDNUM');
/**
 * 企业名称
 */
define('VAR_ENAME', 'ENAME');
/**
 * 营业执照编号
 */
define('VAR_LNUM', 'LNUM');
/**
 * 组织机构代码
 */
define('VAR_OCODE', 'OCODE');
/**
 * 简介
 */
define('VAR_INTRODUCE', 'INTRODUCE');
/**
 * 工作经验
 */
define('VAR_WEXP', 'WEXP');
/**
 * MD5编码
 */
define('VAR_MD5CODE', 'MD5CODE');
/**
 * 职称等级
 */
define('VAR_GCCLASS', 'GCCLASS');
/**
 * 证书注册情况
 */
define('VAR_CCASE', 'CCASE');
/**
 * 工作状态
 */
define('VAR_JSTATE', 'JSTATE');
/**
 * 薪资
 */
define('VAR_SALARY', 'SALARY');
/**
 * 学历
 */
define('VAR_DEGREE', 'DEGREE');
/**
 * 工作经验
 */
define('VAR_JEXP', 'JEXP');
/**
 * INT型布尔值
 */
define('VAR_BOOL', 'BOOL');
/**
 * 招聘人数
 */
define('VAR_JCOUNT', 'JCOUNT');
/**
 * 社保要求
 */
define('VAR_JSOCIAL', 'JSOCIAL');
/**
 * 工作性质
 */
define('VAR_JCATEGORY', 'JCATEGORY');
/**
 * 职位状态
 */
/**
 * 邮政编码 
 */
define('VAR_ZIP', 'ZIP');
define('VAR_JSTATUS', 'JSTATUS');

define('OPERATE_CHECK', 'CHECK');             //检测操作
define('OPERATE_FILTER', 'FILTER');           //过滤操作

/**
 * 人才简历隐私 
 */
define('VAR_HP_RESUME', 'HP_RESUME');
/**
 * 人才姓名隐私
 */
define('VAR_HP_NAME', 'HP_NAME');
/**
 * 人才生日隐私 
 */
define('VAR_HP_BIRTHDAY', 'HP_BIRTHDAY');
/**
 * 人才联系方式隐私 
 */
define('VAR_HP_CONTACT_WAY', 'HP_CONTACT_WAY');
/**
 * 企业职位隐私 
 */
define('VAR_CP_JOB', 'CP_JOB');
/**
 * 企业名称隐私 
 */
define('VAR_CP_COMPANY_NAME', 'CP_COMPANY_NAME');
/**
 * 企业联系人姓名隐私 
 */
define('VAR_CP_CONTACT_NAME', 'CP_CONTACT_NAME');
/**
 * 企业联系方式隐私 
 */
define('VAR_CP_CONTACT_WAY', 'CP_CONTACT_WAY');
/**
 * 经纪人简历隐私 
 */
define('VAR_AP_RESUME', 'AP_RESUME');
/**
 * 经纪人职位隐私 
 */
define('VAR_AP_JOB', 'AP_JOB');
/**
 * 经纪人姓名隐私 
 */
define('VAR_AP_NAME', 'AP_NAME');
/**
 * 经纪人联系方式隐私 
 */
define('VAR_AP_CONTACT_WAY', 'AP_CONTACT_WAY');
/**
 *  验证网址常量
 */
define('VAR_SITE', 'SITE');

//验证性别
define('VAR_SEX', 'GENDER');

//企业性质格式化
define('VAR_COMPANY_CATEGORY','COMPANY_CATEGORY');

//求职类型
define('VAR_JOB_TYPE','JOB_TYPE');

//企业规模
define('VAR_COMPANY_SCALE','COMPANY_SCALE');

/**
 * 检测人才简历隐私参数是否合法
 * @param type $resume 
 */
function check_hp_resume($resume) {
    if ($resume >= 1 && $resume <= 4)
        return true;
    return false;
}

/**
 * 检测人才姓名隐私参数是否合法
 * @param type $name 
 */
function check_hp_name($name) {
    if ($name >= 1 && $name <= 3)
        return true;
    return false;
}

/**
 * 检测人才生日隐私参数是否合法
 * @param type $birthday 
 */
function check_hp_birthday($birthday) {
    if ($birthday >= 1 && $birthday <= 3)
        return true;
    return false;
}

/**
 * 检测人才联系方式隐私参数是否合法
 * @param type $contact_way 
 */
function check_hp_contact_way($contact_way) {
    if ($contact_way >= 1 && $contact_way <= 2)
        return true;
    return false;
}

/**
 * 检测企业职位隐私参数是否合法
 * @param type $job 
 */
function check_cp_job($job) {
    if ($job >= 1 && $job <= 3)
        return true;
    return false;
}

/**
 * 检测企业名称隐私参数是否合法
 * @param type $company_name 
 */
function check_cp_company_name($company_name) {
    if ($company_name >= 1 && $company_name <= 3)
        return true;
    return false;
}

/**
 * 检测企业联系人姓名隐私参数是否合法
 * @param type $contact_name 
 */
function check_cp_contact_name($contact_name) {
    if ($contact_name >= 1 && $contact_name <= 3)
        return true;
    return false;
}

/**
 * 检测企业联系方式隐私参数是否合法
 * @param type $contact_way 
 */
function check_cp_contact_way($contact_way) {
    if ($contact_way >= 1 && $contact_way <= 2)
        return true;
    return false;
}

/**
 * 检测经纪人简历隐私参数是否合法
 * @param type $resume 
 */
function check_ap_resume($resume) {
    if ($resume >= 1 && $resume <= 3)
        return true;
    return false;
}

/**
 * 检测经纪人职位隐私参数是否合法
 * @param type $job 
 */
function check_ap_job($job) {
    if ($job >= 1 && $job <= 3)
        return true;
    return false;
}

/**
 * 检测经纪人姓名隐私参数是否合法
 * @param type $name 
 */
function check_ap_name($name) {
    if ($name >= 1 && $name <= 3)
        return true;
    return false;
}

/**
 * 检测经纪人联系方式隐私参数是否合法
 * @param type $contact_way 
 */
function check_ap_contact_way($contact_way) {
    if ($contact_way >= 1 && $contact_way <= 2)
        return true;
    return false;
}

/**
 * 参数验证
 * @param  <mixed>  $var     验证参数
 * @param  <string> $type    验证的参数类型
 * @param  <string> $operate 操作类型（验证分为检测和过滤两种操作）
 * @param  <bool>   $none    是否允许空值（针对部分验证可设置此值）
 * @return <mixed> 验证结果
 */
function var_validation($var, $type, $operate = 'CHECK', $none = false) {
    $method = strtolower($operate . '_' . $type);
    return call_user_func($method, $var, $none);
}

/**
 * 检测编号合法性
 * @param  <int> $id 编号
 * @return <bool> 是否合法
 */
function check_zid($id) {
    if (is_numeric($id) && $id >= 0)
        return true;
    return false;
}

/**
 * 检测用户密码合法性
 * @param  <string> $password 用户密码
 * @return <bool> 是否合法
 */
function check_password($password) {
    if (strlen($password) > 5 && strlen($password) <= 31)
        return true;
    return false;
}

/**
 * 检测用户名合法性
 * @param  <string> $username 用户名
 * @return <bool> 是否合法
 */
function check_username($username) {
    if (preg_match(REGULAR_USER_USERNAME, $username) == 1) {
        //不能与手机号码格式一致
        return preg_match(REGULAR_USER_PHONE, $username) != 1;
    }
    return false;
}

/**
 * 检测注册验证码合法性
 * @param  <string> $code 验证码
 * @return <bool> 是否合法
 */
function check_rverifycode($code) {
    if (C('REGISTER_CODE_CS')) {
        $verify = md5($code);
    } else {
        $verify = md5(strtolower($code));
    }
    if ($_SESSION[C('REGISTER_CODE')] == $verify) {
        unset($_SESSION[C('REGISTER_CODE')]);           //使用后清除验证码
        return true;
    }
    return false;
}

/**
 * 检测登录验证码合法性
 * @param  <string> $code 验证码
 * @return <bool> 是否合法
 */
function check_lverifycode($code) {
    if (C('LOGIN_CODE_CS')) {
        $verify = md5($code);
    } else {
        $verify = md5(strtolower($code));
    }
    if ($_SESSION[C('LOGIN_CODE')] == $verify) {
        unset($_SESSION[C('LOGIN_CODE')]);              //使用后清除验证码
        return true;
    }
    return false;
}

/**
 * 检测用户邮箱合法性
 * @param <string> $email 用户邮箱
 * @return <bool> 是否合法
 */
function check_email($email) {
    if (strlen($email) > 50)
        return false;
    return preg_match(REGULAR_USER_EMAIL, $email) == 1;
}

/**
 * 检测手机号码是否合法
 * @param  <string> $phone 手机号码          
 * @return <bool> 是否合法
 */
function check_phone($phone) {
    return preg_match(REGULAR_USER_PHONE, $phone) == 1;
}

/**
 * 检测固定电话是否合法
 * @param <string> $fixed_phone 固定电话
 * @return <bool> 是否合法 
 */
function check_fixed_phone($fixed_phone) {
    return preg_match(REGULAR_FIXED_PHONE, $fixed_phone) == 1;
}

/**
 * 检测角色编号是否合法
 * @param  <type> $role_id 角色编号
 * @return <bool> 是否合法
 */
function check_roleid($role_id) {
    if ($role_id > 999 || $role_id < 0)
        return false;
    $service = new PermissionService();
    return $service->exists_role($role_id);
}

/**
 * 检测年份合法性
 * @param <string> $year 用户邮箱
 * @return <bool> 是否合法
 */
function check_year($year) {
    if (is_numeric($year) && strlen($year) == 4)
        return true;
    return false;
}

/**
 * 检测单个文件路径是否合法
 * @param  <int>  $file 文件路径
 * @param  <bool> $none 是否允许空值
 * @return <bool> 是否合法
 */
function check_sfile($file, $none) {
    if ($none && empty($file))
        return true;
    return preg_match('/^[\w\-\/\.]{3,100}$/', $file) == 1;
}

/**
 * 检测多个文件路径是否合法
 * @param  <int>  $file 文件路径
 * @param  <bool> $none 是否允许空值
 * @return <bool> 是否合法
 */
function check_mfile($file, $none) {
    $array = explode(',', $file);
    foreach ($array as $item) {
        if (!check_sfile($item, $none)) {
            return false;
        }
    }
    return true;
}

/**
 * 检测日期是否合法
 * @param <type> $date
 * @param <type> $none
 * @return <type>
 */
function check_date($date, $none) {
    if ($none && empty($date))
        return true;
    if (!preg_match('/^\d{4}-[01]{1}\d-[0123]{1}\d [01]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/', $date) && !preg_match('/^\d{4}-[01]{1}\d-[0123]{1}\d$/', $date)) {
        return false;
    }
    return true;
}

/**
 * 检测姓名是否合法
 * @param  <string> $name 姓名
 * @return <bool> 是否合法
 */
function check_name($name) {
    //待修改
    $length = strlen($name);
    if ($length < 3 || $length > 20)
        return false;
    return true;
}

/**
 * 检测身份证号码是否合法
 * @param  <string> $num 身份证号码
 * @return <bool> 是否合法
 */
function check_idnum($num) {
    if (!preg_match(REGULAR_IDNUMBER_18, $num) && !preg_match(REGULAR_IDNUMBER_15, $num)) {
        return false;
    }
    return true;
}

/**
 * 检测企业名称是否合法
 * @param  <string> $name 企业名称
 * @return <bool> 是否合法
 */
function check_ename($name) {
    //待修改
    $length = strlen($name);
    if ($length < 3 || $length > 60)
        return false;
    return true;
}

/**
 * 检测营业执照编号是否合法
 * @param  <string> $num 营业执照编号
 * @return <bool> 是否合法
 */
function check_lnum($num) {
    //待修改
    $length = strlen($num);
    if ($length < 3 || $length > 30)
        return false;
    return true;
}

/**
 * 检测组织机构代码是否合法
 * @param  <string> $code 组织机构代码
 * @return <bool> 是否合法
 */
function check_ocode($code) {
    //待修改
    $length = strlen($code);
    if ($length < 3 || $length > 30)
        return false;
    return true;
}

/**
 * 验证是否MD5编码
 * @param  <string> $code 编码
 * @return <bool>
 */
function check_md5code($code) {
    if (!preg_match('/^[A-Za-z0-9]{32}$/', $code))
        return false;
    return true;
}

function check_zip($str) {
    if (preg_match("/^[1-9]\d{5}$/", $str))
        return true;
    return false;
}

/**
 * 验证网址是否有效
 * @param string $website 网址
 * @return boolean 是网站返回真否则返回假
 */
function check_site($website) {
    return strlen($website) > 0 && preg_match("/((^http)|(^https)|(^ftp)|(^mms)):\/\/(\S)+\.(\w)+/i", $website);
}

/**
 * 验证性别是否是有效参数
 * @param int $str 性别参数
 * @return boolean 
 */
function check_gender($str) {
    return $str == 0 || $str == 1 ? TRUE : FALSE;
}

/**
 * 日期格式化
 * @param  <string> $date 日期字符串
 * @param  <bool>   $none 是否允许空值
 * @return <string>
 */
function filter_date($date, $none) {
    if ($none && empty($date))
        return $date;
    if (!preg_match('/^\d{4}-[01]{1}\d-\d{2} [01]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/', $date) && !preg_match('/^\d{4}-[01]{1}\d-\d{2}$/', $date)) {
        if ($none) {
            return null;
        } else {
            return date_f();
        }
    }
    return $date;
}

/**
 * 任务状态过滤
 * @param  <int>  $status
 * @param  <bool> $none 是否允许空值
 * @return <int>
 */
function filter_tstatus($status, $none) {
    if ($none && empty($status))
        return $status;
    switch ($status) {
        case 1 :
        case 2 :
        case 3 : break;
        default : $status = 1;
    }
    return $status;
}

/**
 * 工作经验过滤
 * @param  <int>  $exp
 * @param  <bool> $none 是否允许空值
 * @return <int>
 */
function filter_wexp($exp) {
    switch ($exp) {
        case 1 :
        case 2 :
        case 3 :
        case 4 :
        case 5 : break;
        default : $exp = 1;
    }
    return $exp;
}

/**
 * ID格式化
 * @param  <int>  $id 编号
 * @param  <bool> $none 是否允许空值
 * @return <int>
 */
function filter_zid($id, $none) {
    if ($none && empty($id))
        return $id;
    $id = intval($id);
    if ($id < 1)
        $id = 1;
    return $id;
}

/**
 * PAGE格式化
 * @param  <int> $page 第几页
 * @return <int>
 */
function filter_page($page) {
    $page = intval($page);
    if ($page < 1)
        $page = 1;
    else if ($page > 200)
        $page = 200;
    return $page;
}

/**
 * SIZE格式化
 * @param  <int> $size 第几页
 * @return <int>
 */
function filter_size($size) {
    $size = intval($size);
    if ($size < 1)
        $size = 1;
    else if ($size > 30)
        $size = 30;
    return $size;
}

/**
 * 用户名格式化
 * @param  <string> $username 用户名
 * @return <string>
 */
function filter_username($username) {
    return filter_string($username, 50);
}

/**
 * 用户密码格式化
 * @param  <string> $password 用户密码
 * @return <string>
 */
function filter_password($password) {
    return filter_string($password, 30);
}

/**
 * 任务标题模糊搜索关键字过滤
 * @param  <string> $like 关键字
 * @param  <bool>   $none 是否允许空值
 * @return <string>
 */
function filter_tlike($like, $none) {
    if ($none && empty($like))
        return null;
    return filter_string($like, 100);
}

/**
 * 任务回复内容过滤
 * @param  <string> $content 内容
 * @return <string>
 */
function filter_bcontent($content) {
    return filter_string($content, 1000);
}

/**
 * 任务标题过滤
 * @param  <string> $title 标题
 * @return <string>
 */
function filter_ttitle($title) {
    return filter_string($title, 60);
}

/**
 * 任务内容过滤
 * @param  <string> $content 内容
 * @return <string>
 */
function filter_tcontent($content) {
    return filter_string($content, 1000);
}

/**
 * QQ过滤
 * @param  <string> $qq QQ
 * @return <string>
 */
function filter_qq($qq) {
    if (empty($qq))
        return '';
    $qq = trim($qq);
    $qq = substr($qq, 0, 20);
    return htmlspecialchars($qq);
}

/**
 * IP过滤
 * @param  <string> $ip IP
 * @return <string>
 */
function filter_ip($ip) {
    return filter_string($ip, 30);
}

/**
 * 任务天数过滤
 * @param  <int> $days 天数
 * @return <int>
 */
function filter_tdays($days) {
    if ($days < 1)
        return 1;
    if ($days > 30)
        return 30;
    return intval($days);
}

/**
 * 任务回复内容过滤
 * @param  <string> $contact 内容
 * @return <string>
 */
function filter_contact($contact) {
    if (check_phone($contact) || preg_match('/^[\w\-]{6,30}$/', $contact)) {
        return $contact;
    }
    return '';
}

/**
 * 邮箱格式化
 * @param  <string> $email 邮箱
 * @return <string>
 */
function filter_email($email) {
    if (check_email($email))
        return $email;
    return '';
}

/**
 * 手机式化
 * @param  <string> $phone 手机
 * @return <string>
 */
function filter_phone($phone) {
    if (check_phone($phone))
        return $phone;
    return '';
}

/**
 * 单个文件路径过滤
 * @param  <string> $file 文件路径
 * @return <string>
 */
function filter_sfile($file) {
    if (check_sfile($file, true))
        return $file;
    return '';
}

/**
 * 多个文件路径过滤
 * @param  <string> $file 文件路径
 * @return <string>
 */
function filter_mfile($file) {
    if (check_sfile($file, true))
        return $file;
    return '';
}

/**
 * 性别过滤
 * @param  <int> $gender 性别
 * @return <int>
 */
function filter_gender($gender) {
    if ($gender != 1)
        $gender = 0;
    return intval($gender);
}

/**
 * 简介过滤
 * @param  <string> $introduce 简介
 * @return <string>
 */
function filter_introduce($introduce) {
    return filter_string($introduce, 1000);
}

/**
 * 姓名过滤
 * @param  <string> $name 姓名
 * @return <string>
 */
function filter_name($name) {
    if (!check_name($name)) {
        return '';
    }
    return filter_string($name, 20);
}

/**
 * 企业名称过滤
 * @param  <string> $name 企业名称
 * @return <string>
 */
function filter_ename($name) {
    if (!check_ename($name)) {
        return '';
    }
    return filter_string($name, 60);
}

/**
 * 职称等级过滤
 * @param  <int> $var 职称等级
 * @return <int>
 */
function filter_gcclass($var) {
    switch ($var) {
        case 1 :
        case 2 :
        case 3 : break;
        default : $var = 1;
    }
    return $var;
}

/**
 * 证书注册情况过滤
 * @param  <int> $case 注册情况
 * @return <int>
 */
function filter_ccase($case) {
    switch ($case) {
        case 1 :
        case 2 :
        case 3 : break;
        default : $case = 1;
    }
    return $case;
}

/**
 * 工作状态过滤
 * @param  <int> $state 工作状态
 * @return <int>
 */
function filter_jstate($state) {
    switch ($state) {
        case 1 :
        case 2 :
        case 3 :
        case 4 : break;
        default : $state = 1;
    }
    return $state;
}

/**
 * 薪资过滤
 * @param  <int> $salary 薪资
 * @return <int>
 */
function filter_salary($salary) {
    switch ($salary) {
        case 1 :
        case 2 :
        case 3 :
        case 4 :
        case 5 :
        case 6 :
        case 7 :
        case 8 :
        case 9 :
        case 10 :
        case 11 :
        case 12 : break;
        default : $salary = 0;
    }
    return intval($salary);
}

/**
 * 社保要求过滤
 * @param  <int> $var 社保要求
 * @return <int>
 */
function filter_jsocial($var) {
    switch ($var) {
        case 1 :
        case 2 :
        case 3 : break;
        default : $var = 1;
    }
    return $var;
}

/**
 * 工作经验过滤
 * @param  <int> $exp 工作经验
 * @return <int>
 */
function filter_jexp($exp) {
    switch ($exp) {
        case 1 :
        case 2 :
        case 3 : break;
        default : $exp = 1;
    }
    return $exp;
}

/**
 * 工作性质过滤
 * @param  <int> $category 工作性质
 * @return <int>
 */
function filter_jcategory($category) {
    switch ($category) {
        case 1 :
        case 2 : break;
        default : $category = 1;
    }
    return $category;
}

/**
 * 职位状态过滤
 * @param  <int> $status 职位状态
 * @return <int>
 */
function filter_jstatus($status) {
    switch ($status) {
        case 1 :
        case 2 :
        case 3 :
        case 4 :
        case 5 :
        case 6 : break;
        default : $status = 1;
    }
    return $status;
}

/**
 * BOOL过滤
 * @param  <int> $bool BOOL
 * @return <int>
 */
function filter_bool($bool) {
    switch ($bool) {
        case 0 :
        case 1 : break;
        default : $bool = 0;
    }
    return $bool;
}

/**
 * 职位需求个数过滤
 * @param  <int> $count 个数
 * @return <int>
 */
function filter_jcount($count) {
    if ($count < 1)
        $count = 1;
    else if ($count > 20)
        $count = 20;
    return $count;
}

/**
 * 字符串格式化
 * @param  <string> $string 字符串
 * @param  <int>    $lengh  最大长度（-1为不限）
 * @return <string>壹贰叁肆伍陆柒捌玖拾零一二三四五六七八九十|[0123456789]{1,30}
 */
function filter_string($string, $lengh = -1) {
    if (empty($string))
        return $string;
    $string = trim($string);
    if ($lengh != -1) {
        $string = str_sub($string, $lengh);
    }
    //$string = preg_replace('/[\x{58F9}\x{58F9}\x{8D30}\x{53C1}\x{8086}\x{4F0D}\x{9646}\x{67D2}\x{634C}\x{7396}\x{62FE}\x{96F6}\x{4E00}\x{4E8C}\x{4E09}\x{56DB}\x{4E94}\x{516D}\x{4E03}\x{516B}\x{4E5D}\x{5341}0123456789]{6,}/u', '***', $string);
    //$string = preg_replace(REGULAR_USER_EMAIL, '***', $string);
    //$string = strtr($string, array('挂靠' => '', '挂证' => ''));
    return htmlspecialchars($string);
}

/**
 * 企业性质格式化
 * @param int $category
 * @return int 
 */
function filter_company_category($category) {
    switch ($category) {
        case 1 :
        case 2 :
        case 3 :
        case 4 :
        case 5 :
        case 6 :
        case 7 :
        case 8 :
        case 9 : break;
        default : $category = 1;
            break;
    }
    return $category;
}

/**
 * 企业规模格式化
 * @param int $company_scale 
 */
function filter_company_scale($company_scale){
        switch ($company_scale) {
        case 1 :
        case 2 :
        case 3 :
        case 4 :
        case 5 :
        case 6 :
        case 7 :
        case 8 : break;
        default : $company_scale = 1;
            break;
    }
    return $company_scale;
}

/**
 * 招聘类型格式化
 * @param int $job_type 招聘类型
 * @return int 
 */
function filter_job_type($job_type){
    switch($job_type){
        case 1:
        case 2:
            break;
        default:$job_type=1;
    }
    return $job_type;
}

/**
 * 参数验证
 * @param <array> $rule 参数验证规则
 * @param <array> $data 参数数组
 * @return <mixed> 成功返回过滤过的数组，失败返回错误信息
 */
function argumentValidate($rule, $data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $argRule = getArgumentRule($key, $rule);
            if (empty($argRule)) {
                continue;
            } else {
                if (array_key_exists('null', $argRule)) {
                    if (is_bool($argRule['null']) && !$argRule['null']) {
                        if (empty($value)) {
                            if ($value !== 0 && $value !== '0') {
                                $msg = $argRule['name'] . '不能为空！';
                                $error = new ZError($msg);
                                return $error;
                            }
                        }
                    }
                }
                if (array_key_exists('filter', $argRule)) {
                    $data[$key] = var_validation($value, $argRule['filter'], OPERATE_FILTER);
                }
                if (array_key_exists('check', $argRule)) {
                    if (!empty($value)) {
                        if (!var_validation($value, $argRule['check'], OPERATE_CHECK)) {
                            $msg = $argRule['name'] . '格式错误！';
                            $error = new ZError($msg);
                            return $error;
                        }
                    }
                }
                if (array_key_exists('length', $argRule)) {
                    if (is_int($argRule['length'])) {
                        $data[$key] = filter_string($value, $argRule['length']);
                    }
                }
            }
        }
    }
    return $data;
}

/**
 * 获取参数规则
 * @param <array> $name 参数名称
 * @param <array> $rule 参数规则数组
 * @return <mixed> 成功返回参数规则，失败返回null
 */
function getArgumentRule($name, $rule) {
    foreach ($rule as $key => $value) {
        if ($name == $key) {
            return $value;
        }
    }
    return null;
}

?>
