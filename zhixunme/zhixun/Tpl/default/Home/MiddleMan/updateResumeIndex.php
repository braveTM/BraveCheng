<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>人才全职简历修改 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bagent_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/slt-hgs/slt-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/jquery-datepicker/jquery.ui.datepicker.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">75</script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 tmanage fresalter">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::{$nav}::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li"><a href="javascript:;">全职简历修改</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">简历管理</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item addtalents addfres show">                            
                                <if condition="$resume.resume_status neq 3">
                                    <div class="pr_num" id="pr_num">
                                    <span class="red">当前简历已公开，若要修改该简历，请先结束求职</span>
                                    </div>
                                </if>
<!--                                <div class="pro_bg">
                                    <span class="p_name">简历_{$resume.resume_id}</span>
                                </div>-->                            
                            <div class="step step1 updatedata">
                                <if condition="$resume.resume_status eq 3">
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
                                            <input readonly="true" type="text" id="uname" value="{$human.name}"/>
                                        </td>
                                        <td class="ltd">
                                            <span>性别 : </span>
                                        </td>
                                        <td>
                                    <if condition="$human.gender eq 1">
                                        <span class="txtinfo" val="1">男</span>
                                        <else/>
                                        <span class="txtinfo" val="0">女</span>
                                    </if>
                                    <input type="radio" name="sex" value="1" checked/><span class="txthid">男</span>
                                    <input type="radio" name="sex" value="0"/><span class="txthid">女</span>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>生日 : </span>
                                        </td>
                                        <td style="position:relative">
                                            <input id="date" type="text" value="{$human.birth}" readonly="true"/>
                                        </td>
                                        <td class="ltd">
                                            <span class="red">* </span><span>工作年限 : </span>
                                        </td>
                                        <td>
                                            <span class="txtinfo" val="{$human.exp[0]}"> {$human.exp[1]}</span>
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
                                            <input class="mselect" type="text" id="place" pid="{$human.province}" cid="{$human.city}" value="{$human.addr}" readonly/>
                                        </td>
                                        <td class="ltd">
                                            <span class="red">* </span><span>手机 : </span>
                                        </td>
                                        <td>
                                            <input readonly="true" type="text" id="phone" value="{$human.phone}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>Email : </span>
                                        </td>
                                        <td>
                                            <input readonly="true" type="text" id="uemail" value="{$human.email}"/>
                                        </td>
                                        <td class="ltd">
                                            <span>QQ : </span>
                                        </td>
                                        <td>
                                            <input readonly="true" type="text" id="uqq" value="{$human.qq}"/>
                                        </td>
                                    </tr>
                                </table>
                                <div class="nextone">
                                    <div class="btn_common btn4">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="onenext" hid="{$human.id}">保存</a>
                                    </div>
                                </div>
                                <p class="clr"></p>
                            </div>
                            <div class="step step2 updatedata">
                                <if condition="$resume.resume_status eq 3">
                                <a href="javascript:;" class="blue alertitem">修改</a>
                                <else/>
                                <a href="javascript:;" class="blue alertitem" style="display:none;">修改</a>
                                </if>
                                <p class="title">求职岗位 <span class="red">[必填]</span></p>
                                <table class="tb">
                                    <tr class="lst_tr">
                                        <td class="ltd">
                                            <span class="red">* </span><span>职位名称 : </span>
                                        </td>
                                        <td class="fpos">
                                            <div class="slt_pos slt_pos_old" id="slt_pos_old" cids="" pids="" names=""></div>
                                            <a href="javascript:;" id="qposition" cids="{$intent['ids']}" pids="{$intent['pids']}" names="{$intent['names']}" class="qposition blue">选择职位</a><span class="red hidden" id="jtip">职位选择不能为空!</span>
                                            <div class="slt_pos slt_pos_edit" id="slt_pos">
                                                <foreach name="intent['array']" item="it">
                                                    <a href="javascript:;" cid="{$it['id']}" pid="{$it['pid']}">{$it['name']}</a>
                                                </foreach>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>期望工作地点 : </span>
                                        </td>
                                        <td>
                                            <input class="mselect sm_input" type="text" id="explace" readonly="true" pid="{$resume.job_intent.job_province_code}" cid="{$resume.job_intent.job_city_code}" value="{$resume.job_intent.job_province} - {$resume.job_intent.job_city}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>期望待遇 : </span>
                                        </td>
                                        <td>
                                            <span class="txtinfo" val="{$resume.job_intent.job_salary[0]}">{$resume.job_intent.job_salary[1]}</span>
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
                                        <switch name="resume.job_intent.job_salary[1]">                                        
                                        <case value="面议"></case>                                                               
                                        <default  /><span>万/年</span> 
                                        </switch>
<!--                                            <input readonly="true" type="text" class="pay" id="expay" value="{$resume.job_intent.job_salary}"/> <span>万/年</span>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span>职位描述 : </span>
                                        </td>
                                        <td>
                                            <textarea cols="" rows="" id="pos_des" readonly>{$resume.job_intent.job_describle}</textarea>
                                        </td>
                                    </tr>
                                </table>
                                <div class="nextone">
                                    <div class="btn_common btn4">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="savepos" hid="{$human.id}" intid="{$resume.job_intent.job_intent_id}">保存</a>
                                    </div>
                                </div>
                                <p class="clr"></p>
                            </div>
                            <div class="step step3 updatedata">
                                <if condition="$resume.resume_status eq 3">
                                <a href="javascript:;" class="blue alertitem">修改</a>
                                <else/>
                                <a href="javascript:;" class="blue alertitem" style="display:none;">修改</a>
                                </if>
                                <p class="title">学历 <span class="red">[必填]</span></p>
                                <table class="tb">
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>时间 : </span>
                                        </td>
                                        <td class="tcont">
                                            <div class="lf"><input id="stime" type="text" class="timer" readonly value="{$resume.degree.study_startdate}"/></div>
                                            <div class="lf mlf">至</div>
                                            <div class="lf" style="width:370px;"><input id="etime" type="text" class="timer" readonly  value="{$resume.degree.study_enddate}"/></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>学校名称 : </span>
                                        </td>
                                        <td>
                                            <input readonly="true" type="text" id="mscname" value="{$resume.degree.school}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="red">* </span><span>专业名称 : </span>
                                        </td>
                                        <td>
                                            <input readonly="true" type="text" id="mmajname" value="{$resume.degree.major_name}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span>学历 : </span>
                                        </td>
                                        <td>
                                            <span class="txtinfo tinfo_a" val="{$resume.degree.degree_name[0]}">{$resume.degree.degree_name[1]}</span>
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
                                <div class="nextone">
                                    <div class="btn_common btn4">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="savedegree" hid="{$human.id}" intid="{$resume.degree.degree_id}">保存</a>
                                    </div>
                                </div>
                                <p class="clr"></p>
                            </div>
                            <div class="step step4 updatedata">
                                <if condition="$resume.resume_status eq 3">
                                <a href="javascript:;" class="blue alertitem" id="qalertitem">修改</a>
                                <else/>
                                <a href="javascript:;" class="blue alertitem" id="qalertitem" style="display:none;">修改</a>
                                </if>
                                <p class="title">证书情况</p>
                                <table class="tb">
                                    <tr class="qualcont">
                                        <td class="ltd qtd">
                                            <span>资质证书 : </span>
                                        </td>
                                        <td id="myquals">
                                    <foreach name="resume.register_certificate_list" item="qual">
                                        <div class="qualitem"><span>{$qual.register_certificate_name} - <if condition="$qual.register_certificate_major neq ''">{$qual.register_certificate_major} - </if>{$qual.register_case} - {$qual.register_place}</span><a href="javascript:;" class="addqual rf">添加</a><a href="javascript:;" class="delqual rf" cid="{$qual.certificate_id}" hid="{$human.id}">删除</a></div>
                                    </foreach>
                                    <if condition="$resume.register_certificate_list eq null">
                                        <div class="qualitem noqual"><span>暂无</span><a href="javascript:;" class="addqual rf">添加</a></div>
                                    </if>
                                    <input class="mselect qual_select" id="tqual" type="text" style="display:none" readonly/><a href="javascript:;" id="savequal" class="blue" cid="{$qual.certificate_id}" hid="{$human.id}">保存</a><a href="javascript:;" id="cancelqual" class="blue">取消</a>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span>职称证 : </span>
                                        </td>
                                        <td>
                                            <input class="mselect" type="text" readonly id="tjtitle" value="{$resume.grade_certificate.grade_certificate_class_name} - {$resume.grade_certificate.grade_certificate_major}" cid="{$resume.grade_certificate.grade_certificate_id}" gra="{$resume.grade_certificate.grade_certificate_class}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lst_td">
                                            <span>补充说明 : </span>
                                        </td>
                                        <td>
                                            <textarea cols="" rows="" id="add_des" readonly>{$resume.certificate_remark}</textarea>
                                        </td>
                                    </tr>
                                </table>
                                <div class="nextone">
                                    <div class="btn_common btn4">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="btnsavequal" hid="{$human.id}" certid="{$resume.grade_certificate.certificate_id}">保存</a>
                                    </div>
                                </div>
                                <p class="clr"></p>
                            </div>
                            <div class="step step5">
                                <if condition="$resume.resume_status eq 3">
                                <a href="javascript:;" class="blue additem">添加</a>
                                <else/>
                                <a href="javascript:;" class="blue additem" style="display:none;">添加</a>
                                </if>
                                <p class="title">工作经历</p>
                                <div class="addwexp">
                                    <div class="additems">
                                        <table class="tb" id="workexp">
                                            <tr>
                                                <td class="ltd">
                                                    <span class="red">* </span><span>任职时间 : </span>
                                                </td>
                                                <td class="tcont">
                                                    <div class="lf"><input id="wstime" type="text" class="timer" readonly="true"/></div>
                                                    <div class="lf mlf">至</div>
                                                    <div class="lf" style="width:370px;"><input id="wetime" type="text" class="timer" readonly="true"/></div>
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
                                        <div class="nextone">
                                            <div class="btn_common btn4">
                                                <span class="b_lf"></span>
                                                <span class="b_rf"></span>
                                                <a href="javascript:;" class="btn white" id="wsaveadd" type="2" hid="{$human.id}" rid="{$resume.resume_id}">添加</a>
                                            </div>
                                        </div>
                                        <p class="clr"></p>
                                    </div>
                                </div>
                                <foreach name="resume.work_exp_list" item="exp">
                                    <div class="title">
                                        <a href="javascript:;" class="blue sldown">展开</a>
                                        <if condition="$resume.resume_status eq 3">
                                        <a href="javascript:;" class="blue alters">修改</a>
                                        <else/>
                                        <a href="javascript:;" class="blue alters" style="display:none;">修改</a>
                                        </if>
                                        <if condition="$resume.resume_status eq 3">
                                        <a href="javascript:;" class="blue deles" title="删除工程经历{:plus1($key)}">删除</a>
                                        <else/>
                                        <a href="javascript:;" class="blue deles" title="删除工程经历{:plus1($key)}" style="display:none;">删除</a>
                                        </if>
                                        工作经历 {:plus1($key)}<span class="gray"> ({$exp.work_startdate} - {$exp.work_enddate}) </span> :
                                    </div>
                                    <div class="wpitem" wxid="{$exp.work_exp_id}">
                                        <div class="detinfo">
                                            <div class="item">
                                                <p class="gray">任职时间 :</p>
                                                <p class="detail"><span class="wstime">{$exp.work_startdate}</span> 至 <span class="wetime">{$exp.work_enddate}</span></p>
                                            </div>
                                            <div class="item">
                                                <p class="gray">公司名称 :</p>
                                                <p class="detail sdet comname">{$exp.company_name}</p>
                                                <p class="gray">行业名称 :</p>
                                                <p class="detail sdet professname">{$exp.company_industry}</p>
                                            </div>
                                            <div class="item">
                                                <p class="gray">公司规模 :</p>
                                                <p class="detail sdet comscale" val="{$exp.company_scale[0]}">{$exp.company_scale[1]}</p>
                                                <p class="gray">公司性质 :</p>
                                                <p class="detail sdet comchar" val="{$exp.company_property[0]}">{$exp.company_property[1]}</p>
                                            </div>
                                            <div class="item">
                                                <p class="gray">部门 :</p>
                                                <p class="detail sdet job_depart">{$exp.department}</p>
                                                <p class="gray">职位 :</p>
                                                <p class="detail sdet job_hold">{$exp.job_name}</p>
                                            </div>
                                            <div class="item">
                                                <p class="gray">工作描述 :</p>
                                                <p class="detail work_des">{$exp.job_describle}</p>
                                                <div class="clr"></div>
                                            </div>
                                        </div>
                                    </div>
                                </foreach>
                            </div>
                            <div class="step step6">
                                <if condition="$resume.resume_status eq 3">
                                <a href="javascript:;" class="blue additem">添加</a>
                                <else/>
                                <a href="javascript:;" class="blue additem" style="display:none;">添加</a>
                                </if>
                                <p class="title">工程业绩</p>
                                <div class="addwexp">
                                    <div class="additems">
                                        <table class="tb" id="projects">
                                            <tr>
                                                <td class="ltd">
                                                    <span class="red">* </span><span>起止时间 : </span>
                                                </td>
                                                <td class="tcont">
                                                    <div class="lf"><input id="pstime" type="text" class="timer" readonly="true" title="点击右侧图标选择日期"/></div>
                                                    <div class="lf mlf">至</div>
                                                    <div class="lf" style="width:370px;"><input id="petime" type="text" class="timer" readonly="true" title="点击右侧图标选择日期"/></div>
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
                                        <div class="nextone">
                                            <div class="btn_common btn4">
                                                <span class="b_lf"></span>
                                                <span class="b_rf"></span>
                                                <a href="javascript:;" class="btn white" id="psaveadd" type="2" hid="{$human.id}" rid="{$resume.resume_id}">添加</a>
                                            </div>
                                        </div>
                                        <p class="clr"></p>
                                    </div>
                                </div>
                                <foreach name="resume.project_achievement_list" item="gra">
                                    <div class="title">
                                        <a href="javascript:;" class="blue sldown">展开</a>
                                        <if condition="$resume.resume_status eq 3">
                                        <a href="javascript:;" class="blue alters">修改</a>
                                        <else/>
                                        <a href="javascript:;" class="blue alters" style="display:none;">修改</a>
                                        </if>
                                        <if condition="$resume.resume_status eq 3">
                                        <a href="javascript:;" class="blue deles" title="删除工程业绩{:plus1($key)}">删除</a>
                                        <else/>
                                        <a href="javascript:;" class="blue deles" title="删除工程业绩{:plus1($key)}" style="display:none;">删除</a>
                                        </if>
                                        工程业绩 {:plus1($key)}<span class="gray"> ({$gra.start_date} - {$gra.end_date}) </span> :
                                    </div>
                                    <div class="wpitem" gid="{$gra.project_achievement_id}">
                                        <div class="detinfo">
                                            <div class="item">
                                                <p class="gray">起止时间 :</p>
                                                <p class="detail sdet"><span class="pstime">{$gra.start_date}</span> 至 <span class="petime">{$gra.end_date}</span></p>
                                                <p class="gray">规模大小 :</p>
                                                <p class="detail sdet proscale" val="{$gra.scale[0]}">{$gra.scale[1]}</p>
                                            </div>
                                            <div class="item">
                                                <p class="gray">项目名称 :</p>
                                                <p class="detail sdet proname">{$gra.name}</p>
                                                <p class="gray">担任职位 :</p>
                                                <p class="detail sdet proheld">{$gra.job_name}</p>
                                            </div>
                                            <div class="item">
                                                <p class="gray">工作内容 :</p>
                                                <p class="detail workcontent">{$gra.job_describle}</p>
                                                <div class="clr"></div>
                                            </div>
                                        </div>
                                    </div>
                                </foreach>
                            </div>
                            <div class="pb_op">
                                <h2 class="p_info">
                                    <span class="gray">您还可以选择的操作:</span>
                                </h2>
                                <div class="pb_s lf">
                                    <div class="btn_common btn5 btn_l">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <if condition="$resume.resume_status eq 3">
                                            <a href="javascript:;" class="btn white" id="pubresnow" rid="{$resume.resume_id}">立即公开求职</a>
                                            <else/>
                                            <a href="javascript:;" class="btn white" id="pubresnow" rid="{$resume.resume_id}">立即结束求职</a>
                                        </if>
                                    </div>
                                </div>
                                <input type="hidden" id="showalert" value="{$resume.resume_status}"/>
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
