<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>单位资质查询 - {$title}</title>
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
        <div class="layout1 contract refers">
            <div class="t_title">
                <p class="name">单位资质查询</p>
                <p class="liner"></p>
            </div>
            <div id="refs" class="refs">
                <span class="rtitle gray">查询分类: </span>
                <a href="#0" class="a_refer red">设计施工一体化企业</a>
                <a href="#1" class="a_refer">建设工程勘察企业</a>
                <a href="#2" class="a_refer">建设工程设计企业</a>
                <a href="#3" class="a_refer">工程监理企业</a>
                <a href="#4" class="a_refer">工程建设项目招标代理机构</a>
                <a href="#5" class="a_refer">建筑业企业</a>
<!--                <a href="#6" class="a_refer">外商投资城市规划服务企业</a>-->
                <a href="#7" class="a_refer">城市规划编制单位</a>
                <a href="#8" class="a_refer">工程造价咨询企业</a>
                <a href="#9" class="a_refer">房地产开发企业</a>
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
