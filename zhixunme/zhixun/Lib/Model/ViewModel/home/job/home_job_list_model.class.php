<?php
/**
 * Description of home_job_list_model
 *
 * @author moi
 */
class home_job_list_model {
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
     * 投递简历数量
     * @var <int>
     */
    public $r_count;

    /**
     * 职位状态
     * @var <int>
     */
    public $status;
    /**
     * 日期
     * @var <string>
     */
    public $date;

    /**
     * 代理人编号
     * @var <int>
     */
    public $agent_id;

    /**
     * 代理人名字
     * @var <string>
     */
    public $agent;
}
?>
