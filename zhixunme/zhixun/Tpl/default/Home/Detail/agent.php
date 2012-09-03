<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>{$agent.name}的个人主页 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bdetail_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">59</script>
        <meta name='keywords' content='{$agent.name},个人主页,猎头,{$kwds}'>
        <meta name='description' content='这里是{$agent.name}的个人主页。{$agent.summary}/{$desc}'>
    </head>
    <body>        
        <!--猎头详细页 -->         
         <!-- layout::Home:Public:detailheader::0 -->
         <div></div>
        <div class="layout2 comdetail homedetail agdetail agd">
            
            <div class="layout2_l">
                <div class="layout_mid">
                <div class="ly_m_l">
                    <div class="module_1">
                        <div class="photo">
                            <div class="pho_shd_r"><img class="big" src="{$agent.photo}" alt="{$agent.name}"/></div>                            
                        </div>                                                
                        <div class="aginfo">                            
                            <div class="identify">
                                <span class="blue _name" title="{$agent.name}">{$agent.name}</span>
                                <if condition="$agent.real_auth eq 1">
                                    <img class="lit_small relname" src="{$file_root}Files/system/auth/ab.png" title="已实名认证" alt="已实名认证"/>                                 
                                </if>
                                <span class="gray">猎头</span>                                
                                <if condition="$agent.phone_auth eq 1">
                                    <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                                 <else/><img class="lit_small" src="{$file_root}/Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                                </if>
                                <if condition="$agent.email_auth eq 1">
                                    <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>
                                 <else/><img class="lit_small" src="{$file_root}/Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                                </if>
                                
                                <div class="shares" id="share">                  
                                    <div id="ckepop">
                                        <span class="jiathis_txt gray" class="">分享到：</span>
                                        <a class="jiathis_button_tsina"></a>
                                        <a class="jiathis_button_tqq"></a>
                                        <a class="jiathis_button_qzone"></a>                                                                                
                                        <a class="jiathis_button_renren"></a>  
                                        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                                        <a class="jiathis_counter_style"></a>
                                    </div>
                                </div> 
                                <div class="clr"></div>
                            </div>
                        </div>
                        <div></div>                        
                        <div class="baseinfo lf">
                            <p class="agent_url"><span class="gray lf">主页 :</span>&nbsp;&nbsp;<a class="blue" href="{$web_root}/{$agent.user_id}">{$web_root}/{$agent.user_id}</a></p>
                            <notempty name="contacts">
                                <p class="conts">
                                    <span class="gray">手机 :</span>&nbsp;<span class="ph_num">{$contacts.phone}</span>
                                    <if condition="$contacts.phone eq '暂无'">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <else/>&nbsp;&nbsp;
                                    </if>
                                    <span class="gray">邮箱 :</span>&nbsp;<span class="ph_ema">{$contacts.email}&nbsp;&nbsp;</span>                                                                    
                                    <if condition="$contacts.qq neq '暂无'">                                        
                                        <a class="ph_qq" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={$contacts.qq}&site=qq&menu=yes">
                                            <img border="0" src="http://wpa.qq.com/pa?p=2:{$contacts.qq}:41" alt="点击这里给我发消息" title="点击这里给我发消息">
                                        </a>                                    
                                    </if>
                                </p> 
                            </notempty>
                            <if condition="empty($contacts)">
                                <p class="conts sys_note">此用户设置了隐私保护"联系方式暂不公开"</p>                                
                            </if>
                            <p class="baseinfo_t">
                                <span class="gray">地区 :</span>&nbsp;&nbsp;<span>{$agent.location}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span>{$agent.degree}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--                                <span class="gray">活跃度 :</span>&nbsp;&nbsp;
                                <span></span>-->
                            </p>                            
                            <div class="item">
                                <p class="gray">简介 :&nbsp;&nbsp;</p>
                                <p class="detail">{$agent.summary}</p>
                                <div class="clr"></div>
                            </div>
                        </div>                                                
                        <p class="clr"></p>
                        <div class="action rf">
                            <div class="myfollow lf">                           
                                <if condition="$self neq 1">
                                    <switch name="agent.follow">
                                        <case value="0">
                                            <div class="check_m btn_common btn17">
                                                <span class="lf"></span>
                                                <span class="rf"></span>
                                                <span class="jia"></span>
                                                <a href="javascript:;" class="mdetail btn" id="add_focus" uid="{$agent.user_id}" uname="{$agent.name}">加关注</a>
                                            </div>
                                        </case>
                                        <case value="1">
                                            <div class="check_m btn_common btn18">
                                                <span class="lf"></span>
                                                <span class="rf"></span>
                                                <div class="re_focus">
                                                    <span class="imgfocs"></span>
                                                    <span class="gray"  href="javascript:;">已关注 </span><a id="re_focus" uid="{$agent.user_id}" uname="{$agent.name}" class="mdetail btn blue">取消</a></div>                                        
                                            </div>                                        
                                        </case>
                                    </switch>                              
                                </if>
                            </div>
                            <if condition="$self neq 1">
                                <a href="javascript:;" title="举报" id="report_a" uid="{$agent.user_id}" class="complain gray rf"><span class="_m">&nbsp;</span>举报</a>
                                <div class="pra">
                                    <span>赞一下：</span>                     
                                    <a href="javascript:;" class="good" id="praise" uid="{$agent.user_id}"></a>
                                    <span class="red pr_num">{$agent.praise}</span>  
                                </div>                            
                            </if>
                            <input type="hidden" id="ptype" value="{$type}">
                        </div>                        
                        <div class="clr"></div>
                    </div>
                </div>
            </div>         
                <div class="ly_m_l comlist">
                    <div class="ops_filter module_2" id="talfilter" uid="{$agent.user_id}"> 
                        <div class="sm_tab">
                            <ul class="filt_type">
                                <if condition="$type eq 2">
                                    <li class="cur_li"><a href="javascript:;" class="blue" tp="0">正在运作的简历</a></li>
                                    <li><a href="javascript:;" tp="1">正在运作的职位</a></li>
                                <else/>                                    
                                    <li><a href="javascript:;" class="blue" tp="0">正在运作的简历</a></li>
                                    <li class="cur_li"><a href="javascript:;" tp="1">正在运作的职位</a></li>
                                </if>                                
                            </ul>
                        </div>                                                
                        <div class="t_container">
                            <if condition="$type eq 1">
                                <div class="module_2 t_item mod show">
                                    <else/>
                                    <div class="module_2 t_item mod hidden">
                                        </if>                            
                                <span class="ops filt_role">
                                    <span>筛选条件：</span>
                                    <a href="javascript:;" tpy="0" >不限</a>
                                    <b>/</b> 
                                    <a href="javascript:;" tpy="2" class="blue">兼职</a>
                                    <b>/</b>
                                    <a href="javascript:;" tpy ="1" class="blue">全职</a>
                                </span>
                                <div id="pt1" class="p_n rf"></div>
                                <ul class="mlist hgstemp" id="runlist">
                                    <empty name="resume">
                                        <li class="no-data">暂无数据!</li>
                                    </empty>     
                                    <foreach name="resume" item="vo" >
                                        <li>                                           
                                        <!--   兼职简历  start-->
                                        <if condition="$vo.job_category eq 2">
                                            <div class="lf info">
                                                <p>
                                                    <span class="red">[兼职]</span>
                                                    <a rid="" target="_blank" class="blue jtitle" href="{$web_root}/get_resume/{$vo.human_id}">{$vo.name}</a>
                                                    <span class="gray">(简历公开于 {$vo.pub_date})</span>
                                                </p>
                                                <p><span class="gray">期望注册地: </span><span>{$vo.register_place}</span></p>
                                                <foreach name="vo.RC_list" item="v">
                                                    <p>
                                                    <span class="gray">证书情况: </span>
                                                    <span>{$v}</span>
                                                    </p>
                                                </foreach>                                              
                                            </div>
                                            <!--   兼职简历  end-->
                                            <!--   全职简历  start-->
                                        <elseif condition="$vo.job_category eq 1" />
                                            <div class="lf info">
                                                <p>
                                                    <span class="red">[全职]</span>
                                                    <a rid="" target="_blank" class="blue jtitle" href="{$web_root}/get_resume/{$vo.human_id}">{$vo.name}</a>
                                                    <span class="gray">(简历公开于 {$vo.pub_date})</span>
                                                </p>
                                                <div class="detail jdet"> 
                                                    <p class="gray">求职岗位: </p>
                                                    <p class="des lst_p">{$vo.job_name}</p>
                                                </div>
                                                <p class="lst_p"><span class="gray">期望工作地点: </span>
                                                    <span>{$vo.job_addr}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <span class="gray">工作年限: </span>
                                                    <span>{$vo.work_exp}</span>
                                                </p>
                                            </div>
                                        </if>    
                                        <div class="lf oper">                                        
                                            <if condition="$vo.salary eq '面议'">
                                                <p class="face">
                                                    <span class="red big">{$vo.salary}</span>
                                                <else/>
                                                <p>
                                                    <span class="red">¥</span>
                                                    <span class="red big">{$vo.salary}</span>
                                                    <span class="red">万/年</span>
                                            </if>                                                                                                
                                            </p>
                                        </div>
                                        <div class="clr"></div>
                                        </li>
                                    </foreach>                                                                                                                                                                                                                      
                                    <!--   全职简历  end-->
                                </ul>  
                                <div id="pagination1" rel="{$resume_count}" class="pages"></div>
                                <div class="clr"></div>
                            </div>                                  
                            <if condition="$type eq 2 || $type eq 3">
                                <div class="module_3 t_item mod show">
                                    <else/>
                                    <div class="module_3 t_item mod hidden">
                                        </if>                              
                                <span class="ops filt_role">
                                    <span>筛选条件：</span>
                                    <a href="javascript:;" tpy="0" >不限</a>
                                    <b>/</b> 
                                    <a href="javascript:;" tpy="2" class="blue">兼职</a>
                                    <b>/</b>
                                    <a href="javascript:;" tpy ="1" class="blue">全职</a>
                                </span>
                                <div id="pt2" class="p_n rf"></div>
                                <ul class="mlist hgstemp" id="runlist1">
                                    <empty name="job">
                                        <li class="no-data">暂无数据!</li>
                                    </empty>
                                    <foreach name="job" item="vo" >
                                    <li>
                                    <if condition="$vo.category eq 2">                                                                            
<!--                                        兼职职位  start-->
                                    <div class="lf info">
                                        <p>
                                            <span class="red">[兼职]</span>
                                            <a href="{$web_root}/office/{$vo.id}" class="blue jtitle" target="_blank" jid="{$vo.id}">{$vo.title}</a>
                                            <span class="gray">(发布于{$vo.date})</span>
                                        </p>
                                        <p>
                                            <span class="gray">证书使用地: </span><span>{$vo.location}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="gray">地区要求: </span><span>{$vo.place}</span>
                                        </p>
                                        <php>$last = count($vo->cert) - 1;</php>                                                
                                        <foreach name="vo.cert" item="v">                                           
                                            <if condition="$key eq $last">
                                                <p class="lst_p">                                                
                                                <else/>
                                                <p>
                                            </if>                 
                                            <span class="gray">证书要求: </span>
                                            <span>{$v}</span>
                                            </p>
                                        </foreach>
                                    </div>
<!--                                        兼职职位  end-->
                                    <elseif condition="$vo.category eq 1" />
<!--                                        全职职位  start-->
                                        <div class="lf info">
                                            <p>
                                                <span class="red">[全职]</span>
                                                <a href="{$web_root}/office/{$vo.id}" class="blue jtitle" target="_blank" jid="{$vo.id}">{$vo.title}</a>
                                                <span class="gray">(发布于{$vo.date})</span></p>
                                            <p>
                                                <span class="gray">招聘岗位: </span>
                                                <span>{$vo.name}</span>
                                            </p>
                                            <p class="lst_p">
                                                <span class="gray">工作地点: </span>
                                                <span>{$vo.location}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span class="gray">学历要求: </span>
                                                <span>{$vo.degree}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span class="gray">招聘人数: </span>
                                                <span>{$vo.count}人</span>
                                            </p>
                                        </div>
<!--                                        全职职位  end-->
                                    </if>
                                    <div class="lf oper">                                        
                                        <if condition="$vo.salary eq '面议'">
                                            <p class="face">
                                                <span class="red big">{$vo.salary}</span>
                                            <else/>
                                            <p>
                                                <span class="red">¥</span>
                                                <span class="red big">{$vo.salary}</span>
                                                <span class="red">万/年</span>
                                        </if>                                                                                                
                                        </p>
                                    </div>
                                    <div class="clr"></div>
                                    </li>
                                    </foreach>
                                </ul>
                                <div id="pagination2" rel="{$job_count}" class="pages"></div>
                                <div class="clr"></div>
                            </div>
                        </div>  
                    </div>                                                       
                </div>
            </div>
            <div class="agborder"></div>
            <div></div>
            <div class="layout2_r">
                <div class="lmain promlst">
                    <if condition="$agent.real_auth eq 1">
                        <div class="relbuton">职讯网实名认证用户</div>
                        <a class="blue torel lf" href="{$web_root}/profiles/3" target="_blank">我也要认证<em></em></a>
                        <div class="border clr"></div>
                    </if>                    
                    <div class="detailc">
                            <div class="red">
                                <span>{$rcount}</span>
                                <span>{$jcount}</span>
                                <span>{$agent.view}</span>
                            </div>
                            <div class="gray">
                                <span>简历数</span>
                                <span>职位数</span>
                                <span>主页访问数</span>
                            </div>
                    </div>
                    
                            <!--猎头详细页 - 委托职位-->
                            <if condition="$type eq 2">
                                <div class="btn_par">
                                <div class="btn_common btn10">
                                    <span class="lf"></span>
                                    <span class="rf"></span>
                                    <a href="javascript:;" class="white btn" id="deljob" uid="{$agent.user_id}" jid="{$job_id}">委托职位</a>
                                </div>
                                </div>
                                <elseif condition="$type eq 1"/>
                                <!--猎头详细页 - 委托简历-->
                                <div class="btn_par">
                                <input type="hidden" value="" name="resuid" />                              
                                <div class="btn_common btn10">
                                    <span class="lf"></span>
                                    <span class="rf"></span>
                                    <a href="javascript:;" class="white btn" id="app_ftr" uid="{$agent.user_id}">委托简历</a>
                                </div>
                                </div>
                                <else/>
                            </if>
<!--                                <if condition="$iscontact neq 1">
                                <a href="javascript:;" class="lgrebtn" id="ckcontact"uid="{$agent.user_id}" >查看联系方式</a>
                            </if>-->
                            <p class="clr"></p>                    
                    <div class="border"></div>                    
                    <if condition="empty($service_company_list)">
                        <p class="gray title hidden">最近服务过的企业:</p>
                    <else/><p class="gray title">最近服务过的企业:</p>
                    <foreach name="service_company_list" item="com">
                        <a href="{$web_root}/{$com.user_id}" title="{$com.name}" target="_blank" class="undline">{$com.name}</a>
                    </foreach>
                    <div class="border"></div>  
                    </if>                    
                    <if condition="empty($latest_blog)">
                        <p class="gray title hidden">他的职场经验:</p>
                        <else/><p class="gray title">他的职场经验:</p>
                        <foreach name="latest_blog" item="blog">
                            <a href="{$web_root}/article/1/{$blog.blog_id}" class="undline" title="{$blog.title}" target="_blank">{$blog.title}</a>
                        </foreach>
                        <a href="{$web_root}/articles/{$agent.user_id}" class="more undline">更多<em></em></a>
                        <div class="border"></div>  
                    </if>                                                          
                     <!--职讯帮助指导-->
                     <p class="gray title">推荐应用:</p>
                     <a href="{$web_root}/prefer/"class="blue" target="_blank"><em></em>人员资格查询</a>
                     <a href="{$web_root}/refer/"class="blue" target="_blank"><em></em>单位资质查询</a>
                     <a href="{$web_root}/contactbook/"class="blue" target="_blank"><em></em>建设部门通讯录</a>
                     <a href="{$web_root}/pdmail/"class="blue" target="_blank"><em></em>人事部门通讯录</a> 
                     <a href="{$web_root}/contract/"class="blue" id="downing" target="_blank"><em></em>合同模板下载</a>
                </div>
            </div>
            <p class="clr"></p>
        </div>                         
        <!-- layout::Public:footersimple::60 -->
      <!-- JiaThis Button BEGIN -->
      <script type="text/javascript">
                var jiathis_config={
                    url:"{$web_root}/{$agent.user_id}",
                    title:"驰骋建筑领域多年，快捷、高效解决人才、企业需求是我的服务宗旨！我是猎头 {$agent.name}-您身边最给力的建筑顾问！有需求，请找我，我将竭诚为您服务！（分享自 @职讯网）",
                    siteNum:16,
                    pic:"{$agent.photo}"
                }
        </script>
        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1342595208180738" charset="utf-8"></script>
        <!-- JiaThis Button END -->  
    </body>
</html>
