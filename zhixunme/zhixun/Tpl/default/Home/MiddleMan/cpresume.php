<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>创建兼职简历 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bagent_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/jquery-datepicker/jquery.ui.datepicker.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">83</script>  
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
                            <li class="cur_li"><a href="{$web_root}/acpresume/">创建兼职简历</a></li>
                            <li><a href="{$web_root}/a_add_r_index/1" class="nodata">创建全职简历</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">简历管理</a>
                        </div>
                    </div>
                    <p class="sys_note">系统提示: 您公开的简历会自动同步至<a href="{$web_root}/resource/" class="red">[客户管理]</a>系统中。公开的简历,系统默认显示您的联系方式,人才联系方式自动隐藏。</p>
                    <div class="t_container">
                        <!---------------------创建兼职简历-------------------->
                        <div class="t_item addtalents show">
                            <p class="title">人才信息</p>
                            <table class="tb pinfo">
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>姓名 : </span>
                                    </td>
                                    <td>
                                        <input type="text" id="uname"/>
                                    </td>
                                    <td class="ltd">
                                        <span>性别 : </span>
                                    </td>
                                    <td>
                                        <input type="radio" id="male" name="sex" value="1" checked/><label for="male">男</label>
                                        <input type="radio" name="sex" value="0" id="female"/><label for="female">女</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>生日 : </span>
                                    </td>
                                    <td style="position:relative">
                                        <input id="date" type="text" value="" readonly="true" title="点击右侧图标选择日期"/>
                                    </td>
                                    <td class="ltd">
                                        <span>所在地 : </span>
                                    </td>
                                    <td class="rtd">
                                        <input class="mselect" type="text" id="place" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>手机 : </span>
                                    </td>
                                    <td>
                                        <input type="text" id="phone"/>
                                    </td>
                                    <td class="ltd">
                                        <span>QQ : </span>
                                    </td>
                                    <td>
                                        <input type="text" id="uqq"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>Email : </span>
                                    </td>
                                    <td>
                                        <input type="text" id="uemail"/>
                                    </td>
                                    <td class="ltd">
                                        <span>工作年限 : </span>
                                    </td>
                                    <td>
                                        <select id="uexp">
                                            <option value="0">无</option>
                                            <option value="1">1年以上</option>
                                            <option value="2">3年以上</option>
                                            <option value="3">5年以上</option>
                                            <option value="4">8年以上</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <p class="liner"></p>
                            <p class="title">证书情况</p>
                            <table class="tb">
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>资质证书 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect qual_select" id="tqual" type="text" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>职称证 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect" type="text" readonly id="tjtitle"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>期望待遇 : </span>
                                    </td>
                                    <td>
                                        <select id="expay" class="hc">
                                            <option value="0">&nbsp;&nbsp;面议</option>
                                            <option value="7">&nbsp;&nbsp;0 ～ 1</option>
                                            <option value="8">&nbsp;&nbsp;1 ～ 2</option>
                                            <option value="9">&nbsp;&nbsp;2 ～ 3</option>
                                            <option value="10">&nbsp;&nbsp;3 ～ 4</option>
                                            <option value="11">&nbsp;&nbsp;4 ～ 5</option>
                                            <option value="2">&nbsp;&nbsp;5 ～ 10</option>
                                            <option value="3">10 ～ 20</option>
                                            <option value="4">20 ～ 40</option>
                                            <option value="5">40 ～ 99</option>
                                            <option value="6">100 +</option>
                                            <option value="12">手动填写</option>
                                        </select>
                                        <input value="" id="defpay" class="defpay hidden" type="text" />
                                        万/年
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>期望注册地 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect" type="text" readonly id="explace"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd lst_td">
                                        <span>补充说明 : </span>
                                    </td>
                                    <td>
                                        <textarea cols="" rows="" id="add_des">{$HC_resume.certificate_remark}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <p class="liner"></p>
                            <div class="pb_op">
                                <h2 class="p_info">
                                    可选操作 :
                                </h2>
                                <div class="pb_s lf">
                                    <div class="btn_common btn5 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="pubresnow" type="1">立即公开求职</a>
                                    </div>
                                </div>
                                <div class="me_or red lf">
                                    or
                                </div>
                                <div class="pb_a lf">
                                    <div class="btn_common btn8 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="savebtn" type="0">保存,暂不求职</a>
                                    </div>
                                </div>
                                <div class="clr"></div>
                            </div>
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
