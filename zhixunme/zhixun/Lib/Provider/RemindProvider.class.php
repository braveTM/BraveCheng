<?php
/**
 * Description of RemindProvider
 *
 * @author moi
 */
class RemindProvider extends BaseProvider{
    /**
     * 添加用户提醒记录
     * @param  <int>    $user_id 用户编号
     * @param  <string> $remind  提醒
     * @return <bool> 是否成功
     */
    public function add($user_id, $remind){
        $this->da->setModelName('user_remind');
        $data['user_id'] = $user_id;
        $data['remind'] = $remind;
        return $this->da->add($data) != false;
    }

    /**
     * 更新用户提醒记录
     * @param  <int>    $user_id 用户编号
     * @param  <string> $remind  提醒
     * @return <bool> 是否成功
     */
    public function update($user_id, $remind){
        $this->da->setModelName('user_remind');
        $where['user_id'] = $user_id;
        $data['remind'] = $remind;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 删除用户提醒记录
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    public function delete($user_id){
        $this->da->setModelName('user_remind');
        $where['user_id'] = $user_id;
        return $this->da->where($where)->delete() != false;
    }

    /**
     * 获取用户提醒记录
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get($user_id){
        $this->da->setModelName('user_remind');
        $where['user_id'] = $user_id;
        return $this->da->where($where)->find();
    }
}
?>
