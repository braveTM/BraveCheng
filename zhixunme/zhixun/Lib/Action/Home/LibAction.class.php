<?php
header('content-type:text/html;charset=utf-8');
/**
 * Module:113
 */
class LibAction extends BaseAction{
    /**
     * 资源库——代理
     */
    public function agent(){
        $this->assign('tclass', home_index_index_page::task_class());                               //任务分类列表
        $this->assign('agents', home_lib_resource_page::get_list(C('ROLE_AGENT')));                 //代理列表
        $this->assign('count', home_lib_resource_page::get_list_count(C('ROLE_AGENT')));            //数据总条数
        $this->assign('labels', home_common_front_page::get_labels(0, C('ROLE_AGENT')));            //代理分类
        $this->assign('location', home_common_front_page::get_location());                          //省份城市
        $this->assign('recomment', home_lib_resource_page::get_recommend(C('ROLE_AGENT')));         //推荐代理
        $this->assign('guess', home_common_front_page::guess_you_like(AccountInfo::get_user_id())); //猜你喜欢
        $this->display();
    }

    /**
     * 资源库——企业
     */
    public function enterprise(){
        $this->assign('tclass', home_index_index_page::task_class());                               //任务分类列表
        $this->assign('enterprise', home_lib_resource_page::get_list(C('ROLE_ENTERPRISE')));        //企业列表
        $this->assign('count', home_lib_resource_page::get_list_count(C('ROLE_ENTERPRISE')));       //数据总条数
        $labels = home_common_front_page::get_labels(0, C('ROLE_ENTERPRISE'));
        $this->assign('tname', $labels[0]->name);                                                   //总承包名称
        $this->assign('tlabels', home_common_front_page::get_labels($labels[0]->id));               //总承包子分类
        $this->assign('pname', $labels[1]->name);                                                   //专业承包名称
        $group = home_common_front_page::get_first_letter_group($labels[1]->id);
        $this->assign('flgroup', $group);                                                           //专业承包首字母分组
        foreach($group as $item){
            $plabels[] = home_common_front_page::get_labels($labels[1]->id, null, $item->letter);
        }
        $this->assign('plabels', $plabels);                                                         //指定首字母的专业承包子分类
        $this->assign('location', home_common_front_page::get_location());                          //省份城市
        $this->assign('recomment', home_lib_resource_page::get_recommend(C('ROLE_ENTERPRISE')));    //推荐企业
        $this->assign('guess', home_common_front_page::guess_you_like(AccountInfo::get_user_id())); //猜你喜欢
        $this->display();
    }

    /**
     * 资源库——分包商
     */
    public function subcontractor(){
        $this->assign('tclass', home_index_index_page::task_class());                               //任务分类列表
        $this->assign('subs', home_lib_resource_page::get_list(C('ROLE_SUBCONTRACTOR')));           //分包商列表
        $this->assign('count', home_lib_resource_page::get_list_count(C('ROLE_SUBCONTRACTOR')));    //数据总条数
        $this->assign('labels', home_common_front_page::get_labels(0, C('ROLE_SUBCONTRACTOR')));    //分包商分类
        $this->assign('location', home_common_front_page::get_location());                          //省份城市
        $this->assign('recomment', home_lib_resource_page::get_recommend(C('ROLE_SUBCONTRACTOR'))); //推荐分包商
        $this->assign('guess', home_common_front_page::guess_you_like(AccountInfo::get_user_id())); //猜你喜欢
        $this->display();
    }

    /**
     * 资源库——人才
     */
    public function talents(){
        $this->assign('tclass', home_index_index_page::task_class());                               //任务分类列表
        $this->assign('talents', home_lib_resource_page::get_list(C('ROLE_TALENTS')));              //人才列表
        $this->assign('count', home_lib_resource_page::get_list_count(C('ROLE_TALENTS')));          //数据总条数
        $labels = home_common_front_page::get_labels(0, C('ROLE_TALENTS'));
        foreach ($labels as $label) {
            $children[] = home_common_front_page::get_labels($label->id);
        }
        $this->assign('labels', $labels);                                                           //人才大分类
        $this->assign('children', $children);                                                       //人才小分类
        $this->assign('location', home_common_front_page::get_location());                          //省份城市
        $this->assign('recomment', home_lib_resource_page::get_recommend(C('ROLE_TALENTS')));       //推荐人才
        $this->assign('guess', home_common_front_page::guess_you_like(AccountInfo::get_user_id())); //猜你喜欢
        $this->display();
    }

    /**
     * 资源搜索
     */
    public function get_resources(){
        //echo $_POST['role_id'], $_POST['label'], $_POST['auth_code'], $_POST['province'], $_POST['city'], $_POST['page'], $_POST['key'];return;
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $order = null;
        if($_POST['order'] == 'd')        //排序
            $order = 'credibility DESC';
        else if($_POST['order'] == 'a')
            $order = 'credibility';
        $data = home_lib_resource_page::get_list($_POST['role_id'], $_POST['label'], $_POST['auth_code'], $_POST['province'], $_POST['city'], $_POST['page'], $_POST['key'], $order);
        if(empty($data))
            echo jsonp_encode(false);
        else{
            $count = home_lib_resource_page::get_list_count($_POST['role_id'], $_POST['label'], $_POST['auth_code'], $_POST['province'], $_POST['city'], $_POST['key']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 猜你喜欢
     */
    public function get_guess(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_common_front_page::guess_you_like(AccountInfo::get_user_id());
        if(empty($data))
            echo jsonp_encode (false);
        else{
            $service = new ProfileService();
            echo jsonp_encode (true, $data);
        }
    }

    /**
     * 获取企业专业承包资质
     */
    public function get_plabels(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $data = home_common_front_page::get_labels(C('PLABEL'), null, trim($_POST['letter']));
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }
}
?>
