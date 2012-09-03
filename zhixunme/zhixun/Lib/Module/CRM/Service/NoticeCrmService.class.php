<?php

/**
 * NoticeCrmService 提醒模块数据中间处理
 *
 * @author brave
 */
class NoticeCrmService {

    //验证规则
    public static $noticeArgRule = array(
        'uid' => array(
            'name' => '经纪人 id',
            'filter' => VAR_ID,
        ),
        'wid' => array(
            'name' => '提醒方式 id',
            'filter' => VAR_ID,
        ),
        'tid' => array(
            'name' => '  提醒时间 id',
            'filter' => VAR_ID,
        ),
        'cid' => array(
            'name' => '提醒条件 id ',
            'filter' => VAR_ID,
        ),
    );
    public static $noticerecordArgRule = array(
        'uid' => array(
            'name' => '经纪人id',
            'filter' => VAR_ID,
        ),
        'pid' => array(
            'name' => '人才企业id',
            'filter' => VAR_ID,
        ),
        'cid' => array(
            'name' => '提醒条件类型id',
            'filter' => VAR_ID,
        ),
    );

    /**
     * 获取提醒方式列表
     * @return array 返回列表数组
     */
    public static function get_notice_way_list() {
        $var = array();
        $list = ObjectPool::getObj('NoticeCrmProvider')->get_notice_way();
        foreach ($list as $value) {
            $var[$value['id']] = $value['title'];
        }
        return $var;
    }

    /**
     * 获取提醒时间设置项列表
     * @return array 返回时间设置项列表
     */
    public static function get_notice_time_setting_list() {
        $listAfter = array();
        /**
         * 'before' 提前 'now' 正点 'after' 延后
         */
        $list = ObjectPool::getObj('NoticeCrmProvider')->get_notice_time_setting();
        //算法解析
        foreach ($list as $key => $value) {
            $listAfter[$value['type']][$key] = array(
                'id' => $value['id'],
                'day' => $value['day'],
                'hour' => $value['hour'],
                'minute' => $value['minute'],
            );
        }
        return $listAfter;
    }

    /**
     * 获取提醒条件列表
     * @return array 返回提醒条件列表
     */
    public static function get_notice_condition_list() {
        $var = array();
        $list = ObjectPool::getObj('NoticeCrmProvider')->get_notice_condition();
        foreach ($list as $value) {
            $var[$value['id']] = $value['name'];
        }
        return $var;
    }

    /**
     * 添加一条提醒设置
     * @param array $data 提醒项字段
     * @return mixed  返回成功记录或者false
     */
    public static function create_notice_user_setting($data = array()) {
        $data = argumentValidate(self::$noticeArgRule, $data);
        if (is_zerror($data))
            return $data;
        return ObjectPool::getObj('NoticeCrmProvider')->add_notice_user_setting($data);
    }

    /**
     *
     * 获取指定条件的经纪人的所有提醒时间
     * @param string $tableName 条件表
     * @param array $queryData 查询字段
     * @return mixed 返回提醒时间或者false
     */
    private function read_condition($tableName, $queryData = array()) {
        $var = array();
        $row = ObjectPool::getObj('NoticeCrmProvider')->get_condition($tableName, $queryData);
        if (is_array($row)) {
            foreach ($row as $key => $value) {
                /**
                 * 判断经济人是否设置了提醒条件
                 */
                $cid = ApiCrmService::getField('field', $queryData[1], 'notice_condition', 'id');
                $query = array(
                    'uid' => $value['uid'],
                    'cid' => $cid,
                );
                if (ObjectPool::getObj('NoticeCrmProvider')->is_exist('notice_user_setting', 'id', $query)) {
                    $var[$value['uid']][$key] = array(
                        $queryData[0] => $value[$queryData[0]],
                        $queryData[1] => $value[$queryData[1]],
                    );
                }
            }
            return $var;
        }
        return FALSE;
    }

    /**
     * 更新指定经纪人的指定条件的提醒时间
     * @param sting $table 提醒时间表
     * @param int $cid 提醒条件类型id
     * @param string $queryStr 提醒时间条件
     * @param int $period 默认提醒时间段
     * @return boolean  成功返回true
     */
    public static function update_notice_time($table, $cid, $queryStr, $period = NULL) {
        $queryField[0] = $queryStr;
        $queryField[1] = ApiCrmService::getField('id', $cid, 'notice_condition', 'field');
        $birthday = self::read_condition($table, $queryField);
        if (empty($birthday))
            return false;
        foreach ($birthday as $key => $value) {
            //经纪人id与提醒条件类型id
            $timeList = ObjectPool::getObj('NoticeCrmProvider')->get_user_notice_time($key, $cid);
            //时间戳步进值
            if ($timeList) {
                if ($timeList['month'])
                    $steptime = (60 * 60 * 24 * 30) * intval($timeList['month']);
                elseif ($timeList['week'])
                    $steptime = (60 * 60 * 24 * 7) * intval($timeList['week']);
                elseif ($timeList['day'])
                    $steptime = (60 * 60 * 24) * intval($timeList['day']);
                elseif ($timeList['hour'])
                    $steptime = (60 * 60) * intval($timeList['hour']);
                elseif ($timeList['minute'])
                    $steptime = 60 * intval($timeList['minute']);
                else
                    $steptime = 0;
            }
            //设置默认时间段提醒
            isset($period) && $timeperiod = 60 * 60 * $period;
            foreach ($value as $v) {
                //提醒时间提前或延后
                switch ($timeList['type']) {
                    case 'before':
                        $noticetime = date('Y-m-d H:i:s', ((strtotime($v[$queryField[1]]) - $steptime) + $timeperiod));
                        break;
                    case 'after':
                        $noticetime = date('Y-m-d H:i:s', ((strtotime($v[$queryField[1]]) + $steptime) + $timeperiod));
                        break;
                    default:
                        $noticetime = date('Y-m-d H:i:s', (strtotime($v[$queryField[1]]) + $timeperiod));
                        break;
                }
                $data = array(
                    'uid' => $key,
                    'pid' => $v[$queryField[0]],
                    'is_human_id' => $queryStr == 'human_id' ? 0 : 1,
                    'cid' => $cid,
                    'default_time' => $v[$queryField[1]],
                    'notice_time' => $noticetime,
                );
                $data = argumentValidate(self::$noticerecordArgRule, $data);
                if (is_zerror($data))
                    return $data;
                //检查是否相同
                $check = array(
                    'uid' => $key,
                    'pid' => $v[$queryField[0]],
                    'cid' => $cid,
                    'is_human_id' => $queryStr == 'human_id' ? 0 : 1,
                    'default_time' => $v[$queryField[1]],
                );
                //如果条件有改动，则重新进行数据库的更新
                if (!ObjectPool::getObj('NoticeCrmProvider')->is_exist('notice_record', 'id', $check)) {
                    $array = array(
                        'uid' => $key,
                        'pid' => $v[$queryField[0]],
                        'cid' => $cid,
                        'is_human_id' => $queryStr == 'human_id' ? 0 : 1,
                    );
                    $id = ObjectPool::getObj('NoticeCrmProvider')->get_notice_record_by_filter($array);
                    if ($id) {
                        $data['id'] = $id;
                        $year = (date('Y', strtotime($data['notice_time'])) + 1);
                        //如果增加一年还小于当前的年份，则年份使用当前的年份，防止重复发送提醒
                        if ($year < date('Y'))
                            $year = date('Y');
                        $data['notice_time'] = $year . '-' . date('m', strtotime($data['notice_time'])) . '-' . date('d', strtotime($data['notice_time'])) . ' ' . date('H', strtotime($data['notice_time'])) . ':' . date('i', strtotime($data['notice_time'])) . ':' . date('s', strtotime($data['notice_time']));
                        ObjectPool::getObj('NoticeCrmProvider')->update_notice_record($data);
                    } else
                        ObjectPool::getObj('NoticeCrmProvider')->add_notice_record($data);
                }
            }
        }
        return TRUE;
    }

    /**
     * 定时将符合提醒条件的资源保存到提醒记录表中
     * @param int $clock 提醒的准备小时
     */
    public static function save_notice($clock = '8') {
        $list = ObjectPool::getObj('NoticeCrmProvider')->get_notice_condition();
        if ($list) {
            foreach ($list as $value) {
                if ($value['area'] == 1)
                    self::update_notice_time('crm_company', $value['id'], 'enter_id', $clock);
                else
                    self::update_notice_time('crm_human', $value['id'], 'human_id', $clock);
            }
        }
        return FALSE;
    }

    /**
     * 根据准确提醒时间记录表查询当前时间与指定准确时间记录是否有记录
     * @return mixed 有记录返回记录数组否则返回false
     */
    public static function get_notice_record() {
        $var = $userData = array();
        $record = ObjectPool::getObj('NoticeCrmProvider')->notice();
        if (!empty($record)) {
            foreach ($record as $key => $value) {
                $row = ObjectPool::getObj('NoticeCrmProvider')->get_notice_user_setting_by_id($value['uid'], $value['cid']);
                //根据经纪人组装
                $var[$value['uid']][$key] = array(
                    'id' => $value['id'],
                    'pid' => $value['pid'],
                    'cid' => $value['cid'],
                    'wid' => $row['wid'],
                    'tid' => $row['tid'],
                    'notice_time' => $value['notice_time'],
                    'is_human' => $value['is_human_id'],
                );
            }
            /**
             * 数据组装
             */
            foreach ($var as $k => $v) {
                foreach ($v as $key => $value) {
                    $userData[$k][$value['cid']][$value['wid']][$value['tid']][$key] = array(
                        'id' => $value['id'],
                        'pid' => $value['pid'],
                        'notice_time' => $value['notice_time'],
                        'is_human' => $value['is_human'],
                    );
                }
            }
            return $userData;
        }
        return false;
    }

    /**
     * 定时进行发送提醒
     * 大量的算法实现
     */
    public static function doing_notice() {
        $userData = self::get_notice_record();
        if (empty($userData))
            return FALSE;
        foreach ($userData as $broker => $conditionArr) { //经纪人一层  
            foreach ($conditionArr as $cid => $content) { //提醒条件二层
                foreach ($content as $wid => $resource) { //提醒方式三层
                    foreach ($resource as $tid => $value) { //提醒时间四层  
                        //提醒时间设置
                        $noticeTime = ObjectPool::getObj('NoticeCrmProvider')->get_notice_time_setting_by_id($tid);
                        //是否发送提醒判断
                        $day_desc = !empty($noticeTime['month']) ? array(1 => 'month', 2 => $noticeTime['month']) : !empty($noticeTime['week']) ? array(1 => 'week', 2 => $noticeTime['week']) : !empty($noticeTime['day']) ? array(1 => 'day', 2 => $noticeTime['day']) : '';
                        foreach ($value as $notime) {
                            
                        }
                        if (!self::match_notice_time($noticeTime['type'], $day_desc[2], $day_desc[1], $notime['notice_time'])) {
                            break;
                        }
                        //提醒方式
                        $noticeWay = trim(ApiCrmService::getField('id', $wid, 'notice_way', 'title'));
                        if ($noticeTime['month'])
                            $dat = 'month';
                        elseif ($noticeTime['week'])
                            $dat = 'week';
                        elseif ($noticeTime['day'])
                            $dat = 'day';
                        elseif ($noticeTime['hour'])
                            $dat = 'hour';
                        elseif ($noticeTime['minute'])
                            $dat = 'minute';
                        //时间描述，几天后到期
                        $timeDesc = self::time_describe($noticeTime[$dat], $noticeTime['type'], self::day_describe($dat));
//                        //提醒条件，即提醒类型，如：人才生日
                        $noticeCondition = ApiCrmService::getField('id', $cid, 'notice_condition', 'name');
                        $resourceList = array();
                        foreach ($value as $list) {
                            if ($list['is_human'] == 0) {
                                $check_human = 0;
                                array_push($resourceList, $list['pid']);
                            } else {
                                $check_human = 1;
                                array_push($resourceList, $list['pid']);
                            }
                            $idList .= $list['id'] . ',';
                        }
                        foreach ($resourceList as $res) {
                            if ($check_human) {
                                $name = ApiCrmService::getField('enter_id', $res, 'crm_company', 'name');
                                $href = '<a href="' . C('WEB_ROOT') . '/rcompany/' . $res . '">立即查看</a>';
                                $noticeContent = self::lanuage_report($cid, $name, $timeDesc, $href);
                            } else {
                                $name = ApiCrmService::getField('human_id', $res, 'crm_human', 'name');
                                $href = '<a href="' . C('WEB_ROOT') . '/rhuman/' . $res . '">立即查看</a>';
                                $noticeContent = self::lanuage_report($cid, $name, $timeDesc, $href);
                            }
                        }
                        array_shift($resourceList);
                        self::sending_notice($noticeWay, $broker, $noticeCondition . '即将到了', $noticeContent, self::message_type($cid));
                        //成功发送提醒之后，更新数据库提醒时间
                        $record = explode(',', $idList);
                        array_pop($record);
                        foreach ($record as $recordId) {
                            ObjectPool::getObj('NoticeCrmProvider')->do_renew_notice_time($recordId);
                            self::diff_notice_time($recordId);
                        }
                        unset($idList, $noticeContent);
                    }
                }
            }
        }
    }

    /**
     * 更新提醒时间，防止时间段递进值为1
     * @param int $record_id 提醒id
     */
    public static function diff_notice_time($record_id) {
        $update_notice_time = ApiCrmService::getField('id', $record_id, 'notice_record ', 'notice_time');
        $update_timestp = strtotime($update_notice_time);
        $update_year = date('Y', $update_timestp);
        if ($update_year <= date('Y')) {
            $now_datetime = (date('Y') + 1) . '-' . date('m', $update_timestp) . '-' . date('d', $update_timestp) . ' ' . date('H', $update_timestp) . ':' . date('i', $update_timestp) . ':' . date('s', $update_timestp);
            $data = array(
                'id' => $record_id,
                'notice_time' => $now_datetime,
            );
            ObjectPool::getObj('NoticeCrmProvider')->update_notice_record($data);
        }
    }

    /**
     *  提醒内容语言
     * @param int $set 提醒方式id
     * @param string $name 人才企业名称
     * @param string $timeset 时间描述
     * @param string $href 链接察看
     * @return string 提醒内容
     */
    public static function lanuage_report($set, $name, $timeset, $href) {
        switch ($set) {
            case 1:
                $language = $name . $timeset . '汇款,' . $href;
                break;
            case 2:
                $language = $name . '聘用时间' . $timeset . '到期,' . $href;
                break;
            case 3:
                $language = $name . $timeset . '过生,' . $href;
                break;
            case 4:
                $language = $timeset == '今天' ? $timeset . '是' . $name . '成立周年时间,' . $href : $name . '即将到成立时间,' . $href;
                break;
            default:
                break;
        }
        return $language;
    }

    /**
     * 发送指定提醒方式的提醒内容
     * @param string $noticeWay 提醒方式
     * @param int $broker 经纪人
     * @param string $title 提醒标题
     * @param string $content 提醒内容
     * @param int $alertType  提醒类型
     */
    public static function sending_notice($noticeWay, $broker, $title, $content, $alertType) {
        $queryFields = array(
            'contact_mobile',
            'contact_email',
            'name',
        );
        $agent_id = ApiCrmService::getField('user_id', $broker, 'user', 'data_id');
        $row = ApiCrmService::getNeedFields('agent_id', $agent_id, 'agent', $queryFields);
        //根据提醒方式发送提醒
        switch ($noticeWay) {
            case '消息':
                $service = new MessageService();
                $service->send(0, '职讯网', $broker, $row['name'], $title, $content, 0, 1, false, $alertType);
                break;
            case '短信':
                require_cache(APP_PATH . '/Common/Class/SMS.class.php');
                $notify = new SMSFactory();
                $obj = $notify->get_object($row['contact_mobile'], strip_tags($content));
                $obj->send();
                break;
            case '邮件':
                normal_email_send($row['contact_email'], $title, $content);
                break;
            default:
                break;
        }
    }

    /**
     * 时间描述
     * @param int $day 具体时间天数或者月数
     * @param string $step 提前方式
     * @param string $desc 天或者月描述
     * @return string 时间描述
     */
    public static function time_describe($day, $step, $desc) {
        switch ($step) {
            case 'before':
                $timedes = $day . $desc . '后';
                break;
            case 'after':
                $timedes = $day . $desc . '前';
                break;
            default:
                $timedes = '今天';
                break;
        }
        return $timedes;
    }

    /**
     * 字段映射
     * @param string $day字段名称
     * @return string 字段映射中文名称
     */
    public static function day_describe($day) {
        switch ($day) {
            case 'month':
                $string = '月';

                break;
            case 'week':
                $string = '周';

                break;
            case 'day':
                $string = '天';

                break;
            case 'hour':
                $string = '时';

                break;
            case 'minute':
                $string = '分';

                break;
        }
        return $string;
    }

    /**
     * 提醒类型转换4人才生日5企业成立6企业汇款7人才聘用到期
     * @param int $id 类型转换
     * @return int 转换后的id
     */
    public static function message_type($id) {
        switch ($id) {
            case 1:
                $type = 6;
                break;
            case 2:
                $type = 7;
                break;
            case 3:
                $type = 4;
                break;
            case 4:
                $type = 5;
                break;
        }
        return $type;
    }

    /**
     * 添加一条提醒时间记录
     * @param array $data 提醒内容
     * @return mixed 成功返回提醒时间记录id否则返回false
     */
    public static function create_notice_time_setting($data = array()) {
        if (is_array($data)) {
            if (is_zerror(argumentValidate(NoticeCrmProvider::$noticetimesettingArgRule, $data)))
                return $data;
            return ObjectPool::getObj('NoticeCrmProvider')->add_notice_time_setting($data);
        }
    }

    /**
     * 获取指定经纪人的不同提醒条件类型的信息
     * @param int $uid 经纪人id
     * @return array 经纪人设置信息
     */
    public static function get_notice_user_setting_by_id($uid = NULL) {
        $user = $noticeUser = array();
        if (is_array($noticeCon = array_flip(self::get_notice_condition_list()))) {
            foreach ($noticeCon as $value) {
                $noticeUserSet = ObjectPool::getObj('NoticeCrmProvider')->get_notice_user_setting_by_id($uid, $value);
                $time = ObjectPool::getObj('NoticeCrmProvider')->get_notice_time_setting_by_id($noticeUserSet['tid']);
                $noticeUser['time_type'] = $time['type'];
                if ($time['month']) {
                    $noticeUser['time_desc'] = 'month';
                    $noticeUser['time'] = $time['month'];
                }
                if ($time['week']) {
                    $noticeUser['time_desc'] = 'week';
                    $noticeUser['time'] = $time['week'];
                }
                if ($time['day']) {
                    $noticeUser['time_desc'] = 'day';
                    $noticeUser['time'] = $time['day'];
                }
                if ($time['hour']) {
                    $noticeUser['time_desc'] = 'hour';
                    $noticeUser['time'] = $time['hour'];
                }
                if ($time['minute']) {
                    $noticeUser['time_desc'] = 'minute';
                    $noticeUser['time'] = $time['minute'];
                }
                if ($time['type'] == 'now') {
                    $noticeUser['time_desc'] = 'day';
                }
                $noticeUser['wid'] = $noticeUserSet['wid'];
                $user[$value] = $noticeUser;
            }
        }
        return $user;
    }

    /**
     * 判断一些字段条件是否存在
     * @param string $table 表名
     * @param string $id 查询字段
     * @param array $data 字段条件
     */
    public static function notice_user_exist($table, $id = 'id', $data = array()) {
        return ObjectPool::getObj('NoticeCrmProvider')->is_exist($table, $id, $data);
    }

    /**
     * 更新指定经纪人与提醒类型的提醒方式与提醒时间
     * @param array $data 提醒内容数组
     * @return boolean 成功与否
     */
    public function update_notice_user_setting($data = array()) {
        return ObjectPool::getObj('NoticeCrmProvider')->update_notice_user_setting($data);
    }

    /**
     * 判断当前时间是否与提前或者当天到时间想匹配
     * @param int $tag 提前或者当天
     * @param int $time_num 提前到天数或者月数
     * @param string $day_desc 天或者月
     * @param string $diff_time 提醒到时间或者提醒后增加至时间
     * @return boolean 
     */
    public static function match_notice_time($tag, $time_num, $day_desc, $diff_time) {
        switch (trim($tag)) {
            case 'now':
                return strtotime(date('m-d')) == strtotime(date('m-d', strtotime($diff_time))) ? TRUE : FALSE;
                break;
            case 'before':
                if ($day_desc == 'month') {
                    return $time_num == date('m', strtotime($diff_time)) - date('m') ? TRUE : FALSE;
                } elseif ($day_desc == 'week' || $day_desc == 'day') {
                    return $time_num == date('d', strtotime($diff_time)) - date('d') ? TRUE : FALSE;
                }
                break;
        }
        return FALSE;
    }

}

?>
