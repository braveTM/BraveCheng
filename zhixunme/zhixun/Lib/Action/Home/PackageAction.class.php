<?php
header('content-type:text/html;charset=utf-8');
/**
 * Module:015
 */
class PackageAction extends BaseAction{
    /**
     * 套餐管理页面01111
     */
    public function index(){
        $user_id = AccountInfo::get_user_id();
        $current = home_package_index_page::get_current_package($user_id);
        if(empty($current)){
            $pid = 0;
            $has = 0;
        }
        else{
            $pid = $current->pid;
            $has = 1;
            $this->assign('current', $current);
            $this->assign('newc', home_package_index_page::get_package_info($current->pid));
        }
        $this->assign('free', home_package_index_page::get_free_package(AccountInfo::get_group_id()));
        $this->assign('has', $has);
        $this->assign('list', home_package_index_page::get_package_list($user_id, AccountInfo::get_group_id(), $pid));
        if(AccountInfo::get_role_id() == C('ROLE_AGENT')){
            $info = home_agent_account_page::get_statistics();
            $this->assign('score', $info->score);
            $tpl = 'Package:aindex';
        }
        else{
            $tpl = 'Package:index';
        }
        $this->display($tpl);
    }

    /**
     * 购买套餐01111
     */
    public function do_buy_package(){
        if(!$this->is_legal_request())           //非POST请求
            return;
        $service = new PackageService();
        $result  = $service->buy_package(AccountInfo::get_user_id(), AccountInfo::get_group_id(), $_POST['id']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 套餐续费01111
     */
    public function do_renewals_package(){
        if(!$this->is_legal_request())           //非POST请求
            return;
        $service = new PackageService();
        $result  = $service->renewals_package(AccountInfo::get_user_id());
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }
    
    /**
     * 单项续费01111 
     */
    public function do_renewals_single(){
        if(!$this->is_legal_request())           //非POST请求
            return;
        $service = new PackageService();
        $result = $service->renewals_single(AccountInfo::get_user_id(), $_POST['id'], $_POST['va']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }
    
    /**
     * 获取续费结果01111 
     */
    public function get_renewals_result(){
        if(!$this->is_legal_request())           //非POST请求
            return;
        $service = new PackageService();
        $result = $service->get_renewals_result($_POST['id'], $_POST['va']);
        echo jsonp_encode(true, $result);
    }
    
    /**
     * 获取套餐续费提示01111 
     */
    public function get_renewals_tips(){
        if(!$this->is_legal_request())           //非POST请求
            return;
        $service = new PackageService();
        $result = $service->get_renewals_tips(AccountInfo::get_user_id(), $_POST['id']);
        echo jsonp_encode(true, $result);
    }
    
    /**
     * 获取通话分钟数面值信息01111 
     */
    public function get_min_face_value(){
        if(!$this->is_legal_request())           //非POST请求
            return;
        $service = new PackageService();
        $result = $service->get_call_min_list();
        if(empty($result)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 积分兑换套餐00010 
     */
    public function do_exp_exchange_package(){
        if(!$this->is_legal_request())           //非POST请求
            return;
        $service = new PackageService();
        $result = $service->exp_exchange_package(AccountInfo::get_user_id(), AccountInfo::get_role_id(), 9,$_POST['id']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 积分续费套餐00010 
     */
    public function do_exp_renewals_package(){
        if(!$this->is_legal_request())           //非POST请求
            return;
        $service = new PackageService();
        $result = $service->exp_renewals_package(AccountInfo::get_user_id());
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }
}
?>
