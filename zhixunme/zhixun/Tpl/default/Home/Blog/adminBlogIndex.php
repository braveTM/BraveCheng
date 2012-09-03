<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>职场经验管理 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/blog_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico" />
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">91</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!--行业心得管理页 -->
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 blogmanage">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::{$nav}::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_3">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li"><a href="javascript:;">我发布的职场经验</a></li>
                        </ul>
<!--                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">职场经验管理</a>
                        </div>-->
                    </div>
                    <div class="t_container">
                        <div class="t_item show">
                            <div class="t_item_top">
                                <div class="ops_filter" id="amfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_status">
                                        <a href="javascript:;" st="0" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="1">未审核</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="2">审核中</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="3">已通过</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="4">未通过</a>
                                    </span>
                                </div>
                            </div>
                            <div class="mcols mcols_title">
                                <div class="f_cl">标题</div>
                                <div class="s_cl">阅读数</div>
                                <div class="t_cl">时间</div>
                                <div class="fr_cl">状态</div>
                                <div class="fv_cl">操作</div>
                            </div>
                            <ul class="mcols alst_cols hgstemp" id="amlist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination1" class="pages"></div>
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