<?php

/**
 * 经纪公司action
 *
 * @author brave
 */
class BrokerFirmsAction extends BaseAction {

    /**
     * 获取筛选条件的记录00001
     */
    public function get_filter_broker_staff() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $broker_id = AccountInfo::get_user_id();
        $start_time = $_POST['start_time'] ? date('Y-m-d H:i:s', substr(trim($_POST['start_time']), 0, 10)) : date('Y-m-d') . " 00:00:00";
        $end_time = $_POST['end_time'] ? date('Y-m-d H:i:s', substr(trim($_POST['end_time']), 0, 10)) : date('Y-m-d') . " 23:59:59";
        $field = $_POST['field'] ? trim($_POST['field']) : '';
        $order = $_POST['order'] ? intval($_POST['order']) : '';
        $sort = array(
            $field => $order,
        );
        $size = $_POST['page_size'] ? intval($_POST['page_size']) : 20;
        $curpage = $_POST['curpage'] ? intval($_POST['curpage']) : 1;
        $result = home_brokerfirms_page::get_broker_staff($broker_id, $start_time, $end_time, $sort, $size, $curpage);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 默认获取经纪公司信息列表00001
     */
    public function index() {
        $broker_id = AccountInfo::get_user_id();
        $start_time = $_POST['start_time'] ? date('Y-m-d H:i:s', substr(trim($_POST['start_time']), 0, 10)) : date('Y-m-d') . " 00:00:00";
        $end_time = $_POST['end_time'] ? date('Y-m-d H:i:s', substr(trim($_POST['end_time']), 0, 10)) : date('Y-m-d') . " 23:59:59";
        $result = home_brokerfirms_page::get_broker_staff($broker_id, $start_time, $end_time, $sort = array(), $size = 20, $curpage = 1);
        $this->assign('result', $result);
        $this->assign('broker', home_brokerfirms_page::get_broker_info($broker_id));
        $this->assign('menu', home_package_index_page::get_package_info(12));
        $this->assign('daytime', date('Y年m月d日'));
        $this->display('Home/MiddleMan/agentCompany');
    }

    /**
     * 冻结经纪公司的经纪人00001
     */
    public function do_freeze_user() {
        $user_id = $_POST['user_id'];
        $broker_id = AccountInfo::get_user_id();
        $broker = new BrokerFirmsService();
        $result = $broker->freeze_staff($user_id, $broker_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 解冻经纪公司的经纪人00001
     */
    public function do_unfreeze_user() {
        $user_id = $_POST['user_id'];
        $broker = new BrokerFirmsService();
        $broker_id = AccountInfo::get_user_id();
        $result = $broker->unfreeze_staff($user_id, $broker_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 添加员工00001, 
     */
    public function add_staff() {
        $staff_id = trim($_POST['staff']);
        $brokder_id = trim($_POST['broker']);
        $brokder = new BrokerFirmsService();
        if (is_int($staff_id) && is_int($brokder_id)) {
            $insert = array(
                'broker_id' => $brokder_id,
                'staff_id' => $staff_id
            );
            $brokder->add_statff($insert);
        } else {
            $staffs = explode(',', $staff_id);
            foreach ($staffs as $staff) {
                $insert = array(
                    'broker_id' => $brokder_id,
                    'staff_id' => $staff
                );
                $brokder->add_statff($insert);
            }
        }
    }

}

?>
