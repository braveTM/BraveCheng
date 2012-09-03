<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>{$information.title} - 资讯详情页_{$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/blog_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">93</script>
        <meta name='keywords' content='{$information.title},{$kwds}'>
        <meta name='description' content='{$information.title}。{$desc}'>
    </head>
    <body>
        <!--行业心得详细页 -->
        <!-- layout::Home:Public:ie6::60 -->
        <div class="info_hder">
            <div class="tp_ct">
                <span class="gray lf">服务热线：</span><span class="red lf">028-85333199</span>
                <if condition="$user['name']">
                    <a href="{$web_root}/user_exit" title="安全退出" id="exit" class="rf">[安全退出]</a>
                    <span href="javascript:;" class="rf gray">{$user['name']},您好!</span>
                    <else/>
                    <a href="{$web_root}/tregister/" title="注册" class="rf">注册</a>
                    <a href="{$web_root}/login/" title="登录" class="rf">登录</a>
                </if>
            </div>
        </div>
        <div class="clr"></div>
        <div class="pheader">
            <a href="{$web_root}/" title="职讯"><p class="logo lf"></p></a>
            <p class="clr"></p>
            <ul>
                <if condition="$user['name']">
                    <li><a href="{$web_root}/search_job">找职位</a></li>
                    <li><a href="{$web_root}/news/" class="cur_a">行业资讯</a></li>
                    <li><a href="{$web_root}/homepage/">返回个人中心</a></li>
                    <else/>
                    <li><a href="{$web_root}/">首 页</a></li>
                    <li><a href="{$web_root}/search_job">找职位</a></li>
                    <li><a href="{$web_root}/news/" class="cur_a">行业资讯</a></li>
                    <li><a href="{$web_root}/clogin/">企业服务</a></li>
                </if>
            </ul>
        </div>
        <div class="layout1 blogmanage infodetail">
            <div class="layout1_nl">
                <div class="module_3">
                    <div class="sm_tab">
                        <div class="sub_title">
                            <if condition="$information.class_title neq ''">
                                <span class="gray">您的位置：</span><a href="{$web_root}/news/" title="" class="blue">行业资讯</a> > <a href="{$web_root}/articles/0/2/{$information.class_id}" title="" class="blue">{$information.class_title}</a> > <a href="javascript:;" title="">正文</a>
                                <else/><span class="gray">您的位置：</span><a href="{$web_root}/news/" title="" class="blue">行业资讯</a> > <a href="{$web_root}/articles/0/1" title="" class="blue">职场经验</a> > <a href="javascript:;"  class="mn"title="">正文</a>
                            </if>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item show">
                            <h2 class="blue">{$information.title}</h2>
                            <p class="gray">
                                <span>发布人：</span><span class="black">{$information.name}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span>阅读数：</span><span class="black">{$information.read_count}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span>发布日期：</span><span>{$information.create_datetime}</span>
                            </p>
                            <div class="gray lf sr_cont _about">                                
                                <span>喜欢就赞一下吧：</span>
                                <a href="javascript:;" class="good" id="praise0_{$isblog}" bid="{$information.blog_id}"></a>
                                <span class="red pr_num">{$information.praise}</span>                                
                                <if condition="$isblog eq 1">
                                    <a href="javascript:;" title="举报" id="report_artcl" class="complain gray"><span class="_m">&nbsp;</span>举报</a>
                                </if>
                                <div class="shares" id="share1">
                                    <div id="ckepop">
                                        <span class="jiathis_txt gray">分享到：</span>
                                        <a class="jiathis_button_tsina"></a>
                                        <a class="jiathis_button_tqq"></a>
                                        <a class="jiathis_button_qzone"></a>                                                                                
                                        <a class="jiathis_button_renren"></a>  
                                        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                                        <a class="jiathis_counter_style"></a>
                                    </div>
                                    </div>
                                <p class="clr"></p>
                            </div>
                            <p class="clr bt_bdr"></p>
                            <if condition="$isblog eq 1">
                                <input type="hidden" id="infodata" value="{$information.body}" btype="{$isblog}"/>
                                <else/>
                                <input type="hidden" id="infodata" value="" type="{$isblog}"/>
                            </if>
                            <div class="loading">
                                <p></p>
                            </div>
                            <div class="content" id="infocont">
                                <if condition="$isblog eq 0">
                                    {$information.body}
                                </if>
                            </div>
                            <if condition="$information.source neq ''">
                                <p class="art_source"><span class="gray">文章来源：</span> <a href="{$information.source}" class="blue">{$information.source}</a></p>
                            </if>
                            <div class="gray lf sr_cont _about">
                                <span>喜欢就赞一下吧：</span>
                                <a href="javascript:;" class="good" id="praise1_{$isblog}" bid="{$information.blog_id}"></a>
                                <span class="red pr_num">{$information.praise}</span>
                                <if condition="$isblog eq 1">
                                    <a href="javascript:;" title="举报" id="report_artcl1" class="complain gray"><span class="_m">&nbsp;</span>举报</a>
                                </if>
                                <div class="shares" id="share2">
                                    <div id="ckepop">
                                        <span class="jiathis_txt gray">分享到：</span>
                                        <a class="jiathis_button_tsina"></a>
                                        <a class="jiathis_button_tqq"></a>
                                        <a class="jiathis_button_qzone"></a>                                                                                
                                        <a class="jiathis_button_renren"></a>  
                                        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                                        <a class="jiathis_counter_style"></a>
                                    </div>
                                </div> 
                                <p class="clr"></p>
                            </div>
                            <p class="clr"></p>
                            <if condition="$isblog eq 1">
                                <p class="green">本文作者:</p>
                                <div class="publisher">
                                    <li>
                                        <div class="lf photo">
                                            <a href="{$web_root}/{$agent.user_id}" target="_blank" title="{$agent.name}">
                                                <img src="{$agent.photo}" class="psmall hoved_bg bg_rd" alt="{$agent.name}">
                                            </a>
                                            <div class="care_name">
                                                <a href="{$web_root}/{$agent.user_id}" target="_blank" class="red name">{$agent.name}</a>
                                            </div>
                                            <div class="identify">
                                                <switch name="agent.real_auth">
                                                    <case value="0">
                                                        <img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                                                    </case>
                                                    <case value="1">
                                                        <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                                                    </case>
                                                </switch> 
                                                <switch name="agent.phone_auth">
                                                    <case value="0">                                        
                                                        <img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                                                    </case>
                                                    <case value="1">
                                                        <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                                                    </case>
                                                </switch> 
                                                <switch name="agent.email_auth">
                                                    <case value="0">
                                                        <img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                                                    </case>
                                                    <case value="1">
                                                        <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>                                        
                                                    </case>
                                                </switch>                                                
                                                <div class="clr"></div>
                                            </div>
                                        </div>
                                        <div class="lf info">
                                            <div class="detail intro"> 
                                                <p class="gray lf">简介: </p>
                                                <p class="detail lf">{$agent.summary}</p>
                                                <p class="clr"></p>
                                            </div>
                                            <p>
                                                <span class="gray">地区:&nbsp;</span>
                                                <span>{$agent.location}</span>&nbsp;&nbsp;&nbsp;
<!--                                                <span class="gray">活跃度:</span>
                                                <span></span>                                             -->
                                            </p>
                                        </div>
                                        <div class="clr"></div>
                                        <p class="rmp">
                                            <a href="{$web_root}/articles/{$agent.user_id}" class="blue">查看更多Ta的心得></a>
                                        </p>
                                    </li>
                                    <div class="auth_bot">
                                        <p class="lf"></p>
                                        <p class="rf"></p>
                                        <div class="clr"></div>
                                    </div>
                                </div>
                            </if>
                            <div class="ad3"><img src="{$voc_root}/imgs/temp/infodetailad.png" alt="" /></div>
                            <p class="hte">
                            <if condition="$preArt neq null && $isblog eq 0">
                                <a href="{$web_root}/article/{$isblog}/{$preArt['art_id']}"  title="{$preArt['art_title']}" class="lf blue"><上一篇：{$preArt['art_title']}</a>
                                <elseif condition="$isblog eq 0"/><span class="lf"><上一篇：没有了 </span>
                            </if>
                            <if condition="$nextArt neq null && $isblog eq 0">
                                <a href="{$web_root}/article/{$isblog}/{$nextArt['art_id']}"  title="{$nextArt['art_title']}" class="rf blue">下一篇：{$nextArt['art_title']}></a>
                                <elseif condition="$isblog eq 0"/><span class="rf">下一篇：没有了> </span>
                            </if>
                            <if condition="$preBlog neq null && $isblog eq 1">
                                <a href="{$web_root}/article/{$isblog}/{$preBlog['blog_id']}" title="{$preBlog['title']}"  class="lf blue"><上一篇：{$preBlog['title']}</a>
                                <elseif condition="$isblog eq 1"/><span class="lf"><上一篇：没有了 </span>
                            </if>
                            <if condition="$nextBlog neq null && $isblog eq 1">
                                <a href="{$web_root}/article/{$isblog}/{$nextBlog['blog_id']}" title="{$nextBlog['title']}" class="rf blue">下一篇：{$nextBlog['title']}></a>
                                <elseif condition="$isblog eq 1"/><span class="rf">下一篇：没有了> </span>
                            </if>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- UY BEGIN -->
                <div id="uyan_frame"></div>
                <script type="text/javascript" id="UYScript" src="http://v1.uyan.cc/js/iframe.js?UYUserId=1618644" async=""></script>
                <!-- UY END -->
            </div>
            <div class="layout1_nr">
                <div class="module_1">
                    <!-- layout::Public:infonav::0 -->
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <!-- layout::Public:footersimple::60 -->
        <!-- JiaThis Button BEGIN -->
            <script type="text/javascript">
                var jiathis_config={
                    url:"{$web_root}/article/{$isblog}/{$information.blog_id}",
                    title:"《{$information.title}》（分享自 @职讯网）",
                    siteNum:16,
                    pic:"{$agent.photo}"
                }
            </script>
        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1342595208180738" charset="utf-8"></script>
          <!-- JiaThis Button END -->
    </body>
</html>
