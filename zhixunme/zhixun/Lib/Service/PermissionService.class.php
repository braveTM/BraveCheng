<?php
/**
 * Description of PermissionService
 *
 * @author moi
 */
class PermissionService{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new PermissionProvider();
    }
    
    /**
     * 验证角色权限
     * @param  <int>    $role_id  角色编号
     * @param  <string> $action   操作代码
     * @return <bool> 是否有权限
     */
    public function check_role_permission($role_id, $action){
        return $this->provider->check_role_permission($role_id, $action);
    }

    /**
     * 验证角色未激活权限
     * @param  <int>    $role_id  角色编号
     * @param  <string> $action   操作代码
     * @return <bool> 是否有权限
     */
    public function check_role_not_active_permission($role_id, $action){
        return $this->provider->check_role_not_active_permission($role_id, $action);
    }

    /**
     * 获取指定角色的有权限的任务操作的一级分类列表
     * @param  <int> $role_id 角色编号
     * @param  <int> $type    权限类型（1为发布，2为竞标）
     * @return <mixed> 分类列表
     */
    public function get_role_task_class_a($role_id, $type){
        $data = $this->provider->get_role_task_class_a($role_id, $type);
        return $data;

    }

    /**
     * 获取指定角色的有权限的任务操作的指定一级的分类二级分类列表
     * @param  <int> $role_id 角色编号
     * @param  <int> $class_a 一级分类编号
     * @param  <int> $type    权限类型（1为发布，2为竞标）
     * @return <mixed> 分类列表
     */
    public function get_role_task_class_b($role_id, $class_a, $type){
        $data = $this->provider->get_role_task_class_b($role_id, $class_a, $type);
        return $data;
    }

    /**
     * 检查指定角色对指定任务分类是否有指定操作权限
     * @param  <int> $role_id 角色编号
     * @param  <int> $class_b 二级分类编号
     * @param  <int> $type    权限类型（1为发布，2为竞标）
     * @return <bool> 是否有权限
     */
    public function check_role_task_class($role_id, $class_b, $type){
        return $this->provider->check_role_task_class($role_id, $class_b, $type);
    }

    /**
     * 获取指定ACTION信息
     * @param  <string> $code 操作代码
     * @return <array> 信息
     */
    public function get_action($code){
        $data = $this->provider->get_action($code);
        return $data;
    }

    /**
     * 获取角色列表(可注册角色)
     * @return <mixed> 角色列表
     */
    public function get_role_list(){
        return $this->provider->get_role_list();
    }

    /**
     * 指定角色是否存在(可注册角色)
     * @param  <int> $role_id 角色编号
     * @return <bool> 是否存在
     */
    public function exists_role($role_id){
        return $this->provider->exists_role_id(intval($role_id));
    }
}
?>
