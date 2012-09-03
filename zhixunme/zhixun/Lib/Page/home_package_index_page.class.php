<?php
/**
 * Description of home_package_index_page
 *
 * @author moi
 */
class home_package_index_page {
//    /**
//     * 获取套餐使用情况
//     */
//    public static function get_package_use(&$service, &$package){
//        $service = new UserService();
//        $package = $service->get_package(AccountInfo::get_package());
//        $tsvc = new TaskService();
//        //计算当日剩余免费发布任务条数
//        if($package['day_task_post'] == -1){
//            $array['tsc'] = '无限';
//        }
//        else{
//            $tc   = $tsvc->get_task_list(null, null, null, date_f('Y-m-d'), null, 1, 1, null, true);
//            $array['tsc']  = $package['day_task_post'] > $tc ? $package['day_task_post'] - $tc : 0;
//        }
//        //计算当日剩余免费竞标任务条数
//        if($package['day_task_bid'] == -1){
//            $array['bsc'] = '无限';
//        }
//        else{
//            $bc   = $tsvc->get_tasks_by_replyed(AccountInfo::get_user_id(), null, null, null, 1, 1, null, true);
//            $array['bsc']  = $package['day_task_bid'] > $bc ? $package['day_task_bid'] - $bc : 0;
//        }
//        //计算当日剩余免费查看普通用户联系方式条数
//        $array['ssc'] = 6;
//        //计算当日剩余免费委托次数
//        if($package['day_delegate'] == -1){
//            $array['dsc'] = '无限';
//        }
//        else{
//            $dsvc = new DelegateService();
//            $dc   = $dsvc->get_delegates(AccountInfo::get_user_id(), null, null, null, null, 1, 1, null, true, date_f('Y-m-d'));
//            $array['dsc'] = $package['day_delegate'] > $dc ? $package['day_delegate'] - $dc : 0;
//        }
//        return FactoryVMap::array_to_model($array, 'home_package_use');
//    }
//
//    /**
//     * 获取当前套餐使用情况
//     */
//    public static function get_current_package($service, $package){
//        if(empty($package)){
//            if(empty($service))
//                $service = new UserService();
//            $package = $service->get_package(AccountInfo::get_package());
//        }
//        return FactoryVMap::array_to_model($package, 'home_user_package');
//    }
//
//    /**
//     * 可选套餐
//     */
//    public static function get_package_list($service){
//        if(empty($service)){
//            $service = new UserService();
//        }
//        $list = $service->get_packages(AccountInfo::get_role_id(), true, AccountInfo::get_package());
//        return FactoryVMap::list_to_models($list, 'home_user_package');
//    }
//
//    /**
//     * 获取套餐到期时间
//     */
//    public static function get_package_deadline($service){
//        if(empty($service)){
//            $service = new UserService();
//        }
//        $result = $service->get_account(AccountInfo::get_user_id());
//        return $result->__get('expired');
//    }

    /**
     * 获取当前使用套餐信息
     * @param  <int>   $user_id 用户编号
     * @param  <mixed> $package 套餐
     * @return <mixed>
     */
    public static function get_current_package($user_id){
        $usvc = new UserService();
        $user = $usvc->get_account($user_id, 'ARRAY');
        if(!empty($user['package'])){
            $service = new PackageService();
            $array['package'] = $service->get_package($user['package']);
            $array['precord'] = $service->get_package_record($user_id);
            $array['modules'] = $service->get_package_record_free_list($array['precord']['id']);
            $data = FactoryVMap::array_to_model($array, 'home_package_current');
            return $data;
        }
        else{
            return null;
        }
    }

    /**
     * 获取套餐信息
     */
    public static function get_package_info($package_id){
        $service = new PackageService();
        $array['package'] = $service->get_package($package_id);
        $array['modules'] = $service->get_package_modules($package_id);
        $data = FactoryVMap::array_to_model($array, 'home_package_current');
        return $data;
    }
    
    /**
     * 获取可选套餐信息列表
     * @param  <int> $user_id 用户编号
     * @param  <int> $role_id 用户组编号
     * @param  <int> $current 当前使用套餐
     * @return <mixed>
     */
    public static function get_package_list($user_id, $role_id, $current){
        $service = new PackageService();
        $list = $service->get_package_list($role_id);
        foreach ($list as $key => $value) {
            $modules = $service->get_package_modules($value['id']);
            if($value['id'] == $current)
                $list[$key]['current'] = 1;
            else
                $list[$key]['current'] = 0;
            $list[$key]['modules'] = FactoryVMap::list_to_models($modules, 'home_pm_relation');
        }
        return FactoryVMap::list_to_models($list, 'home_package_list');
    } 
    
    /**
     * 获取免费套餐
     * @param int $role_id 角色编号
     * @return mixed 
     */
    public static function get_free_package($role_id){
        $service = new PackageService();
        $package = $service->get_free_package($role_id);
        $package['modules'] = FactoryVMap::list_to_models($service->get_package_modules($package['id']), 'home_package_module');
        return FactoryVMap::array_to_model($package, 'home_package_list');
    }
}
?>
