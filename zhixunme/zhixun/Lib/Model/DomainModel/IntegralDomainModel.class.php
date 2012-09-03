<?php
/**
 * Description of IntegralDomainModel
 *
 * @author moi
 */
class IntegralDomainModel extends ModelBase{
    /**
     *
     * @var <int>
     */
    public $user_id;
    
    /**
     *
     * @var <string>
     */
    public $user_name;

    /**
     * 增长积分
     * @var <int>
     */
    public $integral;

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
