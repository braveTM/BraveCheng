<?php

/**
 * Module:017
 */
class PrivateResumeAction extends BaseAction {

    /**
     * 添加工程业绩00010
     */
    public function do_addPA() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resumeService = new ResumeService();

        $resume_id = $_POST['resume_id'];
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
     * 添加工作经历00010
     */
    public function do_addWorkExp() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resume_id = $_POST['resume_id'];
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
     * 更新个人信息00010
     */
    public function do_UpdateHuman() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $creator = AccountInfo::get_user_id();
        $human_id = $_POST['human_id'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $province_code = $_POST['province_code'];
        $city_code = $_POST['city_code'];
        $contact_mobile = $_POST['contact_mobile'];
        $contact_qq = $_POST['contact_qq'];
        $contact_email = $_POST['contact_email'];
        $work_age = $_POST['work_age'];
        $service = new HumanService();
        $result = $service->update_private_huamn($creator, $human_id, $name, $gender, $birthday, $province_code, $city_code, $contact_mobile, $contact_qq, $contact_email, $work_age);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新兼职简历00010
     */
    public function do_UpdateHangCardIntent() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resumeService = new ResumeService();
        $human_id = $_POST['human_id'];
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

        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, null, null, null, null, $certificate_id, null, null);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $result = $resumeService->updateHCresume($human_id, $certificate_id, $GC_id, $GC_class, $certificate_remark, null, $job_salary, $input_salary, $register_province_ids);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 查询注册证书列表00010
     */
    public function get_RClist() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = $_POST['human_id'];
        $RClist = home_human_profile_page::getRegisterCertificateListByHuman($human_id);
        if (empty($RClist)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $RClist);
        }
    }

    /**
     * 添加注册证书00010
     */
    public function do_addRC() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = $_POST['human_id'];
        $RC_id = $_POST['RC_id'];
        $register_place = $_POST['register_place'];
        $register_case = $_POST['register_case'];

        $resumeService = new ResumeService();
        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, null, null, null, null, null, null, null);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $certificateService = new CertificateService();
        $result = $certificateService->addRegisterCertificateToHuman($human_id, $RC_id, $register_place, $register_case);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 删除工作经历00010
     */
    public function do_deleteWorkExp() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $work_exp_id = $_POST['work_exp_id'];
        $resume_id = $_POST['resume_id'];
        $human_id = $_POST['human_id'];
        $resumeService = new ResumeService();

        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, $resume_id, null, null, null, null, $work_exp_id, null);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $result = $resumeService->deleteWorkExp($work_exp_id, $resume_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除工程业绩00010
     */
    public function do_deletePA() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = $_POST['human_id'];
        $project_achievement_id = $_POST['project_achievement_id'];
        $resume_id = $_POST['resume_id'];
        $resumeService = new ResumeService();

        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, $resume_id, null, null, null, null, null, $project_achievement_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $result = $resumeService->deleteProjectAchievement($project_achievement_id, $resume_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除注册证书00010
     */
    public function do_deleteRC() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $certificate_id = $_POST['certificate_id'];
        $human_id = $_POST['human_id'];
        $resumeService = new ResumeService();

        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, null, null, null, null, $certificate_id, null, null);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $certificateService = new CertificateService();
        $result = $certificateService->deleteCertificate($human_id, $certificate_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新求职岗位00010
     */
    public function do_UpdateJobIntent() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = $_POST['human_id'];
        $job_intent_id = $_POST['job_intent_id'];
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

        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, null, $job_intent_id, null, null, null, null, null);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $result = $resumeService->updateJobIntent($job_intent_id, $job_name, $job_province_code, $job_city_code, $job_salary, $input_salary, $job_describle);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新学历00010
     */
    public function do_UpdateDegree() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = $_POST['human_id'];
        $degree_id = $_POST['degree_id'];
        $resumeService = new ResumeService();
        $study_startdate = $_POST['study_startdate'];
        $study_enddate = $_POST['study_enddate'];
        $school = $_POST['school'];
        $major_name = $_POST['major_name'];
        $degree_name = $_POST['degree_name'];

        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, null, null, null, $degree_id, null, null, null);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $result = $resumeService->updateDegree($degree_id, $study_startdate, $study_enddate, $school, $major_name, $degree_name);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新证书情况00010
     */
    public function do_UpdateCertificateCase() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = $_POST['human_id'];
        $certificate_id = $_POST['certificate_id'];
        $GC_id = $_POST['GC_id'];
        $GC_class = $_POST['GC_class'];
        $certificate_remark = $_POST['certificate_remark'];
        $resumeService = new ResumeService();

        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, null, null, null, null, $certificate_id, null, null);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $result = $resumeService->updateCertificateCase($human_id, $certificate_id, $GC_id, $GC_class, $certificate_remark);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新工作经历00010
     */
    public function do_UpdateWorkExp() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = $_POST['human_id'];
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

        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, null, null, null, null, null, $work_exp_id, null);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $result = $resumeService->updateWorkExp($work_exp_id, $department, $work_startdate, $work_enddate, $company_name, $company_industry, $company_scale, $company_property, $job_name, $job_describle);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新工程业绩00010
     */
    public function do_UpdatePA() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $human_id = $_POST['human_id'];
        $project_achievement_id = $_POST['id'];
        $resumeService = new ResumeService();
        $name = $_POST['name'];
        $scale = $_POST['scale'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $job_name = $_POST['job_name'];
        $job_describle = $_POST['job_describle'];

        $result = $resumeService->isOwnInfoId(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $human_id, null, null, null, null, null, null, $project_achievement_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
            return;
        }

        $result = $resumeService->updateProjectAchievement($project_achievement_id, $name, $scale, $start_date, $end_date, $job_name, $job_describle);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 查询工作经历列表00010
     */
    public function get_WorkExpList() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resume_id = $_POST['resume_id'];
        $workExpList = home_human_profile_page::getWorkExpList($resume_id);
        if (empty($workExpList)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $workExpList);
        }
    }

    /**
     * 查询工程业绩列表00010
     */
    public function get_PAlist() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $resume_id = $_POST['resume_id'];
        $PAlist = home_human_profile_page::getProjectAchievementList($resume_id);
        if (empty($PAlist)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $PAlist);
        }
    }

}

?>
