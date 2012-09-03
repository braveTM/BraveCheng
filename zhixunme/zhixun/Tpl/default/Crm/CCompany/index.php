<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>公司客户档案详细</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$crm_root}/css/resource_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/select-hgs/select-hgs.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/jquery-datepicker/jquery.ui.datepicker.css"/>
        <link type="text/css" rel="stylesheet" href="{$js_root}/{$jqlib}/mask/mask.css">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$crm_root}/config/loader.js" id="loader">97</script>
    </head>
    <body>
        <!-- layout::Home:Public:simpleheader::0 -->
        <div class="layout1 cdetail comdetail com_lde ">
            <div class="sm_tab">
                <ul>
                    <li class="cur_li"><a href="javascript:;">企业档案详细</a></li>
                </ul>
                <div class="sub_title">
                    <a href="javascript:;" title="" class="blue">客户管理</a>
                </div>
            </div>
            <div class="layout1_nl lf base_info">
                <input type="hidden" name="eid" value="{$company.id}" rel="false" />
                <!--基本资料-->
                <div class="mod_1 cbasic area_basic updatedata">
                    <div class="mtitle">
                        <h2 class="lf">基本信息</h2>
                        <a href="javascript:;" class="blue rf base_edit " title="修改" id="cmpy_bdit">修改</a>
                    </div>
                    <div class="clr"></div>
                    <table class="tbase tb_cm mod">
                        <tr>
                            <td class="ltd">
                                <span class="gray"><b class="red">*</b>企业名称 : </span>
                            </td>
                            <td colspan="3">
                                <div><input type="text" id="ename" readonly class="nmbox"  eid="{$company.id}" value="{$company.name}" ></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">企业性质 : </span>
                            </td>
                            <td colspan="1">
                                <div class="csouce" val="{$company.type_id}">{$company.type}</div>
                                <select id="cnature" class="hidden">
                                    <option value="0">不限</option>
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
                            <td class="ltd">
                                <span class="gray">客户来源 : </span>
                            </td>
                            <td>
                                <div class="csouce" val="{$company.source_id}">{$company.source}</div>
                                <select id="custom_surce" class="hidden">
                                    <foreach name="source" item="sc">
                                        <option value="{$sc.id}">{$sc.name}</option>
                                    </foreach>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">成立时间 : </span>
                            </td>
                            <td>
                                <div class="tm"><input id="fd_date" readonly type="text" value="{$company.found_time}" /></div>
                            </td>
                            <td class="ltd">
                                <span class="gray">网址 : </span>
                            </td>
                            <td class="rtd" colspan="3">
                                <div><input  type="text" id="website" readonly class="cbox" value="{$company.site}"  /></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd ltop">
                                <span class="gray">企业介绍 : </span>
                            </td>
                            <td colspan="3">
                                <span class="short_brief">
                                    <span class="fct">{$company.brief_short}</span>
                                    <if condition="$company.brief neq ''">
                                        <a href="javascript:;" title="查看全部" class="blue fold">查看全部>></a>
                                        <else /><a href="javascript:;" title="查看全部" class="blue fold hidden">查看全部>></a>
                                    </if>
                                </span>
                                <div class="all_cnt hidden">
                                    <span class="foldall">{$company.brief}</span><a href="javascript:;" title="收起" class="blue unfold"><<收起</a>
                                </div>
                                <textarea id="ect" class="cin hidden comshort">{$company.brief}</textarea>
                            </td>
                        </tr>
                    </table>
                    <div class="b_next rf hidden">
                        <div class="btn_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" class="btn white" id="save_cbasic">保存</a>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <!--企业资质-->
                <div class="mod_1 area_cert updatedata">
                    <div class="mtitle">
                        <h2 class="lf">企业资质</h2>
                        <a href="javascript:;" class="blue rf base_edit" title="修改" id="cqual">修改</a>
                    </div>
                    <div class="clr"></div>
                    <table class="tb_cm mod">
                        <tr>
                            <td class="ltd ltop">
                                <span class="gray"><b class="red">*</b>企业资质：</span>
                            </td>
                            <td id="myquals">
                        <foreach name="company.nature" item="na">
                            <if condition="$na['nature_name'] neq ''">
                                <div class="qualitem upsats">
                                    <span>
                                        <input type="text" id="cq{$key}"readonly value="{$na['nature_name']}" class="cqbox"/>
                                        <a href="javascript:;" class="sqv cmon hidden ">保存</a>
                                    </span>
                                    <a href="javascript:;" class="addcq rf ">添加</a>
                                    <a href="javascript:;" class="delcq rf " rel="{$na['cn_id']}">删除</a>
                                    <a href="javascript:;" class="updecq rf " rel="{$na['cn_id']}">修改</a>
                                </div>
                            </if>
                        </foreach>
                        <input class="cert_box" id="enter_cqual"  type="text" style="display:none;" />
                        <a href="javascript:;" id="sv_cq" class="blue ">保存</a>
                        <a href="javascript:;" id="cancle_cqual" class="blue">取消</a>
                        </td>
                        </tr>
                    </table>
                </div>
                <!--联系方式-->
                <div class="mod_1 area_basic updatedata contacter">
                    <div class="mtitle">
                        <h2 class="lf">联系方式</h2>
                        <a href="javascript:;" class="blue rf base_edit " title="修改" id="cmpy_bdit">修改</a>
                    </div>
                    <div class="clr"></div>
                    <table class="tbase tb_cm mod">
                        <tr>
                            <td class="ltd">
                                <span class="gray"><b class="red">* </b>联系人 : </span>
                            </td>
                            <td>
                                <div><input type="text" readonly id="contacter" value="{$company.contact}"/></div>
                            </td>
                            <td class="ltd">
                                <span class="gray">手机 : </span>
                            </td>
                            <td>
                                <div><input type="text"readonly id="phone" value="{$company.mobile}"/></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">Email : </span>
                            </td>
                            <td>
                                <div><input type="text"readonly id="uemail" value="{$company.email}" /></div>
                            </td>
                            <td class="ltd">
                                <span class="gray">座机 : </span>
                            </td>
                            <td>
                                <div><input type="text"readonly id="fix_phone" value="{$company.phone}" /></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">QQ : </span>
                            </td>
                            <td>
                                <div><input type="text" readonly id="uqq" value="{$company.qq}" /></div>
                            </td>
                            <td class="ltd">
                                <span class="gray">传真 : </span>
                            </td>
                            <td>
                                <div><input type="text"readonly id="fax" value="{$company.fax}" /></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd">
                                <span class="gray">邮编：</span>
                            </td>
                            <td>
                                <div><input type="text" readonly value="{$company.zipcode}" id="post_number" /></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ltd ltop">
                                <span class="gray">通信地址：</span>
                            </td>
                            <td colspan="3">
                                <div class="adr_deail">
                                    <span class="pv_de" val="{$company.province_id}">{$company.province}</span>
                                    <select id="adr_pro" class="hidden" level="2">
                                          <option value="0"></option>
                                        <foreach name="provinces" item="pro">
                                            <option value="{$pro.id}">{$pro.name}</option>
                                        </foreach>
                                    </select> 
                                    <span class="city_de" val="{$company.city_id}">{$company.city}</span>
                                    <select id="adr_city" class="hidden" level="3">
                                        <foreach name="citys" item="ct">
                                            <option value="{$ct.id}">{$ct.name}</option>
                                        </foreach>
                                    </select> 
                                    <span class="ar_de" val="{$company.region_id}">{$company.region}</span>
                                    <select id="adr_reg" class="hidden" level="4">
                                        <foreach name="regions" item="re">
                                            <option value="{$re.id}">{$re.name}</option>
                                        </foreach>
                                    </select>
                                    <span class="cun" val="{$company.community_id}">{$company.community}</span>
                                    <select id="adr_community" class="hidden">
                                        <foreach name="communitys" item="cm">
                                            <option value="{$cm.id}">{$cm.name}</option>
                                        </foreach>
                                    </select> 
                                    <div class="strt"><input type="text" id="street" value="{$company.address}" readonly /></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="b_next rf hidden">
                        <div class="btn_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" class="btn white " id="save_contacter">保存</a>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <!--企业需求-->
                <div class="mod_1 area_require">
                    <div class="mtitle">
                        <h2 class="lf">企业需求</h2>
                        <if condition="$company.demand neq 0">
                            <a href="javascript:;" class="blue rf base_edit " title="修改" id="require_edit">修改</a>
                            <else /><a href="javascript:;" class="blue rf base_edit " title="添加" id="require_edit">添加</a>
                        </if>
                    </div>
                    <div class="clr"></div>
                    <div class="list_quire">
                        <foreach name="company.demand" item="de">
                            <div class="quire_item updatedata">
                                <table class="tb_cm mod require">
                                    <tr>
                                        <td class="ltd">
                                            <span class="gray"><b class="red">*</b>资质证书：</span>
                                        </td>
                                        <td class="requalis" colspan="3">
                                            <div class="qualitem">
                                                <input type="hidden" name="rct" value="{$de['demand_apt_id']}" />
                                                <input type="hidden" name="regct" value="{$de['demand_reg_info_id']}" />
                                                <input type="hidden" name="nbm" value="{$de['demand_need_num']}" />
                                                <input type="text" id="quali{$key}" class="mselect qquali" value="{$de['cert_name']}-{$de['in_name']}-{$de['demand_reg_info']}-{$de['demand_need_num']}人" readonly style="cursor: default;" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="gray"><b class="red">*</b>人才聘用费：</span>
                                        </td>
                                        <td>
                                            ¥ <input type="text" readonly value="{$de['demand_need_price']}"  class="fees com" /> 万 /
                                            <input type="text"  readonly value="{$de['demand_need_year']}"  class="years com" /> 年·人
                                        </td>
                                        <td class="ltd">
                                            <span class="gray"><b class="red">*</b>服务费：</span>
                                        </td>
                                        <td>
                                            ¥ <input type="text"readonly  value="{$de['demand_service_charge']}"  class="sfee" /> 元/人
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="gray">是否含税：</span>
                                        </td>
                                        <td>
                                            <span class="txtinfo" val="{$de['demand_is_tax']}">{$de['demand_tax']}</span>
                                            <input type="radio" class="hidden tax" value="0"/><span class="txthid hidden ">否</span>
                                            <input type="radio" class="hidden tax" value="1"/><span class="txthid hidden ">是</span>
                                        </td>
                                        <td class="ltd">
                                            <span class="gray">证书用途：</span>
                                        </td>
                                        <td>
                                            <div val="{$de['demand_use_id']}" class="csouce">{$de['demand_use']}</div>
                                            <select  class="hidden usage" >
                                                <option value="1">升级</option>
                                                <option value="2">年检</option>
                                                <option value="3">投标</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="gray">证书选项：</span>
                                        </td>
                                        <td>
                                            <span class="txtinfo" val="{$de['demand_is_fulltime']}">{$de['demand_fulltime']}</span>
                                            <input type="radio" class="fl_tm hidden" value="1"/>
                                            <span class="txthid hidden">兼职</span>
                                            <input type="radio" class="fl_tm hidden" value="2"/>
                                            <span class="txthid hidden">全职</span>
                                            <input type="radio" class="fl_tm hidden "value="0"/>
                                            <span class="txthid hidden">不限</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd ltop">
                                            <span class="gray lf">补充说明：</span>
                                        </td>
                                        <td colspan="3">
                                            <div class="adr_deail1"><span>{$de['demand_notes']}</span></div>
                                            <textarea readonly class="cin lf hidden">{$de['demand_notes']}</textarea>
                                        </td>
                                    </tr>
                                </table>
                                <div class="dbtn">
                                    <a href="javascript:;" title="修改" class="blue svquire " rel="{$de['demand_id']}">保存</a>
                                    <a href="javascript:;" title="修改" class="blue upquire " rel="{$de['demand_id']}">修改</a>
                                    <a href="javascript:;" title="添加" class="blue addquire ">添加</a>
                                    <a href="javascript:;" title="删除" class="blue delequire " rel="{$de['demand_id']}">删除</a>
                                </div>
                            </div>
                        </foreach>
                        <table class="tb_cm hidden" id="adn_quire">
                            <tr>
                                <td class="ltd">
                                    <span class="gray">资质证书：</span>
                                </td>
                                <td id="requalis" colspan="3">
                                    <input type="hidden" name="rct" value="" />
                                    <input type="hidden" name="regct" value="" />
                                    <input type="hidden" name="nbm" value="" />
                                    <input type="text" readonly id="carea_ct" class="mselect" />
                                </td>
                            </tr>
                            <tr>
                                <td class="ltd">
                                    <span class="gray">人才聘用费：</span>
                                </td>
                                <td>
                                    ¥ <input type="text" id="tohir_fee" class="com" /> 万 /
                                    <input type="text"  id="unit" class="com" /> 年·人
                                </td>
                                <td class="ltd">
                                    <span class="gray">服务费：</span>
                                </td>
                                <td>
                                    ¥ <input type="text"id="sevr_fee" class="sfee" /> /人
                                </td>
                            </tr>
                            <tr>
                                <td class="ltd">
                                    <span class="gray">是否含税: </span>
                                </td>
                                <td>
                                    <span class="txtinfo hidden" val="1"></span>
                                    <input type="radio" name="tax" id="tax"value="0"/>
                                    <span class="txthid">是</span>
                                    <input type="radio" name="tax" id="tax_n" value="1"/>
                                    <span class="txthid">否</span>
                                </td>
                                <td class="ltd">
                                    <span class="gray">证书用途：</span>
                                </td>
                                <td>
                                    <div val="" class="csouce hidden"></div>
                                    <select id="usage">
                                        <option value="1">升级</option>
                                        <option value="2">年检</option>
                                        <option value="3">投标</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="ltd">
                                    <span class="gray">证书选项：</span>
                                </td>
                                <td>
                                    <span class="txtinfo hidden" val="1"></span>
                                    <input type="radio" name="is_ful"value="1"/>
                                    <span class="txthid">兼职</span>
                                    <input type="radio" name="is_ful"value="2"/>
                                    <span class="txthid">全职</span>
                                    <input type="radio" name="is_ful"value="0"/>
                                    <span class="txthid">不限</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="ltd ltop">
                                    <span class="gray lf">补充说明：</span>
                                </td>
                                <td colspan="3">
                                    <div class="adr_deail1 hidden"></div>
                                    <textarea id="additional" class="cin lf"></textarea>
                                </td>
                            </tr>
                        </table>
                        <div class="b_next rf hidden">
                            <div class="btn_common btn4">
                                <span class="b_lf"></span>
                                <span class="b_rf"></span>
                                <a href="javascript:;" class="btn white " id="save_require">保存</a>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
                <!--交易记录-->
                <div class="mod_1 area_record ">
                    <div class="mtitle">
                        <h2 class="lf">交易记录</h2>
                        <a href="javascript:;" title="修改" class="edt_p ad_rd blue rf "  rel="{$sta['status_id']}">添加</a>
                    </div>
                    <if condition="$company.status neq ''">
                        <div class="list_deal">
                            <else /><div class="list_deal hidden">
                                </if>
                                <div class="dp gray lf">阶段</div>
                                <div class="d_rd  gray lf">记录</div>
                                <div class="clr"></div>
                            </div>
                            <ul id="rcord_detail">
                                <foreach name="company.status" item="sta">
                                    <li>
                                        <div class="dp lf">
                                            <span val="{$sta['cate_id']}">{$sta['cate_name']}</span>
                                            <if condition="$sta['pro_name'] neq ''">
                                                <span val="{$sta['pro_id']}">-{$sta['pro_name']}</span>
                                            </if>                                            
                                        </div>
                                        <div class="d_rd lf">
                                            <p class="deal_recod">
                                                <span class="notes">{$sta['status_notes']}</span>
                                                <span>
                                                    <a href="javascript:;" title="修改" class="edt_p " rel="{$sta['status_id']}"></a>
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
                        <!--注册人才信息-->
                        <div class="mod_1 area_repn ">
                            <div class="mtitle">
                                <h2 class="lf">注册人才信息</h2>
                                <if condition="$company.registers neq 0">
                                    <a href="javascript:;" class="blue rf base_edit " title="修改" id="repn_edit">修改</a>
                                    <else /><a href="javascript:;" class="blue rf base_edit " title="添加" id="repn_edit">添加</a>
                                </if>
                            </div>
                            <div class="clr"></div>
                            <div class="relis">
                                <foreach name="company.registers" item="reg">
                                    <div class="reg_lisitem  updatedata" name="regp{$key}"> 
                                        <table class="tb_cm  mod reginfo">
                                            <tr>
                                                <td class="ltd">
                                                    <span class="gray"><b class="red">* </b>姓名：</span>
                                                </td> 
                                                <td>
                                                    <input type="text" class="reg_name" value="{$reg['name']}" readonly />
                                                </td>
                                                <td class="ltd">
                                                    <span class="gray">性别：</span>
                                                </td> 
                                                <td>
                                                    <span class="txtinfo" val="{$reg['sex']}">{$reg['sex']}</span>
                                                    <input type="radio" class="csex hidden" value="0" />
                                                    <span class="txthid  hidden">男</span>
                                                    <input type="radio" class="csex hidden" value="1"/>
                                                    <span class="txthid hidden">女</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ltd">
                                                    <span class="gray"><b class="red">* </b>证书情况：</span>
                                                </td>
                                                <td colspan="3" class="regcert">
                                                    <div class="qualitem">
                                                        <input type="hidden" name="rct" value="{$reg['apt_id']}" />
                                                        <input type="hidden" name="regct" value="{$reg['reg_info_id']}" />
                                                        <input type="text" id="reg_cert{$key}" class="mselect reg_pquali" value="{$reg['cert_name']}" readonly style="cursor: default;" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ltd">
                                                    <span class="gray"><b class="red">* </b>聘用工资：</span>
                                                </td>
                                                <td>
                                                    ¥ <input type="text" readonly class="hired_sary fees com" value="{$reg[employ_pay]}"/> 万 / 年
                                                </td>
                                                <td class="ltd">
                                                    <span class="gray">签约时间：</span>
                                                </td>
                                                <td>
                                                    <div class="tm"><input type="text" id="sign{$key}"readonly class="sign_date date" value="{$reg['sign_time']}" /></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ltd">
                                                    <span class="gray"><b class="red">* </b>合同期：</span>
                                                </td>
                                                <td>
                                                    <input type="text" class="contracter fees" readonly value="{$reg['contract_period']}" /> 年
                                                </td>
                                                <td class="ltd">
                                                    <div class="tm"><span class="gray">到期时间：</span></div>
                                                </td>
                                                <td>
                                                    <div class="tm">
                                                        <input type="text"  id="end{$key}" value="{$reg['expiration_time']}" readonly class="end_date date" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ltd">
                                                    <span class="gray"><b class="red">* </b>付款方式：</span>
                                                </td>
                                                <td>
                                                    <input type="text" class="pay" value="{$reg['pay_way']}" readonly />
                                                </td>
                                            </tr>
                                            <tr class="fd_ops">
                                                <td class="ltd">
                                                    <span class="gray">付款时间：</span>
                                                </td>
                                                <td>
                                                    <div class="tm"><input type="text" id="paytime{$key}" value="{$reg['pay_time']}" readonly class="pay_date date" /></div>
                                                </td>
                                                <td class="ltd">
                                                    <span class="gray">退款：</span>
                                                </td>
                                                <td>
                                                    <span class="txtinfo" val="{$reg['is_refund']}">{$reg['is_refund']}</span>
                                                    <input type="radio" class="suc_y hidden" name="ref{$key}"  value="1" />
                                                    <span class="txthid  hidden ">是</span>
                                                    <input type="radio" class="suc_y hidden" name="ref{$key}"  value="0" />
                                                    <span class="txthid  hidden ">否</span>
                                                </td>
                                            </tr>
                                            <if condition="$reg['is_refund'] eq 1">
                                                <tr class="apd">
                                                    <td class="ltd">
                                                        <span class="gray">退款时间：</span>
                                                    </td>
                                                    <td>
                                                        <div class="tm"><input type="text" id="refund{$key}" value="{$reg['refund_time']}" readonly class="refund_date date" /></div>
                                                    </td>
                                                    <td class="ltd">
                                                        <span class="gray">退款金额：</span>
                                                    </td>
                                                    <td>
                                                        ¥ <input type="text" readonly class="refd_money sfee com" value="{$reg['refund_money']}"/> 元
                                                    </td>
                                                </tr>
                                                <tr class="apd">
                                                    <td class="ltd">
                                                        <span class="gray">退款企业签字人：</span>
                                                    </td>
                                                    <td>
                                                        <input type="text"readonly value="{$reg['refund_singor']}"  class="signer" />
                                                    </td>
                                                    <td class="ltd">
                                                        <span class="gray">退款我方负责人：</span>
                                                    </td>
                                                    <td>
                                                        <input type="text"readonly class="agenter" value="{$reg['refund_signer']}"/> 
                                                    </td>
                                                </tr>
                                                <tr class="apd">
                                                    <td class="ltd ltop">
                                                        <span class="gray">退款原因：</span>
                                                    </td>
                                                    <td colspan="3">
                                                        <div class="adr_deail1">
                                                            <span class="fctr">{$reg['refund_reseaon']}</span>
                                                        </div>
                                                        <span></span>
                                                        <textarea class="cin hidden reson">{$reg['refund_reseaon']}</textarea>
                                                    </td>
                                                </tr>
                                            </if>
                                        </table>
                                        <div class="dbtn">
                                            <a href="javascript:;"  class="blue svretan " title="保存" rel="{$reg['reg_com_id']}">保存</a>
                                            <a href="javascript:;" class="blue up_regp " title="修改" rel="{$reg['reg_com_id']}">修改</a> 
                                            <a href="javascript:;" class="blue add_regp " title="添加">添加</a>
                                            <a href="javascript:;" class="blue dele_regp " title="删除" rel="{$reg['reg_com_id']}">删除</a>     
                                        </div>
                                    </div>
                                </foreach>
                                <table class="tb_cm hidden" id="reg_fm">
                                    <tr>
                                        <td class="ltd">
                                            <span class="gray"><b class="red">*</b>姓名：</span>
                                        </td> 
                                        <td>
                                            <input type="text" id="reg_name" value=""  />
                                        </td>
                                        <td class="ltd">
                                            <span class="gray">性别：</span>
                                        </td> 
                                        <td>
                                            <span class="txtinfo hidden" val="0">女</span>
                                            <input type="radio" name="csex" value="1"/><span class="txthid">男</span>
                                            <input type="radio" name="csex" value="0"/><span class="txthid">女</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="gray"><b class="red">* </b>证书情况：</span>
                                        </td>
                                        <td colspan="3" class="regcert">
                                            <div class="qualitem">
                                                <input type="hidden" name="rct" value="" />
                                                <input type="hidden" name="regct" value="" />
                                                <input type="text" id="regct" class="mselect repquali" value="" readonly style="cursor: default;" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="gray"><b class="red">*</b>聘用工资：</span>
                                        </td>
                                        <td>
                                            ¥ <input type="text" id="hired_sary" value="" class="fees"/> 万 / 年
                                        </td>
                                        <td class="ltd">
                                            <span class="gray">签约时间：</span>
                                        </td>
                                        <td>
                                            <div class="tm">
                                                <input type="text" readonly id="sign_date" value=""/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="gray"><b class="red">*</b>合同期：</span>
                                        </td>
                                        <td>
                                            <input type="text" class="fees"  id="contracter" value="" />年
                                        </td>
                                        <td class="ltd">
                                            <span class="gray">到期时间：</span>
                                        </td>
                                        <td>
                                            <div class="tm"><input type="text" readonly value=""  id="end_date" /></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd ltop">
                                            <span class="gray"><b class="red">*</b>付款方式：</span>
                                        </td>
                                        <td>
                                            <input type="text" value="" id="pyment" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ltd">
                                            <span class="gray">付款时间：</span>
                                        </td>
                                        <td>
                                            <div class="tm"><input type="text" value="" readonly  id="pay_date" /></div>
                                        </td>
                                        <td class="ltd">
                                            <span class="gray">退款：</span>
                                        </td>
                                        <td>
                                            <span class="txtinfo hidden" val="1">是</span>
                                            <input type="radio" name="refund" value="1"/>
                                            <span class="txthid">是</span>
                                            <input type="radio" name="refund" value="0"  />
                                            <span class="txthid">否</span>
                                        </td>
                                    </tr>
                                    <tr class="apd">
                                        <td class="ltd">
                                            <span class="gray">退款时间：</span>
                                        </td>
                                        <td>
                                            <div class="tm"><input type="text" value="" readonly  id="refund_date" /></div>
                                        </td>
                                        <td class="ltd">
                                            <span class="gray">退款金额：</span>
                                        </td>
                                        <td>
                                            ¥ <input type="text"  id="refd_money" value="" class="sfee"/> 元
                                        </td>
                                    </tr>
                                    <tr class="apd">
                                        <td class="ltd">
                                            <span class="gray">退款企业签字人：</span>
                                        </td>
                                        <td>
                                            <input type="text" value=""  id="signer" />
                                        </td>
                                        <td class="ltd">
                                            <span class="gray">退款我方负责人：</span>
                                        </td>
                                        <td>
                                            <input type="text" id="agenter" value=""/> 
                                        </td>
                                    </tr>
                                    <tr class="apd">
                                        <td class="ltd ltop">
                                            <span class="gray">退款原因：</span>
                                        </td>
                                        <td colspan="3">
                                            <div class="adr_deail1">
                                                 <span class="fctr"></span>
                                            </div>
                                            <span></span>
                                            <textarea id="reson" class="cin"></textarea>
                                        </td>
                                    </tr>
                                </table>
                                <div class="b_next rf hidden">
                                    <div class="btn_common btn4">
                                        <span class="b_lf"></span>
                                        <span class="b_rf"></span>
                                        <a href="javascript:;" class="btn white " id="save_regperon">保存</a>
                                    </div>
                                </div>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <!--文件管理-->
                        <div class="mod_1 area_file">
                            <div class="mtitle">
                                <h2 class="lf">文件管理</h2>
                                <a href="javascript:;" class="blue rf upfile ">添加文件</a>
                            </div>
                            <if condition="$company.attach neq null">
                                <table class="tb_cm">
                               <else /><table class="tb_cm hidden">
                             </if>
                                <tr>
                                    <td class="ltd ltop"><span class="gray">资历证件：</span></td>
                                    <td id="a_id">
                                <foreach name="company.attach[4]" item="att">
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
                                    <foreach name="company.attach[1]" item="att">
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
                                        <foreach name="company.attach[3]" item="att">
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
                            </tr><tr>
                            <td class="ltd ltop"><span class="gray">其他文件：</span></td>
                            <td id="d_id">
                                <foreach name="company.attach[9]" item="att">
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
                            <a href="javascript:;" class="btn white " id="">保存</a>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
                <!--备注-->
                <div class="mod_1 area_bake updatedata">
                    <div class="mtitle">
                        <h2 class="lf">备注</h2>
                          <if condition="$company.remark neq ''">
                                <a href="javascript:;" class="blue rf base_edit " title="修改" id="back_edit">修改</a>
                                <else /><a href="javascript:;" class="blue rf base_add " title="添加" id="back_edit">添加</a>
                           </if>
                    </div>
                    <div class="clr"></div>
                     <if condition="$company.remark neq ''">
                        <table class="tb_cm mod">
                        <else /><table class="tb_cm mod hidden">
                      </if>
                        <tr>
                            <td class="ltd ltop">
                                <span class="gray">备注：</span>
                            </td>
                            <td>
                                <div class="adr_deail1">
                                    <span>{$company.remark}</span>
                                </div>
                                <textarea id="bkup" class="hidden cin"> {$company.remark}</textarea>
                            </td>
                        </tr>
                    </table>
                    <div class="b_next rf hidden">
                        <div class="btn_common btn4">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" class="btn white " id="csv_bak">保存</a>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
        </div>
        <div class="layout1_nr rf">
            <div class="side_bx">
                <ul class="r_sd" id="r_sd">
                    <li>
                        <a href="javascript:;" title="基本信息" class="lf"><em class="arrow_m"></em>基本信息</a>
                        <span class="gray rf">{$company.comInforPercent }</span>
                    </li>
                    <li>
                        <a href="javascript:;" title="企业资质" class="lf"><em class="arrow_m"></em>企业资质</a>
                    <if condition="$company.comNaturePercent eq ''">
                        <span class="gray rf">-</span>
                        <else /><span class="gray rf exist_c"></span>
                    </if>
                    </li>
                    <li>
                        <a href="javascript:;" title="联系方式" class="lf"><em class="arrow_m"></em>联系方式</a>
                        <span class="gray rf">{$company.comContactPercent}</span>
                    </li>
                    <li>
                        <a href="javascript:;" title="企业需求" class="lf"><em class="arrow_m"></em>企业需求</a>
                        <span class="gray rf">{$company.comDemandPercent }</span>
                    </li>
                    <li>
                        <a href="javascript:;" title="交易记录" class="lf"><em class="arrow_m"></em>交易记录</a>
                    <if condition="$company.comStatusPercent eq ''">
                        <span class="gray rf">-</span>
                        <else /><span class="gray rf">{$company.comStatusPercent }</span>
                    </if>
                    </li>
                    <li>
                        <a href="javascript:;" title="注册人才信息" class="lf"><em class="arrow_m"></em>注册人才信息</a>
                        <span class="gray rf">{$company.comRegisterPercent}</span>
                    </li>
                    <li>
                        <a href="javascript:;" title="文件管理" class="lf"><em class="arrow_m"></em>文件管理</a>
                        <span class="gray rf">{$company.comAttPercent}</span>
                    </li>
                    <li>
                        <a href="javascript:;" title="备注" class="lf"><em class="arrow_m"></em>备注</a>
                    <if condition="$company.remark eq ''">
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
