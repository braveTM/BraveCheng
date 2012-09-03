<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_resume_own_model
 *
 * @author JZG
 */
class home_resume_own_model {
    //put your code here

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
     * 姓名
     * @var <string>
     */
    public $name;

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
     * 类型(1-委托，2-私有）
     * @var <int>
     */
    public $type;
}
?>
