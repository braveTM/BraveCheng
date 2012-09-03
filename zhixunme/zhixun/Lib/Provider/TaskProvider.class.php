<?php
/**
 * 数据访问层-任务类
 * @author YoyiorLee
 */
class TaskProvider extends BaseProvider{

    const INFORMATION_FIELDS_NORMAL = 'info_id,user_id,info_title,info_content,info_class_b,info_class_a,task_type,phone,email,qq,start_time,end_time,read_count,comment_count,status,is_del,service';
    const INFORMATION_FIELDS_LIST = 'info_id,user_id,info_title,info_class_b,info_class_a,task_type,phone,email,qq,start_time,end_time,read_count,comment_count,status,service';
    const TASK_TYPE_FIELDS_NOMAL = 'class_id,class_title,parent_id,class_code,price,unit,icon,sort,is_del';
    const TASK_TYPE_FIELDS_RAND = 'class_id,class_title,parent_id,price,unit,icon';
    
    public function add(TaskDomainModel $model) {
        $this->da->setModelName('information');
        $data = FactoryDMap::model_to_array($model,'task');
        unset($data['id']);
        return $this->da->add($data);
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
        $this->da->setModelName('task_fast');
        $data['title']      = $title;
        $data['content']    = $content;
        $data['start_time'] = date_f();
        $data['end_time']   = date_f('Y-m-d', time() + $days * 86400);
        $data['contact']    = $contact;
        $data['email']      = $email;
        $data['qq']         = $qq;
        $data['ip']         = $ip;
        $data['status']     = 1;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    public function delete($task_id) {
        $this->da->setModelName('information');
        $where['info_id']  = $task_id;
        $data['is_del'] = 1;
        return $this->da->where($where)->data($data)->save();
    }

    public function favorite($task_id) {
        //do favorite
        return true;
    }

    public function get_task($task_id){
        $this->da->setModelName('information');
        $where['info_id']  = $task_id;
        $where['is_del']  = 0;
        return $this->da->where($where)->field(self::INFORMATION_FIELDS_NORMAL)->find();
    }

    /**
     * 获取推荐任务列表
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $class_a 一级分类
     * @param  <int>    $class_b 二级分类
     * @param  <int>    $role    用户角色
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <bool>   $count   是否统计总条数
     * @return <mixed> 任务列表
     */
    public function get_task_by_recommend($user_id, $class_a, $class_b, $role, $page, $size, $count = false){
        $this->da->setModelName('information t1');         //使用任务表
        $where['t1.is_del'] = 0;
        if(!empty($class_b)){                           //分类筛选
            $where['t1.info_class_b'] = $class_b;
        }
        elseif (!empty($class_a)) {
             $where['t1.info_class_a'] = $class_a;
        }
        $where['t1.status'] = 1;
        if(empty($order))
            $order = 't1.sort DESC';
        if(!empty($role)){
            $join[] = C('DB_PREFIX').'user t2 ON t2.user_id=t1.user_id';
            $where['t2.role_id'] = $role;
        }
        if($count){
            if(!empty($join))
                return $this->da->join($join)->where($where)->count('t1.info_id');
            return $this->da->where($where)->count('t1.info_id');
        }
        else{
            $field = 't1.info_id,t1.user_id,t1.info_title,t1.info_class_b,t1.info_class_a,t1.task_type,t1.phone,t1.email,t1.qq,t1.start_time,t1.end_time,t1.read_count,t1.comment_count,t1.status,t1.service';
            if(!empty($join))
                return $this->da->join($join)->where($where)->page("$page,$size")->field($field)->order($order)->select();
            return $this->da->where($where)->page("$page,$size")->field($field)->order($order)->select();
        }
    }

    public function get_tasks_by_replyed($user_id, $status, $class_a, $class_b, $page, $size, $order = null, $count = false){
        $reply_tabel = C('DB_PREFIX').'information_reply';        //回复表名
        $task_tabel  = C('DB_PREFIX').'information';              //任务表名
        $table = "$reply_tabel r,$task_tabel i";
        $where = 'r.is_del=0 AND i.is_del=0 AND i.info_id=r.info_id';
        $where .= " AND r.user_id=$user_id";
        if(!empty($class_b))
            $where .= ' AND i.info_class_b='.intval($class_b);
        elseif(!empty($class_a))
            $where .= ' AND i.info_class_a='.intval($class_a);
        if(!empty($status))
            $where .= ' AND i.status='.intval($status);
        else
            $where .= ' AND i.status>0';
        if($count){                                     //统计条数
            $sql = "SELECT COUNT(i.info_id)
                    FROM $table
                    WHERE $where";
            $result = $this->da->query($sql);
            return intval($result[0]['COUNT(i.info_id)']);
        }
        else{
            if(empty($order))
                $order = 'i.start_time DESC';
            if($page == 0)
                $page = 1;
            $limit = (($page - 1) * $size).", $size";
            $field = 'i.info_id, i.user_id,i.user_name,i.info_title,i.info_content,i.comment_count,i.read_count,i.start_time,i.end_time,i.status,r.is_bid';
            $sql   = "SELECT $field
                      FROM $table
                      WHERE $where
                      ORDER BY $order
                      LIMIT $limit";
            return $this->da->query($sql);
        }
    }

    public function get_tasks_by_reply_count($page_index, $page_size, $order) {
        $this->da->setModelName('information');
        $where['status']  = 1;
        $where['is_del']  = 0;
        $order='comment_count '.$order;
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        if(empty($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;
    }

    public function get_tasks_by_bided($user_id, $page, $size, $order = null, $count = false) {
        $reply_tabel = C('DB_PREFIX').'information_reply';        //回复表名
        $task_tabel  = C('DB_PREFIX').'information';              //任务表名
        $table = "$reply_tabel r,$task_tabel i";
        $where = 'r.is_del=0 AND i.is_del=0 AND i.status=1 AND i.info_id=r.info_id AND r.is_bid=1';
        $where .= " AND r.user_id=$user_id";
        if($count){                                     //统计条数
            $sql = "SELECT COUNT(i.info_id)
                    FROM $table
                    WHERE $where";
            $result = $this->da->query($sql);
            return intval($result[0]['COUNT(i.info_id)']);
        }
        else{
            if(empty($order))
                $order = 'i.start_time DESC';
            if($page == 0)
                $page = 1;
            $limit = (($page - 1) * $size).", $size";
            $field = 'i.info_id, i.user_id,i.user_name,i.info_title,i.info_content,i.comment_count,i.read_count,i.start_time,i.end_time';
            $sql   = "SELECT $filed
                      FROM $table
                      WHERE $where
                      ORDER BY $order
                      LIMIT $limit";
            return $this->da->query($sql);
        }
    }

    public function get_tasks_by_class($task_class_a, $task_class_b, $page_index, $page_size, $order) {
        $this->da->setModelName('information');
        $where['status']  = 1;
        $where['is_del']  = 0;
        if(!empty($task_class_a)){
            $where['info_class_a']  = $task_class_a;
        }else{
            $where['info_class_b']  = $task_class_b;
        }
        if(empty($order))
            $order = 'sort DESC';
        return $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        /*$result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_NOMAL)->select();
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;
         * 
         */
    }

    public function get_tasks_by_default($page_index, $page_size, $order) {
        $this->da->setModelName('information');
        $where['status']  = 1;
        $where['is_del']  = 0;
        if(empty ($order)){
            $order='start_time DESC';
        }
        //人工控制条件
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        if(empty($result))
            return null;
        //人工控制条件
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;
    }

    public function get_tasks_by_like($like_title, $like_content, $like_name, $class, $status, $start_time, $end_time, $page_index, $page_size, $order) {
        $this->da->setModelName('information');
        $where['is_del']  = 0;
        if(!isset ($like_title)&&!isset ($like_content)&&!isset ($like_name)){
            return null;
        }
        if(isset ($like_title)){
            $where['info_title']  = array('like', "%$like_title%");
        }
        if(isset ($like_content)){
            $where['info_content']  = array('like', "%$like_content%");
        }
        if(isset ($like_name)){
            $where['user_name']  = array('like', "%$like_name%");
        }
        if(isset ($class)){
            $where['info_class_a']  =$class;
            $where['info_class_b']  = $class;
        }
        if(isset ($status)){
            $where['status']  = $status;
        }else{
            $where['status']  = array('neq', "0");;
        }
        if(isset ($start_time)){
            $where['start_time']  = array('egt', "%$start_time%");
        }
        if(isset ($end_time)){
            $where['end_time']  = array('elt', "%$end_time%");
        }
        if(isset ($order)){
            $order = 'end_time desc';
        }
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        if(isset($result))
            return null;
        //人工控制条件
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;
    }

    public function get_tasks_by_read($page_index, $page_size, $order) {
        $this->da->setModelName('information');
        $where['status']  = 1;
        $where['is_del']  = 0;
        $order = 'read_count '.$order;
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        if(empty($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;
    }

    public function get_tasks_by_sort($page_index, $page_size, $order) {
        $this->da->setModelName('information');
        $where['status']  = 1;
        $where['is_del']  = 0;
        $order = 'sort '.$order;
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        if(empty($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;
    }

    public function get_tasks_by_status($task_status, $page_index, $page_size, $order) {
        $this->da->setModelName('information');
        $where['status']  = $task_status;
        $where['is_del']  = 0;
        if(empty ($order)){
            $order='start_time desc';
        }
        return $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        /*$result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_NOMAL)->select();
        if(isset($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;*/
    }

    public function get_tasks_by_time($start_time, $end_time, $page_index, $page_size, $order) {
        $this->da->setModelName('information');
        $where['status']  = 1;
        $where['is_del']  = 0;
        if(!empty ($start_time)&&empty ($end_time)){
            $where['start_time']  = array('elt',"$start_time");
        }else if(empty ($start_time)&&!empty ($end_time)){
            $where['end_time']  = array('egt',"$end_time");
        }else if(!empty ($start_time)&&!empty ($end_time)){
            $where['start_time']  = array('elt',"$start_time");
            $where['end_time']  = array('egt',"$end_time");
        }
        if(empty($order))
            $order= 'start_time desc';
        return $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        //$result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_NOMAL)->select();        return $result;
        /*$models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;*/
    }

    public function get_tasks_by_type($task_type, $page_index, $page_size, $order) {
        $this->da->setModelName('information');
        $where['status']  = 1;
        $where['task_type']  = $task_type;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        if(empty($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;
    }

    public function get_tasks_by_user_id($user_id, $status, $page_index, $page_size, $order = null, $count = false) {
        $this->da->setModelName('information');
        $where['user_id']  = $user_id;
        if(!empty ($status)){
            $where['status']  = $status;
        }else{
            $where['status']  = array('gt', "0");;
        }
        $where['is_del']  = 0;
        if($count)                      //统计数量
            return $this->da->where($where)->count('info_id');
        if(empty($order)){
            $order = 'sort DESC';
        }
        return $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_LIST)->select();
        /*$result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_NOMAL)->select();
        if(isset($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'task');
            array_push($models, $one);
        }
        return $models;*/
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
        $this->da->setModelName('information');         //使用任务表
        $where['is_del'] = 0;
        if(!empty($user_id)){
            $where['user_id'] = $user_id;
        }
        if(!empty($class_b)){                           //分类筛选
            $where['info_class_b'] = $class_b;
        }
        elseif (!empty($class_a)) {
             $where['info_class_a'] = $class_a;
        }
        if(!empty($status)){                            //状态筛选
            $where['status'] = $status;
        }
        else{
            $where['status'] = array('gt', 0);
        }
        if(!empty($from) && !empty($to)){              //发布日期筛选
            $where['start_time'] = array('between', "'$from','$to'");
        }
        else if(!empty($from)){
            $where['start_time'] = array('egt', $from);
        }
        else if(!empty($to)){
            $where['start_time'] = array('elt', $to);
        }
        if($like !== null && $like !== ''){            //关键字筛选
            $where['info_title'] = array('like', "%$like%");
        }
        if(empty($order))
            $order = 'sort DESC';
        if($count)
            return $this->da->where($where)->count('info_id');
        else
            return $this->da->where($where)->page("$page,$size")->field(self::INFORMATION_FIELDS_LIST)->order($order)->select();
    }

    public function get_type($id) {
        $this->da->setModelName('task_class');
        $where['class_id']  = $id;
        $where['is_del']  = 0;
        return $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        /*$result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        if(empty($result))
            return null;
        return FactoryDMap::array_to_model($result, 'type');*/
    }

    public function get_types($id) {
        $this->da->setModelName('task_class');
        $where['parent_id']  = $id;
        $where['is_del']     = 0;
        return $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->order('sort DESC')->select();
        /*$result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->select();
        if(empty($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'type');
            array_push($models, $one);
        }
        return $models;*/
    }

    public function get_subtypes(){
        $this->da->setModelName('task_class');
        $where['parent_id']  = array('gt', 0);
        $where['is_del']     = 0;
        return $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->select();
    }

    public function is_exist($id) {
        $this->da->setModelName('information');
        $where['info_id']  = $task_id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        return $result>0;
    }

    public function is_finished($task_id) {
        $this->da->setModelName('information');
        $where['info_id']  = $task_id;
        $where['status']  = 2;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        return $result>0;
    }

    public function report($task_id) {
        //do report
        return true;
    }

    public function update(TaskDomainModel $model) {
        $this->da->setModelName('information');
        $where['info_id']  = $model->__get("id");
        $data = FactoryDMap::model_to_array($model, 'task');
        unset($data['id']);
        return $this->da->where($where)->data($data)->save() != false;
    }

    /**
     * 更新任务信息
     * @param <type> $id
     * @param <type> $data
     * @return <bool>
     */
    public function _update($id, $data){
        $this->da->setModelName('information');
        $where['info_id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->data($data)->save() != false;
    }

    /**
     * 获取随机B类任务分类列表
     * @param  <int> $count 获取条数
     * @return <array>
     */
    public function get_rand_btypes($count){
        $this->da->setModelName('task_class');
        $where['parent_id'] = array('gt', 0);
        $where['is_del']    = 0;
        return $this->da->where($where)->order('rand()')->page('1,'.$count)->field(self::TASK_TYPE_FIELDS_RAND)->select();
    }

    /**
     * 统计指定时间段内某类别发布任务数量
     * @param  <int> $class_a 分类A编号
     * @param  <int> $class_b 分类B编号
     * @param  <date> $from 起始日期
     * @param  <date> $to   结束时间
     * @return <int> 数量
     */
    public function count_task_by_date($class_a, $class_b, $from, $to){
        $this->da->setModelName('information');
        $where['is_del']     = 0;
        $where['start_time'] = array('between', "'$from','$to'");
        $where['status']     = array('gt', 0);
        if(!empty ($class_a))
            $where['info_class_a'] = $class_a;
        else
            $where['info_class_b'] = $class_b;
        return $this->da->where($where)->count('info_id');
    }

    /**
     * 统计指定用户某时间段发布任务条数
     * @param  <int>  $user_id 用户编号
     * @param  <date> $from    日期下限
     * @param  <date> $to      日期上限
     * @return <int> 条数
     */
    public function count_task_by_user($user_id, $from = null, $to = null){
        $this->da->setModelName('information');
        $where['is_del']     = 0;
        $where['status']     = array('gt', 0);
        $where['user_id']    = $user_id;
        if(!empty($from) && !empty($to))
            $where['start_time'] = array('between', "'$from','$to'");
        elseif(!empty($from))
            $where['start_time'] = array('gt', $from);
        elseif(!empty($to))
            $where['start_time'] = array('lt', $to);
        return $this->da->where($where)->count('info_id');
    }

    /**
     * 统计指定用户某时间段竞标条数
     * @param  <int>  $user_id 用户编号
     * @param  <date> $from    日期下限
     * @param  <date> $to      日期上限
     * @return <int> 条数
     */
    public function count_reply_by_user($user_id, $from = null, $to = null){
        $this->da->setModelName('information_reply');
        $where['user_id'] = $user_id;
        $where['status']  = 1;
        $where['is_del']  = 0;
        if(!empty($from) && !empty($to))
            $where['date'] = array('between', "'$from','$to'");
        elseif(!empty($from))
            $where['date'] = array('gt', $from);
        elseif(!empty($to))
            $where['date'] = array('lt', $to);
        return $this->da->where($where)->count('user_id');
    }

    /**
     * 增加任务的投标数
     * @param <type> $id
     * @param <type> $count
     * @return <type>
     */
    public function increase_bid_count($id, $count = 1){
        $this->da->setModelName('information');            //使用任务表
        return $this->da->setInc('comment_count', array('info_id' => $id), $count);
    }

    /**
     * 增加任务的浏览数
     * @param <type> $id
     * @param <type> $count
     * @return <type>
     */
    public function increase_read_count($id, $count = 1){
        $this->da->setModelName('information');            //使用任务表
        return $this->da->setInc('read_count', array('info_id' => $id), $count);
    }

    /**
     * 设置中标
     * @param <int> $reply_id
     * @return <bool>
     */
    public function set_reply_bid($reply_id){
        $this->da->setModelName('information_reply');      //使用任务回复表
        $where['id']      = $reply_id;
        $where['is_del']  = 0;
        $data['is_bid']   = 1;
        $data['bid_date'] = date_f();
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 设置任务状态
     * @param <int> $id
     * @param <int> $status
     * @return <bool>
     */
    public function set_task_status($id, $status){
        $this->da->setModelName('information');             //使用任务表
        $where['info_id'] = $id;
        $where['is_del']  = 0;
        $data['status']   = $status;
        if($status == 2)
            $data['end_time'] = $date;
        return $this->da->where($where)->save($data) != false;
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
        $task_table = C('DB_PREFIX').'information';
        $scan_tabel = C('DB_PREFIX').'information_scan';
        $table      = "$task_table i,$scan_tabel s";
        $where      = "s.user_id=$user_id AND s.info_id=i.info_id";
        if(!empty($class_b))
            $where .= " AND i.class_b=$class_b";
        elseif(!empty($class_a))
            $where .= " AND i.class_a=$class_a";
        if(!empty($status))
            $where .= " AND i.status=$status";
        if($count){
            $sql = "SELECT COUNT(i.info_id)
                    FROM $table
                    WHERE $where";
            $result = $this->da->query($sql);
            return $result[0]['COUNT(i.info_id)'];
        }
        else{
            if(empty($order))
                $order = 's.date DESC';
            if($page < 1)
                $page = 1;
            $limit = (($page - 1) * $size).", $size";
            $sql = "SELECT i.info_id,i.info_title,s.date
                    FROM $table
                    WHERE $where
                    ORDER BY $order
                    LIMIT $limit";
            return $this->da->query($sql);
        }
    }

    /**
     *任务推广设置
     * @param $info_id 任务号
     * @param $service_type 推广方式
     */
    public function set_task_service($info_id,$service_type){
        $this->da->setModelName('information');             //使用任务表
        $time = time();
        $where['info_id'] = $info_id;
        $where['is_del']  = 0;
        $data['sort']     = $time - 1000000000;
        $data['service']  = $service_type;
        if($service_type == C('TASK_SERVICE_RECOMMEND'))
            $data['sort'] = $time-1000000000+86400;
        //if($service_type == C('TASK_SERVICE_TOP'))
            //$data['sort'] = $time;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     *二级分类任务置顶设置信息
     *@param $task_id <int> 任务id
     * @param $calss_b <int> 二级分类
     * @day 置顶时间
     */
    public function set_information_top($task_id,$class_b,$day){
        $this->da->setModelName('information_top');             //使用任务表
        if(empty($day)){
            return ;
        }else{
            $end_time = time()+$day*24*3600;
            $data['task_id'] = $task_id;
            $data['class_b'] = $class_b;
            $data['start_time'] = time();
            $data['end_time'] = $end_time;
            //return $this->da->save($data) != false;
            return $this->da->add($data) != false;
        }

    }

    /**
     * 判断在此时，某个二级分类下是否有置顶的任务号
     * @param $class_b <int> 二级分类id
     */
    public function get_information_top($class_b){
        $this->da->setModelName('information_top');             //使用任务表
        $time =  time();
        $where['class_b'] = $class_b;
        $where['end_time'] = array('egt', $time);
        return $this->da->where($where)->count('id');
    }

    /**
     *
     * @param <type> $user_id 用户id
     * @param <type> $service_type 推广类别
     * @return <type>
     */
    public function get_task_service_user_count($user_id,$service_type,$status = null){
        $this->da->setModelName('information');
        $where['user_id']  = $user_id;
        $where['service']  = $service_type;
        $where['is_del']  = 0;
        if(!empty($status)){
            $where['status']  = $status;
        }
        return $this->da->where($where)->count('info_id');
    }

    /**
     *
     * @param <type> $user_id 当前用户id
     * @return <type>  返回当前用户正在置顶的任务个数
     */
    public function get_user_top_count($user_id){
        $task_table = C('DB_PREFIX').'information';
        $service_tabel = C('DB_PREFIX').'information_top';
        $time = time();
        $sql="SELECT count(t.info_id) as num FROM $task_table AS t
                LEFT JOIN  $service_tabel as tt ON t.info_id=tt.task_id
                WHERE t.user_id = $user_id AND t.is_del = 0 and t.service = 3 and tt.end_time >= $time
        ";
        return $this->da->query($sql);
    }

    /**
     * 获取指定二级分类下当前时间段的置顶信息
     * @param <int> $class_b 二级分类编号
     * @return <array> 置顶信息
     */
    public  function get_top_info($class_b){
        $this->da->setModelName('information_top');             //使用任务置顶表
        $where['class_b']  = $class_b;
        $where['end_time'] = array('egt', time());
        return $this->da->where($where)->find();
    }

    /**
     * 获取分类信息
     * @param <type> $class
     * @return <type> 
     */
    public function get_class_info($class){
        $this->da->setModelName('task_class');             //使用任务表
        $where['class_id'] = $class;
        return $this->da->where($where)->field('class_title')->find();
    }

    /**
     * 获取角色有权限的一级任务分类
     * @param  <int> $role_id 角色编号
     * @param  <int> $op      操作类型（1为发布，2为竞标）
     * @return <mixed>
     */
    public function get_role_types($role_id, $op){
        $this->da->setModelName('permission_role_task_class t1');               //使用角色任务权限表
        $join[] = C('DB_PREFIX').'task_class t2 ON t2.class_id=t1.class_id_a';
        $where['t1.role_id'] = $role_id;
        $where['t1.type'] = $op;
        $where['t2.is_del'] = 0;
        $field = 't2.class_id,t2.class_title';
        return $this->da->join($join)->where($where)->group('t1.class_id_a')->field($field)->select();
    }

    /**
     * 获取角色有权限的指定二级任务分类
     * @param  <int> $role_id 角色编号
     * @param  <int> $op      操作类型（1为发布，2为竞标）
     * @return <mixed>
     */
    public function get_role_subtypes($class_a, $role_id, $op){
        $this->da->setModelName('permission_role_task_class t1');               //使用角色任务权限表
        $join[] = C('DB_PREFIX').'task_class t2 ON t2.class_id=t1.class_id_b';
        $where['t1.role_id'] = $role_id;
        $where['t1.type'] = $op;
        $where['t1.class_id_a'] = $class_a;
        $where['t2.is_del'] = 0;
        $field = 't2.class_id,t2.class_title';
        return $this->da->join($join)->where($where)->field($field)->select();
    }
}
?>
