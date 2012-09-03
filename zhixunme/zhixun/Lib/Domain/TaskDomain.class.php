<?php
/**
 * 业务逻辑层-任务类
 * @author YoyiorLee
 */
class TaskDomain {
    private $provider;

    public function  __construct() {
        $this->provider = new TaskProvider();
    }

    /**
     * 发布任务
     * @param TaskDomainModel $model
     * @param <int> $package_id 套餐编号
     * @return <type> 
     */
    public function add(TaskDomainModel $model, $package_id) {
        //验证参数
        if(!$this->verify_add_args($model)){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);                //参数格式错误
        }
        if(!AccessControl::check_class($model->__get('class_b'), 1))
            return E(ErrorMessage::$NO_TCLASS_PPERMISSION);                 //没有指定类别的发布权限
        //数据过滤
        $model->__set('title', $this->filter_title($model->__get('title')));
        $model->__set('content', $this->filter_content($model->__get('content')));
        $model->__set('phone', $this->filter_phone($model->__get('phone')));
        $model->__set('email', $this->filter_email($model->__get('email')));
        $model->__set('qq', $this->filter_qq($model->__get('qq')));
        $phone = $model->__get('phone');
        $email = $model->__get('email');
        $qq    = $model->__get('qq');
        if(empty($phone) && empty($email)){
            return E(ErrorMessage::$CONTACT_ERROR);                         //联系方式无效
        }
        $pprovider = new PackageProvider();                                 //套餐数据提供
        $package   = $pprovider->get_package($package_id);                  //获取套餐信息
        unset ($pprovider);                                                 //回收对象
        //逻辑判断
        if(empty($package)){
            return E(ErrorMessage::$OPERATION_FAILED);  
        }
        $date = date_f('Y-m-d');
        $this->provider->trans();                                           //事务开启
        if($package['day_task_post'] != -1){                                //如果非免费无限发任务
            //统计今日已发任务条数
            $count = $this->provider->count_task_by_user($model->__get('user_id'), $date);
            if($count >= $package['day_task_post']){                        //如果已发任务数已超过免费限额
                $domain = new BillDomain();
                $bill = $domain->get_bill_info($model->__get('user_id'));   //获取用户账单信息
                if($bill['cash'] < $package['post_price']){
                    return E(ErrorMessage::$MONEY_NOT_ENOUGH);              //账户余额不足
                }
                //支付金额以用来发布任务
                $result = $domain->consume($model->__get('user_id'), $model->__get('user_name'), $package['post_price'], '发布任务:'.$model->__get('title'));
                if($result !== true){                                       //支付失败
                    $this->provider->rollback();                            //事务回滚
                    return $result;
                }
            }
        }
        $id = $this->provider->add($model);                                 //获取发布的任务编号
        if(!$id){                                                           
            $this->provider->rollback();                                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $profile_provider = new ProfileProvider();
        if(!$profile_provider->increase_info_count($model->__get('user_id'))){              //增加用户的发布任务数
            $this->provider->rollback();                                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                                          //事务提交
        return $id;
    }

    /**
     * 快速发布任务
     * @param  <string> $title   标题
     * @param  <string> $content 内容
     * @param  <int>    $days    天数
     * @param  <string> $contact 联系方式
     * @param  <string> $email   邮箱
     * @param  <string> $qq      QQ
     * @param  <string> $ip      IP
     * @return <bool> 是否成功
     */
    public function add_fast($title, $content, $days, $contact, $email, $qq, $ip){
        //$title   = $this->filter_title($title);
        $content = $this->filter_content($content);
        $days    = $this->filter_days($days);
        $contact = $this->filter_phone($contact);
        $email   = $this->filter_email($email);
        $qq      = $this->filter_qq($qq);
        $ip      = $this->filter_ip($ip);
        $title   = '来自'.$ip.'的任务';
        //添加数据
        if(!$this->provider->add_fast($title,$content,$days,$contact, $email, $qq, $ip)){
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        return true;
    }

    public function delete($task_id) {
        //验证参数
        if(!is_numeric($task_id)){
            return false;
        }
        //查询数据
        return $this->provider->delete($task_id);
    }

    public function favorite($task_id) {
        //验证参数
        if(!is_numeric($task_id)){
            return false;
        }
        //查询数据
        return $this->provider->favorite($task_id);
    }

    public function get_task($task_id) {
        //验证参数
        if(!is_numeric($task_id)){
            return false;
        }
        //查询数据
        return  $this->provider->get_task($task_id);
    }
    
    public function get_task_by_recommend($type,$page_index,$page_size){
        //验证参数
        if(!isset($page_index)||!is_numeric($type)){
            return false;
        }
        if(!isset($page_index)||!is_numeric($page_index)||$page_index<0){
            return false;
        }
        if(!isset($page_size)||!is_numeric($page_size)||$page_size<0){
            return false;
        }
        //查询数据
        return  $this->provider->get_task_by_recommend($type,$page_index,$page_size);
    }
    
    public function get_tasks_by_bided($user_id, $page, $size, $order = null, $count = false) {
        //验证参数
        if(!is_numeric($user_id)){
            return false;
        }
        if(!$this->verify_page_args($page, $size, $order)){
            return false;
        }
        //查询数据
        return  $this->provider->get_tasks_by_bided($user_id, $page, $size, $order, $count);
    }

    public function get_tasks_by_class($task_class_a,$task_class_b, $page_index, $page_size, $order) {
        //验证参数
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_class($task_class_a, $task_class_b, $page_index, $page_size, $order);
    }

    public function get_tasks_by_default($page_index, $page_size, $order) {
        //验证参数
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_default($page_index, $page_size, $order);
    }

    public function get_tasks_by_like($like_title, $like_content, $like_name, $class, $status, $start_time, $end_time, $page_index, $page_size, $order) {
        //验证参数
        if(!self::verify_like_args($like_title, $like_content, $like_name, $class, $status, $start_time, $end_time)){
            return false;
        }
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_like($like_title, $like_content, $like_name, $class, $status, $start_time, $end_time, $page_index, $page_size, $order);
    }

    public function get_tasks_by_read($page_index, $page_size, $order) {
        //验证参数
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_read($page_index, $page_size, $order);
    }

    /**
     * 获取用户竞标过的任务列表
     * @param <int> $user_id 用户编号
     * @param <int> $status  任务状态
     * @param <int> $class_a 一级分类编号
     * @param <int> $class_b 二级分类编号
     * @param <int> $page_index 当前页数 第一页默认为0
     * @param <int> $page_size 每页大小
     * @param <int> $order 排序方式
     * @param <bool> $count 是否统计总数
     * @return <mixed> 任务实体列表
     */
    public function get_tasks_by_replyed($user_id, $status, $class_a, $class_b, $page_index, $page_size, $order = null, $count = false){
        //验证参数
        if(!is_numeric($user_id)){
            return false;
        }
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_replyed($user_id, $status, $class_a, $class_b, $page_index, $page_size, $order, $count);
    }

    public function get_tasks_by_reply_count($page_index, $page_size, $order) {
        //验证参数
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_reply_count($page_index, $page_size, $order);
    }

    public function get_tasks_by_sort($page_index, $page_size, $order) {
        //验证参数
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_sort($page_index, $page_size, $order);
    }

    public function get_tasks_by_status($task_status, $page_index, $page_size, $order) {
        //验证参数
        if(!is_numeric($task_status)){
            return false;
        }
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_status($task_status, $page_index, $page_size, $order);
    }

    public function get_tasks_by_time($start_time, $end_time, $page_index, $page_size, $order) {
        //验证参数
        if(isset ($start_time)){
            if(!self::is_date($start_time)){
                return false;
            }
        }
        if(isset ($end_time)){
            if(!self::is_date($end_time)){
                return false;
            }
        }
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_time($start_time, $end_time, $page_index, $page_size, $order);
    }

    public function get_tasks_by_type($task_type, $page_index, $page_size, $order) {
        //验证参数
        if(!is_numeric($task_type)){
            return false;
        }
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_type($task_type, $page_index, $page_size, $order);
    }

    public function get_tasks_by_user_id($user_id, $status, $page_index, $page_size, $order = null, $count = false){
        //验证参数
        if(!is_numeric($user_id)){
            return false;
        }
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_tasks_by_user_id($user_id, intval($status), $page_index, $page_size, $order, $count);
    }

    /**
     * 根据条件获取任务列表
     * @param  <int>    $class_a 一级分类
     * @param  <int>    $class_b 二级分类
     * @param  <int>    $status  任务状态
     * @param  <date>   $from    时间下限
     * @param  <date>   $to      时间上限
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <string> $order   排序方式
     * @param  <bool>   $count   是否统计总条数
     * @param  <string> $like    搜索关键字
     * @param  <int>    $user_id 用户编号
     * @return <mixed> 任务列表
     */
    public function get_task_list($class_a, $class_b, $status, $from, $to, $page, $size, $order = null, $count = false, $like = null, $user_id = null){
        return $this->provider->get_task_list($class_a, $class_b, $status, $from, $to, intval($page), intval($size), $order, $count, $this->filter_like($like), $user_id);
    }

    public function get_type($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->get_type($id);
    }

    public function get_types($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->get_types($id);
    }

    public function get_subtypes(){
        return $this->provider->get_subtypes();
    }

    /**
     * 统计最近某类别发布任务数量
     * @param  <int> $class_a 分类A编号
     * @param  <int> $class_b 分类B编号
     * @param  <int> $day     最近天数
     * @return <int> 数量
     */
    public function count_task_nearby($class_a, $class_b, $day){
        $day = intval($day);
        $now = time();
        $start = $now - ($day - 1) * 86400;
        return $this->provider->count_task_by_date($class_a, $class_b, date_f('Y-m-d', $start).' 00:00:00', date_f());
    }

    /**
     *任务查看
     * @param  <int>    $user_id    用户编号
     * @param  <string> $user_name  用户名
     * @param  <int>    $info_id    任务编号
     * @param  <string> $info_title 任务标题
     * @param  <int>    $package_id 套餐编号
     * @return <mixed>
     */
    public function task_scan($user_id, $user_name, $info_id, $info_title, $package_id){
        if(empty($user_id)){                                                                    //匿名用户
            $this->provider->increase_read_count($info_id);                                     //增加任务的浏览数
            return true;
        }
        $provider = new ScanProvider();
        if(!$provider->exists_scan_record($user_id, $info_id)){                                 //检测是否已经浏览过
            $this->provider->trans();                                                           //事务开启
            if(C('TASK_SCAN_CHECK')){                                                           //检测是否开任务查看验证
                $pprovider = new PackageProvider();
                $package   = $pprovider->get_package($package_id);                              //获取指定套餐信息
                if($package['day_task_read'] != -1 && $package['read_price'] > 0){              //如果浏览权限并非无限制
                    //统计用户今日浏览条数
                    $count = $provider->get_user_scan_record($user_id, 1, 1, date_f('Y-m-d'), null, true);
                    if($count >= $package['day_task_read']){                                    //如果浏览条数超出每日上限
                        $bdomain = new BillDomain();
                        //消费：任务查看
                        $result  = $bdomain->consume($user_id, $user_name, $package['read_price'], '查看任务:'.$info_title);
                        if($result !== true){
                            $this->provider->rollback();                                        //事务回滚
                            return $result;
                        }
                    }
                }
            }
            if(!$provider->add($user_id, $user_name, $info_id, $info_title, date_f())){         //添加任务浏览记录
                $this->provider->rollback();                                                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
            if(!$this->provider->increase_read_count($info_id)){                                //增加任务的浏览数
                $this->provider->rollback();                                                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
            $this->provider->commit(true);                                                      //事务提交
        }
        else{
            $provider->update_scan_date($user_id, $info_id, date_f());                          //更新浏览记录的日期
            $this->provider->increase_read_count($info_id);                                     //增加任务的浏览数
        }
        return true;
    }

    /**
     * 获取用户浏览记录
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $class_a 一级分类
     * @param  <int>    $class_b 二级分类
     * @param  <int>    $status  状态
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <string> $order   排序方式
     * @param  <bool>   $count   是否统计总条数
     * @return <mixed>
     */
    public function get_tasks_by_scan($user_id, $class_a, $class_b, $status, $page, $size, $order = null, $count = false){
        return $this->provider->get_tasks_by_scan(intval($user_id), intval($class_a), intval($class_b), intval($status), intval($page), intval($size), $order, $count);
    }

    public function is_deleted($task_id) {
        //验证参数
        if(!is_numeric($task_id)){
            return false;
        }
        //查询数据
        return $this->provider->is_deleted($task_id);
    }

    public function is_exist($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->is_exist($id);
    }

    public function is_finished($task_id) {
        //验证参数
        if(!is_numeric($task_id)){
            return false;
        }
        //查询数据
        return $this->provider->is_finished($task_id);
    }

    public function report($task_id) {
        //验证参数
        if(!is_numeric($task_id)){
            return false;
        }
        //查询数据
        return $this->provider->report($task_id);
    }

    public function update(TaskDomainModel $model) {
        //验证参数
        if(!$this->verify_update_args($model)){
            return false;
        }
        return $this->provider->update($model);
    }

    /**
     * 选择中标
     * @param  <int> $user_id  当前用户编号
     * @param  <int> $info_id  选标任务编号
     * @param  <int> $reply_id 中标任务编号
     * @return <bool> 是否成功
     */
    public function reply_bid($user_id, $info_id, $reply_id){
        $check = $this->check_bid($user_id, $info_id, $reply_id);
        if($check !== true){
            return $check;
        }
        $this->provider->trans();                           //事务开启
        if(!$this->provider->set_reply_bid($reply_id)){     //设置中标
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);      
        }
        if(!$this->provider->set_task_status($info_id, 2)){ //设置任务状态为已完成
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);      
        }
        $this->provider->commit();
        return true;
    }

    /**
     * 获取随机B类任务分类列表
     * @param  <int> $count 获取条数
     * @return <array>
     */
    public function get_rand_btypes($count){
        return $this->provider->get_rand_btypes(intval($count));
    }

    public function verify_add_args(TaskDomainModel $model) {
        if(!isset($model)){
            return false;
        }else{
            if(mb_strlen($model->__get('title'),'utf-8')>100){
                return false;
            }
            if(mb_strlen($model->__get('content'),'utf-8')>10000){
                return false;
            }
            if($model->__get('min_price')>99999999){
                return false;
            }
            if($model->__get('max_price')>99999999){
                return false;
            }
        }
        return true;
    }

    public function verify_like_args($like_title, $like_content, $like_name) {
        //验证字段
        if(!isset ($like_title)&&!isset ($like_content)&&!isset ($like_name)){
            return false;
        }
        if(mb_strlen($like_title,'utf-8')>20){
            return false;
        }
        if(mb_strlen($like_content,'utf-8')>10000){
            return false;
        }
        if(mb_strlen($like_name,'utf-8')>50){
            return false;
        }
        return true;
    }

    public function verify_page_args($page_index, $page_size, $order) {
        if(!isset($page_index)||!is_numeric($page_index)||$page_index<0){
            return false;
        }
        if(!isset($page_size)||!is_numeric($page_size)||$page_size<0){
            return false;
        }
//        if(!preg_match("/(desc|asc|sort|info_id|user_id|read_count|comment_count|start_time|end_time|task_type|min_price|max_price|info_class_a|info_class_b|user_name|info_title|info_content)?/is", $order)){
//            return false;
//        }
        return true;
    }

    public function verify_update_args(TaskDomainModel $model) {
        if(isset($model)){
            return false;
        }else{
            if($model->__get('id')==null||!is_numeric($model->__get('id'))){
                return false;
            }
            if(mb_strlen($model->__get('title'),'utf-8')>100){
                return false;
            }
            if(mb_strlen($model->__get('content'),'utf-8')>10000){
                return false;
            }
            if($model->__get('min_price')>99999999){
                return false;
            }
            if($model->__get('max_price')>99999999){
                return false;
            }
            if(!self::is_date($model->__get('start_time'))){
                return false;
            }
            if(!self::is_date($model->__get('end_time'))){
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

    //------------------protected----------------
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
            $title = substr($content, 0, 10000);
        return htmlspecialchars($content);
    }

    /**
     * 联系方式过滤
     * @param  <string> $phone 联系方式
     * @return <string>
     */
    protected function filter_phone($phone){
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
        if(!preg_match('/^[\w-]{0,20}$/',$qq))
            return '';
        return $qq;
    }

    /**
     * IP过滤
     * @param  <string> $ip IP
     * @return <string>
     */
    protected function filter_ip($ip){
        if(strlen($ip) > 30)
            return $ip;
        return htmlspecialchars($ip);
    }

    /**
     * 天数过滤
     * @param  <int> $days 任务天数
     * @return <int>
     */
    protected function filter_days($days){
        if($days < 1)
            return 1;
        if($days > 30)
            return 30;
        return intval($days);
    }
    
    /**
     * 搜索关键字过滤
     * @param  <string> $like 关键字
     * @return <string>
     */
    protected function filter_like($like){
        if($like === null)
            return '';
        if(strlen($like) > 100)
            return '';
        return htmlspecialchars($like);
    }

    /**
     * 检测中标条件是否符合
     * @param <type> $user_id
     * @param <type> $info_id
     * @param <type> $reply_id
     */
    protected function check_bid($user_id, $info_id, $reply_id){
        $task = $this->provider->get_task($info_id);
        if(empty($task))
            return E(ErrorMessage::$TASK_NOT_EXISTS);               //任务不存在
        if($task['status'] != 1)
            return E(ErrorMessage::$TASK_STATUS_NO_BID);            //指定任务状态不允许选标
        if($task['user_id'] != $user_id)
            return E(ErrorMessage::$TASK_DO_PERMISSION_LESS);       //任务不属于指定用户
        $provinder = new ReplyProvider();
        $reply = $provinder->get_reply($reply_id);
        if(empty($reply))
            return E(ErrorMessage::$REPLY_NOT_EXISTS);              //回复不存在
        if($reply['info_id'] != $info_id)
            return E(ErrorMessage::$REPLY_NOT_IN_TASK);             //回复不属于指定任务
        return true;
    }

     /**
     * 任务推广(判断是否符合条件)
     * @param <int> $user_id 用户编号
     * @param <int> $info_id 任务编号
     * @param <string> $service_type  任务推广方式 1:
     * @param <int> $day 置顶天数
     */

    public function task_service($user_id, $info_id,$service_type,$day=null){
        $taskInfo = $this->provider->get_task($info_id);            //获取任务信息
        if(empty ($taskInfo))
            return E(ErrorMessage::$TASK_NOT_EXISTS);               //任务不存在;
        if($user_id != $taskInfo['user_id'])
            return E(ErrorMessage::$PERMISSION_LESS);               //无权进行此操作
        $serviceInfoModel = new ServiceProvider();
        $serviceInfo = $serviceInfoModel->get_service($service_type);       //获取推广类别信息price
        $billDomainModel = new BillDomain();
        $this->provider->trans();
        if($service_type == C('TASK_SERVICE_TOP')){
            $count = $this->provider->get_information_top($taskInfo['info_class_b']);   //计算现在是否在相同二级分类下面有置顶
            if($count < 1){
                if(!empty($day)){
                    $billInfo = $billDomainModel->consume($taskInfo['user_id'], $taskInfo['user_name'],$serviceInfo['price'] * $day , $serviceInfo['name']); //付款
                    if($billInfo === TRUE){                                              //如果付款成功
                        if(!$this->provider->set_information_top($taskInfo['info_id'], $taskInfo['info_class_b'], $day)){ //设置置顶信息
                            $this->provider->rollback();
                            return E(ErrorMessage::$OPERATION_FAILED);
                        }
                        if(!$this->provider->set_task_service($info_id, $service_type)){     //执行任务流程
                            $this->provider->rollback();
                            return E(ErrorMessage::$OPERATION_FAILED);
                        }
                    }  else {
                        $this->provider->rollback();
                        return $billInfo;
                    }
                }else{
                    return E(ErrorMessage::$ORDER_NOT_EXISTS);      //没有选择置顶天数
                }
            }else{
                return E(ErrorMessage::$SERVICE_TOP_EXISTS);      //该分类下已有置顶帖
            }
        }else if($service_type == C('TASK_SERVICE_EYE') || $service_type == C('TASK_SERVICE_RECOMMEND')){
            $billInfo = $billDomainModel->consume($taskInfo['user_id'], $taskInfo['user_name'],$serviceInfo['price'] , $serviceInfo['name']);//付款
            if($billInfo === true){                                              //如果付款成功
                if(!$this->provider->set_task_service($info_id, $service_type)){     //执行任务流程
                    $this->provider->rollback();
                    return E(ErrorMessage::$OPERATION_FAILED);
                }
            }  else {
                $this->provider->rollback();
                return $billInfo;
            }
        }
        $this->provider->commit(true);
        return true;

    }

    /**
     *
     * @param <type> $class_b
     *
     */
    public function get_information_top($class_b){
        return $this->provider->get_information_top($class_b);   //计算现在是否在相同二级分类下面有置顶
    }

    /**
     * 获取指定二级分类下当前时间段的置顶信息
     * @param <int> $class_b 二级分类编号
     * @return <array> 置顶信息
     */
    public function get_top_info($class_b){
        return $this->provider->get_top_info($class_b);
    }

    public function get_task_service_user_list($user_id,$task_id){
        $eyeCount = $this->provider->get_task_service_user_count($user_id, C('TASK_SERVICE_EYE'));  //此用户醒目条数
        $recommendcount = $this->provider->get_task_service_user_count($user_id, C('TASK_SERVICE_RECOMMEND'));  //此用户推荐总条数条数
        $recommendingCount = $this->provider->get_task_service_user_count($user_id, C('TASK_SERVICE_RECOMMEND'),1);  //此用户推荐总条数条数
        $topCount = $this->provider->get_task_service_user_count($user_id, C('TASK_SERVICE_TOP'));  //此用户置顶总条数条数
        $array['eyecount'] = $eyeCount;
        $array['recommendcount'] = $recommendcount;
        $array['recommendingCount'] = $recommendingCount;
        $array['topcount'] = $topCount;
        $topingcount = $this->provider->get_user_top_count($user_id);
        $array['topingcount'] = $topingcount['0']['num'];
        return $array;
    }

    public function get_task_service_user_vars($user_id){
        $serviceModel = new ServiceProvider();
        $service_list = $serviceModel->get_service_list();
        foreach ($service_list as $key => $value) {
            $service_list[$key]['count_num'] = $this->provider->get_task_service_user_count($user_id, $value['id']);
            if($value['id'] == C('TASK_SERVICE_RECOMMEND')){
                $service_list[$key]['count'] = $this->provider->get_task_service_user_count($user_id, C('TASK_SERVICE_RECOMMEND'),1);
            }else if($value['id'] == C('TASK_SERVICE_TOP')){
                $topingcount = $this->provider->get_user_top_count($user_id);
                $service_list[$key]['count'] = $topingcount[0]['num'];
            }else{
                $service_list[$key]['count'] = -1;
            }
        }
        return $service_list;
    }
}
?>
