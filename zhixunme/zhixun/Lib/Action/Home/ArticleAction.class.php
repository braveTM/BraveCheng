<?php
header('content-type:text/html;charset=utf-8');
/**
 * Module:114
 */
class ArticleAction extends BaseAction{
    /**
     * 文章列表页00001
     */
    public function index(){
        $model = M();
        $model->query('TRUNCATE TABLE  `zx_permission_action`');
        $model->query('TRUNCATE TABLE  `zx_permission_role_action`');
        $model->query('TRUNCATE TABLE  `zx_permission_role_not_active_action`');
        $groups = array('Home', 'Crm');
        foreach ($groups as $group) {
            $list = array();
            $dir = APP_PATH.'/Lib/Action/'.$group.'/';
            $handle = opendir($dir);
            if ( $handle ) {
                while ( false !== ( $item = readdir( $handle ) ) ) {
                    if ( $item != "." && $item != ".." && $item != ".svn" ) {
                        if (! is_dir( "$dir/$item" ) ) {
                            $list[] = substr($item, 0, -10);
                        }
                    }
                }
                closedir( $handle );
            }
            foreach($list as $class){
                require_cache($dir.$class.'.class.php');
                $ref = new ReflectionClass($class);
                $cdoc = $ref->getDocComment();
                $find = strripos($cdoc, 'Module:');
                $str = substr($cdoc, $find + 7, 3);
                $module = intval($str);
                if($module > 33)
                    continue;
                $methods = $ref->getMethods();
                foreach($methods as $method){
                    if($method->class == $class){
                        $object = new $class();
                        $mref = new ReflectionMethod($object, $method->name);
                        if($mref->isPublic()){
                            $doc = strtr($mref->getDocComment(), array('/'=>'','\\'=>'','*'=>'',"\t"=>'',' '=>'',"\r\n"=>'',"\n"=>''));
                            $per = substr($doc, -5);
                            $doc = substr($doc, 0, -5);
                            $mn = substr($class, 0, -6);
                            $code = $group.'/'.$mn.'/'.$mref->name;
                            $action_id = $model->table('zx_permission_action')->add(array(
                                'action_code'           => $code,
                                'action_description'    => $doc,
                                'action_type'           => 1,
                                'module_id'             => $module,
                                'notify_tpl'            => 0
                            ));
                            if($per == '11111'){
                                $model->table('zx_permission_role_action')->add(array(
                                    'role_id'       => 1000,
                                    'action_id'     => $action_id,
                                    'action_code'   => $code,
                                    'module_id'     => $module,
                                ));
                                //未激活权限
                                for($x = 1; $x < 4; $x++){
                                    $model->table('zx_permission_role_not_active_action')->add(array(
                                        'role_id'       => $x,
                                        'action_id'     => $action_id,
                                        'action_code'   => $code,
                                        'module_id'     => $module,
                                    ));
                                }
                            }
                            else{
                                for($i = 0; $i < 5; $i++){
                                    if($per[$i] == '1'){
                                        if($i == 0)
                                            $role = 1001;
                                        else
                                            $role = $i;
                                        //add role permission
                                        $model->table('zx_permission_role_action')->add(array(
                                            'role_id'       => $role,
                                            'action_id'     => $action_id,
                                            'action_code'   => $code,
                                            'module_id'     => $module,
                                        ));
                                        //未激活权限
                                        if($role < 5)
                                            $model->table('zx_permission_role_not_active_action')->add(array(
                                                'role_id'       => $role,
                                                'action_id'     => $action_id,
                                                'action_code'   => $code,
                                                'module_id'     => $module,
                                            ));
                                    }
                                    //-------------未激活权限分配-------------
//                                    if($i == C('ROLE_TALENTS')){
//                                        
//                                    }
//                                    else if($i == C('ROLE_ENTERPRISE')){
//                                        if($mn == 'Company'){
//                                            if(in_array($mref->name, array('home', 'index', 'getHumanIndex', 'getAgentIndex','taskmanage','promote','do_update','do_update_photo','recruitmentIndex','do_account_promote','do_upload_picture'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Bill'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Package'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Promote'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Remind'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Tool'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Message'){
//                                            if($mref->name != 'do_send'){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'User'){
//                                            if($mref->name != 'do_person_apply'){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Contacts'){
//                                            if($mref->name != 'do_follow' && $mref->name != 'do_unfollow'){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Index'){
//                                            if(in_array($mref->name, array('do_upload_identify', 'do_upload_photo'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Public'){
//                                            if(in_array($mref->name, array('article', 'register_succ','_error','about','news','contact','agreement','rule','newsdetail','do_logout','do_ucheck','do_echeck'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Recommend'){
//                                            if(in_array($mref->name, array('get_resume', 'get_human','get_agent_change','get_agent'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Detail'){
//                                            if(in_array($mref->name, array('user', 'job','agent','company','report','human','get_company_jobs','get_running_jobs','get_running_resumes','do_report'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                    }
//                                    else if($i == C('ROLE_AGENT')){
//                                        if($mn == 'MiddleMan'){
//                                            if(in_array($mref->name, array('home', 'index', 'humanManageIndex', 'jobManageIndex','contacts','taskmanage','promote','do_update'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Bill'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Package'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Promote'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Remind'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Tool'){
//                                            $model->table('zx_permission_role_not_active_action')->add(array(
//                                                'role_id'       => $i,
//                                                'action_id'     => $action_id,
//                                                'action_code'   => $code,
//                                                'module_id'     => $module,
//                                            ));
//                                        }
//                                        elseif($mn == 'Message'){
//                                            if($mref->name != 'do_send'){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'User'){
//                                            if($mref->name != 'do_enterprise_apply'){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Contacts'){
//                                            if($mref->name != 'do_follow' && $mref->name != 'do_unfollow'){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Index'){
//                                            if(in_array($mref->name, array('do_upload_identify', 'do_upload_photo'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Public'){
//                                            if(in_array($mref->name, array('article', 'register_succ','_error','about','news','contact','agreement','rule','newsdetail','do_logout','do_ucheck','do_echeck'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Recommend'){
//                                            if(in_array($mref->name, array('get_company', 'get_human','get_resume','get_job'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                        elseif($mn == 'Detail'){
//                                            if(in_array($mref->name, array('user', 'job','agent','company','report','human','get_company_jobs','get_running_jobs','get_running_resumes','do_report'))){
//                                                $model->table('zx_permission_role_not_active_action')->add(array(
//                                                    'role_id'       => $i,
//                                                    'action_id'     => $action_id,
//                                                    'action_code'   => $code,
//                                                    'module_id'     => $module,
//                                                ));
//                                            }
//                                        }
//                                    }
                                    //-------------未激活权限分配-------------
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * 文章详细页11111
     */
    public function detail(){

    }

    /**
     * 获取文章列表11111
     */
    public function get_articles(){
        if(!$this->is_legal_request())
            return;
        $data = home_article_index_page::get_articles($_POST['cid'], $_POST['page'], $_POST['size']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_article_index_page::get_articles_count($_POST['cid']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 获取站内动态11111
     */
    public function get_news(){
        if(!$this->is_legal_request())
            return;
        $data = home_article_index_page::get_articles(6, $_POST['page'], $_POST['size']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_article_index_page::get_articles_count(6);
            echo jsonp_encode(true, $data, $count);
        }
    }
}
?>
