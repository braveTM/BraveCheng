<?php

/**
 * Description of BrokerFirmsService
 *
 * @author root
 */
class BrokerFirmsService {

    /**
     * 添加经纪人到经纪公司
     * @param array $data 数据
     * @return mixed 返回成功记录id或者错误信息
     */
    public function add_statff($data = array()) {
        $brokerProvider = new BrokerFirmsProvider();
        $data = argumentValidate(BrokerFirmsProvider::$broArgRule, $data);
        if (is_zerror($data))
            return $data;
        if ($record = $brokerProvider->staff_join_broker_firms($data))
            return $record;
        else
            return E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 冻结员工帐号信息
     * @param int $user_id 经纪人id
     * @param int $broker_id 经纪公司id
     * @return mixed 成功返回更新的记录数，否则返回false
     */
    public function freeze_staff($user_id, $broker_id) {
        $brokerProvider = new BrokerFirmsProvider();
        $userProvider = new UserProvider();
        if (!$brokerProvider->isExist($user_id, $broker_id))
            return;
        if ($userProvider->set_user_freeze_status($user_id, 1))
            return true;
        else
            return E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 冻结员工帐号信息
     * @param int $user_id 经纪人id
     * @param int $broker_id 经纪公司id
     * @return mixed 成功返回更新的记录数，否则返回false
     */
    public function unfreeze_staff($user_id, $broker_id) {
        $brokerProvider = new BrokerFirmsProvider();
        $userProvider = new UserProvider();
        if (!$brokerProvider->isExist($user_id, $broker_id))
            return;
        if ($userProvider->set_user_freeze_status($user_id, 0))
            return true;
        else
            return E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 获取指定经纪人的条件筛选记录
     * @param int $broker_id 经纪人id
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @param array $field_sort 排序条件数组
     * @param int $size 每页大小
     * @param int $curpage 当前页
     * @return array 记录数组
     */
    public function get_filter_broker_staff($broker_id, $start, $end, $field_sort = array(), $size = 2, $curpage = 1) {
        $list = array();
        $broker = new BrokerFirmsProvider();
        $staff_id = $broker->staff_of_broker_firms($broker_id);
        $user = new UserService();
        foreach ($staff_id as $value) {
            $user_info = $user->get_user($value['staff_id']);
            $view_article = $this->get_staff_view_article($value['staff_id'], $start, $end);
            $hot_article = $this->get_staff_hot_article($value['staff_id'], $start, $end);
            $view_job = $this->get_staff_view_job($value['staff_id'], $start, $end);
            $employ_resume = $this->get_staff_employ_resume($value['staff_id'], $start, $end);
            $entrust_resume = $this->get_staff_entrust_resume($value['staff_id'], $start, $end);
            $deliver_resume = $this->get_staff_deliver_resume($value['staff_id'], $start, $end);
            $view_resume = $this->get_staff_view_resume($value['staff_id'], $start, $end);
            $page_view = $this->get_staff_page_view($value['staff_id'], $start, $end);
            $public_resume = $this->get_staff_public_resume($value['staff_id'], $start, $end);
            $public_article = $this->get_staff_public_article($value['staff_id'], $start, $end);
            $public_job = $this->get_staff_public_job($value['staff_id'], $start, $end);
            $list[] = array(
                'id' => $value['staff_id'],
                'public_job' => $public_job ? $public_job : 0, //公开职位
                'public_article' => $public_article ? $public_article : 0, //公开文章
                'public_resume' => $public_resume ? $public_resume : 0, //公开简历
                'page_view' => $page_view ? $page_view : 0, //主页浏览量
                'login_time' => $user_info['last_login_date'] ? $user_info['last_login_date'] : 0, //登陆时间
                'name' => $user_info['name'],
                'photo' => $user_info['photo'],
                'is_online' => $user_info['is_online'] ? $user_info['is_online'] : 0,
                'logout_time' => $user_info['last_logout_time'] ? $user_info['last_logout_time'] : 0,
                'view_resume' => $view_resume ? $view_resume : 0,
                'deliver_resume' => $deliver_resume ? $deliver_resume : 0,
                'entrust_resume' => $entrust_resume ? $entrust_resume : 0,
                'employ_resume' => $employ_resume ? $employ_resume : 0,
                'view_job' => $view_job ? $view_job : 0,
                'entrust_job' => $this->get_staff_entrust_job($value['staff_id'], $start, $end),
                'hot_article' => $hot_article ? $hot_article : 0,
                'view_article' => $view_article ? $view_article : 0,
                'is_freeze' => $user_info['is_freeze'],
            );
        }
        if ($field_sort) {
            foreach ($field_sort as $keys => $sort) {
                switch ($keys) {
                    case 'public_resume':
                        $list = $this->define_sort($list, 'public_resume', $sort);
                        break;
                    case 'public_job':
                        $list = $this->define_sort($list, 'public_job', $sort);
                        break;
                    case 'public_article':
                        $list = $this->define_sort($list, 'public_article', $sort);
                        break;
                    case 'page_view':
                        $list = $this->define_sort($list, 'page_view', $sort);
                        break;
                    default :
                        $list = $this->define_sort($list, 'id', $sort);
                        break;
                }
            }
        }
        $page_total_num = count($list);
        $page = ceil($page_total_num / $size);
        if (1 == $curpage) {
            return (array_slice($list, 0, $size));
        } elseif ($curpage > $page) {
            return(array_slice($list, ($size * ($page - 1)), $size));
        } else {
            return(array_slice($list, ($size * ($curpage - 1)), $size));
        }
    }

    /**
     * 对二维数组排序
     * @param array $list 排序数组
     * @param string $field 检索/排序条件字段
     * @param boolean $sort 升/降排序
     * @return array 排序后的数组
     */
    public function define_sort($list, $field, $sort) {
        foreach ($list as $key => $value) {
            $public_resume[$key] = $value[$field];
        }
        $sort ? array_multisort($public_resume, SORT_ASC, $list) : array_multisort($public_resume, SORT_DESC, $list);
        return $list;
    }

    /**
     * 获取经纪公司的基本信息
     * @param int $user_id 经纪公司id
     * @return array 基本信息
     */
    public function get_broker_info($user_id) {
        $user = new UserService();
        return $user->get_user($user_id);
    }

    /**
     * 获取公司经纪人的公开职位数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_public_job($user_id, $start, $end) {
        $service = new JobService();
        return $service->count_user_open_jobs($user_id, $start, $end);
    }

    /**
     * 获取公司经纪人的查看职位数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_view_job($user_id, $start, $end) {
        $service = new UserService();
        return $service->count_user_read_info($user_id, $start, $end, 2);
    }

    /**
     * 获取公司经纪人的委托的简历
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_entrust_job($user_id, $start, $end) {
        $service = new JobService();
        return $service->count_user_delegate_jobs($user_id, $start, $end);
    }

    /**
     * 获取公司经纪人的发布文章数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_public_article($user_id, $start, $end) {
        $service = new BlogService();
        return $service->count_user_blogs($user_id, $start, $end, 1);
    }

    /**
     * 获取公司经纪人的发布文章浏览数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_view_article($user_id, $start, $end) {
        $service = new BlogService();
        return $service->count_blog_read($user_id, $start, $end);
    }

    /**
     * 获取公司经纪人的发布文章赞数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_hot_article($user_id, $start, $end) {
        $service = new BlogService();
        return $service->count_blog_praise($user_id, $start, $end);
    }

    /**
     * 获取公司经纪人页面的浏览量
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_page_view($user_id, $start, $end) {
        $service = new UserService();
        return $service->count_user_view($user_id, $start, $end);
    }

    /**
     * 获取公司经纪人的公开简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_public_resume($user_id, $start, $end) {
        $service = new ResumeService();
        return $service->count_user_open_resume($user_id, $start, $end);
    }

    /**
     * 获取公司经纪人的查看简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_view_resume($user_id, $start, $end) {
        $service = new UserService();
        return $service->count_user_read_info($user_id, $start, $end, 1);
    }

    /**
     * 获取公司经纪人的投递简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_deliver_resume($user_id, $start, $end) {
        $service = new ResumeService();
        return $service->count_user_send_resume($user_id, $start, $end);
    }

    /**
     * 获取公司经纪人的委托简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_entrust_resume($user_id, $start, $end) {
        $service = new ResumeService();
        return $service->getDelegatedResume(1, 1, true, $user_id, 0, 0, null, $start, $end);
    }

    /**
     * 获取公司经纪人的应聘简历数
     * @param int $user_id 用户编号
     * @param string $start 开始时间
     * @param string $end 结束时间
     * @return int
     */
    public function get_staff_employ_resume($user_id, $start, $end) {
        $service = new ResumeService();
        return $service->count_user_employ_resume($user_id, $start, $end);
    }

}

?>
