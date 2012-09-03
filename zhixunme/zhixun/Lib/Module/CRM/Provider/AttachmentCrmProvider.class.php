<?php

/**
 * 附件信息处理模块 包含附件表与附件类型表
 *
 * @author Brave
 */
class AttachmentCrmProvider extends BaseProvider {

    public static $attchmentArgRule = array(
        'att_type_id' => array(
            'name' => '附件类型id',
            'check' => VAR_ID,
        ),
        'att_type_name' => array(
            'name' => '附件类型名称',
            'check' => VAR_NAME,
        ),
        'att_name' => array(
            'name' => '附件名称',
            //'check' => VAR_NAME,
        ),
        'att_path' => array(
            'name' => '附件上传地址',
        ),
        'att_property' => array(
            'name' => '附件专属属性',
        ),
        'identifier' => array(
            'name' => '证件号码',
        ),
    );

    /**
     * 查询指定附件ID的信息
     * @param type $att_id 附件ID
     * @return array
     */
    public function getAttchmentById($att_id) {
        $attType = $this->getAttType();
        /**
         * 注意先后实例化 
         */
        $this->da->setModelName('crm_attachment');
        $where = array(
            'att_id' => $att_id
        );
        $result = $this->da->where($where)->find();
        $result['att_type'] = $attType[$result['att_type_id']];
        return $result;
    }

    /**
     *  添加一条附件信息
     * @param type $data 
     */
    public function addAttachment($data) {
        $this->da->setModelName('crm_attachment');
        $data['is_delete'] = 0;
        $data['att_time'] = time();
        return $this->da->add($data);
    }

    /**
     * 更新附件信息
     * @param array $data
     * @return type 
     */
    public function updateAttachment($data) {
        $this->da->setModelName('crm_attachment');
        $data['att_time'] = time();
        return $this->da->where('att_id=' . $data['att_id'])->save($data);
    }

    /**
     * 获取附件类型
     * @return type 
     */
    public function getAttachmentType() {
        $this->da->setModelName('crm_att_type');
        return $this->da->select();
    }

    /**
     * 删除附件
     * @param int $att_id
     * @param array $data
     * @return type 
     */
    public function deleteAttachment($att_id, $data) {
        $this->da->setModelName('crm_attachment');
        $data['is_delete'] = 1;
        return $this->da->where('att_id=' . $att_id)->save($data);
    }

    /**
     * 获取附件类型名称数组
     * @return type 
     */
    public function getAttType() {
        $results = array();
        $this->da->setModelName('crm_att_type');
        $where = array(
            'is_delete' => 0
        );
        $fields = array(
            'att_type_id',
            'att_type_name'
        );
        foreach ($this->da->field($fields)->where($where)->select() as $v) {
            $results[$v['att_type_id']] = $v['att_type_name'];
        }
        return $results;
    }
    
    public function getAtthumanByEnter(){
        $this->da->setModelName('crm_atthuman');
        $where = array(
            'is_delete' => 0
        );
        $result = $this->da->where($where)->select();
        return $result;
    }

}

?>
