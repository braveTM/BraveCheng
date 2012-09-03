<?php
/**
 * 服务层-消息类
 * @author YoyiorLee
 */
class MessageService{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new MessageProvider();
    }

    /**
     * 发信息
     * @param  <int>    $from_id   发送方编号
     * @param  <string> $from_name 发送方名称
     * @param  <int>    $to_id     接收方编号
     * @param  <string> $to_name   接收方名称
     * @param  <string> $title     标题
     * @param  <string> $content   内容
     * @param  <int>    $reply_id  回复编号
     * @param  <int>    $type      类型
     * @param  <bool>   $gl        内容是否过滤  
     * @param  <int>    $ctype     内容类型（1用户消息2系统消息3简历邀请4人才生日5企业成立6企业汇款7人才聘用到期）
     * @return <bool> 是否成功
     */
    public function send($from_id, $from_name, $to_id, $to_name, $title, $content, $reply_id, $type, $gl = true, $ctype = 1){
        if($gl){
            $data = argumentValidate($this->provider->messageArgRule, array('title' => $title, 'content' => $content));
            if(is_zerror($data))
                return $data;
            $title = $data['title'];
            $content = $data['content'];
        }
        if(!$this->provider->send($from_id, $from_name, $to_id, $to_name, $title, $content, $reply_id, $type, $ctype))
            return E(ErrorMessage::$OPERATION_FAILED);
//        $service = new RemindService();
//        $service->notify(C('REMIND_MESSAGE'), $to_id);        //通知
        return true;
    }
    
    /**
     * 未读消息集合
     * @param int $user_id 用户编号
     * @return array 
     */
    public function assembly_unread($user_id){
        $arr = array(
            1 => 'user',
            2 => 'system',
            3 => 'invite',
            4 => 'birth',
            5 => 'setup',
            6 => 'remit',
            7 => 'employ'
        );
        $array = array(
            'user'      => 0,
            'system'    => 0,
            'invite'    => 0,
            'birth'     => 0,
            'setup'     => 0,
            'remit'     => 0,
            'employ'    => 0
        );
        $unread = $this->provider->get_unread_list($user_id, 1, 100);
        foreach($unread as $item){
            $array[$arr[$item['content_type']]]++;
        }
        foreach($array as $key => $value){
            if($value == 0){
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * 删除信息
     * @param  <int> $id 信息编号
     * @return <bool> 是否成功
     */
    public function delete($id) {
        return $this->provider->delete($id);
    }

    /**
     * 获取收件箱信息列表
     * @param <int> $user_id 用户编号
     * @param <int> $page    第几页
     * @param <int> $size    每页几条
     * @return <mixed> 消息实体列表
     */
    public function get_inbox_messages($user_id, $page, $size) {
        return $this->provider->get_inbox_messages($user_id, $page, $siz);
    }

    /**
     * 获取一条信息
     * @param <int> $id 编号
     * @return <mixed> 消息实体
     */
    public function get_message($id){
        return $this->provider->get_message($id);
    }

    /**
     * 获取发件箱信息列表
     * @param <int> $user_id 用户编号
     * @param <int> $page    第几页
     * @param <int> $size    每页几条
     * @return <mixed> 消息实体列表
     */
    public function get_outbox_messages($user_id, $page, $size){
        return $this->provider->get_outbox_messages($user_id, $page, $size);
    }

    /**
     * 获取系统信息列表
     * @param <int> $user_id 用户编号
     * @param <int> $page    第几页
     * @param <int> $size    每页几条
     * @return <mixed> 消息实体列表
     */
    public function get_system_messages($user_id, $page, $size){
        return $this->provider->get_system_messages($user_id, $page, $size);
    }

    /**
     * 获取收到的信息列表
     * @param <type> $user_id 用户编号
     * @param <type> $page    第几页
     * @param <type> $size    每页几条
     * @param <type> $type    信息类型（1、系统 2、个人，null为不限）
     * @param <type> $read    已读（0、未读 1、已读，null为不限）
     * @param <bool> $content 是否获取内容字段
     * @return <mixed> 信息列表
     */
    public function get_in_messages($user_id, $page, $size, $type = null, $read = null, $content = false){
        return $this->provider->get_in_messages($user_id, intval($page), intval($size), $type, $read, $content);
    }

    /**
     * 获取收到的信息总条数
     * @param <type> $user_id 用户编号
     * @param <type> $type    信息类型（1、系统 2、个人，null为不限）
     * @param <type> $read    已读（0、未读 1、已读，null为不限）
     * @return <mixed> 信息列表
     */
    public function get_in_messages_count($user_id, $type = null, $read = null){
        return $this->provider->get_in_messages_count($user_id, $type, $read);
    }

    /**
     * 获取发出的信息总条数
     * @param <type> $user_id 用户编号
     * @return <mixed> 信息列表
     */
    public function get_out_messages_count($user_id){
        return $this->provider->get_out_messages_count($user_id);
    }

    /**
     * 设置发件人不可见
     * @param  <int> $id 站内信编号
     * @return <bool> 是否成功
     */
    public function set_from_hide($id){
        return $this->provider->set_from_hide($id);
    }

    /**
     * 设置收件人不可见
     * @param  <int> $id 站内信编号
     * @return <bool> 是否成功
     */
    public function set_to_hide($id){
        return $this->provider->set_to_hide($id);
    }

    /**
     * 设置收件人已读
     * @param  <int> $id 站内信编号
     * @return <bool> 是否成功
     */
    public function set_to_read($id){
        return $this->provider->set_to_read($id);
    }

    /**
     * 获取用户未读信息条数
     * @param <int> $user_id 用户编号
     * @param <int> $type    站内信类型
     * @param <int> 条数
     */
    public function get_unread_count($user_id, $type = null){
        return $data = $this->provider->get_unread_count($user_id, $type);
    }

    /**
     * 获取用户的未读信息列表
     * @param  <int> $user_id 用户编号
     * @param  <int> $page    第几页
     * @param  <int> $size    每页几条
     * @param  <int> $type    信息类型
     * @return <mixed> 列表
     */
    public function get_unread_list($user_id, $page, $size, $type = null){
        return $this->provider->get_unread_list($user_id, intval($page), intval($size), $type);
    }

    /**
     * 标记为已读
     * @param  <int>    $user_id 用户编号
     * @param  <string> $mids    消息编号
     * @return <mixed>
     */
    public function mark_read($user_id, $mids){
        $ids = $this->filter_rmid($user_id, $mids);
        if(empty($ids)){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);
        }
        else if(count($ids) == 1){
            $result = $this->provider->set_to_read($ids[0]);
        }
        else{
            $result = $this->provider->set_to_read(null, implode(',', $ids));
        }
        if($result == false){
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        else{
            return true;
        }
    }

    /**
     * 获取系统消息
     * @param <int> $id
     * @return <mixed>
     */
    public function get_system_message($id){
        return $this->provider->get_system_message($id);
    }

    //------------------protected--------------------
    /**
     * 设置已读信息编号过滤
     * @param  <int>    $user_id 用户编号
     * @param  <string> $mids    信息编号
     * @return <array>
     */
    protected function filter_rmid($user_id, $mids){
        $ids = explode(',', $mids);
        $result = array();
        foreach ($ids as $id) {
            if(is_numeric($id)){
                $message = $this->provider->get_message($id);
                if($message['to_id'] == $user_id && $message['to_show'] == 1 && $message['to_read'] == 0){
                    $result[] = $id;
                }
            }
        }
        return $result;
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $ids
     */
    public function delete_messeges($ids){
    	$id = explode(',', $ids);
        foreach ($id as $v) {
            if(is_numeric($v)){
                $message = $this->provider->delete_message($v);
            }
        }
        return $message;
    }
}
?>
