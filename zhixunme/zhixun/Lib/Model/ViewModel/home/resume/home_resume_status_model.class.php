<?php
/**
 * Description of home_resume_status_model
 *
 * @author moi
 */
class home_resume_status_model {
    /**
     * 全职简历完善度
     * @var int 
     */
    public $f_wsd;
    
    /**
     * 兼职简历完善度
     * @var int 
     */
    public $p_wsd;
    
    /**
     * 全职简历期望薪资
     * @var string 
     */
    public $f_salary;
    
    /**
     * 兼职简历期望薪资
     * @var string 
     */
    public $p_salary;
    
    /**
     * 全职简历状态
     * @var int 
     */
    public $f_status;
    
    /**
     * 兼职简历状态
     * @var int 
     */
    public $p_status;
}

?>
