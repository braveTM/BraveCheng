<?php
/**
 * 每次最多邀请个数 
 */
define('MAX_INVITE_COUNT_ONCE', 10);
/**
 * 每日最多邀请个数 
 */
define('MAX_INVITE_COUNT_ONE_DAY', 100);
/**
 * 邀请发送方式-短信 
 */
define('SEND_TYPE_SMS', 1);
/**
 * 邀请发送方式-邮件 
 */
define('SEND_TYPE_EMAIL', 2);
/**
 * Description of InviteService
 *
 * @author moi
 */
class InviteService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function __construct() {
        $this->provider = new InviteProvider();
    }
    
    /**
     * 增加邀请信息
     * @param int $user_id 用户编号
     * @param string $code 邀请码
     * @return bool 是否成功
     */
    public function add_invite($user_id, $code){
        return $this->provider->add_invite($user_id, $code);
    }
    
    /**
     * 获取邀请信息
     * @param int $user_id 用户编号
     * @param string $code 邀请码
     * @return mixed
     */
    public function get_invite($user_id, $code){
        return $this->provider->get_invite($user_id, $code);
    }
    
    /**
     * 邮件邀请注册
     * @param int $user_id 邀请人编号
     * @param int $user_name 邀请人名称
     * @param string $phones 邀请的邮箱(多个以,间隔)
     * @return bool 
     */
    public function invite_by_email($user_id, $user_name, $emails){
        $email_array = explode(',', $emails);
        foreach($email_array as $key => $email){            //过滤不合法邮箱
            if(!var_validation($email, VAR_EMAIL)){
                unset($email_array[$key]);
            }
        }
        $count = count($email_array);                       //统计号码个数
        if($count < 1){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        if($count > 10 ){                                   //一次性邀请人数限制
            return E('邀请数量错误，一次性邀请数量不能超过'.MAX_INVITE_COUNT_ONCE.'个');
        }
        $invite = $this->provider->get_invite($user_id);
        if(empty($invite)){
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        $date = date_f('Y-m-d');
        $record = $this->provider->get_invite_send_record($user_id, $date, SEND_TYPE_EMAIL);
        if(empty($record)){                                 //今日不存在发送记录，添加记录
            $this->provider->add_invite_send_record(array(
                'user_id'   => $user_id,
                'type'      => SEND_TYPE_EMAIL,
                'date'      => $date,
                'count'     => $count,
                'is_del'    => 0
            ));
        }
        else{
            $total_count = $record['count'] + $count;
            if($total_count > MAX_INVITE_COUNT_ONE_DAY){    //今日邮件邀请次数限制
                return E('此次邀请导致今日邮件邀请总次数超过'.MAX_INVITE_COUNT_ONE_DAY.'次，邀请失败');
            }
            $this->provider->update_invite_send_record($record['id'], array('count' => $total_count));
        }
        $content = '<div style="line-height: 30px; color: #232323;">
            <p style="font-size: 20px;font-weight: bolder;margin: 0;">Hi,我是'.$user_name.'</p>
            我注册成为了职讯网（www.zhixun.me）的会员，这是一个非常专业的建筑行业求职招聘平台，所有的企业和经纪人都是实名认证的，快来体验一下吧！<br/>
            <b>接受邀请地址：</b><a href="'.C('WEB_ROOT').'/tregister/'.$invite['code'].'">'.C('WEB_ROOT').'/tregister/'.$invite['code'].'</a> 。<br/>
            <span style="color:#686868;">(如果以上链接无法访问，请将链接粘帖并复制到浏览器地址栏打开)</span><br/>
            本邮件是系统发出的邮件，请勿直接回复。<br/>
            -----------------------------------------------------------<br/>
            职讯网 [date]
        </div>';
        normal_email_send(implode(',', $email_array), '来自职讯网的注册邀请', $content);
        return true;
    }
    
    /**
     * 短信邀请注册
     * @param int $user_id 邀请人编号
     * @param string $phones 邀请的手机号码(多个以,间隔)
     * @return bool 
     */
    public function invite_by_sms($user_id, $user_name, $phones){
        $phone_array = explode(',', $phones);
        foreach($phone_array as $key => $phone){            //过滤不合法手机号码
            if(!var_validation($phone, VAR_PHONE)){
                unset($phone_array[$key]);
            }
        }
        $count = count($phone_array);                       //统计号码个数
        if($count < 1){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        if($count > 10 ){                                   //一次性邀请人数限制
            return E('邀请数量错误，一次性邀请数量不能超过'.MAX_INVITE_COUNT_ONCE.'个');
        }
        $invite = $this->provider->get_invite($user_id);
        if(empty($invite)){
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        $date = date_f('Y-m-d');
        $record = $this->provider->get_invite_send_record($user_id, $date, SEND_TYPE_SMS);
        if(empty($record)){                                 //今日不存在发送记录，添加记录
            $this->provider->add_invite_send_record(array(
                'user_id'   => $user_id,
                'type'      => SEND_TYPE_SMS,
                'date'      => $date,
                'count'     => $count,
                'is_del'    => 0
            ));
        }
        else{
            $total_count = $record['count'] + $count;
            if($total_count > MAX_INVITE_COUNT_ONE_DAY){    //今日短信邀请次数限制
                return E('此次邀请导致今日短信邀请总次数超过'.MAX_INVITE_COUNT_ONE_DAY.'次，邀请失败');
            }
            $this->provider->update_invite_send_record($record['id'], array('count' => $total_count));
        }
        require_cache(APP_PATH.'/Common/Class/SMS.class.php');
        $notify = new SMSFactory();
        $obj = $notify->get_object(implode(',', $phone_array), 'Hi，我是'.$user_name.'，我注册成为了职讯网（www.zhixun.me）的会员，这是一个非常专业的建筑行业求职招聘平台，所有的企业和经纪人都是实名认证的，快来体验一下吧！网址：'.C('WEB_ROOT').'/tregister/'.$invite['code']);
        if(!$obj->send()){
            return E();
        }
        return true;
    }

    /**
     * 记住邀请码
     * @param string $code  邀请码
     */
    public function remember_invite_code($code){
        $_SESSION['invite_code'] = $code;
    }
    
    /**
     * 清除邀请码 
     */
    public function clear_invite_code(){
        unset($_SESSION['invite_code']);
    }
    
    /**
     * 获取邀请码
     * @return string 
     */
    public function get_invite_code(){
        return $_SESSION['invite_code'];
    }
    
    /**
     * 添加邀请记录
     * @param int $user_id 用户编号
     * @param string $code 邀请码
     * @return bool 是否成功
     */
    public function add_invite_record($user_id){
        $code = $this->get_invite_code();
        if(!empty($code)){
            $invite = $this->provider->get_invite(null, $code);
            if(!empty($invite)){
                $this->provider->add_invite_record($user_id, $invite['user_id'], date_f());
            }
            $this->clear_invite_code();
        }
        return true;
    }
}

?>
