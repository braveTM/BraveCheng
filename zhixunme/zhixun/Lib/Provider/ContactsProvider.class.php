<?php
/**
 * Description of ContacttProvider
 *
 * @author moi
 */
class ContactsProvider extends BaseProvider{
    /**
     * 添加用户关注
     * @param  <int> $user_id   用户编号
     * @param  <int> $follow_id 关注编号
     * @return <bool>
     */
    public function add_follow($user_id, $follow_id){
        $this->da->setModelName('follow');                  //使用关注表
        $data['user_id'] = $user_id;
        $data['follow_id'] = $follow_id;
        $data['date'] = date_f();
        return $this->da->add($data) != false;
    }

    /**
     * 删除用户关注
     * @param <int> $user_id   用户编号
     * @param <int> $follow_id 关注编号
     * @return <bool>
     */
    public function delete_follow($user_id, $follow_id){
        $this->da->setModelName('follow');                  //使用关注表
        $where['user_id']   = $user_id;
        $where['follow_id'] = $follow_id;
        return $this->da->where($where)->delete() != false;
    }

    /**
     * 是否存在指定用户关注关系
     * @param <int> $user_id   用户编号
     * @param <int> $follow_id 关注编号
     * @return <bool>
     */
    public function exists_user_follow($user_id, $follow_id){
        $this->da->setModelName('follow');                  //使用关注表
        $where['user_id']   = $user_id;
        $where['follow_id'] = $follow_id;
        return $this->da->where($where)->count('user_id') > 0;
    }

    /**
     * 获取用户的关注列表
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $type    用户类型
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <string> $order   排序方式
     * @param  <bool>   $count   是否统计总条数
     * @return <mixed>
     */
    public function get_follow_list($user_id, $type, $page, $size, $order, $count = false){
        $this->da->setModelName('follow t1');                  //使用关注表
        $join[] = 'INNER JOIN '.C('DB_PREFIX').'user t2 ON t2.user_id=t1.follow_id';
        $where['t1.user_id'] = $user_id;
        if(!empty($type))
            $where['t2.role_id'] = $type;
        $where['t2.is_del'] = 0;
        if($count){
            return $this->da->join($join)->where($where)->count('t1.follow_id');
        }
        else{
            if(empty($order))
                $order = 't1.date DESC';
            $field = 't1.date,t2.user_id,t2.role_id,t2.data_id,t2.photo,t2.name,t2.is_real_auth,t2.is_phone_auth,t2.is_email_auth';
            return $this->da->join($join)->where($where)->order($order)->page($page.','.$size)->field($field)->select();
        }
    }

    /**
     * 增加用户动态
     * @param  <int>    $user_id 用户编号
     * @param  <string> $action  动作
     * @param  <string> $content 内容
     * @param  <int>    $type    动态类型
     * @return <bool> 是否成功
     */
    public function add_moving($user_id, $action, $content, $type){
        $this->da->setModelName('user_moving');                  //使用用户动态表
        $data['user_id'] = $user_id;
        $data['action']  = $action;
        $data['content'] = $content;
        $data['type']    = $type;
        $data['date']    = date_f();
        return $this->da->add($data) != false;
    }

    /**
     * 获取指定用户关注的动态列表
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $type    用户类型
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function get_follow_moving($user_id, $type, $page, $size, $count = false){
        $this->da->setModelName('user_moving t1');                   //使用用户动态表
        $join[] = C('DB_PREFIX').'follow t2 ON t2.follow_id=t1.user_id';
        $join[] = C('DB_PREFIX').'user t3 ON t3.user_id=t1.user_id';
        $where['t2.user_id'] = $user_id;
        if(!empty ($type))
            $where['t3.role_id'] = $type;
        if($count){
            return $this->da->join($join)->where($where)->count('t1.user_id');
        }
        else{
            $order = 't1.date DESC';
            $field = 't3.user_id,t3.photo,t3.name,t3.role_id,t1.action,t1.content,t1.date';
            return $this->da->join($join)->where($where)->order($order)->page($page.','.$size)->field($field)->select();
        }
    }
}
?>
