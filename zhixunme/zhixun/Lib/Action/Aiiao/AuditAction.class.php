<?php

/**
 * Description of AuditAction
 *
 * @author moi
 */
class AuditAction {

    /**
     * 实名认证通知
     */
    public function real_auth_notify() {
        $sup = array($_GET['uid'], $_GET['status']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        if ($_GET['status'] == 1) {
            $tid = C('NOTIFY_REAL_SUC');
        } else {
            $tid = C('NOTIFY_REAL_FAIL');
        }
        $service = new NotifyService();
        $service->send_notify($_GET['uid'], null, $tid, $_GET['fail']);
        $service = new UserService();
        $service->update_user_session($_GET['uid'], time());       //清除用户缓存
    }

    /**
     * 证书认证通知
     */
    public function cert_auth_notify() {
        $sup = array($_GET['uid'], $_GET['status']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        if ($_GET['status'] == 1) {
            $tid = C('NOTIFY_CERT_SUC');
        } else {
            $tid = C('NOTIFY_CERT_FAIL');
        }
        $service = new NotifyService();
        $service->send_notify($_GET['uid'], null, $tid, $_GET['content']);
    }

    /**
     * 充值通知
     */
    public function recharge_notify() {
        $sup = array($_GET['uid'], $_GET['money']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        $service = new NotifyService();
        $service->send_notify($_GET['uid'], null, C('NOTIFY_RECHARGE'), $_GET['money']);
    }

    /**
     * 资讯认证通知 
     */
    public function blog_auth_notify() {
        $sup = array($_GET['uid'], $_GET['status']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        if ($_GET['status'] == 3) {
            $code = $_GET['id'];
            $tid = C('NOTIFY_BLOG_SUC');
        } elseif ($_GET['status'] == 4) {
            $content = $_GET['content'];
            $code = "您发布的心得未通过审核.$content<a class='blue' href='http://www.zhixun.me/article/1/$_GET[id]'>点此查看</a>！";
            $tid = C('NOTIFY_BLOG_FAIL');
        }
        $service = new NotifyService();
        $service->send_notify($_GET['uid'], null, $tid, $code);
    }

    /**
     * 资讯认证通知 
     */
    public function feedback_notify() {
        $sup = array($_GET['uid'], $_GET['status']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        $tid = C('NOTIFY_FEEDBACKC');
        $service = new NotifyService();
        $service->send_notify($_GET['uid'], null, $tid, $_GET['replay']);
    }

    /**
     * 举报通知 
     */
    public function report_notify() {
        $sup = array($_GET['uid'], $_GET['status']);
        debug_log("dd", "Files/user/dd");
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        $tid = C('NOTIFY_REPORT');
        $service = new NotifyService();
        $service->send_notify($_GET['uid'], null, $tid, $_GET['replay']);
    }

    /**
     * 套餐通知 
     */
    public function package_notify() {
        $sup = array($_GET['uid']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        $tid = C('NOTIFY_PAKEAGE');
        $service = new NotifyService();
        $service->send_notify($_GET['uid'], null, $tid, $_GET['content']);
    }

    /**
     * 会员账号冻结通知
     */
    public function user_close_notify() {
        $sup = array($_GET['uid'], $_GET['status']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        $tid = C('NOTIFY_USER_CLOSE');
        $service = new NotifyService();
        $service->send_notify($_GET['uid'], null, $tid, $_GET['content']);
        $service = new UserService();
        $service->update_user_session($_GET['uid'], time());       //清除用户缓存
    }

    /**
     * 会员账号开启通知
     */
    public function user_open_notify() {
        $sup = array($_GET['uid'], $_GET['status']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        $tid = C('NOTIFY_USER_OPEN');
        $service = new NotifyService();
        $service->send_notify($_GET['uid'], null, $tid, $_GET['content']);
        $service = new UserService();
        $service->update_user_session($_GET['uid'], time());       //清除用户缓存
    }

    /**
     * 发送系统通知
     */
    public function system_notify() {
        $sup = array($_GET['mid']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        $service = new NotifyService();
        $service->system_notify($_GET['mid']);
    }

    protected function check_h_a_token($token, $sup) {
        if($_SERVER['SERVER_ADDR'] == '::1')
            $server_ip = ip2long('127.0.0.1');
        else
            $server_ip=  ip2long($_SERVER['SERVER_ADDR']);
        $client_ip= get_client_ip();
        if ($server_ip != $client_ip){
            return false;
        }
        foreach ($sup as $item) {
            $key .= $item;
        }
        return $token == md5('zx_aiiao' . $key);
    }

    /**
     * 投递简历 
     */
    public function send_resume() {
        $sup = array($_GET['sender_id'], $_GET['role_id'], $_GET['job_id'], $_GET['resume_id']);
        if (!$this->check_h_a_token($_GET['token'], $sup)) {
            return;
        }
        $resumeService = new ResumeService();
        $resumeService->sendResumeToJob($_GET['sender_id'], $_GET['role_id'], $_GET['job_id'], $_GET['resume_id']);
    }

}

?>
