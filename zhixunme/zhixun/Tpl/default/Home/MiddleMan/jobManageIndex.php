<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>职位管理 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bagent_1.0.css"/>        
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/card-hgs/card-hgs.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">43</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 comlist jobmanage">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:anav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li><a href="javascript:;">搜索职位</a></li>
                            <li><a href="javascript:;">可能感兴趣的职位</a></li>
                            <li><a href="javascript:;">我公开的职位</a></li>
                            <li><a href="javascript:;">委托来的职位</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">职位管理</a>
                            <input type="hidden" value="" id="tempsave"/>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item hidden">
                             <!-- layout::Public:findjob::0 -->
                        </div>
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="intrfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_type">
                                        <a href="javascript:;" class="red" tp="0">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="2">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="1">全职</a>
                                    </span>
<!--                                    <span class="ops filt_reg">
                                        <a href="javascript:;" re="0" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" re="1">初始注册</a>
                                        <b>/</b>
                                        <a href="javascript:;" re="2">变更注册</a>
                                    </span>-->
                                    <span class="ops filt_status">
                                        <a href="javascript:;" class="red" st="0">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="3">猎头发布</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="2">企业发布</a>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist hgstemp introlist" id="intrjob">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination3" class="pages"></div>
                        </div>
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
                                        <a href="javascript:;" st="2">已完成</a>
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
                            <ul class="mlist mlist_s hgstemp" id="apublist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination2" class="pages"></div>
                        </div>
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="agentfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_status">
                                        <a href="javascript:;" class="red" st="0">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="5">未查看</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="1">未公开</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="2">已公开</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="6">已暂停</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="3">已完成</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="4">被终止的委托</a>
                                    </span>
                                    <span class="ops filt_type">
                                        <a href="javascript:;" class="red" tp="0">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="2">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="1">全职</a>
                                    </span>
<!--                                    <span>
                                        <a href="javascript:;" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">初始注册</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">变更注册</a>
                                    </span>-->
                                </div>
                            </div>
                            <ul class="mlist hgstemp" id="agentjob">
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