<?php
/**
 * Description of home_human_detail_page
 *
 * @author moi
 */
class home_human_detail_page {
    /**
     * 获取人才信息
     * @param int $user_id 用户编号
     * @return mixed 
     */
    public static function get_human_info($user_id){
        $service = new UserService();
        $user = $service->get_user($user_id);                                   //用户信息
        if(empty($user) || $user['is_freeze'] == 1 || $user['role_id'] != C('ROLE_TALENTS')){              //指定人才不存在
            return null;
        }
        $activity = $service->get_user_activity($user_id);                      //用户活跃度
        $service = new HumanService();
        $human = $service->get_human($user['data_id']);                          //人才基本资料
        $data = array_merge($user, $human);
        $service = new CertificateService();
        $certs = $service->getRegisterCertificateListByHuman($user['data_id']); //注册证书
        $gcert = $service->getGradeCertificateListByHuman($user['data_id']);    //职称证书
        $service = new ResumeService();
        $rcount = $service->count_resume_read($human['resume_id']);             //简历被阅读次数
        $data = array_merge($user, $human);
        $resume=$service->get_resume($human['resume_id']);
        $data=  array_merge($data,$resume);
        $data['_certs'] = $certs;
        $data['_gcert'] = $gcert[0];
        $data['_rcount'] = $rcount;
        $data['_active'] = $activity;
        return FactoryVMap::array_to_model($data, 'home_human_detail');
    }

    /**
     * 获取简历状态
     * @param int $resume_id 简历编号
     * @param int $job_intent_id 全职意向编号
     * @param int $hang_card_id 挂证意向编号
     * @param int $category 工作性质
     * @return mixed 
     */
    public static function get_resume_status($resume_id, $job_intent_id, $hang_card_id, $category){
        $service = new ResumeService();
        $jii = $service->getJobIntent($job_intent_id);
        $hci = $service->getHCintentByHCID($hang_card_id);
        $array['fsp'] = $service->getResumeComplete($resume_id);
        $array['psp'] = $service->getHCresumeComplete($resume_id);
        $array['fsa'] = $jii['job_salary'];
        $array['psa'] = $hci['job_salary'];
        $array['fst'] = $category == 1 ? 1 : 0;
        $array['pst'] = $category == 2 ? 1 : 0;
        $array['view'] = $service->count_resume_read($resume_id);
        return FactoryVMap::array_to_model($array, 'home_resume_status');
    }

    /**
     * 获取投递过的企业
     * @param int $user_id 用户编号
     * @return mixed 
     */
    public static function get_send_company($user_id){
        $service = new JobService();
        $data = $service->get_send_company($user_id, 1, 5, false);
        return FactoryVMap::list_to_models($data, 'home_user_base');
    }
}

?>
