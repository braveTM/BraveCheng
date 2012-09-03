<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>找职位 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/fjob_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">4</script> 
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!--行业资讯页 -->
        <!-- layout::Home:Public:ie6::60 -->
        <div class="info_hder">
            <div class="tp_ct">
                <span class="gray lf">服务热线：</span><span class="red lf">028-85333199</span>
                <if condition="$user['name']">
                    <a href="{$web_root}/user_exit" title="安全退出" id="exit" class="rf">[安全退出]</a>
                    <span href="javascript:;" class="rf gray">{$user['name']},您好!</span>
                    <else/>
                    <div class="cus_serverice">
                        <!-- WPA Button Begin -->
                        <script type="text/javascript" src="http://static.b.qq.com/account/bizqq/js/wpa.js?wty=1&type=1&kfuin=800020229&ws=www.zhixun.me&btn1=%E5%9C%A8%E7%BA%BF%E5%AE%A2%E6%9C%8D&aty=0&a=&key=%5B%3ETeWbVc%09%3FU3TfP%3BQ8Tk%04%3EP7%088%07a%01eU7%0Ae%021So"></script>
                        <!-- WPA Button END -->
                    </div>
                    <a href="{$web_root}/tregister/" title="注册" class="rf">注册</a>
                    <a href="{$web_root}/login/" title="登录" class="rf">登录</a>
                </if>
            </div>
        </div>
        <div class="clr"></div>
        <div class="pheader">
            <a href="{$web_root}/" title="职讯"><p class="logo lf"></p></a>
            <p class="clr"></p>
            <ul>
                <if condition="$user['name']">
                    <li><a href="{$web_root}/news/" class="cur_a">找职位</a></li>
                    <li><a href="{$web_root}/news/" class="cur_a">行业资讯</a></li>
                    <li><a href="{$web_root}/homepage/">返回个人中心</a></li>
                    <else/>
                    <li><a href="{$web_root}/">首 页</a></li>
                    <li><a href="{$web_root}/search_job" class="cur_a">找职位</a></li>
                    <li><a href="{$web_root}/news/">行业资讯</a></li>
                    <li><a href="{$web_root}/clogin/">企业服务</a></li>
                </if>
            </ul>
        </div>      
        <div class="layout2 fjob">
            <div class="layout2_l">
                <!--热点职位搜索-->
                <div class="module_1">
                    <div class="info_title">热点职位搜索</div>
                    <div class="job_search">
                        <div class="se_box">
                            <div class="kws">
                            <input type="text" class="gray lf" rel="{$pre_condition[word]}" value="<if condition="empty($pre_condition[word])">请输入您要找的职位<else/>{$pre_condition[word]}</if>" id="keywords" />
                            </div>                
                            <a class="se_btn white lf" id="search" href="javascript:;"></a>
                            <if condition="empty($pre_condition[salary]) && empty($pre_condition[pub_date]) && empty($pre_condition[require_place]) && $pre_condition[super] neq 1">
                                <a href="javascript:;" class="lf blue  m" id="se_advance"><em>+</em>高级搜索</a>
                                <elseif condition="$pre_condition[super] eq 1"/><a href="javascript:;" class="lf blue" id="se_advance"><em>-</em>高级搜索</a>
                                <else/><a href="javascript:;" class="lf blue" id="se_advance"><em>-</em>高级搜索</a>
                            </if>                            
                            <div class="clr"></div>
                        </div>
                        <div class="hot_words" id="hotwords">
                            <span class="gray">热门关键词：</span>                         
                            <foreach name="hot_keyword" item="vo">
                                <a href="{$web_root}/search_job?word={$vo[keyword]}">{$vo[keyword]}</a>
                            </foreach>                            
                        </div>
                        <if condition="empty($pre_condition[salary]) && empty($pre_condition[pub_date]) && empty($pre_condition[require_place]) && $pre_condition[super] neq 1">
                            <ul class="se_more hidden"  id="advance">
                        <elseif condition="$pre_condition[super] eq 1"/>
                            <ul class="se_more"  id="advance">
                        <else/>
                            <ul class="se_more"  id="advance">
                        </if>                        
                            <li><span class="gray">要求地区：</span>
                                <input id="place" type="text" class="mselect" value="{$pre_condition[require_place_name]}" />
                                <input id="pid" type="hidden" value="{$pre_condition[require_place]}" />
                            </li>
                            <li class="salary">
                                <span class="gray">薪资待遇：</span>                               
                                <a href="javascript:;" rel="0" <if condition="$pre_condition[salary] eq 0"> class="sel"</if> >全部</a>
                                <a href="javascript:;" rel="1" <if condition="$pre_condition[salary] eq 1"> class="sel"</if> >0-3万</a>
                                <a href="javascript:;" rel="2" <if condition="$pre_condition[salary] eq 2"> class="sel"</if> >3-5万</a>
                                <a href="javascript:;" rel="3" <if condition="$pre_condition[salary] eq 3"> class="sel"</if> >5-15万</a>
                                <a href="javascript:;" rel="4" <if condition="$pre_condition[salary] eq 4"> class="sel"</if> >15-30万</a>
                                <a href="javascript:;" rel="5" <if condition="$pre_condition[salary] eq 5"> class="sel"</if> >30-100万</a>
                                <a href="javascript:;" rel="6" <if condition="$pre_condition[salary] eq 6"> class="sel"</if> >100万+</a>
                                <a href="javascript:;" rel="7" <if condition="$pre_condition[salary] eq 7"> class="sel"</if> >面议</a>
                            </li>
                            <li class="pub_date">
                                <span class="gray">发布时间：</span>
                                <a href="javascript:;" <if condition="$pre_condition[pub_date] eq 0"> class="sel"</if> rel="0">全部</a>
                                <a href="javascript:;" <if condition="$pre_condition[pub_date] eq 1"> class="sel"</if>  rel="1">1周内</a>
                                <a href="javascript:;" <if condition="$pre_condition[pub_date] eq 2"> class="sel"</if>  rel="2">半月内</a>
                                <a href="javascript:;" <if condition="$pre_condition[pub_date] eq 3"> class="sel"</if>  rel="3">1月内</a>
                                <a href="javascript:;" <if condition="$pre_condition[pub_date] eq 4"> class="sel"</if>  rel="4">6个月内</a>
                                <a href="javascript:;" <if condition="$pre_condition[pub_date] eq 5"> class="sel"</if>  rel="5">1年内</a>
                            </li>
                        </ul>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                    <div class="se_result">
                        <div class="header" id="pos_list">
                            <span class="gray lf">排序方式:</span>
                            <switch name="pre_condition[order]" >                                    
                                    <case value="1">
                                        <a  href="javascript:;" rel="0">默认</a>
                                        <a class="sel count" href="javascript:;">浏览数<em  class="down" rel="1"></em></a>
                                        <a href="javascript:;">薪资待遇<em class="up" rel="3"></em><em class="down" rel="2"></em></a>
                                        <a href="javascript:;">发布时间<em class="up" rel="5"></em><em class="down" rel="4"></em></a>
                                    </case>
                                    <case value="2">
                                        <a  href="javascript:;" rel="0">默认</a>
                                        <a class="count_gray count" href="javascript:;">浏览数<em  class="down" rel="1"></em></a>                                       
 
                                        <a href="javascript:;"class="sel">薪资待遇<em class="up_hov" rel="3"></em><em class="down_sel" rel="2"></em></a>
                                        <a href="javascript:;">发布时间<em class="up" rel="5"></em><em class="down" rel="4"></em></a>
                                    </case>
                                    <case value="3">
                                        <a  href="javascript:;" rel="0">默认</a>
                                        <a class="count_gray count" href="javascript:;">浏览数<em  class="down" rel="1"></em></a>
                                        <a href="javascript:;"class="sel">薪资待遇<em class="up_sel" rel="3"></em><em class="down_hov" rel="2"></em></a>
                                        <a href="javascript:;">发布时间<em class="up" rel="5"></em><em class="down" rel="4"></em></a>
                                    </case>
                                    <case value="4">
                                        <a  href="javascript:;" rel="0">默认</a>
                                        <a class="count_gray count" href="javascript:;">浏览数<em  class="down" rel="1"></em></a>
                                        <a href="javascript:;">薪资待遇<em class="up" rel="3"></em><em class="down" rel="2"></em></a>
                                        <a href="javascript:;" class="sel">发布时间<em class="up_hov" rel="5"></em><em class="down_sel" rel="4"></em></a>
                                    </case>
                                    <case value="5">
                                        <a  href="javascript:;" rel="0">默认</a>
                                        <a class="count_gray count" href="javascript:;">浏览数<em  class="down" rel="1"></em></a>
                                        <a href="javascript:;">薪资待遇<em class="up" rel="3"></em><em class="down" rel="2"></em></a>
                                        <a href="javascript:;" class="sel">发布时间<em class="up_sel" rel="5"></em><em class="down_hov" rel="4"></em></a>
                                    </case>
                                    <default  />
                                        <a class="sel" href="javascript:;" rel="0">默认</a>
                                        <a class="count_gray count" href="javascript:;">浏览数<em  class="down" rel="1"></em></a>
                                        <a href="javascript:;">薪资待遇<em class="up" rel="3"></em><em class="down" rel="2"></em></a>
                                        <a href="javascript:;">发布时间<em class="up" rel="5"></em><em class="down" rel="4"></em></a>
                                </switch>                            
                            <span id="authuser" <if condition="$pre_condition[is_real_auth] eq 2 || empty($pre_condition[is_real_auth])">class="auth cancel lf"<else/>class="auth lf"</if>><em></em>认证用户</span>
                            <span id="cert" <if condition="$pre_condition[cert_type] eq 2 || empty($pre_condition[cert_type])">class="auth cancel lf"<else/>class="auth lf"</if>><em></em>资质证书</span>            
                            <switch name="search_page_count" >
                                <case value="0"></case>
                                <case value="1"></case>
                            <default  />
                            <if condition="empty($pre_condition[page]) || $pre_condition[page] eq 1">
                                <a href="javascript:;" class="rf" id="next">></a>
                                <a href="javascript:;" class="rf gray" id="prev"><</a>      
                                <span class="pages rf">1/{$search_page_count}</span>
                                <elseif condition="$search_page_count eq $pre_condition[page]"/>
                                <a href="javascript:;" class="rf gray" id="next">></a>
                                <a href="javascript:;" class="rf" id="prev"><</a>      
                                <span class="pages rf">{$pre_condition[page]}/{$search_page_count}</span>
                                <else/>
                                <a href="javascript:;" class="rf" id="next">></a>
                                <a href="javascript:;" class="rf" id="prev"><</a>      
                                <span class="pages rf">{$pre_condition[page]}/{$search_page_count}</span>
                            </if>    
                            </switch>
                            <div class="clr"></div>
                        </div>                     
                        <div id="joblist" class="se_list">
                            <ul>
                                <if condition="empty($search_result)">
                                    <li class="no-data gray">暂无数据</li>
                                </if>
                                <foreach name="search_result" item="job">                               
                                       <li>
                                        <div class="lf photo">
                                            <a href="{$web_root}/{$job.publisher_id}" target="_blank" title="{$job.publisher_name}">
                                                <img src="{$job.publisher_photo}" class="psmall" alt="{$job.publisher_name}">
                                            </a>
                                            <div class="identify">
                                                <if condition="$job.real_auth eq 1">                                                                                                        
                                                    <span class="lf"><a class="blue" href="{$web_root}/{$job.publisher_id}" target="_blank">{$job.publisher_name}</a></span>                                                    
                                                    <img class="lit_small" src="{$file_root}Files/system/auth/ab.png" title="已实名认证">
                                                 <else/>                                                 
                                                 <span><a href="{$web_root}/{$job.publisher_id}" class="blue" target="_blank">{$job.publisher_name}</a></span>                                                 
                                                </if>                                                    
                                                <div class="clr"></div>
                                            </div>
                                        </div>
                                        <!--兼职 START-->
                                    <if condition="$job.job_category eq 2">
                                        <div class="lf info">
                                            <p class="first"><span class="red">[兼职]</span><a href="{$web_root}/office/{$job.job_id}" class="blue jtitle" target="_blank" jid="28875567"> {$job.job_title} </a></p>
                                            <foreach name="job.RC_list" item="qa">
                                                <p><span class="gray">证书情况: </span><span>{$qa}</span></p>
                                            </foreach>
                                            <p><span class="gray">证书使用地: </span><span class="place">{$job.C_use_place}</span>
                                                <span class="gray">地区要求: </span><span>{$job.require_place}</span></p>                                          
                                            <p class="own"><span class="gray">来源: </span>
                                                <if condition="$job.publisher_role eq 3"><!--猎头-->
                                                    <span class="resou">猎头</span>
                                                    <elseif condition="$job.publisher_role eq 2"/><!--企业-->
                                                    <span class="resou">企业</span>
                                                </if>                                                
                                                <span class="gray">发布时间:</span>
                                                <span class="date">{$job.pub_datetime}</span>
                                            </p>
                                        </div>                                                                                                  
<!--                                        兼职 END-->

<!--                                        全职 START-->
                                        <elseif condition="$job.job_category eq 1" />
                                        <div class="lf info">
                                            <p  class="first"><span class="red">[全职]</span>
                                                <a href="{$web_root}/office/{$job.job_id}" class="blue jtitle" target="_blank" jid=""> {$job.job_title} </a>                                  
                                            </p>
                                            <foreach name="job.RC_list" item="qa">
                                                <p><span class="gray">证书情况: </span><span>{$qa}</span></p>
                                            </foreach>                                            
                                            <p><span class="gray">招聘岗位: </span><span>{$job.job_name}</span></p>
                                            <p><span class="gray">工作地点: </span><span class="place">{$job.job_province_code}</span>&nbsp;&nbsp;&nbsp;
                                                <span class="gray">学历要求: </span><span>{$job.degree}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="gray">招聘人数: </span><span>{$job.job_count}人</span></p>                                                  
                                            <p class="own"><span class="gray">来源: </span>
                                                <if condition="$job.publisher_role eq 3"><!--猎头-->
                                                    <span class="resou">猎头</span>
                                                    <elseif condition="$job.publisher_role eq 2"/><!--企业-->
                                                    <span class="resou">企业</span>
                                                </if>
                                                <span class="gray">发布时间:</span>
                                                <span class="date">{$job.pub_datetime}</span></p>
                                        </div>
                                    </if>
                                    <!--全职 END-->                                        
                                    <div class="rf oper">
                                        <if condition="$job.job_salary eq '面议'">
                                            <p class="face">
                                                <span class="red big">{$job.job_salary}</span>
                                            <else/>
                                            <p>
                                                <span class="red">¥</span>
                                                <span class="red big">{$job.job_salary}</span>
                                                <span class="red">万/年</span>
                                            </if>                                          
                                            </p>
                                        <div class="btn_common lbtn btn22">
                                            <span class="b_lf"></span><span class="b_rf"></span>
                                            <a href="{$web_root}/office/{$job.job_id}" target="_blank" class="btn white uoper">查看详细</a>
                                        </div>
                                    </div>
                                    <div class="clr"></div>
                                    </li>     
                                </foreach>
                            </ul>
                            <input type="hidden" name="total" value="{$search_count}" />
                            <input type="hidden" name="cpge" value="{$pre_condition[page]}" />                            
                            <div id="pagination" class="pages"></div>
                            <div class="clr"></div>
                        </div>                            
                    </div>
                </div>
            </div>
            <div class="layout2_r">
                <!--登陆职讯-->
                <div class="module_2">
                    <div class="login_box">
                        <div class="title">登录职讯<span class="red" id="err_msg"></span></div>
                        <div class="txt_cont">
                            <span class="lf">帐号：</span>
                            <input type="text" value="" class="lf" id="uname"/>
                            <span class="tipmsg">电子邮箱/手机</span>
                        </div>
                        <div class="txt_cont sec">
                            <span class="lf">密码：</span>
                            <input type="password"  class="lf" value="" id="upsd"/>
                            <span class="tipmsg">密码</span>
                            <a href="{$web_root}/forgot" title="找回密码" class="fpsd">
                                <span class="psdes blue">忘记密码?</span>
                            </a>                        
                        </div>
                        <div>
                            <a href="javascript:;" class="login_btn rf" id="login" ru="{$redirect}"></a>
                            <div class="rec_psd lf"><input type="checkbox" name="cache" checked="true" id="cache"/><label for="cache" class="blue">下次自动登录</label></div>
                            <p class="clr"></p>
                        </div>
                    </div>
                    <p class="gray nac">还没有帐号？</p>
                    <div class="ureg">
                        <div class="btn6 btn_common ta lf">
                            <span class="lf"></span>
                            <a href="{$web_root}/tregister" class="btn white">人才免费注册</a>
                        </div>
                        <div class="btn6 btn_common agent lf">
                            <a href="{$web_root}/aregister" class="btn white">猎头注册</a>
                        </div>
                        <div class="btn6 btn_common enter lf">
                            <span class="rf"></span>
                            <a href="{$web_root}/eregister" class="btn white">企业注册</a>
                        </div>
                    </div>
                </div>
                <p class="clr"></p>
                <!--推荐企业职位-->
                <div class="module_3 recomed">
                    <div class="info_title recomy tlinfo">推荐企业职位</div>
                    <foreach name="company_job_list" item="comp">
                        <if condition="$key eq 3">
                            <div class="com_info mlst">
                        <else /><div class="com_info">
                        </if>
                        <img src="{$comp.logo}" class="mig" alt="{$comp.name}" />
                        <p>{$comp.name}</p>
                        <if condition="$comp.job_category eq 2">
                            <p><span class="red">[兼职]</span>
                            <else /><p><span class="red">[全职]</span>
                        </if>
                        <a href="{$web_root}/office/{$comp.job.id}" title="" class="blue">{$comp.job.name}</a></p>
                        </div>
                    </foreach>
                </div>
                <!--推荐猎头职位-->
                <div class="module_4 recomed">                                
                    <div class="info_title tlinfo">推荐猎头职位</div>
                    <foreach name="agent_job_list" item="aj">
                        <if condition="$key eq 5">
                         <div class="com_info mlst">
                        <else /><div class="com_info">
                        </if>
                        <div class="lf photo">
                            <a href="{$web_root}/{$aj.publisher_id}" target="_blank" title="">
                                <img src="{$aj.publisher_photo}" class="small" alt="{$aj.publisher_name}">
                            </a>
                        </div>
                        <div class="lf info">
                            <p class="head_info"><span><a href="{$web_root}/{$aj.publisher_id}" target="_blank">{$aj.publisher_name}</a></span>
                                <if condition="$aj.real_auth eq 1">
                                    <img src="{$file_root}Files/system/auth/ab.png"  alt="已未实名认证"/>
                                    <else />
                                </if>
                            </p>
                            <if condition="$aj.job_category eq 1">
                                <p><span class="red">[全职]</span>
                                <else /><p><span class="red">[兼职]</span>
                            </if>
                            <a href="{$web_root}/office/{$aj.job_id}" title="" target="_blank" class="blue">{$aj.job_title}</a></p>
                        </div>
                        <p class="clr"></p>
                        </div>
                    </foreach>
                </div>
            </div>
            <p class="clr"></p>
        </div>
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
