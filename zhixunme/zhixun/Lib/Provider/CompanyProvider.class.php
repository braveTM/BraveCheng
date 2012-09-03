<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompanyProvider
 *
 * @author JZG
 */
class CompanyProvider extends BaseProvider{
    //put your code here
     /**
     * 添加企业信息
     * @param <array> $data 企业基本信息数组
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addCompany($data){
        $this->da->setModelName('company');
        $result = $this->da->add($data);
        if($result == false)
            return false;
        return $data['company_id'];
    }

    /**
     * 更新企业信息
     * @param <int> $company_id 企业信息ID
     * @param <array> $data 企业基本信息数组
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateCompany($company_id,$data){
        $this->da->setModelName('company');
        $where['company_id']      = $company_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 删除企业信息
     * @param <int> $company_id 企业信息ID
     * @return <bool> 成功返回true,失败返回false
     */
    public function deleteCompany($company_id){
        $this->da->setModelName('company');
        return $this->da->delete($company_id) !== false;
    }

    /**
     * 查询企业信息
     * @param <int> $company_id 企业信息ID
     * @return <mixed> 成功返回数组（一条记录）或null,失败返回falses
     */
    public function getCompany($company_id){
        $this->da->setModelName('company');
        $where['company_id'] = $company_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 查询企业信息列表
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <string> $order 排序方式
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getCompanyList($page,$size,$order){
        $this->da->setModelName('company');
        $where['is_del']    = 0;
        return $this->da->where($where)->order($order)->page($page.','.$size)->select();
    }

    /**
     * 查询最近服务的企业列表
     * @param <int> $agent_id 代理人ID
     * @param <datetime> $end_time 时间阈
     * @param <int> $page 第几页
     * @param <int> $size 每页几条
     * @param <string> $order 排序方式
     * @return <mixed>
     */
    public function getServiceCompanyList($agent_id,$end_time,$page,$size,$count,$order){
        $field=array('creator_id'=>'user_id','company_name','delegate_datetime');
        $table=C('DB_PREFIX').'job';
        $where['agent_id']=$agent_id;
        if (!empty($end_time)){
            $where['delegate_datetime']=array('gt',$end_time);
        }
        if ($count){
            return $this->da->table($table)->count('user_id');
        }
        if (empty($order)){
            $order='delegate_datetime desc';
        }
        return $this->da->table($table)->field($field)->where($where)->page("$page,$size")->order($order)->select();
    }
}
?>
