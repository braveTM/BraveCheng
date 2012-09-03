<?php

/**
 * 企业列表模型
 * @author YoyiorLee
 */
class crm_index_company_model {
    
    /**
     * 企业ID
     * @var int 
     */
    public $id;

    /**
     * 企业名字
     * @var string 
     */
    public $name;

    /**
     * 所在地：省
     * @var string 
     */
    public $province;

    /**
     * 企业需求
     * @var array 
     */
    public $demand;

    /**
     * 手机
     * @var int 
     */
    public $mobile;

    /**
     * 座机
     * @var int 
     */
    public $phone;

    /**
     * QQ
     * @var int 
     */
    public $qq;

    /**
     * 来源
     * @var string 
     */
    public $source;

    /**
     * 状态ID
     * @var string 
     */
    public $status_id;

    /**
     * 状态-阶段
     * @var string 
     */
    public $status_stage;

    /**
     * 状态-进度
     * @var string 
     */
    public $status_progress;

    /**
     * 状态（阶段/进度）-备注
     * @var string 
     */
    public $status_notes;
}

?>
