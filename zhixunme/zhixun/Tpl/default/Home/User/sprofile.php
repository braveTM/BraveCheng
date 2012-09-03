<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>帐号资料 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/profiles_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">32</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 profiles">
             <div class="layout1_l">
                <div class="module_1">
                       <div class="acc_set">
                        <!--帐号资料-->
                        <div class="b_com my_prof">
                            <div class="area_title">
                                <h2 class="a_title">帐号资料</h2>
                            </div>
                            <div class="sub_p">
                                <a href="{$web_root}/profiles/0" title="基本资料" class="blue"><em>></em>基本资料</a>
                            </div>
                            <div class="sub_p ">
                                <a href="{$web_root}/profiles/1" title="修改密码" class="blue"><em>></em>修改密码</a>
                            </div>
                            <div class="sub_p las_v">
                                <a href="{$web_root}/profiles/2" title="信用认证" class="blue"><em>></em>信用认证</a>
                            </div>
                        </div>
                        <!--我的钱包-->
                        <div class="b_com my_prof">
                            <div class="area_title">
                                <h2 class="a_title">我的钱包</h2>
                            </div>
                            <div class="sub_p ">
                                <a href="{$web_root}/bill/0" title="账户充值" class="blue"><em>></em>账户充值</a>
                            </div>
                            <div class="sub_p las_v">
                                <a href="{$web_root}/bill/1" title="账单明细" class="blue"><em>></em>账单明细</a>
                            </div>
                        </div>
                        <!--我的套餐-->
                        <div class="b_com">
                            <div class="area_title">
                                <h2 class="a_title">我的套餐</h2>
                            </div>
                            <div class="sub_p"><a href="{$web_root}/mpackage/0" class="blue"><em>></em>使用统计</a></div>
                            <div class="sub_p las_v"><a href="{$web_root}/mpackage/1" class="blue"><em>></em>套餐管理</a></div>
                        </div>
                         <!--我要推广-->
                        <div class="b_com nbd">
                            <div class="area_title">
                                <h2 class="a_title">我要推广</h2>
                            </div>
                            <div class="sub_p">
                                <a href="{$web_root}/epromotion/0"class="blue"><em>></em>帐号推广</a>
                            </div>
                            <div class="sub_p">
                                <a href="{$web_root}/epromotion/1"class="blue"><em>></em>信息推广</a>
                            </div>
                        </div>
                   </div>
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li first"><a class="cur_a" href="javascript:;">基本资料</a></li>
                            <li><a href="javascript:;">修改密码</a></li>
                            <li><a href="javascript:;">信用认证</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue" id="uceter">帐号资料</a>
                        </div>
                    </div>
                </div>
                <!--基本资料-->
                <div class="module_3 mod">
                    <table class="t_ldr">
                        <tr>
                            <td class="t_l nickname"><span class="red">*</span><span>企业名称:</span></td>
                            <td id="g_panle">
                                <div>
                                <input type="text" value="东方红科技有限公司" name="nick" id="s_na" class="gray" readonly="true" rel="{$profile.nick}" />
                                </div>
                                </td>
                        </tr>
                        <tr>
                            <td class="t_l"><span class="red">*</span>企业性质:</td>
                              <td id="l_panle">
                                <input type="hidden" value="{$profile.ca}" name="cpy_sex"/>
                                <span class="c_sex">国有企业</span>
                                <a href="javascript:;" title="" class="blue ch_atr">
                                    修改
                                </a>
                                <span id="e_bar" class="hidden">
                                    <select id="e_attr">
                                       <option value="1">国有企业</option>
                                       <option value="2">民营企业</option>
                                   </select>
                                  <a href="javascript:;" title="确定" class="blue e_ok">确定</a>
                                  <a href="javascript:;" title="取消" class="blue e_cle">取消</a>
                                </span>
                            </td>
                        </tr>
                         <tr>
                            <td class="t_l"><span class="red">*</span>注册地:</td>
                            <td id="l_panle">
                                <input type="hidden" name="t_prov" value="{$profile.province}"/>
                                <input type="hidden" name="t_city" value="{$profile.city}"/>
                                <input type="text" id="fro_pv" class="mselect" readonly value=""/>
                            </td>
                        </tr>
<!--                         <tr>
                            <td class="t_l"><span class="red">*</span>劳务分包资质:</td>
                            <td id="l_panle">
                                <input type="text" id="lab_qa" class="mselect" readonly value=""/>
                            </td>
                        </tr>-->
                         <tr>
                            <td class="t_l"><span class="red">*</span>联系人:</td>
                            <td>
                                <div>
                                <input id="cont_p" type="text" value=""/>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="t_l"><span class="red">*</span>联系人手机:</td>
                            <td>
                                <div>
                                 <input id="phone" class="gray" readonly="true" type="text" value="{$profile.phone}"/>
                                <if condition="$auth.phone_auth eq 1">
                                    <a href="javascript:;" title="已通过认证"class="blue ved">修改认证</a>
                                    <else/><a href="javascript:;" id="go_v" class="blue ved">申请认证</a>
                                </if>
                                 </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="t_l">联系人QQ:</td>
                            <td>
                                <div>
                                 <input id="qq" type="text" value="{$profile.qq}"/>
                                 </div>
                            </td>
                        </tr>
                         <tr>
                            <td class="t_l tlr">企业简介:</td>
                            <td>
                                <textarea id="sub_detail"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="t_l" valign="top">企业logo:</td>
                            <td>
                                <table class="tb_info">
                                    <tr>
                                        <td class="ava_mtd">
                                            <form action="{$web_root}/upload_photo" method="post" enctype="multipart/form-data" id="form_upload" target="Upfiler_file_iframe">
                                                <div class="up_fileBox">
                                                    <div class="lf MIB_btn uploadInput">
                                                        <div class="btn_common btn9">
                                                            <span class="b_lf"></span>
                                                            <span class="b_rf"></span>
                                                            <a class="sbtn_normal btn" href="javascript:;">
                                                                <em>选择图片</em>
                                                                <q><input id="file_name" name="file_name" size="1" contenteditable="false" type="file"/></q>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                                <p id="upload_status" style="display:none;" class="error_color">请等待图片上传...</p>
                                                <p class="gray margintb10">支持gif、jpg、png格式图片,且不大于5M</p>
                                            </form>
                                            <iframe id="Upfiler_file_iframe" name="Upfiler_file_iframe" src="about:blank" style="display:none" ></iframe>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <table class="avatar_show" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td id="up_avatar_left" style="display:none;border:none;width:200px;" valign="middle">
                                                            <div class="avatar_box">
                                                                <div id="n_avatar_div" class="avatar_pic">
                                                                    <img id="my_avatar" src="{$profile.photo}" alt="" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td valign="middle" style="border:none;width: 120px;">
                                                            <div class="p_cont_b">
                                                                <div class="avatar_b_box">
                                                                    <div id="b_avatar_div" class="avatar_b_pic">
                                                                        <img src="{$profile.photo}" alt=""/>
                                                                    </div>
                                                                    <input type="hidden" name="photo" value="" />
                                                                </div><br/>
                                                            </div>
                                                        </td>
                                                        <td style="padding-left:10px;border:none;" valign="middle">
                                                            <div class="p_cont_m">
                                                                <div class="avatar_m_box">
                                                                    <div id="m_avatar_div" class="avatar_m_pic">
                                                                        <img src="{$profile.photo}" alt="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="clr"></div>
                                                <p>
                                                    <input type="hidden" value="0"id="x"/>
                                                    <input type="hidden" value="0" id="y"/>
                                                    <input type="hidden" value="100" id="w"/>
                                                    <input type="hidden" value="100" id="h"/>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="save btn_common btn4_common btn4">
                        <span class="b_lf"></span>
                        <span class="b_rf"></span>
                        <a href="javascript:;" id="e_s" class="btn white">保存</a>
                    </div>
                    <div class="clr"></div>
                    <div class="select_area" style="position: absolute;"></div>
                </div>
                 <!--修改密码-->
                <div class="module_4  mod hidden">
                   <p class="red com_tip">建议使用包含数字字母的密码,最少6个字符。</p>
                    <div class="chan_pwd">
                        <div class="post post_2">
                            <span class="t_l">
                                 <b class="red">*</b>旧密码：
                            </span>
                            <input type="password" id="opd" name="opd" class="opd" enquired="">
                        </div>
                        <div class="post post_2">
                            <span class="t_l">
                                 <b class="red">*</b>新密码：
                            </span>
                            <input type="password" id="npd" name="npd" class="npd" enquired="">
                        </div>
                        <div class="post_03 post">
                            <span class="t_l">
                                 <b class="red">*</b>重复新密码：
                            </span>
                            <input type="password" id="copd" name="copd" class="copd" enquired="">
                        </div>
                        <div class="save btn4 btn_common btn4_common">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" id="sav_npd" class="btn white">保存</a>
                        </div>
                    </div>
                </div>
                <!--信用认证-->
                <div class="module_6 mod hidden">
                    <div class="val_p">
                        <p class="ct">您已拥有的信用认证<span class="gray"></span></p>
                        <div class="v_exit">
                            <ul id="v_li">
                                <if condition="$auth.real_auth eq 1"><li class="name_v" rel="isup"><span><img src="{$auth.ricon}" alt="" class="l_small"><a href="javascript:;" title="">企业认证</a></span><span class="s_l"></span></li></if>
                                <if condition="$auth.phone_auth eq 1"><li class="v_phone" rel="ev_phone"><span><img src="{$auth.picon}" alt="" class="l_small"><a href="javascript:;" title="">手机认证</a></span><span class="s_l"></span></li></if>
                                <if condition="$auth.email_auth eq 1"><li class="v_email" rel="ev_email"><span><img src="{$auth.eicon}" alt="" class="l_small"><a href="javascript:;" title="">邮箱认证</a></span><span class="s_l"></span></li></if>
                            </ul>
                        </div>
                        <div class="v_cont ">
                            <if condition="$auth.email_auth eq 1">
                                <div class="name_error isup tab_ct  hidden">
                                    <p class="red">企业认证不允许修改</p>
                                </div>
                            </if>
                            <if condition="$auth.email_auth eq 1">
                                <div class="email_val ev_email tab_ct hidden">
                                    <div class="post">
                                        <span class="t_l"><b class="red">*</b>常用邮箱:</span>
                                        <input type="text" class="email" id="n_email" name="n_email" valide="0"/>
                                    </div>
                                    <div class="save btn4 btn_common btn4_common">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" id="v_mail" class="btn white">重新认证</a>
                                    </div>
                                </div>
                            </if>
                            <if condition="$auth.phone_auth eq 1">
                                 <div class="bp_com phone ev_phone tab_ct hidden">
                                    <div class="post">
                                    <span class="t_l"><b class="red">*</b>输入手机号码:</span>
                                    <input type="text" class="pnum" name="phnum" id="n_pnum" />
                                    </div>
                                    <div class="send">
                                        <input type="button" id="v_send" class="btn" value="发送短信校验码"/>
                                        <div id="countDown" class="point gray" style="display: none;">
                                            校验码已发出，请注意查收短信，如果没有收到，您可以在<strong class="ftx-01 red">1</strong>秒后要求系统重新发送
                                        </div>
                                    </div>
                                    <div class="post">
                                        <span class="t_l"><b class="red">*</b>输入短信校验码:</span>
                                        <input type="text" name="valinum" class="valinum" id="n_valinum">
                                    </div>
                                    <div class="save btn4 btn_common btn4_common">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" id="v_phone" class="btn white">重新认证</a>
                                    </div>
                                  </div>
                            </if>
                        </div>
                    </div>
                     <if condition="$auth.real_auth eq 2">
                         <div class="cin_v">
                                 <p  class="com_tip">您正在申请的信用认证</p>
                                 <div class="pgs">
                                    <span><img src="{$auth.ricon}" alt="" class="l_small" /><em>实名认证</em></span>
                                    <div class="st">
                                        <div class="b1"></div>
                                        <div class="b2"></div>
                                    </div>
                                    <span class="cn">正在审核中....</span>
                                 </div>
                            <div class="clr"></div>
                       </div>
                    </if>
                    <div class="avaible_v">
                        <p  class="com_tip">您可申请的信用认证</p>
                        <div class="v_exit">
                            <ul class="v_list" id="va_li">
                                <if condition="$auth.real_auth eq 0"><li class="name_v" rel="app_vn"><span><img src="{$auth.ricon}" alt="" class="l_small" /><a href="javascript:;" title="">实名认证</a></span><span class="s_l"></span></li></if>
                                <if condition="$auth.phone_auth eq 0"><li class="phone_v" rel="app_vp"><span><img src="{$auth.picon}" alt="" class="l_small" /><a href="javascript:;" title="">手机认证</a></span><span class="s_l"></span></li></if>
                                <if condition="$auth.email_auth eq 0"><li class="email_v" rel="app_ve"><span><img src="{$auth.eicon}" alt="" class="l_small" /><a href="javascript:;" title="">邮箱认证</a></span><span class="s_l"></span></li></if>
                            </ul>
                        </div>
                        <div class="va_cont">
                            <if condition="$auth.email_auth eq 0">
                                <div class="email_val app_ve tab_c">
                                    <div class="post">
                                        <span class="t_l"><b class="red">*</b>常用邮箱:</span>
                                        <input type="text" class="email" id="n_email" name="n_email" valide="0"/>
                                    </div>
                                    <div class="save btn4 btn_common btn4_common">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" id="v_mail" class="btn white">申请认证</a>
                                    </div>
                                </div>
                            </if>
                            <if condition="$auth.phone_auth eq 0">
                                <div class="bp_com phone app_vp tab_c">
                                <div class="post">
                                    <span class="t_l"><b class="red">*</b>输入手机号码:</span>
                                    <input type="text" class="pnum" name="phnum" id="n_pnum" />
                                </div>
                                <div class="send">
                                    <input type="button" id="v_send" class="btn" value="发送短信校验码"/>
                                    <div id="countDown" class="point gray" style="display: none;">
                                        校验码已发出，请注意查收短信，如果没有收到，您可以在<strong class="ftx-01 red">1</strong>秒后要求系统重新发送
                                    </div>
                                </div>
                                <div class="post">
                                    <span class="t_l"><b class="red">*</b>输入短信校验码:</span>
                                    <input type="text" name="valinum" class="valinum" id="n_valinum">
                                </div>
                                <div class="save btn4 btn_common btn4_common">
                                    <span class="b_lf"></span>
                                    <span class="b_rf"></span>
                                    <a href="javascript:;" id="v_phone" class="btn white">申请认证</a>
                                </div>
                              </div>
                            </if>
                            <if condition="$auth.real_auth eq 0">
                                <div class="update_id app_vn tab_c">
                                    <p class="red">友情提示：实名申请一旦认证成功将不允许修改！请正确填写您的信息</p>
                                    <div class="post">
                                        <span class="t_l">
                                            <b class="red">*</b>企业名称:
                                        </span>
                                        <input type="text" value="" id="e_name" />
                                    </div>
                                     <div class="post">
                                        <span class="t_l">
                                            <b class="red">*</b>营业执照编号:
                                        </span>
                                        <input type="text" value="" id="licnum" />
                                    </div>
                                    <div class="file_list">
                                        <form action="{$web_root}/upload_identify" method="POST" target="Upfiler_file_iframe" enctype="multipart/form-data" id="form_upload_01">
                                            <div class="post iden_cop op_lice">
                                                <span class="t_l lf"><b class="red">*</b>营业执照复印件:</span>
                                                <div class="up_idphoto fd">
                                                   <input type="hidden" name="type" value="1" />
                                                    <input type="hidden" name="front_side" />
                                                   <input id="fd_cd" name="file_name" type="file"/>
                                                   <input type="button" id="up_f1" class="up_phot hidden" value="上传"/>
                                                </div>
                                                <div class="clear"></div>
                                                <iframe id="pic_up" name="Upfiler_file_iframe" src="about:blank" style="display:none" ></iframe>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="file_list">
                                        <form action="{$web_root}/upload_identify" method="POST" target="other_file_iframe" enctype="multipart/form-data" id="form_upload_02">
                                            <div class="post other">
                                                <span class="t_l lf"><b class="red">*</b>组织机构代码复印件:</span>
                                                <div class="up_idphoto bd">
                                                   <input type="hidden" name="type" value="2" />
                                                   <input type="hidden" name="back_side" />
                                                   <input id="bd_cd" name="file_name" type="file"/>
                                                   <input type="button" id="up_f2" class="up_phot hidden" value="上传"/>
                                                </div>
                                                <div class="clear"></div>
                                                <iframe id="other_file" name="other_file_iframe" src="about:blank" style="display:none" ></iframe>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="save btn4 btn_common btn4_common">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" id="cv_relname" class="btn white">申请认证</a>
                                    </div>
                                </div>
                            </if>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            <!-- layout::Public:footersimple::60 -->
        </div>
    </body>
</html>
