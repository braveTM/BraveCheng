<?php

/**
 * 用户经验数据提供层
 *
 * @author brave
 */
class ExperienceCrmProvider extends BaseProvider {

    public static $experienceArgRule = array(
        'exp_id' => array(
            'name' => '经验记录自增 id',
            'filter' => VAR_ID,
        ),
        'exp_name' => array(
            'name' => '经验分值名称',
            'filter' => VAR_NAME,
        ),
        'exp_value' => array(
            'name' => ' 每条经验分值',
        ),
        'exp_desc' => array(
            'name' => '经验分值说明 ',
        ),
        'level_exp' => array(
            'name' => '等级经验起点值 ',
            'filter' => VAR_NAME,
        ),
        'img' => array(
            'name' => '等级标示符',
        ),
        'name' => array(
            'name' => '等级名称 ',
        ),
        'user_id' => array(
            'name' => '用户自增 id ',
            'filter' => VAR_ID,
            'check' => VAR_ID,
        ),
        'total_exp' => array(
            'name' => '经验总分值 ',
        ),
    );

    /**
     * 获取经验分值说明列表 
     * @return array 
     */
    public function getExperienceList() {
        $this->da->setModelName('experience');
        return $this->da->select();
    }

    /**
     * 添加一条经验记录
     * @param array $data
     * @return mixed 返回一条记录或者false 
     */
    public function addExperience($data) {
        $this->da->setModelName('experience');
        return $this->da->add($data);
    }

    /**
     * 修改一条经验记录
     * @param array $data
     * @return boolean  
     */
    public function editExperience($data) {
        $this->da->setModelName('experience');
        return $this->da->where('exp_id=' . $data['exp_id'])->save($data);
    }

    /**
     * 获取经验等级列表 
     * @return array 
     */
    public function getExperienceLevelList() {
        $this->da->setModelName('level_experience');
        return $this->da->select();
    }

    /**
     * 添加一条经验等级记录
     * @param array $data
     * @return mixed 返回一条记录或者false 
     */
    public function addExperienceLevel($data) {
        $this->da->setModelName('level_experience');
        return $this->da->add($data);
    }

    /**
     * 修改一条经验等级记录
     * @param array $data
     * @return boolean  
     */
    public function editExperienceLevel($data) {
        $this->da->setModelName('level_experience');
        return $this->da->where('id=' . $data['exp_id'])->save($data);
    }

    /**
     * 用户第一次经验添加
     * @param array $data
     * @return mixed 
     */
    public function addUserExperience($data) {
        $this->da->setModelName('user_experience');
        $data['is_valid'] = 0;
        $data['create_time'] = time();
        return $this->da->add($data);
    }

    /**
     * 更新用户经验等级
     * @param array $data
     * @return mixed 
     */
    public function updateLevelField($data) {
        $this->da->setModelName('user_experience');
        return $this->da->where('user_id = ' . $data['user_id'])->setField('g_id', $data['level']);
    }

    /**
     * 用户的经验值增加
     * @param array $data
     * @return mixed 
     */
    public function setTotalExp($data) {
        $this->da->setModelName('user_experience');
        return $this->da->setInc('total_exp', 'user_id=' . $data['user_id'], $data['total']); //用户的经验增加
    }

    /**
     * 用户 经验记录增加
     * @param array $data
     * @return type 
     */
    public function setRecordExp($data) {
        $this->da->setModelName('user_experience');
        return $this->da->where('user_id=' . $data['user_id'])->save($data); //用户的经验记录增加
    }

    /**
     * 获取指定id的经验等级
     * @param int $id
     * @return array 
     */
    public function getLevelExperienceById($id) {
        $this->da->setModelName('level_experience');
        return $this->da->where('id=' . $id)->find();
    }

    /**
     * 获取指定id的经验说明
     * @param int $id
     * @return array 
     */
    public function getExperienceById($id) {
        $this->da->setModelName('experience');
        return $this->da->where('exp_id=' . $id)->find();
    }

    /*    5.16修改版本 * */

    /**
     * 获取用户总分列表
     * @param int $user_id 用户记录id
     * @return array 返回记录
     */
    public function getUserExperience($user_id) {
        $this->da->setModelName('user_experience ue');
        $where = array(
            'ue.is_valid' => 0,
            'ue.user_id' => $user_id
        );
        $join = array(
            C('DB_PREFIX') . 'experience e ON e.exp_id = ue.exp_id',
        );
        $fields = array(
            'ue.user_id',
            'ue.id',
            'ue.exp_id',
            'ue.create_time',
            'e.exp_value',
            'e.exp_name',
            'e.exp_desc',
        );
        return $this->da->join($join)->field($fields)->where($where)->select();
    }

    /**
     * 根据用户id与经验类别获取最新的时间
     * @param array $data
     * @return int 返回时间 
     */
    public function loginAddUserExperience($data) {
        $this->da->setModelName('user_experience');
        $data['is_valid'] = 0;
        return $this->da->where($data)->order('create_time DESC')->field('create_time')->find();
    }

    /**
     * 增加角色总经验
     * @param array $data
     * @return mixed 成功返回记录数 
     */
    public function addUserTotalExperience($data) {
        $this->da->setModelName('user');
        return $this->da->where('user_id = ' . $data['user_id'])->save($data);
    }

}

?>
