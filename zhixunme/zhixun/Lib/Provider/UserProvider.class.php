<?php
/**
 * Description of UserProvider
 *
 * @author moi
 */
class UserProvider extends BaseProvider{
    /**
     * 用户字段（普通）
     */
    const USER_FIELDS_NOMAL = 'user_id,password,email,phone,role_id,data_id,photo,name,is_freeze,is_activate,email_activate,expired,package,credibility,is_real_auth,is_phone_auth,is_email_auth,view,praise,total_experience,register_guide,group_id,last_login_date,last_logout_date,is_online';
    const USER_FIELDS_PROFILE = 'user_id,email,phone,role_id,data_id,photo,name,credibility,is_real_auth,is_phone_auth,is_email_auth,group_id';
//    /**
//     * 根据用户名获取账户信息
//     * @param  <string> $username 用户名
//     * @return <AccountDomailModel> 账户信息
//     */
//    public function get_user_by_username($username){
//        $this->da->setModelName('user');            //使用账户表
//        $where['user_name'] = $username;
//        $where['is_del']    = 0;
//        $result = $this->da->where($where)->field(self::USER_FIELDS_NOMAL)->find();
//        if(empty($result))
//            return null;
//        return FactoryDMap::array_to_model($result, 'account');
//    }

    /**
     * 根据邮箱获取用户详细信息
     * @param  <string> $email
     * @return <array>
     */
    public function get_user_profile($email, $account = 1){
        $this->da->setModelName('user');            //使用账户表
        $where['email']  = $email;
        $where['is_del'] = 0;
        return $this->da->where($where)->field(self::USER_FIELDS_NOMAL)->find();
    }
    
	/**
     * 根据电话获取用户详细信息
     * @param  <string> $phone
     * @return <array>
     */
    public function get_user_profile_phone($phone, $account = 1){
        $this->da->setModelName('user');            //使用账户表
        $where['phone']  = $phone;
        $where['is_del'] = 0;
        return $this->da->where($where)->field(self::USER_FIELDS_NOMAL)->find();
    }

    /**
     * 根据邮箱获取账户信息
     * @param  <string> $email 用户名
     * @return <AccountDomailModel> 账户信息
     */
    public function get_user_by_email($email){
        return FactoryDMap::array_to_model($this->get_user_profile($email, 2), 'account');
    }
//
//    /**
//     * 设置用户邮箱
//     * @param  <int>    $user_id 用户编号
//     * @param  <string> $email   邮箱
//     * @return <bool> 是否成功
//     */
//    public function set_user_email($user_id, $email){
//        $this->da->setModelName('user');            //使用账户表
//        return $this->da->where(array('user_id' => $user_id))->save(array('email' => $email)) !== false;
//    }

    /**
     * 设置用户手机号码
     * @param  <int>    $user_id 用户编号
     * @param  <string> $phone   手机号码
     * @return <bool> 是否成功
     */
    public function set_user_phone($user_id, $phone){
        $this->da->setModelName('user');            //使用账户表
        return $this->da->where(array('user_id' => $user_id))->save(array('phone' => $phone)) !== false;
    }

    /**
     * 设置用户头像
     * @param  <int>    $user_id 用户编号
     * @param  <string> $photo   头像
     * @return <bool> 是否成功
     */
    public function set_user_photo($user_id, $photo){
        $this->da->setModelName('user');            //使用账户表
        return $this->da->where(array('user_id' => $user_id))->save(array('photo' => $photo)) !== false;
    }

    /**
     * 设置用户姓名
     * @param  <int>    $user_id 用户编号
     * @param  <string> $name    姓名
     * @return <bool> 是否成功
     */
    public function set_user_name($user_id, $name){
        $this->da->setModelName('user');            //使用账户表
        return $this->da->where(array('user_id' => $user_id))->save(array('name' => $name)) !== false;
    }

    /**
     * 根据手机号码获取账户信息
     * @param  <string> $phone 手机号码
     * @return <AccountDomailModel> 账户信息
     */
    public function get_user_by_phone($phone){
        $this->da->setModelName('user');            //使用账户表
        $where['phone']  = $phone;
        $where['is_del'] = 0;
        $result = $this->da->where($where)->field(self::USER_FIELDS_NOMAL)->find();
        if(empty($result))
            return null;
        return FactoryDMap::array_to_model($result, 'account');
    }

    /**
     * 设置用户在线状态
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  状态
     * @return <bool> 是否成功
     */
    public function set_user_online_status($user_id, $status){
        
    }

    /**
     * 更新用户信息
     * @param <int>   $user_id 用户编号
     * @param <array> $data    信息
     * @return <bool> 是否成功
     */
    public function update_user($user_id, $data){
        $this->da->setModelName('user');            //使用账户表
        $where['user_id'] = $user_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 添加用户
     * @param  <string> $password 密码
     * @param  <string> $email    邮箱
     * @param  <int>    $role_id  角色编号
     * @param  <int>    $activate 是否激活
     * @param  <string> $expired  过期时间
     * @param  <int>    $package  套餐编号
     * @param  <string> $phone    手机号码
     * @param  <string> $photo    头像
     * @param  <int>    $data_id  资料编号
     * @param  <string> $name     名字
     * @param  <bool>   $by_phone 是否手机注册
     * @param  <int>    $id       用户编号
     * @return <int> 用户编号
     */
    public function add_user($password, $email, $role_id, $activate, $expired, $package, $phone, $photo, $data_id, $name, $by_phone = false, $id){
        $this->da->setModelName('user');            //使用账户表
        $current_date            = date_f();
        $data['user_id']        = $id;
        $data['password']        = $password;
        $data['email']           = $by_phone ? substr(md5($email.time()), 0, 20) : $email;;
        $data['phone']           = $by_phone ? $phone : substr(md5($phone.time()), 0, 20);
        $data['role_id']         = $role_id;
        $data['is_activate']     = $activate;
        $data['expired']         = $expired;
        $data['package']         = $package;
        $data['register_date']   = $current_date;
        $data['last_login_date'] = $current_date;
        $data['last_login_ip']   = get_client_ip();
        $data['last_logout_date'] = $current_date;
        $data['is_online']       = 1;
        $data['online_time']     = 0;
        $data['is_freeze']       = 0;
        $data['email_activate']  = 0;
        $data['data_id']         = $data_id;
        $data['name']            = $name;
        if(empty($photo))
            $data['photo']       = C('PATH_DEFAULT_AVATAR');
        else
            $data['photo']       = $photo;
        $data['credibility']     = 0;
        $data['is_real_auth']    = 0;
        $data['is_phone_auth']   = 0;
        $data['is_email_auth']   = 0;
        $data['view']            = 0;
        $data['group_id']        = $role_id;
        $data['is_del']          = 0;
        $result = $this->da->add($data);
        if($result == false)
            return false;
        return $id;
    }

    /**
     * 根据用户编号获取角色编号
     * @param  <int> $user_id 用户编号
     * @return <int> 角色编号
     */
    public function get_role_by_id($user_id){
        $this->da->setModelName('user');            //使用账户表
        $where['user_id'] = $user_id;
        $result = $this->da->where($where)->field('role_id')->find();
        if(empty($result))
            return null;
        return intval($result['role_id']);
    }

    /**
     * 根据用户名获取用户编号
     * @param  <string> $name 昵称
     * @return <int>
     */
    public function get_id_by_nick($name){
        $this->da->setModelName('user_profile');            //使用资料表
        $where['user_name'] = $name;
        $where['is_del']    = 0;
        $result = $this->da->where($where)->field('user_id')->find();
        if(empty($result))
            return null;
        return intval($result['user_id']);
    }

    /**
     * 设置用户冻结状态
     * @param  <int> $user_id 用户编号
     * @param  <int> $status  状态
     * @return <bool> 是否成功
     */
    public function set_user_freeze_status($user_id, $status){
        $this->da->setModelName('user');                //使用用户表
        $where['user_id']       = $user_id;
        $data['is_freeze'] = $status;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 根据用户编号获取用户信息
     * @param  <int> $user_id 用户编号
     * @return <mixed> 用户信息
     */
    public function get_user_by_id($user_id, $type = 'MODEL'){
        $this->da->setModelName('user');            //使用账户表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::USER_FIELDS_NOMAL)->find();
        if(empty($result))
            return null;
        if($type == 'MODEL')
            return FactoryDMap::array_to_model($result, 'account');
        else
            return $result;
    }

    /**
     * 获取用户资料
     * @param  <int> $user_id 用户编号
     * @return <mixed> 用户信息
     */
    public function get_user_info($user_id){
        $this->da->setModelName('user');            //使用账户表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        return $this->da->where($where)->field(self::USER_FIELDS_NOMAL)->find();
    }

    /**
     * 获取用户的资料编号
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get_data_id($user_id){
        $this->da->setModelName('user');            //使用账户表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field('data_id')->find();
        return $result['data_id'];
    }

    /**
     * 根据用户头像获取用户信息
     * @param  <int> $user_id 用户编号
     * @return <mixed> 用户信息
     */
    public function get_photo_by_id($user_id){
        $this->da->setModelName('user');            //使用账户表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field('photo')->find();
        return $result['photo'];
    }

    /**
     * 设置指定用户编号的用户密码
     * @param  <int>    $user_id  用户编号
     * @param  <string> $password 密码
     * @return <bool> 是否成功
     */
    public function set_password_by_id($user_id, $password){
        $this->da->setModelName('user');                //使用用户表
        $where['user_id']      = $user_id;
        $data['password'] = $password;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 设置指定用户编号的用户手机号码
     * @param  <int>    $user_id 用户编号
     * @param  <string> $phone   手机号码
     * @return <bool> 是否成功
     */
    public function set_phone_by_id($user_id, $phone){
        $this->da->setModelName('user');                //使用用户表
        $where['id']   = $user_id;
        $data['phone'] = $phone;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 设置指定用户编号的用户角色编号
     * @param  <int> $user_id 用户编号
     * @param  <int> $role_id 角色编号
     * @return <bool> 是否成功
     */
    public function set_role_id_by_id($user_id, $role_id){
        $this->da->setModelName('user');                //使用用户表
        $where['id']     = $user_id;
        $data['role_id'] = $role_id;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 用户名是否存在
     * @param  <string> $username 用户名
     * @return <bool> 是否存在
     */
    public function exists_username($username){
        $this->da->setModelName('user');            //使用账户表
        return $this->da->where(array('user_name' => $username))->count() > 0;
    }

    /**
     * 邮箱是否存在
     * @param  <string> $email 邮箱
     * @return <bool> 是否存在
     */
    public function exists_email($email){
        $this->da->setModelName('user');            //使用账户表
        return $this->da->where(array('email' => $email))->count('email') > 0;
    }

    /**
     * 手机号码是否存在
     * @param  <string> $phone 手机号码
     * @return <bool> 是否存在
     */
    public function exists_phone($phone){
        $this->da->setModelName('user');            //使用账户表
        return $this->da->where(array('phone' => $phone))->count() > 0;
    }

    /**
     * 设置用户套餐
     * @param  <int> $user_id 用户编号
     * @param  <int> $package 套餐编号
     * @param  <int> $expired 过期时间
     * @return <bool> 是否成功
     */
    public function set_user_package($user_id, $package, $expired){
        $this->da->setModelName('user');            //使用账户表
        $where['user_id']    = $user_id;
        $where['is_del']     = 0;
        $data['package']     = $package;
        $data['expired']     = $expired;
        $data['is_activate'] = 1;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * COOKIE登录
     * @param  <string> $email 邮箱
     * @param  <string> $token TOKEN
     * @return <bool> 是否成功
     */
    public function cookie_login($email, $token){
        $this->da->setModelName('user_cookie_token');            //使用COOKIE TOKEN表
        $where['email']   = $email;
        $where['token']   = $token;
        $data['end_time'] = array('gt', date_f());
        $data['is_del']   = 0;
        return $this->da->where($where)->count('email') > 0;
    }

    /**
     * 添加COOKIE登录的TOKEN记录
     * @param  <string> $email   邮箱
     * @param  <string> $token   TOKEN
     * @param  <int>    $user_id 用户编号
     * @param  <string> $s_date  起始时间
     * @param  <string> $e_date  结束时间
     * @return <bool> 是否成功
     */
    public function add_cookie_token($email, $token, $user_id, $s_date, $e_date){
        $this->da->setModelName('user_cookie_token');            //使用COOKIE TOKEN表
        $data['email']      = $email;
        $data['token']      = $token;
        $data['user_id']    = $user_id;
        $data['start_time'] = $s_date;
        $data['end_time']   = $e_date;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 删除COOKIE登录的TOKEN
     * @param  <string> $email  邮箱
     * @param  <string> $token  TOKEN
     * @param  <string> $s_date 起始时间
     * @param  <string> $e_date 结束时间
     * @return <bool> 是否成功
     */
    public function delete_cookie_token($email){
        $this->da->setModelName('user_cookie_token');            //使用COOKIE TOKEN表
        $where['email'] = $email;
        $data['is_del'] = 0;
        return $this->da->where($where)->delete() != false;
    }

    /**
     * 添加账户激活记录
     * @param  <int>    $user_id 账户编号
     * @param  <string> $code    激活码
     * @param  <string> $email   邮箱
     * @return <bool> 是否成功
     */
    public function add_user_active($user_id, $code, $email){
        $this->da->setModelName('user_active');                 //使用账户激活表
        $data['user_id'] = $user_id;
        $data['email']   = $email;
        $data['code']    = $code;
        $data['date']    = date_f();
        $data['is_del']  = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 根据激活码获取激活记录
     * @param  <string> $code 激活码
     * @return <mixed>
     */
    public function get_user_active($code){
        $this->da->setModelName('user_active');                 //使用账户激活表
        $where['code']   = $code;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 根据邮箱获取激活记录
     * @param  <string> $email 邮箱
     * @return <mixed>
     */
    public function get_user_active_by_email($email){
        $this->da->setModelName('user_active');                 //使用账户激活表
        $where['email']  = $email;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
    
    /**
     * 删除指定激活记录
     * @param  <int> $id 编号
     * @return <bool> 是否成功
     */
    public function delete_user_active($id){
        $this->da->setModelName('user_active');                 //使用账户激活表
        $where['id'] = $id;
        $data['is_del'] = 1;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 账户激活
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    public function user_active($user_id){
        $this->da->setModelName('user');                        //使用账户表
        $where['user_id'] = $user_id;
        $data['email_activate'] = 1;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 根据角色资料编号获取账户信息列表
     * @param  <int>    $role  角色编号
     * @param  <string> $datas 资料编号
     * @return <mixed>
     */
    public function get_user_list($role, $datas){
        $this->da->setModelName('user');                        //使用账户表
        $where['data_id'] = array('in', $datas);
        $where['role_id'] = $role;
        $where['is_del']  = 0;
        return $this->da->where($where)->select();
    }

    /**
     * 获取用户列表
     * @param <type> $role_id
     * @param <type> $page
     * @param <type> $size
     * @param <type> $count
     * @return <type> 
     */
    public function get_users($role_id, $page, $size, $count){
        $this->da->setModelName('user');                        //使用账户表
        $where['role_id'] = $role;
        $where['is_del']  = 0;
        return $this->da->where($where)->page($page.','.$size)->select();
    }

    /**
     * 根据角色编号获取用户列表
     * @param <type> $role
     * @param <type> $page
     * @param <type> $size
     * @param <type> $field
     * @return <type>
     */
    public function get_users_by_role($role, $page, $size, $field){
        $this->da->setModelName('user');                        //使用账户表
        $where['role_id'] = $role;
        $where['is_del']  = 0;
        return $this->da->where($where)->page($page.','.$size)->field($field)->select();
    }

    /**
     * 根据角色资料编号获取账户信息
     * @param  <int> $role 角色编号
     * @param  <int> $data 资料编号
     * @return <mixed>
     */
    public function get_user($role, $data){
        $this->da->setModelName('user');                        //使用账户表
        $where['data_id'] = $data;
        $where['role_id'] = $role;
        $where['is_del']  = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 添加用户登录记录
     * @param  <int>    $user_id 用户编号
     * @param  <date>   $date    日期
     * @param  <string> $ip      IP
     * @return <bool> 是否成功
     */
    public function add_login_record($user_id, $date, $ip){
        $this->da->setModelName('user_login');                  //使用用户登录记录表
        $data['user_id']   = $user_id;
        $data['date']      = substr($date, 0, 10);
        $data['date_time'] = $date;
        $data['ip']        = $ip;
        return $this->da->add($data) != false;
    }

    /**
     * 增加用户在线时长
     * @param  <int> $user_id 用户编号
     * @param  <int> $inc     增长值
     * @return <bool> 是否成功
     */
    public function increase_online_time($user_id, $inc){
        $this->da->setModelName('user');                        //使用用户表
        $where['user_id'] = $user_id;
        return $this->da->setInc('last_visit_time', $where, $inc) != false;
    }

    /**
     * 获取用户登录记录
     * @param <int>    $user_id 用户编号
     * @param <string> $from    起始日期
     * @param <string> $to      终止日期
     * @param <bool>   $group   是否GROUP
     */
    public function get_login_record($user_id, $from, $to, $group){
        $this->da->setModelName('user_login');                  //使用用户登录记录表
        $where['user_id'] = $user_id;
        if(!empty($from) && !empty($to)){
            $where['date'] = array('between', "'$from','$to'");
        }
        else if(!empty($from)){
            $where['date'] = array('egt', $from);
        }
        else if(!empty($to)){
            $where['date'] = array('elt', $to);
        }
        if($group){
            return $this->da->where($where)->group('date')->select();
        }
        else{
            return $this->da->where($where)->select();
        }
    }

    /**
     * 添加用户在线记录
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $time    时间
     * @param  <int>    $ip      IP
     * @param  <string> $session SESSION编号
     * @return <bool>
     */
    public function add_user_online($user_id, $time, $ip, $session){
        $this->da->setModelName('user_online');            //使用用户在线表
        $data['user_id']          = $user_id;
        $data['login_time']       = $time;
        $data['login_ip']         = $ip;
        $data['login_session_id'] = $session;
        $data['last_visit_time']  = $time;
        return $this->da->add($data) != false;
    }

    /**
     * 统计在线用户数
     * @return <type>
     */
    public function count_user_online(){
        $this->da->setModelName('user_online');            //使用用户在线表
        return $this->da->count('user_id');
    }

    /**
     * 获取指定编号用户在线记录
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public function get_user_online($user_id){
        $this->da->setModelName('user_online');            //使用用户在线表
        return $this->da->where(array('user_id' => $user_id))->find();
    }

    public function user_is_online($user_id){
        $this->da->setModelName('user_online');            //使用用户在线表
        return $this->da->where(array('user_id' => $user_id))->count('user_id') > 0;
    }

    /**
     * 更新用户在线记录
     * @param  <int>    $user_id 用户编号
     * @param  <array>  $data    更新数据
     * @return <bool>
     */
    public function update_user_online($user_id, $data){
        $this->da->setModelName('user_online');            //使用用户在线表
        $where['user_id']         = $user_id;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 删除指定编号用户在线记录
     * @param  <int> $user_id 用户编号
     * @return <bool>
     */
    public function delete_user_online($user_id){
        $this->da->setModelName('user_online');            //使用用户在线表
        return $this->da->where(array('user_id' => $user_id))->delete() != false;
    }
    
    /**
     * 编辑会员被浏览次数
     * Enter description here ...
     * @param $user_id
     */
    public function addviewCount($user_id){
    	$this->da->setModelName('user');            //使用用户在线表
        $where['user_id'] = $user_id;
        return $this->da->setInc('view', $where) !== false;
    }
    
    /**
     * 添加用户注册验证码记录
     * @param string $phone 手机号码
     * @param string $code  验证码
     * @param string $date  日期
     * @return bool 是否成功 
     */
    public function add_user_phone_register_code($phone, $code, $date){
    	$this->da->setModelName('user_phone_register_code');
        $data['phone']  = $phone;
        $data['code']   = $code;
        $data['date']   = $date;
        $data['is_del'] = 0;
        return $this->da->add($data) != false;
    }
    
    /**
     * 获取指定号码的验证码信息
     * @param string $phone 手机号码
     * @return mixed 
     */
    public function get_user_phone_register_code($phone){
    	$this->da->setModelName('user_phone_register_code');
        $where['phone'] = $phone;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
    
    /**
     * 删除指定号码的验证码信息
     * @param string $phone 手机号码
     * @return bool 
     */
    public function delete_user_phone_register_code($phone){
    	$this->da->setModelName('user_phone_register_code');
        $where['phone'] = $phone;
        $where['is_del'] = 0;
        $data['is_del'] = 1;
        return $this->da->where($where)->save($data) != false;
    }
    
    /**
     * 统计用户主页被浏览次数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_user_view($user_id, $start, $end){
    	$this->da->setModelName('user_view');
        $where['other_id'] = $user_id;
        $where['date'] = array('between', "'$start','$end'");
        return $this->da->where($where)->count('other_id');
    }
    
    /**
     * 统计用户查看信息数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @param int $type 信息类型（1简历2职位）
     * @return int 
     */
    public function count_user_read_info($user_id, $start, $end, $type){
    	$this->da->setModelName('read_contact');
        $where['user_id'] = $user_id;
        $where['object_type'] = $type;
        $where['date'] = array('between', "'$start','$end'");
        return $this->da->where($where)->count('user_id');
    }
    
    /**
     * 添加用户访问别人详细页记录
     * @param int $user_id 用户编号
     * @param int $other_id 对方编号
     * @param string $date 日期
     * @param int $client_ip IP
     * @return bool
     */
    public function add_user_view_record($user_id, $other_id, $date, $client_ip){
    	$this->da->setModelName('user_view');
        $data['user_id'] = $user_id;
        $data['other_id'] = $other_id;
        $data['date'] = $date;
        $data['client_ip'] = $client_ip;
        return $this->da->add($data) != false;
    }
    
    /**
     * 用户赞一下
     * @param int $user_id 用户编号
     * @param int $other_id 对方编号
     * @param string $date 日期
     * @param int $client_ip IP
     * @return bool 
     */
    public function add_user_praise($user_id, $other_id, $date, $client_ip){
    	$this->da->setModelName('user_praise');
        $data['user_id'] = $user_id;
        $data['other_id'] = $other_id;
        $data['date'] = $date;
        $data['client_ip'] = $client_ip;
        return $this->da->add($data) != false;
    }
    
    /**
     * 增加用户被赞数
     * @param int $user_id 用户编号
     * @return bool
     */
    public function increase_user_praise($user_id){
    	$this->da->setModelName('user');
        $where['user_id'] = $user_id;
        if($this->da->setInc('praise', $where, 1))
            return true;
        return false;
    }
    
    /**
     * 随机获取可用的人才信息 
     */
    public function get_rand_user_human($size){
    	$this->da->setModelName('user t1');
        $join[] = 'INNER JOIN '.C('DB_PREFIX').'human t2 on t2.human_id=t1.data_id';
        $join[] = 'INNER JOIN '.C('DB_PREFIX').'resume t3 on t3.resume_id=t2.resume_id';
        $join[] = 'INNER JOIN '.C('DB_PREFIX').'certificate t4 on t4.human_id=t2.human_id';
        $where['t1.role_id'] = 1;
        $where['t1.is_freeze'] = 0;
        $where['t1.is_activate'] = 1;
        $where['t1.email_activate'] = 1;
        $where['t1.register_guide'] = 1;
        $where['t1.is_del'] = 0;
        $where['t2.is_del'] = 0;
        $where['t3.agent_id'] = 0;
        $where['t3.publisher_id'] = array('gt', 0);
        $where['t4.type'] = 1;
        $where['t4.is_del'] = 0;
        $order = 'rand()';
        return $this->da->join($join)->where($where)->page('1,'.$size)->order($order)->select();
    }
    
    /**
     * 随机获取可用的经纪人信息 
     */
    public function get_rand_user_agent($size){
    	$this->da->setModelName('user t1');
        $where['t1.role_id'] = 3;
        $where['t1.is_freeze'] = 0;
        //$where['t1.is_activate'] = 1;
        $where['t1.email_activate'] = 1;
        $where['t1.user_id'] = array('neq', 10017);
        $where['t1.is_del'] = 0;
        $order = 'rand()';
        return $this->da->where($where)->page('1,'.$size)->order($order)->select();
    }
    
    /**
     * 获取发布了职位的经纪人信息 
     */
    public function get_has_job_agent($size){
    	$result = $this->da->query('select publisher_id as user_id from zx_job where publisher_role =3 and publisher_id <>0 and 
            publisher_id in (SELECT user_id
            FROM zx_user
            WHERE role_id =3
            AND is_freeze =0
            AND email_activate =1
            AND user_id <>10017
            AND is_del =0) 
            group by publisher_id order by pub_datetime desc limit 1,'.$size);
        return $result;
    }
    
    /**
     * 获取发布了简历的经纪人信息 
     */
    public function get_has_resume_agent($size){
    	$result = $this->da->query('select publisher_id as user_id from zx_resume where publisher_id=agent_id and publisher_id 
            <>0 and publisher_id in (SELECT user_id
            FROM zx_user
            WHERE role_id =3
            AND is_freeze =0
            AND email_activate =1
            AND user_id <>10017
            AND is_del =0) group by publisher_id order by pub_datetime desc limit 1,'.$size);
        return $result;
    }
    
    /**
     * 增加用户经验 
     * @param int $user_id 用户编号
     * @param int $exp 经验值
     * @return bool
     */
    public function increase_exp($user_id, $exp){
        $this->da->setModelName('user');                        //使用用户表
        $where['user_id'] = $user_id;
        return $this->da->setInc('total_experience', $where, $exp) != false;
    }
    
    /**
     * 减少用户经验 
     * @param int $user_id 用户编号
     * @param int $exp 经验值
     * @return bool
     */
    public function decrease_exp($user_id, $exp){
        $this->da->setModelName('user');                        //使用用户表
        $where['user_id'] = $user_id;
        return $this->da->setDec('total_experience', $where, $exp) != false;
    }
}
?>
