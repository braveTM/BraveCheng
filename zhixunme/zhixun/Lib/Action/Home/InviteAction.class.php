<?php
/**
 * Module:025
 */
class InviteAction extends BaseAction {
    /**
     * 好友邀请页面01111
     */
    public function index() {
        $service = new InviteService();
        $invite = $service->get_invite(AccountInfo::get_user_id());
        $this->assign('icode', C('WEB_ROOT').'/tregister/'.$invite['code']);
        $this->display();
    }
    
    /**
     * 短信邀请01111 
     */
    public function do_invite_sms(){
        if (!$this->is_legal_request())
            return;
        $service = new InviteService();
        $result = $service->invite_by_sms(AccountInfo::get_user_id(), P('name'), $_POST['phones']);
        if(is_zerror($result))
            echo jsonp_encode(false, $result->get_message());
        else
            echo jsonp_encode(true);
    }
    
    /**
     * 邮件邀请01111 
     */
    public function do_invite_email(){
        if (!$this->is_legal_request())
            return;
        $service = new InviteService();
        $result = $service->invite_by_email(AccountInfo::get_user_id(), P('name'), $_POST['emails']);
        if(is_zerror($result))
            echo jsonp_encode(false, $result->get_message());
        else
            echo jsonp_encode(true);
    }
}
?>

