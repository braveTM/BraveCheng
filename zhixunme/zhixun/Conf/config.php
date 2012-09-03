<?php
return array(
    //'配置项'=>'配置值'

    /*其它设置*/
    'APP_DEBUG'              => false,       // 是否开启调试模式
    'URL_MODEL'              => 2,           // URL模式
    'URL_PATHINFO_MODEL'     => 2,           // 智能模式
    'URL_CASE_INSENSITIVE'   => false,       // URL地址是否不区分大小写
    'URL_PATHINFO_DEPR'      => '/',         // PATHINFO模式下，各参数之间的分割符号
    'URL_ROUTER_ON'          => true,        // 是否开启URL路由
    'TMPL_TEMPLATE_SUFFIX'   => '.php',      // 默认模板文件后缀
    'TMPL_VAR_IDENTIFY'      => 'obj',       // 模板变量识别。留空自动判断,参数为'obj'则表示对象
    'PAGE_LISTROWS'          => 100,         // 默认分页每页显示记录数

    /* 数据库设置 */
    'DB_TYPE'                => 'mysqli',    // 数据库类型
    'DB_HOST'                => 'localhost', // 服务器地址
    'DB_NAME'                => 'zhixun',    // 数据库名
    'DB_USER'                => 'root',      // 用户名
    'DB_PWD'                 => '',    // 密码
    'DB_PORT'                => 3306,        // 端口
    'DB_PREFIX'              => 'zx_',       // 数据库表前缀
    'DB_SUFFIX'              => '',          // 数据库表后缀
    'DB_FIELDTYPE_CHECK'     => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'        => true,        // 启用字段缓存
    'DB_CHARSET'             => 'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'         => 0,           // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'         => false,       // 数据库读写是否分离 主从式有效

    /*推荐引擎配置*/
    //'RE_URL'                 => 'http://192.168.0.105:8888/recommenderEngine/',   //推荐引擎URL地址
    'RE_SIZE'                => 100,         //推荐默认条数
    //'RE_ENABLED'             => false,       //是否启用推荐引擎
    
    /* 数据缓存设置 */
    'LIST_CACHE_TIME'        => 3600,        // 列表数据缓存有效期
    'DATA_CACHE_TIME'	     => 864000,      // 数据缓存有效期
    'DATA_CACHE_COMPRESS'    => false,       // 数据缓存是否压缩缓存
    'DATA_CACHE_CHECK'       => false,       // 数据缓存是否校验缓存
    'DATA_CACHE_TYPE'        => 'File',       // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite| Xcache|Apachenote|Eaccelerator
    'DATA_CACHE_PATH'        => TEMP_PATH,   // 缓存路径设置 (仅对File方式缓存有效)
    'DATA_CACHE_SUBDIR'      => true,        // 使用子目录缓存 (自动根据缓存标识的哈希创建子目录)
    'DATA_PATH_LEVEL'        => 3,           // 子目录缓存级别

    /* 分组设置 */
    'DEFAULT_GROUP'          => 'Home',      // 默认分组
    'APP_GROUP_LIST'         => 'Home,Aiiao,Crm,Special',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
    'DEFAULT_MODULE'         => 'Index',     // 默认模块名称
    'DEFAULT_ACTION'         => 'index',     // 默认操作名称

    /* COOKIE设置 */
    'COOKIE_TIME'            => 86400,       //cookie过期时间
    'COOKIE_LONG_TIME'       => 1209600,     //cookie过期时间
    'COOKIE_DOMAIN'          => '',          //cookie域名
    'COOKIE_PATH'            => '/',         //cookie路径

    /* 网站设置 */
    'WEB_NAME'               => '职讯网',      //网站名称
    'SYSTEM_MESSAGE_NAME'    => '系统消息',    //系统发件人名称
    'WEB_ROOT'               => 'http://zx.me',          //网站根目录
    'FILE_ROOT'              => 'http://zx.me/',         //文件根目录
    'EMAIL_HOST'             => 'localhost',                    //发送邮件主机
//    'ERROR_PAGE'             => 'http://localhost/zxtrunk/zx/error',  //错误定向页面
    'PERFECT_PAGE'           => '/perfect',                         //资料完善页面
    'MEMBER_PAGE'            => '/member',                          //会员服务页面

    'KEFU_NUMBER'            => '4008008820',                       //网站客服电话

    'PASS_RESET_TPL'        => 1,                                   //重设密码模版
    'EMAIL_AUTH_TPL'         => 2,                                  //邮箱认证激活模版
    'EMAIL_ACTIVE_TPL'       => 3,                                  //帐号的邮箱激活模版

    //发送邮件配置
    'ADMIN_EMAIL'           => '357028248@qq.com',  //发件人邮箱
    'ADMIN_USER'            => '357028248@qq.com',  //发件人用户名
    'ADMIN_PASSWORD'        => 'ytlwxhn',   //发件人密码
    'SEND_NAME'             => '职讯网',           //发件人昵称
    'RECEIVE_NAME'          => '尊敬的职讯网用户',  //收件人昵称

    'CHARSET'               => 'UTF-8',            //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    'SMTPAUTH'              => true,               // 启用 SMTP 验证功能
    'SMTPSECURE'            => 'ssl',              // 安全协议
    'SMTPHOST'              => 'smtp.qq.com',      //SMTP服务器
    'SMTPPORT'              => 465,                // SMTP服务器的端口号

    //文件上传配置
    'IMAGE_MAX_SIZE'        => 5000000,            //图片类文件允许上传的最大大小
    'IMAGE_ALLOW_EXTS'      => array('jpg', 'png', 'gif'),            //图片类文件允许上传的文件后缀
    'IMAGE_ALLOW_TYPES'     => array('image/jpg','image/jpeg','image/png','image/gif','image/pjpeg'), //图片类文件允许上传的文件类型
    'IMAGE_NORMAL_MAX_W'    => 500,
    'IMAGE_NORMAL_MAX_H'    => 500,

    //头像大小设置
    'IMAGE_BIG_WIETH'    => 200,    //大头像宽度
    'IMAGE_BIG_HEIGTH'   => 200,    //大头像高度
    'IMAGE_SMALL_WIETH'  => 60,     //小头像宽度
    'IMAGE_SMALL_HEIGTH' => 60,     //小头像高度
    

    //权限相关设置
    'TASK_SCAN_CHECK'       => false,              //是否开启任务浏览检测

    'ROLE_TALENTS'          => 1,                  //人才角色编号
    'ROLE_ENTERPRISE'       => 2,                  //企业角色编号
    'ROLE_AGENT'            => 3,                  //代理角色编号
    'ROLE_SUBCONTRACTOR'    => 4,                  //分包商角色编号
    
    'ROLE_PACKAGE_1'        => 101,                //人才基本套餐编号
    'ROLE_PACKAGE_2'        => 201,                //企业基本套餐编号
    'ROLE_PACKAGE_3'        => 301,                //代理基本套餐编号
    'ROLE_PACKAGE_4'        => 401,                //分包商基本套餐编号
    
    'ROLE_PUBLIC'           => 1000,               //公共角色（用于获取无需认证的操作）
    'ROLE_ANONYMOUS'        => 1001,               //匿名角色
    'ROLE_NOACTIVATION'     => 1002,               //未激活角色（登录用户，但未激活）

    'LOGIN_PROMPT'          => '请先登录',          //未登录用户操作提示
    'PERMISSION_PROMPT'     => '对不起，您的权限不足', //注册用户操作提示

    //收费相关
    'IS_FREE'               => true,               //是否免费模式

    //幻灯片设置
    'INDEX_TOP_LID'         => 1,                  //首页头部幻灯片位置编号

    //验证码设置
    'REGISTER_CODE'         => 'zx_register_code', //注册验证码
    'REGISTER_CODE_CS'      => false,              //注册验证码是否大小写敏感
    'LOGIN_CODE'            => 'zx_login_code',    //登录验证码
    'LOGIN_CODE_CS'         => false,              //登录验证码是否大小写敏感

    //路径设置
    'PATH_SYSTEM_PHOTO'     => 'Files/system/photo/system.png',   //系统头像路径
    'PATH_SYSTEM_FILES'     => 'Files/system/',   //系统文件路径
    'PATH_USER_FILES'       => 'Files/user/',     //用户文件路径
    'PATH_DEFAULT_AVATAR'   => 'Files/system/photo/user/big/default.png',//用户默认头像路径
    'PATH_CRM_FILES'        => 'Files/crm/',      //csv文件上传路径

    //每页条数设置
    'SIZE_BILL_RECORD'      => 15,                 //账单明细条数
    'SIZE_UNREAD_MESSAGE'   => 5,                  //未读信息条数
    'SIZE_MESSAGE'          => 15,                 //站内信列表条数
    'SIZE_MESSAGE_LESS'     => 5,                  //少量站内信列表条数
    'SIZE_U_TASK_SCAN'      => 5,                  //个人首页最近浏览列表条数
    'SIZE_PROMOTE_ADMIN'    => 5,                  //推广位列表条数
    'SIZE_JOB_RESUME'       => 5,                  //职位下的简历列表条数
    'SIZE_JOBS'             => 6,                  //职位列表条数
    'SIZE_JOBS_SIMPLE'      => 10,                 //简单职位列表条数
    'SIZE_FOLLOW'           => 8,                  //关注列表条数

    //职位
    'JOB_CATEGORY_FULL'     => 1,                   //全职
    'JOB_CATEGORY_PART'     => 2,                   //兼职

    //提醒设置
    'REMIND_FOLLOWED'       => 'followed',      //被关注
    'REMIND_MESSAGE'        => 'message',       //新消息
    'REMIND_YPRESUME'       => 'ypresume',      //简历应聘
    'REMIND_EYPRESUME'      => 'eypresume',     //企业的简历应聘
    'REMIND_INVITE'         => 'invite',        //简历邀请
    'REMIND_RAGENT'         => 'ragent',        //简历委托
    'REMIND_JAGENT'         => 'jagent',        //职位委托
    'REMIND_EDJOB'          => 'edjob',         //取消委托职位
    'REMIND_EDRESUME'       => 'edresume',      //取消委托简历

    //通知模版设置
    'NOTIFY_REAL_FAIL'      => 8,               //实名认证失败
    'NOTIFY_REAL_SUC'       => 9,               //实名认证成功
    'NOTIFY_CERT_FAIL'      => 11,              //证书认证失败
    'NOTIFY_CERT_SUC'       => 10,              //证书认证成功
    'NOTIFY_RECHARGE'       => 12,              //职讯网充值成功
    'NOTIFY_BLOG_FAIL'      => 15,              //心得认证失败
    'NOTIFY_BLOG_SUC'       => 16,              //心得认证成功
    
    //推广位配置
    'COMPANY_WALL'          => 1,                   //企业品牌墙
    'COMPANY_WALL_COUNT'    => 15,                  //企业品牌墙个数
    'INDEX_RHUMAN'          => 2,                   //首页人才推荐
    'INDEX_RCOMPANY'        => 3,                   //首页企业推荐
    'INDEX_RAGENT'          => 4,                   //首页经纪人推荐

    //推广服务配置
    'PROMOTE_JOB_NORMAL'        => 1,               //职位普通推广
    'PROMOTE_JOB_INDEX'         => 2,               //职位首页推广
    'PROMOTE_RESUME_NORMAL'     => 3,               //简历普通推广
    'PROMOTE_RESUME_INDEX'      => 4,               //简历首页推广
    'PROMOTE_COMPANY_NORMAL'    => 7,               //企业普通推广
    'PROMOTE_COMPANY_INDEX'     => 8,               //企业首页推广
    'PROMOTE_AGENT_NORMAL'      => 9,               //经纪人普通推广
    'PROMOTE_AGENT_INDEX'       => 10,              //经纪人首页推广

    //支付宝配置
    'ALIPAY_CONFIG'         => array(
        'partner'           => '2088701712331155',
        'key'               => '8219jrwwd8yduu2t61pvvsgu2umbshbn',
        'seller_email'      => 'zhixunco@gmail.com',
        'return_url'        => 'http://127.0.0.1/zhixun/pay_callback',
        'notify_url'        => 'http://127.0.0.1/zhixun/pay_callback',
        'sign_type'         => 'MD5',
        'input_charset'     => 'utf-8',
        'transport'         => 'https'
    ),
    
    'AUTH_BANK_OK'          =>  'Files/system/auth/car.png',
    'AUTH_BANK_NO'          =>  'Files/system/auth/gcar.png',
    'AUTH_EMAIL_OK'         =>  'Files/system/auth/mes.png',
    'AUTH_EMAIL_NO'         =>  'Files/system/auth/gmes.png',
    'AUTH_PHONE_OK'         =>  'Files/system/auth/pho.png',
    'AUTH_PHONE_NO'         =>  'Files/system/auth/gpho.png',
    'AUTH_REAL_OK'          =>  'Files/system/auth/nam.png',
    'AUTH_REAL_NO'          =>  'Files/system/auth/gnam.png',

    'INRE_PREFIX'           => '001_',              //邀请简历KEY前缀

    'REGISTER_CERTIFICATE'  =>1,                //注册证书
    'GRADE_CERTIFICATE'     =>2,                //职称证书
);
?>
