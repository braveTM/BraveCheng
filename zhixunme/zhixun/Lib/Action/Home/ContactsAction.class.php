<?php
/**
 * Module:014
 */
class ContactsAction extends BaseAction {
    /**
     * 我的人脉页面01110
     */
    public function index(){
        $role_id = AccountInfo::get_role_id();
        if($role_id == C('ROLE_TALENTS')){
            $this->assign('fe', 1);
            $this->assign('fa', 1);
        }
        else if($role_id == C('ROLE_ENTERPRISE')){
            $this->assign('ft', 1);
            $this->assign('fa', 1);
        }
        else if($role_id == C('ROLE_AGENT')){
            $this->assign('ft', 1);
            $this->assign('fe', 1);
            $this->assign('fa', 1);
        }
        $this->display();
    }

    /**
     * 关注01110
     */
    public function do_follow(){
        $service = new ContactsService();
        $result  = $service->add_user_follow(AccountInfo::get_user_id(), $_POST['id'], AccountInfo::get_role_id());
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 取消关注01110
     */
    public function do_unfollow(){
        $service = new ContactsService();
        $result  = $service->delete_user_follow(AccountInfo::get_user_id(), $_POST['id']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 获取关注列表01110
     */
    public function get_follows(){
        $data = home_contacts_index_page::get_follow_list(AccountInfo::get_user_id(), $_POST['type'], $_POST['page'], $_POST['size']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_contacts_index_page::get_follow_count(AccountInfo::get_user_id(), $_POST['type']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 获取人脉动态列表01110
     */
    public function get_follow_moving(){
        $user_id = AccountInfo::get_user_id();
        $data = home_contacts_index_page::get_follow_moving($_POST['type'], $_POST['page'], $_POST['size'], $user_id);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_contacts_index_page::get_follow_moving_count($_POST['type'], $user_id);
            echo jsonp_encode(true, $data, $count);
        }
    }
}
?>
