<?php
/**
 * Description of home_common_front_page
 *
 * @author moi
 */
class home_common_front_page {
    /**
     * 获取位置信息
     * @return <mixed>
     */
    public static function get_location(){ 
        $service = new ProfileService();
        $province = $service->get_province_list();
        foreach ($province as $key => $value) {
            $province[$key]['children'] =  FactoryVMap::list_to_models($service->get_city_list($value['code']), 'common_common_location');
        }
        $data = FactoryVMap::list_to_models($province, 'common_common_location');
        return $data;
    }
    
    /**
     * 获取省份列表
     * @return mixed 
     */
    public static function get_province_list(){
        $service = new LocationService();
        $province = $service->get_province_list(false);
        return FactoryVMap::list_to_models($province, 'common_common_location');
    }
    
    /**
     * 获取地区列表
     * @return mixed 
     */
    public static function get_area_list(){
        $array = array(
            1 => array('code' => 1, 'name' => '华北地区'),
            2 => array('code' => 2, 'name' => '华东地区'),
            3 => array('code' => 3, 'name' => '华南地区'),
            4 => array('code' => 4, 'name' => '西南地区'),
            5 => array('code' => 5, 'name' => '东北地区'),
            6 => array('code' => 6, 'name' => '华中地区'),
            7 => array('code' => 7, 'name' => '西北地区')
        );
        return FactoryVMap::list_to_models($array, 'common_common_location');
    }
    
    /**
     * 获取指定分类的子分类
     * @param  <int>  $id      分类编号
     * @param  <int>  $role_id 角色编号
     * @param  <char> $first_letter 首字母
     * @return <mixed>
     */
    public static function get_labels($id, $role_id = null, $first_letter = null){
        $service = new LabelService();
        $data = FactoryVMap::list_to_models($service->get_children($id, $role_id, $first_letter), 'common_common_label');
        return $data;
    }

    /**
     * 猜你喜欢
     */
    public static function guess_you_like($size){
        //暂未提供猜你喜欢，使用最新发布代替
        return home_index_index_page::it_post();
    }

    /**
     * 最近浏览
     */
    public static function get_nearby_scan($size){
        $service = new TaskService();
        $data = $service->get_tasks_by_scan(AccountInfo::get_user_id(), null, null, null, 1, $size);
        $data = FactoryVMap::list_to_models($data, 'home_task_scan');
        return $data;
    }

    /**
     * 获取角色列表
     */
    public static function get_roles(){
        $service = new PermissionService();
        $data    = $service->get_role_list();                   //获取系统角色列表
        $data    = FactoryVMap::list_to_models($data, 'common_common_role');
        return $data;
    }

    /**
     * 获取首字母列表
     * @param  <int> $id
     * @return <mixed>
     */
    public static function get_first_letter_group($id){
        $service = new LabelService();
        $data    = $service->group_first_letter($id);                   //获取首字母列表
        $data    = FactoryVMap::list_to_models($data, 'home_lib_flgroup');
        return $data;
    }

    /**
     * 获取银行列表
     */
    public static function get_banks(){
        $service = new BankService();
        $data    = $service->get_bank_list();
        $data    = FactoryVMap::list_to_models($data, 'common_common_bank');
        return $data;
    }

    /**
     * 获取头部信息
     */
    public static function get_header($logined){
        if($logined){
            $array['status'] = 1;
            $array['uname']  = P('name');
        }
        else{
            $array['status'] = 0;
        }
        return FactoryVMap::array_to_model($array, 'common_common_header');
    }

    /**
     * 获取用户推广位信息
     */
    public static function get_promote(){
        
    }
}
?>
