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
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">73</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!--猎头首页 -->
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 ag_default">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:anav::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="L-r-m">
                    <!--未实名认证-->
                    <if condition="$per eq 0">                     
                        <div class="nopermission ">
                            <a href="javscript:;" id="cltip" class="cltip">x</a>
                            <p>{$info.name},非常感谢您成功注册职讯网猎头会员！您目前的状态为<span class="t_font">正式会员</span>,
                                看看您能做什么吧~<a href="{$web_root}/funcop#midman" class="blue">查看</a>。您还可以申请成为职讯网的<span class="t_font">认证会员</span>,享受更多优质服务~
                                <a href="{$web_root}/profiles/3" class="blue">立即去认证></a>
                            </p>
                        </div>
                    </if>
                    <!--推荐简历-->
                    <div class="nH">
                        <h2 class="ct">推荐简历<a href="{$web_root}/ahome/0"title="更多推荐简历"class="rC" ><span>更多</span><em></em></a></h2>
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
                                                    <img src="{$re.publisher_photo}" alt="{$re.publisher_name}" class="small"/>
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
                    <!--推荐职位-->
                    <div class="nH">
                        <h2 class="ct">推荐职位<a href="{$web_root}/ahome/1"title="更多推荐职位"class="rC"><span>更多</span><em></em></a></h2>
                        <div class="tk comlist">
                            <ul class="mlist">
                                <foreach name="jobs" item="job">
                                    <if condition="$job.job_category eq 2">
                                        <li>
                                            <div class="lf photo">
                                                <a href="{$web_root}/{$job.publisher_id}"  target="_blank"title="{$job.publisher_name}">
                                                    <img src="{$job.publisher_photo}" alt="{$job.publisher_name}" class="small"/>
                                                </a>
                                            </div>
                                            <div class="lf info">
                                                <p>
                                                    <span class="red">[兼职]</span>
                                                    <a href="{$web_root}/office/{$job.job_id}" target="_blank" title="{$job.job_title}" class="blue">{$job.job_title}</a>
<!--                                                    <span class="gray">({$job.pub_datetime})</span>-->
                                                </p>
                                                <p>
                                                    <span class="gray">证书使用地:</span>
                                                    <span>{$job.C_use_place}</span>&nbsp;&nbsp;&nbsp;
                                                    <span class="gray sM">地区要求:</span>
                                                    <span>{$job.require_place}</span>
                                                </p>

                                                <foreach name="job.RC_list" item="qa">
                                                    <p>{$qa}</p>
                                                </foreach>
                                            </div>
                                            <div class="clr"></div>
                                        </li>
                                        <elseif condition="$job.job_category eq 1"/>
                                        <li>
                                            <div class="lf photo">
                                                <a href="{$web_root}/{$job.publisher_id}" target="_blank" title="{$job.publisher_name}">
                                                    <img src="{$job.publisher_photo}" alt="{$job.publisher_name}" class="small"/>
                                                </a>
                                            </div>
                                            <div class="lf info">
                                                <p>
                                                    <span class="red">[全职]</span>
                                                    <a href="{$web_root}/office/{$job.job_id}"  target="_blank"title="{$job.job_title}" class="blue">{$job.job_title}</a>
<!--                                                    <span class="gray">({$job.pub_datetime})</span>-->
                                                </p>
                                                <p> 
                                                    <span class="gray">招聘岗位:</span>
                                                    <span>{$job.job_name}</span>
                                                </p>
                                                <p>
                                                    <span class="gray">工作地点:</span>
                                                    <span>{$job.job_province_code}-{$job.job_city_code}</span>&nbsp;&nbsp;&nbsp;
                                                    <span class="gray sM">招聘人数:</span>
                                                    <span>{$job.job_count}人</span>&nbsp;&nbsp;&nbsp;
                                                    <span class="gray">学历要求:</span>
                                                    <span>{$job.degree}</span>
                                                </p>
                                                <foreach name="job.RC_list" item="qa">
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
                                                    <img src="{$mo.photo}" alt="{$mo.name}" class="m_small"/>
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
                    <div class="dm nH _count" id="count">
                        <div class="tk gray">
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
                        <ul class="user_atten">
                            <li><em class="sc"></em>我的积分<span class="red rf">{$statistics.score}</span></li>
                            <li><em class="dig"></em>主页被赞数<span class="red rf">{$statistics.praise}</span></li>
                            <li><em class="vie"></em>主页访问数<span class="rf"><a href="{$web_root}/{$info.user_id}" class="red" target="_blank">{$statistics.view}</a></span></li>
                        </ul>
                        <div class="itg">
                            <div class="glod_icon"></div>
                            <div class="new_icon"></div>
                            <h3>赚积分,换套餐~</h3>
                            <p>如何赚取积分,兑换套餐</p>
                            <div class="btn_common btn23 lf">
                                <span class="b_lf"></span>
                                <span class="b_rf"></span>
                                <a href="{$web_root}/mpackage/1" target="_blank" class="btn blue">立即兑换</a>
                            </div>
                            <a href="{$web_root}/scrule" class="blue lf more" target="_blank">了解更多</a>
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
                    <!--推荐企业-->
                    <div class="dm Cr nH">
                        <h2 class="ct">推荐企业<span class="pr h">&nbsp;</span><span class="pl stop">&nbsp;</span></h2>
                        <div id="recompanys" class="rc">
                            <div class="wrap">
                                <dl>
                                    <dt><img src="{$voc_root}/imgs/temp/comlogo1.png" alt="成都建筑工程集团" class="Lg" /></dt>
                                    <dd><div class="Cds gray">
                                            成都建筑工程集团是集工程总承包、建筑安装施工、房地产开发、市政路桥、建材生产销售和物流、科研设计、装饰装修、文化旅游酒店等为一体的、中西部地区建筑业综合性企业。</div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><img src="{$voc_root}/imgs/temp/comlogo2.png" alt="北京恒乐工程管理有限公司" class="Lg" /></dt>
                                    <dd><div class="Cds gray">
                                            北京恒乐工程管理有限公司是首批获得并同时具有中国建设部颁发的工程造价咨询甲级资质和工程招标甲级资质及建设部认可的工程项目管理的综合性工程管理咨询机构。</div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><img src="{$voc_root}/imgs/temp/comlogo3.png" alt="中国十九冶集团有限公司" class="Lg" /></dt>
                                    <dd><div class="Cds gray">
                                            中国十九冶集团有限公司注册地在四川省攀枝花市，是国内唯一独立承担从矿山开采到型、板材冶金全流程施工能力的大型综合施工企业。</div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><img src="{$voc_root}/imgs/temp/comlogo4.png" alt="安徽华业建工集团" class="Lg" /></dt>
                                    <dd><div class="Cds gray">
                                            安徽华业建工集团是房屋建筑工程施工总承包一级资质企业，拥有市政公用工程施工总承包二级、起重设备安装工程专业承包二级、土石方专业承包二级、城市道路照明专业承包三级资质。</div>
                                    </dd>
                                </dl> 
                            </div>
                            <a href="{$web_root}/ahome/2" class="morecompany blue" title="查看更多企业"><span>查看更多企业</span><em></em></a>
                        </div> 
                    </div>
                    <div class="dm nH sev">
                        <h2 class="ct">平台优势<a  href="{$web_root}/advantages" class="rf blue"><span>查看详细特色</span><em></em></a></h2>
                        <ul class="gray">
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">人性化设计，极简操作</a></li>
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">需求对应，精准匹配</a></li>
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">专业资源库，多种方案</a></li>
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">多重审核，诚信可靠</a></li>
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">CRM，低成本运作</a></li>
                        </ul>                        
                    </div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
        <!-- JiaThis Button BEGIN -->        
        <script type="text/javascript">
                var jiathis_config={
                    url:"{$web_root}/{$info.user_id}",
                    title:"驰骋建筑领域多年，快捷、高效解决人才、企业需求是我的服务宗旨！我是猎头 {$info.name}-您身边最给力的建筑顾问！有需求，请找我，我将竭诚为您服务！（分享自 @职讯网）",
                    siteNum:16,
                    pic:"{$info.photo}"
                }
        </script>
        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1342595208180738" charset="utf-8"></script>
        <!-- JiaThis Button END -->  
    </body>
</html>
