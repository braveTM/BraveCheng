<?php
/**
 * Description of home_agent_detail_model
 *
 * @author moi
 */
class home_agent_detail_model {
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
     * 所属地区
     * @var <int>
     */
    public $location;

    /**
     * 所属公司
     * @var <string>
     */
    public $company;

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
     * 服务类别
     * @var <string>
     */
    public $service;

    /**
     * 活跃度
     * @var <int>
     */
    public $activity;

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
