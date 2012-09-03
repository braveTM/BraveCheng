<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>注册 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/regis_area_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">45</script>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::Home:Public:ie6::60 -->
        <div class="regis_page pub_page">
            <div class="pub_top">
                <div class="p_t_txt">
                    <a href="{$web_root}" title="职讯网首页">
                        <img src="{$file_root}zhixun/Theme/default/vocat/imgs/system/wlogo.png" alt=""/>
                    </a>
                    <a href="{$web_root}/login/" title="登录" class="white">登录</a>
                    <a href="{$web_root}/aregister/" title="猎头注册" class="white role">猎头注册</a>
                    <a class="white">|</a>
                    <a href="{$web_root}/eregister/" title="企业注册" class="white">企业注册</a>
                    <a class="white">|</a>
                    <a href="{$web_root}/tregister/" title="人才注册" class="white">人才注册<em class="cur_role"></em></a>
                </div>
            </div>
            <div class="pub_mid">
                <div class="p_m_top">
                    <p class="p_m_l lf"></p>
                    <p class="p_m_r rf"></p>
                </div>
                <div class="p_m_mid">
                    <div class="p_m_mid_bg">
                        <div class="regis_box_l">
                            <div class="module_1 treg">
                                <h2 class="role_title">人才注册</h2>
                                <div class="reg_ops">
                                    <ul>
                                        <li class="cur_li"><a href="javascript:;" title="手机号码注册">手机号码注册</a></li>
                                        <li><a href="javascript:;"title="电子邮箱注册">电子邮箱注册</a></li>
                                    </ul>
                                </div>
                                <div class="t_container">
                                    <div class="t_item show">
                                        <table cellpadding="0" cellspacing="0" class="t_b t_c">
                                            <tr>
                                                <td class="t_l ltop">
                                                    <span class="red">*</span> 手机号码:
                                                </td>
                                                <td class="lrt">
                                                    <div>
                                                        <input type="text" value="" id="u_phone" />
                                                        <span class="gray">完成注册后,手机号码将作为您的登录帐号</span>
                                                    </div>
                                                    <div class="send">
                                                        <div class="btn_common sd btn9">
                                                            <span class="b_lf"></span>
                                                            <span class="b_rf"></span>
                                                            <a href="javascript:;" id="v_send" class="btn btn_normal"><strong class="gray hidden" id="countDown">(<em class="ftx-01">1</em>)秒后可重新获取验证码</strong><em class="gtcode">免费获取验证码</em></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="t_l">
                                                    <span class="red">*</span> 手机验证码:
                                                </td>
                                                <td class="vfy">
                                                    <input type="text" value="" id="pber" class="u_valid" />
                                                    <span>如果长时间未收到验证码，请尝试选择：<a href="javascript:;" class="blue exchange" title="电子邮箱注册">电子邮箱注册</a></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    <span class="red">*</span> 创建密码:
                                                </td>
                                                <td>
                                                    <div><input type="password" value="" id="ft_pd"/></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    <span class="red">*</span> 重复密码:
                                                </td>
                                                <td>
                                                    <div><input type="password" value="" id="ftco_pd"/></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    <span class="red">*</span> 真实姓名:
                                                </td>
                                                <td>
                                                    <div><input type="text" value="" id="ft_name"/></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    资质证书:
                                                </td>
                                                <td>
                                                    <div><input class="mselect qual_select" type="text" id="jqual_select" readonly/></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    职称证书:
                                                </td>
                                                <td>
                                                    <div><input class="mselect" type="text" id="jtitle_selt" readonly/></div>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="post_6 ">
                                            <input name="rule" type="checkbox" class="agree" checked="true" />
                                            <a  class="rule blue" href="{$web_root}/agreement/" target="_blank" title="职讯网服务协议">我已阅读并接受《职讯网服务协议》</a>
                                        </div>
                                        <div class="p3">
                                            <div class="u_n btn5 btn_common ">
                                                <span class="b_lf"></span>
                                                <span class="b_rf"></span>
                                                <a  class="btn white" id="phone_next" href="javascript:;">立即注册</a>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="t_item hidden">
                                        <table cellpadding="0" cellspacing="0" class="t_b t_c">
                                            <tr>
                                                <td class="t_l">
                                                    <span class="red">*</span> 登录邮箱:
                                                </td>
                                                <td>
                                                    <div><input type="text" value="" id="u_emil"/></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    <span class="red">*</span> 创建密码:
                                                </td>
                                                <td>
                                                    <div><input type="password" value="" id="u_pd"/></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    <span class="red">*</span> 重复密码:
                                                </td>
                                                <td>
                                                    <div><input type="password" value="" id="co_pd"/></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    <span class="red">*</span> 真实姓名:
                                                </td>
                                                <td>
                                                    <div><input type="text" value="" id="u_tname"/></div>
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td class="t_l">
                                                    资质证书:
                                                </td>
                                                <td>
                                                    <div><input class="mselect qual_select" type="text" id="equal_select" readonly/></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    职称证书:
                                                </td>
                                                <td>
                                                    <div><input class="mselect" type="text" id="etitle_selt" readonly/></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="t_l">
                                                    <span class="red">*</span> 验证码:
                                                </td>
                                                <td>
                                                    <input type="text" value="" id="u_valid" class="u_valid lf" />
                                                    <span>
                                                        <img src="{$web_root}/rvcode" alt="点击换一张" title="点击换一张" id="valid_img" class="v_r lf" />
                                                    </span>
                                                    <a href="javascript:;" title="" class="blue lf v_c" id="val_anoth">换一张</a>
                                                    <div class="clr"></div>
                                                </td>
                                            </tr>
                                        </table>
                                        <p class="red valid_tip"></p>
                                        <div class="post_6 ">
                                            <input name="aggree" type="checkbox" class="agree" checked="true" />
                                            <a  class="rule blue" href="{$web_root}/agreement/" target="_blank" title="职讯网服务协议">我已阅读并接受《职讯网服务协议》</a>
                                        </div>
                                        <div class="p3">
                                            <div class="u_n btn5 btn_common ">
                                                <span class="b_lf"></span>
                                                <span class="b_rf"></span>
                                                <a  class="btn white" id="u_next" href="javascript:;">立即注册</a>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="p_m_bot">
                    <p class="p_m_l lf"></p>
                    <p class="p_m_r rf"></p>
                </div>
            </div>
            <!-- layout::Public:footeregister::60 -->
        </div>
    </body>
</html>
