<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>客户管理</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$crm_root}/css/resource_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/mask/mask.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$crm_root}/config/loader.js" id="loader">95</script>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 resource com_lde">
            <div class="sm_tab">
                <ul>
                    <li class="cur_li"><a href="javascript:;">人才资源管理</a></li>
                    <li><a href="javascript:;">企业资源管理</a></li>
                </ul>
                <div class="sub_title">
                    <a href="javascript:;" title="" class="blue">客户管理</a>
                </div>
            </div>
            <div class="t_container">
                <div class="t_item show">
                    <!--操作-->
                    <div class="h_tp">
                        <div class="fl sert_ops">
                            <span class="condition">筛选条件：</span>
                            <span class="type htype">
                                <a href="javascript:;" title="不限" class="red" rel="0">不限</a>
                                <span>/</span>
                                <a href="javascript:;" title="兼职" rel="1">兼职</a>
                                <span>/</span>
                                <a href="javascript:;" title="全职" rel="2">全职</a>
                            </span>
                            <span class="sc">
                                <span>来源:</span>
                                <select id="perid1">
                                        <option value="0">不限</option>
                                    <foreach name="source" item="sour">
                                        <option value="{$sour.id}">{$sour.name}</option>
                                    </foreach>
                                </select>
                            </span>
                            <span class="peroid">
                                <span>阶段:</span>
                                <select id="p1">
                                        <option value="0">不限</option>
                                    <foreach name="category" item="cate" >
                                        <option value="{$cate.id}">{$cate.name}</option>
                                    </foreach>
                                </select>
                                <span class="hidden pro hm">
                                    进度:<select id="p2">
                                        <foreach name="progress" item="ps" >
                                            <option value="{$ps.id}">{$ps.name}</option>
                                        </foreach>
                                    </select>
                                </span>
                            </span>
                        </div>
                        <div class="area sert_ops">
                            <span class="condition">所属地区：</span><input type="text" value="" readonly id="pce" pid="" class="mselect place" />
                        </div>
                        <div class="rbox sert_ops">
                                <input type="hidden" name="mid" />
                                <input type="hidden" name="rid" />
                                <span class="condition">资质证书：</span><input type="text" value="" readonly id="pqcect" class="mselect pcrt" />
                            </div>
                        <div class="zbox sert_ops">
                            <input type="hidden" name="jtlid" />
                            <input type="hidden" name="jtyid" />
                            <input type="hidden" name="jtid" />
                            <span class="condition">人才职称证：</span><input type="text" value="" readonly id="zsect" class="mselect zert" />
                        </div>
                        <div class="hprice sert_ops">
                            <span class="condition">报价：</span>
                            <span class="hpce price">
                                <a href="javascript:;" title="全部" class="red fcd" rel="0">全部</a>
                                <a href="javascript:;" title="1-10万" rel="7">1-10万</a>
                                <a href="javascript:;" title="10-15万" rel="1">10-15万</a>
                                <a href="javascript:;" title="15-20万" rel="2">15-20万</a>
                                <a href="javascript:;" title="20-30万" rel="3">20-30万</a>
                                <a href="javascript:;" title="30-50万" rel="4">30-50万</a>
                                <a href="javascript:;" title="50-100万" rel="5">50-100万</a>
                                <a href="javascript:;" title="100万+" rel="6">100万+</a>
                            </span>
                        </div>
                        <div class="kbox sert_ops">
                            <span class="condition">关键词：</span><input type="text" id="hkey" class="inbox" value="" />
                        </div>
                        <div class="skey sert_ops">
                            <div class="sbtn btn_common btn4_common btn4">
                                <span class="b_lf"></span>
                                <span class="b_rf"></span>
                                <a href="javascript:;" id="search" class="btn white">搜索</a>
                            </div>
                        </div>
                    </div>
                    <span class="lt lf">
                        <label for="ctm">
                           <input type="checkbox" vlaue="" class="all" name="chos_all" id="ctm">全选
                        </label> 
                    </span>
                    <div class="h_md rf">
                        <a href="javascript:;" class="blue fst apr" title="添加人才资源"><em class="add_p"></em>添加人才资源</a>
                        <a href="javascript:;" class="blue dele_human" title="删除"><em class="delet_p"></em>删除</a>  
                        <a href="javascript:;" class="blue emil_all" title="群发邮件"><em class="semail_p"></em>群发邮件</a>  
                        <a href="javascript:;" class="blue import_human" title="导入人才资源"><em class="import_p"></em>导入人才资源</a>  
                    </div> 
                    <div class="clr"></div>
                    <!--列表数据-->
                    <table id="hr_list" class="hgstemp r_list hr_list set_pad"></table>
                    <ul>
                        <li class="loading">
                            <p></p>
                        </li>
                    </ul>
                    <!--操作-->
                    <div class="h_md hr_hd">
                        <span class="all">
                            <label for="chos_all">
                                <input type="checkbox" id="chos_all" name="nams" />全选
                            </label> 
                        </span>
                        <input type="hidden" value="" name="ditem" />
                        <input type="hidden" value="" name="peoples" />
                        <a href="javascript:;" class="blue fst apr" title="添加人才资源"><em class="add_p"></em>添加人才资源</a>
                        <a href="javascript:;" class="blue dele_human" title="删除"><em class="delet_p"></em>删除</a>  
                        <a href="javascript:;" class="blue emil_all" title="群发邮件"><em class="semail_p"></em>群发邮件</a>  
                        <a href="javascript:;" class="blue import_human" title="导入人才资源"><em class="import_p"></em>导入人才资源</a>  
                    </div> 
                    <div class="pages" id="pagination">
                        <div class="pagination">
                        </div>
                    </div>
                </div>
                <div class="t_item hidden"> 
                    <div class="h_tp">
                        <div class="fl sert_ops">
                        <span class="condition">筛选条件：</span>
                            <span class="ctype type">
                                <a href="javascript:;" title="不限" class="red" rel="0">不限</a>
                                <span>/</span>
                                <a href="javascript:;" title="兼职" rel="1">兼职</a>
                                <span>/</span>
                                <a href="javascript:;" title="全职" rel="2">全职</a>
                            </span>
                            <span class="sc">
                                <span>来源:</span>
                                <select id="csource">
                                    <option value="0">不限</option>
                                     <foreach name="source" item="sour">
                                        <option value="{$sour.id}">{$sour.name}</option>
                                    </foreach>
                                </select>
                            </span>
                            <span class="peroid">
                                <span>阶段:</span>
                                <select id="cp1">
                                    <option value="0">不限</option>
                                    <foreach name="category" item="cate" >
                                        <option value="{$cate.id}">{$cate.name}</option>
                                    </foreach>
                                </select>
                                <span class="hidden pro cpro">
                                    进度:<select id="cp2">
                                        <foreach name="progress" item="ps" >
                                            <option value="{$ps.id}">{$ps.name}</option>
                                        </foreach>
                                    </select>
                                </span>
                            </span>
                        </div>
                        <div class="area sert_ops">
                            <span class="condition">需求地区：</span><input type="text"  readonly id="cplace" pid="" class="mselect place" />
                        </div>
                        <div class="rbox sert_ops">
                            <input type="hidden" name="cmid" />
                            <input type="hidden" name="crid" />
                            <span class="condition">需求证书：</span><input type="text" value="" readonly id="cqt" class="mselect pcrt" />
                        </div>
                         <div class="cprice sert_ops">
                            <span class="condition">报价：</span>
                            <span class="cpce price">
                                <a href="javascript:;" title="全部" class="red fcd" rel="0">全部</a>
                                <a href="javascript:;" title="1-10万" rel="7">1-10万</a>
                                <a href="javascript:;" title="10-15万" rel="1">10-15万</a>
                                <a href="javascript:;" title="15-20万" rel="2">15-20万</a>
                                <a href="javascript:;" title="20-30万" rel="3">20-30万</a>
                                <a href="javascript:;" title="30-50万" rel="4">30-50万</a>
                                <a href="javascript:;" title="50-100万" rel="5">50-100万</a>
                                <a href="javascript:;" title="100万+" rel="6">100万+</a>
                            </span>
                        </div>
                        <div class="zbox sert_ops">
                            <span class="condition">关键词：</span><input type="text" id="ckey" class="inbox"/>
                        </div>
                        <div class="skey sert_ops">
                            <div class="sbtn btn_common btn4_common btn4">
                                <span class="b_lf"></span>
                                <span class="b_rf"></span>
                                <a href="javascript:;" id="csearch" class="btn white">搜索</a>
                            </div>
                        </div>  
                    </div>
                    <span class="ct lf">
                        <label for="tm">
                            <input type="checkbox" vlaue="" class="all" name="eall" id="tm"/>全选
                        </label>
                    </span>
                    <div class="h_md rf">
                        <a href="javascript:;" class="blue fst adcmp" title="添加企业资源"><em class="add_p"></em>添加企业资源</a>
                        <a href="javascript:;" class="blue dele_company" title="删除"><em class="delet_p"></em>删除</a>  
                        <a href="javascript:;" class="blue email_company" title="群发邮件"><em class="semail_p"></em>群发邮件</a>  
                        <a href="javascript:;" class="blue impt_cr" title="导入企业资源"><em class="import_p"></em>导入企业资源</a>  
                    </div> 
                    <div class="clr"></div>
                    <!--企业资源客户列表数据-->
                    <table id="cmp_list" class="hgstemp r_list er_list set_pad">
                    </table>
                    <ul>
                        <li class="loading">
                            <p></p>
                        </li>
                    </ul>
                    <!--操作-->
                    <div class="h_md cp_hd">
                        <span class="all">
                            <label for="cmp_all">
                                <input type="checkbox" id="cmp_all" name="cm" />全选
                            </label> 
                        </span>
                        <input type="hidden" value="" name="cdeletm" />
                        <input type="hidden" value="" name="cpeos" />
                        <a href="javascript:;" class="blue fst adcmp" title="添加企业资源"><em class="add_p"></em>添加企业资源</a>
                        <a href="javascript:;" class="blue dele_company" title="删除"><em class="delet_p"></em>删除</a>  
                        <a href="javascript:;" class="blue email_company" title="群发邮件"><em class="semail_p"></em>群发邮件</a>  
                        <a href="javascript:;" class="blue impt_cr" title="导入企业资源"><em class="import_p"></em>导入企业资源</a> 
                    </div> 
                    <div class="pages" id="pagination1">
                        <div class="pagination">
                        </div>
                    </div>
                </div>
            </div>
            <!-- layout::Home:Public:footersimple::60 -->
    </body>
</html>
