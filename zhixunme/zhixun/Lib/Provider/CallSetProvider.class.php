<?php
/**
 * Description of CallSetProvider
 *
 * @author wgz
 */
class CallSetProvider extends BaseProvider {
    
    
    /**
     * 信息字段（收件箱列表）
     */
    const MODEL_FIELDS = 'call_set_id, user_id, call_time_slot,call_status';
    
    /**
     * 获取用户电话回拨设置信息
     * Enter description here ...
     * @param $user_id
     */
    public function getCallSetInfo($user_id){
    	$this->da->setModelName('call_set');
        $where['user_id']      = $user_id;
        return $this->da->where($where)->find();
    }
    
     /**
     * 保存默认数据
     * Enter description here ...
     * @param unknown_type $data
     */
    public function addCallSetInfo($data){
        $data['is_del'] = 0;
    	$this->da->setModelName('call_set');
        return $this->da->add($data);
    }
    
	/**
     * 
     * 编辑用户信息
     * @param unknown_type $user_id
     * @param unknown_type $data  需要修改的信息
     */
    public function updateCallSetInfo($user_id,$data){
    	$this->da->setModelName('call_set');
        $where['user_id']      = $user_id;
        return $this->da->where($where)->save($data) !== false;
    }
  
    
    
    
    
}