<?php

/**
 * NoticeCrmProvider 
 * 提醒功能底层数据提供
 * @author brave
 */
class NoticeCrmProvider extends BaseProvider {

    public static $noticetimesettingArgRule = array(
        'type' => array(
            'name' => '提醒时间方式',
        ),
        'month' => array(
            'name' => '提醒月份',
            'filter' => VAR_ID,
        ),
        'week' => array(
            'name' => '提醒周数',
            'filter' => VAR_ID,
        ),
        'day' => array(
            'name' => '提醒天数 ',
            'filter' => VAR_ID,
        ),
        'hour' => array(
            'name' => '提醒小时',
            'filter' => VAR_ID,
        ),
        'minute' => array(
            'name' => '提醒分钟',
            'filter' => VAR_ID,
        ),
    );

    /**
     * 获取提醒方式列表
     * @return array 返回列表数组 
     */
    public function get_notice_way() {
        $this->da->setModelName('notice_way');
        return $this->da->select();
    }

    /**
     * 获取提醒时间设置项列表
     * @return array 返回时间设置项列表 
     */
    public function get_notice_time_setting() {
        $this->da->setModelName('notice_time_setting');
        return $this->da->select();
    }

    /**
     * 获取指定id的提醒时间设置项
     * @param int $id 提醒时间设置项
     * @return array返回提醒时间设置项一条记录
     */
    public function get_notice_time_setting_by_id($id) {
        $this->da->setModelName('notice_time_setting');
        $where = array(
            'id' => $id,
        );
        return $this->da->where($where)->find();
    }

    /**
     * 获取提醒条件列表
     * @return array 返回提醒条件列表 
     */
    public function get_notice_condition() {
        $this->da->setModelName('notice_condition');
        return $this->da->select();
    }

    /**
     * 添加一条提醒设置
     * @param array $data 提醒项字段 
     * @return mixed  返回成功记录或者false
     */
    public function add_notice_user_setting($data = array()) {
        $this->da->setModelName('notice_user_setting');
        return $this->da->add($data);
    }

    /**
     * 添加一条提醒时间记录
     * @param array $data 提醒内容
     * @return mixed 成功返回提醒时间记录id否则返回false
     */
    public function add_notice_time_setting($data = array()) {
        $this->da->setModelName('notice_time_setting');
        return $this->da->add($data);
    }

    /**
     * 获取指定条件的经纪人的所有提醒时间 
     * @param string $tableName 条件表
     * @param array $queryData 查询字段
     * @return array  返回提醒时间 
     */
    public function get_condition($tableName, $queryData = array()) {
        $this->da->setModelName('notice_user_setting nus');
        $join = array(
            C('DB_PREFIX') . "{$tableName} ON " . C('DB_PREFIX') . "{$tableName}" . ".user_id = nus.uid",
        );
        $where = array(
            $queryData[1] => array('neq', '0000-00-00'),
            C('DB_PREFIX') . "{$tableName}" . '.is_delete' => array('NEQ', 1),
        );
        $queryData[] = 'nus.uid';
        return $this->da->join($join)->field($queryData)->where($where)->Distinct(TRUE)->select();
    }

    /**
     * 更新条件时间
     * @param string $condtionField 条件字段
     * @param string $conditionValue 条件字段值
     * @param string $tableName 条件表
     * @param array $data 条件数组
     * @return boolean 更新成功返回true否则false
     */
    public function set_condition($condtionField, $conditionValue, $tableName, $data = array()) {
        $this->da->setModelName($tableName);
        return $this->da->where($condtionField . "=" . $conditionValue)->save($data);
    }

    /**
     * 获取指定经纪人的指定提醒条件的提醒时间
     * @param int $user_id 经纪人id
     * @param int $condition_id 提醒条件id
     * @return array 返回查询到的提醒时间数组
     */
    public function get_user_notice_time($user_id, $condition_id) {
        $this->da->setModelName('notice_user_setting nus');
        $where = array(
            'nus.uid' => $user_id,
            'nc.id' => $condition_id,
        );
        $join = array(
            C("DB_PREFIX") . 'notice_time_setting nts ON nts.id = nus.tid',
            C("DB_PREFIX") . 'notice_condition nc ON nc.id = nus.cid',
        );
        $field = array(
            'nts.type',
            'nts.day',
            'nts.hour',
            'nts.minute',
        );
        return $this->da->join($join)->field($field)->where($where)->find();
    }

    /**
     * 添加一条提醒准确时间记录
     * @param array $data 提醒准确时间记录
     * @return mixed 成功返回记录id
     */
    public function add_notice_record($data = array()) {
        $this->da->setModelName('notice_record');
        return $this->da->add($data);
    }

    /**
     * 获取当前时间的提醒记录
     * @return array 返回记录 
     */
    public function notice() {
        $this->da->setModelName('notice_record');
        $time = date('Y-m-d H:i:s');
        $where = array(
            'notice_time' => array('ELT', $time),
        );
        $fields = array(
            'id',
            'uid',
            'pid',
            'cid',
            'notice_time',
            'is_human_id',
        );
        return $this->da->field($fields)->where($where)->select();
    }

    /**
     * 根据经纪人和提醒条件查询提醒方式
     * @param int $uid 经纪人id
     * @param int $cid 提醒条件id
     * @return array  返回记录
     */
    public function get_notice_user_setting_by_id($uid, $cid) {
        $this->da->setModelName('notice_user_setting');
        $where = array(
            'uid' => $uid,
            'cid' => $cid,
        );
        return $row = $this->da->where($where)->find();
    }

    /**
     * 判断一些字段值是否存在
     * @param array $data 字段值
     * @return boolean  已经有返回true 否则返回false
     */
    public function is_exist($table, $id, $data = array()) {
        $this->da->setModelName($table);
        return $this->da->where($data)->count($id) > 0 ? TRUE : FALSE;
    }

    /**
     * 更新提醒记录
     * @param type $data
     * @return type 
     */
    public function update_notice_record($data = array()) {
        $this->da->setModelName('notice_record');
        return $this->da->where('id=' . $data['id'])->save($data);
    }

    /**
     * 根据经纪人id资源id与提醒类型id查找唯一索引
     * @param array $data 查询条件
     * @return int 返回id 
     */
    public function get_notice_record_by_filter($data = array()) {
        $this->da->setModelName('notice_record');
        $row = $this->da->field('id')->where($data)->find();
        return $row['id'];
    }

    /**
     * 更新记录时间
     * @param type $record_id 
     */
    public function do_renew_notice_time($record_id) {
        $sql = "update " . C('DB_PREFIX') . "notice_record set notice_time=DATE_ADD(notice_time,INTERVAL 1 YEAR) where id={$record_id}";
        $this->da->execute($sql);
    }

    /**
     * 更新指定经纪人与提醒类型的提醒方式与提醒时间
     * @param array $data 提醒内容数组
     * @return boolean 成功与否
     */
    public function update_notice_user_setting($data = array()) {
        $this->da->setModelName('notice_user_setting');
        $where = array(
            'uid' => $data['uid'],
            'cid' => $data['cid'],
        );
        return $this->da->where($where)->save($data);
    }

}

?>
