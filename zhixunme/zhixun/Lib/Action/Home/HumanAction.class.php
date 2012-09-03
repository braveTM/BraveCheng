<?php

/**
 * Module:004
 */
class HumanAction extends BaseAction {

    /**
     * 人才首页01000
     */
    public function home() {
        $user_id = AccountInfo::get_user_id();
        $this->assign('jobs', home_recommend_page::get_recommend_job_rand($user_id, 6));
        $this->assign('moving', home_contacts_index_page::get_follow_moving(0, 1, 5, $user_id));
        $this->assign('page', home_human_page::get_page_count($user_id, AccountInfo::get_resume_id()));
        $this->assign('agents', home_recommend_page::get_recommend_agent_rand($user_id, 8));
        $this->assign('arts', home_article_index_page::get_web_moving());
        $this->assign('current', home_package_index_page::get_current_package($user_id));
        if (AccessControl::allow_popup()) {
            $this->assign('popup_agent', home_recommend_page::getPopupRecommendAgent($user_id, 10));
            $this->assign('role', 1);
        }
        $this->display('Human:home');
    }

    /**
     * 人才首页01000
     */
    public function index() {
        $this->display();
    }

    /**
     * 找职位页面01000
     */
    public function getJobIndex() {
        $jobService = new JobService();
        $size=10;
        $search_count=home_job_index_page::searchJobCount(null, null, null, null, null, null, null, null);
        if ($search_count % $size == 0) {
            $search_page_count=intval($search_count/$size);
        }else{
            $search_page_count=intval($search_count/$size)+1;
        }
        //搜索结果总页数
        $this->assign('search_page_count',$search_page_count);
        //热门关键词
        $this->assign('hot_keyword', $jobService->getSearchHotKeyword());
        $this->display();
    }

    /**
     * 找企业页面01000
     */
    public function getCompanyIndex() {
        $this->display();
    }

    /**
     * 找经纪人页面01000
     */
    public function getAgentIndex() {
        if ($_GET['type'] == '1' || $_GET['type'] == '2')
            $this->assign('type', $_GET['type']);
        $this->display();
    }

    /**
     * 简历页面01000
     */
    public function resumeIndex() {
        $this->assign('rcerts', home_human_certificate_page::get_register_certs());
        $this->assign('gcert', home_human_certificate_page::get_grade_cert());
        $human_id = AccountInfo::get_data_id();
        $resume = home_human_profile_page::getResume($human_id);
        $this->assign('resume', $resume);
        $HC_resume = home_human_profile_page::getHCresume($human_id);
        $this->assign('HC_resume', $HC_resume);
        $agent = home_agent_account_page::get_agent_detail($resume->agent_id);
        $this->assign('agent', $agent);
        $this->assign('gender', $resume->human->gender);
        $this->assign('intent', home_human_profile_page::getJobIntent($resume->job_intent->job_name_ids));
        $this->display();
    }

    /**
     * 人才查看系统推荐的职位01000
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
     * 人才投递简历01000
     */
    public function do_SendResumeToJob() {
        if (!$this->is_legal_request())
            return;
        $resumeService = new ResumeService();
        $sender = AccountInfo::get_user_id();
        $role = AccountInfo::get_role_id();
        $resume_id = AccountInfo::get_resume_id();
        $job_id = $_POST['job_id'];
        $result = $resumeService->sendResumeToJob($sender, $role, $job_id, $resume_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 人才公开简历01000
     */
    public function do_OpenResume() {
        if (!$this->is_legal_request())
            return;
        $resumeService = new ResumeService();
        $publisher = AccountInfo::get_user_id();
        $role = AccountInfo::get_role_id();
        $resume_id = AccountInfo::get_resume_id();
        $job_category = $_POST['job_category'];
        $result = $resumeService->openResume($publisher, $role, $resume_id, $job_category);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 人才关闭简历01000
     */
    public function do_CloseResume() {
        if (!$this->is_legal_request())
            return;
        $resumeService = new ResumeService();
        $operator = AccountInfo::get_user_id();
        $role = AccountInfo::get_role_id();
        $resume_id = AccountInfo::get_resume_id();
        $result = $resumeService->closeResume($operator, $role, $resume_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 检测简历完整性01000
     */
    public function do_check_resume() {
        if (!$this->is_legal_request())
            return;
        //$service = new ResumeService();
        //$_POST['job_category'];
        $resumeService = new ResumeService();
        $resume_id = AccountInfo::get_resume_id();
        $job_category = $_POST['job_category'];
        $result = $resumeService->validateResumeComplete($resume_id, $job_category);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, C('WEB_ROOT') . '/tfa/' . $_POST['job_category']);
        }
    }

    /**
     * 人才将简历委托给经纪人01000
     */
    public function do_DelegateResume() {
        if (!$this->is_legal_request())
            return;
        $resumeService = new ResumeService();
        $operator = AccountInfo::get_user_id();
        $role = AccountInfo::get_role_id();
        $agent = $_POST['agent_id'];
        $job_category = $_POST['job_category'];
        $resume_id = AccountInfo::get_resume_id();
        $result = $resumeService->delegateResume($operator, $role, $agent, $resume_id, $job_category);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            ApiCrmService::importHuman(array('human' => AccountInfo::get_data_id(), 'user_id' => $agent));
            echo jsonp_encode(true);
        }
    }

    /**
     * 人才终止简历委托01000
     */
    public function do_end_delegate_resume() {
        if (!$this->is_legal_request())
            return;
        $service = new ResumeService();
        $result = $service->endDelegateResume(AccountInfo::get_resume_id(), $agent_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            Notify($agent_id);
            echo jsonp_encode(true);
        }
    }

    /**
     * 人才查看他投递的简历（应聘过的职位）01000
     */
    public function get_SentJob() {
        if (!$this->is_legal_request())
            return;
        $sender = AccountInfo::get_user_id();
        $role = AccountInfo::get_role_id();
        $job_category = $_POST['job_category'];
        $publisher_role = $_POST['publisher_role'];
        $register_case = $_POST['register_case'];
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = home_job_index_page::getSentJob($sender, $role, $job_category, $publisher_role, $register_case, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_job_index_page::getSentJobCount($sender, $role, $job_category, $publisher_role, $register_case));
        }
    }

    /**
     * 人才修改基本资料01000
     */
    public function do_update() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new HumanService();
        $result = $service->update_human(AccountInfo::get_user_id(), AccountInfo::get_data_id(), $_POST['name'], $_POST['gender'], $_POST['birth'], $_POST['pid'], $_POST['cid'], $_POST['qq'], null, null, $_POST['phone'], $_POST['email']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 人才修改头像01000
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
     * 人才查看可能感兴趣的职位01000
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
     * 人才查看可能感兴趣的企业01000
     */
    public function get_InterestedCompany() {
        if (!$this->is_legal_request())
            return;
        $acceptor_id = AccountInfo::get_user_id();
        $page = $_POST['page'];
        $size = $_POST['size'];
        $company_province_code = $_POST['company_province_code'];
        $company_city_code = $_POST['company_city_code'];
        $promote_service = 7;
        $result = home_recommend_page::getInterestedCompany($acceptor_id, $promote_service, $page, $size, $company_province_code, $company_city_code);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_recommend_page::getInterestedCompanyCount($acceptor_id, $promote_service, $company_province_code, $company_city_code));
        }
    }

    /**
     * 人才找经纪人01000
     */
    public function get_AgentList() {
        if (!$this->is_legal_request())
            return;
        $type = $_POST['type'];
        $addr_province_code = $_POST['addr_province_code'];
        $addr_city_code = $_POST['addr_city_code'];
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = home_human_page::getAgentList($type, $addr_province_code, $addr_city_code, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_human_page::getAgentListCount($type, $addr_province_code, $addr_city_code));
        }
    }

    /**
     * 人才获取推荐经纪人
     */
    public function get_RecommendAgent() {
        if (!$this->is_legal_request())
            return;
        $acceptor_id = AccountInfo::get_user_id();
        $promote_service = 10;
        $service_category_id = $_POST['service_category_id'];
        $type = $_POST['type'];
        $addr_province_code = $_POST['addr_province_code'];
        $addr_city_code = $_POST['addr_city_code'];
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = home_recommend_page::getRecommendAgent($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_recommend_page::getRecommendAgentCount($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code));
        }
    }

    /**
     * 上传证书复印件01000
     */
    public function do_upload_cert() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        require_cache(APP_PATH . '/Common/Function/file.php');
        $result = file_upload($_POST['upfname'], get_user_path_root(AccountInfo::get_user_id()) . get_user_path_cert(), 'IMAGE');
        if (is_int($result)) {
            echo "<script type=\"text/javascript\">window.parent.resumeRender.c_m(\"0\")</script>";
        } else {
            require_cache(APP_PATH . '/Common/Function/image.php');
            $res = image_compress(C('IMAGE_NORMAL_MAX_W'), C('IMAGE_NORMAL_MAX_H'), $result);
            if (!$res) {
                echo "<script type=\"text/javascript\">window.parent.resumeRender.c_m(\"0\")</script>";
                return;
            }
            $service = new CertificateService();
            $result = $service->certificate_auth(AccountInfo::get_data_id(), $_POST['upfcid'], $result);
            if (is_zerror($result))
                echo "<script type=\"text/javascript\">window.parent.resumeRender.c_m(\"0\")</script>";
            else
                echo "<script type=\"text/javascript\">window.parent.resumeRender.c_m(\"1\")</script>";
        }
    }

    /**
     * 更新人才职称证书01000
     */
    public function do_update_gcert() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new CertificateService();
        $result = $service->updateGradeCertificate(AccountInfo::get_data_id(), $_POST['cid'], $_POST['gid'], $_POST['gclass']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 添加人才职称证书01000
     */
    public function do_add_gcert() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new CertificateService();
        $result = $service->addGradeCertificateToHuman(AccountInfo::get_data_id(), $_POST['gid'], $_POST['gclass']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除人才资质证书01000
     */
    public function do_delete_rcert() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new CertificateService();
        $result = $service->deleteCertificate(AccountInfo::get_data_id(), $_POST['cid']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 添加人才资质证书01000
     */
    public function do_add_rcert() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new CertificateService();
        $result = $service->addMutiRegisterCertificateToHuman(AccountInfo::get_data_id(), $_POST['rs'], $_POST['ps'], $_POST['cs']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 解除证书认证01000
     */
    public function do_remove_certification() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new CertificateService();
        $result = $service->remove_certification(AccountInfo::get_data_id(), $_POST['cid']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 获取意向推荐职位01000
     */
    public function get_intent_jobs() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $user_id = AccountInfo::get_user_id();
        $intent_id = AccountInfo::get_intent_id();
        $data = home_job_index_page::get_intent_jobs($user_id, $intent_id, $_POST['type'], $_POST['page'], $_POST['size']);
        if (empty($data)) {
            echo jsonp_encode(false);
        } else {
            $count = home_job_index_page::get_intent_jobs_count($user_id, $intent_id, $_POST['type']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 人才全职引导流程01000
     */
    public function do_registerfull_guide() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $cert['gcm_id'] = $_POST['gcm_id'];
        $cert['gcm_class'] = $_POST['gcm_class'];
        $cert['rc_ids'] = explode(',', $_POST['rc_ids']);  //注册证书id
        $cert['rc_case'] = explode(',', $_POST['rc_case']);   //注册证书情况
        $cert['rc_pros'] = explode(',', $_POST['rc_pros']);   //注册地
        $cert['job_type'] = explode(',', $_POST['job_type']);   //注册类别
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
        $cert['province_code'] = $_POST['province_code'];
        $cert['city_code'] = $_POST['city_code'];
        $cert['email'] = $_POST['email'];
        $cert['phone'] = $_POST['phone'];
        $userService = new UserService;
        $result = $userService->guidefull_register(AccountInfo::get_user_id(), AccountInfo::get_intent_id(), $cert);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 人才兼职引导流程01000
     */
    public function do_registerpart_guide() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $cert['gcm_id'] = $_POST['gcm_id'];
        $cert['gcm_class'] = $_POST['gcm_class'];
        $cert['rc_ids'] = explode(',', $_POST['rc_ids']);  //注册证书id
        $cert['rc_case'] = explode(',', $_POST['rc_case']);   //注册证书情况
        $cert['rc_pros'] = explode(',', $_POST['rc_pros']);   //注册地
        $cert['job_salary'] = $_POST['job_salary'];
        $cert['province_code'] = $_POST['province_code'];
        $cert['email'] = $_POST['email'];
        $cert['phone'] = $_POST['phone'];
        $userService = new UserService;
        $result = $userService->guidepart_register(AccountInfo::get_user_id(), AccountInfo::get_hang_card_id(), AccountInfo::get_resume_id(), $cert);
        //$result = $userService->guidepart_register1($data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 设置隐私01000
     */
    public function setPrivacyHuman() {
        $user_id = AccountInfo::get_user_id();
        $this->assign('privacyHuman', home_human_page::getPrivacyHuman($user_id));
        $service = new PackageService();
        $this->assign('min', $service->get_min_num($user_id));
        $this->display();
    }

    /**
     * 执行隐私更改01000
     */
    public function do_update_privacyHuman() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $user_id = AccountInfo::get_user_id();
        $service = new PrivacyService();
        if ($_POST['birthday']) {
            $data['birthday'] = $_POST['birthday'];
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
        $result = $service->updateHumanPrivacy($_POST['human_privacy_id'], $data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 搜索职位01000 
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
