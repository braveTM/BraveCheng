<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_resume_sent_model
 *应聘来的简历
 * @author JZG
 */
class home_resume_sent_model {
    //put your code here

    /**
     * 投递简历记录ID
     * @var <int>
     */
    public $send_resume_id;

    /**
     * 投递人ID
     * @var <int>
     */
    public $sender_id;

    /**
     * 人才ID
     * @var <int>
     */
    public $human_id;

    /**
     * 简历ID
     * @var <int>
     */
    public $resume_id;

    /**
     * 投递人头像
     * @var <string>
     */
    public $sender_photo;

    /**
     * 投递人姓名
     * @var <string>
     */
    public $sender_name;

    /**
     * 投递人角色
     * @var <int>
     */
    public $sender_role;

    /**
     * 实名认证图片地址
     * @var <string>
     */
    public $is_auth_real;

    /**
     * 邮箱认证图片地址
     * @var <string>
     */
    public $is_auth_email;

    /**
     * 手机认证图片地址
     * @var <string>
     */
    public $is_auth_phone;

    /**
     * 工作性质
     * @var <int>
     */
    public $job_category;

    /**
     * 人才姓名
     * @var <string>
     */
    public $human_name;

    /**
     * 简历投递时间
     * @var <datetime>
     */
    public $send_datetime;

    /**
     * 期望注册地
     * @var <string>
     */
    public $register_place;

    /**
     * 证书情况
     * @var <home_human_register_certificate_model>
     */
    public $RC_list;


    /**
     * 求职岗位
     * @var <string>
     */
    public $job_name;

    /**
     * 期望工作地区
     * @var <string>
     */
    public  $job_addr;

    /**
     * 工作年限
     * @var <string>
     */
    public $work_exp;

    /**
     * 投递状态（0-未查看，1-已查看）
     * @var <int>
     */
    public $send_status;

    /**
     * 期望待遇
     * @var <int>
     */
    public $salary;

    /**
     * 应聘职位
     * @var <string>
     */
    public $job;
}
?>
