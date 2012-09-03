<?php
/**
 * 服务层-任务类
 * @author YoyiorLee
 */
class TaskService{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new TaskProvider();
    }

    /**
     * 删除回复(ok)
     * @param <int> $id 编号
     * @return <bool> 是否成功
     */
    public function delete_reply($id) {
        $id = var_validation($id, VAR_ID, OPERATE_FILTER);
        $provider = new ReplyProvider();
        return $provider->delete($id);
    }

    /**
     * 删除浏览记录(ok)
     * @param <int> $id 编号
     * @return <bool> 是否成功
     */
    public function delete_scan($id) {
        $id = var_validation($id, VAR_ID, OPERATE_FILTER);
        $provider = new ScanProvider();
        return $provider->delete($id);
    }

    /**
     * 删除任务(ok)
     * @param <int> $task_id 任务编号
     * @return <bool> 是否成功
     */
    public function delete_task($task_id) {
        $task_id = var_validation($task_id, VAR_ID, OPERATE_FILTER);
        return $this->provider->delete($task_id);
    }

    /**
     * 结束任务(ok)
     * @param <int> $user_id 用户编号
     * @param <int> $task_id 任务编号
     * @return <bool> 是否成功
     */
    public function finish($user_id, $task_id) {
        $task = $this->provider->get_task($task_id);
        if(empty($task) || $task['user_id'] != $user_id){
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        if($task['status'] > 1){
            return E();
        }
        if(!$this->provider->_update($task_id, array('status' => 3))){
            return E();
        }
        return true;
    }

    /**
     * 根据任务id获取任务回复列表(ok)
     * @param <int> $id 编号
     * @return <ReplyDomainModel> 回复实体
     */
    public function get_reply($id) {
        $id = var_validation($id, VAR_ID, OPERATE_FILTER);
        $provider = new ReplyProvider();
        return $provider->get_reply($id);
    }

    /**
     * 根据任务id获取任务回复列表(ok)
     * @param <int> $task_id 编号
     * @param <int> $user_id 编号
     * @param <int> $page_index 当前页数 第一页默认为0
     * @param <int> $page_size 每页大小
     * @param <int> $order 排序方式
     * @return <ReplyDomainModel> 回复实体
     */
    public function get_replys($task_id, $user_id, $page, $size, $order) {
        $page = var_validation($page, VAR_PAGE, OPERATE_FILTER);
        $size = var_validation($size, VAR_SIZE, OPERATE_FILTER);
        $provider = new ReplyProvider();
        if(!empty($task_id)){
            $task_id = var_validation($task_id, VAR_ID, OPERATE_FILTER);
            return $this->provider->get_replys_by_task_id($task_id, $page, $size, $order);
        }else if(!empty($user_id)){
            $user_id = var_validation($user_id, VAR_ID, OPERATE_FILTER);
            return $this->provider->get_replys_by_user_id($user_id, $page, $size, $order);
        }else{
            return null;
        }
    }

    /**
     * 根据id获取任务浏览(ok)
     * @param <int> $id 编号
     * @return <mixed> 浏览模型
     */
    public function get_scan($id) {
        $id = var_validation($id, VAR_ID, OPERATE_FILTER);
        $provider = new ScanProvider();
        return $this->provider->get_scan($id);
    }

    /**
     * 根据任务id获取任务浏览列表(ok)
     * @param <int> $task_id 任务编号
     * @return <mixed> 浏览模型
     */
    public function get_scans($task_id) {
        $task_id = var_validation($task_id, VAR_ID, OPERATE_FILTER);
        $provider = new ScanProvider();
        return $this->provider->get_scans($id);
    }

    /**
     * 根据任务编号获取任务(ok)
     * @param <int> $task_id 任务编号
     * @return <TaskDomainModel> 任务实体
     */
    public function get_task($task_id) {
        return $this->provider->get_task($task_id);
//        $task_id = var_validation($task_id, VAR_ID, OPERATE_FILTER);
//        $cache_key = CC('USER_TASK_ITEM').$task_id;
//        $data = DataCache::get($cache_key);
//        if(empty($data)){
//            $data = $this->provider->get_task($task_id);
//            if(!empty($data))
//                DataCache::set($cache_key, $data, CC('CACHE_TIME_LITTLE'));
//        }
//        return $data;
    }

    /**
     * 获取推荐任务
     * @param <int> $type 类型
     * @param <int> $page_index 当前页数 第一页默认为0
     * @param <int> $page_size 每页大小
     * @return <TaskDomainModel> 任务实体列表
     */
    public function get_task_by_recommend($type,$page,$size){
        $page = var_validation($page, VAR_PAGE, OPERATE_FILTER);
        $size = var_validation($size, VAR_SIZE, OPERATE_FILTER);
        return  $this->provider->get_task_by_recommend($type,$page,$size);
    }

    /**
     * 获取用户竞标过的任务列表
     * @param <int> $user_id 用户编号
     * @param <int> $status  任务状态
     * @param <int> $class_a 一级分类编号
     * @param <int> $class_b 二级分类编号
     * @param <int> $page 当前页数
     * @param <int> $size 每页大小
     * @param <int> $order 排序方式
     * @param <bool> $count 是否统计总数
     * @return <mixed> 任务实体列表
     */
    public function get_tasks_by_replyed($user_id, $status, $class_a, $class_b, $page, $size, $order = null, $count = false){
        $user_id = var_validation($user_id, VAR_ID, OPERATE_FILTER);
        $class_a = var_validation($class_a, VAR_ID, OPERATE_FILTER, true);
        $class_b = var_validation($class_b, VAR_ID, OPERATE_FILTER, true);
        $status  = var_validation($status, VAR_TSTATUS, OPERATE_FILTER, true);
        $page    = var_validation($page, VAR_PAGE, OPERATE_FILTER);
        $size    = var_validation($size, VAR_SIZE, OPERATE_FILTER);
        return $this->provider->get_tasks_by_replyed($user_id, $status, $class_a, $class_b, $page, $size, $order, $count);
    }
    
    /**
     * 获取我中标的任务列表(ok)
     * @param <int> $user_id 用户编号
     * @param <int> $page 当前页数 第一页默认为0
     * @param <int> $size 每页大小
     * @param <int> $order 排序方式
     * @param <bool> $count 是否统计总条数
     * @return List<TaskDomainModel> 任务实体
     */
    public function get_tasks_by_bided($user_id, $page, $size, $order = null, $count = false) {
        $user_id = var_validation($user_id, VAR_ID, OPERATE_FILTER);
        $page    = var_validation($page, VAR_PAGE, OPERATE_FILTER);
        $size    = var_validation($size, VAR_SIZE, OPERATE_FILTER);
        return  $this->provider->get_tasks_by_bided($user_id, $page, $size, $order, $count);
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
        $class_a = var_validation($class_a, VAR_ID, OPERATE_FILTER, true);
        $class_b = var_validation($class_b, VAR_ID, OPERATE_FILTER, true);
        $status  = var_validation($status, VAR_TSTATUS, OPERATE_FILTER, true);
        $from    = var_validation($from, VAR_DATE, OPERATE_FILTER, true);
        $to      = var_validation($to, VAR_DATE, OPERATE_FILTER, true);
        $page    = var_validation($page, VAR_PAGE, OPERATE_FILTER);
        $size    = var_validation($size, VAR_SIZE, OPERATE_FILTER);
        $like    = var_validation($like, VAR_TLIKE, OPERATE_FILTER, true);
        $user_id = var_validation($user_id, VAR_ID, OPERATE_FILTER, true);
        return $this->provider->get_task_list($class_a, $class_b, $status, $from, $to, $page, $size, $order, $count, $like, $user_id);
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
        $task_id = var_validation($task_id, VAR_ID, OPERATE_FILTER);
        $page    = var_validation($page, VAR_PAGE, OPERATE_FILTER);
        $size    = var_validation($size, VAR_SIZE, OPERATE_FILTER);
        $provider = new ReplyProvider();
        return $provider->get_reply_list($task_id, $role_code, $auth_code, $page, $size, $count);
    }

    /**
     * 获取任务类别/分类(ok)
     * @param <int> $id 类别编号
     * @param <int> $page_index 当前页数 第一页默认为0
     * @param <int> $page_size 每页大小
     * @param <int> $order 排序方式
     * @return List<TaskDomainModel> 任务实体
     */
    public function get_type($id) {
        return $this->provider->get_type($id);
    }

    /**
     * 获取任务类别/分类列表(ok)
     * @param <int> $id 编号
     * @param <int> $page_index 当前页数 第一页默认为0
     * @param <int> $page_size 每页大小
     * @param <int> $order 排序方式
     * @return List<TaskDomainModel> 任务实体
     */
    public function get_types($id) {
        return $this->provider->get_types($id);
    }

    /**
     * 回复此任务(ok)
     * @param <int>    $task_id    任务编号
     * @param <int>    $user_id    用户编号
     * @param <string> $user_name  用户名
     * @param <string> $content    回复内容
     * @param <string> $contact    联系方式
     * @param <string> $email      邮箱
     * @param <string> $qq         QQ
     * @return <bool> 是否成功
     */
    public function reply($task_id, $user_id, $user_name, $content, $contact, $email, $qq){
        $task_id = var_validation($task_id, VAR_ID, OPERATE_FILTER);
        $user_id = var_validation($user_id, VAR_ID, OPERATE_FILTER);
        $result = $this->check_bid_permission($task_id, $user_id, $task);        //检测竞标权限
        if($result !== true)
            return $result;
        $provider  = new ReplyProvider();
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($user_id, 9, $task['info_title']);
        if(is_zerror($do)){
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        $content = var_validation($content, VAR_BCONTENT, OPERATE_FILTER);      //竞标内容过滤
        $contact = var_validation($contact, VAR_CONTACT, OPERATE_FILTER);       //联系方式过滤
        $email   = var_validation($email, VAR_EMAIL, OPERATE_FILTER);           //邮箱过滤
        if(empty($contact)){
            return E(ErrorMessage::$CONTACT_ERROR);             //联系方式无效
        }
        $this->provider->trans();                               //事务开启
        //添加竞标信息
        if(!$provider->reply($task_id, $user_id, $user_name, $content, $contact, $email, $qq, date_f())){
            $this->provider->rollback();                        //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        //增加任务的投标数
        if(!$this->provider->increase_bid_count($task_id)){
            $this->provider->rollback();                        //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                              //事务提交
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        $service = new ContactsService();
        $service->moving_bid_task($user_id, $task_id, $task['info_title'], $task['info_class_a']);
        $service = new RemindService();
        $service->notify(C('REMIND_BID'), $task['user_id']);        //通知
        return $task;
    }

    /**
     * 浏览记录(ok)
     * @param <int> $task_id 任务编号
     * @param <int> $user_id 用户编号
     * @param <int> $user_name 用户名
     * @param <int> $title 标题
     * @param <datetime> $date 日期
     * @return <bool> 是否成功
     */
    public function scan($task_id, $user_id, $user_name, $title, $date) {
        $provider = new ScanProvider();
        return $provider->add($user_id, $user_name, $task_id, $title, $date);
    }

    public function get_tasks_by_time($start_time, $end_time, $page_index, $page_size, $order) {
        return $this->provider->get_tasks_by_time($start_time, $end_time, $page_index, $page_size, $order);
    }

    public function get_tasks_by_class($task_class_a,$task_class_b, $page_index, $page_size, $order) {
        return $this->provider->get_tasks_by_class($task_class_a, $task_class_b, $page_index, $page_size, $order);
    }

    /**
     * 发布任务(ok)
     * @param <int> $user_id 用户编号
     * @param <string> $user_name 用户名
     * @param <string> $title 任务标题
     * @param <string> $content 任务内容
     * @param <int> $class_a 任务分类a
     * @param <int> $class_b 任务分类b
     * @param <int> $type 任务类型
     * @param <string> $phone 电话
     * @param <string> $email 邮箱
     * @param <string> $qq QQ
     * @param <int> $min_price 最低金额
     * @param <int> $max_price 最低金额
     * @param <int> $start_time 开始时间
     * @param <int> $end_time 结束时间
     * @param <int> $package_id 套餐编号
     * @return <bool> 是否成功
     */
    public function publish($user_id, $user_name, $title, $content, $class_a, $class_b, $type, $phone, $email, $qq, $min_price, $max_price, $start_time, $end_time, $package_id) {
        $model = new TaskDomainModel();
        $model->__set('user_id', $user_id);
        $model->__set('user_name', $user_name);
        $model->__set('title', $title);
        $model->__set('content', $content);
        $model->__set('class_a', $class_a);
        $model->__set('class_b', $class_b);
        $model->__set('type', $type);
        $model->__set('phone', $phone);
        $model->__set('email', $email);
        $model->__set('qq', $qq);
        $model->__set('min_price', $min_price);     //最低价格
        $model->__set('max_price', $max_price);     //最高价格 默认-1
        $model->__set('start_time', $start_time);     //开始时间
        $model->__set('end_time', $end_time);       //结束时间
        $model->__set('read_count', 0);
        $model->__set('comment_count', 0);
        $model->__set('status', 1);                 //任务状态 默认1
        $model->__set('sort', time() - 1000000000); //任务排序
        $model->__set('is_del', 0);                 //是否删除 默认0
        //-----------------------------------------------------------
        
        //验证参数
        if(!$this->verify_add_args($model)){
            return E(ErrorMessage::$PARAMETER_FORMAT_ERROR);                //参数格式错误
        }
        if(!AccessControl::check_class($model->__get('class_b'), 1))
            return E(ErrorMessage::$NO_TCLASS_PPERMISSION);                 //没有指定类别的发布权限
        //数据过滤
        $model->__set('title', var_validation($model->__get('title'), VAR_TTITLE, OPERATE_FILTER));
        $model->__set('content', var_validation($model->__get('content'), VAR_TCONTENT, OPERATE_FILTER));
        $model->__set('phone', var_validation($model->__get('phone'), VAR_CONTACT, OPERATE_FILTER));
        $model->__set('email', var_validation($model->__get('email'), VAR_EMAIL, OPERATE_FILTER));
        $model->__set('qq', var_validation($model->__get('qq'), VAR_QQ, OPERATE_FILTER));
        $phone = $model->__get('phone');
        if(empty($phone)){
            return E(ErrorMessage::$CONTACT_ERROR);                         //联系方式无效
        }
        $date = date_f('Y-m-d');
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($user_id, 8, $model->__get('title'));
        if(is_zerror($do)){
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        $this->provider->trans();
        $id = $this->provider->add($model);                                     //获取发布的任务编号
        if(!$id){
            $this->provider->rollback();
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                                              //事务提交
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        $service = new ContactsService();
        $service->moving_post_task($user_id, $id, $title, $class_b);
        return $id;
    }

    /**
     * 发布委托任务(ok)
     * @param <int> $user_id 用户编号
     * @param <string> $user_name 用户名
     * @param <string> $title 任务标题
     * @param <string> $content 任务内容
     * @param <int> $class_a 任务分类a
     * @param <int> $class_b 任务分类b
     * @param <string> $phone 电话
     * @param <string> $email 邮箱
     * @param <string> $qq QQ
     * @param <int> $min_price 最低金额
     * @param <int> $max_price 最低金额
     * @param <int> $start_time 开始时间
     * @param <int> $end_time 结束时间
     * @return <bool> 是否成功
     */
    public function publish_agent($user_id, $user_name, $title, $content, $class_a, $class_b, $phone, $email, $qq, $min_price, $max_price, $start_time, $end_time) {
        return $this->publish($user_id, $user_name, $title, $content, $class_a, $class_b, 2, $phone, $email, $qq, $min_price, $max_price, $start_time, $end_time);
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
    public function publish_fast($title, $content, $days, $contact, $email, $qq, $ip){
        $content = var_validation($content, VAR_TCONTENT, OPERATE_FILTER);
        $days    = var_validation($days, VAR_TDAYS, OPERATE_FILTER);
        $contact = var_validation($contact, VAR_CONTACT, OPERATE_FILTER);
        $email   = var_validation($email, VAR_EMAIL, OPERATE_FILTER);
        $qq      = var_validation($qq, VAR_QQ, OPERATE_FILTER);
        $ip      = var_validation($ip, VAR_IP, OPERATE_FILTER);
        $title   = '来自'.$ip.'的任务';
        //添加数据
        if(!$this->provider->add_fast($title,$content,$days,$contact, $email, $qq, $ip)){
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        return true;
    }
    
    /**
     * 修改任务(ok)
     * @param <int> $id 编号
     * @param <int> $user_id 用户编号
     * @param <string> $user_name 用户名
     * @param <string> $title 任务标题
     * @param <string> $content 任务内容
     * @param <int> $class_a 任务分类a
     * @param <int> $class_b 任务分类b
     * @param <int> $type 任务类型
     * @param <string> $phone 电话
     * @param <string> $email 邮箱
     * @param <string> $qq QQ
     * @param <int> $min_price 最低金额
     * @param <int> $max_price 最低金额
     * @param <int> $start_time 开始时间
     * @param <int> $end_time 结束时间
     * @return <bool> 是否成功
     */
    public function update($id, $user_id, $user_name, $title, $content, $class_a, $class_b, $task_type, $phone, $email, $qq, $min_price, $max_price, $start_time, $end_time, $read_count, $comment_count, $status, $sort, $is_del) {
        $model = new TaskDomainModel();
        $model->__set('id', $id);
        $model->__set('user_id', $user_id);
        $model->__set('user_name', $user_name);
        $model->__set('title', $title);
        $model->__set('content', $content);
        $model->__set('class_a', $class_a);
        $model->__set('class_b', $class_b);
        $model->__set('type', $task_type);;
        $model->__set('phone', $phone);
        $model->__set('email', $email);
        $model->__set('qq', $qq);
        $model->__set('min_price', $min_price);     //最低价格
        $model->__set('max_price', $max_price);     //最高价格
        $model->__set('stat_time', $start_time);     //开始时间
        $model->__set('end_time', $end_time);       //结束时间
        $model->__set('read_count', $read_count);   //浏览次数
        $model->__set('comment_count', $comment_count);   //回复次数
        $model->__set('status', $status);                 //任务状态
        $model->__set('sort', $sort);                     //任务排序
        $model->__set('is_del', $is_del);                 //是否删除
        return $this->provider->update($model);
    }

    /**
     * 修改竞标信息(ok)
     * @param <int> $id 竞标编号
     * @param <int> $user_id 用户编号
     * @param <string> $user_name 用户名
     * @param <string> $bid_content 回复内容
     * @return <bool> 是否成功
     */
    public function update_reply($id, $user_id, $user_name, $task_id, $content, $date, $status, $is_bid, $is_del) {
        $model = new ReplyDomainModel();
        $model->__set('id', $id);
        $model->__set('user_id', $user_id);
        $model->__set('user_name', $user_name);
        $model->__set('task_id', $task_id);
        $model->__set('content', $content);
        $model->__set('date', $date);
        $model->__set('status', $status);
        $model->__set('is_bid', $is_bid);
        $model->__set('is_del', $is_del);
        $provider = new ReplyProvider();
        return $provider->update($model);
    }

    /**
     * 获取随机B类任务分类列表
     * @param  <int> $count 获取条数
     * @return <array>
     */
    public function get_rand_btypes($count){
        return $this->provider->get_rand_btypes(intval($count));
    }

    /**
     * 获取中标的竞标列表
     * @param  <int> $page 第几页
     * @param  <int> $size 每页几条
     * @param  <int> $tid 任务编号
     * @return <mixed> 列表
     */
    public function get_replys_by_bided($page, $size, $tid = null){
        $provider = new ReplyProvider();
        return $provider->get_replys_by_bided(intval($page), intval($size), $tid);
    }

    /**
     * 统计最近某类别发布任务数量
     * @param  <int> $class_a 分类A编号
     * @param  <int> $class_b 分类B编号
     * @param  <int> $day     最近天数
     * @return <int> 数量
     */
    public function count_task_nearby($class_a, $class_b, $day){
        $day = var_validation($day, VAR_ID, OPERATE_FILTER);
        $now = time();
        $start = $now - ($day - 1) * 86400;
        return $this->provider->count_task_by_date($class_a, $class_b, date_f('Y-m-d', $start).' 00:00:00', date_f());
    }

    public function get_subtypes(){
        return $this->provider->get_subtypes();
    }

    /**
     * 选择中标
     * @param  <int> $user_id  当前用户编号
     * @param  <int> $info_id  选标任务编号
     * @param  <int> $reply_id 中标任务编号
     * @return <bool> 是否成功
     */
    public function reply_bid($user_id, $info_id, $reply_id){
        $check = $this->check_bid($user_id, $info_id, $reply_id, $task, $reply);
        if($check !== true){
            return $check;
        }
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($user_id, 10, '竞标编号 '.$reply_id);
        if(is_zerror($do)){
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
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
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        $service = new ContactsService();
        $service->moving_selected_task($user_id, $info_id, $task['info_title'], $task['info_class_a']);
        $service = new RemindService();
        $service->notify(C('REMIND_BIDED'), $reply['user_id']);        //通知
        return true;
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
//        if(empty($user_id)){                                                                    //匿名用户
//            $this->provider->increase_read_count($info_id);                                     //增加任务的浏览数
//            return true;
//        }
        $provider = new ScanProvider();
        if(!$provider->exists_scan_record($user_id, $info_id, date_f(null, time() - 600))){       //检测十分钟以内是否已经浏览过
            $this->provider->trans();                                                             //事务开启
//            if(C('TASK_SCAN_CHECK')){                                                           //检测是否开任务查看验证
//                $pprovider = new PackageProvider();
//                $package   = $pprovider->get_package($package_id);                              //获取指定套餐信息
//                if($package['day_task_read'] != -1 && $package['read_price'] > 0){              //如果浏览权限并非无限制
//                    //统计用户今日浏览条数
//                    $count = $provider->get_user_scan_record($user_id, 1, 1, date_f('Y-m-d'), null, true);
//                    if($count >= $package['day_task_read']){                                    //如果浏览条数超出每日上限
//                        $bdomain = new BillDomain();
//                        //消费：任务查看
//                        $result  = $bdomain->consume($user_id, $user_name, $package['read_price'], '查看任务:'.$info_title);
//                        if($result !== true){
//                            $this->provider->rollback();                                        //事务回滚
//                            return $result;
//                        }
//                    }
//                }
//            }
            if(!$provider->add($user_id, $user_name, $info_id, $info_title, date_f())){         //添加任务浏览记录
                $this->provider->rollback();                                                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
            if(!$this->provider->increase_read_count($info_id)){                                //增加任务的浏览数
                $this->provider->rollback();                                                    //事务回滚
                return E(ErrorMessage::$OPERATION_FAILED);
            }
            $this->provider->commit();                                                          //事务提交
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

    /**
     * 检测指定用户是否竞标了指定任务
     * @param  <int> $info_id 任务编号
     * @param  <int> $user_id 用户编号
     * @return <bool>
     */
    public function check_user_reply_task($info_id, $user_id){
        $provider = new ReplyProvider();
        return $provider->check_user_reply_task($info_id, $user_id);
    }

    /**
     * 检测指定用户是否中标了指定任务
     * @param  <int> $info_id 任务编号
     * @param  <int> $user_id 用户编号
     * @return <bool>
     */
    public function check_user_bid_task($info_id, $user_id){
        $provider = new ReplyProvider();
        return $provider->check_user_bid_task($info_id, $user_id);
    }

    /**
     * 任务推广
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
        $this->provider->commit();
        return true;
    }

    /**
     * 统计指定二级分类的任务置顶数
     * @param <type> $class_b
     * @return <type> 
     */
    public function get_information_top($class_b){
        return $this->provider->get_information_top($class_b);
    }

    /**
     * 获取指定二级分类下当前时间段的置顶信息
     * @param <int> $class_b 二级分类编号
     * @return <array> 置顶信息
     */
    public function get_top_info($class_b){
        return $this->provider->get_top_info($class_b);
    }

    public function get_tasks_by_user_id($user_id, $status, $page_index, $page_size, $order = null, $count = false){
        return $this->provider->get_tasks_by_user_id($user_id, intval($status), $page_index, $page_size, $order, $count);
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

    /**
     * 获取分类信息
     * @param <type> $class
     * @return <type>
     */
    public  function get_class_info($class){
        return $this->provider->get_class_info($class);
    }

    /**
     * 获取角色有权限的一级任务分类
     * @param  <int> $role_id 角色编号
     * @param  <int> $op      操作类型（1为发布，2为竞标）
     * @return <mixed>
     */
    public function get_role_types($role_id, $op){
        return $this->provider->get_role_types($role_id, $op);
    }

    /**
     * 获取角色有权限的指定二级任务分类
     * @param  <int> $role_id 角色编号
     * @param  <int> $op      操作类型（1为发布，2为竞标）
     * @return <mixed>
     */
    public function get_role_subtypes($class_a, $role_id, $op){
        return $this->provider->get_role_subtypes($class_a, $role_id, $op);
    }

    //----------------protected------------------
    /**
     * 检测竞标权限
     * @param  <int> $task_id 任务编号
     * @return <mixed>
     */
    protected function check_bid_permission($task_id, $user_id, &$task){
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
     * 检测中标条件是否符合
     * @param <type> $user_id
     * @param <type> $info_id
     * @param <type> $reply_id
     */
    protected function check_bid($user_id, $info_id, $reply_id, &$task, &$reply){
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

    protected function verify_add_args(TaskDomainModel $model) {
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

    protected function verify_like_args($like_title, $like_content, $like_name) {
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

    protected function verify_page_args($page_index, $page_size, $order) {
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

    protected function verify_update_args(TaskDomainModel $model) {
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

}
?>
