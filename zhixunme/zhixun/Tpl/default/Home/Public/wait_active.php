<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>激活邮件 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/regis_area_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$js_root}/{$jqlib}/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">108</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::Home:Public:ie6::60 -->
        <div class="regis_page pub_page">
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
                        <if condition="$type neq 1">
                            <div class="devsion">
                                <ul class="t_np">
                                    <switch name="type">
                                        <case value="2">
                                            <li class="t_01 cu_li"><b>1、</b>企业注册<div class="cur_ste"></div></li>
                                        </case>
                                        <case value="3">
                                            <li class="t_01 cu_li"><b>1、</b>猎头注册<div class="cur_ste"></div></li>
                                        </case>
                                    </switch>
                                    <li class="t_02"><b>2、</b>邮箱验证<div class="cur_ste"></div></li>
                                    <li class="t_03 sgray"><b>3、</b>成功注册</li>
                                </ul>
                            </div>
                        </if>
                        <div class="clr"></div>
                        <div class="t_wrap">
                            <div class="t_eip">
                                <p class="blue">欢迎加入职讯网</p>
                                <input id="email" type="hidden" value="{$email}" />
                                <p class="t_p">您的登录邮箱为: <span class="blue" id="ac_em">{$email}</span> </p>
                                <p class="t_p">系统已向您的邮箱发送了一封验证邮件,请点击邮件中的链接地址来激活您的帐号</p>
                                <p class="gray t_p">如果您长时间未收到邮件，请尝试点击：
                                    <a href="javascript:;" title="重新发送" class="blue resend" id="re_send">重新发送</a>
                                    <a class="loading blue">正在发送,请稍后···</a>
                                </p>
                                <div class="below_tip">
                                    <div class="smile_tip lf">
                                    </div>
                                    <div class="act_em btn5 btn_common rf">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a class="btn white" id="active_em" href="#" target="_blank">去邮箱激活</a>
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
            <!-- layout::Public:footeregister::60 -->
        </div>
    </body>
    <script type="text/javascript">
        function iniEmail(){
            var mails ={
                'sdo.com':'m.sdo.com',
                "163.com":"mail.163.com",
                "sina.com.cn":"mail.sina.com.cn",
                "sohu.com":"mail.sohu.com",
                "tom.com":"mail.tom.com",
                "sogou.com":"mail.sogou.com",
                "126.com":"mail.126.com",
                "10086.cn":"mail.10086.cn",
                "gmail.com":"www.gmail.com",
                "hotmail.com":"www.hotmail.com",
                "189.cn":"www.189.cn",
                "vip.qq.com":"mail.qq.com",
                "qq.com":"mail.qq.com",
                "foxmail.com":"mail.qq.com",
                "yahoo.com.cn":"mail.cn.yahoo.com",
                "eyou.com":"www.eyou.com",
                "yahoo.com":"mail.yahoo.com",
                "21cn.com":"mail.21cn.com",
                "188.com":"www.188.com",
                "yeah.net":"www.yeah.net",
                "wo.com.cn":"mail.wo.com.cn",
                "263.net":"www.263.net"
            };
            var mail = mails["{$email}".replace(/.+@/,"")];
            if(typeof(mail)!="undefined"){
                var that=$("#active_em");
                that.attr("href","http://"+mail);
                that.parent().removeClass("hidden");
            }
        }
        iniEmail();
    </script>
</html>
