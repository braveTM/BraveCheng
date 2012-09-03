<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>职讯网 - 中国建筑职业平台 - 专注于建筑行业的求职招聘</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/index_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$js_root}/{$jqlib}/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">0</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::Home:Public:ie6::60 -->
        <div class="tp_hder">
            <div class="tp_ct">
                <span class="gray lf">服务热线：<span class="red">028-85333199</span></span>
<!--                <div class="cus_serverice">
                         WPA Button Begin 
                        <script type="text/javascript" src="http://static.b.qq.com/account/bizqq/js/wpa.js?wty=1&type=1&kfuin=800020229&ws=www.zhixun.me&btn1=%E5%9C%A8%E7%BA%BF%E5%AE%A2%E6%9C%8D&aty=0&a=&key=%5B%3ETeWbVc%09%3FU3TfP%3BQ8Tk%04%3EP7%088%07a%01eU7%0Ae%021So"></script>
                     WPA Button END 
                </div>-->
                <a href="{$web_root}" class="rf" title="职讯网">职讯网</a>
                <a href="{$web_root}/feedback" class="rf stp" title="建议反馈">建议反馈</a>
            </div>            
        </div>
        <div class="clr"></div>
        <div class="pheader">
            <a href="{$web_root}/" title="职讯"><p class="logo lf"></p></a>
            <p class="clr"></p>
            <ul>
                <li><a href="{$web_root}/" class="cur_a">首 页</a></li>
                    <li><a href="{$web_root}/search_job">找职位</a></li>
                <li><a href="{$web_root}/news/">行业资讯</a></li>
                <li><a href="{$web_root}/clogin/">企业服务</a></li>
            </ul>
        </div>
        <div class="pnav">
            <div class="login_cont">
                <div class="slider" id="slider">
                    <ul id="py">
                        <li class="cur l1" rel="1">
                            <img src="{$voc_root}/imgs/index/slide1.png" alt="赚积分，换套餐,零成本，为您的业务锦上添花" />
                        </li>
                        <li rel="2" class="l2">
                            <img src="{$voc_root}/imgs/index/slide2.png" alt="登录就赚钱，从此不再有淡季" />
                        </li>
                    </ul>
                </div>
                <div class="lwrp">
                    <div class="lp">
                    <ul class="slidindex">
                        <li class="s1 sel" rel="0"></li>
                        <li class="s2" rel="1"></li>
                        <!--                        <li class="s3" rel="2"></li>-->
                    </ul>
                    <div class="login_box hidden">
                        <div class="title">登录职讯<span class="red" id="err_msg"></span></div>
                        <div class="txt_cont">
                            <span class="lf">帐号：</span>
                            <input type="text" value="" class="lf" id="uname"/>
                            <span class="tipmsg">电子邮箱/手机</span>
                        </div>
                        <div class="txt_cont">
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
                        <div class="ureg">
                            <div class="btn6 btn_common ta lf">
                                <span class="lf"></span>
                                <a href="{$web_root}/tregister" class="btn white">人才注册</a>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="main">
            <div class="ser_box">
                <div class="lf sl_in">
                    <input type="text" id="inbox" class="sbox lf gray" value="请输入您要找的职位"/>
                    <a  class="sbtn" id="spo" href="javascript:;">搜索职位</a>
                    <p class="clr"></p>
                    <p class="hot">
                        <span class="gray">热搜关键词：</span>
                        <foreach name="hot_keyword" item="hk">
                            <a href="{$web_root}/search_job?word={$hk[keyword]}" class="blue">{$hk[keyword]}</a>
                        </foreach>
                    <a href="{$web_root}/search_job/1" class="rf advance blue">高级搜索</a>
                    </p>                    
                </div>
                <div class="rf stotal">
                    <span class="lf gray">
                        周统计：
                    </span>
                    <div class="num lf">
                        <span class="red">{$new_job_count}</span>
                        <p>新增职位</p>
                     </div>
                    <div class="num lf">
                        <span class="red">{$new_resume_count}</span>
                        <p>新增简历</p>
                    </div>
                </div>
            </div>
            <p class="clr"></p>
            <!--职位-->
            <div class="wrp_com hot_pos">
                <div class="title gray">
                    <h2 class="tl lf">
                        <span class="gl">热点职位招聘</span>
                    </h2>
                    <span class="rf">
                        <a href="{$web_root}/search_job" class="blue mor" title="查看更多">查看更多<em class="moe mor_ma"></em></a>
                    </span>
                </div>
                <div class="hotlist lf">
                    <div class="ht ">
                        <span class="ptl">标题</span>
                        <span class="ppl">地点</span>
                        <span class="pmon">薪资待遇</span>
                    </div>
                    <foreach name="left_hot_job" item="lh">
                        <if condition="$key eq 0">
                            <div class="lpt tbg">
                            <elseif condition="$key eq 2" />
                            <div class="lpt tbg">
                            <elseif condition="$key eq 4" />
                            <div class="lpt tbg">
                            <else /> <div class="lpt">
                        </if>
                        <span class="ptl"><a href="{$web_root}/office/{$lh.job_id}" target="_blank"class="blue">{$lh.job_title}</a></span>
                        <if condition="$lh.job_category eq '1'">
                            <span class="ppl">{$lh.job_province_code}</span>
                            <else /><span class="ppl">{$lh.C_use_place}</span>
                        </if>
                        <span class="pmon red">¥ {$lh.job_salary} 万/年</span>
                        </div>
                    </foreach>
                </div>
                <div class="hotlist rf hr">
                    <div class="ht">
                        <span class="ptl">标题</span>
                        <span class="ppl">地点</span>
                        <span class="pmon">薪资待遇</span>
                    </div>
                    <foreach name="right_hot_job" item="rh">
                     <if condition="$key eq 0">
                            <div class="lpt tbg">
                            <elseif condition="$key eq 2" />
                            <div class="lpt tbg">
                            <elseif condition="$key eq 4" />
                            <div class="lpt tbg">
                            <else /> <div class="lpt">
                     </if>
                        <span class="ptl"><a href="{$web_root}/office/{$rh.job_id}" target="_blank"class="blue">{$rh.job_title}</a></span>
                        <if condition="$lh.job_category eq '1'">
                            <span class="ppl">{$lh.job_province_code}</span>
                            <else /><span class="ppl">{$lh.C_use_place}</span>
                        </if>
                        <span class="pmon red">¥ {$rh.job_salary} 万/年</span>
                    </div>
                    </foreach>
                </div>
            </div>   
            <p class="clr"></p> 
            <!--企业-->
            <div class="wrp_com area_enter">
                <div class="title gray">
                    <h2 class="tl lf">
                        <span class="gl">热门企业招聘</span>
                    </h2>
                    <span class="rf">
                        <a href="{$web_root}/eregister" class="blue mor" title="企业,立即入驻">企业,立即入驻<em class="moe mor_ma"></em></a>
                    </span>
                </div>
                <p class="clr"></p>
                <ul class="hgstemp" id="fenterprise">
                    <foreach name="company" item="co">
                        <li>
                            <div class="box_ct">
                                <div class="m_bg">
                                    <div class="mid">
                                        <div class="bot"><p></p></div>
                                    </div>
                                </div>
                            </div>
                            <div class="img_bg">
                                <div class="img_box">
                                    <div class="img_top">
                                        <p><a href="{$web_root}/{$co.id}" title="{$co.name}" class="blue">{$co.name}</a></p>
                                    </div>
                                    <img src="{$co.logo}" alt="{$co.name}"/>
                                    <div class="img_bot">
                                        <foreach name="co.jobs" item="job">
                                            <p class="gray"><a href="{$web_root}/office/{$job.id}" title="{$job.name}">{$job.name}</a></p>
                                        </foreach>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </foreach>
                </ul>
            </div>
            <div class="clr"></div>
            <!--人才-->
            <div class="wrp_com">
                <div class="wp-l lf">
                    <div class="title gray">
                        <h2 class="tl lf">
                            <span class="gl">高级建筑人才</span>
                        </h2>
                        <span class="rf">
                            <a href="{$web_root}/tregister" class="mor blue" title="人才,立即入驻">人才,立即入驻
                                <em class="moe mor_ma"></em></a>
                        </span>
                    </div>
                    <div class="clr"></div>
                    <div class="talens t_com">
                        <span class="t_nm">姓名</span>
                        <span class="t_cert">证书</span>
                        <span class="t_mony">期望薪资</span>
                    </div>
                    <foreach name="human" item="ta">
                        <div class="list_tl t_com">
                            <span class="t_nm"><a href="{$web_root}/{$ta.id}/" class="blue">{$ta.name}</a></span>
                            <span class="t_cert">{$ta.cert}</span>
                            <if condition="$ta.salary neq '面议'">
                                <span class="t_mony red">¥ {$ta.salary} 万/年</span>
                                <else /><span class="t_mony red"> 面议 </span>
                            </if>
                        </div>
                    </foreach>
                </div>
                <div class="wp-r rf mzx">
                    <div class="rtitle">
                        <h2 class="lf">行业热点资讯</h2>
                        <span class="rf">
                            <a href="{$web_root}/articles/0/2" class="blue" title="更多">更多 <em class="moe mor_info"></em></a>
                        </span>
                    </div>
                    <div class="clr"></div>
                    <ul>
                        <foreach name="article" item="at">
                            <li>
                                <span class="red">·</span><a href="{$web_root}/article/0/{$at.blog_id}" class="blue" title="{$at.title}">{$at.title}</a>
                            </li>
                        </foreach>
                    </ul>
                </div>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
            <!--猎头-->
            <div class="wrp_com aget_area">
                <div class="wp-l lf">
                    <div class="title gray">
                        <h2 class="tl lf">
                            <span class="gl">推荐猎头</span>
                        </h2>
                        <span class="rf">
                            <a href="{$web_root}/aregister" class="blue mor" title="猎头,立即入驻">猎头,立即入驻<em class="moe mor_ma"></em></a>
                        </span>
                    </div>
                    <div class="clr"></div>
                    <div class="awp">
                        <foreach name="agent" item="ag">
                            <if condition="$key lt 7">
                                <div class="Lp">
                                    <a href="{$web_root}/{$ag.id}" target="_blank" title="{$ag.name}">
                                        <img src="{$ag.photo}" alt="" class="small">
                                        <span class="blue">{$ag.name}</span>
                                    </a>
                                </div>
                                <elseif condition="$key eq 7"/>
                                <div class="Lp Lp_lst">
                                    <a href="{$web_root}/{$ag.id}" target="_blank" title="{$ag.name}">
                                        <img src="{$ag.photo}" alt="" class="small">
                                        <span class="blue">{$ag.name}</span>
                                    </a>
                                </div>
                            </if>
                        </foreach>
                    </div>
                </div>
                <div class="wp-r rf">
                    <div class="rtitle">
                        <h2 class="lf">职场经验</h2>
                        <span class="rf">
                            <a href="{$web_root}/articles/0/1" class="blue" title="更多">更多 <em class="moe mor_info"></em></a>
                        </span>
                    </div>
                    <div class="clr"></div>
                    <ul class="slit">
                        <foreach name="blog" item="zc">
                            <li>
                                <span class="red">·</span><a href="{$web_root}/article/1/{$zc.blog_id}" title="{$zc.title}" class="blue">{$zc.title}</a>
                            </li>
                        </foreach>
                    </ul>
                </div>
                <div class="clr"></div>
            </div>
            <div class="links wrp_com">
                <h2 class="title">
                    友情链接
                </h2>
                <a href="http://bbs.shenlvse.com/" target="_blank"  title="绿色建筑论坛">绿色建筑论坛</a>
                <a href="http://gansujianzhu.5d6d.net/" target="_blank"  title="中国建工网">中国建工网</a>                                      
            </div>
        </div>
        <div class="clr"></div>
        <!---------------------------footer--------------------------->
        <div class="copyright simple_footer index">
            <div class="_index">
            <ul>
                <li><a class="blue" href="{$web_root}/about/" target="_blank">职讯简介</a></li><span>|</span>
                <li><a class="blue" href="{$web_root}/privacy/" target="_blank">隐私协议</a></li><span>|</span>
                <li><a class="blue" href="{$web_root}/joinus/" target="_blank">招贤纳士</a></li><span>|</span>
                <li><a class="blue" href="{$web_root}/help/" target="_blank">帮助中心</a></li><span>|</span>
                <li><a class="blue" href="{$web_root}/contactus/" target="_blank">联系我们</a></li><span>|</span>
                <li><a class="blue" href="{$web_root}/links/" target="_blank">友情链接</a></li><span>|</span>
                <li class="lst_li"><a class="blue" href="{$web_root}/feedback/" target="_blank">建议反馈</a></li>
            </ul>
            <p>Copyright©2011 zhixun.me 版权所有 蜀ICP备12005810号</p>
            <div class="cus_serverice">
                <!-- WPA Button Begin -->
                <script type="text/javascript" src="http://static.b.qq.com/account/bizqq/js/wpa.js?wty=1&type=1&kfuin=800020229&ws=www.zhixun.me&btn1=%E5%9C%A8%E7%BA%BF%E5%AE%A2%E6%9C%8D&aty=0&a=&key=%5B%3ETeWbVc%09%3FU3TfP%3BQ8Tk%04%3EP7%088%07a%01eU7%0Ae%021So"></script>
                <!-- WPA Button END -->
            </div>
            </div>
        </div>

        {$indexjs}
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fe264b810956d7c30b6a5c72b077f9afb' type='text/javascript'%3E%3C/script%3E"));
</script>
    </body>
</html>
