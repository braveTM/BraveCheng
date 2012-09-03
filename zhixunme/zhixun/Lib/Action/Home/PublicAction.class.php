<?php

header('content-type:text/html;charset=utf-8');

/**
 * Module:011
 */
class PublicAction extends BaseAction {

    /**
     * 登录页面10000
     */
    private function login() {
        $redirect = empty($_GET['redirect']) ? C('WEB_ROOT') . '/manage' : $_GET['redirect'];
        $this->assign('redirect', $redirect);
        $this->assign('urls', home_index_index_page::get_urls());           //注册链接地址
        $this->display();
    }

    /**
     * 忘记密码页10000
     */
    public function forgot() {
        $this->display();
    }

    /**
     * 忘记密码邮件发送成功页10000
     */
    public function fgsuc() {
        $this->assign('email', $_POST['email']);
        $this->display();
    }

    /**
     * 忘记密码填写手机验证码页10000
     */
    public function fgphone() {
        $this->assign('phone', $_POST['phone']);
        $this->display();
    }

    /**
     * 重设密码页10000
     */
    public function reset() {
        $service = new ForgotService();
        $token = $_GET['token'];
        if ($_GET['phone']) {
            
        } elseif (!$service->exists_token($_GET['token'])) {
            redirect(C('ERROR_PAGE'));
        }
        $this->assign('token', $token);
        $this->display();
    }

    /**
     * 注册成功页面11111
     */
    public function register_succ() {
        $service = new UserService();
        $result = $service->user_active($_GET['code']);
        if (is_zerror($result)) {
            redirect(C('ERROR_PAGE'));
        } else {
            $service->auto_login($result);
        }
        $this->assign('type', AccountInfo::get_role_id());
        $this->display();
    }

    /**
     * 意见反馈页面11111
     */
    public function feedback() {
        $user = new UserService();
        $userInfo = $user->get_user(AccountInfo::get_user_id());
        $this->assign('userInfo', $userInfo);
        $this->display();
    }

    /**
     * 人才注册页面10000
     */
    public function tregister() {
        if (!empty($_GET['code'])) {
            $service = new InviteService();
            $service->remember_invite_code($_GET['code']);
        }
        $this->assign('photo', C('FILE_ROOT') . 'Files/system/photo/user/big/default.png');
        $this->display();
    }

    /**
     * 企业注册页面10000
     */
    public function eregister() {
        if (!empty($_GET['code'])) {
            $service = new InviteService();
            $service->remember_invite_code($_GET['code']);
        }
        $this->assign('photo', C('FILE_ROOT') . 'Files/system/photo/user/big/default.png');
        $this->display();
    }

    /**
     * 经纪人注册页面10000
     */
    public function aregister() {
        if (!empty($_GET['code'])) {
            $service = new InviteService();
            $service->remember_invite_code($_GET['code']);
        }
        $this->assign('photo', C('FILE_ROOT') . 'Files/system/photo/user/big/default.png');
        $this->assign('types', home_agent_account_page::get_service_category());
        $this->display();
    }

    /**
     * 注册验证码10000
     */
    public function register_code() {
        require_cache(APP_PATH . '/Common/Class/Image.class.php');
        Image::buildImageVerify(4, 5, 'png', 50, 25, C('REGISTER_CODE'), C('REGISTER_CODE_CS'));
    }

    /**
     * 登录验证码10000
     */
    public function login_code() {
        require_cache(APP_PATH . '/Common/Class/Image.class.php');
        Image::buildImageVerify(4, 5, 'png', 50, 25, C('LOGIN_CODE'), C('LOGIN_CODE_CS'));
    }

    /**
     * 等待激活页面10000
     */
    public function wait_active() {
        if (md5($_GET['email'] . C('ROLE_TALENTS')) == $_GET['token']) {
            $type = C('ROLE_TALENTS');
        } else if (md5($_GET['email'] . C('ROLE_ENTERPRISE')) == $_GET['token']) {
            $type = C('ROLE_ENTERPRISE');
        } else if (md5($_GET['email'] . C('ROLE_AGENT')) == $_GET['token']) {
            $type = C('ROLE_AGENT');
        } else if (md5($_GET['email'] . C('ROLE_SUBCONTRACTOR')) == $_GET['token']) {
            $type = C('ROLE_SUBCONTRACTOR');
        } else {
            redirect(C('ERROR_PAGE'));
        }
        $this->assign('email', $_GET['email']);
        $this->assign('type', $type);
        $this->display();
    }

    /**
     * 错误页面11111
     */
    public function _error() {
        $this->display();
    }

    /**
     * 关于我们11111
     */
    public function about() {
        $this->assign('article', home_article_index_page::get_fixed_article(1));
        $this->display();
    }

    /**
     * 联系我们11111
     */
    public function contact() {
        $this->assign('article', home_article_index_page::get_fixed_article(4));
        $this->display();
    }

    /**
     * 服务协议11111
     */
    public function agreement() {
        $this->assign('article', home_article_index_page::get_fixed_article(3));
        $this->display();
    }

    /**
     * 积分规则11111
     */
    public function rule() {
        $this->assign('article', home_article_index_page::get_fixed_article(2));
        $this->display();
    }

    /**
     * 隐私协议11111 
     */
    public function privacy() {
        $this->assign('article', home_article_index_page::get_fixed_article(5));
        $this->display();
    }

    /**
     * 招贤纳士11111 
     */
    public function joinus() {
        $this->assign('article', home_article_index_page::get_fixed_article(6));
        $this->display();
    }

    /**
     * 友情链接11111 
     */
    public function links() {
        $this->assign('article', home_article_index_page::get_fixed_article(7));
        $this->display();
    }

    /**
     * 服务优势11111 
     */
    public function advantages() {
        $this->assign('article', home_article_index_page::get_fixed_article(8));
        $this->display();
    }

    /**
     * 经纪人规范11111 
     */
    public function arule() {
        $this->assign('article', home_article_index_page::get_fixed_article(2));
        $this->display();
    }

    /**
     * 人才规范11111 
     */
    public function trule() {
        $this->assign('article', home_article_index_page::get_fixed_article(10));
        $this->display();
    }

    /**
     * 企业规范11111 
     */
    public function crule() {
        $this->assign('article', home_article_index_page::get_fixed_article(11));
        $this->display();
    }

    /**
     * 手机注册成功页面10000 
     */
    public function phone_regsuc() {
        $this->assign('phone', $_GET['phone']);
        $this->display();
    }
    
    /**
     * 积分规则页面01111
     */
    public function scrule(){
        $info = home_agent_account_page::get_statistics();
        $this->assign('score', $info->score);
        $this->display();
    }

    //-----------------------操作-----------------------
    /**
     * 登录操作10000
     */
    public function do_login() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        $result = $service->login($_POST['uname'], $_POST['pword'], $_POST['rem']);
        if ($result == 3) {
            echo jsonp_encode(false, 3);       //返回错误信息
        } elseif (is_zerror($result)) {                                      //登录失败
            echo jsonp_encode(false, $result->get_message());       //返回错误信息
        } else if (is_string($result)) {                                //未激活信息格式'rX'(X：角色编号)
            $service->re_send_active($_POST['uname']);
            echo jsonp_encode(true, C('WEB_ROOT') . '/wait_active?email=' . $_POST['uname'] . '&token=' . md5($_POST['uname'] . substr($result, 1)));
        } else {
            $data = !empty($_POST['url']) ? $_POST['url'] : C('WEB_ROOT') . '/homepage';
            $service = new InviteService();
            $service->clear_invite_code();
            echo jsonp_encode(true, $data, null, $_POST['func']);
        }
    }

    /**
     * 企业登录10000
     */
    public function do_company_login() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        if (!var_validation($_POST['verify'], VAR_LVERIFYCODE)) {
            $error = E(ErrorMessage::$RV_CODE_ERROR);   //验证码错误
            echo jsonp_encode(false, $error->get_message());
            return;
        }
        $service = new UserService();
        $result = $service->company_login($_POST['uname'], $_POST['pword'], $_POST['rem']);
        if (is_zerror($result)) {                                      //登录失败
            if ($result->get_code() == ErrorMessage::$NOT_COMPANY_ACCOUNT)
                $sup = 1;
            else
                $sup = 0;
            echo jsonp_encode(false, $result->get_message(), null, $sup);       //返回错误信息
        }
        else if (is_numeric($result)) {
            $service->re_send_active($_POST['uname']);
            echo jsonp_encode(true, C('WEB_ROOT') . '/wait_active?email=' . $_POST['uname'] . '&token=' . md5($_POST['uname'] . $result));
        } else {
            $data = !empty($_POST['url']) ? $_POST['url'] : C('WEB_ROOT') . '/homepage';
            $service = new InviteService();
            $service->clear_invite_code();
            echo jsonp_encode(true, $data, null, $_POST['func']);
        }
    }

    /**
     * 退出操作01111
     */
    public function do_logout() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        echo jsonp_encode($service->logout(AccountInfo::get_user_id()));
    }

    /**
     * 注册用户名合法性检测11111
     */
    public function do_ucheck() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        //$_POST['uname']
        $service = new UserService();
        $result = !$service->exists_username($_POST['uname']);
        echo jsonp_encode($result);
    }

    /**
     * 注册邮箱合法性检测11111
     */
    public function do_echeck() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        $result = !$service->exists_email($_POST['email']);
        echo jsonp_encode($result);
    }

    /**
     * 注册10000
     */
    public function do_register() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        if (!var_validation($_POST['verify'], VAR_RVERIFYCODE)) {
            $error = E(ErrorMessage::$RV_CODE_ERROR);   //注册验证码错误
            echo jsonp_encode(false, $error->get_message());
        } else {
            $service = new UserService();
            if ($_POST['type'] == C('ROLE_TALENTS')) {
                //$result = $service->talent_register($_POST['pword'], $_POST['email'], $_POST['phone'], $_POST['qq'], $_POST['name'], $_POST['gender'], cut_avatar($_POST['photo']), $_POST['birth'], $_POST['pid'], $_POST['cid'], $_POST['gcm'], $_POST['gct'], $_POST['gcc'], $_POST['rci'], $_POST['rcs'], $_POST['rcp']);
                $result = $service->talent_register_simple($_POST['pword'], $_POST['email'], $_POST['name'], $_POST['rid'], $_POST['rp'], $_POST['rc'], $_POST['pid'], $_POST['pc']);
            } elseif ($_POST['type'] == C('ROLE_ENTERPRISE')) {
                $result = $service->enterprise_register($_POST['pword'], $_POST['email'], cut_avatar($_POST['photo']), $_POST['name'], $_POST['ca'], $_POST['pid'], $_POST['cid'], $_POST['cname'], $_POST['phone'], '', '', $_POST['company_phone']);
            } elseif ($_POST['type'] == C('ROLE_AGENT')) {
                $result = $service->agent_register($_POST['pword'], $_POST['email'], cut_avatar($_POST['photo']), $_POST['name'], $_POST['phone'], '', $_POST['pid'], $_POST['cid'], '', '', '');
            } elseif ($_POST['type'] == C('ROLE_SUBCONTRACTOR')) {
                $result = E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
            } else {
                $result = E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
            }
            if (is_zerror($result)) {
                echo jsonp_encode(false, $result->get_message());
            } else {
                //email_send($_POST['email'], C('EMAIL_ACTIVE_TPL'), $result[0], $result[1]);
                $service = new NotifyService();
                $service->send_email($_POST['email'], C('EMAIL_ACTIVE_TPL'), $result[0], $result[1]);
                $service = new InviteService();
                $service->add_invite_record($result[0]);
                echo jsonp_encode(true, C('WEB_ROOT') . '/wait_active?email=' . $_POST['email'] . '&token=' . md5($_POST['email'] . $_POST['type'])); //返回页面跳转地址
            }
        }
    }

    /**
     * 职位错误页11111
     */
    public function position_404() {
        if (!empty($_SERVER['HTTP_REFERER']))
            $this->assign('refer', $_SERVER['HTTP_REFERER']);
        else
            $this->assign('refer', C('WEB_ROOT'));
        $this->display();
    }

    /**
     * 简历错误页11111
     */
    public function resume_404() {
        if (!empty($_SERVER['HTTP_REFERER']))
            $this->assign('refer', $_SERVER['HTTP_REFERER']);
        else
            $this->assign('refer', C('WEB_ROOT'));
        $this->display();
    }

    /**
     * 功能对比页面01111
     */
    public function funcop() {
        $this->display();
    }

    /**
     * 手机注册10000
     */
    public function do_phone_register() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        $result = $service->talent_phone_register($_POST['pword'], $_POST['phone'], $_POST['name'], $_POST['code'], $_POST['rid'], $_POST['rp'], $_POST['rc'], $_POST['pid'], $_POST['pc']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            $service->auto_login($result);
            $service = new InviteService();
            $service->add_invite_record($result);
            echo jsonp_encode(true, C('WEB_ROOT') . '/rsuc/' . $_POST['phone']);
        }
    }

    /**
     * 发送手机注册验证码10000
     */
    public function do_send_phone_register_code() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        $result = $service->build_register_phone_code($_POST['phone']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            require_cache(APP_PATH . '/Common/Class/SMS.class.php');
            $notify = new SMSFactory();
            $obj = $notify->get_object($_POST['phone'], '您的手机注册验证码为：' . $result);
            $obj->send();
            echo jsonp_encode(true);
        }
    }

    /**
     * 重新发送激活邮件10000
     */
    public function do_reactive() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        $result = $service->re_send_active($_POST['email']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 发送忘记密码10000
     */
    public function do_forgot() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new ForgotService();
        if (var_validation($_POST['number'], VAR_EMAIL)) { //邮箱
            $result = $service->send_forgot_email($_POST['number']);
            if (is_zerror($result)) {
                echo jsonp_encode(false, $result->get_message());
            } else {
                $remail['url'] = C('WEB_ROOT') . '/fgsuc';
                $remail['email'] = $_POST['number'];
                echo jsonp_encode(true, $remail);
            }
        } elseif (var_validation($_POST['number'], VAR_PHONE)) {  //手机
            $result = $service->send_forgot_phone($_POST['number']);
            if (is_zerror($result)) {
                echo jsonp_encode(false, $result->get_message());
            } else {
                $rphone['url'] = C('WEB_ROOT') . '/fgphone';
                $rphone['phone'] = $_POST['number'];
                echo jsonp_encode(true, $rphone);
            }
        } else {
            echo jsonp_encode(false, "没有此用户，请检查");
        }
    }

    /**
     * 重新发送忘记密码邮件10000 
     */
    public function do_res_forgot() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new ForgotService();
        $result = $service->send_forgot_email($_POST['email']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 填写手机验证码10000
     */
    public function do_phone() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new ForgotService();
        $result = $service->phone_verification($_POST['token'], $_POST['phone']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 重设密码10000
     */
    public function do_reset() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new ForgotService();
        if ($_POST['phone']) {
            $result = $service->finish_reset($_POST['token'], $_POST['pword'], $_POST['phone']);
        } else {
            $result = $service->finish_reset($_POST['token'], $_POST['pword']);
        }
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 意见反馈11111
     */
    public function do_feedback() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $data = array();
        $data['user_id'] = AccountInfo::get_user_id();
        $data['user_name'] = $_POST['user_name'];
        $data['phone'] = $_POST['phone'];
        $data['email'] = $_POST['email'];
        $data['type'] = $_POST['type'];
        $data['content'] = $_POST['content'];
        $service = new FeedbackService();
        $result = $service->addfeedback($data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * $passive_user_id   被叫用户id
     * 电话回拨01111
     */
    public function do_call() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $passive_user_id = $_POST['passive_user_id'];
        $user_id = AccountInfo::get_user_id();
        $callSetServiser = new CallSetService();
        $result = $callSetServiser->callSet($user_id, $passive_user_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 拨打编号api_requestid:APIC-d009c0deac8728392a15a394c27826b3d967ffa7
     * 拨打时间长call_duration:60
     * 电话回拨11111
     */
    public function do_call_request() {
        if (!$this->is_legal_request()) {      //是否合法请求
            exit();
        }
        if (!empty($_POST['api_requestid']) && !empty($_POST['call_duration'])) {
            $call_request_num = $_POST['api_requestid'];
            $long_time = $_POST['call_duration'];
        } else {
            exit;
        }

        $callRequestService = new CallRequestService;
        $callRequestService->updateCall($call_request_num, $long_time);
        exit;
    }

    /**
     * 检测套餐分钟数01111
     */
    public function do_package_min() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $user_id = AccountInfo::get_user_id();
        $callSetServiser = new CallSetService();
        $result = $callSetServiser->callSetPackage($user_id);
        $encode = array();
        if (is_zerror($result)) {
            $encode = array(
                'type' => 1,
                'message' => $result->get_message(),
            );
            echo jsonp_encode(false, $encode);
        } else {
            //$user_id = AccountInfo::get_user_id();
            $packageService = new PackageService();
            $min = $packageService->get_min_num($user_id);
            if ($min <= 5 && $min > 0) {
                $encode = array(
                    'type' => 2,
                    'time' => $min,
                    'message' => "你当前套餐拨打分钟数为 $min 分钟，为了避免影响你正常使用此功能，请及时购买分钟数，你也可以继续拨打",
                );
                echo jsonp_encode(false, $encode);
            } elseif ($min <= 0) {
                $encode = array(
                    'type' => 3,
                    'message' => "你当前套餐拨打分钟数为 $num 分钟，是否立即去购买分钟数",
                );
                echo jsonp_encode(false, $encode);
            } else {
                echo jsonp_encode(true);
            }
        }
    }

    /**
     * url规则“/search_job?key1=value1&key2=value2...”,不限制条件传0
     * 搜索职位10000 
     */
    public function searchJob() {
        //地区省份编号
        $require_place = $_GET['require_place'];
        //薪资待遇1(0~3),2(3～5),3(5~15),4(15~30),5(30~100),6(100+),7(面议)
        $salary = $_GET['salary'];
        //发布日期1(1周内),2(半月内),3(1月内),4(6个月内),5(1年内)
        $pub_date = $_GET['pub_date'];
        //资质证书(1选中，2未选中)
        $cert_type = $_GET['cert_type'];
        if (empty($cert_type)){
            $cert_type=2;
        }
        //关键词
        $word = $_GET['word'];
        //认证用户(1选中，2未选中）
        $is_real_auth = $_GET['is_real_auth'];
        if (empty($is_real_auth)){
            $is_real_auth=2;
        }
        //第几页
        $page = $_GET['page'];
        if (empty($page)) {
            $page = 1;
        }
        //每页条数
        $size = $_GET['size'];
        if (empty($size)) {
            $size = 10;
        }
        //排序(1-浏览数降序,2-薪资待遇降序,3-薪资待遇升序,4-发布时间降序,5-发布时间升序)
        $order = $_GET['order'];

        $result = home_job_index_page::searchJob($require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, null, $page, $size, $order);
        //搜索结果，字段名称参考推荐职位列表响应数据
        $this->assign('search_result', $result);
        //上一次搜索条件
        if (!empty($require_place)) {
            $profileService = new ProfileService();
            $province = $profileService->get_province($require_place);
            $require_place_name = $province['name'];
        }else{
            $require_place_name='不限';
        }
        $this->assign('pre_condition', array_merge($_GET, array('require_place_name' => $require_place_name)));
        //搜索结果总条数
        $search_count=home_job_index_page::searchJobCount($require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, null, $order);
        $this->assign('search_count', $search_count);
        if ($search_count % $size == 0) {
            $search_page_count=intval($search_count/$size);
        }else{
            $search_page_count=intval($search_count/$size)+1;
        }
        //搜索结果总页数
        $this->assign('search_page_count',$search_page_count);
        $jobService = new JobService();
        //热门关键词
        $this->assign('hot_keyword', $jobService->getSearchHotKeyword());
        //推荐猎头职位，字段名称参考推荐职位列表响应数据
        $this->assign("agent_job_list", home_job_index_page::searchJob(null, null, null, null, null, 1, 3, rand(1, 5), 6, null));
        /**
         * 推荐企业职位
         * company_job_list[0].name 企业名称
         * company_job_list[0].logo 企业Logo
         * company_job_list[0].job.id 职位ID
         * company_job_list[0].job.name 职位名称
         * company_job_list[0].job_category 工作性质(1-全职，2-兼职）
         * 
         */
        $company_job_list=home_index_index_page::get_recommend_company(4, rand(1, 2));
        foreach ($company_job_list as $key=>$comp_job){
            $jobs=$comp_job->jobs;
            $company_job_list[$key]->job=$jobs[0];
            $company_job_list[$key]->job_category=$jobs[0]->job_category;
        }
        $this->assign('company_job_list', $company_job_list);
        $this->display("Index:fjob");
    }

}

?>
