<?php
/**
 * Description of home_user_base_model
 *
 * @author moi
 */
class home_user_base_model {
    /**
     * 用户编号
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
