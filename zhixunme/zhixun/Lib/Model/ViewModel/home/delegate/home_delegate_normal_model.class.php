<?php
/**
 * 普通委托页面模型（Normal）
 * @author YoyiorLee
 */
class home_delegate_normal_model {
    /**
     * 委托编号
     * @var <int>
     */
    public $id;

    /**
     * 用户编号
     * @var <int>
     */
    public $user_id;

    /**
     * 用户名称
     * @var <string>
     */
    public $user_name;

    /**
     * 委托人编号
     * @var <int>
     */
    public $delegate_id;

    /**
     * 委托人名称
     * @var <string>
     */
    public $delegate_name;

    /**
     * 委托链接地址
     * @var <string>
     */
    public $url;

    /**
     * 用户链接地址
     * @var <string>
     */
    public $uurl;

    /**
     * 标题
     * @var <string>
     */
    public $title;

    /**
     * 内容
     * @var <string>
     */
    public $content;

    /**
     * 任务日期
     * @var <datetime>
     */
    public $date;

    /**
     * 任务状态
     * @var <string>
     */
    public $status;

    /**
     * 任务状态编号
     * @var <int>
     */
    public $sid;
}
?>
