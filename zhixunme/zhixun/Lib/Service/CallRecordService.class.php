<?php
/**
 * Description of CallRecordService
 *
 * @author wgz
 */
class CallRecordService{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new CallRecordProvider();
    }
    
    /**
     * 保存记录数据
     * Enter description here ...
     * @param unknown_type $data  记录信息
     */
    public function addCallRecordInfo($data){
    	return $this->provider->addCallRecordInfo($data);
    }
    
}