<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class home_promote_admin_page {

    /**
     *获取推广位列表
     * @param <type> $page 第几页
     * @param <type> $size 每页条数
     * @param <type> $order 排序
     */
    public static function get_promote_list($page,$size,$order) {
        $service =new PromoteService();
        $data    = $service->get_promote_list($page, $size, $order, AccountInfo::get_role_id());
        $data    = FactoryVMap::list_to_models($data, 'home_promote');
        return $data;
    }

    /**
     *获取推广位占用记录列表
     * @param <type> $user_id 用户编号
     * @param <type> $order 排序方式
     */
    public static function get_promote_record_list($user_id,$order) {
        $service =new PromoteService();
        $data    = $service->get_promote_record_list($user_id, $order);
        $data    = FactoryVMap::list_to_models($data, 'home_promote_record');
        return $data;
    }

    /**
     * 获取推广位数目
     */
    public static function get_promote_total_count() {
        $service =new PromoteService();
        $data    = $service->get_promote_total_count();
        return $data;
    }

    /**
     * 获取职位推广信息
     */
    public static function get_promote_job($id){
        $service = new PromoteService();
        $user_id = AccountInfo::get_user_id();
        $date = date_f();
        $data = $service->get_job_promote_record($user_id, $id, C('PROMOTE_JOB_INDEX'));
        if(!empty($data)){
            $array[0]['status'] = 1;
            $array[0]['date'] = $data['end_time'];
        }
        else{
            $array[0] = $service->get_promote_service(C('PROMOTE_JOB_INDEX'));
            $array[0]['status'] = 0;
            if($array[0]['max_count'] != -1){
                $array[0]['s_count'] = $array[0]['max_count'] - $service->count_job_promote_record(null, null, C('PROMOTE_JOB_INDEX'), null, $date);
            }
        }
        $data = $service->get_job_promote_record($user_id, $id, C('PROMOTE_JOB_NORMAL'));
        if(!empty($data)){
            $array[1]['status'] = 1;
            $array[1]['date'] = $data['end_time'];
        }
        else{
            $array[1] = $service->get_promote_service(C('PROMOTE_JOB_NORMAL'));
            $array[1]['status'] = 0;
            if($array[1]['max_count'] != -1){
                $array[1]['s_count'] = $array[1]['max_count'] - $service->count_job_promote_record(null, null, C('PROMOTE_JOB_NORMAL'), null, $date);
            }
        }
//        $array[0] = $service->get_promote_service(C('PROMOTE_JOB_INDEX'));
//        $array[1] = $service->get_promote_service(C('PROMOTE_JOB_NORMAL'));
//        if($array[0]['max_count'] != -1){
//            $array[0]['s_count'] = $array[0]['max_count'] - $service->count_job_promote_record(null, null, C('PROMOTE_JOB_INDEX'), null, $date);
//        }
//        if($array[1]['max_count'] != -1){
//            $array[1]['s_count'] = $array[1]['max_count'] - $service->count_job_promote_record(null, null, C('PROMOTE_JOB_NORMAL'), null, $date);
//        }
        return FactoryVMap::list_to_models($array, 'home_agent_promote');
    }

    /**
     * 获取简历推广信息
     */
    public static function get_promote_resume($id){
        $service = new PromoteService();
        $user_id = AccountInfo::get_user_id();
        $date = date_f();
        $data = $service->get_resume_promote_record($user_id, $id, C('PROMOTE_RESUME_INDEX'));
        if(!empty($data)){
            $array[0]['status'] = 1;
            $array[0]['date'] = $data['end_time'];
        }
        else{
            $array[0] = $service->get_promote_service(C('PROMOTE_RESUME_INDEX'));
            $array[0]['status'] = 0;
            if($array[0]['max_count'] != -1){
                $array[0]['s_count'] = $array[0]['max_count'] - $service->count_resume_promote_record(null, null, C('PROMOTE_RESUME_INDEX'), null, $date);
            }
        }
        $data = $service->get_resume_promote_record($user_id, $id, C('PROMOTE_RESUME_NORMAL'));
        if(!empty($data)){
            $array[1]['status'] = 1;
            $array[1]['date'] = $data['end_time'];
        }
        else{
            $array[1] = $service->get_promote_service(C('PROMOTE_RESUME_NORMAL'));
            $array[1]['status'] = 0;
            if($array[1]['max_count'] != -1){
                $array[1]['s_count'] = $array[1]['max_count'] - $service->count_resume_promote_record(null, null, C('PROMOTE_RESUME_NORMAL'), null, $date);
            }
        }
        return FactoryVMap::list_to_models($array, 'home_agent_promote');
//        $service = new PromoteService();
//        $array[0] = $service->get_promote_service(C('PROMOTE_RESUME_INDEX'));
//        $array[1] = $service->get_promote_service(C('PROMOTE_RESUME_NORMAL'));
//        $date = date_f();
//        if($array[0]['max_count'] != -1){
//            $array[0]['s_count'] = $array[0]['max_count'] - $service->count_resume_promote_record(null, null, C('PROMOTE_RESUME_INDEX'), null, $date);
//        }
//        if($array[1]['max_count'] != -1){
//            $array[1]['s_count'] = $array[1]['max_count'] - $service->count_resume_promote_record(null, null, C('PROMOTE_RESUME_NORMAL'), null, $date);
//        }
//        return FactoryVMap::list_to_models($array, 'home_agent_promote');
    }

    /**
     * 获取任务推广信息
     */
    public static function get_promote_task($id){
        $service = new PromoteService();
        $user_id = AccountInfo::get_user_id();
        $date = date_f();
        $data = $service->get_task_promote_record($user_id, $id, C('PROMOTE_TASK_INDEX'));
        if(!empty($data)){
            $array[0]['status'] = 1;
            $array[0]['date'] = $data['end_time'];
        }
        else{
            $array[0] = $service->get_promote_service(C('PROMOTE_TASK_INDEX'));
            $array[0]['status'] = 0;
            if($array[0]['max_count'] != -1){
                $array[0]['s_count'] = $array[0]['max_count'] - $service->count_task_promote_record(null, null, C('PROMOTE_TASK_INDEX'), null, $date);
            }
        }
        $data = $service->get_task_promote_record($user_id, $id, C('PROMOTE_TASK_NORMAL'));
        if(!empty($data)){
            $array[1]['status'] = 1;
            $array[1]['date'] = $data['end_time'];
        }
        else{
            $array[1] = $service->get_promote_service(C('PROMOTE_TASK_NORMAL'));
            $array[1]['status'] = 0;
            if($array[1]['max_count'] != -1){
                $array[1]['s_count'] = $array[1]['max_count'] - $service->count_task_promote_record(null, null, C('PROMOTE_TASK_NORMAL'), null, $date);
            }
        }
        return FactoryVMap::list_to_models($array, 'home_agent_promote');
//        $service = new PromoteService();
//        $array[0] = $service->get_promote_service(C('PROMOTE_TASK_INDEX'));
//        $array[1] = $service->get_promote_service(C('PROMOTE_TASK_NORMAL'));
//        $date = date_f();
//        if($array[0]['max_count'] != -1){
//            $array[0]['s_count'] = $array[0]['max_count'] - $service->count_task_promote_record(null, null, C('PROMOTE_TASK_INDEX'), null, $date);
//        }
//        if($array[1]['max_count'] != -1){
//            $array[1]['s_count'] = $array[1]['max_count'] - $service->count_task_promote_record(null, null, C('PROMOTE_TASK_NORMAL'), null, $date);
//        }
//        return FactoryVMap::list_to_models($array, 'home_agent_promote');
    }
}
?>
