<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>简历管理 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bagent_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/card-hgs/card-hgs.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/jquery-datepicker/jquery.ui.datepicker.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">42</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 comlist tmanage">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:anav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li><a href="javascript:;">我可能感兴趣的简历</a></li>
                            <li><a href="javascript:;">我添加的简历</a></li>
                            <li><a href="javascript:;">委托来的简历</a></li>
                            <li><a href="javascript:;">应聘来的简历</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">简历管理</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <!---------------------我可能感兴趣的简历-------------------->
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="iatfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_type">
                                        <a href="javascript:;" tp="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="2" title="">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="1" title="">全职</a>
                                    </span>
                                    <span class="ops filt_ro">
                                        <a href="javascript:;" ro="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" ro="1" title="">人才自主</a>
                                        <b>/</b>
                                        <a href="javascript:;" ro="3" title="">猎头资源</a>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist hgstemp" id="iatlist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination3" class="pages"></div>
                        </div>
                        <!---------------------我添加的简历-------------------------->
                        <div class="t_item hidden">
                                <div class="t_item_top">
                                    <div class="ops_filter" id="adr">
                                        <span>筛选条件：</span>
                                        <span class="resu_sta">
                                            <a href="javascript:;" rel="0" title="" class="red">不限</a>
                                            <b>/</b>
                                            <a href="javascript:;" rel="1" title="">未公开</a>
                                            <b>/</b>
                                            <a href="javascript:;" rel="2" title="">求职中</a>
                                        </span>
                                        <span class="ops resu_type">
                                            <a href="javascript:;" fl="0" title="" class="red">不限</a>
                                            <b>/</b>
                                            <a href="javascript:;" fl="2" title="">兼职</a>
                                            <b>/</b>
                                            <a href="javascript:;" fl="1" title="">全职</a>
                                        </span>
                                    </div>
                                </div>
                                <ul class="mlist mlist_s hgstemp" id="added_resume">
                                    <li class="loading">
                                        <p></p>
                                    </li>
                                </ul>
                                <div id="pagination5" class="pages"></div>
                        </div>
                        <!---------------------委托来的简历----------------->
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="atfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_status">
                                        <a href="javascript:;" st="0" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="5">未查看</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="1">未公开</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="2">已公开</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="3">已完成</a>
                                        <b>/</b>
                                        <a href="javascript:;" st="4">被终止的委托</a>
                                    </span>
                                    <span class="ops filt_type">
                                        <a href="javascript:;" tp="0" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="2">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="1">全职</a>
                                    </span>
<!--                                    <span>
                                        <a href="javascript:;" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">初始</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">转注</a>
                                    </span>-->
                                </div>
                            </div>
                            <ul class="mlist hgstemp" id="atlist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination1" class="pages"></div>
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
