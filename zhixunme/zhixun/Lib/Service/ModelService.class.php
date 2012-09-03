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
class ModelService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new ModelProvider();
    }
    
    /**
     * 返回用户模块使用信息
     * Enter description here ...
     * @param $user_id  用户id
     */
    public function getModelInfo($user_id){
    	return $this->provider->getModelInfo($user_id);
    }
    
    /**
     * 
     * Enter description here ...
     * @param $data 参数
     */
    public function addModelInfo($data){
    	return $this->provider->addModelInfo($data);
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $user_id
     * @param unknown_type $data  需要修改的信息
     */
    public function updataModelInfo($user_id,$data){
    	return $this->provider->updateModelInfo($user_id, $data);
    }
    
}