<?php

/**
 * 省-市-区-镇 服务提供器
 * @author YoyiorLee
 */
class DistrictCrmService {

    public $provider;

    public function __construct() {
        $this->provider = new DistrictCrmProvider();
    }

    /**
     * 地区是否存在
     * @param int $dist_id 地区ID
     * @return boolean 是否存在（true为存在,false为不存在）
     */
    public function is_exsit($dist_id) {
        if (var_validation($dist_id, VAR_ID)) {
            return $this->provider->is_exsit($dist_id);
        }
        return false;
    }

    /**
     * 添加地区
     * @param mixed $data 地区数据 array(name,level,use_type,dist_pid,is_open）
     * @return int 新增地区ID
     */
    public function add($name, $level, $dist_pid, $is_open = 0, $use_type = 3) {
        $VA = array('dist_name' => $name,
            'level' => $level,
            'use_type' => $use_type,
            'dist_pid' => $dist_pid,
            'is_open' => $is_open);
        $result = argumentValidate($this->provider->$DistrictArgRule, $VA);
        if (is_zerror($result)) {
            return $result;
        }
        return $this->provider->add($result);
    }

    /**
     * 删除地区
     * @param int $dist_id 地区ID
     * @param type $is_completely 是否彻底删除（true为彻底删除，false为逻辑删除）
     * @return boolean 是否删除成功（true为成功，false为失败）
     */
    public function delete($dist_id, $is_completely = false) {
        if (var_validation($dist_id, VAR_ID)) {
            //彻底删除
            if ($is_completely) {
                return $this->provider->_delete($dist_id);
            }
            return $this->provider->delete($dist_id);
        }
        return false;
    }

    /**
     * 更新地区
     * @param int $data 地区数据 array(dist_id,name,level,usetype,dist_pid,is_open)
     * @return boolean 是否更新成功（true为成功，false为失败）
     */
    public function update($data) {
        $VU = array('dist_id' => $dist_id,
            'dist_name' => $name,
            'level' => $level,
            'use_type' => $use_type,
            'dist_pid' => $dist_pid,
            'is_open' => $is_open);
        $result = argumentValidate($this->provider->DistrictArgRule, $VU);
        if (is_zerror($result)) {
            return $result;
        }
        return $this->provider->update($result);
    }

    /**
     * 根据地区编号获取地区
     * @param int $dist_id 地区ID
     * @return mixed 结果集
     */
    public function get_district($dist_id) {
        if (var_validation($dist_id, VAR_ID)) {
            return $this->provider->get_district($dist_id);
        }
        return false;
    }

    /**
     * 获取此地区的子地区
     * @param int $dist_id 地区ID
     * @param int $level 层级ID（1,2,3,4）
     * @return mixed 结果集
     */
    public function get_sub_district($dist_id, $level) {
        if (var_validation($dist_id, VAR_ID)) {
            return $this->provider->get_sub_district($dist_id, $level);
        }
        return false;
    }

    /**
     * 根据地区编号获取地区
     * @param int $code 地区CODE
     * @return mixed 结果集
     */
    public function get_district_by_code($code) {
        if (var_validation($code, VAR_ID)) {
            $result = $this->provider->get_district_by_code($code);
            if(empty($result))
                return 0;
            return $result;
        }
        return 0;
    }

}

?>
