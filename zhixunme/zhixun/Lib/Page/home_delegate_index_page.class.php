<?php
/**
 * Description of home_delegate_index_page
 *
 * @author moi
 */
class home_delegate_index_page {
    /**
     * 获取页面数据
     */
    public static function get_page_info(){
        $array['tab']  = $_GET['tab'];
        if(!empty($_GET['id'])){
            $service = new UserService();
            $role_id = $service->get_role_by_id($_GET['id']);
            if($role_id != C('ROLE_AGENT')){
                $array['id']   = 0;
                $array['name'] = '';
            }
            else{
                $svc = new ProfileService();
                $pro = $svc->get_profile_by_user_id($_GET['id']);
                $array['id']   = $pro['user_id'];
                $array['name'] = $pro['user_name'];
            }
        }
        return FactoryVMap::array_to_model($array, 'home_delegate_index');
    }
}
?>
