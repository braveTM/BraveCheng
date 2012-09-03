<?php
set_time_limit(0);                                                              //设置脚本永不超时
/**
 * Module:018                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            in
 */
class RemindAction extends BaseAction {
    /**
     * 获取站内提醒01111
     */
    public function get_remind(){
        //轮询中增加对用户更新在线状态
        $service = new UserService();
        $service->update_user_last_visit(AccountInfo::get_user_id());
        
        session_write_close();                                                  //释放SESSION独占锁
        $service = new RemindService();
        $data = $service->init_remind(AccountInfo::get_user_id());              //初始化提醒数据
        if(!empty($data)){
            echo jsonp_encode(true, $data);                                     //返回提醒数据
        }
        else
            echo jsonp_encode(false);
//        //长连接方式
//        $session_id = session_id();
//        session_write_close();                                                  //释放SESSION独占锁
//        $user_id = AccountInfo::get_user_id();
//        $service = new RemindService();
//        $data = $service->init_remind($user_id);                                //初始化提醒数据
//        if(!empty($data)){
//            echo jsonp_encode(true, $data);                                     //返回提醒数据
//            return;
//        }
//        $key = md5(time().$user_id.rand_string());                              //生成会话ID
//        $generate = $service->generate_session($key, $user_id, $session_id);    //生成会话记录
//        if(is_zerror($generate)){
//            echo jsonp_encode(false, $generate->get_message());
//            return;
//        }
//        $i = 0;
//        while(true){
//            if(!$service->exists_remind_client($key)){                          //客户端不存在
//                break;
//            }
//            $data = $service->get_remind($key);                                 //获取提醒数据
//            if(!empty($data)){
//                echo jsonp_encode(true, $data);
//                $service->clear_remind($key, $user_id);                         //清除提醒数据
//                $service->clear_remind_client($session_id);                     //清除客户端
//                return;
//            }
//            $i++;
//            if($i > 15)                                                         //设置半分钟分钟为超时时间
//                break;
//            sleep(1);                                                           //设置延时
//        }
//        $service->clear_remind_client($session_id);                             //清除客户端
//        echo jsonp_encode(false);
    }
}
?>
