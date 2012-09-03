<?php
header('content-type:text/html;charset=utf-8');
/**
 * Module:008
 */
class MessageAction extends BaseAction{
    /**
     * 我的消息页01110
     */
    public function msglist(){
        $this->assign('msg', home_message_msglist_page::get_page_info());           //页面数据
        $this->display();
    }
    
    /**
     * 我的消息详细页01110
     */
    public function detail(){
        $detail = home_message_detail_page::get_page_info($_GET['id']);
        if(empty($detail))
            redirect(C('ERROR_PAGE'));
        $this->assign('detail', $detail);           //页面数据
        $this->display();
    }

    /**
     * 获取站内信列表01110
     */
    public function get_messages(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_message_msglist_page::get_list($_POST['page'], $_POST['type'], $_POST['read']);
        if(empty ($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data, home_message_msglist_page::get_messages_count($_POST['type'], $_POST['read']));
        }
    }

    /**
     * 发站内信00000
     */
    public function do_send(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new MessageService();
        $result  = $service->send(AccountInfo::get_user_id(), P('name'), $_POST['id'], $_POST['name'], $_POST['title'], $_POST['content'], 0, 2);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 标记为已读01110
     */
    public function do_read(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new MessageService();
        $result  = $service->mark_read(AccountInfo::get_user_id(), $_POST['ids']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 系统留言11111
     */
    public function do_send_system(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new MessageService();
        if(AccessControl::is_logined()){
            $uid   = -AccountInfo::get_user_id();
            $uname = P('name');
        }
        else{
            $uid   = -1;
            $uname = '游客';
        }
        $result  = $service->send($uid, $uname, 0, C('WEB_NAME'), '留言', $_POST['content'], 0, 2);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }
    
    /**
     * 消息删除01110
     */
    public function do_delete_messeges(){
    	if(!$this->is_legal_request())      //是否合法请求
            return;
    	$service = new MessageService();
        $result  = $service->delete_messeges($_POST['ids']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }
}
?>