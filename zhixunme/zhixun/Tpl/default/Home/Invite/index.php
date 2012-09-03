<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>好友邀请 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/invite_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">7</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 invitefr">
            <div class="sm_tab">
                <div class="sub_title">
                    <a href="javascript:;" title="" class="blue">邀请好友加入职讯网</a>
                </div> 
            </div>
            <div class="inv_way">
                <div class="one"><p class="pic_1"></p></div>
                <div class="two">
                    <p class="p_tit">邀请方法一：<span class="blue"> 电子邮箱邀请好友</span></p>
                    <p class="ct_way">直接输入好友常用的电子邮箱，邀请他注册职讯网。预览邀请内容如右图</p>
                    <div class="ct_way">
                        <p class="lf">电子邮箱：&nbsp;</p>
                        <div class="lf"><input type="text"id="em_cont" class="ebox" /></div>
                        <p class="lf gray">回车可添加多个,一次至多填写10个</p>
                        <div class="clr"></div>
                        <input type="hidden" value="" name="em_list" />
                        <div id="plist" class="items">
                        </div>
                        <div class="save btn_common btn4_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" id="email_invite" class="btn white">发送邀请</a>
                        </div>
                    </div>
                </div>
                <div class="three">
                    <p class="show_p1"></p>
                    <p class="show_text1">Hi，我是{$info.name}，我注册成为了职讯网（www.zhixun.me）的会员，这是一个非常专业的建筑行业求职招聘平台，所有的企业和猎头都是实名认证的，快来体验一下吧！</p>
                </div>
                <p class="clr"></p>
                <div class="one"><p class="pic_2"></p></div>
                <div class="two">
                    <p class="p_tit">邀请方法二：<span class="blue">  短信邀请好友</span></p>
                    <p class="ct_way">直接输入好友的手机号码，邀请他注册职讯网。预览邀请短信内容如右图</p>
                    <div class="ct_way">
                        <p class="lf">手机号码：&nbsp;</p>
                        <div class="lf"><input type="text" id="ph_cont" class="ebox" /></div>
                        <p class="lf gray">回车可添加多个,一次至多填写10个</p>
                        <div class="clr"></div> 
                        <input type="hidden" value="" name="phone_list" />
                        <div id="clist" class="items">
                        </div>
                        <div class="save btn_common btn4_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" id="phone_invite" class="btn white">发送邀请</a>
                        </div>
                    </div>
                </div>
                <div class="three">
                    <p class="show_p2"></p>
                    <p class="show_text2">Hi，我是{$info.name}，我注册成为了职讯网（www.zhixun.me）的会员，这是一个非常专业的建筑行业求职招聘平台，所有的企业和猎头都是实名认证的，快来体验一下吧！</p>
                    <p class="bot"></p>
                </div>
                <p class="clr"></p>
                <div class="one"><p class="pic_3"></p></div>
                <div class="two">
                    <p class="p_tit">邀请方法三：<span class="blue"> 快速邀请好友</span></p>
                    <p class="ct_way">直接复制链接，通过QQ或其他方式发送给你想要邀请的好友。</p>
                    <div class="ct_way">
                        <p class="lf">邀请链接：&nbsp;</p>
                        <div class="lf"><input type="text" id="cop_link" value="{$icode}"/></div>
                        <div class="clr"></div>
                        <div id=""class="msg"></div>
                        <div class="save btn_common btn4_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" id="fast_invite" class="btn white">复制链接</a>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
        </div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
