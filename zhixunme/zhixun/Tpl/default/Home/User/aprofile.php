<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>帐号资料 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/profiles_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">29</script>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 profiles">
            <div class="layout1_l">
                <div class="module_1">
                <!-- layout::{$z_left}::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="sm_tab">
                    <ul>
                        <li><a href="javascript:;">基本资料</a></li>
                        <li><a href="javascript:;">修改头像</a></li>
                        <li><a href="javascript:;">修改密码</a></li>
                        <li><a href="javascript:;">信用认证</a></li>
                        <li><a href="{$web_root}/setPrivacyAgent/4">隐私设置</a></li> 
                        <li><a href="{$web_root}/broker_remind/5">提醒设置</a></li>   
                    </ul>
                    <div class="sub_title">
                        <a href="javascript:;" title="" class="blue" id="uceter">帐号资料</a>
                    </div>
                </div>
                <div class="t_container">
                    <!--基本资料-->
                    <div class="module_3 t_item mod hidden">
                        <table class="t_ldr">
                            <tr>
                                <td class="t_l">
                                    <span class="red">*</span><span>登录邮箱:</span>
                                </td>
                                 <td>
                                     <div>
                                         <if condition="$auth.email_auth eq 1 && $profile.email neq ''">
                                             <input type="text" class="em_box nbd" readonly value="{$profile.email}" id="v_em"/>
                                            <span class="hadp ml"> 已认证 </span>
                                        <elseif condition="$auth.email_auth neq 1 && $profile.email neq ''" />
                                             <input type="text" value="{$profile.email}" valide="{$profile.email}" class="em_box" id="log_email"/>
                                            <span class="red ml">未认证, </span><span class="gray">认证后可用于帐号登录, </span><a href="{$web_root}/profiles/3" id="go_v" title="立即申请认证"class="blue ved">立即申请认证</a>
                                         </if>
                                     </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="t_l"><span class="red">*</span>登录手机号:</td>
                                <td>
                                    <div>
                                        <if condition="$auth.phone_auth eq 1 && $profile.phone neq ''">
                                            <input type="text" class="ep_box nbd" readonly value="{$profile.phone}" id="v_ph"/>
                                            <span class="hadp ml"> 已认证 </span>
                                        <elseif condition="$auth.phone_auth neq 1 && $profile.phone neq ''" />
                                                <input id="phone" type="text"value="{$profile.phone}"  class="ep_box" valide="{$profile.phone}"/>
                                                <span class="red ml">未认证, </span><span class="gray">认证后可用于帐号登录, </span><a href="{$web_root}/profiles/3" id="go_v" class="blue ved" title="立即申请认证">立即申请认证</a>
                                        </if>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="t_l nickname"><span class="red">*</span><span>真实姓名:</span></td>
                                <td id="g_panle">
                                    <div>
                                        <input type="text"  value="{$profile.name}" name="nick" id="nickname" rel="{$profile.name}" />
                                    </div>
                                </td>
                            </tr>
                              <tr>
                                <td class="t_l"><span class="red">*</span>性别:</td>
                                <td id="g_panle">
                                    <input id="gender" type="hidden" value="{$profile.gender}"/>
                                    <span class="lf">
                                        <input type="radio" name="p_sex" id="p_sex1" class="p_gender" val="1" value="男"/><label for="p_sex1">男</label>
                                    </span>
                                    <span class="lf">
                                        <input type="radio" name="p_sex" id="p_sex2" class="p_gender r_wm" val="0" value="女"/><label for="p_sex2">女</label>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="t_l"><span class="red">*</span>所在地:</td>
                                <td id="l_panle">
                                    <input type="hidden" name="t_prov" value="{$profile.province}"/>
                                    <input type="hidden" name="t_city" value="{$profile.city}"/>
                                    <input type="text" id="fro_pv" class="mselect" readonly value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td class="t_l">QQ:</td>
                                <td>
                                    <div>
                                        <input id="qq" type="text" value="{$profile.qq}"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="t_l">所属猎头公司:</td>
                                <td>
                                    <input type="text" id="m_o" value="{$profile.company}"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="t_l tlr">个人简介:</td>
                                <td>
                                    <if condition="$profile.summary neq  ''">
                                    <textarea id="t_intro">{$profile.summary}
                                    <else /> <textarea id="t_intro" class="gray">个人简介是您对外形象展示的重要窗口，您可以就从业年限、行业经验、服务过的大客户、所在经济公司的实力等能提升个人专业度和价值的方面进行自我介绍。
                                    </if>
                                    </textarea>
                                    <input type="hidden" value="{$profile.summary}" name="ef" />
                                </td>
                            </tr>                            
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <div class="save btn_common btn4_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" id="a_s" class="btn white">保存</a>
                        </div>
                    </div>
                    <!--修改头像-->                                        
                    <div class="module_7 t_item mod hidden">   
                        <table class="cphoto">
                            <tr>
                                <td valign="top" class="t_l">修改头像:</td>
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
                                                        <p class="gray margintb10">支持gif、jpg、png格式图片,且不大于5M</p>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <p id="upload_status" style="display:none;" class="error_color">请等待图片上传...</p>                                                    
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
                                                                <p class="dip">拖动下方方块,调整大小</p>
                                                                <div class="avatar_box">
                                                                    <div id="n_avatar_div" class="avatar_pic">
                                                                        <img id="my_avatar" src="{$profile.photo}" />
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
                        <div class="clr"></div>
                        <div class="select_area" style="position: absolute;"></div>
                        <div class="save btn_common btn4_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" id="midmanphoto" class="btn white">保存</a>
                        </div>
                    </div>
                    <!--修改密码-->
                    <div class="module_4 t_item mod hidden">
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
                    <div class="module_6 t_item mod hidden">
                        <div class="val_p">
                            <p class="ct">您已拥有的信用认证<span class="gray"></span></p>
                            <div class="v_exit">
                                <ul id="v_li">
                                    <if condition="$auth.real_auth eq 1"><li class="name_v" rel="isup"><span><img src="{$auth.ricon}" alt="实名认证" title="已通过职迅网实名认证" class="l_small"><a href="javascript:;" title="">实名认证</a></span><span class="s_l"></span></li></if>
                                    <if condition="$auth.phone_auth eq 1"><li class="v_phone" rel="ev_phone"><span><img src="{$auth.picon}" alt="手机认证" title="已通过职迅网手机认证" class="l_small"><a href="javascript:;" title="">手机认证</a></span><span class="s_l"></span></li></if>
                                    <if condition="$auth.email_auth eq 1"><li class="v_email" rel="ev_email"><span><img src="{$auth.eicon}" alt="邮箱认证" title="已通过职迅网邮箱认证" class="l_small"><a href="javascript:;" title="">邮箱认证</a></span><span class="s_l"></span></li></if>
                                </ul>
                            </div>
                            <div class="v_cont ">
                                <if condition="$auth.email_auth eq 1">
                                    <div class="name_error isup tab_ct  hidden">
                                        <table class="block">
                                            <tr>
                                                <td class="relname">姓名:</td>
                                                <td><input type="text" value="{$auth.name}" readonly="readonly" class="gray"></td>                                                
                                            </tr>
                                            <tr>
                                                <td class="relid">身份证号:</td>
                                                <td><input type="text" value="{$auth.num}" readonly="readonly" class="gray"></td>
                                        </tr></table>                                        
                                    </div>
                                </if>
                                <if condition="$auth.email_auth eq 1">
                                    <div class="email_val ev_email tab_ct hidden">
                                        <div class="post">
                                            <span class="t_l tp_l">常用邮箱:</span>
                                            <input type="text" class="gray" readonly  value="{$profile.email}"/>
                                        </div>
                                    </div>
                                </if>
                                <if condition="$auth.phone_auth eq 1">
                                    <div class="tpe phone ev_phone tab_ct hidden">
                                        <div class="post">
                                            <span class="t_l tp_l">手机号码:</span>
                                            <input type="text" class="gray" readonly value="{$profile.phone}" />
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
                                    <if condition="$auth.real_auth eq 0"><li class="name_v" rel="app_vn"><span><img src="{$auth.ricon}" alt="" title="未通过职迅网实名认证" class="l_small" /><a href="javascript:;" title="">实名认证</a></span><span class="s_l"></span></li></if>
                                    <if condition="$auth.phone_auth eq 0"><li class="phone_v" rel="app_vp"><span><img src="{$auth.picon}" alt="" title="未通过职迅网手机认证" class="l_small" /><a href="javascript:;" title="">手机认证</a></span><span class="s_l"></span></li></if>
                                    <if condition="$auth.email_auth eq 0"><li class="email_v" rel="app_ve"><span><img src="{$auth.eicon}" alt="" title="未通过职迅网邮箱认证" class="l_small" /><a href="javascript:;" title="">邮箱认证</a></span><span class="s_l"></span></li></if>
                                </ul>
                            </div>
                            <div class="va_cont">
                                <if condition="$auth.email_auth eq 0">
                                    <div class="email_val app_ve tab_c">
                                        <div class="post">
                                            <span class="t_l tp_l">常用邮箱:</span>
                                            <input type="text" class="email" id="n_email" name="n_email" valide="{$profile.email}" value="{$profile.email}"/>
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
                                            <input type="text" class="pnum" name="phnum" id="n_pnum" valide="{$profile.phone}" value="{$profile.phone}" />
                                        </div>
                                        <div class="send">
                                            <div class="btn_common sd btn9" style="width:212px;">
                                                <span class="b_lf"></span>
                                                <span class="b_rf"></span>
                                                <a href="javascript:;" id="v_send" class="btn btn_normal _send"><strong class="gray hidden" id="countDown">(<em class="ftx-01">1</em>)秒后可重新获取验证码</strong><em class="gtcode">免费获取验证码</em></a>
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
                                        <p  class="red">系统提示：认证通过后头像不可修改，请上传清晰免冠照，以便顺利审核。</p>
                                        <div class="line1 line2">
                                            <span class="t_l"><b class="red">*</b>真实姓名：</span>
                                            <input type="text" class="iden" id="rname" name="realname"/>
                                        </div>
                                        <div class="line1 line2">
                                            <span class="t_l"><b class="red">*</b>身份证号：</span>
                                            <input type="text" class="iden" id="iden" name="iden"/>
                                        </div>
                                        <!--正面-->
                                        <div class="file_list a_f">
                                            <form action="{$web_root}/upload_identify" method="POST" target="Upfiler_file_iframe" enctype="multipart/form-data" id="form_upload_01">
                                                <div class="lm1 iden_cop">
                                                    <span class="lf t_l"><b class="red">*</b>身份证复印件正面：</span>
                                                    <div class="up_idphoto fd">
                                                        <input type="hidden" name="type" value="1" />
                                                        <input type="hidden" name="front_side" />
                                                        <input id="fd_cd" name="file_name" type="file"/>
                                                        <div id="up_f1" class="up_phot hidden"></div>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <iframe id="pic_up" name="Upfiler_file_iframe" src="about:blank" style="display:none" ></iframe>
                                                </div>
                                            </form>
                                            <p class="red stip">为保证顺利进行,请上传清晰的彩色照片或复印件正反面图<br/>尽量不留白边400 * 250px(宽*高),且大小不超过2M</p>
                                        </div>
                                        <!--背面-->
                                        <div class="file_list a_f">
                                            <form action="{$web_root}/upload_identify" method="POST" target="Upfiler_file_iframe2" enctype="multipart/form-data" id="form_upload_02">
                                                <div class="lm1 iden_cop">
                                                    <span class="lf t_l"><b class="red">*</b>身份证复印件背面：</span>
                                                    <div class="up_idphoto bd">
                                                        <input type="hidden" name="type" value="2" />
                                                        <input type="hidden" name="back_side" />
                                                        <input id="bd_cd" name="file_name" type="file"/>
                                                        <div id="up_f2" class="up_phot hidden"></div>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <iframe id="pic_up" name="Upfiler_file_iframe2" src="about:blank" style="display:none" ></iframe>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="save btn4 btn_common btn4_common">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" id="v_relname" class="btn white">申请认证</a>
                                        </div>
                                    </div>
                                </if>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            <!-- layout::Public:comtool::60 -->
            <!-- layout::Public:footersimple::60 -->
        </div>
    </body>
</html>
