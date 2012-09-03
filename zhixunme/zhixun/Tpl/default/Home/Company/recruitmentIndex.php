<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>招聘管理 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/benterprise_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/card-hgs/card-hgs.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">40</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 enterinvite">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:enav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li><a href="javascript:;">我公开的职位</a></li>
                            <li><a href="javascript:;">委托出去的职位</a></li>
                            <li><a href="javascript:;">待处理的职位</a></li>
                            <li><a href="javascript:;">应聘来的简历</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">招聘管理</a>
                            <input type="hidden" value="" id="tempsave"/>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="pubfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_status">
                                        <a href="javascript:;" class="red" st="0">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="1">招聘中</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="4">已暂停</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="2">已结束招聘</a>
                                    </span>
                                    <span class="ops filt_type">
                                        <a href="javascript:;" class="red" tp="0">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="2">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="1">全职</a>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist mlist_s hgstemp" id="epublist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination1" class="pages"></div>
                        </div>
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="delefilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_status">
                                        <a href="javascript:;" class="red" st="0">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="1">委托中</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="2">已结束</a>
                                    </span>
                                    <span class="ops filt_type">
                                        <a href="javascript:;" class="red" tp="0">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="2">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="1">全职</a>
                                    </span>
                                    <span class="ops" style="color:#c00;">（注：委托状态下暂不可查看职位详细）</span>
                                </div>
                            </div>
                            <ul class="mlist mlist_s hgstemp" id="delelist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination2" class="pages"></div>
                        </div>
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="jobboxfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_type">
                                        <a href="javascript:;" tp="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="2" title="">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="1" title="">全职</a>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist mlist_s hgstemp" id="jobboxlist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination3" class="pages"></div>
                        </div>
                        <!---------------------应聘来的简历-------------------->
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="apr">
                                    <span>筛选条件：</span>
                                    <span class="ap_resu_sta">
                                        <a href="javascript:;" rel="0" title="0" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" rel="1" title="">未查看</a>
                                        <b>/</b>
                                        <a href="javascript:;" rel="2" title="">已查看</a>
                                    </span>
                                    <span class="ops ap_resu_type">
                                        <a href="javascript:;"  fl="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" fl="2" title="">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" fl="1" title="">全职</a>
                                    </span>
                                    <span class="ops ap_reg_condition">
                                        <a href="javascript:;" rl="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" rl="3" title="">猎头投递</a>
                                        <b>/</b>
                                        <a href="javascript:;" rl="1" title="" >人才投递</a>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist hgstemp" id="applied_resume">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination6" class="pages"></div>
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