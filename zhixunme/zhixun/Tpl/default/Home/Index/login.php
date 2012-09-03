<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>登陆 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/index_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$js_root}/{$jqlib}/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">3</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
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
        <div class="pheader">
            <a href="{$web_root}/" title="职讯"><p class="logo lf"></p></a>
            <p class="clr"></p>
            <ul>
                <li><a href="{$web_root}/">首 页</a></li>
                    <li><a href="{$web_root}/search_job">找职位</a></li>
                <li><a href="{$web_root}/news/">行业资讯</a></li>
                <li><a href="{$web_root}/clogin/">企业服务</a></li>
            </ul>
        </div>
        <div class="pnav">
            <div class="login_cont">
                <div class="slider" id="slider">
                    <ul id="py">
                      <ul id="py">
                        <li class="cur l1"  rel="1">
                            <img src="{$voc_root}/imgs/index/slide1.png" alt="赚积分，换套餐,零成本，为您的业务锦上添花" />
                        </li>
                        <li rel="2" class="l2">
                            <img src="{$voc_root}/imgs/index/slide2.png" alt="登录就赚钱，从此不再有淡季" />
                        </li>
                     </ul>
                    </ul>
                </div>
                <!--                <ul class="contr" id="ctro">
                                    <li class="cur_li">
                                        <a href="javascript:;"></a>
                                    </li>
                                     <li>
                                        <a href="javascript:;"></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;"></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;"></a>
                                    </li>
                                </ul>-->
               
                <div class="lwrp">
                    <div class="lp">
                    <ul class="slidindex">
                        <li class="s1 sel" rel="0"></li>
                        <li class="s2" rel="1"></li>
<!--                        <li class="s3" rel="2"></li>-->
                    </ul>
                         <div class="login_box hidden">
                        <div class="title">登录职讯<span class="red" id="err_msg"></span></div>
                        <div class="txt_cont">
                            <span class="lf">帐号：</span>
                            <input type="text" value="" class="lf" id="uname"/>
                            <span class="tipmsg">电子邮箱/手机</span>
                        </div>
                        <div class="txt_cont">
                            <span class="lf">密码：</span>
                            <input type="password"  class="lf" value="" id="upsd"/>
                            <span class="tipmsg">密码</span>
                            <a href="{$web_root}/forgot" title="找回密码" class="fpsd">
                                <span class="psdes blue">忘记密码?</span>
                            </a>                        
                        </div>
                        <div>
                            <a href="javascript:;" class="login_btn rf" id="login" ru="{$redirect}"></a>
                            <div class="rec_psd lf"><input type="checkbox" name="cache" checked="true" id="cache"/><label for="cache" class="blue">下次自动登录</label></div>
                            <p class="clr"></p>
                        </div>
                        <div class="ureg">
                            <div class="btn6 btn_common ta lf">
                                <span class="lf"></span>
                                <a href="{$web_root}/tregister" class="btn white">人才注册</a>
                            </div>
                            <div class="btn6 btn_common agent lf">
                                <a href="{$web_root}/aregister" class="btn white">猎头注册</a>
                            </div>
                            <div class="btn6 btn_common enter lf">
                                <span class="rf"></span>
                                <a href="{$web_root}/eregister" class="btn white">企业注册</a>
                            </div>
                        </div>
                    </div>
                    <p class="clr"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="clr"></div>
        <!---------------------------footer--------------------------->
        <!-- layout::Public:footersimple::60 -->

        {$indexjs}
        <script type="text/javascript">
            var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
            document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fe264b810956d7c30b6a5c72b077f9afb' type='text/javascript'%3E%3C/script%3E"));
        </script>
    </body>
</html>
