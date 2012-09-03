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
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">47</script>  
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
                     <a href="{$web_root}/eregister/" title="企业注册" class="white">企业注册<em class="cur_role"></em></a>
                     <a class="white">|</a>
                     <a href="{$web_root}/tregister/" title="人才注册" class="white">人才注册</a>
                </div>
            </div>
            <div class="pub_mid">
                <div class="p_m_top">
                    <p class="p_m_l lf"></p>
                    <p class="p_m_r rf"></p>
                </div>
                <div class="p_m_mid">
                    <div class="p_m_mid_bg">
                        <div class="devsion">
                            <ul class="t_np">
                                <li class="t_01 cu_li"><b>1、</b>企业注册<div class="cur_ste"></div></li>
                                <li class="t_02 sgray"><b>2、</b>邮箱验证</li>
                                <li class="t_03 sgray"><b>3、</b>成功注册</li>
                            </ul>
                        </div>
                        <div class="clr"></div>
                        <div class="regis_box_l">
                            <div class="module_1 re_box">
                                <table cellpadding="0" cellspacing="0" class="t_b t_c">
                                    <tr>
                                        <td class="t_l">
                                            <span class="red">*</span>
                                            登录邮箱:
                                        </td>
                                        <td>
                                            <div><input type="text" value="" id="u_emil"/></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t_l">
                                            <span class="red">*</span>
                                            密码:
                                        </td>
                                        <td>
                                            <div><input type="password" value="" id="u_pd"/></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t_l">
                                            <span class="red">*</span>
                                            重复密码:
                                        </td>
                                        <td>
                                            <div><input type="password" value="" id="co_pd"/></div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="t_bp"></div>
                                <table cellpadding="0" cellspacing="0" class="t_b">
                                    <tr>
                                        <td class="t_l">
                                            <span class="red">*</span>
                                            企业名称:
                                        </td>
                                        <td>
                                            <div><input type="text" value="" id="sub_name"/></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t_l">
                                            <span class="red">*</span>
                                            企业性质:
                                        </td>
                                        <td>
                                            <select id="sub_attr">
                                                <option value="1">国有企业</option>
                                                <option value="2">集体企业</option>
                                                <option value="3">联营企业</option>
                                                <option value="4">股份合作制企业</option>
                                                <option value="5">私营企业</option>
                                                <option value="6">个体户</option>
                                                <option value="7">合伙企业</option>
                                                <option value="8">有限责任公司</option>
                                                <option value="9">股份有限公司</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t_l">
                                            <span class="red">*</span>
                                            企业注册地:
                                        </td>
                                        <td>
                                            <input type="hidden" name="t_prov" value=""/>
                                            <input type="hidden" name="t_city" value=""/>
                                            <div><input type="text" id="place" class="mselect" readonly value=""/></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t_l">
                                            <span class="red">*</span>
                                            联系人:
                                        </td>
                                        <td>
                                            <div><input type="text" value="" id="cont_p"/></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="t_l">
                                            联系人手机:
                                        </td>
                                        <td>
                                            <div><input type="text" value="" id="s_phone"/></div>
                                        </td>
                                    </tr>
                                      <tr>
                                        <td class="t_l">
                                            <span class="red">*</span>
                                            公司电话:
                                        </td>
                                        <td>
                                            <div><input type="text" value="" id="cphone"/></div>
                                        </td>
                                    </tr>
<!--                                    <tr>
                                        <td class="t_l tlr">
                                            企业简介:
                                        </td>
                                        <td>
                                            <textarea id="sub_detail"></textarea>
                                            <input type="hidden" value="" />
                                        </td>
                                    </tr>-->
                                    <tr>
                                        <td class="t_l">
                                            <span class="red">*</span>
                                            验证码:
                                        </td>
                                        <td>
                                            <input type="text" value="" id="u_valid" class="u_valid lf" />
                                            <span>
                                                <img src="{$web_root}/rvcode" alt="点击换一张" title="点击换一张" id="valid_img" class="v_r lf" />
                                            </span>
                                            <a href="javascript:;" title="" class="blue lf v_c" id="val_anoth">换一张</a>
                                        </td>
                                    </tr>
                                </table>
                                <div class="clr"></div>
                                <div class="post_6 ">
                                    <input name="aggree" type="checkbox" class="agree" checked="true" />
                                    <a  class="rule blue" href="{$web_root}/agreement/" target="_blank" title="职讯网服务协议">我已阅读并接受《职讯网服务协议》</a>
                                </div>
                                <div class="p3">
                                    <div class="u_n btn5 btn_common ">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a  class="btn white" id="en_next" href="javascript:;">下一步</a>
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
