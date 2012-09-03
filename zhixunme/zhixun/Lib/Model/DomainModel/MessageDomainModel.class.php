<?php
/**
 * 信息模型
 * @author YoyiorLee
 */
class MessageDomainModel extends ModelBase{
    /**
     * 编号
     * @var <int>
     */
    protected $id;

    /**
     * 发件人编号（系统编号为0）
     * @var <int>
     */
    protected $from_id;

    /**
     * 发件人名称
     * @var <varchar>
     */
    protected $from_name;

    /**
     * 是否对发件人可见
     * @var <int>
     */
    protected $from_show;

    /**
     * 收件人编号
     * @var <int>
     */
    protected $to_id;

    /**
     * 收件人名称
     * @var <varchar>
     */
    protected $to_name;

    /**
     * 是否对收件人可见
     * @var <int>
     */
    protected $to_show;

    /**
     * 收件人是否已查看
     * @var <int>
     */
    protected $to_read;

    /**
     * 信息标题
     * @var <string>
     */
    protected $title;

    /**
     * 信息内容
     * @var <string>
     */
    protected $content;

    /**
     * 回复编号
     * @var <int>
     */
    protected $reply_id;

    /**
     * 站内信类别
     * @var <int>
     */
    protected $type;

    /**
     * 日期
     * @var <datetime>
     */
    protected $date;

    /**
     * 是否已删除
     * @var <int>
     */
    protected $is_del;
}
?>
