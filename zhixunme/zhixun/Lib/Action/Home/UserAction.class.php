<?php
header('content-type:text/html;charset=utf-8');
/**
 * Module:002
 */
class UserAction extends BaseAction{
    //----------------页面---------------
    /**
     * 后台用户资料修改页01111
     */
    public function profiles(){
        switch (AccountInfo::get_role_id()) {
            case C('ROLE_TALENTS')       : $this->tprofile(); break;
            case C('ROLE_ENTERPRISE')    : $this->eprofile(); break;
            case C('ROLE_AGENT')         : $this->aprofile(); break;
            case C('ROLE_SUBCONTRACTOR') : $this->sprofile(); break;
            default : redirect(C('ERROR_PAGE'));
        }
    }
    
    /**
     * 用户退出01111 
     */
    public function logout(){
        $service = new UserService();
        $service->logout(AccountInfo::get_user_id());
        redirect(C('WEB_ROOT'));
    }

    /**
     * 个人主页01111
     */
    public function home(){
        if(AccountInfo::get_role_id() == C('ROLE_SUBCONTRACTOR')){
            redirect(C('WEB_ROOT').'/broker');
        }
        else{
            redirect(C('WEB_ROOT').'/'.AccountInfo::get_user_id().'/index');
        }
//        switch (AccountInfo::get_role_id()) {
//            case C('ROLE_TALENTS')       : redirect(C('WEB_ROOT').'/'.AccountInfo::get_user_id().'/index'); break;
//            case C('ROLE_ENTERPRISE')    : redirect(C('WEB_ROOT').'/'.AccountInfo::get_user_id().'/index'); break;
//            case C('ROLE_AGENT')         : redirect(C('WEB_ROOT').'/'.AccountInfo::get_user_id().'/index'); break;
//            case C('ROLE_SUBCONTRACTOR') : redirect(C('WEB_ROOT').'/broker'); break;
//            default : redirect(C('ERROR_PAGE'));
//        }
    }

    /**
     * 人才后台资料修改页面
     */
    protected function tprofile(){
        $user = home_human_account_page::get_profile();
        $user->soph = home_human_account_page::calculations_sophistication($user);
        //$this->assign('left', home_human_account_page::get_left());
        $this->assign('profile', $user);           //用户资料信息
        $this->assign('auth', home_user_profiles_page::get_auth());                 //用户认证信息
        $this->assign('z_left', 'Public:zl_tnav');                 //左侧
        $this->display('User:tprofile');
    }

    /**
     * 企业后台资料修改页面
     */
    protected function eprofile(){
        $user = home_company_account_page::get_profile();
        $user->soph = home_company_account_page::calculations_sophistication($user);
        //$this->assign('left', home_company_account_page::get_left());
        $this->assign('profile', $user);         //用户资料信息
        $this->assign('auth', home_user_profiles_page::get_auth());                 //用户认证信息
        $this->assign('z_left', 'Public:zl_enav');                 //左侧
        $this->display('User:eprofile');
    }

    /**
     * 经纪人后台资料修改页面
     */
    protected function aprofile(){
        $user = home_agent_account_page::get_profile();
        $user->soph = home_agent_account_page::calculations_sophistication($user);
        //$this->assign('left', home_agent_account_page::get_left());
        $this->assign('service', home_common_front_page::get_labels(0, AccountInfo::get_role_id()));//角色标签
        $this->assign('profile', $user);           //用户资料信息
        $this->assign('auth', home_user_profiles_page::get_auth());                 //用户认证信息
        $this->assign('z_left', 'Public:zl_anav');                 //左侧
        $this->display('User:aprofile');
    }

//    /**
//     * 分包商后台资料修改页面
//     */
//    protected function sprofile(){
//        $this->assign('profile', home_user_profiles_page::get_profile());           //用户资料信息
//        $this->assign('auth', home_user_profiles_page::get_auth());                 //用户认证信息
//        $this->display('User:sprofile');
//    }

    /**
     * 邮箱认证审核页面01111
     */
    public function everify(){
        $service = new AuthService();
        $result = $service->auth_email_verify(AccountInfo::get_user_id(), $_GET['code']);
        if(is_zerror($result)){
            redirect(C('ERROR_PAGE'));
        }
        else{
            $this->display();
        }
    }

    /**
     * 用户详细页11111
     */
    public function user(){
        redirect(C('WEB_ROOT').'/'.$_GET['id']);
//        $service = new UserService();
//        $user = $service->get_user($_GET['id']);
//        if(empty($user)){
//            redirect(C('ERROR_PAGE'));
//        }
//        if($user['role_id'] == C('ROLE_TALENTS')){
//            $service = new HumanService();
//            redirect(C('WEB_ROOT').'/dhuman/'.$_GET['id']);
//        }
//        else if($user['role_id'] == C('ROLE_ENTERPRISE')){
//            redirect(C('WEB_ROOT').'/company/'.$_GET['id']);
//        }
//        else if($user['role_id'] == C('ROLE_AGENT')){
//            redirect(C('WEB_ROOT').'/agent/'.$_GET['id']);
//        }
//        else if($user['role_id'] == C('ROLE_SUBCONTRACTOR')){
//            
//        }
    }
    
    /**
     * 注册后的引导流程01110 
     */
    public function rhome(){
        redirect(C('WEB_ROOT').'/'.AccountInfo::get_user_id().'/index');
        switch (AccountInfo::get_role_id()){
            case C('ROLE_TALENTS') : 
                $user_id = AccountInfo::get_user_id();
                $this->assign('jobs', home_recommend_page::get_recommend_job_rand($user_id, 6));
                $this->assign('moving', home_contacts_index_page::get_follow_moving(0, 1, 5, $user_id));
                $this->assign('page', home_human_page::get_page_count($user_id, AccountInfo::get_resume_id()));
                $this->assign('agents', home_recommend_page::get_recommend_agent_rand($user_id, 8));
                $this->assign('arts', home_article_index_page::get_web_moving());
                $this->assign('current', home_package_index_page::get_current_package($user_id));
                $tpl = 'Human:rhome'; 
                break;
            case C('ROLE_ENTERPRISE') : 
                $user_id = AccountInfo::get_user_id();
                $this->assign('resumes', home_recommend_page::get_recommend_resume_rand($user_id, 6));
                $this->assign('moving', home_contacts_index_page::get_follow_moving(0, 1, 5, $user_id));
                $this->assign('page', home_company_page::get_page_count($user_id));
                $this->assign('humans', home_recommend_page::get_recommend_human_rand($user_id, 8));
                $this->assign('agents', home_recommend_page::get_recommend_agent_rand($user_id, 8));
                $this->assign('current', home_package_index_page::get_current_package($user_id));
                $tpl = 'Company:rhome'; 
                break;
            case C('ROLE_AGENT') : 
                $user_id = AccountInfo::get_user_id();
                $this->assign('resumes', home_recommend_page::get_recommend_resume_rand($user_id, 4));
                $this->assign('jobs', home_recommend_page::get_recommend_job_rand($user_id, 4));
                $this->assign('moving', home_contacts_index_page::get_follow_moving(0, 1, 5, $user_id));
                $this->assign('page', home_agent_page::get_page_count($user_id));
                $this->assign('humans', home_recommend_page::get_recommend_human_rand($user_id, 8));
                $this->assign('arts', home_article_index_page::get_web_moving());
                $this->assign('current', home_package_index_page::get_current_package($user_id));
                $tpl = 'MiddleMan:rhome'; 
                break;
            default : redirect(C('WEB_ROOT').'/error');
        }
        $this->display($tpl);
    }

    //----------------动作---------------
    /**
     * 验证昵称合法性(不重复则合法)11111
     */
    public function do_ncheck(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new ProfileService();
        echo jsonp_encode(!$service->exists_user_name($_POST['nick'], AccountInfo::get_user_id()));
    }

    /**
     * 修改密码01111
     */
    public function do_change(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        $result = $service->change_password(AccountInfo::get_user_id(), $_POST['op'], $_POST['np']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 添加用户标签01111
     */
    public function do_add_label(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new LabelService();
        $result = $service->add_labels(AccountInfo::get_user_id(), AccountInfo::get_role_id(), $_POST['label']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            $data = $service->get_label($_POST['label']);
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 删除用户标签01111
     */
    public function do_delete_label(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new LabelService();
        $result = $service->delete_user_label(AccountInfo::get_user_id(), $_POST['label']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 个人认证申请01010
     */
    public function do_person_apply(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new AuthService();
        if(AccountInfo::get_role_id() == C('ROLE_AGENT'))
            $result  = $service->auth_real_person_apply(AccountInfo::get_user_id(), $_POST['name'], $_POST['num'], $_POST['front'], $_POST['back'], '');
        else
            $result  = $service->auth_real_person_apply(AccountInfo::get_user_id(), $_POST['name'], $_POST['num'], '', '', '', false);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 企业认证申请00101
     */
    public function do_enterprise_apply(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new AuthService();
        $result  = $service->auth_real_enterprise_apply(AccountInfo::get_user_id(), $_POST['name'], $_POST['num'], $_POST['code'], $_POST['pic'], AccountInfo::get_data_id());
//        $result = $service->auth_real_apply(AccountInfo::get_user_id(), P('name'), $_POST['name'], $_POST['num'], $_POST['atta']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 手机认证申请01111
     */
    public function do_phone_apply(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new AuthService();
        $result = $service->auth_phone_apply(AccountInfo::get_user_id(), '', $_POST['phone']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else {
            //手机认证验证码……发送手机短信
            require_cache(APP_PATH.'/Common/Class/SMS.class.php');
            $sms = SMSFactory::get_object($_POST['phone'], '尊敬的职讯网用户，您的验证码为'.$result);
            $sms->send();
            echo jsonp_encode(true);
        }
    }

    /**
     * 邮箱认证申请01111
     */
    public function do_email_apply(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new AuthService();
        $result = $service->auth_email_apply(AccountInfo::get_user_id(), '', $_POST['email']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else {
            //发送邮件认证通知
            //email_send($_POST['email'], C('EMAIL_AUTH_TPL'), AccountInfo::get_user_id(), $result);
            $service = new NotifyService();
            $service->send_email($_POST['email'], C('EMAIL_AUTH_TPL'), AccountInfo::get_user_id(), $result);
            echo jsonp_encode(true);
        }
    }

//    /**
//     * 银行卡认证申请01111
//     */
//    private function do_bank_apply(){
//        if(!$this->is_legal_request())      //是否合法请求
//            return;
//        $service = new AuthService();
//        $result = $service->auth_bank_apply(AccountInfo::get_user_id(), '', $_POST['bid'], $_POST['num']);
//        if(is_zerror($result)){
//            echo jsonp_encode(false, $result->get_message());
//        }
//        else {
//            echo jsonp_encode(true);
//        }
//    }

    /**
     * 手机认证审核01111
     */
    public function do_phone_verify(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new AuthService();
        $result = $service->auth_phone_verify(AccountInfo::get_user_id(), $_POST['code']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }

    /**
     * 获取联系方式01111
     */
    public function get_contact(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        $result  = $service->read_contact(AccountInfo::get_user_id(),$_POST['object_id'],$_POST['object_type'],true, true, AccountInfo::get_group_id());
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 获取简历上的联系方式01111
     */
//    public function get_resume_contact(){
//        if(!$this->is_legal_request())      //是否合法请求
//            return;
//        $service = new UserService();
//        $result  = $service->read_resume_contact(AccountInfo::get_user_id(), $_POST['id'], AccountInfo::get_group_id());
//        if(is_zerror($result)){
//            echo jsonp_encode(false, $result->get_message());
//        }
//        else{
//            echo jsonp_encode(true, $result);
//        }
//    }

    /**
     * 更新用户访问信息01111
     */
    public function do_update_visit(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new UserService();
        $service->update_user_last_visit(AccountInfo::get_user_id());
    }

    //------------protected------------
    /**
     * 完善资料
     * @param <type> $utype
     * @param <type> $gender
     * @param <type> $date
     * @return <type>
     */
    protected function p_do_perfect($utype = null, $gender = null, $date = null){
        $service = new ProfileService();
        //更新用户资料
        $presult = $service->update_profile(AccountInfo::get_user_id(), $_POST['nick'], $_POST['contact'], $_POST['qq'], $this->cut_avatar(), $utype, $gender, $_POST['province'], $_POST['city'], $date, $_POST['summary'], null);
//        $service = new LabelService();
//        //增加用户标签
//        $lresult = $service->add_labels(AccountInfo::get_user_id(), AccountInfo::get_role_id(), explode('_', $_POST['label']));
        if(is_zerror($presult)){                                        //保存资料失败
            return jsonp_encode(false, $presult->get_message());
        }
//        else if(is_zerror($lresult)){                                   //添加用户标签失败
//            return jsonp_encode(true, $lresult->get_message());
//        }
        else{                                                           //操作成功
            return jsonp_encode(true, C('WEB_ROOT').C('MEMBER_PAGE'));
        }
    }

    /**
     * 修改资料
     * @param <type> $utype
     * @param <type> $date
     * @param <type> $gender
     * @return <type>
     */
    protected function p_do_update($date = null, $gender = null){
        $service = new ProfileService();
        return $service->update_profile(AccountInfo::get_user_id(), $_POST['nick'], $_POST['contact'], $_POST['qq'], $this->cut_avatar(), null, $gender, $_POST['province'], $_POST['city'], $date, $_POST['summary'], $_POST['exp']);
    }

    /**
     * 头像剪裁
     * @return <string>
     */
    protected function cut_avatar(){
        if(!empty($_POST['photo']) && strpos($_POST['photo'], C('FILE_ROOT')) !== false && strpos($_POST['photo'], 'normal') !== false){
            $image = str_replace(C('FILE_ROOT'), '', $_POST['photo']);
            if($image != C('PATH_DEFAULT_AVATAR')){
                require_cache(APP_PATH.'/Common/Function/image.php');
                //头像剪裁
                $bpath = str_replace('normal', 'big', $image);
                $mpath = str_replace('normal', 'middle', $image);
                $b = image_cut_avatar($image, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], 160, 160, 220, 200, $bpath);  //大头像
                $m = image_cut_avatar($image, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], 100, 100, 220, 200, $mpath);    //中头像
                if($b && $m)
                    $avatar = $bpath;
            }
        }
        return $avatar;
    }
    
    /**
     * 人才引导头像上传01000
     */
    public function do_guide_photo(){
        $userService = new UserService();
        $result = $userService->update_photo(AccountInfo::get_user_id(), $this->cut_avatar()); 
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true);
        }
    }
    
    /**
     * 用户赞一下01110
     */
    public function do_praise(){
        if (!$this->is_legal_request()){
            return;
        }
        $user_id = $_POST['id'];
        $cache_key = 'praise_user_'.get_client_ip().'_'.$user_id;
        if(!DataCache::get($cache_key)){
            $service = new UserService();
            $result = $service->do_user_praise(AccountInfo::get_user_id(), $user_id, date_f(), get_client_ip());
            if(is_zerror($result)){
                echo jsonp_encode(false);
            }
            else{
                DataCache::set($cache_key, '1', 600);
                echo jsonp_encode(true);
            }
        }else{
            echo jsonp_encode(false);
        }
    }
    
    /**
     * 关闭弹窗推荐01110
     */
    public function do_close_popup(){
        AccessControl::close_popup();
    }
}
?>
