<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>人脉 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bcommon_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">68</script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!--我的人脉页 -->
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 mycontacts">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::{$nav}::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li><a href="javascript:;">人脉动态</a></li>
                            <li><a href="javascript:;">我关注的</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">我的人脉</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="network">
                                    <span>筛选条件：</span>
                                    <span class="person_net">
                                        <a href="javascript:;" title="" rel="0"class="red">不限</a>
                                        <if condition="$fe eq 1">
                                            <b>/</b>
                                            <a href="javascript:;" title="" rel="2">企业</a>
                                        </if>
                                        <if condition="$ft eq 1">
                                            <b>/</b>
                                            <a href="javascript:;" title="" rel="1">人才</a>
                                        </if>
                                        <if condition="$fa eq 1">
                                            <b>/</b>
                                            <a href="javascript:;" title="" rel="3">猎头</a>
                                        </if>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist hgstemp dynamic" id="dynamic">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination1" class="pages"></div>
                        </div>
                        <div class="t_item hidden">
                            <div class="t_item_top">
                                <div class="ops_filter" id="typ_per">
                                    <span>筛选条件：</span>
                                    <span class="t_p">
                                        <a href="javascript:;" title="" rel="0" class="red">不限</a>
                                        <if condition="$fe eq 1">
                                            <b>/</b>
                                            <a href="javascript:;" title="" rel="2">企业</a>
                                        </if>
                                        <if condition="$ft eq 1">
                                            <b>/</b>
                                            <a href="javascript:;" title="" rel="1">人才</a>
                                        </if>
                                        <if condition="$fa eq 1">
                                            <b>/</b>
                                            <a href="javascript:;" title="" rel="3">猎头</a>
                                        </if>
                                    </span>
                                </div>
                            </div>
                            <ul class="mlist hgstemp" id="focus_person">
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