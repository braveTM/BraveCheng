<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of job_certificate_model
 *
 * @author JZG
 */
class home_recommend_job_certificate_model {
    //put your code here
     /**
     * ID
     * @var <int>
     */
    public $id;


    /**
     * 注册情况
     * @var <int>
     */
    public $register_case;

    /**
     * 证书级别
     * @var <int>
     */
    public $class;

    /**
     * 证书名称
     * @var <string>
     */
    public $register_certificate_name;

    /**
     * 专业名称
     * @var <string>
     */
    public $register_certificate_major;
    
    /**
     * 招聘人数（兼职）
     * @var <int> 
     */
    public $RC_count;
}
?>
