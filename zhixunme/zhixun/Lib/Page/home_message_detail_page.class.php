<?php
/**
 * Description of home_message_detail_page
 *
 * @author moi
 */
class home_message_detail_page {
    /**
     * 获取页面信息
     */
    public static function get_page_info($id){
        $user_id = AccountInfo::get_user_id();              //获取当前用户编号
        $service = new MessageService();
        $message = $service->get_message($id);              //获取指定信息
        if(empty($message))                                 //指定信息不存在
            return null;
        $profile = array();
        if($message['from_id'] == $user_id && $message['from_show'] == 1){
            //如果当前用户是信息的发送人并且此条信息对自己可见
            $uservice = new UserService();
            $user = $uservice->get_user($message['to_id']);
        }
        else if($message['to_id'] == $user_id && $message['to_show'] == 1){
            //如果当前用户是信息的接收人并且此条信息对自己可见
            if($message['from_id'] == 0){                   //如果为系统消息，使用系统头像
                $user['photo']   = C('PATH_SYSTEM_PHOTO');
                $user['user_id'] = $message['from_id'];
                $user['name']    = $message['from_name'];
            }
            else{                                           //用户私人消息，获取对方资料
                $uservice = new UserService();
                $user = $uservice->get_user($message['from_id']);
            }
            if($message['to_read'] == 0){                   //若该条为未读消息，则设置状态为已读
                $service->set_to_read($id);
            }
        }
        else{
            return null;
        }
        $array['id']      = $message['id'];
        $array['title']   = $message['title'];
        $array['content'] = $message['content'];
        $array['date']    = $message['date'];
        $array['uid']     = $user['user_id'];
        $array['uname']   = $user['name'];
        $array['uphoto']  = $user['photo'];
        $data = FactoryVMap::array_to_model($array, 'home_message_detail');
        return $data;
    }
}
?>
