<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>找回密码 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/getpwd.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">63</script>  
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
                                    <li>2、验证密码保护信息</li>
                                    <li>3、设置新密码</li>
                                </ul>
                            <div class="t_eip">
                                
<!--                                <p class="blue">找回密码</p>                                -->
<!--                                <p class="t_p">请输入您的注册邮箱, 我们将发送一封密码重置邮件给您！</p>-->
                                <div class="below_tip">
                                    登录帐号:<input type="text" value="请输入您的登录邮箱或手机号" class="get_email gray" id="loginnum"/>
                                </div>
                                <div class="act_em btn5 btn_common">
                                    <span class="b_lf"></span>
                                    <span class="b_rf"></span>
                                    <a class="btn white" id="sen_eadr" href="javascript:;">提交</a>
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
            <!-- layout::Public:footeregister::60 -->
        </div>
    </body>
</html>
