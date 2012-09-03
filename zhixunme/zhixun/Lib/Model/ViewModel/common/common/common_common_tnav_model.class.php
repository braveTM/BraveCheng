<?php
/**
 * 后台管理左边导航模型
 * @author YoyiorLee
 */
class common_common_tnav_model {
    /**
     * 导航编号
     * @var <int>
     */
    public $id;

    /**
     * 导航名称
     * @var <string>
     */
    public $title;

    /**
     * 导航分类图标
     * @var <string>
     */
    public $icon;

    /**
     * 链接地址
     * @var <string>
     */
    public $url;

    /**
     * 子分类
     * @var <array>
     */
    public $children;
}
?>
