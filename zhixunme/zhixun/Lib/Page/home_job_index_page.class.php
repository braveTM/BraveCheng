<?php

/**
 * Description of home_job_index_page
 *
 * @author moi
 */
class home_job_index_page {

    /**
     * 获取指定职位下的简历列表
     * @param  <int> $job_id 职位编号
     * @param  <int> $role 投递者角色编号
     * @param  <int> $page   第几页
     * @return <mixed>
     */
    public static function get_job_resume_list($job_id, $role, $page) {
        $service = new ResumeService();
        $data = $service->getReceiveResumeByJob(AccountInfo::get_user_id(), $job_id, $role, $page, C('SIZE_JOB_RESUME'), false);
        $service = new ContactsService();
        $jservice = new JobService();
        foreach ($data as $key => $value) {
            $data[$key]['follow'] = $service->exists_user_follow(AccountInfo::get_user_id(), $value['sender_id']);
            $data[$key]['job_name'] = $jservice->get_job_position($value['job_name']);
        }
        return FactoryVMap::list_to_models($data, 'home_resume_job');
    }

    /**
     * 获取指定职位下的简历数量
     * @param  <int> $job_id 获取指定职位下的简历列表
     * @param  <int> $role 投递者角色编号
     * @return <int> 数量
     */
    public static function get_job_resume_count($job_id, $role) {
        $service = new ResumeService();
        $count = $service->getReceiveResumeByJob(AccountInfo::get_user_id(), $job_id, $role, null, null, true);
        return $count;
    }

    /**
     * 获取发布的职位列表
     * @param  <int> $type   工作性质
     * @param  <int> $status 职位状态
     * @param  <int> $page   第几页
     * @return <mixed>
     */
    public static function get_pub_job_list($type, $status, $page, $size) {
        switch ($type) {
            case 1 :
            case 2 : break;
            default : $type = null;
        }
        switch ($status) {
            case 1 : $status = 2;
                break;
            case 2 : $status = 3;
                break;
            case 4 : break;
            default : $status = null;
        }
        $user_id = AccountInfo::get_user_id();
        $service = new JobService();
        $list = $service->get_pub_jobs($user_id, $type, $status, $page, $size);
        $date = date_f();
        $pservice = new PromoteService();
        foreach ($list as $key => $value) {
            $list[$key]['job_name'] = $service->get_job_position($value['job_name']);
            $count = $pservice->count_job_promote_record($user_id, $value['job_id'], null, null, $date);
            if ($count > 0)
                $list[$key]['_promote'] = 1;
            else
                $list[$key]['_promote'] = 0;
        }
        return FactoryVMap::list_to_models($list, 'home_job_list');
    }

    /**
     * 获取发布的职位列表数量
     * @param  <int> $type   工作性质
     * @param  <int> $status 职位状态
     * @return <int>
     */
    public static function get_pub_job_count($type, $status) {
        switch ($type) {
            case 1 :
            case 2 : break;
            default : $type = null;
        }
        switch ($status) {
            case 1 : $status = 2;
                break;
            case 2 : $status = 3;
                break;
            case 4 : break;
            default : $status = null;
        }
        $service = new JobService();
        return $service->get_pub_jobs(AccountInfo::get_user_id(), $type, $status, null, null, true);
    }

    /**
     * 获取未处理的职位列表
     * @param  <int> $type   工作性质
     * @param  <int> $page   第几页
     * @return <mixed>
     */
    public static function get_wcl_job_list($type, $page, $size) {
        switch ($type) {
            case 1 :
            case 2 : break;
            default : $type = null;
        }
        $service = new JobService();
        $list = $service->get_pub_jobs(AccountInfo::get_user_id(), $type, 1, $page, $size, false, false, true);
        foreach ($list as $key => $value) {
            $list[$key]['job_name'] = $service->get_job_position($value['job_name']);
        }
        return FactoryVMap::list_to_models($list, 'home_job_list');
    }

    /**
     * 获取未处理的职位列表数量
     * @param  <int> $type   工作性质
     * @param  <int> $status 职位状态
     * @return <int>
     */
    public static function get_wcl_job_count($type) {
        switch ($type) {
            case 1 :
            case 2 : break;
            default : $type = null;
        }
        $service = new JobService();
        return $service->get_pub_jobs(AccountInfo::get_user_id(), $type, 1, null, null, true);
    }

    /**
     * 获取可委托的职位列表
     * @return <mixed>
     */
    public static function get_cd_job_list() {
        $service = new JobService();
        $list = $service->get_pub_jobs(AccountInfo::get_user_id(), null, 1, 1, C('SIZE_JOBS_SIMPLE'), false, true);
        return FactoryVMap::list_to_models($list, 'home_job_simple');
    }

    /**
     * 获取可邀请简历的职位列表
     * @return <mixed>
     */
    public static function get_ci_job_list() {
        $service = new JobService();
        $list = $service->get_pub_jobs(AccountInfo::get_user_id(), null, 2, 1, C('SIZE_JOBS_SIMPLE'), false, true);
        return FactoryVMap::list_to_models($list, 'home_job_simple');
    }

    /**
     * 获取委托的职位列表
     * @param  <int> $type   工作性质
     * @param  <int> $status 职位状态
     * @param  <int> $page   第几页
     * @return <mixed>
     */
    public static function get_agent_job_list($type, $status, $page) {
        switch ($type) {
            case 1 :
            case 2 : break;
            default : $type = null;
        }
        switch ($status) {
            case 1 :
            case 2 : break;
            default : $status = null;
        }
        $service = new JobService();
        $list = $service->getDelegatedJob(AccountInfo::get_user_id(), $type, $status, $page, C('SIZE_JOBS'));
        foreach ($list as $key => $value) {
            $list[$key]['job_name'] = $service->get_job_position($value['job_name']);
        }
        return FactoryVMap::list_to_models($list, 'home_job_list');
    }

    /**
     * 获取委托的职位列表总条数
     * @param  <int> $type   工作性质
     * @param  <int> $status 职位状态
     * @return <mixed>
     */
    public static function get_agent_job_count($type, $status) {
        switch ($type) {
            case 1 :
            case 2 : break;
            default : $type = null;
        }
        switch ($status) {
            case 1 :
            case 2 : break;
            default : $status = null;
        }
        $service = new JobService();
        return $service->getDelegatedJob(AccountInfo::get_user_id(), $type, $status, null, null, true);
    }

    /**
     * 查看应聘过的职位
     * @param <int>  $sender_id 投递人ID
     * @param <int> $role_id 投递人角色
     * @param <int> $job_category 工作性质（1为全职，2为兼职）
     * @param <int> $publisher_role 发布人角色
     * @param <int> $register_case 注册情况
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $resume_id 简历ID 
     * @return <mixed>
     */
    public static function getSentJob($sender, $role, $job_category, $publisher_role, $register_case, $page, $size, $resume_id) {
        $jobService = new JobService();
        $job_list = $jobService->getSentJob($sender, $role, $job_category, $publisher_role, $register_case, false, $page, $size, $resume_id);
        $certificateService = new CertificateService();
        foreach ($job_list as $key => $job) {
            $job_id = $job['job_id'];
            $job_list[$key]['job_certificate_list'] = $certificateService->getRegisterCertificateListByJob($job_id);
            $job_list[$key]['job_name'] = $jobService->get_job_position($job['job_name']);
        }
        return FactoryVMap::list_to_models($job_list, 'home_job_sent');
    }

    /**
     * 查看应聘过的职位的总条数
     * @param <int>  $sender_id 投递人ID
     * @param <int> $role_id 投递人角色
     * @param <int> $job_category 工作性质（1为全职，2为兼职）
     * @param <int> $publisher_role 发布人角色
     * @param <int> $register_case 注册情况
     * @param <int> $resume_id  简历ID
     * @return <int>
     */
    public static function getSentJobCount($sender, $role, $job_category, $publisher_role, $register_case, $resume_id) {
        $jobService = new JobService();
        $job_list_count = $jobService->getSentJob($sender, $role, $job_category, $publisher_role, $register_case, true, null, null, $resume_id);
        return $job_list_count;
    }

    /**
     * 获取收到委托的职位列表
     * @param  <int> $type   工作性质
     * @param  <int> $status 职位状态
     * @param  <int> $page   第几页
     * @return <mixed>
     */
    public static function get_agented_job_list($type, $status, $page) {
        switch ($type) {
            case 1 :
            case 2 : break;
            default : $type = null;
        }
        switch ($status) {
            case 1 :
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 : break;
            default : $status = null;
        }
        $jservice = new JobService();
        $list = $jservice->get_agented_jobs(AccountInfo::get_user_id(), $type, $status, $page, C('SIZE_JOBS'));
        $service = new ContactsService();
        $date = date_f();
        $pservice = new PromoteService();
        $user_id = AccountInfo::get_user_id();
        foreach ($list as $key => $value) {
            $list[$key]['job_name'] = $jservice->get_job_position($value['job_name']);
            $list[$key]['follow'] = $service->exists_user_follow($user_id, $value['creator_id']);
            $count = $pservice->count_job_promote_record($user_id, $value['job_id'], null, null, $date);
            if ($count > 0)
                $list[$key]['_promote'] = 1;
            else
                $list[$key]['_promote'] = 0;
        }
        return FactoryVMap::list_to_models($list, 'home_job_agented');
    }

    /**
     * 获取收到委托的职位列表条数
     * @param  <int> $type   工作性质
     * @param  <int> $status 职位状态
     * @return <mixed>
     */
    public static function get_agented_job_count($type, $status) {
        switch ($type) {
            case 1 :
            case 2 : break;
            default : $type = null;
        }
        switch ($status) {
            case 1 :
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 : break;
            default : $status = null;
        }
        $service = new JobService();
        return $service->get_agented_jobs(AccountInfo::get_user_id(), $type, $status, null, null, true);
    }

    /**
     * 获取职位详细信息
     * @param  <int>  $job_id 职位编号
     * @param  <bool> $self   是否本人
     * @return <mixed>
     */
    public static function get_job_detail($job_id, &$self, &$contact) {
        $jsvc = new JobService();
        $job = $jsvc->get_job($job_id);
        if (empty($job)) {
            return null;
        }
        $user_id = AccountInfo::get_user_id();
        $self = false;
        if ($job['publisher_id'] != 0) {
            if ($job['publisher_id'] == $user_id) {
                $self = true;
            }
        } else {
            if ($job['agent_id'] != 0 && $job['agent_id'] == $user_id) {
                $self = true;
            } else if ($job['agent_id'] == 0 && $job['creator_id'] == $user_id) {
                $self = true;
            }
        }
        if ($job['publisher_id'] == 0 && !$self)                                 //未发布时,非本人不能查看
            return null;
        $csvc = new CertificateService();
        $job['certs'] = $csvc->getRegisterCertificateListByJob($job_id);        //证书信息
        if (!empty($job['grade_certificate_id'])) {
            $job['gcert'] = $csvc->get_grade_certificate($job['grade_certificate_id']);
        }
        $usvc = new UserService();
        if (!$self) {                                                             //非本人
            $jsvc->read_job($job_id, $user_id);                                 //增加查看职位记录
            $user = $usvc->get_user($job['publisher_id']);                      //发布人信息
            if ($job['agent_id'] != 0) {                                          //有代理
                $asvc = new MiddleManService();
                $agent = $asvc->get_agent($user['data_id']);                    //代理人信息
                $job['agent_model'] = FactoryVMap::array_to_model(array_merge($user, $agent), 'home_agent_detail');
            } else {
                $job['pub_model'] = FactoryVMap::array_to_model($user, 'home_user_base');
            }
            $service = new ContactsService();
            $job['follow'] = $service->exists_user_follow($user_id, $job['publisher_id']) ? 1 : 0;
            $contact = $usvc->get_has_read_contact($user_id, $job['publisher_id'], $job_id, 2);
        } else {
            if (!empty($job['agent_id'])) {
                $contact = $usvc->get_has_read_contact($user_id, $job['creator_id'], $job_id, 2);
            }
        }
        $job['job_name'] = $jsvc->get_job_position($job['job_name']);
        $jobOperatePovider = new JobOperateProvider();
        $job['read_count'] = $jobOperatePovider->getReadJobCount($job_id);
        return FactoryVMap::array_to_model($job, 'home_job_detail');
    }

    /**
     * 获取求职意向匹配职位列表
     * @param int $user_id 匹配用户编号
     * @param int $intent_id 意向编号
     * @param int $type 发布者角色
     * @param int $page 第几页
     * @param int $size 每页几条
     * @return array 
     */
    public static function get_intent_jobs($user_id, $intent_id, $type, $page, $size) {
        $jobService = new JobService();
        $list = $jobService->get_intent_jobs($user_id, $intent_id, $type, $page, $size);
        $contactsService = new ContactsService();
        foreach ($list as $key => $value) {
            $list[$key]['job_name'] = $jobService->get_job_position($value['job_name']);
            $list[$key]['follow'] = $contactsService->exists_user_follow($user_id, $value['publisher_id']);
        }
        return FactoryVMap::list_to_models($list, 'home_recommend_job');
    }

    /**
     * 获取求职意向匹配职位总条数
     * @param int $user_id 匹配用户编号
     * @param int $intent_id 意向编号
     * @param int $type 发布者角色
     * @return int 
     */
    public static function get_intent_jobs_count($user_id, $intent_id, $type) {
        $service = new JobService();
        return $service->get_intent_jobs($user_id, $intent_id, $type, 1, 1, true);
    }

    /**
     * 获取浏览过的职位
     * @param int $reader_id 浏览者编号
     * @param int $page       第几页
     * @param int $size       每页条数
     * @param bool $count     是否返回条数
     * @return mixed 
     */
    public static function getReadJob($reader_id, $page, $size) {
        $jobService = new JobService();
        $readJobList = $jobService->getReadJob($reader_id, $page, $size, false);
        return FactoryVMap::list_to_models($readJobList, "home_job_read");
    }

    /**
     * 搜索职位
     * @param type $require_place
     * @param type $salary
     * @param type $pub_date
     * @param type $cert_type
     * @param type $word
     * @param type $is_real_auth
     * @param type $page
     * @param type $size
     * @param type $order
     * @return type 
     */
    public static function searchJob($require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, $publisher_role, $page, $size, $order) {
        $jobService = new JobService();
        $job_list = $jobService->searchJob($require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, $publisher_role, $page, $size, false, $order);
        $certificateService = new CertificateService();
        $service = new ContactsService();
        foreach ($job_list as $key => $job) {
            $job_id = $job['job_id'];
            $job_list[$key]['job_certificate_list'] = $certificateService->getRegisterCertificateListByJob($job_id);
            $job_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $job['publisher_id']);
            $job_list[$key]['job_name'] = $jobService->get_job_position($job['job_name']);
        }
        return FactoryVMap::list_to_models($job_list, 'home_recommend_job');
    }

    /**
     * 搜索的结果总条数
     * @param type $require_place
     * @param type $salary
     * @param type $pub_date
     * @param type $cert_type
     * @param type $word
     * @param type $is_real_auth
     * @param type $order
     * @return type 
     */
    public static function searchJobCount($require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, $publisher_role, $order) {
        $jobService = new JobService();
        return $jobService->searchJob($require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, $publisher_role, null, null, true, $order);
    }

}

?>
