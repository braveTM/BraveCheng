<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>企业服务 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css">      
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/clogin_1.0.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico">        
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">102</script>
        <meta name='keywords' content='企业服务,企业登陆,{$kwds}'>
        <meta name='description' content='职讯网企业服务提供海量资源，精准匹配。{$desc}'>
    </head>
    <body>
        <!-- layout::Home:Public:ie6::60 -->
        <div class="tp_hder">
            <div class="tp_ct">
                <span class="gray lf">服务热线：<span class="red">028-85333199</span></span>
                <div class="cus_serverice">
                        <!-- WPA Button Begin -->
                        <script type="text/javascript" src="http://static.b.qq.com/account/bizqq/js/wpa.js?wty=1&type=1&kfuin=800020229&ws=www.zhixun.me&btn1=%E5%9C%A8%E7%BA%BF%E5%AE%A2%E6%9C%8D&aty=0&a=&key=%5B%3ETeWbVc%09%3FU3TfP%3BQ8Tk%04%3EP7%088%07a%01eU7%0Ae%021So"></script>
                    <!-- WPA Button END -->
                    </div>
                <a href="{$web_root}" class="rf" title="职讯网">职讯网</a>
                <a href="{$web_root}/feedback" class="rf stp" title="建议反馈">建议反馈</a>
            </div>
        </div>
        <div class="clr"></div>
        <div class="pheader clogin_h">
            <a href="{$web_root}/" title="职讯"><p class="logo lf"></p></a>
            <p class="clr"></p>
            <ul>
                <li><a href="{$web_root}/">首 页</a></li>
                    <li><a href="{$web_root}/search_job">找职位</a></li>
                <li><a href="{$web_root}/news/">行业资讯</a></li>
                <li><a href="{$web_root}/login/">人才和猎头登录</a></li>
            </ul>
        </div>
        <div class="clogin_nav">
            <div class="login_cont">
                <div class="login_box clogin">
                    <div class="title"><span class="lf">企业登录</span><span class="red rf" id="err_msg"></span></div>
                    <div class="txt_cont first">
                        <span class="t">帐&nbsp;&nbsp;&nbsp;号:</span>
                        <input type="text" value="" id="uname"/>
                        <span class="tipmsg">电子邮箱/手机号</span>
                    </div>
                    <div class="txt_cont psw">
                        <span class="t">密&nbsp;&nbsp;&nbsp;码:</span>
                        <input type="password" value="" id="upsd"/>
                        <span class="tipmsg">密码</span>
                        <a href="{$web_root}/forgot" title="找回密码" class="fpsd" tabindex="-1"><span class="psdes blue">忘记密码?</span></a>
                        
                    </div>
                    <div class="txt_cont check">
                        <span class="t">验证码:</span>
                        <input type="text" value="" id="auth"/>                        
                        <a href="javascript:;" title="" class="blue rf v_c" id="val_anoth">换一张</a>
                        <img class="rf" id="img_anoth" src="{$web_root}/lvcode" title="点击换一张" alt=""/>
                    </div>
                    <div>                        
                        <div class="rec_psd lf">
                            <input type="checkbox" name="cache" checked="true" id="cache"/>
                            <label for="cache">下次自动登录</label>
                        </div>
                        <a href="javascript:;" class="login_btn rf" id="login" ru="{$redirect}"></a>
                        <p class="clr"></p>
                    </div>
                    <div class="regbtn_cont" id="logbtn">
                        <div class="btn_common">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="{$web_root}/eregister" class="regbtn">企业注册</a>
                        </div>
                    </div>                                                  
                </div>
<!--                <div class="login_copy">
                <div class="border"></div>-->
                </div>
                <p class="clr"></p>
            </div>
        </div>
        <div class="content">            
                <ul class="sevlist">
                    <li>
                        <div class="title blue">
                            <div class="pm"></div>
                            <h2>精准匹配</h2>
                            <span>Precision Match</span>
                        </div>
                        <div class="desc">通过个性化推荐系统准确的搜索匹配帮助企业找到精确、合适的目标候选人</div>
                    </li>
                    <li>
                        <div class="title blue">
                            <div class="online"></div>
                            <h2>信用认证</h2>
                            <span>Credit Certification</span>
                        </div>
                        <div class="desc">实名认证、全人工审核，构建诚信网络互信机制，打造高质量社区，让彼此沟通合作更放心</div>
                    </li>
                    <li>
                        <div class="title blue">
                            <div class="resous"></div>
                            <h2>海量资源</h2>
                            <span>Mass Resources</span>
                        </div>
                        <div class="desc">平台聚集了海量高级建筑人才、猎头、企业，我们提供优质平台级服务，帮助您提高运作效率，准确定位您的人才</div>
                    </li>
                    <li>
                        <div class="title blue">
                            <div class="servce"></div>
                            <h2>服务保障</h2>
                            <span>Best Servce</span>
                        </div>
                        <div class="desc">我们建立多方合作，通过系统自动化和人工方式结合，确保诚信、高效、便捷、安全的服务体系</div>
                    </li>                    
                </ul>     
        </div>                 
        <div class="clr"></div>
        <!-- layout::Public:footersimple::60 -->      
        <script type="text/javascript">
        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fe264b810956d7c30b6a5c72b077f9afb' type='text/javascript'%3E%3C/script%3E"));
        </script>
    </body>
</html>
