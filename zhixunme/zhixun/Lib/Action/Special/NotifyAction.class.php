<?php
/**
 * Description of EmailAction
 *
 * @author moi
 */
class NotifyAction extends Action{
    /**
     * 发送通知
     */
    public function send(){
        set_time_limit(0);
        if($_GET['token'] != email_token())
            exit();
        $service = new NotifyService();
        $service->send_notify($_GET['uids'], $_GET['rids'], $_GET['tid'], $_GET['code']);
    }

    /**
     * 发送邮件
     */
    public function semail(){
        ignore_user_abort(true);
        set_time_limit(0);
        $service = new NotifyService();
        $service->send_email($_GET['email'], $_GET['tid'], $_GET['uid'], $_GET['code'],$_GET['arg']);
    }
    
    /**
     * 普通邮件发送 
     */
    public function nemail(){
        set_time_limit(0);
        $service = new NotifyService();
        $service->normal_email($_POST['email'], $_POST['title'], $_POST['content']);
    }

    /**
     * 简历邀请通知
     */
    public function invite_resume(){
        set_time_limit(0);
        $service = new NotifyService();
        echo $service->invite_resume_notify($_GET['jid'], $_GET['rid']);
    }
}
?>
