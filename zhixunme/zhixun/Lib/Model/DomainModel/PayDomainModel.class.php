<?php
/**
 *
 * @author moi
 */
class PayDomainModel extends ModelBase {
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
     * 标题
     * @var <string>
     */
    public $title;

    /**
     * 交易类型
     * @var <int>
     */
    public $type;

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
     * 备注
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
     * @var <int>
     */
    public $date;
}
?>
