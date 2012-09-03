<?php
/**
 * Description of home_company_account_page
 *
 * @author moi
 */
class home_company_account_page {
    /**
     * 获取企业资料
     */
    public static function get_profile(){
        $service = new CompanyService();
        $data = $service->get_company(AccountInfo::get_data_id());
        $user = P();
        $data = array_merge($user, $data);
        return FactoryVMap::array_to_model($data, 'home_company_profile');
    }

    /**
     * 获取企业详细信息
     * @param  <int> $user_id 用户编号
     * @return <mixed>
     */
    public static function get_company_detail($user_id){
        $service = new UserService();
        $user = $service->get_user($user_id);
        if(empty($user) || $user['is_freeze'] == 1 || $user['role_id'] != C('ROLE_ENTERPRISE')){
            return null;
        }
        $svc = new CompanyService();
        $company = $svc->get_company($user['data_id']);
        $array = array_merge($user, $company);
        $service = new ContactsService();
        $array['follow'] = $service->exists_user_follow(AccountInfo::get_user_id(), $user_id) ? 1 : 0;
        return FactoryVMap::array_to_model($array, 'home_company_detail');
    }
    
    /**
     * 获取发布的职位数
     * @param int $user_id 用户编号
     * @return int 
     */
    public static function get_job_count($user_id){
        $service = new JobService();
        return $service->get_pub_jobs($user_id, null, 2, 1, 1, true);
    }

    /**
     * 计算资料完善度
     * @param <HOME_COMPANY_PROFILE_MODEL> $profile
     * @return <int>
     */
    public static function calculations_sophistication($profile){
        $sophistication = 0;
        if(!empty($profile->name))
            $sophistication++;
        if(!empty($profile->category))
            $sophistication++;
        if(!empty($profile->province))
            $sophistication++;
        if(!empty($profile->city))
            $sophistication++;
        if(!empty($profile->cname))
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
        return round($sophistication / 13, 2) * 100;
    }

    /**
     * 获取经纪人左侧栏数据
     */
    public static function get_left(){
        $date = date_f('Y-m-d');
        $user_id = AccountInfo::get_user_id();
        $service = new JobService();
        $array['receive_count'] = $service->count_resume_send($user_id, $date);
        $service = new TaskService();
        $array['task_count'] = $service->get_task_list(null, null, 1, $date, null, null, null, null, true, null, $user_id);
        $service = new DelegateService();
        $array['delegate_count'] = $service->get_delegates($user_id, null, 2, null, null, null, null, null, true, $date);
        return FactoryVMap::array_to_model($array, 'home_company_left');
    }
}
?>
