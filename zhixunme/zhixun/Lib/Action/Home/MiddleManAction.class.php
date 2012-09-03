<?php

header('content-type:text/html;charset=utf-8');

/**
 * Module:007
 */
class MiddleManAction extends BaseAction {

    /**
     * 经纪人首页00010
     */
    public function home() {
        $user_id = AccountInfo::get_user_id();
        $this->assign('resumes', home_recommend_page::get_recommend_resume_rand($user_id, 4));
        $this->assign('jobs', home_recommend_page::get_recommend_job_rand($user_id, 4));
        //$this->assign('tasks', home_recommend_page::get_recommend_task_rand($user_id, 6));
        $this->assign('moving', home_contacts_index_page::get_follow_moving(0, 1, 5, $user_id));
        $this->assign('page', home_agent_page::get_page_count($user_id));
        $this->assign('humans', home_recommend_page::get_recommend_human_rand($user_id, 8));
        $this->assign('arts', home_article_index_page::get_web_moving());
        $this->assign('current', home_package_index_page::get_current_package($user_id));
        $this->assign('statistics', home_agent_account_page::get_statistics());
        $this->display('MiddleMan:home');
    }

    /**
     * 经纪人职讯推荐页00010
     */
    public function index() {
        $this->display();
    }

    /**
     * 人才管理页面00010
     */
    public function humanManageIndex() {
        $uri = substr($_SERVER['REQUEST_URI'], -5);
        if ($uri == 'atm/2') {
            $service = new RemindService();
            $service->clear_sp_remind(AccountInfo::get_user_id(), array(C('REMIND_RAGENT'), C('REMIND_EDRESUME')));
        } else if ($uri == 'atm/3') {
            $service = new RemindService();
            $service->clear_sp_remind(AccountInfo::get_user_id(), C('REMIND_YPRESUME'));
        }
        $this->display();
    }

    /**
     * 职位管理页面00010
     */
    public function jobManageIndex() {
        $uri = substr($_SERVER['REQUEST_URI'], -5);
        if ($uri == 'apm/2') {
            $service = new RemindService();
            $service->clear_sp_remind(AccountInfo::get_user_id(), array(C('REMIND_JAGENT'), C('REMIND_EDJOB')));
        }
        $jobService = new JobService();
        $size = 10;
        $search_count = home_job_index_page::searchJobCount(null, null, null, null, null, null, null, null);
        if ($search_count % $size == 0) {
            $search_page_count = intval($search_count / $size);
        } else {
            $search_page_count = intval($search_count / $size) + 1;
        }
        //搜索结果总页数
        $this->assign('search_page_count', $search_page_count);
        //热门关键词
        $this->assign('hot_keyword', $jobService->getSearchHotKeyword());
        $this->display();
    }

    /**
     * 我的人脉00010
     */
    public function contacts() {
        $this->display();
    }

    /**
     * 经纪人创建兼职简历页面00010
     */
    public function cpresume() {
        $this->display();
    }

    /**
     * 经纪人创建职位页面00010
     */
    public function job() {
        $this->display();
    }

    /**
     * 经纪人推广页面00010
     */
    public function promote() {
        $data = home_agent_page::get_promote_data($status);
        for ($i = $data['ia']->min_days; $i <= $data['ia']->max_days; $i++) {
            $sai[] = $i;
        }
        for ($i = $data['na']->min_days; $i <= $data['na']->max_days; $i++) {
            $san[] = $i;
        }
        $this->assign('promote', $data);
        $this->assign('record', home_agent_page::get_promote_record());
        $this->assign('mai', $data['ia']->m_count);
        $this->assign('man', $data['na']->m_count);
        $this->assign('uai', $data['ia']->m_count - $data['ia']->s_count);
        $this->assign('uan', $data['na']->m_count - $data['na']->s_count);
        $this->assign('yai', $data['ia']->s_count);
        $this->assign('yan', $data['na']->s_count);
        $this->assign('sai', $sai);
        $this->assign('san', $san);
        $this->assign('status', $status);
        //var_dump($data['ia']->s_count);
        $this->display();
    }

    /**
     * 经纪人查看委托他代理的人才列表00010
     */
    public function get_DelegatedHuman() {
        if (!$this->is_legal_request())
            return;
        $page = $_POST['page'];
        $size = $_POST['size'];
        $agent_id = AccountInfo::get_user_id();
        $delegate_state = $_POST['delegate_state'];
        $job_category = $_POST['job_category'];
        $register_case = $_POST['register_case'];
        $result = home_agent_page::getDelegatedHuman($page, $size, $agent_id, $delegate_state, $job_category, $register_case);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_agent_page::getDelegateHumanCount($agent_id, $delegate_state, $job_category, $register_case));
        }
    }

    /**
     * 经纪人查看拥有的人才列表00010
     */
    public function get_OwnHuman() {
        if (!$this->is_legal_request())
            return;
        $page = $_POST['page'];
        $size = 200; //$_POST['size'];
        $owner = AccountInfo::get_user_id();
        $result = home_agent_page::getOwnResume($page, $size, $owner);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_agent_page::getOwnResumeCount($owner));
        }
    }

    /**
     * 经纪人查看他私有简历列表00010
     */
    public function get_PrivateResume() {
        //************测试数据************
        //参数 page,size,status(0不限1未公开2求职中)，category(0不限1全职2兼职)
        if (!$this->is_legal_request())
            return;
        $page = $_POST['page'];
        $size = $_POST['size'];
        $creator_id = AccountInfo::get_user_id();
        $creator_role = AccountInfo::get_role_id();
        $delegate_status = $_POST['status'];
        $job_category = $_POST['category'];
        $register_case = $_POST['register_case'];
        $result = home_agent_page::getPrivateResumeList($creator_id, $creator_role, $delegate_status, $job_category, $register_case, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_agent_page::getPrivateResumeCount($creator_id, $creator_role, $delegate_status, $job_category, $register_case));
        }
    }

    /**
     * 经纪人查看感兴趣的人才00010
     */
    public function get_InterestedHuman() {
        if (!$this->is_legal_request())
            return;
        $acceptor_id = AccountInfo::get_user_id();
        $page = $_POST['page'];
        $size = $_POST['size'];
        $job_category = $_POST['job_category'];
        $register_case = $_POST['register_case'];
        $publisher_role = $_POST['publisher_role'];
        $register_province_ids = $_POST['register_province_ids'];
        $register_certificate_id = $_POST['register_certificate_id'];
        $promote_service = 3;
        $result = home_recommend_page::getInterestedHuman($acceptor_id, $promote_service, $page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_recommend_page::getInterestedHumanCount($acceptor_id, $promote_service, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id));
        }
    }

    /**
     * 经纪人查看系统推荐的人才00010
     */
    public function get_RecommendHuman() {
        if (!$this->is_legal_request())
            return;
        $acceptor_id = AccountInfo::get_user_id();
        $page = $_POST['page'];
        $size = $_POST['size'];
        $job_category = $_POST['job_category'];
        $register_case = $_POST['register_case'];
        $publisher_role = $_POST['publisher_role'];
        $register_province_ids = $_POST['register_province_ids'];
        $register_certificate_id = $_POST['register_certificate_id'];
        $promote_service = 3;
        $result = home_recommend_page::getRecommendHuman($acceptor_id, $promote_service, $page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_recommend_page::getRecommendHumanCount($acceptor_id, $promote_service, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id));
        }
    }

    /**
     * 经纪人查看系统推荐的职位00010
     */
    public function get_RecommendJob() {
        $acceptor_id = AccountInfo::get_user_id();
        $page = $_POST['page'];
        $size = $_POST['size'];
        $job_category = $_POST['job_category'];
        $register_case = $_POST['register_case'];
        $publisher_role = $_POST['publisher_role'];
        $job_province_code = $_POST['job_province_code'];
        $register_certificate_id = $_POST['register_certificate_id'];
        $promote_service = 1;
        $result = home_recommend_page::getRecommendJob($acceptor_id, $promote_service, $page, $size, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_recommend_page::getRecommendJobCount($acceptor_id, $promote_service, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id));
        }
    }

    /**
     * 经纪人查看系统推荐的任务00010
     */
    public function get_recommend_task() {
        if (!$this->is_legal_request())
            return;
        $data = home_recommend_page::get_recommend_task(AccountInfo::get_user_id(), $_POST['class'], null, $_POST['type'], $_POST['page'], $_POST['size']);
        if (empty($data)) {
            echo jsonp_encode(false);
        } else {
            $count = home_recommend_page::get_recommend_task_count(AccountInfo::get_user_id(), $_POST['class'], null, $_POST['type']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 经纪人查看委托他代理的职位列表00010
     */
    public function get_AgentedJob() {
        if (!$this->is_legal_request())
            return;
        $data = home_job_index_page::get_agented_job_list($_POST['type'], $_POST['status'], $_POST['page']);
        if (empty($data)) {
            echo jsonp_encode(false);
        } else {
            $count = home_job_index_page::get_agented_job_count($_POST['type'], $_POST['status']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 经纪人查看委托他代理的职位详细00010
     */
    public function do_read_delegate_job() {
        if (!$this->is_legal_request())
            return;
        $service = new JobService();
        $result = $service->read_delegate_job(AccountInfo::get_user_id(), $_POST['job_id']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, C('WEB_ROOT') . '/office/' . $_POST['job_id']);
        }
    }

    /**
     * 经纪人查看他发布的职位列表00010
     */
    public function get_PubJob() {
        if (!$this->is_legal_request())
            return;
        if (empty($_POST['size']))
            $size = C('SIZE_JOBS');
        else
            $size = $_POST['size'];
        $data = home_job_index_page::get_pub_job_list($_POST['type'], $_POST['status'], $_POST['page'], $size);
        if (empty($data)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $data, home_job_index_page::get_pub_job_count($_POST['type'], $_POST['status']));
        }
    }

    /**
     * 经纪人暂停职位00010
     */
    public function do_pause_job() {
        if (!$this->is_legal_request())
            return;
        $service = new JobService();
        $result = $service->pauseJob(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $_POST['jid']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人重新发布职位00010
     */
    public function do_restart_job() {
        if (!$this->is_legal_request())
            return;
        $service = new JobService();
        $result = $service->startJob(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $_POST['jid']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人查看人才投递给他发布的职位的简历00010
     */
    public function get_ReceiveResumeByJob() {
        if (!$this->is_legal_request())
            return;
        $data = home_job_index_page::get_job_resume_list($_POST['job'], $_POST['type'], $_POST['page']);
        if (empty($data)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $data, home_job_index_page::get_job_resume_count($_POST['job'], $_POST['type']));
        }
    }

    /**
     * 经纪人邀请人才委托他代理简历00010
     */
    public function do_InviteResume() {
        $service = new ResumeService();
        $result = $service->inviteResume(AccountInfo::get_user_id(), $_POST['rid'], $_POST['jid']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            Notify();                                           //系统通知
            invite_notify($_POST['jid'], $_POST['rid']);        //邀请通知
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人结束招聘00010
     */
    public function do_EndRecruitment() {
        if (!$this->is_legal_request())
            return;
        $service = new JobService();
        $result = $service->closeJob(AccountInfo::get_user_id(), $_POST['id']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人公开他代理的人才的求职意向00010
     */
    public function do_OpenJobIntent() {
        if (!$this->is_legal_request())
            return;
        $resumeService = new ResumeService();
        $publisher = AccountInfo::get_user_id();
        $role = AccountInfo::get_role_id();
        $resume_id = $_POST['resume_id'];
        $result = $resumeService->openResume($publisher, $role, $resume_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人关闭他代理的人才的求职意向00010
     */
    public function do_CloseJobIntent() {
        if (!$this->is_legal_request())
            return;
        $resumeService = new ResumeService();
        $operator = AccountInfo::get_user_id();
        $role = AccountInfo::get_role_id();
        $resume_id = $_POST['resume_id'];
        $result = $resumeService->closeResume($operator, $role, $resume_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人向企业发布的职位投递他代理的人才的简历00010
     */
    public function do_SendResumeToJob() {
        if (!$this->is_legal_request())
            return;
        $resumeService = new ResumeService();
        $sender = AccountInfo::get_user_id();
        $role = AccountInfo::get_role_id();
        $resume_ids = $_POST['resume_ids'];
        $job_id = $_POST['job_id'];
        $result = $resumeService->sendResumesToJob($sender, $role, $job_id, $resume_ids);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人公开他代理的企业的招聘信息00010
     */
    public function do_OpenJob() {
        if (!$this->is_legal_request())
            return;
        $service = new JobService();
        $result = $service->pubJob(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $_POST['job_id']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人发布招聘信息00010
     */
    public function do_pub_job() {
        if (!$this->is_legal_request())       //是否合法请求
            return;
        $service = new JobService();
        $user_id = AccountInfo::get_user_id();
        /**
         * 增加手动输入期望待遇
         */
        if (12 == trim($_POST['salary'])) {
            $input_salary = transform_number($_POST['treatment']);
            $job_salary = 12;
        } else {
            $input_salary = 0.00;
            $job_salary = $_POST['salary'];
        }
        if ($_POST['type'] == 1) {            //全职
            $result = $service->createJob($user_id, $_POST['title'], $_POST['job_type'], $_POST['name'], $_POST['job'], $_POST['count'], $_POST['RCIS'], $_POST['RCSS'], $_POST['GCI'], $_POST['GCC'], $_POST['pid'], $_POST['cid'], $job_salary, $input_salary, $_POST['degree'], $_POST['exp'], $_POST['description'], $_POST['company_qualification'], $_POST['company_category'], $_POST['company_regtime'], $_POST['company_scale'], $_POST['company_introduce']);
        } else {                               //兼职
            $result = $service->createPartJob($user_id, $_POST['title'], $_POST['job_type'], $_POST['name'], $_POST['RCIS'], $_POST['RCSS'], $_POST['RCCS'], $_POST['GCI'], $_POST['GCC'], $_POST['place'], $_POST['pid'], $_POST['cid'], $job_salary, $input_salary, $_POST['safety_b'], $_POST['muti'], $_POST['degree'], $_POST['exp'], $_POST['status'], $_POST['social'], $_POST['description'], $_POST['company_qualification'], $_POST['company_category'], $_POST['company_regtime'], $_POST['company_scale'], $_POST['company_introduce']);
        }
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            $do = $service->pubJob($user_id, C('ROLE_AGENT'), $result);
            if (is_zerror($do)) {
                echo jsonp_encode(false, $do->get_message());
            } else {
                $api_crm = new ApiCrmService();
                $api_crm->importCompany($result, $user_id);
                echo jsonp_encode(true);
            }
        }
    }

    /**
     * 获取可邀请简历职位列表00010
     */
    public function get_can_invite_jobs() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_job_index_page::get_ci_job_list();
        if (empty($data)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 经纪人查看他为委托他的人才投递的简历（应聘过的职位）00010
     */
    public function get_SentJobByHuman() {
        $sender = AccountInfo::get_user_id();
        $role = AccountInfo::get_role_id();
        $resume_id = $_POST['resume_id'];
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = home_job_index_page::getSentJob($sender, $role, null, null, null, $page, $size, $resume_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_job_index_page::getSentJobCount($sender, $role, null, null, null, $resume_id));
        }
    }

    /**
     * 经纪人修改基本资料00010
     */
    public function do_update() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new MiddleManService();
        $result = $service->update_agent(AccountInfo::get_user_id(), AccountInfo::get_data_id(), $_POST['name'], $_POST['qq'], $_POST['pid'], $_POST['cid'], $_POST['in'], '', $_POST['company'], $_POST['gender'], $_POST['email'], $_POST['phone']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人查看可能感兴趣的职位00010
     */
    public function get_InterestedJob() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $acceptor_id = AccountInfo::get_user_id();
        $page = $_POST['page'];
        $size = $_POST['size'];
//        $page=1;
//        $size=5;
        $job_category = $_POST['job_category'];
        $register_case = $_POST['register_case'];
        $publisher_role = $_POST['publisher_role'];
        $job_province_code = $_POST['job_province_code'];
        $register_certificate_id = $_POST['register_certificate_id'];
        $promote_service = 1;
        $result = home_recommend_page::getInterestedJob($acceptor_id, $promote_service, $page, $size, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_recommend_page::getInterestedJobCount($acceptor_id, $promote_service, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id));
        }
    }

    /**
     * 经纪人查看应聘来的简历00010
     */
    public function get_SentResume() {
        if (!$this->is_legal_request())
            return;
        $publisher_id = AccountInfo::get_user_id();
        $publisher_role = AccountInfo::get_role_id();
        $sent_status = $_POST['sent_status'];
        $job_category = $_POST['job_category'];
        $sender_role = $_POST['sender_role'];
        $page = $_POST['page'];
        $size = $_POST['size'];
//        $page=1;
//        $size=5;
        $result = home_agent_page::getSentResume($publisher_id, $publisher_role, $sent_status, $job_category, $sender_role, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_agent_page::getSentResumeCount($publisher_id, $publisher_role, $sent_status, $job_category, $sender_role));
        }
    }

    /**
     * 经纪人阅读应聘来的简历00010
     */
    public function do_readSentResume() {
        if (!$this->is_legal_request())
            return;
        $operator = AccountInfo::get_user_id();
        $operator_role = AccountInfo::get_role_id();
//        $send_resume_id='14';
        $send_resume_id = $_POST['send_resume_id'];
        $resumeService = new ResumeService();
        $result = $resumeService->updateSendStatus($operator, $operator_role, $send_resume_id, 2);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人阅读委托来的简历00010
     */
    public function do_readDelegatedResume() {
        if (!$this->is_legal_request())
            return;
        $resumeService = new ResumeService();
        $resume_id = $_POST['rid'];
        $agent = AccountInfo::get_user_id();
        $result = $resumeService->updateDelegateResumeStatus($agent, $resume_id, 1);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人完成简历委托00010
     */
    public function do_completeDelegatedResume() {
        if (!$this->is_legal_request())
            return;
        $resumeService = new ResumeService();
        $resume_id = $_POST['resume_id'];
        $agent = AccountInfo::get_user_id();
        $result = $resumeService->completeDelegateResume($agent, $resume_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人创建私有兼职简历00010
     */
    public function do_createPrivateHCresume() {
        if (!$this->is_legal_request()) {
            return;
        }
        $resumeService = new ResumeService();
        $owner = AccountInfo::get_user_id();
        $owner_role = AccountInfo::get_role_id();
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $province_code = $_POST['province_code'];
        $city_code = $_POST['city_code'];
        $contact_mobile = $_POST['contact_mobile'];
        $contact_qq = $_POST['contact_qq'];
        $contact_email = $_POST['contact_email'];
        $work_age = $_POST['work_age'];
        $RC_ids = $_POST['RC_ids'];
        $RC_cases = $_POST['RC_cases'];
        $RC_provinces = $_POST['RC_provinces'];
        $GC_id = $_POST['GC_id'];
        $GC_class = $_POST['GC_class'];
        /**
         * 增加手动输入期望待遇
         */
        if (12 == trim($_POST['job_salary'])) {
            $input_salary = transform_number($_POST['treatment']);
            $job_salary = 12;
        } else {
            $input_salary = 0.00;
            $job_salary = $_POST['job_salary'];
        }
        $register_province_ids = $_POST['register_province_ids'];
        $certificate_remark = $_POST['certificate_remark'];
        $is_public = $_POST['is_public'];
        $result = $resumeService->createPrivateHCresume($owner, $owner_role, $name, $gender, $birthday, $province_code, $city_code, $contact_mobile, $contact_qq, $contact_email, $work_age, $RC_ids, $RC_cases, $RC_provinces, $GC_id, $GC_class, $job_salary, $input_salary, $register_province_ids, $certificate_remark, $is_public, $human_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            ApiCrmService::importHuman(array('human' => $human_id, 'user_id' => AccountInfo::get_user_id()));
            echo jsonp_encode(true);
        }
    }

    /**
     * 经纪人创建私有全职简历第一步00010
     */
    public function do_createPrivateResumeStep1() {
        if (!$this->is_legal_request()) {
            return;
        }
        $resumeService = new ResumeService();
        $owner = AccountInfo::get_user_id();
        $owner_role = AccountInfo::get_role_id();
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $province_code = $_POST['province_code'];
        $city_code = $_POST['city_code'];
        $contact_mobile = $_POST['contact_mobile'];
        $contact_qq = $_POST['contact_qq'];
        $contact_email = $_POST['contact_email'];
        $work_age = $_POST['work_age'];
        $result = $resumeService->createPrivateResumeStep1($owner, $owner_role, $name, $gender, $birthday, $province_code, $city_code, $contact_mobile, $contact_qq, $contact_email, $work_age, $human_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            ApiCrmService::importHuman(array('human' => $human_id, 'user_id' => AccountInfo::get_user_id()));
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 经纪人创建私有全职简历第二步00010
     */
    public function do_createPrivateResumeStep2() {
        if (!$this->is_legal_request()) {
            return;
        }
        $resumeService = new ResumeService();
        $human_id = $_POST['human_id'];
        $job_name = $_POST['job_name'];
        $job_province_code = $_POST['job_province_code'];
        $job_city_code = $_POST['job_city_code'];
        /**
         * 增加手动输入期望待遇
         */
        if (12 == trim($_POST['job_salary'])) {
            $input_salary = transform_number($_POST['treatment']);
            $job_salary = 12;
        } else {
            $input_salary = 0.00;
            $job_salary = $_POST['job_salary'];
        }
        $job_describle = $_POST['job_describle'];
        $study_startdate = $_POST['study_startdate'];
        $study_enddate = $_POST['study_enddate'];
        $school = $_POST['school'];
        $major_name = $_POST['major_name'];
        $degree_name = $_POST['degree_name'];
        $RC_ids = $_POST['RC_ids'];
        $RC_cases = $_POST['RC_cases'];
        $RC_provinces = $_POST['RC_provinces'];
        $RC_ids = $_POST['RC_ids'];
        $RC_cases = $_POST['RC_cases'];
        $RC_provinces = $_POST['RC_provinces'];
        $GC_id = $_POST['GC_id'];
        $GC_class = $_POST['GC_class'];
        $certificate_remark = $_POST['certificate_remark'];
        $result = $resumeService->createPrivateResumeStep2($human_id, $job_name, $job_province_code, $job_city_code, $job_salary, $input_salary, $job_describle, $study_startdate, $study_enddate, $school, $major_name, $degree_name, $RC_ids, $RC_cases, $RC_provinces, $RC_ids, $RC_cases, $RC_provinces, $GC_id, $GC_class, $certificate_remark);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 创建全职简历页面00010
     */
    public function createResumeIndex() {
        $this->display();
    }

    /**
     * 修改私有简历页面00010
     */
    public function updateResumeIndex() {
        $human_id = $_GET['human_id'];
        $resume = home_human_profile_page::getResume($human_id);
        $this->assign('human', $resume->human);
        $this->assign('resume', $resume);
        $this->assign('intent', home_human_profile_page::getJobIntent($resume->job_intent->job_name_ids));
        $this->display();
    }

    /**
     * 修改挂证（兼职简历）页面00010
     */
    public function updateHCIndex() {
        $human_id = $_GET['human_id'];
        $HC_resume = home_human_profile_page::getHCresume($human_id);
        if (empty($HC_resume) || $HC_resume->agent_id != AccountInfo::get_user_id()) {
            redirect(C('ERROR_PAGE'));
        }
        $this->assign('HC_resume', $HC_resume);
        $this->display();
    }

    /**
     * 删除私有简历00010
     */
    public function do_deletePrivateResume() {
        if (!$this->is_legal_request()) {
            return;
        }
        $human_id = $_POST['human_id'];
        $operator = AccountInfo::get_user_id();
        $resumeService = new ResumeService();
        $result = $resumeService->deletePrivateResume($operator, $human_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 创建Blog页面00010
     */
    public function createBlogIndex() {
        $this->display('Blog:updateBlogIndex');
    }

    /**
     * 更新Blog页面00010
     */
    public function updateBlogIndex() {
        $this->assign('blog', home_blog_page::getBlog($_GET['id']));
        $this->display('Blog:updateBlogIndex');
    }

    /**
     * 管理Blog页面00010
     */
    public function adminBlogIndex() {
        $this->display('Blog:adminBlogIndex');
    }

    /**
     * 经纪人提醒设置页面00010
     */
    public function remind() {
        $this->assign('notice_condition', ObjectPool::getObj('NoticeCrmService')->get_notice_condition_list());
        $this->assign('notice_way', ObjectPool::getObj('NoticeCrmService')->get_notice_way_list());
        $this->assign('notice_user', crm_notice_page::notice_user_init(AccountInfo::get_user_id()));
        $this->display();
    }

    /**
     * 设置隐私00010
     */
    public function setPrivacyAgent() {
        $user_id = AccountInfo::get_user_id();
        $this->assign('privacyAgent', home_agent_page::getPrivacyAgent($user_id));
        $this->display();
    }

    /**
     * 执行隐私更改00010
     */
    public function do_update_privacyAgent() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $user_id = AccountInfo::get_user_id();
        $service = new PrivacyService();
        if ($_POST['job']) {
            $data['job'] = $_POST['job'];
        }
        if ($_POST['resume']) {
            $data['resume'] = $_POST['resume'];
        }
        if ($_POST['name']) {
            $data['name'] = $_POST['name'];
        }
        if ($_POST['contact_way']) {
            $data['contact_way'] = $_POST['contact_way'];
            if ($_POST['contact_way'] == 1) {
                $userService = new UserService();
                $userInfo = $userService->get_user($user_id);
                if ($userInfo['is_phone_auth'] != 1) {
                    echo jsonp_encode(false, "手机未认证");
                    return false;
                }
                if (!var_validation($userInfo['phone'], VAR_PHONE)) {
                    echo jsonp_encode(false, "指定手机不存在");
                    return false;
                }
            }
        }
        //将电话回拨的时间段处理
        if ($_POST['call_type']) {
            /**
             * 把前台的时间段转换为数组
             */
            $pretime = explode(",", $_POST['call_time']);
            $call_time = array();
            $i = 0;
            $j = 0;
            foreach ($pretime as $key => $value) {
                if ($key % 2 == 0) {
                    $call_time[$i]['start_time'] = $value;
                    $i++;
                }
                if ($key % 2 == 1) {
                    $call_time[$j]['end_time'] = $value;
                    $j++;
                }
            }
            $call = array(
                'call_type' => $_POST['call_type'],
                'call_time' => $call_time,
            );
            $call_time_slot = serialize($call);
            $calldata['call_time_slot'] = $call_time_slot;
            $user_id = AccountInfo::get_user_id();
            $callService = new CallSetService();
            $s = $callService->updateCallSetInfo($user_id, $calldata);
            if (is_zerror($s)) {
                echo jsonp_encode(false, $result->get_message());
            }
        }
        $result = $service->updateAgentPrivacy($_POST['agent_privacy_id'], $data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 猎头修改头像00010
     */
    public function do_update_photo() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        $result = $service->update_photo(AccountInfo::get_user_id(), cut_avatar($_POST['photo']));
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 搜索职位00010 
     */
    public function get_searchJob() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        //地区省份编号
        $require_place = $_POST['require_place'];
        //薪资待遇1(0~3),2(3～5),3(5~15),4(15~30),5(30~100),6(100+),7(面议)
        $salary = $_POST['salary'];
        //发布日期1(1周内),2(半月内),3(1月内),4(6个月内),5(1年内)
        $pub_date = $_POST['pub_date'];
        //资质证书(1选中，2未选中)
        $cert_type = $_POST['cert_type'];
        if (empty($cert_type)) {
            $cert_type = 2;
        }
        //关键词
        $word = $_POST['word'];
        //认证用户(1选中，2未选中）
        $is_real_auth = $_POST['is_real_auth'];
        if (empty($is_real_auth)) {
            $is_real_auth = 2;
        }
        //第几页
        $page = $_POST['page'];
        if (empty($page)) {
            $page = 1;
        }
        //每页条数
        $size = $_POST['size'];
        if (empty($size)) {
            $size = 10;
        }
        //排序(1-浏览数降序,2-薪资待遇降序,3-薪资待遇升序,4-发布时间降序,5-发布时间升序)
        $order = $_POST['order'];
        $result = home_job_index_page::searchJob($require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, null, $page, $size, $order);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_job_index_page::searchJobCount($require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, null, $order));
        }
    }

}

?>
