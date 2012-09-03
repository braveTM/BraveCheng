<?php
/**
 * Description of AuthDomain
 *
 * @author moi
 */
class AuthDomain{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new AuthProvider();
    }
    
    /**
     * 邮箱认证申请
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <string> $email     认证邮箱
     * @return <bool> 成功返回邮箱验证码
     */
    public function auth_email_apply($user_id, $user_name, $email){
        if(!$this->check_email($email)){                      //邮箱格式不正确
            return E(ErrorMessage::$EMAIL_FORMAT_ERROR);
        }
        $user_provider = new UserProvider();
        if($user_provider->exists_email($email) || $this->provider->exists_email($email)){
            return E(ErrorMessage::$EMAIL_EXISTS);               //邮箱已被占用
        }
        unset($user_provider);                                //回收对象
        $this->provider->trans();                             //开启事务
        if(!$this->provider->set_auth_email_del($user_id)){   //删除指定用户以前的邮箱认证记录
            $this->provider->rollback();                      //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $pro_provider = new ProfileProvider();
        if(!$pro_provider->set_user_auth_email($user_id, 0)){ //设置用户邮箱验证状态为未通过
            $this->provider->rollback();                      //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        unset($pro_provider);                                 //回收对象
        $code = md5(rand_string().time());                    //邮箱验证码
        //添加邮箱验证记录
        if(!$this->provider->add_auth_email_record($user_id, $user_name, $email, $code, date_f())){
            $this->provider->rollback();                      //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                            //提交事务
        return $code;
    }

    /**
     * 邮箱认证审核
     * @param  <int>    $user_id 用户编号
     * @param  <string> $code    邮箱验证码
     * @return <bool> 审核是否通过
     */
    public function auth_email_verify($user_id, $code){
        if(!$this->check_email_code($code)){        //验证邮箱验证码格式
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        //获取用户最近一次的邮箱认证记录
        $record = $this->provider->get_last_auth_email_record($user_id);    
        if($code != $record['code']){               //验证邮箱验证码有效性
            return E(ErrorMessage::$EMAIL_CODE_INVALID);
        }
        $this->provider->trans();                   //开启事务
        //设置邮箱验证申请为审核通过
        if(!$this->provider->set_auth_email_status($record['id'], 1, date_f())){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $pro_provider = new ProfileProvider();
        //设置用户已通过邮箱认证
        if(!$pro_provider->set_user_auth_email($user_id, 1)){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        unset($pro_provider);                       //回收对象
        $user_provider = new UserProvider();
        //修改用户邮箱
        if(!$user_provider->set_user_email($user_id, $record['email'])){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        unset($user_provider);                      //回收对象
        $this->provider->commit();                  //提交事务
        return true;
    }

    /**
     * 银行卡认证申请
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <int>    $bank_id   银行编号
     * @param  <string> $card_num  银行卡号
     * @return <bool> 申请是否成功
     */
    public function auth_bank_apply($user_id, $user_name, $bank_id, $card_num){
        //检测银行编号和银行卡号是否合法
        if(!$this->check_bank_id($bank_id) || !$this->check_card_num($card_num)){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        //检测银行卡号是否被使用过
        if($this->provider->exists_card_num($card_num)){
            return E(ErrorMessage::$CARDNUM_EXISTS);
        }
        $this->provider->trans();                   //开启事务
        //删除指定用户以前的银行卡认证记录
        if(!$this->provider->set_auth_bank_del($user_id)){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $provider = new ProfileProvider();
        //设置用户的银行卡认证状态为未认证
        if(!$provider->set_user_auth_bank($user_id, 0)){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //添加用户的银行卡认证申请记录
        if(!$this->provider->add_auth_bank_record($user_id, $user_name, $bank_id, $card_num, date_f())){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                  //提交事务
        return true;
    }

    /**
     * 银行卡认证审核
     * @param  <int> $auth_id 认证编号
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  审核状态状态
     * @return <bool> 审核是否通过
     */
    public function auth_bank_verify($auth_id, $user_id, $status){
        if(!$this->check_auth_status($status)){                 //审核状态不合法
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        $result = $this->check_auth_bank_record($auth_id, $user_id);
        if($result != true){      //记录不合法
            return $result;
        }
        $this->provider->trans();                               //开启事务
        //设置银行卡认证审核状态
        if(!$this->provider->set_auth_bank_status($auth_id, $status, date_f())){
            $this->provider->rollback();                        //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        if($status == 1){
            $provider = new ProfileProvider();
            //设置用户已通过银行卡认证
            if(!$provider->set_user_auth_bank($user_id, 1)){
                $this->provider->rollback();                    //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        $this->provider->commit();                              //提交事务
        return true;
    }

    /**
     * 手机认证申请
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <int>    $bank_id   手机号码
     * @return <bool> 申请是否成功
     */
    public function auth_phone_apply($user_id, $user_name, $phone){
        if(!$this->check_phone($phone)){
            return E(ErrorMessage::$PHONE_FORMAT_ERROR);   //手机号码不合法
        }
        $user_provider = new UserProvider();
        if($user_provider->exists_phone($phone) || $this->provider->exists_phone($phone)){
            return E(ErrorMessage::$PHONE_EXISTS);         //手机号码已被使用
        }
        unset($user_provider);                          //回收对象
        $this->provider->trans();                       //开启事务
        //删除指定用户以前的手机认证记录
        if(!$this->provider->set_auth_phone_del($user_id)){
            $this->provider->rollback();                //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $pro_provider = new ProfileProvider();
        //设置用户的手机认证状态为未认证
        if(!$pro_provider->set_user_auth_phone($user_id, 0)){
            $this->provider->rollback();                //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        unset($pro_provider);                           //回收对象
        $code = rand_string();                          //手机验证码
        //添加用户手机认证记录
        if(!$this->provider->add_auth_phone_record($user_id, $user_name, $phone, $code, date_f())){
            $this->provider->rollback();                //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                      //提交事务
        return $code;
    }

    /**
     * 手机认证审核
     * @param  <int>    $user_id 用户编号
     * @param  <string> $code    手机验证码
     * @return <bool> 审核是否通过
     */
    public function auth_phone_verify($user_id, $code){
        if(!$this->check_phone_code($code)){        //验证手机验证码格式
            return E(ErrorMessage::$PHONE_CODE_INVALID);
        }
        //获取用户最近一次的邮箱认证记录
        $record = $this->provider->get_last_auth_phone_record($user_id);
        if($code != $record['code']){               //验证手机验证码有效性
            return E(ErrorMessage::$PHONE_CODE_INVALID);
        }
        $this->provider->trans();                   //开启事务
        //设置手机验证申请为审核通过
        if(!$this->provider->set_auth_phone_status($record['id'], 1, date_f())){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $pro_provider = new ProfileProvider();
        //设置用户已通过手机认证
        if(!$pro_provider->set_user_auth_phone($user_id, 1)){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        unset($pro_provider);                       //回收对象
        $user_provider = new UserProvider();
        //修改用户手机
        if(!$user_provider->set_user_phone($user_id, $record['phone'])){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        unset($user_provider);                      //回收对象
        $this->provider->commit();                  //提交事务
        return true;
    }

    /**
     * 实名认证申请
     * @param  <int>    $user_id    用户编号
     * @param  <string> $user_name  用户名
     * @param  <int>    $real_name  真实名称
     * @param  <int>    $real_num   相关编号
     * @param  <int>    $attachment 附件
     * @return <bool> 申请是否成功
     */
    public function auth_real_apply($user_id, $user_name, $real_name, $real_num, $attachment){
        if($this->provider->exists_auth_real($user_id)){
            return E(ErrorMessage::$REAL_AUTHED);              //用户已进行过实名认证
        }
        $real_name = $this->filter_real_name($real_name);
        if(!$this->check_real_name($real_name) || !$this->check_real_num($real_num) || !$this->check_real_atta($attachment)){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);   //参数有误
        }
        if($this->provider->exists_id_number($real_num)){
            return E(ErrorMessage::$IDNUM_EXISTS);             //指定证件号码已被使用
        }
        $result = $this->provider->add_auth_real_record($user_id, $user_name, $real_name, $real_num, $attachment, date_f());
        if($result == true)
            return true;
        return E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 实名认证审核
     * @param  <int> $auth_id 认证编号
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  审核状态
     * @return <bool> 审核是否通过
     */
    public function auth_real_verify($auth_id, $user_id, $status){
        if(!$this->check_auth_status($status)){                 //审核状态不合法
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        $result = $this->check_auth_real_record($auth_id, $user_id);
        if($result != true){ //记录不合法
            return $result;
        }
        $this->provider->trans();                               //开启事务
        //设置实名认证审核状态
        if(!$this->provider->set_auth_real_status($auth_id, $status, date_f())){
            $this->provider->rollback();                        //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        if($status == 1){
            $provider = new ProfileProvider();
            //设置用户已通过实名认证
            if(!$provider->set_user_auth_real($user_id, 1)){
                $this->provider->rollback();                    //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        $this->provider->commit();                              //提交事务
        return true;
    }

    //----------------protected---------------

    /**
     * 检测邮箱是否合法
     * @param  <string> $email
     * @return <bool> 是否合法
     */
    protected function check_email($email){
        if(strlen($email) > 100)
            return false;
        return preg_match(REGULAR_USER_EMAIL, $email) == 1;
    }

    /**
     * 检测邮箱验证码是否合法
     * @param  <string> $code 验证码
     * @return <bool> 是否合法
     */
    protected function check_email_code($code){
        return preg_match(REGULAR_EMAIL_CODE, $code) == 1;
    }

    /**
     * 检测银行编号的合法性
     * @param  <int> $bank_id 银行编号
     * @return <bool> 是否合法
     */
    protected function check_bank_id($bank_id){
        $provider = new BankProvider();
        return $provider->exists_bank_id($bank_id);
    }

    /**
     * 检测银行卡号的合法性
     * @param  <string> $card_num 银行卡号
     * @return <bool> 是否合法
     */
    protected function check_card_num($card_num){
        if((strlen($card_num) == 19) && ctype_alnum($card_num)) return true;
        return false;
    }

    /**
     * 检测审核状态的合法性
     * @param  <int> $status 状态
     * @return <bool> 是否合法
     */
    protected function check_auth_status($status){
        switch ($status){
            case 1  :
            case 2  : return true;
            default : return false;
        }
    }

    /**
     * 检测指定银行卡认证记录的合法性
     * @param  <int> $auth_id 认证编号
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否合法
     */
    protected function check_auth_bank_record($auth_id, $user_id){
        $record = $this->provider->get_auth_bank($auth_id);
        if(empty($record))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);        //没有指定记录
        if($record['status'] != 0 )
            return E(ErrorMessage::$RECORD_CHECKED);           //记录已被审核
        if($record['user_id'] != $user_id )
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);   //记录不属于指定用户
        return true;
    }

    /**
     * 验证手机号码是否合法
     * @param  <string> $phone 手机号码
     * @return <bool> 是否合法
     */
    protected function check_phone($phone){
        return preg_match(REGULAR_USER_PHONE, $phone) == 1;
    }

    /**
     * 验证手机验证码是否合法
     * @param  <string> $code 手机验证码
     * @return <bool> 是否合法
     */
    protected function check_phone_code($code){
        return preg_match(REGULAR_PHONE_CODE, $code) == 1;
    }

    /**
     * 检测真实姓名是否合法
     * @param  <string> $name 真实姓名
     * @return <bool> 是否合法
     */
    protected function check_real_name($name){
        //return preg_match(REGULAR_REALNAME, $name) == 1;
        return strlen($name) <= 60;
    }

    /**
     * 真实姓名转义
     * @param  <string> $name 真实姓名
     * @return <string>
     */
    protected function filter_real_name($name){
        return htmlspecialchars($name);
    }


    /**
     * 检测身份证号码是否合法
     * @param  <string> $num 身份证号码
     * @return <bool> 是否合法
     */
    protected function check_real_num($num){
        if(preg_match('/^\w{6,50}$/', $num) == 1){
            return true;
        }
        return false;
    }

    /**
     * 检测附近是否合法
     * @param  <string> $atta 附件
     * @return <bool> 是否合法
     */
    protected function check_real_atta($atta){
        return strlen($atta) <= 300;
    }

    /**
     * 检测指定实名认证记录的合法性
     * @param  <int> $auth_id 记录编号
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否合法
     */
    protected function check_auth_real_record($auth_id, $user_id){
        $record = $this->provider->get_auth_real($auth_id);
        if(empty($record))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);        //没有指定记录
        if($record['status'] != 0)
            return E(ErrorMessage::$RECORD_CHECKED);           //记录已被审核
        if($record['user_id'] != $user_id )
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);   //记录不属于指定用户
        return true;
    }

    /**
     * 获取指定用户的实名认证信息
     * @param  <int> $user_id 用户编号
     * @return <mixed> 认证信息
     */
    public function get_real_auth($user_id){
        return $this->provider->get_last_auth_real_record($user_id, 1);
    }

    /**
     * 获取指定用户的手机认证信息
     * @param  <int> $user_id 用户编号
     * @return <mixed> 认证信息
     */
    public function get_phone_auth($user_id){
        return $this->provider->get_last_auth_phone_record($user_id, 1);
    }

    /**
     * 获取指定用户的邮箱认证信息
     * @param  <int> $user_id 用户编号
     * @return <mixed> 认证信息
     */
    public function get_email_auth($user_id){
        return $this->provider->get_last_auth_email_record($user_id, 1);
    }

    /**
     * 获取指定用户的银行卡认证信息
     * @param  <int> $user_id 用户编号
     * @return <mixed> 认证信息
     */
    public function get_bank_auth($user_id){
        return $this->provider->get_last_auth_bank_record($user_id, 1);
    }
}
?>
