<?php
/**
 * 业务逻辑层-回复/竞标类
 * @author YoyiorLee
 */
class ReplyDomain{
    private $provider;

    public function  __construct() {
        $this->provider = new ReplyProvider();
    }

    /**
     * 回复此任务(ok)
     * @param <int>    $task_id    任务编号
     * @param <int>    $user_id    用户编号
     * @param <string> $user_name  用户名
     * @param <string> $content    回复内容
     * @param <string> $contact    联系方式
     * @param <string> $email      邮箱
     * @param <int>    $package_id 套餐编号
     * @return <bool> 是否成功
     */
    public function reply($task_id, $user_id, $user_name, $content, $contact, $email, $package_id){
        $result = $this->check_bid_permission($task_id, $user_id);        //检测竞标权限
        if($result !== true)
            return $result;
        $provider  = new TaskProvider();
        $pprovider = new PackageProvider();
        $package   = $pprovider->get_package($package_id);      //获取指定套餐信息
        if(empty($package))
            return E(ErrorMessage::$OPERATION_FAILED);
        $this->provider->trans();                               //事务开启
        if($package['day_task_bid'] != -1){
            //统计用户今日竞标数量
            $count = $provider->count_reply_by_user($user_id, date_f('Y-m-d'));
            if($count >= $package['day_task_bid']){             //如果数量不小于每日的免费数量
                $domain = new BillDomain();
                //消费：任务竞标
                $result = $domain->consume($user_id, $user_name, $package['bid_price'], '竞标任务,任务编号为'.$task_id);
                if($result !== true){
                    $this->provider->rollback();                //事务回滚
                    return $result;
                }
            }
        }
        $content = $this->filter_bcontent($content);            //竞标内容过滤
        $contact = $this->filter_contact($contact);             //联系方式过滤
        $email   = $this->filter_email($email);                 //邮箱过滤
        if(empty($contact) && empty($email)){
            return E(ErrorMessage::$CONTACT_ERROR);             //联系方式无效
        }
        //添加竞标信息
        if(!$this->provider->reply($task_id, $user_id, $user_name, $content, $contact, $email, date_f())){
            $this->provider->rollback();                        //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $provider = new TaskProvider();
        //增加任务的投标数
        if(!$provider->increase_bid_count($task_id)){
            $this->provider->rollback();                        //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit(true);                          //事务提交
        return true;
    }

    public function delete($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->delete($id);
    }

    public function get_reply($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->get_reply($id);
    }

    public function get_replys_by_bided($page, $size, $tid){
        //验证参数
        return $this->provider->get_replys_by_bided(intval($page), intval($size), $tid);
    }
    
    public function get_replys_by_task_id($task_id, $page_index, $page_size, $order) {
        //验证参数
        if(!is_numeric($task_id)){
            return false;
        }
        if(!self::verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_replys_by_task_id($task_id, $page_index, $page_size, $order);
    }

    public function get_replys_by_user_id($user_id, $page_index, $page_size, $order) {
        //验证参数
        if(!is_numeric($user_id)){
            return false;
        }
        if(!self::verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_replys_by_user_id($user_id, $page_index, $page_size, $order);
    }

    /**
     * 获取任务回复列表
     * @param  <int>    $task_id   任务编号
     * @param  <string> $role_code 角色代码
     * @param  <string> $auth_code 认证代码
     * @param  <int>    $page      第几页
     * @param  <int>    $size      每页几条
     * @param  <bool>   $count     是否统计条数
     * @return <mixed>
     */
    public function get_reply_list($task_id, $role_code, $auth_code, $page, $size, $count = false){
        return $this->provider->get_reply_list(intval($task_id), $role_code, $auth_code, intval($page), intval($size), $count);
    }

    public function is_exist($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->is_exist($id);
    }

    public function update(ReplyDomainModel $model) {
        //验证参数
        if(!$this->verify_update_args($model)){
            return false;
        }
        //查询数据
        return $this->provider->update($model);
    }

    /**
     * 检测指定用户是否竞标了指定任务
     * @param  <int> $info_id 任务编号
     * @param  <int> $user_id 用户编号
     * @return <bool>
     */
    public function check_user_reply_task($info_id, $user_id){
        return $this->provider->check_user_reply_task($info_id, $user_id);
    }

    public function verify_add_args(ReplyDomainModel $model) {
        if(!isset($model)){
            return false;
        }else{
            if(!$model->__get('id')){
                return false;
            }
            if($model->__get('task_id')==null||!is_numeric($model->__get('task_id'))){
                return false;
            }
            if(mb_strlen($model->__get('content'),'utf-8')>10000){
                return false;
            }
            if(!$this->is_date($model->__get('date'))){
                return false;
            }
            if(!is_numeric($model->__get('is_bid'))){
                return false;
            }
        }
        return true;
    }

    public function verify_page_args($page_index, $page_size, $order) {
        if(!isset($page_index)||!is_numeric($page_index)||$page_index>=0){
            return false;
        }
        if(!isset($page_size)||!is_numeric($page_size)||$page_size>=0){
            return false;
        }
        if(!isset($order)||!preg_match("/(desc|asc|sort|id|user_id|date|user_name|content)?/is", $order)){
            return false;
        }
        return true;
    }

    public function verify_update_args(ReplyDomainModel $model) {
        if(isset($model)){
            return false;
        }else{
            if($model->__get('id')==null||!is_numeric($model->__get('id'))){
                return false;
            }
            if($model->__get('task_id')==null||!is_numeric($model->__get('task_id'))){
                return false;
            }
            if(mb_strlen($model->__get('content'),'utf-8')>10000){
                return false;
            }
            if(!self::is_date($model->__get('date'))){
                return false;
            }
            if(!is_numeric($model->__get('is_bid'))){
                return false;
            }
        }
        return true;
    }
    
    public function is_date($data){
         if(isset($data) && $data!='' && preg_match("/^(/d{2}|/d{4})-((0([1-9]{1}))|(1[0|1|2])|([1-9]{1}))-(([0-2]([0-9]))|(3[0|1])|([1-9]{1}))(|/s+((0|1)[0-9]|2[0-3])(|:[0-5][0-9](|:[0-5][0-9])))$/",$data) )
         {
            return true;
         }
         return false;
    }

    //----------------protected------------------
    /**
     * 检测竞标权限
     * @param  <int> $task_id 任务编号
     * @return <mixed>
     */
    protected function check_bid_permission($task_id, $user_id){
        $provider = new TaskProvider();
        $task     = $provider->get_task($task_id);
        if(empty($task))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);             //任务不存在
        if($task['status'] != 1)
            return E(ErrorMessage::$TASK_STATUS_NO_BID);            //指定任务状态不允许投标
        if(!AccessControl::check_class($task['info_class_b'], 2))
            return E(ErrorMessage::$NO_TCLASS_BPERMISSION);         //没有指定类别的竞标权限
        if($task['user_id'] == $user_id)
            return E(ErrorMessage::$BID_OWN_TASK);                  //不能参与投标自己发布的任务
        return true;
    }

    /**
     * 邮箱过滤
     * @param  <string> $email
     * @return <string>
     */
    protected function filter_email($email){
        if(strlen($email) > 100)
            return '';
        if(!preg_match(REGULAR_USER_EMAIL, $email) == 1)
            return '';
        return $email;
    }

    /**
     * 联系方式过滤
     * @param  <string> $contact 联系方式
     * @return <string>
     */
    protected function filter_contact($contact){
        if($contact == '0')
            return '';
        $contact = trim($contact);
        if(strlen($contact) > 30) $contact = substr($contact, 0, 30);
        return htmlspecialchars($contact);
    }

    /**
     * 竞标内容过滤
     * @param  <string> $content 内容
     * @return <string>
     */
    protected function filter_bcontent($content){
        if(strlen($content) > 10000)
            $content = substr($content, 0, 10000);
        return htmlspecialchars($content);
    }
}
?>
