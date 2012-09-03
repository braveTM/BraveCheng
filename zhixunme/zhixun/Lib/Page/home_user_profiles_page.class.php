<?php
/**
 * Description of home_user_profiles_page
 *
 * @author moi
 */
class home_user_profiles_page {
    /**
     * 获取当期用户标签列表
     * @return <mixed>
     */
    public static function get_user_labels(){
        $service = new LabelService();
        return FactoryVMap::list_to_models($service->get_user_labels(AccountInfo::get_user_id()), 'common_common_label');
    }

    /**
     * 获取用户资料信息
     * @return <mixed>
     */
    public static function get_profile(){
        $data = P();
        return FactoryVMap::array_to_model($data, 'home_user_profiles');
    }

    /**
     * 获取用户认证信息
     * @return <mixed>
     */ 
    public static function get_auth(){
        $data = P();
        $user_id = AccountInfo::get_user_id();
        $service = new AuthService();
        if($data['is_real_auth'] == 1){
            $real = $service->get_real_auth($user_id);
            $data['a_real_name'] = $real['_info']['name'];
            $data['a_real_num']  = $real['_info']['number'];
        }
        else{
            $real = $service->get_real_auth($user_id);
            if(!empty($real) && $real['status'] == 0)
                $data['wait_real'] = 1;         //实名认证等待审核中
        }
        if($data['is_phone_auth'] == 1){
            $phone = $service->get_phone_auth($user_id);
            $data['a_phone'] = $phone['phone'];
        }
        if($data['is_email_auth'] == 1){
            $email = $service->get_email_auth($user_id);
            $data['a_email'] = $email['email'];
        }
        return FactoryVMap::array_to_model($data, 'home_user_auth');
    }
}
?>
