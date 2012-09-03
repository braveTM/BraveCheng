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
class CallRequestService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new CallRequestProvider();
    }
    
    /**
     * 返回用户模块使用信息
     * Enter description here ...
     * @param $call_request_num  回调编号
     */
    public function getCallRequestInfo($call_request_num){
    	return $this->provider->getCallRequestInfo($call_request_num);
    }
    
    /**
     * 
     * Enter description here ...
     * @param $data 参数
     */
    public function addCallRequestInfo($data){
    	return $this->provider->addCallRequestInfo($data);
    }
    
    /**
     * Enter description here ...
     * @param $call_request_num  回调编号
     * @param unknown_type $data  需要修改的信息
     */
    public function updateCallRequestInfo($call_request_num,$data){
    	return $this->provider->updateCallRequestInfo($call_request_num, $data);
    }
    
    public function updateCall($call_request_num,$long_time){
        //(1)查看回拨回调状态
        $callRequestInfo = $this->provider->getCallRequestInfo($call_request_num);
        if($callRequestInfo['status'] == 3 || empty($callRequestInfo)){
            exit();
        }
        $active_user_id = $callRequestInfo['active_user_id'];
        $passive_user_id = $callRequestInfo['passive_user_id'];
         //(2)编辑回拨回调表
        $this->provider->trans();                           //开启事务
        $updateCRData = array();
        $updateCRData['status'] = 3;
        $updateCRData['end_time'] = time();
        $callRequestResult = $this->provider->updateCallRequestInfo($call_request_num, $updateCRData);
        if(is_zerror($callRequestResult)){
            $this->provider->rollback();                    //回滚事务
            return;
            //return $callRequestResult;
        }
        //(3)改变主叫和被叫的通话状态
        $callSetService = new CallSetService();
        $data['call_status'] = 1;
        $callSetService->updateCallSetInfo($active_user_id, $data);
        $callSetResult = $callSetService->updateCallSetInfo($passive_user_id, $data);
        if(is_zerror($callSetResult)){
            $this->provider->rollback();                    //回滚事务
            return;
            //return $callSetResult;
        }
        //（4）扣除套餐分钟数
        $num = ceil($long_time/60);
        $packageService = new PackageService();
        $packagetResult = $packageService->use_min($active_user_id, $num);
        if(is_zerror($packagetResult)){
            $this->provider->rollback();                    //回滚事务
            return;
            //return $packagetResult;
        }
        //(6)记录
        $callRecordService = new CallRecordService();
        $recordData = array();
        $recordData['active_user_id'] = $active_user_id;
        $recordData['passive_user_id'] = $passive_user_id;
        $recordData['call_time'] = max(0,$callRequestInfo['start_time']);
        $recordData['long_time'] = max(0,$long_time);
        $callRecordResult = $callRecordService->addCallRecordInfo($recordData);
        if(is_zerror($callRecordResult)){
            $this->provider->rollback();                    //回滚事务
            return;
            //return $callRecordResult;
        }
        $this->provider->commit();                          //提交事务
        exit;
    }
    
}
?>