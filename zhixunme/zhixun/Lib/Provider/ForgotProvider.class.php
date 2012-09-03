<?php
/**
 * Description of ForgotProvider
 *
 * @author moi
 */
class ForgotProvider extends BaseProvider{
    /**
     * 添加用户忘记密码记录
     * @param  <int>    $user_id 用户编号
     * @param  <string> $email   用户邮箱
     * @param  <string> $token   TOKEN
     * @return <bool> 是否成功
     */
    public function add_forgot($user_id, $email, $token){
        $this->da->setModelName('user_forgot');             //使用用户忘记密码表
        $data['user_id'] = $user_id;
        $data['email']   = $email;
        $data['token']   = $token;
        $data['date']    = date_f();
        $data['is_del']  = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 删除用户以前的忘记密码记录
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    public function delete_user_forgot($user_id){
        $this->da->setModelName('user_forgot');             //使用用户忘记密码表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        $data['is_del']   = 1;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 删除指定忘记密码记录
     * @param  <string> $token TOKEN
     * @return <bool> 是否成功
     */
    public function delete_forgot($token){
        $this->da->setModelName('user_forgot');             //使用用户忘记密码表
        $where['token'] = $token;
        $data['is_del'] = 1;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 获取指定忘记密码记录
     * @param  <string> $token TOKEN
     * @return <mixed>
     */
    public function get_forgot($token,$phone = null){
        $this->da->setModelName('user_forgot');             //使用用户忘记密码表
        if(!empty($phone)){
        	$where['email']  = $phone;
        }
        $where['token']  = $token;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 是否存在指定TOKEN
     * @param  <string> $token TOKEN
     * @return <bool> 是否存在
     */
    public function exists_token($token){
        $this->da->setModelName('user_forgot');             //使用用户忘记密码表
        $where['token']  = $token;
        $where['is_del'] = 0;
        return $this->da->where($where)->count('token') > 0;
    }
}
?>
