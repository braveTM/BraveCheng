<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MiddleManProvider
 *
 * @author JZG
 */
class MiddleManProvider extends BaseProvider{
    /**
     * 经纪人列表字段
     */
    const AGENT_LIST_FIELD = 'a.agent_id, a.name, a.addr_province_code, a.addr_city_code, a.introduce, a.company_name, u.user_id, u.photo, u.is_real_auth, u.is_phone_auth, u.is_email_auth';

     /**
     * 添加经纪人信息
     * @param <array> $data 经纪人基本信息数组
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addMiddleMan($data){
        $this->da->setModelName('agent');
        $result = $this->da->add($data);
        if($result == false)
            return false;
        return $data['agent_id'];
    }

    /**
     * 更新经纪人信息
     * @param <int> $agent_id 经纪人信息ID
     * @param <array> $data 经纪人基本信息数组
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateMiddleMan($agent_id,$data){
        $this->da->setModelName('agent');
        $where['agent_id']      = $agent_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 删除经纪人信息
     * @param <int> $agent_id 经纪人信息ID
     * @return <bool> 成功返回true,失败返回false
     */
    public function deleteMiddleMan($agent_id){
        $this->da->setModelName('agent');
        return $this->da->delete($agent_id) !== false;
    }

    /**
     * 查询经纪人信息
     * @param <int> $agent_id 经纪人信息ID
     * @return <mixed> 成功返回数组（一条记录）或null,失败返回falses
     */
    public function getMiddleMan($agent_id){
        $this->da->setModelName('agent');
        $where['agent_id'] = $agent_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 查询经纪人信息列表
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <string> $order 排序方式
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getMiddleManList($page,$size,$order){
        $this->da->setModelName('agent');
        $where['is_del']    = 0;
        return $this->da->where($where)->order($order)->page($page.','.$size)->select();
    }

    /**
     * 增加经纪人服务类别
     * @param  <int> $agent_id   经纪人资料编号
     * @param  <int> $service_id 服务类别编号
     * @return <mixed>
     */
    public function add_agent_service($agent_id, $service_id){
        $this->da->setModelName('agent_service_category');
        $data['agent_id']            = $agent_id;
        $data['service_category_id'] = $service_id;
        $data['is_del']              = 0;
        return $this->da->add($data) !== false;
    }

    /**
     * 检测指定经纪人是否存在指定服务
     * @param  <int> $agent_id   经纪人资料编号
     * @param  <int> $service_id 服务类别编号
     * @return <bool>
     */
    public function exists_agent_service($agent_id, $service_id){
        $this->da->setModelName('agent_service_category');
        $where['agent_id']            = $agent_id;
        $where['service_category_id'] = $service_id;
        $where['is_del']              = 0;
        return $this->da->where($where)->count('agent_id') > 0;
    }

    /**
     * 删除经纪人拥有的服务(物理删除)
     * @param  <int> $agent_id 经纪人资料编号
     * @return <type>
     */
    public function delete_agent_services($agent_id){
        $this->da->setModelName('agent_service_category');
        $where['agent_id']            = $agent_id;
        return $this->da->where($where)->delete() !== false;
    }

    /**
     * 获取经纪人的服务列表
     * @param  <int> $agent_id 经纪人资料编号
     * @return <mixed>
     */
    public function get_agent_services($agent_id){
        $field=array(
          't2.service_category_id','t2.name'
        );
        $table=C('DB_PREFIX').'agent_service_category t1';
        $join[0]=C('DB_PREFIX').'service_category t2 on t1.service_category_id=t2.service_category_id';
        $where['t1.agent_id']=$agent_id;
        $where['t1.is_del']=0;
        $where['t2.is_del']=0;
        return $this->da->table($table)->join($join)->where($where)->select();
    }

    /**
     * 获取经纪人列表
     * @param  <int>  $type     类型（1为个人，2为公司）
     * @param  <int>  $service  服务类别
     * @param  <int>  $province 省份编号
     * @param  <int>  $city     城市编号
     * @param  <int>  $page     第几页
     * @param  <int>  $size     每页几条
     * @param  <bool> $count    是否统计总条数
     * @return <mixed>
     */
    public function get_agent_list($type, $service, $province, $city, $page, $size, $count = false){
        if($type === 1){
            $where['a.company_name'] = '';
        }
        else if($type === 2){
            $where['a.company_name'] = array('neq', '');
        }
        if(!empty($service)){
            $join[] = C('DB_PREFIX').'agent_service_category c ON c.agent_id = a.agent_id';
            $where['c.service_category_id'] = $service;
        }
        if(!empty($city)){
            $where['a.addr_city_code'] = $city;
        }
        else if(!empty($province)){
            $where['a.addr_province_code'] = $province;
        }
        if($count){
            if(!empty($join))
                return $this->da->table(C('DB_PREFIX').'agent a')->join($join)->where($where)->count();
            else
                return $this->da->table(C('DB_PREFIX').'agent a')->where($where)->count();
        }
        else{
            $join[] = C('DB_PREFIX').'user u ON u.data_id = a.agent_id';
            return $this->da->table(C('DB_PREFIX').'agent a')->join($join)->where($where)->field(self::AGENT_LIST_FIELD)->page($page.','.$size)->select();
        }
    }

    /**
     * 获取经纪人服务类别列表
     * @return <mixed>
     */
    public function get_service_category(){
        $this->da->setModelName('service_category');
        $where['is_del'] = 0;
        return $this->da->where($where)->select();
    }

    /**
     * 获取经纪人详细信息列表
     * @param <array> $field 字段列表
     * @param <int> $type 经纪人类别（1为个人，2为公司成员）
     * @param <int> $addr_province_code 所在地省份编号
     * @param <int> $addr_city_code 所在地城市编号
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <bool> $count 为true时返回总条数
     * @param <string> $order 排序
     * @return <mixed>
     */
    public function getDetailAgentList($field,$type,$addr_province_code,$addr_city_code,$page,$size,$count,$order){
        $table=C('DB_PREFIX').'user user';
        $join[0]='inner join '.C('DB_PREFIX').'agent agent on user.data_id=agent.agent_id';
        $where['user.role_id']=C('ROLE_AGENT');
        if($type === 1){
            $where['agent.company_name'] = '';
        }
        else if($type === 2){
            $where['agent.company_name'] = array('neq', '');
        }
        if (!empty($addr_province_code)){
            $where['agent.addr_province_code']=$addr_province_code;
        }
        if (!empty($addr_city_code)){
            $where['agent.addr_city_code']=$addr_city_code;
        }
        $where['user_id'] = array('neq', '10017');      //不提供内部帐号
        $where['user.is_del']=0;
        $where['user.is_freeze']=0;
        $where['user.is_activate']=1;
        $where['user.email_activate']=1;
        $where['agent.is_del']=0;
        if ($count){
            return $this->da->table($table)->join($join)->where($where)->count('user.user_id');
        }
        return $this->da->table($table)->join($join)->where($where)->field($field)->page("$page,$size")->order($order)->select();
    }

    /**
     * 获取指定服务类别的经纪人详细列表
     * @param <array> $field 字段列表
     * @param <int> $service_category_id 服务类别ID
     * @param <int> $type 经纪人类别（1为个人，2为公司成员）
     * @param <int> $addr_province_code 所在地省份编号
     * @param <int> $addr_city_code 所在地城市编号
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <bool> $count 为true时返回总条数
     * @param <string> $order 排序
     * @return <mixed>
     */
    public function getDetailAgentListByS($field,$service_category_id,$type,$addr_province_code,$addr_city_code,$page,$size,$count,$order){
        $table=C('DB_PREFIX').'agent_service_category t1';
        $join[0]='inner join '.C('DB_PREFIX').'agent agent on t1.agent_id=agent.agent_id';
        $join[1]='inner join '.C('DB_PREFIX').'user user on user.data_id=agent.agent_id';
        $where['user.role_id']=C('ROLE_AGENT');
        $where['t1.service_category_id']=$service_category_id;
        if($type === 1){
            $where['agent.company_name'] = '';
        }
        else if($type === 2){
            $where['agent.company_name'] = array('neq', '');
        }
        if (!empty($addr_province_code)){
            $where['agent.addr_province_code']=$addr_province_code;
        }
        if (!empty($addr_city_code)){
            $where['agent.addr_city_code']=$addr_city_code;
        }
        $where['t1.is_del']=0;
        $where['user.is_del']=0;
        $where['agent.is_del']=0;
        if ($count){
            return $this->da->table($table)->join($join)->where($where)->count('user.user_id');
        }
        return $this->da->table($table)->join($join)->where($where)->field($field)->page("$page,$size")->order($order)->select();
    }
}
?>
