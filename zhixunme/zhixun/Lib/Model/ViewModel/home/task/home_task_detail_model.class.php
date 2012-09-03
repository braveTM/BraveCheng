<?php
/**
 * 详细任务模型
 * @author YoyiorLee
 */
class home_task_detail_model {
    /**
     * 任务编号
     * @var <int>
     */
    public $id;

    /**
     * 任务标题
     * @var <string>
     */
    public $title;

    /**
     * 任务内容
     * @var <string>
     */
    public $content;

    /**
     * 手机
     * @var <string>
     */
    public $phone;

    /**
     * 邮箱
     * @var <string>
     */
    public $email;

    /**
     * QQ
     * @var <string>
     */
    public $qq;

    /**
     * 访客头像
     * @var <string>
     */
    public $photo;

    /**
     * 发布时间
     * @var <string>
     */
    public $start_time;

    /**
     * 结束时间
     * @var <string>
     */
    public $end_time;

    /**
     * 任务链接地址
     * @var <string>
     */
    public $url;

    /**
     * 投标数
     * @var <int>
     */
    public $rcount;

    /**
     * 浏览数
     * @var <int>
     */
    public $scount;

    /**
     * 任务状态
     * @var <int>
     */
    public $status;

    /**
     * 任务状态文字版
     * @var <string>
     */
    public $tstatus;

    /**
     * 任务分类
     * @var <int>
     */
    public $class_b;
    
    /**
     * 用户信息
     * @var <mixed>
     */
    public $user;

    /**
     * 访客信息
     * @var <mixed>
     */
    public $self;

    /**
     * 是否显示竞标框
     * @var <int>
     */
    public $show_text;

    /**
     * 是否显示联系方式
     * @var <int>
     */
    public $show_contact;

    /**
     * 是否显示PS
     * @var <int>
     */
    public $show_ps;
}
?>
