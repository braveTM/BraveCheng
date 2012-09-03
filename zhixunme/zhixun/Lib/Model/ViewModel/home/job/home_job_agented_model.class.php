<?php
/**
 * Description of home_job_agented_model
 *
 * @author moi
 */
class home_job_agented_model {
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
     * 创建者编号
     * @var <int>
     */
    public $u_id;

    /**
     * 创建者名字
     * @var <string>
     */
    public $u_name;

    /**
     * 创建者头像
     * @var <string>
     */
    public $u_photo;

    /**
     * 是否已加关注
     * @var <int>
     */
    public $follow;

    /**
     * 是否实名认证
     * @var <int>
     */
    public $real_auth;

    /**
     * 是否手机认证
     * @var <int>
     */
    public $phone_auth;

    /**
     * 是否邮箱认证
     * @var <int>
     */
    public $email_auth;
}
?>
