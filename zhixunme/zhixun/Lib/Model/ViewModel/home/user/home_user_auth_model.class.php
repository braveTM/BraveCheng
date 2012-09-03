<?php
/**
 * Description of home_user_auth_model
 *
 * @author moi
 */
class home_user_auth_model {

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
     * 名字
     * @var <string>
     */
    public $name;
    
    /**
     * 编号
     * @var <string>
     */
    public $num;

    /**
     * 手机号码
     * @var <string>
     */
    public $phone;

    /**
     * 邮箱
     * @var <string>
     */
    public $email;

    /**
     * 实名认证图标
     * @var <string>
     */
    public $ricon;

    /**
     * 手机认证图标
     * @var <string>
     */
    public $picon;

    /**
     * 邮箱认证图标
     * @var <string>
     */
    public $eicon;

    /**
     * 是否全部认证
     * @var <int>
     */
    public $all;

    /**
     * 是否全部未认证
     * @var <int>
     */
    public $none;
}
?>
