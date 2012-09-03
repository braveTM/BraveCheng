<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>我要推广 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/promote_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">28</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
       <!-- layout::{$bheader}::0 -->
       <div class="layout1 promote">
           <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::Public:anav::0 -->
                </div>
            </div>
           <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li><a href="javascript:;">账户推广</a></li>
                            <li><a href="javascript:;">任务推广</a></li>
                        </ul>
                         <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">我的推广</a>
                        </div>
                    </div>
                </div>
                <div class="module_3 mod bder hidden">
                    <div class="pa_use">
                        <if condition="empty($promote_record_list)">
                            <p class="red">您暂时未使用任何推广</p>
                        </if>
                        <foreach name="promote_record_list" item="promote_record">
                        <p class="using">您目前使用的推广：</p>
                            <div class="promot_item">
                                <span class="promot_lf">{$promote_record.promote_title}</span>
                                <span class="promote_mf">¥ <b class="red">{$promote_record.promote_price}</b> /周</span>
                                <span class="promot_rf"><b class="red">{$promote_record.end_time}到期</b></span>
                            </div>
                        </foreach>
                    </div>
                    <div class="avaible_pac">
                        <p class="using">可选推广位：</p>
                        <div class="hgstemp" id="promo">
                        </div>
                        <div id="Pagination" class="pagination"></div>
                         <div class="btn_common btn3 getpromo">
                                <span class="b_lf"></span>
                                <span class="b_rf"></span>
                                <a href="javascript:void(0);" id="getpromo" class=" btn blue">立即抢占</a>
                         </div>
                         <div class="directions gray">
                            <p>在您点击"立即抢占"推广后，推广位所需费用将会在您的职讯钱包里被扣除;如果抢占失败，页面会自动刷新，您还可以抢占剩余的推广位，如果您还有什么疑问,请查看"账户推广"的相关说明;您也可拨打职讯网客服电话400-2323-2334进行咨询。</p>
                        </div>
                   </div>
                    <div class="clr"></div>
                </div>
               <div class="module_4 bder mod hidden">
                    <div class="pa_use">
                        <p class="using">您目前已使用的推广：</p>
                        <foreach name="promote" item="item">
                            <div class="promot_item">
                                <span class="record">{$item.name}</span>
                                <span class="total_count">共计<b class="red">{$item.count_num}</b>条</span>
                                <span class="in_using">
                                    <if condition="$item.count eq -1"> <b class="red">所有标红任务正在使用</b>
                                        <else/><b class="red">{$item.count}</b>条正在使用
                                    </if>
                                </span>
                                <span class="chec_in">可在任务管理里<a href="{$web_root}/mtask/" title="查看" class="blue" label="{$item.id}">查看</a></span>
                            </div>
                        </foreach>
                    </div>
                   <div class="avaible_pac">
                       <p class="using">任务推广方式：<span class="method_tip">(可在<a href="{$web_root}/mtask/" title="" class="blue">任务管理</a>或是在<a href="{$web_root}/taskpub/" title="发布任务" class="blue">发布任务</a>后进行推广设置)</span></p>
                       <foreach name="promote_method" item="method">
                           <div class="promot_item">
                                <span class="record">{$method.name}</span>
                                <span class="total_count">¥ <b class="red">{$method.price}</b> /天·条</span>
                                <span class="in_using">{$method.period}</span>
                                <span class="chec_in">{$method.description}</span>
                            </div>
                       </foreach>
                   </div>
               </div>
            </div>
       </div>
       <div class="clr"></div>
        <!-- layout::Public:comtool::60 -->
      <!-- layout::Public:footersimple::60 -->
    </body>
</html>
