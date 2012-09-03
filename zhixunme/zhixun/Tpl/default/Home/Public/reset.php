<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>设置新密码 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/getpwd.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$js_root}/{$jqlib}/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">64</script>  
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
                                    <li class="now">3、设置新密码</li>
                             </ul>
                            <div class="t_eip">
                                <span class="gray">建议使用包含数字和字母的密码，至少6个字符</span>
                                <div>
                                <div class="post">
                                    <span class="tl">新密码:</span>
                                    <input type="password" id="n_pwd" />
                                </div>
                                    </div>
                                <div>
                                <div class="post">
                                    <span class="tl">确认密码:</span>
                                    <input type="password" id="conf_pwd" />
                                </div>
                                </div>
                                <div class="below_tip">
                                    <div class="em_s btn5 btn_common ">
                                        <input type="hidden" value="{$token}" name="toke"/>
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a class="btn white" id="save_npd" href="javascript:;">保存</a>
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
