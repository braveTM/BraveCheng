<?php
/**
 * Description of lib_resource_list_model
 *
 * @author moi
 */
class home_lib_resource_model {
    /**
     * 编号
     * @var <int>
     */
    public $id;

    /**
     * 名称
     * @var <string>
     */
    public $name;

    /**
     * 头像
     * @var <string>
     */
    public $photo;

    /**
     * 简介
     * @var <string>
     */
    public $summary;

    /**
     * 省份
     * @var <string>
     */
    public $province;

    /**
     * 城市
     * @var <string>
     */
    public $city;

    /**
     * 信誉度等级图标
     * @var <string>
     */
    public $credit_icon;
    
    /**
     * 信誉度等级描述
     * @var <string>
     */
    public $credit_alt;

    /**
     * 实名认证
     * @var <string> 
     */
    public $auth_real;

    /**
     * 手机认证
     * @var <string>
     */
    public $auth_phone;

    /**
     * 邮箱认证
     * @var <string>
     */
    public $auth_email;

    /**
     * 银行认证
     * @var <string>
     */
    public $auth_bank;

    /**
     * 链接地址
     * @var <string>
     */
    public $url;

    /**
     * 标签
     * @var <array>
     */
    public $labels;
}
?>
