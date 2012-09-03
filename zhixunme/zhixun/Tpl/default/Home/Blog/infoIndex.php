<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>行业资讯 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/information_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">89</script> 
        <meta name='keywords' content='建筑行业新闻,职场经验,考证咨询,资质培训,政策法规,文件通知,{$kwds}'>
        <meta name='description' content='分享职场经验,了解建筑行业动态、考证咨询、资质培训、政策法规等信息。{$desc}'>
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
                    <li><a href="{$web_root}/news/" class="cur_a">行业资讯</a></li>
                    <li><a href="{$web_root}/homepage/">返回个人中心</a></li>
                    <else/>
                    <li><a href="{$web_root}/">首 页</a></li>
                    <li><a href="{$web_root}/search_job">找职位</a></li>
                    <li><a href="{$web_root}/news/" class="cur_a">行业资讯</a></li>
                    <li><a href="{$web_root}/clogin/">企业服务</a></li>
                </if>
            </ul>
        </div>
        <div class="layout2 information">
            <div class="layout2_l">
                <!--最新职场热文-->
                <div class="module_1">
                    <div class="info_title">最新职场热文<a href="{$web_root}/articles/0/1" title="更多最新职场热文" class="more" target="_blank">更多<em></em></a></div>
                    <ul class="hot_exp" id="exp_list">
                        <if condition="empty($newBlog)">
                            <p class="no-data">暂无数据</p>
                        </if>                        
                        <foreach name="newBlog" item="nb">
                            <li>
                                <div class="lf photo">
                                    <a href="{$web_root}/{$nb.creator_id}">
                                        <img src="{$nb.photo}" class="psmall" alt="{$nb.name}">
                                    </a>
                                    <div class="care_name"><a href="{$web_root}/{$nb.creator_id}" target="_blank" class="blue name">{$nb.name}</a></div>
                                </div>
                                <div class="lf info">
                                    <p><a href="{$web_root}/article/1/{$nb.blog_id}" title="{$nb.title}" target="_blank" class="blue">{$nb.title}</a></p>
                                    <div class="clr"></div>
                                    <div class="detail"> 
                                        <p class="des">{$nb.body}...</p>
                                        <div class="clr"></div>
                                    </div>
                                    <div class="b_bot"> 
                                        <span class="gray">发布时间:</span>
                                        <span>{$nb.create_datetime}</span>
                                        <span class="gray m_f">阅读数:</span>
                                        <span class="red">{$nb.read_count}</span>
                                        <span class="gray m_f">赞:</span>
                                        <span>{$nb.praise}</span>
                                        <span class="gray m_f">分享:</span>
                                        <span class="sare">
                                            <div class="shares">
                                                <a class="share shr_1" title="分享到新浪微博" tp="sina" tit="{$nb.title}" ur="{$web_root}/article/1/{$nb.blog_id}" href="javascript:;"></a>
                                                <a class="share shr_2"  title="分享到腾讯微博" tp="tencent" tit="{$nb.title}" ur="{$web_root}/article/1/{$nb.blog_id}" href="javascript:;"></a>
                                                <a class="share shr_3" title="分享到QQ空间" tp="qzone" tit="{$nb.title}" ur="{$web_root}/article/1/{$nb.blog_id}" href="javascript:;"></a>
                                                <p class="clr"></p>
                                            </div>
                                        </span>
                                        <a href="{$web_root}/article/1/{$nb.blog_id}" class="blue mall" title="[阅读全文]" target="_blank">[阅读全文]</a>
                                    </div>
                                </div>
                                <div class="clr"></div>
                            </li>
                        </foreach>
                    </ul>
                    <a href="{$web_root}/articles/0/1" title="点击阅读更多最新职场热文" class="blue more_read" target="_blank">点击阅读更多最新职场热文<em></em></a>
                </div>
            </div>
            <div class="layout2_r">
                <!--本周十大热文-->
                <div class="module_2">
                    <div class="info_title tlinfo">本周十大热文</div>
                    <ul class="s_list m3_list">
                        <if condition="empty($hot_blog_in_week)">
                            <p class="no-data">暂无数据</p>
                        </if>                        
                        <foreach name="hot_blog_in_week" item="hw">
                            <if condition="$key eq 0">
                                <li class="first">
                                <elseif condition="$key eq 1"/>
                                <li class="second">
                                <elseif condition="$key eq 2"/>
                                <li class="third">
                                <elseif condition="$key eq 9"/>
                                <li class="las">
                                <else /><li>
                            </if>
                            <span>{$hw.number}</span>
                            <a href="{$web_root}/article/1/{$hw.blog_id}" target="_blank"  class="blue" title="{$hw.title}">{$hw.title}</a>
                            </li>
                        </foreach>
                    </ul>
                </div>
                <!--发布排行榜-->
                <div class="module_3">
                    <div class="info_title tlinfo">发布排行榜</div>
                    <ul id="publist">
                        <if condition="empty($releaseblog)">
                            <p class="no-data">暂无数据</p>
                        </if>                        
                        <foreach name="releaseblog" item="vo" >
                            <if condition="$vo.key neq 1">
                                <li class="hover hidden">
                                <else /><li class="hover">
                            </if>                           
                            <if condition="$vo.key eq 1"><span class="red1 red">{$vo.key}</span>
                                <elseif condition="$vo.key eq 2"/><span class="red2 lf">{$vo.key}</span>    
                                <elseif condition="$vo.key eq 3"/><span class="red3 lf">{$vo.key}</span>        
                                <else /><span class="gray lf">{$vo.key}</span>
                            </if>
                            <div class="photo"><img src="{$vo.photo}" alt="{$vo.name}" /><a class="blue" href="javascript:;">{$vo.name}</a></div>
                            <div class="detail">
                                <a href="{$web_root}/article/1/{$vo.blog_id}" target="_blank"><h3 class="blue">{$vo.title}</h3></a>
                                <div class="gray">共发布<span class="red">{$vo.blog_count}</span>篇</div>
                                <div class="gray">被赞<span class="red">{$vo.praise}</span>次</div>                                                                
                            </div>
                            </li>
                            <if condition="$vo.key eq 1">
                                <li class="gray hidden">
                                <else /><li class="gray">
                            </if>                         
                            <if condition="$vo.key eq 1"><span class="red1 red">{$vo.key}</span>
                                <elseif condition="$vo.key eq 2"/><span class="red2">{$vo.key}</span>    
                                <elseif condition="$vo.key eq 3"/><span class="red3">{$vo.key}</span>        
                                <else /><span class="gray">{$vo.key}</span>
                            </if>
                            <span class="blue">{$vo.name}</span>(共发布<span class="red">{$vo.blog_count}</span>篇,被赞<span class="red">{$vo.praise}</span>次)
                            </li>
                        </foreach>                                            
                    </ul>
                </div>
<!--                广告位一 
                <div class="ads_1"></div>-->
            </div>
            <p class="clr"></p>
            <!--广告位二 -->
            <div class="ads_2">
                <if condition="$user['name']">
                    <img src="{$voc_root}/imgs/temp/ad1.png" />
                    <else/><a href="{$web_root}/login" target="_blank"><img src="{$voc_root}/imgs/temp/ad1.png" /></a>
                </if>                
            </div>
            <!--推荐职场经验-->
            <div class="module_4 lf">                                
                <div class="info_title">推荐职场经验<a href="{$web_root}/articles/0/3" title="更多推荐职场经验" class="more" target="_blank">更多<em></em></a></div>
                <ul>
                    <if condition="empty($recommendblog)">
                            <p class="no-data">暂无数据</p>
                    </if>                 
                    <volist name="recommendblog" id="vo" offset="0" length='1'>                        
                        <li class="first">
                            <a class="title" href="{$web_root}/article/1/{$vo.blog_id}" target="_blank"><h2 class="blue">{$vo.title}</h2></a>
                            <p>{$vo.body}...<a href="{$web_root}/article/1/{$vo.blog_id}" target="_blank" class="blue rf">[阅读全文]</a></p>                        
                        </li>
                    </volist>
                    <volist name="recommendblog" id="vo" offset="1" length='8'>
                        <li class="cont"><span class="red">·</span><a href="{$web_root}/article/1/{$vo.blog_id}" target="_blank" class="blue">{$vo.title}</a>
                            <span class="gray">(作者:{$vo.name}，阅读数:{$vo.read_count})</span>
                        </li>   
                    </volist>   
                    <div class="clr"></div>
                </ul>                             
            </div>
            <!--培训资讯-->
            <div class="module_5 rf">
                <div class="info_title">考证资讯<a href="{$web_root}/articles/0/2/12" title="更多考证咨询" class="more" target="_blank">更多<em></em></a></div>
                <ul>
                    <if condition="empty($trainArt)">
                            <p class="no-data">暂无数据</p>
                    </if>                    
                    <volist name="trainArt" id="vo" offset="0" length='1'>
                        <li class="first">                        
                            <img title="{$vo.title}" src="{$file_root}zhixun/Theme/default/vocat/imgs/temp/ad03.png" alt="" />
                            <a class="title" href="{$web_root}/article/0/{$vo.art_id}" target="_blank" ><h2 class="blue">{$vo.title}</h2></a>
                            <p>{$vo.body}...<a href="{$web_root}/article/0/{$vo.art_id}" target="_blank" class="blue rf">[阅读全文]</a></p>                        
                        </li>
                    </volist>
                    <volist name="trainArt" id="vo" offset="1" length='8'>                         
                        <li class="cont"><span class="red">·</span><a href="{$web_root}/article/0/{$vo.art_id}" target="_blank" class="blue">{$vo.title}</a>
                            <span class="gray">(作者:{$vo.name}，阅读数:{$vo.read_count})</span>
                        </li>   
                    </volist>
                </ul>                
            </div>
            <p class="clr"></p>
            <!--广告位三 -->
            <div class="ads_3">
                 <if condition="$user['name']">
                     <img src="{$voc_root}/imgs/temp/ad2.png" />
                     <else/><a href="{$web_root}/login" target="_blank"><img src="{$voc_root}/imgs/temp/ad2.png" /></a>
                 </if>                
            </div>
            <div class="layout2_l">
                <!--行业新闻-->
                <div class="module_6">
                    <div class="info_title">行业新闻<a href="{$web_root}/articles/0/2/11" title="更多行业新闻" class="more" target="_blank">更多<em></em></a></div>
                    <ul class="bcom" id="majinfo">
                        <foreach name="industryArt" item="inart">
                            <li>
                                <div class="lf bcount">
                                    <div class="cnber">{$inart.read_count}</div>
                                    <div class="cbg"></div>
                                    <div class="gray">浏览数</div>
                                </div>
                                <div class="lf bdetail">
                                    <div class="zx_title">
                                        <a href="{$web_root}/article/0/{$inart.art_id}" title="{$inart.title}" target="_blank" class="blue">{$inart.title}</a>
                                    </div>
                                    <div class="z_deil">{$inart.body}...</div>
                                    <div class="gray lf">
                                        <span>发布时间：</span>
                                        <span>{$inart.create_datetime}</span>
                                        <span class="pd">赞：</span>
                                        <span class="red">{$inart.praise}</span>
                                        <span class="pd">分享：</span>
                                        <div class="shares">
                                            <a class="share shr_1" title="分享到新浪微博" tp="sina" tit="{$inart.title}" ur="{$web_root}/article/0/{$inart.blog_id}" href="javascript:;"></a>
                                            <a class="share shr_2"  title="分享到腾讯微博" tp="tencent" tit="{$inart.title}" ur="{$web_root}/article/0/{$inart.blog_id}" href="javascript:;"></a>
                                            <a class="share shr_3" title="分享到QQ空间" tp="qzone" tit="{$inart.title}" ur="{$web_root}/article/0/{$inart.blog_id}" href="javascript:;"></a>
                                            <p class="clr"></p>
                                        </div>
                                    </div>
                                    <a class="blue rmore" href="{$web_root}/article/0/{$inart.art_id}" title="阅读全文" target="_blank">[阅读全文]</a>
                                    <div></div>
                                </div>
                                <p class="clr"></p>
                            </li>
                        </foreach>
                        <if condition="empty($industryArt)">
                            <p class="no-data">暂无数据</p>
                        </if>
                    </ul>
                    <a href="{$web_root}/articles/0/2/11" target="_blank" class="blue rdm" title="更多心得">点击，阅读更多行业新闻<em></em></a>
                </div>
            </div>
            <div class="layout2_r">
                <!--公示公告-->
                <div class="module_7 simlist">
                    <div class="info_title tlinfo">公示公告<a href="{$web_root}/articles/0/2/8" target="_blank" title="更多公示公告" class="more" >更多<em></em></a></div>
                    <div class="s_list">
                        <foreach name="publicityArt" item="p1">
                            <if condition="$key eq 0">
                                <a href="{$web_root}/article/0/{$p1.blog_id}" target="_blank" class="red" title="{$p1.title}">{$p1.title}</a>
                                <else/>
                                <a href="{$web_root}/article/0/{$p1.blog_id}" target="_blank" class="blue" title="{$p1.title}"><span class="red">·</span>{$p1.title}</a>
                            </if>
                        </foreach>
                        <if condition="empty($publicityArt)">
                            <p class="no-data">暂无数据</p>
                        </if>
                    </div>
                </div>
                <!--职讯帮助中心-->
                <div class="module_8 simlist">
                    <div class="info_title tlinfo">职讯帮助中心<a href="{$web_root}/help/" title="更多职讯帮助中心" class="more" target="_blank">更多<em></em></a></div>
                    <div class="s_list">
                        <foreach name="helpArt" item="p2">
                            <a href="{$web_root}/article/0/{$p2.blog_id}" target="_blank" class="blue" title="{$p2.title}"><span class="red">·</span>{$p2.title}</a>
                        </foreach>
                        <if condition="empty($helpArt)">
                            <p class="no-data">暂无数据</p>
                        </if>
                    </div>
                </div>
            </div>
            <p class="clr"></p>
            <!--广告位四 -->
            <div class="ads_4">
                <if condition="$user['name']">
                    <img src="{$voc_root}/imgs/temp/ad3.png" />
                    <else/><a href="{$web_root}/login" target="_blank"><img src="{$voc_root}/imgs/temp/ad3.png" /></a>
                </if>                
            </div>
            <!--政策法规-->
            <div class="module_9 lf simlist">
                <div class="info_title">政策法规<a href="{$web_root}/articles/0/2/10" target="_blank" title="更多政策法规" class="more" >更多<em></em></a></div>
                <div class="s_list b_list">
                    <foreach name="policyArt" item="p3">
                        <a href="{$web_root}/article/0/{$p3.blog_id}" class="blue"target="_blank"  title="{$p3.title}"><span class="red">·</span>{$p3.title}</a>
                    </foreach>
                    <if condition="empty($policyArt)">
                        <p class="no-data">暂无数据</p>
                    </if>
                </div>
            </div>
            <!--文件通知-->
            <div class="module_10 lf simlist">
                <div class="info_title">文件通知<a href="{$web_root}/articles/0/2/9" target="_blank" title="更多文件通知" class="more">更多<em></em></a></div>
                <div class="s_list b_list">
                    <foreach name="fileArt" item="p2">
                        <a href="{$web_root}/article/0/{$p2.blog_id}" target="_blank" class="blue" title="{$p2.title}"><span class="red">·</span>{$p2.title}</a>
                    </foreach>
                    <if condition="empty($fileArt)">
                        <p class="no-data">暂无数据</p>
                    </if>
                </div>
            </div>
            <!--媒体报道-->
            <div class="module_11 lf simlist">
                <div class="info_title b_list">媒体报道<a href="{$web_root}/articles/0/2/14" title="更多媒体报道" class="more" target="_blank">更多<em></em></a></div>
                <!--广告位五 -->
                <div class="ads_5"></div>
                <div class="s_list">
                    <foreach name="mediaArt" item="p2">
                        <a href="{$web_root}/article/0/{$p2.blog_id}" target="_blank" class="blue" title="{$p2.title}"><span class="red">·</span>{$p2.title}</a>
                    </foreach>
                    <if condition="empty($mediaArt)">
                        <p class="no-data">暂无数据</p>
                    </if>
                </div>
            </div>
            <p class="clr"></p>
            <!--广告位六 -->
            <div class="ads_6">
                <if condition="$user['name']">
                    <img src="{$voc_root}/imgs/temp/ad4.png" />
                    <else/><a href="{$web_root}/login" target="_blank"><img src="{$voc_root}/imgs/temp/ad4.png" /></a>
                </if>                
            </div>
        </div>
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>