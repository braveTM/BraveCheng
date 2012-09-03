<?php

/**
 * Description of NotifyService
 *
 * @author moi
 */
class NotifyService {

    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function __construct() {
        $this->provider = new NotifyProvider();
    }

    /**
     * 获取通知模版
     * @param  <int> $id 模版编号
     * @return <array> 模版信息
     */
    public function get_notify_tpl($id) {
        $data = $this->provider->get_notify_tpl($id);
        return $data;
    }

    /**
     * 获取通知模版(不使用缓存)
     * @param  <int> $id 模版编号
     * @return <array> 模版信息
     */
    public function get_notify_tpl_no_cache($id) {
        return $this->provider->get_notify_tpl($id);
    }

    /**
     * 添加通知模版
     * @param  <string> $title   标题
     * @param  <string> $content 内容
     * @param  <string> $remark  备注
     * @param  <int>    $fixed   是否固定模版
     * @param  <int>    $m       是否发送站内信
     * @param  <int>    $e       是否发送邮件
     * @param  <int>    $s       是否发送短信
     * @return <int> 模版编号
     */
    public function add_notify_tpl($title, $content, $remark, $fixed, $m, $e, $s) {
        $title = $this->filter_title($title);
        $content = $this->filter_content($content);
        $remark = $this->filter_remark($remark);
        $fixed = $this->filter_whether($fixed);
        $m = $this->filter_whether($m);
        $e = $this->filter_whether($e);
        $s = $this->filter_whether($s);
        $result = $this->provider->add_notify_tpl($title, $content, $remark, $fixed, $m, $e, $s);
        if ($result == false)
            return E(ErrorMessage::$OPERATION_FAILED);
        return $result;
    }

    /**
     * 发送通知
     * @param <string> $user_ids 用户编号（多个间用逗号隔开）
     * @param <string> $role_ids 角色编号（多个间用逗号隔开）
     * @param <int>    $tpl_id
     * @param <string> $code
     */
    public function send_notify($user_ids, $role_ids, $tpl_id, $code) {
        $notify = $this->provider->get_notify_tpl($tpl_id);     //获取指定通知模版
        if (empty($notify)) {
            return;                                             //指定模版不存在
        }
        if ($notify['message'] == 1) {
            $mn = new MessageNotify();                          //启用站内信通知
        }
        if ($notify['email'] == 1) {
            $en = new EmailNotify();                            //启用邮件通知
        }
        if ($notify['sms'] == 1) {
            $sn = new SMSNotify();                              //启用短信通知
            $service = new UserService();
        }
        $date = date_f('Y-m-d');                                //获取当期日期
        $provider = new UserProvider();
        if (!empty($role_ids)) {                                  //通知指定角色所有用户
            $rarray = explode(',', $role_ids);                  //实现待定
        } else {                                                   //通知指定用户
            $uarray = explode(',', $user_ids);
            foreach ($uarray as $uid) {                         //循环用户
                $user = $provider->get_user_by_id($uid);        //获取指定用户账户信息
                if (empty($user))
                    continue;                                   //用户不存在进入下一次循环

                    
                //通知内容自定义标签替换
                $content = notify_replace($notify['content'], $user->__get('user_name'), $date, $code);
                $mess_content = notify_replace($notify['mess_content'], $user->__get('user_name'), $date, $code);
                
                if ($mn != null) {                                //站内信通知
                    $mn->send($user->__get('user_id'), $user->__get('user_name'), $notify['title'], $mess_content);
                }
                if ($en != null) {                                //邮件通知
                    $en->send($user->__get('email'), $user->__get('user_name'), $notify['title'], $content);
                }
                if ($sn != null && strlen($user['phone']) == 11) {                                //短信通知
                    //如果用户在线则取消短信通知，改为站内信通知
                    if (!$service->check_user_online($user->__get('user_id')))
                        $sn->send($user->__get('phone'), $user->__get('user_name'), $notify['title'], $content);
                    else if ($mn == null)
                        $mn->send($user->__get('user_id'), $user->__get('user_name'), $notify['title'], $mess_content);
                }
            }
        }
    }

//    /**
//     * 系统通知
//     * @param <string> $user_ids 用户编号（多个间用逗号隔开）
//     * @param <string> $role_ids 角色编号（多个间用逗号隔开）
//     * @param <int>    $mes
//     */
//    public function system_notify($user_ids, $role_ids, $mes){
//        $service = new MessageService();
//        $notify = $service->get_system_message($mes);
//        if(empty($notify)){
//            return;                                             //指定模版不存在
//        }
//        if($notify['is_message'] == 1){
//            $mn = new MessageNotify();                          //启用站内信通知
//        }
//        if($notify['is_mail'] == 1){
//            $en = new EmailNotify();                            //启用邮件通知
//        }
//        if($notify['is_phone'] == 1){
//            $sn = new SMSNotify();                              //启用短信通知
//            $service = new UserService();
//        }
//        $date = date_f('Y-m-d');                                //获取当期日期
//        $provider = new UserProvider();
//        if(!empty($role_ids)){                                  //通知指定角色所有用户
//            $rarray = explode(',', $role_ids);
//            foreach($rarray as $role){
//                $i = 1;
//                while(true){
//                    $list = $provider->get_users($role, $i, 30);
//                    if(empty($list))
//                        break;
//                    foreach($list as $item){
//                        //通知内容自定义标签替换
//                        $content = notify_replace($notify['content'], $user['name'], $date, $code);
//                        if($mn != null){                                //站内信通知
//                            $mn->send($user['user_id'], $user['name'], $notify['title'], $content);
//                        }
//                        if($en != null){                                //邮件通知
//                            $en->send($user['email'], $user['name'], $notify['title'], $content);
//                        }
//                        if($sn != null){                                //短信通知
//                            //如果用户在线则取消短信通知，改为站内信通知
//                            if(!$service->check_user_online($user->__get('user_id')))
//                                $sn->send($user['phone'], $user['name'], $notify['title'], $content);
//                            else if($mn == null)
//                                $mn->send($user['user_id'], $user['name'], $notify['title'], $content);
//                        }
//                    }
//                }
//            }
//        }
//        else{                                                   //通知指定用户
//            $uarray = explode(',', $user_ids);
//            foreach ($uarray as $uid) {                         //循环用户
//                $user = $provider->get_user_by_id($uid);        //获取指定用户账户信息
//                if(empty($user))
//                    continue;                                   //用户不存在进入下一次循环
//                //通知内容自定义标签替换
//                $content = notify_replace($notify['content'], $user->__get('user_name'), $date, $code);
//                if($mn != null){                                //站内信通知
//                    $mn->send($user->__get('user_id'), $user->__get('user_name'), $notify['title'], $content);
//                }
//                if($en != null){                                //邮件通知
//                    $en->send($user->__get('email'), $user->__get('user_name'), $notify['title'], $content);
//                }
//                if($sn != null){                                //短信通知
//                    //如果用户在线则取消短信通知，改为站内信通知
//                    if(!$service->check_user_online($user->__get('user_id')))
//                        $sn->send($user->__get('phone'), $user->__get('user_name'), $notify['title'], $content);
//                    else if($mn == null)
//                        $mn->send($user->__get('user_id'), $user->__get('user_name'), $notify['title'], $content);
//                }
//            }
//        }
//    }

    /**
     * 给指定邮箱发送邮件
     * @param  <type> $email
     * @param  <type> $tpl_id
     * @param  <type> $uid
     * @param  <type> $code
     * @param  <string> $arg
     * @return <type>
     */
    public function send_email($email, $tpl_id, $uid, $code, $arg) {
        $notify = $this->provider->get_notify_tpl($tpl_id);     //获取指定通知模版
        if (empty($notify)) {
            return;                                             //指定模版不存在
        }
        $en = new EmailNotify();                                //启用邮件通知
        $date = date_f('Y-m-d');                                //获取当前日期
        $provider = new UserProvider();
        $user = $provider->get_user_by_id($uid);                //获取指定用户账户信息
        if (empty($user)) {
            $uname = '尊敬的' . C('WEB_NAME') . '用户';
        } else {
            $uname = $user->__get('user_name');
        }
        //通知内容自定义标签替换
        $content = notify_replace($notify['content'], $uname, $date, $code, $arg);
        //邮件通知
        $en->send($email, $uname, $notify['title'], $content);
    }

    /**
     * 普通邮件发送
     * @param string $email 邮箱
     * @param string $title 邮件标题 
     * @param string $content 内容
     */
    public function normal_email($email, $title, $content) {
        $en = new EmailNotify();
        $array = explode(',', $email);
        foreach ($array as $em) {
            if (var_validation($em, VAR_EMAIL))
                $en->send($em, '尊敬的用户', $title, $content);
        }
    }

    /*
     * 简历邀请通知
     */

    public function invite_resume_notify($jid, $rid) {
        $service = new ResumeService();
        $resume = $service->getResume($_GET['rid']);
        if (empty($resume))
            return;
        $key = C('INRE_PREFIX') . md5(time() . $jid . $rid . rand_string());
        $jsvc = new JobService();
        $job = $jsvc->get_job($jid);
        if (empty($job))
            return;
        $usvc = new UserService();
        if ($resume['agent_id'] != 0) {                   //简历在经纪人手上
            $msvc = new MiddleManService();
            $user = $usvc->get_user($resume['agent_id']);
            $data = $msvc->get_agent($user['data_id']);
        } else {
            $hsvc = new HumanService();
            $data = $hsvc->get_human_by_resume($rid);
            $user = $usvc->get_user_by_data($data['human_id'], 1);
        }
        $service = new SMSRecordService();
        if (!is_zerror($service->inviteResumeNotify($jid, $rid, $key)) && !empty($data)) {
            if (!$usvc->check_user_online($user['user_id']) && !empty($user['phone'])) {                    //用户不在线
                require_cache(APP_PATH . '/Common/Class/SMS.class.php');
                $sms = SMSFactory::get_object($user['phone'], '尊敬的职讯网用户,职位<' . $job['title'] . '>的发布人邀请你参与简历投递，直接回复Y将完成简历的自动投递，不投递则不需回复');
                $sms->send($key);
            }
            $mes = new MessageService();
            $content = '<div style="line-height: 30px; color: #232323;">
                            ' . $user['name'] . '，你好！有经纪人/企业发现你的求职简历和此招聘职位匹配，特邀你投递简历，点击这里查看此职位详情：<a class="blue" target="_blank" href="' . C('WEB_ROOT') . '/office/' . $job['job_id'] . '">' . $job['title'] . '</a>。
                        </div>';
            $mes->send(0, C('WEB_NAME'), $user['user_id'], $user['name'], '来自<' . $job['company_name'] . '>的简历邀请', $content, 0, 1, false);
            return true;
        }
    }

    public function system_notify($id) {
        $service = new MessageService();
        $message = $service->get_system_message($id);
        if (empty($message)) {
            return;
        }
        if ($message['is_message'] == 1) {
            $mn = new MessageNotify();                          //启用站内信通知
        }
        if ($message['is_email'] == 1) {
            $en = new EmailNotify();                            //启用邮件通知
        }
        if ($message['is_phone'] == 1) {
            $sn = new SMSNotify();                              //启用短信通知
            $service = new UserService();
        }
        $types = explode(',', $message['user_type']);
        $usvc = new UserService();
        foreach ($types as $type) {
            $i = 1;
            while (true) {
                $user = $usvc->get_users_by_role($type, $i, 50);
                if (empty($user))
                    break;
                foreach ($user as $item) {
                    if ($mn != null) {                                //站内信通知
                        $mn->send($item['user_id'], $item['name'], $message['title'], $message['content']);
                    }
                    if ($en != null) {                                //邮件通知
                        $en->send($item['email'], $item['name'], $message['title'], $message['content']);
                    }
                    if ($sn != null) {                                //短信通知
                        //如果用户在线则取消短信通知，改为站内信通知
                        if (!empty($item['phone']) && strlen($item['phone']) == 11)
                            $sn->send($item['phone'], $item['name'], $message['title'], $message['content']);
                    }
                }
                $i++;
            }
        }
//                $user = $provider->get_user_by_id($uid);        //获取指定用户账户信息
//                if(empty($user))
//                    continue;                                   //用户不存在进入下一次循环
//                //通知内容自定义标签替换
//                $content = notify_replace($notify['content'], $user->__get('name'), $date, $code);
//                if($mn != null){                                //站内信通知
//                    $mn->send($user->__get('user_id'), $user->__get('name'), $notify['title'], $content);
//                }
//                if($en != null){                                //邮件通知
//                    $en->send($user->__get('email'), $user->__get('name'), $notify['title'], $content);
//                }
//                if($sn != null){                                //短信通知
//                    //如果用户在线则取消短信通知，改为站内信通知
//                    if(!$service->check_user_online($user->__get('user_id')))
//                        $sn->send($user->__get('phone'), $user->__get('name'), $notify['title'], $content);
//                    else if($mn == null)
//                        $mn->send($user->__get('user_id'), $user->__get('name'), $notify['title'], $content);
//                }
    }

    //----------------protected--------------------

    /**
     * 标题过滤
     * @param  <string> $title 标题
     * @return <string>
     */
    protected function filter_title($title) {
        if (strlen($title) > 100)
            $title = msubstr($title, 100);
        return addslashes($title);
    }

    /**
     * 内容过滤
     * @param  <string> $content 备注
     * @return <string>
     */
    protected function filter_content($content) {
        return addslashes($content);
    }

    /**
     * 备注过滤
     * @param  <string> $remark 备注
     * @return <string>
     */
    protected function filter_remark($remark) {
        if (strlen($remark) > 100)
            $remark = msubstr($remark, 100);
        return htmlspecialchars($remark);
    }

    /**
     * 是否类型过滤
     * @param <int> $var
     * @return <int>
     */
    protected function filter_whether($var) {
        if ($var != 1)
            return 0;
        return 1;
    }

    /**
     * 填充公共参数
     * @param type $receiver_id
     * @param type $operator_id 
     */
    public function fillCommonArgs(&$args, $receiver_id, $operator_id) {
        $userService = new UserService();
        $receiver = $userService->get_user($receiver_id);
        if (!empty($receiver)) {
            $args['[receiver_login_name]'] = $receiver['email'];
            $args['[receiver_name]'] = $receiver['name'];
            $args['[receiver_id]'] = $receiver['user_id'];
            if ($receiver['role_id'] == 1) {
                $args['[privacy_set_link]'] = C('WEB_ROOT') . '/setPrivacyHuman/4';
            } else if ($receiver['role_id'] == 2) {
                $args['[privacy_set_link]'] = C('WEB_ROOT') . '/setPrivacyCompany/4';
            } else {
                $args['[privacy_set_link]'] = C('WEB_ROOT') . '/setPrivacyAgent/4';
            }
        }
        $operator = $userService->get_user($operator_id);
        if (!empty($operator)) {
            $args['[operator_id]'] = $operator['user_id'];
            $args['[operator_name]'] = $operator['name'];
        }
    }

}

?>
