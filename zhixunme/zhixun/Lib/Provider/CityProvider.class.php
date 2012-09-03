<?php

/**
 * Description of CityProvider
 *
 * @author moi
 */
class CityProvider extends BaseProvider {

    /**
     * 获取城市列表
     * @param  <int> $province 省份代码
     * @return <mixed> 城市列表
     */
    public function get_city_list($province) {
        $this->da->setModelName('city');                    //使用城市表
        return $this->da->where(array('pro_code' => $province))->order('sort desc')->select();
    }

    /**
     * 指定代码城市是否存在
     * @param  <string> $code 城市代码
     * @return <bool> 是否存在
     */
    public function is_exists_city($code) {
        $this->da->setModelName('city');                    //使用城市表
        $data = $this->da->where(array('code' => $code))->find();
        if (!empty($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 检测省份和城市的关系对应是否正确
     * @param  <int> $code     城市编号
     * @param  <int> $pro_code 省份编号
     * @return <bool> 是否正确
     */
    public function check_city_province($code, $pro_code) {
        if ($code == 0)                   //城市未选择
            return true;
        $this->da->setModelName('city');                    //使用城市表
        $data = $this->da->where(array('code' => $code))->find();
        return $data['pro_code'] == $pro_code;
    }

    /**
     * 获取指定城市信息
     * @param  <int> $code 城市代码
     * @return <array> 城市信息
     */
    public function get_city($code) {
        $this->da->setModelName('city');                    //使用城市表
        return $this->da->where(array('code' => $code))->find();
    }

    /**
     *  数据转换 
     * @author brave 
     */
    public function getList($curPage, $pageSize) {
        $this->da->setModelName('city');
        return $this->da->page($curPage . ',' . $pageSize)->select();
    }

    public function get_province_list() {
        $this->da->setModelName('province');
        return $this->da->select();
    }

    /**
     *  数据转换 
     * @author brave 
     */
}

?>
