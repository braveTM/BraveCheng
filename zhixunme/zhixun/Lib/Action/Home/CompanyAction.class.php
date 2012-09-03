<?php

header('content-type:text/html;charset=utf-8');

/**
 * Module:006
 */
class CompanyAction extends BaseAction {

    /**
     * 企业首页00100
     */
    public function home() {
        $user_id = AccountInfo::get_user_id();
        $this->assign('resumes', home_recommend_page::get_recommend_resume_rand($user_id, 6));
        $this->assign('moving', home_contacts_index_page::get_follow_moving(0, 1, 5, $user_id));
        $this->assign('page', home_company_page::get_page_count($user_id));
        $this->assign('humans', home_recommend_page::get_recommend_human_rand($user_id, 8));
        $this->assign('agents', home_recommend_page::get_recommend_agent_rand($user_id, 8));
        $this->assign('current', home_package_index_page::get_current_package($user_id));
        if (AccessControl::allow_popup()) {
            $this->assign('popup_agent', home_recommend_page::getPopupRecommendAgent($user_id, 10));
            $this->assign('role', 2);
        }
        $this->display('Company:home');
    }

    /**
     * 企业首页00100
     */
    public function index() {
        $this->display();
    }

    /**
     * 找人才页面00100
     */
    public function getHumanIndex() {
        $this->display();
    }

    /**
     * 找经纪人页面00100
     */
    public function getAgentIndex() {
        //if($_GET['token'] == job_token($_GET['job_id']))
        if (is_numeric($_GET['job_id']))                     //职位编号
            $this->assign('jid', $_GET['job_id']);
        if (is_numeric($_GET['d_id']))                          //委托编号
            $this->assign('did', $_GET['d_id']);
        $this->display();
    }

    /**
     * 招聘页面00100
     */
    public function recruitmentIndex() {
        $uri = substr($_SERVER['REQUEST_URI'], -13);
        if ($uri == 'recruitment/3') {
            $service = new RemindService();
            $service->clear_sp_remind(AccountInfo::get_user_id(), C('REMIND_EYPRESUME'));
        }
        $this->display();
    }

    /**
     * 企业创建职位页面00100
     */
    public function job() {
        $user = home_company_account_page::get_profile();
        $user->category=cc_format($user->category);
        $user->company_scale=company_scale_format($user->company_scale);
        $this->assign('info', $user);
        $this->display();
    }

    /**
     * 企业推广页面00100
     */
    public function promote() {
        $data = home_company_page::get_promote_data($status);
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
        $this->assign('own', $data['own']);
        $this->display();
    }

    /**
     * 企业查看系统推荐的人才00100
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
     * 企业邀请人才向他投递简历00100
     */
    public function do_InviteResume() {
        if (!$this->is_legal_request())
            return;
        $service = new ResumeService();
        $result = $service->inviteResume(AccountInfo::get_user_id(), $_POST['rid'], $_POST['jid']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            invite_notify($_POST['jid'], $_POST['rid']);        //邀请通知
            echo jsonp_encode(true);
        }
    }

    /**
     * 企业查看他发布的职位00100
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
     * 企业查看未处理的职位00100
     */
    public function get_wcl_job() {
        if (!$this->is_legal_request())
            return;
        if (empty($_POST['size']))
            $size = C('SIZE_JOBS');
        else
            $size = $_POST['size'];
        $data = home_job_index_page::get_wcl_job_list($_POST['type'], $_POST['page'], $size);
        if (empty($data)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $data, home_job_index_page::get_wcl_job_count($_POST['type']));
        }
    }

    /**
     * 企业查看他委托出去的职位00100
     */
    public function get_DelegateJob() {
        if (!$this->is_legal_request())
            return;
        $data = home_job_index_page::get_agent_job_list($_POST['type'], $_POST['status'], $_POST['page']);
        if (empty($data)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $data, home_job_index_page::get_agent_job_count($_POST['type'], $_POST['status']));
        }
    }

    /**
     * 企业结束招聘00100
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
     * 企业查看人才投递给他发布的职位的简历00100
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
     * 企业找经纪人00100
     */
    public function get_AgentList() {
        if (!$this->is_legal_request())
            return;
        //$service_category_id=$_POST['service_category_id'];
        $type = $_POST['type'];
        $addr_province_code = $_POST['addr_province_code'];
        $addr_city_code = $_POST['addr_city_code'];
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = home_company_page::getAgentList(null, $type, $addr_province_code, $addr_city_code, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_company_page::getAgentListCount($service_category_id, $type, $addr_province_code, $addr_city_code));
        }
    }

    /**
     * 企业获取推荐经纪人00100
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
     * 企业将职位委托给经纪人00100
     */
    public function do_delegate_job() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new JobService();
        $result = $service->delegateJob(AccountInfo::get_user_id(), $_POST['aid'], $_POST['jid']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
//            $api_crm = new ApiCrmService();
//            $api_crm->importCompany($_POST['jid'], $_POST['aid'], AccountInfo::get_user_id());
            echo jsonp_encode(true);
        }
    }

    /**
     * 终止职位委托00100
     */
    public function do_end_delegate_job() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new JobService();
        $result = $service->endDelegateJob(AccountInfo::get_user_id(), $_POST['id']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 获取可委托职位列表00100
     */
    public function get_can_delegate_jobs() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_job_index_page::get_cd_job_list();
        if (empty($data)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 获取可邀请简历职位列表00100
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
     * 企业查看感兴趣的人才00100
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
     * 企业发布招聘信息00100
     */
    public function do_pub_job() {
        if (!$this->is_legal_request())       //是否合法请求
            return;
        $service = new JobService();
        $user_id = AccountInfo::get_user_id();
        $svc = new CompanyService();
        $company = $svc->get_company(AccountInfo::get_data_id());
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
            $result = $service->createJob($user_id, $_POST['title'],$_POST['job_type'], $company['company_name'], $_POST['job'], $_POST['count'], $_POST['RCIS'], $_POST['RCSS'], $_POST['GCI'], $_POST['GCC'], $_POST['pid'], $_POST['cid'], $job_salary, $input_salary, $_POST['degree'], $_POST['exp'],$_POST['description'],$company['company_qualification'],$company['company_category'],$company['company_regtime'],$company['company_scale'],$company['introduce']);
        } else {                               //兼职
            $result = $service->createPartJob($user_id, $_POST['title'],$_POST['job_type'], $company['company_name'], $_POST['RCIS'], $_POST['RCSS'], $_POST['RCCS'], $_POST['GCI'], $_POST['GCC'], $_POST['place'], $_POST['pid'], $_POST['cid'], $job_salary, $input_salary, $_POST['safety_b'], $_POST['muti'], $_POST['degree'], $_POST['exp'], $_POST['status'], $_POST['social'],$_POST['description'],$company['company_qualification'],$company['company_category'],$company['company_regtime'],$company['company_scale'],$company['introduce']);
        }
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            if ($_POST['do'] == 1) {          //发布职位
                $do = $service->pubJob($user_id, C('ROLE_ENTERPRISE'), $result);
                if (is_zerror($do)) {
                    echo jsonp_encode(false, $do->get_message());
                } else {
                    echo jsonp_encode(true);
                }
            } else {                           //找代理
                echo jsonp_encode(true, C('WEB_ROOT') . '/efa' . '?job_id=' . $result . '&token=' . job_token($result));
            }
        }
    }

    /**
     * 将已存在的职位发布出来00100
     */
    public function do_publish_job() {
        if (!$this->is_legal_request())       //是否合法请求
            return;
        $service = new JobService();
        $result = $service->pubJob(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $_POST['jid']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 企业暂停职位00100
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
     * 企业重新发布职位00100
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
     * 企业查看应聘来的简历00100
     */
    public function get_SentResume() {
        if (!$this->is_legal_request())
            return;
        $publisher_id = AccountInfo::get_user_id();
        $sent_status = $_POST['sent_status'];
        $job_category = $_POST['job_category'];
        $sender_role = $_POST['sender_role'];
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = home_company_page::getSentResume($publisher_id, $sent_status, $job_category, $sender_role, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_company_page::getSentResumeCount($publisher_id, $sent_status, $job_category, $sender_role));
        }
    }

    /**
     * 企业上传企业墙图片00100
     */
    public function do_upload_picture() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        require_cache(APP_PATH . '/Common/Function/file.php');
        $user_id = AccountInfo::get_user_id();
        $result = file_upload('file_name', get_user_path_root($user_id) . get_user_path_promote(), 'IMAGE');
        if (is_int($result)) {
            echo "<script type=\"text/javascript\">window.parent.promoteRender.i(\"上传失败\")</script>";
        } else {
            require_cache(APP_PATH . '/Common/Function/image.php');
            $res = image_compress(C('IMAGE_NORMAL_MAX_W'), C('IMAGE_NORMAL_MAX_H'), $result);
            if (!$res) {
                echo "<script type=\"text/javascript\">window.parent.promoteRender.i(\"操作失败\")</script>";
                return;
            }
            $service = new PromoteService();
            $update = $service->update_promote_record($_POST['id'], $user_id, $result, '');
            if (is_zerror($update))
                echo "<script type=\"text/javascript\">window.parent.promoteRender.i(\"" . $update->get_message() . "\")</script>";
            else
                echo "<script type=\"text/javascript\">window.parent.promoteRender.h(\"" . C('FILE_ROOT') . $result . "\")</script>";
        }
    }

    /**
     * 企业修改基本资料00100
     */
    public function do_update() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new CompanyService();
        $result = $service->update_company(AccountInfo::get_user_id(), AccountInfo::get_data_id(), $_POST['name'], $_POST['qq'], $_POST['ca'], $_POST['pid'], $_POST['cid'], $_POST['in'], cut_avatar($_POST['photo']), $_POST['company_phone'],$_POST['company_qualification'],$_POST['company_regtime'],$_POST['company_scale'], $_POST['email'], $_POST['phone']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 企业修改头像00100
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
     * 设置隐私00100
     */
    public function setPrivacyCompany() {
        $user_id = AccountInfo::get_user_id();
        $this->assign('privacyCompany', home_company_page::getPrivacyCompany($user_id));
        $this->display();
    }

    /**
     * 执行隐私更改00100
     */
    public function do_update_privacyCompany() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $user_id = AccountInfo::get_user_id();
        $service = new PrivacyService();
        if ($_POST['job']) {
            $data['job'] = $_POST['job'];
        }
        if ($_POST['company_name']) {
            $data['company_name'] = $_POST['company_name'];
        }
        if ($_POST['contact_name']) {
            $data['contact_name'] = $_POST['contact_name'];
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
        $result = $service->updateCompanyPrivacy($_POST['company_privacy_id'], $data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 企业阅读应聘来的简历00100
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

}

?>
