<?php
/**
 * 后台任务管理首页数据提供
 * @author YoyiorLee
 */
class home_task_admin_page { 
    /**
     * 待选标任务提醒
     * @return <mixed>
     */
    public static function get_candidate_remind(){
        $service = new TaskService();
        //获取待竞标的任务
        $result['count'] = $service->get_tasks_by_user_id(AccountInfo::get_user_id(), 1, 1, 1, null, true);
        $data    = $service->get_tasks_by_user_id(AccountInfo::get_user_id(), 1, 1, C('SIZE_TASK_REMIND'));
        $result['list']  = FactoryVMap::list_to_models($data, 'home_task_normal');
        return $result;
    }

    /**
     * 我竞标的任务提醒
     * @return <mixed>
     */
    public static function get_ibid_remind(){
        $service  = new TaskService();
        //获取我竞标过但任务还没有完成的任务
        $result['count'] = $service->get_tasks_by_replyed(AccountInfo::get_user_id(), 1, null, null, 1, 1, null, true);
        $data     = $service->get_tasks_by_replyed(AccountInfo::get_user_id(), 1, null, null, 1, C('SIZE_TASK_REMIND'));
        $result['list']  = FactoryVMap::list_to_models($data, 'home_task_normal');
        return $result;
    }

    /**
     * 我发布的任务
     * @return <mixed>
     */
    public static function get_ipost($status = 0, $page = 1, $order = null){
        $service = new TaskService();
        //获取我发布的任务
        if($order == 'd')                           //排序方式
            $order = 'comment_count DESC';
        elseif($order == 'a')
            $order = 'comment_count';
        else
            $order = null;
        $user_id = AccountInfo::get_user_id();
        $data    = $service->get_tasks_by_user_id($user_id, $status, $page, C('SIZE_TASK_ADMIN'), $order);
        $date = date_f();
        $service = new PromoteService();
        foreach($data as $key => $value){
            $count = $service->count_task_promote_record($user_id, $value['info_id'], null, null, $date);
            if($count > 0)
                $data[$key]['_promote'] = 1;
            else
                $data[$key]['_promote'] = 0;
        }
        $data    = FactoryVMap::list_to_models($data, 'home_task_normal');
        return $data;
    }

    /**
     * 我发布的任务条数
     * @return <mixed>
     */
    public static function get_ipost_count($status = 0){
        $service = new TaskService();
        //获取我发布的任务
        $data    = $service->get_tasks_by_user_id(AccountInfo::get_user_id(), $status, 1, 1, null, true);
        return $data;
    }

    /**
     * 我竞标的任务
     * @return <mixed>
     */
    public static function get_ibid($status = 0, $page = 1, $order = null){
        $service = new TaskService();
        //获取我竞标过的的所有任务
        if($order == 'd')                           //排序方式
            $order = 'i.comment_count DESC';
        elseif($order == 'a')
            $order = 'i.comment_count';
        else
            $order = null;
        if($status == 4){
            $data = $service->get_tasks_by_bided(AccountInfo::get_user_id(), $page, C('SIZE_TASK_ADMIN'), $order);
        }
        else{
            $data = $service->get_tasks_by_replyed(AccountInfo::get_user_id(), $status, null, null, $page, C('SIZE_TASK_ADMIN'), $order);
        }
        $data    = FactoryVMap::list_to_models($data, 'home_task_normal');
        return $data;
    }

    /**
     * 我竞标的任务数量
     * @return <mixed>
     */
    public static function get_ibid_count($status = 0){
        $service = new TaskService();
        //获取我竞标过的的所有任务
        if($status == 4){
            $data = $service->get_tasks_by_bided(AccountInfo::get_user_id(), 1, 1, null, true);
        }
        else{
            $data = $service->get_tasks_by_replyed(AccountInfo::get_user_id(), $status, null, null, 1, 1, null, true);
        }
        return $data;
    }

    /**
     * 获取有权限发布的任务分类
     * @return <mixed>
     */
    public static function get_pub_tclass(){
        $role_id = AccountInfo::get_role_id();
        $service = new TaskService();
        $data = $service->get_role_types($role_id, 1);
        foreach ($data as $key => $value) {
            //获取二级分类作为指定一级分类的CHILDREN
            $data[$key]['children'] = FactoryVMap::list_to_models($service->get_role_subtypes($value['class_id'], $role_id, 1), 'home_index_tclass');
        }
        $data = FactoryVMap::list_to_models($data, 'home_index_tclass');
        return $data;
    }
}
?>
