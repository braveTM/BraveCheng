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
        <div class="regis_page">
            <div class="pub_top">
                <div class="top_re">
                    <a href="{$web_root}" title="职讯网首页">
                        <div class="log_area"></div>
                    </a>
                    <a href="{$web_root}" title="登录" class="blue">登录</a>
                </div>
            </div>
            <div class="pub_mid">
                 <div class="devsion">
                   <ul class="t_np">
                        <li class="t_01 cu_li"><b>1、</b>劳务分包商注册<div class="cur_ste"></div></li>
                        <li class="t_02 gray"><b>2、</b>邮箱验证</li>
                        <li class="t_03 gray"><b>3、</b>成功注册</li>
                    </ul>
                </div>
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
                                       注册地:
                                   </td>
                                   <td>
                                         <input type="hidden" name="t_prov" value=""/>
                                        <input type="hidden" name="t_city" value=""/>
                                        <input type="text" id="place" class="mselect" readonly value=""/>
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
                                       <span class="red">*</span>
                                       联系人手机:
                                   </td>
                                   <td>
                                       <div><input type="text" value="" id="u_phone"/></div>
                                   </td>
                               </tr>
                               <tr>
                                   <td class="t_l">
                                       联系人QQ:
                                   </td>
                                   <td>
                                       <div><input type="text" value="" id="u_qq"/></div>
                                   </td>
                               </tr>
                               <tr>
                                   <td class="t_l tlr">
                                       企业简介:
                                   </td>
                                   <td>
                                       <textarea id="sub_detail"></textarea>
                                       <input type="hidden" value="" />
                                   </td>
                               </tr>
                                <tr>
                            <td class="t_l tl_p" valign="top">企业头像:</td>
                            <td class="tl_q">
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
                                                                <q><input id="file_name" name="file_name" size="5" contenteditable="false" type="file"/></q>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                                <p id="upload_status" style="display:none;" class="error_color">请等待图片上传...</p>
                                                <p class="gray margintb10">支持gif、jpg、png各式图片,且不大于5M</p>
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
                                                                    <img  id="my_avatar" src="{$photo}" alt="" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td valign="middle" style="border:none;width: 120px;">
                                                            <div class="p_cont_b">
                                                                <div class="avatar_b_box">
                                                                    <div id="b_avatar_div" class="avatar_b_pic">
                                                                       <img src="{$photo}" alt="" />
                                                                    </div>
                                                                     <input type="hidden" name="photo" value="{$photo}" />
                                                                </div><br/>
                                                            </div>
                                                        </td>
                                                        <td style="padding-left:10px;border:none;" valign="middle">
                                                            <div class="p_cont_m">
                                                                <div class="avatar_m_box">
                                                                    <div id="m_avatar_div" class="avatar_m_pic">
                                                                        <img src="{$photo}" alt="" />
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
                                <div class="clr"></div>
                                <div class="select_area" style="position: absolute;"></div>
                            </td>
                        </tr>
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
                        <p class="red valid_tip"></p>
                      <div class="clr"></div>
                       <div class="post_6 ">
                            <input name="aggree" type="checkbox" class="agree" checked="true" />
                            <a  class="rule"href="javascript;" title="">我已阅读并接受《职讯网用户守则》</a>
                        </div>
                        <div class="p3">
                            <div class="u_n btn5 btn_common ">
                                <span class="b_lf"></span>
                                <span class="b_rf"></span>
                                <a  class="btn white" id="sub_next" href="javascript:;">下一步</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
           <!-- layout::Public:footeregister::60 -->
        </div>
    </body>
</html>
