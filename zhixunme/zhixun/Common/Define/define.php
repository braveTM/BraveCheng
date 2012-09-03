<?php
/**
 * 正则-用户名
 */
define('REGULAR_USER_USERNAME', '/^\w{6,16}$/');

/**
 * 正则-手机号码
 */
define('REGULAR_USER_PHONE', '/^1\d{10}$/');

/**
 *正则-固定电话 
 */
define('REGULAR_FIXED_PHONE','/^\d{3,4}-\d{7,8}(-\d{3,4})?$/');
/**
 * 正则-邮箱
 */
define('REGULAR_USER_EMAIL', '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/');

/**
 * 正则-邮箱验证码
 */
define('REGULAR_EMAIL_CODE', '/^[a-zA-Z0-9]{32}$/');

/**
 * 正则-手机验证码
 */
define('REGULAR_PHONE_CODE', '/^[a-zA-Z0-9]{6}$/');

/**
 * 正则-真实姓名
 */
define('REGULAR_REALNAME', '/^[\x{4e00}-\x{9fa5}]{1,30}$/');//?

/**
 * 正则-15位身份证号码
 */
define('REGULAR_IDNUMBER_15', '/^[\d]{15}$/');

/**
 * 正则-18位身份证号码
 */
define('REGULAR_IDNUMBER_18', '/^[\d]{17}[a-zA-Z0-9]{1}$/');

/**
 * 领域模型目录
 */
define('DOMAINMODEL_PATH', APP_PATH.'/Lib/Domain/DomainModel');

/**
 * 服务接口目录
 */
define('ISERVICE_PATH', APP_PATH.'/Lib/Interface/ServiceInterface');

/**
 * 业务接口目录
 */
define('IDOMAIN_PATH', APP_PATH.'/Lib/Interface/DomainInterface');

/**
 * 数据提供接口目录
 */
define('IPROVIDER_PATH', APP_PATH.'/Lib/Interface/ProviderInterface');
?>
