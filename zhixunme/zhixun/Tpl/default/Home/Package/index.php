<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>我的套餐 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/package_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">25</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 package">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::{$z_left}::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <if condition="$has eq 1">
                                <li><a href="javascript:;">统计·续费</a></li>
                                <li><a href="javascript:;">购买套餐</a></li>
                                <else/>
                                <li class="cur_li"><a href="javascript:;">套餐管理</a></li>
                            </if>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">我的套餐</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <if condition="$has eq 1 && $newc.free eq 1">
                            <div class="t_item pstat hidden">
                                <p class="title">您当前的套餐为<span class="red"> 免费版 </span> ，套餐剩余项统计如下：</p>
                                <elseif condition="$has eq 1"/>
                            <div class="t_item pstat hidden">
                                <p class="title">您购买的<span class="red"> {$current.title} </span> ,剩余条数统计如下：</p>
                        </if>
                        <if condition="$has eq 1">
                                <table>
                                    <tr class="tr_one">
                                        <td class="one"></td>
                                        <td class="two">共计</td>
                                        <td class="three">剩余</td>
                                    </tr>
                                    <foreach name="current.modules" item="cur">
                                    <tr>
                                            <td class="one">{$cur.name}</td>
                                        <switch name="cur.t_count">
                                            <case value="-1">                            
                                            <td class="two">不限</td>
                                            <td class="three">不限</td>
                                            </case>
                                            <default/>
                                            <td class="two">{$cur.t_count}</td>
                                            <td class="three">{$cur.s_count}</td>
                                        </switch>
                                    </tr>
                                    </foreach>
                                </table>
                        </if>
                        <if condition="$has eq 1 && $newc.free neq 1">
                                <p class="rec_title">套餐续费方式选择 :</p>
                                <div class="filter_rec" id="filter_rec">
<!--                                    <input type="radio" name="rechr" id="rechr0" checked/><label for="rechr0">单项续费</label>-->
                                    <input type="radio" name="rechr" id="rechr1" checked/><label for="rechr1">全项续费</label>
                                </div>
                                <elseif condition="$has eq 1"/>
                         </if>
                        <if condition="$has eq 1 && $newc.free neq 1">
                                <!--                                单项续费-->
<!--                                <div class="rechr_item">
                                    <p class="trigg"></p>
                                    <p class="tit_tip">友情提示：单项续费，使用期限不变，次数或分钟数将累加到您现在使用的套餐对应单项中。</p>
                                    <table class="sin_rechr">
                                        <tr>
                                            <td class="ltd">续费项 :</td>
                                            <td>
                                                <select id="schr_item">                                               
                                                 <foreach name="current.modules" item="curm"> 
                                                    <option value="{$curm.id}">{$curm.name}</option>
                                                  </foreach>                                             
                                                    <option value="8">电话拨打分钟数</option>
                                                </select>
                                                <span class="gray"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ltd" valign="top"></td>
                                            <td>
                                                <input type="text" id="scr_use"/><span class="unit"></span>
                                                <span class="gray"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ltd">续费结果 :</td>
                                            <td><span id="chr_res"></span></td>
                                        </tr>
                                    </table>
                                    <div class="chrbtn">
                                        <div class="btn_common btn5">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a id="scharge_now" class="btn white">立即续费</a>
                                        </div>
                                    </div>
                                </div>-->
                        </if>
                        <if condition="$has eq 1 && $newc.free neq 1">
                                <!--                                全项续费-->
                                <div class="rechr_item">
                                    <p class="trigg"></p>
                                    <p class="tit_tip f_rec">友情提示：全项续费，使用期限将从新套餐开始计算，之前套餐剩余次数将自动累加到对应项中。</p>
                                    <div class="now_pac">
                                        <p class="lf">{$newc.title} :</p>
                                        <div class="lf">
                                            <foreach name="newc.modules" item="cur"> 
                                                <span class="tit_pac">{$cur.name}</span>
                                                <if condition="$cur.s_count lt 0">
                                                    <span>不限</span>
                                                    <else /><span>+{$cur.s_count} {$cur.unit}</span>
                                                </if>                                                
                                            </foreach>
                                        </div>
                                        <p class="clr"></p>
                                    </div>
                                    <div class="now_pac">
                                        <p class="lf">所需金额 :</p>
                                        <div class="lf">
                                            <span class="red">{$current.price}</span> 元
                                        </div>
                                        <p class="clr"></p>
                                    </div>
                                    <div class="chrbtn">
                                        <div class="btn_common btn5">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a id="fcharge_now" class="btn white" score="{$current.price}">立即续费</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <elseif condition="$has eq 1"/>
                            </div>
                        </if>
                        <if condition="$has eq 0">
                            <div class="t_item mpack show">
                                <else/>
                                <div class="t_item mpack hidden">
                                    </if>
                                    <if condition="$has eq 1 && $newc.free neq 1">
                                        <p class="title">您购买的<span class="red"> {$current.title} </span> 套餐将于 <span class="red">{$current.date}</span> 结束,共计剩余 <em class="red">{$current.days}</em> 天,您可更换/续费您的套餐 :</p>
                                        <elseif condition="$has eq 1 && $newc.free eq 1"/>
                                        <p class="title">您当前的套餐为<span class="red"> 免费版 </span> ，您可以更换您的套餐 :</p>
                                    </if>
                                    <div class="slide">
                                        <a href="javascript:;" class="ctr lctr"></a>
                                        <a href="javascript:;" class="ctr rctr"></a>
                                        <span class="shad lshad"></span>
                                        <span class="shad rshad"></span>
                                        <ul id="pac_items">
                                            <li class="loading" style="opacity:1;background: none;width:90%;">
                                                <p></p>
                                            </li>
                                            <foreach name="list" item="l">
                                                <li>
                                                    <div class="top"><p></p></div>
                                                <if condition="$l.use eq 1">
                                                    <p class="isbuy"></p>
                                                </if>    
                                                <if condition="$l.recom neq ''">
                                                    <p class="isrec"></p>
                                                </if>
                                                <div class="mid_bg">
                                                    <div class="mid">
                                                        <p class="name">----- {$l.title} -----</p>
                                                        <p class="score"><span>￥{$l.price}</span> </p>
                                                        <foreach name="l.modules" item="t">
                                                            <if condition="$t.count lt 0">
                                                                <p class="item">不限<span> - {$t.name}</span></p>
                                                            <else/>
                                                            <p class="item">{$t.count}<span> {$t.unit} - {$t.name}</span></p>
                                                            </if>
                                                        </foreach>                                                        
                                                    </div>
                                                </div>
                                                <div class="bot"><p></p></div>
                                                <if condition="$l.use eq 1">
<!--                                                    <div class="oper oper_l">
                                                        <a href="javascript:;" class="srenew" pid="{$l.id}">单项续费</a>
                                                    </div>-->
                                                    <div class="oper">
                                                        <a href="javascript:;" class="renew" pid="{$l.id}">全项续费</a>
                                                    </div>
                                                    <else/>
                                                    <div class="oper">
                                                        <a href="javascript:;" class="buynow" pid="{$l.id}">立即购买</a>
                                                    </div>
                                                </if>
                                                </li>
                                            </foreach>
                                            <li>
                                                <div class="top"><p></p></div>
                                                <p class="isbuy isgive"></p>
                                                <div class="mid_bg">
                                                    <div class="mid">
                                                        <p class="name">----- {$free.title} -----</p>
                                                        <p class="score"><span>￥{$free.price}</span> </p>
                                                        <foreach name="free.modules" item="t">
                                                            <if condition="$t.s_count lt 0">
                                                                <p class="item">不限<span> - {$t.name}</span></p>
                                                            <else/>
                                                            <p class="item">{$t.s_count}<span> - {$t.name}</span></p>
                                                            </if>
                                                        </foreach>
                                                    </div>
                                                </div>
                                                <div class="bot"><p></p></div>                   
                                                </li>
                                        </ul>
                                        <p class="clr"></p>
                                    </div>
                                    <div class="intro">
                                        <p>套餐更换/续费说明：</p>
                                        <p>· 对已购买的套餐续费,购买的服务项次数将累计</p>
                                        <p>· 更换套餐,将清零之前购买的服务项次数</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
        </div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
