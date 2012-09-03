<?php
/**
 * Description of home_bill_index_page
 *
 * @author moi
 */
class home_bill_index_page {
    /**
     * 获取页面信息
     * @return <mixed>
     */
    public static function get_page_info(){
        $service = new BillService();
        $bill = $service->get_bill_info(AccountInfo::get_user_id());
        $array['cash']  = $bill['cash'];
        $array['name']  = P('name');
        return FactoryVMap::array_to_model($array, 'home_bill_index');
    }

    /**
     * 获取支付方式列表
     * @return <mixed>
     */
    public static function get_payments(){
        $service = new BillService();
        return FactoryVMap::list_to_models($service->get_pay_type_list(), 'home_bill_payment');
    }

    /**
     * 获取账单记录
     * @param  <int>  $type  账单类型
     * @param  <int>  $page  第几页
     * @return <mixed>
     */
    public static function get_records($type = 0, $page = 1){
        $service = new BillService();
        $data = $service->get_bill_record_list(AccountInfo::get_user_id(), $type, null, null, $page, C('SIZE_BILL_RECORD'), null);
        return FactoryVMap::list_to_models($data, 'home_bill_details');
    }

    /**
     * 获取账单记录总条数
     * @param  <int>  $type  账单类型
     * @return <int>
     */
    public static function get_records_count($type = 0){
        $service = new BillService();
        return $service->get_bill_record_list(AccountInfo::get_user_id(), $type, null, null, 1, C('SIZE_BILL_RECORD'), null, true);
    }
}
?>
