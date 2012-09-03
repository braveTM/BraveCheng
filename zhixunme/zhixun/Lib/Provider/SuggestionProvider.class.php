<?php
/**
 * 数据访问层-建议/举报/投诉类
 * @author YoyiorLee
 * @date 2011-11-22
 */
class SuggestionProvider extends BaseProvider{
    
    const SUGGESSTION_FIELDS_NOMAL = 'info_id,user_id,user_name,info_title,info_content,info_class_b,info_class_a,task_type,start_time,end_time,read_count,comment_count,status,is_del';
    const TASK_TYPE_FIELDS_NOMAL = 'class_id,class_title,parent_id,class_code,price,icon,sort,is_del';

    public function  __construct() {
         $this->private = new SuggestionProvider();
    }

    public function add($model) {
        $this->da->setModelName('suggestion');
        $data = FactoryDMap::model_to_array($model,'suggestion');
        unset($data['id']);
        return $this->da->add($data);
    }

    public function delete($id) {
        $this->da->setModelName('suggestion');
        $where['id']  = $task_id;
        $data['is_del'] = 1;
        return $this->da->where($where)->data($data)->save();
    }

    public function get_suggestion($id) {
        $this->da->setModelName('suggestion');
        $where['id']  = $id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::SUGGESSTION_FIELDS_NOMAL)->find();
        if(isset($result))
            return null;
        return FactoryDMap::array_to_model($result, 'suggestion');
    }

    public function get_suggestions_by_type($user_id, $type, $page_index, $page_size, $order) {
        $this->da->setModelName('suggestion');
        $where['is_del']  = 0;
        $result = $this->da->where($where)->page("$page_index,$page_size")->order($order)->field(self::INFORMATION_FIELDS_NOMAL)->select();
        if(isset($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'suggestion');
            array_push($models, $one);
        }
        return $models;
    }

    public function get_type($id) {
        $this->da->setModelName('task_class');
        $where['class_id']  = $id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        if(empty($result))
            return null;
        return FactoryDMap::array_to_model($result, 'type');
    }

    public function get_types($id, $order) {
        $this->da->setModelName('task_class');
        $where['parent_id']  = $id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        if(empty($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'type');
            array_push($models, $one);
        }
        return $models;
    }

    public function is_exist($id){
        $this->da->setModelName('information');
        $where['id']  = $id;
        $where['is_del']  = 0;
        $result = $this->da->where($where)->field(self::TASK_TYPE_FIELDS_NOMAL)->find();
        return $result>0;
    }
}
?>
