<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>帐户资料 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/remind.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">106</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 remind">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::{$z_left}::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="sm_tab">
                    <ul>
                        <li><a href="{$web_root}/profiles/0">基本资料</a></li>
                        <li><a href="{$web_root}/profiles/1">修改头像</a></li>
                        <li><a href="{$web_root}/profiles/2">修改密码</a></li>
                        <li><a href="{$web_root}/profiles/3">信用认证</a></li>
                        <li><a href="{$web_root}/setPrivacyAgent/4">隐私设置</a></li>
                        <li class="cur_li"><a href="{$web_root}/broker_remind/5">提醒设置</a></li>     
                    </ul>
                    <div class="sub_title">
                        <a href="javascript:;" title="" class="blue" id="uceter">设置</a>
                    </div>
                </div>
                <div class="t_container">
                    <div class="t_item hidden"></div>
                    <div class="t_item hidden"></div>
                    <div class="t_item hidden"></div>
                    <div class="t_item hidden"></div>
                    <div class="t_item hidden"></div>
                    <div class="t_item show">
                        <div class="rmd-wrap">
                            <p class="sytip">系统提示：职讯智能提醒系统(职讯小秘书)提供更加人性化的信息管理，方便、快捷地提高您的工作效率。</p>
                            <div class="rld lf">
                                <div class="msg_set set">
                                    <h2 class="title">
                                       客户管理 - 提醒设置:
                                    </h2>
                                    <p class="gray rtip">客户管理关键事件提醒。您在“客户管理-->档案详细页”填写的关键事件日期，可以在此统一设置提醒时间和提醒方式，系统将会按照您的设置自动提醒。快进入<a href="{$web_root}/resource" target="_blank" class="blue" title="客户管理">客户管理</a>模块体验吧！</p>
                                </div>
                                <div class="rem_set">
                                    <php>$ky=1;$lb=1;</php>
                                    <foreach name="notice_condition" item="nd">
                                        <php>$time_desc=$notice_user[$key];</php>
                                        <div class="md_com">
                                            <p class="pv{$key}" val="{$key}">{$nd}提醒</p>
                                            <div class="mli">
                                                <span>时间：</span>
                                                <input type="hidden" id="t_{$key}"value="{$notice_user[$key].time_type}" />
                                                <span><input type="radio" name="wd_{$key}" id="forward_{$lb}" value="1" /> <label for="forward_{$lb}"> 提前  </label> 
                                                    <input type="text" value="{$notice_user[$key].time}" class="ibox_{$key} inbox" id="box_{$key}" />
                                                    <if condition="$time_desc.time_desc eq 'day'">
                                                        <span class="unit blue">天</span>
                                                        <elseif condition="$time_desc.time_desc eq 'week'"/>
                                                        <span class="unit blue">周</span>
                                                        <elseif condition="$time_desc.time_desc eq 'month'"/>
                                                        <span class="unit blue">月</span>
                                                    </if>
                                                    <a href="javascript:;" class="gt_m"></a>
                                                    <span class="ops">
                                                        <ul>
                                                            <li class="cur">天</li>
                                                            <li>周</li>
                                                            <li>月</li>
                                                        </ul>
                                                    </span>
                                                </span>
                                                <span><input type="radio" name="wd_{$key}" id="cuday_{$lb}" value="0"/> <label for="cuday_{$lb}">当天</label></span>
                                            </div>
                                            <div class="mli">
                                                <span>方式：</span>
                                                <input type="hidden" id="m_{$key}" value="{$notice_user[$key].wid}" />
                                                <foreach name="notice_way" item="nm">
                                                    <span class="tl"><input type="radio" id="mt_{$lb}" value="{$key}"  name="mthod_{$ky}"/><label for="mt_{$lb}"> {$nm}</label></span>
                                                    <php>$lb++;</php>
                                                </foreach>
                                                <php>$ky=$ky+1;</php>
                                            </div>
                                        </div>
                                    </foreach>
                                    <div class="save btn_common btn4_common btn4">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" id="rem_sv" class="btn white">保存</a>
                                    </div>
                                </div>
                            </div>
                            <div class="sdr rf">
                                <div class="frt">
                                    <h2 class="mtitle gray">提醒方式：</h2>
                                    <ul>
                                        <li>
                                            <p>1、消息 ：</p>  
                                            <p>网站顶部的明显提醒按钮</p>
                                            <div class="exap_m"></div>
                                        </li>
                                        <li>
                                            <p>2、手机短信通知 ：</p>  
                                            <p>选择此方式，智能提醒系统将提醒内容通过手机短信发送到您的手机。</p>
                                        </li>
                                        <li>
                                            <p>3、电子邮件通知 ：</p>  
                                            <p>选择此方式，智能提醒系统将提醒内容通过电子邮件发送到您的邮箱中。</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            <!-- layout::Public:footersimple::60 -->
        </div>
    </body>
</html>
