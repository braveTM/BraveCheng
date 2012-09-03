<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MiddleManService
 *
 * @author wgz
 */
class CallSetService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new CallSetProvider();
    }
    
    /**
     * 返回用户模块使用信息
     * Enter description here ...
     * @param $user_id  用户id
     */
    public function getCallSetInfo($user_id){
    	return $this->provider->getCallSetInfo($user_id);
    }
    
    /**
     * 
     * Enter description here ...
     * @param $data 参数
     */
    public function addCallSetInfo($data){
    	return $this->provider->addCallSetInfo($data);
    }
    
    /**
     * Enter description here ...
     * @param unknown_type $user_id
     * @param unknown_type $data  需要修改的信息
     */
    public function updateCallSetInfo($user_id,$data){
    	return $this->provider->updateCallSetInfo($user_id, $data);
    }
    
    public function callSet($active_user_id,$passive_user_id){
    	//(1)判断主叫和被叫用户是否手机认证
    	$userService = new UserService();
    	$activeUserInfo = $userService->get_user($active_user_id);//主叫
    	if($activeUserInfo['is_phone_auth'] != 1 || !var_validation($activeUserInfo['phone'], VAR_PHONE)){
    		return E(ErrorMessage::$ACTIVE_NOT_PHONE);
    	}
    	$passiveUserInfo = $userService->get_user($passive_user_id);//被叫
        
    	if($passiveUserInfo['is_phone_auth']!= 1 || !var_validation($passiveUserInfo['phone'], VAR_PHONE)){
    		return E(ErrorMessage::$PASSIVE_NOT_PHONE);
    	}
    	//(2)查询此主叫是否还有回拨分钟数
    	/***********************查询剩余套餐数还没有做**********************************/
        $packageService = new PackageService();
        $min = $packageService->get_min_num($active_user_id);
        if($min <= 0){
                return E(ErrorMessage::$CALL_NO_MIN);
        }
        $max_seconds = $min*60; 
    	//(3)判断被叫是否现在接听
    	//$role_type  = AccountInfo::get_role_id(); 
        $role_type  = $passiveUserInfo['role_id']; 
    	$privacyService = new PrivacyService();
    	if($role_type == 1){
    		$info = $privacyService->getHumanPrivacy($passive_user_id);
    	}elseif ($role_type == 2){
    		$info = $privacyService->getCompanyPrivacy($passive_user_id);
    	}elseif ($role_type == 3){
    		$info = $privacyService->getAgentPrivacy($passive_user_id);
    	}
    	if(empty($info) || $info['contact_way'] != 1){
    		return E(ErrorMessage::$CALL_NOT);
    	}
    	//(4)判断被叫用户是否空闲//判断被叫接听时间段
    	$callSetInfo = $this->provider->getCallSetInfo($passive_user_id);
    	if($callSetInfo['call_status'] == 2){
    		return E(ErrorMessage::$CALL_BUSY);
    	}
    	$call_time_slot = unserialize( $callSetInfo['call_time_slot']);
    	if ($call_time_slot['call_type'] == 3){
    		return E(ErrorMessage::$CALL_NOT_CONVENIENT);
    	}elseif ($call_time_slot['call_type'] == 2 && count($call_time_slot['call_time']) > 0){
	    	foreach ($call_time_slot['call_time'] as $key=>$value){
				$start_time = strtotime($value['start_time']);
				$end_time = strtotime($value['end_time']);
                                $time = time();
				if($start_time < $time && $time < $end_time) {
					
				}else{
                                    return E(ErrorMessage::$CALL_NOT_CONVENIENT);
					break;
                                }
			}
    	}
       
    	//(6)调用回拨接口
    	require_cache(APP_PATH.'/Common/Class/Call.class.php');
    	$call = CallFactory::get_instance();
        $start_time = time();
        $callConnectId = $call->call($activeUserInfo['phone'], $passiveUserInfo['phone'], $max_seconds, $order_id);
        if(empty($callConnectId)){
                return E(ErrorMessage::$CALL_NOT_EXISTS);
        }  
         //(5)改变主叫和被叫的通话状态
        $this->provider->trans();                           //开启事务
        $data['call_status'] = 2;
        if(!$this->provider->updateCallSetInfo($active_user_id, $data)){
            $this->provider->rollback();                    //回滚事务
            return E();
        }
        if(!$this->provider->updateCallSetInfo($passive_user_id, $data)){
            $this->provider->rollback();                    //回滚事务
            return E();
        }
        //(7).记录回拨回调表
        $callRequestdata = array();
        $callRequestdata['call_request_num'] = $callConnectId;
        $callRequestdata['active_user_id'] = $active_user_id;
        $callRequestdata['passive_user_id'] = $passive_user_id;
        $callRequestdata['status'] = 2;
        $callRequestdata['is_abnormal'] = 0;
        $callRequestdata['start_time'] = $start_time;
        $callRequestdata['end_time'] = $start_time;
        $callRequestService = new CallRequestService();
        $callRequestResult = $callRequestService->addCallRequestInfo($callRequestdata);
        if(is_zerror($callRequestResult)){
            $this->provider->rollback();                    //回滚事务
            return $callRequestResult;
        }
        $this->provider->commit();                          //提交事务
        return true;
    }
    
    /**
     *查看隐私回拨设置
     */
    public function getPrivacyCallSet($user_id){
        $userService = new UserService();
        $userInfo = $userService->get_user($user_id);
        if(!$userInfo['role_id']){
            return false;
        }
        $role_type  = $userInfo['role_id']; 
    	$privacyService = new PrivacyService();
    	if($role_type == 1){
    		$info = $privacyService->getHumanPrivacy($user_id);
    	}elseif ($role_type == 2){
    		$info = $privacyService->getCompanyPrivacy($user_id);
    	}elseif ($role_type == 3){
    		$info = $privacyService->getAgentPrivacy($user_id);
    	}
        
        if($info['contact_way'] == 1){
            $callSetInfo = $this->provider->getCallSetInfo($user_id);
            $call_time_slot = unserialize( $callSetInfo['call_time_slot']);
            $info['call_type'] = $call_time_slot['call_type'];
            $info['call_time'] = $call_time_slot['call_time'];
             $info['call_time_type']= 1;
            if ($call_time_slot['call_type'] == 2 && count($call_time_slot['call_time']) > 0){
	    	foreach ($call_time_slot['call_time'] as $key=>$value){
				$start_time = strtotime($value['start_time']);
				$end_time = strtotime($value['end_time']);
                                $time = time();
				if($start_time < $time && $time < $end_time) {
					$info['call_time_type'] = 0;//可以拨打电话
				}
			}
            }
            $info['call_status'] = $callSetInfo['call_status'];
        } 
        return $info;
    }
    
    public function callSetPackage($active_user_id){
        //(1)判断主叫和被叫用户是否手机认证
    	$userService = new UserService();
    	$activeUserInfo = $userService->get_user($active_user_id);//主叫
    	if($activeUserInfo['is_phone_auth'] != 1 || !var_validation($activeUserInfo['phone'], VAR_PHONE)){
    		return E(ErrorMessage::$PHONE_NOT_EXISTS);
    	}
    	/*$passiveUserInfo = $userService->get_user($passive_user_id);//被叫
    	if($passiveUserInfo['is_phone_auth']!= 1 || !var_validation($passiveUserInfo['phone'], VAR_PHONE)){
    		return E(ErrorMessage::$PHONE_NOT_EXISTS);
    	}
        $packageService = new PackageService();
        $min = $packageService->get_min_num($active_user_id);
        if($min <= 5 && $min > 0){
            return "你当前套餐拨打分钟数为 $num 分钟，为了避免影响你正常使用此功能，请及时购买分钟数，你也可以继续拨打";
        }elseif( $min <= 0){
            return "你当前套餐拨打分钟数为 $num 分钟，是否立即去购买分钟数";
        }*/
        return true;
    }
    
}