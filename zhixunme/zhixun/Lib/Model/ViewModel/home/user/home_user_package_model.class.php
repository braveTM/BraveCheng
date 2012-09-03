<?php
/**
 * Description of home_user_package_model
 *
 * @author moi
 */
class home_user_package_model {
    /**
     * 套餐编号
     * @var <int>
     */
    public $id;

    /**
     * 套餐名称
     * @var <string>
     */
    public $name;
    
    /**
     * 套餐价格
     * @var <int>
     */
    public $price;
    
    /**
     * 套餐期限单位
     * @var <string>
     */
    public $unit;

    /**
     * 套餐优惠政策
     * @var <array>
     */
    public $favorable;
}
?>
