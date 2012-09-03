<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JobService
 *
 * @author JZG
 */
class JobService {

    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function __construct() {
        $this->provider = new JobProvider();
    }

    /**
     * 创建全职职位
     * @param  <int>    $user_id     创建人编号
     * @param  <string> $company     招聘企业
     * @param  <string> $title       标题
     * @param  <int> $job_type       招聘类别（1-预招，2-热招）
     * @param  <string> $job         职位
     * @param  <int>    $count       招聘人数
     * @param  <string> $RC_IDS      资质证书编号（多个以,隔开）
     * @param  <string> $RC_STATUS   资质证书注册情况（多个以,隔开）
     * @param  <int>    $GC_ID       职称编号
     * @param  <int>    $GCC_ID      职称等级
     * @param  <int>    $pid         工作省份
     * @param  <int>    $cid         工作城市
     * @param  <int>    $salary      年薪
     * @param float $input_salary 手动输年薪
     * @param  <int>    $degree      学历
     * @param  <int>    $exp         工作经验
     * @param  <string> $description 职位描述
     * @param  <string> $company_qualification 企业资质
     * @param  <int>    $company_category 企业性质
     * @param  <date>   $company_regtime  企业成立时间
     * @param  <int>    $company_scale    企业规模
     * @param  <string> $company_introduce 企业简介 
     * @return <mixed> 成功返回职位ID，错误返回ZERROR
     */
    public function createJob($user_id, $title, $job_type, $company, $job, $count, $RC_IDS, $RC_STATUS, $GC_ID, $GCC_ID, $pid, $cid, $salary, $input_salary, $degree, $exp, $description, $company_qualification, $company_category, $company_regtime, $company_scale, $company_introduce) {
        $data = array(
            'creator_id' => $user_id,
            'title' => $title,
            'company_name' => $company,
            'job_name' => $job,
            'job_type' => $job_type,
            'count' => $count,
            'job_salary' => $salary,
            'input_salary' => $input_salary,
            'degree' => $degree,
            'job_exp' => $exp,
            'job_describle' => $description,
            'company_qualification' => $company_qualification,
            'company_category' => $company_category,
            'company_regtime' => $company_regtime,
            'company_scale' => $company_scale,
            'company_introduce' => $company_introduce
        );
        $data = argumentValidate($this->provider->jobArgRule, $data);           //参数验证
        if (is_zerror($data)) {
            return $data;
        }
        $job_check = $this->check_job_position($job, 5);                        //验证职位合法性
        if (is_zerror($job_check)) {
            return $job_check;
        }
        if (!empty($RC_IDS)) {
            $ids = explode(',', $RC_IDS);
            $sts = explode(',', $RC_STATUS);
        }
        $provider = new CertificateProvider();
        if (!empty($GC_ID) && $provider->exists_gc_id($GC_ID)) {              //检测职称证书编号是否存在
            $data['grade_certificate_id'] = $GC_ID;
            $data['grade_certificate_class'] = var_validation($GCC_ID, VAR_GCCLASS, OPERATE_FILTER);
        }
        filter_location($pid, $cid);
        $data['job_province_code'] = $pid;
        $data['job_city_code'] = $cid;
        $data['job_category'] = C('JOB_CATEGORY_FULL');
        $data['status'] = 1;
        while (true) {                                        //生成唯一主键
            $id = build_id();
            $temp = $this->provider->getJob($id);
            if (empty($temp))
                break;
        }
        $data['job_id'] = $id;
        $this->provider->trans();                                           //事务开启
        $result = $this->provider->addJob($user_id, $data);                 //添加职位
        if (!$result) {
            $this->provider->rollback();                                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        if (!empty($RC_IDS) && count($ids) == count($sts)) {
            foreach ($ids as $key => $id) {                                     //添加职位的资质要求
                if (!$provider->exists_rc_id($id)) {                              //检测资质证书编号是否存在
                    $this->provider->rollback();                                //事务回滚
                    return E(ErrorMessage::$RC_NOT_EXISTS);
                }
                $info['certificate_id'] = $id;
                if ($sts[$key] == 0)
                    $info['status'] = 0;
                else
                    $info['status'] = var_validation($sts[$key], VAR_CCASE, OPERATE_FILTER);
                $info['count'] = 0;
                if (!$this->provider->addJobCertificate($result, $info)) {        //添加资质要求
                    $this->provider->rollback();                                //事务回滚
                    return E(ErrorMessage::$OPERATION_FAILED);
                }
            }
        }
        ExperienceCrmService::add_experience_post_job($user_id);
        $this->provider->commit();                                          //事务提交
        return $result;
    }

    /**
     * 创建兼职职位
     * @param  <int>    $user_id     创建人编号
     * @param  <string> $company     招聘企业
     * @param  <string> $title       标题
     * @param  <int>    $job_type    招聘类别
     * @param  <string> $RC_IDS      资质证书编号（多个以,隔开）
     * @param  <string> $RC_STATUS   资质证书注册情况（多个以,隔开）
     * @param  <string> $RC_COUNT    资质证书个数（多个以,隔开）
     * @param  <int>    $GC_ID       职称编号
     * @param  <int>    $GCC_ID      职称等级
     * @param  <string> $pids        地区要求（多个以,隔开）
     * @param  <int>    $pid         注册省份
     * @param  <int>    $cid         注册城市
     * @param  <int>    $salary      年薪
     * @param float $input_salary 手动输入年薪
     * @param  <int>    $safety_b    是否考取安全B证
     * @param  <int>    $muti        是否允许多证
     * @param  <int>    $degree      学历
     * @param  <int>    $exp         工作经验
     * @param  <int>    $status      工作状态
     * @param  <int>    $social      社保要求
     * @param  <string> $description 职位描述
     * @param  <string> $company_qualification 企业资质
     * @param  <int>    $company_category 企业性质
     * @param  <date>   $company_regtime  企业成立时间
     * @param  <int>    $company_scale    企业规模
     * @param  <string> $company_introduce 企业简介 
     * @return <mixed> 成功返回职位ID，错误返回ZERROR
     */
    public function createPartJob($user_id, $title, $job_type, $company, $RC_IDS, $RC_STATUS, $RC_COUNT, $GC_ID, $GCC_ID, $pids, $pid, $cid, $salary, $input_salary, $safety_b, $muti, $degree, $exp, $status, $social, $description, $company_qualification, $company_category, $company_regtime, $company_scale, $company_introduce) {
        $data = array(
            'creator_id' => $user_id,
            'title' => $title,
            'job_type' => $job_type,
            'company_name' => $company,
            'job_state' => $status,
            'job_salary' => $salary,
            'input_salary' => $input_salary,
            'degree' => $degree,
            'job_exp' => $exp,
            'social_security' => $social,
            'safety_b_card' => $safety_b,
            'muti_certificate' => $muti,
            'job_describle' => $description,
            'company_qualification' => $company_qualification,
            'company_category' => $company_category,
            'company_regtime' => $company_regtime,
            'company_scale' => $company_scale,
            'company_introduce' => $company_introduce
        );
        $data = argumentValidate($this->provider->jobArgRule, $data);           //参数验证
        if (is_zerror($data)) {
            return $data;
        }
        if (!empty($RC_IDS)) {                                                     //资质要求格式验证
            $ids = explode(',', $RC_IDS);
            $sts = explode(',', $RC_STATUS);
            $cts = explode(',', $RC_COUNT);
            if (count($ids) != count($sts) || count($ids) != count($cts)) {           //资质要求格式错误
                return E(ErrorMessage::$CERTIFICATE_REQUIRE_FORMAT_ERROR);
            }
        }
        $psvc = new ProvinceService();
        $data['require_place'] = $psvc->filter_place($pids);
        $provider = new CertificateProvider();
        if (!empty($GC_ID) && $provider->exists_gc_id($GC_ID)) {              //检测职称证书编号是否存在
            $data['grade_certificate_id'] = $GC_ID;
            $data['grade_certificate_class'] = var_validation($GCC_ID, VAR_GCCLASS, OPERATE_FILTER);
        }
        filter_location($pid, $cid);
        $data['job_province_code'] = $pid;
        $data['job_city_code'] = $cid;
        $data['job_category'] = C('JOB_CATEGORY_PART');
        $data['status'] = 1;
        while (true) {                                        //生成唯一主键
            $id = build_id();
            $temp = $this->provider->getJob($id);
            if (empty($temp))
                break;
        }
        $data['job_id'] = $id;
        $this->provider->trans();                                           //事务开启
        $result = $this->provider->addJob($user_id, $data);                 //添加职位
        if (!$result) {
            $this->provider->rollback();                                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        foreach ($ids as $key => $id) {                                     //添加职位的资质要求
            if (!$provider->exists_rc_id($id)) {                              //检测资质证书编号是否存在
                $this->provider->rollback();                                //事务回滚
                return E(ErrorMessage::$RC_NOT_EXISTS);
            }
            $info['certificate_id'] = $id;
            if ($sts[$key] == 0)
                $info['status'] = 0;
            else
                $info['status'] = var_validation($sts[$key], VAR_CCASE, OPERATE_FILTER);
            $info['count'] = var_validation($cts[$key], VAR_JCOUNT, OPERATE_FILTER);
            if (!$this->provider->addJobCertificate($result, $info)) {        //添加资质要求
                $this->provider->rollback();                                //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        ExperienceCrmService::add_experience_post_job($user_id);
        $this->provider->commit();                                          //事务提交
        return $result;
    }

    /**
     * 发布职位(企业或经纪人将招聘信息公开）
     * @param <int> $publisher 发布人（企业或经纪人）
     * @param <int> $role ROLE_ENTERPRISE为企业，ROLE_AGENT为经纪人
     * @param <int> $job_id 职位ID
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function pubJob($publisher, $role, $job_id) {
        //检测用户的发布权限
        $check = $this->check_job_do_permission($job_id, $publisher, 1, null, $job);
        if (is_zerror($check)) {
            return $check;
        }
        $data = array(
            'publisher_id' => $publisher,
            'publisher_role' => $role,
        );
        $data = argumentValidate($this->provider->jobArgRule, $data);
        if (is_zerror($data)) {
            return $data;
        }
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($publisher, 1, $job['title']);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        $this->provider->trans();
        $data['pub_datetime'] = date_f();
        $data['status'] = 2;
        if (!$this->provider->updateJob($job_id, $data)) {
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        if ($job['agent_id'] > 0) {
            $using = $this->provider->get_using_delegate_job($job_id);
            if (!$this->provider->update_delegate_job($using['id'], array('status' => 2))) {
                $this->provider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        $this->provider->commit();
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        $service = new ContactsService();
        $service->moving_post_jobs($publisher, $job['job_id'], $job['job_category'], $job['title']);

        //添加职位索引
        if (!$this->provider->existJobIndex($job_id)){
            $job=$this->provider->getJob($job_id);
            $this->addJobIndex($job);
        }
        //公开职位时触发推荐更新
        $recommendService = new RecommendService();
        $recommendService->openJobTriggerUpdate(AccountInfo::get_user_id(), AccountInfo::get_role_id());
        return true;
    }

    /**
     * 暂停职位
     * @param <int> $publisher 发布人（企业或经纪人）
     * @param <int> $role ROLE_ENTERPRISE为企业，ROLE_AGENT为经纪人
     * @param <int> $job_id 职位ID
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function pauseJob($publisher, $role, $job_id) {
        //检测用户的发布权限
        $check = $this->check_job_do_permission($job_id, $publisher, 1, null, $job);
        if (is_zerror($check)) {
            return $check;
        }
        $data = array(
            'status' => 4,
            'publisher_id' => 0,
            'publisher_role' => 0,
        );
        $data = argumentValidate($this->provider->jobArgRule, $data);
        if (is_zerror($data)) {
            return $data;
        }
        $this->provider->trans();
        if (!$this->provider->updateJob($job_id, $data)) {
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        if ($job['agent_id'] > 0) {
            $using = $this->provider->get_using_delegate_job($job_id);
            if (!$this->provider->update_delegate_job($using['id'], array('status' => 6))) {
                $this->provider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        $this->provider->commit();
        return true;
    }

    /**
     * 重新发布职位
     * @param <int> $publisher 发布人（企业或经纪人）
     * @param <int> $role ROLE_ENTERPRISE为企业，ROLE_AGENT为经纪人
     * @param <int> $job_id 职位ID
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function startJob($publisher, $role, $job_id) {
        //检测用户的发布权限
        $check = $this->check_job_do_permission($job_id, $publisher, 1, null, $job);
        if (is_zerror($check)) {
            return $check;
        }
        if ($job['status'] != 4) {                //暂停的职位才能重新开始
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        $data = array(
            'publisher_id' => $publisher,
            'publisher_role' => $role,
        );
        $data = argumentValidate($this->provider->jobArgRule, $data);
        if (is_zerror($data)) {
            return $data;
        }
        $this->provider->trans();
        $data['pub_datetime'] = date_f();
        $data['status'] = 2;
        if (!$this->provider->updateJob($job_id, $data)) {
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        if ($job['agent_id'] > 0) {
            $using = $this->provider->get_using_delegate_job($job_id);
            if (!$this->provider->update_delegate_job($using['id'], array('status' => 2))) {
                $this->provider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        $this->provider->commit();
        return true;
    }

    /**
     * 委托职位
     * @param <int> $operator 委托人（企业）
     * @param <int> $agent 代理人(经纪人）
     * @param <int> $job_id 职位ID
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function delegateJob($operator, $agent, $job_id) {
        //检测用户的代理权限
        $check = $this->check_job_do_permission($job_id, $operator, 2, $agent, $job);
        if (is_zerror($check)) {
            return $check;
        }
        $date = date_f();
        $data['agent_id'] = $agent;
        $data['publisher_id'] = 0;
        $data['publisher_role'] = 0;
        $data['status'] = 1;
        $data['delegate_datetime'] = $date;
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($operator, 14, $job['title']);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        $this->provider->trans();
        if (!$this->provider->updateJob($job_id, $data)) {
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        if (!$this->provider->add_delegate_job($agent, $job_id, $date)) {
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        $service = new RemindService();
        $service->notify(C('REMIND_JAGENT'), $agent);        //通知
        //ExperienceCrmService::add_experience_entrust_office($operator); //调用经验模块增加经验
        //发送通知邮件
        $userService = new UserService();
        $user = $userService->get_user($agent);
        $job = $this->get_job($job_id);
        $notifyService=new NotifyService();
        $args=array();
        $notifyService->fillCommonArgs($args,$agent,$operator);
        $args['[company_name]']=$job['company_name'];
        $args['[job_name]']=$job['title'];
        $args['[job_link]']=C('WEB_ROOT') . '/office/' . $job['job_id'];
        email_send($user['email'], 24, $user['user_id'], null, $args);
        
        return true;
    }

    /**
     * 终止委托职位
     * @param <int> $operator 委托人（企业）
     * @param <int> $agent 代理人(经纪人）
     * @param <int> $job_id 职位ID
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function endDelegateJob($operator, $job_id) {
        //检测用户的代理权限
        $check = $this->check_job_do_permission($job_id, $operator, 3);
        if (is_zerror($check)) {
            return $check;
        }
        $data['agent_id'] = 0;
        $data['publisher_id'] = 0;
        $data['publisher_role'] = 0;
        $data['status'] = 1;
        $this->provider->trans();
        if (!$this->provider->updateJob($job_id, $data)) {
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $result = $this->provider->get_using_delegate_job($job_id);
        $update['status'] = 4;
        $update['end_agent_date'] = date_f();
        if (!$this->provider->update_delegate_job($result['id'], $update)) {
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();
        $service = new RemindService();
        $service->notify(C('REMIND_EDJOB'), $result['agent_id']);
        return true;
    }

    /**
     * 结束职位（结束招聘）
     * @param <int> $operator 结束人（企业或经纪人）
     * @param <int> $job_id 职位ID
     * @return <bool> 成功返回true，错误返回错误信息
     */
    public function closeJob($operator, $job_id) {
        $jobProvider = new JobProvider();
        $check = $this->check_job_do_permission($job_id, $operator, 1, null, $job);
        if (is_zerror($check)) {
            return $check;
        }
        $this->provider->trans();
        if (!$jobProvider->updateJob($job_id, array('publisher_id' => 0, 'status' => 3))) {
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        if ($job['agent_id'] > 0) {
            $using = $this->provider->get_using_delegate_job($job_id);
            $update['status'] = 3;
            $update['finish_date'] = date_f();
            if (!$this->provider->update_delegate_job($using['id'], $update)) {
                $this->provider->rollback();
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        $this->provider->commit();
        return true;
    }

    /**
     * 查看职位
     * @param <int> $operator 查看人（人才或经纪人）
     * @param <int> $role ROLE_TALENTS为人才，ROLE_AGENT为经纪人
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getAllJob($operator, $role) {
        $jobProvider = new JobProvider();
        $jobProvider->getJobList();
    }

    /**
     * 查看应聘过的职位
     * @param <int>  $sender_id 投递人ID
     * @param <int> $role_id 投递人角色
     * @param <int> $job_category 工作性质（1为全职，2为兼职）
     * @param <int> $publisher_role 发布人角色
     * @param <int> $register_case 注册情况
     * @param <int> $count 为true时返回总记录数
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $resume_id 简历ID
     * @return <mixed>
     */
    public function getSentJob($sender, $role, $job_category, $publisher_role, $register_case, $count, $page, $size, $resume_id) {
        $jobProvider = new JobProvider();
        return $jobProvider->getSentJob($sender, $role, $job_category, $publisher_role, $count, $page, $size, null, $resume_id);
    }

    /**
     * 获取指定用户发布的职位列表
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $type    工作性质
     * @param  <int>  $status  职位状态
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @param  <bool> $no_full 是否不需要详细数据
     * @param  <bool> $no_rcount 是否不需要简历数
     * @return <mixed>
     */
    public function get_pub_jobs($publisher, $type, $status, $page, $size, $count = false, $no_full = false, $no_rcount = false) {
        $provider = new JobProvider();
        if (!empty($type))
            $type = var_validation($type, VAR_JCATEGORY, OPERATE_FILTER);
        if (!empty($status))
            $status = var_validation($status, VAR_JSTATUS, OPERATE_FILTER);
        $data = $provider->get_pub_jobs($publisher, $type, $status, var_validation($page, VAR_PAGE, OPERATE_FILTER), var_validation($size, VAR_SIZE, OPERATE_FILTER), $count);
        if ($count || $no_full) {
            return $data;
        }
        if (empty($data)) {
            return null;
        }
        $service = new CertificateService();
        $rserv = new ResumeService();
        foreach ($data as $key => $value) {
            $data[$key]['certs'] = $service->getRegisterCertificateListByJob($value['job_id']);
            if (!$no_rcount)
                $data[$key]['r_count'] = $rserv->getReceiveResumeByJob($publisher, $value['job_id'], null, null, null, true);
            else
                $data[$key]['r_count'] = 0;
        }
        return $data;
    }

    /**
     * 获取指定用户委托的职位列表
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $type    工作性质
     * @param  <int>  $status  职位状态
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function getDelegatedJob($user_id, $type, $status, $page, $size, $count = false) {
        $provider = new JobProvider();
        if (!empty($type))
            $type = var_validation($type, VAR_JCATEGORY, OPERATE_FILTER);
        $data = $provider->get_agent_jobs($user_id, $type, $status, var_validation($page, VAR_PAGE, OPERATE_FILTER), var_validation($size, VAR_SIZE, OPERATE_FILTER), $count);
        if ($count)
            return $data;
        if (empty($data))
            return null;
        $service = new CertificateService();
        $rserv = new ResumeService();
        foreach ($data as $key => $value) {
            $data[$key]['certs'] = $service->getRegisterCertificateListByJob($value['job_id']);
            $data[$key]['r_count'] = $rserv->getReceiveResumeByJob($user_id, $value['job_id'], null, null, null, true);
        }
        return $data;
    }

    /**
     * 获取正在运作的职位
     * @param int $publisher_id 发布人编号
     * @param int $type 职位类型
     * @param int $page 第几页
     * @param int $size 每页几条
     * @param bool $count 是否统计总条数
     * @return array 
     */
    public function get_running_jobs($publisher_id, $type, $page, $size, $count = false) {
        return $this->provider->get_running_jobs($publisher_id, $type, $page, $size, $count);
    }

    /**
     * 查看委托来的职位
     * @param  <int> $user_id 用户编号
     * @param  <int> $job_id  职位编号
     * @return <mixed>
     */
    public function read_delegate_job($user_id, $job_id) {
        $provider = new JobProvider();
        $using = $provider->get_using_delegate_job($job_id);
        if (empty($user_id) || $user_id != $using['agent_id'] || $using['status'] != 5) {
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        if (!$provider->update_delegate_job($using['id'], array('status' => 1))) {
            return E();
        }
        return true;
    }

    /**
     * 查看职位详细
     * @param  <int> $job_id  职位编号
     * @param  <int> $user_id 用户编号
     * @return <bool>
     */
    public function read_job($job_id, $user_id) {
        $provider = new JobOperateProvider();
        $r = $provider->getReadJob($user_id, $job_id, date_f(null, time() - 600));
        if (empty($r))
            $provider->addReadJob(array('reader_id' => $user_id, 'job_id' => $job_id));
        return;
    }

    /**
     * 查看创建过的职位
     * @param <int> $creator 创建人（企业）
     * @param <int> $role ROLE_ENTERPRISE为企业
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getCreatedJob($creator, $role) {
        $jobProvider = new JobProvider();
        $jobProvider->getJobList();
    }

    /**
     * 查看代理的职位
     * @param <int> $agent 代理人（经纪人）
     * @param <int> $role  ROLE_AGENT为经纪人
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getAgentedJob($agent, $role) {
        $jobProvider = new JobProvider();
        $jobProvider->getJobList();
    }

    /**
     * 获取指定编号的职位信息
     * @param  <int> $job_id 职位编号
     * @return <mixed>
     */
    public function get_job($job_id) {
        $provider = new JobProvider();
        return $provider->getJob($job_id);
    }

    /**
     * 获取指定用户收到的委托职位列表
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $type    工作性质
     * @param  <int>  $status  职位状态
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function get_agented_jobs($user_id, $type, $status, $page, $size, $count = false) {
        $provider = new JobProvider();
        if (!empty($type))
            $type = var_validation($type, VAR_JCATEGORY, OPERATE_FILTER);
        if (!empty($status))
            $status = var_validation($status, VAR_JSTATUS, OPERATE_FILTER);
        $data = $provider->get_agented_jobs($user_id, $type, $status, var_validation($page, VAR_PAGE, OPERATE_FILTER), var_validation($size, VAR_SIZE, OPERATE_FILTER), $count);
        if ($count)
            return $data;
        if (empty($data))
            return null;
        $service = new CertificateService();
        $rserv = new ResumeService();
        foreach ($data as $key => $value) {
            $data[$key]['certs'] = $service->getRegisterCertificateListByJob($value['job_id']);
            $data[$key]['r_count'] = $rserv->getReceiveResumeByJob($user_id, $value['job_id'], null, null, null, true);
        }
        return $data;
    }

    /**
     * 获取职位列表
     * @param  <int>    $page  第几页
     * @param  <int>    $size  每页几条
     * @param  <string> $order 排序方式
     * @param  <bool>   $count 是否统计总条数
     * @return <mixed>
     */
    public function get_job_list($page, $size, $order = null, $count = false) {
        $data = $this->provider->get_job_list($page, $size, $order, $count);
        return $data;
    }

    /**
     * 统计收到的简历投递数
     * @param  <int>    $user_id 用户编号
     * @param  <string> $from    起始日期
     * @param  <string> $to      终止日期
     * @return <int>
     */
    public function count_resume_send($user_id, $from = null, $to = null) {
        return $this->provider->count_resume_send_by_user($user_id, $from, $to);
    }

    /**
     * 统计经纪人收到的委托职位数量
     * @param  <int>    $agent_id 经纪人编号
     * @param  <string> $from     起始时间
     * @return <int>
     */
    public function count_agent_job($agent_id, $from = null) {
        return $this->provider->count_agent_job($agent_id, $from);
    }

    /**
     * 检测指定用户对指定职位的基本操作权限
     * @param <int> $job_id  职位编号
     * @param <int> $user_id 操作者用户编号
     * @param <mixed> $job 职位（引用传参）
     * @return <bool> 失败返回ZERROR
     */
    public function check_job_op_permission($job_id, $user_id, &$job) {
        return $this->check_job_do_permission($job_id, $user_id, 1, null, $job);
    }

    /**
     * 获取投递过的企业
     * @param int $user_id 用户编号
     * @param int $page    第几页
     * @param int $size    每页几条
     * @param int $count   是否统计总条数
     * @return mixed
     */
    public function get_send_company($user_id, $page, $size, $count) {
        return $this->provider->get_send_company($user_id, $page, $size, $count);
    }

    /**
     * 获取职位列表
     * @param int $parent_id 父类别编号
     * @return array 
     */
    public function get_job_positions($parent_id) {
        return $this->provider->get_positions($parent_id);
    }

    /**
     * 
     * @param type $ids 
     */
    public function job_id_to_name($ids) {
        
    }

    /**
     * 检测职位选择合法性
     * @param string $position 职位编号字符串
     * @param int $count 最大限制个数
     * @return boolean 
     */
    public function check_job_position($position, $count) {
        $array = explode(',', $position);
        if (count($array) > $count) {
            return E('选择职位数量超出最大限制');
        }
        foreach ($array as $item) {
            $pos = $this->provider->get_position($item);
            if (empty($pos)) {
                return E('职位选择错误');
            }
        }
        return true;
    }

    /**
     * 获取职位信息
     * @param string $position 职位编号字符串
     * @return string 
     */
    public function get_job_position($position) {
        $array = explode(',', $position);
        foreach ($array as $item) {
            $pos = $this->provider->get_position($item);
            $name = $pos['name'];
            if ($pos['parent_id'] != 0) {
                $par = $this->provider->get_position($pos['parent_id']);
                $name = $par['name'] . ' - ' . $name;
            }
            $string .= $name . '、';
        }
        return rtrim($string, '、');
    }

    /**
     * 获取更详细职位信息
     * @param string $str 职位编号字符串
     * @return array 
     */
    public function get_job_position_more($str) {
        $ids = explode(',', $str);
        $pids = array();
        $names = array();
        foreach ($ids as $item) {
            $pos = $this->provider->get_position($item);
            $name = $pos['name'];
            if ($pos['parent_id'] != 0) {
                $par = $this->provider->get_position($pos['parent_id']);
                $name = $par['name'] . ' - ' . $name;
            }
            array_push($pids, $pos['parent_id']);
            array_push($names, $name);
        }
        return array('ids' => $ids, 'pids' => $pids, 'names' => $names);
    }

    /**
     * 获取求职意向匹配职位列表
     * @param int $user_id 匹配用户编号
     * @param int $intent_id 意向编号
     * @param int $type 发布者角色
     * @param int $page 第几页
     * @param int $size 每页几条
     * @param bool $count 是否统计总条数
     * @return mixed 
     */
    public function get_intent_jobs($user_id, $intent_id, $type, $page, $size, $count = false) {
        if (!var_validation($user_id, VAR_ID) || !var_validation($intent_id, VAR_ID) || !var_validation($type, VAR_ID)) {
            return null;
        }
        $resumeService = new ResumeService();
        $intent = $resumeService->getJobIntent($intent_id);                     //获取用户求职意向
        if (empty($intent) || empty($intent['job_province_code']) || empty($intent['job_city_code']) || $intent['job_salary'] === null || empty($intent['job_name'])) {
            return null;                                                        //求职意向不存在或者未填写完整，无法进行意向推送
        }
        $positions = explode(',', $intent['job_name']);
        $position_array = array();
        foreach ($positions as $position) {                                       //循环检测用户的求职岗位
            $info = $this->provider->get_position($position);                   //获取求职岗位详细信息
            if (empty($info)) {
                continue;
            }
            array_push($position_array, $info['id']);                           //将岗位编号增加到岗位数组中
            if ($info['parent_id'] == 0) {                                        //若该岗位属于岗位大类，则将其下的所有小分类增加到岗位数组中
                $children = $this->provider->get_positions($info['id']);
                foreach ($children as $child)
                    array_push($position_array, $child['id']);
            }
        }
        $position_array = array_unique($position_array);                        //将岗位数组中的重复值去掉
        if (empty($position_array)) {
            return null;
        }
        $data = $this->provider->get_intent_jobs($user_id, $position_array, $intent['job_salary'], $intent['job_province_code'], $intent['job_city_code'], $type, $page, $size, $count);
        if (!$count) {
            $userService = new UserService();
            foreach ($data as $key => $item) {                                    //返回数据中增加职位发布人的信息
                $user = $userService->get_user($item['publisher_id']);
                $data[$key] = array_merge($data[$key], $user);
            }
        }
        return $data;
    }

    /**
     * 验证求职意向是否完整
     * @param int $intent_id 求职意向编号
     * @return bool 
     */
    public function check_intent_full($intent_id) {
        $resumeService = new ResumeService();
        $intent = $resumeService->getJobIntent($intent_id);
        if (empty($intent) || empty($intent['job_province_code']) || empty($intent['job_city_code']) || empty($intent['job_salary']) || empty($intent['job_name'])) {
            return false;
        }
        return true;
    }

    /**
     * 是否存在委托职位关系
     * @param int $job_id 职位编号
     * @param int $agent_id 委托人编号
     * @return bool
     */
    public function exists_delegate_job($job_id, $agent_id) {
        return $this->provider->exists_delegate_job($job_id, $agent_id);
    }

    /**
     * 统计用户公开的职位数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_open_jobs($user_id, $start, $end) {
        return $this->provider->count_user_open_jobs($user_id, $start, $end);
    }

    /**
     * 统计用户代理的职位数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_delegate_jobs($user_id, $start, $end) {
        return $this->provider->count_user_delegate_jobs($user_id, $start, $end);
    }

    //------------protected-------------
    /**
     * 检测指定用户对指定职位的操作权限
     * @param <int> $job_id  职位编号
     * @param <int> $user_id 操作者用户编号
     * @param <int> $type    操作类型（1当前职位的基本操作所有权,2代理3终止代理）
     * @param <int> $ac_id   接受者用户编号
     * @param <array> $job   职位信息
     * @return <bool> 失败返回ZERROR
     */
    protected function check_job_do_permission($job_id, $user_id, $type, $ac_id = null, &$job = null) {
        $job = $this->provider->getJob($job_id);
        if (empty($job)) {
            return E(ErrorMessage::$JOB_NOT_EXISTS);
        }
        if ($type == 1) {
            if ($job['status'] == 3) {
                return E(ErrorMessage::$JOB_HAS_CLOSED);
            }
            if ($job['agent_id'] == 0 && $job['creator_id'] == $user_id) {
                return true;
            } else if ($job['agent_id'] != 0 && $job['agent_id'] == $user_id) {
                return true;
            } else {
                return E(ErrorMessage::$JOB_PUB_NO_PERMISSION);
            }
        } else if ($type == 2) {
            if ($job['creator_id'] != $user_id) {
                return E(ErrorMessage::$JOB_ENT_NO_PERMISSION);
            }
            if ($job['agent_id'] != 0) {
                return E(ErrorMessage::$JOB_OPERATE_NO_PERMISSION);
            }
            if ($job['status'] == 3) {
                return E(ErrorMessage::$JOB_HAS_CLOSED);
            }
            $provider = new UserProvider();
            if ($provider->get_role_by_id($ac_id) != C('ROLE_AGENT')) {
                return E(ErrorMessage::$OTHER_NO_PERMISSION_ACCEPT);
            }
            return true;
        } else if ($type == 3) {
            if ($job['creator_id'] != $user_id) {
                return E(ErrorMessage::$JOB_ENT_NO_PERMISSION);
            }
            if ($job['agent_id'] == 0) {
                return E(ErrorMessage::$JOB_NOT_AGENTED);
            }
            if ($job['status'] == 3) {
                return E(ErrorMessage::$JOB_HAS_CLOSED);
            }
            return true;
        }
    }

    /**
     * 获取浏览过的职位
     * @param int $reader_id 浏览者编号
     * @param int $page       第几页
     * @param int $size       每页条数
     * @param bool $count     是否返回条数
     * @return mixed 
     */
    public function getReadJob($reader_id, $page, $size, $count) {
        $jobProvider = new JobProvider();
        return $jobProvider->getReadJob($reader_id, $page, $size, $count);
    }

    /**
     * 添加职位索引
     * @param int $job_id 职位ID
     * @param int $require_place 地区要求省份ID 
     * @param int $salary 薪资待遇
     * @param date $pub_date 发布日期
     * @param int $read_count 阅读数
     * @param int $cert_type 证书类型（1-资质证书，2-职称证书）
     * @param string $word 全文搜索关键词
     * @param int $salary_sort 薪资排序
     */
    private function addJobIndexInternal($job_id, $require_place, $salary, $pub_date, $read_count, $cert_type, $word, $salary_sort) {
        $data = array(
            'job_id' => $job_id,
            'require_place' => $require_place,
            'salary' => $salary,
            'pub_date' => $pub_date,
            'read_count' => $read_count,
            'cert_type' => $cert_type,
            'word' => $word,
            'salary_sort' => $salary_sort
        );
        $jobProvider = new JobProvider();
        $jobProvider->addJobIndex($data);
    }

    /**
     * 添加职位索引
     * @param array $job 职位
     */
    public function addJobIndex($job) {
        //分隔地区要求
        if ($job['job_category'] == 1) {
            $rp_array = array($job['job_province_code']);
        } else {
            $rp_array = explode(',', $job['require_place']);
        }
        //薪资格式化
        $salary = salary_convert($job['job_salary'], $job['input_salary']);
        $salary_sort = salary_sort_convert($job['job_salary'], $job['input_salary']);
        //浏览数
        $jobProvider = new JobProvider();
        $read_count = $jobProvider->countJobRead($job['job_id']);
        //证书类型
        $csvc = new CertificateService();
        $certs = $csvc->getRegisterCertificateListByJob($job['job_id']);
        if (!empty($certs)) {
            $cert_type = 1;
        } else {
            $cert_type = 2;
        }
        $word_array = $this->buildJobWord($job);
        foreach ($rp_array as $rp) {
            foreach ($word_array as $word) {
                $this->addJobIndexInternal($job['job_id'], $rp, $salary, $job['pub_datetime'], $read_count, $cert_type, $word, $salary_sort);
            }
        }
    }

    /**
     * 生成职位全文搜索关键词
     * @param array $job 职位
     * @return array 
     */
    private function buildJobWord($job) {
        $word_array = array();
        //工作性质
        if ($job['job_category'] == 1) {
            $word = '全职';
        } else {
            $word = '兼职';
        }
        //职位名称
        $word.=$job['title'];

        $csvc = new CertificateService();
        $certs = $csvc->getRegisterCertificateListByJob($job['job_id']);        //证书信息
        if (!empty($job['grade_certificate_id'])) {
            $gcert = $csvc->get_grade_certificate($job['grade_certificate_id']);
        }

        //职称证书
        if (!empty($job['grade_certificate_id'])) {
            $word.= GC_C_format($job['grade_certificate_class']) . $gcert['grade_certificate_type'] . $gcert['major'];
        }

        $profileService = new ProfileService();
        //工作地点或证书使用地
        $province = $profileService->get_province($job['job_province_code']);
        $word.=$province['name'];
        //地区要求
        if (!empty($job['require_place'])) {
            $pids = explode(',', $job['require_place']);
            foreach ($pids as $pid) {
                $pro = $profileService->get_province($pid);
                if (!empty($pro))
                    $word .= $pro['name'];
            }
        }
        //发布角色
        if ($job['publisher_role'] == 2) {
            $word.='企业';
        } else {
            $word.='猎头';
        }

        //资质证书
        if (!empty($certs)) {
            foreach ($certs as $key => $cert) {
                $temp = $cert['register_certificate_name'];
                if (!empty($cert['register_certificate_major']))
                    $temp .= $cert['register_certificate_major'];
                switch ($cert['status']) {
                    case 1 : $temp .= '初始注册';
                        break;
                    case 2 : $temp .= '变更注册';
                        break;
                    case 3 : $temp .= '重新注册';
                        break;
                }
                if ($cert['count'] > 0)
                    $temp .= $cert['count'] . '人';
                $word_array[$key] = ch_word_segment($word . $temp);
            }
        }else {
            $word_array[0] = ch_word_segment($word);
        }

        return $word_array;
    }

    /**
     * 导入职位索引数据（导入前需要清空职位索引表） 
     */
    public function importJobIndex() {
        $jobProvider = new JobProvider();
        $i = 1;
        while (true) {
            $job_list = $jobProvider->getPubJobList($i, 10);
            if (empty($job_list)) {
                break;
            } else {
                foreach ($job_list as $job) {
                    if (!$jobProvider->existJobIndex($job['job_id'])) {
                        $this->addJobIndex($job);
                    }
                }
            }
            $i++;
        }
    }

    /**
     * 搜索职位
     * @param int $require_place
     * @param int $salary
     * @param int $pub_date
     * @param int $cert_type
     * @param string $word 
     */
    public function searchJob($require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, $publisher_role, $page, $size, $count, $order) {
        $jobProvider = new JobProvider();
        if (!empty($require_place)) {
            $require_place = intval($require_place);
        }
        if (!empty($salary)) {
            $salary = intval($salary);
        }
        if (!empty($pub_date)) {
            $pub_date = intval($pub_date);
        }
        if (!empty($cert_type)) {
            $cert_type = intval($cert_type);
        }
        if (!empty($word)) {
            //热门关键词统计
            $word = preg_replace('/[a-z0-9A-Z_]/', '', $word);
            $this->addJobSearchHot($word);
            $word = ch_word_segment($word);
        }
        if (!empty($is_real_auth)) {
            $is_real_auth = intval($is_real_auth);
        }
        if (!empty($order)) {
            $order = intval($order);
        }
        $field = array(
            'job.creator_id', 'job.job_id', 'job.job_category', 'job.company_name', 'job.title as job_title',
            'publisher.is_email_auth', 'publisher.is_phone_auth', 'publisher.is_real_auth',
            'job.publisher_id', 'job.publisher_role', 'publisher.name', 'publisher.photo', 'job.degree', 'job.job_city_code',
            'job.count', 'job.job_name', 'job.job_province_code', 'job.require_place', 'job.job_salary', 'job.salary_unit'
            , 'job.pub_datetime', 'job.input_salary'
        );
        return $jobProvider->getJobIndexList($field, $require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, $publisher_role, $page, $size, $count, $order);
    }

    /**
     * 添加职位搜索关键词统计
     * @param string $word 
     */
    private function addJobSearchHot($word) {
        $keyword_array = explode(' ', $word);
        if (count($keyword_array) > 10) {
            //搜索关键词太长，切割数组
            $keyword_array = array_slice($keyword_array, 0, 10);
        }
        foreach ($keyword_array as $value) {
            if (strlen($value) > 30) {
                //关键词太长，截取关键词
                $value = substr($value, 0, 30);
            }

            $this->updateJobSearchHot($value);
        }
    }

    /**
     * 更新职位搜索关键词统计
     * @param string $keyword 
     */
    private function updateJobSearchHot($keyword) {
        $jobProvider = new JobProvider();
        $result = $jobProvider->getJobSearchHot($keyword);
        if (empty($result)) {
            $jobProvider->addJobSearchHot($keyword);
        } else {
            $jobProvider->updateJobSearchHot($result['id'], intval($result['count']) + 1);
        }
    }

    /**
     * 获取热门关键词
     * @return string 
     */
    public function getSearchHotKeyword() {
        $jobProvider = new JobProvider();
        return $jobProvider->getSearchHotKeyword();
    }

}

?>
