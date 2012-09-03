<?php
/**
 * Description of home_agent_page
 *
 * @author JZG
 */
class home_agent_page {
    /**
     * 获取委托来的人才
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $agent_id 代理人ID
     * @param <int> $delegate_state 委托状态（1-未公开，2-求职中）
     * @param <int> $job_category 工作性质（1-全职，2-兼职）
     * @param <int> $register_case 注册情况（1-初始，2-变更，3-重新）
     * @return <mixed>
     */
   public static function getDelegatedHuman($page,$size,$agent_id,$delegate_state,$job_category,$register_case){
       $resumeService=new ResumeService();
       $human_list=$resumeService->getDelegatedResume($page, $size, false, $agent_id, $delegate_state, $job_category, $register_case);
       $service = new ContactsService();
       $date = date_f();
       $pservice = new PromoteService();
       $jobService = new JobService();
       foreach($human_list as $key=>$human){
           $human_list[$key]=$resumeService->unserilalizeDelegatedResume($human['resume_data']) + $human;
           $resume_id=$human['resume_id'];
           $human_list[$key]['send_count']=$resumeService->getSendResumeCount($agent_id,$resume_id);
           $human_list[$key]['follow'] = $service->exists_user_follow($agent_id, $human_list[$key]['user_id']);
           $count = $pservice->count_resume_promote_record($agent_id, $human['resume_id'], null, null, $date);
           $human_list[$key]['job_name'] = $jobService->get_job_position($human_list[$key]['job_name']);
           if($count > 0)
               $human_list[$key]['_promote'] = 1;
           else
               $human_list[$key]['_promote'] = 0;
       }
       return FactoryVMap::list_to_models($human_list,'home_delegate_human');
   }

   /**
    *获取拥有的简历
    * @param <int> $page 第几页
    * @param <int> $size 每页几条
    * @param <int> $owner 拥有者
    * @return <object>
    */
   public static function getOwnResume($page,$size,$owner){
       $resumeService=new ResumeService();
       $human_list=$resumeService->getOwnResumeList($owner, $page, $size, false);
       $certificateService=new CertificateService();
       $jobService = new JobService();
       foreach($human_list as $key=>$human){
           $vali = $resumeService->validateResumeComplete($human['resume_id']);
           if($vali !== true){
               unset($human_list[$key]);
               continue;
           }
           $human_id=$human['human_id'];
           $human_list[$key]['RC_list']=$certificateService->getRegisterCertificateListByHuman($human_id);
           $human_list[$key]['job_name'] = $jobService->get_job_position($human_list[$key]['job_name']);
       }
       return FactoryVMap::list_to_models($human_list,'home_resume_own');
   }

   /**
    * 获取拥有的简历总条数
    * @param <int> $owner 拥有者
    * @return <int>
    */
   public static function getOwnResumeCount($owner){
       $resumeService=new ResumeService();
       $count=$resumeService->getOwnResumeList($owner,null,null,true);
       return $count;
   }


   /**
    * 获取委托来的人才的总记录数
    * @param <type> $agent_id 经纪人ID
    * @param <type> $delegate_state 委托状态（1-未公开，2-求职中）
    * @param <type> $job_category 工作性质（1-全职，2-兼职）
    * @param <type> $register_case 注册情况（1-初始，2-变更，3-重新）
    * @return <int> 
    */
   public static function getDelegateHumanCount($agent_id,$delegate_state,$job_category,$register_case){
       $resumeService=new ResumeService();
       $count=$resumeService->getDelegatedResume(null, null, true, $agent_id, $delegate_state, $job_category, $register_case);
       return $count;
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
    * @return <mixed>
    */
   public static function getPrivateResumeList($creator_id,$creator_role,$delegate_status,$job_category,$register_case,$page,$size){
       $resumeService=new ResumeService();
       $human_list=$resumeService->getPrivateResumeList($creator_id, $creator_role, $delegate_status, $job_category, $register_case, $page, $size,false);
       $certificateService=new CertificateService();
       $service = new ContactsService();
       $date = date_f();
       $pservice = new PromoteService();
       $jobService = new JobService();
       foreach($human_list as $key=>$human){
           $human_id=$human['human_id'];
           $human_list[$key]['RC_list']=$certificateService->getRegisterCertificateListByHuman($human_id);
           $resume_id=$human['resume_id'];
           $human_list[$key]['send_count']=$resumeService->getSendResumeCount($creator_id,$resume_id);
           $human_list[$key]['follow'] = $service->exists_user_follow($creator_id, $human['user_id']);
           $count = $pservice->count_resume_promote_record($creator_id, $human['resume_id'], null, null, $date);
           $human_list[$key]['job_name'] = $jobService->get_job_position($human['job_name']);
           if($count > 0)
               $human_list[$key]['_promote'] = 1;
           else
               $human_list[$key]['_promote'] = 0;
       }
       return FactoryVMap::list_to_models($human_list,'home_delegate_human');
   }
   
  /**
    * 查询添加的私有简历总条数
    * @param <int> $creator_id 创建人ID
    * @param <int> $creator_role 创建人角色
    * @param <int> $delegate_status 委托状态（1-未公开，2-求职中）
    * @param <int> $register_case 注册情况(1-初始注册，2-变更注册，3-重新注册）
    * @param <int> $job_category 工作性质（1-全职，2-兼职）
    * @return <int>
    */
   public static function getPrivateResumeCount($creator_id,$creator_role,$delegate_status,$job_category,$register_case){
       $resumeService=new ResumeService();
       $count=$resumeService->getPrivateResumeList($creator_id, $creator_role, $delegate_status, $job_category, $register_case,null,null, true);
       return $count;
   }

   /**
    * 查看应聘来的简历
    * @param <int> $publisher_id 发布人ID
    * @param <int> $publisher_role 发布人角色（2-企业，3-经纪人）
    * @param <int> $sent_status 投递状态（1-未查看，2-已查看）
    * @param <int> $job_category 工作性质（1-全职，2-兼职）
    * @param <int> $sender_role 投递人角色（1-人才，3-经纪人）
    * @param <int> $page 第几页
    * @param <int> $size 每页几条
    * @return <mixed> 
    */
   public static  function getSentResume($publisher_id,$publisher_role,$sent_status,$job_category,$sender_role,$page,$size){
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
    * @param <int> $publisher_role 发布人角色（2-企业，3-经纪人）
    * @param <int> $sent_status 投递状态（1-未查看，2-已查看）
    * @param <int> $job_category 工作性质（1-全职，2-兼职）
    * @param <int> $sender_role 投递人角色（1-人才，3-经纪人）
    * @return <int>
    */
   public static function getSentResumeCount($publisher_id,$publisher_role,$sent_status,$job_category,$sender_role){
       $resumeService=new ResumeService();
       $count=$resumeService->getSentResume($publisher_id, $sent_status, $job_category, $sender_role, null,null,true);
       return $count;
   }

   /**
    * 获取首页面数据统计
    * @return <int>
    */
   public static function get_page_count($user_id){
       $service = new BillService();
       $bill = $service->get_bill_info($user_id);
       if($bill['cash'] > 10000){
           $bill['cash'] = floor($bill['cash']/10000)."万";
       }
       $array['count1'] = $bill['cash'];
       $service = new ResumeService();
       $array['count2'] = $service->count_agent_resume($user_id);
       $service = new JobService();
       $pub_count = $service->get_pub_jobs($user_id, 0, 0, 1, 1, true);
       $delegate_count = $service->get_agented_jobs($user_id, 0, 0, 1, 1, true);
       $array['count3'] = $pub_count + $delegate_count;
       return FactoryVMap::array_to_model($array, 'common_common_index');
   }

   /**
    * 获取推广页面数据
    */
   public static function get_promote_data(&$status){
       $service = new PromoteService();
       $data = $service->get_promote_service(C('PROMOTE_AGENT_NORMAL'));
       if($data['max_count'] == -1)
           $data['s_count'] == -1;
       else
           $data['s_count'] = $data['max_count'] - $service->count_agent_promote_record(null, C('PROMOTE_AGENT_NORMAL'), null, date_f());
       $array['na'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //普通账户推广
       $data = $service->get_promote_service(C('PROMOTE_AGENT_INDEX'));
       if($data['max_count'] == -1)
           $data['s_count'] == -1;
       else
           $data['s_count'] = $data['max_count'] - $service->count_agent_promote_record(null, C('PROMOTE_AGENT_INDEX'), null, date_f());
       $array['ia'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //首页账户推广
       $data = $service->get_promote_service(C('PROMOTE_JOB_NORMAL'));
       $array['nj'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //普通职位推广
       $data = $service->get_promote_service(C('PROMOTE_RESUME_NORMAL'));
       $array['nr'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //普通简历推广
       //$data = $service->get_promote_service(C('PROMOTE_TASK_NORMAL'));
       //$array['nt'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //普通任务推广
       $data = $service->get_promote_service(C('PROMOTE_JOB_INDEX'));
       $array['ij'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //首页职位推广
       $data = $service->get_promote_service(C('PROMOTE_RESUME_INDEX'));
       $array['ir'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //首页简历推广
       //$data = $service->get_promote_service(C('PROMOTE_TASK_INDEX'));
       //$array['it'] = FactoryVMap::array_to_model($data, 'home_agent_promote');     //首页任务推广
       $data = $service->get_agent_promote_record(AccountInfo::get_user_id(), C('PROMOTE_AGENT_NORMAL'));   //获取自己普通账户推广信息
       if(empty($data)){
           $status['hn'] = 0;
       }
       else{
           $status['hn'] = 1;
           $status['dn'] = $data['end_time'];
       }
       $data = $service->get_agent_promote_record(AccountInfo::get_user_id(), C('PROMOTE_AGENT_INDEX'));    //获取自己首页账户推广信息
       if(empty($data)){
           $status['hi'] = 0;
       }
       else{
           $status['hi'] = 1;
           $status['di'] = $data['end_time'];
       }
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
       $array['ar'] = $service->count_resume_promote_record($user_id);
       //$array['at'] = $service->count_task_promote_record($user_id);
       $array['uj'] = $service->count_job_promote_record($user_id, null, null, null, $date);
       $array['ur'] = $service->count_resume_promote_record($user_id, null, null, null, $date);
       //$array['ut'] = $service->count_task_promote_record($user_id, null, null, null, $date);
       return $array;
   }

   public static function get_account_promote_status(){
   }
   
   /**
    * 经纪人隐私
    * Enter description here ...
    * @param $user_id
    */
	public static function getPrivacyAgent($user_id){
   		$privacyService = new PrivacyService();
   		$info = $privacyService->getAgentPrivacy($user_id);
   		$agentService= new MiddleManService();
   		$agentInfo = $agentService->get_agent($info['agent_id']);
   		
		//获得电话回拨时间段
   		if($info['contact_way'] == 1){
   			$user_id = AccountInfo::get_user_id();
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
                
   		$info['names'] = array();
   		$info['names']['type'] = $info['name'];
   		$info['names']['quanname'] = $agentInfo['name'];
   		$info['names']['banname'] = substr($agentInfo['name'], 0,3);
   		return FactoryVMap::array_to_model($info,'home_privacy_agent');
   }
}
?>
