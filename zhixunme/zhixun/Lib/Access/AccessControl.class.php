<?php
/**
 * Description of AccessControl
 *
 * @author moi
 */
require_cache(APP_PATH.'/Common/Function/crypt.php');

define('COOKIE_ACCOUNT', 'zx_ac');
define('COOKIE_ACCOUNT_USERID', 'id');
define('COOKIE_ACCOUNT_EMAIL', 'em');
define('COOKIE_ACCOUNT_TOKEN', 'to');
define('COOKIE_ACCOUNT_CID', 'cid');

define('SESSION_ACCOUNT', 'zx_account');
define('SESSION_ACCOUNT_USERID', 'userid');
define('SESSION_ACCOUNT_ACTIVATE', 'activate');
define('SESSION_ACCOUNT_ROLE', 'roleid');;
define('SESSION_ACCOUNT_DATAID', 'dataid');
define('SESSION_ACCOUNT_PACKAGE', 'package');
define('SESSION_ACCOUNT_GROUPID', 'groupid');
define('SESSION_ACCOUNT_PERFECT', 'perfect');
define('SESSION_TELENT_RESUME', 'resumeid');
define('SESSION_TELENT_DEGREE', 'degreeid');
define('SESSION_TELENT_INTENT', 'intentid');
define('SESSION_TELENT_HANGCD', 'hangcardid');
define('SESSION_POPUP', 'popup');

define('SESSION_TASK', 'zx_task');
define('SESSION_TASK_POSTED', 'posted');

class AccessControl {
    /**
     * 认证
     */
    public static function authenticate(){
        AccessControl::check_status();
        if(!AccessControl::check_access()){
            AccessControl::auth_failed();
        }
    }

    /**
     * 登录
     * @param <AccountDomainModel> $model    账户模型
     * @param <bool>               $remember 是否记住登录状态
     */
    public static function login(AccountDomainModel $model, $remember, $token){
        $model->__set('password', decrypt_cpassword($model->__get('password')));
        CookieSession::set_account_cookie($model, $remember, $token);
        CookieSession::set_account_session($model);
        CookieSession::set_popup_session(1);
    }

    /**
     * 退出登录
     */
    public static function logout(){
        CookieSession::clear_account_cookie();
        CookieSession::clear_account_session();
    }

    /**
     * 检查用户登录状态
     */
    public static function check_status(){
        if(!CookieSession::exists_account_cookie()){                //COOKIE不存在
            if(CookieSession::exists_account_session()){            //SESSION存在
                CookieSession::clear_account_session();             //清除SESSION信息
            }
        }
        else{                                                       //COOKIE存在
            if(!CookieSession::exists_account_session()){           //SESSION不存在
                $service = new UserService();
                $account = $service->login_by_cookie(CookieSession::get_userid_cookie(), CookieSession::get_token_cookie());
                if($account == null || is_zerror($account)){                               //使用COOKIE数据登录失败
                    CookieSession::clear_account_cookie();          //清除COOKIE
                }
                else{                                               //使用COOKIE数据登录成功
                    CookieSession::set_account_session($account);   //设置账户SESSION
                }
            }
        }
    }

    /**
     * 是否登录
     */
    public static function is_logined(){
        return CookieSession::get_userid_session() != null;
    }

    /**
     * 权限验证
     * @return <bool> 是否有权限
     */
    public static function check_access(){
        if(AccessControl::is_logined()){
            AccessControl::check_activate();        //登录后验证用户激活状态
        }
        $service = new PermissionService();
        $action  = AccessControl::get_action_code();
        if(AccessControl::is_logined() && intval(CookieSession::get_activate_session()) == 0){  //账户未激活
            //$result = $service->check_role_not_active_permission(AccessControl::get_role_id(), $action);
            $result = $service->check_role_permission(AccessControl::get_role_id(), $action);
        }
        else{                                                                               //验证操作权限
            $result = $service->check_role_permission(AccessControl::get_role_id(), $action);
        }
        if(!$result){
            $result = $service->check_role_permission(C('ROLE_PUBLIC'), $action);           //公共操作
        }
        return $result;
    }

    /**
     * 检测角色指定任务分类的指定操作权限
     * @param  <int> $class_id 任务分类
     * @param  <int> $type     操作类型（1、发布 2、竞标）
     * @return <bool> 是否有权限
     */
    public static function check_class($class_id, $type){
        $service = new PermissionService();
        return $service->check_role_task_class(AccessControl::get_role_id(), $class_id, $type);
    }

    /**
     * 权限认证失败
     */
    public static function auth_failed(){
        $auth = new Auth();
        if(AccessControl::is_do_action()){
            switch (AccessControl::get_role_id()){
                case C('ROLE_ANONYMOUS')    : $auth->set_property(2, C('LOGIN_PROMPT')); break;           //匿名用户
                case C('ROLE_NOACTIVATION') : $auth->set_property(2, C('LOGIN_PROMPT')); break;           //未激活用户
                default : $auth->set_property(2, C('PERMISSION_PROMPT'));                                 //注册用户
            }
        }
        else{
            switch (AccessControl::get_role_id()){
                case C('ROLE_ANONYMOUS')    : $auth->set_property(1, C('WEB_ROOT').'/login?redirect=http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]); break;           //匿名用户
                case C('ROLE_NOACTIVATION') : $auth->set_property(1, C('WEB_ROOT').'/error'); break;           //未激活用户
                default : $auth->set_property(1, C('WEB_ROOT').'/homepage');                                   //注册用户
            }
        }
        $auth->run();
    }

    /**
     * 完成注册
     */
    public static function finish_register(){
        CookieSession::set_perfect_session(1);
    }

    /**
     * 完成完善资料
     */
    public static function finish_perfect(){
        CookieSession::set_perfect_session(0);
    }

    /**
     * 检测完善资料状态
     */
    public static function check_perfect(){
        return intval(CookieSession::get_perfect_session()) == 1;
    }

    /**
     * 完成任务发布
     * @param <int> $id 任务编号
     */
    public static function finish_tpost($id){
        CookieSession::set_tpost_session($id);
    }

    /**
     * 获取完成任务编号
     */
    public static function get_tpost(){
        return intval(CookieSession::get_tpost_session());
    }

    /**
     * 结束任务成功发布
     */
    public static function finish_tpostsuc(){
        CookieSession::set_tpost_session(0);
    }

    /**
     * 更改当前用户套餐
     */
    public static function set_package($value){
        CookieSession::set_package_session($value);
    }

    /**
     * 设置TOKEN COOKIE
     * @param <string> $token
     */
    public static function set_token_cookie($token){
        CookieSession::set_token_cookie($token);
    }
    
    /**
     * 是否允许弹出框 
     */
    public static function allow_popup(){
        if(CookieSession::get_popup_session()){
            return true;
        }
        return false;
    }
    
    /**
     * 关闭弹出框 
     */
    public static function close_popup(){
        CookieSession::clear_popup_session();
    }

    //---------------protected--------------
    /**
     * 检测账户是否激活
     * @return <bool> 是否激活
     */
    protected static function check_activate(){
        if(intval(CookieSession::get_activate_session()) == 0){
            $service = new UserService();
            $user = $service->get_account(CookieSession::get_userid_session());
            if($user->__get('activate') == 1){
                CookieSession::set_activate_session(1);
            }
        }
    }

    /**
     * 获取当期用户角色编号
     * @return <int> 角色编号
     */
    protected static function get_role_id(){
        if(CookieSession::exists_account_session()){
            return intval(CookieSession::get_role_session());
        }
        return C('ROLE_ANONYMOUS');
    }

    /**
     * 获取当期操作代码
     * @return <string> 操作代码
     */
    protected static function get_action_code(){
        return GROUP_NAME.'/'.MODULE_NAME.'/'.ACTION_NAME;
    }

    /**
     * 是否请求类操作
     * @return <bool> 
     */
    protected static function is_do_action(){
        if(substr(ACTION_NAME, 0, 3) == 'do_' || substr(ACTION_NAME, 0, 4) == 'get_')
            return true;
        return false;
    }
}

class CookieSession {
    //-----------------COOKIE-----------------
    /**
     * 检测是否存在账户COOKIE
     * @return <mixed>
     */
    public static function exists_account_cookie(){
        return !empty($_COOKIE[COOKIE_ACCOUNT][COOKIE_ACCOUNT_USERID]);
    }

    /**
     * 获取COOKIE中的用户编号
     * @return <int> 用户编号
     */
    public static function get_userid_cookie(){
        return decrypt_cookie($_COOKIE[COOKIE_ACCOUNT][COOKIE_ACCOUNT_USERID]);
    }

    /**
     * 获取COOKIE中的邮箱
     * @return <string> 邮箱
     */
    public static function get_email_cookie(){
        return decrypt_cookie($_COOKIE[COOKIE_ACCOUNT][COOKIE_ACCOUNT_EMAIL]);
    }

    /**
     * 获取COOKIE中的TOKEN
     * @return <string> TOKEN
     */
    public static function get_token_cookie(){
        return decrypt_cookie($_COOKIE[COOKIE_ACCOUNT][COOKIE_ACCOUNT_TOKEN]);
    }

    /**
     * 设置COOKIE中的TOKEN
     * @param <string> $token TOKEN
     */
    public static function set_token_cookie($token){
        setcookie(COOKIE_ACCOUNT.'['.COOKIE_ACCOUNT_TOKEN.']', encrypt_cookie($token), time() + C('COOKIE_TIME'), C('COOKIE_PATH'), C('COOKIE_DOMAIN'));
    }

    /**
     * 设置账户COOKIE
     * @param <AccountDomainModel> $model 账户模型
     */
    public static function set_account_cookie(AccountDomainModel $model, $remember, $token){
        $last = $remember ? C('COOKIE_LONG_TIME') : C('COOKIE_TIME');
        $t = time() + $last;
        //设置用户编号COOKIE
        setcookie(COOKIE_ACCOUNT.'['.COOKIE_ACCOUNT_USERID.']', encrypt_cookie($model->__get('user_id')), $t, C('COOKIE_PATH'), C('COOKIE_DOMAIN'));
        //设置邮箱COOKIE
        setcookie(COOKIE_ACCOUNT.'['.COOKIE_ACCOUNT_EMAIL.']', encrypt_cookie($model->__get('email')), $t, C('COOKIE_PATH'), C('COOKIE_DOMAIN'));
        //设置TOKEN COOKIE
        setcookie(COOKIE_ACCOUNT.'['.COOKIE_ACCOUNT_TOKEN.']', encrypt_cookie($token), $t, C('COOKIE_PATH'), C('COOKIE_DOMAIN'));
        setcookie(COOKIE_ACCOUNT.'['.COOKIE_ACCOUNT_CID.']', md5($model->__get('user_id')), $t, C('COOKIE_PATH'), C('COOKIE_DOMAIN'));
    }

    /**
     * 清除账户COOKIE
     */
    public static function clear_account_cookie(){
        $t = time() - 86400;
        //设置用户编号COOKIE过期
        setcookie(COOKIE_ACCOUNT.'['.COOKIE_ACCOUNT_USERID.']', '', $t, C('COOKIE_PATH'), C('COOKIE_DOMAIN'));
        //设置邮箱COOKIE过期
        setcookie(COOKIE_ACCOUNT.'['.COOKIE_ACCOUNT_EMAIL.']', '', $t, C('COOKIE_PATH'), C('COOKIE_DOMAIN'));
        //设置TOKEN COOKIE过期
        setcookie(COOKIE_ACCOUNT.'['.COOKIE_ACCOUNT_TOKEN.']', '', $t, C('COOKIE_PATH'), C('COOKIE_DOMAIN'));
        setcookie(COOKIE_ACCOUNT.'['.COOKIE_ACCOUNT_CID.']', '', $t, C('COOKIE_PATH'), C('COOKIE_DOMAIN'));
    }

    //-----------------SESSION-----------------
    /**
     * 获取完善资料SESSION
     */
    public static function get_perfect_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_PERFECT];
    }

    /**
     * 设置完善资料SESSION
     */
    public static function set_perfect_session($value){
        $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_PERFECT] = $value;
    }
    /**
     * 获取完成任务发布SESSION
     */
    public static function get_tpost_session(){
        return $_SESSION[SESSION_TASK][SESSION_TASK_POSTED];
    }

    /**
     * 设置完成任务发布SESSION
     */
    public static function set_tpost_session($value){
        $_SESSION[SESSION_TASK][SESSION_TASK_POSTED] = $value;
    }

    /**
     * 检测是否存在账户SESSION
     * @return <mixed>
     */
    public static function exists_account_session(){
        return !empty($_SESSION[SESSION_ACCOUNT]);
    }

    /**
     * 获取SESSION中的激活状态
     * @return <string> 激活状态
     */
    public static function get_activate_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_ACTIVATE];
    }

    /**
     * 获取SESSION中的角色编号
     * @return <string> 角色编号
     */
    public static function get_role_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_ROLE];
    }

    /**
     * 获取SESSION中的资料编号
     * @return <string> 资料编号
     */
    public static function get_data_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_DATAID];
    }

    /**
     * 获取SESSION中的用户编号
     * @return <string> 用户编号
     */
    public static function get_userid_session(){
        if(!isset($_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_USERID])){
            return null;
        }
        else{
            return $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_USERID];
        }
    }

    /**
     * 获取SESSION中的用户组编号
     * @return <string> 用户组编号
     */
    public static function get_groupid_session(){
        if(!isset($_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_GROUPID])){
            return null;
        }
        else{
            return $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_GROUPID];
        }
    }

    /**
     * 获取SESSION中的套餐编号
     * @return <string> 套餐编号
     */
    public static function get_package_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_PACKAGE];
    }

    /**
     * 设置SESSION中的套餐编号
     */
    public static function set_package_session($value){
        $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_PACKAGE] = $value;
    }

    /**
     * 设置SESSION中的激活状态
     */
    public static function set_activate_session($value){
        $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_ACTIVATE] = $value;
    }

    /**
     * 设置账户SESSION
     * @param <AccountDomainModel> $model 账户模型
     */
    public static function set_account_session(AccountDomainModel $model){
        $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_USERID]   = $model->__get('user_id');
        $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_ACTIVATE] = $model->__get('activate');
        $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_ROLE]     = $model->__get('role_id');
        $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_DATAID]   = $model->__get('data_id');
        $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_PACKAGE]  = $model->__get('package');
        $_SESSION[SESSION_ACCOUNT][SESSION_ACCOUNT_GROUPID]  = $model->__get('group_id');
        if($model->__get('role_id') == C('ROLE_TALENTS')){
            $svc     = new HumanService();
            $human   = $svc->get_human($model->__get('data_id'));
            $service = new ResumeService();
            $resume  = $service->getResume($human['resume_id']);
            self::set_talent_session($resume['resume_id'], $resume['degree_id'], $resume['job_intent_id'], $resume['hang_card_intent_id']);
        }
    }

    /**
     * 设置人才SESSION
     * @param <int> $rid 简历编号
     * @param <int> $did 学历编号
     * @param <int> $iid 求职意向
     * @param <int> $hid 挂证意向
     */
    public static function set_talent_session($rid, $did, $iid, $hid){
        $_SESSION[SESSION_ACCOUNT][SESSION_TELENT_RESUME] = $rid;
        $_SESSION[SESSION_ACCOUNT][SESSION_TELENT_DEGREE] = $did;
        $_SESSION[SESSION_ACCOUNT][SESSION_TELENT_INTENT] = $iid;
        $_SESSION[SESSION_ACCOUNT][SESSION_TELENT_HANGCD] = $hid;
    }

    /**
     * 获取简历编号SESSION
     * @return <string>
     */
    public static function get_resume_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_TELENT_RESUME];
    }

    /**
     * 获取学历编号SESSION
     * @return <string>
     */
    public static function get_degree_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_TELENT_DEGREE];
    }

    /**
     * 获取求职意向编号SESSION
     * @return <string>
     */
    public static function get_intent_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_TELENT_INTENT];
    }

    /**
     * 获取挂证意向编号SESSION
     * @return <string>
     */
    public static function get_hangcd_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_TELENT_HANGCD];
    }

    /**
     * 清除账户SESSION
     */
    public static function clear_account_session(){
        $_SESSION[SESSION_ACCOUNT] = array();
    }

    /**
     * 设置弹出框SESSION
     * @return <string>
     */
    public static function set_popup_session($value){
        $_SESSION[SESSION_ACCOUNT][SESSION_POPUP] = $value;
    }

    /**
     * 获取弹出框SESSION
     * @return <string>
     */
    public static function get_popup_session(){
        return $_SESSION[SESSION_ACCOUNT][SESSION_POPUP];
    }

    /**
     * 清除弹出框SESSION
     */
    public static function clear_popup_session(){
        $_SESSION[SESSION_ACCOUNT][SESSION_POPUP] = null;
    }
}

class AccountInfo{
    /**
     * 获取当前用户编号
     * @return <int> 用户编号
     */
    public static function get_user_id(){
        return intval(CookieSession::get_userid_session());
    }

    /**
     * 获取当前用户角色编号
     * @return <int> 角色编号
     */
    public static function get_role_id(){
        return intval(CookieSession::get_role_session());
    }

    /**
     * 获取当前用户资料编号
     * @return <int> 资料编号
     */
    public static function get_data_id(){
        return intval(CookieSession::get_data_session());
    }
    
    /**
     * 获取当前用户所属用户组编号
     * @return <int> 用户组编号
     */
    public static function get_group_id(){
        return intval(CookieSession::get_groupid_session());
    }

    /**
     * 获取当前用户激活状态
     * @return <int> 激活状态（0为未激活，1为已激活）
     */
    public static function get_activate(){
        return intval(CookieSession::get_activate_session());
    }

    /**
     * 获取当前用户套餐编号
     * @return <int> 套餐编号
     */
    public static function get_package(){
        return intval(CookieSession::get_package_session());
    }

    /**
     * 获取当前用户的简历编号（仅限人才使用）
     * @return <int> 简历编号
     */
    public static function get_resume_id(){
        return intval(CookieSession::get_resume_session());
    }

    /**
     * 获取当前用户的学历编号（仅限人才使用）
     * @return <int> 学历编号
     */
    public static function get_degree_id(){
        return intval(CookieSession::get_degree_session());
    }

    /**
     * 获取当前用户的求职意向编号（仅限人才使用）
     * @return <int> 求职意向编号
     */
    public static function get_intent_id(){
        return intval(CookieSession::get_intent_session());
    }

    /**
     * 获取当前用户的挂证意向编号（仅限人才使用）
     * @return <int> 求职意向编号
     */
    public static function get_hang_card_id(){
        return intval(CookieSession::get_hangcd_session());
    }
}

class Auth {
    /**
     * 认证失败的错误处理方式(1、页面跳转，2、输出内容并终止程序）
     * @var <int>
     */
    private $approach;

    /**
     * 处理内容
     * @var <string>
     */
    private $message;

    public function set_property($approach, $message){
        $this->approach = $approach;
        $this->message  = $message;
    }

    /**
     * 执行
     */
    public function run(){
        switch ($this->approach){
            case 1  : redirect($this->message); break;
            case 2  : exit(jsonp_encode(false, $this->message));     break;
            default : exit('error');
        }
    }
}
?>
