<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JobProvider
 *
 * @author JZG
 */
class JobProvider extends BaseProvider {

    /**
     * 职位字段规则
     * @var <array>
     */
    public $jobArgRule = array(
        'job_id' => array(
            'name' => '职位编号',
            'check' => VAR_ID,
            'null' => false
        ),
        'creator_id' => array(
            'name' => '创建人编号',
            'check' => VAR_ID,
            'null' => false
        ),
        'agent_id' => array(
            'name' => '代理人编号',
            'check' => VAR_ID,
            'null' => false
        ),
        'publisher_id' => array(
            'name' => '发布人编号',
            'check' => VAR_ID,
            'null' => false
        ),
        'publisher_role' => array(
            'name' => '发布者角色',
            'check' => VAR_ROLEID,
            'null' => false
        ),
        'title' => array(
            'name' => '职位标题',
            'length' => 128,
            'null' => false
        ),
        'company_name' => array(
            'name' => '招聘企业名称',
            'length' => 128,
            'null' => false
        ),
        'job_type' => array(
            'name' => '求职类型',
            'filter' => VAR_JOB_TYPE,
        ),
        'company_qualification' => array(
            'name' => '企业资质',
            'length' => 128,
            'null' => true
        ),
        'company_category' => array(
            'name' => '企业性质',
            'filter' => VAR_COMPANY_CATEGORY,
        ),
        'company_regtime' => array(
            'name' => '企业成立时间',
            'check' => VAR_DATE,
            'null' => true
        ),
        'company_scale' => array(
            'name' => '企业规模',
            'filter' => VAR_COMPANY_SCALE,
        ),
        'company_introduce' => array(
            'name' => '企业简介',
            'length' => 1024,
        ),
        'job_state' => array(
            'name' => '工作状态',
            'filter' => VAR_JSTATE,
        ),
        'job_salary' => array(
            'name' => '薪资',
            'filter' => VAR_SALARY,
        ),
        'job_name' => array(
            'name' => '职位名称',
            'length' => 128,
            'null' => false
        ),
        'job_describle' => array(
            'name' => '职位描述',
            'length' => 1024
        ),
        'degree' => array(
            'name' => '学历',
            'length' => 16,
        ),
        'job_exp' => array(
            'name' => '工作经验',
            'filter' => VAR_JEXP,
        ),
        'count' => array(
            'name' => '招聘人数',
            'filter' => VAR_JCOUNT,
        ),
        'social_security' => array(
            'name' => '社保要求',
            'filter' => VAR_JSOCIAL,
        ),
        'safety_b_card' => array(
            'name' => '安全B证要求',
            'filter' => VAR_BOOL,
        ),
        'muti_certificate' => array(
            'name' => '允许多证情况',
            'filter' => VAR_BOOL,
        )
    );

    /**
     * 添加职位
     * @param <int> $creator_id 创建人ID
     * @param <array> $data 职位基本信息
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addJob($creator_id, $data) {
        $this->da->setModelName('job');
        $date = date_f();
        $data['creator_id'] = $creator_id;
        $data['create_datetime'] = $date;
        $data['pub_datetime'] = $date;
        $data['delegate_datetime'] = $date;
        $data['update_datetime'] = $date;
        $data['is_del'] = 0;
        $data['agent_id'] = 0;
        $data['publisher_id'] = 0;
        $result = $this->da->add($data);
        if ($result == false)
            return false;
        return $data['job_id'];
    }

    /**
     * 添加职位证书信息
     * @param <int> $job_id 职位ID
     * @param <array> $data 职位证书信息
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addJobCertificate($job_id, $data) {
        $this->da->setModelName('job_certificate');
        $data['job_id'] = $job_id;
        $data['is_del'] = 0;
        return $this->da->add($data);
    }

    /**
     * 更新职位
     * @param <int> $job_id 职位ID
     * @param <array> $data 职位基本信息
     *  @return <bool> 成功返回true,失败返回false
     */
    public function updateJob($job_id, $data) {
        $this->da->setModelName('job');
        $where['job_id'] = $job_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 删除职位
     * @param <int> $job_id 职位ID
     * @return <bool> 成功返回true,失败返回false
     */
    public function deleteJob($job_id) {
        $this->da->setModelName('job');
        return $this->da->delete($job_id) !== false;
    }

    /**
     * 查询职位
     * @param <int> $job_id 职位ID
     * @return <mixed> 成功返回数组（一条记录）或null,失败返回false
     */
    public function getJob($job_id) {
        $this->da->setModelName('job');
        $where['job_id'] = $job_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 查询职位列表
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <string> $order 排序方式
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getJobList($page, $size, $order) {
        $this->da->setModelName('job');
        $where['is_del'] = 0;
        return $this->da->where($where)->order($order)->page($page . ',' . $size)->select();
    }

    /**
     * 获取指定用户发布的职位列表
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $type    工作性质
     * @param  <int>  $status  职位状态
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function get_pub_jobs($user_id, $type, $status, $page, $size, $count = false) {
        $this->da->setModelName('job');
        $where['creator_id'] = $user_id;
        $where['agent_id'] = 0;
        if (!empty($type))
            $where['job_category'] = $type;
        if (!empty($status))
            $where['status'] = $status;
        else
            $where['status'] = array('gt', 1);
        $where['is_del'] = 0;
        if ($count) {
            return $this->da->where($where)->count('publisher_id');
        } else {
            $order = 'pub_datetime DESC';
            $field = 'job_id,title,company_name,job_category,job_salary,input_salary,job_name,degree,count,job_province_code,job_city_code,require_place,status,pub_datetime as date';
            return $this->da->where($where)->page($page . ',' . $size)->order($order)->field($field)->select();
        }
    }

    /**
     * 获取指定用户委托的职位列表
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $type    工作性质
     * @param  <int>  $status  职位状态
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function get_agent_jobs($user_id, $type, $status, $page, $size, $count = false) {
        $this->da->setModelName('job t1');
        $where['creator_id'] = $user_id;
        $where['agent_id'] = array('gt', 0);
        if (!empty($type))
            $where['job_category'] = $type;
        if (!empty($status)) {
            if ($status == 1)
                $where['status'] = array('neq', 3);
            else
                $where['status'] = 3;
        }
        $where['t1.is_del'] = 0;
        if ($count) {
            return $this->da->where($where)->count('creator_id');
        } else {
            $order = 'delegate_datetime DESC';
            $field = 'job_id,agent_id,title,company_name,job_category,job_salary,input_salary,job_name,degree,count,job_province_code,job_city_code,require_place,delegate_datetime as date,t1.status,t2.name as agent_name';
            return $this->da->join(C('DB_PREFIX') . 'user t2 ON t1.agent_id=t2.user_id')->where($where)->page($page . ',' . $size)->order($order)->field($field)->select();
        }
    }

    /**
     * 获取应聘过的职位
     * @param <int>  $sender_id 投递人ID
     * @param <int> $role_id 投递人角色
     * @param <int> $job_category 工作性质（1为全职，2为兼职）
     * @param <int> $publisher_role 发布人角色
     * @param <int> $count 为true时返回总记录数
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <string> $order 排序
     * @param <int> $resume_id 简历ID
     * @return <mixed>
     */
    public function getSentJob($sender_id, $role_id, $job_category, $publisher_role, $count, $page, $size, $order, $resume_id) {
        $field = array(
            'job.job_id', 'job.job_category', 'job.company_name', 'job.title',
            'publisher.is_email_auth', 'publisher.is_phone_auth', 'publisher.is_real_auth',
            'job.publisher_id', 'job.publisher_role', 'publisher.name', 'publisher.photo', 'job.degree', 'job.job_city_code',
            'job.count', 'job.job_name', 'job.job_province_code', 'job.require_place', 'job.job_salary', 'job.salary_unit',
            't1.send_datetime', 'job.input_salary'
        );
        $table = C('DB_PREFIX') . 'send_resume t1';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'user publisher on t1.publisher_id=publisher.user_id';
        $join[1] = 'inner join ' . C('DB_PREFIX') . 'job job on t1.job_id=job.job_id';
        $where['t1.sender_id'] = $sender_id;
        if (!empty($resume_id)) {
            $where['t1.resume_id'] = $resume_id;
        }

        if (!empty($job_category)) {
            $where['job.job_category'] = $job_category;
        }
        if (!empty($publisher_role)) {
            $where['publisher.role_id'] = $publisher_role;
        }
        if ($count) {
            return $this->da->table($table)->join($join)->where($where)->field($field)->count('t1.send_resume_id');
        }
        if (empty($order))
            $order = 't1.send_datetime DESC';
        return $this->da->table($table)->join($join)->where($where)->field($field)->page("$page,$size")->order($order)->select();
    }

    /**
     * 获取指定用户收到的委托职位列表
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $type    工作性质
     * @param  <int>  $status  职位状态
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function get_agented_jobs($user_id, $type, $status, $page, $size, $count = false) {
        $this->da->setModelName('delegate_job t1');
        $where['t1.agent_id'] = $user_id;
        $where['t1.is_del'] = 0;
        if (!empty($status)) {
            $where['t1.status'] = $status;
        }
        $join[] = 'INNER JOIN ' . C('DB_PREFIX') . 'job t2 ON t2.job_id=t1.job_id';
        $where['t2.is_del'] = 0;
        if (!empty($type)) {
            $where['t2.job_category'] = $type;
        }
        if ($count) {
            return $this->da->join($join)->where($where)->count('t1.agent_id');
        } else {
            $join[] = C('DB_PREFIX') . 'user t3 ON t3.user_id=t2.creator_id';
            $order = 't2.delegate_datetime DESC';
            $field = 't2.job_id,t2.creator_id,t2.agent_id,t2.title,t2.company_name,t2.job_category,t2.job_salary,t2.input_salary,t2.job_name,t2.degree,t2.count,t2.job_province_code,t2.job_city_code,t2.require_place,t2.delegate_datetime as date,t1.status,t3.user_id,t3.photo,t3.name,t3.is_real_auth,t3.is_phone_auth,t3.is_email_auth';
            return $this->da->join($join)->where($where)->page($page . ',' . $size)->order($order)->field($field)->select();
        }
//        $this->da->setModelName('job t1');
//        $where['agent_id'] = $user_id;
//        if(!empty($type))
//            $where['job_category'] = $type;
//        if(!empty($status)){
//            $where['status'] = $status;
//        }
//        $where['t1.is_del'] = 0;
//        if($count){
//            return $this->da->where($where)->count('creator_id');
//        }
//        else{
//            $order = 'delegate_datetime DESC';
//            $field = 'job_id,creator_id,agent_id,title,company_name,job_category,job_salary,job_name,degree,count,job_province_code,job_city_code,require_place,delegate_datetime as date,t1.status,t2.user_id,t2.photo,t2.name,t2.is_real_auth,t2.is_phone_auth,t2.is_email_auth';
//            return $this->da->join(C('DB_PREFIX').'user t2 ON t1.creator_id=t2.user_id')->where($where)->page($page.','.$size)->order($order)->field($field)->select();
//        }
    }

    /**
     * 统计指定经纪人代理的职位数量
     * @param  <int>    $agent_id 代理编号
     * @param  <string> $from     起始时间
     * @return <int>
     */
    public function count_agent_job($agent_id, $from) {
        $this->da->setModelName('job');
        $where['agent_id'] = $agent_id;
        if (!empty($from))
            $where['delegate_datetime'] = array('gt', $from);
        return $this->da->where($where)->count('agent_id');
    }

    /**
     * 获取职位列表
     * @param  <int>    $page  第几页
     * @param  <int>    $size  每页几条
     * @param  <string> $order 排序方式
     * @param  <bool>   $count 是否统计总条数
     * @return <mixed>
     */
    public function get_job_list($page, $size, $order = null, $count = false) {
        $this->da->setModelName('job t1');
        $join[] = 'INNER JOIN ' . C('DB_PREFIX') . 'user t2 ON t2.user_id=t1.publisher_id';
        $where['t1.status'] = 2;
        $where['t1.is_del'] = 0;
        $where['t2.is_del'] = 0;
        $where['t2.is_freeze'] = 0;
        $where['t2.is_activate'] = 1;
        $where['t2.email_activate'] = 1;
        if ($count) {
            return $this->da->join($join)->where($where)->count('t1.job_id');
        }
        if (empty($order))
            $order = 't1.pub_datetime DESC';
        $field = 't1.job_id,t1.publisher_role,t1.company_name,t1.title as job_title,t1.job_category,t1.job_province_code,
                  t1.job_city_code,t1.job_salary,t1.job_name,t1.degree,t1.job_exp,t1.count,t1.require_place,
                  t1.pub_datetime,t2.user_id,t2.name,t2.photo,t2.role_id,t2.is_real_auth,t2.is_phone_auth,t2.is_email_auth';
        return $this->da->join($join)->where($where)->field($field)->page("$page,$size")->order($order)->select();
    }

    /**
     * 获取正在运作的职位
     * @param int $publisher_id 发布人编号
     * @param int $type 职位类型
     * @param int $page 第几页
     * @param int $size 每页几条
     * @param bool $count 是否统计总条数
     * @return mixed 
     */
    public function get_running_jobs($publisher_id, $type, $page, $size, $count = false) {
        $this->da->setModelName('job');
        $where['publisher_id'] = $publisher_id;
        if (!empty($type)) {
            $where['job_category'] = $type;
        }
        if ($count) {
            return $this->da->where($where)->count('publisher_id');
        } else {
            $order = 'pub_datetime DESC';
            $field = 'creator_id,job_id,company_name,title,job_category,job_province_code,job_city_code,job_salary,input_salary,grade_certificate_id,grade_certificate_class,job_name,job_exp,job_exp,count,require_place,status,pub_datetime as date';
            return $this->da->where($where)->page($page . ',' . $size)->order($order)->field($field)->select();
        }
    }

    /**
     * 统计收到的简历投递数
     * @param  <int>    $user_id 用户编号
     * @param  <string> $from    起始日期
     * @param  <string> $to      终止日期
     * @return <int>
     */
    public function count_resume_send_by_user($user_id, $from, $to) {
        $this->da->setModelName('send_resume');            //使用职位表
        $where['publisher_id'] = $user_id;
        $where['is_del'] = 0;
        if (!empty($from) && !empty($to))
            $where['send_datetime'] = array('between', "'$from','$to'");
        else if (!empty($from))
            $where['send_datetime'] = array('gt', $from);
        else if (!empty($to))
            $where['send_datetime'] = array('lt', $to);
        return $this->da->where($where)->count('publisher_id');
    }

    /**
     * 添加委托职位记录
     * @param  <int>    $agent_id 经纪人编号
     * @param  <int>    $job_id   职位编号
     * @param  <string> $date     委托日期
     * @return <bool> 是否成功
     */
    public function add_delegate_job($agent_id, $job_id, $date) {
        $this->da->setModelName('delegate_job');
        $data['agent_id'] = $agent_id;
        $data['job_id'] = $job_id;
        $data['status'] = 5;
        $data['agent_date'] = $date;
        $data['finish_date'] = $date;
        $data['end_agent_date'] = $date;
        $data['is_del'] = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 更新委托职位记录
     * @param  <int>   $id   编号
     * @param  <array> $data 数据
     * @return <bool> 是否成功
     */
    public function update_delegate_job($id, $data) {
        $this->da->setModelName('delegate_job');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->save($data);
    }

    /**
     * 获取正在使用委托职位记录
     * @param  <int> $job_id 职位编号
     * @return <mixed>
     */
    public function get_using_delegate_job($job_id) {
        $this->da->setModelName('delegate_job');
        $where['job_id'] = $job_id;
        $where['status'] = array('in', '1,2,5,6');
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取投递过的企业
     * @param int $user_id 用户编号
     * @param int $page    第几页
     * @param int $size    每页几条
     * @param int $count   是否统计总条数
     * @return mixed
     */
    public function get_send_company($user_id, $page, $size, $count) {
        $this->da->setModelName('user t1');
        $where['t1.role_id'] = C('ROLE_ENTERPRISE');
        $where['t1.is_del'] = 0;
        $join[] = 'INNER JOIN ' . C('DB_PREFIX') . 'send_resume t2 ON t2.publisher_id=t1.user_id';
        $where['t2.sender_id'] = $user_id;
        $where['t2.is_del'] = 0;
        if ($count) {
            return $this->da->join($join)->where($where)->count('t2.sender_id');
        } else {
            $order = 't2.send_datetime DESC';
            $field = 't1.user_id,t1.photo,t1.name';
            return $this->da->join($join)->where($where)->page($page . ',' . $size)->order($order)->field($field)->select();
        }
    }

    /**
     * 获取职位列表
     * @param int $parent_id 父类别编号
     * @return array 
     */
    public function get_positions($parent_id) {
        $this->da->setModelName('job_position');
        $where['parent_id'] = $parent_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->select();
    }

    /**
     * 获取职位信息
     * @param int $id 编号
     * @return mixed 
     */
    public function get_position($id) {
        $this->da->setModelName('job_position');
        $where['id'] = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 获取求职意向匹配职位列表
     * @param int $user_id 匹配用户编号
     * @param array $position_array 求职岗位数组
     * @param int $job_salary 期望薪资
     * @param int $job_province_code 期望注册省份
     * @param int $job_city_code 期望注册城市
     * @param int $type 发布者角色
     * @param int $page 第几页
     * @param int $size 每页几条
     * @param bool $count 是否统计总条数
     * @return mixed 
     */
    public function get_intent_jobs($user_id, $position_array, $job_salary, $job_province_code, $job_city_code, $type, $page, $size, $count) {
        $this->da->setModelName('job');
        if (count($position_array) == 1) {
            $job_where = ' AND job_name = ' . $position_array[0];
        } else {
            $job_in = implode(',', $position_array);
            $job_where = ' AND job_name in (' . $job_in . ')';
        }
        if ($type > 0) {
            $role_where = ' AND publisher_role = ' . $type;
        }
        $where = "job_salary >= $job_salary AND publisher_id != $user_id AND publisher_id > 0 AND job_category = 1 AND is_del = 0 AND job_province_code = $job_province_code" . $job_where . $role_where;
        if ($count) {
            return $this->da->where($where)->count('job_id');
        }
        $order = 'pub_datetime DESC';
        $field = 'job_id,agent_id,publisher_id,publisher_role,title as job_title,company_name,title,job_category,job_state,job_province_code,job_city_code,job_salary,grade_certificate_id,grade_certificate_class,job_name,degree,job_exp,count,pub_datetime';
        return $this->da->where($where)->order($order)->field($field)->page($page . ',' . $size)->select();
    }

    /**
     * 是否存在委托职位关系
     * @param int $job_id 职位编号
     * @param int $agent_id 委托人编号
     * @return bool
     */
    public function exists_delegate_job($job_id, $agent_id) {
        $this->da->setModelName('delegate_job');
        $where['agent_id'] = $agent_id;
        $where['job_id'] = $job_id;
        return $this->da->where($where)->count('agent_id') > 0;
    }

    /**
     * 统计用户公开的职位数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_open_jobs($user_id, $start, $end) {
        $this->da->setModelName('job');
        $where['publisher_id'] = $user_id;
        $where['pub_datetime'] = array('between', "'$start','$end'");
        $where['is_del'] = 0;
        return $this->da->where($where)->count('publisher_id');
    }

    /**
     * 统计用户代理的职位数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function count_user_delegate_jobs($user_id, $start, $end) {
        $this->da->setModelName('job');
        $where['agent_id'] = $user_id;
        $where['delegate_datetime'] = array('between', "'$start','$end'");
        $where['is_del'] = 0;
        return $this->da->where($where)->count('agent_id');
    }

    /**
     * 获取浏览过的职位
     * @param int $reader_id 浏览者编号
     * @param int $page       第几页
     * @param int $size       每页条数
     * @param bool $count     是否返回总条数
     * @return mixed 
     */
    public function getReadJob($reader_id, $page, $size, $count) {
        $table = C('DB_PREFIX') . "read_job read_job";
        $join = array();
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'job job on read_job.job_id=job.job_id';
        $where = array();
        $where['read_job.is_del'] = 0;
        $where['read_job.reader_id'] = $reader_id;
        $where['job.is_del'] = 0;
        if ($count) {
            return $this->da->table($table)->join($join)->where($where)->count();
        }
        $field = "job.job_id,job.title";
        return $this->da->table($table)->join($join)->where($where)->page("$page,$size")->field($field)->order('read_job.read_datetime desc')->select();
    }

    /**
     * 添加职位索引
     * @param array $data 职位索引数据
     * @return mixed 
     */
    public function addJobIndex($data) {
        $this->da->setModelName('job_index');
        return $this->da->add($data);
    }

    /**
     * 删除职位索引
     * @param int $job_id 职位ID
     * @return bool 
     */
    public function deleteJobIndex($job_id) {
        $this->da->setModelName('job_index');
        $where['job_id'] = $job_id;
        return $this->da->where($where)->delete() !== false;
    }

    /**
     * 更新职位索引
     * @param int $job_id 职位ID
     * @param array $data 职位索引数据
     * @return bool 
     */
    public function updateJobIndex($job_id, $data) {
        $this->da->setModelName('job_index');
        $where['job_id'] = $job_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 获取发布的职位ID
     * @param int $page 第几页
     * @param int $size 每页几条
     * @return array 
     */
    public function getPubJobList($page, $size) {
        $this->da->setModelName('job');
        $where['publisher_id'] = array('gt', 0);
        $where['is_del'] = 0;
        return $this->da->where($where)->page("$page,$size")->select();
    }

    /**
     * 职位浏览数
     * @param int $job_id 职位ID
     * @return int 
     */
    public function countJobRead($job_id) {
        $this->da->setModelName('read_job');
        $where['job_id'] = "'--" . $job_id . "--'";
        $where['is_del'] = 0;
//        $this->da->execute("SELECT * FROM `zx_job_index` WHERE id='" .addslashes("' ; delete from zx_job_index where '1'='1")."'");
        return $this->da->where($where)->count('read_job_id');
    }

    /**
     * 搜索职位
     * @param int $require_place
     * @param int $salary
     * @param int $pub_date
     * @param int $cert_type
     * @param string $word
     * @param int $page
     * @param int $size
     * @param int $count
     * @param int $order
     */
    private function getJobIndexIdList($require_place, $salary, $pub_date, $cert_type, $word, $order) {
        //防止危险字符
        $word = addslashes($word);

        $sql = "SELECT DISTINCT job_id FROM zx_job_index ";

        //条件
        if (!empty($require_place)) {
            $where['require_place'] = $require_place;
        }
        if (!empty($salary)) {
            $where['salary'] = $salary;
        }
        if (!empty($pub_date)) {
            $where['pub_date'] = array('gt', pubDateConvert($pub_date));
        }
        if (!empty($cert_type) && $cert_type == 1) {
            $where['cert_type'] = $cert_type;
        }

        //解析where
        if (!empty($where)) {
            $sql.=' where ';
            $first = true;
            foreach ($where as $key => $value) {
                if ($first) {
                    $first = false;
                } else {
                    $sql.=' and ';
                }
                if (is_array($value)) {
                    if ($value[0] == 'gt') {
                        $sql.=$key . ">'" . $value[1] . "'";
                    }
                } else {
                    $sql.=$key . "='" . $value . "' ";
                }
            }
        }
        //全文搜索
        if (!empty($word)) {
            if (empty($where)) {
                $sql.=' where ';
            } else {
                $sql.=' and ';
            }
            $sql.=" MATCH(word) AGAINST('" . $word . "')";
        }

        //排序
        if (!empty($order)) {
            $sql.=' order by ';
            switch ($order) {
                case 1:
                    $sql.=' read_count DESC';
                    break;
                case 2:
                    $sql.=' salary_sort DESC';
                    break;
                case 3:
                    $sql.=' salary_sort ASC';
                    break;
                case 4:
                    $sql.=' pub_date DESC';
                    break;
                case 5:
                    $sql.=' pub_date ASC';
            }
        } else {
            //关键字为空时，默认按发布时间降序
            if (empty($word)) {
                $sql.=' order by pub_date DESC';
            }
        }

        $result = $this->da->query($sql);
        return $result;
    }

    /**
     * 获取职位信息
     * @param type $field
     * @param type $job_id
     * @param type $job_category
     * @param type $publisher_role
     * @return type 
     */
    private function getJobInfo($field, $job_id, $job_category, $publisher_role, $is_real_auth) {
        $table = C('DB_PREFIX') . 'job job';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'user publisher on job.publisher_id=publisher.user_id';
        $where['job.job_id'] = $job_id;
        if (!empty($job_category)) {
            $where['job.job_category'] = $job_category;
        }
        if (!empty($publisher_role)) {
            $where['job.publisher_role'] = $publisher_role;
        }
        $where['publisher.is_freeze'] = 0;

        $where['publisher.email_activate'] = 1;
        $where['publisher.is_del'] = 0;
        if (!empty($is_real_auth) && $is_real_auth==1) {
            $where['publisher.is_real_auth'] = 1;
            $where['publisher.is_activate'] = 1;
        }

        return $this->da->table($table)->join($join)->where($where)->field($field)->find();
    }

    /**
     * 搜索职位
     * @param type $field
     * @param type $require_place
     * @param type $salary
     * @param type $pub_date
     * @param type $cert_type
     * @param type $word
     * @param type $page
     * @param type $size
     * @param type $count
     * @param type $order
     * @return int 
     */
    public function getJobIndexList($field, $require_place, $salary, $pub_date, $cert_type, $word, $is_real_auth, $publisher_role, $page, $size, $count, $order) {
        $jobIdList = $this->getJobIndexIdList($require_place, $salary, $pub_date, $cert_type, $word, $order);
        $jobList = Array();
        $i = 0;
        $recommendProvider = new RecommendProvider();
        foreach ($jobIdList as $sj) {
            $job_id = $sj['job_id'];
            $job_info = $this->getJobInfo($field, $job_id, null, $publisher_role, $is_real_auth);
            if ($recommendProvider->isDisabledUser($job_info['publisher_id'])) {
                continue;
            }
            if (!empty($job_info)) {
                $jobList[$i] = $job_info;
                $i++;
            }
        }
        if ($count) {
            return $i;
        }
        $offset = ($page - 1) * $size;
        return array_slice($jobList, $offset, $size);
    }

    /**
     * 更新职位搜索关键词统计
     * @param int $id
     * @param int $count
     * @return bool 
     */
    public function updateJobSearchHot($id, $count) {
        $this->da->setModelName('job_search_hot');
        $where['id'] = $id;
        $data['count'] = $count;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 获取职位搜索统计
     * @param string $keyword
     * @return array 
     */
    public function getJobSearchHot($keyword) {
        $this->da->setModelName('job_search_hot');
        $where['keyword'] = $keyword;
        return $this->da->where($where)->find();
    }

    /**
     * 添加职位搜索统计
     * @param string $keyword 
     */
    public function addJobSearchHot($keyword) {
        $this->da->setModelName('job_search_hot');
        $data['keyword'] = $keyword;
        return $this->da->add($data);
    }

    /**
     * 删除职位搜索统计
     * @param int $id
     * @return bool 
     */
    public function deleteJobSearchHot($id) {
        $this->da->setModelName('job_search_hot');
        $where['id'] = $id;
        return $this->da->where($where)->delete() !== false;
    }

    /**
     * 获取热门关键词
     * @return array 
     */
    public function getSearchHotKeyword() {
        $this->da->setModelName('job_search_hot');
        $order = 'count desc';
        return $this->da->page('0,6')->order($order)->select();
    }

    /**
     * 判断是否存在指定职位的索引
     * @param int $job_id 
     */
    public function existJobIndex($job_id) {
        $this->da->setModelName('job_index');
        $where['job_id'] = $job_id;
        return $this->da->where($where)->count('job_id') > 0;
    }

}

?>
