<?php
/**
 * 回复任务模型
 * @author YoyiorLee
 */
class ReplyDomainModel extends ModelBase{
    /**
     * 编号
     * @var <int>
     */
    protected  $id;

    /**
     * 标题
     * @var <int>
     */
    protected $task_id;

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
     * 内容
     * @var <string>
     */
    protected $content;

    /**
     * 日期
     * @var <datetime>
     */
    protected $date;

    /**
     * 回复状态
     * @var <int>
     */
    protected $status;

    /**
     * 是否竞标
     * @var <int>
     */
    protected $is_bid;

    /**
     * 是否删除
     * @var <int>
     */
    protected $is_del;
}
?>
