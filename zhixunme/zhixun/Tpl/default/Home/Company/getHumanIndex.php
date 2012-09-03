<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>找人才 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/benterprise_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/card-hgs/card-hgs.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">37</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 ftalents">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:enav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li"><a href="javascript:;">可能感兴趣的人才</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">找人才</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item_top">
                            <div class="ops_filter" id="talfilter">
                                <span>筛选条件：</span>
                                <span class="filt_type">
                                    <a href="javascript:;" class="red" tp="0">不限</a>
                                    <b>/</b>
                                    <a href="javascript:;" tp="2">兼职</a>
                                    <b>/</b>
                                    <a href="javascript:;" tp="1">全职</a>
                                </span>
                                <span class="ops filt_role">
                                    <a href="javascript:;" rol="0" class="red">不限</a>
                                    <b>/</b>
                                    <a href="javascript:;" rol="3">猎头公开简历</a>
                                    <b>/</b>
                                    <a href="javascript:;" rol="1">人才公开简历</a>
                                </span>
                            </div>
                        </div>
                        <ul class="mlist hgstemp" id="talentlist">
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