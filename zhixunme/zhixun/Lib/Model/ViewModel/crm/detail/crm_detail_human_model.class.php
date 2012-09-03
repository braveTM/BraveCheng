<?php

/**
 * 人才详情模型
 * @author YoyiorLee
 */
class crm_detail_human_model {

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
     * 性别
     * @var int 
     */
    public $sex;

    /**
     * 性别名称
     * @var string 
     */
    public $sex_name;

    /**
     * 是否 全职/兼职
     * @var int 
     */
    public $is_fulltime;

    /**
     * 全职/兼职
     * @var string 
     */
    public $fulltime;

    /**
     * 生日
     * @var string 
     */
    public $birthday;

    /**
     * 手机
     * @var int 
     */
    public $mobile;

    /**
     * 座机
     * @var string 
     */
    public $phone;

    /**
     * 传真
     * @var string 
     */
    public $fax;

    /**
     * EMAIL
     * @var string 
     */
    public $email;

    /**
     * QQ
     * @var int 
     */
    public $qq;

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
     * 人才报价
     * @var float 
     */
    public $quote;

    /**
     * 来源
     * @var string 
     */
    public $source_id;

    /**
     * 来源
     * @var string 
     */
    public $source;

    /**
     * 备注
     * @var string 
     */
    public $remark;

    /**
     * 注册单位
     * @var mixed 
     */
    public $employ;

    /**
     * 开户行
     * @var mixed 
     */
    public $bank;

    /**
     * 职称证书
     * @var mixed 
     */
    public $title;

    /**
     * 资质证书
     * @var array 
     */
    public $aptitude;

    /**
     * 状态（阶段，进度，备注）
     * @var array 
     */
    public $status;

    /**
     * 附件
     * @var array 
     */
    public $attachment;

}

?>
