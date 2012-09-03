<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>隐私设置 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/setprivate_1.0.css"/>   
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/jQuery-ptTimeSelect/jquery.ptTimeSelect.css"/>                
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">103</script>            
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>  
    </head>
    <body>      
         <!-- layout::{$bheader}::0 -->
          <div class="layout1 tindex">
            <div class="layout1_l">
                <div class="module_1">
                   <!-- layout::{$z_left}::0 -->
                </div>
            </div>              
              <div class="layout1_r">
                  <div class="module_2 cpriv">
                      <div class="sm_tab">
                          <ul>
                            <li><a href="{$web_root}/profiles/0">基本资料</a></li>
                            <li><a href="{$web_root}/profiles/1">修改头像</a></li>
                            <li><a href="{$web_root}/profiles/2">修改密码</a></li>
                            <li><a href="{$web_root}/profiles/3">信用认证</a></li>
                            <li class="cur_li"><a href="javascript:;">隐私设置</a></li>                          
                          </ul>
                          <div class="sub_title">
                              <a href="javascript:;" title="" class="blue">设置</a>
                          </div>
                      </div>
                      <div class="t_container">
                          <div class="t_item hidden"></div>
                          <div class="t_item hidden"></div>
                          <div class="t_item hidden"></div>
                          <div class="t_item hidden"></div>
                          <div class="t_item show">
                              <p class="sys_note">
                                  系统提示:为了严保个人信息安全，职讯智能隐私保护系统已避免泄露和骚扰,保障您和企业,猎头有效的沟通。
                              </p>
                              <div class="set_1">
                                  <h3>我希望公开的简历被谁看到:<span class="gray">(您目前公开的是</span>——<span class="red">{$privacyHuman.resume_name}</span>,<if condition="$privacyHuman.resume_name eq '兼职简历'">
                                          <a href="{$web_root}/resume/0" class="blue">去修改</a>
                                          <elseif condition="$privacyHuman.resume_name eq '全职简历'" /><a href="{$web_root}/resume/1" class="blue">去修改</a>
                                          <else/><a href="{$web_root}/resume/0" class="blue">去修改</a>
                                      </if>)</h3>                                  
                                  <ul>                                     
                                      <label><li class="first"><input class="pub1" name="pub1" type="radio" value="1" <if condition="$privacyHuman.resume eq 1">checked="checked"</if>/>企业和猎头都能看到</li></label>
                                      <label><li><input class="pub1" name="pub1" type="radio" value="2"<if condition="$privacyHuman.resume eq 2">checked="checked"</if> />仅猎头看到</li></label>
                                      <label><li><input class="pub1" name="pub1" type="radio" value="3"<if condition="$privacyHuman.resume eq 3">checked="checked"</if> />仅企业看到</li></label>
                                      <label><li><input class="pub1" name="pub1" type="radio" value="4"<if condition="$privacyHuman.resume eq 4">checked="checked"</if> />暂不公开</li></label>                                                                                                                                        
                                  </ul>
                                  <div class="clr"></div>
                              </div>
<!--                              联系方式隐私设置-->
                              <div class="set_4">
                                  <h3>联系方式隐私设置</h3>                                  
                                  <ul id="co_w">                                     
                                      <label><li class="first"><input class="pub4" name="apub4" type="radio" value="1" <if condition="$privacyHuman.contact_way eq 1">checked="checked"</if>/>公开</li></label>
                                      <label><li><input class="pub4" name="apub4" type="radio" value="2"<if condition="$privacyHuman.contact_way eq 2">checked="checked"</if> />不公开</li></label>                                                                                                                                  
                                  </ul>
                                  <div class="clr"></div>
                                  <div class="contract_w" id="contract_w">
                                      <p class="gtrig"></p>
                                      <input type="checkbox" id="u_cont1"/><label for="u_cont1">邮箱</label>
                                      <input type="checkbox" id="u_cont2"/><label for="u_cont2">QQ</label>
                                      <input type="checkbox" id="u_cont3"/><label for="u_cont3">手机</label>
                                  </div>
                              </div>
<!--                              电话回拨设置start-->

<!--                              电话回拨设置end-->
                              <div class="set_3">
                                  <h4>隐私信息设置:</h4>
                                  <ul>
                                      <li class="first1">姓名显示:</li>
                                      <label><li class="first"><input class="pub3" name="pub3" <if condition="$privacyHuman.name eq 1">checked="checked"</if> type="radio" value="1"  />{$privacyHuman.names['quanname']}</li></label>
                                      <label><li class=""><input class="pub3" name="pub3" type="radio" <if condition="$privacyHuman.name eq 2">checked="checked"</if> value="2"  />{$privacyHuman.names['banname']}先生</li></label>
                                      <label><li class=""><input class="pub3" name="pub3" type="radio" <if condition="$privacyHuman.name eq 3">checked="checked"</if> value="3"  />{$privacyHuman.names['banname']}女士</li></label>
                                  </ul>
                                  <div class="clr"></div>
                                  <ul>
                                      <li class="first1">生日显示:</li>                                    
                                      <label><li class="first"><input class="pub4" name="pub4" type="radio"<if condition="$privacyHuman.birthday eq 1">checked="checked"</if>value="1" />{$privacyHuman.birthdays['time']}</li></label>
                                      <label><li class=""><input class="pub4" name="pub4" type="radio" <if condition="$privacyHuman.birthday eq 2">checked="checked" </if>  value="2"/>{$privacyHuman.birthdays['duantime']}</li></label>
                                      <label><li class=""><input class="pub4" name="pub4" type="radio" <if condition="$privacyHuman.birthday eq 3">checked="checked" </if>  value="3"/>保密</li></label>
                                  </ul>     
                                  <div class="clr"></div>
                              </div>
                              <div class="savebut">
                                  <div class="em_s btn_common btn4" id="save">                                              
                                      <span class="b_lf"></span>
                                      <span class="b_rf"></span>
                                      <a href="javascript:;" id="save_npd" class="btn white" rel="{$privacyHuman.human_privacy_id}">保&nbsp;&nbsp;存</a>
                                  </div>
                             </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="clr"></div>
          </div>
         <!-- layout::Public:comtool::60 -->
        <!-- layout::Public:footersimple::60 -->
    </body>
</html>    
