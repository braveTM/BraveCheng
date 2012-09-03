<?php
/**
 * Description of MessageProvider
 *
 * @author wgz
 */
class SetModelProvider extends BaseProvider {
    
    
    /**
     * 信息字段（收件箱列表）
     */
    const MODEL_FIELDS = 'model_id, user_id, call';
    
    /**
     * 
     * 获取用户的启用模块状态
     * @param unknown_type $user_id  用户id
     * @return 
     */
    public function getModelInfo($user_id){
    	$this->da->setModelName('model');
        $where['user_id']      = $user_id;
        return $this->da->where($where)->find();
    }
    
    /**
     * 保存默认数据
     * Enter description here ...
     * @param unknown_type $data
     */
    public function addModelInfo($data){
        $data['is_del'] = 0;
    	$this->da->setModelName('model');
        return $this->da->add($data);
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $user_id
     * @param unknown_type $data  需要修改的信息
     */
    public function updateModelInfo($user_id,$data){
    	$this->da->setModelName('model');
        $where['user_id']      = $user_id;
        return $this->da->where($where)->save($data) !== false;
    }
    
}