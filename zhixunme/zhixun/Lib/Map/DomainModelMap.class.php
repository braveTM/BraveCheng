<?php
/**
 * Description of DomainModelMap
 *
 * @author moi
 */
class DomainModelMap {
    
    public static function  __callStatic($name, $arguments) {
        return null;
    }
    
    /***************************Array to Model*********************************/
    /**
     * 将数组角色模型转化为账户模型(AccountDomainModel)
     * @param  <array> $array 数组
     * @return <AccountDomainModel> 账户模型
     */
    public static function array_to_account_model($array){
        $model = new AccountDomainModel();
        if(array_key_exists('user_id', $array)){
            $model->__set('user_id', intval($array['user_id']));
        }
        if(array_key_exists('name', $array)){
            $model->__set('user_name', $array['name']);
        }
        if(array_key_exists('password', $array)){
            $model->__set('password', $array['password']);
        }
        if(array_key_exists('email', $array)){
            $model->__set('email', $array['email']);
        }
        if(array_key_exists('phone', $array)){
            $model->__set('phone', $array['phone']);
        }
        if(array_key_exists('role_id', $array)){
            $model->__set('role_id', intval($array['role_id']));
        }
        if(array_key_exists('data_id', $array)){
            $model->__set('data_id', intval($array['data_id']));
        }
        if(array_key_exists('is_freeze', $array)){
            $model->__set('freeze', intval($array['is_freeze']));
        }
        if(array_key_exists('is_activate', $array)){
            $model->__set('activate', intval($array['is_activate']));
        }
        if(array_key_exists('email_activate', $array)){
            $model->__set('eactivate', intval($array['email_activate']));
        }
        if(array_key_exists('expired', $array)){
            $model->__set('expired', $array['expired']);
        }
        if(array_key_exists('package', $array)){
            $model->__set('package', $array['package']);
        }
        if(array_key_exists('group_id', $array)){
            $model->__set('group_id', $array['group_id']);
        }
        return $model;
    }

    /**
     * 将数组(array)转化为角色模型(RoleDomainModel)
     * @param  <array> $array 数组
     * @return <RoleDomainModel> 角色模型
     */
    public static function array_to_role_model($array){
        $model = new RoleDomainModel();
        if(array_key_exists('role_id', $array)){
            $model->__set('role_id', intval($array['role_id']));
        }
        if(array_key_exists('role_name', $array)){
            $model->__set('role_name', $array['role_name']);
        }
        if(array_key_exists('user_type', $array)){
            $model->__set('user_type', intval($array['user_type']));
        }
        if(array_key_exists('register', $array)){
            $model->__set('register', doubleval($array['register']));
        }
        return $model;
    }

    /**
     * 将数组(array)转化为任务模型(TaskDomainModel)
     * @param  <array> $array 数组
     * @return <TaskDomainModel> 任务模型
     */
    public static function array_to_task_model($array){
        $model = new TaskDomainModel();
        $domain = new TaskDomain();
        if(array_key_exists('info_id', $array)){
            $model->__set('id', intval($array['info_id']));
        }
        if(array_key_exists('user_id', $array)){
            $model->__set('user_id', intval($array['user_id']));
        }
        if(array_key_exists('user_name', $array)){
            $model->__set('user_name', $array['user_name']);
        }
        if(array_key_exists('info_title', $array)){
            $model->__set('title', $array['info_title']);
        }
        if(array_key_exists('info_content', $array)){
            $model->__set('content', $array['info_content']);
        }

        if(array_key_exists('info_class_a', $array)){
            $model->__set('class_a', $array['info_class_a']);
            $type = $domain->get_type($array['info_class_a']);
            if($type){
                $model->__set('class_a_name', $type->__get("name"));
            }
        }

        if(array_key_exists('info_class_b', $array)){
            $model->__set('class_b', $array['info_class_b']);
            $type = $domain->get_type($array['info_class_b']);
            if($type){
                $model->__set('class_b_name', $type->__get("name"));
            }
        }

        if(array_key_exists('task_type', $array)){
            $model->__set('type', $array['task_type']);
            $type = $domain->get_type($array['task_type']);
            if($type){
                $model->__set('type_name', $type->__get("name"));
            }
        }

        if(array_key_exists('phone', $array)){
            $model->__set('phone', intval($array['phone']));
        }
        if(array_key_exists('email', $array)){
            $model->__set('email', intval($array['email']));
        }
        if(array_key_exists('qq', $array)){
            $model->__set('qq', intval($array['qq']));
        }
        if(array_key_exists('min_price', $array)){
            $model->__set('min_price', intval($array['min_price']));
        }
        if(array_key_exists('start_time', $array)){
            $model->__set('start_time', $array['start_time']);
        }
        if(array_key_exists('end_time', $array)){
            $model->__set('end_time', $array['end_time']);
        }
        if(array_key_exists('read_count', $array)){
            $model->__set('read_count', intval($array['read_count']));
        }
        if(array_key_exists('comment_count', $array)){
            $model->__set('comment_count', intval($array['comment_count']));
        }
        if(array_key_exists('status', $array)){
            $model->__set('status', intval($array['status']));
        }
        if(array_key_exists('sort', $array)){
            $model->__set('sort', intval($array['sort']));
        }
        if(array_key_exists('is_del', $array)){
            $model->__set('is_del', intval($array['is_del']));
        }
        return $model;
    }

    /**
     * 将数组(array)转化为类型模型(TypeDomainModel)
     * @param  <array> $array 数组
     * @return <TypeDomainModel> 类型模型
     */
    public static function array_to_type_model($array){
        $model = new TypeDomainModel();
        $temp = "";
        //编号
        if(array_key_exists('id', $array)){
            $temp = intval($array['id']);
        }else if(array_key_exists('class_id', $array)){
            $temp = intval($array['class_id']);
        }
        $model->__set('id',$temp);

        //名称
        if(array_key_exists('title', $array)){
            $temp = intval($array['title']);
        }else if(array_key_exists('class_title', $array)){
            $temp = $array['class_title'];
        }else if(array_key_exists('name', $array)){
            $temp = $array['name'];
        }
        $model->__set('name',$temp);

        //父编号
        if(array_key_exists('description', $array)){
            $temp = $array['description'];
        }
        $model->__set('description',$temp);

        //图标
        if(array_key_exists('logo', $array)){
            $temp = $array['logo'];
        }else if(array_key_exists('icon', $array)){
            $temp = $array['icon'];
        }
        $model->__set('icon',$temp);

        //价格
        if(array_key_exists('role_id', $array)){
            $temp = intval($array['role_id']);
        }
        $model->__set('role_id',$temp);

        //一级分类编号
        if(array_key_exists('class_id_a', $array)){
            $temp = intval($array['class_id_a']);
        }
        $model->__set('class_id_a',$temp);

        //二级分类编号
        if(array_key_exists('class_id_b', $array)){
            $temp = intval($array['class_id_b']);
        }
        $model->__set('class_id_b',$temp);
        
        //价格
        if(array_key_exists('price', $array)){
            $temp = intval($array['price']);
        }
        $model->__set('price',$temp);
        
        //父编号
        if(array_key_exists('parent_id', $array)){
            $temp = intval($array['parent_id']);
        }
        $model->__set('parent_id',$temp);

        //分类代号
        if(array_key_exists('class_code', $array)){
            $temp = intval($array['class_code']);
        }
        $model->__set('code',$temp);

        //排序
        if(array_key_exists('sort', $array)){
            $temp = intval($array['sort']);
        }
        $model->__set('sort',$temp);
        
        //是否删除
        if(array_key_exists('is_del', $array)){
            $temp = intval($array['is_del']);
        }
        $model->__set('is_del',$temp);
        return $model;
    }
    
    /**
     * 将数组(array)转化为任务模型(ReplyDomainModel)
     * @param  <array> $array 数组
     * @return <ReplyDomainModel> 任务模型
     */
    public static function array_to_reply_model($array){
        $model = new ReplyDomainModel();
        //编号
        if(array_key_exists('id', $array)){
            $model->__set('id',intval($array['id']));
        }

        //任务编号
        if(array_key_exists('info_id', $array)){
            $model->__set('task_id',intval($array['info_id']));
        }

        //用户编号
        if(array_key_exists('user_id', $array)){
            $model->__set('user_id',intval($array['user_id']));
        }

        //用户名
        if(array_key_exists('user_name', $array)){
            $model->__set('user_name',$array['user_name']);
        }

        //内容
        if(array_key_exists('content', $array)){
            $model->__set('content',$array['content']);
        }

        //日期
        if(array_key_exists('date', $array)){
            $model->__set('date',$array['date']);
        }

        //状态
        if(array_key_exists('status', $array)){
            $model->__set('status',intval($array['status']));
        }

        //是否中标
        if(array_key_exists('is_bid', $array)){
            $model->__set('is_bid',intval($array['is_bid']));
        }
        
        //是否删除
        if(array_key_exists('is_del', $array)){
            $model->__set('is_del',intval($array['is_del']));
        }
        return $model;
    }

    /**
     * 将数组(array)转化为任务模型(ScanDomainModel)
     * @param  <array> $array 数组
     * @return <ScanDomainModel> 任务模型
     */
    public static function array_to_scan_model($array){
        $model = new ScanDomainModel();
        //编号
        if(array_key_exists('id', $array)){
            $model->__set('id',intval($array['id']));
        }

        //任务编号
        if(array_key_exists('info_id', $array)){
            $model->__set('task_id',intval($array['info_id']));
        }

        //用户编号
        if(array_key_exists('user_id', $array)){
            $model->__set('user_id',intval($array['user_id']));
        }

        //用户名
        if(array_key_exists('user_name', $array)){
            $model->__set('user_name',$array['user_name']);
        }

        //内容
        if(array_key_exists('info_title', $array)){
            $model->__set('title',$array['info_title']);
        }

        //日期
        if(array_key_exists('date', $array)){
            $model->__set('date',$array['date']);
        }

        //是否删除
        if(array_key_exists('is_del', $array)){
            $model->__set('is_del',intval($array['is_del']));
        }
        return $model;
    }

    /**
     * 将数组(array)转化为站内信模型(MessageDomainModel)
     * @param  <array> $array 数组
     * @return <MessageDomainModel> 站内信模型
     */
    public static function array_to_message_model($array){
        $model = new MessageDomainModel();
        //编号
        if(array_key_exists('id', $array)){
            $model->__set('id',intval($array['id']));
        }

        //发信人编号
        if(array_key_exists('from_id', $array)){
            $model->__set('from_id',intval($array['from_id']));
        }

        //发信人名称
        if(array_key_exists('from_name', $array)){
            $model->__set('from_name',$array['from_name']);
        }

        //是否对发信人可见
        if(array_key_exists('from_show', $array)){
            $model->__set('from_show',intval($array['from_show']));
        }

        //收信人编号
        if(array_key_exists('to_id', $array)){
            $model->__set('to_id',intval($array['to_id']));
        }

        //收信人名称
        if(array_key_exists('to_name', $array)){
            $model->__set('to_name',$array['to_name']);
        }

        //是否对收信人可见
        if(array_key_exists('to_show', $array)){
            $model->__set('to_show',intval($array['to_show']));
        }

        //收信人是否已查看
        if(array_key_exists('to_read', $array)){
            $model->__set('to_read',intval($array['to_read']));
        }

        //标题
        if(array_key_exists('title', $array)){
            $model->__set('title',$array['title']);
        }

        //内容
        if(array_key_exists('content', $array)){
            $model->__set('content',$array['content']);
        }

        //回复信件编号
        if(array_key_exists('reply_id', $array)){
            $model->__set('reply_id',intval($array['reply_id']));
        }

        //信件类别
        if(array_key_exists('type', $array)){
            $model->__set('type',intval($array['type']));
        }

        //日期
        if(array_key_exists('date', $array)){
            $model->__set('date',$array['date']);
        }

        //是否删除
        if(array_key_exists('is_del', $array)){
            $model->__set('is_del',intval($array['is_del']));
        }
        return $model;
    }

    /**
     * 将数组(array)转化为任务模型(DelegateDomainModel)
     * @param  <array> $array 数组
     * @return <DelegateDomainModel> 任务模型
     */
    public static function array_to_delegate_model($array){
        $model = new DelegateDomainModel();
        //编号
        if(array_key_exists('id', $array)){
            $model->__set('id',intval($array['id']));
        }

        //用户编号
        if(array_key_exists('user_id', $array)){
            $model->__set('user_id',intval($array['user_id']));
        }

        //用户名
        if(array_key_exists('user_name', $array)){
            $model->__set('user_name',$array['user_name']);
        }

        //委托人编号
        if(array_key_exists('delegate_id', $array)){
            $model->__set('delegate_id',intval($array['delegate_id']));
        }

        //标题
        if(array_key_exists('title', $array)){
            $model->__set('title',$array['title']);
        }

        //内容
        if(array_key_exists('content', $array)){
            $model->__set('content',$array['content']);
        }

        //日期
        if(array_key_exists('date', $array)){
            $model->__set('date',$array['date']);
        }

        //委托分类a
        if(array_key_exists('class_a', $array)){
            $model->__set('class_a', $array['class_a']);
            $type = $domain->get_type($array['class_a']);
            if($type){
                $model->__set('class_a_name', $type->__get("name"));
            }
        }

        //委托分类b
        if(array_key_exists('class_b', $array)){
            $model->__set('class_b', $array['class_b']);
            $type = $domain->get_type($array['class_b']);
            if($type){
                $model->__set('class_b_name', $type->__get("name"));
            }
        }

        //状态
        if(array_key_exists('status', $array)){
            $model->__set('status',intval($array['status']));
        }

        //是否删除
        if(array_key_exists('is_del', $array)){
            $model->__set('is_del',intval($array['is_del']));
        }
        return $model;
    }

    /**
     * 将数组(array)转化为任务模型(SuggestionDomainModel)
     * @param  <array> $array 数组
     * @return <SuggestionDomainModel> 任务模型
     */
    public static function array_to_suggestion_model($array){
        $model = new SuggestionDomainModel();
        //编号
        if(array_key_exists('id', $array)){
            $model->__set('id',intval($array['id']));
        }

        //用户编号
        if(array_key_exists('user_id', $array)){
            $model->__set('user_id',intval($array['user_id']));
        }

        //用户名
        if(array_key_exists('user_name', $array)){
            $model->__set('user_name',$array['user_name']);
        }

        //对方用户名
        if(array_key_exists('other_name', $array)){
            $model->__set('other_name',$array['other_name']);
        }

        //内容
        if(array_key_exists('content', $array)){
            $model->__set('content',$array['content']);
        }

        //日期
        if(array_key_exists('date', $array)){
            $model->__set('date',$array['date']);
        }

        //类型
        if(array_key_exists('type', $array)){
            $model->__set('type', $array['type']);
            $type = $domain->get_type($array['type']);
            if($type){
                $model->__set('type_name', $type->__get("name"));
            }
        }

        //状态
        if(array_key_exists('date', $array)){
            $model->__set('date',intval($array['date']));
        }

        //是否删除
        if(array_key_exists('is_del', $array)){
            $model->__set('is_del',intval($array['is_del']));
        }
        return $model;
    }

    /***************************Model to Array*********************************/
    /**
     * 将任务模型(TaskDomainModel)转化为数组
     * @param <TaskDomainModel> $model 
     * @return <array> 任务数组
     */
    public static function task_model_to_array(TaskDomainModel $model){
        if($model->__get('id')){
            $array['id']            = $model->__get('id');
        }
        if($model->__get('user_id')){
            $array['user_id']       = $model->__get('user_id');
        }
        if($model->__get('user_name')){
            $array['user_name']     = $model->__get('user_name');
        }
        if($model->__get('title')){
            $array['info_title']    = $model->__get('title');
        }
        if($model->__get('content')){
            $array['info_content']  = $model->__get('content');
        }
        if($model->__get('class_a')){
            $array['info_class_a']  = $model->__get('class_a');
        }
        if($model->__get('class_b')){
            $array['info_class_b']  = $model->__get('class_b');
        }
        if($model->__get('type')){
            $array['task_type']     = $model->__get('type');
        }
        if($model->__get('phone')){
            $array['phone']     = $model->__get('phone');
        }
        if($model->__get('email')){
            $array['email']     = $model->__get('email');
        }
        if($model->__get('qq')){
            $array['qq']     = $model->__get('qq');
        }
        if($model->__get('min_price')){
            $array['min_price']     = $model->__get('min_price');
        }
        if($model->__get('max_price')){
            $array['max_price']     = $model->__get('max_price');
        }
        if($model->__get('start_time')){
            $array['start_time']    = $model->__get('start_time');
        }
        if($model->__get('end_time')){
            $array['end_time']      = $model->__get('end_time');
        }
        if($model->__get('read_count')){
            $array['read_count']    = $model->__get('read_count');
        }
        if($model->__get('comment_count')){
            $array['comment_count'] = $model->__get('comment_count');
        }
        if($model->__get('status')){
            $array['status']        = $model->__get('status');
        }
        if($model->__get('sort')){
            $array['sort']          = $model->__get('sort');
        }
        if($model->__get('is_del')){
            $array['is_del']        = $model->__get('is_del');
        }
        return $array;
    }

    /**
     * 将回复模型(ReplyDomainModel)转化为数组
     * @param <ReplyDomainModel> $model
     * @return <array> 任务数组
     */
    public function reply_model_to_array(ReplyDomainModel $model){
        if($model->__get('id')){
            $array['id']            = $model->__get('id');
        }
        if($model->__get('task_id')){
            $array['info_id']            = $model->__get('task_id');
        }
        if($model->__get('user_id')){
            $array['user_id']            = $model->__get('user_id');
        }
        if($model->__get('user_name')){
            $array['user_name']            = $model->__get('user_name');
        }
        if($model->__get('content')){
            $array['content']            = $model->__get('content');
        }
        if($model->__get('date')){
            $array['date']              = $model->__get('date');
        }
        if($model->__get('status')){
            $array['status']            = $model->__get('status');
        }
        if($model->__get('is_bid')){
            $array['is_bid']            = $model->__get('is_bid');
        }
        if($model->__get('is_del')){
            $array['is_del']            = $model->__get('is_del');
        }
        return $array;
    }

    /**
     * 将回复模型(ScanDomainModel)转化为数组
     * @param <ScanDomainModel> $model
     * @return <array> 任务数组
     */
    public function scan_model_to_array(ScanDomainModel $model){
        if($model->__get('id')){
            $array['id']            = $model->__get('id');
        }
        if($model->__get('task_id')){
            $array['info_id']            = $model->__get('task_id');
        }
        if($model->__get('user_id')){
            $array['user_id']            = $model->__get('user_id');
        }
        if($model->__get('user_name')){
            $array['user_name']            = $model->__get('user_name');
        }
        if($model->__get('title')){
            $array['info_title']            = $model->__get('title');
        }
        if($model->__get('date')){
            $array['date']              = $model->__get('date');
        }
        if($model->__get('is_del')){
            $array['is_del']            = $model->__get('is_del');
        }
        return $array;
    }

    /**
     * 将回复模型(MessageDomainModel)转化为数组
     * @param <MessageDomainModel> $model
     * @return <array> 任务数组
     */
    public function message_model_to_array(MessageDomainModel $model){
        if($model->__get('id')){
            $array['id']            = $model->__get('id');
        }
        if($model->__get('from_id')){
            $array['from_id']            = $model->__get('from_id');
        }
        if($model->__get('from_name')){
            $array['from_name']            = $model->__get('from_name');
        }
        if($model->__get('from_show')){
            $array['from_show']            = $model->__get('from_show');
        }
        if($model->__get('to_id')){
            $array['to_id']            = $model->__get('to_id');
        }
        if($model->__get('to_name')){
            $array['to_name']            = $model->__get('to_name');
        }
        if($model->__get('to_show')){
            $array['to_show']            = $model->__get('to_show');
        }
        if($model->__get('to_read')){
            $array['to_read']            = $model->__get('to_read');
        }
        if($model->__get('title')){
            $array['info_title']            = $model->__get('title');
        }
        if($model->__get('content')){
            $array['content']            = $model->__get('content');
        }
        if($model->__get('reply_id')){
            $array['reply_id']            = $model->__get('reply_id');
        }
        if($model->__get('type')){
            $array['type']            = $model->__get('type');
        }
        if($model->__get('date')){
            $array['date']              = $model->__get('date');
        }
        if($model->__get('is_del')){
            $array['is_del']            = $model->__get('is_del');
        }
        return $array;
    }

    /**
     * 将回复模型(DelegateDomainModel)转化为数组
     * @param <DelegateDomainModel> $model
     * @return <array> 任务数组
     */
    public function delegate_model_to_array(DelegateDomainModel $model){
        if($model->__get('id')){
            $array['id']            = $model->__get('id');
        }
        if($model->__get('user_id')){
            $array['user_id']            = $model->__get('user_id');
        }
        if($model->__get('user_name')){
            $array['user_name']            = $model->__get('user_name');
        }
        if($model->__get('delegate_id')){
            $array['delegate_id']            = $model->__get('delegate_id');
        }
        if($model->__get('title')){
            $array['title']             = $model->__get('title');
        }
        if($model->__get('content')){
            $array['content']            = $model->__get('content');
        }
        if($model->__get('class_a')){
            $array['class_a']            = $model->__get('class_a');
        }
        if($model->__get('class_b')){
            $array['class_b']            = $model->__get('class_b');
        }
        if($model->__get('date')){
            $array['date']              = $model->__get('date');
        }
        if($model->__get('status')){
            $array['status']            = $model->__get('status');
        }
        if($model->__get('is_del')){
            $array['is_del']            = $model->__get('is_del');
        }
        return $array;
    }
    /**
     * 将回复模型(SuggestionDomainModel)转化为数组
     * @param <SuggestionDomainModel> $model
     * @return <array> 任务数组
     */
    public function suggestion_model_to_array(SuggestionDomainModel $model){
        if($model->__get('id')){
            $array['id']            = $model->__get('id');
        }
        if($model->__get('user_id')){
            $array['user_id']            = $model->__get('user_id');
        }
        if($model->__get('user_name')){
            $array['user_name']            = $model->__get('user_name');
        }
        if($model->__get('other_name')){
            $array['other_name']            = $model->__get('other_name');
        }
        if($model->__get('content')){
            $array['content']            = $model->__get('content');
        }
        if($model->__get('type')){
            $array['type']            = $model->__get('type');
        }
        if($model->__get('date')){
            $array['date']              = $model->__get('date');
        }
        if($model->__get('is_del')){
            $array['is_del']            = $model->__get('is_del');
        }
        return $array;
    }

    /**
     * 将资料模型转化为数组
     * @param ProfileDomainModel $model 
     */
    public function profile_model_to_array(ProfileDomainModel $model){
        if($model->__get('user_id') !== null ){
            $array['user_id']      = $model->__get('user_id');
        }
        if($model->__get('user_name') !== null ){
            $array['user_name']    = $model->__get('user_name');
        }
        if($model->__get('photo') !== null ){
            $array['photo']        = $model->__get('photo');
        }
        if($model->__get('introduction') !== null ){
            $array['introduction'] = $model->__get('introduction');
        }
        if($model->__get('experience') !== null ){
            $array['experience']   = $model->__get('experience');
        }
        if($model->__get('date') !== null ){
            $array['date']            = $model->__get('date');
        }
        if($model->__get('gender') !== null ){
            $array['gender']       = $model->__get('gender');
        }
        if($model->__get('user_type') !== null ){
            $array['user_type']    = $model->__get('user_type');
        }
        if($model->__get('contact') !== null ){
            $array['contact']      = $model->__get('contact');
        }
        if($model->__get('qq') !== null ){
            $array['qq']           = $model->__get('qq');
        }
        if($model->__get('province') !== null ){
            $array['province_id']  = $model->__get('province');
        }
        if($model->__get('city') !== null ){
            $array['city_id']      = $model->__get('city');
        }
        return $array;
    }
}
?>
