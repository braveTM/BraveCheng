<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_found_agent_model
 *
 * @author JZG
 */
class home_found_agent_model {
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
     * 经纪人名称
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
     * 经纪人个人简介
     * @var <string>
     */
    public $agent_introduce;

    /**
     * 所在地省份编号
     * @var <int>
     */
    public $addr_province_code;

    /**
     * 所在地城市编号
     * @var <int>
     */
    public $addr_city_code;

    /**
     * 所属公司名称
     * @var <string>
     */
    public $company_name;

    /**
     * 服务列表
     * @var <array>
     */
    public $service_list;

    /**
     * 活跃度
     * @var <string>
     */
    public $activity;
}
?>
