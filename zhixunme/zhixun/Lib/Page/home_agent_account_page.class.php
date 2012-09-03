<?php
/**
 * Description of home_agent_count_page
 *
 * @author moi
 */
class home_agent_account_page {
    /**
     * 获取当前用户基本资料
     */
    public static function get_profile(){
        $service = new MiddleManService();
        $data = $service->get_agent(AccountInfo::get_data_id());
        $user = P();
        $data = array_merge($user, $data);
        return FactoryVMap::array_to_model($data, 'home_agent_profile');
    }
    
    /**
     * 获取猎头统计数据 
     */
    public static function get_statistics(){
        $user = P();
        $stat['view'] = $user['view'];
        $stat['praise'] = $user['praise'];
        $stat['score'] = $user['total_experience'];
        return FactoryVMap::array_to_model($stat, 'home_agent_statistics');
    }

    /**
     * 获取经纪人列表
     * @param  <int> $type     类型
     * @param  <int> $svc      经纪人服务
     * @param  <int> $province 省份编号
     * @param  <int> $city     城市编号
     * @param  <int> $page     第几页
     * @return <mixed>
     */
    public static function get_agent_list($type, $svc, $province, $city, $page){
        $service = new MiddleManService();
        $result  = $service->get_agent_list($type, $svc, $province, $city, $page, $size, $count);
        if(empty($result))
            return null;
        foreach ($result as $key => $item) {
            $result[$key]['_service'] = $service->get_agent_services($item['agent_id']);
        }
        return FactoryVMap::list_to_models($result, 'home_agent_profile');
    }


    /**
     * 获取经纪人服务类别列表
     * @return <mixed>
     */
    public static function get_service_category(){
        $service = new MiddleManService();
        $list = $service->get_service_category();
        return FactoryVMap::list_to_models($list, 'home_agent_type');
    }

    /**
     * 获取经纪人详细信息
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public static function get_agent_detail($user_id){
        $service = new UserService();
        $user = $service->get_user($user_id);
        if(empty($user) || $user['is_freeze'] == 1 || $user['role_id'] != C('ROLE_AGENT')){
            return null;
        }
        $svc   = new MiddleManService();
        $agent = $svc->get_agent($user['data_id']);
        $array = array_merge($user, $agent);
        $service = new ContactsService();
        $array['follow'] = $service->exists_user_follow(AccountInfo::get_user_id(), $user_id) ? 1 : 0;
        return FactoryVMap::array_to_model($array, 'home_agent_detail');
    }

    /**
     * 计算资料完善度
     * @param <HOME_AGENT_PROFILE_MODEL> $profile
     * @return <int>
     */
    public static function calculations_sophistication($profile){
        $sophistication = 0;
        if(!empty($profile->name))
            $sophistication++;
        if(!empty($profile->province))
            $sophistication++;
        if(!empty($profile->city))
            $sophistication++;
        if(!empty($profile->company))
            $sophistication++;
        if(!empty($profile->phone))
            $sophistication++;
        if(!empty($profile->email))
            $sophistication++;
        if(!empty($profile->qq))
            $sophistication++;
        if(!empty($profile->summary))
            $sophistication++;
        if(!empty($profile->photo))
            $sophistication++;
        if(!empty($profile->real_auth))
            $sophistication++;
        if(!empty($profile->phone_auth))
            $sophistication++;
        if(!empty($profile->email_auth))
            $sophistication++;
        return round($sophistication / 12, 2) * 100;
    }

    /**
     * 获取经纪人左侧栏数据
     */
    public static function get_left(){
        $date = date_f('Y-m-d');
        $user_id = AccountInfo::get_user_id();
        $service = new ResumeService();
        $array['invite_count'] = $service->count_agent_resume_invite($user_id, $date);
        $service = new JobService();
        $array['receive_count'] = $service->count_resume_send($user_id, $date);
        $array['job_delegate'] = $service->count_agent_job($user_id, $date);
        $service = new TaskService();
        $array['task_count'] = $service->get_task_list(null, null, 1, $date, null, null, null, null, true, null, $user_id);
        $service = new DelegateService();
        $array['delegate_count'] = $service->get_delegates(null, $user_id, 2, null, null, null, null, null, true, $date);
        return FactoryVMap::array_to_model($array, 'home_agent_left');
    }
    
    /**
     * 获取正在运作的职位
     * @param int $user_id 发布人编号
     * @param int $type 职位类型
     * @param int $page 第几页
     * @param int $size 每页几条
     * @return array 
     */
    public static function get_running_job($user_id, $type, $page, $size){
        $service = new JobService();
        $list = $service->get_running_jobs($user_id, $type, $page, $size);
        $certService = new CertificateService();
        foreach($list as $key => $value){
            $list[$key]['certs'] = $certService->getRegisterCertificateListByJob($value['job_id']);
            $list[$key]['job_name'] = $service->get_job_position($value['job_name']);
        }
        return FactoryVMap::list_to_models($list, 'home_job_list');
    }
    
    /**
     * 获取正在运作的职位数
     * @param int $user_id 发布人编号
     * @param int $type 职位类型
     * @return int 
     */
    public static function get_running_job_count($user_id, $type){
        $service = new JobService();
        return $service->get_running_jobs($user_id, $type, 1, 1, true);
    }
    
    /**
     * 获取正在运作的简历
     * @param int $user_id 发布人编号
     * @param int $type 简历类型
     * @param int $page 第几页
     * @param int $size 每页几条
     * @return array 
     */
    public static function get_running_resume($user_id, $type, $page, $size){
        $service = new ResumeService();
        $list = $service->get_running_resumes($user_id, $type, $page, $size);
        $service = new CertificateService();
        $jobService = new JobService();
        foreach($list as $key => $item){
           $list[$key]['RC_list'] = $service->getRegisterCertificateListByHuman($item['human_id']);
           $list[$key]['job_name'] = $jobService->get_job_position($item['job_name']);
        }
        return FactoryVMap::list_to_models($list, 'home_resume_own');
    }
    
    /**
     * 获取正在运作的简历数
     * @param int $user_id 发布人编号
     * @param int $type 简历类型
     * @return int 
     */
    public static function get_running_resume_count($user_id, $type){
        $service = new ResumeService();
        return $service->get_running_resumes($user_id, $type, 1, 1, true);
    }

    /**
     * 获取最近服务的企业列表
     * @param <int> $agent_id 代理人ID
     * @param <datetime> $end_time 时间阈
     * @param <int> $page 第几页
     * @param <int> $size 每页几条
     * @return <mixed>
     */
    public static function getServiceCompanyList($agent_id,$end_time,$page,$size){
        $agentService=new MiddleManService();
        $company_list=$agentService->getServiceCompanyList($agent_id, $end_time, $page, $size, false);
        return FactoryVMap::list_to_models($company_list,"home_company_profile");
    }

    /**
     * 获取最近服务的企业列表总条数
     * @param <int> $agent_id 代理人ID
     * @param <int> $end_time  时间阈
     * @return <int>
     */
    public static function getServiceCompanyListCount($agent_id,$end_time){
        $agentService=new MiddleManService();
        $count=$agentService->getServiceCompanyList($agent_id, $end_time, null, null, true);
        return $count;
    }
}
?>
