<?php
/**
 * Description of LongConnectProvider
 *
 * @author moi
 */
class LongConnectProvider extends BaseProvider{
    /**
     * 添加长连接记录
     * @param  <string> $id      会话ID
     * @param  <int>    $user_id 用户编号
     * @param  <string> $session_id 
     * @return <bool> 是否成功
     */
    public function add($id, $user_id, $session_id){
        $this->da->setModelName('long_connect_record');              
        $data['id'] = $id;
        $data['user_id'] = $user_id;
        $data['session_id'] = $session_id;
        $data['time'] = time();
        $data['remind'] = '';
        return $this->da->add($data) != false;
    }

    /**
     * 删除长连接记录
     * @param  <int>  $id 会话ID
     * @return <bool> 是否成功
     */
    public function delete($id){
        $this->da->setModelName('long_connect_record');
        $where['id'] = $id;
        return $this->da->where($where)->delete() != false;
    }

    /**
     * 删除长连接记录
     * @param  <int>  $session_id 
     * @return <bool> 是否成功
     */
    public function delete_by_session_id($session_id){
        $this->da->setModelName('long_connect_record');
        $where['session_id'] = $session_id;
        return $this->da->where($where)->delete() != false;
    }

    /**
     * 获取长连接记录
     * @param  <int>  $session_id
     * @return <mixed> 
     */
    public function get_by_session_id($session_id){
        $this->da->setModelName('long_connect_record');
        $where['session_id'] = $session_id;
        return $this->da->where($where)->find();
    }

    /**
     * 获取指定用户的会话记录
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get_user_record($user_id){
        $this->da->setModelName('long_connect_record');
        $where['user_id'] = $user_id;
        return $this->da->where($where)->select();
    }

    /**
     * 获取指定用户的提醒记录
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get_user_remind($id){
        $this->da->setModelName('long_connect_record');
        $where['id'] = $id;
        return $this->da->where($where)->find();
    }

    /**
     * 保存指定用户的提醒记录
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function update_user_remind($id, $remind){
        $this->da->setModelName('long_connect_record');
        $where['id'] = $id;
        $data['remind'] = $remind;
        return $this->da->where($where)->save($data) != false;
    }
}
?>
