<?php
/**
 * Description of home_user_index_model
 *
 * @author moi
 */
class home_user_index_model {
    /**
     * 用户编号
     * @var <string>
     */
    public $id;

    /**
     * 用户昵称
     * @var <string>
     */
    public $name;

    /**
     * 用户头像
     * @var <string>
     */
    public $photo;

    /**
     * 省份
     * @var <string>
     */
    public $province;

    /**
     * 城市
     * @var <string>
     */
    public $city;

    /**
     * 实名认证
     * @var <string>
     */
    public $auth_real;

    /**
     * 手机认证
     * @var <string>
     */
    public $auth_phone;

    /**
     * 邮箱认证
     * @var <string>
     */
    public $auth_email;

    /**
     * 银行卡认证
     * @var <string>
     */
    public $auth_bank;

    /**
     * 实名认证链接地址
     * @var <string>
     */
    public $arurl;

    /**
     * 手机认证链接地址
     * @var <string>
     */
    public $apurl;

    /**
     * 邮箱认证链接地址
     * @var <string>
     */
    public $aeurl;

    /**
     * 银行卡认证链接地址
     * @var <string>
     */
    public $aburl;

    /**
     * 资料完善度
     * @var <int>
     */
    public $schedule;

    /**
     * 资料完善页面
     * @var <string>
     */
    public $purl;

    /**
     * 正在进行任务数量
     * @var <int>
     */
    public $tcount;

    /**
     * 等待选标任务数量
     * @var <int>
     */
    public $wtcount;

    /**
     * 正在进行委托数量
     * @var <int>
     */
    public $dcount;

    /**
     * 等待选标委托数量
     * @var <int>
     */
    public $wdcount;

    /**
     * 账户余额
     * @var <double>
     */
    public $cash;

    /**
     * 充值页面链接地址
     * @var <string>
     */
    public $recharge;

    /**
     * 账单明细页面链接地址
     * @var <string>
     */
    public $bill;

    /**
     * 信息列表页面链接地址
     * @var <string>
     */
    public $murl;
}
?>
