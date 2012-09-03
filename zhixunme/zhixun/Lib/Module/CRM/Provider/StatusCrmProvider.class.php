<?php

/**
 * 阶段进度处理模型
 *
 * @author Brave
 */
class StatusCrmProvider extends BaseProvider {

    /**
     * 验证字段 
     */
    public static $statusArgRule = array(
        'status_id' => array(
            'name' => '人才企业阶段进度关系ID',
            'filter' => VAR_ID,
            'null' => false
        ),
        'cate_id' => array(
            'name' => '阶段ID',
            'filter' => VAR_ID,
            'null' => false
        ),
        'pro_id' => array(
            'name' => '进度ID',
            'length' => VAR_ID,
            'null' => false
        ),
        'notes' => array(
            'name' => '阶段备注',
            'length' => 300,
            'null' => false
        ),
    );

    /**
     * 获取指定人才、企业对应的阶段进度信息列表或者最新的一条阶段进度信息
     * @param int $human_enter_id 人才、企业id
     * @param boolean $is_human 人才或企业判断条件
     * @param boolean $last 是否获取最新的一条阶段进度信息
     * @return array  返回阶段进度列表
     */
    public function getStatusById($human_enter_id, $is_human = TRUE, $last = FALSE) {
        $this->da->setModelName('crm_status s');
        $where = array(
            's.is_delete' => 0
        );
        if ($is_human)
            $where['s.human_id'] = $human_enter_id;
        else
            $where['s.enter_id'] = $human_enter_id;
        $join = array(
            C('DB_PREFIX') . 'crm_category c ON c.cate_id = s.cate_id',
            C('DB_PREFIX') . 'crm_progress p ON p.pro_id = s.pro_id'
        );
        $fields = array(
            's.status_id',
            'c.cate_id',
            'c.cate_name',
            'p.pro_id',
            'p.pro_name',
            's.notes as status_notes',
        );
        if ($last) {
            $order = array(
                's.create_time DESC'
            );
            return $this->da->join($join)->field($fields)->where($where)->order($order)->limit('1')->find();
        }
        $list = $this->da->join($join)->field($fields)->where($where)->select();
        return $list;
    }

    /**
     *  获取阶段列表
     * @return type 
     */
    public function getCategory() {
        $this->da->setModelName('crm_category');
        return $this->da->select();
    }

    /**
     * 获取进度列表
     * @return type 
     */
    public function getProgress() {
        $this->da->setModelName('crm_progress');
        return $this->da->select();
    }

    /**
     *  添加一条人才企业阶段进度关系
     * @param type $data
     * @return mixed 返回false或者记录ID 
     */
    public function addStatus($data) {
        $this->da->setModelName('crm_status');
        $data['is_delete'] = 0;
        $data['create_time'] = time();
        return $this->da->add($data);
    }

    /**
     * 更新指定id的人才企业阶段进度关系记录
     * @param type $status_id
     * @param type $data
     * @return boolean 
     */
    public function updateStatus($status_id, $data) {
        $this->da->setModelName('crm_status');
        $data['create_time'] = time();
        return $this->da->where('status_id=' . $status_id)->save($data);
    }

    /**
     * 查询指定人才企业阶段进度关系记录
     * @param int $status_id 关系id
     * @return array 返回一条关系记录
     */
    public function getRelationStatus($status_id) {
        $this->da->setModelName('crm_status s');
        $where = array(
            's.is_delete' => 0,
            's.status_id' => $status_id,
        );
        $join = array(
            C('DB_PREFIX') . 'crm_category c ON c.cate_id = s.cate_id',
            C('DB_PREFIX') . 'crm_progress p ON p.pro_id = s.pro_id'
        );
        $fields = array(
            's.notes as status_notes',
            's.status_id',
            's.cate_id',
            's.pro_id',
            'c.cate_name',
            'p.pro_name',
        );
        return $this->da->join($join)->field($fields)->where($where)->find();
    }

}

?>
