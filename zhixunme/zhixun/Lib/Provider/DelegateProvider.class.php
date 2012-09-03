<?php
/**
 * 委托数据访问类
 * @author YoyiorLee
 */
class DelegateProvider extends BaseProvider{

    const DELEGATE_FIELDS_NOMAL = "id,user_id,user_name,delegate_id,delegate_name,title,content,class_a,class_b,date,status,contact,email,qq,rcontent,rcontact,remail,rqq,rdate";
    const DELEGATE_FIELDS_LIST = "id,user_id,user_name,delegate_id,delegate_name,title,class_a,class_b,date,status";
    const TASK_TYPE_FIELDS_NOMAL = 'class_id,class_title,parent_id,class_code,price,icon,sort,is_del';

    /**
     * 申请代理
     * @param <int>    $user_id       用户编号
     * @param <string> $user_name     用户名
     * @param <int>    $delegate_id   代理编号
     * @param <string> $delegate_name 代理名称
     * @param <string> $title         标题
     * @param <string> $content       内容
     * @param <string> $contact       联系电话
     * @param <string> $email         邮箱
     * @param <string> $qq            QQ
     * @param <int>    $class_a       一级分类
     * @param <int>    $class_b       二级分类
     * @param <int>    $date          日期
     * @return <bool> 是否成功
     */
    public function add($user_id, $user_name, $delegate_id, $delegate_name, $title, $content, $contact, $email, $qq, $class_a, $class_b, $date){
        $this->da->setModelName('delegate');
        $data['user_id']       = $user_id;
        $data['user_name']     = $user_name;
        $data['delegate_id']   = $delegate_id;
        $data['delegate_name'] = $delegate_name;
        $data['title']         = $title;
        $data['content']       = $content;
        $data['contact']       = $contact;
        $data['email']         = $email;
        $data['qq']            = $qq;
        $data['class_a']       = $class_a;
        $data['class_b']       = $class_b;
        $data['date']          = $date;
        $data['rcontent']      = '';
        $data['rcontact']      = '';
        $data['remail']        = '';
        $data['rqq']           = '';
        $data['rdate']         = $date;
        $data['status']        = 1;
        $data['is_del']        = 0;
        return $this->da->add($data);
    }

    public function update_d($id, $data){
        $this->da->setModelName('delegate');
        $where['id'] = $id;
        return $this->da->where($where)->save($data) != false;
    }

    public function delete($id) {
        $this->da->setModelName('delegate');
        $where['id']  = $id;
        $data['is_del'] = 1;
        return $this->da->where($where)->save($data);
    }

    /**
     * 获取指定条件代理列表
     * @param  <int>    $user_id     用户编号
     * @param  <int>    $delegate_id 代理人编号
     * @param  <int>    $status      状态
     * @param  <int>    $class_a     一级分类编号
     * @param  <int>    $class_b     二级分类编号
     * @param  <int>    $page        第几页
     * @param  <int>    $size        每页几条
     * @param  <string> $order       排序方式
     * @param  <bool>   $count       是否统计总条数
     * @param  <date>   $from        起始时间
     * @param  <date>   $to          终止时间
     * @return <mixed>
     */
    public function get_delegates($user_id, $delegate_id, $status, $class_a, $class_b, $page, $size, $order = null, $count = false, $from = null, $to = null){
        $this->da->setModelName('delegate');
        $where['is_del'] = 0;
        if(!empty($user_id))
            $where['user_id'] = $user_id;
        if(!empty($delegate_id))
            $where['delegate_id'] = $delegate_id;
        if(!empty($status))
            $where['status'] = $status;
        else
            $where['status'] = array('gt', $status);
        if(!empty($class_b))
            $where['class_b'] = $class_b;
        elseif(!empty($class_a))
            $where['class_a'] = $class_a;
        if(!empty($from) && !empty($to)){              //日期筛选
            $where['date'] = array('between', "'$from','$to'");
        }
        else if(!empty($from)){
            $where['date'] = array('egt', $from);
        }
        else if(!empty($to)){
            $where['date'] = array('elt', $to);
        }
        if(empty($order))
            $order = 'date DESC';
        if($count){
            return $this->da->where($where)->count('id');
        }
        else{
            return $this->da->where($where)->order($order)->page($page.','.$size)->filed(self::DELEGATE_FIELDS_LIST)->select();
        }
    }

    public function get_applied_delegates_by_user_id($user_id, $page_index, $page_size, $order) {
        $this->da->setModelName('delegate');
        $where['delegate_id']  = $user_id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::DELEGATE_FIELDS_NOMAL)->find();
        if(isset($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'delegate');
            array_push($models, $one);
        }
        return $models;
    }

    /**
     * 获取委托列表
     * @param  <int>    $user_id     用户编号
     * @param  <int>    $page        第几页
     * @param  <int>    $size        每页几条
     * @param  <int>    $type        代理类型（参数已废弃）
     * @param  <int>    $delegate_id 代理编号
     * @param  <int>    $status      委托状态
     * @param  <string> $order       排序方式
     * @param  <bool>   $count       是否统计总条数
     * @return <mixed>
     */
    public function get_apply_delegates_by_user_id($user_id, $page, $size, $type, $delegate_id, $status = null, $order = null, $count = false) {
        $this->da->setModelName('delegate');
        $where['is_del'] = 0;
        if(!empty($user_id)){
            $where['user_id'] = $user_id;
        }
        if(!empty($delegate_id)){
            $where['delegate_id'] = $delegate_id;
        }
        if(!empty($status)){
            $where['status'] = $status;
        }
        else{
            $where['status'] = array('gt', 1);
        }
        if(empty($order)){
            $order = 'date DESC';
        }
        if($count){
            return $this->da->where($where)->count('id');
        }
        else{
            return $this->da->where($where)->page($page.','.$size)->order($order)->field(self::DELEGATE_FIELDS_LIST)->select();
        }
    }

    public function get_delegate($id) {
        $this->da->setModelName('delegate');
        $where['id'] = $id;
        $where['is_del']  = 0;
        return $this->da->where($where)->field(self::DELEGATE_FIELDS_NOMAL)->find();
    }

    public function get_delegates_by_status($user_id, $status, $page_index, $page_size, $order) {
        $this->da->setModelName('delegate');
        $where['user_id']  = $user_id;
        $where['status']  = $status;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::DELEGATE_FIELDS_NOMAL)->find();
        if(isset($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'delegate');
            array_push($models, $one);
        }
        return $models;
    }

    public function get_type($id) {
        $this->da->setModelName('task_class');
        $where['class_id']  = $id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        if(empty($result))
            return null;
        return FactoryDMap::array_to_model($result, 'type');
    }

    public function get_types($id) {
        $this->da->setModelName('task_class');
        $where['parent_id']  = $id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        if(empty($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'type');
            array_push($models, $one);
        }
        return $models;
    }

    public function is_exist($id) {
        $this->da->setModelName('delegate');
        $where['id']  = $task_id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        return $result>0;
    }

    public function update(DelegateDomainModel $model) {
        $this->da->setModelName('delegate');
        $where['id']  = $model->__get("id");
        $data = FactoryDMap::model_to_array($model, 'delegate');
        unset($data['id']);
        $result = $this->da->where($where)->data($data)->save();
        return $result>0;
    }

    public function update_status($id, $status) {
        $this->da->setModelName('delegate');
        $where['id']  = $id;
        $where['status']  = $status;
        $result = $this->da->where($where)->data($data)->save();
        return $result>0;
    }

    /**
     * 统计指定用户某时间段委托条数
     * @param  <int>  $user_id 用户编号
     * @param  <date> $from    日期下限
     * @param  <date> $to      日期上限
     * @return <int> 条数
     */
    public function count_delegate_by_user($user_id, $from = null, $to = null){
        $this->da->setModelName('delegate');
        $where['user_id'] = $user_id;
        $where['status']  = 1;
        $where['is_del']  = 0;
        $where['delegate_id'] = array('gt', 0);
        if(!empty($from) && !empty($to))
            $where['date'] = array('between', "'$from','$to'");
        elseif(!empty($from))
            $where['date'] = array('gt', $from);
        elseif(!empty($to))
            $where['date'] = array('lt', $to);
        return $this->da->where($where)->count('user_id');
    }

    /**
     * 代理回复
     * @param  <int>    $id      代理编号
     * @param  <string> $contact 联系电话
     * @param  <string> $email   邮箱
     * @param  <string> $qq      QQ
     * @param  <string> $content 内容
     * @param  <int>    $status  状态
     * @param  <date>   $date    日期
     * @return <bool>
     */
    public function delegate_reply($id, $contact, $email, $qq, $content, $status, $date){
        $this->da->setModelName('delegate');
        $where['id'] = $id;
        $data['rcontent'] = $content;
        $data['rcontact'] = $contact;
        $data['remail']   = $email;
        $data['rqq']      = $qq;
        $data['status']   = $status;
        return $this->da->where($where)->save($data) != false;
    }

}
?>
