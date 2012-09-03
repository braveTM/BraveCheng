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
class home_human_page {
    //put your code here
    
    /**
     * 人才找经纪人
     * @param <int> $type 经纪人类别（1为个人，2为公司成员）
     * @param <int> $addr_province_code 所在地省份编号
     * @param <int> $addr_city_code 所在地城市编号
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @return <mixed>
     */
    public static function getAgentList($type,$addr_province_code,$addr_city_code,$page,$size){
        $middleManService=new MiddleManService();
        $agentList=$middleManService->getDetailAgentList(null, $type, $addr_province_code, $addr_city_code, $page, $size, false);
        $service = new ContactsService();
        foreach($agentList as $key => $value){
            $agentList[$key]['follow'] = $service->exists_user_follow(AccountInfo::get_user_id(), $value['user_id']);
        }
        return FactoryVMap::list_to_models($agentList,'home_found_agent');
    }

    /**
     * 人才找经纪人的总记录数
     * @param <int> $type 经纪人类别（1为个人，2为公司成员）
     * @param <int> $addr_province_code 所在地省份编号
     * @param <int> $addr_city_code 所在地城市编号
     * @return <int>
     */
    public static function getAgentListCount($type,$addr_province_code,$addr_city_code){
        $middleManService=new MiddleManService();
        $count=$middleManService->getDetailAgentList(null, $type, $addr_province_code, $addr_city_code, null,null, true);
        return $count;
    }

   /**
    * 获取页面数据统计
    * @return <int>
    */
   public static function get_page_count($user_id, $resume_id){
       $service = new BillService();
       $bill = $service->get_bill_info($user_id);
       $service = new ResumeService();
       $array['count1'] = $bill['cash'];
       $array['count2'] = $service->count_user_resume_invite($user_id);
       $array['count3'] = $service->count_user_send_resume($user_id);
       return FactoryVMap::array_to_model($array, 'common_common_index');
   }
   
   /**
    * 人才隐私获取
    * Enter description here ...
    * @param $user_id
    */
	public static function getPrivacyHuman($user_id){
   		$privacyService = new PrivacyService();
   		$info = $privacyService->getHumanPrivacy($user_id);
   		
   		$resumeService = new ResumeService();
   		$resemeInfo = $resumeService->get_resume($info['resume_id']);
   		
   		if($resemeInfo['job_category'] ==1){
   			$info['resume_name'] = "全职简历";
   		}elseif($resemeInfo['job_category'] ==2){
   			$info['resume_name'] = "兼职简历";
   		}else{
   			$info['resume_name'] = "暂未公开简历";
   		}
   		
		//获得电话回拨时间段
   		if($info['contact_way'] == 1){
   			$user_id = AccountInfo::get_user_id();
        	$service = new CallSetService();
        	$callSet = $service->getCallSetInfo($user_id);
        	$call_time_slot = unserialize($callSet['call_time_slot']);
        	$info['call_time_slot']['call_type'] = $call_time_slot['call_type'];
        	$info['call_time_slot']['call_time'] = $call_time_slot['call_time'];
   		}
   		
   		$humanService = new HumanService();
   		$user_info = $humanService->get_human($info['human_id']);
                
                //获取分钟数
                $packageService = new PackageService;
                $info['min']= $packageService->get_min_num($user_id);
   		
                //获取绑定电话
                $userService = new UserService();
                $userInfo = $userService->get_user($user_id);
                $info['is_phone_auth'] = $userInfo['is_phone_auth'];
                $info['phone'] = $userInfo['phone'];
   		
   		$info['birthdays'] = array();
   		$info['birthdays']['type'] = $info['birthday'];
   		$info['birthdays']['time'] = $user_info['birthday'];
   		$info['birthdays']['duantime'] = substr($user_info['birthday'], 6,5);
   		
   		$info['names'] = array();
   		$info['names']['type'] = $info['name'];
   		$info['names']['quanname'] = $user_info['name'];
   		$info['names']['banname'] = substr($user_info['name'], 0,3);
   		
   		return FactoryVMap::array_to_model($info,'home_privacy_human');
   }
}
?>
