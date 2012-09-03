<?php
/**
 * Description of home_delegate_detail_model
 *
 * @author moi
 */
class home_delegate_detail_model {
    /**
     * 委托编号
     * @var <int>
     */
    public $id;

    /**
     * 委托标题
     * @var <string>
     */
    public $title;

    /**
     * 委托内容
     * @var <string>
     */
    public $content;

    /**
     * 委托状态
     * @var <string>
     */
    public $status;

    /**
     * 委托标题
     * @var <日期>
     */
    public $date;

    /**
     * 申请用户编号
     * @var <int>
     */
    public $uid;

    /**
     * 申请用户昵称
     * @var <string>
     */
    public $uname;

    /**
     * 申请用户头像
     * @var <string>
     */
    public $uphoto;

    /**
     * 申请用户链接地址
     * @var <string>
     */
    public $url;

    /**
     * 申请用户手机
     * @var <string>
     */
    public $phone;

    /**
     * 申请用户邮箱
     * @var <string>
     */
    public $email;

    /**
     * 申请用户QQ
     * @var <string>
     */
    public $qq;

    /**
     * 回复用户编号
     * @var <int>
     */
    public $ruid;

    /**
     * 回复用户昵称
     * @var <string>
     */
    public $runame;

    /**
     * 回复用户头像
     * @var <string>
     */
    public $ruphoto;

    /**
     * 回复用户链接
     * @var <string>
     */
    public $rurl;

    /**
     * 回复内容
     * @var <string>
     */
    public $rcontent;

    /**
     * 回复用户手机
     * @var <string>
     */
    public $rphone;

    /**
     * 回复用户邮箱
     * @var <string>
     */
    public $remail;

    /**
     * 回复用户QQ
     * @var <string>
     */
    public $rqq;

    /**
     * 回复日期
     * @var <string>
     */
    public $rdate;

    /**
     * 是否显示回复
     * @var <int>
     */
    public $show_reply;
}
?>
