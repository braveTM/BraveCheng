<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>市场行情指导 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
         <link type="text/css" rel="stylesheet" href="{$voc_root}/css/tool_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">88</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <php>dump($login);</php>
        <if condition="$login eq 1">
        <!-- layout::{$bheader}::0 -->
        <else/>
        <div class="bdheader" id="bdheader">
            <!-- layout::Public:n_header::0 -->
        </div>
        </if>
        <div class="layout1  market">
            <div class="t_title">
                <p class="name">市场行情指导 - <span class="gn">年度走势</span></p>
                <p class="liner"></p>
            </div>
            <div class="mrap">
                <div class="myear">
                    <span class="b_lf"></span>
                    <div class="ys lf">
                        <span>
                            年份:
                        </span>  
                        <a href="javascript:;" title="2012年" class="cuy" rep="2012">2012年</a>
                        <a href="javascript:;" title="历年" class="pyears">历年趋势</a>
                    </div>
                    <span class="b_rf"></span>
                </div>
                <div class="clr"></div>
                <div id="mbox" style="width: 980px; height: 400px; margin: 0 auto"></div>
                <div class="tdes">
                    <input type="hidden" value="1" id="zid"/>
                    <span class="fl">上图为</span><input type="text" value="一级注册建造师-建筑工程" readonly id="quali_select" class="qselect blue mselect" /><span class="gray">(点击图标查看其他证书走势情况)</span>
                </div>
                <div class="area">
                <span class="lf">地区：</span>
                <div class="lf provs yp"> 
                     <foreach name="province" item="pv">
                     <if condition="$key eq 1"><span><a href="javascript:;" title="{$pv.name}" rel="{$pv.id}" class="blue cur_prov">
                     <else /><span><a href="javascript:;" title="{$pv.name}" rel="{$pv.id}" class="blue">
                     </if>
                     {$pv.name}</a></span>
                    </foreach>
                </div>
                <div class="clr"></div>
            </div>
            </div>
            <div class="t_title d_p">
                <p class="name">市场行情指导 - <span class="gn">本月交易价</span></p>
                <p class="liner"></p>
            </div>
            <div class="mrap">
               <div class="usch">
                   <span class="lf"></span>
                   <div class="sbox lf">
                       <input type="text" value="" class="" id="scont" />
                       <a class="blue" title="搜索" class="blue" id="sbtn">搜索</a>
                   </div>
                   <span class="rf"></span>
               </div>
               <div class="area">
                <span class="lf">地区：</span>
                  <div class="lf provs marea"> 
                    <foreach name="province" item="pv">
                     <if condition="$key eq 1"><span><a href="javascript:;" title="{$pv.name}" rel="{$pv.id}" class="blue cur_prov">
                     <else /><span><a href="javascript:;" title="{$pv.name}" rel="{$pv.id}" class="blue">
                     </if>
                     {$pv.name}</a></span>
                    </foreach>
                </div>
                <div class="clr"></div>
            </div>
            <ul id="marketlist" class="mktlist hgstemp">
            </ul>
            <p class="gray mark">注：以上价格有1-3千浮动偏差，仅供参考!</p>
            <div id="Pagination" class="pages">
                <div class="pagination">
                </div>
            </div>
          </div>
        </div>
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
