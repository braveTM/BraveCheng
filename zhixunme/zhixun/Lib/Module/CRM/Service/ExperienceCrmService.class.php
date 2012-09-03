<?php

/**
 * 用户经验模块
 *
 * @author brave
 */
class ExperienceCrmService {

    /**
     * 实例化接口
     * @param string $name
     * @return obj 
     */
    private static function getInstance($name) {
        return new $name();
    }

    /**
     * 获取经验分值记录
     * @return array 分值记录数组 
     */
    public static function get_experience_list() {
        $rows = self::getInstance('ExperienceCrmProvider')->getExperienceList();
        return $rows;
    }

    /**
     * 添加或者修改经验分值记录
     * @param array $data = array(
      "exp_id",经验记录自增 id
      "exp_name",经验分值名称
      "exp_value",每条经验分值
      "exp_desc",经验分值说明
      );
     * @return mixed 返回成功记录或者false 
     */
    public static function save_experience($data) {
        $data = argumentValidate(ExperienceCrmProvider::$experienceArgRule, $data);
        if (is_zerror($data))
            return $data;
        return self::getInstance('ExperienceCrmProvider')->addUserExperience($data);
    }

    /**
     * 获取经验等级记录
     * @return array 分值记录数组 
     */
    public static function get_experience_level_list() {
        $rows = self::getInstance('ExperienceCrmProvider')->getExperienceLevelList();
        return $rows;
    }

    /**
     * 添加或者修改经验等级记录
     * @param array $data = array(
      "id",等级自增 id
      "level_exp",等级经验起点值
      "img",等级标示符
      "name",等级名称
      );
     * @return boolean 
     */
    public static function save_experience_level($data) {
        $data = argumentValidate(ExperienceCrmProvider::$experienceArgRule, $data);
        if (is_zerror($data))
            return $data;
        if (empty($data['id']))
            return self::getInstance('ExperienceCrmProvider')->addExperienceLevel($data) > 0 ? TRUE : FALSE;
        else {
            if (!ApiCrmService::isExist('id', $data['id'], 'level_experience'))
                return E(ErrorMessage::$RECORD_NOT_EXISTS); //记录不存在
            return self::getInstance('ExperienceCrmProvider')->editExperienceLevel($data);
        }
    }

    /**
     * 更新用户经验等级
     * @param array $data = array(
      "user_id",用户自增 id
      "level",等级自增 id
      );
     * @return mixed 
     */
    public static function update_level($data) {
        $data = argumentValidate(ExperienceCrmProvider::$experienceArgRule, $data);
        if (is_zerror($data))
            return $data;
        if (!empty($data) && ApiCrmService::isExist('user_id', $data['user_id'], 'user_experience'))
            return self::getInstance('ExperienceCrmProvider')->updateLevelField($data);
    }

    /**
     * 获取用户当前经验信息
     * @param int $user_id
     * @return array 返回经验信息 
     */
    public static function get_experience_by_user($user_id) {
        if (!ApiCrmService::isExist('user_id', $user_id, 'user_experience'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS); //记录不存在
        $userExp = self::getInstance('ExperienceCrmProvider')->getUserExperience($user_id);
        //等级说明
        $row = self::getInstance('ExperienceCrmProvider')->getLevelExperienceById($userExp['g_id']);
        $userExp['level_name'] = $row['name'];
        $userExp['level_img'] = $row['img'];
        //经验记录信息
        $id = explode(',', $userExp['record']);
        if (is_array($id)) {
            foreach ($id as $v) {
                $userExp['exp_notes'][] = self::getInstance('ExperienceCrmProvider')->getExperienceById($v);
            }
        }

        return $userExp;
    }

    /*    5.16修改版本 * */

    /**
     * 用户总经验值
     * @param int $user_id 用户id
     * @return int 返回经验总值 
     */
    public static function get_total_experience($user_id) {
        $total = null;
        if (!ApiCrmService::isExist('user_id', $user_id, 'user_experience'))
            return FALSE;
        $rows = self::getInstance('ExperienceCrmProvider')->getUserExperience($user_id);
        foreach ($rows as $value) {
            $total +=$value['exp_value'];
        }
        return $total;
    }

    /**
     * 添加与更新用户经验
     * @param type $user_data 用户经验数据
     * @return mixed 返回成功记录或者false
     */
    public static function add_experience($user_data) {
        if (!ApiCrmService::isExist('exp_id', $user_data['exp_id'], 'experience'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS); //记录不存在
        return self::save_experience($user_data);
    }

    /**
     * 每天登陆增加经验
     * @param int $user_id 用户id
     * @return boolean 成功返回true 否则false
     */
    public static function add_experience_per_day($user_id) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 2, //登陆类别
        );
        $create_time = self::getInstance('ExperienceCrmProvider')->loginAddUserExperience($data);
        if(date_f('Y-m-d') != date_f('Y-m-d', $create_time)){
            if (self::add_experience($data)) {
                $service = new UserService();
                return $service->increase_exp($user_id, 3);
                //return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
            }
        }
        return FALSE;
    }

    /**
     * 每10分钟委托成功简历
     * @param int $user_id 用户id
     * @return boolean  成功返回true 否则false
     */
    public static function add_experience_entrust_resume($user_id) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 1, //委托简历
        );
        $create_time = self::getInstance('ExperienceCrmProvider')->loginAddUserExperience($data);
        if (($_SERVER['REQUEST_TIME'] - $create_time['create_time']) > (10 * 60)) {
            if (self::add_experience($data)) {
                return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
            }
        }
        return FALSE;
    }

    /**
     * 每10分钟委托成功职位
     * @param int $user_id 用户id
     * @return boolean  成功返回true 否则false
     */
    public static function add_experience_entrust_office($user_id) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 3, //委托职位
        );
        $create_time = self::getInstance('ExperienceCrmProvider')->loginAddUserExperience($data);
        if (($_SERVER['REQUEST_TIME'] - $create_time['create_time']) > (10 * 60)) {
            if (self::add_experience($data)) {
                return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
            }
        }
        return FALSE;
    }

    /**
     *  发表职场经验经验增加5分
     * @param int $user_id 用户id
     * @return boolean 成功返回true 否则false
     */
    public static function add_experience_post_office($user_id) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 4, //发表职场经验
        );
        if (self::add_experience($data)) {
            $service = new UserService();
            return $service->increase_exp($user_id, 5);
            //return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
        }
        return FALSE;
    }

    /**
     * 加V认证通过增加经验值
     * @param int $user_id 用户id
     * @return boolean 成功返回true 否则false
     */
    public static function add_experience_V($user_id) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 11, //加V认证
        );
        if (self::add_experience($data)) {
            $service = new UserService();
            return $service->increase_exp($user_id, 50);//加V认证增加50分
            //return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
        }
        return FALSE;
    }

    /**
     * 购买套餐增加经验值
     * @param int $user_id 用户id
     * @return boolean 成功返回true 否则false
     */
    public static function add_experience_buy_package($user_id, $score) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 12, //购买套餐
        );
        if (self::add_experience($data)) {
            $service = new UserService();
            return $service->increase_exp($user_id, $score);
            //return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
        }
        return FALSE;
    }

    /**
     * 投递简历增加经验值
     * @param int $user_id 用户id
     * @return boolean 成功返回true 否则false
     */
    public static function add_experience_send_resume($user_id) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 13, //投递简历
        );
        if (self::add_experience($data)) {
            $service = new UserService();
            return $service->increase_exp($user_id, 3);//投递简历增加3分
            //return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
        }
        return FALSE;
    }

    /**
     * 删除信息减少经验值
     * @param int $user_id 用户id
     * @return boolean 成功返回true 否则false
     */
    public static function add_experience_delete_info($user_id) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 15, //删除信息
        );
        if (self::add_experience($data)) {
            $service = new UserService();
            return $service->decrease_exp($user_id, 12);
            //return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
        }
        return FALSE;
    }

    /**
     * 邀请简历增加经验值
     * @param int $user_id 用户id
     * @return boolean 成功返回true 否则false
     */
    public static function add_experience_invite_resume($user_id) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 14, //邀请简历
        );
        if (self::add_experience($data)) {
            $service = new UserService();
            return $service->increase_exp($user_id, 1);//邀请简历增加1分
            //return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
        }
        return FALSE;
    }

    /**
     *  查看一次联系方式经验增加1
     * @param int $user_id 用户id
     * @return boolean 成功返回true 否则false
     */
    public static function add_experience_view_contact($user_id) {
        $data = array(
            'user_id' => $user_id,
            'exp_id' => 5, //查看联系方式
        );
        if (self::add_experience($data)) {
            $service = new UserService();
            return $service->increase_exp($user_id, 1);
            //return self::add_user_total_experience($user_id, self::get_total_experience($user_id));
        }
        return FALSE;
    }

    /**
     * 发布职位增加经验
     * @param int $userid 角色id
     * @return boolean 
     */
    public static function add_experience_post_job($userid) {
        if (self::add_experience(array('user_id' => $userid, 'exp_id' => 6))) {
            $service = new UserService();
            return $service->increase_exp($userid, 8);
            //return self::add_user_total_experience($userid, self::get_total_experience($userid));
        }
        return FALSE;
    }

    /**
     * 每发布一条简历信息增加经验
     * @param int $userid 角色id
     * @return type 
     */
    public static function add_experience_post_resume($userid) {
        if (self::add_experience(array('user_id' => $userid, 'exp_id' => 7))) {
            $service = new UserService();
            return $service->increase_exp($userid, 10);
            //return self::add_user_total_experience($userid, self::get_total_experience($userid));
        }
        return FALSE;
    }

    /**
     * 个人主页访问量增加10次增加经验
     * @param int $userid 角色id
     * @return boolean 
     */
    public static function add_experience_browse10($userid) {
        if (self::add_experience(array('user_id' => $userid, 'exp_id' => 9))) {
            $service = new UserService();
            return $service->increase_exp($userid, 1);
            //return self::add_user_total_experience($userid, self::get_total_experience($userid));
        }
        return FALSE;
    }

    /**
     * 个人主页被赞一次增加经验
     * @param int $userid 角色id
     * @return boolean 
     */
    public static function add_experience_praise($userid) {
        if (self::add_experience(array('user_id' => $userid, 'exp_id' => 10))) {
            $service = new UserService();
            return $service->increase_exp($userid, 1);
            //return self::add_user_total_experience($userid, self::get_total_experience($userid));
        }
        return FALSE;
    }

    /**
     * 增加角色总经验
     * @param int $userid 角色id
     * @param int $total 总经验
     * @return mixed 成功返回true 
     */
    public function add_user_total_experience($userid, $total) {
        if (!ApiCrmService::isExist('user_id', $userid, 'user'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS); //记录不存在
        $rows = self::getInstance('ExperienceCrmProvider')->addUserTotalExperience(array('user_id' => $userid, 'total_experience' => $total));
        return $rows ? TRUE : E(ErrorMessage::$OPERATION_FAILED);
    }

}

?>
