<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_interested_company_model
 *
 * @author JZG
 */
class home_interested_company_model {
    //put your code here
    /**
     * 用户ID
     * @var <int>
     */
    public $user_id;

    /**
     * 用户头像
     * @var <string> 
     */
    public $user_photo;

    /**
     * 联系人名称
     * @var <string>
     */
    public $name;

    /**
     * 用户实名认证图片地址
     * @var <string>
     */
    public $user_auth_real;

    /**
     * 用户邮箱认证图片地址
     * @var <string>
     */
    public $user_auth_email;

    /**
     * 用户手机认证图片地址
     * @var <string>
     */
    public $user_auth_phone;

    /**
     * 企业名称
     * @var <string>
     */
    public $company_name;

    /**
     * 企业简介
     * @var <string>
     */
    public $company_introduce;

    /**
     * 企业注册地省份编号
     * @var <int>
     */
    public $company_province_code;

    /**
     * 企业注册地城市编号
     * @var <int>
     */
    public $company_city_code;

    /**
     * 企业所在地区
     * @var <string>
     */
    public $location;
}
?>
