<?php
/**
 * Description of ForgotService
 *
 * @author moi
 */
class ForgotService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new ForgotProvider();
    }

    /**
     * 发送忘记密码
     * @param  <string> $email 邮箱
     * @return <bool>
     */
    public function send_forgot_email($email){
        $provider = new UserProvider();
        $user = $provider->get_user_profile($email, 2);              //检测指定邮箱是否存在
        if(empty($user)){
            return E(ErrorMessage::$EMAIL_NOT_EXISTS);
        }
        if($user['is_freeze'] == 1){
            return E(ErrorMessage::$ACCOUNT_FREEZED);
        }
        else if($user['email_activate'] == 0){
            return E(ErrorMessage::$ACCOUNT_NOT_ACTIVATE);
        }
        $this->provider->delete_user_forgot($user['user_id']);      //删除原有忘记密码记录
        $token = md5(time().$user['user_id'].rand_string());
        //生成当次忘记密码记录
        if(!$this->provider->add_forgot($user['user_id'], $email, $token)){
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $service = new NotifyService();
        $service->send_email($email, C('PASS_RESET_TPL'), $user['user_id'], $token);
        //email_send($email, C('PASS_RESET_TPL'), $user['user_id'], $token);
        return true;
    }
    
	/**
     * 发送忘记密码
     * @param  <string> $phone 电话找回密码
     * @return <bool>
     */
    public function send_forgot_phone($phone){
        $provider = new UserProvider();
        $user = $provider->get_user_profile_phone($phone, 2);              //检测指定手机是否存在
        if(empty($user)){
            return E(ErrorMessage::$PHONE_NOT_EXISTS);
        }
        if($user['is_freeze'] == 1){
            return E(ErrorMessage::$ACCOUNT_FREEZED);
        }
        else if($user['email_activate'] == 0){
            return E(ErrorMessage::$ACCOUNT_NOT_ACTIVATE);
        }
        $this->provider->delete_user_forgot($user['user_id']);      //删除原有忘记密码记录
        //$token = md5(time().$user['user_id'].rand_string());
        $token = rand_string(6,1);
        //生成当次忘记密码记录
        if(!$this->provider->add_forgot($user['user_id'], $phone, $token)){
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //手机认证验证码……发送手机短信
        require_cache(APP_PATH.'/Common/Class/SMS.class.php');
        $sms = SMSFactory::get_object($phone, '尊敬的职讯网用户，您的验证码为'.$token);
        if(!$sms->send()){
            	return E(ErrorMessage::$OPERATION_FAILED);
        }
        return true;
    }

    /**
     * 完成重设密码
     * @param  <string> $token    TOKEN
     * @param  <string> $password 密码
     * * @param  <string> $phone 电话
     * @return <bool> 是否成功
     */
    public function finish_reset($token, $password , $phone = null){
        $data = $this->provider->get_forgot($token,$phone);
        if(empty($data)){                                       //TOKEN错误
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        $this->provider->trans();                               //事务开启
        $provider = new UserProvider();
        //更新用户密码
        if(!$provider->update_user($data['user_id'], array('password' => encrypt_password($password)))){
            $this->provider->rollback();                        //事务回滚
            return E();
        }
        if(!$this->provider->delete_forgot($token)){            //删除指定忘记密码记录
            $this->provider->rollback();                        //事务回滚
            return E();
        }
        $service = new UserService();
        $login = $service->auto_login($data['user_id']);        //自动登录
        if(is_zerror($login)){
            $this->provider->rollback();                        //事务回滚
            return E();
        }
        $this->provider->commit();                              //事务提交
        return true;
    }
    
    /**
     * 完成手机验证步骤
     */
    
    public function phone_verification($token,$phone){
    	$data = $this->provider->get_forgot($token,$phone);
        if(empty($data)){                                       //TOKEN错误
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        return $data;
    }

    /**
     * 是否存在指定TOKEN
     * @param  <string> $token TOKEN
     * @return <bool> 是否存在
     */
    public function exists_token($token){
        return $this->provider->exists_token($token);
    }
}
?>
