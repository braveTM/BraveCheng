<?php

/**
 * 省-市-区-镇 数据提供器
 * @author YoyiorLee
 */
class DistrictCrmProvider extends BaseProvider {

    const DISTRICT_TABLE = 'crm_district';

    public function __construct() {
        parent::__construct(self::DISTRICT_TABLE);
    }

    /**
     * 地区字段规则
     * @var <array>
     */
    public $DistrictArgRule = array(
        'dist_id' => array(
            'name' => '地区ID',
            'filter' => VAR_ID,
            'null' => false
        ),
        'dist_name' => array(
            'name' => '地区名称',
            'filter' => VAR_STRING,
        ),
        'level' => array(
            'name' => '地区层级',
            'filter' => VAR_ID,
        ),
        'use_type' => array(
            'name' => '用途',
            'filter' => VAR_ID,
        ),
        'dist_pid' => array(
            'name' => '地区父ID',
            'filter' => VAR_ID,
        ),
        'is_open' => array(
            'name' => '是否开放',
            'filter' => VAR_ID,
        ),
    );

    /**
     * 地区是否存在
     * @param int $dist_id 地区ID
     * @return boolean 是否存在（true为存在,false为不存在）
     */
    public function is_exsit($dist_id) {
        $where['dist_id'] = $dist_id;
        $where['is_open'] = 0;
        return $this->da->where($where)->select() > 0;
    }

    /**
     * 添加地区
     * @param mixed $data 地区数据 array(name,level,use_type,dist_pid,is_open）
     * @return int 新增地区ID
     */
    public function add($data) {
        if (empty($data)) {
            return false;
        }
        return $this->da->add($data);
    }

    /**
     * （彻底）删除地区
     * @param int $dist_id 地区ID
     * @return boolean 是否彻底删除成功（true为成功，false为失败）
     */
    public function _delete($dist_id) {
        //删除此地区下的所有子地区
        $where['dist_pid'] = $dist_id;
        $status = $this->da->where($where)->delete();
        //删除此地区
        $where['dist_id'] = $dist_id;
        unset($where['dist_pid']);
        return $this->da->where($where)->delete();
    }

    /**
     * （逻辑）删除地区
     * @param int $dist_id
     * @return boolean 是否彻底删除成功（true为成功，false为失败）
     */
    public function delete($dist_id) {
        $where['dist_id'] = $dist_id;
        $data['is_open'] = 1;
        return $this->da->where($where)->save($data);
    }

    /**
     * 更新地区
     * @param int $data 地区数据 array(dist_id,name,level,usetype,dist_pid,is_open)
     * @return boolean 是否更新成功（true为成功，false为失败）
     */
    public function update($data) {
        if (!isset($data['dist_id'])) {
            return false;
        }
        $where = array(
            'dist_id' => $data['dist_id'],
        );
        return $this->da->where($where)->save($data);
    }

    /**
     * 根据地区编号获取地区
     * @param int $dist_id 地区ID
     * @return mixed 结果集
     */
    public function get_district($dist_id) {
        $where['dist_id'] = $id;
        $where['is_open'] = 0;
        return $this->da->field('dist_id,name,level,dist_pid')->where($where)->select();
    }

    /**
     * 获取此地区的子地区
     * @param int $dist_id 地区ID
     * @param int $level 层级ID（1,2,3,4）
     * @return mixed 结果集
     */
    public function get_sub_district($dist_id, $level) {
        $where['dist_pid'] = $dist_id;
        $where['is_open'] = 0;
        if(isset($level)){
            $where['level'] = $level;
        }
        $field = 'dist_id,dist_name,level,dist_pid';
        return $this->da->field($field)->where($where)->select();
    }
    
    /**
     * 根据地区编号获取地区
     * @param int $code 地区CODE
     * @return mixed 结果集
     */
    public function get_district_by_code($code){
        $where['is_open'] = 0;
        $where['code'] = $code;
        $field = 'dist_id,dist_name,level,dist_pid';
        return $this->da->field($field)->where($where)->find();
    }

    /**
     *  数据转换 
     * @author brave 
     */
    public function getList($name) {
        $this->da->setModelName('crm_district');
        $where = array(
            'dist_name' => array('like', "%$name%"),
        );
        return $this->da->where($where)->find();
    }

}

?>
