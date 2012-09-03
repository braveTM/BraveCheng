<?php

/**
 * 附件信息处理模块 包含附件表与附件类型表
 *
 * @author Brave
 */
class AtthumanCrmProvider extends BaseProvider {
    public static $attchmentArgRule = array(
        'att_human_id' => array(
            'name' => '附件关系ID',
            'check' => VAR_ID,
        ),
        'att_id' => array(
            'name' => '附件ID',
            'check' => VAR_ID,
            'null' => false,
        ),
        'human_id' => array(
            'name' => '人才资源ID',
            'check' => VAR_ID,
            'null' => true,
        ),
        'enter_id' => array(
            'name' => '企业资源ID',
            'check' => VAR_ID,
            'null' => true,
        ),
        'is_delete' => array(
            'name' => 'sc',
        ),
    );
    
     /**
     *  添加一条附件信息
     * @param type $data 
     */
    public function addAtthuman($data) {
        $this->da->setModelName('crm_atthuman');
        $data['is_delete'] = 0;
        return $this->da->add($data);
    }
    
    /**
     * 删除附件
     * @param int $att_id
     * @param array $data
     * @return type 
     */
    public function deleteAtthuman($user_id,$where) {
        $this->da->setModelName('crm_attachment');
        $data['is_delete'] = 1;
        $where['is_delete'] = 0;
        
        return $this->da->where($where)->save($data);
    }
    
    /**
     *
     * @param human_id $user_type 
     */
    public function spaiecalPercent($human_id,$user_type,$att_type_id){
        $this->da->setModelName('crm_atthuman at');
         $join = array(
            C('DB_PREFIX') . 'crm_attachment atm ON atm.att_id = at.att_id'
        );
        $field = array(
            'at.att_human_id',
        );
        if($user_type == 1){
            $where['at.human_id'] = $human_id;
        }elseif($user_type == 2){
            $where['at.enter_id'] = $human_id;
        }
        $where['at.is_delete'] = 0;
        $where['atm.att_type_id'] = $att_type_id;
        $list = $this->da->join($join)->where($where)->field($field)->select();
        if(!empty($list)){
            return TRUE;
        }  else {
            return FALSE;
        }
        
    }
    
    
    
}
?>
