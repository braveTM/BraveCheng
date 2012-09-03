<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JobOperateProvider
 *
 * @author JZG
 */
class JobOperateProvider extends BaseProvider{
    /**
     * 添加简历邀请记录
     * @param <int>    $invitor 邀请人编号
     * @param <int>    $resume  简历编号
     * @param <int>    $job     职位编号
     * @param <string> $date    邀请日期
     * @param <string> $user_id 当前简历拥有者编号
     * @return <bool> 是否成功
     */
    public function add_invite_resume($invitor, $resume, $job, $date, $user_id){
        $this->da->setModelName('invite_resume');
        $data['invitor_id'] = $invitor;
        $data['resume_id']  = $resume;
        $data['user_id']    = $user_id;
        $data['job_id']     = $job;
        $data['invite_datetime'] = $date;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 查询职位操作列表
     */

    /**
     * 添加投递简历记录
     * @param <array> $data 投递简历记录
     * @return <bool> 是否成功
     */
    public function addSendResume($data){
        $this->da->setModelName('send_resume');
        $data['is_del']     = 0;
        $data['send_datetime']=date_f();
        return $this->da->add($data) != false;
    }

    /**
     * 添加查看简历记录
     * @param <array> $data 查看简历记录
     * @return <bool> 是否成功
     */
    public function addReadResume($data){
        $this->da->setModelName('read_resume');
        $data['is_del']=0;
        $data['read_datetime']=date_f();
        return $this->da->add($data)!==false;
    }

    /**
     * 获取查看简历记录
     * @return <bool> 是否成功
     */
    public function getReadResume($user_id, $resume_id){
        $this->da->setModelName('read_resume');
        $where['is_del'] = 0;
        $where['reader_id'] =$user_id;
        $where['resume_id'] = $resume_id;
        return $this->da->where($where)->find();
    }

    /**
     * 更新查看简历记录
     * @return <bool> 是否成功
     */
    public function updateReadResume($id, $date){
        $this->da->setModelName('read_resume');
        $where['id'] = $id;
        $data['read_datetime'] = $date;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 添加查看职位记录
     * @param <array> $data 查看职位记录
     * @return <bool> 是否成功
     */
    public function addReadJob($data){
        $this->da->setModelName('read_job');
        $data['is_del']=0;
        $data['read_datetime']=date_f();
        return $this->da->add($data)!==false;
    }

    /**
     * 获取职位查看信息
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $job_id  职位编号
     * @param  <string> $from    起始时间
     * @return <mixed>
     */
    public function getReadJob($user_id, $job_id, $from){
       $this->da->setModelName('read_job');            
       $where['reader_id'] = $user_id;
       $where['job_id'] = $job_id;
       if(!empty($from)){
           $where['read_datetime'] = array('gt', $from);
       }
       return $this->da->where($where)->find();
    }

    /**
     * 更新职位查看信息
     * @param  <int> $id   编号
     * @param  <int> $date 日期
     * @return <bool> 是否成功
     */
    public function updateReadJob($id, $date){
       $this->da->setModelName('read_job');
       $where['read_job_id']  = $id;
       $data['read_datetime'] = $date;
       return $this->da->where($where)->save($data) != false;
    }

    /**
     * 查询投递简历数量
     * @param <int> $sender_id 投递人ID
     * @param <int> $resume_id 简历ID
     * @return <int>
     */
    public function getSendResumeCount($sender_id,$resume_id){
        $this->da->setModelName('send_resume');
        $where['is_del']=0;
        $where['sender_id']=$sender_id;
        $where['resume_id']=$resume_id;
        return $this->da->where($where)->count('send_resume_id');
    }

    /**
     * 更新投递简历记录
     * @param <int> $send_resume_id 投递简历记录ID
     * @param <array> $data 数据
     * @return <bool> 是否更新成功
     */
    public function updateSendResume($send_resume_id,$data){
        $this->da->setModelName('send_resume');
        $where['send_resume_id']=$send_resume_id;
        return $this->da->where($where)->save($data)!==false;
    }

    /**
     * 查询委托简历记录
     * @param <int> $delegate_resume_id 委托简历记录ID
     * @return <mixed>
     */
    public function getDelegateResume($delegate_resume_id){
        $this->da->setModelName('delegate_resume');
        $where['is_del']=0;
        $where['id']=$delegate_resume_id;
        return $this->da->where($where)->find();
    }

    /**
     * 查询投递简历记录
     * @param <int> $send_resume_id 投递简历记录ID
     * @return <mixed>
     */
    public function getSendResume($send_resume_id){
        $this->da->setModelName('send_resume');
        $where['is_del']=0;
        $where['send_resume_id']=$send_resume_id;
        return $this->da->where($where)->find();
    }
    
    /**
     * 取得职位浏览数
     * Enter description here ...
     * @param unknown_type $job_id
     */
    public function getReadJobCount($job_id){
    	$this->da->setModelName('read_job');
        $where['job_id']  = $job_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->count();
    }
    
    
    /**
     * 
     * 取得简历浏览数
     * @param $resume_id
     */
    public function getReadResumeCount($resume_id) {
    	$this->da->setModelName('read_resume');
        $where['resume_id']  = $resume_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->count();
    }

}
?>
