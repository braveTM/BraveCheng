<?php
/**
 * Module:016
 */
class PromoteAction extends BaseAction {
    /**
     * 推广页面01110
     */
    public function index() {
        $user_id=AccountInfo::get_user_id();
        $this->assign('tnav', home_common_admin_page::left_navigate());     //导航
        $this->assign('tclass', home_index_index_page::task_class());       //任务分类列表
        $this->assign('promote_record_list',home_promote_admin_page::get_promote_record_list($user_id, null));      //获取推广位记录列表
        $this->assign('promote',  home_task_hall_page::get_task_service_user_info(AccountInfo::get_user_id()));
        $this->assign('promote_method',home_task_hall_page::get_service_list());
        $this->display();
    }

    /**
     * 获取推广位列表01110
     */
    public function get_promote_list() {
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $page=$_POST['page'];
        $data = home_promote_admin_page::get_promote_list($page, C('SIZE_PROMOTE_ADMIN'), null);
        if(empty ($data)) {
            echo jsonp_encode(false);
        }
        else {
            $count = home_promote_admin_page::get_promote_total_count();
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 占用推广位01110
     */
    public function do_hold_promote() {
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $service = new PromoteService();
        $result  = $service->hold_promote($_POST['id'], $_POST['days'], AccountInfo::get_user_id(), AccountInfo::get_role_id());
        if(is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        }else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 账户推广01110
     */
    public function do_promote_account(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $role_id = AccountInfo::get_role_id();
        $service = new PromoteService();
        if($role_id == C('ROLE_ENTERPRISE')){
            $result = $service->buy_promote_company(AccountInfo::get_user_id(), $_POST['id'], $_POST['days']);
        }
        else if($role_id == C('ROLE_AGENT')){
            $result = $service->buy_promote_agent(AccountInfo::get_user_id(), $_POST['id'], $_POST['days']);
        }
        else{
            $result = E();
        }
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 信息推广01110
     */
    public function do_promote_info(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $type = $_POST['type'];//1职位2简历3任务
        $service = new PromoteService();
        if($type == PROMOTE_TYPE_JOB){
            $result = $service->buy_promote_job(AccountInfo::get_user_id(), $_POST['id'], $_POST['service'], $_POST['days']);
        }
        else if($type == PROMOTE_TYPE_RESUME){
            $result = $service->buy_promote_resume(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $_POST['id'], $_POST['service'], $_POST['days']);
        }
        else if($type == PROMOTE_TYPE_TASK){
            $result = $service->buy_promote_task(AccountInfo::get_user_id(), $_POST['id'], $_POST['service'], $_POST['days']);
        }
        else{
            $result = E();
        }
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 获取职位推广信息00110
     */
    public function get_job_promote(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_promote_admin_page::get_promote_job($_POST['id']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }
    
    /**
     * 获取简历推广信息01010
     */
    public function get_resume_promote(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_promote_admin_page::get_promote_resume($_POST['id']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }
    
    /**
     * 获取任务推广信息00110
     */
    public function get_task_promote(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_promote_admin_page::get_promote_task($_POST['id']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }
}
?>
