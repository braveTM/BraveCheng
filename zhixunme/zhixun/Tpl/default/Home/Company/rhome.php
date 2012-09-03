<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>用户中心 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/default_common_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/guide_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">117</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!--企业首页 -->
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 ag_default">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:enav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="L-r-m">
                    <!--推荐简历-->
                    <div class="nH">
                        <h2 class="ct">推荐简历<a href="{$web_root}/ehome/0"title="更多推荐简历"class="rC" ><span>更多</span><em></em></a></h2>
                        <div class="tk comlist">
                            <ul class="mlist">
                                <foreach name="resumes" item="re">
                                    <if condition="$re.job_category eq 2">
                                        <li>
                                            <div class="lf photo">
                                                <a href="{$web_root}/{$re.publisher_id}" target="_blank" title="{$re.publisher_name}">
                                                    <img src="{$re.publisher_photo}" class="small" alt="{$re.publisher_name}"/>
                                                </a>
                                            </div>
                                            <div class="lf info">
                                                <p class="head_info">
                                                    <span class="red">[兼职]</span>
                                                    <a href="{$web_root}/get_resume/{$re.human_id}" target="_blank" title="{$re.human_name}" class="blue">{$re.human_name}</a>
<!--                                                    <span class="gray">(简历修改于 {$re.update_datetime})</span>-->
                                                </p>
                                                <p>
                                                    <span class="gray">期望注册地:</span>
                                                    <span>{$re.register_province_ids}</span>
                                                </p>
                                                <foreach name="re.RC_list" item="qa">
                                                    <p>{$qa}</p>
                                                </foreach>
                                            </div>
                                            <div class="clr"></div>
                                        </li>
                                        <elseif condition="$re.job_category eq 1"/>
                                        <li>
                                            <div class="lf photo">
                                                <a href="{$web_root}/{$re.publisher_id}" target="_blank" title="{$re.publisher_name}">
                                                    <img src="{$re.publisher_photo}" alt="" class="small"/>
                                                </a>
                                            </div>
                                            <div class="lf info">
                                                <p class="head_info">
                                                    <span class="red">[全职]</span>
                                                    <a href="{$web_root}/get_resume/{$re.human_id}" target="_blank" title="{$re.human_name}" class="blue">{$re.human_name}</a>
<!--                                                    <span class="gray">(简历修改于 {$re.update_datetime})</span>-->
                                                </p>
                                                <p>
                                                    <span class="gray">求职岗位: </span>
                                                    <span>{$re.job_name}</span>
                                                </p>
                                                <p>
                                                    <span class="gray">期望注册地: </span>
                                                    <span>{$re.work_addr}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <span class="gray">工作年限: </span>
                                                    <span>{$re.human_work_age}</span>
                                                </p>
                                                <foreach name="re.RC_list" item="qa">
                                                    <p>{$qa}</p>
                                                </foreach>
                                            </div>
                                            <div class="clr"></div>
                                        </li>
                                    </if>
                                </foreach>
                            </ul>
                            <p class="bdr_cov"></p>
                        </div>
                    </div>
                    <if condition="$per eq 1 && $moving neq 0">
                        <!--人脉动态-->
                        <div class="nH Dy">
                            <h2 class="ct">人脉动态<a href="{$web_root}/contacts/0"title="更多人脉动态"class="rC" ><span>更多</span><em></em></a></h2>
                            <div class="tk comlist">
                                <ul class="mlist contr">
                                    <foreach name="moving" item="mo">
                                        <li>
                                            <div class="lf photo">
                                                <a href="{$web_root}/{$mo.user_id}" title="{$mo.name}" target="_blank">
                                                    <img src="{$mo.photo}" alt="" class="m_small"/>
                                                </a>
                                            </div>
                                            <div class="lf info">
                                                <p>
                                                    <a href="{$web_root}/{$mo.user_id}" title="{$mo.name}" target="_blank" class="blue">{$mo.name}</a>
                                                    <span>{$mo.action}</span>
                                                    <span class="gray">({$mo.date})</span>
                                                </p>
                                                <p>
                                                    {$mo.content}
                                                </p>
                                            </div>
                                            <div class="clr"></div>
                                        </li>
                                    </foreach>
                                </ul>
                                <p class="bdr_cov"></p>
                            </div>
                        </div>
                    </if>
                </div>
                <div class="L-r">
                    <!--当前免费套餐使用统计-->
                    <div class="dm nH _count count">
                        <h2 class="ct"><span class="lf">当前套餐使用统计</span><a class="blue r" href="{$web_root}/mpackage/" target="_blank"><span>续费</span><em></em></a></h2>
                        <div class="tk">                                                   
                            <ul class="Tj">
                                <foreach name="current.modules" item="cur">                                                                            
                                    <if condition="$cur.name eq '电话拨打分钟数'">
                                        <li title="[{$cur.name}-使用统计]&#13;套餐总计: {$cur.t_count}分钟&#13;已使用: {$cur.t_count-$cur.s_count}分钟&#13;还剩余: {$cur.s_count}分钟&#13;已超出：0分钟">
                                            <em class="gray">{$cur.name}:</em>
                                            <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" class="red">{$cur.t_count-$cur.s_count}</a>/{$cur.t_count}</em>                                    
                                        </li>                                     
                                        <elseif condition="$cur.t_count egt 0" />
                                        <li title="[{$cur.name}-使用统计]&#13;套餐总计: {$cur.t_count}条&#13;已使用: {$cur.t_count-$cur.s_count}条&#13;还剩余: {$cur.s_count}条&#13;已超出：0条">
                                            <em class="gray">{$cur.name}:</em>
                                            <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" class="red">{$cur.t_count-$cur.s_count}</a>/{$cur.t_count}</em>                                    
                                        </li>                                                                
                                        <elseif condition="$cur.t_count lt 0"/>                                    
                                        <li>                                                                                                              
                                            <em class="gray">{$cur.name}:</em>
                                            <em class="fr"><a href="{$web_root}/mpackage/" target="_blank"  class="">不限</a></em>                                    
                                        </li>
                                    </if> 
                                </foreach>                                                                                               
                                <if condition="$current.modules eq ''">
                                    <li>                                                                        
                                        <em class="gray">发布职位数:</em>
                                        <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" title="已使用"class="red">0</a>/0</em>                                    
                                    </li>                                      
                                    <li>                                                                        
                                        <em class="gray">人才联系方式查看数:</em>
                                        <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" title="已使用"class="red">0</a>/0</em>                                    
                                    </li>                                      
                                    <li>                                                                        
                                        <em class="gray">猎头联系方式查看数:</em>
                                        <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" title="已使用"class="red">0</a>/0</em>                                    
                                    </li>                                      
                                </if>
                            </ul>
                            <div class="butn">                                
                                <div class="butn1">
                                    <a  href="{$web_root}/mpackage/1" target="_blank" class="butn1">
                                        <span>更多套餐<br/>金额优惠</span>
                                        立即升级套餐
                                    </a>
                                </div>
                                <div class="butn2">
                                    <a href="{$web_root}/bill/" target="_blank" class="butn2">
                                        <span>可用金额<br/><font style="font-size:14px;">{$page.count1}</font></span>                                    
                                        立即去充值
                                    </a>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>
                    </div>
                    <!--推荐人才-->
                    <div class="dm Tr nH recwarp">
                        <h2 class="ct" id="rec">推荐人才</h2>
                        <div class="Lt">
                            <foreach name="humans" item="hm">
                                <div class="Lp">
                                    <a href="{$web_root}/{$hm.id}"  target="_blank" title="{$hm.name}">
                                        <img src="{$hm.photo}" alt="{$hm.name}" class="m_small"/>
                                        <span class="blue">{$hm.name}</span>
                                    </a>
                                </div>
                            </foreach>                            
                        </div>
                        <div class="Lt hgstemp hidden" id="recman"></div>
                        <div class="clr"></div>
                    </div>
                    <!--推荐猎头-->
                    <div class="dm Tg Tr nH">
                        <h2 class="ct">推荐猎头<a href="{$web_root}/ehome/1"title="更多猎头推荐"class="rC" ><span>更多</span><em></em></a></h2>
                        <div class="Lt">
                            <foreach name="agents" item="ag">
                                <div class="Lp">
                                    <a href="{$web_root}/{$ag.id}" title="{$ag.name}" target="_blank">
                                        <img src="{$ag.photo}" alt="{$ag.name}"title="{$ag.name}" class="m_small"/>
                                        <span class="blue">{$ag.name}</span>
                                    </a>
                                </div>
                            </foreach>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="dm nH sev">
                        <h2 class="ct">平台优势<a href="{$web_root}/advantages" target="_blank" class="rf blue"><span>查看详细特色</span><em></em></a></h2>
                        <ul class="gray">
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">人性化设计，极简操作</a></li>
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">海量资源，高质量建筑人才</a></li>
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">需求对应，精准匹配</a></li>
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">诚信平台，服务保障</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
        <div class="rt_cover com_cov" id="rt_cover">
            <div class="rt_bg">
                <!--            中间导航-->
                <div class="navtip com_cov">
                    <p>欢迎来到职讯网！</p>
                    <a href="javascript:;" class="rt_close" id="rt_close"></a>
                    <div class="pagin" id="pagin">
                        <span class="lspan"></span>
                        <a href="javascript:;" class="cur"></a>
                        <a href="javascript:;"></a>
                        <a href="javascript:;"></a>
                        <a href="javascript:;"></a>
                        <a href="javascript:;"></a>
                        <a href="javascript:;"></a>
                        <span class="rspan">下一个 ></span>
                        <div class="clr"></div>
                    </div>
                </div>
                <!--            引导块-->
                <!--                招聘管理-->
                <div class="fun_info fun_info3 guide1">
                    <div class="func_bg">
                        <div class="acc_set">
                            <div class="b_com my_quali">
                                <div class="area_title">
                                    <h2 class="a_title">招聘管理</h2>
                                </div>
                                <div class="sub_p">
                                    <a href="{$web_root}/recruitment/" class="blue"><em></em>我公开的职位</a>
                                </div>
                                <div class="sub_p">
                                    <a href="{$web_root}/recruitment/3" class="blue"><em></em>收到应聘简历</a>
                                </div>
                                <div class="adb btn9 btn_common btn">
                                    <span class="b_lf"></span>
                                    <span class="b_rf"></span>
                                    <a href="{$web_root}/epubjob/" class="btn blue">发布新职位</a>
                                </div>
                            </div>
                        </div>
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip3 guide1">
                    <div class="tri"><p></p></div>
                    <p class="top"></p>
                    <p class="blue">发布新职位</p>
                    <p class="cont">点击这里发布您的招聘信息，可公开或委托职位给猎头哦。</p>
                    <p class="bot"></p>
                </div>
                <div class="fun_info fun_info4 guide1">
                    <div class="func_bg">
                        <div class="bh_nav">
                            <a href="{$web_root}/recruitment/">招聘管理</a>
                        </div> 
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip4 guide1">
                    <div class="tri"><p></p></div>
                    <p class="top"></p>
                    <p class="blue">招聘管理</p>
                    <p class="cont">您公开或委托出去的职位、<a href="{$web_root}/recruitment/3" target="-blank" class="blue">应聘来的简历</a>都在这里查看。</p>
                    <p class="bot"></p>
                </div>
                <!--                个性推荐-->
                <div class="fun_info fun_info5 guide2">
                    <div class="func_bg">
                        <div class="acc_set">
                            <div class="b_com">
                                <div class="sub_p">
                                    <a href="{$web_root}/ehome/" class="blue"><em></em>推荐简历</a>
                                </div>
                            </div>
                        </div>
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip5 guide2">
                    <p class="top"></p>
                    <p class="blue">个性推荐快速入口</p>
                    <p class="cont">系统会根据您发布的职位信息进行精准匹配，推荐的简历在这儿查看哦。</p>
                    <p class="bot"></p>
                    <div class="tri bri"><p></p></div>
                </div>
                <div class="fun_info fun_info6 guide2">
                    <div class="func_bg">
                        <div class="nH">
                            <h2 class="ct">推荐简历<a href="{$web_root}/ehome/0" title="更多推荐简历" class="rC"><span>更多</span><em></em></a></h2>
                            <div class="tk comlist">
                                <ul class="mlist">
                                    <li>
                                        <div class="lf photo">
                                            <a href="{$web_root}/80" target="_blank" title="黄先生">
                                                <img src="{$file_root}Files/system/photo/user/big/default.png" class="small" alt="黄先生">
                                            </a>
                                        </div>
                                        <div class="lf info">
                                            <p class="head_info">
                                                <span class="red">[兼职]</span>
                                                <a href="{$web_root}/get_resume/52" target="_blank" title="黄先生" class="blue">黄先生</a>
                                            </p>
                                            <p>
                                                <span class="gray">期望注册地:</span>
                                                <span>四川</span>
                                            </p>
                                        </div>
                                        <div class="clr"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip6 guide2">
                    <div class="tri lri"><p></p></div>
                    <p class="top"></p>
                    <p class="blue">个性推荐</p>
                    <p class="cont">系统根据您的职位招聘要求，而精确<a href="{$web_root}/{$user_id_self}/index/" target="_blank"  class="blue">推送的简历</a>在这里查看哦。<span class="red">发布的信息越详细，接收到的推荐越精准</span></p>
                    <p class="bot"></p>
                </div>
                <!--                套餐推荐-->
                <div class="fun_info fun_info7 guide3">
                    <div class="func_bg">
                        <div class="L-r">
                            <!--当前免费套餐使用统计-->
                            <div class="dm nH _count" id="count">
                                <h2 class="ct"><span class="lf">当前套餐使用统计</span><a href="{$web_root}/mpackage/" target="_blank" class="r blue rf"><span>续费</span><em></em></a></h2>
                                <div class="tk">
                                    <ul class="Tj">
                                        <foreach name="current.modules" item="cur">                                                                            
                                            <if condition="$cur.name eq '电话拨打分钟数'">
                                                <li>
                                                    <em class="gray">{$cur.name}:</em>
                                                    <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" class="red">{$cur.t_count-$cur.s_count}</a>/{$cur.t_count}</em>                                    
                                                </li>                                     
                                                <elseif condition="$cur.t_count egt 0" />
                                                <li>
                                                    <em class="gray">{$cur.name}:</em>
                                                    <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" class="red">{$cur.t_count-$cur.s_count}</a>/{$cur.t_count}</em>                                    
                                                </li>                                                                                                    
                                                <elseif condition="$cur.t_count lt 0"/>                                    
                                                <li>                                                                                                              
                                                    <em class="gray">{$cur.name}:</em>
                                                    <em class="fr"><a href="{$web_root}/mpackage/" target="_blank"  class="">不限</a></em>                                    
                                                </li>
                                            </if> 
                                        </foreach>
                                        <if condition="$current.modules eq ''">
                                            <li>                                                                        
                                                <em class="gray">发布职位数:</em>
                                                <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" title="剩余"class="red">0</a>/0</em>                                    
                                            </li>                                      
                                            <li>                                                                        
                                                <em class="gray">人才联系方式查看数:</em>
                                                <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" title="剩余"class="red">0</a>/0</em>                                    
                                            </li>                                      
                                            <li>                                                                        
                                                <em class="gray">企业联系方式查看数:</em>
                                                <em class="fr"><a href="{$web_root}/mpackage/" target="_blank" title="剩余"class="red">0</a>/0</em>                                    
                                            </li>                                      
                                        </if>
                                    </ul>
                                    <div class="butn">                                
                                        <div class="butn1">
                                            <a href="{$web_root}/mpackage/1" target="_blank"  class="butn1">
                                                <span>更多套餐<br/>金额优惠</span>
                                                立即升级套餐
                                            </a>
                                        </div>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                            </div>
                        </div>
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip7 guide3">
                    <div class="tri rri"><p></p></div>
                    <p class="top"></p>
                    <p class="blue">套餐统计</p>
                    <p class="cont">在这里您可以快速地<a href="{$web_root}/mpackage/" target="_blank" class="blue">查看套餐使用情况</a>、升级套餐哦。</p>
                    <p class="bot"></p>
                </div>
                <!--                站内应用、客户管理、行业资讯-->
                <div class="fun_info fun_info8 guide4">
                    <div class="func_bg">
                        <div class="acc_set">
                            <div class="b_com">
                                <div class="area_title">
                                    <h2 class="a_title">站内应用</h2>
                                </div>
                                <div class="sub_p">
                                    <a href="{$web_root}/prefer/" class="blue" target="_blank"><em></em>人员资格查询</a>
                                </div>
                                <div class="sub_p">
                                    <a href="{$web_root}/refer/" class="blue" target="_blank"><em></em>单位资质查询</a>
                                </div>
                                <div class="sub_p">
                                    <a href="{$web_root}/contactbook/" class="blue" target="_blank"><em></em>建设部门通讯录</a>
                                </div>
                                <div class="sub_p">
                                    <a href="{$web_root}/pdmail/" class="blue" target="_blank"><em></em>人事部门通讯录</a>
                                </div>
                                <div class="sub_p">
                                    <a href="{$web_root}/contract/" class="blue" target="_blank"><em></em>合同模板下载</a>
                                </div>
                            </div>
                        </div>
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip8 guide4">
                    <p class="top"></p>
                    <p class="blue">站内应用</p>
                    <p class="cont">为您贴心设计站内小工具，让您轻松查询资质信息、建设部门通讯录。</p>
                    <p class="bot"></p>
                    <div class="tri bri"><p></p></div>
                </div>
                <div class="fun_info fun_info10 guide4">
                    <div class="func_bg">
                        <div class="bh_nav">
                            <a href="#" class="">行业资讯</a>
                        </div> 
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip10 guide4">
                    <div class="tri"><p></p></div>
                    <p class="top"></p>
                    <p class="blue">行业资讯</p>
                    <p class="cont">去这里了解建筑行业新闻、政策法规、文件通知、公示公告等最新资讯。</p>
                    <p class="bot"></p>
                </div>
                <!--                帐号-->
                <div class="fun_info fun_info11 guide5">
                    <div class="func_bg">
                        <div class="bh_nav">
                            <a href="#" class="">帐号</a>
                        </div> 
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip11 guide5">
                    <div class="tri trri"><p></p></div>
                    <p class="top"></p>
                    <p class="blue">帐号</p>
                    <p class="cont">个人资料修改、<a href="{$web_root}/setPrivacyCompany/4" target="_blank" class="blue">隐私保护设置</a>、<a href="{$web_root}/profiles/3" target="_blank" class="blue">信用认证</a>、客户关键事件提醒设置在这里哦。</p>
                    <p class="bot"></p>
                </div>
            </div>
        </div>
    </body>
</html>
