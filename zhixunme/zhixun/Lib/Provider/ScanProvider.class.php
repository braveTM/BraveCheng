<?php
/**
 * 数据访问层-回复类
 * @author YoyiorLee
 * @date 2011-11-14
 */
class ScanProvider extends BaseProvider{
    
    const SCAN_FIELDS_NOMAL = "id,info_id,user_id,user_name,info_title,date,is_del";

    /**
     * 添加用户浏览任务记录
     * @param  <int>    $user_id    用户编号
     * @param  <string> $user_name  用户名
     * @param  <int>    $info_id    任务编号
     * @param  <string> $info_title 任务标题
     * @param  <date>   $date       浏览日期
     * @return <bool> 是否成功
     */
    public function add($user_id, $user_name, $info_id, $info_title, $date) {
        $this->da->setModelName('information_scan');
        $data['user_id'] = $user_id;
        $data['user_name'] =$user_name;
        $data['info_id'] = $info_id;
        $data['info_title'] = $info_title;
        $data['date'] = $date;
        return $this->da->add($data) != false;
    }

    public function delete($id) {
        $this->da->setModelName('information_scan');
        $where['id']  = $id;
        $data['is_del'] = 1;
        $result = $this->da->where($where)->data($data)->save();
        return $result>0;
    }

    public function get_scan($id){
        $this->da->setModelName('information_scan');
        $where['id']  = $id;
        $where['is_del'] = 0;
        $result = $this->da->where($where)->field(self::SCAN_FIELDS_NOMAL)->find();
        if(isset($result))
            return null;
        return FactoryDMap::array_to_model($result, 'scan');
    }
    
    public function get_scans_by_task_id($task_id, $order) {
        $this->da->setModelName('information_scan');
        $where['info_id']  = $task_id;
        $where['is_del'] = 0;
        $result = $this->da->where($where)->order($order)->field(self::SCAN_FIELDS_NOMAL)->select();
        if(isset($result))
            return null;
        $models = array();
        foreach($result as $item){
            $one = FactoryDMap::array_to_model($item, 'scan');
            array_push($models, $one);
        }
        return $models;
    }
    
    public function is_exist($id){
        $this->da->setModelName('information_scan');
        $where['id']  = $id;
        $where['is_del'] = 0;
        $result = $this->da->where($where)->field(self::SCAN_FIELDS_NOMAL)->select();
        return $result>0;
    }

    /**
     * 获取用户浏览记录
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <date> $from    起始时间
     * @param  <date> $to      结束时间
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function get_user_scan_record($user_id, $page, $size, $from = null, $to = null, $count = false){
        $this->da->setModelName('information_scan');             //使用任务浏览表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        if(!empty($from) && !empty($to)){
            $where['date'] = array('between', "'$from','$to'");
        }
        else if(!empty($from)){
            $where['date'] = array('gt', $from);
        }
        else if(!empty($to)){
            $where['date'] = array('lt', $to);
        }
        if($count){
            return $this->da->where($where)->count('user_id');
        }
        else{
            return $this->da->where($where)->page($page.','.$size)->order('date DESC')->select();
        }
    }

    /**
     * 是否存在指定条件浏览记录
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $info_id 任务编号
     * @param  <date> $from    起始时间
     * @param  <date> $to      结束时间
     * @return <bool> 是否存在
     */
    public function exists_scan_record($user_id, $info_id, $from = null, $to = null){
        $this->da->setModelName('information_scan');             //使用任务浏览表
        $where['user_id'] = $user_id;
        $where['info_id'] = $info_id;
        $where['is_del']  = 0;
        if(!empty($from) && !empty($to)){
            $where['date'] = array('between', "'$from','$to'");
        }
        else if(!empty($from)){
            $where['date'] = array('gt', $from);
        }
        else if(!empty($to)){
            $where['date'] = array('lt', $to);
        }
        return $this->da->where($where)->count('info_id') > 0;
    }

    /**
     * 更新浏览记录日期
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $info_id 任务编号
     * @param  <date> $date    日期
     * @return <bool> 是否成功
     */
    public function update_scan_date($user_id, $info_id, $date){
        $this->da->setModelName('information_scan');             //使用任务浏览表
        $where['user_id'] = $user_id;
        $where['info_id'] = $info_id;
        $where['is_del']  = 0;
        $data['date'] = $date;
        return $this->da->where($where)->save($data) != false;
    }
}
?>
