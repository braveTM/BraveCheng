<?php
/**
 * @author wgz
 */

class home_privacy_agent_model {
    /**
     * 经纪人隐私ID
     * @var <int>
     */
    public $agent_privacy_id;
    /**
     * 经纪人用户ID
     * @var <int>
     */
    public $user_id;
    /**
     * 经纪人资料ID
     * @var <int>
     */
    public $agent_id;
    /**
     *简历（1-企业和经纪人能看，2-经纪人能看，3-企业能看）
     * @var <int>
     */
    public $resume;
    /**
     *职位（1-人才和经纪人能看，2-经纪人能看，3-人才能看）
     * @var <int>
     */
    public $job;
    /**
     * 姓名（1-显示真实姓名，2-显示替换姓名）
     * @var <int>
     */
    public $name;
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