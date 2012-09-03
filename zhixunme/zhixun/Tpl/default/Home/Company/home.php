<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>用户中心 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/default_common_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">72</script>
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
                    <!--未实名认证-->
                   <if condition="$per eq 0">
                   <div class="nopermission ">
                            <a href="javscript:;" id="cltip" class="cltip">x</a>
                            <p>{$info.name},您好！非常感谢您成功注册职讯网企业会员!您目前的状态为<span class="t_font">正式会员</span>,
                            看看您能做什么吧~<a href="{$web_root}/funcop" class="blue">查看</a>。您还可以申请成为职讯网的<span class="t_font">认证会员</span>,享受更多优质服务~
                                <a href="{$web_root}/profiles/3" class="blue">立即去认证></a>
                            </p>
                    </div>
                    </if>
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
                        <div class="tk">                                                   
                             <!-- JiaThis Button BEGIN -->
                            <span>分享主页:</span>
                            <div id="jiathis_style_32x32">                                
                                <a class="jiathis_button_tsina"></a>
                                <a class="jiathis_button_qzone"></a>                               
                                <a class="jiathis_button_tqq"></a>
                                <a class="jiathis_button_renren"></a>                                
                                <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                                <a class="jiathis_counter_style"></a>
                            </div>                            
                            <!-- JiaThis Button END --> 
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
        <!-- layout::Public:agentalert::0 --> 
        <!-- JiaThis Button BEGIN -->
        <script type="text/javascript">
                var jiathis_config={
                    url:"{$web_root}/{$info.user_id}",
                    title:"{$info.name}，诚聘建筑行业兼职、全职人才。更多招聘职位，请关注本公司主页（分享自 @职讯网）",
                    siteNum:16,
                    pic:"{$info.photo}"
                }
        </script>
        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1342595208180738" charset="utf-8"></script>
        <!-- JiaThis Button END -->  
    </body>
</html>
