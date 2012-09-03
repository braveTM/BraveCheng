<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>{$resume.human.name}的简历 - 简历详情页_{$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bdetail_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/card-hgs/card-hgs.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">60</script>
        <meta name='keywords' content='{$resume.human.name},求职简历,{$kwds}'>
        <meta name='description' content='这是{$resume.human.name}的求职简历。{$desc}'>
    </head>
    <body>
        <!--全职简历详细页 -->
<!--         layout::Public:detailheader::0 -->
        <div class="layout4 comdetail resdetail fjd">
            <div class="layout_top">
                <p>
                    <a href="{$web_root}" class="logo" title="个人中心 - 职讯"></a>
                    <a href="javascript:window.opener=null;window.open('','_self');window.close();" class="blue rf">关闭此页</a>
                </p>
            </div>
            <if condition="!empty($agent) && $private eq 1 && $self eq 1">
                <div class="layout_mid dborder hidden">
            <else/>
                <div class="layout_mid dborder">
            </if>
                <div class="ly_m_l">
                    <!--                    没有猎头代理 || 有猎头代理&&非私有&&本人 || 有代理猎头&&私有&&本人-->
                    <if condition="empty($agent)||(!empty($agent) && $private neq 1 && $self eq 1)">
                        <div class="photo lf">
                            <p class="ptitle">简历发布人</p>
                            <a href="{$web_root}/{$resume.human.user_id}" title="{$resume.human.name}">
                                <img class="psmall" src="{$resume.human.photo}" alt="{$resume.human.name}"/>
                            </a>
                            <div class="pub_info rf">
                                <p class="iden_name lf">{$resume.human.name}</p>
                                <div class="identify lf">                                    
                                    <switch name="resume.human.real_auth">
                                            <case value="0">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                                            </case>
                                        </switch> 
                                        <switch name="resume.human.phone_auth">
                                            <case value="0">                                        
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                                            </case>
                                        </switch> 
                                        <switch name="resume.human.email_auth">
                                            <case value="0">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>                                        
                                            </case>
                                        </switch>
                                    <span class="gray">他是人才</span>
                                </div>
                                <div class="clr"></div>
                                <switch name="follow">
                                    <case value="0">
                                        <div class="myfollows lf">
                                            <div class="check_m btn_common btn17">
                                                <span class="lf"></span>
                                                <span class="rf"></span>
                                                <span class="jia"></span>
                                                <a href="javascript:;" title="加关注" id="add_focus"class="mdetail btn" uid="{$resume.human.user_id}" uname="{$resume.human.name}">加关注</a>                                        
                                            </div>                                            
                                        </div>
                                    </case>
                                    <case value="1">
                                        <div class="myfollows lf">
                                            <div class="check_m btn_common btn18">
                                                <span class="lf"></span>
                                                <span class="rf"></span>
                                                <span class="imgfocs"></span>
                                                <div class="re_focus"><span class="gray"  href="javascript:;">已关注 </span><a id="re_focus" uid="{$resume.human.user_id}" uname="{$resume.human.name}" class="btn blue">取消</a></div>                                        
                                            </div>
                                        </div>
                                    </case>
                                </switch>
                                <p class="clr"></p>
                                <p class="baseinfo">
<!--                                    <span class="gray">活跃度:</span>
                                    <span></span>-->
                                </p>
                            </div>
                            <p class="clr"></p>
                        </div>
                        <!--                   有猎头代理&&非私有&&非本人 || 有代理猎头&&私有&&非本人-->
                        <else/>
                        <div class="photo lf">
                            <p class="ptitle">简历发布人</p>
                            <a href="{$web_root}/{$agent.user_id}" title="{$agent.name}">
                                <img class="psmall" src="{$agent.photo}" alt="{$agent.name}"/>
                            </a>
                            <div class="pub_info rf">
                                <p class="iden_name lf">{$agent.name}</p>
                                <div class="identify lf">
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
                                    <span class="gray">他是猎头</span>
                                    <div class="clr"></div>
                                </div>                                
                                <p class="clr"></p>
                                <switch name="follow">
                                    <case value="0">
                                        <div class="myfollows lf">
                                            <div class="check_m btn_common btn17">
                                                <span class="lf"></span>
                                                <span class="rf"></span> 
                                                <span class="jia"></span>
                                                <a href="javascript:;" title="加关注" id="add_focus"class="mdetail btn" uid="{$agent.user_id}" uname="{$agent.name}">加关注</a>                                        
                                            </div>                                            
                                        </div>
                                    </case>
                                    <case value="1">
                                        <div class="myfollows lf">
                                            <div class="check_m btn_common btn18">
                                                <span class="lf"></span>
                                                <span class="rf"></span>
                                                <span class="imgfocs"></span>
                                                <div class="re_focus"><span class="gray"  href="javascript:;">已关注 </span><a id="re_focus" uid="{$agent.user_id}" uname="{$agent.name}" class="btn blue">取消</a></div>                                        
                                            </div>                                            
                                        </div>
                                    </case>
                                </switch>
                                 <p class="clr"></p>
                                <p class="baseinfo">
<!--                                    <span class="gray">活跃度:</span>
                                    <span></span>-->
                                </p>
                            </div>
                            <p class="clr"></p>
                        </div>
                    </if>
                    <if condition="($private neq 1 or $self neq 1) and ($show_contact_bt eq 1)">
                         <div class="check btn_common btn10 lf">
                            <span class="lf"></span>
                            <span class="rf"></span>
                            <a href="javascript:;" class="white btn" id="se_agphone">查看联系方式</a>
                         </div>
                        <div class="check lf hidden" id="loading">
                            <ul><li class="loading"><p></p><span>正在获取联系方式，请稍后…</span></li></ul>                            
                        </div>
                    </if>
                    <!--                    不是本人访问&&猎头代理-->
                    <if condition="empty($contacts) and ($show_contact_bt eq 0)">
                        <div class="nocontact gray rf">此用户暂未公开联系方式!</div>
                    </if>
                    <if condition="empty($contacts)">                        
                        <div class="module_2 conts hidden lf" id="cont_way">
                     <else/>
                       <div class="module_2 conts lf" id="cont_way">
                     </if>
                                <p><span class="gray">手机:</span><span class="ph_num">{$contacts.phone}</span></p>
                                <p><span class="gray">邮箱:</span><span class="ph_ema">{$contacts.email}</span></p>
                                <p><span class="ph_qq">
                                        <if condition="$contacts.qq neq '暂无'">
                                            <a class="ph_qq" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$contacts.qq}&site=qq&menu=yes">
                                                <img border="0" src="http://wpa.qq.com/pa?p=2:{$contacts.qq}:41" alt="点击这里给我发消息" title="点击这里给我发消息">
                                            </a>                                            
                                        </if>
                                    </span>                                
                                </p>
                            </div>                        
                             <!--电话回拨start-->
                                 
                            <!--电话回拨end-->
                    <p class="clr"></p>
                   </div>
                </div>
                <div class="layout_mid dborder">
                    <div class="ly_m_l">
                        <p class="fres_icon"></p>
                        <div class="module_2 detinfo detinfo_t n_to">
                            <p class="title">个人信息</p>
                            <div class="item">
                                <p class="gray">姓名 :</p>
                                <p class="detail sdet">{$resume.human.name}</p>
                                <p class="gray">生日 :</p>
                                <p class="detail sdet">{$resume.human.birth}</p>
                            </div>
                            <div class="item">
                                <p class="gray">居住地 :</p>
                                <p class="detail sdet">{$resume.human.addr}</p>
                                <p class="gray">工作年限 :</p>
                                <p class="detail sdet">{$resume.human.exp[1]}</p>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <!--求职岗位-->
                        <div class="module_2 detinfo detinfo_t">
                            <p class="title">求职意向</p>
                            <div class="item">
                                <p class="gray">期望待遇 :</p>
                                <p class="detail sdet">
                                    <span class="red">{$resume.job_intent.job_salary[1]}</span>
                                 <switch name="resume.job_intent.job_salary[1]" >                                        
                                    <case value="面议"></case>                                                               
                                    <default  /> 万/年
                                </switch>
                                </p>
                                <p class="gray expad">期望工作地点 :</p>
                                <p class="detail sdet">{$resume.job_intent.job_province}-{$resume.job_intent.job_city}</p>
                            </div>
                            <div class="item">
                                <p class="gray">岗位名称 :</p>
                                <div class="detail pos_req">{$resume.job_intent.job_name}</div>
                            </div>
                            <div class="item">
                                <p class="gray">补充说明 :</p>
                                <div class="detail pos_req">
                                    <if condition="$resume.job_intent.job_describle eq 0"><span class="red">未填写</span>
                                        <else />{$resume.job_intent.job_describle}
                                    </if>
                                </div>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <!--学历-->
                        <div class="module_2 detinfo detinfo_t">
                            <p class="title">学历</p>
                            <div class="item">
                                <p class="gray">就读时间 :</p>
                                <p class="detail sdet">
                                    <span class="b_time">{$resume.degree.study_startdate}</span>
                                    至
                                    <span class="e_time">{$resume.degree.study_enddate}</span>
                                </p>
                                <p class="gray">学校名称 :</p>
                                <p class="detail sdet">{$resume.degree.school}</p>
                            </div>
                            <div class="item">
                                <p class="gray">专业名称 :</p>
                                <p class="detail sdet">{$resume.degree.major_name}</p>
                                <p class="gray">学历 :</p>
                                <p class="detail sdet">{$resume.degree.degree_name[1]}</p>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <!--证书情况-->
                        <div class="module_2 detinfo detinfo_t">
                            <p class="title">证书情况</p>
                            <foreach name="resume.register_certificate_list" item="cert">
                                <div class="item">
                                    <p class="gray">资质证书 :</p>
                                    <p class="detail">{$cert.register_certificate_name}
                                    <php>
                                        if(!empty($cert->register_certificate_major)){
                                        echo '-'.$cert->register_certificate_major;
                                        }
                                    </php>
                                    -{$cert.register_case}-{$cert.register_place}</p>
                                </div>
                            </foreach>
                            <div class="item">
                                <p class="gray">职称证 :</p>
                                <p class="detail sdet">{$resume.grade_certificate.grade_certificate_class_name}-{$resume.grade_certificate.grade_certificate_type}-{$resume.grade_certificate.grade_certificate_major}</p>
                            </div>
                            <div class="item">
                                <p class="gray">补充说明 :</p>
                                <div class="detail pos_req">
                                    <if condition="$resume.certificate_remark eq 0"><span class="red">未填写</span>
                                        <else />{$resume.certificate_remark}
                                    </if>
                                </div>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <!--工作经历-->
                        <div class="module_2 detinfo detinfo_t">
                            <p class="title">工作经历</p>
                            <if condition="$resume.work_exp_list eq 0"><p class="title red">暂未填写</p>
                                <else /><foreach name="resume.work_exp_list" item="exper">
                                    <div class="exp_list">
                                        <div class="item">
                                            <p class="gray">任职时间 :</p>
                                            <p class="detail sdet">
                                                <span>{$exper.work_startdate}</span>至
                                                <span>{$exper.work_enddate}</span>
                                            </p>
                                        </div>
                                        <div class="item">
                                            <p class="gray">公司名称 :</p>
                                            <p class="detail sdet">{$exper.company_name}</p>
                                            <p class="gray">行业 :</p>
                                            <p class="detail sdet">{$exper.company_industry}</p>
                                        </div>
                                        <div class="item">
                                            <p class="gray">公司规模 :</p>
                                            <p class="detail sdet">
                                                {$exper.company_scale[1]}
                                            </p>
                                            <p class="gray">公司性质 :</p>
                                            <p class="detail sdet">
                                                {$exper.company_property[1]}
                                            </p>
                                        </div>
                                        <div class="item">
                                            <p class="gray">部门 :</p>
                                            <p class="detail sdet">
                                                {$exper.department}
                                            </p>
                                            <p class="gray">职位 :</p>
                                            <p class="detail sdet">
                                                {$exper.job_name}
                                            </p>
                                        </div>
                                        <div class="item">
                                            <p class="gray">补充说明 :</p>
                                            <div class="detail pos_req">
                                                {$exper.job_describle}
                                            </div>
                                            <div class="clr"></div>
                                        </div>
                                    </div>
                                </foreach>
                            </if>
                        </div>
                        <!--工程业绩-->
                        <div class="module_2 detinfo detinfo_t">
                            <p class="title">工程业绩</p>
                            <if condition="$resume.project_achievement_list eq 0"><p class="title red">暂未填写</p>
                                <else />
                                <foreach name="resume.project_achievement_list" item="achive">
                                    <div class="prgs_list">
                                        <div class="item">
                                            <p class="gray">起始时间 :</p>
                                            <p class="detail sdet">
                                                <span>{$achive.start_date}</span>至
                                                <span>{$achive.end_date}</span>
                                            </p>
                                        </div>
                                        <div class="item">
                                            <p class="gray">项目名称 :</p>
                                            <p class="detail sdet">{$achive.name}</p>
                                        </div>
                                        <div class="item">
                                            <p class="gray">规模大小 :</p>
                                            <p class="detail sdet">{$achive.scale[1]}</p>
                                        </div>
                                        <div class="item">
                                            <p class="gray">担任职务 :</p>
                                            <p class="detail sdet">{$achive.job_name}</p>
                                        </div>
                                        <div class="item">
                                            <p class="gray">补充说明 :</p>
                                            <div class="detail pos_req">
                                                {$achive.job_describle}
                                            </div>
                                            <div class="clr"></div>
                                        </div>
                                    </div>
                                </foreach>
                            </if>
                        </div>
                        <if condition="$self neq 1">
                            <div class="module_3 btn_par detinfo inv_apl ">
                                <div class="btn_green lf">
                                    <div class="btn_common sw btn5">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white" id="inv_apl">邀请投递简历</a>
                                    </div>
                                    <input type="hidden" name="cate_id" value="{$resume.job_category}" />
                                    <input type="hidden" name="rid" value="{$resume.resume_id}" />
                                </div>
                            </div>
                        </if>
                        <input type="hidden" name="resume_number" value="{$resume.resume_id}"/>
                        <input type="hidden" name="isagented" value="{$agent.id}" />
                        <input type="hidden" id="rmid" value="{$mid}" />
                    </div>
                </div>
            </div>
        </div>
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
