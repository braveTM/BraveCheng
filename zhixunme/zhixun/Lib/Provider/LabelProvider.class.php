<?php
/**
 * Description of LabelProvider
 *
 * @author moi
 */
class LabelProvider extends BaseProvider{
    /**
     * 获取指定分类的子分类
     * @param  <int>  $id           分类编号
     * @param  <int>  $role_id      角色编号
     * @param  <char> $first_letter 首字母
     * @return <mixed>
     */
    public function get_children($id, $role_id = null, $first_letter = null){
        $this->da->setModelName('user_label');              //使用用户标签表
        $where['parent_id'] = $id;
        if(isset ($role_id))
            $where['role_id'] = $role_id;
        if(isset ($first_letter))
            $where['first_letter'] = $first_letter;
        return $this->da->where($where)->order('sort desc')->select();
    }

    /**
     * 获取首字母分组
     * @param  <int>  $id      分类编号
     * @param  <int>  $role_id 角色编号
     * @return <mixed>
     */
    public function group_first_letter($id, $role_id = null){
        $this->da->setModelName('user_label');              //使用用户标签表
        $where['parent_id'] = $id;
        if(!empty($role_id))
            $where['role_id'] = $role_id;
        return $this->da->where($where)->order('first_letter')->group('first_letter')->field('first_letter')->select();
    }

    /**
     * 增加指定用户的标签
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $label   标签编号
     * @param  <date> $date    日期
     * @return <bool> 是否成功
     */
    public function add_label($user_id, $label, $date){
        $this->da->setModelName('user_label_relation');              //使用用户标签关系表
        $data['user_id']  = $user_id;
        $data['label_id'] = $label;
        $data['date']     = $date;
        return $this->da->add($data) != false;
    }

    /**
     * 获取指定标签信息
     * @param  <int> $id 标签编号
     * @return <array> 标签信息
     */
    public function get_label($id){
        $this->da->setModelName('user_label');              //使用用户标签表
        $where['id'] = $id;
        return $this->da->where($where)->find();
    }

    /**
     * 检测指定用户是否拥有指定标签
     * @param  <int> $user_id  用户编号
     * @param  <int> $label_id 标签编号
     * @return <bool> 是否拥有
     */
    public function exists_user_label($user_id, $label_id){
        $this->da->setModelName('user_label_relation');              //使用用户标签关系表
        $where['user_id']  = $user_id;
        $where['label_id'] = $label_id;
        return $this->da->where($where)->count('user_id') > 0;
    }

    /**
     * 获取用户标签列表
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get_user_labels($user_id){
        $label_table = C('DB_PREFIX').'user_label';                //标签表
        $relation_table = C('DB_PREFIX').'user_label_relation';    //标签关系表
        $where = 'r.user_id='.$user_id.' AND r.label_id=l.id';
        $field = 'l.id,l.name,l.title,l.icon,l.first_letter';
        $order = 'l.sort DESC';
        $sql = "SELECT $field
                FROM $label_table l,$relation_table r
                WHERE $where
                ORDER BY $order
                LIMIT 0,1000";
        return $this->da->query($sql);
    }

    /**
     * 删除用户指定标签
     * @param  <int> $user_id  用户编号
     * @param  <int> $label_id 标签编号
     * @return <bool> 是否成功
     */
    public function delete_user_label($user_id, $label_id){
        $this->da->setModelName('user_label_relation');              //使用用户标签关系表
        $where['user_id']  = $user_id;
        $where['label_id'] = $label_id;
        return $this->da->where($where)->delete() != false;
    }
}
?>
