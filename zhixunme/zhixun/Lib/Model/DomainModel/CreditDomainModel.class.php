<?php
/**
 * Description of CreditDomainModel
 *
 * @author moi
 */
class CreditDomainModel extends ModelBase {
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
     * 增长信誉度
     * @var <int>
     */
    public $credit;

    /**
     * 增长原因
     * @var <string>
     */
    public $reason;

    /**
     * 增长类型
     * @var <int>
     */
    public $type;

    /**
     * 日期
     * @var <int>
     */
    public $date;
}
?>
