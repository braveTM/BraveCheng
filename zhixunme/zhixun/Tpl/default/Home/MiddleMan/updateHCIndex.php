<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>人才兼职简历修改 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bagent_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/jquery-datepicker/jquery.ui.datepicker.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">76</script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 tmanage tpro fresalter">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::{$nav}::0 -->
                </div>
            </div>
            <div class="layout1_r acc_opion">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li"><a href="javascript:;">兼职简历修改</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">简历管理</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item addtalents addfres">                            
                                <if condition="$HC_resume.resume_status neq 3">
                                    <div class="pr_num" id="pr_num">
                                    <span class="red">当前简历已公开，若要修改该简历，请先结束求职</span>
                                    </div>
                                </if>                            
                            <div class="step step1 updatedata">
                                <if condition="$HC_resume.resume_status eq 3">
                                    <a href="javascript:;" class="blue alertitem">修改</a>
                                    <else/>
                                    <a href="javascript:;" class="blue alertitem" style="display:none;">修改</a>
                                </if>
                                <p class="title">人才信息 <span class="red">[必填]</span></p>
                                <table class="tb pinfo">
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>姓名 : </span>
                                        </td>
                                        <td>
                                            <input readonly="true" type="text" id="uname" value="{$HC_resume.human.name}" class="text"/>
                                        </td>
                                        <td class="ltd">
                                            <span>性别 : </span>
                                        </td>
                                        <td>
                                    <if condition="$HC_resume.human.gender eq 1">
                                        <span class="txtinfo" val="1">男</span>
                                        <else/>
                                        <span class="txtinfo" val="0">女</span>
                                    </if>
                                    <input type="radio" name="sex" value="1"  class="sx"checked/><span class="txthid">男</span>
                                    <input type="radio" name="sex" value="0"  class="sx"/><span class="txthid">女</span>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>生日 : </span>
                                        </td>
                                        <td style="position:relative">
                                            <input id="date" type="text" value="{$HC_resume.human.birth}" readonly="true" class="text"/>
                                        </td>
                                        <td class="ltd">
                                            <span class="red">* </span><span>工作年限 : </span>
                                        </td>
                                        <td>
                                            <span class="txtinfo" val="{$HC_resume.human.exp[0]}"> {$HC_resume.human.exp[1]}</span>
                                            <select id="uexp">
                                                <option value="0">无</option>
                                                <option value="1">1年以上</option>
                                                <option value="2">3年以上</option>
                                                <option value="3">5年以上</option>
                                                <option value="4">8年以上</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>所在地 : </span>
                                        </td>
                                        <td class="rtd">
                                            <input class="mselect" type="text" id="place" pid="{$HC_resume.human.province}" cid="{$HC_resume.human.city}" value="{$HC_resume.human.addr}" readonly/>
                                        </td>
                                        <td class="ltd">
                                            <span class="red">* </span><span>手机 : </span>
                                        </td>
                                        <td>
                                            <input readonly="true" type="text" id="phone" value="{$HC_resume.human.phone}" class="text"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>Email : </span>
                                        </td>
                                        <td>
                                            <input readonly="true" type="text" id="uemail" value="{$HC_resume.human.email}" class="text"/>
                                        </td>
                                        <td class="ltd">
                                            <span>QQ : </span>
                                        </td>
                                        <td>
                                            <input readonly="true" type="text" id="uqq" value="{$HC_resume.human.qq}" class="text"/>
                                        </td>
                                    </tr>
                                </table>
                                <div class="nextone">
                                    <div class="btn_common btn4">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="onenext" hid="{$HC_resume.human.id}">保存</a>
                                    </div>
                                </div>
                                <p class="clr"></p>
                            </div>
                            <div class="step step4 updatedata">
                                <if condition="$HC_resume.resume_status eq 3">
                                    <a href="javascript:;" class="blue alertitem" id="qalertitem">修改</a>
                                    <else/>
                                    <a href="javascript:;" class="blue alertitem" id="qalertitem" style="display:none;">修改</a>
                                </if>
                                <p class="title">证书情况 <span class="red">[必填]</span></p>
                                <table class="tb">
                                    <tr class="qualcont">
                                        <td class="ltd qtd">
                                            <span class="red">* </span><span>资质证书 : </span>
                                        </td>
                                        <td id="myquals">
                                    <foreach name="HC_resume.register_certificate_list" item="qual">
                                        <div class="qualitem"><span>{$qual.register_certificate_name} - <if condition="$qual.register_certificate_major neq ''">{$qual.register_certificate_major} - </if>{$qual.register_case} - {$qual.register_place}</span><a href="javascript:;" class="addqual rf">添加</a><a href="javascript:;" class="delqual rf" cid="{$qual.certificate_id}" hid="{$HC_resume.human.id}">删除</a></div>
                                    </foreach>
                                    <input class="mselect qual_select" id="tqual" type="text" style="display:none" readonly/><a href="javascript:;" id="savequal" class="blue" cid="{$qual.certificate_id}" hid="{$HC_resume.human.id}">保存</a><a href="javascript:;" id="cancelqual" class="blue">取消</a>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>职称证 : </span>
                                        </td>
                                        <td>
                                            <input class="mselect" type="text" readonly id="tjtitle" value="{$HC_resume.grade_certificate.grade_certificate_class_name} - {$HC_resume.grade_certificate.grade_certificate_major}" cid="{$HC_resume.grade_certificate.grade_certificate_id}" gra="{$HC_resume.grade_certificate.grade_certificate_class}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>期望待遇 : </span>
                                        </td>
                                        <td>                                 
                                            <span class="txtinfo" val="{$HC_resume.job_salary[0]}">{$HC_resume.job_salary[1]}</span>
                                            <select id="expay" class="pay">
                                                <option value="0">面议</option>
                                                <option value="7">&nbsp;&nbsp;0 ～ 1</option>
                                                <option value="8">&nbsp;&nbsp;1 ～ 2</option>
                                                <option value="9">&nbsp;&nbsp;2 ～ 3</option>
                                                <option value="10">&nbsp;&nbsp;3 ～ 4</option>
                                                <option value="11">&nbsp;&nbsp;4 ～ 5</option>
                                                <option value="2">5 ～ 10</option>
                                                <option value="3">10 ～ 20</option>
                                                <option value="4">20 ～ 40</option>
                                                <option value="5">40 ～ 99</option>
                                                <option value="6">100 +</option>
                                                <option value="12">手动填写</option>
                                            </select>
                                            <input value="" id="defpay" class="defpay hidden" type="text" />
                                        <span>万/年</span>
                                    </switch>                                            
                                </td>
                                </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>期望注册地 : </span>
                                        </td>
                                        <td>
                                            <input class="mselect text" type="text" readonly id="explace" value="{$HC_resume.register_provinces}" pid="{$HC_resume.register_province_ids}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span>补充说明 : </span>
                                        </td>
                                        <td>
                                            <textarea cols="" rows="" id="add_des" readonly>{$HC_resume.certificate_remark}</textarea>
                                        </td>
                                    </tr>
                                </table>
                                <div class="nextone">
                                    <div class="btn_common btn4">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="btnsavequal" hid="{$HC_resume.human.id}" certid="{$HC_resume.grade_certificate.certificate_id}">保存</a>
                                    </div>
                                </div>
                                <p class="clr"></p>
                            </div>
                            <div class="pb_op">
                                <h2 class="p_info">
                                    <span class="gray">您还可以选择的操作:</span>
                                </h2>
                                <div class="pb_s lf">
                                    <div class="btn_common btn5 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <if condition="$HC_resume.resume_status eq 3">
                                            <a href="javascript:;" class="btn white" id="pubresnow" type="1" rid="{$HC_resume.resume_id}">立即公开求职</a>
                                            <else/>
                                            <a href="javascript:;" class="btn white" id="pubresnow" type="1" rid="{$HC_resume.resume_id}">立即结束求职</a>
                                        </if>
                                    </div>
                                </div>
                                <input type="hidden" id="showalert" value="{$HC_resume.resume_status}"/>
                                <div class="clr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clr"></div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
