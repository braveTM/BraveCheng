<?php
/**
 * Description of home_message_msglist_page
 *
 * @author moi
 */
class home_message_msglist_page {
    /**
     * 获取页面信息
     */
    public static function get_page_info(){
        $service = new MessageService();
        $array['unread_s'] = $service->get_unread_count(AccountInfo::get_user_id(), 1);             //系统消息未读条数
        $array['unread_p'] = $service->get_unread_count(AccountInfo::get_user_id(), 2);             //个人消息未读条数
        if($array['unread_s'] != 0)
            $array['unread_slist'] = FactoryVMap::list_to_models ($service->get_unread_list(AccountInfo::get_user_id(), 1, C('SIZE_UNREAD_MESSAGE'), 1), 'home_message_list');
        if($array['unread_p'] != 0)
            $array['unread_plist'] = FactoryVMap::list_to_models ($service->get_unread_list(AccountInfo::get_user_id(), 1, C('SIZE_UNREAD_MESSAGE'), 2), 'home_message_list');
        return FactoryVMap::array_to_model($array, 'home_message_page');
    }

    /**
     * 获取站内信列表
     * @param  <int> $page 第几页
     * @param  <int> $type 列表类别
     * @param  <int> $read 是否已读
     * @return <mixed> 列表
     */
    public static function get_list($page = 1, $type = 1, $read = 2){
        if($read != 0 && $read != 1)
            $read = null;
        $service = new MessageService();
        if($type == 1){
            //全部
            $data = $service->get_in_messages(AccountInfo::get_user_id(), $page, C('SIZE_MESSAGE'), null, $read);
        }
        else if($type == 2){
            //系统信息
            $data = $service->get_in_messages(AccountInfo::get_user_id(), $page, C('SIZE_MESSAGE'), 1, $read);
        }
        else if($type == 3){
            //个人收件箱
            $data = $service->get_in_messages(AccountInfo::get_user_id(), $page, C('SIZE_MESSAGE'), 2, $read);
        }
        else if($type == 4){
            //已发送
            $data = $service->get_outbox_messages(AccountInfo::get_user_id(), $page, C('SIZE_MESSAGE'));
        }
        return FactoryVMap::list_to_models($data, 'home_message_list');
    }

    /**
     * 获取站内信总条数
     * @param  <int> $page 第几页
     * @param  <int> $type 列表类别
     * @param  <int> $read 是否已读
     * @return <mixed> 总条数
     */
    public static function get_messages_count($type = 1, $read = 2){
        if($read != 0 && $read != 1)
            $read = null;
        $service = new MessageService();
        if($type == 1){
            //全部
            $count = $service->get_in_messages_count(AccountInfo::get_user_id(), null, $read);
        }
        else if($type == 2){
            //系统信息
            $count = $service->get_in_messages_count(AccountInfo::get_user_id(), 1, $read);
        }
        else if($type == 3){
            //个人收件箱
            $count = $service->get_in_messages_count(AccountInfo::get_user_id(), 2, $read);
        }
        else if($type == 4){
            //已发送
            $count = $service->get_out_messages_count(AccountInfo::get_user_id());
        }
        return $count;
    }
}
?>
