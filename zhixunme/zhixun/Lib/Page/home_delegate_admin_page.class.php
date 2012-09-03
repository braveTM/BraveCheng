<?php
/**
 * 委托数据提供
 * @author YoyiorLee
 */
class home_delegate_admin_page { 
    /**
     * 待选标【委托提醒】
     * @return <mixed>
     */
    public static function get_candidate_remind($page = 1, $order = null){
        $service  = new TaskService();
        //获取待竞标的委托的
        $data = $service->get_task_list(2, null, null, null, null, $page, C('SIZE_DELEGATE_ADMIN'), $order, false, null, AccountInfo::get_user_id());
        $data    = FactoryVMap::list_to_models($data, 'home_task_normal');
        return $data;
    }

    /**
     * 我指定的【委托提醒】（除职讯外）
     * @return <mixed>
     */
    public static function get_ispecified_remind(){
        $service  = new DelegateService();
        //获取带竞标的任务
        $data    = $service->get_apply_delegates(AccountInfo::get_user_id(), 0, C('SIZE_DELEGATE_REMIIND'), null,'0',true);
        $data    = FactoryVMap::list_to_models($data, 'home_delegate_normal');
        return $data;
    }

    /**
     * 我指定职讯的【委托提醒】
     * @return <mixed>
     */
    public static function get_ispecifiedzx_remind(){
        $service  = new DelegateService();
        //获取带竞标的任务
        $data    = $service->get_apply_delegates(AccountInfo::get_user_id(), 0, C('SIZE_DELEGATE_REMIIND'), null,'0',false);
        $data    = FactoryVMap::list_to_models($data, 'home_delegate_normal');
        return $data;
    }
    
    /**
     * 我收到的【委托提醒】
     * @return <mixed>
     */
    public static function get_specifiedme_remind(){
        $service  = new DelegateService();
        //获取带竞标的任务
        $data    = $service->get_applied_delegates(AccountInfo::get_user_id(), 0, C('SIZE_DELEGATE_REMIIND'), null);
        $data    = FactoryVMap::list_to_models($data, 'home_delegate_normal');
        return $data;
    }

    /**
     * 我发布的委托
     * @param  <int>    $type   委托类型（参数已废弃）
     * @param  <int>    $page   第几页
     * @param  <int>    $size   每页几条
     * @param  <int>    $status 委托状态
     * @param  <string> $order  排序方式
     * @return <mixed>
     */
    public static function get_ipost($type, $page, $size, $status = null, $order = null){
        $service = new DelegateService();
        //获取我指定的委托
        $data    = $service->get_apply_delegates_by_user_id(AccountInfo::get_user_id(), $page, $size, 2, null, $status);
        $data    = FactoryVMap::list_to_models($data, 'home_delegate_normal');
        return $data;
    }

    /**
     * 我发布的委托
     * @param  <int>    $type   委托类型（参数已废弃）
     * @param  <int>    $status 委托状态
     * @return <mixed>
     */
    public static function get_ipost_count($type = 1, $status = null){
        $service = new DelegateService();
        //获取我指定的委托
        $data    = $service->get_apply_delegates_by_user_id(AccountInfo::get_user_id(), 1, 1, 2, null, $status, null, true);            
        return $data;
    }
    
    /**
     * 我收到的委托
     * @return <mixed>
     */
    public static function get_ireceive($page, $size, $status = null, $order = null){
        $service  = new DelegateService();
        //获取我接受的委托
        $data    = $service->get_apply_delegates_by_user_id(null, $page, $size, null, AccountInfo::get_user_id(), $status, $order);
        foreach ($data as $key => $value) {
            $data[$key]['side'] = 3;
        }
        $data    = FactoryVMap::list_to_models($data, 'home_delegate_normal');
        return $data;
    }

    /**
     * 我收到的委托
     * @return <mixed>
     */
    public static function get_ireceive_count($status = null){
        $service  = new DelegateService();
        //获取我接受的委托
        $data    = $service->get_apply_delegates_by_user_id(null, 1, 1, null, AccountInfo::get_user_id(), $status, null, true);
        return $data;
    }
}
?>
