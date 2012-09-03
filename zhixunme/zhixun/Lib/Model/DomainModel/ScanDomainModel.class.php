<?php
/**
 * 任务浏览模型
 * @author YoyiorLee
 */
class ScanDomainModel extends ModelBase{
    /**
     * 编号
     * @var <int>
     */
    protected $id;

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
     * 标题
     * @var <string>
     */
    protected $title;

    /**
     * 日期
     * @var <datetime>
     */
    protected $date;

    /**
     * 是否删除
     * @var <int>
     */
    protected $is_del;
}
?>
