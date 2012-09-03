<?php

/**
 * Description of CNoticeAction
 *
 * @author Administrator
 */
class CNoticeAction extends BaseAction {

    /**
     * 添加一条提醒设置
     * @param array $data 提醒项字段 
     * @return mixed  返回成功记录或者false
     * 00010
     */
    function do_add_notice_user_setting() {
        $notice = trim($_POST['notice']);
        if (max(0, $notice)) {
            $arr = explode(';', $notice);
            foreach ($arr as $value) {
                $record = explode(',', $value);
                $notice_time_setting_type = trim($record[3]);
                if (!$record[1])
                    echo jsonp_encode(FALSE, '提醒设置不完整');
                //提醒时间记录
                $notice_time = array(
                    'type' => $record[1],
                    $notice_time_setting_type => $record[2],
                );
                if ('now' == trim($record[1]))
                    array_pop($notice_time);
                if ($id = ObjectPool::getObj('NoticeCrmService')->create_notice_time_setting($notice_time)) {
                    //经纪人提醒时间记录
                    $data = array(
                        'uid' => AccountInfo::get_user_id(),
                        'wid' => intval($record[4]),
                        'tid' => $id,
                        'cid' => $record[0],
                    );
                    if (!$data['wid'] || !$data['uid'] || !$data['tid'] || !$data['tid'])
                        echo jsonp_encode(FALSE, '提醒设置不完整');
                    $query = array('uid' => AccountInfo::get_user_id(), 'cid' => $record[0]);
                    if (!ObjectPool::getObj('NoticeCrmService')->notice_user_exist('notice_user_setting', 'id', $query)) {
                        $result = ObjectPool::getObj('NoticeCrmService')->create_notice_user_setting($data);
                    } else {
                        $result = ObjectPool::getObj('NoticeCrmService')->update_notice_user_setting($data);
                    }
                }
            }
            echo is_zerror($result) ? jsonp_encode(FALSE, $result->get_message()) : jsonp_encode(TRUE, $result);
        }
    }

}

?>
