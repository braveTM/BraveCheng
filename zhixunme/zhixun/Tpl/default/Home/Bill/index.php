<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>我的账户 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/bill_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/pagination/pagination.css"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">9</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 bill">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::{$z_left}::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_3">
                    <a href="javascript:;" id="ipost_task"></a>
                    <div class="sm_tab">
                        <ul>
                            <li><a class="cur_a" href="javascript:;">账户充值</a></li>
                            <li><a href="javascript:;">账单明细</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">我的钱包</a>
                        </div>
                    </div>
                    <div class="t_container">
                        <div class="t_item recharge hidden">
                            <form action='{$web_root}/do_recharge/' method='post' target="_blank" onsubmit="return BillController.h();">
                                <div class="u_info">
                                    <span class="u_title">用户名: </span>
                                    <span class="u_input">{$page.name}</span>
                                </div>
                                <div class="u_info">
                                    <span class="u_title">可用金额: </span>
                                    <span class="u_input red">{$page.cash}&nbsp;</span>元
                                    <span class="gray">(一次充值金额不能少于5元)</span>
                                </div>
                                <div class="u_info">
                                    <span class="u_title">充值金额: </span>
                                    <input type="text" class="u_input" name="money" id="money"/>元
                                </div>
                                <p class="title">请选择支付方式:</p>
                                <div class="pay_way" id="pay_way">
                                    <ul class="cg">
                                        <foreach name="payments" item="mode">
                                            <if condition="$key eq 0">
                                                <li class="cur_li">
                                                    <div>
                                                        <input type="radio" checked name="type" value="{$mode.id}" class="hidden"/>
                                                        <img src="{$mode.icon}" class="pay" alt=""/>
                                                    </div>
                                                    <span class="pointer"></span>
                                                </li>
                                                <else />
                                                <li>
                                                    <div>
                                                        <input type="radio" name="type" value="{$mode.id}" class="hidden"/>
                                                        <img src="{$mode.icon}" class="pay" alt=""/>
                                                    </div>
                                                </li>
                                            </if>
                                        </foreach>
                                        <if condition="$payments eq 0">
                                            <li>
                                                <div>
                                                    <input type="radio" name="type" value="{$mode.id}" class="hidden"/>
                                                    <img src="{$file_root}/Files/system/payment/postmoney.png" class="pay"alt=""/>
                                                </div>
                                                <span class="pointer"></span>
                                            </li>
                                            <else />
                                            <li>
                                                <div>
                                                    <input type="radio" name="type" value="{$mode.id}" class="hidden"/>
                                                    <img src="{$file_root}Files/system/payment/pay_remittance.png" class="pay" alt=""/>
                                                </div>
                                            </li>
                                        </if>
                                    </ul>
                                    <div class="clr"></div>
                                </div>
                                <foreach name="payments" item="mode">
                                    <div class="mod hidden">
                                        <div class="m1">
                                            {$mode.text}
                                            <div class="chrbtn" id="chrbtn_cont">
                                                <div class="btn_common btn5">
                                                    <span class="b_lf"></span>
                                                    <span class="b_rf"></span>
                                                    <input type="submit" id="chrbtn" class="btn white" value="立即支付"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </foreach>
                                <div class="clr"></div>
                                <div class="mod hidden">
                                    <div class="info fs">
                                        <span class="comom gray">第<em>1</em>步:</span>
                                        <p class="des fs">请点击 "线下支付" 按钮生成订单编号</p>
                                        <div class="g_n btn_common btn4_common btn4">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" id="gen_nm" class="btn white">线下支付</a>
                                        </div>
                                        <div class="odr hidden">------您的订单编号为<em class="red"></em></div>
                                    </div>
                                    <div class="info">
                                        <span class="comom gray">第<em>2</em>步:</span>
                                        <p class="des">请到附近银行网点将款项打入下述我公司指定的银行帐号</p>
                                    </div>
                                    <div class="info">
                                        <span class="comom gray">第<em>3</em>步:</span>
                                        <p class="des">将银行转帐底单以及第一步生成的订单编号传真至职讯网客服中心 <em class="gray">(</em><span class="red"> 028-85333199 </span><em class="gray">)</em>,<br/>收到传真后我们将为您办理相关业务。</p>
                                    </div>
                                    <div class="clr"></div>
                                    <div class="bk">
                                        <div class="lf icbc">
                                            <div class=" lf ic_lg"></div>
                                            <div class="lf devsion"></div>
                                        </div>
                                        <div class="lf ac_detail">
                                            <p>
                                                <span class="gray">开户名:</span>
                                                <span>邓翔匀</span>
                                            </p>
                                            <p>
                                                <span class="gray">帐&nbsp;&nbsp;&nbsp;号:</span>
                                                <span>6222 0244 0205 0049 463</span>
                                            </p>
                                            <p>
                                                <span class="gray">开户行:</span>
                                                <span>中国工商银行航空路支行</span>
                                            </p>
                                        </div>
                                        <div class="clr"></div>
                                        <div class="l_sdow"></div>
                                        <div class="r_sdow"></div>
                                        <div class="t_ad"></div>
                                    </div>
                                    <p>尊敬的客户, 您可以到以下地址进行 <span class="green">现金缴费</span></p>
                                    <p class="gray">成都市驰骋职讯信息技术有限公司</p>
                                    <p class="gray">联系电话: 028-85333199</p>
                                    <p class="gray">联系地址: 四川省成都市高新区天府软件园D5-DB044</p>
                                </div>
                            </form>
                            <p class="directions gray">
                                如果您通过在线支付充值账户, 成功后资金会立刻划拨到您的职讯钱包;通过在线支付充值出现任何问题,可拨打职讯网客服电话028-85333199进行处理。
                            </p>
                        </div>
                        <div class="t_item hidden">
                            <div class="filter" id="my_bill">
                                类别:
                                <input type="radio" value="0" name="bltype" checked="true" id="bltype1"/><label for="bltype1">全部</label>
                                <input type="radio" value="1" name="bltype" id="bltype2"/><label for="bltype2">收入</label>
                                <input type="radio" value="2" name="bltype" id="bltype3"/><label for="bltype3">支出</label>
                            </div>
                            <div class="mcols mcols_title">
                                <div class="f_cl">详细</div>
                                <div class="s_cl">金额</div>
                                <div class="t_cl">时间</div>
                                <div class="clr"></div>
                            </div>
                            <ul id="mybilllist" class="mcols hgstemp">
                                <li class="loading">
                                    <p></p>
                                </li>
                            </ul>
                            <div id="pagination" class="pages">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clr"></div>
        <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>
