<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_human_page
 *
 * @author JZG
 */
class home_human_profile_page {
    //put your code here

    /**
     * 获取全职简历
     * @param <int> $human_id 人才ID
     * @return <object>
     */
    public static function getResume($human_id){
        $humanService=new HumanService();
        $human=$humanService->get_human($human_id);
        if (empty($human)){
            return null;
        }
        $resume_id=$human['resume_id'];
        if (empty($resume_id)){
            return null;
        }
        $resumeService=new ResumeService();
        $resume=$resumeService->getResume($resume_id);
        if (empty($resume)){
            return null;
        }
        $jobService = new JobService();
        $resume['job_intent']['job_name_ids'] = $resume['job_intent']['job_name'];
        $resume['job_intent']['job_name'] = $jobService->get_job_position($resume['job_intent']['job_name']);
        $service = new UserService();
        $user = $service->get_user_by_data($human_id, C('ROLE_TALENTS'));
        $user_id = AccountInfo::get_user_id();
        if(AccountInfo::get_role_id() == C('ROLE_TALENTS')){
            if($human_id != AccountInfo::get_data_id()){
                $resumeService->read_resume($user_id, $resume_id);  //添加查看简历记录
            }
        }
        elseif(AccountInfo::get_role_id() == C('ROLE_AGENT')){
            if($resume['agent_id'] != $user_id){
                $resumeService->read_resume($user_id, $resume_id);  //添加查看简历记录
            }
        }
        else{
            $resumeService->read_resume($user_id, $resume_id);      //添加查看简历记录
        }
        $resume['resume_id']=$resume_id;
        if (empty($user)){
            $resume['human']=array_merge(array('user_id'=>0),$human);
        }else{
            $resume['human']=array_merge($user, $human);
        }
        $privacyService=new PrivacyService();
        $privacyService->replace('home_human_profile_model',$resume['human']);
        $resume['resume_status']=$resumeService->getResumeStatus($resume_id);
        $certificateService=new CertificateService();
        $registerCertificateList=$certificateService->getRegisterCertificateListByHuman($human_id);
        if (!empty ($registerCertificateList)){
            $resume['register_certificate_list']=$registerCertificateList;
        }
        $gradeCertificateList=$certificateService->getGradeCertificateListByHuman($human_id);
        if (!empty($gradeCertificateList)){
            $resume['grade_certificate_list']=$gradeCertificateList;
        }
        $jobOperatePovider = new JobOperateProvider();
        $resume['read_count'] = $jobOperatePovider->getReadJobCount($human_id);
        return FactoryVMap::array_to_model($resume,'home_human_resume');
    }

    /**
     * 获取兼职简历
     * @param <int> @human_id 用户ID
     * @return <object>
     */
    public static function getHCresume($human_id){
        $humanService=new HumanService();
        $human=$humanService->get_human($human_id);
        if (empty($human)){
            return null;
        }
        $resume_id=$human['resume_id'];
        if (empty($resume_id)){
            return null;
        }
        $resumeService=new ResumeService();
        $HC_resume=$resumeService->getHCintent($resume_id);
        if (empty($HC_resume)){
            return null;
        }
        $rinfo = $resumeService->get_resume($resume_id);
        $HC_resume['agent_id'] = $rinfo['agent_id'];
        if($human_id != AccountInfo::get_data_id()){
            $resumeService->read_resume(AccountInfo::get_user_id(), $resume_id);//添加查看简历记录
        }
        $service = new UserService();
        $user = $service->get_user_by_data($human_id, C('ROLE_TALENTS'));
        $HC_resume['resume_id']=$resume_id;
        if (empty($user)){
            $HC_resume['human']=array_merge(array('user_id'=>0),$human);
        }else{
            $HC_resume['human']=array_merge($user, $human);
        }
        $privacyService=new PrivacyService();
        $privacyService->replace('home_human_profile_model',$HC_resume['human']);
        $HC_resume['resume_status']=$resumeService->getResumeStatus($resume_id);
        $certificateService=new CertificateService();
        $registerCertificateList=$certificateService->getRegisterCertificateListByHuman($human_id);
        if (!empty ($registerCertificateList)){
            $HC_resume['register_certificate_list']=$registerCertificateList;
        }
        $gradeCertificateList=$certificateService->getGradeCertificateListByHuman($human_id);
        if (!empty($gradeCertificateList)){
            $HC_resume['grade_certificate_list']=$gradeCertificateList;
        }
        return FactoryVMap::array_to_model($HC_resume,'home_human_HC_resume');
    }

    /**
     * 获取委托来的简历的详细信息
     * @param <type> $delegate_resume_id
     */
    public static function getDelegatedResumeDetail($delegate_resume_id){
        $resumeService=new ResumeService();
        $resume_data=$resumeService->getDelegatedResumeDetail($delegate_resume_id);
        
        $jobService = new JobService();
        $resume_data['job_intent']['job_name_ids'] = $resume_data['job_intent']['job_name'];
        $resume_data['job_intent']['job_name'] = $jobService->get_job_position($resume_data['job_intent']['job_name']);
        //填充人才用户数据
        $service = new UserService();
        $user = $service->get_user_by_data($resume_data['human']['human_id'], C('ROLE_TALENTS'));
        if (empty($user)){
            $resume_data['human']=array_merge(array('user_id'=>0),$resume_data['human']);
        }else{
            $resume_data['human']=array_merge($user, $resume_data['human']);
        }

        //数据转换
        if ($resume_data['job_category'] == 1){
            $resume_data['register_certificate_list']=$resume_data['RC_list'];
            $resume_data['grade_certificate_list']=$resume_data['GC_list'];
            return FactoryVMap::array_to_model($resume_data,"home_human_resume");
        }else{
            $resume_data=array_merge($resume_data,$resume_data['hang_card_intent']);
            $resume_data['register_certificate_list']=$resume_data['RC_list'];
            $resume_data['grade_certificate_list']=$resume_data['GC_list'];
            return FactoryVMap::array_to_model($resume_data, 'home_human_HC_resume');
        }
    }

    /**
     * 获取应聘来的简历的详细信息
     * @param <type> $send_resume_id
     */
    public static function getSentResumeDetail($send_resume_id){
        $resumeService = new ResumeService();
        $resume_data = $resumeService->getSentResumeDetail($send_resume_id, $pub_id);
        if(empty($resume_data)){
            redirect(C('ERROR_PAGE'));                                          //数据不存在
        }
        if($pub_id != AccountInfo::get_user_id()){
            redirect(C('ERROR_PAGE'));                                          //无法查看非投递给自己的简历
        }
        $jobService = new JobService();
        $resume_data['job_intent']['job_name_ids'] = $resume_data['job_intent']['job_name'];
        $resume_data['job_intent']['job_name'] = $jobService->get_job_position($resume_data['job_intent']['job_name']);
        //填充人才用户数据
        $service = new UserService();
        $user = $service->get_user_by_data($resume_data['human']['human_id'], C('ROLE_TALENTS'));
        if (empty($user)) {
            $resume_data['human'] = array_merge(array('user_id' => 0), $resume_data['human']);
        } else {
            $resume_data['human'] = array_merge($user, $resume_data['human']);
        }
        //数据转换
        if ($resume_data['job_category'] == 1) {
            $resume_data['register_certificate_list'] = $resume_data['RC_list'];
            $resume_data['grade_certificate_list'] = $resume_data['GC_list'];
            return FactoryVMap::array_to_model($resume_data, "home_human_resume");
        } else {
            $resume_data = array_merge($resume_data, $resume_data['hang_card_intent']);
            $resume_data['register_certificate_list'] = $resume_data['RC_list'];
            $resume_data['grade_certificate_list'] = $resume_data['GC_list'];
            return FactoryVMap::array_to_model($resume_data, 'home_human_HC_resume');
        }
    }

    /**
     * 获取工作经历列表
     * @param <int> $resume_id 简历ID
     * @return <object>
     */
    public static function getWorkExpList($resume_id){
        $resumeService=new ResumeService();
        $workExpList=$resumeService->getWorkExpList($resume_id);
        return FactoryVMap::list_to_models($workExpList,'home_human_workExp');
    }

    /**
     * 获取工程业绩列表
     * @param <int> $resume_id 简历ID
     * @return <object>
     */
    public static function getProjectAchievementList($resume_id){
        $resumeService=new ResumeService();
        $PAlist=$resumeService->getProjectAchievementList($resume_id);
        return FactoryVMap::list_to_models($PAlist,'home_human_projectAchievement');
    }

    /**
     *  获取所有注册证书信息
     */
    public static function getAllRegisterCertificateInfo(){
        $certificateService=new CertificateService();
        $RClist=$certificateService->getAllRegisterCertificateInfo();
        return FactoryVMap::list_to_models($RClist,'home_human_RC_info');
    }

    /**
     * 根据注册证书信息ID和级别获取注册证书专业列表
     * @param <int> $RCI_id 注册证书信息ID
     * @param <int> $RC_class 级别（0为无级别之分）
     * @return <object>
     */
    public static function getRegisterCertificateMajorList($RCI_id,$RC_class){
        $certificateService=new CertificateService();
        $RCmajorList=$certificateService->getRegisterCertificateMajorList($RCI_id, $RC_class);
        return FactoryVMap::list_to_models($RCmajorList,'home_human_RC_major');
    }

    /**
     * 获取人才的注册证书列表
     * @param <int> $human_id 人才信息ID
     * @return <object>
     */
    public static function getRegisterCertificateListByHuman($human_id) {
        $certicateService=new CertificateService();
        $RCList=$certicateService->getRegisterCertificateListByHuman($human_id);
        return FactoryVMap::list_to_models($RCList,'home_human_register_certificate');
    }

    /**
     * 获取指定职称证书类型的职称证书列表
     * @param <int> $grade_certificate_type_id 职称证书类型ID
     * @return <object>
     */
    public static function getGradeCertificateList($grade_certificate_type_id){
        $certificateService=new CertificateService();
        $GClist=$certificateService->getGradeCertificateList($grade_certificate_type_id);
        return FactoryVMap::list_to_models($GClist,'home_human_GC_major');
    }

    /**
     * 获取所有职称证书类型
     * @return <mixed> 成功返回职称证书类型数组或空数组，失败返回false
     */
    public static function getAllGradeCertificateType(){
        $certificateService=new CertificateService();
        $GClist=$certificateService->getAllGradeCertificateType();
        return FactoryVMap::list_to_models($GClist,'home_human_GC_type');
    }

    /**
     * 获取人才的职称证书列表
     * @param <int> $human_id  人才信息ID
     * @return <mixed> 成功返回人才的职称证书数组或空数组，失败返回false
     */
    public static function getGradeCertificateListByHuman($human_id){
        $certificateService=new CertificateService();
        $GClist=$certificateService->getGradeCertificateListByHuman($human_id);
        return FactoryVMap::list_to_models($GClist,'home_human_grade_certificate');
    }
    
    /**
     * 获取求职意向信息
     * @param int $intent_id 意向编号
     * @return array 
     */
    public static function getJobIntent($job_intent){
        $jobService = new JobService();
        $position = $jobService->get_job_position_more($job_intent);
        $result['ids'] = implode(',', $position['ids']);
        $result['pids'] = implode(',', $position['pids']);
        $result['names'] = implode(',', $position['names']);
        foreach($position['ids'] as $key => $value){
            $result['array'][$key]['id'] = $value;
            $result['array'][$key]['pid'] = $position['pids'][$key];
            $result['array'][$key]['name'] = $position['names'][$key];
        }
        return $result;
    }
}
?>
