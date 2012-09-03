<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_delegate_human_model
 *
 * @author JZG
 */
class home_delegate_human_model {
    /**
     * ID
     * @var <int>
     */
    public $id;

    /**
     * 用户ID
     * @var <int>
     */
    public $user_id;

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
     * 用户头像
     * @var <string>
     */
    public $user_photo;

    /**
     * 姓名
     * @var <string>
     */
    public $name;

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
     * 简历委托时间
     * @var <datetime>
     */
    public $delegate_datetime;

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
     * 简历投递次数
     * @var <int>
     */
    public $send_count;

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
     * 委托状态（5-未查看，1-未公开，2-已公开，3-完成，4-终止委托）
     * @var <int>
     */
    public $status;

    /**
     * 期望待遇
     * @var <int>
     */
    public $salary;
}
?>
