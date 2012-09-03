<?php
/**
 * Description of AccountDomainModel
 *
 * @author moi
 */
class AccountDomainModel extends ModelBase{
    /**
     * 用户编号
     * @var <int>
     */
    public $user_id;

    /**
     * 用户名
     * @var <string>
     */
    public $user_name;

    /**
     * 用户密码
     * @var <type>
     */
    public $password;

    /**
     * 邮箱
     * @var <string>
     */
    public $email;
    
    /**
     * 手机号码
     * @var <string> 
     */
    public $phone;

    /**
     * 角色编号
     * @var <int>
     */
    public $role_id;

    /**
     * 资料编号
     * @var <int>
     */
    public $data_id;

    /**
     * 是否被冻结
     * @var <int>
     */
    public $freeze;

    /**
     * 是否已激活
     * @var <int>
     */
    public $activate;

    /**
     * 是否已邮件激活
     * @var <int>
     */
    public $eactivate;

    /**
     * 过期时间
     * @var <date>
     */
    public $expired;

    /**
     * 套餐编号
     * @var <int>
     */
    public $package;

    /**
     * 用户组编号
     * @var <int>
     */
    public $group_id;
}
?>
