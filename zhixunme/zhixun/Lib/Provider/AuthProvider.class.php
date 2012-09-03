<?php
/**
 * Description of AuthProvider
 *
 * @author moi
 */
class AuthProvider extends BaseProvider{
    /**
     * 设置指定用户的邮箱认证为已删除
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    public function set_auth_email_del($user_id){
        $this->da->setModelName('auth_email');              //使用邮箱认证表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        $data['is_del']   = 1;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 添加用户邮箱认证记录
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <string> $email     邮箱
     * @param  <string> $code      邮箱验证码
     * @param  <int>    $date      日期
     * @param  <int>    $status    认证状态
     * @return <bool> 是否成功
     */
    public function add_auth_email_record($user_id, $user_name, $email, $code, $date, $status = 0){
        $this->da->setModelName('auth_email');              //使用邮箱认证表
        $data['user_id']    = $user_id;
        $data['user_name']  = $user_name;
        $data['email']      = $email;
        $data['code']       = $code;
        $data['start_time'] = $date;
        $data['end_time']   = $date;
        $data['status']     = $status;
        $data['is_del']     = 0;
        return $this->da->add($data) !== false;
    }

    /**
     * 获取指定用户的最后一次邮箱验证记录
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  认证状态
     * @return <array> 验证记录
     */
    public function get_last_auth_email_record($user_id, $status = 0){
        $this->da->setModelName('auth_email');              //使用邮箱认证表
        $where['user_id'] = $user_id;
        $where['status']  = $status;
        $where['is_del']  = 0;
        return $this->da->where($where)->order('start_time desc')->find();
    }

    /**
     * 设置邮箱验证状态
     * @param  <int> $auth_id 验证编号
     * @param  <int> $status  状态
     * @param  <int> $date    日期
     * @return <bool> 是否成功
     */
    public function set_auth_email_status($auth_id, $status, $date){
        $this->da->setModelName('auth_email');              //使用邮箱认证表
        $where['id']      = $auth_id;
        $data['status']   = $status;
        $data['end_time'] = $date;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 设置指定用户的银行卡认证为已删除
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    public function set_auth_bank_del($user_id){
        $this->da->setModelName('auth_bank');              //使用银行卡认证表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        $data['is_del']   = 1;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 添加用户银行卡认证记录
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <int>    $bank_id   银行编号
     * @param  <string> $card_num  银行卡号
     * @param  <int>    $date      日期
     * @return <bool> 是否成功
     */
    public function add_auth_bank_record($user_id, $user_name, $bank_id, $card_num, $date){
        $this->da->setModelName('auth_bank');              //使用银行卡认证表
        $data['user_id']    = $user_id;
        $data['user_name']  = $user_name;
        $data['bank_id']    = $bank_id;
        $data['card_num']   = $card_num;
        $data['start_time'] = $date;
        $data['end_time']   = $date;
        $data['status']     = 0;
        $data['is_del']     = 0;
        return $this->da->add($data) !== false;
    }

    /**
     * 获取银行卡认证记录
     * @param  <int> $auth_id  记录编号
     * @return <array> 认证记录
     */
    public function get_auth_bank($auth_id){
        $this->da->setModelName('auth_bank');              //使用银行卡认证表
        $where['id']     = $auth_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 设置银行卡认证状态
     * @param  <int> $auth_id 验证编号
     * @param  <int> $status  状态日期
     * @param  <int> $date    日期
     * @return <bool> 是否成功
     */
    public function set_auth_bank_status($auth_id, $status, $date){
        $this->da->setModelName('auth_bank');              //使用银行卡认证表
        $where['id']      = $auth_id;
        $data['status']   = $status;
        $data['end_time'] = $date;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 设置指定用户的手机认证为已删除
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    public function set_auth_phone_del($user_id){
        $this->da->setModelName('auth_phone');              //使用手机认证表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        $data['is_del']   = 1;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 添加用户手机认证记录
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <string> $phone     手机号码
     * @param  <string> $code      手机验证码
     * @param  <int>    $date      日期
     * @param  <int>    $status    认证状态
     * @return <bool> 是否成功
     */
    public function add_auth_phone_record($user_id, $user_name, $phone, $code, $date, $status = 0){
        $this->da->setModelName('auth_phone');              //使用手机认证表
        $data['user_id']    = $user_id;
        $data['user_name']  = $user_name;
        $data['phone']      = $phone;
        $data['code']       = $code;
        $data['start_time'] = $date;
        $data['end_time']   = $date;
        $data['status']     = $status;
        $data['is_del']     = 0;
        return $this->da->add($data) !== false;
    }

    /**
     * 获取指定用户的最后一次手机验证记录
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  认证状态
     * @return <mixed> 验证记录
     */
    public function get_last_auth_phone_record($user_id, $status = 0){
        $this->da->setModelName('auth_phone');              //使用手机认证表
        $where['user_id'] = $user_id;
        $where['status']  = $status;
        $where['is_del']  = 0;
        return $this->da->where($where)->order('start_time desc')->find();
    }

    /**
     * 获取指定用户的最后一次手机验证记录
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  认证状态
     * @return <mixed> 验证记录
     */
    public function get_last_auth_bank_record($user_id, $status = 0){
        $this->da->setModelName('auth_bank');              //使用手机认证表
        $where['user_id'] = $user_id;
        $where['status']  = $status;
        $where['is_del']  = 0;
        return $this->da->where($where)->order('start_time desc')->find();
    }

    /**
     * 获取指定用户的最后一次实名验证记录
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  认证状态
     * @return <mixed> 验证记录
     */
    public function get_last_auth_real_record($user_id, $status = 0){
        $this->da->setModelName('auth_real');              //使用手机认证表
        $where['user_id'] = $user_id;
        $where['status']  = $status;
        $where['is_del']  = 0;
        return $this->da->where($where)->order('start_time desc')->find();
    }

    

    /**
     * 设置手机认证状态
     * @param  <int> $auth_id 验证编号
     * @param  <int> $stauts  状态
     * @param  <int> $date    日期
     * @return <bool> 是否成功
     */
    public function set_auth_phone_status($auth_id, $status, $date){
        $this->da->setModelName('auth_phone');              //使用手机认证表
        $where['id']      = $auth_id;
        $data['status']   = $status;
        $data['end_time'] = $date;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 添加实名认证记录
     * @param  <int>    $user_id    用户编号
     * @param  <string> $user_name  用户名
     * @param  <string> $real_name  真实名称
     * @param  <string> $real_num   相关编号
     * @param  <string> $attachment 附件
     * @param  <int>    $date       日期
     * @return <bool> 是否成功
     */
    public function add_auth_real_record($user_id, $user_name, $real_name, $real_num, $attachment, $date){
        $this->da->setModelName('auth_real');              //使用实名认证表
        $data['user_id']    = $user_id;
        $data['user_name']  = $user_name;
        $data['real_name']  = $real_name;
        $data['real_num']   = $real_num;
        $data['attachment'] = $attachment;
        $data['start_time'] = $date;
        $data['end_time']   = $date;
        $data['status']     = 0;
        $data['is_del']     = 0;
        return $this->da->add($data) !== false;
    }

    /**
     * 设置实名验证状态
     * @param  <int> $auth_id 验证编号
     * @param  <int> $status  状态
     * @param  <int> $date    日期
     * @return <bool> 是否成功
     */
    public function set_auth_real_status($auth_id, $status, $date){
        $this->da->setModelName('auth_real');              //使用实名认证表
        $where['id']      = $auth_id;
        $data['status']   = $status;
        $data['end_time'] = $date;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 检测是否存在已验证过的邮箱
     * @param  <string> $email 邮箱
     * @return <bool> 是否存在
     */
    public function exists_email($email){
        $this->da->setModelName('auth_email');              //使用邮箱验证表
        $where['email']  = $email;
        $where['is_del'] = 0;
        return $this->da->where($where)->count() > 0;
    }

    /**
     * 检测是否存在已验证过的银行卡号
     * @param  <string> $card_num 银行卡号
     * @return <bool> 是否存在
     */
    public function exists_card_num($card_num){
        $this->da->setModelName('auth_bank');              //使用银行卡验证表
        $where['card_num']  = $card_num;
        $where['is_del']    = 0;
        return $this->da->where($where)->count() > 0;
    }

    /**
     * 检测是否存在已验证过的手机号码
     * @param  <string> $phone 手机号码
     * @return <bool> 是否存在
     */
    public function exists_phone($phone){
        $this->da->setModelName('auth_phone');              //使用手机号码验证表
        $where['phone']  = $phone;
        $where['is_del'] = 0;
        return $this->da->where($where)->count() > 0;
    }

//    /**
//     * 检测是否存在已验证过的身份证号码
//     * @param  <int> $num 身份证号码
//     * @return <bool> 是否存在
//     */
//    public function exists_id_number($num){
//        $this->da->setModelName('auth_real');              //使用实名认证表
//        $where['real_num']  = $num;
//        $where['is_del']    = array('lt', 2);
//        return $this->da->where($where)->count() > 0;
//    }
//
//    /**
//     * 检测指定用户是否已进行过实名认证
//     * @param <type> $user_id
//     * @return <type>
//     */
//    public function exists_auth_real($user_id){
//        $this->da->setModelName('auth_real');              //使用实名认证表
//        $where['user_id']  = $user_id;
//        $where['status']   = 1;
//        $where['is_del']   = 0;
//        return $this->da->where($where)->count() > 0;
//    }
//
//    /**
//     * 获取指定实名认证记录
//     * @param  <int> $auth_id 认证编号
//     * @return <array> 实名认证记录
//     */
//    public function get_auth_real($auth_id){
//        $this->da->setModelName('auth_real');              //使用实名认证表
//        $where['id']     = $auth_id;
//        $where['is_del'] = 0;
//        return $this->da->where($where)->find();
//    }

    /**
     * 根据用户编号获取实名认证记录
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get_real_auth($user_id){
        $this->da->setModelName('auth_real');              //使用实名认证表
        $where['user_id'] = $user_id;
        $where['status']  = array('neq', 2);
        $where['is_del']  = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 根据认证编号获取实名认证记录
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get_real_auth_by_auth_id($auth_id, $type){
        $this->da->setModelName('auth_real');              //使用实名认证表
        $where['auth_id'] = $auth_id;
        $where['type']    = $type;
        $where['is_del']  = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 增加个人认证记录
     * @param  <string> $name    真实姓名
     * @param  <string> $number  身份证号码
     * @param  <string> $c_front 身份证正面复印件
     * @param  <string> $c_back  身份证背面复印件
     * @param  <string> $photo   用户头像
     * @return <int> 记录编号
     */
    public function add_person_auth($name, $number, $c_front, $c_back, $photo){
        $this->da->setModelName('auth_person');                 //使用个人认证表
        $data['name']       = $name;
        $data['number']     = $number;
        $data['card_front'] = $c_front;
        $data['card_back']  = $c_back;
        $data['photo']      = $photo;
        $data['is_del']     = 0;
        return $this->da->add($data);
    }

    /**
     * 增加企业认证记录
     * @param  <string> $name    企业名称
     * @param  <string> $number  营业执照编号
     * @param  <string> $code    组织机构代码
     * @param  <string> $picture 营业执照复印件
     * @return <int> 记录编号
     */
    public function add_enterprise_auth($name, $number, $code, $picture){
        $this->da->setModelName('auth_enterprise');             //使用企业认证表
        $data['name']    = $name;
        $data['number']  = $number;
        $data['code']    = $code;
        $data['picture'] = $picture;
        $data['is_del']     = 0;
        return $this->da->add($data);
    }

    /**
     * 增加实名认证记录
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $auth_id 认证编号
     * @param  <int>    $type    认证类型（1个人，2企业）
     * @param  <string> $date    日期
     * @return <bool> 是否成功
     */
    public function add_auth_real($user_id, $auth_id, $type, $date){
        $this->da->setModelName('auth_real');                   //使用实名认证表
        $data['user_id']    = $user_id;
        $data['auth_id']    = $auth_id;
        $data['type']       = $type;
        $data['status']     = 0;
        $data['start_time'] = $date;
        $data['end_time']   = $date;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 更新个人认证记录
     * @param  <string> $name    真实姓名
     * @param  <string> $number  身份证号码
     * @param  <string> $c_front 身份证正面复印件
     * @param  <string> $c_back  身份证背面复印件
     * @param  <string> $photo   用户头像
     * @return <bool> 记录编号
     */
    public function update_auth_person($id, $name, $number, $c_front, $c_back, $photo){
        $this->da->setModelName('auth_person');                 //使用个人认证表
        $where['id']        = $id;
        $where['is_del']    = 0;
        $data['name']       = $name;
        $data['number']     = $number;
        $data['card_front'] = $c_front;
        $data['card_back']  = $c_back;
        $data['photo']      = $photo;
        return $this->da->where($where)->save($data);
    }

    /**
     * 更新企业认证记录
     * @param  <string> $name    企业名称
     * @param  <string> $number  营业执照号码
     * @param  <string> $code    组织机构代码
     * @param  <string> $picture 营业执照复印件
     * @return <bool>
     */
    public function update_auth_enterprise($id, $name, $number, $code, $picture){
        $this->da->setModelName('auth_enterprise');             //使用个人认证表
        $where['id']     = $id;
        $where['is_del'] = 0;
        $data['name']    = $name;
        $data['number']  = $number;
        $data['code']    = $code;
        $data['picture'] = $picture;
        return $this->da->where($where)->save($data);
    }

    /**
     * 更新实名认证记录
     * @param  <string> $name    真实姓名
     * @param  <string> $number  身份证号码
     * @param  <string> $c_front 身份证正面复印件
     * @param  <string> $c_back  身份证背面复印件
     * @return <int> 记录编号
     */
    public function update_auth_real($id, $status, $date){
        $this->da->setModelName('auth_real');                   //使用个人认证表
        $where['id']     = $id;
        $where['is_del'] = 0;
        $data['status']  = $status;
        if($status == 0)
            $data['start_time'] = $date;
        $data['end_time'] = $date;
        return $this->da->where($where)->save($data);
    }

    /**
     * 根据身份证号码获取个人认证记录
     * @param  <int> $num 身份证号码
     * @return <bool> 是否存在
     */
    public function get_record_by_idnum($num){
        $this->da->setModelName('auth_person');             //使用个人认证表
        $where['number'] = $num;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 根据营业执照号码获取企业认证记录
     * @param  <int> $num 营业执照号码
     * @return <bool> 是否存在
     */
    public function get_record_by_lnum($num){
        $this->da->setModelName('auth_enterprise');             //使用企业认证表
        $where['number'] = $num;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 根据组织机构代码获取企业认证记录
     * @param  <int> $num 组织机构代码
     * @return <bool> 是否存在
     */
    public function get_record_by_ocode($code){
        $this->da->setModelName('auth_enterprise');             //使用企业认证表
        $where['code']   = $code;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取指定编号的个人认证记录
     * @param  <int> $auth_id 编号
     * @return <mixed>
     */
    public function get_real_person($auth_id){
        $this->da->setModelName('auth_person');             //使用个人认证表
        $where['id'] = $auth_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取指定编号的企业认证记录
     * @param  <int> $auth_id 编号
     * @return <mixed>
     */
    public function get_real_enterprise($auth_id){
        $this->da->setModelName('auth_enterprise');             //使用企业认证表
        $where['id'] = $auth_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
}
?>
