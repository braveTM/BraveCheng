<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>找企业 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/btalent_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">38</script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 tfenterprise">
            <div class="layout1_l">
                <div class="module_1">
                     <!-- layout::Public:tnav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li"><a href="javascript:;">可能感兴趣的企业</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">找企业</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item">
                            <div class="t_item_top">
                                 <div class="ops_filter">
<!--                                    <span>筛选条件：</span>
                                    <span>
                                        <a href="javascript:;" title="" class="red">不限</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">招聘中</a>
                                        <b>/</b>
                                        <a href="javascript:;" title="">未招聘</a>
                                    </span>-->
                                     <span class="pops lf">地区筛选:</span>
                                     <input id="plafilter" class="mselect lf" readonly="true" type="text"/>
                              </div>
                                <div class="clr"></div>
                            </div>
                            <ul class="mlist hgstemp" id="companylist">
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