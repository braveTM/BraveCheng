<?php
/**
 * @author wgz
 */

class home_privacy_company_model {
    /**
     * 企业隐私ID
     * @var <int>
     */
    public $company_privacy_id;
    /**
     * 用户ID
     * @var <int>
     */
    public $user_id;
    /**
     * 企业资料ID
     * @var <int>
     */
    public $company_id;
    /**
     * 职位（1-人才和经纪人能看，2-经纪人能看，3-人才能看）
     * @var <int>
     */
    public $job;
    /**
     * 企业名称（1-显示真实名称，2-显示替换名称）
     * @var <int>
     */
    public $company_name;
    /**
     * 联系人名称（1-显示真实名称，2-显示替换名称）
     * @var <int>
     */
    public $contact_name;
    /**
     * 联系方式（1-公开，2-不公开）
     * @var <int>
     */
    public $contact_way;
    /**
     * 
     * @var <int>
     */
    public $is_del;
}