<?php
/**
 * Description of home_message_list_model
 *
 * @author moi
 */
class home_message_list_model {
    /**
     * 站内信编号
     * @var <int>
     */
    public $id;

    /**
     * 站内信标题
     * @var <string>
     */
    public $title;

    /**
     * 发件人编号
     * @var <int>
     */
    public $fid;

    /**
     * 发件人名称
     * @var <string>
     */
    public $fname;

    /**
     * 收件人编号
     * @var <int>
     */
    public $tid;

    /**
     * 收件人名称
     * @var <string>
     */
    public $tname;

    /**
     * 是否已读
     * @var <int>
     */
    public $read;

    /**
     * 日期
     * @var <string>
     */
    public $date;

    /**
     * 信息链接地址
     * @var <type> 
     */
    public $url;

    /**
     * 发件人地址
     * @var <type>
     */
    public $furl;

    /**
     * 收件人地址
     * @var <type>
     */
    public $surl;

    /**
     * 信息内容
     * @var <string>
     */
    public $content;
}
?>
