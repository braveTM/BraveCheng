<?php
return array(
    'CACHE_TIME_LONG'          => 864000,                       //长缓存时间
    'CACHE_TIME_NORMAL'        => 86400,                        //普通缓存时间
    'CACHE_TIME_LITTLE'        => 600,                          //稍短缓存时间
    'CACHE_TIME_SHORT'         => 300,                          //较短缓存时间
    'CACHE_TIME_SHORTER'       => 60,                           //短缓存时间

    'SYSTEM_LAST_VISIT'        => 'SYSTEM_LAST_VISIT_',         //用户最后访问时间缓存
    'SYSTEM_ROLE_EXIST'        => 'SYSTEM_ROLE_EXIST_',         //角色存在缓存
    'SYSTEM_ROLE_ITEM'         => 'SYSTEM_ROLE_ITEM_',          //指定角色缓存
    'SYSTEM_ACTION_ITEM'       => 'SYSTEM_ACTION_ITEM_',        //指定操作缓存
    'SYSTEM_PROVINCE_ITEM'     => 'SYSTEM_PROVINCE_ITEM_',      //指定省份缓存
    'SYSTEM_PROVINCE_LIST'     => 'SYSTEM_PROVINCE_LIST',       //省份列表缓存
    'SYSTEM_CITY_ITEM'         => 'SYSTEM_CITY_ITEM_',          //指定城市缓存
    'SYSTEM_CITY_LIST'         => 'SYSTEM_CITY_LIST_',          //指定城市列表缓存
    'SYSTEM_NOTIFY_TPL'        => 'SYSTEM_NOTIFY_TPL_',         //通知模版缓存
    'SYSTEM_PAY_TYPE_LIST'     => 'SYSTEM_PAY_TYPE_LIST',       //支付方式列表缓存
    'SYSTEM_PAY_TYPE_ITEM'     => 'SYSTEM_PAY_TYPE_ITEM_',      //支付方式信息缓存
    'SYSTEM_PERMISSION_ITEM'   => 'SYSTEM_PERMISSION_ITEM_',    //权限关系缓存
    'SYSTEM_TASK_CLASS_A'      => 'SYSTEM_TASK_CLASS_A_',       //指定角色拥有指定操作权限的A级任务分类缓存
    'SYSTEM_TASK_CLASS_B'      => 'SYSTEM_TASK_CLASS_B_',       //指定角色拥有指定操作权限的B级任务分类缓存
    'SYSTEM_TASK_CLASS'        => 'SYSTEM_TASK_CLASS_',         //任务分类缓存
    'SYSTEM_PER_T_CLASS_ITEM'  => 'SYSTEM_PER_T_CLASS_ITEM_',   //指定角色是否拥有指定类别的指定操作权限缓存
    'SYSTEM_SLIDE_LIST'        => 'SYSTEM_SLIDE_LIST_',         //指定位置的幻灯片列表缓存
    'SYSTEM_ARTICLE_CLASS'     => 'SYSTEM_ARTICLE_CLASS_',      //指定父编号文章分类缓存
    'SYSTEM_LABEL_LIST'        => 'SYSTEM_LABEL_LIST_',         //角色标签列表缓存
    'SYSTEM_USER_LABEL'        => 'SYSTEM_USER_LABEL_',         //指定用户标签列表缓存
    'SYSTEM_LABEL_ITEM'        => 'SYSTEM_LABEL_ITEM_',         //指定标签信息缓存
    'SYSTEM_LABEL_FL_GROUP'    => 'SYSTEM_LABEL_FL_GROUP_',     //用户标签首字母分组列表缓存
    'SYSTEM_TASK_SUBCLASS'     => 'SYSTEM_TASK_SUBCLASS',       //任务所有二级分类列表缓存
    'SYSTEM_PACKAGE_ITEM'      => 'SYSTEM_PACKAGE_ITEM_',       //指定套餐信息缓存
    'SYSTEM_PACKAGE_LIST'      => 'SYSTEM_PACKAGE_LIST_',       //指定套餐列表缓存
    'SYSTEM_BANK_LIST'         => 'SYSTEM_BANK_LIST',           //指定银行列表缓存
    'SYSTEM_SERVICE_ITEM'      => 'SYSTEM_SERVICE_ITEM_',       //指定服务信息缓存
    'SYSTEM_SERVICE_LIST'      => 'SYSTEM_SERVICE_LIST_',       //指定服务信息缓存列表
    'SYSTEM_CERTIFICATE_ITEM'  => 'SYSTEM_CERTIFICATE_ITEM_',   //指定证书信息缓存

    'USER_PROFILE_ITEM'        => 'USER_PROFILE_ITEM_',         //指定用户资料缓存
    'USER_UNREAD_MESSAGE'      => 'USER_UNREAD_MESSAGE_',       //指定用户未读信息数量缓存
    'USER_INBOX_MESSAGE_INDEX' => 'USER_INBOX_MESSAGE_INDEX_',  //指定用户收件箱首页列表缓存
    'USER_OUTBOX_MESSAGE_INDEX'=> 'USER_OUTBOX_MESSAGE_INDEX_', //指定用户发件箱首页列表缓存
    'USER_MESSAGE_ITEM'        => 'USER_MESSAGE_ITEM_',         //指定信息缓存
    'USER_RESOURCE_LIST'       => 'USER_RESOURCE_LIST_',        //资源库列表缓存
    'USER_TASK_ITEM'           => 'USER_TASK_ITEM_',            //任务信息缓存
    'USER_TASK_TOP'            => 'USER_TASK_TOP_',             //任务信息缓存
    'USER_REMIND'              => 'USER_REMIND_',               //用户提醒缓存
    'USER_LONG_CONN'           => 'USER_LONG_CONN_',            //用户长连接缓存
    'USER_BY_EMAIL'            => 'USER_BY_EMAIL_',             //根据邮箱获取用户信息
);

?>
