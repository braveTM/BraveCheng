/****************************** 后台数据访问路径配置 ******************************/
//公用数据访问路径
WEBURL={
    //common
    Login:WEBROOT+"/do_login",//登录
    Exit:WEBROOT+"/logout",//退出
    Statistic:WEBROOT+"/update_visit",/*更新登录状态*/
    GetCertsMajor:WEBROOT+"/get_rcert_major",/*获取资质证书专业*/
    GetCerts:WEBROOT+"/get_rcerts",/*获取资质证书类型列表*/
    GetGCertType:WEBROOT+"/get_gcert_type",/*获取职称证类型*/
    GetGCerts:WEBROOT+"/get_gcerts",/*获取指定职称证类型专业*/
    AGetCanInvitJob:WEBROOT+"/get_aci_job",/*猎头获取可用于邀请简历的职位*/
    ASendResumes:WEBROOT+"/a_sent_job",/*猎头投递所选的多份简历*/
    AInviteResumes:WEBROOT+"/a_invite_resume",/*猎头邀请简历*/
    EGetCanInvitJob:WEBROOT+"/get_eci_job",/*企业获取可用于邀请简历的职位*/
    EInvitResume:WEBROOT+"/e_invite_resume",/*企业邀请简历*/
    ResumeDetail:WEBROOT+"/get_resume",/*简历详细页*/
    LTimeRequest:WEBROOT+"/get_remind",/*长轮询*/
    PromoteInfo:WEBROOT+"/do_promote_info",/*信息推广*/
    JobPromote:WEBROOT+"/get_job_promote",/*职位推广*/
    ResumePromote:WEBROOT+"/get_resume_promote",/*简历推广*/
    DeleResume:WEBROOT+"/h_delegate_resume",/*委托简历*/
    GetAResumes:WEBROOT+"/a_get_own_human",/*获取指定猎头的人才列表*/
    GetPJobs:WEBROOT+"/Home/RCommon/get_p_jobs",/*获取全职的大分类*/
    GetCJobs:WEBROOT+"/Home/RCommon/get_c_jobs"/*获取全职指定大分类的小分类*/
};
CRMURL={
    GetHumanResourceLis:WEBROOT+"/Crm/CIndex/get_humans",/*获取人才资源列表*/
    GetCmRelist:WEBROOT+"/Crm/CIndex/get_companys",/*获取企业资源列表*/
    DeleHuamnsRes:WEBROOT+"/Crm/CIndex/do_delete_humans",//批量删除人才资源
    DeleEnterpriseRes:WEBROOT+"/Crm/CIndex/do_delete_companys",//批量删除企业资源
    GetFilterEnterResoue:WEBROOT+"/Crm/CIndex/get_companys_by_filter",/*获取筛选条件的企业资源列表数据*/
    GetfilterListHuman:WEBROOT+"/Crm/CIndex/get_humans_by_filter",/*获取筛选条件的人才资源列表数据*/
    DoupdateEnterprise:WEBROOT+"/Crm/CCompany/do_update_base",/*CRM更新企业基本信息*/
    AddEnterPriseQual:WEBROOT+"/Crm/CCompany/do_add_nature",/*CRM添加企业资质*/
    UpdateEnterpriseQual:WEBROOT+"/Crm/CCompany/do_update_nature",/*CRM更新企业资质*/
    DeleEnterQual:WEBROOT+"/Crm/CCompany/do_delete_nature",/*CRM删除企业资质*/
    GetAreaInfo:WEBROOT+"/Crm/CCommon/get_district",/*CRM获取城市地区*/
    DoUdateContacter:WEBROOT+"/Crm/CCompany/do_update_contact",/*CRM更新企业联系人*/
    GetCertsTpe:WEBROOT+"/Crm/CIndex/get_certificates",/*CRM获取资质证书*/
    GetGertMajor:WEBROOT+"/Crm/CIndex/get_industries",/*CRM获取资质证书对应专业*/
    GetZcType:WEBROOT+"/Crm/CIndex/get_title_types",/*CRM获取职称类别*/
    GetZCname:WEBROOT+"/Crm/CIndex/get_titles",/*CRM获取选中职称类别对应名称*/
    GetCrmProvinces:WEBROOT+"/Crm/CCommon/get_district",/*CRM获取省份数据*/
    UpHumanStatus:WEBROOT+"/Crm/CCommon/do_update_human_status",/*CRM更新人才状态*/
    UpEnterStatus:WEBROOT+"/Crm/CCommon/do_update_enter_status",/*CRM更新企业状态*/
    AddHumanStatus:WEBROOT+"/Crm/CCommon/do_add_human_status",/*CRM添加人才状态*/
    AddEnterStatus:WEBROOT+"/Crm/CCommon/do_add_enter_status",/*CRM添加企业状态*/
    TUpdateBase:WEBROOT+"/Crm/CHuman/do_update_base",/*人才更新基本信息*/
    UpEntEnterRequire:WEBROOT+"/Crm/CCompany/do_update_demand",/*CRM更新企业需求*/
    TUpdateAptiude:WEBROOT+"/Crm/CHuman/do_delete_aptitude",/*人才更新资质证书*/
    TUpdateBank:WEBROOT+"/Crm/CHuman/do_update_bank",/*人才更新开户行*/
    TUpdateEmploy:WEBROOT+"/Crm/CHuman/do_update_employ",/*人才更新注册企业信息*/
    TUpdateRemark:WEBROOT+"/Crm/CHuman/do_update_remark",/*人才更新备注*/
    DeleEnterRequire:WEBROOT+"/Crm/CCompany/do_delete_demand",/*CRM删除企业需求*/
    TAddQual:WEBROOT+"/Crm/CHuman/do_add_aptitude",/*人才添加资质证*/
    TDeleQual:WEBROOT+"/Crm/CHuman/do_delete_aptitude",/*人才删除资质*/
    TalDelOres:WEBROOT+"/Crm/CHuman/delete_certificate_copy",/*人才删除自己导入的资质证书*/
    TUpdateTitle:WEBROOT+"/Crm/CHuman/do_update_title",/*人才更新职称证*/
    AddEnterRequires:WEBROOT+"/Crm/CCompany/do_add_demand",/*CRM添加企业需求资质证书*/
    CUpdateRemark:WEBROOT+"/Crm/CCompany/do_update_remark",/*CRM添加企业需求*/
    AddEnterRegTa:WEBROOT+"/Crm/CCompany/do_add_register",/*CRM添加企业注册人才信息*/
    UpdateEnterRegTa:WEBROOT+"/Crm/CCompany/do_update_register",/*CRM更新企业注册人才信息*/
    DeleRgTan:WEBROOT+"/Crm/CCompany/do_delete_register",/*CRM更新企业注册人才信息*/
    DeleComReTan:WEBROOT+"/Crm/CCompany/do_delete_register",/*CRM删除企业注册人才信息*/
    AddResourceHuman:WEBROOT+"/Crm/CIndex/add_human",/*CRM创建人才信息*/
    AddCompanyResource:WEBROOT+"/Crm/CIndex/add_company",/*CRM创建企业信息*/
    Upfilehuman:WEBROOT+"/Crm/CHuman/do_upload_crmAttHuman",/*CRM人才附件上传*/
    UpfileCompany:WEBROOT+"/Crm/CCompany/do_upload_crmAttCompany",/*CRM企业附件上传*/
    ImportCvsHuman:WEBROOT+"/Crm/CHuman/do_upload_crmAttCsv",/*CVS人才文件导入*/
    ImportCvsCompany:WEBROOT+"/Crm/CCompany/do_upload_crmAttCsv",/*CVS企业文件导入*/
    SendHumanEmail:WEBROOT+"/Crm/CIndex/send_mail_human",/*CRM发送人才邮件*/
    SendCompanyEmail:WEBROOT+"/Crm/CIndex/send_mail_companys",/*CRM发送企业邮件*/
    CvsHumanTempXls:WEBROOT+"/Files/system/crm/human.xls",/*csv人才模板下载*/
    CvsCompanyTempXls:WEBROOT+"/Files/system/crm/company.xls",/*csv企业模板下载*/
    DelCrmAtt:WEBROOT+"/Crm/CIndex/do_delete_crmAtt"/*删除详情页附件*/
};
/****************************** 语言包 ******************************/
LANGUAGE={
    L0032:"请输入QQ号码",
    L0033:"QQ号码不能为空!",
    L0034:"QQ号码格式不正确!",
    L0039:"请输入电话号码",
    L0040:"电话号码格式不正确",
    L0041:"电话号码不能为空",
    L0042:"请输入你的简介,不超过140个字",
    L0043:"最多只能输入140个字",
    L0044:"简介不能为空",
    L0045:"该用户名可用",
    L0046:"请选择资质",
    L0047:"请选择资质类别",
    L0048:"确定删除？",
    L0049:"该邮箱地址可以使用",
    L0050:"请输入您的19位银行卡号",
    L0051:"银行卡号不允许为空！",
    L0052:"银行卡号只能为数字",
    L0053:"银行卡号格式不正确",
    L0054:"请选择您的银行卡类型",
    L0055:"电话号码只能为数字",
    L0056:"验证码不允许为空",
    L0057:"验证码错误",
    L0058:"验证码正确",
    L0059:"输入你获得的验证码",
    L0060:"请输入您的真实姓名",
    L0061:"输入只能为汉字",
    L0062:"请输入您的身份证号码",
    L0063:"您输入的身份证格式有误",
    L0064:"代理人",
    L0065:"投标数",
    L0066:"上一页",
    L0067:"下一页",
    L0068:"真实姓名不允许为空",
    L0069:"身份证号不允许为空",
    L0070:"请上传身份证复印件正面",
    L0075:"请输入单位名称",
    L0076:"请输入单位注册编号",
    L0077:"单位名称不能为空",
    L0078:"工商编号不能为空",
    L0079:"工商编号格式错误",
    L0088:"昵称不能为空",
    L0089:"请输入姓名",
    L0093:"发送成功!",
    L0094:"发送失败!",
    L0095:"全部",
    L0096:"退出失败!",
    L0098:"昵称过长，最多为30个字符",
    L0099:"格式不正确",
    L0100:"该昵称已存在",
    L0102:"登录成功!",
    L0103:"登录失败!",
    L0106:"确认发布",
    L0115:"人才姓名不能为空",
    L0116:"电话不能为空",
    L0117:"企业名称不能为空",
    L0118:"操作成功",
    L0119:"操作失败",
    L0126:"请输入企业名称",
    L0127:"请输入人才姓名",
    L0130:"格式错误",
    L0131:"简介不能为空",
    L0135:"请输入联系人姓名",
    L0136:"联系人姓名不能为空",
    L0137:"请输入企业简介,不超过140个字",
    L0138:"地区不能为空",
    L0151:"资质要求不能为空!",
    L0152:"请输入营业执照编号",
    L0153:"营业执照编号不能为空",
    L0154:"身份证号不能为空",
    L0155:"工作地点不能为空!",
    L0156:"地区要求不能为空!",
    L0157:"证书使用地不能为空!",
    L0158:"所在地不能为空!",
    L0159:"资质证书不能为空!",
    L0160:"期望注册地不能为空!",
    L0161:"请输入人才的真是姓名",
    L0162:"注册到期时间不能为空!",
    L0163:"请输入人才的期望待遇!",
    L0164:"期望待遇不能为空!",
    L0165:"期望待遇须为整数!",
    L0166:"期望待遇不能为负数!",
    L0167:"职称证书不能为空",
    L0168:"该类别已存在",
    L0169:"请添加服务类别",
    L0170:"请上传身份证复印件背面",
    L0171:"QQ号码不能为空",
    L0172:"请输入你所期望的职位名称",
    L0173:"职位名称不能为空！",
    L0174:"所输入金额必须大于0",
    L0175:"请输入学校名称",
    L0176:"学校名称不能为空",
    L0177:"期望待遇不能少于1000",
    L0180:"专业名称不能为空",
    L0181:"时间不能为空",
    L0182:"起始时间不能大于结束时间",
    L0183:"起始时间不能和结束时间相同",
    L0184:"请输入你所担任的职位名称",
    L0185:"请输入你所在的部门名称",
    L0186:"部门名称不能为空",
    L0187:"请输入你所工作的公司名称",
    L0188:"公司名称不能为空",
    L0189:"请输入你公司的所属行业",
    L0190:"行业名称不能为空",
    L0191:"请输入你的工作内容",
    L0192:"工作内容不能为空",
    L0193:"请输入项目名称",
    L0194:"项目名称不能为空",
    L0195:"请选择你要委托的简历类型:",
    L0196:"确定",
    L0197:"请上传营业执照复印件",
    L0198:"请上传组织机构代码复印件",
    L0199:"您确定要发布该职位?",
    L0200:"请输入专业名称",
    L0201:"请输入人才毕业学校的名称",
    L0202:"毕业学校名称不能为空!",
    L0203:"请输入人才的专业名称",
    L0204:"专业名称不能为空!",
    L0205:"请输入人才公司名称",
    L0206:"请输入人才所在行业名称",
    L0207:"请输入人才所在的部门名称",
    L0208:"请输入人才所担任的职位名称",
    L0209:"请输入人才相关工作情况",
    L0210:"工作描述不能为空!",
    L0211:"请输入人才工作内容",
    L0212:"生日不能为空!",
    L0213:"起始时间不能为空!",
    L0214:"结束时间不能为空!",
    L0220:"您还没输入您的意见",
    L0221:"资质证书与职称证书须选填其中一项!",
    L0224:"确认查看",
    L0225:"传真号码格式错误",
    L0226:"格式:(区号-公司号码-分机号(分机号选填)",
    L0227:"格式：http://www.xx.xx",
    L0228:"公司网址格式错误",
    L0229:"请输入公司的资质:如房屋建筑工程资质",
    L0230:"资质名称错误",
    L0231:"开户名格式错误",
    L0232:"开户行格式错误",
    L0233:"开户帐号格式错误",
    L0234:"开户名不能为空",
    L0235:"开户行不能为空",
    L0236:"开户帐号不能为空",
    L0237:"企业资质不能为空",
    L0238:"请先保存资质证书",
    L0239:"邮箱格式: user@xx.xom",
    L0240:"邮箱格式不正确!"
};
/****************************** 共用模版 ******************************/
COMMONTEMP={
    /*输入框提示模板*/
    T0001:'<div class="tip"><span class="tri"></span><div class="msg"></div></div>',
    /*alert确认按钮*/
    T0002:'<div class="dia_ok_cont"><div class="btn_common btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn blue dia_ok">确&nbsp;&nbsp;定</a></div></div>',
    /*弹出框模板*/
    T0003:'<div class="alr_msgbox_cover" id="{alrid}"><div class="alr_msgbox">'
    +'<div class="alr_bg">'
    +'<a href="javascript:;" class="a_closebtn"></a>'
    +'<div class="btn_common alrbox">'
    +'<span class="b_lf ab_lf"></span>'
    +'<span class="b_rf ab_rf"></span>'
    +'<div class="alr_content">{detail_cont}</div>'
    +'</div>'
    +'</div>'
    +'</div>',
    //想对某某说
    T0005:'<p class="blue"><em class="big_f">想对</em><em class="u_nm">{uname}</em><em class="big_f">说:</em></p><div class="tit_msg_cont">标题: <input type="text" class="tit_input" id="msgtitle"></div><div class="area_cont msg_title"><span>内容: </span><textarea cols="" rows="" id="msgcont"></textarea></div><div class="al_bt"><p class="red lf"></p><div class="btn3_cont rf"><div class="btn_common btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn blue" datacont="" id="sendmsg">发&nbsp;&nbsp;送</a></div></div><div class="clr"></div></div></div>',
    //登录框
    T0006:'<p class="blue"><em class="big_f big_f_log">登&nbsp;&nbsp;录</em><a href="'+WEBROOT+'/tregister/" class="gray">人才注册</a><span>|</span><a href="'+WEBROOT+'/eregister/" class="gray">企业注册</a><span>|</span><a href="'+WEBROOT+'/aregister/" class="gray">猎头注册</a></p><div class="area_cont lgtable"><table><tbody><tr><td class="gray">用户名:</td><td><input type="text" id="alr_uname"></td></tr><tr><td class="gray">密&nbsp;&nbsp;&nbsp;码:</td><td><input type="password" id="alr_uid"></td></tr></tbody></table></div><div class="al_bt logbder"><p class="red lf"></p><div class="btn3_cont rf"><div class="btn_common btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn blue" datacont="" id="alrlogin" uname="" uid="">登&nbsp;&nbsp;录</a></div></div><div class="clr"></div></div>',
    T0007:'<div class="tit_msg_cont">标题: <input type="text" class="tit_input" id="{tit_id}"/></div>',
    /*操作提示框（有确认按钮）*/
    T0008:'<div class="alr_opermsg_cover no_sure_dialog">'
    +'<div class="alr_msgbox oper_alr">'
    +'<div class="oper_middle">'
    +'<p class="lf icon {class}"></p>'
    +'<p class="lf msg">{msg}</p>'
    +'<p class="clr"></p>'
    +'</div>'
    +'<div class="sr_btn btn_common btn3">'
        +'<span class="b_lf"></span>'
        +'<span class="b_rf"></span>'
        +'<a href="javascript:;" id="" class="btn blue">确定</a>'
    +'</div>'
    +'</div>'
    +'</div>',
    /*操作提示框（有确认按钮有取消）*/
    T0011:'<div class="alr_opermsg_cover sure_dialog">'
    +'<div class="alr_msgbox oper_alr">'
    +'<div class="oper_middle">'
    +'<p class="lf icon {class}"></p>'
    +'<p class="msg">{msg}</p>'
    +'<p class="clr"></p>'
    +'<div class="yesorno">'
    +'<div class="yes_btn_cont">'
    +'<div class="btn_common btn3">'
    +'<span class="b_lf"></span>'
    +'<span class="b_rf"></span>'
    +'<a href="javascript:;" class="btn blue" id="{sureid}">{btntext}</a>'
    +'</div>'
    +'</div>'
    +'<a href="javascript:;" class="gray cancel">取消</a>'
    +'</div>'
    +'</div>'
    +'</div>'
    +'</div>',
//  //版本过低提示
//    T0012:'<div style="position: relative;height:210px"><div class="browser_bg">'
//    +'<p class="red">您的浏览器版本太低了，为了让您获得更优质的用户体验效果，请选择一款给力的浏览器吧！</p>'
//    +'<div class="browser_cont">'
//    +'<div class="img_chrome"><a href="http://www.google.com/chrome/" target="_blank" title="谷歌浏览器"></a></div>'
//    +'<div class="img_firfox" ><a href="http://www.firefox.com.cn/download/" target="_blank" title="火狐浏览器"></a></div>'
//    +'<div class="img_safari"><a href="http://www.apple.com.cn/safari/download/" target="_blank" title="safari浏览器"></a></div>'
//    +'<div class="img_opera"><a href="http://www.operachina.com/browser/" target="_blank" title="欧朋浏览器"></a></div>'
//    +'<div class="img_ie9"><a href="http://info.msn.com.cn/ie9/" target="_blank" title="IE9"></a></div>'
//    +'<div class="img_maxthon"><a href="http://www.maxthon.cn/mx3/" target="_blank" title="傲游浏览器"></a></div>'
//    +'</div></div></div>',
    /*输入框提示模板*/
    T0014:'<div class="result"></div>',
    /*添加更多资质要求模板*/
    T0015:'<a href="javascript:;" class="blue addqual">添加更多资质要求</a>',
    /*添加删除更多资质要求模板*/
    T0016:'<a href="javascript:;" class="blue delqual">删除</a>',
    /*添加更多资质证书模板*/
    T0017:'<a href="javascript:;" class="blue addqual">添加更多资质证书</a>',
    T0018:'<div class="data_cover" id="{id}"><div class="select_bg"><div class="select_cont"><a href="javascript:;" class="close_slt" title="取消"></a><div class="content"></div><div class="next"><a href="javascript:;" class="blue okbtn">{text}</a></div></div></div></div>',
    /*保存资质证书模板*/
    T0019:'<a href="javascript:;" class="blue sq_qua">保存</a>',
    /*添加资质证书简单模板*/
    T0020:'<a href="javascript:;" title="" class="blue adn_qa">添加</a>',
    T0021:'<a href="javascript:;" title="" class="blue adn_cancle">取消</a>',
    /*添加工作经验简单模板*/
    T0023:'<a href="javascript:;" title="" class="blue adexper">添加工作经验</a>',
    T0024:'<a href="javascript:;" title="" class="blue canexper">取消</a>',
    /*添加工程业绩简单模板*/
    T0025:'<a href="javascript:;" title="" class="blue adprs">添加工程业绩</a>',
    T0026:'<a href="javascript:;" title="" class="blue prs_cancle">取消</a>',
    T0027:'<p class="alr_box"><span><input type="radio" value="2" name="reum" checked/>兼职简历</span><span><input type="radio" value="1"name="reum" />全职简历</span></p>',
    //提点意见
    T0028:'<p class="blue"><em class="big_f">想对</em><em class="u_nm">职讯</em><em class="big_f">说:</em></p><div class="area_cont msg_title zxtxt"><textarea cols="" rows="" id="zxmsgcont"></textarea></div><div class="al_bt"><p class="red lf"></p><div class="btn3_cont rf"><div class="btn_common btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn blue" datacont="" id="sendmsgtozx">发&nbsp;&nbsp;送</a></div></div><div class="clr"></div></div></div>',
    /*资质要求清空*/
    T0029:'<a href="javascript:;" class="blue emptyqual">清空</a>',
    /*信用认证图片上传*/
    T0030:'<div style="position:relative;"><img  class="ld" src="'+WEBROOT+'/zhixun/Theme/default/vocat/imgs/system/loading.gif" alt="名称"/><span class="lt">正在上传,请稍后</span></div>',
    /*清空选择中资质内容*/
    T0031:'<a href="javascript:;" title="清空" class="blue empty">清空</a>',
    /*清空选择中地区内容*/
    T0032:'<a href="javascript:;" title="清空" class="blue em_area">清空</a>'
}
/****************************** 常量配置 ******************************/
CONSTANT={
    C0001:'20',//任务列表/任务详细每页条数
    C0002:'15',//发布的任务列表/竞标的任务列表/发出的委托列表/收到的委托列表每页条数
    C0003:'6',
    C0004:'10',//任务详细页列表
    //消息提醒
    M0001:'份投递来的简历',//ypresume简历应聘
    M0002:'份委托来的简历',//ragent简历委托
    M0003:'个委托来的职位',//jagent职位委托
    M0004:'个委托来的任务',//tagent任务委托
    M0005:'个系统消息',//system站内信
    M0006:'个简历邀请',//invite简历邀请
    M0007:'个职位委托被取消',//edjob取消委托职位
    M0008:'个简历委托被取消',//edresume取消委托简历
    M0009:'个用户消息',//user用户消息
    M00010:'个人才即将过生',//birth人才生日提醒
    M00011:'个企业成立纪念日将到',//setup企业成立纪念日将到
    M00012:'个企业汇款日期将到',//remit企业汇款日期将到
    M00013:'个人才即将聘用到期',//employ人才聘用到期
    M00014:'份投递来的简历'//eypresume企业收到的简历应聘
};
/****************************** 资源文件名配置 ******************************/
SOURCENAME={
    /***** model *****/
    M0003:JSURLROOT+"models/account_m_1.0.js",
    M0004:JSURLROOT+"models/user_m_1.0.js",
    M0005:JSURLROOT+"models/message_m_1.0.js",
    M0006:JSURLROOT+"models/bill_m_1.0.js",
    /***** controller *****/
    CT0001:JSURLROOT+"controllers/base_c_1.0.js",
    /***** render *****/
    R0001:JSURLROOT+"renders/base_r_1.0.js",
    /***** lib *****/
    L0001:THEMEROOT+"crm/config/temple.js",
    //L0002:CONURLROOT+"jquery.ui.core.js",已合并到L0003中
    L0003:THEMEROOT+"lib/jquery-datepicker/jquery.ui.datepicker.js",
    L0006:THEMEROOT+"lib/pagination/jquery.pagination.js",//分页js
    L0013:THEMEROOT+"lib/select-hgs/select-core-hgs.js",
    L0015:THEMEROOT+"lib/card-hgs/card-hgs.js",
    L0016:THEMEROOT+"lib/card-hgs/bcard-hgs.js",
    L0017:THEMEROOT+"lib/slt-hgs/slt-core-hgs.js",
    /*********************************CRM系统部分**************************************/
    /*******Module**********/
    c_M0001:CRMURLROOT+"models/resource_m_1.0.js",
    /*******Controller******/
    c_CT0001:CRMURLROOT+"controller/resource_c_1.0.js",
    c_CT0002:CRMURLROOT+"controller/resourcedetail_c_1.0.js",
    /*******Render**********/
    r_Rn0001:CRMURLROOT+"render/resource_r_1.0.js",
    r_Rn0002:CRMURLROOT+"render/resourcedetail_r_1.0.js",
    /*********CRM_lib*************/
    c_L0001:THEMEROOT+"lib/mask/jquery.mask.js",
    c_M0002:THEMEROOT+"lib/edrecoder/edrecoder-hgs.js"
};
/****************************** 全局变量定义 ******************************/
/* 
 * 顶级命名空间HGS
 */
HGS = new Object||{};
/*
 * 幻灯片计时器
 */
STIMER=null;
/*
 * 在线统计计时器
 */
STATTIMER=null;
/*
 * 企业墙计时器
 */
ENTERTIMER=null;
/*图表定义*/
CHART=null;

