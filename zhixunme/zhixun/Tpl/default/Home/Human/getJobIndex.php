<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>找职位 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/btalent_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">39</script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 fjobs">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:tnav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li><a href="javascript:;">搜索职位</a></li>
                            <li><a href="javascript:;">可能感兴趣的职位</a></li>
                            <li><a href="javascript:;">意向职位</a></li>
                            <li><a href="javascript:;">我应聘过的职位</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">找职位</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item hidden">
                             <!-- layout::Public:findjob::0 -->
                        </div>
<!--                        可能感兴趣的职位-->
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="jobfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_type">
                                        <a href="javascript:;" tp="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="2" title="">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="1" title="">全职</a>
                                    </span>
<!--                                    <span class="ops">
                                        <a href="javascript:;" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">初始</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">专注</a>
                                    </span>-->
                                    <span class="ops filt_role">
                                        <a href="javascript:;" rol="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" rol="3" title="">猎头发布</a>
                                        <b>/</b>
                                        <a href="javascript:;" rol="2" title="">企业发布</a>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist hgstemp" id="joblist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination1" class="pages"></div>
                        </div>
<!--                        意向职位-->
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="wjobfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_role">
                                        <a href="javascript:;" rol="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" rol="3" title="">猎头发布</a>
                                        <b>/</b>
                                        <a href="javascript:;" rol="2" title="">企业发布</a>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist hgstemp" id="wjoblist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination3" class="pages"></div>
                        </div>
<!--                        我应聘过的职位-->
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                 <div class="ops_filter" id="ojobfilter">
                                    <span>筛选条件：</span>
                                    <span class="filt_type">
                                        <a href="javascript:;" tp="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="2" title="">兼职</a>
                                        <b>/</b>
                                        <a href="javascript:;" tp="1" title="">全职</a>
                                    </span>
<!--                                    <span class="ops">
                                        <a href="javascript:;" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">初始</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">专注</a>
                                    </span>-->
                                    <span class="ops filt_role">
                                        <a href="javascript:;" rol="0" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" rol="3" title="">猎头发布</a>
                                        <b>/</b>
                                        <a href="javascript:;" rol="2" title="">企业发布</a>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist hgstemp" id="ojoblist">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination2" class="pages"></div>
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