<?php
/**
 * Description of home_package_nomal_model
 *
 * @author moi
 */
class home_package_current_model {
    /**
     * 编号
     * @var <int>
     */
    public $id;

    /**
     * 套餐编号
     * @var <int>
     */
    public $pid;

    /**
     * 名称
     * @var <string>
     */
    public $title;

    /**
     * 是否免费套餐
     * @var <int>
     */
    public $free;

    /**
     * 价格
     * @var <int>
     */
    public $price;

    /**
     * 到期时间
     * @var <string>
     */
    public $date;

    /**
     * 到期剩余天数
     * @var <int>
     */
    public $days;

    /**
     * 期限
     * @var <int>
     */
    public $deadline;

    /**
     * 套餐模块优惠政策
     * @var <array>
     */
    public $modules;
}
?>
