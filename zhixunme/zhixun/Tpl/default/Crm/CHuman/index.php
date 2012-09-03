<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>人才客户档案详细</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$crm_root}/css/resource_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/card-hgs/card-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/mask/mask.css">
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/jquery-datepicker/jquery.ui.datepicker.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$crm_root}/config/loader.js" id="loader">96</script>
    </head>
    <body>        
        <!-- layout::Home:Public:simpleheader::0 -->
        <div class="layout1 hmdetail comdetail com_lde">
            <div class="sm_tab">
                <ul>
                    <li class="cur_li"><a href="javascript:;">人才档案详细</a></li>
                </ul>
                <div class="sub_title">
                    <a href="javascript:;" title="" class="blue">客户管理</a>
                </div>
            </div>
            <div class="layout1_nl lf base_info">
                <!--基本资料-->
                <input type="hidden" name="hid" id="h_id" rel="true" value="{$human.id}" />
                <div class="mod_1 area_basic updatedata">
                    <div class="mtitle">
                        <h2 class="lf">基本信息</h2>
                        <a href="javascript:;" class="blue rf  base_edit " title="修改">修改</a>
                    </div>
                    <div class="clr"></div>
                    <table class="tbase tb_cm mod">
                        <tr>
                            <td class="ltd">
                                <span class="red">* </span><span class="gray">姓名 : </span>
                            </td>
                            <td>
                                <div><input type="text" readonly  id="uname" value="{$human.name}" ></div>
                            </td>
                            <td class="ltd">
                                <span class="gray">客户来源 : </span>
                            </td>
                            <td>
                                <div class="csouce" val="{$human.source_id}">{$human.source}</div>
                                <select id="custom_surce" class="hidden ">
                                    <foreach name="source" item="sc">
                                        <option value="{$sc.id}">{$sc.name}</option>
                                    </foreach>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">性别 : </span>
                            </td>
                            <td>
                                <span class="txtinfo" val="{$human.sex}">{$huamn.sexname}</span>
                                <label for="sexops">
                                    <input type="radio" id="sexops" name="sex" value="0"checked="checked" class="hidden"/><span class="txthid hidden ">男</span>
                                </label>
                                <label for="sops">
                                    <input type="radio" id="sops" name="sex" value="1" class="hidden"/><span class="txthid hidden">女</span>
                                </label>
                            </td>
                            <td class="ltd">
                                <span class="gray">生日 : </span>
                            </td>
                            <td>
                                <div class="tm"><input  readonly id="date" type="text" value="{$human.birthday}" /></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">证件类型 : </span>
                            </td>
                            <td>
                                <div class="csouce" val="{$human.doc_type}"></div>
                                <select id="card_type" class="hidden">
                                    <option value="1">身份证</option>
                                    <option value="2">军官证</option>
                                </select>
                            </td>
                            <td class="ltd">
                                <span class="idata"></span>
                                <span id="cmber" class="gray">证件号 : </span>
                            </td>
                            <td>                            
                                <div><input type="text" id="id_number"  readonly  value="{$human.doc_number}" /></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">手机 : </span>
                            </td>
                            <td>
                                <div><input type="text" id="phone" readonly  value="{$human.mobile}" /></div>
                            </td>
                            <td class="ltd">
                                <span class="gray">座机 : </span>
                            </td>
                            <td>
                                <div><input type="text"  readonly  id="fix_phone" value="{$human.phone}" /></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">Email : </span>
                            </td>
                            <td>
                                <div><input type="text"  readonly   id="uemail" value="{$human.email}" /></div>
                            </td>
                            <td class="ltd">
                                <span class="gray">传真 : </span>
                            </td>
                            <td>
                                <div><input type="text"  readonly  id="fax" value="{$human.fax}" /></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">QQ : </span>
                            </td>
                            <td>
                                <div><input type="text"  readonly   id="uqq" value="{$human.qq}"/></div>
                            </td>
                            <td class="ltd"> <span class="gray">邮编 :</span></td>
                            <td>
                                <div><input type="text"  readonly  value="{$human.zipcode}" id="post_number"/></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd ltop"> <span class="gray">通信地址 : </span></td>
                            <td colspan="3">
                                <div class="adr_deail">
                                    <span class="pv_de" val="{$human.province_id}">{$human.province}</span>
                                    <select id="adr_pro" class="hidden" level="2">
                                        <option value="0"></option>
                                        <foreach name="provinces" item="pro">
                                            <option value="{$pro.id}">{$pro.name}</option>
                                        </foreach>
                                    </select> 
                                    <span class="city_de" val="{$human.city_id}">{$human.city}</span>
                                    <select id="adr_city" class="hidden" level="3">
                                        <foreach name="citys" item="ct">
                                            <option value="{$ct.id}">{$ct.name}</option>
                                        </foreach>
                                    </select> 
                                    <span class="ar_de" val="{$human.region_id}">{$human.region}</span>
                                    <select id="adr_reg" class="hidden" level="4">
                                        <foreach name="regions" item="re">
                                            <option value="{$re.id}">{$re.name}</option>
                                        </foreach>
                                    </select>
                                    <span class="cun" val="{$human.community_id}">{$human.community}</span>
                                    <select id="adr_community" class="hidden">
                                        <foreach name="communitys" item="cm">
                                            <option value="{$cm.id}">{$cm.name}</option>
                                        </foreach>
                                    </select>
                                    <div class="strt"><input type="text" id="street" value="{$human.address}" readonly /></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="b_next rf hidden">
                        <div class="btn_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" class="btn white" id="onenext" aid="{$human.attachment['att_human_id']}">保存</a>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <!--证书情况-->
                <div class="mod_1 area_cert updatedata">
                    <div class="mtitle">
                        <h2 class="lf">证书情况</h2>
                        <a href="javascript:;" class="blue rf base_edit " id="qalertitem" title="修改">修改</a>
                    </div>
                    <div class="clr"></div>                    
                    <table class="tb_cm mod">
                        <tr>
                            <td class="ltd ltop">
                                <span class="gray">资质证书：</span>
                            </td>
                            <td id="myquals">
                        <if condition="$human.certificate_copy neq ''">
                            <foreach name="human.certificate_copy" item="copy" key="val">
                                <div class="qualitem">
                                    <input type="hidden" name="certificate_id" value="{$val}"/>
                                    <span>{$copy}</span>
                                    <a href="javascript:;" class="addqual rf ">添加</a>
                                    <a href="javascript:;" class="delqual rf ">删除</a>
                                </div>
                            </foreach>
                        </if>
                        <foreach name="human.aptitude" item="ap">
                            <if condition="$ap[industry] neq ''">
                                <div class="qualitem">
                                    <span>{$ap['certificate']}-{$ap['industry']}-{$ap['reg_case']}-{$ap['province']}</span>
                                    <a href="javascript:;" class="addqual rf ">添加</a>
                                    <a href="javascript:;" class="delqual rf" cid="{$ap['apt_human_id']}">删除</a>
                                </div>
                                <else/>
                                <div class="qualitem">
                                    <span>{$ap['certificate']}-{$ap['reg_case']}-{$ap['province']}</span>
                                    <a href="javascript:;" class="addqual rf ">添加</a>
                                    <a href="javascript:;" class="delqual rf" cid="{$ap['apt_human_id']}">删除</a>
                                </div>
                            </if>
                        </foreach>
                        <input class="mselect qual_select cert_box" id="tqual" readonly type="text" style="display:none;cursor: pointer; " />
                        <a href="javascript:;" id="savequal" class="blue">保存</a>
                        <a href="javascript:;" id="cancelqual" class="blue">取消</a>                        
                        </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">职称证：</span>
                            </td>
                            <td>
                                <input type="hidden" name="levid" value="{$human.title['level_id']}" />
                                <input type="hidden" name="type_id"value="{$human.title['type_id']}" />
                                <input type="hidden" name="nm_id" value="{$human.title['id']}" />
                        <if condition="$human.title neq ''">
                            <input class="mselect cert_box" type="text"  readonly id="tjtitle" cid="{$human.title['id']}" ttid="{$human.title['type_id']}" gra="{$human.title['level_id']}" value="{$human.title['level']}-{$human.title['name']}"/>
                            <else /><input class="mselect cert_box" type="text"  readonly id="tjtitle" cid="{$human.title['id']}" ttid="{$human.title['type_id']}" gra="{$human.title['level_id']}" value="" style="cursor:default;"/>
                        </if>
                        </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">报价：</span>
                            </td>
                            <td>
                                <input type="text" value="{$human.quote}" readonly class="pbox" id="hprice" /> 万 / 年
                            </td>
                        </tr>
                    </table>
                    <div class="b_next rf hidden">
                        <div class="btn_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" class="btn white" id="qualisv">保存</a>
                        </div>
                    </div>
<!--                    <div class="btn_common btn15_common btn15">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>                            
                            <a href="{$web_root}/acpresume/" title="创建简历" target="_blank" id="creat_res" class="btn white">创建简历</a>                                          
                    </div>-->
                    <div class="clr"></div>
                </div>
                <!--交易记录-->
                <div class="mod_1 area_record up">
                    <div class="mtitle">
                        <h2 class="lf">交易记录</h2>
                        <a href="javascript:;" title="修改" class="edt_p ad_rd blue rf "  rel="{$sta['status_id']}">添加</a>
                    </div>
                    <if condition="$human.status  neq ''">
                        <div class="list_deal">
                            <else /><div class="list_deal hidden">
                                </if>
                                <div class="dp gray lf">阶段</div>
                                <div class="d_rd  gray lf">记录</div>
                                <div class="clr"></div>
                            </div>
                            <ul id="rcord_detail">
                                <foreach name="human.status" item="sta">
                                    <li>
                                        <div class="dp lf">
                                            <span val="{$sta['cate_id']}">{$sta['cate_name']}</span>
                                            <if condition="$sta['pro_name'] neq ''">
                                                <span val="{$sta['pro_id']}">-{$sta['pro_name']}</span>
                                            </if>
                                        </div>
                                        <div class="d_rd lf">
                                            <p class="deal_recod"><span class="notes">{$sta['status_notes']}</span>
                                                <span>
                                                    <a href="javascript:;" title="修改" class="edt_p" rel="{$sta['status_id']}"></a>
                                                </span>
                                            </p>
                                            <p class="clr"></p>
                                        </div>
                                        <div class="clr"></div>
                                    </li>
                                </foreach>
                            </ul>
                            <div class="clr"></div>
                        </div>
                        <!--开户行-->
                        <div class="mod_1 area_bank updatedata">
                            <div class="mtitle">
                                <h2 class="lf">开户行</h2>
                                <if condition="$human.bank neq ''">
                                    <a href="javascript:;" class="blue rf base_edit " title="修改">修改</a>
                                    <else /><a href="javascript:;" class="blue rf base_add " title="添加">添加</a>
                                </if>
                            </div>
                            <div class="clr"></div>
                            <if condition="$human.bank eq ''">
                                <table class="tb_cm mod hidden">
                                    <else /> <table class="tb_cm mod">
                                        </if>
                                        <tr>
                                            <td class="ltd ">
                                                <span class="gray"><b class="red">*</b>开户名：</span>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" id="acount_name" class="bbox"readonly value="{$human.bank['username']}" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ltd ">
                                                <span class="gray"><b class="red">*</b>开户行：</span>
                                            </td>
                                            <td>
                                                <input type="text" value="{$human.bank['name']}" class="cbox"readonly id="bank_name" /> 
                                            </td>
                                            <td class="ltd">
                                                <span class="gray"><b class="red">*</b>开户账号：</span>
                                            </td>
                                            <td>
                                                <input type="text" value="{$human.bank['account']}" class="cbox"readonly id="acount_nm"/> 
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="b_next rf hidden">
                                        <div class="btn_common btn4">
                                            <span class="b_lf"></span>
                                            <span class="b_rf"></span>
                                            <a href="javascript:;" class="btn white" id="sv_bk" bid="{$human.bank['id']}">保存</a>
                                        </div>
                                    </div>
                                    <div class="clr"></div>
                                    </div>
                                    <!--注册企业信息-->
                                    <div class="mod_1 area_recmpy updatedata">
                                        <div class="mtitle">
                                            <h2 class="lf">注册企业信息</h2>
                                            <if condition="$human.employ neq ''">
                                                <a href="javascript:;" class="blue rf base_edit " title="修改" id="recmy_edit">修改</a>
                                                <else /><a href="javascript:;" class="blue rf base_add " title="添加" id="recmy_edit">添加</a>
                                            </if>
                                        </div>
                                        <div class="clr"></div>
                                        <if condition="$human.employ neq ''">
                                            <table class="tb_cm mod ">
                                                <else /><table class="tb_cm mod hidden">
                                                    </if>
                                                    <tr>
                                                        <td class="ltd">
                                                            <span class="gray"><b class="red">*</b>企业名称：</span>
                                                        </td> 
                                                        <td colspan="3">
                                                            <input type="text" readonly id="recname" value="{$human.employ['name']}" class="mcbox" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ltd">
                                                            <span class="gray">联系人：</span>
                                                        </td> 
                                                        <td>
                                                            <input type="text" readonly  id="person" value="{$human.employ['charger']}" />
                                                        </td>
                                                        <td class="ltd">
                                                            <span class="gray">聘用工资：</span>
                                                        </td>
                                                        <td>
                                                            ¥ <input type="text" readonly value="{$human.employ['pay']}" class="sx" id="salry" /> 万/年
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ltd">
                                                            <span class="gray">签约时间：</span>
                                                        </td>
                                                        <td>
                                                            <div class="tm"><input type="text" value="{$human.employ['sign_time']}" readonly id="sign_date" /></div>
                                                        </td>
                                                        <td class="ltd">
                                                            <span class="gray"> 合同期：</span>
                                                        </td>
                                                        <td>
                                                            <div class="csouce" val="{$human.employ['contract']}"></div>
                                                            <select id="agreement" class="hidden">
                                                                <option value="1">1年</option>
                                                                <option value="2">2年</option>
                                                                <option value="3">3年</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ltd">
                                                            <span class="gray">到期时间：</span>
                                                        </td>
                                                        <td>
                                                            <div class="tm"><input type="text" value="{$human.employ['expr_time']}"  readonly id="end_date" /></div>
                                                        </td>
                                                        <td class="ltd">
                                                            <span class="gray">付款时间：</span>
                                                        </td>
                                                        <td>
                                                            <div class="tm"><input type="text" value="{$human.employ['pay_time']}" readonly id="pay_date" /></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ltd">
                                                            <span class="gray">付款方式：</span>
                                                        </td>
                                                        <td>
                                                            <div class="paym csouce" val="{$human.employ['payment']}"></div>
                                                            <select id="pay_meth" class="hidden">
                                                                <option value="1">一年一付</option>
                                                                <option value="2">两年一付</option>
                                                                <option value="3">三年一付</option>
                                                                <option value="4">一次性付清</option>
                                                            </select>  
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ltd">
                                                            <span class="gray">单位地址：</span>
                                                        </td>
                                                        <td colspan="3">
                                                            <div class="adr_deail cstr">
                            <!--                                    <span class="pv_de" val="{$human.province_id}">{$human.province}</span>
                                                                <select id="rec_adr_pro" class="hidden" level="2">
                                                                    <foreach name="provinces" item="pro">
                                                                        <option value="{$pro.id}">{$pro.name}</option>
                                                                    </foreach>
                                                                </select> 
                                                                <span class="city_de" val="{$human.city_id}">{$human.city}</span>
                                                                <select id="rec_adr_city" class="hidden" level="3">
                                                                    <foreach name="citys" item="ct">
                                                                        <option value="{$ct.id}">{$ct.name}</option>
                                                                    </foreach>
                                                                </select> 
                                                                <span class="ar_de" val="{$human.region_id}">{$human.region}</span>
                                                                <select id="rec_adr_reg" class="hidden" level="4">
                                                                    <foreach name="regions" item="re">
                                                                        <option value="{$re.id}">{$re.name}</option>
                                                                    </foreach>
                                                                </select>
                                                                <span class="cun" val="{$human.community_id}">{$human.community}</span>
                                                                <select id="rec_adr_community" class="hidden">
                                                                    <foreach name="communitys" item="cm">
                                                                        <option value="{$cm.id}">{$cm.name}</option>
                                                                    </foreach>
                                                                </select> -->
                                                                <input type="text" id="cstreet" class="strbox" value="{$human.employ['location']}" readonly />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="b_next rf hidden">
                                                    <div class="btn_common btn4">
                                                        <span class="b_lf"></span>
                                                        <span class="b_rf"></span>
                                                        <a href="javascript:;" class="btn white" id="enter_sv">保存</a>
                                                    </div>
                                                </div>
                                                <div class="clr"></div>
                                                </div>
                                                <!--文件管理-->
                                                <div class="mod_1 area_file">
                                                    <div class="mtitle">
                                                        <h2 class="lf">文件管理</h2>
                                                        <a href="javascript:;" class="blue rf upfile ">添加文件</a>                                
                                                    </div>
                                                    <if condition="$human.attach neq null">
                                                        <table class="tb_cm">
                                                            <else /><table class="tb_cm hidden">
                                                                </if>
                                                                <tr>
                                                                    <td class="ltd ltop"><span class="gray">资历证件：</span></td>
                                                                    <td id="a_id">
                                                                <foreach name="human.attach[4]" item="att">
                                                                    <div class="m_file">
                                                                        <span class="cd_name" value="{$att['att_id']}" >{$att['att_name']}</span>
                                                                        <span class="m_d">                                                    
                                                                            <a href="{$web_root}/{$att['att_path']}" title="下载" class="blue download ">下载</a>
                                                                            <span>|</span>
                                                                            <a href="javascript:;" title="删除" rel="{$att['att_relation_id']}" class="blue dele_ct ">删除</a>
                                                                        </span>
                                                                    </div>
                                                                </foreach>                                    
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ltd ltop"><span class="gray">身份证件：</span></td>
                                                                    <td id="b_id">  
                                                                <foreach name="human.attach[1]" item="att">
                                                                    <div class="m_file">
                                                                        <span class="cd_name" value="{$att['att_id']}" >{$att['att_name']}</span>
                                                                        <span class="m_d">                                                    
                                                                            <a href="{$web_root}/{$att['att_path']}" title="下载" class="blue download ">下载</a>
                                                                            <span>|</span>
                                                                            <a href="javascript:;" title="删除" rel="{$att['att_relation_id']}" class="blue dele_ct ">删除</a>
                                                                        </span>
                                                                    </div>
                                                                </foreach>                                 
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ltd ltop"><span class="gray">合同文件：</span></td>
                                                                    <td id="c_id">  
                                                                <foreach name="human.attach[3]" item="att">
                                                                    <div class="m_file">
                                                                        <span class="cd_name" value="{$att['att_id']}" >{$att['att_name']}</span>
                                                                        <span class="m_d">                                                    
                                                                            <a href="{$web_root}/{$att['att_path']}" title="下载" class="blue download ">下载</a>
                                                                            <span>|</span>
                                                                            <a href="javascript:;" title="删除" rel="{$att['att_relation_id']}" class="blue dele_ct ">删除</a>
                                                                        </span>
                                                                    </div>
                                                                </foreach>  
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ltd ltop"><span class="gray">其他文件：</span></td>
                                                                    <td id="d_id">
                                                                <foreach name="human.attach[9]" item="att">
                                                                    <div class="m_file">
                                                                        <span class="cd_name" value="{$att['att_id']}" >{$att['att_name']}</span>
                                                                        <span class="m_d">                                                    
                                                                            <a href="{$web_root}/{$att['att_path']}" title="下载" class="blue download ">下载</a>
                                                                            <span>|</span>
                                                                            <a href="javascript:;" title="删除" rel="{$att['att_relation_id']}" class="blue dele_ct ">删除</a>
                                                                        </span>
                                                                    </div>
                                                                </foreach>  
                                                                </td>
                                                                </tr>
                                                            </table>
                                                            <div class="b_next rf hidden">
                                                                <div class="btn_common btn4">
                                                                    <span class="b_lf"></span>
                                                                    <span class="b_rf"></span>
                                                                    <a href="javascript:;" class="btn white" id="">保存</a>
                                                                </div>
                                                            </div>
                                                            <div class="clr"></div>
                                                            </div>
                                                            <!--备注-->
                                                            <div class="mod_1 area_bake updatedata">
                                                                <div class="mtitle">
                                                                    <h2 class="lf">备注</h2>
                                                                    <if condition="$human.remark neq ''">
                                                                        <a href="javascript:;" class="blue rf base_edit " title="修改" id="back_edit">修改</a>
                                                                        <else /><a href="javascript:;" class="blue rf base_add " title="添加" id="back_edit">添加</a>
                                                                    </if>
                                                                </div>
                                                                <div class="clr"></div>
                                                                <if condition="$human.remark neq ''">
                                                                    <table class="tb_cm mod">
                                                                        <else /><table class="tb_cm mod hidden">
                                                                            </if>
                                                                            <tr>
                                                                                <td class="ltd ltop">
                                                                                    <span class="gray">备注：</span>
                                                                                </td>
                                                                                <td colspan="3">
                                                                                    <div class="adr_deail1">
                                                                                        <span>{$human.remark}</span>
                                                                                    </div>
                                                                                    <textarea id="bkup" class="hidden cin"> {$human.remark}</textarea>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <div class="b_next rf hidden">
                                                                            <div class="btn_common btn4">
                                                                                <span class="b_lf"></span>
                                                                                <span class="b_rf"></span>
                                                                                <a href="javascript:;" class="btn white" id="sv_bak">保存</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="clr"></div>
                                                                        </div>
                                                                        </div>
                <div class="layout1_nr rf">
                   <div class="side_bx">
                      <ul class="r_sd" id="r_sd">
                            <li>
                                <a href="#" title="基本信息" class="lf"><em class="arrow_m"></em>基本信息</a>
                                <span class="gray rf">{$human.humanInforPercent}</span>
                            </li>
                            <li>
                                <a href="javascript:;" title="证书情况" class="lf"><em class="arrow_m"></em>证书情况</a>
                            <if condition="$human.humanCertPercent eq ''">
                                <span class="gray rf">-</span>
                                <else /><span class="gray rf">{$human.humanCertPercent}</span>
                            </if>
                            </li>
                            <li>
                                <a href="javascript:;" title="交易记录" class="lf"><em class="arrow_m"></em>交易记录</a>
                            <if condition="$human.humanStatusPercent eq ''">
                                <span class="gray rf">-</span>
                                <else /><span class="gray rf exist_c"></span>
                            </if>
                            </li>
                            <li>
                                <a href="javascript:;" title="开户行" class="lf"><em class="arrow_m"></em>开户行</a>
                            <if condition="$human.humanBankPercent eq ''">
                                <span class="gray rf">-</span>
                                <else /><span class="gray rf exist_c"></span>
                            </if>
                            </li>
                            <li>
                                <a href="javascript:;" title="注册企业信息" class="lf"><em class="arrow_m"></em>注册企业信息</a>
                                <span class="gray rf">{$human.humanRegisterPercent}</span>
                            </li>
                            <li>
                                <a href="javascript:;" title="文件管理" class="lf"><em class="arrow_m"></em>文件管理</a>
                                <span class="gray rf">{$human.humanAttPercent}</span>
                            </li>
                            <li>
                                <a href="javascript:;" title="备注" class="lf"><em class="arrow_m"></em>备注</a>
                            <if condition="$human.remark eq ''">
                                <span class="gray rf">-</span>
                                <else /><span class="gray rf exist_c"></span>
                            </if>
                            </li>
                        </ul>
                      <div class="clr"></div>
                    </div>
                </div>
           </div>
        <div class="clr"></div>
    </body>
</html>
