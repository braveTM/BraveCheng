<?php

/**
 * Description of brokerProvider
 *
 * @author brave
 */
class BrokerFirmsProvider extends BaseProvider {

    public static $broArgRule = array(
        'broker_id' => array(
            'name' => '经纪公司',
            'check' => VAR_ID,
            'filter' => VAR_ID,
            'null' => false
        ),
        'staff_id' => array(
            'name' => '经纪人',
            'check' => VAR_ID,
            'filter' => VAR_ID,
            'null' => false
        ),
    );

    /**
     * 实例化模型
     */
    public function __construct() {
        parent::__construct('broker_firms');
    }

    /**
     * 新增一个员工到经纪公司
     * @param array $insert 数据
     * @return mixed 返回新增的记录id或者false
     */
    public function staff_join_broker_firms($insert = array()) {
        $insert['join_time'] = $_SERVER['REQUEST_TIME'];
        return $this->da->add($insert);
    }

    /**
     * 获取指定经纪公司的员工记录
     * @param int $broker_id 经纪公司id
     * @param  boolean $is_freeze 是否被冻结
     * @return array 员工记录
     */
    public function staff_of_broker_firms($broker_id) {
        $where = array(
            'broker_id' => $broker_id,
        );
        $fields = array(
            'staff_id',
        );
        return $this->da->where($where)->field($fields)->select();
    }

    /**
     * 
     * 冻结员工帐号信息
     * @param int $broker_id 经纪公司id
     * @param int $staff_id 经纪人id
     * @return mixed 成功返回更新的记录数，否则返回false
     */
    public function freeze_staff($broker_id, $staff_id) {
        $update = array(
            'freeze_time' => $_SERVER['REQUEST_TIME'],
        );
        $where = array(
            'broker_id' => $broker_id,
            'staff_id' => $staff_id
        );
        return $this->da->where($where)->save($update);
    }

    /**
     *  判断数据字段是否存在数据值
     * @param sting $fieldName 数据字段
     * @param mixed $fieldValue 字段值
     * @param boolean $is_freeze 是否需要在所有记录中筛选
     * @return boolean 存在返回真
     */
    public function isExist($staff_id, $broker_id) {
        $where = array(
            'staff_id' => $staff_id,
            'broker_id' => $broker_id,
        );
        return $this->da->where($where)->count('id') > 0 ? TRUE : FALSE;
    }

}

?>
