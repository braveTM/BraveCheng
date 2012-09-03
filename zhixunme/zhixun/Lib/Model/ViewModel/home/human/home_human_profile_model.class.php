<?php
/**
 * Description of home_human_profile_model
 *
 * @author moi
 */
class home_human_profile_model {
    /**
     * 资料编号
     * @var <int>
     */
    public $id;

    /**
     * 用户编号(为0表示私有人才）
     * @var <int>
     */
    public $user_id;

    /**
     * 姓名
     * @var <string>
     */
    public $name;

    /**
     * 性别
     * @var <int>
     */
    public $gender;

    /**
     * 生日
     * @var <string>
     */
    public $birth;

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
     * 头像
     * @var <string>
     */
    public $photo;

    /**
     * 工作年限
     * @var <array>
     */
    public $exp;

    /**
     * 居住地
     * @var <string>
     */
    public $addr;

    /**
     * 是否实名认证
     * @var <int>
     */
    public $real_auth;

    /**
     * 实名认证图片地址
     * @var <string>
     */
    public $real_auth_path;

    /**
     * 是否手机认证
     * @var <int>
     */
    public $phone_auth;

    /**
     * 手机认证图片地址
     * @var <string>
     */
    public $phone_auth_path;

    /**
     * 是否邮箱认证
     * @var <int>
     */
    public $email_auth;

    /**
     * 邮箱认证图片地址
     * @var <string>
     */
    public $email_auth_path;
}
?>
