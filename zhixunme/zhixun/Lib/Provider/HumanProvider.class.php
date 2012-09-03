<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HumanProvider
 *
 * @author JZG
 */
class HumanProvider extends BaseProvider {
    //put your code here

    /**
     * 人才字段规则
     * @var <array>
     */
    public $humanArgRule = array(
        'human_id' => array(
            'name' => '人才ID',
            'filter' => VAR_ID,
            'null' => false
        ),
        'resume_id' => array(
            'name' => '简历ID',
            'filter' => VAR_ID,
            'null' => false
        ),
        'name' => array(
            'name' => '姓名',
            'check' => VAR_NAME,
            'filter' => VAR_NAME,
            'null' => false
        ),
        'gender' => array(
            'name' => '性别',
            'filter' => VAR_GENDER,
            'null' => false
        ),
        'birthday' => array(
            'name' => '生日',
            'filter' => VAR_DATE,
        ),
        'identity_card' => array(
            'name' => '身份证号',
            'check' => VAR_IDNUM
        ),
        'province_code' => array(
            'name' => '居住地省份编号',
            'filter' => VAR_ID,
            'null' => false,
        ),
        'city_code' => array(
            'name' => '居住地城市编号',
            'filter' => VAR_ID,
            'null' => false,
        ),
        'work_age' => array(
            'name' => '工作年限',
            'filter' => VAR_WEXP,
            'null' => false,
        ),
        'certificate_remark' => array(
            'name' => '证书补充说明',
            'length' => 150,
        ),
        'contact_qq' => array(
            'name' => '联系人QQ',
            'filter' => VAR_QQ
        ),
        'contact_mobile' => array(
            'name' => '联系人手机',
            'check' => VAR_PHONE,
            'null' => false,
        ),
        'contact_email' => array(
            'name' => '联系人邮箱',
            'check' => VAR_EMAIL,
        ),
    );

    /**
     * 添加人才信息
     * @param <int> $resume_id 简历ID
     * @param <array> $data 人才基本信息数组
     * @return <mixed> 成功返回添加记录ID，失败返回false
     */
    public function addHuman($resume_id, $data) {
        $this->da->setModelName('human');
        $data['resume_id'] = $resume_id;
        $result = $this->da->add($data);
        if($result == false)
            return false;
        return $data['human_id'];
    }

    /**
     * 更新人才信息
     * @param <int> $human_id 人才信息ID
     * @param <array> $data 人才基本信息数组
     * @return <bool> 成功返回true,失败返回false
     */
    public function updateHuman($human_id, $data) {
        $this->da->setModelName('human');
        $where['human_id'] = $human_id;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 删除人才信息
     * @param <int> $human_id 人才信息ID
     * @return <bool> 成功返回true,失败返回false
     */
    public function deleteHuman($human_id) {
        $this->da->setModelName('human');
        return $this->da->delete($human_id) !== false;
    }

    /**
     * 查询人才信息
     * @param <int> $human_id 人才信息ID
     * @return <mixed> 成功返回数组（一条记录）或null,失败返回false
     */
    public function getHuman($human_id) {
        $this->da->setModelName('human');
        $where['human_id'] = $human_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 根据简历编号查询人才信息
     * @param <int> $human_id 人才信息ID
     * @return <mixed> 成功返回数组（一条记录）或null,失败返回false
     */
    public function getHumanByResumeId($resume_id) {
        $this->da->setModelName('human');
        $where['resume_id'] = $resume_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 查询人才信息列表
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <string> $order 排序方式
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function getHumanList($page, $size, $order) {
        $this->da->setModelName('human');
        $where['is_del'] = 0;
        return $this->da->where($where)->order($order)->page($page . ',' . $size)->select();
    }

    /**
     * 判断指定人才ID是否存在
     * @param <int> $human_id
     */
    public function isExistHuman($human_id) {
        $this->da->setModelName('human');
        $where['human_id'] = $human_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->count('human_id') > 0;
    }

    /**
     * 获取人才信息列表
     * @param <int>    $page  第几页
     * @param <int>    $size  每页条数
     * @param <string> $order 排序方式
     * @param <bool>   $count 是否统计总条数
     * @return <mixed> 成功返回数组（无数据为空数组），失败返回false
     */
    public function get_human_list($page, $size, $order, $count) {
        $this->da->setModelName('human t1');
        $join[] = 'INNER JOIN ' . C('DB_PREFIX') . 'resume t2 ON t2.resume_id=t1.resume_id';
        $join[] = 'INNER JOIN ' . C('DB_PREFIX') . 'user t3 ON t3.data_id=t1.human_id';
        $join[] = 'INNER JOIN ' . C('DB_PREFIX') . 'job_intent t4 on t4.job_intent_id=t2.job_intent_id';
        $join[] = 'INNER JOIN ' . C('DB_PREFIX') . 'hang_card_intent t5 on t5.hang_card_intent_id=t2.hang_card_intent_id';
        $where['t3.role_id'] = C('ROLE_TALENTS');
        $where['t3.is_del'] = 0;
        $where['t3.is_freeze'] = 0;
        $where['t3.is_activate'] = 1;
        $where['t3.email_activate'] = 1;
        $where['t2.publisher_id'] = array('gt', 0);
        if ($count) {
            return $this->da->join($join)->where($where)->count('t2.resume_id');
        }
        if (empty($order))
            $order = 't2.update_datetime DESC';
        $field = 't1.human_id,t1.resume_id,t1.name as human_name,t1.work_age,t2.job_category,t2.update_datetime,
                  t3.user_id,t3.role_id,t3.photo,t3.name,t3.is_real_auth,t3.is_phone_auth,t3.is_email_auth,t4.job_province_code,
                  t4.job_city_code,t4.job_salary,t4.job_name,t5.job_salary as hang_card_salary,t5.register_province_ids';
        return $this->da->join($join)->where($where)->field($field)->page("$page,$size")->order($order)->select();
    }

    /**
     * 指定人才是否是指定经纪人添加的人才
     * @param <int> $creator_id 创建人ID
     * @param <int> $human_id 人才ID
     * @return <bool> 
     */
    public function isAddHuman($creator_id, $human_id) {
        $table = C('DB_PREFIX') . 'resume resume';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'human human on resume.resume_id=human.resume_id';
        $join[1] = C('DB_PREFIX') . 'user user on user.data_id=human.human_id and user.is_del=0 and user.role_id=' . C('ROLE_TALENTS');
        $where['resume.agent_id'] = $creator_id;
        $where['human.human_id'] = $human_id;
        $where['user.data_id'] = array('exp', 'is null');
        $where['resume.is_del'] = 0;
        $where['human.is_del'] = 0;
        return $this->da->table($table)->join($join)->where($where)->count('resume.resume_id') > 0;
    }

}

?>
