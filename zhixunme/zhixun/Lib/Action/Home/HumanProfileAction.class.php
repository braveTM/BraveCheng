<?php

/**
 * Module:005
 */
class HumanProfileAction extends BaseAction {
    //put your code here

    /**
     * 查询全职简历01000
     */
    public function getResume() {
        $user_id = AccountInfo::get_user_id();
        $resume = home_human_profile_page::getResume($user_id);
        //echo jsonp_encode(true,$resume);
        $this->assign('resume', $resume);
        $this->display();
    }

    /**
     * 更新个人信息01000
     */
    public function do_UpdateHuman() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $service = new HumanService();
        $result = $service->update_human(AccountInfo::get_user_id(), AccountInfo::get_data_id(), $_POST['name'], $_POST['gender'], $_POST['birth'], $_POST['pid'], $_POST['cid'], $_POST['qq'], $_POST['exp'], cut_avatar($_POST['photo']), $_POST['phone'], $_POST['email']);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新求职岗位01000
     */
    public function do_UpdateJobIntent() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $job_intent_id = AccountInfo::get_intent_id();
        $resumeService = new ResumeService();
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
        $result = $resumeService->updateJobIntent($job_intent_id, $job_name, $job_province_code, $job_city_code, $job_salary, $input_salary, $job_describle);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新学历01000
     */
    public function do_UpdateDegree() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $degree_id = AccountInfo::get_degree_id();
        $resumeService = new ResumeService();
        $study_startdate = $_POST['study_startdate'];
        $study_enddate = $_POST['study_enddate'];
        $school = $_POST['school'];
        $major_name = $_POST['major_name'];
        $degree_name = $_POST['degree_name'];
        $result = $resumeService->updateDegree($degree_id, $study_startdate, $study_enddate, $school, $major_name, $degree_name);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新证书情况01000
     */
    public function do_UpdateCertificateCase() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = AccountInfo::get_data_id();
        $certificate_id = $_POST['certificate_id'];
        $GC_id = $_POST['GC_id'];
        $GC_class = $_POST['GC_class'];
        $certificate_remark = $_POST['certificate_remark'];
        $resumeService = new ResumeService();
        $result = $resumeService->updateCertificateCase($human_id, $certificate_id, $GC_id, $GC_class, $certificate_remark);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新工作经历01000
     */
    public function do_UpdateWorkExp() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $work_exp_id = $_POST['id'];
        $resumeService = new ResumeService();
        $department = $_POST['department'];
        $work_startdate = $_POST['work_startdate'];
        $work_enddate = $_POST['work_enddate'];
        $company_name = $_POST['company_name'];
        $company_industry = $_POST['company_industry'];
        $company_scale = $_POST['company_scale'];
        $company_property = $_POST['company_property'];
        $job_name = $_POST['job_name'];
        $job_describle = $_POST['job_describle'];
        $result = $resumeService->updateWorkExp($work_exp_id, $department, $work_startdate, $work_enddate, $company_name, $company_industry, $company_scale, $company_property, $job_name, $job_describle);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新工程业绩01000
     */
    public function do_UpdatePA() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $project_achievement_id = $_POST['id'];
        $resumeService = new ResumeService();
        $name = $_POST['name'];
        $scale = $_POST['scale'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $job_name = $_POST['job_name'];
        $job_describle = $_POST['job_describle'];
        $result = $resumeService->updateProjectAchievement($project_achievement_id, $name, $scale, $start_date, $end_date, $job_name, $job_describle);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 查询工作经历列表01000
     */
    public function get_WorkExpList() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resume_id = AccountInfo::get_resume_id();
        $workExpList = home_human_profile_page::getWorkExpList($resume_id);
        if (empty($workExpList)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $workExpList);
        }
    }

    /**
     * 查询工程业绩列表01000
     */
    public function get_PAlist() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resume_id = AccountInfo::get_resume_id();
        $PAlist = home_human_profile_page::getProjectAchievementList($resume_id);
        if (empty($PAlist)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $PAlist);
        }
    }

    /**
     * 查询注册证书列表01000
     */
    public function get_RClist() {
        $human_id = AccountInfo::get_data_id();
        $RClist = home_human_profile_page::getRegisterCertificateListByHuman($human_id);
        if (empty($RClist)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $RClist);
        }
    }

    /**
     * 查询职称证书列表01000
     */
    public function get_GClist() {
        $human_id = AccountInfo::get_data_id();
        $GClist = home_human_profile_page::getGradeCertificateListByHuman($human_id);
        if (empty($GClist)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $GClist);
        }
    }

    /**
     * 添加工作经历01000
     */
    public function do_addWorkExp() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resume_id = AccountInfo::get_resume_id();
        $resumeService = new ResumeService();
        $department = $_POST['department'];
        $work_startdate = $_POST['work_startdate'];
        $work_enddate = $_POST['work_enddate'];
        $company_name = $_POST['company_name'];
        $company_industry = $_POST['company_industry'];
        $company_scale = $_POST['company_scale'];
        $company_property = $_POST['company_property'];
        $job_name = $_POST['job_name'];
        $job_describle = $_POST['job_describle'];
        $result = $resumeService->addWorkExp($resume_id, $department, $work_startdate, $work_enddate, $company_name, $company_industry, $company_scale, $company_property, $job_name, $job_describle);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 添加工程业绩01000
     */
    public function do_addPA() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resume_id = AccountInfo::get_resume_id();
        $resumeService = new ResumeService();
        $name = $_POST['name'];
        $scale = $_POST['scale'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $job_name = $_POST['job_name'];
        $job_describle = $_POST['job_describle'];
        $result = $resumeService->addProjectAchievement($resume_id, $name, $scale, $start_date, $end_date, $job_name, $job_describle);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 添加注册证书01000
     */
    public function do_addRC() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = AccountInfo::get_data_id();
        $RC_id = $_POST['RC_id'];
        $register_place = $_POST['register_place'];
        $register_case = $_POST['register_case'];
        $certificateService = new CertificateService();
        $result = $certificateService->addRegisterCertificateToHuman($human_id, $RC_id, $register_place, $register_case);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 添加职称证书01000
     */
    public function do_addGC() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = AccountInfo::get_data_id();
        $GC_id = $_POST['GC_id'];
        $GC_class = $_POST['GC_class'];
        $certificateService = new CertificateService();
        $result = $certificateService->addGradeCertificateToHuman($human_id, $GC_id, $GC_class);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除工作经历01000
     */
    public function do_deleteWorkExp() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $work_exp_id = $_POST['work_exp_id'];
        $resumeService = new ResumeService();
        $result = $resumeService->deleteWorkExp($work_exp_id, AccountInfo::get_resume_id());
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除工程业绩01000
     */
    public function do_deletePA() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $project_achievement_id = $_POST['project_achievement_id'];
        $resumeService = new ResumeService();
        $result = $resumeService->deleteProjectAchievement($project_achievement_id, AccountInfo::get_resume_id());
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除注册证书01000
     */
    public function do_deleteRC() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $certificate_id = $_POST['certificate_id'];
        $certificateService = new CertificateService();
        $result = $certificateService->deleteCertificate(AccountInfo::get_data_id(), $certificate_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除职称证书01000
     */
    public function do_deleteGC() {
        
    }

    /**
     * 查询所有注册证书信息01000
     */
    public function get_AllRCinfo() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $RClist = home_human_profile_page::getAllRegisterCertificateInfo();
        if (empty($RClist)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $RClist);
        }
    }

    /**
     * 查询指定注册证书的专业列表01000
     */
    public function get_RCmajorList() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $RCI_id = $_POST['RCI_id'];
        $RCmajorList = home_human_profile_page::getRegisterCertificateMajorList($RCI_id, 0);
        if (empty($RCmajorList)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $RCmajorList);
        }
    }

    /**
     * 查询所有职称证书类别01000
     */
    public function get_AllGCType() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $GCtypeList = home_human_profile_page::getAllGradeCertificateType();
        if (empty($GCtypeList)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $GCtypeList);
        }
    }

    /**
     * 查询指定职称证书类别的职称证书专业列表01000
     */
    public function get_GCmajorList() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $grade_certificate_type_id = $_POST['grade_certificate_type_id'];
        $GCmajorList = home_human_profile_page::getGradeCertificateList($grade_certificate_type_id);
        if (empty($GCmajorList)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $GCmajorList);
        }
    }

    /**
     * 查询兼职简历01000
     */
    public function get_HangCardResume() {
        $user_id = AccountInfo::get_user_id();
        $HC_resume = home_human_profile_page::getHCresume($user_id);
        //echo jsonp_encode(true,$HC_resume);
        $this->assign('HC_resume', $HC_resume);
        $this->display();
    }

    /**
     * 更新兼职简历01000
     */
    public function do_UpdateHangCardIntent() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resumeService = new ResumeService();
        $human_id = AccountInfo::get_data_id();
        $hung_card_intent_id = AccountInfo::get_hang_card_id();
        $certificate_id = $_POST['certificate_id'];
        $GC_id = $_POST['GC_id'];
        $GC_class = $_POST['GC_class'];
        $certificate_remark = $_POST['certificate_remark'];
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
        $result = $resumeService->updateHCresume($human_id, $certificate_id, $GC_id, $GC_class, $certificate_remark, $hung_card_intent_id, $job_salary, $input_salary, $register_province_ids);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

}

?>
