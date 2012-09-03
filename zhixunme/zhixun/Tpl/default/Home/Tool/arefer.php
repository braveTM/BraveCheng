<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>受理发证信息查询 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/tool_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">94</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <if condition="$login eq 1">
        <!-- layout::{$bheader}::0 -->
        <else/>
        <div class="bdheader" id="bdheader">
            <!-- layout::Public:n_header::0 -->
        </div>
        </if>
        <div class="layout1 contract refers arefer">
            <div class="t_title"> 
                <p class="name">受理发证信息查询</p>
                <p class="liner"></p>
            </div>
            <div id="refs" class="refs">
                <span class="rtitle gray">查询分类: </span>
                <!--                受理发证信息查询-->
                <a href="#19" class="a_refer red">工程建设项目招标代理机构资格核准</a>
                <a href="#20" class="a_refer p_refer">建筑业企业资质核准</a>
                <a href="#21" class="a_refer p_refer">监理企业资质核准</a>
                <a href="#22" class="a_refer l_refer">建设工程勘察企业资质核准</a>
                <a href="#23" class="a_refer">建设工程设计企业资质核准</a>
                <a href="#24" class="a_refer">设计施工一体化资质核准</a>
            </div>
            <p id="ref_cover" class="ref_cover"></p>
            <p id="ref_loadding" class="ref_loadding"></p>
            <iframe name="iframeid" class="iframeid" id="iframeid" curcls="" src="" scrolling="no" frameborder="0"></iframe>
            <div id="nolimit" class="nolimit">
                对不起，暂不支持火狐浏览器的查询，您可以选择IE浏览器、谷歌浏览器或者其他高级浏览器！
            </div>
        </div>
        <div class="clr"></div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
