<?php
/**
 * Description of ContactProvider
 *
 * @author moi
 */
class ContactProvider extends BaseProvider{
    /**
     * 添加查看联系方式记录
     * @param  <int> $user_id  用户编号
     * @param  <int> $other_id 查看的用户编号
     * @param  <int> $object_id 查看的对象ID
     * @param  <int> $object_type 查看的对象类型(1-简历，2-职位)
     * @return <bool>
     */
    public function add_read_contact($user_id, $other_id,$object_id,$object_type){
        $this->da->setModelName('read_contact');
        $data['user_id']  = $user_id;
        $data['other_id'] = $other_id;
        $data['date']     = date_f();
        $data['object_id']=$object_id;
        $data['object_type']=$object_type;
        $data['is_del']   = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 是否存在指定记录
     * @param  <int> $user_id  用户编号
     * @param  <int> $other_id 查看的用户编号
     * @param  <int> $object_id 查看的对象ID
     * @param  <int> $object_type 查看的对象类型(1-简历，2-职位)
     * @return <bool>
     */
    public function is_exists_record($user_id, $other_id,$object_id,$object_type){
        $this->da->setModelName('read_contact');
        $where['user_id']  = $user_id;
        $where['other_id'] = $other_id;
        $where['object_id']=$object_id;
        $where['object_type']=$object_type;
        $where['is_del']   = 0;
        return $this->da->where($where)->count('user_id') > 0;
    }
}
?>
