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
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">116</script>       
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
                            <h2 class="ct">人脉动态<a href="{$web_root}/contacts/0" title="更多人脉动态"class="rC"><span>更多</span><em></em></a></h2>
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
                        <h2 class="ct"><span class="lf">当前套餐使用统计</span><a class="blue r" href="{$web_root}/mpackage/" target="_blank"><span>续费</span><em></em></a></h2>
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
                            <li><em>.</em><a href="{$web_root}/advantages" target="_blank" class="gray">人性化设计以，极简操作</a></li>
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
        <div class="rt_cover hum_cov" id="rt_cover">
            <div class="rt_bg">
                <!--            中间导航-->
                <div class="navtip">
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
                <!--                简历管理-->
                <div class="fun_info fun_info3 guide1">
                    <div class="func_bg">
                        <div class="acc_set">
                            <div class="b_com my_prof">
                                <div class="sub_p blue">
                                    <a href="{$web_root}/resume/" title="现在去完善" class="blue"><em></em>兼职简历完善</a>
                                </div>
                                <div class="sub_p blue">
                                    <a href="{$web_root}/resume/1" title="现在去完善" class="blue"><em></em>全职简历完善</a>
                                </div>
                            </div>
                        </div>
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip3 guide1">
                    <div class="tri"><p></p></div>
                    <p class="top"></p>
                    <p class="blue">完善简历</p>
                    <p class="cont">点击这里<a href="{$web_root}/resume/" target="_blank" class="blue">完善您的简历信息</a>，可公开或委托简历给猎头哦。</p>
                    <p class="bot"></p>
                </div>
                <div class="fun_info fun_info4 guide1">
                    <div class="func_bg">
                        <div class="bh_nav">
                            <a href="{$web_root}/apm/">简历管理</a>
                        </div> 
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip4 guide1">
                    <div class="tri"><p></p></div>
                    <p class="top"></p>
                    <p class="blue">简历管理</p>
                    <p class="cont">您的简历、求职意向、资质证书都在这里哦。</p>
                    <p class="bot"></p>
                </div>

                <!--                个性推荐-->
                <div class="fun_info fun_info5 guide2">
                    <div class="func_bg">
                        <div class="acc_set">
                            <div class="b_com">
                                <div class="sub_p">
                                    <a href="{$web_root}/thome/" class="blue"><em></em>推荐职位</a>
                                </div>
                            </div>
                        </div>
                        <div class="wh_cov"></div>
                    </div>
                </div>
                <div class="funtip funtip5 guide2">
                    <p class="top"></p>
                    <p class="blue">个性推荐快速入口</p>
                    <p class="cont">系统会根据您公开的简历信息进行精准匹配，<a href="{$web_root}/thome/" target="_blank" class="blue">推荐的职位</a>在这儿查看哦。（公开的简历越详细，接收到的推荐职位越精准）</p>
                    <p class="bot"></p>
                    <div class="tri bri"><p></p></div>
                </div>
                <div class="fun_info fun_info6 guide2">
                    <div class="func_bg">
                        <div class="nH">
                            <h2 class="ct">推荐职位<a href="{$web_root}/thome/" title="更多推荐职位" class="rC"><span>更多</span><em></em></a></h2>
                            <div class="tk comlist">
                                <ul class="mlist">
                                    <li>
                                        <div class="lf photo">
                                            <a href="{$web_root}/10024" target="_blank" title="周清">
                                                <img src="{$file_root}Files/user/1/10024/photos/big/20120611/1339387093.jpg" alt="周清" class="small">
                                            </a>
                                        </div>
                                        <div class="lf info">
                                            <p>
                                                <span class="red">[兼职]</span>
                                                <a href="{$web_root}/office/929476" target="_blank" title="昆明造价公司急需造价工程师兼职挂证!" class="blue">昆明造价公司急需造价工程师兼职挂证!</a>
                                            </p>
                                            <p>
                                                <span class="gray">证书使用地:</span>
                                                <span>云南</span>&nbsp;&nbsp;&nbsp;
                                                <span class="gray sM">地区要求:</span>
                                                <span>不限</span>
                                            </p>
                                            <p>注册造价工程师 - 土建专业 - 初始注册 - 5人</p>                                            </div>
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
                    <p class="cont">这里是系统根据您的简历信息精确<a href="{$web_root}/thome/" target="_blank" class="blue">推送的职位。</a><span class="red">发布的信息越详细，接收到的推荐越精准</span></p>
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
                    <p class="cont">在这里您可以快速地查看<a href="{$web_root}/mpackage/" target="_blank" class="blue">套餐使用情况</a>、<a href="{$web_root}/mpackage/1"  target="_blank" class="blue">升级套餐</a>哦。</p>
                    <p class="bot"></p>
                </div>
                <!--                站内应用、行业资讯-->
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
                    <p class="cont">个人资料修改、<a href="{$web_root}/setPrivacyHuman/4" target="_blank" class="blue">隐私保护设置</a>、<a href="{$web_root}/profiles/3" target="_blank" class="blue">信用认证</a>在这里哦。</p>
                    <p class="bot"></p>
                </div>
            </div>
        </div>
    </body>
</html>
