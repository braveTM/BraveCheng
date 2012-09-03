<?php
/**
 * Description of UserDomain
 *
 * @author hp
 */
class UserDomain {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new UserProvider();
    }

    /**
     * 登录
     * @param  <string> $username 用户名|邮箱|手机
     * @param  <string> $password 密码
     * @param  <bool>   $remember 是否记住登录状态
     * @return <AccountDomainModel> 账户模型
     */
    public function login($username, $password, $remember){
        if(!$this->check_password($password))           //密码格式错误
            return E(ErrorMessage::$PASSWORD_FORMAT_ERROR);
        $model = null;
        if($this->check_username($username)){           //用户名登录
            $model = $this->provider->get_user_by_username($username);
        }
        else if($this->check_email($username)){         //邮箱登录
            $model = $this->provider->get_user_by_email($username);
        }
        else if($this->check_phone($username)){         //手机登录
            $model = $this->provider->get_user_by_phone($username);
        }
        if($model != null){
            //用户被冻结
            if($model->__get('freeze') != 0)
                return E(ErrorMessage::$ACCOUNT_FREEZED);
            //用户密码错误
            if($model->__get('password') != encrypt_password($password))
                return E(ErrorMessage::$PASSWORD_ERROE);
            AccessControl::login($model, $remember);    //执行登录操作
            return $model;
        }
        return E(ErrorMessage::$ACCOUNT_NOT_EXISTS);
    }

    /**
     * 使用COOKIE自动登录
     * @param  <string> $username 用户名
     * @param  <string> $password 密码
     * @return <mixed> 账户信息
     */
    public function login_by_cookie($username, $password){
        $username = trim($username);
        $password = trim($password);
        if(!$this->check_username($username))
            return E(ErrorMessage::$USERNAME_FORMAT_ERROR);     //用户名格式错误
        $model = $this->provider->get_user_by_username($username);
        if($model != null){
            //用户被冻结
            if($model->__get('freeze') != 0)
                return E(ErrorMessage::$ACCOUNT_FREEZED);
            //用户密码错误
            if($model->__get('password') != encrypt_cpassword($password))
                return E(ErrorMessage::$PASSWORD_ERROE);
            return $model;
        }
        return E(ErrorMessage::$ACCOUNT_NOT_EXISTS);
    }

    /**
     * 用户注册
     * @param  <string> $username 用户名
     * @param  <string> $password 密码
     * @param  <string> $email    邮箱
     * @param  <int>    $role_id  角色编号
     * @return <bool> 是否成功
     */
    public function register($username, $password, $email, $role_id){
        //参数验证
        if(!$this->check_username($username)){
            return E(ErrorMessage::$USERNAME_FORMAT_ERROR);
        }
        if(!$this->check_password($password)){
            return E(ErrorMessage::$PASSWORD_FORMAT_ERROR);
        }
        if(!$this->check_email($email)){
            return E(ErrorMessage::$EMAIL_FORMAT_ERROR);
        }
        if(!$this->check_roleid($role_id)){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        if($this->exists_username($username)){
            return E(ErrorMessage::$USERNAME_EXISTS);
        }
        if( $this->exists_email($email)){
            return E(ErrorMessage::$EMAIL_EXISTS);
        }
        $password     = encrypt_password($password);        //密码加密
        $per_provider = new PermissionProvider();
        $role         = $per_provider->get_role($role_id);  //获取角色模型
        $activate     = 0;                                  //设置激活状态为未激活
        $expired      = time() + 30 * 86400;                //设置激活期限为一个月
        $package      = C('ROLE_PACKAGE_'.$role_id);        //获取角色基本套餐编号
        $user_type = $role->__get('user_type');             //用户类型
        unset($per_provider);                               //回收对象
        $this->provider->trans();                           //开启事务
        $user_id = $this->provider->add_user($username, $password, $email, $role_id, $activate, $expired, $package);     //添加账户
        if($user_id == false){                              //添加账户失败
            $this->provider->rollback ();                   //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $pro_provider = new ProfileProvider();
        if(!$pro_provider->add_profile($user_id, $username, $user_type)){
            $this->provider->rollback ();                   //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        unset($pro_provider);                               //回收对象
        $bill_provider = new BillProvider();
        if(!$bill_provider->add_bill($user_id, $username)){
            $this->provider->rollback ();                   //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        unset($bill_provider);                              //回收对象
        $this->provider->commit();                          //提交事务
        return true;
    }

    /**
     * 用户退出登录
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    public function logout($user_id){
        AccessControl::logout();
        return true;
    }

    /**
     * 获取指定账户
     * @param  <int> $user_id 用户编号
     * @return <mixed> 账户
     */
    public function get_account($user_id){
        return $this->provider->get_user_by_id($user_id);
    }
    
    /**
     * 修改密码
     * @param  <int>    $user_id 用户编号
     * @param  <string> $old_pwd 旧密码
     * @param  <string> $new_pwd 新密码
     * @return <bool> 是否成功
     */
    public function change_password($user_id, $ole_pwd, $new_pwd){
        $account = $this->provider->get_user_by_id($user_id);
        if(empty($account) || ($account->__get('password') != encrypt_password($ole_pwd)))
            return E(ErrorMessage::$OLD_PASSWORD_ERROE);
        if(!$this->check_password($new_pwd))
            return E(ErrorMessage::$NEW_PASSWORD_FORMAT_ERROE);
        if(!$this->provider->set_password_by_id($user_id, encrypt_password($new_pwd)))
            return E(ErrorMessage::$OPERATION_FAILED);
        return true;
    }

    /**
     * 根据用户编号获取角色编号
     * @param  <int> $user_id 用户编号
     * @return <int> 角色编号
     */
    public function get_role_by_id($user_id){
        return $this->provider->get_role_by_id($user_id);
    }

    /**
     * 用户名是否存在
     * @param  <string> $username 用户名
     * @return <bool> 是否存在
     */
    public function exists_username($username){
        return $this->provider->exists_username($username);
    }

    /**
     * 邮箱是否存在
     * @param  <string> $email 邮箱
     * @return <bool> 是否存在
     */
    public function exists_email($email){
        return $this->provider->exists_email($email);
    }

    /**
     * 手机号码是否存在
     * @param  <string> $phone 手机号码
     * @return <bool> 是否存在
     */
    public function exists_phone($phone){
        return $this->provider->exists_phone($phone);
    }

    /**
     * 获取指定编号套餐信息
     * @param  <int> $id 套餐编号
     * @return <array> 套餐信息
     */
    public function get_package($id){
        $provider = new PackageProvider();
        return $provider->get_package($id);
    }

    /**
     * 获取指定角色可拥有套餐列表
     * @param  <int>  $role_id 角色编号
     * @param  <bool> $include 是否包含系统默认套餐
     * @param  <int>  $exclude 排除指定套餐
     * @return <array> 套餐列表
     */
    public function get_packages($role_id, $include = false, $exclude = null){
        $provider = new PackageProvider();
        return $provider->get_packages($role_id, $include, $exclude);
    }

    /**
     * 更换用户套餐
     * @param  <int>    $user_id    用户编号
     * @param  <string> $user_name  用户名
     * @param  <int>    $package_id 套餐编号
     * @return <mixed>
     */
    public function change_package($user_id, $user_name, $package_id){
        $package = $this->check_package($package_id, $user_id);
        if(is_zerror($package)){
            return $package;
        }
        $user = $this->provider->get_user_by_id($user_id);
        $this->provider->trans();
        //消费
        $provider = new PackageProvider();
        $package  = $provider->get_package($package_id);
        $domain = new BillDomain();
        $result = $domain->consume($user_id, $user_name, $package['money'], '购买账户套餐:'.$package['name']);
        if(is_zerror($result)){
            $this->provider->rollback();                            //事务回滚
            return $result;
        }
        //更换套餐
        $last = $this->get_package_time($package['deadline'], $package['unit']);
        $time = time();
        if($user->__get('package') == $package_id && $user->__get('expired') > $time){
            $expired = $user->__get('expired') + $last;
        }
        else{
            $expired = $time + $last;
        }
        if(!$this->provider->set_user_package($user_id, $package_id, $expired)){
            $this->provider->rollback();                            //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();
        return true;
    }

    //-------------------protected-----------------------

    /**
     * 检测用户名是否合法
     * @param  <string> $username
     * @return <bool> 是否合法
     */
    protected function check_username($username){
        if(preg_match(REGULAR_USER_USERNAME, $username) == 1){
            //不能与手机号码格式一致
            return preg_match(REGULAR_USER_PHONE, $username) != 1;
        }
        return false;
    }
    
    /**
     * 检测密码是否合法
     * @param  <string> $password
     * @return <bool> 是否合法
     */
    protected function check_password($password){
        return true;
    }

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
     * 检测角色编号是否合法
     * @param  <type> $role_id 角色编号
     * @return <bool> 是否合法
     */
    protected function check_roleid($role_id){
        if($role_id > 999 || $role_id < 0)
            return false;
        $provider = new PermissionProvider();
        return $provider->exists_role_id($role_id);
    }

    /**
     * 检测手机号码是否合法
     * @param  <string> $phone 手机号码
     * @return <bool> 是否合法
     */
    protected function check_phone($phone){
        return preg_match(REGULAR_USER_PHONE, $phone) == 1;
    }
    
    /**
     * 检测套餐选取是否合法
     * @param  <int>    $id      套餐编号
     * @param  <int>    $user_id 用户编号
     * @return <mixed>
     */
    protected function check_package($id, $user_id){
        $ppvd    = new PackageProvider();
        $package = $ppvd->get_package($id);
        if(empty($package)){
            return E(ErrorMessage::$PACKAGE_NOT_EXISTS);            //套餐不存在
        }
        $upvd = new UserProvider();
        $role = $this->provider->get_role_by_id($user_id);
        if($role != $package['role_id']){
            return E(ErrorMessage::$PACKAGE_ROLE_ERROR);            //套餐角色错误
        }
        return $package;
    }

    /**
     * 获取套餐持续时间
     * @param  <int> $line 期限
     * @param  <int> $unit 单位
     * @return <int>
     */
    protected function get_package_time($line, $unit){
        switch ($unit){
            case 1  : $seconds = 86400;       break;
            case 2  : $seconds = 30 * 86400;  break;
            case 3  : $seconds = 365 * 86400; break;
            default : $seconds = 0;
        }
        return $line * $seconds;
    }
}
?>
