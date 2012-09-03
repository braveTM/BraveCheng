<?php
/**
 * Description of BaseAction
 *
 * @author moi
 */
require_cache(LIB_PATH.'Access/AccessControl.class.php');
class BaseAction extends Action{
    public function  __construct() {
        parent::__construct();
        filterSubmitAction(MODULE_NAME,ACTION_NAME);//屏蔽短时间大量提交
        stat_from();//统计来源
        AccessControl::authenticate();      //权限认证
        $this->login_status();
        $this->assign_base();
        $this->register_guide();
    }

    /**
     * 设置登录状态
     */
    public function login_status(){
        if(AccessControl::is_logined()){
            $this->assign_left();
            $header = home_common_front_page::get_header(true);
        }
        else{
            $header = home_common_front_page::get_header(false);
        }
        $this->assign('header', $header);
        $this->assign('bheader', home_common_admin_page::back_header());
        $this->assign('bnav', home_common_admin_page::back_navigate());
    }

    /**
     * 基本变量赋值
     */
    public function assign_base(){
        $this->assign('web_root', C('WEB_ROOT'));
        $this->assign('file_root', C('FILE_ROOT'));
        $this->assign('js_root', C('FILE_ROOT').'zhixun/Theme/default');//主题根路径
        
        $this->assign('voc_root', C('FILE_ROOT').'zhixun/Theme/default/vocat');//网站主要组成块根路径
        $this->assign('crm_root', C('FILE_ROOT').'zhixun/Theme/default/crm');
        $this->assign('jqlib', 'lib');
        $this->assign('indexjs', '<script type="text/javascript" src="'.$this->voc_root.'/js/renders/index_r_1.0.js"></script>
        <script type="text/javascript" src="'.$this->voc_root.'/js/controllers/index_c_1.0.js"></script>');
        
        
//        $this->assign('voc_root', C('FILE_ROOT').'zhixun/Theme/default/zminvocat');//网站主要组成块根路径
//        $this->assign('crm_root', C('FILE_ROOT').'zhixun/Theme/default/zmincrm');
//        $this->assign('jqlib', 'zminlib');
//        $this->assign('indexjs', '<script type="text/javascript" src="'.$this->voc_root.'/pages/index_c_1.0.js"></script>');//网站默认标题、关键字、描述
        $this->assign('title', '职讯网_专注于建筑行业求职招聘的职业平台');
        $this->assign("kwds","职讯网,zhixun,建筑,招聘,求职,人才,简历,企业,找工作,职位,猎头,高薪,兼职,全职,建造师,注册工程师,监理工程师,造价工程师,爆破工程师,建筑师,结构师,资讯,新闻,政策法规,职场经验,资源管理,职业,平台");
        $this->assign("desc","职讯网zhixun.me专注于建筑行业的求职招聘，为建筑企业、高级建筑人才、猎头提供求职招聘、资源管理等人力资源服务。让企业和人才的合作更加方便、愉快！");
    }

    /**
     * 是否合法请求
     */
    public function is_legal_request(){
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    //---------------protected------------------
    /**
     * 左侧导航页面赋值
     */
    protected function assign_left(){
        $this->assign('user_id_self', AccountInfo::get_user_id());
        if(AccountInfo::get_role_id() == C('ROLE_TALENTS')){
            $this->assign('nav', 'Public:tnav');
            $user = home_human_account_page::get_profile();
            $user->soph = home_human_account_page::calculations_sophistication($user);
            $this->assign('info', $user);
            //$this->assign('left', home_human_account_page::get_left());
            $this->assign('per', 1);
            $this->assign('z_left', 'Public:zl_tnav');
        }
        else if(AccountInfo::get_role_id() == C('ROLE_ENTERPRISE')){
            $this->assign('nav', 'Public:enav');
            $user = home_company_account_page::get_profile();
            $user->soph = home_company_account_page::calculations_sophistication($user);
            $this->assign('info', $user);
            //$this->assign('left', home_company_account_page::get_left());
            $this->assign('per', AccountInfo::get_activate());
            $this->assign('z_left', 'Public:zl_enav');
        }
        else if(AccountInfo::get_role_id() == C('ROLE_AGENT')){
            $this->assign('nav', 'Public:anav');
            $user = home_agent_account_page::get_profile();
            $user->soph = home_agent_account_page::calculations_sophistication($user);
            $this->assign('info', $user);
            //$this->assign('left', home_agent_account_page::get_left());
            $this->assign('per', AccountInfo::get_activate());
            $this->assign('z_left', 'Public:zl_anav');
        }
    }
    
    /**
     *注册引导流程 
     */
    
    public function register_guide(){
//        $userService = new UserService();
//        $userInfo = $userService->get_user(AccountInfo::get_user_id());
//        if($userInfo['role_id'] == 1 && $userInfo['register_guide'] == 0){
//            $register_guide['is_guide'] = 1;
//            if(var_validation($userInfo['email'],VAR_EMAIL)){
//                $register_guide['email_phone'] = 1;   //需要填写电话号码
//            }elseif(var_validation($userInfo['phone'],VAR_PHONE)){
//                 $register_guide['email_phone'] = 2;  //需要填写邮箱
//            }
//            $this->assign('register_guide', $register_guide);
//        }
    }
}
?>
