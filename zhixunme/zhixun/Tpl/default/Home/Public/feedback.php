<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>意见反馈 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/articledeta_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">100</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::Home:Public:ie6::60 -->
        <div class="feedback dacom pub_page">
            <div class="pub_top">
                <div class="p_t_txt">
                    <a href="{$web_root}" title="职讯网首页">
                        <img src="{$file_root}zhixun/Theme/default/vocat/imgs/system/wlogo.png" alt="职讯网首页"/>
                    </a>
                     <a href="{$web_root}" title="回到首页" class="white">回到首页</a>
                </div>
            </div>
            <div class="pub_mid">
                <div class="p_m_top">
                    <p class="p_m_l lf"></p>
                    <p class="p_m_r rf"></p>
                </div>
                <div class="p_m_mid fdb">
                    <div class="p_m_mid_bg">
                        <div class="fwrap">
                            <p class="blue">建议与反馈</p>
                            <div class="fcont">
                                <p class="s_tip gray">亲爱的用户,您好,欢迎您向职讯提建议!请将您的想法、意见、建议和投诉内容告诉我们，以便我们能够及时改善，提供更加优质的服务。</p>
                                <h2 class="ctitle">您的联系方式<span class="gray">(选填)</span>：</h2>
                                <div class="con_item">
                                    <span class="tl">姓名：</span>                               
                                    <span><input class="gray" type="text" value="{$info.name}" id="name" /></span>
                                </div>
                                <div class="con_item">
                                    <span class="tl">手机：</span>
                                    <span><input class="gray" type="text" value="{$info.phone}" id="mobile" /></span>
                                </div>
                                 <div class="con_item">                                    
                                    <span class="tl"><em class="red">*</em>电子邮箱：</span>
                                    <span><input class="gray" type="text" value="{$info.email}" id="email" /></span>
                                </div>
                                <h2 class="ctitle">反馈分类：</h2>
                                <div class="sort_item">
                                    <p> 
                                        <span>
                                            <label for="sort1">
                                                <input id="sort1" type="radio" value="1" name="st" />访问速度/网络故障
                                            </label>
                                        </span>
                                        <span>
                                            <label for="sort2">
                                                <input id="sort2" type="radio" value="2"  name="st" />系统故障(注册/登录/简历投递/委托等)
                                            </label>
                                        </span>
                                        <span>
                                            <label for="sort3">
                                                <input id="sort3" type="radio" value="3" name="st"  />用户体验/页面(页面布局)
                                            </label> 
                                        </span>
                                    </p>
                                    <p>
                                        <span>
                                            <label for="sort4">
                                                <input id="sort4" type="radio" value="4" name="st"  />业务投诉
                                            </label>
                                        </span>
                                        <span>
                                            <label for="sort5">
                                                <input id="sort5" type="radio" checked value="5" name="st"  />建议意见
                                            </label>
                                        </span>
                                        <span>
                                            <label for="sort6">
                                                <input id="sort6" type="radio" value="6" name="st"  />其他反馈
                                            </label>
                                        </span>
                                    </p>
                                </div>
                                <h2 class="ctitle">反馈内容：</h2>
                                <p>
                                    <textarea id="advice_box" class="inbox gray"> 亲爱的职讯网用户:&#13;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我们会每天关注您的建议并提供反馈，不断优化产品，为您更好的服务。&#13;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请留下您详细的疑问或建议，谢谢！
                                    </textarea>
                                </p>
                                <p class="stip red hidden"></p>
                                <div class="sub">
                                    <div class="btn_common btn20">
                                        <span class="lf"></span>
                                        <span class="rf"></span>                                                        
                                        <a href="javascript:;" class="white btn" id="sm_fdb">提交</a>                                                        
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
</html>
