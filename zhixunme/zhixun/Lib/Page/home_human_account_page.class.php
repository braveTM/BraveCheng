<?php
/**
 * Description of home_human_account_page
 *
 * @author moi
 */
class home_human_account_page {
    /**
     * 获取人才信息
     */
    public static function get_profile(){
        $service = new HumanService();
        $data = $service->get_human(AccountInfo::get_data_id());
        $user = P();
        $data = array_merge($user, $data);
        return FactoryVMap::array_to_model($data, 'home_human_profile');
    }

    /**
     * 计算资料完善度
     * @param <HOME_HUMAN_PROFILE_MODEL> $profile
     * @return <int>
     */
    public static function calculations_sophistication($profile){
        $sophistication = 0;
        if(!empty($profile->name))
            $sophistication++;
        if($profile->gender !== null)
            $sophistication++;
        if(!empty($profile->birth))
            $sophistication++;
        if(!empty($profile->province))
            $sophistication++;
        if(!empty($profile->city))
            $sophistication++;
        if(!empty($profile->phone))
            $sophistication++;
        if(!empty($profile->email))
            $sophistication++;
        if(!empty($profile->qq))
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
     * 获取人才左侧栏数据
     */
    public static function get_left(){
        $date = date_f('Y-m-d');
        $resume_id = AccountInfo::get_resume_id();
        $service = new ResumeService();
        $array['invite_count'] = $service->count_resume_invite($resume_id, $date);
        $array['resume_complete']=$service->getResumeComplete($resume_id);
        $array['HCresume_complete']=$service->getHCresumeComplete($resume_id);
        return FactoryVMap::array_to_model($array, 'home_human_left');
    }
}
?>
