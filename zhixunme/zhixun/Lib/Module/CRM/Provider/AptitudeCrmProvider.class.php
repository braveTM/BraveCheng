<?php

/**
 * Description of AptitudeCrmProvider
 *
 * @author YoyiorLee & brave
 */
class AptitudeCrmProvider extends BaseProvider {

    /**
     * 注册情况
     * @var type 
     */
    public static $reginfo = array(
        1 => '初始注册',
        2 => '变更注册',
        3 => '重新注册',
    );

    /**
     * 表名 
     */

    const APTI_HUMAN_TABLE = 'crm_apt_human ah';

    /**
     * 构造函数 
     */
    public function __construct() {
        parent::__construct(self::APTI_HUMAN_TABLE);
    }

    /**
     * 此人资质是否已存在
     * @param int $apt_id 资质ID
     * @param int $human_id 人才ID
     * @return boolean 是否存在（true存在，false不存在）
     */
    public function is_exsit($apt_id, $human_id) {
        $where['apt_id'] = $apt_id;
        $where['human_id'] = $human_id;
        return $this->da->where($where)->select() > 0;
    }

    /**
     * 更具ID删除人才资质关系
     * @param int $aman_id 人才资质关系ID
     * @return boolean 成功返回自增ID，失败返回false
     */
    public function add($data) {
        if ($this->is_exsit($data['apt_id'], $data['human_id'])) {
            $data['is_delete'] = 0;
            return $this->da->add($data);
        }
        return false;
    }

    /**
     * 更具ID删除人才资质关系
     * @param int $aman_id 人才资质关系ID
     * @return boolean 是否成功（true成功，false失败） 
     */
    public function delete($aman_id) {
        $data['is_delete'] = 1;
        $where['aman_id'] = $aman_id;
        return $this->da->where($where)->save($data);
    }

    /**
     * 修改人才资质
     * @param int $aman_id 人才资质关系ID
     * @param array $data 人才资质关系数据
     * @return boolean 是否成功（true成功，false失败） 
     */
    public function update($aman_id, $data) {
        $where['aman_id'] = $aman_id;
        return $this->da->where($where)->save($data);
    }

    /**
     * 获取人才的资质证书
     * @param int $human_id 人才ID
     * @return array 结果集
     */
    public function get_aptitude_by_human($human_id) {
        $join = array(
            C('DB_PREFIX') . 'crm_district cd ON cd.dist_id = ah.province_id'
        );
        $field = array(
            'ah.aman_id,ah.apt_id,ah.human_id,ah.reg_info,ah.province_id',
            'cd.dist_name as province',
        );
        $where['ah.human_id'] = $human_id;
        $where['ah.is_delete'] = 0;
        $list = $this->da->join($join)->where($where)->field($field)->select();
        foreach ($list as $key => $value) {
            $list[$key]['reg_case'] = self::$reginfo[$value['reg_info']];
        }
        return $list;
    }

    /**
     * 获取人才的资质证书
     * @param int $human_id 人才资质关系ID
     * @return array 结果集
     */
    public function get_aptitude_by_id($id) {
        $join = array(
            C('DB_PREFIX') . 'crm_district cd ON cd.dist_id = ah.province_id'
        );
        $field = array(
            'ah.aman_id,ah.apt_id,ah.human_id,ah.reg_info,ah.province_id',
            'cd.dist_name as province',
        );
        $where['ah.aman_id'] = $id;
        $where['ah.is_delete'] = 0;
        $value = $this->da->join($join)->where($where)->field($field)->find();
        $value['reg_case'] = self::$reginfo[$value['reg_info']];
        return $value;
    }

    /**
     * 获取证书列表
     * @return type 
     */
    public function getCertificate() {
        $this->da->setModelName('crm_certificate');
        $where = array(
            'is_delete' => 0,
        );
        return $this->da->where($where)->select();
    }

    /**
     *  获取行业列表
     * @return type 
     */
    public function getIndustry() {
        $where = array(
            'is_delete' => 0,
        );
        $this->da->setModelName('crm_industry');
        return $this->da->where($where)->select();
    }

    /**
     * 获取指定行业id的行业信息
     * @param type $in_id
     * @return type 
     */
    public function getIndustryByInid($in_id) {
        $this->da->setModelName('crm_industry');
        $where = array(
            'is_delete' => 0,
            'in_id' => $in_id,
        );
        $fields = array(
            'in_name',
        );
        $row = $this->da->field($fields)->where($where)->find();
        return $row['in_name'];
    }

}

?>
