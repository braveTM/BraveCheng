<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_human_resume_model
 *
 * @author JZG
 */
class home_human_resume_model {
    //put your code here
    
    /**
     * 简历ID
     * @var <int>
     */
    public $resume_id;

    /**
     * 人才信息
     * @var <home_human_profile_model>
     */
    public $human;

    /**
     * 求职意向
     * @var <home_human_jobIntent_model>
     */
    public $job_intent;

     /**
      * 学历
      * @var <home_human_degree_model>
      */
    public $degree;

    /**
     * 注册证书列表
     * @var <home_human_register_certificate_model>
     */
    public $register_certificate_list;

    /**
     * 职称证书
     * @var <home_human_grade_certificate_model>
     */
    public $grade_certificate;

    /**
     * 证书备注信息
     * @var <string>
     */
    public $certificate_remark;

    /**
     * 工作经历列表
     * @var <home_human_workExp_model>
     */
    public $work_exp_list;

    /**
     * 工程业绩列表
     * @var <home_human_projectAchievement_model>
     */
    public $project_achievement_list;

    /**
     * 代理人ID
     * @var <int>
     */
    public $agent_id;

    /**
     * 发布人ID
     * @var <int>
     */
    public $publisher_id;

    /**
     * 工作性质
     * @var <int>
     */
    public $job_category;

    /**
     * 简历状态（1-未委托、未公开，2-未委托、已公开，3-已委托、未公开，4-已委托、已公开）
     * @var <int>
     */
    public $resume_status;
}
?>
