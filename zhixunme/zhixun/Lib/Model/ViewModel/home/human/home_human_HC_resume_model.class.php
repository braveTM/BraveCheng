<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_human_HC_resume_mode
 *
 * @author JZG
 */
class home_human_HC_resume_model {
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
     * 期望待遇
     * @var <int>
     */
    public $job_salary;

    /**
     * 薪资单位
     * @var <int>
     */
    public $salary_unit;

    /**
     * 期望注册地
     * @var <string>
     */
    public $register_provinces;

    /**
     * 期望注册地省份ID
     * @var <string>
     */
    public $register_province_ids;

    /**
     * 补充说明
     * @var <string>
     */
    public $certificate_remark;

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
