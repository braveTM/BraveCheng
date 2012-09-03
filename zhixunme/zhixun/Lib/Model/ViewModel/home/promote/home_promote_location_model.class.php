<?php
/**
 * Description of home_promote_location_model
 *
 * @author moi
 */
class home_promote_location_model {
    /**
     * 推广位编号
     * @var <int>
     */
    public $id;

    /**
     * 推广位标题
     * @var <string>
     */
    public $title;

    /**
     * 推广位单价
     * @var <int>
     */
    public $price;

    /**
     * 最小购买天数
     * @var <int>
     */
    public $min_days;

    /**
     * 最大购买天数
     * @var <int>
     */
    public $max_days;

    /**
     * 排序
     * @var <int>
     */
    public $sort;

    /**
     * 占用情况
     * @var <int>
     */
    public $hold;
}
?>
