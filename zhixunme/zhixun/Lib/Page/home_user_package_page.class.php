<?php
/**
 * Description of home_user_package_page
 *
 * @author moi
 */
class home_user_package_page {
    /**
     * 获取套餐列表
     * @param <int> $role_id 角色编号
     */
    public static function get_package_list($role_id){
        $service = new UserService();
        $package = $service->get_packages($role_id);
        $data = FactoryVMap::array_to_model($package, 'home_user_package');
        return $data;
    }
}
?>
