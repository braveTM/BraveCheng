<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>{$sub_title} - 资讯列表页_{$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/blog_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/share/bar.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">92</script>
        <meta name='keywords' content='{$sub_title},{$kwds}'>
        <meta name='description' content='{$sub_title}。{$desc}'>
    </head>
    <body>
        <!--资讯列表页面 -->
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
        <div class="layout1 blogmanage blogindex">
            <div class="layout1_nl">
                <div class="module_3">
                    <input type="hidden" id="usid" value="{$user_id}"/>
                    <input type="hidden" id="inid" value="{$art_blog}"/>
                    <input type="hidden" id="cid" value="{$class_id}"/>
                    <div class="sm_tab">
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue list_title">{$sub_title}</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item">
                            <ul class="hgstemp bcom" id="texp">
                                <if condition="$blog_list eq ''">
                                    <li class="no-data red">暂无相关数据!</li>
                                    <else />
                                    <foreach name="blog_list" item="bg">
                                        <li>
                                            <div class="lf bcount">
                                                <div class="cnber">{$bg.read_count}</div>
                                                <div class="cbg"></div>
                                                <div class="gray">浏览数</div>
                                            </div>
                                            <div class="lf bdetail">
                                                <div class="zx_title">
                                                    <a href="{$web_root}/article/{$url}/{$bg.blog_id}" title="{$bg.title}" class="blue">{$bg.title}</a>
                                                </div>
                                                <div class="z_deil">{$bg.body}<a class="blue rf rmore" href="{$web_root}/article/{$url}/{$bg.blog_id}" title="阅读全文" target="_blank">[阅读全文]</a>
                                                    <p class="clr"></p>
                                                </div>
                                                <div class="gray lf">
                                                    <span>发布人：</span>
                                                    <span class="source">{$bg.name}</span>
                                                    <span class="pd">发布时间：</span>
                                                    <span>{$bg.create_datetime}</span>
                                                    <span class="pd">赞：</span>
                                                    <span class="red">{$bg.praise}</span>
                                                    <span class="pd">分享：</span>
                                                    <span class="shre">
                                                        <div class="shares">
                                                            <a class="share shr_1" tp="sina" tit="{$bg.title}" ur="{$web_root}/article/{$url}/{$bg.blog_id}" href="javascript:;"></a>
                                                            <a class="share shr_2" tp="tencent" tit="{$bg.title}" ur="{$web_root}/article/{$url}/{$bg.blog_id}" href="javascript:;"></a>
                                                            <a class="share shr_3" tp="qzone" tit="{$bg.title}" ur="{$web_root}/article/{$url}/{$bg.blog_id}" href="javascript:;"></a>
                                                            <p class="clr"></p>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                        <p class="clr"></p>
                                    </foreach>
                                </if>
                            </ul>
                            <input type="hidden" name="total" value="{$count}" />
                            <input type="hidden" name="cpge" value="{$page}" />
                            <input type="hidden" name="href" value="{$link_pre}" />
                            <div id="pagination1" class="pages"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layout1_nr">
                <div class="module_1">
                    <!-- layout::Public:infonav::0 -->
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>