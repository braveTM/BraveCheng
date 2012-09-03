<?php
/**
 * 委托模型
 * @author YoyiorLee
 */
class DelegateDomainModel extends ModelBase{
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
     * 委托对方用户编号
     * @var <int>
     */
    protected $delegate_id;

    /**
     * 标题
     * @var <string>
     */
    protected $title;

    /**
     * 内容
     * @var <string>
     */
    protected $content;

    /**
     * 分类A
     * @var <int>
     */
    protected $class_a;

    /**
     * 分类A名称
     * @var <string>
     */
    protected $class_a_name;

    /**
     * 分类B
     * @var <int>
     */
    protected $class_b;

    /**
     * 分类B名称
     * @var <int>
     */
    protected $class_b_name;

    /**
     * 日期
     * @var <datetime>
     */
    protected $date;

    /**
     * 委托状态
     * @var <int>
     */
    protected $status;

    /**
     * 是否删除
     * @var <int>
     */
    protected $is_del;
}
?>
