<?php

/**
 * 人才列表模型
 * @author YoyiorLee
 */
class crm_index_human_model {

    /**
     * 人才ID
     * @var int 
     */
    public $id;

    /**
     * 人才名字
     * @var string 
     */
    public $name;

    /**
     * 全职/兼职
     * @var string 
     */
    public $fulltime;

    /**
     * 所在地：省
     * @var string 
     */
    public $province;

    /**
     * 资质证书
     * @var array 
     */
    public $aptitude;

    /**
     * 职称证书
     * @var string 
     */
    public $title;

    /**
     * 人才报价
     * @var float 
     */
    public $quote;

    /**
     * 手机
     * @var int 
     */
    public $mobile;

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
