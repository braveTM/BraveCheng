<?php
/**
 * Description of BillDomainModel
 *
 * @author moi
 */
class BillDomainModel extends ModelBase{
    /**
     * 用户编号
     * @var <int>
     */
    public $user_id;

    /**
     * 用户名
     * @var <string>
     */
    public $user_name;

    /**
     * 账单标题
     * @var <string>
     */
    public $bill_title;

    /**
     * 账单类型
     * @var <int>
     */
    public $bill_type;

    /**
     * 收入金额
     * @var <double>
     */
    public $income;

    /**
     * 支出金额
     * @var <double>
     */
    public $outlay;

    /**
     * 账户余额
     * @var <double>
     */
    public $surplus;

    /**
     * 账单备注
     * @var <string>
     */
    public $remark;

    /**
     * 支付方式
     * @var <int>
     */
    public $pay_type;

    /**
     * 交易日期
     * @var <date>
     */
    public $date;
}
?>
