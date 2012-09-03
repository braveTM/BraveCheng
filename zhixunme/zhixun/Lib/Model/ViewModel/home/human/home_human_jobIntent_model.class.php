<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_human_jobIntent_model
 *
 * @author JZG
 */
class home_human_jobIntent_model {
    //put your code here
    /**
     * 求职意向ID
     * @var <int>
     */
    public $job_intent_id;

    /**
     * 工作地点省份编号
     * @var <int>
     */
    public $job_province_code;

    /**
     * 工作地点省份
     * @var <string>
     */
    public $job_province;

    /**
     * 工作地点城市编号
     * @var <int>
     */
    public $job_city_code;

    /**
     * 工作地点城市
     * @var <string>
     */
    public $job_city;

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
     * 职位名称
     * @var <int>
     */
    public $job_name;

    /**
     * 职位描述
     * @var <string>
     */
    public $job_describle;
}
?>
