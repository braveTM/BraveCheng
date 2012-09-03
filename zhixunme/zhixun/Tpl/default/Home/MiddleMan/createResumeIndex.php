<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>创建全职简历 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bagent_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/slt-hgs/slt-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/jquery-datepicker/jquery.ui.datepicker.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">67</script>  
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
                            <li><a href="{$web_root}/acpresume/" class="nodata">创建兼职简历</a></li>
                            <li class="cur_li"><a href="{$web_root}/a_add_r_index/1">创建全职简历</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">简历管理</a>
                        </div>
                    </div>
                    <p class="sys_note">系统提示:您公开的人才简历信息会自动同步至[客户管理]系统中。</p>
                    <div class="t_container">
                        <!---------------------应聘来的简历-------------------->
                        <div class="t_item hidden">
                        </div>
                        <!---------------------创建全职简历-------------------->
                        <div class="t_item addtalents addfres show">
                            <div class="steptab steptab1">
                                <span class="frtspan">第 1 步</span><span>个人信息</span><span class="red"> [必填]</span>
                                <span class="gray hidden">已完成</span>
                            </div>
                            <div class="step step1">
                                <p class="title">人才信息 <span class="red">[必填]</span></p>
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
                                            <span class="red">* </span><span>生日 : </span>
                                        </td>
                                        <td style="position:relative">
                                            <input id="date" type="text" value="" readonly="true" title="点击右侧图标选择日期"/>
                                        </td>
                                        <td class="ltd">
                                            <span class="red">* </span><span>工作年限 : </span>
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
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>所在地 : </span>
                                        </td>
                                        <td class="rtd">
                                            <input class="mselect" type="text" id="place" readonly/>
                                        </td>
                                        <td class="ltd">
                                            <span class="red">* </span><span>手机 : </span>
                                        </td>
                                        <td>
                                            <input type="text" id="phone"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>Email : </span>
                                        </td>
                                        <td>
                                            <input type="text" id="uemail"/>
                                        </td>
                                        <td class="ltd">
                                            <span>QQ : </span>
                                        </td>
                                        <td>
                                            <input type="text" id="uqq"/>
                                        </td>
                                    </tr>
                                </table>
                                <p class="nextone"><span class="gray">请认真核对以上信息,</span><a href="javascript:;" class="red" id="onenext">下一步></a></p>
                            </div>
                            <div class="steptab steptab2">
                                <span class="frtspan">第 2 步</span><span>求职岗位</span><span class="red"> [必填]</span><span>学历</span><span class="red"> [必填]</span><span>证书情况</span>
                                <span class="gray hidden">已完成</span>
                            </div>
                            <div class="step2 step hidden">
                                <p class="title">求职岗位 <span class="red">[必填]</span></p>
                                <table class="tb">
                                    <tr class="lst_tr">
                                        <td class="ltd">
                                            <span class="red">* </span><span>职位名称 : </span>
                                        </td>
                                        <td class="fpos">
                                            <a href="javascript:;" id="qposition" cids="" pids="" names="">选择职位</a><span class="red hidden" id="jtip">职位选择不能为空!</span>
                                            <div class="slt_pos" id="slt_pos">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>期望工作地点 : </span>
                                        </td>
                                        <td>
                                            <input class="mselect sm_input" type="text" id="explace" readonly/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>期望待遇 : </span>
                                        </td>
                                        <td>
                                            <select id="expay" class="hc pay">
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
                                        <td class="ltd lst_td">
                                            <span>职位描述 : </span>
                                        </td>
                                        <td>
                                            <textarea cols="" rows="" id="pos_des"></textarea>
                                        </td>
                                    </tr>
                                </table>
                                <p class="title">学历 <span class="red">[必填]</span></p>
                                <table class="tb">
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>时间 : </span>
                                        </td>
                                        <td class="tcont">
                                            <div class="lf"><input id="stime" type="text" class="timer" readonly="true" title="点击右侧图标选择日期"/></div>
                                            <div class="lf mlf">至</div>
                                            <div class="lf" style="width:370px;"><input id="etime" type="text" class="timer" readonly="true" title="点击右侧图标选择日期"/></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>学校名称 : </span>
                                        </td>
                                        <td>
                                            <input type="text" id="mscname"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>专业名称 : </span>
                                        </td>
                                        <td>
                                            <input type="text" id="mmajname"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span>学历 : </span>
                                        </td>
                                        <td>
                                            <select id="tdegree">
                                                <option value="1">中专</option>
                                                <option value="2">大专</option>
                                                <option value="3">本科</option>
                                                <option value="4">研究生</option>
                                                <option value="5">博士</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <p class="title">证书情况</p>
                                <table class="tb">
                                    <tr>
                                        <td class="ltd">
                                            <span>资质证书 : </span>
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
                                        <td class="ltd lst_td">
                                            <span>补充说明 : </span>
                                        </td>
                                        <td>
                                            <textarea cols="" rows="" id="add_des"></textarea>
                                        </td>
                                    </tr>
                                </table>
                                <p class="nextone"><a href="javascript:;" class="red" id="twonext">下一步></a></p>
                            </div>
                            <div class="steptab steptab3">
                                <span class="frtspan">第 3 步</span><span>工作经历</span><span class="red"> </span><span>工程业绩</span>
                            </div>
                            <div class="step step3 hidden">
                                <p class="title">工作经历</p>
                                <div id="wdegree_cont">
                                </div>
                                <table class="tb" id="workexp">
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>任职时间 : </span>
                                        </td>
                                        <td class="tcont">
                                            <div class="lf"><input id="wstime" type="text" class="timer" readonly="true" title="点击右侧图标选择日期"/></div>
                                            <div class="lf mlf">至</div>
                                            <div class="lf" style="width:370px;"><input id="wetime" type="text" class="timer" readonly="true" title="点击右侧图标选择日期"/></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>公司名称 : </span>
                                        </td>
                                        <td>
                                            <input type="text" id="comname"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>行业名称 : </span>
                                        </td>
                                        <td>
                                            <input type="text" id="professname"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span class="red">* </span><span>公司规模 : </span>
                                        </td>
                                        <td>
                                            <select id="comscale">
                                                <option value="1">1-49人</option>
                                                <option value="2">50-99人</option>
                                                <option value="3">100-499人</option>
                                                <option value="4">500-999人</option>
                                                <option value="5">1000-2000人</option>
                                                <option value="6">2000-5000人</option>
                                                <option value="7">5000-10000人</option>
                                                <option value="8">10000人以上</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span class="red">* </span><span>公司性质 : </span>
                                        </td>
                                        <td>
                                            <select id="comchar">
                                                <option value="1">国有企业</option>
                                                <option value="2">集体企业</option>
                                                <option value="3">联营企业</option>
                                                <option value="4">股份合作制企业</option>
                                                <option value="5">私营企业</option>
                                                <option value="6">个体户</option>
                                                <option value="7">合伙企业</option>
                                                <option value="8">有限责任公司</option>
                                                <option value="9">股份有限公司</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>部门 :</span>
                                        </td>
                                        <td>
                                            <input type="text" value="" id="job_depart" name="com_depart"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>职位 :</span>
                                        </td>
                                        <td>
                                            <input type="text" value="" id="job_hold"  name="jo_pos"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span class="red">* </span><span>工作描述 : </span>
                                        </td>
                                        <td>
                                            <textarea cols="" rows="" id="work_des"></textarea>
                                        </td>
                                    </tr>
                                </table>
                                <div class="addbtn">
                                    <a href="javascript:;" id="wsave" type="1">保存</a> | <a href="javascript:;" id="wsaveadd" type="2">保存并添加更多工作经历</a>
                                </div>
                                <p class="title">工程业绩</p>
                                <div id="project_cont"></div>
                                <table class="tb" id="projects">
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>起止时间 : </span>
                                        </td>
                                        <td class="tcont">
                                            <div class="lf"><input id="pstime" type="text" class="timer" readonly="true" title="点击右侧图标选择日期"/></div>
                                            <div class="lf mlf">至</div>
                                            <div class="lf"><input id="petime" type="text" class="timer" readonly="true" title="点击右侧图标选择日期"/></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>项目名称 : </span>
                                        </td>
                                        <td>
                                            <input type="text" id="proname"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>规模大小 : </span>
                                        </td>
                                        <td>
                                            <select id="proscale">
                                                <option value="1">&nbsp;&nbsp;0～100万</option>
                                                <option value="2">100～300万</option>
                                                <option value="3">300～500万</option>
                                                <option value="4">500～800万</option>
                                                <option value="5">800～1000万</option>
                                                <option value="6">1000～2000万</option>
                                                <option value="7">2000～5000万</option>
                                                <option value="8">5000万以上</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span class="red">* </span><span>担任职位 : </span>
                                        </td>
                                        <td>
                                            <input type="text" id="proheld"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span class="red">* </span><span>工作内容 : </span>
                                        </td>
                                        <td>
                                            <textarea cols="" rows="" id="workcontent"></textarea>
                                        </td>
                                    </tr>
                                </table>
                                <div class="addbtn">
                                    <a href="javascript:;" id="psave" type="1">保存</a> | <a href="javascript:;" id="psaveadd" type="2">保存并添加更多工程业绩</a>
                                </div>
                            </div>
                            <div class="pb_op hidden">
                                <h2 class="p_info">
                                    可选操作 : &nbsp;&nbsp;&nbsp;<span class="gray">(友情提醒: 以上填写信息为全职简历,兼职简历可在右上角点击进入创建)</span>
                                </h2>
                                <div class="pb_s lf">
                                    <div class="btn_common btn5 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="pubresnow">立即公开求职</a>
                                    </div>
                                </div>
                                <div class="me_or red lf">
                                    or
                                </div>
                                <div class="pb_a lf">
                                    <div class="btn_common btn8 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="savebtn">保存,暂不求职</a>
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