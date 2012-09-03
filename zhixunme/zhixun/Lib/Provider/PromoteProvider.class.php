<?php
/**
 * Description of PromoteProvider
 *
 * @author zhiguo
 */
class PromoteProvider extends BaseProvider {

    const PROMOTE_FIELDS = 'id,title,price,role_id,min_days,max_days,sort';
    const PROMOTE_RECORD_FIELDS = 'id,promote_id,start_time,end_time,user_id,picture,dtext,cost';
    /**
     * 获取推广位占用记录列表
     * @param <type> $user_id 用户编号
     * @param <type> $order 排序方式
     */
    public function get_promote_record_list($user_id,$order) {
        $this->da->setModelName('promote_record');
        $where['is_del'] = 0;
        $where['user_id']=$user_id;
        if (empty($order)) {
            $order = 'start_time DESC';
        }
        return $this->da->where($where)->field(self::PROMOTE_RECORD_FIELDS)->order($order)->select();
    }

    /**
     * 获取推广位列表
     * @param <int>    $page 第几页
     * @param <int>    $size 每页条数
     * @param <string> $order 排序
     * @param <int>    $role_id 角色编号
     * @param <int>    $area 区域编号
     */
    public function get_promote_list($page, $size, $order, $role_id = null, $area = null) {
        $this->da->setModelName('promote_location');
        $where['is_del'] = 0;
        if (!empty($role_id))
            $where['role_id'] = $role_id;
        if (empty($order)) {
            $order = 'sort';
        }
        if (!empty($area)){
            $where['area'] = $area;
        }
        return $this->da->where($where)->page("$page,$size")->field(self::PROMOTE_FIELDS)->order($order)->select();
    }

    /**
     * 添加推广位记录
     * @param <type> $user_id 用户编号
     * @param <type> $promote_id 推广位编号
     * @param <type> $start_time 开始时间
     * @param <type> $end_time 过期时间
     * @param <type> $cost 花费
     */
    public function add_promote_record($user_id, $promote_id, $start_time, $end_time, $cost) {
        $this->da->setModelName('promote_record');
        $data['user_id'] = $user_id;
        $data['promote_id'] = $promote_id;
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        $data['picture'] = '';
        $data['dtext'] = '';
        $data['cost'] = $cost;
        return $this->da->add($data) !== false;
    }

    /**
     * 判断指定推广位当前是否被占用
     * @param  <int> $promote_id 推广位ID
     * @return <bool>
     */
    public function is_hold_promote($promote_id) {
        $this->da->setModelName('promote_record');
        $where['is_del'] = 0;
        $date = date_f();
        $where['end_time']   = array('gt', $date);
        $where['promote_id'] = $promote_id;
        return $this->da->where($where)->count('promote_id') > 0;
    }

    /**
     * 用户推广记录列表
     * @param <int>    $user_id    用户编号
     * @param <int>    $promote_id 推广位编号
     * @param <string> $end        推广结束时间
     * @param <bool>   $count      是否统计总条数
     * @return <mixed>
     */
    public function get_promote_records($user_id, $promote_id, $end, $count){
        $this->da->setModelName('promote_record');
        $where['is_del'] = 0;
        if(!empty($user_id))
            $where['user_id'] = $user_id;
        if(!empty($promote_id))
            $where['promote_id'] = $promote_id;
        if(!empty($end))
            $where['end_time'] = array('gt', $end);
        if($count){
            return $this->da->where($where)->count('id');
        }
        else{
            return $this->da->where($where)->select();
        }
    }

    /**
     * 获取指定区域的推广位记录
     * @param  <int>    $area_id 区域编号
     * @param  <string> $end     结束时间
     * @param  <bool>   $count   是否统计总条数
     * @return <mixed>
     */
    public function get_area_promote_records($area_id, $end, $count){
        $this->da->setModelName('promote_location t1');
        $join[] = 'INNER JOIN '.C('DB_PREFIX').'promote_record t2 ON t2.promote_id=t1.id';
        $where['t1.is_del'] = 0;
        $where['t2.is_del'] = 0;
        $where['t1.area'] = $area_id;
        $where['t2.end_time'] = array('gt', $end);
        if($count){
            return $this->da->join($join)->where($where)->count('t2.end_time');
        }
        else{
            $field = 't2.promote_id,t2.user_id,t2.picture,t2.dtext,t1.sort';
            return $this->da->join($join)->where($where)->field($field)->select();
        }
    }

    /**
     * 获取指定推广位当前记录
     * @param  <int> $promote_id 推广位ID
     * @return <mixed>
     */
    public function get_hold_promote($promote_id){
        $this->da->setModelName('promote_record');
        $where['is_del'] = 0;
        $date = date_f();
        $where['end_time']   = array('gt', $date);
        $where['promote_id'] = $promote_id;
        return $this->da->where($where)->find();
    }

    /**
     * 获取指定推广位的当前占用记录
     * @param <type> $promote_id  推广位ID
     */
    public function get_current_promote_record($promote_id) {
        $this->da->setModelName('promote_record');
        $where['is_del'] = 0;
        $date = date_f();
        $where['end_time'] = array('gt', $date);
        $where['promote_id']=$promote_id;
        return $this->da->where($where)->field(self::PROMOTE_RECORD_FIELDS)->find();
    }

    /**
     * 获取指定推广位
     * @param <type> $promote_id 推广位ID
     * @return <type>
     */
    public function get_promote($promote_id) {
        $this->da->setModelName('promote_location');
        $where['is_del'] = 0;
        $where['id']=$promote_id;
        return $this->da->where($where)->field(self::PROMOTE_FIELDS)->find();
    }

    /**
     * 获取指定推广位记录
     * @param  <int> $id 编号
     * @return <mixed>
     */
    public function get_promote_location_record($id){
        $this->da->setModelName('promote_record');
        $where['is_del'] = 0;
        $where['id'] = $id;
        return $this->da->where($where)->find();
    }

    /**
     * 获取推广位数目
     */
    public function get_promote_total_count() {
        $this->da->setModelName('promote_location');
        $where['is_del'] = 0;
        return $this->da->where($where)->count('id');
    }

    /**
     * 获取推广服务列表
     * @param  <int> $type 服务类型（1职位2简历3任务）
     * @return <mixed>
     */
    public function get_promote_services($type){
        $this->da->setModelName('promote_service');
        $where['type']   = $type;
        $where['is_del'] = 0;
        return $this->da->where($where)->select();
    }

    /**
     * 获取指定推广服务信息
     * @param  <int> $id 推广服务编号
     * @return <mixed>
     */
    public function get_promote_service($id){
        $this->da->setModelName('promote_service');
        $where['id']     = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 添加职位服务记录
     * @param  <int>    $user_id    用户编号
     * @param  <int>    $job_id     职位编号
     * @param  <int>    $service    服务编号
     * @param  <string> $start_time 开始时间
     * @param  <string> $end_time   结束时间
     * @param  <int>    $cost       花费
     * @param  <int>    $area       推广地区编号（暂未开放）
     * @param  <int>    $role       推广针对角色编号（暂未开放）
     * @return <bool> 是否成功
     */
    public function add_promote_job_record($user_id, $job_id, $service, $start_time, $end_time, $cost, $area = 0, $role = 0){
        $this->da->setModelName('promote_job');
        $data['user_id']    = $user_id;
        $data['job_id']     = $job_id;
        $data['service_id'] = $service;
        $data['start_time'] = $start_time;
        $data['end_time']   = $end_time;
        $data['cost']       = $cost;
        $data['area']       = $area;
        $data['role']       = $role;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 更新职位服务记录
     * @param  <int>   $id   记录编号
     * @param  <array> $data 更新数据
     * @return <bool> 是否成功
     */
    public function update_promote_job_record($id, $data){
        $this->da->setModelName('promote_job');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 添加简历服务记录
     * @param  <int>    $user_id    用户编号
     * @param  <int>    $resume_id  简历编号
     * @param  <int>    $service    服务编号
     * @param  <string> $start_time 开始时间
     * @param  <string> $end_time   结束时间
     * @param  <int>    $cost       花费
     * @param  <int>    $area       推广地区编号（暂未开放）
     * @param  <int>    $role       推广针对角色编号（暂未开放）
     * @return <bool> 是否成功
     */
    public function add_promote_resume_record($user_id, $resume_id, $service, $start_time, $end_time, $cost, $area = 0, $role = 0){
        $this->da->setModelName('promote_resume');
        $data['user_id']    = $user_id;
        $data['resume_id']  = $resume_id;
        $data['service_id'] = $service;
        $data['start_time'] = $start_time;
        $data['end_time']   = $end_time;
        $data['cost']       = $cost;
        $data['area']       = $area;
        $data['role']       = $role;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 更新简历服务记录
     * @param  <int>   $id   记录编号
     * @param  <array> $data 更新数据
     * @return <bool> 是否成功
     */
    public function update_promote_resume_record($id, $data){
        $this->da->setModelName('promote_resume');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 添加任务服务记录
     * @param  <int>    $user_id    用户编号
     * @param  <int>    $task_id    任务编号
     * @param  <int>    $service    服务编号
     * @param  <string> $start_time 开始时间
     * @param  <string> $end_time   结束时间
     * @param  <int>    $cost       花费
     * @param  <int>    $area       推广地区编号（暂未开放）
     * @param  <int>    $role       推广针对角色编号（暂未开放）
     * @return <bool> 是否成功
     */
    public function add_promote_task_record($user_id, $task_id, $service, $start_time, $end_time, $cost, $area = 0, $role = 0){
        $this->da->setModelName('promote_task');
        $data['user_id']    = $user_id;
        $data['task_id']    = $task_id;
        $data['service_id'] = $service;
        $data['start_time'] = $start_time;
        $data['end_time']   = $end_time;
        $data['cost']       = $cost;
        $data['area']       = $area;
        $data['role']       = $role;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 更新任务服务记录
     * @param  <int>   $id   记录编号
     * @param  <array> $data 更新数据
     * @return <bool> 是否成功
     */
    public function update_promote_task_record($id, $data){
        $this->da->setModelName('promote_task');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 添加企业服务记录
     * @param  <int>    $user_id    用户编号
     * @param  <int>    $service    服务编号
     * @param  <string> $start_time 开始时间
     * @param  <string> $end_time   结束时间
     * @param  <int>    $cost       花费
     * @param  <int>    $area       推广地区编号（暂未开放）
     * @param  <int>    $role       推广针对角色编号（暂未开放）
     * @return <bool> 是否成功
     */
    public function add_promote_company_record($user_id, $service, $start_time, $end_time, $cost, $area = 0, $role = 0){
        $this->da->setModelName('promote_company');
        $data['user_id']    = $user_id;
        $data['service_id'] = $service;
        $data['start_time'] = $start_time;
        $data['end_time']   = $end_time;
        $data['cost']       = $cost;
        $data['area']       = $area;
        $data['role']       = $role;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 更新企业服务记录
     * @param  <int>   $id   记录编号
     * @param  <array> $data 更新数据
     * @return <bool> 是否成功
     */
    public function update_promote_company_record($id, $data){
        $this->da->setModelName('promote_company');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->save($data) != false;
    }
    /**
     * 添加经纪人服务记录
     * @param  <int>    $user_id    用户编号
     * @param  <int>    $service    服务编号
     * @param  <string> $start_time 开始时间
     * @param  <string> $end_time   结束时间
     * @param  <int>    $cost       花费
     * @param  <int>    $area       推广地区编号（暂未开放）
     * @param  <int>    $role       推广针对角色编号（暂未开放）
     * @return <bool> 是否成功
     */
    public function add_promote_agent_record($user_id, $service, $start_time, $end_time, $cost, $area = 0, $role = 0){
        $this->da->setModelName('promote_agent');
        $data['user_id']    = $user_id;
        $data['service_id'] = $service;
        $data['start_time'] = $start_time;
        $data['end_time']   = $end_time;
        $data['cost']       = $cost;
        $data['area']       = $area;
        $data['role']       = $role;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 更新经纪人服务记录
     * @param  <int>   $id   记录编号
     * @param  <array> $data 更新数据
     * @return <bool> 是否成功
     */
    public function update_promote_agent_record($id, $data){
        $this->da->setModelName('promote_agent');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->save($data) != false;
    }
    
    /**
     * 获取职位推广记录
     * @param <int>    $user_id 用户编号
     * @param <int>    $job_id  职位编号
     * @param <int>    $service 服务编号
     * @param <string> $start   开始时间
     * @param <string> $end     结束时间
     * @param <bool>   $only    是否获取唯一（优先级最高，为TRUE则使用FIND方法）
     * @param <int>    $page    第几页
     * @param <int>    $size    每页几条
     * @param <bool>   $count   是否统计总条数
     * @return <mixed>
     */
    public function get_promote_job_record($user_id, $job_id, $service, $start, $end, $only, $page, $size, $count){
        $this->da->setModelName('promote_job');
        if(!empty($user_id)){
            $where['user_id'] = $user_id;
        }
        if(!empty($job_id)){
            $where['job_id'] = $job_id;
        }
        if(!empty($service)){
            $where['service_id'] = $service;
        }
        if(!empty($start)){
            $where['start_time'] = array('lt', $start);
        }
        if(!empty($end)){
            $where['end_time'] = array('gt', $end);
        }
        $where['is_del'] = 0;
        if($only){
            return $this->da->where($where)->find();
        }
        if($count){
            return $this->da->where($where)->count('id');
        }
        else{
            $order = 'start_time DESC';
            return $this->da->where($where)->order($order)->page($page.','.$size)->select();
        }
    }

    /**
     * 获取简历推广记录
     * @param <int>    $user_id   用户编号
     * @param <int>    $resume_id 简历编号
     * @param <int>    $service   服务编号
     * @param <string> $start     开始时间
     * @param <string> $end       结束时间
     * @param <bool>   $only      是否获取唯一（优先级最高，为TRUE则使用FIND方法）
     * @param <int>    $page      第几页
     * @param <int>    $size      每页几条
     * @param <bool>   $count     是否统计总条数
     * @return <mixed>
     */
    public function get_promote_resume_record($user_id, $resume_id, $service, $start, $end, $only, $page, $size, $count){
        $this->da->setModelName('promote_resume');
        if(!empty($user_id)){
            $where['user_id'] = $user_id;
        }
        if(!empty($resume_id)){
            $where['resume_id'] = $resume_id;
        }
        if(!empty($service)){
            $where['service_id'] = $service;
        }
        if(!empty($start)){
            $where['start_time'] = array('lt', $start);
        }
        if(!empty($end)){
            $where['end_time'] = array('gt', $end);
        }
        $where['is_del'] = 0;
        if($only){
            return $this->da->where($where)->find();
        }
        if($count){
            return $this->da->where($where)->count('id');
        }
        else{
            $order = 'start_time DESC';
            return $this->da->where($where)->order($order)->page($page.','.$size)->select();
        }
    }

    /**
     * 获取任务推广记录
     * @param <int>    $user_id 用户编号
     * @param <int>    $task_id 任务编号
     * @param <int>    $service 服务编号
     * @param <string> $start   开始时间
     * @param <string> $end     结束时间
     * @param <bool>   $only    是否获取唯一（优先级最高，为TRUE则使用FIND方法）
     * @param <int>    $page    第几页
     * @param <int>    $size    每页几条
     * @param <bool>   $count 是否统计总条数
     * @return <mixed>
     */
    public function get_promote_task_record($user_id, $task_id, $service, $start, $end, $only, $page, $size, $count){
        $this->da->setModelName('promote_task');
        if(!empty($user_id)){
            $where['user_id'] = $user_id;
        }
        if(!empty($task_id)){
            $where['task_id'] = $task_id;
        }
        if(!empty($service)){
            $where['service_id'] = $service;
        }
        if(!empty($start)){
            $where['start_time'] = array('lt', $start);
        }
        if(!empty($end)){
            $where['end_time'] = array('gt', $end);
        }
        $where['is_del'] = 0;
        if($only){
            return $this->da->where($where)->find();
        }
        if($count){
            return $this->da->where($where)->count('id');
        }
        else{
            $order = 'start_time DESC';
            return $this->da->where($where)->order($order)->page($page.','.$size)->select();
        }
    }

    /**
     * 获取企业推广记录
     * @param <int>    $user_id 用户编号
     * @param <int>    $service 服务编号
     * @param <string> $start   开始时间
     * @param <string> $end     结束时间
     * @param <bool>   $only    是否获取唯一（优先级最高，为TRUE则使用FIND方法）
     * @param <int>    $page    第几页
     * @param <int>    $size    每页几条
     * @param <bool>   $count 是否统计总条数
     * @return <mixed>
     */
    public function get_promote_company_record($user_id, $service, $start, $end, $only, $page, $size, $count){
        $this->da->setModelName('promote_company');
        if(!empty($user_id)){
            $where['user_id'] = $user_id;
        }
        if(!empty($service)){
            $where['service_id'] = $service;
        }
        if(!empty($start)){
            $where['start_time'] = array('lt', $start);
        }
        if(!empty($end)){
            $where['end_time'] = array('gt', $end);
        }
        $where['is_del'] = 0;
        if($only){
            return $this->da->where($where)->find();
        }
        if($count){
            return $this->da->where($where)->count('id');
        }
        else{
            $order = 'start_time DESC';
            return $this->da->where($where)->order($order)->page($page.','.$size)->select();
        }
    }

    /**
     * 获取经纪人推广记录
     * @param <int>    $user_id 用户编号
     * @param <int>    $service 服务编号
     * @param <string> $start   开始时间
     * @param <string> $end     结束时间
     * @param <bool>   $only    是否获取唯一（优先级最高，为TRUE则使用FIND方法）
     * @param <int>    $page    第几页
     * @param <int>    $size    每页几条
     * @param <bool>   $count 是否统计总条数
     * @return <mixed>
     */
    public function get_promote_agent_record($user_id, $service, $start, $end, $only, $page, $size, $count){
        $this->da->setModelName('promote_agent');
        if(!empty($user_id)){
            $where['user_id'] = $user_id;
        }
        if(!empty($service)){
            $where['service_id'] = $service;
        }
        if(!empty($start)){
            $where['start_time'] = array('lt', $start);
        }
        if(!empty($end)){
            $where['end_time'] = array('gt', $end);
        }
        $where['is_del'] = 0;
        if($only){
            return $this->da->where($where)->find();
        }
        if($count){
            return $this->da->where($where)->count('id');
        }
        else{
            $order = 'start_time DESC';
            return $this->da->where($where)->order($order)->page($page.','.$size)->select();
        }
    }

    /**
     * 更新推广位置记录信息
     * @param  <int>   $id   编号
     * @param  <array> $data 数据
     * @return <bool>
     */
    public function update_promote_record($id, $data){
        $this->da->setModelName('promote_record');
        $where['id'] = $id;
        return $this->da->where($where)->save($data) != false;
    }
}
?>
