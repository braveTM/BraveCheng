<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_company_page
 *
 * @author JZG
 */
class home_company_page {
    //put your code here
    /**
     * 企业找经纪人
     * @param <int> $service_category_id 服务类别ID
     * @param <int> $type 经纪人类别（1为个人，2为公司成员）
     * @param <int> $addr_province_code 所在地省份编号
     * @param <int> $addr_city_code 所在地城市编号
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @return <mixed>
     */
    public static function getAgentList($service_category_id,$type,$addr_province_code,$addr_city_code,$page,$size){
        $middleManService=new MiddleManService();
        $agentList=$middleManService->getDetailAgentList($service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, false);
        $service = new ContactsService();
        foreach ($agentList as $key=>$value){
            $agent_id=$value['agent_id'];
            //$agentList[$key]['services']=$middleManService->get_agent_services($agent_id);
            $agentList[$key]['follow'] = $service->exists_user_follow(AccountInfo::get_user_id(), $value['user_id']);
        }
        return FactoryVMap::list_to_models($agentList,'home_found_agent');
    }

    /**
     * 企业找经纪人的总记录数
     * @param <int> $service_category_id 服务类别ID
     * @param <int> $type 经纪人类别（1为个人，2为公司成员）
     * @param <int> $addr_province_code 所在地省份编号
     * @param <int> $addr_city_code 所在地城市编号
     * @return <int>
     */
    public static function getAgentListCount($service_category_id,$type,$addr_province_code,$addr_city_code){
        $middleManService=new MiddleManService();
        $count=$middleManService->getDetailAgentList($service_category_id, $type, $addr_province_code, $addr_city_code, null,null, true);
        return $count;
    }

   /**
    * 获取页面数据统计
    * @return <int>
    */
   public static function get_page_count($user_id){
       $service = new BillService();
       $bill = $service->get_bill_info($user_id);
       if($bill['cash'] > 10000){
           $bill['cash'] = floor($bill['cash']/10000)."万";
       }
       $array['count1'] = $bill['cash'];
       $service = new JobService();
       $array['count2'] = $service->get_pub_jobs($user_id, 0, 0, 1, 1, true);
       $service = new ResumeService();
       $array['count3'] = $service->getSentResume($user_id, 2, 0, 0, 0, 1, 1, true);
       return FactoryVMap::array_to_model($array, 'common_common_index');
   }

   /**
    * 获取推广页面数据
    */
   public static function get_promote_data(&$status){
       $service = new PromoteService();
       $data = $service->get_promote_service(C('PROMOTE_COMPANY_NORMAL'));
       if($data['max_count'] == -1)
           $data['s_count'] == -1;
       else
           $data['s_count'] = $data['max_count'] - $service->count_company_promote_record(null, C('PROMOTE_COMPANY_NORMAL'), null, date_f());
       $array['na'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //普通账户推广
       $data = $service->get_promote_service(C('PROMOTE_COMPANY_INDEX'));
       if($data['max_count'] == -1)
           $data['s_count'] == -1;
       else
           $data['s_count'] = $data['max_count'] - $service->count_company_promote_record(null, C('PROMOTE_COMPANY_INDEX'), null, date_f());
       $array['ia'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //首页账户推广
       $data = $service->get_promote_service(C('PROMOTE_JOB_NORMAL'));
       $array['nj'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //普通职位推广
       //$data = $service->get_promote_service(C('PROMOTE_TASK_NORMAL'));
       //$array['nt'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //普通任务推广
       $data = $service->get_promote_service(C('PROMOTE_JOB_INDEX'));
       $array['ij'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //首页职位推广
       //$data = $service->get_promote_service(C('PROMOTE_TASK_INDEX'));
       //$array['it'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //首页任务推广
       $data = $service->get_company_promote_record(AccountInfo::get_user_id(), C('PROMOTE_COMPANY_NORMAL'));   //获取自己普通账户推广信息
       if(empty($data)){
           $status['hn'] = 0;
       }
       else{
           $status['hn'] = 1;
           $status['dn'] = $data['end_time'];
       }
       $data = $service->get_company_promote_record(AccountInfo::get_user_id(), C('PROMOTE_COMPANY_INDEX'));    //获取自己首页账户推广信息
       if(empty($data)){
           $status['hi'] = 0;
       }
       else{
           $status['hi'] = 1;
           $status['di'] = $data['end_time'];
       }
       //企业品牌墙
       $data = $service->get_promote_list(1, 30, null, C('ROLE_ENTERPRISE'), 1, AccountInfo::get_user_id(), true);
       foreach($data as $item){
           if($item['_hold'] == 2){
               $temp['id'] = $item['_info']['id'];
               $temp['title'] = $item['title'];
               $temp['end'] = $item['_info']['end_time'];
               $temp['pic'] = $item['_info']['picture'];
               $temp['sort'] = $item['sort'];
           }
       }
       $array['brand'] = FactoryVMap::list_to_models($data, 'home_promote_location');
       $array['own'] = FactoryVMap::array_to_model($temp, 'home_promote_record');
       return $array;

   }

   /**
    * 获取推广记录信息
    */
   public static function get_promote_record(){
       $user_id = AccountInfo::get_user_id();
       $date = date_f();
       $service = new PromoteService();
       $array['aj'] = $service->count_job_promote_record($user_id);
       //$array['at'] = $service->count_task_promote_record($user_id);
       $array['uj'] = $service->count_job_promote_record($user_id, null, null, null, $date);
       $array['ut'] = $service->count_task_promote_record($user_id, null, null, null, $date);
       return $array;
   }

   /**
    * 查看应聘来的简历
    * @param <int> $publisher_id 发布人ID
    * @param <int> $sent_status 投递状态（1-未查看，2-已查看）
    * @param <int> $job_category 工作性质（1-全职，2-兼职）
    * @param <int> $sender_role 投递人角色（1-人才，3-经纪人）
    * @param <int> $page 第几页
    * @param <int> $size 每页几条
    * @return <mixed> 
    */
   public static  function getSentResume($publisher_id,$sent_status,$job_category,$sender_role,$page,$size){
       $resumeService=new ResumeService();
       $sent_resume=$resumeService->getSentResume($publisher_id, $sent_status, $job_category, $sender_role, $page, $size,false);
       $service = new ContactsService();
       $jobService = new JobService();
       foreach($sent_resume as $key=>$resume){
           $sent_resume[$key]=$resume+$resumeService->unserilalizeSentResume($resume['resume_data']);
           $sent_resume[$key]['follow'] = $service->exists_user_follow($publisher_id, $resume['user_id']);
           $sent_resume[$key]['job_name'] = $jobService->get_job_position($sent_resume[$key]['job_name']);
       }
       return FactoryVMap::list_to_models($sent_resume,'home_resume_sent');
   }

   /**
    * 查看应聘来的简历总条数
    * @param <int> $publisher_id 发布人ID
    * @param <int> $sent_status 投递状态（1-未查看，2-已查看）
    * @param <int> $job_category 工作性质（1-全职，2-兼职）
    * @param <int> $sender_role 投递人角色（1-人才，3-经纪人）
    * @return <int>
    */
   public static function getSentResumeCount($publisher_id,$sent_status,$job_category,$sender_role){
       $resumeService=new ResumeService();
       $count=$resumeService->getSentResume($publisher_id, $sent_status, $job_category, $sender_role, null,null,true);
       return $count;
   }
   
   /**
    * 隐私
    * Enter description here ...
    * @param $user_id
    */
   public static function getPrivacyCompany($user_id){
   		$privacyService = new PrivacyService();
   		$info = $privacyService->getCompanyPrivacy($user_id);
   		
   		//获得电话回拨时间段
   		if($info['contact_way'] == 1){
                    $service = new CallSetService();
                    $callSet = $service->getCallSetInfo($user_id);
                    $call_time_slot = unserialize($callSet['call_time_slot']);
                    $info['call_time_slot']['call_type'] = $call_time_slot['call_type'];
                    $info['call_time_slot']['call_time'] = $call_time_slot['call_time'];
   		}
                //获取分钟数
                $packageService = new PackageService;
                $info['min']= $packageService->get_min_num($user_id);
                //获取绑定电话
                $userService = new UserService();
                $userInfo = $userService->get_user($user_id);
                $info['is_phone_auth'] = $userInfo['is_phone_auth'];
                $info['phone'] = $userInfo['phone'];
                //
                $companyService = new CompanyService();
   		$companyInfo = $companyService->get_company($info['company_id']);
   		$info['names'] = array();
   		$info['names']['quanname'] = $companyInfo['contact_name'];
   		$info['names']['banname'] = mb_substr($companyInfo['contact_name'], 0, 1, 'utf-8') ;
   		$info['names']['company_quanname'] = $companyInfo['company_name'];
   		$info['names']['company_banname'] = company_name_format($companyInfo['company_name']);
   		
   		return FactoryVMap::array_to_model($info,'home_privacy_company');
   }
}
?>
