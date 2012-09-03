<?php
/**
 * 业务逻辑层-任务浏览类
 * @author YoyiorLee
 * @date 2011-10-30
 */
class ScanDomain {
    private $provider;
    
    function  __construct() {
        $this->provider = new ScanProvider();
    }

    public function add(ScanDomainModel $model) {
        //验证参数
        if(!self::verify_add_args($model)){
            return false;
        }
        //查询数据
        return $this->provider->add($model);
    }

    public function delete($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->delete($id);
    }

    public function get_scan($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->get_scan($id);
    }

    public function get_scans($task_id, $order) {
        //验证参数
        if(!is_numeric($task_id)){
            return false;
        }
        if(!isset($order)||!preg_match("/(desc|asc|id|info_title|date|user_id|user_name|date)?/is", $order)){
            return false;
        }
        //查询数据
        return $this->provider->get_scans_by_task_id($task_id, $order);
    }

    public function is_exist($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->provider->is_exist($id);
    }

    public function verify_add_args(ScanDomainModel $model) {
        if(!isset($model)){
            return false;
        }else{
            if(!$model->__get('id')){
                return false;
            }
            if($model->__get('task_id')==null||!is_numeric($model->__get('task_id'))){
                return false;
            }
            if(mb_strlen($model->__get('title'),'utf-8')>10000){
                return false;
            }
            if(!self::is_date($model->__get('date'))){
                return false;
            }
            if(!is_numeric(!is_numeric($model->__get('user_id')))){
                return false;
            }
            if(!self::is_date($model->__get('date'))){
                return false;
            }
        }
        return true;
    }

    public function is_date($data){
         if(isset($data) && $data!='' && preg_match("/^(/d{2}|/d{4})-((0([1-9]{1}))|(1[0|1|2])|([1-9]{1}))-(([0-2]([0-9]))|(3[0|1])|([1-9]{1}))(|/s+((0|1)[0-9]|2[0-3])(|:[0-5][0-9](|:[0-5][0-9])))$/",$data) )
         {
            return true;
         }
         return false;
    }
}
?>
