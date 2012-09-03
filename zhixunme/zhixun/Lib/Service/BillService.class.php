<?php
/**
 * Description of BillService
 *
 * @author moi
 */
class BillService{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new BillProvider();
    }

    /**
     * 获取支付方式列表
     * @return <mixed> 列表
     */
    public function get_pay_type_list(){
        $data = $this->provider->get_pay_type_list();
        return $data;
    }

    /**
     * 添加支付临时记录
     * @param  <int>    $user_id  用户编号
     * @param  <double> $money    金额
     * @param  <int>    $payment  支付方式
     * @param  <string> $order_id 订单编号
     * @param  <string> $type     订单类型
     * @param  <string> $sup      额外参数
     * @return <bool> 是否成功
     */
    public function add_pay_temp($user_id, $money, $payment, $order_id, $type, $sup = ''){
        if($money < 5)
            return false;
        switch ($type){
            case 2 :
                $result = $this->check_package($sup, $money, $user_id);
                if(is_zerror($result)){
                    return $result;
                }
                break;
        }
        return $this->provider->add_pay_temp($user_id, $money, $payment, $order_id, $type, $sup, date_f());
    }

    /**
     * 支付信息审核（使用当前登录ID可能导致不安全因素以及COOKIE域名不同或过期后的ID丢失问题，目前使用下订单时的用户ID）
     * @param <int>    $user_id   用户编号
     * @param <int>    $user_name 用户名
     * @param <double> $money     金额
     * @param <string> $order_id  订单编号
     * @return <bool> 是否成功
     */
    public function pay_check($user_id, $user_name, $money, $order_id){
        $date = date_f();
        $data = $this->provider->get_pay_by_order($order_id);
        if(empty($data)){
            return E(ErrorMessage::$ORDER_NOT_EXISTS);              //指定订单不存在
        }
        if(!pay_callback_check($data['payment'])){
            $this->provider->update_pay_status($order_id, 2);       //支付失败
            return E(ErrorMessage::$PAY_FAILED);
        }
        if($money > $data['money']){
            $money = $data['money'];
        }
        $this->provider->trans();                                   //事务开启
        if(!$this->provider->update_pay_status($order_id, 1)){      //更新支付账单的状态
            $this->provider->rollback();                            //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        switch ($data['type']){
            case 1 :
                //账户充值
                $result = $this->recharge($data['user_id'], $user_name, $money, $data['payment']);
                if(is_zerror($result)){
                    $this->provider->rollback();                            //事务回滚
                    return $result;
                }
                break;
            case 2 :
                //账户充值
                $result = $this->recharge($data['user_id'], $user_name, $money, $data['payment']);
                if(is_zerror($result)){
                    $this->provider->rollback();                            //事务回滚
                    return $result;
                }
                //更换套餐
                $domain = new UserDomain();
                $result = $domain->change_package($data['user_id'], $data['sup']);
                if(is_zerror($result)){
                    $this->provider->rollback();                            //事务回滚
                    return $result;
                }
                AccessControl::set_package($package_id);
                break;
        }
        $this->provider->commit();                                          //事务提交
        return true;
    }

    /**
     * 充值
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <double> $money     充值金额
     * @param  <string> $pay_type  支付方式
     * @return <bool> 是否成功
     */
    public function recharge($user_id, $user_name, $money, $pay_type){
        if($money <= 0)
            return E(ErrorMessage::$MONEY_ERROR);           //金额错误
        $date = date_f();
        $bill = $this->provider->get_bill_info($user_id);
        if(empty($bill))
            return E(ErrorMessage::$BILL_NOT_EXISTS);       //指定账单不存在
        $this->provider->trans();                           //事务开启
        //添加账单记录
        if(!$this->provider->add_bill_record($user_id, $user_name, '充值', 1, $money, 0, $bill['cash'] + $money, $pay_type, $date)){
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);      //操作失败
        }
        //添加充值记录
        if(!$this->provider->add_recharge_record($user_id, $user_name, $money, $date, $pay_type)){
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);      //操作失败
        }
        //更新收入
        if(!$this->provider->update_income($user_id, $money)){
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);      //操作失败
        }
        $this->provider->commit();                          //事务提交
        return true;
    }

    /**
     * 消费
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <double> $money     消费金额
     * @param  <string> $title     消费类型
     * @return <bool> 是否成功
     */
    public function consume($user_id, $user_name, $money, $title){
        if($money < 1)
            return E(ErrorMessage::$MONEY_ERROR);           //金额错误
        $date = date_f();
        $bill = $this->provider->get_bill_info($user_id);
        if(empty($bill))
            return E(ErrorMessage::$BILL_NOT_EXISTS);       //指定账单不存在
        if($money > $bill['cash'])
            return E(ErrorMessage::$MONEY_NOT_ENOUGH);      //余额不足
        $this->provider->trans();                           //事务开启
        //添加账单记录
        if(!$this->provider->add_bill_record($user_id, $user_name, $title, 2, 0, $money, $bill['cash'] - $money, '', $date)){
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);      //操作失败
        }
        //更新支出
        if(!$this->provider->update_outlay($user_id, $money)){
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);      //操作失败
        }
//        $cprovider = new CreditProvider();
//        //增加信用增长记录
//        if(!$cprovider->add_credit_record($user_id, $user_name, intval($money), $title.'  消费:'.$money.'元', 1)){
//            $this->provider->rollback();                    //事务回滚
//            return E(ErrorMessage::$OPERATION_FAILED);      //操作失败
//        }
//        $pprovider = new ProfileProvider();
        //增加用户信誉度
//        if(!$pprovider->increase_credit($user_id, intval($money))){
//            $this->provider->rollback();                    //事务回滚
//            return E(ErrorMessage::$OPERATION_FAILED);      //操作失败
//        }
        $this->provider->commit();                          //事务提交
        return true;
    }


    /**
     * 赚钱
     * @param  <int>    $user_id   用户编号
     * @param  <double> $money     消费金额
     * @param  <string> $title     消费类型
     * @return <bool> 是否成功
     */
    public function income($user_id, $money, $title){
        if($money < 1)
            return E(ErrorMessage::$MONEY_ERROR);           //金额错误
        $date = date_f();
        $bill = $this->provider->get_bill_info($user_id);
        if(empty($bill))
            return E(ErrorMessage::$BILL_NOT_EXISTS);       //指定账单不存在
        $this->provider->trans();                           //事务开启
        //添加账单记录
        if(!$this->provider->add_bill_record($user_id, '', $title, 1, $money, 0, $bill['cash'] + $money, '', $date)){
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);      //操作失败
        }
        //更新收入
        if(!$this->provider->update_income($user_id, $money)){
            $this->provider->rollback();                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);      //操作失败
        }
        $this->provider->commit();                          //事务提交
        return true;
    }

    /**
     * 获取指定支付方式信息
     * @param  <int> $id 支付方式编号
     * @return <array> 支付方式信息
     */
    public function get_payment($id){
        return $this->provider->get_payment($id);
    }

    /**
     * 申请提现
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <double> $money     提现金额
     * @return <bool> 是否成功
     */
    public function withdraw_apply($user_id, $user_name, $money){}

    /**
     * 提现审核
     * @param  <int>    $admin_id    审核管理员编号
     * @param  <string> $withdraw_id 提现记录编号
     * @param  <int>    $status      审核结果
     * @return <bool> 是否成功
     */
    public function withdraw_verify($admin_id, $withdraw_id, $status){}

    /**
     * 获取账单信息
     * @param  <int> $user_id 用户编号
     * @return <mixed> 账单信息
     */
    public function get_bill_info($user_id){
        return $this->provider->get_bill_info($user_id);
    }

    /**
     * 获取用户账单记录列表
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $type    类型（0为所有，1为收入，2为支出）
     * @param  <int>    $from    起始时间
     * @param  <int>    $to      结束时间
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <string> $order   排序条件
     * @param  <bool>   $count   是否统计总条数
     * @return <miexd> 账单记录列表
     */
    public function get_bill_record_list($user_id, $type, $from, $to, $page, $size, $order, $count = false){
        return $this->provider->get_bill_record_list($user_id, $this->filter_type($type), $from, $to, intval($page), intval($size), $order, $count);
    }

    /**
     * 获取用户充值记录
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $from    起始时间
     * @param  <int>    $to      结束时间
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <string> $order   排序条件
     * @return <miexd> 记录列表
     */
    public function get_recharge_list($user_id, $from, $to, $page, $size, $order){}

    /**
     * 获取用户提现记录
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $from    起始时间
     * @param  <int>    $to      结束时间
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <string> $order   排序条件
     * @return <miexd> 记录列表
     */
    public function get_withdraw_list($user_id, $from, $to, $page, $size, $order){}
    
    //----------------protected-----------------
    /**
     * 账单类型过滤
     * @param  <int> $type 账单类型
     * @return <int>
     */
    protected function filter_type($type){
        switch ($type){
            case 0  :
            case 1  :
            case 2  : break;
            default : $type = 0;
        }
        return intval($type);
    }

    /**
     * 检测套餐选取是否合法
     * @param  <int>    $id      套餐编号
     * @param  <double> $money   金额
     * @param  <int>    $user_id 用户编号
     * @return <mixed>
     */
    protected function check_package($id, $money, $user_id){
        $ppvd    = new PackageProvider();
        $package = $ppvd->get_package($id);
        if(empty($package)){
            return E(ErrorMessage::$PACKAGE_NOT_EXISTS);            //套餐不存在
        }
        if($money != $package['money']){
            return E(ErrorMessage::$PACKAGE_MONEY_ERROR);           //套餐价格错误
        }
        $upvd = new UserProvider();
        $role = $upvd->get_role_by_id($user_id);
        if($role != $package['role_id']){
            return E(ErrorMessage::$PACKAGE_ROLE_ERROR);            //套餐角色错误
        }
        return true;
    }

    /**
     * 生成汇款订单
     * @param  <int> $user_id 用户编号
     * @param  <int> $money   汇款金额
     * @return <int> 订单编号
     */
    public function create_remittance_order($user_id, $money){
        if($money < 1){
            return E(ErrorMessage::$MONEY_ERROR);           //金额错误
        }
        $result = $this->provider->create_remittance_order($user_id, $money);
        if(!$result){
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        return $result;
    }
}
?>
