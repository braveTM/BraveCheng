<?php
/**
 * Module:003
 */
class BillAction extends BaseAction{
    //----------------页面---------------
    /**
     * 我的账户页01111
     */
    public function index(){
        $this->assign('page', home_bill_index_page::get_page_info());       //页面普通数据
        $this->assign('payments', home_bill_index_page::get_payments());    //支付方式
        $this->display();
    }

    //----------------动作---------------
    /**
     * 获取账单记录01111
     */
    public function get_bills(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $data  = home_bill_index_page::get_records($_POST['type'], $_POST['page']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_bill_index_page::get_records_count($_POST['type']);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 充值01111
     */
    public function do_recharge(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $_POST['subject'] = '职讯网账户充值';
        $service = new BillService();
        $data = $service->get_payment($_POST['type']);
        if(!empty($data)){
            $order_id = md5(time().rand_string().AccountInfo::get_user_id());       //生成唯一订单号
            $result   = $service->add_pay_temp(AccountInfo::get_user_id(), $_POST['money'], $_POST['type'], $order_id, 1);
            if($result){
                $pay  = pay($data['file'], $data['func'], $order_id);
                header('content-type:text/html;charset=utf-8');
                echo $pay;
                return;
            }
        }
        redirect(C('ERROR_PAGE'));
    }

//    /**
//     * 购买套餐01111
//     */
//    public function do_package(){
//        if(!$this->is_legal_request())      //是否合法请求
//            return;
//        $psvc = new UserService();
//        $package = $psvc->get_package($_POST['id']);
//        $_POST['money'] = $package['money'];
//        $_POST['subject'] = '职讯网套餐购买-'.$package['name'];
//        $service = new BillService();
//        $data = $service->get_payment($_POST['type']);//($_POST['type']);
//        if(!empty($data) && !empty($package)){
//            $order_id = md5(time().rand_string().AccountInfo::get_user_id());       //生成唯一订单号
//            $result   = $service->add_pay_temp(AccountInfo::get_user_id(), $_POST['money'], 1, $order_id, 2, $_POST['id']);
//            if($result){
//                $pay  = pay($data['file'], $data['func'], $order_id);
//                echo $pay;
//                return;
//            }
//        }
//        redirect(C('ERROR_PAGE'));
//    }

    /**
     * 支付回调函数01111
     */
    public function pay_callback(){
        $service = new BillService();
        $result  = $service->pay_check(AccountInfo::get_user_id(), P('name'), $_GET['total_fee'], $_GET['out_trade_no']);
        if(is_zerror($result)){                //支付失败
            redirect(C('ERROR_PAGE'));
        }
        else{
            redirect(C('WEB_ROOT').'/bill/?pay='.time());
        }
    }

    /**
     * 余额检测01111
     */
    public function do_money_check(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new BillService();
        $bill = $service->get_bill_info(AccountInfo::get_user_id());
        if($bill['cash'] > $_POST['money']){
            echo jsonp_encode(true);
        }
        else{
            echo jsonp_encode(false);
        }
    }

    /**
     * 生成汇款订单01111
     */
    public function do_hk_order(){
        if(!$this->is_legal_request())      //是否合法请求
            return;
        $service = new BillService();
        $result  = $service->create_remittance_order(AccountInfo::get_user_id(), $_POST['money']);
        if(is_zerror($result)){
            echo jsonp_encode(false, $result->get_message());
        }
        else{
            echo jsonp_encode(true, $result);
        }
    }
}
?>