<?php
/**
 * Description of LabelDomain
 *
 * @author moi
 */
class LabelDomain{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new LabelProvider();
    }
    /**
     * 获取指定分类的子分类
     * @param  <int>  $id           分类编号
     * @param  <int>  $role_id      角色编号
     * @param  <char> $first_letter 首字母
     * @return <mixed>
     */
    public function get_children($id, $role_id = null, $first_letter = null){
        return $this->provider->get_children($id, $role_id, $first_letter);
    }

    /**
     * 获取首字母分组
     * @param  <int>  $id      分类编号
     * @param  <int>  $role_id 角色编号
     * @return <mixed>
     */
    public function group_first_letter($id, $role_id = null){
        return $this->provider->group_first_letter($id, $role_id);
    }

    /**
     * 增加用户标签
     * @param  <int>   $user_id 用户编号
     * @param  <int>   $role_id 角色编号
     * @param  <mixed> $label   标签
     * @return <bool> 是否成功
     */
    public function add_labels($user_id, $role_id, $label){
        $date   = date_f();
        $result = false;
        if(is_array($label)){                                   //多个标签
            foreach ($label as $item) {
                if(!$this->exists_user_label($user_id, $item)){
                    if($this->provider->add_label($user_id, $item, $date) && !$result)
                        $result = true;
                }
            }
        }
        else{                                                   //单个标签
            if(!$this->exists_user_label($user_id, $label) && $this->check_label($role_id, $label)){
                $result = $this->provider->add_label($user_id, $label, $date);
            }
        }
        if(!$result)
            return E(ErrorMessage::$SAVE_FAILED);
        return true;
    }

    /**
     * 检测指定用户是否拥有指定标签
     * @param  <int> $user_id  用户编号
     * @param  <int> $label_id 标签编号
     * @return <bool> 是否拥有
     */
    public function exists_user_label($user_id, $label){
        return $this->provider->exists_user_label($user_id, $label);
    }

    /**
     * 获取用户标签列表
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get_user_labels($user_id){
        return $this->provider->get_user_labels(intval($user_id));
    }

    /**
     * 删除用户指定标签
     * @param  <int> $user_id 用户编号
     * @param  <int> $label   标签编号
     * @return <bool> 是否成功
     */
    public function delete_user_label($user_id, $label){
        if($this->provider->delete_user_label($user_id, $label))
            return true;
        else
            return E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 获取指定标签信息
     * @param  <int> $id 标签编号
     * @return <mixed> 标签信息
     */
    public function get_label($id){
        return $this->provider->get_label($id);
    }

    //----------------protected-----------------
    /**
     * 检测用户标签合法性
     * @param  <int> $role_id 角色编号
     * @param  <int> $label   标签编号
     * @return <bool> 是否合法
     */
    protected function check_label($role_id, $label){
        $info = $this->provider->get_label($label);
        return $info['role_id'] == $role_id;
    }
}
?>
