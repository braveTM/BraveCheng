<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_user_profiles_model
 *
 * @author hp
 */
class home_user_profiles_model {
    /**
     * 用户编号
     * @var <int>
     */
    public $id;

    /**
     * 用户名
     * @var <string>
     */
    public $name;

    /**
     * 用户昵称
     * @var <string>
     */
    public $nick;

    /**
     * 用户头像
     * @var <string>
     */
    public $photo;

    /**
     * 简介
     * @var <string>
     */
    public $summary;

    /**
     * 经历
     * @var <string>
     */
    public $experience;

    /**
     * 生日——年
     * @var <int>
     */
    public $date_y;

    /**
     * 生日——月
     * @var <int>
     */
    public $date_m;

    /**
     * 生日——日
     * @var <int>
     */
    public $date_d;

    /**
     * 性别
     * @var <int>
     */
    public $gender;

    /**
     * 用户类型
     * @var <int>
     */
    public $user_type;

    /**
     * 联系方式
     * @var <string>
     */
    public $contact;

    /**
     * QQ
     * @var <string>
     */
    public $qq;

    /**
     * 省份编号
     * @var <int>
     */
    public $province;

    /**
     * 城市编号
     * @var <int>
     */
    public $city;

    /**
     * 是否实名认证
     * @var <int>
     */
    public $real_auth;

    /**
     * 是否手机认证
     * @var <int>
     */
    public $phone_auth;

    /**
     * 是否邮箱认证
     * @var <int>
     */
    public $email_auth;

    /**
     * 是否银行卡认证
     * @var <int>
     */
    public $bank_auth;
}
?>
