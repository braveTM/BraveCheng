<?php

/**
 * 职称数据提供器
 * @author YoyiorLee
 */
class TitleCrmProvider extends BaseProvider {
    /**
     * 人才表字段
     */

    const TITLE_TALBLE = 'crm_titles t';

    /**
     * 构造函数 
     */
    public function __construct() {
        parent::__construct(self::TITLE_TALBLE);
    }

    /**
     * 添加职称
     * @param array $data 职称信息 
     * @return 成功返回自增ID，失败返回false
     */
    public function add($data) {
        return $this->da->add($data);
    }

    /**
     * 根据分类ID获取职称分类
     * @param int $t_id 分类ID
     * @return array 结果集
     */
    public function get_title_type_by_id($t_id) {
        $this->da->setModelName('crm_titles_type tt');
        $where['tt.t_id'] = $t_id;
        $where['tt.is_delete'] = 0;
        return $this->da->where($where)->field('tt.t_id,tt.t_name')->find();
    }

    /**
     * 获取职称所有分类
     * @param int $t_id 分类ID
     * @return array 结果集
     */
    public function get_title_types() {
        $this->da->setModelName('crm_titles_type tt');
        $where['tt.is_delete'] = 0;
        return $this->da->where($where)->field('tt.t_id,tt.t_name')->select();
    }

    /**
     * 根据职称ID获取职称
     * @param int $id 职称ID
     * @return array 结果集
     */
    public function get_title($tp_id) {
        $join = array(
            C('DB_PREFIX') . 'crm_titles_type tt ON tt.t_id = t.t_id'
        );
        $field = array(
            't.tp_id,t.tp_name,t.t_id',
            'tt.t_name as title_type',
        );
        $where['t.tp_id'] = $tp_id;
        $where['t.is_delete'] = 0;
        $list = $this->da->join($join)->where($where)->field($field)->find();
        return $list;
    }

    /**
     * 根据职称ID获取职称
     * @param int $id 职称ID
     * @return array 结果集
     */
    public function get_title_by_type($t_id) {
        $field = array(
            't.tp_id,t.tp_name,t.t_id',
        );
        $where['t.t_id'] = $t_id;
        $where['t.is_delete'] = 0;
        return $this->da->where($where)->field($field)->select();
    }

    /*     * ************************职称CU********************************************************* */

    /**
     *  更新职称
     * @param type $tp_id $data['tp_id'] 职称id 
     */
    public function updateTitles($data) {
        $this->da->setModelName('crm_titles');
        $this->da->where('tp_id = ' . $data['tp_id']);
    }

    /**
     * 查询指定职称专业信息
     * @param int $tp_id 职称专业id
     * @return array 返回职称专业数组
     */
    public function getRelationTitles($tp_id) {
        $this->da->setModelName('crm_titles t');
        $join = array(
            C('DB_PREFIX') . 'crm_titles_type tp ON tp.t_id = t.t_id',
        );
        $where = array(
            't.tp_id' => $tp_id,
            't.is_delete' => 0,
            'tp.is_delete' => 0,
        );
        $fields = array(
            't.tp_id',
            't.t_id',
            't.tp_name',
            'tp.t_name',
        );
        return $this->da->join($join)->field($fields)->where($where)->find();
    }

}

?>
