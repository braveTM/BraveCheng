<?php
/**
 * Description of home_company_detail_model
 *
 * @author moi
 */
class home_company_detail_model {
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
     * 企业名称
     * @var <string>
     */
    public $name;

    /**
     * 性质
     * @var <int>
     */
    public $category;

    /**
     * 地点
     * @var <int>
     */
    public $location;

    /**
     * 联系人
     * @var <string>
     */
    public $cname;

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
