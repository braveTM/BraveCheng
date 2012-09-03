<?php
/**
 * Description of home_job_detail_model
 *
 * @author moi
 */
class home_job_detail_model {
    /**
     * 职位编号
     * @var <int>
     */
    public $id;

    /**
     * 招聘标题
     * @var <string>
     */
    public $title;

    /**
     * 招聘企业
     * @var <string>
     */
    public $company;

    /**
     * 职位性质
     * @var <int>
     */
    public $category;

    /**
     * 工作状态
     * @var <int>
     */
    public $state;

    /**
     * 职位名称
     * @var <string>
     */
    public $name;

    /**
     * 学历要求
     * @var <string>
     */
    public $degree;

    /**
     * 招聘人数
     * @var <int>
     */
    public $count;

    /**
     * 工作地点
     * @var <string>
     */
    public $location;

    /**
     * 地区要求
     * @var <string>
     */
    public $place;

    /**
     * 薪资
     * @var <string>
     */
    public $salary;

    /**
     * 证书
     * @var <array>
     */
    public $cert;

    /**
     * 职称证书
     * @var <string>
     */
    public $gcert;
    
    /**
     * 日期
     * @var <string>
     */
    public $date;

    /**
     * 职位状态
     * @var <int> 
     */
    public $status;
    
    /**
     * 职位描述
     * @var <string> 
     */
    public $descript;

    /**
     * 工作经验
     * @var <int>
     */
    public $exp;

    /**
     * 是否要求社保
     * @var <int>
     */
    public $social;

    /**
     * 是否考取安全B证
     * @var <int>
     */
    public $bcard;

    /**
     * 是否允许多证
     * @var <int>
     */
    public $muti;

    /**
     * 发布人模型
     * @var <model>
     */
    public $pub_model;

    /**
     * 代理人模型
     * @var <model>
     */
    public $agent_model;

    /**
     * 是否被代理
     * @var <int>
     */
    public $is_agent;
    
    /**
     * 招聘类型（1-预招，2-热招）
     * @var int 
     */
    public $job_type;
    
    /**
     * 企业资质
     * @var string 
     */
    public $company_qualification;
    
    /**
     * 企业性质
     * @var int 
     */
    public $company_category;
    
    /**
     * 企业成立时间
     * @var date 
     */
    public $company_regtime;
    
    /**
     * 企业规模
     * @var int 
     */
    public $company_scale;
    
    /**
     * 企业简介
     * @var string 
     */
    public $company_introduce;
}
?>
