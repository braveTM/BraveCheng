<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>{$profile.name}的个人主页 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bdetail_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">98</script>
        <meta name='keywords' content='{$profile.name},个人主页,人才,{$kwds}'>
        <meta name='description' content='这里是{$profile.name}的个人主页。{$desc}'>
    </head>
    <body>
        <!--人才详细页 -->
         <!-- layout::Home:Public:detailheader::0 -->
         <div></div>
        <div class="layout4 comdetail homedetail humdetail">
            <div class="layout_mid dborder">
                <div class="ly_m_l">
                    <div class="module_1 human">
                        <div class="photo">
                            <div class="pho_shd_r">
                                <img class="big" src="{$profile.photo}" alt="{$profile.name}"/>
                            </div>                           
                        </div>
                        <div class="detailc comp">
                            <div class="c_detail">                                
                                <span class="green">{$profile.rcount}</span>
                                <span class="gray">简历阅读</span>                                                                
                            </div>
                            <div class="c_detail">                                
                                <span class="green">{$profile.view}</span>
                                <span class="gray">主页访问数</span>                                                                                          
                            </div>
                        </div>
                        <div class="aginfo">
                            <div class="myfollow rf">                        
                             <if condition="$self neq 1">
                                <switch name="follow">
                                    <case value="0">
                                        <div class="check_m btn_common btn17">
                                            <span class="lf"></span>
                                            <span class="rf"></span>
                                            <span class="jia"></span>
                                            <a href="javascript:;" title="加关注" id="add_focus" uid="{$profile.uid}" class="mdetail btn" uname="{$profile.name}">加关注</a>                                          
                                        </div>                                         
                                    </case>
                                    <case value="1">
                                        <div class="re_focus">
                                            <div class="check_m btn_common btn18">
                                                <span class="lf"></span>
                                                <span class="rf"></span>
                                                <span class="imgfocs"></span>
                                                <div class="re_focus"><span class="gray"  href="javascript:;">已关注 </span><a id="re_focus" uid="{$profile.uid}" uname="{$profile.name}" class="mdetail btn blue">取消</a></div>                                        
                                            </div>                                             
                                        </div>
                                    </case>
                                </switch>
                             </if>  
                            </div>
                            <div class="identify">
                                <span class="blue _name" title="{$profile.name}">{$profile.name}</span>
                                <span class="gray">人才</span>
                                <if condition="$profile.real_auth eq 1">
                                    <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                                 <else/><img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                                </if>
                                <if condition="$profile.phone_auth eq 1">
                                    <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                                 <else/><img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                                </if>
                                <if condition="$profile.email_auth eq 1">
                                    <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>
                                 <else/><img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                                </if> 
                                <if condition="$self neq 1">
                                <a href="javascript:;" title="举报" id="report_h" uid="{$profile.uid}" class="complain gray"><span class="_m">&nbsp;</span>举报</a>
                                </if>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <div></div>                       
                        <a class="blue user_url" href="{$web_root}/{$profile.uid}">{$web_root}/{$profile.uid}</a>
                        <div class="baseinfo lf">
                            <foreach name="profile.certs" item="cert">
                                <p class="baseinfo_t">
                                    <span class="gray">证书情况 :</span>&nbsp;&nbsp;
                                    <span>
                                        {$cert}
                                        <!--                                        {$cert.register_certificate_name}
                                                                                <php>
                                                                                    if(!empty($cert->register_certificate_major)){
                                                                                    echo '-'.$cert->register_certificate_major;
                                                                                    }
                                                                                </php>
                                                                                -{$cert.register_case}-{$cert.register_place}-->
                                    </span>
                                </p>
                            </foreach>
                            <p class="baseinfo_t">
                                <span class="gray">职称证 :</span>&nbsp;&nbsp;
                                <span>{$profile.gcert}</span>
                            </p>
                            <p class="baseinfo_t">
                                <span class="gray">所在地 :</span>&nbsp;&nbsp;
                                <span>{$profile.place}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="gray">工作年限 :</span>&nbsp;&nbsp;
                                <span>{$profile.work_age}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--                                <span class="gray">活跃度:</span>
                                <span></span>-->
                            </p>
                        </div>
                        <p class="clr"></p>
                    </div>
                    <div class="module_2">
                        <p class="htitle gray">人才简历情况:</p>
                        <ul class="mcols">
                            <li>
                                <div class="f_cl">
                                    <span class="green">兼职简历</span>
                                </div>
                                <div class="s_cl">
                                    <span class="gray">完善度</span>&nbsp;&nbsp;&nbsp;
                                    <span class="lblue">{$resume.p_wsd}%</span>
                                </div>
                                <div class="t_cl">
                                    <span class="gray">薪资要求</span>&nbsp;&nbsp;&nbsp;
                                    <if condition="$resume.p_salary eq '面议'">
                                        <span class="red">{$resume.p_salary}</span>
                                    <else /><span class="red">¥ {$resume.p_salary} 万/年</span>
                                    </if>                                    
                                </div>
                                <div class="fr_cl">
                                    <span class="gray">状态</span>&nbsp;&nbsp;&nbsp;
                                    <if condition="$resume.p_status eq 1">
                                        <span class="lblue">已公开</span>
                                        <else/>
                                        <span class="lblue">已关闭</span>
                                    </if>
                                </div>
<!--                                <div class="_browse">
                                    <span class="gray">浏览数</span>&nbsp;&nbsp;&nbsp;
                                    <span class="red">{$resume.f_wsd}</span>
                                </div>-->
                            <if condition="$resume.p_status eq 1">
                                <div class="fv_cl lf">
                                    <div class="check_m btn_common btn10 lf">
                                    <span class="lf"></span>
                                    <span class="rf"></span>
                                    <a href="{$web_root}/get_resume/{$profile.hid}" class="white btn">查看简历</a>
                                    </div>
                                </div>
                            </if>
                            <div class="clr"></div>
                            </li>
                            <li class="lst_li">
                                <div class="f_cl">
                                    <span class="green">全职简历</span>
                                </div>
                                <div class="s_cl">
                                    <span class="gray">完善度</span>&nbsp;&nbsp;&nbsp;
                                    <span class="lblue">{$resume.f_wsd}%</span>
                                </div>
                                <div class="t_cl">                                    
                                    <span class="gray">薪资要求</span>&nbsp;&nbsp;&nbsp;
                                    <if condition="$resume.f_salary eq '面议'">
                                        <span class="red">{$resume.f_salary}</span>
                                    <else /><span class="red">¥ {$resume.f_salary} 万/年</span>
                                    </if>                                    
                                </div>
                                <div class="fr_cl">
                                    <span class="gray">状态</span>&nbsp;&nbsp;&nbsp;
                                    <if condition="$resume.f_status eq 1">
                                        <span class="lblue">已公开</span>
                                        <else/>
                                        <span class="lblue">已关闭</span>
                                    </if>
                                </div>
<!--                                <div class="_browse">
                                    <span class="gray">浏览数</span>&nbsp;&nbsp;&nbsp;
                                    <span class="red">{$resume.f_wsd}</span>
                                </div>-->
                            <if condition="$resume.f_status eq 1">
                                <div class="fv_cl lf">
                                    <div class="check_m btn_common btn10 lf">
                                    <span class="lf"></span>
                                    <span class="rf"></span>
                                    <a href="{$web_root}/get_resume/{$profile.hid}" class="white btn">查看简历</a>
                                    </div>
                                </div>
                            </if>
                            <div class="clr"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="layout_mid dborder">
                <div class="ly_m_l">
                    <p class="htitle gray">Ta最近投递的企业:</p>
                    <div class="nearcom">
                        <foreach name="company" item="com">
                            <a href="{$web_root}/{$com.id}"><img src="{$com.photo}" alt="{$com.name}"/></a>
    <!--                        <a href="#"><img src="/zx/zhixun/Theme/default/vocat/imgs/system/dlogo.png"/></a>
                            <a href="#"><img src="/zx/zhixun/Theme/default/vocat/imgs/system/dlogo.png"/></a>
                            <a href="#"><img src="/zx/zhixun/Theme/default/vocat/imgs/system/dlogo.png"/></a>
                            <a href="#" class="lst_a"><img src="/zx/zhixun/Theme/default/vocat/imgs/system/dlogo.png"/></a>-->
                        </foreach>
                    </div>
                </div>
            </div>
        </div>    
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
