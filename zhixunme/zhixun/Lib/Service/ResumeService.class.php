<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResumeService
 *
 * @author JZG
 */
class ResumeService {

    //put your code here
    /**
     * 创建简历(S)
     * @return <mixed> 成功返回新创建的简历ID，失败返回错误信息
     */
    public function createResume() {
        $resumeProvider = new ResumeProvider();
        $resumeProvider->trans();
        $job_intent_id = $resumeProvider->addJobIntent(null);
        if (!$job_intent_id) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$JOB_INTENT_ADD_ERROR);
        }

        $hang_card_intent_id = $resumeProvider->addHangCardIntent(null);
        if (!$hang_card_intent_id) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$HANG_CARD_INTENT_ADD_ERROR);
        }

        $degree_id = $resumeProvider->addDegree(null);
        if (!$degree_id) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$DEGREE_ADD_ERROR);
        }
        while (true) {                                        //生成唯一主键
            $id = build_id();
            $temp = $resumeProvider->getResume($id);
            if (empty($temp))
                break;
        }
        $resume_id = $resumeProvider->addResume($job_intent_id, $hang_card_intent_id, $degree_id, null, $id);
        if (!$resume_id) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$RESUME_ADD_ERROR);
        }
        $resumeProvider->commit();
        return $resume_id;
    }

    /**
     * 查询简历 (S)
     * @param <int> $resume_id 简历ID
     * @return <array>
     */
    public function getResume($resume_id) {
        $resumeProvider = new ResumeProvider();

        $result = argumentValidate($resumeProvider->resumeArgRule, array('resume_id' => $resume_id));
        if (is_zerror($result)) {
            return $result;
        } else {
            $resume_id = $result['resume_id'];
        }
        $resume = $resumeProvider->getResume($resume_id);
        $job_intent_id = $resume['job_intent_id'];
        $resume['job_intent'] = $resumeProvider->getJobIntent($job_intent_id);
        $degree_id = $resume['degree_id'];
        $resume['degree'] = $resumeProvider->getDegree($degree_id);
        $resume['work_exp_list'] = $resumeProvider->getWorkExpList($resume_id, null);
        $resume['project_achievement_list'] = $resumeProvider->getProjectAchievementList($resume_id, null);
        return $resume;
    }

    /**
     * 查询挂证意向
     * @param <int> $resume_id 简历ID
     * @return <array>
     */
    public function getHCintent($resume_id) {
        $resumeProvider = new ResumeProvider();
        $resume = $resumeProvider->getResume($resume_id);
        $HC_intent = $resumeProvider->getHCintent($resume['hang_card_intent_id']);
        $HC_intent['job_category'] = $resume['job_category'];
        return $HC_intent;
    }

    /**
     * 获取简历信息
     * @param int $resume_id 简历编号
     * @return array
     */
    public function get_resume($resume_id) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->getResume($resume_id);
    }

    /**
     * 查询挂证意向
     * @param <int> $hang_card_id 挂证意向编号
     * @return <array>
     */
    public function getHCintentByHCID($hang_card_id) {
        $resumeProvider = new ResumeProvider();
        $HC_intent = $resumeProvider->getHCintent($hang_card_id);
        return $HC_intent;
    }

    /**
     * 更新求职意向
     * @param <int> $job_intent_id 求职意向ID
     * @param <string> $job_name 职位名称
     * @param <int> $job_province_code 工作地点省份编号
     * @param <int> $job_city_code  工作地点城市编号
     * @param <int> $job_salary 期望薪资
     * @param float $input_salary 手动输入期望待遇
     * @param <string> $job_describle 职位描述
     * @return <mixed> 成功返回true,失败返回错误信息
     */
    public function updateJobIntent($job_intent_id, $job_name, $job_province_code, $job_city_code, $job_salary, $input_salary, $job_describle) {
        $resumeProvider = new ResumeProvider();
        $data = array(
            'job_name' => $job_name,
            'job_province_code' => $job_province_code,
            'job_city_code' => $job_city_code,
            'job_salary' => $job_salary,
            'input_salary' => $input_salary,
            'job_describle' => $job_describle
        );
        $result = argumentValidate($resumeProvider->jobIntentArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        } else {
            $data = $result;
        }
        $jobService = new JobService();
        $job_check = $jobService->check_job_position($job_name, 5);
        if (is_zerror($job_check)) {
            return $job_check;
        }
        if ($resumeProvider->updateJobIntent($job_intent_id, $data)) {
            $service = new ContactsService();
            $service->moving_update_resume();
            //修改简历时触发推荐更新
            $recommendService = new RecommendService();
            $recommendService->alterResumeTriggerUpdate(AccountInfo::get_user_id(), AccountInfo::get_role_id());
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 更新学历
     * @param <int> $degree_id 学历ID
     * @param <date> $study_startdate 开始时间
     * @param <date> $study_enddate 结束时间
     * @param <string> $school 学校名称
     * @param <string> $major_name 专业名称
     * @param <string> $degree_name 学历名称
     * @return <mixed> 成功返回true,失败返回错误信息
     */
    public function updateDegree($degree_id, $study_startdate, $study_enddate, $school, $major_name, $degree_name) {
        $resumeProvider = new ResumeProvider();
        $data = array(
            'study_startdate' => $study_startdate,
            'study_enddate' => $study_enddate,
            'school' => $school,
            'major_name' => $major_name,
            'degree_name' => $degree_name
        );
        $result = argumentValidate($resumeProvider->degreeArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        } else {
            $data = $result;
        }

        if ($resumeProvider->updateDegree($degree_id, $data)) {
            $service = new ContactsService();
            $service->moving_update_resume();
            //修改简历时触发推荐更新
            $recommendService = new RecommendService();
            $recommendService->alterResumeTriggerUpdate(AccountInfo::get_user_id(), AccountInfo::get_role_id());
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 更新注册情况
     * @param <int> $human_id 人才信息ID
     * @param <int> $certificate_id 资质证书ID（没有职称证书，则为0）
     * @param <int> $GC_id 职称证书ID
     * @param <int> $GC_class 职称证书等级
     * @param <string> $certificate_remark 证书备注
     * @return <mixed> 成功返回true,失败返回错误信息
     */
    public function updateCertificateCase($human_id, $certificate_id, $GC_id, $GC_class, $certificate_remark) {
        $humanProvider = new HumanProvider();
        //添加参数验证
        $humanProvider->trans();
        $certificateProvider = new CertificateProvider();
        if ($certificate_id == 0) {
            $result = $certificateProvider->addGradeCertificateToHuman($human_id, $GC_id, $GC_class, null);
            if (!$result) {
                $humanProvider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        } else {
            $data = array(
                'grade_certificate_id' => $GC_id,
                'grade_certificate_class' => $GC_class
            );
            $result = $certificateProvider->updateCertificate($certificate_id, $data);
            if (!$result) {
                $humanProvider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        $data = array(
            'certificate_remark' => $certificate_remark
        );
        $result = $humanProvider->updateHuman($human_id, $data);
        if ($result) {
            $humanProvider->commit();
            $service = new ContactsService();
            $service->moving_update_resume();
            //修改简历时触发推荐更新
            $recommendService = new RecommendService();
            $recommendService->alterResumeTriggerUpdate(AccountInfo::get_user_id(), AccountInfo::get_role_id());
            return true;
        } else {
            $humanProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 更新挂证（兼职）简历
     * @param <int> $human_id 人才信息ID
     * @param <int> $certificate_id 资质证书ID（无职称证书为0）
     * @param <type> $GC_id 职称证书ID
     * @param <type> $GC_class 职称证书等级
     * @param <type> $certificate_remark 补充说明
     * @param <type> $hang_card_intent_id 挂证意向ID
     * @param <type> $job_salary 期望待遇
     * @param float $input_salary 手动输入期望待遇
     * @param <type> $register_province_ids 期望注册地（以逗号分隔的省份编号）
     * @return <mixed> 成功返回true,失败返回错误信息
     */
    public function updateHCresume($human_id, $certificate_id, $GC_id, $GC_class, $certificate_remark, $hang_card_intent_id, $job_salary, $input_salary, $register_province_ids) {
        $humanProvider = new HumanProvider();
        if (!$humanProvider->isExistHuman($human_id)) {
            //人才不存在
            return E(ErrorMessage::$HUMAN_NOT_EXIST);
        }
        if (empty($hang_card_intent_id)) {
            //hang_card_intent_id 为空，则通过human_id从数据库中关联查询
            $human = $humanProvider->getHuman($human_id);
            $resume_id = $human['resume_id'];
            $resumeProvider = new ResumeProvider();
            $resume = $resumeProvider->getResume($resume_id);
            $hang_card_intent_id = $resume['hang_card_intent_id'];
        }
        if (AccountInfo::get_role_id() == C('ROLE_AGENT')) {
            //若当前用户为经纪人，则判断指定人才ID是否是指定经纪人添加的
            if (!$humanProvider->is_transed()) {
                if (!$humanProvider->isAddHuman(AccountInfo::get_user_id(), $human_id)) {
                    return E(ErrorMessage::$HUMAN_NOT_OWN);
                }
            }
        }

        //开启事务
        $humanProvider->trans();
        $certificateProvider = new CertificateProvider();

        // 更新证书表
        if (!empty($GC_id)) {
            if (!$certificateProvider->exists_gc_id($GC_id)) {
                //职称证书ID不存在
                return E(ErrorMessage::$GCM_NOT_EXISTS);
            }
            $GC_class = var_validation($GC_class, VAR_GCCLASS, OPERATE_FILTER);

            if ($certificate_id == 0) {
                $result = $certificateProvider->addGradeCertificateToHuman($human_id, $GC_id, $GC_class, null);
                if (!$result) {
                    $humanProvider->rollback();
                    return E(ErrorMessage::$OPERATION_FAILED);
                }
            } else {
                $data = array(
                    'grade_certificate_id' => $GC_id,
                    'grade_certificate_class' => $GC_class
                );
                $GC_list = $certificateProvider->getGradeCertificateListByHuman($human_id, null);
                if (empty($GC_list)) {
                    //资质证书记录不存在
                    return E(ErrorMessage::$OPERATION_FAILED);
                }
                $result = $certificateProvider->updateCertificate($certificate_id, $data);
                if (!$result) {
                    $humanProvider->rollback();
                    return E(ErrorMessage::$OPERATION_FAILED);
                }
            }
        }

        //更新挂证意向表
        $resumeProvider = new ResumeProvider();
        $data = array(
            'job_salary' => $job_salary,
            'register_province_ids' => $register_province_ids,
            'input_salary' => $input_salary,
        );
        $result = $resumeProvider->updateHangCardIntent($hang_card_intent_id, $data);
        if (!$result) {
            $humanProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }

        //更新人才表
        $data = array(
            'certificate_remark' => $certificate_remark
        );

        $data = argumentValidate($humanProvider->humanArgRule, $data);
        if (is_zerror($data)) {
            return $data;
        }
        $result = $humanProvider->updateHuman($human_id, $data);
        if ($result) {
            $humanProvider->commit();
            $service = new ContactsService();
            $service->moving_update_resume();
            //修改简历时触发推荐更新
            $recommendService = new RecommendService();
            $recommendService->alterResumeTriggerUpdate(AccountInfo::get_user_id(), AccountInfo::get_role_id());
            return true;
        } else {
            $humanProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 更新工作经历
     * @param <int> $work_exp_id 工作经历ID
     * @param <string> $department 部门
     * @param <date> $work_startdate 任职开始起始日期
     * @param <date> $work_enddate 任职结束日期
     * @param <string> $company_name 公司名称
     * @param <string> $company_industry 行业
     * @param <string> $company_scale 公司规模
     * @param <int> $company_property 公司性质
     * @param <string> $job_name 职位
     * @param <string> $job_describle 工作描述
     * @return <mixed> 成功返回true,失败返回错误信息
     */
    public function updateWorkExp($work_exp_id, $department, $work_startdate, $work_enddate, $company_name, $company_industry, $company_scale, $company_property, $job_name, $job_describle) {
        $resumeProvider = new ResumeProvider();
        $data = array(
            'department' => $department,
            'work_startdate' => $work_startdate,
            'work_enddate' => $work_enddate,
            'company_name' => $company_name,
            'company_industry' => $company_industry,
            'company_scale' => $company_scale,
            'company_property' => $company_property,
            'job_name' => $job_name,
            'job_describle' => $job_describle
        );

        $result = argumentValidate($resumeProvider->workExpArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        } else {
            $data = $result;
        }

        if ($resumeProvider->updateWorkExp($work_exp_id, $data)) {
            $service = new ContactsService();
            $service->moving_update_resume($user_id);
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 更新工程业绩
     * @param <int> $project_achievement_id 工程业绩ID
     * @param <string> $name 项目名称
     * @param <string> $scale 规模大小
     * @param <date> $start_date 项目起始时间
     * @param <date> $end_date 项目结束时间
     * @param <string> $job_name 担任职务
     * @param <string> $job_describle 工作内容
     * @return <mixed> 成功返回true,失败返回错误信息
     */
    public function updateProjectAchievement($project_achievement_id, $name, $scale, $start_date, $end_date, $job_name, $job_describle, $user_id) {
        $resumeProvider = new ResumeProvider();
        $data = array(
            'name' => $name,
            'scale' => $scale,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'job_name' => $job_name,
            'job_describle' => $job_describle
        );

        $result = argumentValidate($resumeProvider->projectAchievementArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        } else {
            $data = $result;
        }

        if ($resumeProvider->updateProjectAchievement($project_achievement_id, $data)) {
            $service = new ContactsService();
            $service->moving_update_resume($user_id);
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 添加工作经历
     * @param <int> $resume_id 简历ID
     * @param <string> $department 部门
     * @param <date> $work_startdate 任职开始起始日期
     * @param <date> $work_enddate 任职结束日期
     * @param <string> $company_name 公司名称
     * @param <string> $company_industry 行业
     * @param <string> $company_scale 公司规模
     * @param <int> $company_property 公司性质
     * @param <string> $job_name 职位
     * @param <string> $job_describle 工作描述
     * @return <mixed> 成功返回添加记录ID,失败返回错误信息
     */
    public function addWorkExp($resume_id, $department, $work_startdate, $work_enddate, $company_name, $company_industry, $company_scale, $company_property, $job_name, $job_describle) {
        $resumeProvider = new ResumeProvider();
        $data = array(
            'department' => $department,
            'work_startdate' => $work_startdate,
            'work_enddate' => $work_enddate,
            'company_name' => $company_name,
            'company_industry' => $company_industry,
            'company_scale' => $company_scale,
            'company_property' => $company_property,
            'job_name' => $job_name,
            'job_describle' => $job_describle
        );
        if (AccountInfo::get_role_id() == C('ROLE_AGENT')) {
            if (!$resumeProvider->isAddResume(AccountInfo::get_user_id(), $resume_id)) {
                return E(ErrorMessage::$RESUME_NOT_OWN);
            }
        }
        $result = argumentValidate($resumeProvider->workExpArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        } else {
            $data = $result;
        }
        $result = $resumeProvider->addWorkExp($resume_id, $data);
        if ($result) {
            $service = new ContactsService();
            $service->moving_update_resume();
            return $result;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 添加工程业绩
     * @param <int> $resume_id 简历ID
     * @param <string> $name 项目名称
     * @param <string> $scale 规模大小
     * @param <date> $start_date 项目起始时间
     * @param <date> $end_date 项目结束时间
     * @param <string> $job_name 担任职务
     * @param <string> $job_describle 工作内容
     * @return <mixed> 成功返回添加记录ID,失败返回错误信息
     */
    public function addProjectAchievement($resume_id, $name, $scale, $start_date, $end_date, $job_name, $job_describle) {
        $resumeProvider = new ResumeProvider();
        $data = array(
            'name' => $name,
            'scale' => $scale,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'job_name' => $job_name,
            'job_describle' => $job_describle
        );
        if (AccountInfo::get_role_id() == C('ROLE_AGENT')) {
            if (!$resumeProvider->isAddResume(AccountInfo::get_user_id(), $resume_id)) {
                return E(ErrorMessage::$RESUME_NOT_OWN);
            }
        }

        $result = argumentValidate($resumeProvider->projectAchievementArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        } else {
            $data = $result;
        }
        $result = $resumeProvider->addProjectAchievement($resume_id, $data);
        if ($result) {
            $service = new ContactsService();
            $service->moving_update_resume();
            return $result;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 获取工作经历列表
     * @param <int> $resume_id 简历ID
     * @return <mixed>成功返回数组或空数组，失败返回false
     */
    public function getWorkExpList($resume_id) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->getWorkExpList($resume_id, null);
    }

    /**
     * 获取工程业绩列表
     * @param <int> $resume_id 简历ID
     * @return <mixed>成功返回数组或空数组，失败返回false
     */
    public function getProjectAchievementList($resume_id) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->getProjectAchievementList($resume_id, null);
    }

    /**
     * 删除工作经历
     * @param <int> $work_exp_id 工作经历ID
     * @param <int> $resume_id 当前用户简历编号
     * @return <bool> 成功返回true,失败返回false
     */
    public function deleteWorkExp($work_exp_id, $resume_id) {
        $resumeProvider = new ResumeProvider();
        $exp = $resumeProvider->getWorkExp($work_exp_id);
        if (empty($exp) || $exp['resume_id'] != $resume_id) {
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        if (!$resumeProvider->deleteWorkExp($work_exp_id)) {
            return E();
        }
        $service = new ContactsService();
        $service->moving_update_resume();
        return true;
    }

    /**
     * 删除工程业绩
     * @param <int> $project_achievement_id 工程业绩ID
     * @param <int> $resume_id 当前用户简历编号
     * @return <bool> 成功返回true,失败返回false
     */
    public function deleteProjectAchievement($project_achievement_id, $resume_id) {
        $resumeProvider = new ResumeProvider();
        $project = $resumeProvider->getProjectAchievement($project_achievement_id);
        if (empty($project) || $project['resume_id'] != $resume_id) {
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        if (!$resumeProvider->deleteProjectAchievement($project_achievement_id)) {
            return E();
        }
        $service = new ContactsService();
        $service->moving_update_resume();
        return true;
    }

    /**
     * 委托简历
     * @param <int> $operator 委托人（人才）
     * @param <int> $role ROLE_TALENTS为人才
     * @param <int> $agent 代理人(经纪人）
     * @param <int> $resume_id 简历ID
     * @param <int> $job_category 求职意向（1-全职，2-兼职）
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function delegateResume($operator, $role, $agent, $resume_id, $job_category) {
        $resume_status = $this->getResumeStatus($resume_id);
        if ($resume_status > 1 && $resume_status < 3) {
            //简历已公开
            return E(ErrorMessage::$RESUME_OPEN);
        } else if ($resume_status > 2) {
            //简历已委托
            return E(ErrorMessage::$RESUME_AGENT);
        }
        //经纪人ID验证
        $userService = new UserService();
        $user = $userService->get_user($agent);
        if (empty($user)) {
            return E(ErrorMessage::$USER_NOT_EXISTS);
        }
        if ($user['role_id'] != C('ROLE_AGENT')) {
            return E(ErrorMessage::$USER_NOT_AGENT);
        }
        $resumeProvider = new ResumeProvider();
        //判断简历是否完整
        if (!$resumeProvider->is_transed()) {
            $result = $this->validateResumeComplete($resume_id, $job_category);
            if (is_zerror($result)) {
                return $result;
            }
        }
        //开启事务
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($operator, 15, '委托给' . $user['name']);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        $resumeProvider->trans();
        $data = array(
            'agent_id' => $agent,
            'publisher_id' => 0,
            'delegate_datetime' => date_f(),
            'job_category' => $job_category
        );
        $data = argumentValidate($resumeProvider->resumeArgRule, $data);
        if (is_zerror($data)) {
            return $data;
        }
        //更新简历表
        $result = $resumeProvider->updateResume($resume_id, $data);
        if (!$result) {
            //更新简历表失败，事务回滚
            $resumeProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }

        $data = array(
            'agent_id' => $agent,
            'resume_id' => $resume_id,
            'agent_date' => date_f(),
            'status' => 5,
            'job_category' => $job_category,
            'resume_data' => $this->serializeResumeData($resume_id),
        );
        $result = $resumeProvider->deleteDelegateResumeStatus($agent, $resume_id);
        if (!$result) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$DRS_ADD_FAIL);
        }
        //更新简历委托状态表
        $result = $resumeProvider->addDelegateResumeStatus($data);
        if (!$result) {
            //更新简历委托状态表失败，事务回滚
            $resumeProvider->rollback();
            return E(ErrorMessage::$DRS_ADD_FAIL);
        } else {
            $resumeProvider->commit();
            //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
            $pks->end_paying_operation();
            //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        }
        if ($result) {
            $service = new RemindService();
            $service->notify(C('REMIND_RAGENT'), $agent);        //通知
            //ExperienceCrmService::add_experience_entrust_resume($operator); //调用经验模块增加经验
            //发送通知邮件
            $args=array();
            $notifyService=new NotifyService();
            $notifyService->fillCommonArgs($args,$agent,AccountInfo::get_user_id());
            email_send($user['email'], 22,$user['user_id'],null,$args);
            //添加发送站内信
            //$notifyService->send_notify($user['user_id'],$role,22,"dd");
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 终止委托简历
     * @param <int> $resume_id 简历编号
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function endDelegateResume($resume_id, &$agent_id) {
        $resume_status = $this->getResumeStatus($resume_id);
        if ($resume_status < 3) {
            //简历未委托
            return E(ErrorMessage::$RESUME_NOT_AGENT);
        } else if ($resume_status > 3) {
            //委托的简历已公开
            return E(ErrorMessage::$RESUME_OPEN);
        }
        $resumeProvider = new ResumeProvider();
        //开启事务
        $resumeProvider->trans();
        $resume = $resumeProvider->getResume($resume_id);
        $agent_id = $resume['agent_id'];
        $data = array(
            'agent_id ' => 0,
            'publisher_id' => 0,
            'job_category ' => 0
        );
        //更新简历表
        $result = $resumeProvider->updateResume($resume_id, $data);
        if (!$result) {
            //事务回滚
            $resumeProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }

        //更新委托简历状态表
        $data = array(
            'status' => 4
        );
        $result = $resumeProvider->updateDelegateResumeStatus($agent_id, $resume_id, $data);
        if (!$result) {
            //事务回滚
            $resumeProvider->rollback();
            return E(ErrorMessage::$DRS_UPDATE_FAIL);
        } else {
            $service = new RemindService();
            $service->notify(C('REMIND_EDRESUME'), $agent_id);
            $resumeProvider->commit();
            return true;
        }
    }

    /**
     * 公开简历
     * @param <int> $publisher 公开人（人才或经纪人）
     * @param <int> $role ROLE_TALENTS为人才，ROLE_AGENT为经纪人
     * @param <int> $resume_id 简历ID
     * @param <int> $job_category 求职意向（1-全职，2-兼职）
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function openResume($publisher, $role, $resume_id, $job_category) {
        $resumeProvider = new ResumeProvider();
        //验证当前简历状态
        $resume_status = $this->getResumeStatus($resume_id);
        if ($role == C('ROLE_TALENTS')) {
            if ($resume_status > 1 && $resume_status < 3) {
                //简历已公开
                return E(ErrorMessage::$RESUME_OPEN);
            } else if ($resume_status > 2) {
                //简历已委托
                return E(ErrorMessage::$RESUME_AGENT);
            }
            if (empty($job_category)) {
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        } else if ($role == C('ROLE_AGENT')) {
            if ($resume_status < 3) {
                //简历未委托
                return E(ErrorMessage::$RESUME_NOT_AGENT);
            } else if ($resume_status > 3) {
                //简历已公开
                return E(ErrorMessage::$RESUME_OPEN);
            }
            if (!$resumeProvider->isOwnResume($publisher, $resume_id)) {
                //简历未委托给该经纪人
                return E(ErrorMessage::$RESUME_NOT_OWN);
            }
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }

        //验证简历数据是否完整
        $result = $this->validateResumeComplete($resume_id, $job_category);
        if (is_zerror($result)) {
            return $result;
        }

        $data = array(
            'publisher_id' => $publisher,
            'pub_datetime' => date_f()
        );

        if (!empty($job_category)) {
            $data['job_category'] = $job_category;
            $data = argumentValidate($resumeProvider->resumeArgRule, $data);
            if (is_zerror($data)) {
                return $data;
            }
        }
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($publisher, 11, '简历编号 ' . $resume_id);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        $isDelegatedResume = $resumeProvider->isDelegatedResume($publisher, $resume_id);
        $resumeProvider->trans();
        $result = $resumeProvider->updateResume($resume_id, $data);
        if (!$result) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        } else {
            if ($isDelegatedResume) {
                //如果是委托来的简历，需更新委托简历状态表
                $result = $this->updateDelegateResumeStatus($publisher, $resume_id, 2);
                if (is_zerror($result)) {
                    $resumeProvider->rollback();
                    return $result;
                } else {
                    $resumeProvider->commit();
                }
            } else {
                $resumeProvider->commit();
            }
        }


        if ($result) {
            //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
            $pks->end_paying_operation();
            //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 关闭简历
     * @param <int> $operator 操作人ID
     * @param <int> $role 操作人角色
     * @param <int> $resume_id 简历ID
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function closeResume($operator, $role, $resume_id) {
        $resume_status = $this->getResumeStatus($resume_id);
        if ($role == C('ROLE_TALENTS')) {
            if ($resume_status < 2) {
                //简历未委托，未公开
                return E(ErrorMessage::$RESUME_CLOSE);
            } else if ($resume_status > 2) {
                //简历处于委托中
                return E(ErrorMessage::$RESUME_AGENT);
            }
            $data = array(
                'publisher_id' => 0,
                'job_category' => 0
            );
        } else if ($role == C('ROLE_AGENT')) {
            if ($resume_status < 4 && $resume_status > 2) {
                //简历未公开
                return E(ErrorMessage::$RESUME_CLOSE);
            } else if ($resume_status < 3) {
                //简历未委托
                return E(ErrorMessage::$RESUME_NOT_AGENT);
            }
            $data = array(
                'publisher_id' => 0
            );
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $resumeProvider = new ResumeProvider();
        $result = false;
        if ($role == C('ROLE_AGENT')) {
            $isDelegatedResume = $resumeProvider->isDelegatedResume($operator, $resume_id);
            if ($isDelegatedResume) {
                //如果是经纪人关闭委托来的简历，则需要更新委托简历状态表
                $resumeProvider->trans();
                $result = $this->updateDelegateResumeStatus($operator, $resume_id, 1);
                if (is_zerror($result)) {
                    $resumeProvider->rollback();
                    return $result;
                }
                $result = $resumeProvider->updateResume($resume_id, $data);
                if (!$result) {
                    $resumeProvider->rollback();
                    return E(ErrorMessage::$OPERATION_FAILED);
                } else {
                    $resumeProvider->commit();
                    return true;
                }
            } else {
                $result = $resumeProvider->updateResume($resume_id, $data);
            }
        } else {
            $result = $resumeProvider->updateResume($resume_id, $data);
        }

        if ($result) {
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 投递简历
     * @param <int> $sender 投递人（人才或经纪人）
     * @param <int> $role  ROLE_TALENTS为人才，ROLE_AGENT为经纪人
     * @param <int> $job_id 职位ID
     * @param <int> $resume_id 简历ID
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function sendResumeToJob($sender, $role, $job_id, $resume_id) {
        $jobProvider = new JobProvider();
        $job = $jobProvider->getJob($job_id);
        if (empty($job) || $job['publisher_id'] == 0) {
            return E(ErrorMessage::$JOB_NOT_EXISTS);
        }
        $resumeStatus = $this->getResumeStatus($resume_id,$role);
        $resumeProvider = new ResumeProvider();
        if ($role == C('ROLE_TALENTS')) {
            if ($resumeStatus < 2) {
                //简历未公开
                return E(ErrorMessage::$RESUME_CLOSE);
            }
            if ($resumeStatus > 2) {
                //简历已委托
                return E(ErrorMessage::$RESUME_AGENT);
            }
        } else if ($role == C('ROLE_AGENT')) {
            if (!$resumeProvider->isOwnResume($sender, $resume_id)) {
                //简历未委托给该经纪人
                return E(ErrorMessage::$RESUME_NOT_OWN);
            }
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $result = $this->validateResumeComplete($resume_id);
        if (is_zerror($result)) {
            return $result;
        }
        $resume = $resumeProvider->getResume($resume_id);
        $jobOperateProvider = new JobOperateProvider();
        $data = array(
            'sender_id' => $sender,
            'publisher_id' => $job['publisher_id'],
            'resume_id' => $resume_id,
            'resume_data' => $this->serializeResumeData($resume_id),
            'job_category' => $resume['job_category'],
            'job_id' => $job_id,
        );
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($sender, 3, '投递职位 ' . $job['title']);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        if(!$resumeProvider->exists_send_record($sender, $resume_id, $job_id))
            ExperienceCrmService::add_experience_send_resume($sender);      //如果之前不存在指定投递记录，则增加经验值
        $result = $jobOperateProvider->addSendResume($data);
        if ($result) {
            $service = new ContactsService();
            $service->moving_position($sender, $job['job_id'], $job['job_category'], $job['title']);
            //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
            $pks->end_paying_operation();
            //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
            $service = new RemindService();
            if ($job['publisher_role'] == C('ROLE_AGENT'))
                $service->notify(C('REMIND_YPRESUME'), $job['publisher_id']);        //通知-应聘到经纪人
            else
                $service->notify(C('REMIND_EYPRESUME'), $job['publisher_id']);       //通知-应聘到企业
            //发送邮件通知
            $userService=new UserService();
            $user_id=$job['publisher_id'];
            $user=$userService->get_user($user_id);
            $email=$user['email'];
            if ($user['role_id']==2){
                $send_link=C('WEB_ROOT').'/recruitment/3';
                $invite_link=C('WEB_ROOT').'/efc/';
            }else{
                $send_link=C('WEB_ROOT').'/atm/3';
                $invite_link=C('WEB_ROOT').'/atm/0';
            }
            $args=array(
                '[job_link]'=>C('WEB_ROOT').'/office/'.$job['job_id'],
                '[job_name]'=>$job['title'],
                '[read_sr_link]'=>$send_link,
                '[read_ir_link]'=>$invite_link
            );
            $notifyService=new NotifyService();
            $notifyService->fillCommonArgs($args,$user_id,$sender);
            email_send($email, 22, $user_id, null, $args);
            return true;
        }else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 投递多份简历
     * @param <int> $sender 投递人（经纪人）
     * @param <int> $role ROLE_AGENT
     * @param <int> $job_id 职位ID
     * @param <string> $resume_ids 简历ID集合（多份ID以“,”分隔）
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function sendResumesToJob($sender, $role, $job_id, $resume_ids) {
        $delimiter = ",";
        $resume_ids = explode($delimiter, $resume_ids);
        foreach ($resume_ids as $resume_id) {
            $result = $this->sendResumeToJob($sender, $role, $job_id, $resume_id);
            if (is_zerror($result)) {
                break;
            }
        }
        return $result;
    }

    /**
     * 邀请简历
     * @param <int> $operator 发出邀请的人（经纪人或企业）
     * @param <int> $resume_id 简历ID
     * @param <int> $job_id 职位ID
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function inviteResume($operator, $resume_id, $job_id) {
        $check = $this->check_job($operator, $job_id, '邀请简历');
        if (is_zerror($check))
            return $check;
        $provider = new ResumeProvider();
        $resume = $provider->getResume($resume_id);
        if (empty($resume)) {
            return E(ErrorMessage::$RESUME_NOT_EXIST);
        }
        if ($resume['publisher_id'] != 0) {
            $owner = $resume['publisher_id'];
        } elseif ($resume['agent_id'] != 0) {
            $owner = $resume['agent_id'];
        }
        if (empty($owner)) {
            $psvc = new HumanService();
            $human = $psvc->get_human_by_resume($resume_id);
            $usvc = new UserService();
            $user = $usvc->get_user_by_data($data_id, $role_id);
            $owner = $user['user_id'];
        }
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($operator, 2, '简历编号' . $resume['id'] . '; 简历拥有者编号' . $owner);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        if(!$provider->exists_invite_record($operator, $resume_id, $owner))
            ExperienceCrmService::add_experience_invite_resume($operator);      //如果之前不存在指定邀请记录，则增加经验值
        $jobOperateProvider = new JobOperateProvider();
        if (!$jobOperateProvider->add_invite_resume($operator, $resume_id, $job_id, date_f(), $owner)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
//已使用系统消息通知，暂不再进行再次通知
//        $service = new RemindService();
//        $service->notify(C('REMIND_INVITE'), $owner);        //通知
        return true;
    }

    /**
     * 查看简历
     * @param <int> $operator 查看人（企业或经纪人）
     * @param <int> $role ROLE_AGENT为经纪人，ROLE_ENTERPRISE为企业
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getAllResume($operator, $role) {
        $resumeProvider = new ResumeProvider();
        $resumeProvider->getResumeList();
    }

    /**
     * 查看指定职位已经收到的简历
     * @param <int> $publisher 职位发布人（企业或经纪人）
     * @param <int> $job_id 职位ID
     * @param <int> $role 投递者角色编号
     * @param <int> $page 第几页
     * @param <int> $size 每页几条
     * @param <bool> $count 是否统计总条数
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getReceiveResumeByJob($publisher, $job_id, $role, $page, $size, $count = false) {
        $provider = new JobProvider();
        $job = $provider->getJob($job_id);
        if (empty($job)) {
            return null;
        }
        $resumeProvider = new ResumeProvider();
        $data = $resumeProvider->getJobResumeList($publisher, $job_id, $job['job_category'], $role, null, null, $page, $size, $count);
        if ($count)
            return $data;
        if (empty($data))
            return null;
        $field = array();

        $provinceProvider = new ProvinceProvider();
        foreach ($data as $key => $item) {
            if ($item['job_category'] == 1) {
                $field = array(
                    'resume.agent_id', 'resume.publisher_id', 'human.name' => 'h_name', 'human.human_id', 'human.work_age', 'job_intent.job_salary','job_intent.job_province_code','job_intent.job_city_code','job_intent.job_name'
                );
            } else {
                $field = array(
                    'resume.agent_id', 'resume.publisher_id', 'human.name' => 'h_name', 'human.human_id', 'human.work_age', 'hang_card_intent.job_salary', 'hang_card_intent.register_province_ids'
                );
            }
            $resume_data = unserialize($item['resume_data']);
            $data[$key] = $item + $this->reduceResumeData($field, $resume_data);
            $item = $data[$key];
            $data[$key]['category'] = $item['job_category'];
            //-----------------证书----------------
            $data[$key]['certs'] = $resume_data['RC_list'];
            //-----------------工作年限----------------
            if ($item['job_category'] == 1) {
                $data[$key]['exp'] = intval($item['work_age']);
            }
            //-----------------期望注册地----------------
            else {
                $pids = explode(',', $item['register_province_ids']);
                foreach ($pids as $pid) {
                    $pro = $provinceProvider->get_province($pid);
                    if (!empty($pro))
                        $place .= $pro['name'] . ',';
                }
                if (!empty($place)) {
                    $data[$key]['place'] = rtrim($place, ',');
                }
            }
        }
        return $data;
    }

    /**
     * 查看邀请过的简历
     * @param <int> $operator 发出邀请的人（经纪人或企业）
     * @param <int> $role ROLE_AGENT为经纪人，ROLE_ENTERPRISE为企业
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getInvitedResume($operator, $role) {
        $jobOperateProvider = new JobOperateProvider();
        $jobOperateProvider->getJobOperateList();
    }

    /**
     * 获取查看过的简历
     * @param int $user_id 用户编号
     * @param int $page 第几页
     * @param int $size 每页几条
     * @param bool $count 是否统计总条数
     * @return mixed 
     */
    public function getReadResume($user_id, $page, $size, $count = false) {
        $provider = new ResumeProvider();
        return $provider->get_read_resume($user_id, $page, $size, $count);
    }

    /**
     * 查看公开过的简历
     * @param <int> $publisher 公开人（经纪人）
     * @param <int> $role ROLE_AGENT为经纪人
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getOpenedResume($publisher, $role) {
        $resumeProvider = new ResumeProvider();
        $resumeProvider->getResumeList();
    }

    /**
     * 查看代理的简历
     * @param <int> $agent 代理人（经纪人）
     * @param <int> $role ROLE_AGENT为经纪人
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getAgentedResume($agent, $role) {
        $resumeProvider = new ResumeProvider();
        $resumeProvider->getResumeList();
    }

    /**
     * 获取学历信息
     * @param  <int> $degree_id 学历编号
     * @return <mixed>
     */
    public function getDegree($degree_id) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->getDegree($degree_id);
    }

    /**
     * 获取求职意向信息
     * @param  <int> $job_intent_id 意向编号
     * @return <mixed>
     */
    public function getJobIntent($job_intent_id) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->getJobIntent($job_intent_id);
    }

    /**
     * 查看简历（动作）
     * @param  <int> $user_id   用户编号
     * @param  <int> $resume_id 简历编号
     * @return <mixed>
     */
    public function read_resume($user_id, $resume_id) {
        $provider = new ResumeProvider();
        $resume = $provider->getResume($resume_id);
        if (empty($resume))
            return null;
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($user_id, 4, '简历编号 ' . $resume_id);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        $provider = new JobOperateProvider();
        $r = $provider->getReadResume($user_id, $resume_id, date_f(null, time() - 600));
        if (empty($r))
            $provider->addReadResume(array('reader_id' => $user_id, 'resume_id' => $resume_id));
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        return true;
//        return $resume;
    }

    /**
     * 检测职位操作权限
     * @param  <int>    $user_id 操作者编号
     * @param  <int>    $job_id  职位编号
     * @param  <string> $operate 操作
     * @return <bool>
     */
    public function check_job($user_id, $job_id, $operate) {
        $provider = new JobProvider();
        $job = $provider->getJob($job_id);
        if (empty($job)) {
            return E(ErrorMessage::$JOB_NOT_EXISTS);
        }
        if ($job['publisher_id'] != $user_id) {
            return new ZError('对不起，你没有此职位的' . $operate . '权限');
        }
        return true;
    }

    /**
     * 获取委托来的简历
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <bool> $count 为true返回总记录数
     * @param <int> $agent_id 代理人ID
     * @param <int> $delegate_state 委托状态（1-未公开，2-求职中）
     * @param <int> $job_category 工作性质（1-全职，2-兼职）
     * @param <int> $register_case 注册情况（1-初始，2-变更，3-重新）
     * @param <string> $from 起始时间
     * @param <string> $to 结束时间
     * @return <mixed>
     */
    public function getDelegatedResume($page, $size, $count, $agent_id, $delegate_state, $job_category, $register_case, $from = null, $to = null) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->getDelegatedResume($page, $size, $count, null, $agent_id, $delegate_state, $job_category, $register_case, $from, $to);
    }

    /**
     * 反序列化委托来的简历
     * @param <type> $str
     * @return <mixed>
     */
    public function unserilalizeDelegatedResume($str) {
        $resumeData = unserialize($str);
        $userProvider = new UserProvider();
        $resumeData['user'] = $userProvider->get_user(C('ROLE_TALENTS'), $resumeData['human']['human_id']);
        $field = array(
            'resume.delegate_datetime', 'resume.resume_id', 'resume.publisher_id','resume.job_category', 'human.human_id', 'user.is_email_auth',
            'user.is_phone_auth', 'user.is_real_auth', 'user.name', 'resume.resume_id',
            'user.user_id', 'user.photo', 'job_intent.job_province_code', 'job_intent.job_city_code',
            'job_intent.job_name', 'job_intent.job_salary' => 'fsalary', 'human.work_age', 'job_intent.input_salary' => 'fisalary',
            'hang_card_intent.register_province_ids', 'hang_card_intent.job_salary' => 'psalary', 'hang_card_intent.input_salary' => 'pisalary'
        );
        $data = $this->reduceResumeData($field, $resumeData);
        $data['RC_list'] = $resumeData['RC_list'];
        return $data;
    }

    /**
     * 根据字段数组，缩减简历数组
     * @param <type> $field
     * @param <type> $resumeData
     * @return <type>
     */
    private function reduceResumeData($field, $resumeData) {
        $data = array();
        foreach ($field as $key => $value) {
            if (is_int($key)) {
                $tempArray = explode('.', $value);
                if ($tempArray[0] == 'resume') {
                    $data[$tempArray[1]] = $resumeData[$tempArray[1]];
                } else {
                    $data[$tempArray[1]] = $resumeData[$tempArray[0]][$tempArray[1]];
                }
            } else {
                $tempArray = explode('.', $key);
                $data[$value] = $resumeData[$tempArray[0]][$tempArray[1]];
            }
        }
        return $data;
    }

    /**
     * 查询投递简历数量
     * @param <int> $sender_id 投递人ID
     * @param <int> $resume_id 简历ID
     * @return <int>
     */
    public function getSendResumeCount($sender_id, $resume_id) {
        $jobOperateProvider = new JobOperateProvider();
        return $jobOperateProvider->getSendResumeCount($sender_id, $resume_id);
    }

    /**
     * 统计经纪人收到的简历邀请数
     * @param  <int>    $user_id 用户编号
     * @param  <string> $from    起始时间
     * @param  <string> $to      终止时间
     * @return <int>
     */
    public function count_agent_resume_invite($user_id, $from = null, $to = null) {
//       $provider = new ResumeProvider();
//       return $provider->count_agent_resume_invite($user_id, $from, $to);
        return $this->count_user_resume_invite($user_id, $from, $to);
    }

    /**
     * 获取正在运作的简历
     * @param int $publisher_id 发布人编号
     * @param int $type 简历类型
     * @param int $page 第几页
     * @param int $size 每页几条
     * @param bool $count 是否统计总条数
     * @return mixed 
     */
    public function get_running_resumes($publisher_id, $type, $page, $size, $count = false) {
        $provider = new ResumeProvider();
        return $provider->get_running_resumes($publisher_id, $type, $page, $size, $count);
    }

    /**
     * 统计简历收到的邀请数
     * @param  <int>    $resume_id 简历编号
     * @param  <string> $from      起始时间
     * @param  <string> $to        终止时间
     * @return <int>
     */
    public function count_resume_invite($resume_id, $from = null, $to = null) {
        $provider = new ResumeProvider();
        return $provider->count_resume_invite($resume_id, $from, $to);
    }

    /**
     * 统计用户收到的简历邀请数
     * @param  <int>    $user_id 用户编号
     * @param  <string> $from    起始时间
     * @param  <string> $to      终止时间
     * @return <int>
     */
    public function count_user_resume_invite($user_id, $from = null, $to = null) {
        $provider = new ResumeProvider();
        return $provider->count_user_resume_invite($user_id, $from, $to);
    }

    /**
     * 验证简历数据是否完整
     * @param <int> $resume_id 简历ID
     * @param <int> $job_category 工作性质（1为全职，2为兼职）
     * @return <mixed> 成功返回true，失败返回错误信息
     */
    public function validateResumeComplete($resume_id, $job_category) {
        $humanProvider = new HumanProvider();
        $human = $humanProvider->getHumanByResumeId($resume_id);
        $result = argumentValidate($humanProvider->humanArgRule, $human);
        if (is_zerror($result)) {
            return $result;
        }
        $resumeProvider = new ResumeProvider();
        $resume = $resumeProvider->getResume($resume_id);
        $result = argumentValidate($resumeProvider->resumeArgRule, $resume);
        if (is_zerror($result)) {
            return $result;
        }

        if (empty($job_category)) {
            $job_category = $resume['job_category'];
        }

        if (!empty($job_category)) {
            $data['job_category'] = $job_category;
            $data = argumentValidate($resumeProvider->resumeArgRule, $data);
            if (is_zerror($data)) {
                return $data;
            }
            if ($job_category == C('JOB_CATEGORY_FULL')) {
                $jobIntent = $resumeProvider->getJobIntent($resume['job_intent_id']);
                $result = argumentValidate($resumeProvider->jobIntentArgRule, $jobIntent);
                if (is_zerror($result)) {
                    return $result;
                }
                $degree = $resumeProvider->getDegree($resume['degree']);
                $result = argumentValidate($resumeProvider->degreeArgRule, $degree);
                if (is_zerror($result)) {
                    return $result;
                }
            } else {
                $hangCardIntent = $resumeProvider->getHCintent($resume['hang_card_intent_id']);
                $result = argumentValidate($resumeProvider->hangCardIntentArgRule, $hangCardIntent);
                if (is_zerror($result)) {
                    return $result;
                }
                $certificateProvider = new CertificateProvider();
                $RC_list = $certificateProvider->getRegisterCertificateListByHuman($human['human_id'], null);
                $GC_list = $certificateProvider->getGradeCertificateListByHuman($human['human_id'], null);
                if (empty($RC_list) && empty($GC_list)) {
                    return E(ErrorMessage::$RC_GC_ONE_AT_LEAST);
                }
            }
        }
        return true;
    }

    /**
     * 获取简历状态
     * @param <int> $resume_id 简历ID
     * @param <int> $role 角色ID
     * @return <int>
     */
    public function getResumeStatus($resume_id,$role=null) {
        $resumeProvider = new ResumeProvider();
        if (empty($role)){
            $role=  AccountInfo::get_role_id();
        }
        if ($role == C('ROLE_AGENT')) {
            $data = $resumeProvider->getPrivateResumeStatus($resume_id);
            $data['creator_id'] = 0;
        } else {
            $data = $resumeProvider->getResumeStatus($resume_id);
            if (empty($data)) {
                $data = $resumeProvider->getPrivateResumeStatus($resume_id);
                $data['creator_id'] = 0;
            }
        }
        $creator_id = $data['creator_id'];
        $agent_id = $data['agent_id'];
        $publisher_id = $data['publisher_id'];
        $status = 0;
        if ($agent_id == 0 && $publisher_id == 0) {
            $status = 1;        //未委托，未公开（人才关闭简历）
        } else if ($agent_id == 0 && $publisher_id > 0 && $publisher_id == $creator_id) {
            $status = 2;       //未委托，已公开
        } else if ($agent_id > 0 && $publisher_id == 0) {
            $status = 3;      //已委托，未公开（经纪人关闭简历）
        } else if ($agent_id > 0 && $publisher_id > 0 && $publisher_id != $creator_id) {
            $status = 4;     //已委托，已公开
        }
        return $status;
    }

    /**
     * 获取简历完整度
     * @param <int> $resume_id 简历ID
     */
    public function getResumeComplete($resume_id) {
        $humanProvider = new HumanProvider();

        $human_field_count = count($humanProvider->humanArgRule);
        $human = $humanProvider->getHumanByResumeId($resume_id);
        $human_complete_count = $this->computeNonEmpty($human, $humanProvider->humanArgRule);

        $resumeProvider = new ResumeProvider();
        $resume = $resumeProvider->getResume($resume_id);

        $degree_field_count = count($resumeProvider->degreeArgRule);
        $degree_id = $resume['degree_id'];
        $degree = $resumeProvider->getDegree($degree_id);
        $degree_complete_count = $this->computeNonEmpty($degree, $resumeProvider->degreeArgRule);

        $job_intent_field_count = count($resumeProvider->jobIntentArgRule);
        $job_intent_id = $resume['job_intent_id'];
        $job_intent = $resumeProvider->getJobIntent($job_intent_id);
        $job_intent_complete_count = $this->computeNonEmpty($job_intent, $resumeProvider->jobIntentArgRule);

        $work_exp_field_count = count($resumeProvider->workExpArgRule);
        $work_exp_list = $resumeProvider->getWorkExpList($resume_id, null);
        foreach ($work_exp_list as $key => $work_exp) {
            $work_exp_complete_count[$key] = $this->computeNonEmpty($work_exp, $resumeProvider->workExpArgRule);
        }

        $project_ach_field_count = count($resumeProvider->projectAchievementArgRule);
        $project_ach_list = $resumeProvider->getProjectAchievementList($resume_id, null);
        foreach ($project_ach_list as $key => $project_ach) {
            $project_ach_complete_count[$key] = $this->computeNonEmpty($project_ach, $resumeProvider->projectAchievementArgRule);
        }

        $human_id = $human['human_id'];
        $certificateService = new CertificateService();
        $RC_list = $certificateService->getRegisterCertificateListByHuman($human_id);
        $RC_complete = count($RC_list);

        $GC_list = $certificateService->getGradeCertificateListByHuman($human_id);
        $GC_complete = count($GC_list);

        $total = $human_field_count + $degree_field_count + $job_intent_field_count + $RC_complete + 1;
        $complete = $human_complete_count + $degree_complete_count + $job_intent_complete_count + $RC_complete + $GC_complete;
        foreach ($work_exp_complete_count as $count) {
            $total+=$work_exp_field_count;
            $complete+=$count;
        }
        foreach ($project_ach_complete_count as $count) {
            $total+=$project_ach_field_count;
            $complete+=$count;
        }

        if ($complete == 0) {
            return 0;
        }
        return round($complete / $total, 2) * 100;
    }

    /**
     * 获取兼职简历完善度
     * @param <int> $resume_id 简历ID
     */
    public function getHCresumeComplete($resume_id) {
        $humanProvider = new HumanProvider();

        $human_field_count = count($humanProvider->humanArgRule);
        $human = $humanProvider->getHumanByResumeId($resume_id);
        $human_complete_count = $this->computeNonEmpty($human, $humanProvider->humanArgRule);

        $resumeProvider = new ResumeProvider();
        $resume = $resumeProvider->getResume($resume_id);

        $human_id = $human['human_id'];
        $certificateService = new CertificateService();
        $RC_list = $certificateService->getRegisterCertificateListByHuman($human_id);
        $RC_complete = count($RC_list);

        $GC_list = $certificateService->getGradeCertificateListByHuman($human_id);
        $GC_complete = count($GC_list);

        $hang_card_intent_id = $resume['hang_card_intent_id'];
        $HCintent_field_count = count($resumeProvider->hangCardIntentArgRule);
        $HCintent = $resumeProvider->getHCintent($hang_card_intent_id);
        $HCintent_complete_count = $this->computeNonEmpty($HCintent, $resumeProvider->hangCardIntentArgRule);

        $total = $human_field_count + $HCintent_field_count + $RC_complete + 1;
        $complete = $human_complete_count + $HCintent_complete_count + $RC_complete + $GC_complete;

        if ($complete == 0) {
            return 0;
        }
        return round($complete / $total, 2) * 100;
    }

    /**
     * 计算非空数目
     * @param <array> $values
     * @param <array> $keys
     * @return int 
     */
    private function computeNonEmpty($values, $keys) {
        $count = 0;
        foreach ($keys as $key => $value) {
            if (!empty($values[$key]) && $values[$key] <> '0000-00-00') {
                $count++;
            }
        }
        return $count;
    }

    /**
     * 查看应聘来的简历
     * @param <int> $publisher_id 发布人ID
     * @param <int> $sent_status 投递状态（1-未查看，2-已查看）
     * @param <int> $job_category 工作性质（1-全职，2-兼职）
     * @param <int> $sender_role 投递人角色（1-人才，2-经纪人）
     * @param <int> $page 第几页
     * @param <int> $size 每页几条
     * @param <int> $count 是否返回总条数
     * @return <mixed>
     */
    public function getSentResume($publisher_id, $sent_status, $job_category, $sender_role, $page, $size, $count) {
        $field = array(
            'sender.is_email_auth', 'sender.is_phone_auth', 'sender.is_real_auth',
            'sender.name', 'sender.user_id', 'sender.photo', 'sender.role_id',
            'send_resume.send_datetime', 'send_resume.status', 'job.title' => 'job', 'send_resume.send_resume_id', 'send_resume.resume_data', 'send_resume.job_category'
        );
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->getSentResume($publisher_id, $sent_status, $job_category, $sender_role, $field, $page, $size, $count, null);
    }

    /**
     * 反序列化应聘来的简历
     * @param <type> $str
     * @return <mixed>
     */
    public function unserilalizeSentResume($str) {
        if (empty($str)) {
            return array();
        }
        $resumeData = unserialize($str);
        $field = array(
            'resume.resume_id', 'human.human_id', 'human.name' => 'human_name', 'job_intent.job_province_code',
            'job_intent.job_city_code', 'job_intent.job_name', 'human.work_age', 'job_intent.job_salary' => 'fsalary', 'hang_card_intent.register_province_ids',
            'hang_card_intent.job_salary' => 'psalary','job_intent.input_salary' => 'fisalary','hang_card_intent.input_salary' => 'pisalary'
        );
        $data = $this->reduceResumeData($field, $resumeData);
        $data['RC_list'] = $resumeData['RC_list'];
        return $data;
    }

    /**
     * 更新投递简历状态
     * @param <int> $operator 操作人ID
     * @param <int> $operator_role 操作人角色（2-企业，3-经纪人）
     * @param <int> $send_resume_id 投递简历记录ID
     * @param <int> $status 投递状态（1-未查看，2-已查看）
     * @return <bool>
     */
    public function updateSendStatus($operator, $operator_role, $send_resume_id, $status) {
        $jobOperateProvider = new JobOperateProvider();
        $data = array(
            'status' => $status,
        );
        $result = $jobOperateProvider->updateSendResume($send_resume_id, $data);
        if ($result) {
            return true;
        } else {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
    }

    /**
     * 创建私有兼职简历
     * @param <int> $owner 拥有者ID
     * @param <int> $owner_role 拥有者角色（3-经纪人）
     * @param <string> $name 姓名
     * @param <int> $gender 性别(0-女,1-男)
     * @param <datetime> $birthday 出生日期
     * @param <int> $province_code 省份编号
     * @param <int> $city_code 城市编号
     * @param <string> $contact_mobile 联系人手机
     * @param <string> $contact_qq 联系人QQ
     * @param <string> $contact_email 联系人邮箱
     * @param <int> $work_age 工作年限（1,2,3,4）
     * @param <string> $RC_ids 注册证书ID（“,”隔开）
     * @param <string> $RC_cases 注册情况 （“,”隔开）
     * @param <string> $RC_provinces 注册地省份编号（“,”隔开）
     * @param <int> $GC_id 职称证书ID
     * @param <int> $GC_class 职称证书级别
     * @param <int> $job_salary 期望待遇
     * @param float $input_salary  手动输入期望待遇
     * @param <string> $register_province_ids 期望注册地（“,”隔开）
     * @param <string> $certificate_remark 补充说明
     * @param <int> $is_public 是否公开简历
     * @param <int> $human_id 添加的人才编号
     * @return <mixed> 成功返回true,失败返回错误信息
     */
    public function createPrivateHCresume($owner, $owner_role, $name, $gender, $birthday, $province_code, $city_code, $contact_mobile, $contact_qq, $contact_email, $work_age, $RC_ids, $RC_cases, $RC_provinces, $GC_id, $GC_class, $job_salary, $input_salary, $register_province_ids, $certificate_remark, $is_public, &$human_id) {
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($owner, 13, $name);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        $resumeProvider = new ResumeProvider();
        //开启事务
        $resumeProvider->trans();
        $humanService = new HumanService();
        //添加人才信息
        $human_id = $humanService->add_private_human($name, $gender, $birthday, $province_code, $city_code, $contact_mobile, $contact_qq, $contact_email, $work_age);
        if (is_zerror($human_id)) {
            //添加人才失败，事务回滚
            $resumeProvider->rollback();
            return $human_id;
        }
        //添加注册证书
        $certicateService = new CertificateService();
        $result = $certicateService->addMutiRegisterCertificateToHuman($human_id, $RC_ids, $RC_provinces, $RC_cases);
        if (is_zerror($result)) {
            //添加注册证书失败，事务回滚
            $resumeProvider->rollback();
            return $result;
        }
        //更新挂证意向
        $humanProvider = new HumanProvider();
        $human = $humanProvider->getHuman($human_id);
        $resume_id = $human['resume_id'];
        $resume = $resumeProvider->getResume($resume_id);
        $hang_card_intent_id = $resume['hang_card_intent_id'];
        $resumeService = new ResumeService();
        $result = $resumeService->updateHCresume($human_id, 0, $GC_id, $GC_class, $certificate_remark, $hang_card_intent_id, $job_salary, $input_salary, $register_province_ids);
        if (is_zerror($result)) {
            //更新挂证意向失败，事务回滚
            $resumeProvider->rollback();
            return $result;
        }

        //更新简历表
        $data = array(
            'agent_id' => $owner,
            'publisher_id' => 0,
            'delegate_datetime' => date_f(),
            'job_category' => 2
        );
        $data = argumentValidate($resumeProvider->resumeArgRule, $data);
        if (is_zerror($data)) {
            $resumeProvider->rollback();
            return $data;
        }
        $result = $resumeProvider->updateResume($resume_id, $data);
        if (is_zerror($result)) {
            //委托简历失败，事务回滚
            $resumeProvider->rollback();
            return $result;
        }

        if ($is_public) {
            //公开简历
            $result = $this->openResume($owner, $owner_role, $resume_id, 2);
            if (is_zerror($result)) {
                $resumeProvider->rollback();
                return $result;
            }
        }
        ExperienceCrmService::add_experience_post_resume($owner);
        $resumeProvider->commit();
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        return true;
    }

    /**
     * 创建私有简历第一步
     * @param <int> $owner 拥有者ID
     * @param <int> $owner_role 拥有者角色（3-经纪人）
     * @param <string> $name 姓名
     * @param <int> $gender 性别（0-女，1-男）
     * @param <datetime> $birthday 出生日期
     * @param <int> $province_code 省份编号
     * @param <int> $city_code 城市编号
     * @param <string> $contact_mobile 联系人手机
     * @param <string> $contact_qq 联系人QQ
     * @param <string> $contact_email 联系人邮箱
     * @param <int> $work_age 工作年限(1,2,3,4)
     * @param <int> $human_id 添加的人才编号
     * @return <mixed> 成功返回true,失败返回错误信息
     */
    public function createPrivateResumeStep1($owner, $owner_role, $name, $gender, $birthday, $province_code, $city_code, $contact_mobile, $contact_qq, $contact_email, $work_age, &$human_id) {
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($owner, 13, $name);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        $resumeProvider = new ResumeProvider();
        //开启事务
        $resumeProvider->trans();
        $humanService = new HumanService();
        //添加人才信息
        $human_id = $humanService->add_private_human($name, $gender, $birthday, $province_code, $city_code, $contact_mobile, $contact_qq, $contact_email, $work_age);
        if (is_zerror($human_id)) {
            //添加人才信息失败，事务回滚
            $resumeProvider->rollback();
            return $human_id;
        }
        $humanProvider = new HumanProvider();
        $human = $humanProvider->getHuman($human_id);
        $resume_id = $human['resume_id'];

        //更新简历表
        $data = array(
            'agent_id' => $owner,
            'publisher_id' => 0,
            'delegate_datetime' => date_f(),
            'job_category' => 1
        );
        $data = argumentValidate($resumeProvider->resumeArgRule, $data);
        if (is_zerror($data)) {
            $resumeProvider->rollback();
            return $data;
        }
        $result = $resumeProvider->updateResume($resume_id, $data);
        if (is_zerror($result)) {
            //委托简历失败，事务回滚
            $resumeProvider->rollback();
            return $result;
        } else {
            //委托简历成功，事务提交
            ExperienceCrmService::add_experience_post_resume($owner);
            $resumeProvider->commit();
            //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
            $pks->end_paying_operation();
            //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
            return array(
                'human_id' => $human_id,
                'resume_id' => $resume_id,
            );
        }
    }

    /**
     * 创建私有简历第二步
     * @param <int> $human_id 人才ID
     * @param <string> $job_name 职位名称
     * @param <int> $job_province_code 工作地点省份编号
     * @param <int> $job_city_code 工作地点城市编号
     * @param <string> $job_salary 期望待遇
     * @param float $input_salary 手动输入期望待遇
     * @param <string> $job_describle 职位描述
     * @param <datetime> $study_startdate 学历起始时间
     * @param <datetime> $study_enddate 学历终止时间
     * @param <string> $school 学校名称
     * @param <string> $major_name 专业名称
     * @param <int> $degree_name 学历名称
     * @param <string> $RC_ids 注册证书ID集合（“,”分隔）
     * @param <string> $RC_cases 注册情况集合 （“,”分隔）
     * @param <string> $RC_provinces 注册地省份编号集合（“,”分隔）
     * @param <int> $GC_id 职称证书ID
     * @param <int> $GC_class 职称证书级别
     * @param <string> $certificate_remark 证书补充说明
     * @return <mixed> 成功返回true，失败返回错误信息
     */
    public function createPrivateResumeStep2($human_id, $job_name, $job_province_code, $job_city_code, $job_salary, $input_salary, $job_describle, $study_startdate, $study_enddate, $school, $major_name, $degree_name, $RC_ids, $RC_cases, $RC_provinces, $RC_ids, $RC_cases, $RC_provinces, $GC_id, $GC_class, $certificate_remark) {
        $resumeProvider = new ResumeProvider();
        //开启事务
        $resumeProvider->trans();
        $humanProvider = new HumanProvider();
        $human = $humanProvider->getHuman($human_id);
        //判断人才是否存在
        if (empty($human)) {
            return E(ErrorMessage::$HUMAN_NOT_EXIST);
        }
        $resume_id = $human['resume_id'];
        $resume = $resumeProvider->getResume($resume_id);
        $job_intent_id = $resume['job_intent_id'];
        $degree_id = $resume['degree_id'];
        //更新求职意向
        $result = $this->updateJobIntent($job_intent_id, $job_name, $job_province_code, $job_city_code, $job_salary, $input_salary, $job_describle);
        if (is_zerror($result)) {
            //更新求职意向失败，事务回滚
            $resumeProvider->rollback();
            return $result;
        }
        //更新学历
        $result = $this->updateDegree($degree_id, $study_startdate, $study_enddate, $school, $major_name, $degree_name);
        if (is_zerror($result)) {
            //更新学历失败，事务回滚
            $resumeProvider->rollback();
            return $result;
        }
        if (!empty($$RC_ids)) {
            //添加资质证书
            $certicateService = new CertificateService();
            $result = $certicateService->addMutiRegisterCertificateToHuman($human_id, $RC_ids, $RC_provinces, $RC_cases);
            if (is_zerror($result)) {
                //添加资质证书失败，事务回滚
                $resumeProvider->rollback();
                return $result;
            }
        }
        if (!empty($GC_id)) {
            //更新证书情况
            $result = $this->updateCertificateCase($human_id, 0, $GC_id, $GC_class, $certificate_remark);
        }
        if (is_zerror($result)) {
            //更新证书情况失败，事务回滚
            $resumeProvider->rollback();
            return $result;
        } else {
            //成功，提交事务
            $resumeProvider->commit();
            return true;
        }
    }

    /**
     * 查询添加的私有简历
     * @param <int> $creator_id 创建人ID
     * @param <int> $creator_role 创建人角色
     * @param <int> $delegate_status 委托状态（1-未公开，2-求职中）
     * @param <int> $register_case 注册情况(1-初始注册，2-变更注册，3-重新注册）
     * @param <int> $job_category 工作性质（1-全职，2-兼职）
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <bool> $count 是否返回总条数
     * @return <mixed>
     */
    public function getPrivateResumeList($creator_id, $creator_role, $delegate_status, $job_category, $register_case, $page, $size, $count) {
        $field = array(
            'resume.job_category', 'resume.delegate_datetime', 'resume.resume_id', 'resume.publisher_id', 'human.human_id',
            'job_intent.job_province_code', 'job_intent.job_city_code', 'human.name',
            'job_intent.job_name', 'job_intent.job_salary as fsalary', 'job_intent.input_salary as fisalary', 'human.work_age', 'hang_card_intent.register_province_ids', 'hang_card_intent.job_salary as psalary', 'hang_card_intent.input_salary as pisalary'
        );
        $resumeProvider = new ResumeProvider();
        if (!empty($register_case)) {
            $resumeProvider->getPrivateResumeListByR($creator_id, $delegate_status, $job_category, $register_case, $field, $page, $size, $count, null);
        } else {
            return $resumeProvider->getPrivateResumeList($creator_id, $delegate_status, $job_category, $field, $page, $size, $count, null);
        }
    }

    /**
     * 获取拥有的简历
     * @param <int> $owner
     * @param <int> $page
     * @param <int> $size
     * @param <bool> $count
     */
    public function getOwnResumeList($owner, $page, $size, $count) {
        $field = array(
            'resume.job_category', 'resume.delegate_datetime', 'resume.resume_id', 'resume.publisher_id', 'human.human_id',
            'job_intent.job_province_code', 'job_intent.job_city_code', 'human.name',
            'job_intent.job_name', 'human.work_age', 'hang_card_intent.register_province_ids', 'user.data_id'
        );
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->getOwnResumeList($owner, $field, $page, $size, $count, null);
    }

//   /**
//    * 完成委托简历
//    * @param  <int> $user_id   用户编号
//    * @param  <int> $resume_id 简历编号
//    * @return <bool>
//    */
//   public function finish_agent_resume($user_id, $resume_id){
//       $provider = new ResumeProvider();
//       $resume = $provider->getResume($resume_id);
//       if(empty($resume) || $resume['agent_id'] != $user_id){
//           return E(ErrorMessage::$PERMISSION_LESS);
//       }
//       $provider->trans();
//       if(!$provider->updateResume($resume_id, array('job_category' => 0, 'agent_id' => 0, 'publisher_id' => 0))){
//           $provider->rollback();
//           return E();
//       }
//       $using = $provider->get_using_delegate_resume($resume_id);
//       if(!$provider->update_delegate_resume($user_id['id'], array('status' => 3, 'finish_date' => date_f()))){
//           $provider->rollback();
//           return E();
//       }
//       $provider->commit();
//       return true;
//   }

    /**
     * 统计经纪人拥有的简历数量
     * @param  <int> $agent_id 经纪人编号
     * @return <int>
     */
    public function count_agent_resume($agent_id) {
        if ($agent_id == 0)
            return 0;
        $provider = new ResumeProvider();
        return $provider->count_agent_resume($agent_id);
    }

    /**
     * 统计用户投递简历数
     * @param  <int> $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return <int>
     */
    public function count_user_send_resume($user_id, $start, $end) {
        $provider = new ResumeProvider();
        return $provider->count_user_send_resume($user_id, $start, $end);
    }

    /**
     * 统计简历被查看数
     * @param  <int> $resume_id 简历编号
     * @return <int>
     */
    public function count_resume_read($resume_id) {
        $provider = new ResumeProvider();
        return $provider->count_resume_read($resume_id);
    }

    /**
     * 更新委托简历状态
     * @param <int> $agent 经纪人ID
     * @param <int> $resume_id 简历ID
     * @param <int> $status 委托简历状态（1-未公开，2-已公开）
     */
    public function updateDelegateResumeStatus($agent, $resume_id, $status) {
        $resumeProvider = new ResumeProvider();
        $preStatus = $resumeProvider->getDelegateResumeStatus($agent, $resume_id);
        if ($status == 1) {
            //1-未公开
            if (empty($preStatus)) {
                //简历未委托
                return E(ErrorMessage::$RESUME_NOT_AGENT);
            }
            if ($preStatus['status'] != 2 && $preStatus['status'] != 5) {
                //已公开和未查看才能转为未公开
                return new ZError(drs_format($preStatus['status']));
            }
            $data = array(
                'status' => $status
            );
            $result = $resumeProvider->updateDelegateResumeStatus($agent, $resume_id, $data);
            if (!$result) {
                return E(ErrorMessage::$DRS_UPDATE_FAIL);
            }
        } else if ($status == 2) {
            //2-已公开
            if (empty($preStatus)) {
                //简历未委托
                return E(ErrorMessage::$RESUME_NOT_AGENT);
            }
            if ($preStatus['status'] != 1 && $preStatus['status'] != 5) {
                //未公开或未查看才能转为已公开
                return new ZError(drs_format($preStatus['status']));
            }
            $data = array(
                'status' => $status
            );
            $result = $resumeProvider->updateDelegateResumeStatus($agent, $resume_id, $data);
            if (!$result) {
                return E(ErrorMessage::$DRS_UPDATE_FAIL);
            }
        } else {
            //$status格式错误
            return E(ErrorMessage::$DRS_FORMAT_FAIL);
        }
        return true;
    }

    /**
     * 标记接收到的指定简历已经处理
     * @param <int> $agent 经纪人ID
     * @param <int> $resume_id  简历ID
     * @return <mixed>
     */
    public function completeDelegateResume($agent, $resume_id) {
        $resumeProvider = new ResumeProvider();
        $preStatus = $resumeProvider->getDelegateResumeStatus($agent, $resume_id);
        //3-完成
        if (empty($preStatus)) {
            //简历未委托
            return E(ErrorMessage::$RESUME_NOT_AGENT);
        }
        $data = array(
            'status' => 3
        );
        $resumeProvider->trans();
        if (!$resumeProvider->updateDelegateResumeStatus($agent, $resume_id, $data)) {
            $resumeProvider->rollback();
            return E();
        }
        if (!$resumeProvider->updateResume($resume_id, array('agent_id' => 0, 'publisher_id' => 0, 'job_category' => 0))) {
            $resumeProvider->rollback();
            return E();
        }
        $resumeProvider->commit();
        return true;
    }

    /**
     * 删除私有简历
     * @param <int> $operator 操作人ID
     * @param <int> $human_id 人才ID
     * @return <mixed>
     */
    public function deletePrivateResume($operator, $human_id) {
        $humanProvider = new HumanProvider();

        if (!$humanProvider->isAddHuman($operator, $human_id)) {
            //经纪人只能删除自己创建的简历
            return E(ErrorMessage::$HUMAN_NOT_OWN);
        }

        $human = $humanProvider->getHuman($human_id);
        $resume_id = $human['resume_id'];
        $resumeProvider = new ResumeProvider();
        $resume = $resumeProvider->getResume($resume_id);
        $job_intent_id = $resume['job_intent_id'];
        $hang_card_intent_id = $resume['hang_card_intent_id'];
        $degree_id = $resume['degree_id'];
        $certificateProvider = new CertificateProvider();
        $RC_list = $certificateProvider->getRegisterCertificateListByHuman($human_id, null);
        $GC_list = $certificateProvider->getGradeCertificateListByHuman($human_id, null);
        $workExpList = $resumeProvider->getWorkExpList($resume_id, null);
        $PA_list = $resumeProvider->getProjectAchievementList($resume_id, null);

        $resumeProvider->trans();
        foreach ($RC_list as $rc) {
            $certificate_id = $rc['certificate_id'];
            //更新证书表(删除注册证书）
            $result = $certificateProvider->deleteCertificate($certificate_id);
            if (!$result) {
                $resumeProvider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        foreach ($GC_list as $gc) {
            $certificate_id = $rc['certificate_id'];
            //更新证书表(删除职称证书）
            $result = $certificateProvider->deleteCertificate($certificate_id);
            if (!$result) {
                $resumeProvider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        //更新简历表
        $result = $resumeProvider->updateResume($resume_id, array('is_del' => 1));
        if (!$result) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //更新求职意向表
        $result = $resumeProvider->updateJobIntent($job_intent_id, array('is_del' => 1));
        if (!$result) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //更新学历表
        $result = $resumeProvider->updateDegree($degree_id, array('is_del' => 1));
        if (!$result) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //更新挂证意向表
        $result = $resumeProvider->updateHangCardIntent($hang_card_intent_id, array('is_del' => 1));
        if (!$result) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        foreach ($workExpList as $workExp) {
            $work_exp_id = $workExp['work_exp_id'];
            //更新工作经历表
            $result = $resumeProvider->deleteWorkExp($work_exp_id);
            if (!$result) {
                $resumeProvider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        foreach ($PA_list as $pa) {
            $project_achievement_id = $pa['project_achievement_id'];
            //更新工程业绩表
            $result = $resumeProvider->deleteProjectAchievement($project_achievement_id);
            if (!$result) {
                $resumeProvider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        //更新人才表
        $result = $humanProvider->updateHuman($human_id, array('is_del' => 1));
        if (!$result) {
            $resumeProvider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        } else {
            ExperienceCrmService::add_experience_delete_info($operator);
            $resumeProvider->commit();
            return true;
        }
    }

    /**
     * 判断指定角色的用户是否具有指定信息ID的权限
     * @param <int> $owner
     * @param <int> $role
     * @param <int> $human_id
     * @param <int> $resume_id
     * @param <int> $job_intent_id
     * @param <int> $hang_card_intent_id
     * @param <int> $degree_id
     * @param <int> $certificate_id
     * @param <int> $workExpId
     * @param <int> $PA_id
     * @return <mixed> 
     */
    public function isOwnInfoId($owner, $role, $human_id, $resume_id, $job_intent_id, $hang_card_intent_id, $degree_id, $certificate_id, $workExpId, $PA_id) {
        $humanProvider = new HumanProvider();
        //验证human_id
        if (!$humanProvider->isAddHuman($owner, $human_id)) {
            return E(ErrorMessage::$HUMAN_NOT_OWN);
        }
        $human = $humanProvider->getHuman($human_id);
        if (empty($human)) {
            return E(ErrorMessage::$HUMAN_NOT_EXIST);
        }
        $resumeProvider = new ResumeProvider();
        // 验证resume_id
        if (!empty($resume_id)) {
            if ($resume_id != $human['resume_id']) {
                return E(ErrorMessage::$RECORD_NOT_EXISTS);
            }
        } else {
            $resume_id = $human['resume_id'];
        }

        $resume = $resumeProvider->getResume($resume_id);
        if (empty($resume)) {
            return E(ErrorMessage::$RESUME_NOT_EXIST);
        }
        if (!empty($job_intent_id)) {
            //验证job_intent_id
            if ($job_intent_id != $resume['job_intent_id']) {
                return E(ErrorMessage::$RECORD_NOT_EXISTS);
            }
        }
        if (!empty($hang_card_intent_id)) {
            //验证hang_card_intent_id
            if ($hang_card_intent_id != $resume['hang_card_intent_id']) {
                return E(ErrorMessage::$RECORD_NOT_EXISTS);
            }
        }
        if (!empty($degree_id)) {
            if ($degree_id != $resume['degree_id']) {
                return E(ErrorMessage::$RECORD_NOT_EXISTS);
            }
        }
        if (!empty($certificate_id)) {
            $certificateProvider = new CertificateProvider();
            $certificate = $certificateProvider->get_certificate($certificate_id);
            if ($human_id != $certificate['human_id']) {
                return E(ErrorMessage::$RECORD_NOT_EXISTS);
            }
        }
        if (!empty($workExpId)) {
            $workExp = $resumeProvider->getWorkExp($workExpId);
            if ($resume_id != $workExp['resume_id']) {
                return E(ErrorMessage::$RECORD_NOT_EXISTS);
            }
        }
        if (!empty($PA_id)) {
            $PA = $resumeProvider->getProjectAchievement($PA_id);
            if ($resume_id != $PA['resume_id']) {
                return E(ErrorMessage::$RECORD_NOT_EXISTS);
            }
        }
        return true;
    }

    /**
     * 序列化简历数据
     * @param <int> $resume_id 人才信息ID
     * @return <string> 序列化后的字符串
     */
    public function serializeResumeData($resume_id) {
        $humanProvider = new HumanProvider();
        $human = $humanProvider->getHumanByResumeId($resume_id);

        $resumeProvider = new ResumeProvider();
        $resume = $resumeProvider->getResume($resume_id);

        //人才表
        $resume['human'] = $human;
        //学历表
        $resume['degree'] = $resumeProvider->getDegree($resume['degree_id']);
        //求职意向表
        $resume['job_intent'] = $resumeProvider->getJobIntent($resume['job_intent_id']);
        //挂证意向表
        $resume['hang_card_intent'] = $resumeProvider->getHCintent($resume['hang_card_intent_id']);
        //工作经历表
        $resume['work_exp_list'] = $resumeProvider->getWorkExpList($resume_id, null);
        //工程业绩表
        $resume['project_achievement_list'] = $resumeProvider->getProjectAchievementList($resume['project_achievement_id'], null);
        //资质证书表
        $s = $resume['hang_card_intent']['input_salary'];
        $b = $resume['job_intent']['input_salary'];
        $certificateService = new CertificateService();
        $resume['RC_list'] = $certificateService->getRegisterCertificateListByHuman($human['human_id']);
        $resume['GC_list'] = $certificateService->getGradeCertificateListByHuman($human['human_id']);
        $str = serialize($resume);
        return $str;
    }

    /**
     * 获取委托来的简历的详细信息
     * @param <type> $delegate_resume_id
     */
    public function getDelegatedResumeDetail($delegate_resume_id) {
        $jobOperateProvider = new JobOperateProvider();
        $delegate_resume = $jobOperateProvider->getDelegateResume($delegate_resume_id);
        $resume_data = unserialize($delegate_resume['resume_data']);
        return $resume_data;
    }

    /**
     * 获取应聘来的简历的详细信息
     * @param <type> $send_resume_id
     */
    public function getSentResumeDetail($send_resume_id, &$pub_id) {
        $jobOperateProvider = new JobOperateProvider();
        $send_resume = $jobOperateProvider->getSendResume($send_resume_id);
        $resume_data = unserialize($send_resume['resume_data']);
        $pub_id = $send_resume['publisher_id'];
        return $resume_data;
    }

    /**
     * 是否存在投递简历关系
     * @param int $sender_id 投递人编号
     * @param type $pub_id 发布职位人编号
     * @return bool
     */
    public function exists_send_resume($sender_id, $pub_id) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->exists_send_resume($sender_id, $pub_id);
    }

    /**
     * 是否存在投递简历关系
     * @param int $resume_id 简历编号
     * @param type $pub_id 发布职位人编号
     * @return bool
     */
    public function exists_send_resume_with_resume($resume_id, $pub_id) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->exists_send_resume_with_resume($resume_id, $pub_id);
    }

    /**
     * 是否存在委托简历关系
     * @param int $resume_id 简历编号
     * @param type $agent_id 委托人编号
     * @return bool
     */
    public function exists_delegate_resume_with_resume($resume_id, $agent_id) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->exists_delegate_resume_with_resume($resume_id, $agent_id);
    }

    /**
     * 统计用户查看简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_user_read_resume($user_id, $start, $end) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->count_user_read_resume($user_id, $start, $end);
    }

    /**
     * 统计用户公开的简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_user_open_resume($user_id, $start, $end) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->count_user_open_resume($user_id, $start, $end);
    }

    /**
     * 统计用户收到的应聘简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_employ_resume($user_id, $start, $end) {
        $resumeProvider = new ResumeProvider();
        return $resumeProvider->count_user_employ_resume($user_id, $start, $end);
    }
    
    /**
     * 统计新增简历数
     * @param date $start_datetime
     */
    public function count_new_resume($start_datetime){
        $resumeProvider=new ResumeProvider();
        return $resumeProvider->count_new_resume($start_datetime);
    }

}

?>
