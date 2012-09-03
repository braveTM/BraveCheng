<?php
/**
 * Description of PermissionProvider
 *
 * @author moi
 */
class PermissionProvider extends BaseProvider{
    /**
     * 验证角色权限
     * @param  <int>    $role_id 角色编号
     * @param  <string> $action  操作代码
     * @return <bool> 是否有权限
     */
    public function check_role_permission($role_id, $action){
        $this->da->setModelName('permission_role_action');      //使用权限关系表
        $where['role_id']     = $role_id;
        $where['action_code'] = $action;
        $data = $this->da->where($where)->find();
        return !empty($data);
    }
    /**
     * 验证角色未激活权限
     * @param  <int>    $role_id 角色编号
     * @param  <string> $action  操作代码
     * @return <bool> 是否有权限
     */
    public function check_role_not_active_permission($role_id, $action){
        $this->da->setModelName('permission_role_not_active_action');   
        $where['role_id']     = $role_id;
        $where['action_code'] = $action;
        return $this->da->where($where)->count('action_code') > 0;
    }

    /**
     * 获取指定角色的有权限的任务操作的一级分类列表
     * @param  <int> $role_id 角色编号
     * @param  <int> $type    权限类型（1为发布，2为竞标）
     * @return <mixed> 分类列表
     */
    public function get_role_task_class_a($role_id, $type){
        $this->da->setModelName('permission_role_task_class');  //使用任务类别权限关系表
        $where['role_id'] = $role_id;
        $where['type']    = $type;
        return $this->da->where($where)->group('class_id_a')->select();
    }

    /**
     * 获取指定角色的有权限的任务操作的指定一级的分类二级分类列表
     * @param  <int> $role_id 角色编号
     * @param  <int> $class_a 一级分类编号
     * @param  <int> $type    权限类型（1为发布，2为竞标）
     * @return <mixed> 分类列表
     */
    public function get_role_task_class_b($role_id, $class_a, $type){
        $this->da->setModelName('permission_role_task_class');  //使用任务类别权限关系表
        $where['role_id']    = $role_id;
        $where['class_id_a'] = $class_a;
        $where['type']       = $type;
        return $this->da->where($where)->select();
    }

    /**
     * 检查指定角色对指定任务分类是否有指定操作权限
     * @param  <int> $role_id 角色编号
     * @param  <int> $class_b 二级分类编号
     * @param  <int> $type    权限类型（1为发布，2为竞标）
     * @return <bool> 是否有权限
     */
    public function check_role_task_class($role_id, $class_b, $type){
        $this->da->setModelName('permission_role_task_class');  //使用任务类别权限关系表
        $where['role_id']    = $role_id;
        $where['class_id_b'] = $class_b;
        $where['type']       = $type;
        return $this->da->where($where)->count('id') > 0;
    }

    /**
     * 获取角色列表(可注册角色)
     * @return <mixed> 角色列表
     */
    public function get_role_list(){
        $this->da->setModelName('role');                         //使用角色表
        $where['register'] = 1;
        return $this->da->where($where)->select();
    }

    /**
     * 是否存在指定角色编号的角色(可注册角色)
     * @param  <int> $role_id 角色编号
     * @return <bool> 是否存在
     */
    public function exists_role_id($role_id){
        $this->da->setModelName('role');                //使用role表
        return $this->da->where(array('role_id' => $role_id, 'register' => 1))->count() > 0;
    }

    /**
     * 获取指定角色
     * @param  <int> $role_id 角色编号
     * @return <RoleDomainModel> 角色信息
     */
    public function get_role($role_id){
        $this->da->setModelName('role');                //使用role表
        $data = $this->da->where(array('role_id' => $role_id))->find();
        if(empty($data))
            return null;
        return FactoryDMap::array_to_model($data, 'role');
    }

    /**
     * 获取指定ACTION信息
     * @param  <string> $code 操作代码
     * @return <array> 信息
     */
    public function get_action($code){
        $this->da->setModelName('permission_action');         //使用操作表
        $where['action_code'] = $code;
        return $this->da->where($where)->find();
    }
}
?>
