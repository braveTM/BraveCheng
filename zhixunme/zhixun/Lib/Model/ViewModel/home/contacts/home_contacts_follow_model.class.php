<?php
/**
 * Description of home_contacts_follow_model
 *
 * @author moi
 */
class home_contacts_follow_model {
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
     * 用户类型
     * @var <int>
     */
    public $type;

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
     * 简介
     * @var <string>
     */
    public $summary;

    /**
     * 地区
     * @var <string>
     */
    public $location;

    /**
     * 活跃度
     * @var <string>
     */
    public $active;

    /**
     * 所属公司
     * @var <string>
     */
    public $company;

    /**
     * 证书
     * @var <array>
     */
    public $certs;
}
?>
