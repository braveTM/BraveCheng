<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResumeProvider
 *
 * @author JZG
 */
class ResumeProvider extends BaseProvider{
    //put your code here

    /**
     * 简历字段规则
     * @var <array>
     */
    public $resumeArgRule=array(
        'resume_id'=>array(
            'name'=>'简历ID',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'job_category'=>array(
            'name'=>'工作性质',
            'filter'=>VAR_JCATEGORY,
        ),
    );

    /**
     * 求职意向字段规则
     * @var <array>
     */
    public $jobIntentArgRule=array(
        'job_intent_id'=>array(
            'name'=>'求职意向ID',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'job_category'=>array(
            'name'=>'工作性质',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'job_province_code'=>array(
            'name'=>'工作地点省份ID',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'job_city_code'=>array(
            'name'=>'工作地点城市ID',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'job_name'=>array(
            'name'=>'职位名称',
            'length'=>128,
            'null'=>false
        ),
        'job_salary'=>array(
            'name'=>'期望待遇',
            'null'=>false
        ),
        'job_describle'=>array(
            'name'=>'职位描述',
            'length'=>1024
        )
    );

    /**
     * 挂证意向字段规则
     * @var <array>
     */
    public $hangCardIntentArgRule=array(
        'hang_card_intent_id'=>array(
            'name'=>'挂证意向ID',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'job_salary'=>array(
            'name'=>'期望薪资',
            'null'=>false
        ),
        'register_province_ids'=>array(
            'name'=>'期望注册地',
            'null'=>false
        ),
    );

    /**
     * 学历字段规则
     * @var <array>
     */
    public $degreeArgRule=array(
        'degree_id'=>array(
           'name'=>'学历名称',
           'filter'=>VAR_ID,
           'null'=>false
        ),
        'school'=>array(
            'name'=>'学校名称',
            'length'=>128,
            'null'=>false
        ),
        'study_startdate'=>array(
            'name'=>'开始日期',
            'check'=> VAR_DATE,
            'null'=>false
        ),
        'study_enddate'=>array(
            'name'=>'结束日期',
            'check'=>VAR_DATE,
            'null'=>false
        ),
        'major_name'=>array(
            'name'=>'专业名称',
            'length'=>128,
            'null'=>false
        ),
        'degree_name'=>array(
            'name'=>'学历名称',
            'length'=>128,
            'null'=>false
        )
    );

    /**
     * 工作经历字段规则
     * @var <array>
     */
    public $workExpArgRule=array(
        'work_exp_id'=>array(
            'name'=>'工作经历ID',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'department'=>array(
            'name'=>'部门',
            'length'=>128,
            'null'=>false
        ),
        'work_startdate'=>array(
            'name'=>'任职开始日期',
            'check'=>VAR_DATE,
            'null'=>false
        ),
        'work_enddate'=>array(
            'name'=>'任职结束日期',
            'check'=>VAR_DATE,
            'null'=>false
        ),
        'company_name'=>array(
            'name'=>'公司名称',
            'length'=>256,
            'null'=>false
        ),
        'company_industry'=>array(
            'name'=>'行业',
            'length'=>256,
            'null'=>false
        ),
        'company_scale'=>array(
            'name'=>'公司规模',
            'length'=>256,
            'null'=>false
        ),
        'company_property'=>array(
            'name'=>'公司性质',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'job_name'=>array(
            'name'=>'职位',
            'length'=>'128',
            'null'=>false
        ),
        'job_describle'=>array(
            'name'=>'工作描述',
            'length'=>'1024'
        )
    );

    /**
     * 工程业绩字段规则
     * @var <array>
     */
    public $projectAchievementArgRule=array(
        'project_achievement_id'=>array(
            'name'=>'工程业绩ID',
            'filter'=>VAR_ID,
            'null'=>false
        ),
        'name'=>array(
            'name'=>'项目名称',
            'length'=>128,
            'null'=>false
        ),
        'scale'=>array(
            'name'=>'规模大小',
            'length'=>128,
            'null'=>false
        ),
        'start_date'=>array(
            'name'=>'起始日期',
            'check'=>VAR_DATE,
            'null'=>false
        ),
        'end_date'=>array(
            'name'=>'结束日期',
            'check'=>VAR_DATE,
            'null'=>false
        ),
        'job_name'=>array(
            'name'=>'担任职务',
            'length'=>128,
            'null'=>false
        ),
        'job_describle'=>array(
            'name'=>'工作内容',
            'length'=>1024,
            'null'=>false
        )
    );
    
    /**
     * 添加求职意向
     * @param <array> $data 求职意向基本数据
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addJobIntent($data){
        if (is_null($data)){
            $data['is_del']=0;
        }
        $this->da->setModelName('job_intent');
        return $this->da->add($data);
    }

    /**
     * 添加挂证意向
     * @param <array> $data 挂证意向基本数据
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addHangCardIntent($data){
        if (is_null($data)){
            $data['is_del']=0;
        }
        $this->da->setModelName('hang_card_intent');
        return $this->da->add($data);
    }

    /**
     *添加学历
     * @param <type> $data 学历基本数据
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addDegree($data){
        $this->da->setModelName('degree');
        if (is_null($data)){
            $data['is_del']=0;
        }
        return $this->da->add($data);
    }
    
     /**
     * 添加简历
      * @param <int> $job_intent_id 求职意向ID
      * @param <int> $hang_card_intent_id 挂证意向ID
      * @param <int> $degree_id 学历ID
      * @param <array> $data 简历基本数据
      * @param int $id 简历编号
      * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addResume($job_intent_id,$hang_card_intent_id,$degree_id,$data,$id){
        $this->da->setModelName('resume');
        $data['resume_id']=$id;
        $data['job_intent_id']=$job_intent_id;
        $data['hang_card_intent_id']=$hang_card_intent_id;
        $data['degree_id']=$degree_id;
        $data['update_datetime']=date_f();
        $result = $this->da->add($data);
        if($result == false)
            return false;
        return $id;
    }

    /**
     * 获取求职意向
     * @param <int> $job_intent_id 求职意向ID
     * @return <mixed> 成功返回数组（一条记录）或null,失败返回false
     */
    public function getJobIntent($job_intent_id){
        $this->da->setModelName('job_intent');
        $where['job_intent_id'] = $job_intent_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取挂证意向
     * @param <int> $hang_card_intent_id 挂证意向ID
     * @return <mixed> 成功返回数组（一条记录）或null,失败返回false
     */
    public function getHCintent($hang_card_intent_id){
        $this->da->setModelName('hang_card_intent');
        $where['hang_card_intent_id'] = $hang_card_intent_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取学历
     * @param <type> $degree_id 学历ID
     * @return <mixed> 成功返回数组（一条记录）或null,失败返回false
     */
    public function getDegree($degree_id){
        $this->da->setModelName('degree');
        $where['degree_id'] = $degree_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 查询简历
     * @param <int> $id 简历ID
     * @return <mixed> 成功返回数组（一条记录）或null,失败返回falses
     */
    public function getResume($resume_id){
        $this->da->setModelName('resume');
        $where['resume_id'] = $resume_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取工作经历列表
     * @param <int> $resume_id 简历ID
     * @param <string> $order 排序
     * @return <mixed>成功返回数组或空数组，失败返回false
     */
    public function getWorkExpList($resume_id,$order){
        $this->da->setModelName('work_exp');
        $where['resume_id']=$resume_id;
        $where['is_del']    = 0;
        return $this->da->where($where)->order($order)->select();
    }

    /**
     * 获取工程业绩列表
     * @param <int> $resume_id 简历ID
     * @param <string> $order 排序
     * @return <mixed>成功返回数组或空数组，失败返回false
     */
    public function getProjectAchievementList($resume_id,$order){
        $this->da->setModelName('project_achievement');
        $where['resume_id']=$resume_id;
        $where['is_del']    = 0;
        return $this->da->where($where)->order($order)->select();
    }

    /**
     * 添加工作经历
     * @param <int> $resume_id 简历ID
     * @param <array> $data 工作经历基本数据
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addWorkExp($resume_id,$data){
        if (is_null($data)){
            $data['is_del']=0;
        }
        $data['resume_id']=$resume_id;
        $this->da->setModelName('work_exp');
        return $this->da->add($data);
    }

    /**
     * 添加工程业绩
     * @param <int> $resume_id 简历ID
     * @param <array> $data 工程业绩基本数据
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addProjectAchievement($resume_id,$data){
        if (is_null($data)){
            $data['is_del']=0;
        }
        $data['resume_id']=$resume_id;
        $this->da->setModelName('project_achievement');
        return $this->da->add($data);
    }

    /**
     * 删除工作经历
     * @param <int> $work_exp_id 工作经历ID
     * @return <bool> 成功返回true,失败返回false
     */
    public function deleteWorkExp($work_exp_id){
        $this->da->setModelName('work_exp');
        $where['work_exp_id']=$work_exp_id;
        return $this->da->where($where)->delete() !== false;
    }

    /**
     * 删除工程业绩
     * @param <int> $project_achievement_id 工程业绩ID
     * @return <bool> 成功返回true,失败返回false
     */
    public function deleteProjectAchievement($project_achievement_id){
        $this->da->setModelName('project_achievement');
        $where['project_achievement_id']=$project_achievement_id;
        return $this->da->where($where)->delete() !== false;
    }

    /**
     * 获取工作经历
     * @param  <int> $work_exp_id 工作经历ID
     * @return <mixed>
     */
    public function getWorkExp($work_exp_id){
        $this->da->setModelName('work_exp');
        $where['work_exp_id']=$work_exp_id;
        return $this->da->where($where)->find();
    }

    /**
     * 获取工程业绩
     * @param <int> $project_achievement_id 工程业绩ID
     * @return <mixed>
     */
    public function getProjectAchievement($project_achievement_id){
        $this->da->setModelName('project_achievement');
        $where['project_achievement_id']=$project_achievement_id;
        return $this->da->where($where)->find();
    }
    
    /**
     * 更新学历
     * @param <int> $degree_id 学历ID
     * @param <array> $data 学历基本信息
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateDegree($degree_id,$data){
        $this->da->setModelName('degree');
        $where['degree_id']      = $degree_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 更新求职意向
     * @param <int> $job_intent_id 求职意向ID
     * @param <array> $data 求职意向基本信息
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateJobIntent($job_intent_id,$data){
        $this->da->setModelName('job_intent');
        $where['job_intent_id']      = $job_intent_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 更新挂证意向
     * @param <int> $hang_card_intent_id 挂证意向ID
     * @param <array> $data 挂证意向基本信息
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateHangCardIntent($hang_card_intent_id,$data){
        $this->da->setModelName('hang_card_intent');
        $where['hang_card_intent_id']=$hang_card_intent_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 更新工作经历
     * @param <int> $work_exp_id 工作经历ID
     * @param <array> $data 工作经历基本信息
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateWorkExp($work_exp_id,$data){
        $this->da->setModelName('work_exp');
        $where['work_exp_id']      = $work_exp_id;
        return $this->da->where($where)->save($data) !== false;
    }
    /**
     * 更新工程业绩
     * @param <int> $PA_id 工程业绩ID
     * @param <array> $data 工程业绩基本信息
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateProjectAchievement($PA_id,$data){
        $this->da->setModelName('project_achievement');
        $where['project_achievement_id']      = $PA_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 更新简历
     * @param <int> $resume_id 简历ID
     * @param <array> $data 简历基本信息
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateResume($resume_id,$data){
        $this->da->setModelName('resume');
        $where['resume_id']      = $resume_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 查询简历列表
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <string> $order 排序方式
     */
    public function getResumeList($page,$size,$order){
        $this->da->setModelName('resume');          
        $where['is_del']    = 0;
        return $this->da->where($where)->order($order)->page($page.','.$size)->select();
    }

    /**
     * 获取指定职位的简历列表
     * @param int $user_id 发布者编号
     * @param int $job_id 职位编号
     * @param int $job_type 职位类型
     * @param int $role 投递者角色编号
     * @param string $from 起始时间
     * @param string $to 终止时间
     * @param int $page 第几页
     * @param int $size 每页几条
     * @param bool $count 是否统计总条数
     * @return mixed 
     */
    public function getJobResumeList($user_id, $job_id, $job_type, $role, $from, $to, $page, $size, $count = false){
        $table = C('DB_PREFIX').'send_resume'.' t1';
        if(!empty($from) && !empty($to))
            $where['t1.send_datetime'] = array('between', "'$from','$to'");
        else if(!empty($from)){
            $where['t1.send_datetime'] = array('gt', $from);
        }
        else if(!empty($to)){
            $where['t1.send_datetime'] = array('lt', $to);
        }
        if(!empty($role)){
            $where['t4.role_id'] = $role;
            $join[] = C('DB_PREFIX').'user t4 on t1.sender_id=t4.user_id';
        }
        $where['t1.job_id'] = $job_id;
        $where['t1.publisher_id'] = $user_id;
        $where['t1.is_del'] = 0;
        if($count){
            if(!empty($join))
                return $this->da->table($table)->join($join)->where($where)->count('job_id');
            return $this->da->table($table)->where($where)->count('job_id');
        }
        else{
            $order = 't1.send_datetime DESC';
           // $field = 't1.sender_id,t1.resume_id,t1.job_id,t1.send_datetime,t2.agent_id,t2.publisher_id,t4.photo,t4.name,t4.role_id,t5.name as h_name,t4.is_real_auth,t4.is_phone_auth,t4.is_email_auth,t5.human_id,t5.work_age';
            $field = 't1.send_resume_id,t1.sender_id,t1.resume_id,t1.job_id,t1.send_datetime,t1.job_category,t1.resume_data,t4.photo,t4.name,t4.role_id,t4.is_real_auth,t4.is_phone_auth,t4.is_email_auth';
           // $join[] = C('DB_PREFIX').'resume t2 on t1.resume_id=t2.resume_id';
            if(empty($join))
                $join[] = C('DB_PREFIX').'user t4 on t1.sender_id=t4.user_id';
           // $join[] = C('DB_PREFIX').'human t5 on t1.resume_id=t5.resume_id';
          //  if($job_type == 1){
          //      $join[] = C('DB_PREFIX').'job_intent t3 on t2.job_intent_id=t3.job_intent_id';
          //      $field.=',t3.job_salary';
         //   }
         //   else{
           //     $join[] = C('DB_PREFIX').'hang_card_intent t3 on t2.hang_card_intent_id=t3.hang_card_intent_id';
          //      $field.=',t3.job_salary,t3.register_province_ids';
         //   }
            return $this->da->table($table)->join($join)->where($where)->page($page.','.$size)->order($order)->field($field)->select();
        }
    }

    /**
     * 获取委托来的简历
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $count 为true则返回总记录数
     * @param <string> $order 排序
     * @param <int> $agent_id 代理人ID
     * @param <int> $delegate_state 委托状态（1-未公开，2-求职中,4-已终止委托，3-完成,5-未查看）
     * @param <int> $job_category 工作性质（1-全职，2-兼职）
     * @param <string> $from 起始时间
     * @param <string> $to 结束时间
     * @return <mixed> 
     */
   public function getDelegatedResume($page,$size,$count,$order,$agent_id,$delegate_state,$job_category, $from = null, $to = null){
       $table=C('DB_PREFIX').'delegate_resume delegate_resume';
       $where['delegate_resume.agent_id']=$agent_id;
       if (!empty ($delegate_state)){
           $where['delegate_resume.status']=$delegate_state;
       }
       if (!empty($job_category)){
           $where['delegate_resume.job_category']=$job_category;
       }
       if(!empty($from) && !empty($to)){
           $where['agent_date'] = array('between', "'$from','$to'");
       }
       else if(!empty($from)){
           $where['agent_date'] = array('gt', $from);
       }
       else if(!empty($to)){
           $where['agent_date'] = array('lt', $to);
       }
       if ($count){
           return $this->da->table($table)->where($where)->count('delegate_resume.id');
       }
       if (empty($order)){
           $order = 'delegate_resume.agent_date DESC';
       }
       return $this->da->table($table)->where($where)->page("$page,$size")->order($order)->select();
   }

   /**
    * 查询拥有的简历
    * @param <int> $owner
    * @param <array> $field
    * @param <int> $page
    * @param <int> $size
    * @param <bool> $count
    * @param string $order
    * @return <mixed>
    */
   public function getOwnResumeList($owner,$field,$page, $size, $count, $order) {
        $table = C('DB_PREFIX') . 'resume resume';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'human human on human.resume_id=resume.resume_id';
        $join[1] = 'inner join ' . C('DB_PREFIX') . 'job_intent job_intent on job_intent.job_intent_id=resume.job_intent_id';
        $join[2] = 'inner join ' . C('DB_PREFIX') . 'hang_card_intent hang_card_intent on hang_card_intent.hang_card_intent_id=resume.hang_card_intent_id';
        $join[3]=C('DB_PREFIX').'user user on user.data_id=human.human_id and user.is_del=0 and user.role_id='.C('ROLE_TALENTS');
        $where['resume.agent_id']=$owner;
        $where['resume.is_del']=0;
        $where['human.is_del']=0;
        $where['job_intent.is_del']=0;
        $where['hang_card_intent.is_del']=0;
        if ($count) {
            return $this->da->table($table)->where($where)->join($join)->count('resume.resume_id');
        }
        if (empty($order)) {
            $order = 'resume.delegate_datetime DESC';
        }
        return $this->da->table($table)->where($where)->join($join)->field($field)->page("$page,$size")->order($order)->select();
    }

    /**
     * 获取正在运作的简历
     * @param int $publisher_id 发布人编号
     * @param int $type 简历类型
     * @param int $page 第几页
     * @param int $size 每页几条
     * @param bool $count 是否统计总条数
     * @return mixed 
     */
    public function get_running_resumes($publisher_id, $type, $page, $size, $count = false){
        $this->da->setModelName('resume t1');
        $where['t1.publisher_id'] = $publisher_id;
        $where['t1.is_del'] = 0;
        if(!empty($type)){
            $where['t1.job_category'] = $type;
        }
        if($count){
            return $this->da->where($where)->count('publisher_id');
        }
        else{
            $join[] = 'INNER JOIN '.C('DB_PREFIX').'human t2 ON t2.resume_id=t1.resume_id';
            $join[] = 'INNER JOIN '.C('DB_PREFIX').'job_intent t3 on t3.job_intent_id=t1.job_intent_id';
            $join[] = 'INNER JOIN '.C('DB_PREFIX').'hang_card_intent t4 on t4.hang_card_intent_id=t1.hang_card_intent_id';
            $order = 'pub_datetime DESC';
            $field = 't2.human_id,t2.resume_id,t2.name,t1.job_category,t1.job_intent_id,t1.hang_card_intent_id,t1.pub_datetime,t3.job_province_code,t3.job_city_code,t3.job_salary as fsalary,t3.input_salary as fisalary,t3.job_name,t4.register_province_ids,t4.job_salary as psalary,t3.job_city_code,t3.job_salary as fsalary,t4.input_salary as pisalary';
            return $this->da->where($where)->join($join)->page($page.','.$size)->order($order)->field($field)->select();
        }
    }
    
   /**
    * 统计经纪人收到的简历邀请数
    * @param  <int>    $user_id 用户编号
    * @param  <string> $from    起始时间
    * @param  <string> $to      终止时间
    * @return <int>
    */
   public function count_agent_resume_invite($user_id, $from, $to){
       $this->da->setModelName('resume t1');            //使用简历表
       $where['t1.agent_id'] = $user_id;
       $where['t1.is_del']   = 0;
       $join[]='INNER JOIN '.C('DB_PREFIX').'invite_resume t2 on t2.resume_id=t1.resume_id';
       if(!empty($from) && !empty($to))
           $where['t2.invite_datetime'] = array('between', "'$from','$to'");
       else if(!empty($from))
           $where['t2.invite_datetime'] = array('gt', $from);
       else if(!empty($to))
           $where['t2.invite_datetime'] = array('lt', $to);
       $where['t2.is_del'] = 0;
       return $this->da->join($join)->where($where)->count('t2.resume_id');
   }

   /**
    * 统计简历收到的邀请数
    * @param  <int>    $resume_id 简历编号
    * @param  <string> $from      起始时间
    * @param  <string> $to        终止时间
    * @return <int>
    */
   public function count_resume_invite($resume_id, $from, $to){
       $this->da->setModelName('invite_resume');            //使用简历邀请表
       $where['resume_id'] = $resume_id;
       $where['is_del']    = 0;
       if(!empty($from) && !empty($to))
           $where['invite_datetime'] = array('between', "'$from','$to'");
       else if(!empty($from))
           $where['invite_datetime'] = array('gt', $from);
       else if(!empty($to))
           $where['invite_datetime'] = array('lt', $to);
       return $this->da->where($where)->count('resume_id');
   }

   /**
    * 统计用户收到的简历邀请数
    * @param  <int>    $user_id 用户编号
    * @param  <string> $from    起始时间
    * @param  <string> $to      终止时间
    * @return <int>
    */
   public function count_user_resume_invite($user_id, $from, $to){
       $this->da->setModelName('invite_resume');            //使用简历邀请表
       $where['user_id'] = $user_id;
       $where['is_del']    = 0;
       if(!empty($from) && !empty($to))
           $where['invite_datetime'] = array('between', "'$from','$to'");
       else if(!empty($from))
           $where['invite_datetime'] = array('gt', $from);
       else if(!empty($to))
           $where['invite_datetime'] = array('lt', $to);
       return $this->da->where($where)->count('user_id');
   }

   /**
    * 统计经纪人拥有的简历数量
    * @param  <int> $agent_id 经纪人编号
    * @return <int>
    */
   public function count_agent_resume($agent_id){
       $this->da->setModelName('resume');            //使用简历表
       $where['agent_id'] = $agent_id;
       $where['is_del']   = 0;
       return $this->da->where($where)->count('agent_id');
   }

   /**
    * 统计简历被查看数
    * @param  <int> $resume_id 简历编号
    * @return <int>
    */
   public function count_resume_read($resume_id){
       $this->da->setModelName('read_resume');            //使用简历查看表
       $where['resume_id'] = $resume_id;
       $where['is_del']    = 0;
       return $this->da->where($where)->count('resume_id');
   }
   
   public function getDelegatedResumeByR($register_case,$fields,$page,$size,$count,$order,$agent_id,$delegate_state,$job_category){

   }


   /**
    * 查询简历状态相关数据
    * @param <int> $resume_id 简历ID
    * @return <mixed>
    */
   public function getResumeStatus($resume_id){
       $table=C('DB_PREFIX').'resume resume';
       $join[0]='inner join '.C('DB_PREFIX').'human human on human.resume_id=resume.resume_id';
       $join[1]='inner join '.C('DB_PREFIX').'user user on user.data_id=human.human_id';
       $where['resume.resume_id']=$resume_id;
       $where['user.role_id']=C('ROLE_TALENTS');
       $field=array('user.user_id'=>'creator_id','resume.agent_id','resume.publisher_id');
       return $this->da->table($table)->join($join)->where($where)->field($field)->find();
   }

   public function getPrivateResumeStatus($resume_id){
       $table=C('DB_PREFIX').'resume resume';
       $join[0]='inner join '.C('DB_PREFIX').'human human on human.resume_id=resume.resume_id';
       $where['resume.resume_id']=$resume_id;
       $field=array('resume.agent_id','resume.publisher_id');
       return $this->da->table($table)->join($join)->where($where)->field($field)->find();
   }

   /**
    * 经纪人是否拥有指定简历
    * @param <int> $resume_id 简历ID
    * @return <bool>
    */
   public function isOwnResume($agent_id,$resume_id){
       $this->da->setModelName('resume');
       $where['agent_id']=$agent_id;
       $where['resume_id']=$resume_id;
       $where['is_del']=0;
       return $this->da->where($where)->count('resume_id')>0;
   }
   /**
    * 指定简历是否是指定经纪人添加的简历
    * @param <int> $creator_id 创建人ID
    * @param <int> $resume_id 简历ID
    * @return <bool>
    */
   public function isAddResume($creator_id,$resume_id){
        $table=C('DB_PREFIX').'resume resume';
        $join[0]='inner join '.C('DB_PREFIX').'human human on resume.resume_id=human.resume_id';
        $join[1]=C('DB_PREFIX').'user user on user.data_id=human.human_id and user.is_del=0';
        $where['resume.agent_id']=$creator_id;
        $where['resume.resume_id']=$resume_id;
        $where['user.data_id']=array('exp','is null');
        $where['resume.is_del']=0;
        $where['human.is_del']=0;
        return $this->da->table($table)->join($join)->where($where)->count('resume.resume_id') > 0;
   }

   /**
    * 指定简历是否是指定经纪人代理的简历
    * @param <int> $agent_id 经纪人ID
    * @param <int> $resume_id 简历ID
    * @return <bool>
    */
   public function isDelegatedResume($agent_id,$resume_id){
       $table=C("DB_PREFIX").'resume resume';
       $join[0]='inner join '.C('DB_PREFIX').'human human on human.resume_id= resume.resume_id';
       $join[1]='inner join '.C('DB_PREFIX').'user user on user.data_id=human.human_id';
       $where['user.role_id']=C('ROLE_TALENTS');
       $where['resume.agent_id']=$agent_id;
       $where['resume.resume_id']=$resume_id;
       $where['resume.is_del']=0;
       $where['human.is_del']=0;
       $where['user.is_del']=0;
       return $this->da->table($table)->join($join)->where($where)->count('resume.resume_id') > 0;
   }

   /**
    * 查看应聘来的简历
    * @param <int> $publisher_id 发布人ID
    * @param <int> $sent_status 投递状态（1为未查看，2为已查看）
    * @param <int> $job_category 工作性质(1为全职，2为兼职)
    * @param <int> $sender_role 投递人角色
    * @param <array> $field 查询字段数组
    * @param <int> $page 第几页
    * @param <int> $size 每页几条
    * @param <bool> $count 是否返回条数
    * @param <string> $order 排序
    * @return <mixed>
    */
   public function getSentResume($publisher_id,$sent_status,$job_category,$sender_role,$field,$page,$size,$count,$order){
       $table=C('DB_PREFIX').'send_resume send_resume';
       $join[0]='inner join '.C('DB_PREFIX').'job job on send_resume.job_id=job.job_id';
       $join[1]='inner join '.C('DB_PREFIX').'user sender on sender.user_id=send_resume.sender_id';

       $where['send_resume.is_del']=0;
       $where['job.is_del']=0;
       $where['sender.is_del']=0;
       $where['send_resume.publisher_id']=$publisher_id;
       $where['job.publisher_id']=$publisher_id;
       if (!empty($sent_status)){
           $where['send_resume.status']=$sent_status;
       }
       if (!empty($job_category)){
           $where['send_resume.job_category']=$job_category;
       }
       if (!empty($sender_role)){
           $where['sender.role_id']=$sender_role;
       }
       if ($count){
           return $this->da->table($table)->join($join)->where($where)->count('send_resume.send_resume_id');
       }
       if (empty($order)){
           $order='send_resume.send_datetime DESC';
       }
       return $this->da->table($table)->join($join)->field($field)->where($where)->page("$page,$size")->order($order)->select();
   }

   /**
    * 查询添加的简历
    * @param <int> $creator_id 创建人ID
    * @param <int> $delegate_status 委托状态（1-未公开，2-求职中）
    * @param <int> $job_category 工作性质（1-全职，2-兼职）
    * @param <array> $field 字段数组
    * @param <int> $page 第几页
    * @param <int> $size 每页几条
    * @param <int> $count 是否返回总条数
    * @param <string> $order 排序方式
    * @return <mixed>
    */
   public function getPrivateResumeList($creator_id,$delegate_status,$job_category,$field,$page,$size,$count,$order){
       $table=C('DB_PREFIX').'resume resume';
       $join[0]='inner join '.C('DB_PREFIX').'human human on resume.resume_id=human.resume_id';
       $join[1]='inner join '.C('DB_PREFIX').'job_intent job_intent on job_intent.job_intent_id=resume.job_intent_id';
       $join[2]='inner join '.C('DB_PREFIX').'hang_card_intent hang_card_intent on hang_card_intent.hang_card_intent_id=resume.hang_card_intent_id';
       $join[3]='left join '.C('DB_PREFIX').'user user on user.data_id=human.human_id and user.role_id=1';
       $where['resume.is_del']=0;
       $where['human.is_del']=0;
       $where['job_intent.is_del']=0;
       $where['hang_card_intent.is_del']=0;
       $where['user.data_id']=array('exp','is null');
       $where['resume.agent_id']=$creator_id;
       if (!empty($delegate_status)){
           if ($delegate_status == 1){
               $where['resume.publisher_id']=0;
              // $where['resume.job_category']=0;
           }else if($delegate_status == 2){
               $where['resume.publisher_id']=$creator_id;
               $where['resume.job_category']=array('neq',0);
           }
       }
       if (!empty($job_category)){
           $where['resume.job_category']=$job_category;
       }
       if ($count){
           return $this->da->table($table)->join($join)->where($where)->count('resume.resume_id');
       }
       if (empty($order)){
           $order='resume.delegate_datetime DESC';
       }
       return $this->da->table($table)->join($join)->where($where)->page("$page,$size")->field($field)->order($order)->select();
   }

   /**
    * 查询拥有的简历
    * @param <int> $owner_id 拥有者ID
    * @param <int> $page 第几页
    * @param <int> $size 每页条数
    * @param <bool> $count 是否返回总条数
    * @param string $order 排序
    * @return <mixed>
    */
   public function getOwnResume($owner_id,$page,$size,$count,$order){
       $table=C('DB_PREFIX').'resume resume';
       $join[0]='inner join '.C('DB_PREFIX').'human human on resume.resume_id=human.resume_id';
       $join[1]='inner join '.C('DB_PREFIX').'job_intent job_intent on job_intent.job_intent_id=resume.job_intent_id';
       $join[2]='inner join '.C('DB_PREFIX').'hang_card_intent hang_card_intent on hang_card_intent.hang_card_intent_id=resume.hang_card_intent_id';
       $where['resume.is_del']=0;
       $where['human.is_del']=0;
       $where['job_intent.is_del']=0;
       $where['hang_card_intent.is_del']=0;
       $where['resume.agent_id']=$owner;
       if ($count){
           return $this->da->table($table)->join($join)->where($where)->count('resume.resume_id');
       }
       if (empty($order)){
           $order='resume.delegate_datetime DESC';
       }
       return $this->da->table($table)->join($join)->where($where)->page("$page,$size")->field($field)->order($order)->select();
   }

   /**
    * 统计用户投递简历数
    * @param  <int> $user_id 用户编号
    * @param string $start 开始时间
    * @param string $end 结束时间
    * @return <int>
    */
   public function count_user_send_resume($user_id, $start, $end){
       $this->da->setModelName('send_resume');
       $where['sender_id'] = $user_id;
       $where['is_del']    = 0;
       if(!empty($start))
           $where['send_datetime'] = array('between', "'$start','$end'");
       return $this->da->where($where)->count('sender_id');
   }

   public function getPrivateResumeListByR($creator_id,$delegate_status,$job_category,$register_case,$field,$page,$size,$count,$order){
       
   }

   /**
    * 更新委托简历状态
    * @param <int> $agent_id 代理人ID
    * @param <int> $resume_id 简历ID
    * @param <array> $data 数据数组
    * @return <bool>
    */
   public function updateDelegateResumeStatus($agent_id,$resume_id,$data){
       $this->da->setModelName('delegate_resume');
       $where['agent_id']=$agent_id;
       $where['resume_id']=$resume_id;
       $where['is_del']=0;
       return $this->da->where($where)->save($data) !== false;
   }

   /**
    * 添加委托简历状态
    * @param <array> $data 数据数组
    * @return <mixed>
    */
   public function addDelegateResumeStatus($data){
       $this->da->setModelName('delegate_resume');
       if (is_null($data)){
           $data['is_del']=0;
       }
       return $this->da->add($data);
   }

   /**
    * 删除委托简历状态
    * @param <int> $agent_id 经纪人ID
    * @param <int> $resume_id 简历ID
    * @return <bool>
    */
   public function deleteDelegateResumeStatus($agent_id,$resume_id){
       $this->da->setModelName('delegate_resume');
       $where['agent_id']=$agent_id;
       $where['resume_id']=$resume_id;
       $where['is_del']=0;
       return $this->da->where($where)->delete() !==false;
   }

   /**
    * 查询委托简历状态
    * @param <int> $agent_id 经纪人ID
    * @param <int> $resume_id 简历ID
    */
   public function getDelegateResumeStatus($agent_id,$resume_id){
       $this->da->setModelName('delegate_resume');
       $where['agent_id']=$agent_id;
       $where['resume_id']=$resume_id;
       $where['is_del']=0;
       return $this->da->where($where)->find();
   }

   /**
    * 获取正在委托的简历记录
    * @param  <int> $resume_id 简历编号
    * @return <mixed>
    */
   public function get_using_delegate_resume($resume_id){
       $this->da->setModelName('delegate_resume');
       $where['resume_id'] = $resume_id;
       $where['status'] = array('in', '1,2,5');
       $where['is_del'] = 0;
       return $this->da->where($where)->find();
   }

   /**
    * 更新委托的简历记录
    * @param  <int>   $id   编号
    * @param  <array> $data 数据
    * @return <mixed>
    */
   public function update_delegate_resume($id, $data){
       $this->da->setModelName('delegate_resume');
       $where['id'] = $id;
       $where['is_del'] = 0;
       return $this->da->where($where)->save($data);
   }
   
   /**
    * 获取查看过的简历
    * @param int $user_id 用户编号
    * @param int $page 第几页
    * @param int $size 每页几条
    * @param bool $count 是否统计总条数
    * @return mixed 
    */
   public function get_read_resume($user_id, $page, $size, $count){
       $this->da->setModelName('read_resume t1');
       $where['t1.reader_id'] = $user_id;
       $join[] = 'INNER JOIN '.C('DB_PREFIX').'resume t2 ON t2.resume_id=t1.resume_id';
       $where['t2.publisher_id'] = array('gt', 0);
       $where['t1.is_del'] = 0;
       if($count){
           return $this->da->join($join)->where($where)->count('t1.reader_id');
       }
       $join[] = 'INNER JOIN '.C('DB_PREFIX').'user t3 ON t3.user_id=t2.publisher_id';
       $join[] = 'INNER JOIN '.C('DB_PREFIX').'job_intent t4 ON t4.job_intent_id=t2.job_intent_id';
       $join[] = 'INNER JOIN '.C('DB_PREFIX').'hang_card_intent t5 ON t5.hang_card_intent_id=t2.hang_card_intent_id';
       $join[] = 'INNER JOIN '.C('DB_PREFIX').'human t6 ON t6.resume_id=t2.resume_id';
       $where['t3.is_del'] = 0; 
       $order = 't1.read_datetime DESC';
       $field='t1.read_datetime,t1.resume_id,t2.agent_id,t2.publisher_id,t2.job_category,t3.user_id,t3.name,t3.photo,t3.role_id,t3.is_real_auth,t3.is_phone_auth,t3.is_email_auth,t4.job_province_code,t4.job_city_code,t4.job_name,t4.job_salary as fsalary,t5.register_province_ids,t5.job_salary as psalary,t6.human_id,t6.name as h_name,t6.work_age';
       return $this->da->where($where)->join($join)->order($order)->page($page.','.$size)->field($field)->select();
   }
    
    /**
     * 是否存在投递简历关系
     * @param int $sender_id 投递人编号
     * @param type $pub_id 发布职位人编号
     * @return bool
     */
    public function exists_send_resume($sender_id, $pub_id){
        $this->da->setModelName('send_resume');
        $where['sender_id'] = $sender_id;
        $where['publisher_id'] = $pub_id;
        return $this->da->where($where)->count('publisher_id') > 0;
    }
    
    /**
     * 是否存在投递简历关系
     * @param int $resume_id 简历编号
     * @param type $pub_id 发布职位人编号
     * @return bool
     */
    public function exists_send_resume_with_resume($resume_id, $pub_id){
        $this->da->setModelName('send_resume');
        $where['resume_id'] = $resume_id;
        $where['publisher_id'] = $pub_id;
        return $this->da->where($where)->count('publisher_id') > 0;
    }
    
    /**
     * 是否存在委托简历关系
     * @param int $resume_id 简历编号
     * @param type $agent_id 委托人编号
     * @return bool
     */
    public function exists_delegate_resume_with_resume($resume_id, $agent_id){
        $this->da->setModelName('delegate_resume');
        $where['resume_id'] = $resume_id;
        $where['agent_id'] = $agent_id;
        return $this->da->where($where)->count('agent_id') > 0;
    }
    
    /**
     * 统计用户查看简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_user_read_resume($user_id, $start, $end){
        $this->da->setModelName('read_resume');
        $where['reader_id'] = $user_id;
        $where['read_datetime'] = array('between', "'$start','$end'");
        return $this->da->where($where)->count('reader_id');
    }
    
    /**
     * 统计用户公开的简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int 
     */
    public function count_user_open_resume($user_id, $start, $end){
        $this->da->setModelName('resume');
        $where['publisher_id'] = $user_id;
        $where['pub_datetime'] = array('between', "'$start','$end'");
        $where['is_del'] = 0;
        return $this->da->where($where)->count('publisher_id');
    }
    
    /**
     * 统计用户收到的应聘简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_employ_resume($user_id, $start, $end){
        $this->da->setModelName('send_resume');
        $where['publisher_id'] = $user_id;
        $where['send_datetime'] = array('between', "'$start','$end'");
        $where['is_del'] = 0;
        return $this->da->where($where)->count('publisher_id');
    }
    
    /**
     * 是否存在指定投递记录
     * @param int $sender_id 投递人编号
     * @param int $resume_id 简历编号
     * @param int $job_id 投递职位编号
     * @return bool 
     */
    public function exists_send_record($sender_id, $resume_id, $job_id){
        $this->da->setModelName('send_resume');
        $where['sender_id'] = $sender_id;
        $where['resume_id'] = $resume_id;
        $where['job_id'] = $job_id;
        return $this->da->where($where)->count('job_id') > 0;
    }
    
    /**
     * 是否存在指定邀请记录
     * @param int $invitor_id 邀请人编号
     * @param int $resume_id 简历编号
     * @param int $user_id 持有简历者编号
     * @return bool 
     */
    public function exists_invite_record($invitor_id, $resume_id, $user_id){
        $this->da->setModelName('invite_resume');
        $where['invitor_id'] = $invitor_id;
        $where['resume_id'] = $resume_id;
        $where['user_id'] = $user_id;
        return $this->da->where($where)->count('job_id') > 0;
    }

	/**
     * 统计新增简历数
     * @param date $start_datetime 起始时间范围 
     */
    public function count_new_resume($start_datetime){
        $this->da->setModelName('resume');
        $where['publiser_id']=array('gt',0);
        $where['update_datetime']=array('gt',$start_datetime);
        return $this->da->where($where)->count('resume_id');
    }
}
?>
