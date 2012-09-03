<?php
/**
 * 建议模型
 * @author YoyiorLee
 */
class SuggestionDomainModel extends ModelBase{
    /**
     * 编号
     * @var <int>
     */
    protected $id;

    /**
     * 用户编号
     * @var <int>
     */
    protected $user_id;

    /**
     * 用户名
     * @var <int>
     */
    protected $user_name;

    /**
     * 对方用户名
     * @var <string>
     */
    protected $other_name;

    /**
     * 内容
     * @var <string>
     */
    protected $content;

    /**
     * 类型
     * @var <string>
     */
    protected $type;

    /**
     * 类型名称
     * @var <string>
     */
    protected $type_name;

    /**
     * 日期
     * @var <datetime>
     */
    protected $date;

    /**
     * 是否删除
     * @var <string>
     */
    protected $is_del;
}
?>
