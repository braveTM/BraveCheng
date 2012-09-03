<?php
/**
 * Module:013
 */
class DelegateAction extends BaseAction{
    /**
     * 委托流程页11110
     */
    public function index(){
        $this->assign('tclass', home_index_index_page::task_class());       //任务分类列表
        $this->assign('page', home_delegate_index_page::get_page_info());   //页面数据
        $this->assign('dele_status', AccessControl::is_logined() ? 0 : 1);  //委托状态（为1则弹出登录框）
        $this->assign('contact', home_user_index_page::get_contact());      //用户联系方式
        //视图
        $this->display();
    }
    /**
     * 后台委托管理页01110
     */
    public function delemanage(){
//        $this->assign('tnav', home_common_admin_page::left_navigate());     //导航
        $this->assign('hasr', AccountInfo::get_role_id() == C('ROLE_AGENT') ? 1 : 0);
        //$this->assign('tclass', home_index_index_page::task_class());       //任务分类列表
        //后台管理-左侧导航列表
        //$this->assign('tnav', home_common_admin_page::left_navigate());
        //后台管理-待选标【委托提醒列表】
        $this->assign('ccount', home_delegate_admin_page::get_ipost_count(1, 1));
        //后台管理-待选标【委托提醒列表】
        $this->assign('drcandidate', home_delegate_admin_page::get_ipost(1, 1, C('SIZE_DELEGATE_REMIIND'), 1));
        //视图
        $this->display();
    }
    /**
     * 委托管理详细页01110
     */
    public function detail(){
        $detail = home_delegate_publish_page::get_detail($_GET['id']);
        if(empty($detail))
            redirect (C('ERROR_PAGE'));
        $this->assign('detail', $detail);                                   //页面详细数据
        $this->assign('contact', home_user_index_page::get_contact());      //联系方式
        $this->display();
    }

    /**
     * 委托成功页面01110
     */
    public function delesuc(){
        $this->display();
    }

    /**
     * 回复委托00010
     */
    public function do_delegate_reply(){
        $service = new DelegateService();
        $result  = $service->delegate_reply(AccountInfo::get_user_id(), $_POST['id'], $_POST['contact'], $_POST['email'], $_POST['qq'], $_POST['content'], $_POST['status']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 发布委托00100
     */
    public function do_publish(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $service = new DelegateService();
        $result  = $service->apply(AccountInfo::get_user_id(), P('name'), 0, $_POST['title'], $_POST['content'], $_POST['contact'], $_POST['email'], $_POST['qq'], $_POST['ac'], $_POST['bc'], AccountInfo::get_package());
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 获取能够委托的委托列表00100
     */
    public function get_cd_list(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $data = home_delegate_admin_page::get_ipost(null, 1, 30, 1);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 代理人检测11110
     */
    public function do_acheck(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $service = new ProfileService();
        $user_id = $service->get_id_by_nick($_POST['nick']);
        if(!empty($user_id)){
            $svc = new UserService();
            $role = $svc->get_role_by_id($user_id);
            if($role == C('ROLE_AGENT')){
                echo jsonp_encode(true, $user_id);
                return;
            }
        }
        echo jsonp_encode(false);
    }

    /**
     * 获取我发布的委托01110
     */
    public function get_ipostd(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        //此方法专指已委托出去的，不包括待处理
        if($_POST['status'] == 1)
            $_POST['status'] = null;
        $data = home_delegate_admin_page::get_ipost(null, $_POST['page'], C('SIZE_DELEGATE_ADMIN'), $_POST['status']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_delegate_admin_page::get_ipost_count($_POST['type'], $_POST['status']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 获取未处理的委托列表01110
     */
    public function get_wcl_list(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $data = home_delegate_admin_page::get_ipost(null, $_POST['page'], C('SIZE_DELEGATE_ADMIN'), 1);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_delegate_admin_page::get_ipost_count(null, 1);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 获取我收到的委托00010
     */
    public function get_ireceive(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $data = home_delegate_admin_page::get_ireceive($_POST['page'], C('SIZE_DELEGATE_ADMIN'), $_POST['status']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_delegate_admin_page::get_ireceive_count($_POST['status']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 删除指定代理01110
     */
    public function delete_delegate(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $service = new DelegateService();
        $result  = $service->delete(AccountInfo::get_user_id(), $_POST['id']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 代理委托01110
     */
    public function do_delegate(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $service = new DelegateService();
        $result  = $service->delegate(AccountInfo::get_user_id(), $_POST['uid'], $_POST['did']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }
}
?>