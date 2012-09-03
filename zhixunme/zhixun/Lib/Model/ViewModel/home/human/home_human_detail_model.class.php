<?php
/**
 * Description of home_human_detail_model
 *
 * @author moi
 */
class home_human_detail_model {
    /**
     * 人才用户编号
     * @var int 
     */
    public $uid;
    
    /**
     * 人才资料编号
     * @var int 
     */
    public $hid;
    
    /**
     * 人才简历编号
     * @var int 
     */
    public $rid;
    
    /**
     * 名字
     * @var int 
     */
    public $name;
    
    /**
     * 头像
     * @var string 
     */
    public $photo;
    
    /**
     * 求职意向编号
     * @var int 
     */
    public $ji_id;
    
    /**
     * 挂证意向编号
     * @var int 
     */
    public $hc_id;
    
    /**
     * 工作性质
     * @var int 
     */
    public $category;
    
    /**
     * 实名认证图片
     * @var string 
     */
    public $real_auth;
    
    /**
     * 邮箱认证图片
     * @var string 
     */
    public $email_auth;
    
    /**
     * 手机认证图片
     * @var string 
     */
    public $phone_auth;
    
    /**
     * 地点
     * @var string 
     */
    public $place;
    
    /**
     * 工作年限
     * @var string 
     */
    public $work_age;
    
    /**
     * 活跃度
     * @var string 
     */
    public $active;
    
    /**
     * 注册证书
     * @var array 
     */
    public $certs;
    
    /**
     * 职称证书
     * @var string 
     */
    public $gcert;
    
    /**
     * 简历浏览数
     * @var int 
     */
    public $rcount;
}

?>
