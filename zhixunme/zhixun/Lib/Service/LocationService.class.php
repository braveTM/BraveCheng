<?php
/**
 * Description of LocationService
 *
 * @author moi
 */
class LocationService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new ProvinceProvider();
    }

    /**
     * 指定代码省份是否存在
     * @param  <string> $code 省份代码
     * @return <bool> 是否存在
     */
    public function is_exists_province($code){
        return $this->provider->is_exists_province($code);
    }

    /**
     * 指定代码城市份是否存在
     * @param  <string> $code 城市代码
     * @return <bool> 是否存在
     */
    public function is_exists_city($code){
        $provider = new CityProvider();
        return $provider->is_exists_city($code);
    }

    /**
     * 检测省份和城市的关系对应是否正确
     * @param  <int> $code     城市编号
     * @param  <int> $pro_code 省份编号
     * @return <bool> 是否正确
     */
    public function check_city_province($code, $pro_code){
        $provider = new CityProvider();
        return $provider->check_city_province($code, $pro_code);
    }
    
    /**
     * 获取省份列表
     * @param type $bx 是否包括不限选项
     * @return type 
     */
    public function get_province_list($bx = true){
        $provider = new ProvinceProvider();
        $province = $provider->get_province_list();
        if(!$bx){
            unset($province[0]);
        }
        return $province;
    }
}
?>
