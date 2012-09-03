<?php
require_cache(APP_PATH.'/Common/Class/mailer.class.php');
/**
 * 发送邮件
 * @param  <string> $to           收件人邮箱
 * @param  <string> $body         邮件内容
 * @param  <string> $subject      邮件主题
 * @param  <string> $send_name    发件人名称
 * @param  <string> $receive_name 收件人名称
 * @return <bool> 是否成功
 */
function send_email($to, $body, $subject, $send_name = '', $receive_name = ''){
    //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
    if($send_name == '')
        $send_name = C('SEND_NAME');
    if($receive_name == '')
        $receive_name = C('RECEIVE_NAME');
    error_reporting(E_STRICT);
    date_default_timezone_set("Asia/Shanghai");         //设定时区东八区
    $from             = C("ADMIN_EMAIL");
    $mail             = new PHPMailer();                //实例化一个PHPMailer对象
    $body             = ereg_replace("[\]",'',$body);   //对邮件内容进行必要的过滤
    $mail->CharSet    = C("CHARSET");                   //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();                                    // 设定使用SMTP服务
    $mail->SMTPDebug  = 1;                              // 启用SMTP调试功能 (1 = errors and messages 2 = messages only)
    $mail->SMTPAuth   = C("SMTPAUTH");                  // 启用 SMTP 验证功能
    $mail->SMTPSecure = C("SMTPSECURE");                // 安全协议
    $mail->Host       = C("SMTPHOST");                  // SMTP 服务器
    $mail->Port       = C("SMTPPORT");                  // SMTP服务器的端口号
    $mail->Username   = C("ADMIN_USER");                // SMTP服务器用户名
    $mail->Password   = C("ADMIN_PASSWORD");            // SMTP服务器密码
    $mail->SetFrom($from, $send_name);
    $mail->AddReplyTo($from,$send_name);
    $mail->Subject    = $subject;
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer! - From www.peedan.com"; // optional, comment out and test
    $mail->MsgHTML($body);
    $address = $to;
    $mail->AddAddress($address, $receive_name);
    //$mail->AddAttachment("images/phpmailer.gif");      // attachment
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    if(!$mail->Send()) {
        //return "Mailer Error: " . $mail->ErrorInfo;
        return false;
    }
    else {
        return true;
    }
}

/**
 * 获取邮箱验证的邮件内容
 * @param  <string> $user_name 用户名
 * @param  <string> $code      邮箱验证码
 * @return <string> 内容
 */
function get_email_auth_body($user_name, $code){
    return $user_name.'您好,http://192.168.0.105:8080/zhixun/do_email_verify/'.$code;
}

/**
 * 获取邮箱验证的邮件主题
 * @return <string> 主题
 */
function get_email_auth_subject(){
    return C('WEB_NAME').'邮箱认证申请';
}
?>
