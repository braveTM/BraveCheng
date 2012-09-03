<?php

/**
 * Description of MailAction
 *
 * @author brave
 */
class MailAction {

    public $smtp = array(
        array(
            'smtp' => 'smtp.gmail.com',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.gmail.com',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.yeah.net',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.163.com',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.163.com',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.yeah.net',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.126.com',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.yeah.net',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.163.com',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.yeah.net',
            'port' => 465,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
        array(
            'smtp' => 'smtp.ym.163.com',
            'port' => 25,
            'smtpauth' => true,
            'smtpsecure' => 'ssl',
        ),
    );
    public $mails = array(
        array(
            'username' => 'sir.bravecheng@gmail.com',
            'password' => 'md5chenghuiyong',
        ),
        array(
            'username' => 'zhixuncom@gmail.com',
            'password' => 'zhixunzjgh',
        ),
        array(
            'username' => 'wwwzhixunme@yeah.net',
            'password' => 'zhixunzjgh'
        ),
        array(
            'username' => 'zhixunme@163.com',
            'password' => 'zhixunzjgh',
        ),
        array(
            'username' => 'zhixunco@163.com',
            'password' => 'zhixunzjgh',
        ),
        array(
            'username' => 'zhixunme@yeah.net',
            'password' => 'zhixunzjgh',
        ),
        array(
            'username' => 'zhixunme@126.com',
            'password' => 'zhixunzjgh',
        ),
        array(
            'username' => 'zhixunco@yeah.net',
            'password' => 'zhixunzjgh',
        ),
        array(
            'username' => 'advert01@163.com',
            'password' => 'zhixunad044!',
        ),
        array(
            'username' => 'zhixuncom@yeah.net',
            'password' => 'zhixunzjgh',
        ),
        array(
            'username' => 'ad@zhixunba.com',
            'password' => 'zhixunad044!',
        ),
    );
    public $account = array();
    public $filename = '';
    public $switch = 5; //每发送10个邮箱切换一个smtp
    public $error_info = '';
    public $receive_name = '尊敬的职讯网用户';
    public $send_name = '职讯网';
    public $subject = array("建筑业最快捷的求职招聘通道，【职讯网】值得推荐！", "建筑企业与人才“招聘求职”快车【职讯网】值得推荐！");
    public $body = ' <div style="_text-aling:center;letter-spacing: 1px;width:100%;padding-bottom:20px;background-color:#f6f6f6;font-size:13px;color:#232323;font-family: \'微软雅黑\',Arial,Helvetica,sans-serif,STHeiti;height:100%;">
            <div style="width:706px;margin:0 auto;background:#fbfbfb url(\'http://www.zhixun.me/zhixun/Theme/default/vocat/imgs/system/leftshadow.png\') repeat-y 0 0;padding-left: 26px;position: relative;">
                <div style="height:100%;padding-right: 26px;background:url(\'http://www.zhixun.me/zhixun/Theme/default/vocat/imgs/system/rightshadow.png\') repeat-y right 0">
                    <div style="width:100%;background-color:#fbfbfb;">
                        <a title="职讯网" href="http://www.zhixun.me/?f=b_spread_mail"style="text-decoration: none;outline: none;blr:expression(this.onFocus=this.blur());" target="_blank"> <img src="http://www.zhixun.me/zhixun/Theme/default/vocat/imgs/system/header.png" style="border:none;height:106px;width:100%;display: block;" alt="职讯网"/></a>
                        <a href="http://www.zhixun.me/?f=b_spread_mail" target="_blank" style="text-decoration: none;outline: none;blr:expression(this.onFocus=this.blur());"title="立即体验">
                             <img src="http://www.zhixun.me/zhixun/Theme/default/vocat/imgs/system/fly.png" style="border:none;height:260px;width:680px;display:block" alt="" />
                         </a>
                         <div style="line-height:25px;padding:10px 30px 20px 30px;">
                            <p style="margin:5px 0 5px 0;font-size:14px;">还在苦苦寻觅？</p>
                            <p style="margin:0 0 10px 0;color:#888;">发了大量的帖子都石沉海底？打了大量的电话还是没有业务？还在各种小众网站游荡，寻找机会？还在五八、七八、九八 这类垃圾堆一样的分类信息网站苦苦寻觅？<strong style="color:#c00">那么，你真的OUT了！</strong></p>
                            <div style="overflow: hidden;width:100%;">
                                <p style="color:#00589A;text-align: center;font-size:18px;margin-bottom:20px;text-decoration:none;">———————<span style="margin:0 20px 0 20px">职讯网为建筑猎头量身定做</span>———————<p>
                                <div style="margin-bottom:15px;">
                                    <p style="color:#c00;margin:0;font-size:14px;">【免费营销推广】</p>
                                    <p style="margin:0 0 0 5px;">职讯网将为您做大量的免费营销工作，促进您的业务增长！让您坐等人才、企业找上门！</p>
                                </div>
                                 <div style="margin-bottom:15px;">
                                    <p style="color:#c00;margin:0;font-size:14px;">【0 成本入住】</p>
                                    <p style="margin:0 0 0 5px;">这一切都是免费的！零成本入住职讯，为您的业务锦上添花！</p>
                                </div>
                                 <div style="margin-bottom:15px;">
                                    <p style="color:#c00;margin:0;font-size:14px;">【赚积分 换增值套餐】</p>
                                    <p style="margin:0 0 0 5px;">职讯网全新推出积分系统！积分可以换取增值套餐，轻轻松松赚积分，毫无鸭梨找资源！</p>
                                </div>
                                 <div style="margin-bottom:15px;">
                                    <p style="color:#c00;margin:0;font-size:14px;">【全站套餐5折优惠】</p>
                                    <p style="margin:0 0 0 5px;">职讯夏日清凉优惠，全站套餐5折销售！买多少送多少！</p>
                                </div>
								<p style="margin-bottom:15px;text-align:center;"><a style="display: inline-block;padding: 7px 18px;background-color: #D44B38;color: white;font-size: 16px;font-weight: bold;border-radius: 2px;border: solid 1px #C43B28;white-space: nowrap;text-decoration: none;" href="http://www.zhixun.me/?f=b_spread_mail" title="立即去体验吧">立即去体验</a></p>
                                <p style="margin:0">更多活动细则，请参考<a href="http://www.zhixun.me/?f=b_spread_mail"style="color:#00589A;text-decoration:none;"target="_blank" title="点击查看更多详情">www.zhixun.me</a></p>
                                <div style="height:30px;line-height:30px;background-color:#efefef; margin:0 auto;text-align: center;margin-top:25px">
                                    <span style="color:#a2a2a2;">客服热线：</span>
                                    <span style="color:#006fba;">028-8533 3199</span>
                                    <span style="color:#a2a2a2;margin:0 20px;">周一至周六</span>
                                    <span style="color:#a2a2a2;">9：00~18:00</span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div style="height:4px;margin:0 -3px 0 -3px;width:686px;background:url(\'http://www.zhixun.me/zhixun/Theme/default/vocat/imgs/system/footer.png\') no-repeat 0 0"></div>
                    </div>
                </div>
                <div style="width:650px;margin:0 auto;padding-left: 30px;">
                    <p style="margin:0 0 5px 0;color:#686868;">本邮件由职讯系统自动发出，请不要直接回复。</p>
                    <p style="margin:0 0 5px 0;color:#686868">Copyright &copy; 2012 职讯，职讯网（www.zhixun.me） - 专注于建筑行业的求职招聘平台</p>
                </div>
				<img src="http://www.zhixun.me/edm04115207" style="border:none;height:1px;width:1px;display:none" alt="" />
         </div>';

    function index() {
        set_time_limit(0);
//        $this->filename = APP_PATH . '/broker.txt';
        $this->filename = 'broker.txt';
        $this->set_mail();
        printr(date('Ymdhis'));
        printr($this->account);
        printr($this->error_info);
    }

    function set_mail() {
        $yes = array();
        if (file_exists($this->filename)) {
            $count = explode(',', file_get_contents($this->filename));
            $section = (array_chunk($count, $this->switch));
            foreach ($section as $index => $email) {
                //切换服务器
                $exchange = floor($index / $this->switch);
                $yes[] = $this->switch_smtp($exchange, $email);
            }
            $this->account['faild'] = count($this->account['error']);
            $this->account['success'] = array_sum($yes);
            $this->account['total'] = count($count);
        } else {
            $this->error_info = $this->set_error(2);
        }
    }

    function switch_smtp($number_link, $email) {
        $index = $number_link % 10;
        $yes = 0;
        switch ($index) {
            case $index:
                require_cache(APP_PATH . '/Common/Class/mailer.class.php');
                $mail = new PHPMailer(); //new一个PHPMailer对象出来
                $mail->SMTPAuth = $this->smtp[$index]['smtpauth'];   // 启用 SMTP 验证功能
                $mail->SMTPSecure = $this->smtp[$index]['smtpsecure'];                 // 安全协议
                $mail->Host = $this->smtp[$index]['smtp'];      // SMTP 服务器
                $mail->Port = $this->smtp[$index]['port'];            // SMTP服务器的端口号
                $mail->Username = $this->mails[$index]['username'];  // SMTP服务器用户名
                $mail->Password = $this->mails[$index]['password'];   // SMTP服务器密码   
                $mail->SetFrom($this->mails[$index]['username'], $this->send_name);
                $mail->AddReplyTo($this->mails[$index]['username'], $this->send_name);
                error_reporting(E_STRICT);
                date_default_timezone_set("Asia/Shanghai"); //设定时区东八区
                $body = eregi_replace("[\]", '', $this->body); //对邮件内容进行必要的过滤
                $mail->CharSet = "UTF-8"; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
                $mail->IsSMTP(); // 设定使用SMTP服务
                $mail->SMTPDebug = 1;  // 启用SMTP调试功能 // 1 = errors and messages // 2 = messages only
                foreach ($email as $key => $to) {
                    if ($key % 2 == 0) {
                        $mail->Subject = $this->subject[0];
                    } else {
                        $mail->Subject = $this->subject[1];
                    }
                    $mail->AltBody = "To view the message, please use an HTML compatible email viewer! - From www.zhixun.me"; // optional, comment out and test
                    $mail->MsgHTML($body);
                    $address = $to;
                    $mail->AddAddress($address, $this->receive_name);
                    if (!$mail->Send()) {
                        $this->account['error'][$to] = $mail->ErrorInfo;
                    } else {
                        $yes++;
                    }
                }
                break;
            default :
                $this->error_info = $this->set_error(1);
                break;
        }
        return $yes;
    }

    function set_error($num) {
        $error = array(
            1 => '未知错误',
            2 => '文件读取失败',
        );
        return $error[$num];
    }

}

?>
