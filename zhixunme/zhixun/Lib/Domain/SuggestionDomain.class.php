<?php
/**
 * 业务逻辑层-建议/举报/投诉类
 * @author YoyiorLee
 * @date 2011-11-22
 */
class SuggestionDomain {
    private $private;

    public function  __construct() {
         $this->private = new SuggestionProvider();
    }

    public function add($model) {
        //验证参数
        if(!$this->verify_add_args($model)){
            return false;
        }
        //添加数据
        return $this->private->add($model);
    }

    public function delete($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->private->delete($id);
    }

    public function get_suggestion($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->private->get_suggestion($id);
    }

    public function get_suggestions_by_type($user_id, $type, $page_index, $page_size, $order) {
        //验证参数
        if(!is_numeric($user_id)){
            return false;
        }
        if(!is_numeric($type)){
            return false;
        }
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->private->get_suggestions_by_type($user_id, $type, $page_index, $page_size, $order);
    }

    public function get_type($id) {
        //验证参数
        if(!is_numeric($user_id)){
            return false;
        }
        //查询数据
        return $this->private->get_type($id);
    }

    public function get_types($id, $order) {
        //验证参数
        if(!is_numeric($user_id)){
            return false;
        }
        if(!isset($order)||!preg_match("/(desc|asc|id|user_id|date|user_name|content|type|other_name)?/is", $order)){
            return false;
        }
        //查询数据
        return $this->private->get_types($id, $order);
    }

    public function is_exist($id) {
        //验证参数
        if(!is_numeric($user_id)){
            return false;
        }
        //查询数据
        return $this->private->is_exist($id);
    }

    public function verify_add_args(SuggestionDomainModel $model) {
        if(!isset($model)){
            return false;
        }else{
            if(!$model->__get('id')){
                return false;
            }
            if(!is_numeric($model->__get('user_id'))){
                return false;
            }
            if(mb_strlen($model->__get('content'),'utf-8')>10000){
                return false;
            }
            if(mb_strlen($model->__get('content'),'utf-8')>10000){
                return false;
            }
            if(!is_numeric($model->__get('type'))){
                return false;
            }
            if(!self::is_date($model->__get('date'))){
                return false;
            }
            if(!is_numeric($model->__get('is_del'))){
                return false;
            }
        }
        return true;
    }

    public function verify_page_args($page_index, $page_size, $order) {
        if(!isset($page_index)||!is_numeric($page_index)||$page_index>=0){
            return false;
        }
        if(!isset($page_size)||!is_numeric($page_size)||$page_size>=0){
            return false;
        }
        if(!isset($order)||!preg_match("/(desc|asc|id|user_id|date|user_name|content|type|other_name)?/is", $order)){
            return false;
        }
        return true;
    }
}
?>
