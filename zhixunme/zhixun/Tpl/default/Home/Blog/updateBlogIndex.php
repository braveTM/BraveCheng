<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>发布职场经验 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/blog_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">90</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!--行业心得发布页 -->
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 blogpublish">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::{$nav}::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_3">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li">
                            <if condition='$blog.blog_id neq null'>
                                <a href="javascript:;">修改我的行业经验</a>
                                <else/>
                                <a href="javascript:;">发布我的行业经验</a>
                            </if>
                            </li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">行业经验管理</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item show">
                            <span class="gray">友情提示：</span>
                            <p class="gray">1、“职场经验”是为猎头特制的“博客式”的文章发表专栏，欢迎您将个人从业过程中积累的宝贵经验及对行业的独到见解等分享给所有的职讯网用户。</p>
                            <p class="gray">2、文章规范：1）标题字数不超过25个字，正文内容不超过3屏，纯文本文档 2）文章主题为建筑行业相关，内容和谐。3）内容以原创文章为主，转载的行业经验文章需注明出处。</p>
                            <p class="gray">3、文章审核通过后，作者个人信息将与发布的心得一并展示在“行业资讯”版块优秀文章还有机会被选为“推荐职场经验”，吸引更多的用户关注到您，赶快发布您的职场经验吧~</p>
                            <p class="gray">4、行业经验文章发布的相关规则请严格参照 <a href="{$web_root}/arule/" class="blue">《猎头使用规范》</a></p>
                            <div class="atitle">
                                <span>标题：&nbsp;</span><input type="text" id="art_title" value="{$blog.title}"/>
                            </div>
                            <div class="atitle art_src">
                                <span>来源：&nbsp;</span><input type="text" id="art_src" value="{$blog.source}"/>
                            </div>
                            <p class="txttitle">请将内容输入以下输入框<em class="gray"> (注：您可以使用回车或空格键来控制文本样式)</em></p>
                            <input type="hidden" id="infocontent" value="{$blog.body}">
                            <textarea cols="" rows="" id="acontent"></textarea>
                            <input type="hidden" id="isbid" value="{$blog.blog_id}">
                            <div class="pb_op">
                                <div class="pb_s lf">
                                    <div class="btn_common btn5 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="checknow" st="2">提交审核</a>
                                    </div>
                                </div>
                                <div class="me_or red lf">
                                    or
                                </div>
                                <div class="pb_a lf">
                                    <div class="btn_common btn8 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="savenow" st="1">保存为草稿</a>
                                    </div>
                                </div>
                                <div class="clr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>