<?php
/**
 * @author wgz
 */

class home_privacy_human_model {
    /**
     * 人才隐私ID	
     * @var <int>
     */
    public $human_privacy_id;
    /**
     * 人才用户ID
     * @var <int>
     */
    public $user_id;
    /**
     * 人才资料ID
     * @var <int>
     */
    public $human_id;
    /**
     * 简历ID	
     * @var <int>
     */
    public $resume_id;
    /**
     *简历（1-企业和经纪人能看，2-经纪人能看，3-企业能看）
     * @var <int>
     */
    public $resume;
    /**
     *生日（1-年月日，2-月日，3-保密）
     * @var <int>
     */
    public $birthday;
    /**
     * 姓名（1-显示真实姓名，2-显示替换姓名）
     * @var <int>
     */
    public $name;
    /**
     * 联系人名称（1-公开，2-不公开）
     * @var <int>
     */
    public $contact_way;
    /**
     * 
     * @var <int>
     */
    public $is_del;		
}