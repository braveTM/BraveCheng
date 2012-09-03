<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_recommend_human_model
 *
 * @author JZG
 */
class home_recommend_human_model {
    //put your code here
    /**
     * 简历ID
     * @var <int>
     */
    public $resume_id;

    /**
     * 发布人ID
     * @var <int>
     */
    public $publisher_id;

    /**
     * 发布人姓名
     * @var <string>
     */
    public $publisher_name;

    /**
     * 发布人头像
     * @var <string>
     */
    public $publisher_photo;

    /**
     * 发布人角色
     * @var <string>
     */
    public $publisher_role;

    /**
     * 发布人实名认证图片地址
     * @var <string>
     */
    public $publisher_auth_real;

    /**
     * 发布人邮箱认证图片地址
     * @var <string>
     */
    public $publisher_auth_email;

    /**
     * 发布人手机认证图片地址
     * @var <string>
     */
    public $publisher_auth_phone;

    /**
     * 工作性质(1为全职，2为兼职)
     * @var <int>
     */
    public $job_category;

    /**
     * 人才编号
     * @var <int>
     */
    public $human_id;
    
    /**
     * 人才姓名
     * @var <string>
     */
    public $human_name;

    /**
     * 期望注册地(兼职)
     * @var <string>
     */
    public $register_province_ids;

    /**
     * 人才的注册证书列表
     * @var <home_human_register_certificate_model> 
     */
    public $RC_list;

    /**
     * 求职岗位（全职）
     * @var <string>
     */
    public $job_name;

    /**
     * 人才的工作年限（全职）
     * @var <int>
     */
    public $human_work_age;

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
     * 简历更新时间
     * @var <datetime>
     */
    public $update_datetime;

    /**
     * 工作地点
     * @var <string>
     */
    public $work_addr;
}
?>
