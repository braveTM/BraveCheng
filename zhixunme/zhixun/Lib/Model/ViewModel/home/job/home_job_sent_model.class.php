<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_job_sent_model
 *
 * @author JZG
 */
/**
 * 应聘过的职位
 */
class home_job_sent_model {
    /**
     * ID
     * @var <int>
     */
    public $id;

    /**
     * 职位ID
     * @var <int>
     */
    public $job_id;

    /**
     * 发布人ID
     * @var <int>
     */
    public $publisher_id;

    /**
     * 发布人头像
     * @var <string>
     */
    public $publisher_photo;

    /**
     * 发布人姓名
     * @var <string>
     */
    public $publisher_name;

    /**
     * 发布人角色
     * @var <int>
     */
    public $publisher_role;

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
     * 发布人实名认证图片地址
     * @var <string>
     */
    public $publisher_auth_real;

    /**
     * 工作性质
     * @var <int>
     */
    public $job_category;

    /**
     * 职位标题
     * @var <string>
     */
    public $job_title;

    /**
     * 企业名称
     * @var <string>
     */
    public $company_name;

    /**
     * 证书使用地省份编号
     * @var <int>
     */
    public $C_use_place;

    /**
     * 地区要求（以“,”分隔的省份编号字符串）
     * @var <string>
     */
    public $require_place;

    /**
     * 招聘要求的注册证书列表
     * @var <home_human_register_certificate_model>
     */
    public $RC_list;

    /**
     * 职位名称
     * @var <string>
     */
    public $job_name;

    /**
     * 招聘人数（全职）
     * @var <int>
     */
    public $job_count;

    /**
     * 工作地点省份编号
     * @var <int>
     */
    public $job_province_code;

    /**
     * 工作地点城市编号
     * @var <int>
     */
    public $job_city_code;

    /**
     * 学历要求
     * @var <string>
     */
    public $degree;

    /**
     * 薪资
     * @var <int>
     */
    public $job_salary;

    /**
     * 薪资单位
     * @var <int>
     */
    public $salary_unit;

    /**
     * 投递时间
     * @var <datetime>
     */
    public $send_datetime;
}
?>
