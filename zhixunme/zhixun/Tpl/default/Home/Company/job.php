<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>发布新职位 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/benterprise_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/slt-hgs/slt-hgs.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">86</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 enterinvite">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:enav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li"><a href="javascript:;">发布兼职职位</a></li>
                            <li><a href="javascript:;">发布全职职位</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">招聘管理</a>
                            <input type="hidden" value="" id="tempsave"/>
                        </div>
                    </div>
                    <div class="t_container">
                        <p class="title">职位描述</p>
                        <div class="t_item show">
                            <!-- 兼职 -->
                            <table class="tb tb_all">
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>标题 : </span>
                                    </td>
                                    <td>
                                        <input type="text" id="jtit" class="lontxt"/>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>招聘类别 : </span>
                                    </td>
                                    <td>
                                        <input type="radio" name="pcatg" id="cate1" value="2" checked/><label for="cate1">热招</label>
                                        <input type="radio" name="pcatg" id="cate2" value="1"  /><label for="cate2">预招</label>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="ltd">
                                    </td>
                                    <td>
                                       <div class="etip red">注："资质要求"和"职称要求"至少填写一项</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                       资质要求 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect qual_select" type="text" id="jqual_select" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>职称要求 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect" type="text" id="jtitle_selt" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>地区要求 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect" type="text" id="jpselect" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>证书使用地 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect" type="text" id="jupselect" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>薪资待遇 : </span>
                                    </td>
                                    <td>
                                        <select id="jthepay" class="scbox">
                                            <option value="0">面议</option>
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
                                        <span> 万/年</span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>接受多证 : </span>
                                    </td>
                                    <td>
                                        <input type="radio" name="acmult" checked value="1" id="acmult1"/><label for="acmult1">是</label>
                                        <input type="radio" name="acmult" value="0" id="acmult2"/><label for="acmult2">否</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>考取安全B证 : </span>
                                    </td>
                                    <td>
                                        <input type="radio" name="isb" checked value="1" id="isb1"/><label for="isb1">是</label>
                                        <input type="radio" name="isb" value="0" id="isb2"/><label for="isb2">否</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>学历要求 : </span>
                                    </td>
                                    <td>
                                        <select id="jdegree" class="scbox">
                                            <option value="0">不限</option>
                                            <option value="1">中专</option>
                                            <option value="2">大专</option>
                                            <option value="3">本科</option>
                                            <option value="4">研究生</option>
                                            <option value="5">博士</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>工作经验 : </span>
                                    </td>
                                    <td>
                                        <select id="jexp" class="scbox">
                                            <option value="0">不限</option>
                                            <option value="1">1年以上</option>
                                            <option value="2">3年以上</option>
                                            <option value="3">5年以上</option>
                                            <option value="4">8年以上</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>工作状态 : </span>
                                    </td>
                                    <td>
                                        <input type="radio" name="workstate" id="workstate1" value="0" checked/><label for="workstate1">不限</label>
                                        <input type="radio" name="workstate" id="workstate2" value="1"/><label for="workstate2">在职</label>
                                        <input type="radio" name="workstate" id="workstate3" value="2"/><label for="workstate3">退休</label>
                                        <input type="radio" name="workstate" id="workstate4" value="3"/><label for="workstate4">离职</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>社保要求 : </span>
                                    </td>
                                    <td>
                                        <input type="radio" name="sprequire" id="sprequire1" value="0" checked/><label for="sprequire1">不限</label>
                                        <input type="radio" name="sprequire" id="sprequire2" value="1"/><label for="sprequire2">需缴纳</label>
                                        <input type="radio" name="sprequire" id="sprequire3" value="2"/><label for="sprequire3">不需缴纳</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd lst_td ltop">
                                        <span>职位描述 : </span>
                                    </td>
                                    <td>
                                        <textarea cols="" rows="" id="pjob_des"></textarea>
                                    </td>
                                </tr>
                            </table>
                             <p class="liner"></p>
                            <p class="ctitle">企业信息</p>
                            <p class="sys_note">系统提示:如需修改企业信息，请修改企业基本资料 <a href="{$web_root}/profiles" target="_blank" class="blue" title="去修改">去修改</a>。<span class="red">资料修改完成后，刷新此页面</span></p>
                            <table class="tb">
                                <tr>
                                    <td class="ltd">
                                        <span>招聘企业 : </span>
                                    </td>
                                    <td>
                                        <div class="lontxt">{$info.name}</div>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="ltd">
                                        <span>企业资质 : </span>
                                    </td>
                                    <td>
                                        <div class="lontxt">{$info.company_qualification}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>企业性质 : </span>
                                    </td>
                                    <td>
                                        <div class="lontxt">{$info.category}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>成立时间 : </span>
                                    </td>
                                    <td>
                                       <if condition="$info.company_regtime neq '0000-00-00'">
                                            <div class="lontxt">{$info.company_regtime}
                                          <else /><div class="lontxt">
                                        </if>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>企业规模 : </span>
                                    </td>
                                    <td>
                                        <div class="lontxt">{$info.company_scale}</div>
                                  </td>
                                </tr>
                                 <tr>
                                    <td class="ltd ltop">
                                       <span>企业简介 : </span>
                                    </td>
                                    <td colsapn="3">
                                        <div class="info">{$info.summary}</div>
                                    </td>
                                </tr>
                            </table>
                            <div class="pb_op">
                                <h2 class="p_info">
                                    请选择该职位的发布方式
                                </h2>
                                <div class="pb_s lf">
                                    <div class="btn_common btn5 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="part_agentpub">猎头代理</a>
                                    </div>
                                </div>
                                <div class="me_or red lf">
                                    或
                                </div>
                                <div class="pb_a lf">
                                    <div class="btn_common btn8 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="epart_pub">公开招聘</a>
                                    </div>
                                </div>
                                <div class="clr"></div>
                                <div class="t_l">
                                    <div class="l_tip lf">
                                        <p class="red">委托给猎头代理后</p>
                                        <p class="red">猎头会与您联系根据您的需求</p>
                                        <p class="red">为您筛选最合适的人才</p>
                                    </div>
                                    <div class="r_tip rf">
                                        <p class="red">公开招聘后</p>
                                        <p class="red">职位将不可被猎头代理</p>
                                        <p class="red">您会收到人才或者猎头发来的求职简历</p>
                                        <p class="red">需要您自己对简历进行筛选和管理</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="t_item hidden">
                            <!-- 全职 -->
                            <table class="tb tbful">
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>标题 : </span>
                                    </td>
                                    <td>
                                        <input type="text" id="qtit" class="lontxt"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>招聘类别 : </span>
                                    </td>
                                    <td>
                                        <input type="radio" name="qatg" id="qcate" value="2" checked/><label for="qcate">热招</label>
                                        <input type="radio" name="qatg" id="qcate1" value="1"  /><label for="qcate1">预招</label>
                                    </td>
                                </tr>
                                <tr class="lst_tr">
                                    <td class="ltd">
                                        <span class="red">* </span><span>招聘职位 : </span>
                                    </td>
                                    <td class="fpos">
                                        <a href="javascript:;" id="qposition" cids="" pids="" names="" class="blue">选择职位</a><span class="red hidden" id="jtip">职位选择不能为空!</span>
                                        <div class="slt_pos" id="slt_pos">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>招聘人数 : </span>
                                    </td>
                                    <td>
                                        <input type="text" class="percount" id="percount"/> 人
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>资质要求 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect qual_select" type="text" id="qqual_select" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>职称要求 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect" type="text" id="qtitle_selt" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>工作地点 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect" type="text" id="qpselect" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span class="red">* </span><span>薪资待遇 : </span>
                                    </td>
                                    <td>
                                        <select id="thepay" class="scbox">
                                            <option value="0">面议</option>
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
                                        <input value="" id="defpay1" class="defpay hidden" type="text" />
                                        <span> 万/年</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>学历要求 : </span>
                                    </td>
                                    <td>
                                        <select id="degree"class="scbox">
                                            <option value="0">不限</option>
                                            <option value="1">中专</option>
                                            <option value="2">大专</option>
                                            <option value="3">本科</option>
                                            <option value="4">研究生</option>
                                            <option value="5">博士</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>工作经验 : </span>
                                    </td>
                                    <td>
                                        <select id="exp"class="scbox">
                                            <option value="0">不限</option>
                                            <option value="1">1年以上</option>
                                            <option value="2">3年以上</option>
                                            <option value="3">5年以上</option>
                                            <option value="4">8年以上</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd lst_td ltop">
                                        <span>职位描述 : </span>
                                    </td>
                                    <td>
                                        <textarea cols="" rows="" id="pos_des"></textarea>
                                    </td>
                                </tr>
                            </table>
                            <p class="liner"></p>
                            <p class="ctitle">企业信息</p>
                            <p class="sys_note">系统提示:如需修改企业信息，请修改企业基本资料 <a href="{$web_root}/profiles" target="_blank" class="blue" title="去修改">去修改</a>。<span class="red">资料修改完成后，刷新此页面</span></p>
                              <table class="tb">
                                <tr>
                                    <td class="ltd">
                                        <span>招聘企业 : </span>
                                    </td>
                                    <td>
                                        <div class="lontxt">{$info.name}</div>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="ltd">
                                        <span>企业资质 : </span>
                                    </td>
                                    <td>
                                        <div class="lontxt">{$info.company_qualification}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>企业性质 : </span>
                                    </td>
                                    <td>
                                        <div class="lontxt">{$info.category}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>成立时间 : </span>
                                    </td>
                                    <td>
                                        <if condition="$info.company_regtime neq '0000-00-00'">
                                            <div class="lontxt">{$info.company_regtime}
                                          <else /><div class="lontxt">
                                        </if>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ltd">
                                        <span>企业规模 : </span>
                                    </td>
                                    <td>
                                        <div class="lontxt">{$info.company_scale}</div>
                                  </td>
                                </tr>
                                 <tr>
                                    <td class="ltd ltop">
                                       <span>企业简介 : </span>
                                    </td>
                                    <td colsapn="3">
                                        <div class="info">{$info.summary}</div>
                                    </td>
                                </tr>
                            </table>
                            <div class="pb_op pub_job">
                                <h2 class="p_info">
                                    请选择该职位的发布方式
                                </h2>
                                <div class="pb_s lf">
                                    <div class="btn_common btn5 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="fl_agentpub">猎头代理</a>
                                    </div>
                                </div>
                                <div class="me_or red lf">
                                    或
                                </div>
                                <div class="pb_a lf">
                                    <div class="btn_common btn8 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="efl_pub">公开招聘</a>
                                    </div>
                                </div>
                                <div class="clr"></div>
                                <div class="t_l">
                                    <div class="l_tip lf">
                                        <p class="red">委托给猎头代理后</p>
                                        <p class="red">猎头会与您联系根据您的需求</p>
                                        <p class="red">为您筛选最合适的人才</p>
                                    </div>
                                    <div class="r_tip rf">
                                        <p class="red">公开招聘后</p>
                                        <p class="red">职位将不可被猎头代理</p>
                                        <p class="red">您会收到人才或者猎头发来的求职简历</p>
                                        <p class="red">需要您自己对简历进行筛选和管理</p>
                                    </div>
                                </div>
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