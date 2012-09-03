<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_human_register_certificate
 *
 * @author JZG
 */
class home_human_register_certificate_model {
    //put your code here
    /**
     * 注册证书ID
     * @var <int>
     */
    public $certificate_id;

    /**
     * 注册地省份编号
     * @var <int>
     */
    public $register_place;

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
}
?>
