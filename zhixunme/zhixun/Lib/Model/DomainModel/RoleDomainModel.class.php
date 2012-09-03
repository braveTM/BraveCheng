<?php
/**
 * Description of RoleDomainModel
 *
 * @author moi
 */
class RoleDomainModel extends ModelBase{
    /**
     * 角色编号
     * @var <int>
     */
    public $role_id;

    /**
     * 角色名称
     * @var <string>
     */
    public $role_name;
    
    /**
     * 用户类型
     * @var <int>
     */
    public $user_type;

    /**
     * 是否能注册
     * @var <int>
     */
    public $register;
}
?>
