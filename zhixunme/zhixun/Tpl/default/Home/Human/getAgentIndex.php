<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>找猎头 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/btalent_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">36</script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!--个人找猎头 -->
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 tfagent">
           <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:tnav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li"><a href="javascript:;">可能感兴趣的猎头</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">找猎头</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item">
                            <div class="t_item_top">
                                <div class="ops_filter">
                                    <span>筛选条件：</span>
                                    <span>
                                        <a href="javascript:;" title="" class="red" rel="0">不限</a>
                                    </span>
                                    <b>/</b>
                                    <span>
                                        <a href="javascript:;" title="" rel="1">个人</a>
                                    </span>
                                    <b>/</b>
                                    <span>
                                        <a href="javascript:;" title="" rel="2">公司成员</a>
                                    </span>
                                     <div class="s_r en_c_r">
                                          <span>
                                            地区选择:
                                        </span>
                                        <div class="chos_area">
                                            <input type="hidden" name="prov_id" />
                                            <input type="hidden" name="city_id" />
                                            <input id="from_area" class="from_area mselect" readonly value="" />
                                        </div>
                                    </div>
                              </div>
                            </div>
                            <input type="hidden" name="resuid"  value="{$type}"/>
                            <ul class="mlist hgstemp" id="agent_list">
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
        <div class="sele_agent"></div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>