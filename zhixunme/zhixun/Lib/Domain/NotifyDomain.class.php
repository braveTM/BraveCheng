<?php
/**
 * Description of NotifyDomain
 *
 * @author moi
 */
class NotifyDomain {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new NotifyProvider();
    }
    /**
     * 获取通知模版
     * @param  <int> $id 模版编号
     * @return <array> 模版信息
     */
    public function get_notify_tpl($id){
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
    public function add_notify_tpl($title, $content, $remark, $fixed, $m, $e, $s){
        $title   = $this->filter_title($title);
        $content = $this->filter_content($content);
        $remark  = $this->filter_remark($remark);
        $fixed   = $this->filter_whether($fixed);
        $m       = $this->filter_whether($m);
        $e       = $this->filter_whether($e);
        $s       = $this->filter_whether($s);
        $result  = $this->provider->add_notify_tpl($title, $content, $remark, $fixed, $m, $e, $s);
        if($result == false)
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
    public function send_notify($user_ids, $role_ids, $tpl_id, $code){
        $notify = $this->provider->get_notify_tpl($tpl_id);     //获取指定通知模版
        if(empty($notify)){
            return;                                             //指定模版不存在
        }
        if($notify['message'] == 1){
            $mn = new MessageNotify();                          //启用站内信通知
        }
        if($notify['email'] == 1){
            $en = new EmailNotify();                            //启用邮件通知
        }
        if($notify['sms'] == 1){
            $sn = new SMSNotify();                              //启用短信通知
        }
        $date = date_f('Y-m-d');                                //获取当期日期
        $provider = new UserProvider();         
        if($role_ids != '0'){                                   //通知指定角色所有用户
            $rarray = explode(',', $role_ids);                  //实现待定
        }
        else{                                                   //通知指定用户
            $uarray = explode(',', $user_ids);
            foreach ($uarray as $uid) {                         //循环用户
                $user = $provider->get_user_by_id($uid);        //获取指定用户账户信息
                if(empty($user))
                    continue;                                   //用户不存在进入下一次循环
                //通知内容自定义标签替换
                $content = notify_replace($notify['content'], $user->__get('user_name'), $date, $code);
                if($mn != null){                                //站内信通知
                    $mn->send($user->__get('user_id'), $user->__get('user_name'), $notify['title'], $content);
                }
                if($en != null){                                //邮件通知
                    $en->send($user->__get('email'), $user->__get('user_name'), $notify['title'], $content);
                }
                if($sn != null){                                //短信通知
                    $sn->send($user->__get('phone'), $user->__get('user_name'), $notify['title'], $content);
                }
            }
        }

    }

    /**
     * 给指定邮箱发送邮件
     * @param  <type> $email
     * @param  <type> $tpl_id
     * @param  <type> $uid
     * @param  <type> $code
     * @return <type>
     */
    public function send_email($email, $tpl_id, $uid, $code){
        $notify = $this->provider->get_notify_tpl($tpl_id);     //获取指定通知模版
        if(empty($notify)){
            return;                                             //指定模版不存在
        }
        $en = new EmailNotify();                                //启用邮件通知
        $date = date_f('Y-m-d');                                //获取当前日期
        $provider = new UserProvider();                         
        $user = $provider->get_user_by_id($uid);                //获取指定用户账户信息
        if(empty($user)){
            $uname = '尊敬的'.C('WEB_NAME').'用户';
        }
        else{
            $uname = $user->__get('user_name');
        }
        //通知内容自定义标签替换
        $content = notify_replace($notify['content'], $uname, $date, $code);
        //邮件通知
        $en->send($email, $uname, $notify['title'], $content);
    }
    
    //----------------protected--------------------

    /**
     * 标题过滤
     * @param  <string> $title 标题
     * @return <string>
     */
    protected function filter_title($title){
        if(strlen($title) > 100)
            $title = msubstr($title, 100);
        return addslashes($title);
    }

    /**
     * 内容过滤
     * @param  <string> $content 备注
     * @return <string>
     */
    protected function filter_content($content){
        return addslashes($content);
    }

    /**
     * 备注过滤
     * @param  <string> $remark 备注
     * @return <string>
     */
    protected function filter_remark($remark){
        if(strlen($remark) > 100)
            $remark = msubstr($remark, 100);
        return htmlspecialchars($remark);
    }

    /**
     * 是否类型过滤
     * @param <int> $var
     * @return <int>
     */
    protected function filter_whether($var){
        if($var != 1)
            return 0;
        return 1;
    }
}
?>
