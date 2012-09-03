<?php
/**
 * Description of MessageProvider
 *
 * @author moi
 */
class MessageProvider extends BaseProvider {
    /**
     * 站内信字段规则
     * @var <array>
     */
    public $messageArgRule=array(
        'title'=>array(
            'name'=>'站内信标题',
            'length'=>60,
            'null'=>false
        ),
        'content'=>array(
            'name'=>'站内信内容',
            'length'=>1000,
            'null'=>false
        ),
    );
    
    /**
     * 信息字段（收件箱列表）
     */
    const MESSAGE_FIELDS_IN_LIST = 'id, from_id, from_name, to_read, title, reply_id, date, content_type';
    /**
     * 信息字段（发件箱列表）
     */
    const MESSAGE_FIELDS_OUT_LIST = 'id, to_id, to_name, title, reply_id, date';
    /**
     * 信息字段（系统列表）
     */
    const MESSAGE_FIELDS_SYSTEM_LIST = 'id, from_id, from_name, to_read, title, date, content_type';
    /**
     * 信息字段（带内容列表）
     */
    const MESSAGE_FIELDS_CONTENT_LIST = 'id, from_id, from_name, to_read, title, reply_id, date, content';
    
    /**
     * 获取一条信息
     * @param <int> $id 编号
     * @return <mixed> 消息实体
     */
    public function get_message($id){
        $this->da->setModelName('message');            //使用站内信表
        $where['id']     = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取收件箱信息列表
     * @param <int> $user_id 用户编号
     * @param <int> $page    第几页
     * @param <int> $size    每页几条
     * @return <mixed> 消息实体列表
     */
    public function get_inbox_messages($user_id, $page, $size){
        $this->da->setModelName('message');            //使用站内信表
        $where['to_id'] = $user_id;
        $where['to_show'] = 1;
        $where['type']    = 2;
        $where['is_del']  = 0;
        return $this->da->where($where)->page($page.','.$size)->order('date desc')->field(self::MESSAGE_FIELDS_IN_LIST)->select();
    }

    /**
     * 获取发件箱信息列表
     * @param <int> $user_id 用户编号
     * @param <int> $page    第几页
     * @param <int> $size    每页几条
     * @return <mixed> 消息实体列表
     */
    public function get_outbox_messages($user_id, $page, $size){
        $this->da->setModelName('message');            //使用站内信表
        $where['from_id']   = $user_id;
        $where['from_show'] = 1;
        $where['type']      = 2;
        $where['is_del']    = 0;
        return $this->da->where($where)->page($page.','.$size)->order('date desc')->field(self::MESSAGE_FIELDS_OUT_LIST)->select();
    }

    /**
     * 获取系统信息列表
     * @param <int> $user_id 用户编号
     * @param <int> $page    第几页
     * @param <int> $size    每页几条
     * @return <mixed> 消息实体列表
     */
    public function get_system_messages($user_id, $page, $size){
        $this->da->setModelName('message');            //使用站内信表
        $where['to_id'] = $user_id;
        $where['to_show'] = 1;
        $where['type']    = 1;
        $where['is_del']  = 0;
        return $this->da->where($where)->page($page.','.$size)->order('date desc')->field(self::MESSAGE_FIELDS_SYSTEM_LIST)->select();
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
        $this->da->setModelName('message');            //使用站内信表
        $where['to_id'] = $user_id;
        $where['to_show'] = 1;
        $where['is_del']  = 0;
        if($type !== null)
            $where['type'] = $type;
        if($read !== null)
            $where['to_read'] = $read;
        if($content)
            $field = self::MESSAGE_FIELDS_CONTENT_LIST;
        else
            $field = self::MESSAGE_FIELDS_IN_LIST;
        return $this->da->where($where)->page($page.','.$size)->order('date desc')->field($field)->select();
    }

    /**
     * 获取收到的信息总条数
     * @param <type> $user_id 用户编号
     * @param <type> $type    信息类型（1、系统 2、个人，null为不限）
     * @param <type> $read    已读（0、未读 1、已读，null为不限）
     * @return <mixed> 信息列表
     */
    public function get_in_messages_count($user_id, $type = null, $read = null){
        $this->da->setModelName('message');            //使用站内信表
        $where['to_id'] = $user_id;
        $where['to_show'] = 1;
        $where['is_del']  = 0;
        if($type !== null)
            $where['type'] = $type;
        if($read !== null)
            $where['to_reak'] = $read;
        return $this->da->where($where)->count('to_id');
    }

    /**
     * 获取发出的信息总条数
     * @param <type> $user_id 用户编号
     * @return <mixed> 信息列表
     */
    public function get_out_messages_count($user_id){
        $this->da->setModelName('message');            //使用站内信表
        $where['from_id']   = $user_id;
        $where['from_show'] = 1;
        $where['type']      = 2;
        $where['is_del']    = 0;
        return $this->da->where($where)->count('from_id');
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
     * @param  <int>    $ctype     内容类型（1用户消息2系统消息3简历邀请4人才生日5企业成立6企业汇款7人才聘用到期）
     * @return <bool> 是否成功
     */
    public function send($from_id, $from_name, $to_id, $to_name, $title, $content, $reply_id, $type, $ctype){
        $this->da->setModelName('message');            //使用站内信表
        $data['from_id']   = $from_id;
        $data['from_name'] = $from_name;
        $data['to_id']     = $to_id;
        $data['to_name']   = $to_name;
        $data['title']    = $title;
        $data['content']  = $content;
        $data['reply_id'] = $reply_id;
        $data['type']     = $type;
        $data['from_show'] = 1;
        $data['to_show']   = 1;
        $data['to_read']   = 0;
        $data['date']      = date_f();
        $data['content_type'] = $ctype;
      //  $data['remind_type'] = $rtype;
        $data['is_del']    = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 删除信息
     * @param  <int> $id 编号
     * @return <bool> 是否成功
     */
    public function delete($id){
        $this->da->setModelName('message');            //使用站内信表
        $where['id']    = $id;
        $data['is_del'] = 1;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 设置发件人不可见
     * @param  <int> $id 站内信编号
     * @return <bool> 是否成功
     */
    public function set_from_hide($id){
        $this->da->setModelName('message');            //使用站内信表
        $where['id']       = $id;
        $data['from_show'] = 0;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 设置收件人不可见
     * @param  <int> $id 站内信编号
     * @return <bool> 是否成功
     */
    public function set_to_hide($id){
        $this->da->setModelName('message');            //使用站内信表
        $where['id']     = $id;
        $data['to_show'] = 0;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 设置收件人已读
     * @param  <int>    $id 站内信编号
     * @param  <string> $id 站内信编号（多个）
     * @return <bool> 是否成功
     */
    public function set_to_read($id, $in = null){
        $this->da->setModelName('message');            //使用站内信表
        if(!empty($id))
            $where['id'] = $id;
        else
            $where['id'] = array('in', $in);
        $data['to_read'] = 1;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 是否存在指定编号信息
     * @param  <int> $id 信息编号
     * @return <bool> 是否存在
     */
    public function exists_message($id){
        $this->da->setModelName('message');            //使用站内信表
        $where['id']    = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->count() > 0;
    }

    /**
     * 获取用户的未读信息条数
     * @param  <int> $user_id 用户编号
     * @param  <int> $type    信息类型
     * @return <int> 条数
     */
    public function get_unread_count($user_id, $type = null){
        $this->da->setModelName('message');            //使用站内信表
        $where['to_id']   = $user_id;
        $where['to_read'] = 0;
        $where['to_show'] = 1;
        $where['is_del']   = 0;
        if($type != null)
            $where['type'] = $type;
        return $this->da->where($where)->count();
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
        $this->da->setModelName('message');            //使用站内信表
        $where['to_id']   = $user_id;
        $where['to_read'] = 0;
        $where['to_show'] = 1;
        $where['is_del']   = 0;
        if($type != null)
            $where['type'] = $type;
        return $this->da->where($where)->field(self::MESSAGE_FIELDS_IN_LIST)->select();
    }

    /**
     * 获取系统消息
     * @param <int> $id
     * @return <mixed>
     */
    public function get_system_message($id){
        $this->da->setModelName('system_message');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
    
    /**
     * 删除系统消息
     * Enter description here ...
     * @param INT $id 消息id号
     */
    public function delete_message($id){
    	$this->da->setModelName('message');
        $where['id'] = $id;
        $data['is_del'] = 1;
        return $this->da->where($where)->save($data);
    }
}
?>
