<?php
/**
 * 业务逻辑-委托服务类
 * @author YoyiorLee
 */
class DelegateService{
    private $provider ;

    public function  __construct(){
        $this->provider = new DelegateProvider();
    }

    /**
     * 申请代理
     * @param <int>    $user_id     用户编号
     * @param <string> $user_name   用户名
     * @param <int>    $delegate_id 代理编号
     * @param <string> $title       标题
     * @param <string> $content     内容
     * @param <string> $contact     联系电话
     * @param <string> $email       邮箱
     * @param <string> $qq          QQ
     * @param <int>    $class_a     一级分类
     * @param <int>    $class_b     二级分类
     * @param <int>    $package_id  用户套餐编号
     * @return <mixed>
     */
    public function apply($user_id, $user_name, $delegate_id, $title, $content, $contact, $email, $qq, $class_a, $class_b, $package_id){
        $delegate_id = 0;
        $delegate_name = '';
        $title     = $this->filter_title($title);
        $content   = $this->filter_content($content);
        $contact   = $this->filter_phone($contact);
        $email     = $this->filter_email($email);
        $qq        = $this->filter_qq($qq);
        if(empty($contact) && empty($email)){
            return E(ErrorMessage::$CONTACT_ERROR);                         //联系方式无效
        }
//        $pprovider = new PackageProvider();
//        $package   = $pprovider->get_package($package_id);                  //获取用户套餐信息
//        if(empty($package))
//            return E(ErrorMessage::$OPERATION_FAILED);
//        $this->provider->trans();                                           //事务开启
//        if($package['day_delegate'] != -1){
//            //统计用户今日委托条数
//            $count = $this->provider->count_delegate_by_user($user_id, date_f('Y-m-d'));
//            if($count >= $package['day_delegate']){                         //如果代理次数超出每日免费限额
//                $domain = new BillDomain();
//                $result = $domain->consume($user_id, $user_name, $package['delegate_price'], '申请代理：'.$title);
//                if($result !== true){
//                    $this->provider->rollback();                            //事务回滚
//                    return $result;
//                }
//            }
//        }
        //添加代理记录
        $result = $this->provider->add($user_id, $user_name, $delegate_id, $delegate_name, $title, $content, $contact, $email, $qq, $class_a, $class_b, date_f());
        if(!$result){
//           $this->provider->rollback();                                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
//       $this->provider->commit();
        return $result;
    }

    /**
     * 代理
     * @param  <int> $user_id     用户编号
     * @param  <int> $delegate_id 代理人编号
     * @param  <int> $id          委托编号
     * @return <bool>
     */
    public function delegate($user_id, $delegate_id, $id){
        $d = $this->provider->get_delegate($id);
        if(empty($d)){
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        if($d['user_id'] != $user_id || $d['status'] != 1){
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        $service = new UserService();
        $user = $service->get_user($delegate_id);
        if(empty($user) || $user['role_id'] != C('ROLE_AGENT')){
            return E(ErrorMessage::$OTHER_NO_PERMISSION_ACCEPT);
        }
        $result = $this->provider->update_d($id, array('delegate_id' => $delegate_id, 'delegate_name' => $user['name'], 'status' => 2));
        if(!$result)
            return E();
        notify_send($delegate_id, C('NOTIFY_TAGENT'));
        $service = new RemindService();
        $service->notify(C('REMIND_TAGENT'), $delegate_id);        //通知
        return true;
    }

    /**
     * 删除委托
     * @param <int> $id 编号
     * @return <bool> 是否成功
     */
    public function delete($user_id, $id) {
        $delegate = $this->provider->get_delegate($id);
        if(empty($delegate)){
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        if($delegate['user_id'] != $user_id){
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        if(!$this->provider->delete($id)){
            return E();
        }
        return true;
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
    public function get_apply_delegates_by_user_id($user_id, $page, $size, $type, $delegate_id, $status = null, $order = null, $count = false){
        return $this->provider->get_apply_delegates_by_user_id($user_id, intval($page), intval($size), $type, $delegate_id, $status, $order, $count);
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
        return $this->provider->get_delegates($user_id, $delegate_id, $status, $class_a, $class_b, intval($page), intval($size), $order, $count, $from, $to);
    }

    /**
     * 根据委托编号获取委托
     * @param <int> $id 编号
     * @return <mixed> 委托
     */
    public function get_delegate($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->get_delegate($id);
    }

    /**
     * 获取类型
     * @param <int> $id 类型编号
     * @return <mixed> 类型实体
     */
    public function get_type($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->get_type($id);
    }

    /**
     * 获取类型列表
     * @param <int> $id 类型编号
     * @return <mixed> 类型列表
     */
    public function get_types($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->get_types($id);
    }

    /**
     * 更新委托
     * @param <int> $id 编号
     * @param <int> $user_id 用户编号
     * @param <string> $user_name 用户名
     * @param <int> $delegate_id 委托人编号
     * @param <string> $title 委托标题
     * @param <string> $content 委托类容
     * @param <int> $class_a 委托分类a
     * @param <int> $class_b 委托分类b
     * @param <datetime> $date 委托日期
     * @param <int> $status 委托状态
     * @return <bool> 是否成功
     */
    public function update($id, $user_id, $user_name, $delegate_id, $title, $content, $class_a, $class_b, $date, $status) {
        $model = new DelegateDomainModel();
        $model = new DelegateDomainModel();
        $model->__set('id', null);
        $model->__set('title', $title);
        $model->__set('user_id', $user_id);
        $model->__set('user_name', $user_name);
        $model->__set('delegate_id', $delegate_id);
        $model->__set('title', $title);
        $model->__set('content', $content);
        $model->__set('class_a', $class_a);
        $model->__set('class_b', $class_b);
        $model->__set('date', $date);
        $model->__set('status', $status);
        $model->__set('is_del', 0);
        //验证参数
        if(!$this->verify_update_args($model)){
            return false;
        }
        //更新数据
        return $this->provider->update($model);
    }

    /**
     * 更新委托状态
     * @param <int> $id 委托编号
     * @param <int> $status 委托状态
     * @return <bool> 是否成功
     */
    public function update_status($id,$status) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->update_status($id, $status);
    }

    /**
     * 代理回复
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $id      代理编号
     * @param  <string> $contact 联系电话
     * @param  <string> $email   邮箱
     * @param  <string> $qq      QQ
     * @param  <string> $content 内容
     * @param  <int>    $status  状态
     * @return <bool>
     */
    public function delegate_reply($user_id, $id, $contact, $email, $qq, $content, $status){
        $delegate = $this->provider->get_delegate($id);
        if(empty($delegate)){
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        if($delegate['delegate_id'] != $user_id){
            return E(ErrorMessage::$DELEGATE_PERMISSION_LESS);
        }
        if($delegate['status'] > 2){
            return E(ErrorMessage::$DELEGATE_STATUS_ERROR);
        }
        $content = $this->filter_content($content);
        $contact = $this->filter_phone($contact);
        $email   = $this->filter_email($email);
        $qq      = $this->filter_qq($qq);
        if($status != 4)
            $status = 3;
        if($status == 4){
            if(empty($contact) && empty($email))
                return E(ErrorMessage::$CONTACT_ERROR);
            //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
            $pks = new PackageService();
            $do = $pks->start_paying_operation($user_id, 12, '委托编号 '.$id);
            if(is_zerror($do)){
                return $do;
            }
            //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        }
        if(!$this->provider->delegate_reply($id, $contact, $email, $qq, $content, $status, date_f()))
            return E(ErrorMessage::$OPERATION_FAILED);
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
//        $service = new RemindService();
//        $service->notify(C('REMIND_DREPLY'), $delegate['user_id']);        //通知
//        notify_send($delegate['user_id'], C('NOTIFY_DREPLY'));
        return true;
    }

    public function verify_add_args(DelegateDomainModel $model) {
        if(isset($model)){
            return false;
        }else{
            if(!$model->__get('id')){
                return false;
            }
            if(!is_numeric($model->__get('user_id'))){
                return false;
            }
            if(!is_numeric($model->__get('delegate_id'))){
                return false;
            }
            if(mb_strlen($model->__get('title'),'utf-8')>20){
                return false;
            }
            if(mb_strlen($model->__get('content'),'utf-8')>10000){
                return false;
            }
            if(!is_numeric($model->__get('class_a'))){
                return false;
            }
            if(!is_numeric($model->__get('class_b'))){
                return false;
            }
            if(!$this->is_date($model->__get('date'))){
                return false;
            }
            if(!is_numeric($model->__get('status'))){
                return false;
            }
            if(!is_numeric($model->__get('is_del'))){
                return false;
            }
        }
        return true;
    }

    public function verify_page_args($page_index, $page_size, $order) {
        if(!isset($page_index)||!is_numeric($page_index)||$page_index<=0){
            return false;
        }
        if(!isset($page_size)||!is_numeric($page_size)||$page_size<=0){
            return false;
        }
        return true;
    }

    public function verify_update_args(DelegateDomainModel $model) {
        if(isset($model)){
            return false;
        }else{
            if($model->__get('id')==null||!is_numeric($model->__get('id'))){
                return false;
            }
            if(!is_numeric($model->__get('user_id'))){
                return false;
            }
            if(!is_numeric($model->__get('delegate_id'))){
                return false;
            }
            if(mb_strlen($model->__get('title'),'utf-8')>20){
                return false;
            }
            if(mb_strlen($model->__get('content'),'utf-8')>10000){
                return false;
            }
            if(!is_numeric($model->__get('class_a'))){
                return false;
            }
            if(!is_numeric($model->__get('class_b'))){
                return false;
            }
            if(!$this->is_date($model->__get('date'))){
                return false;
            }
            if(!is_numeric($model->__get('status'))){
                return false;
            }
            if(!is_numeric($model->__get('is_del'))){
                return false;
            }
        }
        return true;
    }

    public function is_date($data){
        if(!preg_match('/^\d{4}-[01]{1}\d-[01]{1}\d [01]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/',$date) && !preg_match('/^\d{4}-[01]{1}\d-[01]{1}\d$/',$date))
            return false;
         return true;
    }
    //--------------------protected---------------------
    /**
     * 检测代理人合法性
     * @param  <int> $id 代理编号
     * @return <mixed>
     */
    protected function check_delegate($id){
        $provider = new UserProvider();
        $user     = $provider->get_user_by_id($id);
        if(empty($user))
            return E(ErrorMessage::$USER_NOT_EXISTS);           //指定用户不存存在
        if($user->__get('role_id') != C('ROLE_AGENT'))
            return E(ErrorMessage::$USER_NOT_AGENT);            //指定用户不是经纪人/公司
        return true;
    }

    /**
     * 标题过滤
     * @param  <string> $title 标题
     * @return <string>
     */
    protected function filter_title($title){
        if(strlen($title) > 100)
            $title = substr($title, 0, 100);
        return htmlspecialchars($title);
    }

    /**
     * 内容过滤
     * @param  <string> $content 内容
     * @return <string>
     */
    protected function filter_content($content){
        if(strlen($content) > 10000)
            $content = substr($content, 0, 10000);
        return htmlspecialchars($content);
    }

    /**
     * 联系方式过滤
     * @param  <string> $phone 联系方式
     * @return <string>
     */
    protected function filter_phone($phone){
        if(empty($phone))
            return '';
        if(!preg_match('/^[\w-]{0,30}$/',$date))
            return '';
        return $phone;
    }

    /**
     * 邮箱过滤
     * @param  <string> $email
     * @return <bool> 是否合法
     */
    protected function filter_email($email){
        if(strlen($email) > 100)
            return '';
        if(preg_match(REGULAR_USER_EMAIL, $email) == 1)
            return $email;
        return '';
    }

    /**
     * QQ过滤
     * @param  <string> $qq QQ
     * @return <string>
     */
    protected function filter_qq($qq){
        if(empty($qq))
            return '';
        if(!preg_match('/^[\w-]{0,20}$/',$qq))
            return '';
        return $qq;
    }
}
?>
