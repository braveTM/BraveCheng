<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>注册成功 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/regis_area_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>  
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
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
                        <p class="clr"></p>
                        <div class="t_wrap">
                            <div class="t_eip">
                                <p class="blue">邮箱验证已成功,开始职讯之旅！</p>
                                <p class="t_p">您的邮箱: <span class="blue"> {$email}</span>, 已通过系统认证</p>
                                <p class="t_p"><span id="timer" class="red">10</span>秒之后将带您进入您的<a href="{$web_root}/rhome/" title="" class="blue">个人中心</a>,开始您的职讯之旅吧!</p>
                                <div class="below_tip">
                                    <div class="sm_tip lf">
                                    </div>
                                    <div class="succ_r btn5 btn_common rf">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a  class="btn white" href="{$web_root}/rhome/">开始职讯之旅</a>
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
        function GetCookie(c_name){
            if(document.cookie.length>0){
                var c_start=document.cookie.indexOf(c_name + "=");
                var c_end='';
                if(c_start!=-1){
                    c_start=c_start + c_name.length+1;
                    c_end=document.cookie.indexOf(";",c_start);
                    if (c_end==-1) c_end=document.cookie.length;
                    return unescape(document.cookie.substring(c_start,c_end));
                }
            }
            return "";
        }
        function DelCookie(c_name){
            var exp = new Date();
            exp.setTime(exp.getTime() - 1);
            var cval=HGS.Base.GetCookie(c_name);
            if(cval!=null) document.cookie= c_name + "="+cval+";expires="+exp.toGMTString()+";path=/";
        }
        if(GetCookie("reurl").length>0){
            location.href=GetCookie("reurl");
        }else{
            var t=10;
            setInterval(function(){
                t=t-1;
                document.getElementById("timer").innerHTML=t;
            },1000);
            setTimeout(function(){
                location.href="{$web_root}/rhome/";
            },10000);
        }                
    </script>
</html>
