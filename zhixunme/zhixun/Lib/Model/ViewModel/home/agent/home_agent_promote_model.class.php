<?php
/**
 * Description of home_agent_promote_model
 *
 * @author moi
 */
class home_agent_promote_model {
    /**
     * 推广服务编号
     * @var <int>
     */
    public $id;

    /**
     * 最多推广人数
     * @var <int>
     */
    public $m_count;
    
    /**
     * 剩余推广人数
     * @var <int>
     */
    public $s_count;
    
    /**
     * 单价
     * @var <int>
     */
    public $price;

    /**
     * 最小推广天数
     * @var <int>
     */
    public $min_days;

    /**
     * 最大推广天数
     * @var <int>
     */
    public $max_days;
}
?>
