<?php
/**
 * Description of home_bill_details_model
 *
 * @author moi
 */
class home_bill_details_model {
    /**
     * 记录编号
     * @var <int>
     */
    public $id;

    /**
     * 标题
     * @var <string>
     */
    public $title;

    /**
     * 账单类型（1为收入，2为支出）
     * @var <int>
     */
    public $type;

    /**
     * 金额
     * @var <double>
     */
    public $money;

    /**
     * 日期
     * @var <string>
     */
    public $date;
}
?>
