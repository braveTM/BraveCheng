<?php
/**
 * Description of home_user_index_page
 *
 * @author moi
 */
class home_user_index_page {
    /**
     * 获取页面信息
     */
    public static function get_page_info(){
        $profile = P();
        if(empty($profile)) exit();             //用户不存在，中断程序，退出
        $pservice = new ProfileService();
        $profile['_province'] = $pservice->get_province($profile['province_id']);       //获取省份信息
        if(!empty($profile['_province']))
            $profile['_city'] = $pservice->get_city($profile['city_id']);               //省份存在，则获取城市信息
        $tservice = new TaskService();
        $dservice = new DelegateService();
        $profile['_count']['tcount']  = $tservice->get_tasks_by_replyed(AccountInfo::get_user_id(), 1, null, null, 1, 1, null, true);
        $profile['_count']['wtcount'] = $tservice->get_tasks_by_user_id(AccountInfo::get_user_id(), 1, 1, 1, null, true);
        $profile['_count']['dcount']  = $tservice->get_tasks_by_replyed(AccountInfo::get_user_id(), 1, C('DELES_ID'), null, 1, 1, null, true);
        $profile['_count']['wdcount'] = $dservice->get_delegates(AccountInfo::get_user_id(), null, 2, null, null, 1, 1, null, true);
        $bservice = new BillService();
        $profile['_bill'] = $bservice->get_bill_info(AccountInfo::get_user_id());
        return FactoryVMap::array_to_model($profile, 'home_user_index');
    }

    /**
     * 我的消息
     */
    public static function get_messages(){
        $service = new MessageService();
        $data = $service->get_in_messages(AccountInfo::get_user_id(), 1, C('SIZE_MESSAGE_LESS'), null, null, true);
        return FactoryVMap::list_to_models($data, 'home_message_list');
    }

    /**
     * 获取当前登录用户联系方式
     * @param <bool>　$n 为空时是否输出替代字符串
     */
    public static function get_contact($n = false){
        if(!AccessControl::is_logined()){
            return null;
        }
        else{
            $service        = new UserService();
            $data = $service->get_data_info(AccountInfo::get_data_id(), AccountInfo::get_role_id());
            $array['email'] = $data['contact_email'];
            $array['phone'] = $data['contact_mobile'];
            $array['qq']    = $data['contact_qq'];
            if($n)
                return FactoryVMap::array_to_model($array, 'home_user_ncontact');
            return FactoryVMap::array_to_model($array, 'home_user_contact');
        }
    }
}
?>
