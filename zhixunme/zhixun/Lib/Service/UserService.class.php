<?php

/**
 * Description of UserService
 *
 * @author moi
 */
class UserService {

    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function __construct() {
        $this->provider = new UserProvider();
    }

    /**
     * 登录
     * @param  <string> $username 用户名|邮箱|手机
     * @param  <string> $password 密码
     * @param  <bool>   $remember 是否记住登录状态
     * @return <AccountDomainModel> 账户模型
     */
    public function login($username, $password, $remember) {
        if (!var_validation($password, VAR_PASSWORD)) {   //密码格式错误
            return E(ErrorMessage::$PASSWORD_FORMAT_ERROR);
        }
        $model = null;
        if (var_validation($username, VAR_EMAIL)) {       //邮箱登录
            $model = $this->provider->get_user_by_email($username);
        } else if (var_validation($username, VAR_PHONE)) {  //手机登录
            $model = $this->provider->get_user_by_phone($username);
        }
        if ($model != null) {
            $error_key = 'LOGIN-PASSWORD-ERROR-' . $model->__get('user_id');
            $error = DataCache::get($error_key);
            if ($error >= 5) {
                //return E(ErrorMessage::$PWD_ERROR_LOCK);
                return 3;
                /* $return = array(
                  'return' => false,
                  'num' => 3,
                  'data' => E(ErrorMessage::$PWD_ERROR_LOCK),
                  );
                  return $return; */
            }
            //用户被冻结
            if ($model->__get('freeze') != 0)
                return E(ErrorMessage::$ACCOUNT_FREEZED);
            //用户密码错误
            if ($model->__get('password') != encrypt_password($password)) {
                $error = $error + 1;
                DataCache::set($error_key, $error + 1, 300);
                return E(ErrorMessage::$PASSWORD_ERROE);
            }
            //登录邮箱未激活
            if ($model->__get('eactivate') != 1) {
                return 'r' . $model->__get('role_id');
            }
            DataCache::set($error_key, 0, 300);
            $time = time();
            $token = make_cookie_token($model->__get('email'), $time);
            AccessControl::login($model, $remember, $token);    //执行登录操作
            $last = $remember ? C('COOKIE_LONG_TIME') : C('COOKIE_TIME');
            $this->provider->add_cookie_token($model->__get('email'), $token, date_f(null, $time), date_f(null, $time + $last));
            $this->update_user_login_status($model->__get('user_id'));
            $recommendService = new RecommendService();
            $recommendService->loginTriggerUpdate($model->__get('user_id'), $model->__get('role_id'));  //调用推荐引擎模块刷新用户数据
            ExperienceCrmService::add_experience_per_day($model->__get('user_id'));     //调用经验模块增加经验
            return $model;
        }
        return E(ErrorMessage::$ACCOUNT_NOT_EXISTS);
    }

    /**
     * 企业登录
     * @param  <string> $username 邮箱|手机
     * @param  <string> $password 密码
     * @param  <bool>   $remember 是否记住登录状态
     * @return <AccountDomainModel> 账户模型
     */
    public function company_login($username, $password, $remember) {
        if (!var_validation($password, VAR_PASSWORD)) {   //密码格式错误
            return E(ErrorMessage::$PASSWORD_FORMAT_ERROR);
        }
        $model = null;
        if (var_validation($username, VAR_EMAIL)) {       //邮箱登录
            $model = $this->provider->get_user_by_email($username);
        } else if (var_validation($username, VAR_PHONE)) {  //手机登录
            $model = $this->provider->get_user_by_phone($username);
        }
        if ($model == null) {
            return E(ErrorMessage::$ACCOUNT_NOT_EXISTS);
        }
        if ($model->__get('role_id') != C('ROLE_ENTERPRISE')) {
            return E(ErrorMessage::$NOT_COMPANY_ACCOUNT);
        }
        return $this->login($username, $password, $remember);
    }

    /**
     * 使用COOKIE自动登录
     * @param  <string> $user_id 用户编号
     * @param  <string> $token TOKEN
     * @return <mixed> 账户信息
     */
    public function login_by_cookie($user_id, $token) {
        $token = trim($token);
        if (!$this->provider->cookie_login($email, $token)) {
            return E(ErrorMessage::$COOKIE_INVALID);         //COOKIE无效
        }
        $model = $this->provider->get_user_by_id($user_id);
        if ($model != null) {
            //用户被冻结
            if ($model->__get('freeze') != 0)
                return E(ErrorMessage::$ACCOUNT_FREEZED);
            //账户未激活
            if ($model->__get('eactivate') == 0)
                return E(ErrorMessage::$ACCOUNT_NOT_ACTIVATE);
            $this->update_user_login_status($model->__get('user_id'));
            $recommendService = new RecommendService();
            $recommendService->loginTriggerUpdate($model->__get('user_id'), $model->__get('role_id'));
            ExperienceCrmService::add_experience_per_day($model->__get('user_id'));     //调用经验模块增加经验
            return $model;
        }
        return E(ErrorMessage::$ACCOUNT_NOT_EXISTS);
    }

    /**
     * 自动登录
     * @param <int> $user_id 用户编号
     */
    public function auto_login($user_id) {
        $model = $this->provider->get_user_by_id($user_id);
        $time = time();
        $token = make_cookie_token($model->__get('email'), $time);
        AccessControl::login($model, false, $token);                //执行登录操作
        $last = $remember ? C('COOKIE_LONG_TIME') : C('COOKIE_TIME');
        $this->provider->add_cookie_token($model->__get('email'), $token, $user_id, date_f(null, $time), date_f(null, $time + $last));
    }

    /**
     * 人才注册
     * @param  <string> $password  密码
     * @param  <string> $email     邮箱
     * @param  <string> $phone     手机
     * @param  <string> $qq        QQ
     * @param  <string> $name      姓名
     * @param  <int>    $gender    性别
     * @param  <string> $photo     头像
     * @param  <string> $birth     生日
     * @param  <int>    $pid       省份编号
     * @param  <int>    $cid       城市编号
     * @param  <int>    $GCM_id    职称证书专业ID
     * @param  <int>    $GCT_id    职称证书类型ID
     * @param  <int>    $GC_class  职称证书级别
     * @param  <string> $RC_IDS    注册证书编号(多个以,隔开)
     * @param  <string> $RC_STATUS 注册证书注册情况(多个以,隔开)
     * @param  <string> $RC_PROS   注册证书注册地(多个以,隔开)
     * @return <mixed>
     */
    public function talent_register($password, $email, $phone, $qq, $name, $gender, $photo, $birth, $pid, $cid, $GCM_id, $GCT_id, $GC_class, $RC_IDS, $RC_STATUS, $RC_PROS) {
        //添加人才资料，添加用户职称，将注册证书临时表数据转入注册证书表中，完成账户基本注册
        $this->provider->trans();                           //开启事务
        $service = new HumanService();                      //添加人才信息
        $human = $service->add_human($name, $gender, $birth, $pid, $cid, $phone, $qq, $email);
        if (is_zerror($human)) {
            $this->provider->rollback();                    //回滚事务
            return $human;
        }
        $csvc = new CertificateService();
        //添加职称证书
        if (!empty($GCM_id)) {
            $cert = $csvc->addGradeCertificateToHuman($human, $GCM_id, $GC_class);
            if (is_zerror($cert)) {
                $this->provider->rollback();                    //回滚事务
                return $cert;
            }
        }
        //添加注册证书
        $ids = explode(',', $RC_IDS);
        $sts = explode(',', $RC_STATUS);
        $prs = explode(',', $RC_PROS);
        if (count($ids) != count($sts) || count($ids) != count($prs)) {           //资质信息格式错误
            return E(ErrorMessage::$CERTIFICATE_INFO_FORMAT_ERROR);
        }
        $province = new ProvinceProvider();
        foreach ($ids as $key => $id) {                                     //添加职位的资质要求
            if (!$csvc->exists_rc_id($id)) {                                  //检测资质证书编号是否存在
                $this->provider->rollback();                                //事务回滚
                return E(ErrorMessage::$RC_NOT_EXISTS);
            }
            $sts[$key] = var_validation($sts[$key], VAR_CCASE, OPERATE_FILTER);
            if (!$province->is_exists_province($prs[$key])) {
                $this->provider->rollback();                                //事务回滚
                return E(ErrorMessage::$PROVINCE_CODE_NOT_EXISTS);
            }
            $cert = $csvc->addRegisterCertificateToHuman($human, $id, $prs[$key], $sts[$key]);
            if (is_zerror($cert)) {
                $this->provider->rollback();                                //事务回滚
                return $cert;
            }
        }
//        //添加注册证书
//        $temp = $csvc->tempIntoRegisterCertificate($code, $human);
//        if(is_zerror($temp)){
//            $this->provider->rollback();                    //回滚事务
//            return $temp;
//        }
        //完成基本注册流程
        $result = $this->register($password, $email, $phone, $photo, $human, C('ROLE_TALENTS'), 1, $name);
        if (is_zerror($result)) {
            $this->provider->rollback();                    //回滚事务
            return $result;
        }
//        $update = $this->update_user_name($result[0], $name);
//        if(is_zerror($update)){
//            $this->provider->rollback();                    //回滚事务
//            return $update;
//        }
        $this->provider->commit();                          //提交事务
        return $result;
    }
    /**
     * 人才引导注册(兼职) 
     * @param int $user_id 用户编号
     * @param int $hang_card_id 挂证意向编号
     * @param int $resume_id 简历编号
     * @param array $cert 证书情况
     * @return bool
     */
    public function guidepart_register($user_id, $hang_card_id, $resume_id, $certs = array()){
        $this->provider->trans();                           //开启事务
        $csvc = new CertificateService();
        //添加职称证书
        $human_id = $this->provider->get_data_id($user_id);
        $GCM_id = $certs['gcm_id'];
        $GC_class = $certs['gcm_class'];
        if(!empty($GCM_id)){
            $cert = $csvc->addGradeCertificateToHuman($human_id, $GCM_id, $GC_class);
            if(is_zerror($cert)){
                $this->provider->rollback();                    //回滚事务
                return $cert;
            }
        }
         //添加注册证书
        $ids = $certs['rc_ids'];  //注册证书id
        $sts =$certs['rc_case'];   //注册证书情况
        $prs = $certs['rc_pros'];   //注册地
        if(count($ids) == count($sts) || count($ids) == count($prs)){          
            $province = new ProvinceProvider();
            foreach ($ids as $key => $id) {                                     //添加职位的资质要求
                if(!$csvc->exists_rc_id($id)){                                  //检测资质证书编号是否存在
                    $this->provider->rollback();                                //事务回滚
                    return E(ErrorMessage::$RC_NOT_EXISTS);
                }
                $sts[$key] = var_validation($sts[$key], VAR_CCASE, OPERATE_FILTER);
                if(!$province->is_exists_province($prs[$key])){
                    $this->provider->rollback();                                //事务回滚
                    return E(ErrorMessage::$PROVINCE_CODE_NOT_EXISTS);
                }
                $cert = $csvc->addRegisterCertificateToHuman($human_id, $id, $prs[$key], $sts[$key]);
                if(is_zerror($cert)){
                    $this->provider->rollback();                                //事务回滚
                    return $cert;
                }
            }
        }
        
        //更新兼职挂证意向表
        $resumeProvider=new ResumeProvider();
        $hang_card_intent_id=$hang_card_id;
        $data=array(
            'job_salary'=>$certs['job_salary'],
            'register_province_ids'=>$certs['province_code']
        );
        $result=$resumeProvider->updateHangCardIntent($hang_card_intent_id, $data);
       if (!$result){
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
       }
        //编辑人才信息
        if(!empty($certs['email'])){
            $human_data['contact_email'] = $certs['email'];
        }elseif(!empty($certs['phone'])){
            $human_data['contact_mobile'] = $certs['phone'];
        }
        $humanProvinder = new HumanProvider();
        //参数验证
        
        //获取human_id
        
        
        if(!$humanProvinder->updateHuman($human_id,$human_data)){
            $this->provider->rollback();                       //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //编辑userregister_guide
        $userdata['register_guide'] = 1;
        if(!$this->provider->update_user($user_id, $userdata)){
            $this->provider->rollback();                       //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $service = new ResumeService();
        if(!$service->openResume($user_id, C('ROLE_TALENTS'), $resume_id, 2)){
            $this->provider->rollback();                       //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                          //提交事务
        return true;
    }
    
    /**
     *人才引导注册(全职) 
     * @param int $user_id 用户编号
     * @param int $job_intent_id 求职意向编号
     * @param array $cert 证书情况
     * @return bool
     */
    public function guidefull_register($user_id, $job_intent_id, $certs = array()){
        $this->provider->trans();                           //开启事务
        $csvc = new CertificateService();
        //添加职称证书
        $human_id = $this->provider->get_data_id($user_id);
        $GCM_id = $certs['gcm_id'];
        $GC_class = $certs['gcm_class'];
        if(!empty($GCM_id)){
            $cert = $csvc->addGradeCertificateToHuman($human_id, $GCM_id, $GC_class);
            if(is_zerror($cert)){
                $this->provider->rollback();                    //回滚事务
                return $cert;
            }
        }
         //添加注册证书
        if(!empty($certs['rc_ids']) && !empty($certs['rc_ids'][0])){
            $ids = $certs['rc_ids'];  //注册证书id
            $sts =$certs['rc_case'];   //注册证书情况
            $prs = $certs['rc_pros'];   //注册地
            if(count($ids) != count($sts) || count($ids) != count($prs)){           //资质信息格式错误
                $this->provider->rollback();                    //回滚事务
                return E(ErrorMessage::$CERTIFICATE_INFO_FORMAT_ERROR);
            }
            $province = new ProvinceProvider();
            foreach ($ids as $key => $id) {                                     //添加职位的资质要求
                if(!$csvc->exists_rc_id($id)){                                  //检测资质证书编号是否存在
                    $this->provider->rollback();                                //事务回滚
                    return E(ErrorMessage::$RC_NOT_EXISTS);
                }
                $sts[$key] = var_validation($sts[$key], VAR_CCASE, OPERATE_FILTER);
                if(!$province->is_exists_province($prs[$key])){
                    $this->provider->rollback();                                //事务回滚
                    return E(ErrorMessage::$PROVINCE_CODE_NOT_EXISTS);
                }
                $cert = $csvc->addRegisterCertificateToHuman($human_id, $id, $prs[$key], $sts[$key]);
                if(is_zerror($cert)){
                    $this->provider->rollback();                                //事务回滚
                    return $cert;
                }
            }
        }
        //更新兼职挂证意向表
         //编辑全职的求职意向
        $resumeService=new ResumeService();
        $job_name=$certs['job_type'];
        $job_province_code=$certs['province_code'];
        $job_city_code=$certs['city_code'];
        $job_salary=$certs['job_salary'];
        $job_describle = ' ';
        $result=$resumeService->updateJobIntent($job_intent_id, $job_name, $job_province_code, $job_city_code, $job_salary, $job_describle);
         if(!$result){
            $this->provider->rollback();                                //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //编辑人才信息
        if(!empty($certs['email'])){
            $human_data['contact_email'] = $certs['email'];
        }elseif(!empty($certs['phone'])){
            $human_data['contact_mobile'] = $certs['phone'];
        }
        $humanProvinder = new HumanProvider();
        //参数验证
        
        //获取human_id
        
        if(!$humanProvinder->updateHuman($human_id,$human_data)){
            $this->provider->rollback();                                //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        
        //编辑userregister_guide
        $userdata['register_guide'] = 1;
        $this->provider->update_user($user_id, $userdata);
        $this->provider->commit();                          //提交事务
        return true;
    }

    /**
     * 人才引导注册(兼职) 1
     */
    public function guidepart_register1($certs) {
        //更新兼职挂证意向表
        $resumeProvider = new ResumeProvider();
        $hang_card_intent_id = AccountInfo::get_hang_card_id();
        $data = array(
            'job_salary' => $certs['job_salary'],
            'register_province_ids' => $certs['province_code']
        );
        $result = $resumeProvider->updateHangCardIntent($hang_card_intent_id, $data);
        if (!$result) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //编辑人才信息
        if (!empty($certs['email'])) {
            $human_data['contact_email'] = $certs['email'];
        } elseif (!empty($certs['phone'])) {
            $human_data['contact_mobile'] = $certs['phone'];
        }
        $humanProvinder = new HumanProvider();
        //参数验证
        //获取human_id
        $human_id = $this->provider->get_data_id(AccountInfo::get_user_id());

        if (!$humanProvinder->updateHuman($human_id, $human_data)) {
            $humanProvinder->rollback();                       //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 人才简单注册
     * @param  <string> $password  密码
     * @param  <string> $email     邮箱
     * @param  <string> $name      姓名
     * @param  <int> $rid 注册证书编号
     * @param  <int> $rp 注册证书地区
     * @param  <int> $rc 注册证书注册情况
     * @param  <int> $gid 职称证书编号
     * @param  <int> $gc 职称证书注册情况
     * @return <mixed>
     */
    public function talent_register_simple($password, $email, $name, $rid, $rp, $rc, $gid, $gc) {
        $this->provider->trans();                           //开启事务
        $service = new HumanService();                      //添加人才信息
        $human = $service->add_human($name, 1, date_f(), 0, 0, '', '', $email);
        if (is_zerror($human)) {
            $this->provider->rollback();                    //回滚事务
            return $human;
        }
        $service = new CertificateService();
        if(!empty($rid)){
            $service->addRegisterCertificateToHuman($human, $rid, $rp, $rc);
        }
        if(!empty($gid)){
            $service->addGradeCertificateToHuman($human, $gid, $gc);
        }
        //完成基本注册流程
        $result = $this->register($password, $email, '', C('PATH_DEFAULT_AVATAR'), $human, C('ROLE_TALENTS'), 1, $name);
        if (is_zerror($result)) {
            $this->provider->rollback();                    //回滚事务
            return $result;
        }
//        $update = $this->update_user_name($result[0], $name);
//        if(is_zerror($update)){
//            $this->provider->rollback();                    //回滚事务
//            return $update;
//        }
        $this->provider->commit();                          //提交事务
        return $result;
    }

    /**
     * 人才手机注册
     * @param string $password 密码
     * @param string $phone    手机号码
     * @param string $name     姓名
     * @param string $code     验证码
     * @param  <int> $rid 注册证书编号
     * @param  <int> $rp 注册证书地区
     * @param  <int> $rc 注册证书注册情况
     * @param  <int> $gid 职称证书编号
     * @param  <int> $gc 职称证书注册情况
     * @return mixed 
     */
    public function talent_phone_register($password, $phone, $name, $code, $rid, $rp, $rc, $gid, $gc) {
        if (!var_validation($password, VAR_PASSWORD)) {       //密码格式错误
            return E(ErrorMessage::$PASSWORD_FORMAT_ERROR);
        }
        if (!var_validation($phone, VAR_PHONE)) {             //手机号码格式错误
            return E(ErrorMessage::$PHONE_FORMAT_ERROR);
        }
        if ($this->exists_phone($phone)) {                    //手机号码重复
            return E(ErrorMessage::$PHONE_EXISTS);
        }
        $code_info = $this->provider->get_user_phone_register_code($phone);
        if (empty($code_info) || $code_info['code'] != $code) {
            return E('手机验证码错误');
        }
        $this->provider->trans();                           //开启事务
        $service = new HumanService();                      //添加人才信息
        $human = $service->add_human($name, 1, date_f(), 0, 0, $phone, '', '');
        if (is_zerror($human)) {
            $this->provider->rollback();                    //回滚事务
            return $human;
        }
        $service = new CertificateService();
        if(!empty($rid)){
            $service->addRegisterCertificateToHuman($human, $rid, $rp, $rc);
        }
        if(!empty($gid)){
            $service->addGradeCertificateToHuman($human, $gid, $gc);
        }
        $password = encrypt_password($password);            //密码加密
        while (true) {                                        //生成唯一主键
            $id = build_id();
            $temp = $this->provider->get_user_by_id($id);
            if (empty($temp))
                break;
        }
        $user_id = $this->provider->add_user($password, '', C('ROLE_TALENTS'), 1, 0, 0, $phone, C('PATH_DEFAULT_AVATAR'), $human, $name, true, $id);     //添加账户
        if ($user_id == false) {                              //添加账户失败
            $this->provider->rollback();                   //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $bill_provider = new BillProvider();
        if (!$bill_provider->add_bill($user_id)) {            //添加账户账单
            $this->provider->rollback();                   //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $authProvider = new AuthProvider();
        if (!$authProvider->add_auth_phone_record($user_id, $name, $phone, $code, date_f(), 1)) {
            return E();                                     //设置手机认证信息
        }
        if (!$this->provider->update_user($user_id, array('is_phone_auth' => 1, 'email_activate' => 1))) {
            return E();                                     //设置用户手机认证状态及注册激活
        }
        $service = new InviteService();
        if (!$service->add_invite($user_id, create_invite_code())) {
            $this->provider->rollback();                   //回滚事务
            return E();
        }
        $service = new PackageService();
        if (!$service->buy_free_package($user_id, C('ROLE_TALENTS'))) {       //购买免费套餐
            $this->provider->rollback();                   //回滚事务
            return E();
        }
        $data_id = $human;
        //添加隐私
        $privacyService = new PrivacyService();
        $result = true;
        $humanService = new HumanService();
        $human = $humanService->get_human($data_id);
        $resume_id = $human['resume_id'];
        $result = $privacyService->createHumanPrivacy($user_id, $data_id, $resume_id, 1, 1, 1, 1);
        if (is_zerror($result)) {
            $this->provider->rollback();
            return $result;
        }

        //添加回拨设置
        $callSetservice = new CallSetService();
        $call_time_slot = array(
            'call_type' => 1,
            'call_time' => 0,
        );
        $data = array();
        $data['user_id'] = $user_id;
        $data['call_time_slot'] = serialize($call_time_slot);
        $data['call_status'] = 1;
        $callSetservice->addCallSetInfo($data);
        if (is_zerror($result)) {
            $this->provider->rollback();
            return $result;
        }

        //添加模块设置
        $modelService = new SetModelService();
        $modelData = array();
        $modelData['user_id'] = $user_id;
        $modelData['call'] = 1;
        $result = $modelService->addModelInfo($modelData);
        if (is_zerror($result)) {
            $this->provider->rollback();
            return $result;
        }

        $this->provider->commit();                          //提交事务
        $service = new RecommendService();
        $service->registerTriggerUpdate($user_id, C('ROLE_TALENTS'));                 //设置用户喜好度
        return $user_id;
    }

    /**
     * 生成注册手机验证码
     * @param string $phone 手机号码
     * @return mixed 成返回验证码，失败返回ZERROR
     */
    public function build_register_phone_code($phone) {
        if (!var_validation($phone, VAR_PHONE)) {             //手机号码格式错误
            return E(ErrorMessage::$PHONE_FORMAT_ERROR);
        }
        if ($this->exists_phone($phone)) {                    //手机号码已存在
            return E(ErrorMessage::$PHONE_EXISTS);
        }
        $this->provider->delete_user_phone_register_code($phone);
        $code = rand_string(6, 1);
        $result = $this->provider->add_user_phone_register_code($phone, $code, date_f());
        if (!$result) {
            return E();
        }
        return $code;
    }

    /**
     * 获取注册手机验证码
     * @param string $phone 手机号码
     * @return mixed 
     */
    public function get_register_phone_code($phone) {
        return $this->provider->get_user_phone_register_code($phone);
    }

    /**
     * 企业注册
     * @param  <string> $password  密码
     * @param  <string> $email     邮箱
     * @param  <string> $photo     头像
     * @param  <string> $name      企业名称
     * @param  <int>    $category  企业性质
     * @param  <int>    $pid       省份编号
     * @param  <int>    $cid       城市编号
     * @param  <string> $c_name    联系人
     * @param  <string> $c_phone   联系人手机
     * @param  <string> $c_qq      联系人QQ
     * @param  <string> $introduce 简介
     * @param  <string> $company_phone 公司电话
     * @return <mixed> 
     */
    public function enterprise_register($password, $email, $photo, $name, $category, $pid, $cid, $c_name, $c_phone, $c_qq, $introduce, $company_phone) {
        $this->provider->trans();                           //开启事务
        $service = new CompanyService();                    //添加企业信息
        $company = $service->add_company($name, $category, $c_name, $c_phone, $c_qq, $email, $pid, $cid, $introduce, $company_phone);
        if (is_zerror($company)) {
            $this->provider->rollback();                    //回滚事务
            return $company;
        }
        //完成基本注册流程
        $result = $this->register($password, $email, $c_phone, $photo, $company, C('ROLE_ENTERPRISE'), 0, $c_name);
        if (is_zerror($result)) {
            $this->provider->rollback();                    //回滚事务
            return $result;
        }
//        $update = $this->update_user_name($result[0], $c_name);
//        if(is_zerror($update)){
//            $this->provider->rollback();                    //回滚事务
//            return $update;
//        }
        $this->provider->commit();                          //提交事务
        return $result;
    }

    /**
     * 经纪人注册
     * @param  <string> $password  密码
     * @param  <string> $email     邮箱
     * @param  <string> $photo     头像
     * @param  <string> $name      姓名
     * @param  <string> $phone     手机
     * @param  <string> $qq        QQ
     * @param  <int>    $pid       省份编号
     * @param  <int>    $cid       城市编号
     * @param  <string> $introduce 简介
     * @param  <string> $company   所属公司
     * @param  <string> $sc        服务类别
     * @return <mixed>
     */
    public function agent_register($password, $email, $photo, $name, $phone, $qq, $pid, $cid, $introduce, $company, $sc) {
        $this->provider->trans();                           //开启事务
        $service = new MiddleManService();                  //添加经纪人信息
        $agent = $service->add_agent($name, $phone, $qq, $email, $pid, $cid, $introduce, $company, $sc);
        if (is_zerror($agent)) {
            $this->provider->rollback();                       //回滚事务
            return $agent;
        }
        //完成基本注册流程
        $result = $this->register($password, $email, $phone, $photo, $agent, C('ROLE_AGENT'), 0, $name);
        if (is_zerror($result)) {
            $this->provider->rollback();                       //回滚事务
            return $result;
        }
//        $update = $this->update_user_name($result[0], $name);
//        if(is_zerror($update)){
//            $this->provider->rollback();                    //回滚事务
//            return $update;
//        }
        $this->provider->commit();                          //提交事务
        return $result;
    }

    /**
     * 用户退出登录
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    public function logout($user_id) {
        AccessControl::logout();
        $this->update_user_logout_status($user_id);
        return true;
    }

    /**
     * 获取指定账户
     * @param  <int> $user_id 用户编号
     * @return <mixed> 账户
     */
    public function get_account($user_id, $type = 'MODEL') {
        return $this->provider->get_user_by_id($user_id, $type);
    }

    /**
     * 获取用户资料
     * @param  <int> $user_id 用户编号
     * @return <mixed> 用户信息
     */
    public function get_user($user_id) {
        return $this->provider->get_user_info($user_id);
    }

    /**
     * 获取用户资料
     * @param  <int> $user_id 用户编号
     * @return <mixed> 用户信息
     */
    public function get_user_by_email($user_id) {
        return $this->provider->get_user_info($user_id);
    }

    /**
     * 根据资料编号和角色编号获取用户信息
     * @param <type> $data_id
     * @param <type> $role_id
     * @return <type>
     */
    public function get_user_by_data($data_id, $role_id) {
        return $this->provider->get_user($role_id, $data_id);
    }

    /**
     * 获取指定用户头像
     * @param  <int> $user_id 用户编号
     * @return <string>
     */
    public function get_account_photo($user_id) {
        return $this->provider->get_photo_by_id($user_id);
    }

    /**
     * 根据用户编号获取角色编号
     * @param  <int> $user_id 用户编号
     * @return <int> 角色编号
     */
    public function get_role_by_id($user_id) {
        return $this->provider->get_role_by_id($user_id);
    }

    /**
     * 根据角色编号获取用户列表
     * @param int $role_id 角色编号
     * @param int $page 第几页
     * @param int $size 每页几条
     * @return array 用户列表 
     */
    public function get_users_by_role($role_id, $page, $size) {
        $filed = 'user_id,name,email,phone';
        return $this->provider->get_users_by_role($role_id, $page, $size, $filed);
    }

    /**
     * 修改密码
     * @param  <int>    $user_id 用户编号
     * @param  <string> $old_pwd 旧密码
     * @param  <string> $new_pwd 新密码
     * @return <bool> 是否成功
     */
    public function change_password($user_id, $ole_pwd, $new_pwd) {
        $account = $this->provider->get_user_by_id($user_id);
        if (empty($account) || ($account->__get('password') != encrypt_password($ole_pwd)))
            return E(ErrorMessage::$OLD_PASSWORD_ERROE);
        if (!var_validation($new_pwd, VAR_PASSWORD))
            return E(ErrorMessage::$NEW_PASSWORD_FORMAT_ERROE);
        if (!$this->provider->set_password_by_id($user_id, encrypt_password($new_pwd)))
            return E(ErrorMessage::$OPERATION_FAILED);
        $this->provider->delete_cookie_token($account->__get('email'));
        $time = time();
        $this->provider->add_cookie_token($account->__get('email'), make_cookie_token($account->__get('email'), $time), $time, $time + C('COOKIE_TIME'));
        AccessControl::set_token_cookie($token);
        return true;
    }

    /**
     * 用户名是否存在
     * @param  <string> $username 用户名
     * @return <bool> 是否存在
     */
    public function exists_username($username) {
        return $this->provider->exists_username($username);
    }

    /**
     * 邮箱是否存在
     * @param  <string> $email 邮箱
     * @return <bool> 是否存在
     */
    public function exists_email($email) {
        return $this->provider->exists_email($email);
    }

    /**
     * 手机号码是否存在
     * @param  <string> $phone 手机号码
     * @return <bool> 是否存在
     */
    public function exists_phone($phone) {
        return $this->provider->exists_phone($phone);
    }

    /**
     * 获取指定编号套餐信息
     * @param  <int> $id 套餐编号
     * @return <array> 套餐信息
     */
    public function get_package($id) {
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
    public function get_packages($role_id, $include = false, $exclude = null) {
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
    public function change_package($user_id, $user_name, $package_id) {
        $package = $this->check_package($package_id, $user_id);
        if (is_zerror($package)) {
            return $package;
        }
        $user = $this->provider->get_user_by_id($user_id);
        $this->provider->trans();
        //消费
        $provider = new PackageProvider();
        $package = $provider->get_package($package_id);
        $domain = new BillDomain();
        $result = $domain->consume($user_id, $user_name, $package['money'], '购买账户套餐:' . $package['name']);
        if (is_zerror($result)) {
            $this->provider->rollback();                            //事务回滚
            return $result;
        }
        //更换套餐
        $last = $this->get_package_time($package['deadline'], $package['unit']);
        $time = time();
        if ($user->__get('package') == $package_id && $user->__get('expired') > $time) {
            $expired = $user->__get('expired') + $last;
        } else {
            $expired = $time + $last;
        }
        if (!$this->provider->set_user_package($user_id, $package_id, $expired)) {
            $this->provider->rollback();                            //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();
        AccessControl::set_package($package_id);
        return true;
    }

    /**
     * 获取用户的资料编号
     * @param  <int> $user_id 用户编号
     * @return <int>
     */
    public function get_data_id($user_id) {
        $user_id = var_validation($user_id, VAR_ID, OPERATE_FILTER);
        return $this->provider->get_data_id($user_id);
    }

    /**
     * 账户激活
     * @param  <string> $code 激活码
     * @return <bool>
     */
    public function user_active($code) {
        if (!var_validation($code, VAR_MD5CODE)) {
            return E(ErrorMessage::$ACTIVE_CODE_INVALID);
        }
        $result = $this->provider->get_user_active($code);                      //获取激活记录
        if (empty($result)) {
            return E(ErrorMessage::$ACTIVE_CODE_INVALID);
        }
        $this->provider->trans();                   //事务开启
        if (!$this->provider->delete_user_active($result['id'])) {                //删除激活记录
            $this->provider->rollback();            //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
//        if(!$this->provider->user_active($result['user_id'])){
//            $this->provider->rollback();            //事务回滚
//            return E(ErrorMessage::$OPERATION_FAILED);
//        }
        $provider = new AuthProvider();
        //增加邮箱认证记录
        if (!$provider->add_auth_email_record($result['user_id'], '', $result['email'], md5($code), date_f(), 1)) {
            $this->provider->rollback();            //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //设置邮件激活与邮件认证状态
        if (!$this->provider->update_user($result['user_id'], array('is_email_auth' => 1, 'email_activate' => 1))) {
            $this->provider->rollback();            //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();
        return $result['user_id'];
    }

    /**
     * 根据角色资料编号获取账户信息列表
     * @param  <int>    $role  角色编号
     * @param  <string> $datas 资料编号
     * @return <mixed>
     */
    public function get_user_list($role, $datas) {
        foreach ($datas as $data) {
            $in .= $data . ',';
        }
        if (empty($in)) {
            return null;
        }
        $in = rtrim($in, ',');
        return $this->provider->get_user_list($role, $in);
    }

    /**
     * 更新用户姓名
     * @param <int>    $user_id 用户编号
     * @param <string> $name    姓名
     * @return <bool>
     */
    public function update_user_name($user_id, $name) {
        if (!var_validation($name, VAR_NAME)) {
            return E(ErrorMessage::$NAME_FORMAT_ERROR);
        }
        if (!$this->provider->set_user_name($user_id, $name)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        return true;
    }

    /**
     * 检测指定用户是否在线
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否在线
     */
    public function check_user_online($user_id) {
        return $this->provider->user_is_online($user_id);
    }

    /**
     * 查看联系方式
     * @param  <int>  $get_id  查看人编号
     * @param  <int> $object_id 查看的对象ID
     * @param  <int> $object_type 查看的对象类型(1-简历，2-职位)
     * @param  <bool> $cf      是否可以查看人才联系方式
     * @param  <bool> $pay     是否执行支付操作
     * @return <mixed> 成功返回联系方式数组，失败返回ZERROR
     */
    public function read_contact($get_id, $object_id, $object_type, $cf = false, $pay = true, $group = 0) {
        if ($object_type == 1) {
            $resumeService = new ResumeService();
            $resume = $resumeService->get_resume($object_id);
            $user_id = $resume['publisher_id'];
            if ($user_id == 0) {
                if ($resume['agent_id'] > 0) {
                    $user_id = $resume['agent_id'];
                } else {
                    $hs = new HumanService();
                    $human = $hs->get_human_by_resume($object_id);
                    $us = new UserService();
                    $user = $us->get_user_by_data($human['human_id'], C('ROLE_TALENTS'));
                    $user_id = $user['user_id'];
                }
            }
        } else if ($object_type == 2) {
            $jobService = new JobService();
            $job = $jobService->get_job($object_id);
            $user_id = $job['publisher_id'];
            if ($user_id == 0) {
                if ($job['agent_id'] > 0) {
                    $user_id = $job['agent_id'];
                } else {
                    $user_id = $job['creator_id'];
                }
            }
            if ($user_id == $get_id) {                //获取的是本人编号
                $user_id = $job['creator_id'];      //委托来的职位，获取创建人编号
            }
        }
        $user = $this->provider->get_user_info($user_id);
        if (empty($user)) {
            return E(ErrorMessage::$USER_NOT_EXISTS);
        }
        if (!$cf && $user['role_id'] == C('ROLE_TALENTS')) {
            return E(ErrorMessage::$USER_NOT_OPEN_CONTACT);
        }
//        if($group == 11 && $object_type == 1){                                  //金牌合作经纪人查看投递来的简历联系方式无限制
//            $provider = new ResumeProvider();
//            $resume   = $provider->getResume($resume_id);
//            $exists = $provider->exists_send_resume_with_resume($object_id, $get_id);
//            if($exists)
//                $pay = false;
//        }
        $provider = new ContactProvider();
        if ($user_id != $get_id && !$provider->is_exists_record($get_id, $user_id, $object_id, $object_type)) {                    //以前未查看过           
            if ($object_type == 1) {//查看简历联系方式
                $service = new ResumeService();
                $exists = $service->exists_send_resume_with_resume($object_id, $get_id);
                if ($exists) {
                    $module_id = 18;                                        //查看投递来的简历联系方式
                } else {
                    $exists = $service->exists_delegate_resume_with_resume($object_id, $get_id);
                    if ($exists) {
                        $module_id = 19;                                        //查看委托来的简历联系方式
                    } else {
                        $module_id = 16;
                    }
                }
            } else if ($object_type == 2) {  //查看委托来的职位联系方式
                $service = new JobService();
                $exists = $service->exists_delegate_job($object_id, $get_id);
                if ($exists) {
                    $module_id = 20;                                        //查看委托来的职位系方式
                } else {
                    $module_id = 17;
                }
            }
            if ($pay) {
                //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
                $pks = new PackageService();
                $do = $pks->start_paying_operation($get_id, $module_id, '用户编号 ' . $user_id);
                if (is_zerror($do)) {
                    return $do;
                }
                //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
            }                                          //事务开启
            if (!$provider->add_read_contact($get_id, $user_id, $object_id, $object_type)) {                //添加查看记录
                $this->provider->rollback();                                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
            //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
            if ($pay) {
                $pks->end_paying_operation();
            }
            //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        }
        $data = $this->get_data_info($user['data_id'], $user['role_id']);
        $contact['email'] = !empty($data['contact_email']) ? $data['contact_email'] : $user['email'];
        $contact['phone'] = $data['contact_mobile'];
        $contact['qq'] = $data['contact_qq'];
        if ($user['role_id'] == C('ROLE_ENTERPRISE')) {
            $companyService = new CompanyService();
            $company = $companyService->get_company($user['data_id']);
            $contact['company_phone'] = $company['company_phone'] == null ? "" : $company['company_phone'];
        }
        //ExperienceCrmService::add_experience_view_contact($user_id);    //调用经验模块增加经验
        return $contact;
    }

    /**
     * 查看简历联系方式
     * @param  <int> $user_id   用户编号
     * @param  <int> $resume_id 简历编号
     * @param  <int> $group     所属用户组
     * @return <mixed>
     */
    public function read_resume_contact($user_id, $resume_id, $group) {
        $provider = new ResumeProvider();
        $resume = $provider->getResume($resume_id);
        if (empty($resume)) {
            return E(ErrorMessage::$USER_NOT_OPEN_CONTACT);
        }
        if (!empty($resume['publisher_id']))
            $id = $resume['publisher_id'];
        else if (!empty($resume['agent_id']))
            $id = $resume['agent_id'];
        else {
            $hs = new HumanService();
            $human = $hs->get_human_by_resume($resume_id);
            $us = new UserService();
            $user = $us->get_user_by_data($human['human_id'], C('ROLE_TALENTS'));
            $id = $user['user_id'];
        }
        if ($resume['agent_id'] > 0 && $user_id == $id) {     //代理人查看自己代理的人才
            $hs = new HumanService();
            $human = $hs->get_human_by_resume($resume_id);
            $us = new UserService();
            $user = $us->get_user_by_data($human['human_id'], C('ROLE_TALENTS'));
            $id = $user['user_id'];
        }
        if ($group == 11) {                                               //金牌合作经纪人查看投递来的简历联系方式无限制
            $exists = $provider->exists_send_resume($id, $user_id);
            if ($exists)
                return $this->read_contact($id, $user_id, true, false);
        }
        $contact = $this->read_contact($id, $user_id, true);
        return $contact;
    }

    /**
     * 获取查看过的联系方式
     * @param  <int> $user_id  用户编号
     * @param  <int> $other_id 对方编号
     * @param  <int> $object_id 查看的对象ID
     * @param  <int> $object_type 查看的对象类型(1-简历，2-职位)
     * @return <mixed> 查看过返回对方联系方式，未查看过返回NULL
     */
    public function get_has_read_contact($user_id, $other_id, $object_id, $object_type) {
        $provider = new ContactProvider();
        $has = $provider->is_exists_record($user_id, $other_id, $object_id, $object_type);
        if ($has) {
            $user = $this->provider->get_user_info($other_id);
            $data = $this->get_data_info($user['data_id'], $user['role_id']);
            $contact['email'] = !empty($data['contact_email']) ? $data['contact_email'] : $user['email'];
            $contact['phone'] = $data['contact_mobile'];
            $contact['qq'] = $data['contact_qq'];
            if ($user['role_id'] == 2) {
                $contact['company_phone'] = $data['company_phone'] == null ? "" : $data['company_phone'];
            }
            return $contact;
        } else {
            return null;
        }
    }

    /**
     * 获取联系方式
     * @param int $user_id 用户ID
     * @param int $role_id 角色ID
     * @return mixed 
     */
    public function get_contact($user_id, $role_id) {
        $user = $this->provider->get_user_info($user_id);
        $data = $this->get_data_info($user['data_id'], $role_id);
        $contact = array();
        $contact['email'] = !empty($data['contact_email']) ? $data['contact_email'] : $user['email'];
        $contact['phone'] = $data['contact_mobile'];
        $contact['qq'] = $data['contact_qq'];
        if ($user['role_id'] == 2) {
            $contact['company_phone'] = $data['company_phone'] == null ? "" : $data['company_phone'];
        }
        return $contact;
    }

    /**
     * 获取用户资料
     * @param  <int> $data_id 资料编号
     * @param  <int> $role_id 角色编号
     * @return <mixed>
     */
    public function get_data_info($data_id, $role_id) {
        $privacyService = new PrivacyService();
        if ($role_id == C('ROLE_TALENTS')) {
            $provider = new HumanProvider();
            $data = $provider->getHuman($data_id);
            $privacyService->replace("home_user_base", $data);
        } else if ($role_id == C('ROLE_ENTERPRISE')) {
            $provider = new CompanyProvider();
            $data = $provider->getCompany($data_id);
            $privacyService->replace("home_user_base", $data);
        } else if ($role_id == C('ROLE_AGENT')) {
            $provider = new MiddleManProvider();
            $data = $provider->getMiddleMan($data_id);
            $privacyService->replace("home_user_base", $data);
        }
        return $data;
    }

    /**
     * 获取用户活跃度（过去七天的登录记录）
     * @param  <int> $user_id 用户编号
     * @return <string>
     */
    public function get_user_activity($user_id) {
        //------------------图形展示活跃度------------------
//        $time = time();
//        $from = date_f('Y-m-d', $time - 6 * 86400);
//        $data = $this->provider->get_login_record($user_id, $from, null, true);
//        if(empty($data)){
//            return '0000000';
//        }
//        $active[$from] = 0;
//        $active[date_f('Y-m-d', $time - 5 * 86400)] = 0;
//        $active[date_f('Y-m-d', $time - 4 * 86400)] = 0;
//        $active[date_f('Y-m-d', $time - 3 * 86400)] = 0;
//        $active[date_f('Y-m-d', $time - 2 * 86400)] = 0;
//        $active[date_f('Y-m-d', $time - 86400)] = 0;
//        $active[date_f('Y-m-d')] = 0;
//        foreach($data as $item){
//            if(array_key_exists($item['date'], $active))
//                $active[$item['date']] = 1;
//        }
//        return implode('', $active);
        //------------------文字展示活跃度------------------
        $time = time();
        $from = date_f('Y-m-d', $time - 6 * 86400);
        $data = $this->provider->get_login_record($user_id, $from, null, true);
        if (empty($data)) {
            return '一周没来了';
        }
        $active[$from] = 0;
        $active[date_f('Y-m-d', $time - 5 * 86400)] = 0;
        $active[date_f('Y-m-d', $time - 4 * 86400)] = 0;
        $active[date_f('Y-m-d', $time - 3 * 86400)] = 0;
        $active[date_f('Y-m-d', $time - 2 * 86400)] = 0;
        $active[date_f('Y-m-d', $time - 86400)] = 0;
        $active[date_f('Y-m-d')] = 0;
        $i = 0;
        foreach ($data as $item) {
            if (array_key_exists($item['date'], $active))
                $i++;
        }
        if ($i == 0) {
            return '一周没来了';
        } else if ($i < 3) {
            return '偶尔来';
        } else if ($i < 7) {
            return '经常来';
        } else {
            return '每天都来';
        }
    }

    /**
     * 更新用户最后访问信息
     * @param  <int> $user_id 用户编号
     * @return <bool>
     */
    public function update_user_last_visit($user_id) {
        $time = time();
        $last = DataCache::get(CC('SYSTEM_LAST_VISIT') . $user_id);
        if (empty($last)) {
            DataCache::set(CC('SYSTEM_LAST_VISIT') . $user_id, $time, CC('CACHE_TIME_NORMAL'));
            return true;
        }
        $gap = $time - $last;
        if ($gap < 10) {                                 //两次时间间隔过短
            return false;
        }
        if ($gap > 600) {                                 //两次时间间隔过长
            DataCache::set(CC('SYSTEM_LAST_VISIT') . $user_id, $time, CC('CACHE_TIME_NORMAL'));
            return false;
        }
        $data['last_visit_time'] = $time;
        //更新用户最后访问时间
        if (!$this->provider->update_user_online($user_id, $data))
            return E(ErrorMessage::$OPERATION_FAILED);
        //增加用户在线时长
        if (!$this->provider->increase_online_time($user_id, $gap))
            return E(ErrorMessage::$OPERATION_FAILED);
        DataCache::set(CC('SYSTEM_LAST_VISIT') . $user_id, $time, CC('CACHE_TIME_NORMAL'));
        return true;
    }

    /**
     * 重新发送邮箱激活邮件
     * @param  <string> $email 邮箱
     * @return <bool>
     */
    public function re_send_active($email) {
        $record = $this->provider->get_user_active_by_email($email);
        if (empty($record)) {
            return E(ErrorMessage::$EMAIL_NOT_EXISTS);
        }
        $service = new NotifyService();
        $service->send_email($_POST['email'], C('EMAIL_ACTIVE_TPL'), $record['user_id'], $record['code']);
        //email_send($email, C('EMAIL_ACTIVE_TPL'), $record['user_id'], $record['code']);
        return true;
    }

    //-------------------protected-----------------------
    /**
     * 检测套餐选取是否合法
     * @param  <int>    $id      套餐编号
     * @param  <int>    $user_id 用户编号
     * @return <mixed>
     */
    protected function check_package($id, $user_id) {
        $ppvd = new PackageProvider();
        $package = $ppvd->get_package($id);
        if (empty($package)) {
            return E(ErrorMessage::$PACKAGE_NOT_EXISTS);            //套餐不存在
        }
        $role = $this->provider->get_role_by_id($user_id);
        if ($role != $package['role_id']) {
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
    protected function get_package_time($line, $unit) {
        switch ($unit) {
            case 1 : $seconds = 86400;
                break;
            case 2 : $seconds = 30 * 86400;
                break;
            case 3 : $seconds = 365 * 86400;
                break;
            default : $seconds = 0;
        }
        return $line * $seconds;
    }

    /**
     * 基本注册流程
     * @param  <string> $password 密码
     * @param  <string> $email    邮箱
     * @param  <string> $phone    手机
     * @param  <string> $photo    照片
     * @param  <int>    $data_id  资料编号
     * @param  <int>    $role_id  角色编号
     * @param  <int>    $activate 是否激活
     * @param  <string> $name     名字
     * @return <mixed> 成功返回数组（账户编号和激活码）,失败返回ZERROR
     */
    protected function register($password, $email, $phone, $photo, $data_id, $role_id, $activate, $name) {
        if (!var_validation($password, VAR_PASSWORD)) {       //密码格式错误
            return E(ErrorMessage::$PASSWORD_FORMAT_ERROR);
        }
        if (!var_validation($email, VAR_EMAIL)) {             //邮箱格式错误
            return E(ErrorMessage::$EMAIL_FORMAT_ERROR);
        }
//        if(!var_validation($phone, VAR_PHONE)){             //手机号码格式错误
//            return E(ErrorMessage::$PHONE_FORMAT_ERROR);
//        }
        if ($this->exists_email($email)) {                    //邮箱重复
            return E(ErrorMessage::$EMAIL_EXISTS);
        }
//        if($this->exists_phone($phone)){                    //手机号码重复
//            return E(ErrorMessage::$PHONE_EXISTS);
//        }
        $photo = var_validation($photo, VAR_SFILE, OPERATE_FILTER);     //头像路径过滤
        $password = encrypt_password($password);            //密码加密
        while (true) {                                        //生成唯一主键
            $id = build_id();
            $temp = $this->provider->get_user_by_id($id);
            if (empty($temp))
                break;
        }
        $this->provider->trans();                           //开启事务
        $user_id = $this->provider->add_user($password, $email, $role_id, $activate, 0, 0, $phone, $photo, $data_id, $name, false, $id);     //添加账户
        if ($user_id == false) {                              //添加账户失败
            $this->provider->rollback();                   //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $bill_provider = new BillProvider();
        if (!$bill_provider->add_bill($user_id)) {            //添加账户账单
            $this->provider->rollback();                   //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $code = md5(time() . rand_string() . $user_id);
        if (!$this->provider->add_user_active($user_id, $code, $email)) {
            $this->provider->rollback();                   //回滚事务
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $service = new InviteService();
        if (!$service->add_invite($user_id, create_invite_code())) {
            $this->provider->rollback();                   //回滚事务
            return E();
        }
        $service = new PackageService();
        if (!$service->buy_free_package($user_id, $role_id)) {//购买免费套餐
            $this->provider->rollback();                   //回滚事务
            return E();
        }
        //添加隐私
        $privacyService = new PrivacyService();
        $result = true;
        if ($role_id == 1) {
            $humanService = new HumanService();
            $human = $humanService->get_human($data_id);
            $resume_id = $human['resume_id'];
            $result = $privacyService->createHumanPrivacy($user_id, $data_id, $resume_id, 1, 1, 1, 1);
        } else if ($role_id == 2) {
            $result = $privacyService->createCompanyPrivacy($user_id, $data_id, 1, 1, 1, 1);
        } else if ($role_id == 3) {
            $result = $privacyService->createAgentPrivacy($user_id, $data_id, 1, 1, 1, 1);
        }
        if (is_zerror($result)) {
            $this->provider->rollback();
            return $result;
        }

        //添加回拨设置
        $callSetservice = new CallSetService();
        $call_time_slot = array(
            'call_type' => 1,
            'call_time' => 0,
        );
        $data = array();
        $data['user_id'] = $user_id;
        $data['call_time_slot'] = serialize($call_time_slot);
        $data['call_status'] = 1;
        $callSetservice->addCallSetInfo($data);
        if (is_zerror($result)) {
            $this->provider->rollback();
            return $result;
        }

        //添加模块设置
        $modelService = new SetModelService();
        $modelData = array();
        $modelData['user_id'] = $user_id;
        $modelData['call'] = 1;
        $result = $modelService->addModelInfo($modelData);
        if (is_zerror($result)) {
            $this->provider->rollback();
            return $result;
        }

        $this->provider->commit();                          //提交事务
        $service = new RecommendService();
        $service->registerTriggerUpdate($user_id, $role_id);                 //设置用户喜好度
        return array($user_id, $code);
    }

    /**
     * 登录更新用户状态
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    protected function update_user_login_status($user_id) {
        $date = date_f();
        $ip = get_client_ip();
        $time = time();
        $data = array(
            'is_online' => 1,
            'last_login_date' => $date,
            'last_login_ip' => $ip,
            'last_login_session' => '',
        );
        //更新账户信息
        $this->provider->update_user($user_id, $data);
        //添加登录记录
        $this->provider->add_login_record($user_id, $date, $ip);
        $online = $this->provider->get_user_online($user_id);
        if (empty($online)) {
            //增加用户在线记录
            $this->provider->add_user_online($user_id, $time, $ip, '');
        } else {
            //强制上一用户下线
            //...
            //更新用户在线记录
            $this->provider->update_user_online($user_id, array(
                'login_time' => $time,
                'login_ip' => $ip,
                'login_session_id' => '',
                'last_visit_time' => $time
            ));
        }
        DataCache::set(CC('SYSTEM_LAST_VISIT') . $user_id, $time, CC('CACHE_TIME_NORMAL'));
        return true;
    }

    /**
     * 登出更新用户状态
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    protected function update_user_logout_status($user_id) {
        DataCache::remove(CC('SYSTEM_LAST_VISIT') . $user_id);
        $this->provider->update_user($user_id, array('last_logout_date' => date_f(), 'is_online' => 0));
        //删除用户在线记录
        $this->provider->delete_user_online($user_id);
        return true;
    }

    /**
     * 增加用户被查看次数
     * @param int $user_id 用户编号
     * @return bool
     */
    public function addviewCount($user_id) {
        $view = $this->provider->get_user_info($user_id);
        if($view['view'] % 10 == 9){
            ExperienceCrmService::add_experience_browse10($user_id);
        }
        return $this->provider->addviewCount($user_id);
    }

    /**
     * 更新用户头像
     * @param int $user_id 用户编号
     * @param string $photo 头像路径
     * @return bool 是否成功
     */
    public function update_photo($user_id, $photo) {
        if (!empty($photo)) {
            $data['photo'] = $photo;
            if (!$this->provider->update_user($user_id, $data))
                return E();
        }
        return true;
    }

    /**
     * 更新
     * @param type $user_id
     * @param type $session 
     */
    public function update_user_session($user_id, $session) {
        if (!empty($session)) {
            $data['last_login_session'] = $session;
            if ($this->provider->update_user($user_id, $data))
                return true;
        }
        return E();
    }

    /**
     * 统计用户页面被访问数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_user_view($user_id, $start, $end) {
        return $this->provider->count_user_view($user_id, $start, $end);
//        $user = $this->provider->get_user_info($user_id);
//        return $user['view'];
    }

    /**
     * 统计用户查看信息数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @param int $type 信息类型（1简历2职位）
     * @return int 
     */
    public function count_user_read_info($user_id, $start, $end, $type) {
        return $this->provider->count_user_read_info($user_id, $start, $end, $type);
    }

    /**
     * 添加用户访问别人详细页记录
     * @param int $user_id 用户编号
     * @param int $other_id 对方编号
     * @param string $date 日期
     * @param int $client_ip IP
     * @return bool
     */
    public function add_user_view_record($user_id, $other_id, $date, $client_ip) {
        if ($user_id == $other_id) {
            return E();        //访问自己主页不添加访问记录
        }
        if (!$this->provider->add_user_view_record($user_id, $other_id, $date, $client_ip)) {
            return E();
        }
        return true;
    }

    /**
     * 用户赞一下
     * @param int $user_id 用户编号
     * @param int $other_id 对方编号
     * @param string $date 日期
     * @param int $client_ip IP
     * @return bool 
     */
    public function do_user_praise($user_id, $other_id, $date, $client_ip) {
        if ($user_id == $other_id) {
            return E('无法赞自己哦！');
        }
        if (!$this->provider->add_user_praise($user_id, $other_id, $date, $client_ip)) {
            return E();
        }
        $this->provider->increase_user_praise($other_id);
        ExperienceCrmService::add_experience_praise($other_id);
        //发送通知邮件
        $args=array();
        $notifyService=new NotifyService();
        $notifyService->fillCommonArgs($args, $other_id, $user_id);
        $userService=new UserService();
        $user=$userService->get_user($other_id);
        email_send($user['email'], 26, $user['user_id'], null, $args);
        return true;
    }
    
    /**
     * 随机获取可用的人才信息 
     */
    public function get_rand_user_human($count){
        return $this->provider->get_rand_user_human($count);
    }
    
    /**
     * 随机获取可用的经纪人信息 
     */
    public function get_rand_user_agent($count){
        $jagent = $this->provider->get_has_job_agent(30);
        $ragent = $this->provider->get_has_resume_agent(30);
        $agents = array_merge($jagent, $ragent);
        foreach ($agents as $v){
            $v = join(",",$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[] = $v;
        }
        $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k] = explode(",",$v);   //再将拆开的数组重新组装
        }
        $agents = $temp;
        $acount = count($agents);
        if($count > $acount)
            $count = $acount;
        $indexes = array_rand($agents, $count);
        foreach($indexes as $index){
            $nagents[] = $agents[$index];
        }
        foreach($nagents as $agent){
            $array[] = $this->provider->get_user_by_id($agent[0], 'ARRAY');
        }
    	return $array;
    }
    
    /**
     * 增加用户经验 
     * @param int $user_id 用户编号
     * @param int $exp 经验值
     * @return bool
     */
    public function increase_exp($user_id, $exp){
        return $this->provider->increase_exp($user_id, $exp);
    }
    
    /**
     * 减少用户经验 
     * @param int $user_id 用户编号
     * @param int $exp 经验值
     * @return bool
     */
    public function decrease_exp($user_id, $exp){
        return $this->provider->decrease_exp($user_id, $exp);
    }
}

?>
