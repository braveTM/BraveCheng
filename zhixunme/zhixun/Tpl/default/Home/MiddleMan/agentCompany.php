<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>猎头管理 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>        
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/manageagent_1.0.css"/> 
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">114</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!--企业首页 -->
        <!-- layout::Public:amheader::0 -->
        <div class="layout1 acindex">
            <div class="layout1_l">
                <!-- layout::Public:amnav::0 -->
            </div>
            <div class="layout1_r">
                <div class="module_2">        
                    <div class="seebydt">
                        <ul>
                            <li class="today">
                                <div class="adb btn_common btn btn21">
                                    <span class="lf"></span>
                                    <span class="rf"></span>
                                    <a href="javascript:;" class="btn blue" rel="1">今天</a>
                                </div>
                            </li>
                            <li class="step">
                                <div class="adb btn_common btn btn21 lf">
                                    <span class="lf"></span>
                                    <span class="rf"></span>
                                    <a href="javascript:;" id="prev" class="btn" rel="2"><</a>
                                </div>                                    
                            </li>
                            <li class="step">
                                <div class="adb btn_common btn btn21 lf">
                                    <span class="lf"></span>
                                    <span class="rf"></span>
                                    <a href="javascript:;" id="next" class="btn gray stop"  rel="3">></a>
                                </div>
                            </li>
                            <li id="date" class="dt">{$daytime}</li>
                            <li class="selstep">
                               按<a href="javascript:;" class="sel" rel="4">天</a>/<a class="blue" rel="5" href="javascript:;">周</a>/<a rel="6"  class="blue"  href="javascript:;">月</a>查看
                            </li>
                        </ul>                                                                        
                    </div>
                    <div class="clr"></div>
                    <div class="counthd" id="sort">
                        <ul>
                            <li class="tdh">成员</li>
                            <li class="gray p pres" rels="public_resume">公开简历<a class="down" rel="0"></a></li>
                            <li class="gray p pjob" rels="public_job">公开职位<a class="down" rel="0"></a></li>
                            <li class="gray p patc" rels="public_article">发布文章<a class="down" rel="0"></a></li>
                            <li class="gray p brcount" rels="page_view">主页浏览量<a class="down" rel="0"></a></li>
                            <li class="gray logtime">登录时间</li>
                            <li class="gray extime">下线时间</li>
                            <li class="gray freeze">冻结帐号</li>
                        </ul>
                    </div>                  
                    <div class="memberdata" id="members">
                        <ul class="count">                            
                            <li class="hd">总计</li>
                            <li>{$result.total_resume}</li>
                            <li>{$result.total_job}</li>
                            <li>{$result.total_article}</li>
                            <li>{$result.total_view}</li>
                            <li class="logtime">-</li>
                            <li class="extime">-</li>
                            <li class="freeze">-</li>
                        </ul>
                        <div id="member" class="hgstemp">
<!--                        <ul class="member">
                            <li class="mk off"></li>
                            <li class="photo">
                                <a href="#" target="_blank"><img src="" /></a>
                                <a href="#" target="_blank" class="name blue">张老师</a>
                            </li>
                            <li class="ct">78</li>
                            <li class="ct">39</li>
                            <li class="ct">02</li>
                            <li class="ct">32</li>
                            <li class="ct logtime">6-29 18:56</li>
                            <li class="ct extime">6-29 18:56</li>
                            <li class="ct freeze"><a href="javascript:;" class="blue off">立即冻结</a></li>
                        </ul>                        
                        <div class="border dinfo hidden">
                            <div class="detail lf ">                            
                                <ul class="resudata">
                                    <li><h4 class="gray" >简历数据分析</h4></li>
                                    <li><em class="gray lf">查看简历:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">公开简历:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">投递的简历:</em><em class="c">110</em>个</li>
                                </ul> 
                                <ul class="jobdata">
                                    <li><h4 class="gray">职位数据分析</h4></li>
                                    <li><em class="gray lf">查看职位:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">公开职位:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">委托来的职位:</em><em class="c">110</em>个</li>
                                </ul> 
                                <ul class="artdata">
                                    <li><h4 class="gray">文章数据分析</h4></li>
                                    <li><em class="gray lf">浏览总数:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">赞总数:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">分享总数:</em><em class="c">110</em>个</li>
                                </ul> 
                            </div>
                        </div>
                        <ul class="member">
                            <li class="mk"></li>
                            <li class="photo">
                                <a href="#" target="_blank"><img src="" /></a>
                                <a href="#" target="_blank" class="name blue">张老师</a>
                            </li>
                            <li class="ct">78</li>
                            <li class="ct">39</li>
                            <li class="ct">02</li>
                            <li class="ct">32</li>
                            <li class="ct logtime">6-29 18:56</li>
                            <li class="ct extime">6-29 18:56</li>
                            <li class="ct freeze">
                                                                <a href="javascript:;" class="blue off">立即冻结</a>
                                <a href="javascript:;" class="blue on"><span class="gray">已冻结|</span>解冻</a>
                            </li>
                        </ul>
                        <div class="border dinfo hidden">
                            <div class="detail lf ">                            
                                <ul class="resudata">
                                    <li><h4 class="gray" >简历数据分析</h4></li>
                                    <li><em class="gray lf">查看简历:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">公开简历:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">投递的简历:</em><em class="c">110</em>个</li>
                                </ul> 
                                <ul class="jobdata">
                                    <li><h4 class="gray">职位数据分析</h4></li>
                                    <li><em class="gray lf">查看职位:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">公开职位:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">委托来的职位:</em><em class="c">110</em>个</li>
                                </ul> 
                                <ul class="artdata">
                                    <li><h4 class="gray">文章数据分析</h4></li>
                                    <li><em class="gray lf">浏览总数:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">赞总数:</em><em class="c">110</em>个</li>
                                    <li><em class="gray lf">分享总数:</em><em class="c">110</em>个</li>
                                </ul> 
                            </div>
                        </div>-->
                     </div>
                    </div>
                    <div id="pages" class="page rf"></div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>