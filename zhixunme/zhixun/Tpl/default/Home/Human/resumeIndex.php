<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>简历管理 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/btalent_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/slt-hgs/slt-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/jquery-datepicker/jquery.ui.datepicker.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">56</script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 tpro mycert">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:tnav::0 -->
                </div>
            </div>
            <div class="layout1_r acc_opion">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li><a href="javascript:;">我的兼职简历</a></li>
                            <li><a href="javascript:;">我的全职简历</a></li>
                            <li><a href="javascript:;">我的全职求职意向</a></li>
                            <li><a href="javascript:;">我的证书</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">简历管理</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item hidden">
                            <!--绑定猎头-->
                            <if condition="$HC_resume.job_category eq 2 &&$HC_resume.resume_status gt 2">
                                 <div class="del_agent">
                                    <h2 class="p_top">代理猎头</h2>
                                    <ul class="mlist" id="dgate_agent">
                                        <li>
                                            <div class="lf photo">
                                                <a href="{$web_root}/{$agent.user_id}" title="{$agent.name}">
                                                    <img src="{$agent.photo}" class="psmall" alt="{$agent.name}">
                                                </a>
                                          <div class="identify">
                                           <switch name="agent.real_auth">
                                            <case value="0">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                                            </case>
                                        </switch> 
                                        <switch name="agent.phone_auth">
                                            <case value="0">                                        
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                                            </case>
                                        </switch> 
                                        <switch name="agent.email_auth">
                                            <case value="0">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>                                        
                                            </case>
                                        </switch>                                                                                                           
                                                     <div class="clr"></div>
                                                </div>
                                            </div>
                                            <div class="lf info">
                                                <p>
                                                    <a href="{$web_root}/{$agent.user_id}" class="blue comname">{$agent.name}</a>
                                                    <span class="mg_con"></span>
                                                </p>
                                                <div class="detail">
                                                    <p class="gray">简介:</p>
                                                     <p class="des">{$agent.summary}</p>
                                                </div>
                                                <div class="clr"></div>
                                                <p>
                                                    <span class="gray">服务:</span>
                                                    <span>{$agent.service}</span>
                                                </p>
                                                <p>
                                                    <span class="gray">地区: </span>
                                                    <span>{$agent.location}</span>
<!--                                                    <span class="gray s_mf">活跃度:</span>
                                                    <span></span>-->
                                                </p>
                                                                                              
                                                <p class="red">注: 猎头未公开您的简历时,点击蓝色锁即可解除绑定。简历解锁后,可修改或委托其他猎头代理。</p>
                                            </div>
                                            <div class="lf oper">
                                                <div>
                                                    <a href="javascript:;" class="red lock_pic"></a>
                                                </div>
                                            </div>
                                            <div class="clr"></div>
                                        </li>
                                    </ul>
                                </div>
                            </if>
                            <!--个人信息(兼职)-->
                            <div id="part_bpin" class="rcom part_bpin updatedata">
                                <h2 class="p_info">
                                    个人信息
                                </h2>
                                <table class="tb_in tb_com" cellpadding="0" cleespacing="0">
                                    <tr>
                                        <td class="tl">
                                            <span><b class="red">*</b>姓名 :</span>
                                        </td> 
                                        <td>
                                            <div><input type="text" value="{$HC_resume.human.name}" readonly id="p_tname" readonly /></div>
                                        </td> 
                                        <td class="tl">
                                            <span><b class="red">*</b>性别 :</span>
                                        </td> 
                                        <td>
                                            <span class="txtinfo" val="{$HC_resume.human.gender}"></span>
                                            <label for="p_sex1">
                                                <input type="radio" id="p_sex1" name="sex" value="1" checked="" class="hidden"/><span class="txthid hidden ">男</span>
                                            </label>
                                            <label for="p_sex2">
                                                <input type="radio" id="p_sex2" name="sex" value="0" checked="checked" class="hidden"/><span class="txthid hidden">女</span>
                                            </label>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td class="tl">
                                            生日 :
                                        </td> 
                                        <td>
                                            <div style="position:relative">
                                                <input type="text" readonly id="p_date" value="{$HC_resume.human.birth}"/>
                                            </div>
                                        </td> 
                                        <td class="tl">
                                           <span><b class="red">*</b>所在地 :</span>
                                        </td> 
                                        <td>
                                            <input type="hidden" name="pat_prov" value="{$HC_resume.human.province}"/>
                                            <input type="hidden" name="pat_city" value="{$HC_resume.human.city}"/>
                                            <div><input type="text" id="p_befrm" class="mselect t_place" readonly value="{$HC_resume.human.addr}"/></div>
                                        </td>
                                    </tr>
                                     <tr>
                                         <td class="tl"><span><b class="red">*</b>手机 :</span></td> 
                                        <td>
                                            <if condition="$info.phone_auth eq '1'">
                                            <div><input type="text" id="p_phone" readonly class="phone"  value="{$HC_resume.human.phone}" />
                                            <else /> <div><input type="text" id="p_phone" readonly class="n_phone"  value="{$HC_resume.human.phone}" />
                                            </if>
</div>                                      </div>
                                        </td> 
                                        <td class="tl"><span>QQ :</span></td> 
                                        <td>
                                            <div><input type="text" id="p_qq" readonly value="{$HC_resume.human.qq}" /></div>
                                        </td>
                                    </tr>
                                     <tr>
                                         <td class="tl"><span><b class="red">*</b>Email :</span></td> 
                                        <td>
                                             <if condition="$info.email_auth eq '1'">
                                            <div><input type="text" class="email" value="{$HC_resume.human.email}" readonly id="p_email"/>
                                            <else /><div><input type="text" class="n_email" value="{$HC_resume.human.email}" readonly id="p_email"/>
                                           </if>
                                            </div>
                                        </td> 
                                        <td class="tl">
                                            <span><b class="red">*</b>工作年限 :</span>
                                        </td> 
                                        <td>
                                            <span class="pt_com" val="{$HC_resume.human.exp[0]}">{$HC_resume.human.exp[1]}</span>
                                            <select id="p_msel" class="hidden">
                                                <option value="1">无</option>
                                                <option value="2">1年以上</option>
                                                <option value="3">3年以上</option>
                                                <option value="4">5年以上</option>
                                                <option value="5">8年以上</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <div class="p_img lf">
                                   <img class="psmall" src="{$HC_resume.human.photo}" alt="用户名称"/>
                                </div>
                                <div class="clr"></div>
                            </div>
                            <div class="sv_info up_info" id="sv_info">
                                <a href="javascript:;" title="修改" class="blue base_edit" id="pt_up">修改</a>
                                <span class="gray">修改信息将与帐户资料同步</span>
                            </div>
                            <!--保存个人资料-->
                            <div class="sv_pro s_btn hidden" id="sv_pro">
                                <div class="btn_common btn4 s_n">
                                    <span class="b_lf"></span>
                                    <span class="b_rf"></span>
                                    <a class="btn white sv_mtn" id="sv_ptinfo" href="javascript:;">保存</a>
                                </div>
                            </div>
                            <!--证书情况(兼职)-->
                            <div class="part_quali" id="pt_quali">
                                 <h2 class="p_info">
                                    证书情况
                                </h2>
                                <div class="had_qua">
                                <if condition="$HC_resume.register_certificate_list neq 0">
                                 <foreach name="HC_resume.register_certificate_list" item="cert">
                                     <div class="qua_list">
                                         <span class="tl"><b class="red">*</b>资质证书 :</span><span class="cer_name">{$cert.register_certificate_name}
                                        <php>
                                            if(!empty($cert->register_certificate_major)){
                                                echo '- '.$cert->register_certificate_major;
                                            }
                                        </php> 
                                        - {$cert.register_case} - {$cert.register_place}</span>
                                        <a href="javascript:;" title="删除" rel="{$cert.certificate_id}" class="blue d_cert">删除</a>
                                     </div>
                                    </foreach>
                                    <else /><div class="qua_list"><span class="tl">资质证书 :</span><a href="javascript:;" title="添加" class="blue adn_qa">添加</a></div>
                                </if>
                                </div>
                                <table class="tb_cert">
                                   <tr class="first hidden">
                                       <td class="ltd">
                                            <span><b class="red">*</b>资质证书 :</span>
                                        </td>
                                        <td>
                                            <input type="text" readonly value="" id="qqual_select" class="qual_select mselect" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd"><span>职称证 :</span></td>
                                        <td>
                                           <if condition="$HC_resume.grade_certificate neq ''">
                                               <input type="text" readonly  id="p_cert" class="mselect hidden" value="{$HC_resume.grade_certificate.grade_certificate_class_name} - {$HC_resume.grade_certificate.grade_certificate_type} - {$HC_resume.grade_certificate.grade_certificate_major}"/>
                                               <else /><input type="text" readonly  id="p_cert" class="mselect hidden" value=""/>
                                           </if>
                                           <input type="hidden" name="certid" value="{$HC_resume.grade_certificate.certificate_id}"/>
                                           <input type="hidden" name="jtlid" value="{$HC_resume.grade_certificate.grade_certificate_class}" />
                                           <input type="hidden" name="jtid" value="{$HC_resume.grade_certificate.grade_certificate_id}" />
                                           <if condition="$HC_resume.grade_certificate neq ''">
                                                <span class="hd_com" id="r_cert">
                                                    {$HC_resume.grade_certificate.grade_certificate_class_name} - {$HC_resume.grade_certificate.grade_certificate_type} - {$HC_resume.grade_certificate.grade_certificate_major}
                                                </span>
                                               <else /><span class="hd_com" id="r_cert"></span>
                                           </if>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd"> 
                                             <span><b class="red">*</b>期望待遇 :</span>
                                        </td>
                                        <td>                                            
                                            <span class="hd_com expal" val="{$HC_resume.job_salary[0]}" id="p_sa">{$HC_resume.job_salary[1]}</span>                                            
                                            <switch name="HC_resume.job_salary[1]" >                                        
                                            <case value="面议"></case>                                                               
                                                <default  /><span class="hd_com">万/年</span>
                                            </switch>                                                                                        
                                              <select id="job_salary" class="hidden" rel="pjob">
                                                <option value="0">面议</option>
                                                <option value="7">0 ～ 1</option>
                                                <option value="8">1 ～ 2</option>
                                                <option value="9">2 ～ 3</option>
                                                <option value="10">3 ～ 4</option>
                                                <option value="11">4 ～ 5</option>                                                
                                                <option value="2">5 ～ 10</option>
                                                <option value="3">10 ～ 20</option>
                                                <option value="4">20 ～ 40</option>
                                                <option value="5">40 ～ 99</option>
                                                <option value="6">100 +</option>
                                                <option value="12">手动填写</option>
                                              </select>
                                              <input value="" id="defpay" class="defpay hidden" type="text" />
                                        <span class="hidden ut">万/年</span>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td class="ltd">
                                            <span><b class="red">*</b>期望注册地 :</span>
                                        </td>
                                        <td>
                                            <input type="hidden" value="{$HC_resume.register_province_ids}" name="resum_pro"/>
                                             <input type="text" id="p_area" class="hidden  mselect" value="{$HC_resume.register_provinces}" readonly />
                                             <span class="hd_com" id="r_prov">{$HC_resume.register_provinces}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd lop"><span>补充说明 :</span></td>
                                        <td>
                                            <textarea id="p_cmp" class="hidden" cols="" rows="">{$HC_resume.certificate_remark}</textarea>
                                            <span class="hd_com" id="expec_in">{$HC_resume.certificate_remark}</span>
                                        </td>
                                    </tr>
                                </table>
                                <div class="up_info sv_ptqa">
                                       <a href="javascript:;" title="修改" class="blue" id="pt_qa">修改</a>
                                </div>
                                <div class="s_btn hidden" id="sv_ptcert">
                                    <div class="btn_common btn4 s_n">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a class="btn white sv_mtn" id="sv_cert" href="javascript:;">保存</a>
                                    </div>
                                </div>
                           </div>
                         <div class="clr"></div>
                         <input type="hidden" value="{$HC_resume.job_category}" name="job_cat"/>
                         <input type="hidden" value="{$HC_resume.resume_status}" name="job_sta"/>
                         <if condition="$HC_resume.job_category eq 0">
                                  <div class="pb_op" id="part_pub">
                                    <h2 class="p_info">
                                        请选择发布方式 :<span class="gray"> （您只能选择公开或委托兼职、全职简历之一）</span>
                                    </h2>
                                    <div class="pb_s lf">
                                        <div class="btn_common btn5">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;"class="btn white" id="pub_presu">公开求职</a>
                                        </div>
                                    </div>
                                    <div class="me_or red lf">
                                            or
                                    </div>
                                    <div class="pb_a lf">
                                        <div class="btn_common btn8">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" class="btn white" id="cho_presu">猎头代理</a>
                                        </div>
                                    </div>
                                    <div class="clr"></div>
                                    <div class="t_l pat_tp">
                                        <div class="l_tip lf">
                                            <p class="red">您的简历将被精准推送至</p>
                                            <p class="red">有相应需求的企业、猎头首页</p>
                                            <p class="red">您也可以自主投递简历到喜欢的职位</p>
                                        </div>
                                        <div class="r_tip rf">
                                            <p class="red">如果您没有时间,可以委托猎头代理</p>
                                            <p class="red">猎头将根据您的具体需求</p>
                                            <p class="red">为您筛选、推荐最合适的职位</p>
                                        </div>
                                    </div>
                                </div>
                             <elseif condition="$HC_resume.job_category eq 1 && $HC_resume.resume_status eq 2 "/>
                                  <div class="pb_op" id="part_pub">
                                        <h2 class="p_info">
                                           请选择发布方式:<span class="red"> （您已公开全职简历,您可以选择暂停全职求职后,再公开兼职简历）</span>
                                        </h2>
                                        <div class="pb_s lf">
                                            <div class="btn_common btn7">
                                                <span class="b_lf"></span>
                                                <span class="b_rf"></span>
                                                <a href="javascript:;"class="btn white" id="pub_presu">公开求职</a>
                                            </div>
                                        </div>
                                        <div class="me_or red lf">
                                                or
                                        </div>
                                        <div class="pb_a lf">
                                            <div class="btn_common btn7">
                                                <span class="b_lf"></span>
                                                <span class="b_rf"></span>
                                                <a href="javascript:;" class="btn white" id="cho_presu">猎头代理</a>
                                            </div>
                                        </div>
                                  </div>
                             <elseif condition="$HC_resume.job_category eq 2 && $HC_resume.resume_status eq 2"/>
                                  <div class="pb_op" id="part_pub">
                                        <h2 class="p_info">
                                            请选择发布方式:<span class="red"> （暂停求职后，您兼职简历将暂不能推送、投递）</span>
                                        </h2>
                                        <div class="pb_s lf">
                                            <div class="btn_common btn5">
                                                <span class="b_lf"></span>
                                                <span class="b_rf"></span>
                                                <a href="javascript:;"class="btn white" id="end_pub">暂停求职</a>
                                            </div>
                                        </div>
                                        <div class="me_or red lf">
                                                or
                                        </div>
                                        <div class="pb_a lf">
                                            <div class="btn_common btn7">
                                                <span class="b_lf"></span>
                                                <span class="b_rf"></span>
                                                <a href="javascript:;" class="btn white" id="cho_presu">猎头代理</a>
                                            </div>
                                        </div>
                                  </div>
                            <elseif condition="$HC_resume.job_category eq 2 && $HC_resume.resume_status eq 3"/>
                         </if>
                        </div>
                        <div class="t_item hidden">
                            <!--绑定猎头-->
                            <if condition="$resume.job_category eq 1 &&$resume.resume_status gt 2">
                                 <div class="del_agent">
                                    <h2 class="p_top">代理猎头</h2>
                                    <ul class="mlist" id="dgate_agent">
                                        <li>
                                            <div class="lf photo">
                                               <a href="{$web_root}/{$agent.user_id}" title="{$agent.name}">
                                                    <img src="{$agent.photo}" class="psmall" alt="{$agent.name}">
                                                </a>
                                                <div class="identify">
                                                    
                                           <switch name="agent.real_auth">
                                            <case value="0">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                                            </case>
                                        </switch> 
                                        <switch name="agent.phone_auth">
                                            <case value="0">                                        
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                                            </case>
                                        </switch> 
                                        <switch name="agent.email_auth">
                                            <case value="0">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>                                        
                                            </case>
                                        </switch>   <div class="clr"></div>
                                                </div>
                                            </div>
                                            <div class="lf info">
                                                <p>
                                                    <a href="{$web_root}/{$agent.user_id}" class="blue comname">{$agent.name}</a>
                                                    <span class="mg_con"></span>
                                                </p>
                                                <div class="detail">
                                                    <p class="gray">简介:</p>
                                                     <p class="des">{$agent.summary}</p>
                                                </div>
                                                <div class="clr"></div>
                                                <p>
                                                    <span class="gray">服务:</span>
                                                    <span>{$agent.service}</span>
                                                </p>
                                                <p>
                                                    <span class="gray">地区: </span>
                                                    <span>{$agent.location}</span>
<!--                                                    <span class="gray s_mf">活跃度:</span>
                                                    <span></span>-->
                                                </p>
                                                    <p>
                                                        <span class="gray">所属公司:</span>
                                                        <span>{$agent.company}</span>
                                                    </p>
                                                <p class="red">注: 猎头未公开您的简历时,点击蓝色锁即可解除绑定。简历解锁后,可修改或委托其他猎头代理。</p>
                                            </div>
                                            <div class="lf oper">
                                                <div>
                                                    <a href="javascript:;" class="red lock_pic"></a>
                                                </div>
                                            </div>
                                            <div class="clr"></div>
                                        </li>
                                    </ul>
                                </div>
                            </if>
                            <!--个人信息(全职)-->
                            <div class="bp_inf updatedata rcom" id="ful_pinfo">
                                <h2 class="p_info">
                                    个人信息
                                </h2>
                                <table class="tb_in tb_com">
                                    <tr>
                                        <td class="tl">
                                            <span><b class="red">*</b>姓名 :</span>
                                        </td>
                                        <td>
                                            <div><input id="q_tname" type="text" readonly value="{$resume.human.name}" /></div>
                                        </td> 
                                        <td class="tl">
                                            <span><b class="red">*</b>性别 :</span>
                                        </td>
                                        <td>
                                            <span class="txtinfo" val="{$resume.human.gender}"></span>
                                            <label for="sexops">
                                                <input type="radio" id="sexops" name="p_sex" value="1" checked="" class="hidden"/><span class="txthid hidden ">男</span>
                                            </label>
                                            <label for="sops">
                                                <input type="radio" id="sops" name="p_sex" value="0" checked="checked" class="hidden"/><span class="txthid hidden">女</span>
                                            </label>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td class="tl"><span>生日 :</span></td>
                                        <td>
                                            <div style="position:relative">
                                                <input type="text" value="{$resume.human.birth}" readonly  id="q_bth"/>
                                            </div>
                                        </td> 
                                        <td class="tl">
                                            <span><b class="red">*</b>居住地 :</span>
                                        </td>
                                        <td>
                                            <input type="hidden" name="q_pro" value="{$resume.human.province}" />
                                            <input type="hidden" name="q_city" value="{$resume.human.city}"/>
                                            <div><input type="text" value="{$resume.human.addr}" id="q_bf" class="mselect t_place" readonly/></div>
                                        </td>
                                    </tr>
                                     <tr>
                                         <td class="tl"><span><b class="red">*</b>手机 :</span></td>
                                        <td>   
                                            <if condition="$info.phone_auth eq '1'">
                                            <div><input type="text" id="q_phone"readonly value="{$resume.human.phone}" class="phone" />
                                            <else /><div><input type="text" id="q_phone"readonly value="{$resume.human.phone}" class="n_phone" />
                                            </if>
                                            </div>
                                        </td>
                                        <td class="tl"><span>QQ :</span></td>
                                        <td>
                                            <div><input type="text" id="q_pq" readonly value="{$resume.human.qq}" /></div>                                            
                                        </td>
                                    </tr>
                                      <tr>
                                          <td class="tl"><span><b class="red">*</b>Email :</span></td>
                                        <td>
                                             <if condition="$info.email_auth eq '1'">
                                             <div><input type="text" value="{$resume.human.email}" id="q_email" class="email" readonly />
                                             <else /><input type="text" value="{$resume.human.email}" id="q_email" class="n_email" readonly />
                                             </if>
                                             </div>
                                        </td> 
                                         <td class="tl">
                                            <span><b class="red">*</b>工作年限 :</span>
                                        </td>
                                        <td>
                                            <span val="{$resume.human.exp[0]}" class="pt_com">{$resume.human.exp[1]}</span>
                                            <select id="q_se" class="hidden">
                                                <option value="1">无</option>
                                                <option value="2">1年以上</option>
                                                <option value="3">3年以上</option>
                                                <option value="4">5年以上</option>
                                                <option value="5">8年以上</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <div class="p_img lf">
                                   <img class="psmall" src="{$HC_resume.human.photo}" alt="用户名称"/>
                                </div>
                                <div class="clr"></div>
                            </div>
                            <div class="up_info q_sfo">
                                <a href="javascript:;" title="修改" id="ful_edit" class="blue base_edit">修改</a>
                                <span class="gray">修改信息将与帐户资料同步</span>
                            </div>
                            <div class="q_sv s_btn hidden" id="q_sv">
                                <div class="btn_common btn4 s_n">
                                    <span class="b_lf"></span>
                                    <span class="b_rf"></span>
                                    <a class="btn white sv_mtn" id="ful_save" href="javascript:;">保存</a>
                                </div>
                            </div>
                            <div class="clr"></div>
                            <!--学历-->
                            <div class="edu" id="person_edu">
                                 <h2 class="p_info">
                                    <span class="lf">学历</span>
                                   <a href="javascript:;" title="修改" class="blue rf" id="edu_edit">修改</a>
                                </h2>
                                <div class="clr"></div>
                                 <div class="qua_detail">
                                     <table class="tb_cert degree_tb">
                                         <tr>
                                             <td class="tl">
                                                 <span><b class="red">*</b>时间 :</span>
                                             </td>
                                             <td>
                                                 <div style="position:relative;display:inline-block;">
                                                     <input type="text" readonly value="{$resume.degree.study_startdate}" id="be_time" class="hidden" />
                                                     <span id="per_bt" class="per_com">{$resume.degree.study_startdate}</span>
                                                 </div>
                                                 <if condition="$resume.degree.study_startdate neq ''">
                                                     <div style="display:inline-block;margin-left:5px">至</div>
                                                     <else /><div style="display:none;margin-left:5px" class="to">至</div>
                                                 </if>
                                                 <div style="position:relative;display: inline-block;margin-left:5px;">
                                                   <input type="text" readonly value="{$resume.degree.study_enddate}" id="end_time" class="hidden"/> 
                                                   <span id="per_end" class="per_com">{$resume.degree.study_enddate}</span>
                                                  </div>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="tl">
                                                 <span><b class="red">*</b>学校名称 :</span>
                                             </td>
                                             <td>
                                                  <input type="text" value="{$resume.degree.school}" id="q_scname"  class="hidden"/>
                                                  <span id="per_schname" class="per_com">{$resume.degree.school}</span>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="tl">
                                                  <span><b class="red">*</b>专业名称 :</span>
                                             </td>
                                             <td>
                                                 <input type="text" id="q_majoy" value="{$resume.degree.major_name}" class="hidden" />
                                                 <span id="per_profession" class="per_com">{$resume.degree.major_name}</span>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="tl">
                                                  <span><b class="red">*</b>学历 :</span>
                                             </td>
                                             <td>
                                                 <select id="q_edu" class="hidden">
                                                    <option value="1">中专</option>
                                                    <option value="2">大专</option>
                                                    <option value="3">本科</option>
                                                    <option value="4">硕士</option>
                                                    <option value="5">博士</option>
                                                </select>
                                                 <span id="per_degr" class="per_com">{$resume.degree.degree_name[1]}</span>
                                             </td>
                                         </tr>
                                     </table>
                                     <div class="s_btn hidden" id="peredu_save">
                                        <div class="btn_common btn4 s_n">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a class="btn white sv_mtn" id="edu_save" href="javascript:;">保存</a>
                                        </div>
                                    </div>
                                </div>
                           </div>
                            <!--证书情况-->
                            <div class="bp_quali" id="zert_quali">
                                 <h2 class="p_info">
                                    <span class="lf">证书情况</span>
                                    <a href="javascript:;" title="修改" class="blue rf" id="fjobct_edit">修改</a>
                                </h2>
                                 <div class="had_qua">
                                 <if condition="$resume.register_certificate_list neq 0">
                                 <foreach name="resume.register_certificate_list" item="cert">
                                     <div class="qua_list">
                                         <span class="tl"><b class="red">*</b>资质证书 :</span><span class="cer_name">{$cert.register_certificate_name}
                                            <php>
                                            if(!empty($cert->register_certificate_major)){
                                                echo '- '.$cert->register_certificate_major;
                                            }
                                        </php>
                                        - {$cert.register_case}-{$cert.register_place}</span>
                                        <a href="javascript:;" title="删除" rel="{$cert.certificate_id}" class="blue d_cert">删除</a>
                                     </div>
                                    </foreach>
                                    <else /><div class="qua_list"> <span class="tl">资质证书 :</span> <a href="javascript:;" title="添加"class="blue adn_qa">添加</a></div>
                                 </if>
                                </div>
                                 <div class="clr"></div>
                                 <div class="qua_detail">
                                     <table class="tb_cert jt_tb">
                                         <tr class="first hidden">
                                             <td class="ltd">
                                                 <span><b class="red">*</b>资质证书 :</span>
                                             </td>
                                             <td>
                                                <input type="text" value="" readonly="true" id="pqual_select" class="qual_select mselect" />
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="ltd">
                                                 <span>职称证 :</span>
                                             </td>
                                             <td>
                                                 <input type="hidden" name="q_certid" value="{$resume.grade_certificate.certificate_id}"/>
                                                 <input type="hidden" name="q_jtlid" value="{$resume.grade_certificate.grade_certificate_class}" />
                                                 <input type="hidden" name="q_jtid" value="{$resume.grade_certificate.grade_certificate_id}" />
                                                  <if condition="$resume.grade_certificate neq ''">
                                                     <input type="text" readonly value="{$resume.grade_certificate.grade_certificate_class_name} - {$resume.grade_certificate.grade_certificate_type}-{$resume.grade_certificate.grade_certificate_major}" id="q_cert" class="mselect hidden" />
                                                     <else /><input type="text" readonly value="" id="q_cert" class="mselect hidden" />
                                                  </if>
                                                 <if condition="$resume.grade_certificate neq ''">
                                                    <span id="fult_cert" class="f_com">
                                                        {$resume.grade_certificate.grade_certificate_class_name}-{$resume.grade_certificate.grade_certificate_type} - {$resume.grade_certificate.grade_certificate_major}
                                                    </span>
                                                   <else /><span id="fult_cert" class="f_com"></span>
                                                 </if>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="ltd lop">
                                                 补充说明 :
                                             </td>
                                             <td>
                                                  <textarea id="q_detail" cols="" class="hidden" rows="">{$resume.certificate_remark}</textarea>
                                                  <span id="fult_de">{$resume.certificate_remark}</span>
                                             </td>
                                         </tr>
                                     </table>
                                     <div class="s_btn hidden" id="fjob_cert">
                                        <div class="btn_common btn4 s_n">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a class="btn white sv_mtn" id="fjob_csve" href="javascript:;">保存</a>
                                        </div>
                                    </div>
                                </div>
                           </div>
                            <!--工作经历-->
                            <div class="bp_exper" id="job_exper">
                                <div class="p_info">
                                       <h2 class="lf">工作经历</h2>
                                </div>
                                <div class="clr"></div>
                                <div id="had_exper" class="had_exp">
                                    <foreach name="resume.work_exp_list" item="exper">
                                        <table class="experlis t_ce">
                                            <tr>
                                                <td class="tl"><span><b class="red">*</b>起始时间 :</span></td>
                                                <td>
                                                    {$exper.work_startdate}
                                                    至
                                                    {$exper.work_enddate}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tl"><span><b class="red">*</b>公司名称 :</span></td>
                                                <td>
                                                    {$exper.company_name}
                                                </td>
                                                 <td class="tl"><span><b class="red">*</b>行业 :</span></td>
                                                <td>
                                                    {$exper.company_industry}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tl"><span><b class="red">*</b>公司规模 : </span></td>
                                                <td>
                                                     {$exper.company_scale[1]}
                                                </td>
                                                 <td class="tl"><span><b class="red">*</b>公司性质 :</span></td>
                                                <td>
                                                    {$exper.company_property[1]}
                                                </td>
                                            </tr>
                                             <tr>
                                            <td class="tl">
                                                <span><b class="red">*</b>部门 :</span>
                                            </td>
                                            <td>
                                                 {$exper.department}
                                            </td>
                                            <td class="tl">
                                                <span><b class="red">*</b>职位 :</span>
                                            </td>
                                            <td>
                                                 {$exper.job_name}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tl lop">
                                                <span><b class="red">*</b>工作内容 :</span>
                                            </td>
                                            <td>
                                                <span class="work_detail">{$exper.job_describle}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <div class="up_info exp_deal">
                                                  <a href="javascript:;" title="" class="delexp blue" rel="{$exper.work_exp_id}">删除工作经验</a>
                                                  <a href="javascript:;" title="" class="blue adexper">添加工作经验</a>
                                               </div>
                                            </td>
                                        </tr>
                                       </table>
                                    </foreach>
                                </div>
                                <div class="qua_detail exp hidden" id="job_explist">
                                    <table class="tb_cert exp_tb">
                                        <tr>
                                            <td class="tl">
                                                <span><b class="red">*</b>起始时间 :</span>
                                            </td>
                                            <td>
                                                <div style="position:relative;display:inline-block;">
                                                    <input type="text" value="" id="exp_bdate" readonly/>
                                                </div>
                                                <div style="position:relative;display:inline-block;margin-left:5px;">至</div>
                                                <div style="position:relative;display:inline-block;">
                                                    <input type="text" value="" id="exp_endate" readonly/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tl">
                                                <span><b class="red">*</b>公司名称 :</span>
                                            </td>
                                            <td>
                                                <input type="text" id="exp_cname"  value="" name="com_name"/>
                                            </td>
                                            <td class="tl">
                                                <span><b class="red">*</b>行业 :</span>
                                            </td>
                                            <td>
                                                <input type="text" id="exp_trade"  value="" name="com_name"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tl">
                                                 <span><b class="red">*</b>公司规模 :</span>
                                            </td>
                                            <td>
                                                <select id="exp_sacle">
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
                                            <td class="tl">
                                                <span><b class="red">*</b>公司性质 :</span>
                                            </td>
                                            <td>
                                                <select id="exp_attr">
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
                                            <td class="tl">
                                                <span><b class="red">*</b>部门 :</span>
                                            </td>
                                            <td>
                                                <input type="text" value="" id="job_depart" name="com_depart"/>
                                            </td>
                                            <td class="tl">
                                                <span><b class="red">*</b>职位 :</span>
                                            </td>
                                            <td>
                                                <input type="text" value="" id="job_hold"  name="jo_pos"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tl lop">
                                                <span><b class="red">*</b>工作内容 :</span>
                                            </td>
                                            <td>
                                                <textarea id="job_cont" cols="" rows=""></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="s_btn" id="exp_s">
                                        <div class="btn_common btn4 s_n">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a class="btn white sv_mtn" id="exper_save" href="javascript:;">保存</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--工程业绩-->
                            <div class="pgrs" id="job_perform">
                                 <div class="p_info">
                                       <h2 class="lf">工程业绩</h2>
                                </div>
                                 <div class="clr"></div>
                                 <div class="had_project" id="had_progrs">
                                     <foreach name="resume.project_achievement_list" item="achive">
                                         <table class="t_pf tp">
                                             <tr>
                                                 <td class="tl"><span><b class="red">*</b>起始时间 :</span></td>
                                                 <td>
                                                     {$achive.start_date}
                                                     至
                                                     {$achive.end_date}
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td class="tl"><span><b class="red">*</b>项目名称 :</span></td>
                                                 <td>
                                                     {$achive.name}
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td class="tl"><span><b class="red">*</b>规模大小 :</span></td>
                                                 <td>
                                                     {$achive.scale[1]}
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td class="tl"><span><b class="red">*</b>担任职务 :</span></td>
                                                 <td>
                                                    {$achive.job_name}
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td class="tl lop"><span><b class="red">*</b>工作内容 :</span></td>
                                                 <td>
                                                     <span class="work_detail">{$achive.job_describle}</span>
                                                 </td>
                                             </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="up_info prgs_deal">
                                                          <a href="javascript:;" title="" class="dele_prgs blue" rel="{$achive.project_achievement_id}">删除工程业绩</a>
                                                          <a href="javascript:;" title="" class="blue adprs">添加工程业绩</a>
                                                       </div>
                                                    </td>
                                                </tr>
                                         </table>
                                     </foreach>
                                 </div>
                                 <div class="qua_detail perfane hidden" id="perforce">
                                    <table class="tb_cert t_pf">
                                        <tr>
                                            <td class="tl"><span><b class="red">*</b>起始时间 :</span></td>
                                            <td> 
                                                <div style="position:relative;display:inline-block;">
                                                     <input type="text" id="pjstart"  value="" readonly/>
                                                </div>
                                                <div style="position:relative;display:inline-block;margin-left:5px">至</div>
                                                <div style="position:relative;display:inline-block;">
                                                    <input type="text" id="pjstoped"  value="" readonly/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tl"><span><b class="red">*</b>项目名称 :</span></td>
                                            <td>
                                                <input type="text" id="pjname" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tl"><span><b class="red">*</b>规模大小 :</span></td>
                                            <td>
                                               <select id="pjscale">
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
                                            <td class="tl"><span><b class="red">*</b>担任职务 :</span></td>
                                            <td>
                                                <input type="text" id="pjheld" />
                                            </td>
                                        </tr>
                                         <tr>
                                            <td class="tl lop"><span><b class="red">*</b>工作内容 :</span></td>
                                            <td>
                                                <textarea id="pjcontent"rows="" cols=""></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="s_btn" id="pjchive_s">
                                        <div class="btn_common btn4 s_n">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a class="btn white sv_mtn" id="pjr_save" href="javascript:;">保存</a>
                                        </div>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                            <div class="clr"></div>
                            <input type="hidden" value="{$resume.job_category}"/>
                            <input type="hidden" value="{$resume.resume_status}"/>
                             <if condition="$HC_resume.job_category eq 0">
                                       <div class="pb_op" id="fut_pub">
                                    <h2 class="p_info">
                                        请选择发布方式:<span class="gray"> （您只能选择公开或委托兼职、全职简历之一）</span>
                                    </h2>
                                    <div class="pb_s lf">
                                        <div class="btn_common btn5">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" class="btn white" id="fjob_app">公开求职</a>
                                        </div>
                                    </div>
                                    <div class="me_or red lf">
                                            or
                                    </div>
                                    <div class="pb_a lf">
                                        <div class="btn_common btn8">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" class="btn white" id="fjob_adel">猎头代理</a>
                                        </div>
                                    </div>
                                    <div class="clr"></div>
                                    <div class="t_l ful_tp">
                                        <div class="l_tip lf">
                                            <p class="red">您的简历将被精准推送至</p>
                                            <p class="red">有相应需求的企业、猎头首页</p>
                                            <p class="red">您也可以自主投递简历到喜欢的职位</p>
                                        </div>
                                        <div class="r_tip rf">
                                            <p class="red">如果您没有时间,可以委托猎头代理</p>
                                            <p class="red">猎头将根据您的具体需求</p>
                                            <p class="red">为您筛选、推荐最合适的职位</p>
                                        </div>
                                    </div>
                                </div>
                                <elseif condition="$HC_resume.job_category eq 1 && $HC_resume.resume_status eq 2 "/>
                                       <div class="pb_op" id="fut_pub">
                                     <h2 class="p_info">
                                       请选择发布方式:<span class="red"> （暂停求职后，您全职简历将暂不能推送、投递）</span>
                                    </h2>
                                    <div class="pb_s lf">
                                        <div class="btn_common btn5">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" class="btn white" id="fend_app">暂停求职</a>
                                        </div>
                                    </div>
                                    <div class="me_or red lf">
                                            or
                                    </div>
                                    <div class="pb_a lf">
                                        <div class="btn_common btn7">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" class="btn white" id="fjob_adel">猎头代理</a>
                                        </div>
                                    </div>
                                  </div>
                                  <elseif condition="$HC_resume.job_category eq 2 && $HC_resume.resume_status eq 2 "/>
                                       <div class="pb_op" id="fut_pub">
                                        <h2 class="p_info">
                                            请选择发布方式:<span class="red"> （您已公开兼职简历,您可以选择暂停兼职求职后,再公开全职简历）</span>
                                        </h2>
                                    <div class="pb_s lf">
                                        <div class="btn_common btn7">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" class="btn white" id="fjob_app">公开求职</a>
                                        </div>
                                    </div>
                                    <div class="me_or red lf">
                                            or
                                    </div>
                                    <div class="pb_a lf">
                                        <div class="btn_common btn7">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" class="btn white" id="fjob_adel">猎头代理</a>
                                        </div>
                                    </div>
                                </div>
                                 <elseif condition="$HC_resume.job_category eq 1 && $HC_resume.resume_status eq 3 "/>
                             </if>
                        </div>
                        <div class="t_item hidden">
                            <!--求职岗位-->
                            <div class="bp_position" id="job_position">
                                <div class="qjobtip">
                                    <p class="pic"></p>
                                    <div>
                                        <p class="big">你期望找一份什么样的工作</p>
                                        <p class="small">填写求职意愿，不仅能看到最合适自己的职位，更能让HR主动找到你！</p>
                                    </div>
                                </div>
                                 <h2 class="p_info">
                                    <a href="javascript:;" title="修改" class="blue rf jblue" id="jobpo_edit">修改</a>
                                 </h2>
                                <div class="clr"></div>
                                 <div class="qua_detail">
                                     <table cellspacing="0" cellpadding="0" class="tb_cert" >
                                         <tr>
                                             <td class="tl">
                                                 <span>期望待遇:</span>
                                             </td>
                                             <td>
                                                <span class="job_pay hidden">
                                                   <select id="q_salary" rel="fjob">
                                                        <option value="0">面议</option>
                                                        <option value="7">0 ～ 1</option>
                                                        <option value="8">1 ～ 2</option>
                                                        <option value="9">2 ～ 3</option>
                                                        <option value="10">3 ～ 4</option>
                                                        <option value="11">4 ～ 5</option>
                                                        <option value="2">5 ～ 10</option>
                                                        <option value="3">10 ～ 20</option>
                                                        <option value="4">20 ～ 40</option>
                                                        <option value="5">40 ～ 99</option>
                                                        <option value="6">100 +</option>
                                                        <option value="12">手动填写</option>
                                                    </select>
                                                    <input value="" id="defpay1" class="defpay hidden" type="text" />万/年                                                    
                                                </span>                                                 
                                                 <span id="jpo_pay" val="{$resume.job_intent.job_salary[0]}">{$resume.job_intent.job_salary[1]}</span>
                                                 <switch name="resume.job_intent.job_salary[1]" >
                                                    <case value="面议"></case>                                                               
                                                    <default  /><span class="j_com">万/年</span>
                                                 </switch>
<!--                                                <span class="hidden ut">万/年</span>-->
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="tl">
                                                 <span>工作地点:</span>
                                             </td>
                                             <td>
                                                 <input type="hidden" name="jobp_prov"value="{$resume.job_intent.job_province_code}"/>
                                                 <input type="hidden" name="jobp_city" value="{$resume.job_intent.job_city_code}"/>
                                                 <input type="text" value="{$resume.job_intent.job_province} <notempty name='$resume.job_intent.job_city'>- {$resume.job_intent.job_city}</notempty>" id="q_area" class="mselect hidden" readonly/>
                                                 <span id="job_place" class="j_com">{$resume.job_intent.job_province} <notempty name="$resume.job_intent.job_city">- {$resume.job_intent.job_city}</notempty></span>
                                             </td>
                                         </tr>
                                         <tr class="lst_tr">
                                             <td class="tl">
                                                 <span>职位名称:</span>
                                             </td>
                                             <if condition="empty($intent)">
                                             <td class="fpos hidden">
                                             <else/>
                                             <td class="fpos">
                                             </if>
                                                <a href="javascript:;" id="q_pos" cids="{$intent['ids']}" pids="{$intent['pids']}" names="{$intent['names']}" class="blue">选择职位</a><span class="red" style="display:none" id="jtip">职位选择不能为空!</span>
                                                <div class="slt_pos" id="slt_pos">
                                                    <foreach name="intent['array']" item="it">
                                                        <a href="javascript:;" cid="{$it['id']}" pid="{$it['pid']}" class="undo">{$it['name']}</a>
                                                    </foreach>
                                                </div>
<!--                                                <span id="job_po" class="j_com">{$resume.job_intent.job_name}</span>-->
                                            </td>
<!--                                             <td>
                                                 
                                                 <input type="text" id="q_pos" value="{$resume.job_intent.job_name}" class="hidden" />
                                                 <span id="job_po" class="j_com">{$resume.job_intent.job_name}</span>
                                             </td>-->
                                         </tr>
                                         <tr>
                                             <td class="tl job_des">
                                                 求职意向:
                                             </td>
                                             <td>
                                                 <textarea id="job_want" class="hidden" clos="" rows="">{$resume.job_intent.job_describle}</textarea>
                                                 <span id="jpo_da">{$resume.job_intent.job_describle}</span>
                                             </td>
                                         </tr>
                                     </table>
                                     <div class="s_btn hidden" id="job_posv">
                                        <div class="btn_common btn4 s_n">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a class="btn white sv_mtn" id="jobpo_save" href="javascript:;">保存</a>
                                        </div>
                                    </div>
                                </div>
                           </div>
                        </div>
                        <!---------------------我的证书----------------->
                        <div class="t_item hidden">
                            <p class="sys_note">系统提示:您上传的证书仅用于职讯网审核，其他用户无权查看。审核通过后您的资质证书状态为“已认证”，系统会优先推荐您的简历。</p>
                            <p class="title blue">我拥有的证书</p>
                            <form action="{$web_root}/upload_cert" method="post" enctype="multipart/form-data" id="form_upload" target="Upfiler_file_iframe">
                                <table class="tb">
                                    <foreach name="rcerts" item="r">
                                        <tr>
                                            <td class="ltd">
                                                <span>资质证书 : </span>
                                            </td>
                                            <td>
                                                <div cid="{$r.id}">
                                                    <span>{$r.name}</span>
                                                    <a href="javascript:;" class="blue delecert">删除</a>
                                                </div>
                                            <if condition="$r.status eq 3">
                                                <span class="green">已通过认证</span>
                                                <elseif condition="$r.status eq 2"/>
                                                <span class="red">文件已上传,待审核</span>
                                                <else/>
                                                <span class="gray">未认证</span>
                                                <input type="file" name="file_{$r.id}" class="files"/>
                                            </if>
                                        </td>
                                        </tr>
                                    </foreach>
                                    <tr>
                                        <td class="ltd">
                                            <span>职称证 : </span>
                                        </td>
                                        <td>
                                            <div cid="{$gcert.id}" id="htit">
                                                <if condition="$gcert neq null">
                                                    <span class="tname">{$gcert.name}</span>
                                                </if>
                                                <if condition="$gcert neq null and $gcert.status eq 1">
                                                    <a href="javascript:;" class="blue alter">修改</a>
                                                    <elseif condition="$gcert neq null and $gcert.status eq 3"/>
                                                    <a href="javascript:;" class="blue opencont">解除认证</a>
                                                    <else/>
                                                </if>
                                                <if condition="$gcert eq null">
                                                    <div class="qual_cont">
                                                        <input class="mselect" type="text" id="qtitle" readonly/>
                                                    </div>
                                                    <else/>
                                                    <div class="qual_cont">
                                                        <input class="mselect hidden" type="text" id="qtitle" readonly/>
                                                    </div>
                                                </if>
                                            </div>
                                            <if condition="$gcert.status eq 3">
                                                <span class="green">已通过认证</span>
                                                <elseif condition="$gcert.status eq 2"/>
                                                <span class="red">文件已上传,待审核</span>
                                                <elseif condition="$gcert.status eq 1"/>
                                                <span class="gray">未认证</span>
                                                <input type="file" name="file_tcert" class="files"/>
                                                <else/>
                                            </if>
                                    </td>
                                    </tr>
<!--                                    <tr>
                                        <td class="ltd">
                                            <span>到期提醒 : </span>
                                        </td>
                                        <td style="position:relative">
                                            <input id="detime" type="text" value="" readonly="true" title="点击右侧图标选择日期"/>
                                            <span class="red">&nbsp;&nbsp;&nbsp;设置证书注册到期时间,系统会提前一周通知您</span>
                                        </td>
                                    </tr>-->
                                </table>
                                <input type="hidden" name="upfname" value="" id="upfname"/>
                                <input type="hidden" name="upfcid" value="" id="upfcid"/>
                            </form>
                            <iframe id="Upfiler_file_iframe" name="Upfiler_file_iframe" src="about:blank" style="display:none" ></iframe>
<!--                            <div class="add_tal">
                                <div class="btn_common btn4">
                                    <span class="b_lf"></span>
                                    <span class="b_rf"></span>
                                    <a class="btn white" href="javascript:;" id="subbtn">提&nbsp;&nbsp;交</a>
                                </div>
                            </div>-->
                            <p class="liner"></p>
                            <p class="title blue">添加新证书</p>
                            <table class="tb tb_cert tb_nt">
                                <tr>
                                    <td class="ltd">
                                        <span>资质证书 : </span>
                                    </td>
                                    <td>
                                        <input class="mselect qual_select" id="tqual" type="text" readonly/>
                                    </td>
                                </tr>
                            </table>
                            <div class="add_tal">
                                <div class="btn_common btn4">
                                    <span class="b_lf"></span>
                                    <span class="b_rf"></span>
                                    <a class="btn white" href="javascript:;" id="savebtn">添&nbsp;&nbsp;加</a>
                                </div>
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
