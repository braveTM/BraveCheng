<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>邮件发送成功 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/getpwd.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">65</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::Home:Public:ie6::60 -->
        <div class="get_pd pub_page">
            <div class="pub_top">
                <div class="p_t_txt">
                    <a href="{$web_root}" title="职讯网首页">
                        <img src="{$file_root}zhixun/Theme/default/vocat/imgs/system/wlogo.png" alt=""/>
                    </a>
                    <a href="{$web_root}" title="登录" class="white">登录</a>
                </div>
            </div>
            <div class="pub_mid">
                <div class="p_m_top">
                    <p class="p_m_l lf"></p>
                    <p class="p_m_r rf"></p>
                </div>
                <div class="p_m_mid">
                    <div class="p_m_mid_bg">
                        <div class="t_wrap">
                             <ul class="fpsw_nav blue">
                                    <li class="now">1、找回密码</li>
                                    <li class="now">2、验证密码保护信息</li>
                                    <li>3、设置新密码</li>
                              </ul>
                            <a href="{$web_root}/forgot" class="blue rf phonepsw">返回用手机号找回密码</a>
                            <div class="t_eip">                                                                                               
                                <p class="t_p">邮件已发送到您的邮箱:<input id="email" type="text" value="" readonly="readonly">,请点其中的链接重设密码。</p>
                                <p class="gray">如果长时间没有收到邮件,<span class="red" id="time">60</span>秒之后可点击:<span class="blue resend" id="re_send">重发邮件确认</span></p>
                                <div class="below_tip">
                                    <div class="smile_tip lf">
                                    </div>
                                    <div class="go_em btn_common btn5 rf">
                                    <span class="b_lf"></span>
                                    <span class="b_rf"></span>
                                    <a class="btn white go_mail" id="toemail" href="javascript:;" target="_blank">去邮箱看看</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="p_m_bot">
                    <p class="p_m_l lf"></p>
                    <p class="p_m_r rf"></p>
                </div>
            </div>
            <!-- layout::Public:footersimple::60 -->
        </div> 
    </body>
</html>
