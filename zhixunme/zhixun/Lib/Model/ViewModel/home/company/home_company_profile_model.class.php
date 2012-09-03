<?php
/**
 * Description of home_company_profile_model
 *
 * @author moi
 */
class home_company_profile_model {
    /**
     * 资料编号
     * @var <int>
     */
    public $id;

    /**
     * 用户编号
     * @var <int>
     */
    public $user_id;

    /**
     * 企业名称
     * @var <string>
     */
    public $name;

    /**
     * 性质
     * @var <int>
     */
    public $category;

    /**
     * 省份编号
     * @var <int>
     */
    public $province;

    /**
     * 城市编号
     * @var <int>
     */
    public $city;

    /**
     * 联系人
     * @var <string>
     */
    public $cname;

    /**
     * 手机
     * @var <string>
     */
    public $phone;

    /**
     * 邮箱
     * @var <string>
     */
    public $email;

    /**
     * QQ
     * @var <string>
     */
    public $qq;

    /**
     * 简介
     * @var <string>
     */
    public $summary;

    /**
     * 头像
     * @var <string>
     */
    public $photo;

    /**
     * 是否实名认证
     * @var <int>
     */
    public $real_auth;

    /**
     * 是否手机认证
     * @var <int>
     */
    public $phone_auth;

    /**
     * 是否邮箱认证
     * @var <int>
     */
    public $email_auth;
    
    /**
     * 企业资质
     * @var <string> 
     */
    public $company_qualification;
    
    /**
     * 企业成立时间
     * @var <date> 
     */
    public $company_regtime;
    
    /**
     * 企业规模
     * @var <int> 
     */
    public $company_scale;
}
?>
