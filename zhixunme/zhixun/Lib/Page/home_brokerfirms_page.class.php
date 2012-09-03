<?php

/**
 * Description of home_brokerfirms_page
 *
 * @author brave
 */
class home_brokerfirms_page {

    public static function get_broker_staff($broker_id, $start_time, $end_time, $sort, $size, $curpage) {
        $broker = new BrokerFirmsService();
        $data = $broker->get_filter_broker_staff($broker_id, $start_time, $end_time, $sort, $size, $curpage);
        return FactoryVMap::array_to_model($data, 'home_broker');
    }

    public static function get_broker_info($user_id) {
        $broker = new BrokerFirmsService();
        $data = $broker->get_broker_info($user_id);
        return FactoryVMap::array_to_model($data, 'home_broker_info');
    }

}

?>
