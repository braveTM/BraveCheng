<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_blog_model
 *
 * @author JZG
 */
class home_blog_model {
    //put your code here
    /**
     * BlogID
     * @var <int> 
     */
    public $blog_id;
    /**
     *标题
     * @var <string>
     */
    public $title;
    /**
     * 正文
     * @var <string>
     */
    public $body;
    /**
     *阅读次数
     * @var <int>
     */
    public $read_count;
    /**
     *状态（1-未审核/草稿，2-审核中，3-审核通过，4-审核未通过）
     * @var <type>
     */
    public $status;
    /**
     * 创建时间
     * @var <type>
     */
    public $create_datetime;
    /**
     *姓名
     * @var <type>
     */
    public $name;
    /**
     *头像
     * @var <type>
     */
    public $photo;
    /**
     *邮箱认证
     * @var <type>
     */
    public $is_auth_email;
    /**
     *手机认证
     * @var <type>
     */
    public $is_auth_phone;

    /**
     *实名认证
     * @var <type>
     */
    public $is_auth_real;
    
    /**
     *创建人ID
     * @var type 
     */
    public $creator_id;

    /**
     *发布的Blog数
     * @var <type>
     */
    public $blog_count;
    
    /**
     *blog 赞
     * @var <type>
     */
    public $praise;
}
?>
