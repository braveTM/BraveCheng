<?php
/**
 * Description of home_agent_profile_model
 *
 * @author moi
 */
class home_agent_profile_model {
    /**
     * 资料编号
     * @var <int>
     */
    public $id;

    /**
     * 用户编号
     * @var <int>
     */
    public $user_id;

    /**
     * 名称
     * @var <string>
     */
    public $name;

    /**
     * 性别
     * @var <int>
     */
    public $gender;

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
     * 所属公司
     * @var <string>
     */
    public $company;

    /**
     * 手机
     * @var <string>
     */
    public $phone;

    /**
     * 邮箱
     * @var <string>
     */
    public $email;

    /**
     * QQ
     * @var <string>
     */
    public $qq;

    /**
     * 简介
     * @var <string>
     */
    public $summary;

    /**
     * 头像
     * @var <string>
     */
    public $photo;

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
}
?>
