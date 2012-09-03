<?php
/**
 * 竞标任务模型
 * @author YoyiorLee
 */
class home_task_reply_model {
    /**
     * 竞标编号
     * @var <int>
     */
    public $id;
    /**
     * 任务编号
     * @var <int>
     */
    public $task_id;

    /**
     * 联系电话
     * @var <string>
     */
    public $contact;

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
     * 竞标内容
     * @var <string>
     */
    public $content;

    /**
     * 竞标时间
     * @var <string>
     */
    public $date;

    /**
     * 是否中标
     * @var <string>
     */
    public $is_bid;

    /**
     * 用户编号
     * @var <int>
     */
    public $user_id;

    /**
     * 用户昵称
     * @var <string>
     */
    public $user_name;

    /**
     * 用户类型
     * @var <int>
     */
    public $user_type;

    /**
     * 用户头像
     * @var <string>
     */
    public $photo;

    /**
     * 实名认证
     * @var <string>
     */
    public $auth_real;

    /**
     * 手机认证
     * @var <string>
     */
    public $auth_phone;

    /**
     * 邮箱认证
     * @var <string>
     */
    public $auth_email;

    /**
     * 用户链接地址
     * @var <string>
     */
    public $url;

}
?>
