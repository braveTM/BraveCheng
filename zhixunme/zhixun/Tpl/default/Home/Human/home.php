<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>用户中心 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/default_common_1.0.css"/>
        <if condition="$register_guide['is_guide'] eq 1">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/slt-hgs/slt-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/boot-hgs/boot-hgs.css"/>
        </if>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">74</script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!--人才首页 -->
        <!-- layout::{$bheader}::0 --> 
        <div class="layout1 ag_default">
            <div class="layout1_l">
                <div class="module_1">
                     <!-- layout::Public:tnav::0 --> 
                </div>
            </div>
            <div class="layout1_r">
                <div class="L-r-m">
<!--                    推荐职位-->
                    <div class="nH">
                        <h2 class="ct">推荐职位<a href="{$web_root}/thome/"title="更多推荐职位"class="rC"><span>更多</span><em></em></a></h2>
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
                                                    <img src="{$job.publisher_photo}" alt="" class="small"/>
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
                            <h2 class="ct">人脉动态<a href="{$web_root}/contacts/0"title="更多人脉动态"class="rC"><span>更多</span><em></em></a></h2>
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
                    <!--数据统计-->
                    <div class="dm Tr nH taocan _count">                        
                        <div class="tk">
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
                    <!--推荐猎头-->
                    <div class="dm Tg Tr nH recwarp">
                        <h2 class="ct" id="recmidman">推荐猎头</h2>
                        <div class="Lt">
                            <foreach name="agents" item="ag">
                                <div class="Lp">
                                    <a href="{$web_root}/{$ag.id}" target="_blank"title="{$ag.name}">
                                        <img src="{$ag.photo}" alt="{$ag.name}" class="m_small"/>
                                        <span class="blue">{$ag.name}</span>
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
                                    <dt><img src="{$voc_root}/imgs/temp/comlogo1.png" alt="" class="Lg" /></dt>
                                    <dd><div class="Cds gray">
                                        成都建筑工程集团是集工程总承包、建筑安装施工、房地产开发、市政路桥、建材生产销售和物流、科研设计、装饰装修、文化旅游酒店等为一体的、中西部地区建筑业综合性企业。</div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><img src="{$voc_root}/imgs/temp/comlogo2.png" alt="" class="Lg" /></dt>
                                    <dd><div class="Cds gray">
                                        北京恒乐工程管理有限公司是首批获得并同时具有中国建设部颁发的工程造价咨询甲级资质和工程招标甲级资质及建设部认可的工程项目管理的综合性工程管理咨询机构。</div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><img src="{$voc_root}/imgs/temp/comlogo3.png" alt="" class="Lg" /></dt>
                                    <dd><div class="Cds gray">
                                        中国十九冶集团有限公司注册地在四川省攀枝花市，是国内唯一独立承担从矿山开采到型、板材冶金全流程施工能力的大型综合施工企业。</div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><img src="{$voc_root}/imgs/temp/comlogo4.png" alt="" class="Lg" /></dt>
                                    <dd><div class="Cds gray">
                                        安徽华业建工集团是房屋建筑工程施工总承包一级资质企业，拥有市政公用工程施工总承包二级、起重设备安装工程专业承包二级、土石方专业承包二级、城市道路照明专业承包三级资质。</div>
                                    </dd>
                                </dl> 
                            </div>
                            <a href="{$web_root}/thome/1" class="morecompany blue" title="查看更多企业"><span>查看更多企业</span><em></em></a>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="dm nH sev">
                        <h2 class="ct">平台优势<a  href="{$web_root}/advantages" class="rf blue"><span>查看详细特色</span><em></em></a></h2>
                        <ul class="gray">
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">人性化设计，极简操作</a></li>
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">海量职位，合作平台</a></li>
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
                    title:"我是 {$info.name}，欢迎访问我的个人主页（分享自 @职讯网）",
                    siteNum:16,
                    pic:"{$info.photo}"
                }
        </script>
        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1342595208180738" charset="utf-8"></script>
        <!-- JiaThis Button END -->  
    </body>
</html>
