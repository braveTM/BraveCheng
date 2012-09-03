<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>{$job.title} - 职位详情页_{$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bdetail_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">58</script>
        <meta name='keywords' content='{$job.title},{$kwds}'>
        <meta name='description' content='{$job.title}。{$desc}'>
    </head>
    <body>
        <!--全职职位详细页 -->
         <!-- layout::Home:Public:detailheader::0 -->
        <div class="layout4 comdetail joblistdetail">
            <div class="layout_mid dborder">
                <div class="ly_m_l">
                    <div class="module_1 detinfo">
                        <input name="type" id="rt" type="hidden" value="{$type}" />
                        <if condition="$job.job_type eq '1'">
                            <div class="ptype">
                            <else /><div class="ptype htype">
                        </if>
                        </div>
                        <p class="blue"><span class="red" jid="{$job.id}" id="fullid">[全职] </span> {$job.title} <span class="gray">(发布于 {$job.date})</span>
                        <span class="red rf count">{$job.read_count}</span><span class="gray rf">浏览数:</span></p>
                        <if condition="$job.job_agent eq 1 ">
                            <div class="item">                           
                                <p class="gray">委托来源 :</p>
                                <p class="detail company">{$job.company}</p>
                                <switch name="iscontact">
                                    <case value="1"></case>
                                    <default/>
                                    <div class="btn_common btn10 lf">
                                        <span class="lf"></span>
                                        <span class="rf"></span>
                                        <a href="javascript:;" class="white btn" id="ckcontact" uid="{$job.id}">查看联系方式</a>
                                    </div>                                                       
                                </switch>                                
                            </div>                        
                        </if>
                        <if condition="$job.job_agent eq 1 && $iscontact eq 1">
                            <div class="item contway">
                                <p class="gray">联系方式 :</p>
                                <p class="detail"><span class="gray phone">手机 </span><span>{$contacts.phone}</span><span class="gray email">邮箱 </span><span>{$contacts.email}</span></p>                                                                                                
                            </div>
                        <else />
                            <div class="item hidden contway" id="cont_way">
                                <p class="gray">联系方式 :</p>
                                <p class="detail"><span class="gray phone">手机 </span><span id="phone"></span><span class="gray email">邮箱 </span><span id="email"></span></p>                                                                                                
                            </div>
                        </if>  
                        <div class="item">
                            <p class="gray">招聘职位 :</p>
                            <p class="detail sdet">{$job.name}</p>
                            <p class="gray">招聘人数 :</p>
                            <p class="detail sdet">{$job.count}&nbsp;&nbsp;人</p>
                        </div>
                        <foreach name="job.cert" item="b">
                            <div class="item">
                                <p class="gray">资质要求 :</p>
                                <p class="detail">{$b}</p>
                            </div>
                        </foreach>
                        <if condition="$job.gcert neq null">
                            <div class="item">
                                <p class="gray">职称要求 :</p>
                                <p class="detail">{$job.gcert}</p>
                            </div>
                        </if>                          
                        <p class="clr"></p>
                        <div class="hd_item hidden" id="hd_item">
                            <div class="item">
                                <p class="gray">工作地点 :</p>
                                <p class="detail sdet">{$job.location}</p>
                                <p class="gray">薪资待遇 :</p>
                                <p class="detail sdet"><span class="red">
                                        <if condition="$job.salary eq '面议'">
                                        {$job.salary}</span></p>    
                                    <else/>{$job.salary}</span>万/年</p>    
                                    </if>                                        
                            </div>
                            <div class="item">
                                <p class="gray">学历要求 :</p>
                                <p class="detail sdet">{$job.degree}</p>
                                <p class="gray">工作经验 :</p>
                                <p class="detail sdet">{$job.exp}</p>
                            </div>
                            <div class="item">
                                <p class="gray">职位描述 :</p>
                                <p class="detail _desc">
                                    {$job.descript}
                                </p>
                                <div class="clr"></div>
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
                        </div>                          
                        <p class="clr"></p>
                        <div class="chmore" id="chmore">
                         <div class="shares"  id="share">
                                    <span class="lf gray">分享职位：</span>
                                    <a class="share shr_1" href="javascript:;" tp="sina" title="分享到新浪微博" ur="{$web_root}/office{$isblog}/{$job.id}" tit="[全职]{$job.title}"></a>
                                    <a class="share shr_2" href="javascript:;" tp="tencent" title="分享到腾讯微博" ur="{$web_root}/office{$isblog}/{$job.id}"  tit="[全职]{$job.title}"></a>
                                    <a class="share shr_3" href="javascript:;" tp="qzone" title="分享到QQ空间" ur="{$web_root}/office{$isblog}/{$job.id}"   tit="[全职]{$job.title}"></a>                                                                                                  
                                    <p class="clr"></p>
                        </div>
                         <a href="javascript:;" class="m">查看职位详细信息</a><a href="javascript:;" class="chk_a">></a></div>
                        <p class="clr"></p>
                    </div>
                    <div class="res_list">
                        <p class="count rf">共计<span class="red" id="dr_resume"></span>份</p>
                        <div class="ops_filter" id="resfilter">
                            <span class="gray">收到的应聘简历：</span>
                            <span class="filt_type">
                                <a href="javascript:;" rl="0" title="" class="red">不限</a>
                                <b>/</b>
                                <a href="javascript:;" rl="3" title="">猎头投递</a>
                                <b>/</b>
                                <a href="javascript:;" rl="1" title="" >人才投递</a>
                            </span>
                        </div>
                        <ul class="mlist hgstemp" id="reslist">
                            <li class="loading">
                                <p></p>
                            </li>
                        </ul>
                    </div>
                    <div class="module_4 btn_par">
                        <div id="pagination" class="pages">
                        </div>
                        <if condition="$job.status eq 2">
                            <div class="btn_green">
                                <div class="btn_common btn5">
                                    <span class="b_lf"></span>
                                    <span class="b_rf"></span>
                                    <a href="javascript:;" class="btn white" id="closejob">结束招聘</a>
                                </div>
                            </div>
                        </if>
                        <p class="clr"></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
