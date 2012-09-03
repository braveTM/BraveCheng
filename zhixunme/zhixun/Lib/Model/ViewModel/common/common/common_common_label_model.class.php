<?php
/**
 * Description of common_common_label_model
 *
 * @author moi
 */
class common_common_label_model {
    /**
     * 编号
     * @var <int>
     */
    public $id;

    /**
     * 名称
     * @var <string>
     */
    public $name;

    /**
     * 标题
     * @var <string>
     */
    public $title;

    /**
     * 拼音首字母
     * @var <char>
     */
    public $fletter;

    /**
     * 图标路径
     * @var <string>
     */
    public $icon;

    /**
     * 子分类
     * @var <array>
     */
    public $children;
}
?>
