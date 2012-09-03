<?php
/**
 * Description of home_lib_talents_page
 *
 * @author moi
 */
class home_lib_resource_page {
    /**
     * 获取资源库列表
     * @param <int>    $role_id   角色编号
     * @param <int>    $label     标签编号
     * @param <string> $auth_code 认证代码
     * @param <int>    $province  省份编号
     * @param <int>    $city      城市编号
     * @param <int>    $page      第几页
     * @param <int>    $key       关键字
     * @param <string> $order     排序方式
     * @return <mixed> 资源列表
     */
    public static function get_list($role_id, $label = null, $auth_code = '0000', $province = null, $city = null, $page = 1, $key = null, $order = null){
        $service = new ProfileService();
        $data = $service->get_resource_profile_list($label, $role_id, $auth_code, $province, $city, $page, C('SIZE_RESOURCE'), $key, $order);
        foreach ($data as $key => $value) {
            $data[$key]['_credit']   = $service->get_credit_level($value['credibility']);   //获取信誉度信息
            $data[$key]['_province'] = $service->get_province($value['province_id']);       //获取省份信息
            if(!empty($data[$key]['_province']))
                $data[$key]['_city'] = $service->get_city($value['city_id']);               //省份存在，则获取城市信息
        }
        $data = FactoryVMap::list_to_models($data, 'home_lib_resource');
        return $data;
    }

    /**
     * 获取资源库列表总条数
     * @param <int>    $role_id   角色编号
     * @param <int>    $label     标签编号
     * @param <string> $auth_code 认证代码
     * @param <int>    $province  省份编号
     * @param <int>    $city      城市编号
     * @param <int>    $key       关键字
     * @return <int> 总条数
     */
    public static function get_list_count($role_id, $label = null, $auth_code = '0000', $province = null, $city = null, $key = null){
        $service = new ProfileService();
        $data    = $service->get_resource_profile_list($label, $role_id, $auth_code, $province, $city, 1, 1, $key, null, true);
        return $data;
    }
    
    /**
     * 获取资源推荐列表
     * @param  <int> $role_id 角色编号
     * @return <mixed> 推荐列表
     */
    public static function get_recommend($role_id){
        $service = new ProfileService();
        //获取左侧推广位用户信息
        $data = $service->get_resource_profile_list(null, $role_id, '0000', null, null, 1, C('SIZE_RECOMMEND'), null, 'p.sort DESC');
        if($role_id == C('ROLE_TALENTS')){
            $lservice = new LabelService();
        }
        foreach ($data as $key => $value) {
            $data[$key]['role_id']   = $role_id;
            $data[$key]['_credit']   = $service->get_credit_level($value['credibility']);   //获取信誉度信息
            $data[$key]['_province'] = $service->get_province($value['province_id']);       //获取省份信息
            if(!empty($data[$key]['_province']))
                $data[$key]['_city'] = $service->get_city($value['city_id']);               //省份存在，则获取城市信息
            if(isset($lservice)){
                $data[$key]['_label'] = FactoryVMap::list_to_models($lservice->get_user_labels($value['user_id']), 'common_common_label');      //获取用户标签列表
            }
        }
        $data = FactoryVMap::list_to_models($data, 'home_lib_resource');
        return $data;
    }
}
?>
