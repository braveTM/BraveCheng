<?php
/**
 * Description of BillProvider
 *
 * @author moi
 */
class BillProvider extends BaseProvider{
    /**
     * 添加用户账单
     * @param  <int>    $user_id   用户编号
     * @return <bool> 是否成功
     */
    public function add_bill($user_id){
        $this->da->setModelName('bill');                //使用账单表
        $data['user_id']      = $user_id;
        $data['cash']         = 0;
        $data['outlay_count'] = 0;
        $data['income_count'] = 0;
        $data['outlay_money'] = 0;
        $data['income_money'] = 0;
        $data['freeze_money'] = 0;
        $data['is_del']       = 0;
        return $this->da->add($data) !== false;
    }

    /**
     * 增加收入
     * @param  <int>    $user_id 用户编号
     * @param  <double> $money   金额
     * @return <bool> 是否成功
     */
    public function update_income($user_id, $money){
        $this->da->setModelName('bill');                //使用账单表
        $where['user_id'] = $user_id;
        if($this->da->setInc('cash', $where, $money) && $this->da->setInc('income_count', $where, 1) && $this->da->setInc('income_money', $where, $money))
            return true;
        return false;
    }

    /**
     * 增加支出
     * @param  <int>    $user_id 用户编号
     * @param  <double> $money   金额
     * @return <bool> 是否成功
     */
    public function update_outlay($user_id, $money){
        $this->da->setModelName('bill');                //使用账单表
        $where['user_id'] = $user_id;
        if($this->da->setDec('cash', $where, $money) && $this->da->setInc('outlay_count', $where, 1) && $this->da->setInc('outlay_money', $where, $money))
            return true;
        return false;
    }

    /**
     * 获取支付方式列表
     * @return <mixed> 列表
     */
    public function get_pay_type_list(){
        $this->da->setModelName('pay_type');             //支付方式表
        return $this->da->where(array('is_del' => 0))->order('sort desc')->select();
    }

    /**
     * 添加支付临时记录
     * @param  <int>    $user_id  用户编号
     * @param  <double> $money    金额
     * @param  <int>    $payment  支付方式
     * @param  <string> $order_id 订单编号
     * @param  <string> $type     订单类型
     * @param  <string> $sup      额外参数
     * @param  <date>   $date     日期
     * @return <bool> 是否成功
     */
    public function add_pay_temp($user_id, $money, $payment, $order_id, $type, $sup, $date){
        $this->da->setModelName('pay_temp');             //支付临时表
        $data['user_id']  = $user_id;
        $data['order_Id'] = $order_id;
        $data['payment']  = $payment;
        $data['money']    = $money;
        $data['date']     = $date;
        $data['type']     = $type;
        $data['sup']      = $sup;
        $data['status']   = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 更新支付信息状态
     * @param <string> $order_id 订单编号
     * @param <int>    $status   状态
     * @return <bool> 是否成功
     */
    public function update_pay_status($order_id, $status){
        $this->da->setModelName('pay_temp');             //支付临时表
        $where['order_id'] = $order_id;
        $data['status']    = $status;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 根据账单编号获取支付信息
     * @param  <string> $order_id 账单编号
     * @return <mixed>
     */
    public function get_pay_by_order($order_id){
        $this->da->setModelName('pay_temp');             //支付临时表
        $where['order_id'] = $order_id;
        return $this->da->where($where)->find();
    }

    /**
     * 获取指定支付方式信息
     * @param  <int> $id 支付方式编号
     * @return <array> 支付方式信息
     */
    public function get_payment($id){
        $this->da->setModelName('pay_type');             //支付方式表
        $where['id']     = $id;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 添加用户充值记录
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <double> $money     充值金额
     * @param  <date>   $date      日期
     * @param  <int>    $pay_type  支付方式
     * @return <bool> 是否成功
     */
    public function add_recharge_record($user_id, $user_name, $money, $date, $pay_type){
        $this->da->setModelName('bill_recharge');        //使用充值表
        $data['user_id']   = $user_id;
        $data['user_name'] = $user_name;
        $data['money']     = $money;
        $data['date']      = $date;
        $data['type']      = $pay_type;
        $data['is_del']    = 0;
        return $this->da->add($data) != false;
        
    }

    /**
     * 添加用户账单记录
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <string> $title     账单标题
     * @param  <int>    $type      账单类型（1为收入，2为支出）
     * @param  <double> $income    收入金额
     * @param  <double> $outlay    支出金额
     * @param  <double> $surplus   剩余现金
     * @param  <int>    $pay_type  支付方式
     * @param  <date>   $date      日期
     * @param  <string> $remark    账单备注
     * @return <bool> 是否成功
     */
    public function add_bill_record($user_id, $user_name, $title, $type, $income, $outlay, $surplus, $pay_type, $date, $remark = ''){
        $this->da->setModelName('bill_record');           //使用账单记录表
        $data['user_id']      = $user_id;
        $data['user_name']    = $user_name;
        $data['bill_title']   = $title;
        $data['bill_type']    = $type;
        $data['income_money'] = $income;
        $data['outlay_money'] = $outlay;
        $data['surplus_cash'] = $surplus;
        $data['pay_type']     = $pay_type;
        $data['bill_remark']  = $remark;
        $data['date']         = $date;
        $data['is_del']       = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 添加提现记录
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <double> $money     提现金额
     * @param  <date>   $date      日期
     * @return <bool> 是否成功
     */
    public function add_withdraw_record($user_id, $user_name, $money, $date){
        $this->da->setModelName('bill_withdraw');        //使用提现表
        $data['user_id']    = $user_id;
        $data['user_name']  = $user_name;
        $data['money']      = $money;
        $data['start_time'] = $date;
        $data['end_time']   = $date;
        $data['admin_id']   = 0;
        $data['status']     = 1;
        $data['is_del']     = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 设置提现审核状态
     * @param  <int>    $admin_id    审核管理员编号
     * @param  <string> $withdraw_id 提现记录编号
     * @param  <int>    $status      审核结果
     * @param  <date>   $date        审核日期
     * @return <bool> 是否成功
     */
    public function set_withdraw_status($admin_id, $withdraw_id, $status, $date){
        $this->da->setModelName('bill_withdraw');        //使用提现表
        $where['id']      = $withdraw_id;
        $where['is_del']  = 0;
        $data['end_time'] = $date;
        $data['admin_id'] = $admin_id;
        $data['status']   = $status;
        return $this->da->where($where)->save($data) != false;
    }

    /**
     * 获取账单信息
     * @param  <int> $user_id 用户编号
     * @return <mixed> 账单信息
     */
    public function get_bill_info($user_id){
        $this->da->setModelName('bill');                //使用账单表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        return $this->da->where($where)->find();
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
        $this->da->setModelName('bill_record');                 //使用账单记录表
        $where['user_id'] = $user_id;
        if($type === 1 || $type === 2)                          
            $where['bill_type'] = $type;                        //账单类型筛选条件
        if(!empty($from)){
            if(!empty($to)){
                $where['date'] = array('between', "'$from','$to'"); //日期筛选条件
            }
            else{
                $where['date'] = array('egt', $from);           //日期筛选条件
            }
        }
        else if(!empty($to)){
            $where['date'] = array('elt', $to);                 //日期筛选条件
        }
        $where['is_del'] = 0;
        if(empty($order))
            $order = 'date DESC';
        if($count)
            return $this->da->where($where)->count('user_id');
        else
            return $this->da->where($where)->page($page.','.$size)->order($order)->select();
    }

    /**
     * 获取用户充值记录
     * @param  <int>    $user_id 用户编号
     * @param  <date>   $from    起始时间
     * @param  <date>   $to      结束时间
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <string> $order   排序条件
     * @return <miexd> 记录列表
     */
    public function get_recharge_list($user_id, $from, $to, $page, $size, $order){
        $this->da->setModelName('bill_recharge');               //使用充值表
        $where['user_id'] = $user_id;
        if(!empty($from)){
            if(!empty($to)){
                $where['date'] = array('between', "'$from','$to'"); //日期筛选条件
            }
            else{
                $where['date'] = array('egt', $from);           //日期筛选条件
            }
        }
        else if(!empty($to)){
            $where['date'] = array('elt', $to);                 //日期筛选条件
        }
        $where['is_del'] = 0;
        return $this->da->where($where)->page($page.','.$size)->order($order)->select();
    }

    /**
     * 获取用户提现记录
     * @param  <int>    $user_id 用户编号
     * @param  <date>   $from    起始时间
     * @param  <date>   $to      结束时间
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <string> $order   排序条件
     * @return <miexd> 记录列表
     */
    public function get_withdraw_list($user_id, $from, $to, $page, $size, $order){
        $this->da->setModelName('bill_withdraw');                   //使用提现表
        $where['user_id'] = $user_id;
        if(!empty($from)){
            if(!empty($to)){
                $where['end_time'] = array('between', "'$from','$to'"); //日期筛选条件
            }
            else{
                $where['end_time'] = array('egt', $from);           //日期筛选条件
            }
        }
        else if(!empty($to)){
            $where['end_time'] = array('elt', $to);                 //日期筛选条件
        }
        $where['is_del'] = 0;
        return $this->da->where($where)->page($page.','.$size)->order($order)->select();
    }

    /**
     * 生成汇款订单
     * @param  <int> $user_id 用户编号
     * @param  <int> $money   汇款金额
     * @return <int> 订单编号
     */
    public function create_remittance_order($user_id, $money){
        $this->da->setModelName('remittance_order');            //使用汇款订单表
        $data['user_id']    = $user_id;
        $data['money']      = $money;
        $data['status']     = 0;
        $data['reason']     = '';
        $data['start_time'] = date_f();
        $data['end_time']   = $data['start_time'];
        $data['is_del']     = 0;
        return $this->da->add($data);
    }
}
?>
