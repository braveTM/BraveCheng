<?php
/**
 * Description of CallSetProvider
 *
 * @author wgz
 */
class CallRequestProvider extends BaseProvider {

    /***************************************************************************************************************/
    /**
     * 获取用户电话回拨设置信息
     * Enter description here ...
     * @param $user_id
     */
    public function getCallRequestInfo($call_request_num){
    	$this->da->setModelName('call_request');
        $where['call_request_num']      = $call_request_num;
        return $this->da->where($where)->find();
    }
    
     /**
     * 保存默认数据
     * Enter description here ...
     * @param unknown_type $data
     */
    public function addCallRequestInfo($data){
        $data['is_del'] = 0;
    	$this->da->setModelName('call_request');
        return $this->da->add($data);
    }
    
	/**
     * 
     * 编辑用户信息
     * @param unknown_type $user_id
     * @param unknown_type $data  需要修改的信息
     */
    public function updateCallRequestInfo($call_request_num,$data){
    	$this->da->setModelName('call_request');
        $where['call_request_num']      = $call_request_num;
        return $this->da->where($where)->save($data) !== false;
    }
    
    
    
    
}