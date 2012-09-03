<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>{$company.name}的个人主页 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bdetail_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/detail-login/detail-login.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">111</script>
        <meta name='keywords' content='{$company.name},个人主页,企业,{$kwds}'>
        <meta name='description' content='这里是{$company.name}的个人主页。{$company.summary}/{$desc}'>
    </head>
    <body>
        <!--企业详细页 -->
         <div class="bdheader" id="bdheader">
            <!-- layout::Public:n_header::0 -->
        </div>
        <!-- layout::Public:detail_login::0 --> 
        <div class="layout4 comdetail homedetail endetail">
            <!--            <div class="layout_top">
                            <p>
                                <a href="{$web_root}/" class="logo" title="个人中心 - 职讯"></a>
                            </p>
                        </div>-->
            <div class="layout_mid dborder">
                <div class="ly_m_l">
                    <div class="module_1 c">
                        <div class="photo">
                            <div class="pho_shd_r">
                                <img class="big" src="{$company.photo}" alt="{$company.name}" id="cuid" uid="{$company.user_id}"/>
                            </div>                           
                        </div>
                         <div class="detailc comp">
                            <div class="c_detail c">                                
                                <span class="green">{$jcount}</span>
                                <span class="gray">职位数</span>                                                                
                            </div>
                            <div class="c_detail">                                
                                <span class="green">{$company.view}</span>
                                <span class="gray">主页访问数</span>
                            </div>
                        </div>
                        <div class="aginfo">
                            <div class="myfollow rf">                                
                                <div class="check_m btn_common btn17">
                                    <span class="lf"></span>
                                    <span class="rf"></span>
                                    <span class="jia"></span>
                                    <a href="javascript:;" title="加关注" id="add_focus" uid="{$company.user_id}" class="mdetail btn" uname="{$company.name}">加关注</a>                                          
                                </div>                                                                          
                            </div>
                            <div class="identify">
                                <span class="blue _cname" id="name" title="{$company.name}">{$company.name}</span>
                                <span class="gray">企业</span>                                                              
                                <if condition="$company.real_auth eq 1">
                                    <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                                 <else/><img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                                </if>
                                <if condition="$company.phone_auth eq 1">
                                    <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                                 <else/><img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                                </if>
                                <if condition="$company.email_auth eq 1">
                                    <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>
                                 <else/><img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                                </if>                                
                                <a href="javascript:;" id="report_c" title="举报" uid="{$company.user_id}" class="complain gray"><span class="_m">&nbsp;</span>举报</a>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <div></div>                       
                        <a class="blue user_url" href="{$web_root}/{$company.user_id}">{$web_root}/{$company.user_id}</a>
                        <div class="baseinfo c lf">
                            <p class="baseinfo_t">
                                <span class="gray">性质 :</span>&nbsp;&nbsp;
                                <span>{$company.category}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="gray">所在地 :</span>&nbsp;&nbsp;
                                <span>{$company.location}</span>
                            </p>
                            <div class="item">
                                <p class="gray">简介 :&nbsp;&nbsp;</p>
                                <p class="detail">{$company.summary}</p>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <if condition="$company.summary neq ''">
<!--                        <a href="javascript:;" class="checkmore" id="checkmore" uid="{$company.user_id}">查看全部简介></a>-->
                        </if>
                        <p class="clr"></p>
                    </div>
                </div>
            </div>
            <div class="layout_mid dborder">
                <div class="ly_m_l">
                    <div class="ops_filter" id="talfilter">
                        <span>招聘中的职位：</span>
                        <span class="filt_type">
                            <a href="javascript:;" class="red" tp="0">不限</a>
                            <b>/</b>
                            <a href="javascript:;" tp="2">兼职</a>
                            <b>/</b>
                            <a href="javascript:;" tp="1">全职</a>
                        </span>
                    </div>
                    <ul class="mlist hgstemp" id="joblist">
                        <empty name="job">
                             <li class="no-data">暂无数据!</li>
                         </empty>
                        <foreach name="job" item="vo">
                            <li>
                            <!--                            兼职start-->
                            <if condition="$vo.category eq 2">
                                <div class="lf info">
                                    <p>
                                        <span class="red">[兼职]</span>
                                        <a href="{$web_root}/office/{$vo.id}" class="blue jtitle" target="_blank" jid="{$vo.id}">{$vo.title}</a>
                                        <span class="gray">(发布于 {$vo.date})</span>
                                    </p>
                                    <p><span class="gray">证书使用地: </span>
                                        <span>{$vo.location}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                <!--                            兼职end-->                            
                                <!--                            全职start-->  
                                <elseif condition="$vo.category eq 1"/>
                                <div class="lf info">
                                    <p>
                                        <span class="red">[全职]</span>
                                        <a href="{$web_root}/office/{$vo.id}" class="blue jtitle" target="_blank" jid="{$vo.id}">{$vo.title}</a>
                                        <span class="gray">(发布于 {$vo.date})</span>
                                    </p>
                                    <p>
                                        <span class="gray">招聘岗位: </span>
                                        <span>{$vo.name}</span> 
                                    </p>
                                    <p>
                                        <span class="gray">工作地点: </span>
                                        <span>{$vo.location}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="gray">学历要求: </span>
                                        <span>{$vo.degree}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="gray">招聘人数: </span>
                                        <span>{$vo.count}人</span> 
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
                                <!--                            全职end-->  
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
                    <div id="pagination1" rel="{$job_count}" class="pages"></div>
                </div>
            </div>
        </div>
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
