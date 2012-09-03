<?php

header('content-type:text/html;charset=utf-8');

/**
 * Module:010
 */
class DetailAction extends BaseAction {

    /**
     * 用户个人主页11111
     */
    public function user() {
        //获取用户编号
        preg_match('/^\d{1,11}/is', $_GET['match_reg'], $matches);
        $user_id = $matches[0];
        //查询用户信息
        $service = new UserService();
        $user = $service->get_user($user_id);
        //用户不存在或者用户被冻结、未激活、未邮箱激活则跳转到错误页
        if (empty($user) || $user['is_freeze'] == 1 || $user['email_activate'] == 0) {
            redirect(C('WEB_ROOT') . '/error');
        }
        //已登录用户判断
        if (AccessControl::is_logined()) {
            //用户编号为本人编号
            if ($user_id == AccountInfo::get_user_id()) {
                //如果请求页面为index，则路由到个人中心页面
                preg_match('/[a-zA-Z]+/is', $_GET['match_reg'], $ms);
                if ($ms[0] == 'index') {
                    switch ($user['role_id']) {
                        case C('ROLE_TALENTS') :
                            require_cache(APP_PATH . '/Lib/Action/Home/HumanAction.class.php');
                            $action = new HumanAction();
                            $action->home();
                            break;
                        case C('ROLE_ENTERPRISE') :
                            require_cache(APP_PATH . '/Lib/Action/Home/CompanyAction.class.php');
                            $action = new CompanyAction();
                            $action->home();
                            break;
                        case C('ROLE_AGENT') :
                            require_cache(APP_PATH . '/Lib/Action/Home/MiddleManAction.class.php');
                            $action = new MiddleManAction();
                            $action->home();
                            break;
                        case C('ROLE_SUBCONTRACTOR') :
                            require_cache(APP_PATH . '/Lib/Action/Home/BrokerFirmsAction.class.php');
                            $action = new BrokerFirmsAction();
                            $action->index();
                            break;
                        default : redirect(C('WEB_ROOT') . '/error');
                    }
                    return;
                }
            }
        }
        //角色详细页渲染
        switch ($user['role_id']) {
            case C('ROLE_TALENTS') : $_GET['id'] = $user_id;
                $this->human();
                break;
            case C('ROLE_ENTERPRISE') : $_GET['id'] = $user_id;
                $this->company();
                break;
            case C('ROLE_AGENT') : $_GET['id'] = $user_id;
                $this->agent();
                break;
            default : redirect(C('WEB_ROOT') . '/error');
        }
    }

    /**
     * 职位详细11111
     */
    public function job() {
        $job = home_job_index_page::get_job_detail($_GET['id'], $self, $contact);
        if (empty($job)) {
            redirect(C('WEB_ROOT') . '/perror');
        }
        $this->assign('job', $job);
        if ($job->is_agent == 1) {
            $user_id = $job->agent_model->id;
        } else {
            $user_id = $job->pub_model->id;
        }

        //隐私设置中是否公开联系方式1公开，2不公开
        $privacyService = new PrivacyService();
        if ($job->is_agent == 1 || $job->pub_model->role_id == 3) {
            //经纪人发布或经纪人代理
            $this->assign('contact_role', 3);
            $privacy = $privacyService->getAgentPrivacy($user_id);
            $contact_way = $privacy['contact_way'];
            if ($contact_way == 1) {
                //公开联系方式
                $userService = new UserService();
                //获取经纪人的联系方式
                $contact = $userService->get_contact($user_id, 3);
                $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
            }
        } else {
            //企业发布
            $this->assign('contact_role', 2);
            $privacy = $privacyService->getCompanyPrivacy($user_id);
            $contact_way = $privacy['contact_way'];
            if ($contact_way == 1 && empty($contact)) {
                //show_contact_bt是否显示“查看联系方式”按钮
                $this->assign('show_contact_bt', 1);
            } else {
                $this->assign('show_contact_bt', 0);
                if (!empty($contact) && $contact_way==1) {
                    //contact不为空并且隐私设置公开
                    $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
                }
            }
        }


        if (AccessControl::is_logined()) {                                //登录用户
            //电话回拨
            $callSetService = new CallSetService();
            $callSetInfo = $callSetService->getPrivacyCallSet($user_id);
            $this->assign('callSetInfo', $callSetInfo);
            $type = AccountInfo::get_role_id();
            if ($type != C('ROLE_TALENTS') && $type != C('ROLE_AGENT')) {
                if (!$self)      //如果不是人才或者经纪人，则不允许查看除本人外发布的职位
                    redirect(C('WEB_ROOT') . '/perror');
            }
            $this->assign('type', $type);
            $role_type = $job->pub_model->role_id;
            $this->assign('mid', 17);            //查看职位联系方式模块编号
//            if($role_type == C('ROLE_ENTERPRISE')){
//                $this->assign('mid', 6);            //查看企业联系方式模块编号
//            }
//            else if($role_type == C('ROLE_AGENT')){
//                $this->assign('mid', 7);            //查看经纪人联系方式模块编号
//            }
            $this->assign('role_type', $role_type);
            if ($job->category == C('JOB_CATEGORY_FULL')) {
                if ($self) {
                    $tpl = 'Detail:job_full_self';
                } else {
                    $tpl = 'Detail:job_full';
                }
            } else {
                if ($self) {
                    $tpl = 'Detail:job_part_self';
                } else {
                    $tpl = 'Detail:job_part';
                }
            }
        } else {                                               //未登录用户
            if ($job->category == C('JOB_CATEGORY_FULL')) {
                $tpl = 'Detail:n_job_full';
            } else {
                $tpl = 'Detail:n_job_part';
            }
        }
        $recommendService = new RecommendService();
        $recommendService->jobDetailTriggerUpdate($_GET['id'], $job->category);
        $similarJob = home_recommend_page::getSimilarJobList($_GET['id'], 1, 10);
        $this->assign('similarJob', $similarJob);
        $readJob=  home_job_index_page::getReadJob(AccountInfo::get_user_id(),0,10);
        $this->assign('readJob', $readJob);
        $this->display($tpl);
    }

    /**
     * 经纪人详细11111
     */
    public function agent() {
        $user_id = $_GET['id'];
        $agent = home_agent_account_page::get_agent_detail($user_id);
        if (empty($agent)) {
            redirect(C('ERROR_PAGE'));
        }
        $userService = new UserService();
        if (AccountInfo::get_user_id() == $user_id) {
            $this->assign('self', 1);
            //经纪人联系方式对自己始终公开
            $contact = $userService->get_contact($user_id, 3);
            $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
        } else {
            //其他人查看经纪人联系方式，需要根据经纪人的隐私设置
            $privacyService = new PrivacyService();
            $privacy = $privacyService->getAgentPrivacy($user_id);
            $contact_way = $privacy['contact_way'];
            if ($contact_way == 1) {
                //公开联系方式
                //获取经纪人的联系方式
                $contact = $userService->get_contact($user_id, 3);
                $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
            }
        }
        $this->assign('agent', $agent);
        $this->assign('job_id', $_GET['job_id']);
        $this->assign('rcount', home_agent_account_page::get_running_resume_count($user_id, 0));
        $this->assign('jcount', home_agent_account_page::get_running_job_count($user_id, 0));
        $this->assign('service_company_list', home_agent_account_page::getServiceCompanyList($user_id, null, 1, 10));
        $this->assign('latest_blog', home_blog_page::getLatestBlog($user_id, 10));
        $this->assign('job');
        if (AccessControl::is_logined()) {                //登录用户
            $this->assign('type', AccountInfo::get_role_id());
            $service = new UserService();
            $contact = $service->get_has_read_contact(AccountInfo::get_user_id(), $user_id);
            if (empty($contact)) {
                $this->assign('iscontact', 0);
            } else {
                $this->assign('iscontact', 1);
                $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
            }
            $tpl = 'Detail:agent';
        } else {
            $tpl = 'Detail:n_agent';                    //未登录用户
        }
        //十分钟以内同一客户端访问该页面不增加访问次数
        $cache_key = 'agent_view_' . get_client_ip() . '_00' . $user_id;
        if (!DataCache::get($cache_key)) {
            $userService = new UserService();
            $result = $userService->add_user_view_record(AccountInfo::get_user_id(), $user_id, date_f(), get_client_ip());
            if(!is_zerror($result))
                $userService->addviewCount($user_id);
            DataCache::set($cache_key, '1', 600);
        }
        $this->assign('job', home_agent_account_page::get_running_job($user_id, 0, 1, 6));
        $this->assign('job_count', home_agent_account_page::get_running_job_count($user_id, 0));
        $this->assign('resume', home_agent_account_page::get_running_resume($user_id, 0, 1, 6));
        $this->assign('resume_count', home_agent_account_page::get_running_resume_count($user_id, 0));
        $this->display($tpl);
    }

    /**
     * 企业详细11111
     */
    public function company() {
        $user_id = $_GET['id'];
        $company = home_company_account_page::get_company_detail($user_id);
        if (empty($company)) {
            redirect(C('ERROR_PAGE'));
        }
        if (AccountInfo::get_user_id() == $user_id) {
            $this->assign('self', 1);
        }
        $this->assign('company', $company);
        $this->assign('jcount', home_company_account_page::get_job_count($user_id));
        if (AccessControl::is_logined()) {
            $this->assign('type', AccountInfo::get_role_id());
            $tpl = 'Detail:company';
        } else {
            $tpl = 'Detail:n_company';                  //未登录用户
        }
        //十分钟以内同一客户端访问该页面不增加访问次数
        $cache_key = 'company_view_' . get_client_ip() . '_00' . $user_id;
        if (!DataCache::get($cache_key)) {
            $userService = new UserService();
            $result = $userService->add_user_view_record(AccountInfo::get_user_id(), $user_id, date_f(), get_client_ip());
            if(!is_zerror($result))
                $userService->addviewCount($user_id);
            DataCache::set($cache_key, '1', 600);
        }
        //职位列表赋值
        $service = new JobService();
        $result = $service->get_pub_jobs($user_id, 0, 2, 1, 6, false, true);
        $certService = new CertificateService();
        foreach ($result as $key => $value) {
            $result[$key]['certs'] = $certService->getRegisterCertificateListByJob($value['job_id']);
            $result[$key]['job_name'] = $service->get_job_position($value['job_name']);
        }
        $this->assign('job', FactoryVMap::list_to_models($result, 'home_job_list'));
        $this->assign('job_count', $service->get_pub_jobs($user_id, 0, 2, 1, 6, true, false));
        $this->display($tpl);
    }

    /**
     * 举报详细页 11111
     */
    public function report() {
        $newtype = $_GET['newtype'];
        if ($newtype == 1) {
            //职位举报
            $job_id = $_GET['report'];   //job_id
            $data = home_job_index_page::get_job_detail($job_id, $self, $contact);
            if (empty($data)) {
                redirect(C('ERROR_PAGE'));
            }
            $this->assign('data', $data);
        } elseif ($newtype == 2) {
            //心得
            $blog_id = $_GET['report'];   //blog_id
            $data = home_blog_page::getBlog($blog_id);
            $this->assign('data', $data);
        } elseif ($newtype == 3) {
            //会员
            $user_id = $_GET['report'];    //user_id
            $usvc = new UserService();
            $user = $usvc->get_user($user_id);
            $data = FactoryVMap::array_to_model($user, 'home_user_base');
            $this->assign('data', $data);
        }
        $this->assign('newtype', $newtype);
        $this->display();
    }

    /**
     * 简历详细页11111
     */
    public function resume() {
        $human_id = $_GET['human_id'];
        $user_id = AccountInfo::get_user_id();
        $type = AccountInfo::get_role_id();
        if ($type == C('ROLE_TALENTS')) {
            redirect(C('WEB_ROOT') . '/rerror');          //人才不允许查看简历
        }
        $resume = home_human_profile_page::getResume($human_id);
        if ($resume->publisher_id == 0 && $resume->create_id != $user_id && $resume->agent_id != $user_id) {
            redirect(C('WEB_ROOT') . '/rerror');
        }
        if ($resume->job_category == C('JOB_CATEGORY_FULL')) {
            if (empty($resume)) {
                redirect(C('WEB_ROOT') . '/rerror');
            }
            $this->assign('resume', $resume);
            $tpl = 'Detail:fjob_resudetail';
        } else {
            $HC_resume = home_human_profile_page::getHCresume($human_id);
            if (empty($HC_resume)) {
                redirect(C('WEB_ROOT') . '/rerror');
            }
            $this->assign('HC_resume', $HC_resume);
            $tpl = 'Detail:pjob_resudetail';
        }
        if (empty($resume->human->user_id)) {
            $this->assign('private', 1);
        }
        if ($resume->agent_id == $user_id) {
            $this->assign('self', 1);
        }
        $this->assign('mid', 16);            //查看简历联系方式模块编号
//        if(empty($resume->agent_id)){
//            $this->assign('mid', 5);            //查看人才联系方式模块编号
//        }
//        else{
//            $this->assign('mid', 7);            //查看经纪人联系方式模块编号
//        }
        //电话回拨
        $callSetService = new CallSetService();
        $callSetInfo = $callSetService->getPrivacyCallSet($resume->publisher_id);
        $this->assign('callSetInfo', $callSetInfo);
        $this->assign('type', $type);
        $svc = new ContactsService();
        if (!empty($resume->agent_id)) {
            if ($user_id == $resume->agent_id)
                $other_id = $resume->human->user_id;        //代理经纪人本人查看
            else
                $other_id = $resume->agent_id;              //对方编号
            $follow = $svc->exists_user_follow($user_id, $resume->agent_id);
            $this->assign('follow', $follow ? 1 : 0);
            $this->assign('agent', home_agent_account_page::get_agent_detail($resume->agent_id));
        } else {
            $other_id = $resume->human->user_id;        //对方编号
            $follow = $svc->exists_user_follow($user_id, $resume->human->user_id);
            $this->assign('follow', $follow ? 1 : 0);
            $this->assign('activity', $resume->human->activity);
        }

        //联系方式控制策略
        if ($resume->publisher_id > 0) {
            //隐私设置中是否公开联系方式1公开，2不公开
            $privacyService = new PrivacyService();
            if ($resume->agent_id > 0) {
                //经纪人发布或经纪人代理
                $this->assign('contact_role', 3);
                $privacy = $privacyService->getAgentPrivacy($resume->publisher_id);
                $contact_way = $privacy['contact_way'];
                if ($contact_way == 1) {
                    //公开联系方式
                    $userService = new UserService();
                    //获取经纪人的联系方式
                    $contact = $userService->get_contact($other_id, 3);
                    $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
                }
            } else {
                //人才发布
                $this->assign('contact_role', 1);
                $privacy = $privacyService->getHumanPrivacy($resume->publisher_id);
                $contact_way = $privacy['contact_way'];
                $service = new UserService();
                $contact = $service->get_has_read_contact($user_id, $other_id, $resume->resume_id, 1);
                if ($contact_way == 1 && empty($contact)) {
                    //show_contact_bt是否显示“查看联系方式”按钮
                    $this->assign('show_contact_bt', 1);
                } else {
                    $this->assign('show_contact_bt', 0);
                    if (!empty($contact) && $contact_way==1) {
                        //contact不为空并且隐私设置为公开
                        $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
                    }
                }
            }
        }
        if(!AccessControl::is_logined()){
            if($tpl == 'Detail:fjob_resudetail')
                $tpl = 'Detail:n_fjob_resudetail';
            if($tpl == 'Detail:pjob_resudetail')
                $tpl = 'Detail:n_pjob_resudetail';
        }
        $this->display($tpl);
    }

    /**
     * 人才详细页11111
     */
    public function human() {
        $user_id = $_GET['id'];
        $profile = home_human_detail_page::get_human_info($user_id);
        if (empty($profile)) {
            redirect(C('ERROR_PAGE'));                                          //用户不存在
        }
        if (AccountInfo::get_user_id() == $user_id) {
            $this->assign('self', 1);
        }
        if (AccessControl::is_logined()) {
            $service = new ContactsService();
            $follow = $service->exists_user_follow(AccountInfo::get_user_id(), $user_id) ? 1 : 0;
            $this->assign('follow', $follow);
            $tpl = 'Detail:human';
        } else {
            $tpl = 'Detail:n_human';                  //未登录用户
        }
        $this->assign('profile', $profile);
        $this->assign('resume', home_human_detail_page::get_resume_status($profile->rid, $profile->ji_id, $profile->hc_id, $profile->category));
        $this->assign('company', home_human_detail_page::get_send_company($user_id));
        $cache_key = 'human_view_' . get_client_ip() . '_00' . $user_id;
        if (!DataCache::get($cache_key)) {
            $userService = new UserService();
            $result = $userService->add_user_view_record(AccountInfo::get_user_id(), $user_id, date_f(), get_client_ip());
            if(!is_zerror($result))
                $userService->addviewCount($user_id);
            DataCache::set($cache_key, '1', 600);
        }
        $this->display($tpl);
    }

    /**
     * 委托简历详细页00010
     */
    public function delegatedResume() {
        $user_id = AccountInfo::get_user_id();
        $delegate_resume_id = $_GET['delegate_resume_id'];
        $resume = home_human_profile_page::getDelegatedResumeDetail($delegate_resume_id);
        if (empty($resume->agent_id) || $resume->agent_id != $user_id || empty($resume->human->user_id)) {
            redirect(C('ERROR_PAGE'));                                          //非经纪人本人代理无法查看
        }
        if ($resume->job_category == C('JOB_CATEGORY_FULL')) {
            if (empty($resume)) {
                redirect(C('ERROR_PAGE'));
            }
            $this->assign('resume', $resume);
            $tpl = 'Detail:fjob_resudetail';
        } else {
            if (empty($resume)) {
                redirect(C('ERROR_PAGE'));
            }
            $this->assign('HC_resume', $resume);
            $tpl = 'Detail:pjob_resudetail';
        }
        $this->assign('mid', 16);            //查看简历联系方式模块编号
//        if(empty($resume->agent_id)){
//            $this->assign('mid', 5);            //查看人才联系方式模块编号
//        }
//        else{
//            $this->assign('mid', 7);            //查看经纪人联系方式模块编号
//        }
        $this->assign('self', 1);
        //电话回拨
        $callSetService = new CallSetService();
        $callSetInfo = $callSetService->getPrivacyCallSet($job->pub_model->id);
        $this->assign('callSetInfo', $callSetInfo);
        $svc = new ContactsService();
        $follow = $svc->exists_user_follow($user_id, $resume->human->user_id);
        $this->assign('follow', $follow ? 1 : 0);
        $this->assign('agent', home_agent_account_page::get_agent_detail($resume->agent_id));
        $this->assign('activity', $resume->human->activity);
        $service = new UserService();
        $contact = $service->get_has_read_contact($user_id, $resume->human->user_id, $resume->resume_id, 1);
        if (empty($contact)) {
            $this->assign('iscontact', 0);
        } else {
            $this->assign('iscontact', 1);
            $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
        }

        //联系方式控制策略
        $privacyService = new PrivacyService();
        $this->assign('contact_role', 1);
        $privacy = $privacyService->getHumanPrivacy($resume->user_id);
        $contact_way = $privacy['contact_way'];
        $service = new UserService();
        $contact = $service->get_has_read_contact($user_id, $other_id, $resume->resume_id, 1);
        if ($contact_way == 1 && empty($contact)) {
            //show_contact_bt是否显示“查看联系方式”按钮
            $this->assign('show_contact_bt', 1);
        } else {
            $this->assign('show_contact_bt', 0);
            if (!empty($contact) && $contact_way==1) {
                //contact不为空并且隐私设置为公开
                $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
            }
        }
        $this->display($tpl);
    }

    /**
     * 应聘来的简历详细页00110
     */
    public function sentResume() {
        $send_resume_id = $_GET['send_resume_id'];
        $user_id = AccountInfo::get_user_id();
        $resume = home_human_profile_page::getSentResumeDetail($send_resume_id);
        if ($resume->job_category == C('JOB_CATEGORY_FULL')) {
            if (empty($resume)) {
                redirect(C('ERROR_PAGE'));
            }
            $this->assign('resume', $resume);
            $tpl = 'Detail:fjob_resudetail';
        } else {
            if (empty($resume)) {
                redirect(C('ERROR_PAGE'));
            }
            $this->assign('HC_resume', $resume);
            $tpl = 'Detail:pjob_resudetail';
        }
        if (empty($resume->human->user_id)) {
            $this->assign('private', 1);
        }
        if ($resume->agent_id == AccountInfo::get_user_id()) {
            $this->assign('self', 1);
        }
        $this->assign('mid', 16);            //查看简历联系方式模块编号
//        if(empty($resume->agent_id)){
//            $this->assign('mid', 5);            //查看人才联系方式模块编号
//        }
//        else{
//            $this->assign('mid', 7);            //查看经纪人联系方式模块编号
//        }
        //电话回拨
        $callSetService = new CallSetService();
        $callSetInfo = $callSetService->getPrivacyCallSet($job->pub_model->id);
        $this->assign('callSetInfo', $callSetInfo);
        $svc = new ContactsService();
        if (!empty($resume->agent_id)) {
            if ($user_id == $resume->agent_id)
                $other_id = $resume->human->user_id;        //代理经纪人本人查看
            else
                $other_id = $resume->agent_id;              //对方编号
            $follow = $svc->exists_user_follow(AccountInfo::get_user_id(), $resume->agent_id);
            $this->assign('follow', $follow ? 1 : 0);
            $this->assign('agent', home_agent_account_page::get_agent_detail($resume->agent_id));
        } else {
            $other_id = $resume->human->user_id;        //对方编号
            $follow = $svc->exists_user_follow(AccountInfo::get_user_id(), $resume->human->user_id);
            $this->assign('follow', $follow ? 1 : 0);
            $this->assign('activity', $resume->human->activity);
        }
        $service = new UserService();
        $contact = $service->get_has_read_contact($user_id, $other_id, $resume->resume_id, 1);
        if (empty($contact)) {
            $this->assign('iscontact', 0);
        } else {
            $this->assign('iscontact', 1);
            $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
        }

        //联系方式控制策略
        if ($resume->publisher_id > 0 || $resume->agent_id > 0) {
            //隐私设置中是否公开联系方式1公开，2不公开
            $privacyService = new PrivacyService();
            if ($resume->agent_id > 0) {
                //经纪人发布或经纪人代理
                $this->assign('contact_role', 3);
                $privacy = $privacyService->getAgentPrivacy($resume->agent_id);
                $contact_way = $privacy['contact_way'];
                if ($contact_way == 1) {
                    //公开联系方式
                    $userService = new UserService();
                    //获取经纪人的联系方式
                    $contact = $userService->get_contact($other_id, 3);
                    $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
                }
            } else {
                //人才发布
                $this->assign('contact_role', 1);
                $privacy = $privacyService->getHumanPrivacy($resume->publisher_id);
                $contact_way = $privacy['contact_way'];
                $service = new UserService();
                $contact = $service->get_has_read_contact($user_id, $other_id, $resume->resume_id, 1);
                if ($contact_way == 1 && empty($contact)) {
                    //show_contact_bt是否显示“查看联系方式”按钮
                    $this->assign('show_contact_bt', 1);
                } else {
                    $this->assign('show_contact_bt', 0);
                    if (!empty($contact) && $contact_way==1) {
                        //contact不为空并且隐私设置为公开
                        $this->assign('contacts', FactoryVMap::array_to_model($contact, 'home_user_contact'));
                    }
                }
            }
        }
        $this->display($tpl);
    }

    //------------------操作-------------------
    /**
     * 获取指定企业发布的职位列表11110
     */
    public function get_company_jobs() {
        if (!$this->is_legal_request())
            return;
        $service = new JobService();
        $result = $service->get_pub_jobs($_POST['uid'], $_POST['type'], 2, $_POST['page'], $_POST['size'], false, true);
        if (!empty($result)) {
            $certService = new CertificateService();
            foreach ($result as $key => $value) {
                $result[$key]['certs'] = $certService->getRegisterCertificateListByJob($value['job_id']);
                $result[$key]['job_name'] = $service->get_job_position($value['job_name']);
            }
            echo jsonp_encode(true, FactoryVMap::list_to_models($result, 'home_job_list'), $service->get_pub_jobs($_POST['uid'], $_POST['type'], 2, $_POST['page'], $_POST['size'], true));
        } else {
            echo jsonp_encode(false);
        }
    }

    /**
     * 获取指定用户正在运作的职位11110 
     */
    public function get_running_jobs() {
        if (!$this->is_legal_request())
            return;
        $data = home_agent_account_page::get_running_job($_POST['id'], $_POST['type'], $_POST['page'], $_POST['size']);
        if (!empty($data)) {
            $count = home_agent_account_page::get_running_job_count($_POST['id'], $_POST['type']);
            echo jsonp_encode(true, $data, $count);
        } else {
            echo jsonp_encode(false);
        }
    }

    /**
     * 获取指定用户正在运作的简历11110 
     */
    public function get_running_resumes() {
        if (!$this->is_legal_request())
            return;
        $data = home_agent_account_page::get_running_resume($_POST['id'], $_POST['type'], $_POST['page'], $_POST['size']);
        if (!empty($data)) {
            $count = home_agent_account_page::get_running_resume_count($_POST['id'], $_POST['type']);
            echo jsonp_encode(true, $data, $count);
        } else {
            echo jsonp_encode(false);
        }
    }

    /**
     * 举报11111
     */
    public function do_report() {
        if (!$this->is_legal_request())
            return;
        $data['reported_id '] = $_POST['reported_id'];
        $data['type'] = $_POST['type'];
        $data['newtype'] = $_POST['newtype'];
        $data['content'] = $_POST['content'];
        $data['report_user_id'] = AccountInfo::get_user_id();
        $data['status'] = 1;
        $reportService = new ReportService();
        //参数验证
        $result = $reportService->addReport($data);
        if (is_zerror($result) || $result == false) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

}

?>
