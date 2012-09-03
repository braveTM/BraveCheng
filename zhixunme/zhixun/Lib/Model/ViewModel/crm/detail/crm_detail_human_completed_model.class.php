<?php

/**
 * 人才资料完成度模型
 * @author YoyiorLee
 */
class crm_detail_human_completed_model {
    
    /**
     * 人才ID
     * @var int 
     */
    public $human_id;

    /**
     * 人才基本信息情况
     * @var string 
     */
    public $base;

    /**
     * 人才资质证书情况
     * @var string 
     */
    public $aptitude;

    /**
     * 人才阶段情况
     * @var string 
     */
    public $status;

    /**
     * 开户行情况
     * @var string 
     */
    public $bank;

    /**
     * 注册企业信息情况
     * @var string 
     */
    public $employ;

    /**
     * 附件信息情况
     * @var string 
     */
    public $attachment;

    /**
     * 备注情况
     * @var string 
     */
    public $remark;

}

?>
