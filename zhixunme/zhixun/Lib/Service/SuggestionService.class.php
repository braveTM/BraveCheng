<?php
/**
 * Description of SuggestionService
 *
 * @author YoyiorLee
 */
class SuggestionService{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new SuggestionProvider();
    }

    /**
     * 删除
     * @param <int> $id 编号
     * @return <bool> 是否成功
     */
    public function delete($id) {
        //验证参数
        if(!is_numeric($id)){
            return false;
        }
        //查询数据
        return $this->private->delete($id);
    }

    /**
     * 批量删除
     * @param <string> $ids 编号集合（用,分开）
     * @return <bool> 是否成功
     */
    public function delete_batch($ids) {
        $ids = explode(',',$ids);
        foreach($ids as $id){
            if(!$this->delete($id)){
                return false;
            }
        }
        return true;
    }

    /**
     * 获取投诉列表
     * @param <int> $id 编号
     * @return List<SuggestionDomainModel> 信息实体列表
     */
    public function get_complaints($user_id, $type, $page_index, $page_size, $order) {
        if(!$this->verify_page_args($page_index, $page_size, $order)){
            return false;
        }
        //查询数据
        return $this->private->get_suggestions_by_type($user_id, $type, $page_index, $page_size, $order);
    }

    /**
     * 获取举报列表
     * @param $user_id 用户编号
     * @return List<SuggestionDomainModel> 信息实体
     */
    public function get_reports($user_id) {
    }

    /**
     * 获取具体建议/投诉/举报信息内容
     * @param <int> $id 编号
     * @return <SuggestionDomainModel> 信息实体
     */
    public function get_suggestion($id) {
        return $this->private->get_suggestion($id);
    }

    /**
     * 获取建议列表
     * @param <int> $id 编号
     * @return List<SuggestionDomainModel> 信息实体列表
     */
    public function get_suggestions($user_id) {
    }

    /**
     * 获取类型实体
     * @param $id 类型编号
     * @return <TypeDomainModel> 类型实体
     */
    public function get_type($id) {
        return $this->private->get_type($id);
    }

    /**
     * 获取类型的子类型列表
     * @param $id 类型编号
     * @return List<TypeDomainModel> 类型实体列表
     */
    public function get_types($id) {
        return $this->private->get_types($id, $order);
    }

    /**
     * 发送信息
     * @param <int> $user_id 用户编号
     * @param <int> $user_name 用户名
     * @param <int> $other_name 对方用户名
     * @param <int> $content 内容
     * @param <int> $type 类型
     * @param <int> $date 日期
     * @return <bool> 是否成功
     */
    public function send($user_id, $user_name, $other_name, $content, $type, $date) {
        $model = new SuggestionDomainModel();
        $model->__set('id', null);
        $model->__set('user_id', $user_id);
        $model->__set('user_name', $user_name);
        $model->__set('other_name', $other_name);
        $model->__set('content', $content);
        $model->__set('type', $type);
        $model->__set('date', $date);
        $model->__set('is_del', 0);
        //验证参数
        if(!$this->verify_add_args($model)){
            return false;
        }
        //添加数据
        return $this->private->add($model);
    }

    //--------------protected-----------------
    protected function verify_add_args(SuggestionDomainModel $model) {
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

    protected function verify_page_args($page_index, $page_size, $order) {
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
