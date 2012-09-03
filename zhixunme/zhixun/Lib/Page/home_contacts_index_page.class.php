<?php
/**
 * Description of home_contacts_index_page
 *
 * @author moi
 */
class home_contacts_index_page {
    /**
     * 获取用户的关注列表
     * @param  <int> $user_id 用户编号
     * @param  <int> $type    用户类型
     * @param  <int> $page    第几页
     * @param  <int> $size    每页几条
     * @return <mixed>
     */
    public static function get_follow_list($user_id, $type, $page, $size){
        if(empty($size))
            $size = C('SIZE_FOLLOW');
        $service = new ContactsService();
        $list = $service->get_follow_list($user_id, $type, $page, $size);
        $service = new UserService();
        $csvc = new CertificateService();
        $psvc = new ProvinceService();
        foreach($list as $key => $value){
            $list[$key]['_info'] = $service->get_data_info($value['data_id'], $value['role_id']);
            if($value['role_id'] == C('ROLE_TALENTS')){
                $list[$key]['_cert'] = $csvc->getRegisterCertificateListByHuman($value['data_id']);;
            }
            $list[$key]['_info']['activity'] = $service->get_user_activity($value['user_id']);
        }
        return FactoryVMap::list_to_models($list, 'home_contacts_follow');
    }
    
    /**
     * 获取用户的关注列表数量
     * @param  <int> $user_id 用户编号
     * @param  <int> $type    用户类型
     * @return <int>
     */
    public static function get_follow_count($user_id, $type){
        $service = new ContactsService();
        return $service->get_follow_list($user_id, $type, null, null, null, true);
    }

    /**
     * 获取关注的动态列表
     * @param  <int>  $type 用户类型
     * @param  <int>  $page 第几页
     * @param  <int>  $size 每页几条
     * @param  <int>  $user_id 用户编号
     * @return <mixed>
     */
    public static function get_follow_moving($type, $page, $size, $user_id){
        $service = new ContactsService();
        $list = $service->get_follow_moving($user_id, $type, $page, $size);
        return FactoryVMap::list_to_models($list, 'home_contacts_moving');
    }
    
    /**
     * 获取关注的动态列表
     * @param  <int>  $type 用户类型
     * @param  <int>  $user_id 用户编号
     * @return <mixed>
     */
    public static function get_follow_moving_count($type, $user_id){
        $service = new ContactsService();
        return $service->get_follow_moving($user_id, $type, null, null, true);
    }
}
?>
