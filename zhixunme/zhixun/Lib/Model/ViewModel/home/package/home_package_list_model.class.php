<?php
/**
 * Description of home_package_list_model
 *
 * @author moi
 */
class home_package_list_model {
    /**
     * 套餐编号
     * @var <int>
     */
    public $id;

    /**
     * 套餐标题
     * @var <string>
     */
    public $title;

    /**
     * 套餐价格
     * @var <int>
     */
    public $price;

    /**
     * 套餐使用期限
     * @var <int>
     */
    public $deadline;

    /**
     * 是否正在使用
     * @var <int>
     */
    public $use;

    /**
     * 套餐模块
     * @var <array>
     */
    public $modules;

    /**
     * 推荐信息
     * @var <string>
     */
    public $recom;
}
?>
