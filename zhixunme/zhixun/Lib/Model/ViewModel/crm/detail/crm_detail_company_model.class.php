<?php
/**
 * 企业详模型
 * @author YoyiorLee
 */
class crm_detail_company_model {
    /**
     * 企业ID
     * @var int 
     */
    public $id;

    /**
     * 企业名称
     * @var string 
     */
    public $name;

    /**
     * 企业性质ID(1 国营 2 私营)
     * @var string 
     */
    public $type_id;
    
    /**
     * 企业性质名称
     * @var string 
     */
    public $type;

    /**
     * 成立时间
     * @var int 
     */
    public $found_time;

    /**
     * 来源
     * @var int 
     */
    public $source_id;

    /**
     * 来源
     * @var string 
     */
    public $source;

    /**
     * 网址
     * @var string 
     */
    public $site;

    /**
     * 简介
     * @var string 
     */
    public $brief;

    /**
     * 联系人
     * @var string
     */
    public $contact;

    /**
     * 手机
     * @var int 
     */
    public $mobile;
    
    /**
     * 邮箱
     * @var string 
     */
    public $email;
    
    /**
     * 座机
     * @var string 
     */
    public $phone;

    /**
     * QQ
     * @var int 
     */
    public $qq;
    
    /**
     * 传真
     * @var string 
     */
    public $fax;

    /**
     * 邮编
     * @var int
     */
    public $zipcode;

    /**
     * 所在地：省ID
     * @var string 
     */
    public $province_id;

    /**
     * 所在地：省
     * @var string 
     */
    public $province;

    /**
     * 所在地：市ID
     * @var string 
     */
    public $city_id;
    
    /**
     * 所在地：市
     * @var string 
     */
    public $city;

    /**
     * 所在地：区ID
     * @var string 
     */
    public $region_id;
    
    /**
     * 所在地：区
     * @var string 
     */
    public $region;

    /**
     * 所在地：镇ID
     * @var string 
     */
    public $community_id;

    /**
     * 所在地：镇
     * @var string 
     */
    public $community;

    /**
     * 详细地址
     * @var string 
     */
    public $address;

    /**
     * 备注
     * @var string 
     */
    public $remark;

    /**
     * 企业资质
     * @var mixed 
     */
    public $nature;

    /**
     * 企业需求
     * @var mixed 
     */
    public $demand;

    /**
     * 状态（阶段，进度，备注）
     * @var array 
     */
    public $status;

    /**
     * 企业注册人才信息
     * @var mixed 
     */
    public $registers;

    /**
     * 附件
     * @var array 
     */
    public $attachment;
}

?>
