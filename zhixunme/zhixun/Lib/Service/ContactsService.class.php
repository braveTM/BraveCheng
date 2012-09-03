<?php

/**
 * Description of ContactsService
 *
 * @author moi
 */
class ContactsService {

    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function __construct() {
        $this->provider = new ContactsProvider();
    }

    /**
     * 添加用户关注
     * @param  <int> $user_id   用户编号
     * @param  <int> $follow_id 关注编号
     * @param  <int> $role_id   用户角色编号
     * @return <bool>
     */
    public function add_user_follow($user_id, $follow_id, $role_id) {
        $check = $this->check_follow($user_id, $follow_id, $role_id, $frole_id);
        if (is_zerror($check)) {
            return $check;
        }
        if ($frole_id == C('ROLE_TALENTS'))
            $module_id = 11;
        else if ($frole_id == C('ROLE_ENTERPRISE'))
            $module_id = 12;
        else if ($frole_id == C('ROLE_AGENT'))
            $module_id = 13;
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL START↓↓↓↓↓↓↓↓↓↓
        $pks = new PackageService();
        $do = $pks->start_paying_operation($user_id, $module_id, $follow_id);
        if (is_zerror($do)) {
            return $do;
        }
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL START↑↑↑↑↑↑↑↑↑↑
        if (!$this->provider->add_follow($user_id, $follow_id)) {
            return E();
        }
        //↓↓↓↓↓↓↓↓↓↓PAY CONTROL END↓↓↓↓↓↓↓↓↓↓
        $pks->end_paying_operation();
        //↑↑↑↑↑↑↑↑↑↑PAY CONTROL END↑↑↑↑↑↑↑↑↑↑
        $this->moving_follow($user_id, $check['role_id'], $follow_id, $check['name'], $check['data_id']);
        
        //发送通知邮件
        $userService=new UserService();
        $user = $userService->get_user($follow_id);
        $email = $user['email'];
        $args=array();
        $notifyService=new NotifyService();
        $notifyService->fillCommonArgs($args,$follow_id,$user_id);
        email_send($email, 25, $follow_id, null, $args);
        
//        $service = new RemindService();
//        $service->notify(C('REMIND_FOLLOWED'), $follow_id);        //通知
        return true;
    }

    /**
     * 删除用户关注
     * @param  <int> $user_id   用户编号
     * @param  <int> $follow_id 关注编号
     * @return <bool>
     */
    public function delete_user_follow($user_id, $follow_id) {
        if (!$this->provider->delete_follow($user_id, $follow_id)) {
            return E();
        }
        return true;
    }

    /**
     * 是否存在用户关注
     * @param  <int> $user_id   用户编号
     * @param  <int> $follow_id 关注编号
     * @return <int> 1为存在，0为不存在
     */
    public function exists_user_follow($user_id, $follow_id) {
        return intval($this->provider->exists_user_follow($user_id, $follow_id));
    }

    /**
     * 获取用户的关注列表
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $type    用户类型
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <string> $order   排序方式
     * @param  <bool>   $count   是否统计总条数
     * @return <mixed>
     */
    public function get_follow_list($user_id, $type, $page, $size, $order = null, $count = false) {
        if (!empty($type) && !is_numeric($type)) {
            $type = null;
        }
        return $this->provider->get_follow_list($user_id, $type, $page, $size, $order, $count);
    }

    /**
     * 获取指定用户的动态列表
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function get_moving_list($user_id, $page, $size, $count = false) {
        
    }

    /**
     * 获取指定用户关注的动态列表
     * @param  <int>  $user_id 用户编号
     * @param  <int>  $type    用户类型
     * @param  <int>  $page    第几页
     * @param  <int>  $size    每页几条
     * @param  <bool> $count   是否统计总条数
     * @return <mixed>
     */
    public function get_follow_moving($user_id, $type, $page, $size, $count = false) {
        if (!empty($type) && !is_numeric($type)) {
            $type = null;
        }
        return $this->provider->get_follow_moving($user_id, $type, $page, $size, $count);
    }

    /**
     * 添加应聘职位动态
     * @param  <int>    $user_id      用户编号
     * @param  <int>    $job_id       职位编号
     * @param  <int>    $job_category 职位泪腺
     * @param  <string> $job_title    职位标题
     * @return <bool> 是否成功
     */
    public function moving_position($user_id, $job_id, $job_category, $job_title) {
        $action = '应聘了职位';
        if ($job_category == C('JOB_CATEGORY_FULL'))
            $category = '[全职]';
        else
            $category = '[兼职]';
        $content = "<span class='red'>$category</span><a target='_blank' class='blue' href='[root]/office/$job_id'>$job_title</a>";
        if (!$this->provider->add_moving($user_id, $action, $content, 1)) {
            return E();
        }
        return true;
    }

    /**
     * 添加更新简历动态
     * @param  <int> $user_id      用户编号
     * @return <bool> 是否成功
     */
    public function moving_update_resume() {
        $service = new UserService();
        $data = $service->get_user(AccountInfo::get_user_id());
        if ($data['role_id'] != C('ROLE_TALENTS')) {
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        $action = '更新了简历';
        $content = '';
        if (!$this->provider->add_moving($user_id, $action, $content, 2)) {
            return E();
        }
        return true;
    }

    /**
     * 添加发布职位动态
     * @param  <int>    $user_id      用户编号
     * @param  <int>    $job_id       职位编号
     * @param  <int>    $job_category 职位类型
     * @param  <string> $job_title    职位标题
     * @return <bool> 是否成功
     */
    public function moving_post_jobs($user_id, $job_id, $job_category, $job_title) {
        $action = '发布了职位';
        if ($job_category == C('JOB_CATEGORY_FULL'))
            $category = '[全职]';
        else
            $category = '[兼职]';
        $content = "<span class='red'>$category</span><a target='_blank' class='blue' href='[root]/office/$job_id'>$job_title</a>";
        if (!$this->provider->add_moving($user_id, $action, $content, 3)) {
            return E();
        }
        return true;
    }

    /**
     * 添加关注用户动态
     * @param  <int>    $user_id        用户编号
     * @param  <int>    $follow_role    关注的角色
     * @param  <int>    $follow_id      关注的编号
     * @param  <string> $follow_name    关注的名字
     * @param  <int>    $follow_data_id 关注的资料编号
     * @return <bool> 是否成功
     */
    public function moving_follow($user_id, $follow_role, $follow_id, $follow_name, $follow_data_id) {
        if ($follow_role == C('ROLE_TALENTS')) {
            $type = '人才';
            $url = '/get_resume/' . $follow_data_id;
        } elseif ($follow_role == C('ROLE_ENTERPRISE')) {
            $type = '企业';
            $url = '/company/' . $follow_id;
        } else {//C('ROLE_AGENT'))
            $type = '经纪人';
            $url = '/agent/' . $follow_id;
        }
        $action = "关注了 <a target='_blank' class='blue' href='[root]$url'>$follow_name</a> - <span>$type</span>";
        $content = '';
        if (!$this->provider->add_moving($user_id, $action, $content, 4)) {
            return E();
        }
        return true;
    }

    /**
     * 添加通过信用认证动态
     * @param  <int> $user_id 用户编号
     * @param  <int> $type    类型（1实名2手机3邮箱）
     * @return <bool> 是否成功
     */
    public function moving_through_auth($user_id, $type) {
        if ($type == 1)
            $st = '实名';
        elseif ($type == 2)
            $st = '手机';
        else
            $st = '邮箱';
        $action = "通过了" . $st . "认证";
        $service = new UserService();
        $user = $service->get_user($user_id);
        if ($user['is_real_auth'] == 1) {
            $real = '[f_root]' . C('AUTH_REAL_OK');
        } else {
            $real = '[f_root]' . C('AUTH_REAL_NO');
        }
        if ($user['is_phone_auth'] == 1) {
            $phone = '[f_root]' . C('AUTH_PHONE_OK');
        } else {
            $phone = '[f_root]' . C('AUTH_PHONE_NO');
        }
        if ($user['is_email_auth'] == 1) {
            $email = '[f_root]' . C('AUTH_EMAIL_OK');
        } else {
            $email = '[f_root]' . C('AUTH_EMAIL_NO');
        }
        $content = "<img class='l_small' src='$real' alt='实名认证'/><img class='l_small' src='$phone' alt='手机认证'/><img class='l_small' src='$email' alt='邮箱认证'/>";
        if (!$this->provider->add_moving($user_id, $action, $content, 5)) {
            return E();
        }
        return true;
    }

    /**
     * 添加发布任务动态
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $task_id 任务编号
     * @param  <string> $title   任务标题
     * @param  <int>    $class   任务类型
     * @return <bool> 是否成功
     */
    public function moving_post_task($user_id, $task_id, $title, $class) {
        $service = new TaskService();
        $info = $service->get_class_info($class);
        $action = '发布了任务';
        $content = "<span class='red'>[" . $info['class_title'] . "]</span><a target='_blank' class='blue' href='[root]/dtask/$task_id'>$title</a>";
        if (!$this->provider->add_moving($user_id, $action, $content, 6)) {
            return E();
        }
        return true;
    }

    /**
     * 添加更新个人资料动态
     * @param  <int> $user_id 用户编号
     * @return <bool> 是否成功
     */
    public function moving_update_profile($user_id) {
        $action = '更新了个人资料';
        $content = '';
        if (!$this->provider->add_moving($user_id, $action, $content, 7)) {
            return E();
        }
        return true;
    }

    /**
     * 添加竞标任务动态
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $task_id 任务编号
     * @param  <string> $title   任务标题
     * @param  <int>    $class   任务类型
     * @return <bool> 是否成功
     */
    public function moving_bid_task($user_id, $task_id, $title, $class) {
        $service = new TaskService();
        $info = $service->get_class_info($class);
        $action = '竞标了任务';
        $content = "<span class='red'>[" . $info['class_title'] . "]</span><a target='_blank' class='blue' href='[root]/dtask/$task_id'>$title</a>";
        if (!$this->provider->add_moving($user_id, $action, $content, 8)) {
            return E();
        }
        return true;
    }

    /**
     * 添加中标任务动态
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $task_id 任务编号
     * @param  <string> $title   任务标题
     * @param  <int>    $class   任务类型
     * @return <bool> 是否成功
     */
    public function moving_selected_task($user_id, $task_id, $title, $class) {
        $service = new TaskService();
        $info = $service->get_class_info($class);
        $action = '中标了任务';
        $content = "<span class='red'>[" . $info['class_title'] . "]</span><a target='_blank' class='blue' href='[root]/dtask/$task_id'>$title</a>";
        if (!$this->provider->add_moving($user_id, $action, $content, 9)) {
            return E();
        }
        return true;
    }

    //--------------------protected-------------------
    /**
     * 检测用户关注权限
     * @param  <int> $user_id   用户编号
     * @param  <int> $follow_id 关注编号
     * @param  <int> $role_id   用户角色编号
     * @return <mixed> 成功返回对方信息，失败返回ZERROR
     */
    protected function check_follow($user_id, $follow_id, $role_id, &$frole_id) {
        if ($user_id == $follow_id) {
            return new ZError('不能关注自己');
        }
        if ($this->provider->exists_user_follow($user_id, $follow_id)) {
            return E(ErrorMessage::$FOLLOW_EXISTS);
        }
        $provider = new UserProvider();
        $user = $provider->get_user_info($follow_id);
        $frole_id = $user['role_id'];
        if (empty($frole_id)) {
            return E(ErrorMessage::$USER_NOT_EXISTS);
        }
        if ($role_id == C('ROLE_TALENTS')) {                              //人才只允许关注企业和经纪人
            if ($frole_id != C('ROLE_ENTERPRISE') && $frole_id != C('ROLE_AGENT')) {
                return E(ErrorMessage::$FOLLOW_NO_PERMISSION);
            }
        } else if ($role_id == C('ROLE_ENTERPRISE')) {
            if ($frole_id == C('ROLE_ENTERPRISE')) {                      //企业不允许关注企业
                return E(ErrorMessage::$FOLLOW_NO_PERMISSION);
            }
        } else if ($role_id == C('ROLE_SUBCONTRACTOR')) {                   //劳务分包商只允许关注企业和经纪人
            if ($frole_id != C('ROLE_ENTERPRISE') && $frole_id != C('ROLE_AGENT')) {
                return E(ErrorMessage::$FOLLOW_NO_PERMISSION);
            }
        }
        return $user;
    }

}

?>
