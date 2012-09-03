<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>举报 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>        
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/report_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader"></script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        
        <div class="bheader" id="bheader">
           <div class="bh_cont">               
            <a class="logo lf title report" id="logo_a" href="{$web_root}/a_index/" title="回到首页">
            <img src="{$file_root}zhixun/Theme/default/vocat/imgs/system/logo.png" alt=""></a>                                                
           </div>
        </div>
         <div class="layout1 report">              
        <div class="re_main">
            <h1>举报</h1>
            <div class="notice">                
                <p>不良信息是指含色情、暴力、广告或其他骚扰您正常使用职讯网的内容。您要举报的<if condition="$newtype eq 1">信息-职位
                    <elseif condition="$newtype eq 2" />信息-职场经验
                    <elseif condition="($newtype eq 3) AND ($data.role_id eq 1)"/>是用户-人才
                    <elseif condition="($newtype eq 3) AND ($data.role_id eq 2)"/>是用户-企业
                    <elseif condition="($newtype eq 3) AND ($data.role_id eq 3)"/>是用户-猎头
                </if>                              
                </p>
            </div>
            <div class="reported_info">
             <!-----------  职位举报   -------------->
                <if condition="$newtype eq 1">
                <div class="photo">                   
                    <img src="{$data.pub_model.photo}" title="{$data.name}" alt="" />
                </div>               
                <div class="user_info">                    
                    <span class="gray">发布者:</span>
                    <span class="blue"id="user" uid="{$data.pub_model.id}">{$data.pub_model.name}</span>                    
                    <switch name="data.pub_model.real_auth">
                        <case value="0">
                            <img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                        </case>
                        <case value="1">
                            <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                        </case>
                    </switch> 
                    <switch name="data.pub_model.phone_auth">
                        <case value="0">                                        
                            <img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                        </case>
                        <case value="1">
                            <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                        </case>
                    </switch> 
                    <switch name="data.pub_model.email_auth">
                        <case value="0">
                            <img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                        </case>
                        <case value="1">
                            <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>                                        
                        </case>
                    </switch>                  
                </div>
                </if> 
             <!-----------  职场经验举报   -------------->
                <if condition="$newtype eq 2">
                    <div class="photo">                   
                    <img src="{$data.photo}" title="{$data.name}" alt="" />
                    </div>               
                    <div class="user_info">                    
                    <span class="gray">发布者:</span>
                    <span class="blue"id="user" uid="{$data.id}">{$data.name}</span>
                    
                    <switch name="data.real_auth">
                        <case value="0">
                            <img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                        </case>
                        <case value="1">
                            <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                        </case>
                    </switch> 
                    <switch name="data.phone_auth">
                        <case value="0">                                        
                            <img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                        </case>
                        <case value="1">
                            <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                        </case>
                    </switch> 
                    <switch name="data.email_auth">
                        <case value="0">
                            <img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                        </case>
                        <case value="1">
                            <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>                                        
                        </case>
                    </switch>                                         
                    </div>
                </if>
             <!-----------  用户举报   -------------->
                <if condition="$newtype eq 3">
                 <div class="photo">                   
                    <img src="{$data.photo}" title="{$data.name}" alt="" />
                </div>               
                <div class="user_info">                    
<!--                    <span class="gray">发布者:</span>-->
                    <div class="t_user"><span class="blue"id="user" uid="{$data.id}">{$data.name}</span></div>
                    <div class="t_user">
                        
                     <switch name="data.real_auth">
                        <case value="0">
                            <img class="lit_small" src="{$file_root}Files/system/auth/gnam.png" title="未实名认证" alt="未实名认证"/>
                        </case>
                        <case value="1">
                            <img class="lit_small" src="{$file_root}Files/system/auth/nam.png" title="已实名认证" alt="已实名认证"/>
                        </case>
                    </switch> 
                    <switch name="data.phone_auth">
                        <case value="0">                                        
                            <img class="lit_small" src="{$file_root}Files/system/auth/gpho.png" title="未手机认证" alt="未手机认证"/>
                        </case>
                        <case value="1">
                            <img class="lit_small" src="{$file_root}Files/system/auth/pho.png" title="已手机认证" alt="已手机认证"/>
                        </case>
                    </switch> 
                    <switch name="data.email_auth">
                        <case value="0">
                            <img class="lit_small" src="{$file_root}Files/system/auth/gmes.png" title="未邮箱验证" alt="未邮箱验证"/>
                        </case>
                        <case value="1">
                            <img class="lit_small" src="{$file_root}Files/system/auth/mes.png" title="已邮箱验证" alt="已邮箱验证"/>                                        
                        </case>
                    </switch>                                                
                    </div>
                </div>
                </if>        
                <div class="report_title blue">       
                   <if condition="$data.category eq 1">                       
                       <span class="red">[全职]</span>                      
                       <elseif condition="$data.category eq 2"/><span class="red">[兼职]</span>                      
                   </if>
                 {$data.title}</div>                                
            </div>
            <div class="report_type">
                <h3>举报类型:</h3>
                <table id="retype">
                    <tr>
                        <td><input type="radio" name="type" value="1" />垃圾广告</td>
                        <td><input type="radio" name="type" value="2" />虚假信息</td>
                        <td><input type="radio" name="type" value="3" />淫秽色情</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="type" value="4"/>泄露他人隐私</td>
                        <td><input type="radio" name="type" value="5" />敏感信息</td>
                        <td><input type="radio" name="type" value="6" />欺诈骗取</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="type" value="7" />非法服务</td>
                        <td><input type="radio" name="type" value="8" />其它</td>                        
                    </tr>
                </table>
                <h3>补充说明:</h3>
                <textarea id="addtext" class="addinfo" name="add">请详细填写举报理由</textarea>
                <span class="note gray">请放心,您的隐私会得到保护</span>
            </div>
            <div class="reportsub">
            <div class="check_m btn_common btn10">
                <span class="lf"></span>
                <span class="rf"></span>
                <a href="javascript:;" id="s_report" type="{$newtype}" class="white btn">确认举报</a>
            </div>            
        </div>
       </div>
    </body>
</html>