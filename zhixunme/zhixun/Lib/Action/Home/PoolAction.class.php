<?php
header('content-type:text/html;charset=utf-8');
/**
 * Module:116
 */
class PoolAction extends BaseAction {
    /**
     * 我的资源库
     */
    public function index() {
        //视图
        $this->assign('tnav', home_common_admin_page::left_navigate());     //导航
        $this->assign('tclass', home_index_index_page::task_class());       //任务分类列表
        $this->display();
    }
    /**
     * 经纪人首页
     */
    public function aindex() {
        $this->display();
    }
    /**
     * 人才首页
     */
    public function tindex() {
        $this->display();
    }
    /**
     * 企业首页
     */
    public function eindex() {
        $this->display();
    }
    /**
     * 招聘页
     */
    public function bringin() {
        $this->display();
    }
    /**
     * 企业找经纪人页
     */
    public function efagent() {
        $this->display();
    }
    /**
     * 找企业
     */
    public function fenterprises() {
        $this->display();
    }
    /**
     * 求职
     */
    public function fjobs() {
        $this->display();
    }
    /**
     * 找人才
     */
    public function ftalents() {
        $this->display();
    }
    /**
     * 职位管理
     */
    public function jobmanange() {
        $this->display();
    }
    /**
     * 人才找经纪人
     */
    public function tfagent() {
        $this->display();
    }
    /**
     * 人才管理
     */
    public function tmanage() {
        $this->display();
    }
    /**
     * 我的人脉
     */
    public function mycontacts() {
        $this->display();
    }
    /**
     * 经纪人详细页
     */
    public function agdetail() {
        $this->display();
    }

    /**
     * 获取资源库列表
     */
    public function get_pool_list() {
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $user_id=AccountInfo::get_user_id();
        $data = home_pool_admin_page::get_pool_list($user_id, $_POST['type'], $_POST['like'], $_POST['page'], null);
        if(empty ($data)) {
            echo jsonp_encode(false);
        }
        else {
            $count = home_pool_admin_page::get_pool_total_count($user_id, $_POST['type'], $_POST['like']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 模型对象列表转化为数组
     * @param <mixed> $model
     * @return <array>
     */
    private function models_to_array($models){
        if(empty($models))
            return null;
        $array = array();
        foreach ($models as $model) {
            $array[] = $this->model_to_array($model);
        }
        return $array;
    }

    /**
     * 模型对象转化为数组
     * @param <mixed> $model
     * @return <array>
     */
    private function model_to_array($model){
        $array=array();
        $array=get_object_vars($model);
        foreach($array as $key=>$value){
            if (is_array($value)){
                foreach($value as $ckey=>$child){
                    if (is_object($value)){
                       $array[$key][$ckey]=$this->model_to_array($child);
                    }
                }
            }
            if (is_object($value)){
                $array[$key]=$this->model_to_array($value);
            }
        }
        return $array;
    }


    /**
     * 新增资源库
     */
    public function do_add_pool() {
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $service = new PoolService();
        $result  = $service->add_pool(AccountInfo::get_user_id(),P('name'), $_POST['r_name'], $_POST['r_qual'], $_POST['r_province'], $_POST['r_city'], $_POST['r_phone'],$_POST['type']);
        if(is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        }else {
            echo jsonp_encode(true);
        }
    }
}
?>
