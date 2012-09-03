<?php
/**
 * 任务模型
 * @author YoyiorLee
 */
class TaskDomainModel extends ModelBase{
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
     * 任务分类
     * @var <int>
     */
    protected $type;

    /**
     * 电话
     * @var <string>
     */
    protected $phone;

    /**
     * 邮箱
     * @var <string>
     */
    protected $email;

    /**
     * qq
     * @var <string>
     */
    protected $qq;

    /**
     * 任务分类名称
     * @var <string>
     */
    protected $type_name;

    /**
     * 最低价格
     * @var <int>
     */
    protected $min_price;

    /**
     * 最高价格
     * @var <int>
     */
    protected $max_price;

    /**
     * 发布时间
     * @var <datetime>
     */
    protected $start_time;

    /**
     * 过期时间
     * @var <datetime>
     */
    protected $end_time;
    /**
     * 浏览次数
     * @var <int>
     */
    protected $read_count;

    /**
     * 评论数
     * @var <int>
     */
    protected $comment_count;

    /**
     * 任务状态
     * @var <int>
     */
    protected $status;

    /**
     * 排序级别
     * @var <int>
     */
    protected $sort;

    /**
     * 是否删除
     * @var <int>
     */
    protected $is_del;
}
?>
