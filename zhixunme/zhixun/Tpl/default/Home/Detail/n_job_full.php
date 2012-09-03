<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>{$job.title} - 职位详情页_{$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bdetail_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/card-hgs/card-hgs.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/detail-login/detail-login.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">112</script>
        <meta name='keywords' content='{$job.title},{$kwds}'>
        <meta name='description' content='{$job.title}。资质要求:{$job.cert[0]}，地区要求:{$job.location}，薪资待遇:{$job.salary}万/年。{$desc}'>
    </head>
    <body>
        <div class="bdheader" id="bdheader">
            <!-- layout::Public:n_header::0 -->
        </div>
        <!-- layout::Public:detail_login::0 --> 
        <div></div>
        <div class="layout2 comdetail ftimejob pdtl">
            <div class="layout2_l">
                <div class="ly_m_l">
                    <div class="module_1 detinfo _job">
                        <if condition="$job.job_type eq '1'">
                            <div class="ptype">
                            <else /><div class="ptype htype">
                        </if>
                        </div>
                        <p class="blue"><span class="red" jid="{$job.id}" type="1" id="jobid">[全职] </span> {$job.title}</p>
                        <div class="job_full">
                            <div class="lf pl">
                                <span class="gray">发布于: {$job.date}</span>
                                <span class="gray count">浏览数:</span><span class="red count">{$job.read_count}</span>
                                <a href="javascript:;" id="report" title="举报" class="complain gray"><span class="_m">&nbsp;</span>举报</a>
                            </div>
                            <div class="shares rf" id="share">
                                <div id="ckepop">
                                        <span class="jiathis_txt gray">分享到：</span>
                                        <a class="jiathis_button_tsina"></a>
                                        <a class="jiathis_button_tqq"></a>
                                        <a class="jiathis_button_qzone"></a>                                                                                
                                        <a class="jiathis_button_renren"></a>  
                                        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                                        <a class="jiathis_counter_style"></a>
                               </div>
                            </div> 
                        </div>
                        <div class="item">
                            <p class="gray _tl">招聘职位 :</p>
                            <p class="detail sdet">{$job.name}</p>
                            <p class="gray">招聘人数 :</p>
                            <p class="detail sdet scd">{$job.count}人</p>
                        </div>
                        <foreach name="job.cert" item="b">
                            <div class="item">
                                <p class="gray _tl">资质要求 :</p>
                                <p class="detail">{$b}</p>
                            </div>
                        </foreach>
                        <if condition="$job.gcert neq null">
                            <div class="item">
                                <p class="gray _tl">职称要求 :</p>
                                <p class="detail">{$job.gcert}</p>
                            </div>
                        </if>
                        <div class="item">
                            <p class="gray _tl">工作地点 :</p>
                            <p class="detail sdet">{$job.location}</p>
                            <p class="gray">薪资待遇 :</p>
                            <p class="detail sdet scd"><span class="red">
                                    <if condition="$job.salary eq '面议'">
                                        {$job.salary}</span></p>    
                                    <else/>{$job.salary}</span>万/年</p>    
                                    </if>
                        </div>
                        <div class="item">
                            <p class="gray _tl">学历要求 :</p>
                            <p class="detail sdet">{$job.degree}</p>
                            <p class="gray">工作经验 :</p>
                            <p class="detail sdet scd">{$job.exp}</p>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="module_4 detinfo detinfo_t">
                        <div class="item">
                            <p class="gray">职位描述 :</p>
                            <if condition="$job.descript neq null">
                                <p class="detail _desc">
                                    {$job.descript}
                                </p>
                                <else/>
                                <p class="detail red">
                                    暂无
                                </p>
                            </if>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="module_4 cinfo detinfo ">
                        <p class="ctitle gray">企业信息</p>
                         <if condition="$job.company_name neq ''">
                            <div class="item">
                                <p class="gray _tl">招聘企业 :</p>
                                <p class="detail">{$job.company_name}</p>
                            </div>
                         </if>
                        <if condition="$job.company_qualification neq ''">
                            <div class="item">
                                <p class="gray _tl">企业资质 :</p>
                                <p class="detail">{$job.company_qualification}</p>
                            </div>
                        </if>
                         <if condition="$job.company_category neq ''">
                            <div class="item">
                                <p class="gray _tl">企业性质 :</p>
                                <p class="detail">{$job.company_category}</p>
                            </div>
                         </if>
                         <if condition="$job.company_regtime neq '0000-00-00'">
                            <div class="item">
                                <p class="gray _tl">成立时间 :</p>
                                <p class="detail">{$job.company_regtime}</p>
                            </div>
                         </if>
                         <if condition="$job.company_scale neq ''">
                            <div class="item">
                                <p class="gray _tl">企业规模 :</p>
                                <p class="detail">{$job.company_scale}</p>
                            </div>
                         </if>
                        <if condition="$job.company_introduce neq ''">
                          <div class="item">
                            <p class="gray _tl">企业简介 :</p>
                            <p class="detail">{$job.company_introduce}</p>
                            <p class="clr"></p>
                          </div>
                        </if>
                    </div>
                    <p class="clr"></p>
                    <div class="module_3 btn_par job_ful">
                        <div class="btn_green lf">
                            <div class="btn_common btn5 sw">
                                <span class="b_lf"></span>
                                <span class="b_rf"></span>
                                <a href="javascript:;" class="btn white" id="app_ftr" type="{$type}">投递全职简历</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="agborder"></div>
            <div></div>
            <div class="layout2_r">
                <div class="lmain">
                    <!-- 若不为代理则显示发布者头像等-->
                    <p class="gray title _role">发布联系人</p>
                    <if condition="$job.is_agent eq 0">                        
                        <div class="photo">
                            <a class="img" href="{$web_root}/{$job.pub_model.id}" title="{$job.pub_model.name}">
                                <img class="psmall" src="{$job.pub_model.photo}" alt="{$job.pub_model.name}"/>
                            </a>
                            <div class="identify rf">
                                <p class="iden_name">{$job.pub_model.name}</p>                                
                                <switch name="job.pub_model.real_auth">
                                    <case value="0">
                                        <img class="lit_small lf" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                                    </case>
                                    <case value="1">
                                        <img class="lit_small lf" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                                    </case>
                                </switch> 
                                <switch name="job.pub_model.phone_auth">
                                    <case value="0">                                        
                                        <img class="lit_small lf" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                                    </case>
                                    <case value="1">
                                         <img class="lit_small lf" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                                   </case>
                                </switch> 
                                <switch name="job.pub_model.email_auth">
                                    <case value="0">
                                        <img class="lit_small lf" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                                    </case>
                                    <case value="1">
                                        <img class="lit_small lf" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>                                        
                                    </case>
                                </switch>                                                                
                                <p class="clr"></p>
                                <switch name="role_type">
                                    <case value="2">
                                        <span class="gray connect">企业联系人</span>
                                    </case>
                                    <case value="3">
                                         <span class="gray connect">猎头</span>
                                    </case>
                                </switch>                                
                                <else />                                
                                <div class="photo">
                                    <a class="img" href="{$web_root}/{$job.agent_model.id}" title="{$job.agent_model.name}">
                                        <img class="psmall" src="{$job.agent_model.photo}" alt="{$job.agent_model.name}"/>
                                    </a>
                                    <div class="identify rf">
                                        <p class="iden_name">{$job.agent_model.name}</p>                                            
                                        <switch name="job.agent_model.real_auth">
                                            <case value="0">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                                            </case>
                                        </switch> 
                                        <switch name="job.agent_model.phone_auth">
                                            <case value="0">                                        
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                                            </case>
                                        </switch> 
                                        <switch name="job.agent_model.email_auth">
                                            <case value="0">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                                            </case>
                                            <case value="1">
                                                <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>                                        
                                            </case>
                                        </switch>                                                                               
                                        <p class="clr"></p>
                                        <span class="gray connect">猎头</span>                                        
                                        </if>
                                        <div class="myfollow">                                          
                                            <div class="check_m btn_common btn17">
                                                <span class="lf"></span>
                                                <span class="rf"></span>
                                                <span class="jia"></span>
                                                <a href="javascript:;" title="加关注" id="add_focus" uid="{$agent.user_id}" class="mdetail btn" uname="{$agent.name}">加关注</a>                                          
                                            </div>                                                                                           
                                        </div>
                                    </div>
                                    <p class="clr"></p>
                                </div>                               
                                <if condition="$contact_role eq 3"><p class="conts sys_note">登录后免费查看猎头联系方式</p></if>
                                <div class="check_m btn_common btn10">
                                    <span class="lf"></span>
                                    <span class="rf"></span>
                                    <a href="javascript:;" class="white btn" id="ckcontact" uid="{$job.pub_model.id}">查看联系方式</a>
                                </div>
                                    </div>                                   
                                   <!--电话回拨start-->                                                                       
                                    <!--电话回拨end-->
                                    <div class="lmain promlst">
                                        <p class="gray title">类似职位推荐</p>
                                        <foreach name="similarJob" item="sim">
                                            <a href="{$web_root}/office/{$sim.job_id}" title="{$sim.job_title}" target="_blank">{$sim.job_title}</a>
                                        </foreach>
                                        <if condition="empty($similarJob)">
                                            <a href="javascript:;" style="color:#c00;">暂无类似职位</a>
                                        </if>
                                    </div>
                            </div>
                        </div>
                    </if>
                </div>
                <p class="clr"></p>
            </div>
            <!-- layout::Public:footersimple::60 -->
            <!-- JiaThis Button BEGIN -->
        <script type="text/javascript">
                var jiathis_config={
                    url:"{$web_root}/office{$isblog}/{$job.id}",
                    title:"[全职]{$job.title}（分享自 @职讯网）",                    
                    siteNum:16,
                    pic:"{$job.agent_model.photo}",
                    summary:"{$job.descript}"
                }
        </script>
        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1342595208180738" charset="utf-8"></script>
        <!-- JiaThis Button END -->
    </body>
</html>
