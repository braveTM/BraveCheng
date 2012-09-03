<?php
/**
 * Description of AuthService
 *
 * @author moi
 */
class AuthService{
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
     * @return <bool> 申请是否成功
     */
    public function auth_email_apply($user_id, $user_name, $email){
        if(!$this->check_email($email)){                      //邮箱格式不正确
            return E(ErrorMessage::$EMAIL_FORMAT_ERROR);
        }
        $user_provider = new UserProvider();
        if($user_provider->exists_email($email)){
            return E(ErrorMessage::$EMAIL_EXISTS);               //邮箱已被占用
        }
        unset($user_provider);                                //回收对象
        $auth = $this->provider->get_last_auth_email_record($user_id, 1);
        if(!empty($auth)){
            return E('邮箱认证暂时不提供修改');
        }
        $this->provider->trans();                             //开启事务
        if(!$this->provider->set_auth_email_del($user_id)){   //删除指定用户以前的邮箱认证记录
            $this->provider->rollback();                      //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $user_provider = new UserProvider();
        if(!$user_provider->update_user($user_id, array('is_email_auth' => 0))){
            $this->provider->rollback();                      //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
//        $pro_provider = new ProfileProvider();
//        if(!$pro_provider->set_user_auth_email($user_id, 0)){ //设置用户邮箱验证状态为未通过
//            $this->provider->rollback();                      //回滚事务
//            return E(ErrorMessage::$OPERATION_FAILED);
//        }
//        unset($pro_provider);                                 //回收对象
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
        $user_provider = new UserProvider();
        //设置用户已通过邮箱认证
        if(!$user_provider->update_user($user_id, array('is_email_auth' => 1))){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $user = $user_provider->get_user_info($user_id);
        if($user['role_id'] == C('ROLE_TALENTS')){
            $hp = new HumanProvider();
            if(!$hp->updateHuman($user['data_id'], array('contact_email' => $record['email']))){
                $this->provider->rollback();            //回滚事务
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        else if($user['role_id'] == C('ROLE_ENTERPRISE')){
            $cp = new CompanyProvider();
            if(!$cp->updateCompany($user['data_id'], array('contact_email' => $record['email']))){
                $this->provider->rollback();            //回滚事务
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        else if($user['role_id'] == C('ROLE_AGENT')){
            $mp = new MiddleManProvider();
            if(!$mp->updateMiddleMan($user['data_id'], array('contact_email' => $record['email']))){
                $this->provider->rollback();            //回滚事务
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        else if($user['role_id'] == C('ROLE_SUBCONTRACTOR')){
            
        }
        unset($user_provider);                      //回收对象
        $this->provider->commit();                  //提交事务
        $service = new ContactsService();
        $service->moving_through_auth($user_id, 3);
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
        if($user_provider->exists_phone($phone)){
            return E(ErrorMessage::$PHONE_EXISTS);         //手机号码已被使用
        }
        $auth = $this->provider->get_last_auth_phone_record($user_id, 1);
        if(!empty($auth)){
            return E('手机认证暂时不提供修改');
        }
        $this->provider->trans();                       //开启事务
        //删除指定用户以前的手机认证记录
        if(!$this->provider->set_auth_phone_del($user_id)){
            $this->provider->rollback();                //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //设置用户的手机认证状态为未认证
        if(!$user_provider->update_user($user_id, array('is_phone_auth' => 0))){
            $this->provider->rollback();                //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $code = rand_string(6, 1);                      //手机验证码
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
        //获取用户最近一次的手机认证记录
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
//        $pro_provider = new ProfileProvider();
//        //设置用户已通过手机认证
//        if(!$pro_provider->set_user_auth_phone($user_id, 1)){
//            $this->provider->rollback();            //回滚事务
//            return E(ErrorMessage::$OPERATION_FAILED);
//        }
//        unset($pro_provider);                       //回收对象
        $user_provider = new UserProvider();
//        //修改用户手机
//        if(!$user_provider->set_user_phone($user_id, $record['phone'])){
//            $this->provider->rollback();            //回滚事务
//            return E(ErrorMessage::$OPERATION_FAILED);
//        }
        //设置用户手机认证，设置用户手机号
        if(!$user_provider->update_user($user_id, array('phone' => $record['phone'], 'is_phone_auth' => 1))){
            $this->provider->rollback();            //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $user = $user_provider->get_user_info($user_id);
        if($user['role_id'] == C('ROLE_TALENTS')){
            $hp = new HumanProvider();
            if(!$hp->updateHuman($user['data_id'], array('contact_mobile' => $record['phone']))){
                $this->provider->rollback();            //回滚事务
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        else if($user['role_id'] == C('ROLE_ENTERPRISE')){
            $cp = new CompanyProvider();
            if(!$cp->updateCompany($user['data_id'], array('contact_mobile' => $record['phone']))){
                $this->provider->rollback();            //回滚事务
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        else if($user['role_id'] == C('ROLE_AGENT')){
            $mp = new MiddleManProvider();
            if(!$mp->updateMiddleMan($user['data_id'], array('contact_mobile' => $record['phone']))){
                $this->provider->rollback();            //回滚事务
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        else if($user['role_id'] == C('ROLE_SUBCONTRACTOR')){

        }
        unset($user_provider);                      //回收对象
        $this->provider->commit();                  //提交事务
        $service = new ContactsService();
        $service->moving_through_auth($user_id, 2);
        return true;
    }

    /**
     * 个人实名认证申请
     * @param  <int>    $user_id 用户编号
     * @param  <string> $name    真实姓名
     * @param  <string> $number  身份证号码
     * @param  <string> $c_front 身份证正面复印件
     * @param  <string> $c_back  身份证背面复印件
     * @param  <string> $photo   用户头像
     * @return <bool> 申请是否成功
     */
    public function auth_real_person_apply($user_id, $name, $number, $c_front, $c_back, $photo, $c_need = true){
        if(!var_validation($name, VAR_NAME)){
            return E(ErrorMessage::$NAME_FORMAT_ERROR);
        }
        if(!var_validation($number, VAR_IDNUM)){
            return E(ErrorMessage::$IDNUM_FORMAT_ERROR);
        }
        if($c_need){
            if(!var_validation($c_front, VAR_SFILE) || !var_validation($c_back, VAR_SFILE)){
                return E(ErrorMessage::$FILE_PATH_ERROR);
            }
        }
        if($this->exists_idnum($number, $user_id)){
            return E(ErrorMessage::$IDNUM_EXISTS);
        }
        $provider = new UserProvider();
        if(!empty($photo)){                                                     //头像不为空
            if(!var_validation($photo, VAR_SFILE)){
                return E(ErrorMessage::$FILE_PATH_ERROR);
            }
            if(!$provider->update_user($user_id, array('photo' => $photo))){    //修改账户头像
                return E();
            }
        }
        else{
            $user = $provider->get_user_info($user_id);
            $photo = $user['photo'];
        }
        $auth = $this->provider->get_real_auth($user_id);       //获取指定用户的实名认证记录
        $this->provider->trans();                               //事务开启
        if(empty($auth)){
            //增加个人认证记录
            $record = $this->provider->add_person_auth($name, $number, $c_front, $c_back, $photo);
            if(!$record){
                $this->provider->rollback();                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
            //增加用户实名认证记录
            if(!$this->provider->add_auth_real($user_id, $record, 1, date_f())){
                $this->provider->rollback();                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        else{
            return E('实名认证无法修改');
            //更新个人认证记录
            if(!$this->provider->update_auth_person($auth['auth_id'], $name, $number, $c_front, $c_back, $photo)){
                $this->provider->rollback();                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
            //更新用户实名认证记录
            if(!$this->provider->update_auth_real($auth['id'], 0, date_f())){
                $this->provider->rollback();                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        $this->provider->commit();                              //事务提交
        return true;
    }

    /**
     * 企业实名认证申请
     * @param  <int>    $user_id 用户编号
     * @param  <string> $name    企业名称
     * @param  <string> $number  营业执照号码
     * @param  <string> $code    组织机构代码
     * @param  <string> $picture 营业执照复印件
     * @param  <int>    $data_id 资料编号
     * @return <bool> 申请是否成功
     */
    public function auth_real_enterprise_apply($user_id, $name, $number, $code, $picture, $data_id){
        if(!var_validation($name, VAR_ENAME)){
            return E(ErrorMessage::$ENAME_FORMAT_ERROR);
        }
        if(!var_validation($number, VAR_LNUM)){
            return E(ErrorMessage::$LNUM_FORMAT_ERROR);
        }
        if(!var_validation($code, VAR_SFILE)){
            return E(ErrorMessage::$FILE_PATH_ERROR);
        }
        if(!var_validation($picture, VAR_SFILE)){
            return E(ErrorMessage::$FILE_PATH_ERROR);
        }
        if($this->exists_lnum($number, $user_id)){
            return E(ErrorMessage::$LNUM_EXISTS);
        }
        $auth = $this->provider->get_real_auth($user_id);       //获取指定用户的实名认证记录
        $this->provider->trans();                               //事务开启
        if(empty($auth)){
            //增加企业认证记录
            $record = $this->provider->add_enterprise_auth($name, $number, $code, $picture);
            if(!$record){
                $this->provider->rollback();                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
            //增加用户实名认证记录
            if(!$this->provider->add_auth_real($user_id, $record, 2, date_f())){
                $this->provider->rollback();                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        else{
            //更新企业认证记录
            if(!$this->provider->update_auth_enterprise($record['auth_id'], $name, $number, $code, $picture)){
                $this->provider->rollback();                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
            //更新用户实名认证记录
            if(!$this->provider->update_auth_real($auth['id'], 0, date_f())){
                $this->provider->rollback();                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        
        $provider = new CompanyProvider();
        //修改用户企业名称
        if(!$provider->updateCompany($data_id, array('company_name' => $name))){
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                              //事务提交
        return true;
    }

    /**
     * 获取指定用户的实名认证信息
     * @param  <int> $user_id 用户编号
     * @return <mixed> 认证信息
     */
    public function get_real_auth($user_id){
        $result = $this->provider->get_real_auth($user_id);
        if(empty($result))
            return null;
        if($result['type'] == 1){
            $result['_info'] = $this->provider->get_real_person($result['auth_id']);
        }
        else{
            $result['_info'] = $this->provider->get_real_enterprise($result['auth_id']);
        }
        return $result;
        //return $this->provider->get_last_auth_real_record($user_id, 1);
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

    /**
     * 检测身份证号码是否存在
     * @param  <string> $num 身份证号码
     * @return <bool>
     */
    public function exists_idnum($num, $user_id){
        $record = $this->provider->get_record_by_idnum($num);
        if(!empty($record)){
            $real = $this->provider->get_real_auth_by_auth_id($record['id'], 1);
            if($real['status'] != 2 && $real['user_id'] != $user_id){
                return true;
            }
        }
        return false;
    }

    /**
     * 检测营业执照号码是否存在
     * @param  <string> $num 营业执照号码
     * @return <bool>
     */
    public function exists_lnum($num, $user_id){
        $record = $this->provider->get_record_by_lnum($num);
        if(!empty($record)){
            $real = $this->provider->get_real_auth_by_auth_id($record['id'], 2);
            if($real['status'] != 2 && $real['user_id'] != $user_id){
                return true;
            }
        }
        return false;
    }

    /**
     * 检测组织机构代码是否存在
     * @param  <string> $code 组织机构代码
     * @return <bool>
     */
    public function exists_ocode($code, $user_id){
        $record = $this->provider->get_record_by_ocode($code);
        if(!empty($record)){
            $real = $this->provider->get_real_auth_by_auth_id($record['id'], 2);
            if($real['status'] != 2 && $real['user_id'] != $user_id){
                return true;
            }
        }
        return false;
    }
    
    /**
     * 经纪人认证成功后修改头像
     * @param int $user_id 用户编号
     * @return
     */
    public function real_auth_suc($user_id){
        $record = $this->provider->get_real_auth($user_id);
        if(!empty($record) && $record['type'] == 1){
            $real = $this->provider->get_real_person($auth_id);
            if(!empty($real) && $real['photo'] != C('PATH_DEFAULT_AVATAR')){
                $service = new UserService();
                $service->update_photo($user_id, $real['photo']);
            }
        }
        
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
}
?>
