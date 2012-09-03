<?php
/**
 * Description of InviteProvider
 *
 * @author moi
 */
class InviteProvider extends BaseProvider{
    /**
     * 增加邀请信息
     * @param int $user_id 用户编号
     * @param string $code 邀请码
     * @return bool 是否成功
     */
    public function add_invite($user_id, $code){
        $this->da->setModelName('user_invite');
        $data['user_id'] = $user_id;
        $data['code'] = $code;
        $data['is_del'] = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 获取邀请信息
     * @param int $user_id 用户编号
     * @param string $code 邀请码
     * @return mixed
     */
    public function get_invite($user_id, $code){
        $this->da->setModelName('user_invite');
        if(!empty($user_id)){
            $where['user_id'] = $user_id;
        }
        if(!empty($code)){
            $where['code'] = $code;
        }
        if(empty($where)){                              //条件不存在，返回空
            return null;
        }
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
    
    /**
     * 获取邀请发送记录
     * @param int $user_id 用户编号
     * @param int $date 日期
     * @param int $type 邀请类型（1短信2邮件）
     * @return mixed
     */
    public function get_invite_send_record($user_id, $date, $type){
        $this->da->setModelName('user_invite_send_record');
        $where['user_id'] = $user_id;
        $where['date'] = $date;
        $where['type'] = $type;
        return $this->da->where($where)->find();
    }
    
    /**
     * 添加邀请发送记录
     * @param array $data 记录数据
     * @return bool 是否成功 
     */
    public function add_invite_send_record($data){
        $this->da->setModelName('user_invite_send_record');
        return $this->da->add($data) != false;
    }
    
    /**
     * 更新邀请发送记录
     * @param int $id 记录编号
     * @param array $data 记录数据
     * @return bool 是否成功 
     */
    public function update_invite_send_record($id, $data){
        $this->da->setModelName('user_invite_send_record');
        $where['id'] = $id;
        return $this->da->where($where)->save($data) != false;
    }
    
    /**
     * 添加邀请记录
     * @param int $user_id 用户编号
     * @param int $invite_user_id 邀请者编号
     * @param date $date 日期
     * @return bool 是否成功
     */
    public function add_invite_record($user_id, $invite_user_id, $date){
        $this->da->setModelName('user_invite_record');
        $data['user_id'] = $user_id;
        $data['invite_user_id'] = $invite_user_id;
        $data['date'] = $date;
        $data['is_del'] = 0;
        return $this->da->add($data) != false;
    }
}

?>
