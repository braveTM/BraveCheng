 <?php
/**
 * 任务大厅-数据提供
 * @author YoyiorLee
 */
class home_task_hall_page {
    /**
     * 获取任务列表
     * @param  <int> $class_a 一级分类
     * @param  <int> $class_b 二级分类
     * @param  <int> $status  状态
     * @param  <int> $date    时间选项
     * @param  <int> $page    第几页
     * @param  <string> $like 关键字
     * @return <mixed> 任务列表
     */
    public static function get_tasks($class_a = null, $class_b = null, $status = null, $date = 0, $page = 1, $like = null){
        $service = new TaskService();
        $data = $service->get_task_list($class_a, $class_b, $status, null, null, $page, 10, null, false, $like);
        return FactoryVMap::list_to_models($data, 'home_task_normal');
//        $service = new TaskService();
//        switch ($date){
//            case 1  : $from = date_f('Y-m-d H:i:s', time() - 86400);      break;
//            case 2  : $from = date_f('Y-m-d H:i:s', time() - 3 * 86400);  break;
//            case 3  : $from = date_f('Y-m-d H:i:s', time() - 5 * 86400);  break;
//            case 4  : $from = date_f('Y-m-d H:i:s', time() - 7 * 86400);  break;
//            case 5  : $from = date_f('Y-m-d H:i:s', time() - 30 * 86400); break;
//            default : break;
//        }
//        $data    = $service->get_task_list($class_a, $class_b, $status, $from, null, $page, C('SIZE_HALL_TASK'), null, false, $like);
//        if(!empty($class_b) && $page == 1){                 //二级分类列表第一页显示，则查询出置顶数据
//            $top = $service->get_top_info($class_b);        //获取置顶信息
//            if(!empty($top)){
//                $task = $service->get_task($top['task_id']);//获取任务信息
//                if(!empty($task)){                          //将置顶任务插入任务列表的头部
//                    $array[0] = $task;
//                    foreach ($data as $value) {
//                        if($value['service'] == 3)          //取消原列表中的置顶任务信息
//                            continue;
//                        $array[] = $value;
//                    }
//                    $data = $array;
//                }
//            }
//        }
//        else{
//            foreach ($data as $key => $value) {
//                if($value['service'] == 3){          //取消原列表中的置顶状态
//                    $data[$key]['service'] = 0;
//                }
//            }
//        }
//        $data    = FactoryVMap::list_to_models($data, 'home_task_normal');
//        return $data;
    }

    /**
     * 获取指定条件任务列表总条数
     * @param <type> $class_a
     * @param <type> $class_b
     * @param <type> $status
     * @param <type> $date
     * @return <int> 总条数
     */
    public static function get_tasks_count($class_a = null, $class_b = null, $status = null, $date = 0, $like = null){
        $service = new TaskService();
        return $service->get_task_list($class_a, $class_b, $status, null, null, $page, 10, null, true, $like);
//        $service = new TaskService();
//        //获取我竞标过的的所有任务
//        switch ($date){
//            case 1  : $from = date_f('Y-m-d H:i:s', time() - 86400);      break;
//            case 2  : $from = date_f('Y-m-d H:i:s', time() - 3 * 86400);  break;
//            case 3  : $from = date_f('Y-m-d H:i:s', time() - 5 * 86400);  break;
//            case 4  : $from = date_f('Y-m-d H:i:s', time() - 7 * 86400);  break;
//            case 5  : $from = date_f('Y-m-d H:i:s', time() - 30 * 86400); break;
//            default : break;
//        }
//        $data    = $service->get_task_list($class_a, $class_b, $status, $from, null, null, null, null, true, $like);
//        return $data;
    }

    /**
     * 任务详细信息
     * @param <int> $task_id 任务编号
     * @return <mixed>
     */
    public static function get_detail($task_id){
        $service = new TaskService();
        $data    = $service->get_task($task_id);
        if(empty($data))
            return null;
        $prof            = new ProfileService();
        $data['_user']   = $prof -> get_profile_by_user_id($data['user_id']);
        $data['_credit'] = $prof -> get_credit_level($data['_user']['credibility']);
        $data            = FactoryVMap::array_to_model($data, 'home_task_detail');
        return $data;
    }

    /**
     * 获取任务回复列表
     * @param  <int>    $task_id   任务编号
     * @param  <int>    $type      角色类型(1企业2经纪人)
     * @param  <int>    $page      第几页
     * @param  <int>    $size      每页几条
     * @param  <string> $role_code 角色代码
     * @param  <string> $auth_code 认证代码
     * @return <mixed>
     */
    public static function get_replys($task_id, $type, $page, $size, $role_code = '0000', $auth_code = '000'){
        $service = new TaskService();
        //获取竞标列表
        if($type == C('ROLE_ENTERPRISE'))
            $role_code = '0100';
        elseif($type == C('ROLE_AGENT'))
            $role_code = '0010';
        $data    = $service->get_reply_list($task_id, $role_code, $auth_code, $page, $size);
        return FactoryVMap::list_to_models($data, 'home_task_reply');
    }

    /**
     * 获取任务回复列表数量
     * @param  <int>    $task_id   任务编号
     * @param  <int>    $type      角色类型(1企业2经纪人)
     * @param  <string> $role_code 角色代码
     * @param  <string> $auth_code 认证代码
     * @return <mixed>
     */
    public static function get_replys_count($task_id, $type, $role_code = '0000', $auth_code = '000'){
        $service = new TaskService();
        if($type == C('ROLE_ENTERPRISE'))
            $role_code = '0100';
        elseif($type == C('ROLE_AGENT'))
            $role_code = '0010';
        return $service->get_reply_list($task_id, $role_code, $auth_code, 1, 1, true);
    }

    /**
     * 获取任务分类
     */
    public static function get_class($level = 2, $children = false){
        $service  = new TaskService();
        if($level == 1){
            $data = $service->get_types(0);
            if($children){
                foreach($data as $key => $value){
                    $child = $service->get_types($value['class_id']);
                    $data[$key]['children'] = FactoryVMap::list_to_models($child, 'home_index_tclass');
                }
            }
        }
        else
            $data = $service->get_subtypes();
        $data     = FactoryVMap::list_to_models($data, 'home_index_tclass');
        return $data;
    }

    /**
     * 获取任务列表关键字信息
     * @param <type> $ac
     * @param <type> $bc
     * @param <type> $key
     * @return <type> 
     */
    public static function get_keyword($ac, $bc, $key){
        $array['aclass'] = intval($ac);
        $array['bclass'] = intval($bc);
        $array['key']    = htmlspecialchars($key);
        return FactoryVMap::array_to_model($array, 'home_task_condition');
    }

    /**
     * 获取任务详细页控制变量信息
     */
    public static function get_detail_vars($task_id, $status, $user_id, $class){
        $service = new TaskService();
        $is_bider = $service->check_user_reply_task($task_id, AccountInfo::get_user_id());
        if($user_id == AccountInfo::get_user_id() || $is_bider){
            $array['show_contact'] = 1;
        }
        else{
            $array['show_contact'] = 0;
        }
        if($status == 1 && $user_id != AccountInfo::get_user_id()){
            $array['show_bid'] = 1;
            if(!AccessControl::is_logined()){
                $array['bid_status'] = 1;       //用户未登录
            }
            else if(!AccessControl::check_class($class, 2)){
                $array['bid_status'] = 2;       //用户竞标此任务权限不足
            }
            else{
                $array['bid_status'] = 3;       //可以竞标
            }
        }
        else{
            $array['show_bid'] = 0;
        }
        if($status == 2){
            $array['status'] = 1;
        }
        elseif($status == 3){
            $array['status'] = 2;
        }
        else{
            $array['status'] = 0;
        }
        return FactoryVMap::array_to_model($array, 'home_task_vars');
    }

    /**
     * 获取任务详细页控制变量信息
     */
    public static function get_publish_vars(){
        if(AccessControl::is_logined()){
            $array['show_tip'] = 1;
            $uservice = new UserService();
            $package  = $uservice->get_package(AccountInfo::get_package());
            if($package['day_task_post'] == -1){
                $array['surplus'] = '无限';
            }
            else{
                $service = new TaskService();
                $count   = $service->get_task_list(null, null, null, date_f('Y-m-d'), null, 1, 1, null, true, null, AccountInfo::get_user_id());
                $array['surplus'] = $package['day_task_post'] - $count;
                if($array['surplus'] < 0)
                    $array['surplus'] = 0;
            }
            $array['price'] = $package['post_price'];
        }
        else{
            $array['show_tip'] = 0;
        }
        return FactoryVMap::array_to_model($array, 'home_task_pvars');
    }

    /**
     * 获取任务发布的状态
     * @param <int>    $surplus 免费发布条数
     * @param <double> $price   发布价格
     * @return <int> 状态值
     */
    public static function get_pub_status($surplus, $price){
        if(AccessControl::is_logined()){
            if($surplus === 0){
                $service = new BillService();
                $bill = $service->get_bill_info(AccountInfo::get_user_id());
                if($bill['cash'] < $price){
                    return 2;
                }
            }
            return 0;
        }
        else{
            return 1;
        }
    }

    /**
     * 获取推广任务信息
     * @param $info_id 任务id
     */

    public static function get_service_vars($info_id = null){
        $task = new TaskService();
        $taskInfo = $task->get_task($info_id);            //获取任务信息
        if(empty ($taskInfo))
            return E(ErrorMessage::$TASK_NOT_EXISTS);               //任务不存在;
        $classCount = $task->get_information_top($taskInfo['info_class_b']);  //return 1,此二级分类下有置顶，0.此二级分类下没有置顶

        $array['id']  = $info_id;
        $array['top'] = $classCount;
        $service = new TaskService();
        if($classCount != 0){
            $end_time = $service->get_top_info($taskInfo['info_class_b']);
            $next_top = date("m月d日 H小时i分",$end_time['end_time']);
            $array['top_next_time'] = $next_top ;
        }
        $class_info = $service->get_class_info($taskInfo['info_class_b']);
        $array['class_title'] = $class_info['class_title'];
        $array['service_list'] = self::get_service_list();
        return FactoryVMap::array_to_model($array, 'task_service');
    }
    /**
     *
     * @return <type>
     */
    public static function get_service_list(){
        $service = new ServiceService();
        $service_list =  $service->get_service_list();
        return FactoryVMap::list_to_models($service_list, 'task_service_list');
    }

    /**
     *
     * @param <type> $task_id 任务id
     * @param <type> $user_id 用户id
     * @return <type>
     */

    public static function get_task_service_user_info($user_id){
        $service = new TaskService();
        $task_service_count = $service->get_task_service_user_vars($user_id);
        return FactoryVMap::list_to_models($task_service_count, 'task_service_count');
    }

    /**
     * 获取用户可发布的任务分类列表
     */
    public static function get_user_pub_class(){
        $service = new PermissionService();
        $pub_a   = $service->get_role_task_class_a(AccountInfo::get_role_id(), 1);
        foreach($pub_a as $key => $item){
            $id = $item['class_id'];
            $pub_b[$id] = $service->get_role_task_class_b(AccountInfo::get_role_id(), $id, 1);
            if(empty($pub_b[$id])){
                unset ($pub_b[$id]);
                unset ($pub_a[$key]);
            }
        }
        $array[] = FactoryVMap::list_to_models($pub_a, 'home_index_tclass');
        $array[] = FactoryVMap::list_to_models($pub_b, 'home_index_tclass');
        return $array;
    }
}
?>
