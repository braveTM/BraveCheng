/****************************** 后台数据访问路径配置 ******************************/
//公用数据访问路径
WEBURL={
    //common
    Login:WEBROOT+"/do_login",//登录
    ComLogin:WEBROOT+"/Home/Public/do_company_login",//企业登录
    Exit:WEBROOT+"/logout",//退出
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
    GetCJobs:WEBROOT+"/Home/RCommon/get_c_jobs",/*获取全职指定大分类的小分类*/
    RerportSpam:WEBROOT+"/report",/*举报页面*/
    DoreportSpam:WEBROOT+"/Home/Detail/do_report",/*举报提交*/
    PJResSave:WEBROOT+"/Home/Human/do_registerpart_guide",/*人才引导流程 - 兼职保存*/
    FJResSave:WEBROOT+"/Home/Human/do_registerfull_guide",/*人才引导流程 - 全职保存*/
    PhoSave:WEBROOT+"/Home/User/do_guide_photo",/*人才引导流程 - 头像保存*/
    //message
    SendSystem:WEBROOT+"/send_system",//给职讯留言
    GetMsgList:WEBROOT+"/get_messages",//获取我的消息列表
    SendMsg:WEBROOT+"/send_message",//发送站内信
    RemarkRead:WEBROOT+"/mark_read",//记录是否已阅读
    RemoveFollower:WEBROOT+"/unfollow",/*取消我关注的人表*/
    AddFollower:WEBROOT+"/follow",/*添加我关注的人*/
    Dodynews:WEBROOT+"/get_news",/*站内动态**/
    DelMsgList:WEBROOT+"/Home/Message/do_delete_messeges",/*删除消息记录**/
    DoPostFedBack:WEBROOT+'/Home/Public/do_feedback',/*提交反馈内容*/
    SendEmRequest:WEBROOT+'/Home/Invite/do_invite_email',/*邮件邀请注册*/
    SendPhoneReuest:WEBROOT+'/Home/Invite/do_invite_sms',/*短信邀请注册*/
    //contacts
    GetContact:WEBROOT+"/get_contact",/*获取用户联系方式*/
    //cert
    DeleTCert:WEBROOT+"/delete_rcert",/*人才删除证书*/
    AddTCert:WEBROOT+"/add_rcert",/*人才添加证书*/
    UpdateTtitle:WEBROOT+"/update_gcert",/*修改人才职称证*/
    RemoveTitleCt:WEBROOT+"/remove_cert_ct",/*修改人才职称证*/
    //recommend
    AGetRecTalents:WEBROOT+"/a_get_recommend_human",/*猎头获取推荐人才列表*/
    EGetRecTalents:WEBROOT+"/e_get_recommend_human",/*企业推获取荐人才列表*/
    AGetRecJobs:WEBROOT+"/a_get_recommend_job",/*猎头获取推荐职位列表*/
    EGetRecJobs:WEBROOT+"/h_get_recommend_job",/*人才获取推荐职位列表*/
    ASearchJob:WEBROOT+"/a_search_job",/*猎头搜索职位*/
    HSearchJob:WEBROOT+"/h_search_job",/*人才搜索职位*/
    GetRecAgent:WEBROOT+"/get_recommend_agent",/*获取推荐猎头列表*/
    GetRecCompany:WEBROOT+"/get_recommend_company",/*获取推荐企业列表*/
    //information
    CreateBlog:WEBROOT+"/a_create_blog",/*猎头 - 创建blog*/
    AGetBlogs:WEBROOT+"/a_get_blog_list",/*猎头 - 获取所有blog*/
    ADeleBlog:WEBROOT+"/a_delete_blog",/*猎头 - 删除行业心得*/
    AValidateBlog:WEBROOT+"/a_ask_validate_blog",/*猎头 - 提交审核行业心得*/
    AUpdateBlog:WEBROOT+"/a_update_blog",/*猎头 - 修改行业心得*/
    AgeExplist:WEBROOT+"/get_blog_list",/*行业心得*/
    blogPraise:WEBROOT+"/Home/Information/do_Blog_Praise",/*职场经验赞一下*/
    infoPraise:WEBROOT+"/Home/Information/do_Article_Praise",/*资讯赞一下*/
    agentPraise:WEBROOT+"/Home/User/do_praise",/*猎头赞一下*/
    //pool
    GetTanAgentList:WEBROOT+"/h_get_agent_list",/*人才获取所找的猎头列表*/
    GetAgentList:WEBROOT+"/get_resources",//猎头/公司列表
    GetCompnayAgentList:WEBROOT+"/e_get_agent_list",/*企业获取所找的猎头列表*/
    EGetTanlentList:WEBROOT+"/e_get_interested_human",/*企业获取可能感兴趣的人才列表-找人才*/
    TGetCompanyList:WEBROOT+"/h_get_interested_company",/*人才获取可能感兴趣的企业列表-找企业*/
    DoapplyAgentResum:WEBROOT+"/h_delegate_resume",/*人才委托猎头简历*/
    FGetTalents:WEBROOT+"/get_talents",/*大首页 - 找人才*/
    GetFocsPerson:WEBROOT+"/get_follows",/*获取我关注的人的列表*/
    GetDymicLis:WEBROOT+"/get_follow_moving",/*获取人脉同台列表*/
    GetChangeHuman:WEBROOT+"/change_recommend_human",/*获取换一换推荐人才列表*/
    GetChangeMidman:WEBROOT+"/Home/Recommend/get_agent_change",/*获取换一换推荐猎头列表*/
    ClosePopu:WEBROOT+"/Home/User/do_close_popup",/*关闭猎头推送弹窗*/
    //delegate
    ValiAgent:WEBROOT+"/check_agent",//验证猎头是否存在
    ReplyDele:WEBROOT+"/delegate_reply",//回复委托
    //tool
    GetDealTool:WEBROOT+"/get_market_current",/*市场行情-本月交易价*/
    GetReqData:WEBROOT+"/get_year_market",/*市场行情-年度走势数据*/
    getYearData:WEBROOT+"/get_year_market_compare",/*市场行情-历年走势数据*/
    callBackCheck:WEBROOT+"/do_package_min",/*电话回拨请求验证*/
    callBack:WEBROOT+"/do_call"/*电话回拨*/
};
//账单相关数据访问路径
BILLURL={
    GetBill:WEBROOT+"/get_bills",//获取账单明细列表
    Recharge:WEBROOT+"/do_recharge",//账户充值
//    UpdatePac:WEBROOT+"/change_package",/*更换套餐、套餐续费*/
    DoBuyRecommend:WEBROOT+"/do_promote_account",/*猎头购买推广品牌位*/
    DoHkOffline:WEBROOT+"/hk_order",/*线下汇款操作*/
    DoRobRecomPos:WEBROOT+"/hold_promote",/*企业抢占品牌位推广操作*/
    BuyPackage:WEBROOT+"/buy_package",/*购买套餐*/
    RenewPackage:WEBROOT+"/renewals_package",/*套餐续费*/
    GetSChrRes:WEBROOT+"/Home/Package/get_renewals_result",/*获取单项续费结果*/
    RSChrRes:WEBROOT+"/Home/Package/do_renewals_single",/*使用统计 - 单项续费 - 立即续费*/
    GetSChrTips:WEBROOT+"/Home/Package/get_renewals_tips",/*使用统计 - 单项续费 - 续费项提示获取*/
    ChangePackage:WEBROOT+"/Home/Package/do_exp_exchange_package",/*积分兑换套餐*/
    ScorRenewPackage:WEBROOT+"/Home/Package/do_exp_renewals_package",/*积分续费*/
    PayCheck:WEBROOT+"/do_pay_check",/*付费操作检测*/
    GetFaceValue:WEBROOT+'/Home/Package/get_min_face_value'/*电话面值获取*/
};
//账户相关数据访问路径
ACCOUNTURL={
    ValidateEmail:WEBROOT+"/echeck",//邮箱唯一性验证
    ValidateUName:WEBROOT+"/ucheck",//用户名唯一性验证
    ValidNickname:WEBROOT+"/ncheck",//用户昵称唯一性检测
    Register:WEBROOT+"/do_register",//注册
    TalentBasic:WEBROOT+"/update_human",//更新账户基本资料(个人)
    EnterpriseBasic:WEBROOT+"/update_company",//更新账户基本资料(企业)
    AgentBasic:WEBROOT+"/update_agent",//更新账户基本资料(猎头)
    SaveNewPwd:WEBROOT+"/do_change",//更新账户新密码
    GetValidNum:WEBROOT+"/do_phone_apply",//账户/发送验证码到手机
    UpdatePhone:WEBROOT+"/do_phone_verify",//账户/更新手机号码,手机认证申请
    ApplyVemail:WEBROOT+"/do_email_apply",//邮箱认证申请，
    ApplyVbank:WEBROOT+"/do_bank_apply",//银行认证申请
    ApplyTvname:WEBROOT+"/do_peapply",//实名认证申请(个人,猎头)
    ApplyEvname:WEBROOT+"/do_enapply",//实名认证申请(企业)
    DoForgetPwd:WEBROOT+"/do_forgot",/*忘记密码*/
    DoSenewPwd:WEBROOT+"/do_reset",/*重设新密码*/
    DoResendActive:WEBROOT+"/Home/Public/do_reactive",/*注册激活邮件页->重新发送激活邮件*/
    MobileRegister:WEBROOT+"/Home/Public/do_phone_register",/*人才手机注册*/
    SendValidNber:WEBROOT+"/Home/Public/do_send_phone_register_code",/*人才手机注册*/
    PswPhone:WEBROOT+"/Home/Public/do_phone",/*手机验证码检测*/ 
    ChangeTalentPhoto:WEBROOT+"/Home/Human/do_update_photo",/*保存人才修改头像*/
    ChangeEnterPhoto:WEBROOT+"/Home/Company/do_update_photo",/*保存企业修改头像*/
    ChangeMidmanPhoto:WEBROOT+"/Home/MiddleMan/do_update_photo",/*保存猎头修改头像*/
    RemindSet:WEBROOT+"/Crm/CNotice/do_add_notice_user_setting",/*猎头提醒设置*/
    SetPrivacyHuman:WEBROOT+'/Home/Human/do_update_privacyHuman',/*人才隐私设置*/
    SetPrivacyAgent:WEBROOT+'/Home/MiddleMan/do_update_privacyAgent',/*猎头隐私设置*/
    SetPrivacyCompany:WEBROOT+'/Home/Company/do_update_privacyCompany',/*企业隐私设置*/
    DoRensendEmial:WEBROOT+'/Home/Public/do_res_forgot'/*忘记密码页->重新发送邮件*/
};
//职位相关数据访问路径
JOBURL={
    APubJob:WEBROOT+"/apub_job",/*猎头发布职位*/
    EPubJob:WEBROOT+"/epub_job",/*企业发布职位*/
    AGetPubJobs:WEBROOT+"/get_apub_job",/*猎头获取已发布职位*/
    EGetPubJobs:WEBROOT+"/get_epub_job",/*企业获取已发布职位*/
    EGetWCLJob:WEBROOT+"/get_wcl_job",/*企业获取未处理的职位列表*/
    AEndPubJobs:WEBROOT+"/a_end_rec",/*猎头-立即结束招聘*/
    EEndPubJobs:WEBROOT+"/e_end_rec",/*企业-立即结束招聘*/
    AGetResList:WEBROOT+"/job_ar_resume",/*猎头-获取指定职位的简历列表*/
    EGetResList:WEBROOT+"/job_r_resume",/*企业-获取指定职位的简历列表*/
    AGetAgentJobs:WEBROOT+"/get_agented_job",/*猎头-获取委托来的职位列表*/
    EGetAgentJobs:WEBROOT+"/get_agent_job",/*企业-获取委托出去的职位列表*/
    AOpenJobs:WEBROOT+"/open_job",/*猎头-立即公开招聘*/
    AGetIntJobs:WEBROOT+"/a_get_interested_job",/*猎头-获取可能感兴趣的职位*/
    GetCDJobs:WEBROOT+"/get_cd_job",/*获取可委托的职位列表*/
    DeleJobs:WEBROOT+"/eent_job",/*委托职位*/
    EEndDelJob:WEBROOT+"/end_delegate_job",/*企业-立即终止委托*/
    TGetInteJob:WEBROOT+"/h_get_interested_job",/*人才获取感兴趣的职位列表*/
    TGetCDJob:WEBROOT+"/h_get_sent_job",/*人才获取应聘过的职位列表*/
    GetComPubJobs:WEBROOT+"/get_company_jobs",/*获取指定企业发布的职位*/
    ERPubJob:WEBROOT+"/epub_ojob",/*企业立即发布待处理职位*/
    ACheckJDetial:WEBROOT+"/read_delegate_job",/*猎头 - 委托来的职位 - 查看详细*/
    AInterRupJob:WEBROOT+"/apausejob",/*猎头-暂停职位招聘*/
    AGoesonJob:WEBROOT+"/a_restart_job",/*猎头-继续职位招聘*/
    EPaJob:WEBROOT+"/epausejob",/*企业-暂停职位招聘*/
    EGoJob:WEBROOT+"/e_restart_job",/*企业-继续职位招聘*/
    GetARunningJob:WEBROOT+"/get_running_job",/*获取指定猎头正在运作的职位*/
    TGetWantJobs:WEBROOT+"/Home/Human/get_intent_jobs"/*获取指定猎头正在运作的职位*/
};
//简历相关数据访问路径
RESUMEUR={
    DoUpdatePersonInfo:WEBROOT+"/doUpdateHuman",/*更新简历个人基本信息*/
    DoUpJobPosition:WEBROOT+"/doUpdateJobIntent",/*(全职)更新求职岗位信息*/
    AdFuExperience:WEBROOT+"/addWorkExp",/*(全职)添加个人工作经验*/
    AAddWExp:WEBROOT+"/a_add_w_e",/*猎头创建全职简历 - 添加工作经历*/
    AAddPExp:WEBROOT+"/a_add_p_a",/*猎头创建全职简历 - 添加工程业绩*/
    DodelExp:WEBROOT+"/deleteWorkExp",/*(全职)删除个人工作经验*/
    DoDeleAchivement:WEBROOT+"/deletePA",/*(全职)删除个人工程业绩*/
    DoAdAchive:WEBROOT+"/addPA",/*(全职)添加个人工程业绩*/
    DopubPart:WEBROOT+"/h_open_resume",/*(简历)选择公开求职发布方式*/
    DoEndPart:WEBROOT+"/h_close_resume",/*(简历)结束公开求职发布方式*/
    DoUpPersonEdu:WEBROOT+"/doUpdateDegree",/*(全职)更新个人学历信息*/
    DogetTancontac:WEBROOT+"/get_resume_contact",/*查看兼职简历人才联系方式*/
    DoDeleGatePub:WEBROOT+"/check_resume",/*(简历)选择代理方式发布简历*/
    SendResume:WEBROOT+"/h_send_resume",/*人才投递简历*/
    DleCertificate:WEBROOT+"/deleteRC",/*(兼职)删除资质证书*/
    AddCerficate:WEBROOT+"/addRC",/*(兼职)添加资质证书*/
    GetCerts:WEBROOT+"/get_rcerts",/*获取资质证书类型列表*/
    AGetAgentedHuman:WEBROOT+"/a_get_agent_human",/*猎头获取他代理的人才列表*/
    AGetIHuman:WEBROOT+"/a_get_interested_human",/*猎头获取他感兴趣的人才列表*/
    APubResume:WEBROOT+"/a_open_job_intent",/*猎头-立即公开求职*/
    ACloseResume:WEBROOT+"/a_close_job_intent",/*猎头-立即结束求职*/
    DogetAppResumeList:WEBROOT+"/a_get_sent_resume",/*获取应聘来的简历列表*/
    EgetAppResumeList:WEBROOT+"/e_get_sent_resume",/*企业获取应聘来的简历列表*/
    ACreReume:WEBROOT+"/a_create_hc_resume",/*猎头创建兼职简历*/
    DoCheckAppResume:WEBROOT+"/a_read_sent_resume",/*经纪人立即查看应聘来的简历*/
    DoCompanyCheckSentResume:WEBROOT+"/e_read_sent_resume",/*企业立即查看应聘来的简历*/
    DoComChkSResume:WEBROOT+"/e_read_sent_resume",/*企业立即查看应聘来的简历*/
    DoGetAddedResum:WEBROOT+"/a_get_private_resume",/*获取我添加的简历列表*/
    ACRStep1:WEBROOT+"/a_create_resume_step1",/*猎头创建全职简历第一步*/
    ACRStep2:WEBROOT+"/a_create_resume_step2",/*猎头创建全职简历第一步*/
    AComResume:WEBROOT+"/a_complete_delegated_resume",/*猎头 - 委托来的简历 - 完成求职*/
    ACheckRDetial:WEBROOT+"/a_read_delegated_resume",/*猎头 - 委托来的简历 - 查看详细*/
    DeleAresm:WEBROOT+"/a_delete_private_resume",/*猎头 - 我添加的简历 - 删除*/
    ASaveTInfo:WEBROOT+"/a_update_human",/*猎头 - 全职简历修改 - 人才信息保存*/
    ASaveGetPos:WEBROOT+"/a_update_job_intent",/*猎头 - 全职简历修改 - 求职岗位保存*/
    ASaveDegree:WEBROOT+"/a_update_degree",/*猎头 - 全职简历修改 - 学历保存*/
    AUpdateDegree:WEBROOT+"/a_update_work_exp",/*猎头 - 全职简历修改 - 修改工作经历*/
    AUpdateWExp:WEBROOT+"/a_update_p_a",/*猎头 - 全职简历修改 - 修改工程业绩*/
    ADelRC:WEBROOT+"/a_delete_rc",/*猎头 - 全职简历修改 - 删除资质证书*/
    AAddRC:WEBROOT+"/a_add_rc",/*猎头 - 全职简历修改 - 添加资质证书*/
    AUpdateCert:WEBROOT+"/a_update_cc",/*猎头 - 全职简历修改 - 证书情况修改*/
    AUpdatePCert:WEBROOT+"/a_update_hc",/*猎头 - 兼职简历修改 - 证书情况修改*/
    ADeleWExp:WEBROOT+"/a_delete_work_exp",/*猎头 - 全职简历修改 - 删除个人工作经验*/
    ADeleWGrade:WEBROOT+"/a_delete_p_a",/*猎头 - 全职简历修改 - 删除个人工程业绩*/
    GetARunResumes:WEBROOT+"/get_running_resume",/*获取指定猎头正在运作的简历*/
    UpdateCertificate:WEBROOT+"/doUpdateHangCardIntent",/*(兼职)更新证书情况*/
    UpFultCert:WEBROOT+"/doUpdateCertificateCase",/*(全职)更新证书情况*/
    DoUnlockResum:WEBROOT+"/end_delegate_resume"/*人才结束委托简历*/
};
//公司猎头管理
CAURL={
    OffAgent:WEBROOT+"/freeze",/*冻结猎头帐号*/
    OnAgent:WEBROOT+"/unfreeze",/*解冻猎头帐号*/
    GetFilterEmployee:WEBROOT+"/get_broker"/*获取筛选条件的数据*/    
};
/****************************** 页面短路径配置 ******************************/
SWEBURL={
    JobDetail:WEBROOT+'/office',             /*职位详细页面*/
    AGENTDetail:WEBROOT+'/agent',            /*猎头详细页面*/
    CompanyDetail:WEBROOT+'/company',        /*企业详细页*/
    ResumeDetail:WEBROOT+'/get_resume',      /*简历详细页*/
    SResumeDetail:WEBROOT+'/get_s_resume',      /*应聘来的简历详细页副本*/
    DResumeDetail:WEBROOT+'/get_d_resume',      /*应聘来的简历详细页副本*/
    EFindAgent:WEBROOT+'/efa',               /*企业找猎头页面*/
    APResume:WEBROOT+'/a_update_hc_index/',  /*猎头兼职简历修改页面*/
    AFResume:WEBROOT+'/a_update_r_index/',   /*猎头全职简历修改页面*/
    UserDetail:WEBROOT+'/alluser',           /*我关注的人的详细*/
    InfoDetail:WEBROOT+'/article/', /*资讯详细页*/
    BlogEdit:WEBROOT+'/a_update_blog_index',  /*行业心得编辑（添加）页*/
    BlogManage:WEBROOT+'/ablogs/' /*行业心得管理页*/
};
/****************************** 语言包 ******************************/
LANGUAGE={
    L0001:"邮箱格式: user@xx.xom",
    L0002:"邮箱不能为空!",
    L0003:"邮箱格式不正确!",
    L0004:"该邮箱已存在!",
    L0005:"用户名应为6-16个包含英文、字符、数字或汉字的字符串,且字符串不能以_开头",
    L0006:"用户名不能为空!",
    L0007:"用户名格式不正确!",
    L0008:"该用户名已存在!",
    L0009:"密码应为6-16个包含英文、字符、数字或特殊符号的字符串",
    L0010:"密码不能为空!",
    L0011:"密码长度不能小于6",
    L0012:"密码长度不能大于16",
    L0013:"密码格式不正确!",
    L0014:"用户名长度不能小于6",
    L0015:"用户名长度不能大于16",
    L0016:"请再次输入密码",
    L0017:"两次密码不一致!",
    L0018:"请填入您已注册的用户名",
    L0019:"请填入您的密码",
    L0020:"对不起,暂无相关数据!",
    L0029:"请输入您的电话号码",
    L0030:"电话号码不能为空!",
    L0031:"电话格式不正确!",
    L0032:"请输入QQ号码",
    L0033:"QQ号码不能为空!",
    L0034:"QQ号码格式不正确!",
    L0039:"请输入电话号码",
    L0040:"电话号码格式不正确",
    L0041:"电话号码不能为空",
    L0042:"请输入你的简介,不超过140个字",
    L0043:"最多只能输入300个字",
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
    L0066:"上一页",
    L0067:"下一页",
    L0068:"真实姓名不允许为空",
    L0069:"身份证号不允许为空",
    L0070:"请上传身份证复印件正面",
    L0071:"请输入您要充值的金额，充值金额不能低于5元",
    L0072:"充值数目不能为空!",
    L0073:"充值金额须为数字!",
    L0074:"充值金额不能低于5元!",
    L0075:"请输入单位名称",
    L0076:"请输入单位注册编号",
    L0077:"单位名称不能为空",
    L0078:"工商编号不能为空",
    L0079:"工商编号格式错误",
    L0089:"请输入您的姓名",
    L0093:"发送成功!",
    L0094:"发送失败!",
    L0096:"退出失败!",
    L0098:"昵称过长，最多为30个字符",
    L0099:"格式不正确",
    L0100:"该昵称已存在",
    L0102:"登录成功!",
    L0103:"登录失败!",
    L0106:"确认发布",
    L0108:"立即充值",
    L0109:"请选择套餐类型",
    L0111:"请选择一个推广位",
    L0115:"人才姓名不能为空",
    L0116:"电话不能为空",
    L0117:"企业名称不能为空",
    L0118:"操作成功",
    L0119:"操作失败",
    L0126:"请输入企业名称",
    L0127:"请输入人才姓名",
    L0128:"所选消息已为已读信息，无需再标记",
    L0129:"请输入您所属猎头公司名称(若无，可不填)",
    L0130:"格式错误",
    L0131:"简介不能为空",
    L0132:"必须同意《职讯网用户守则》才能进行注册",
    L0133:"验证码不能为空",
    L0134:"验证码不能为空",
    L0135:"请输入联系人姓名",
    L0136:"联系人姓名不能为空",
    L0137:"请输入企业简介,不超过300个字",
    L0138:"地区不能为空",
    L0139:"请输入招聘的标题,不超过30个字",
    L0140:"招聘的标题不能为空!",
    L0141:"招聘的标题长度不能超过30个字!",
    L0142:"请输入招聘企业名称,长度不能超过30个字!",
    L0143:"招聘企业名称不能为空!",
    L0144:"招聘企业名称长度不能超过30个字!",
    L0145:"请输入职位名称,长度不能超过20个字!",
    L0146:"职位名称不能为空!",
    L0147:"职位名称长度不能超过20个字!",
    L0148:"请输入招聘人数，须为整数",
    L0149:"招聘人数不能为空!",
    L0150:"招聘人数须为整数",
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
    L0178:"您确定要终止委托吗?(终止后您可以在 已终止的职位 里查看到相关信息)",
    L0179:"您确定要结束该职位的招聘吗?",
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
    L0215:"您还未选择想要标记为已读的信息",
    L0216:"购买套餐需花费您{score}元,确认继续吗?",
    L0217:"确认购买",
    L0218:"套餐续费需花费您{score}元,确认继续吗?",
    L0219:"确认续费",
    L0220:"您还没输入您的意见",
    L0221:"资质证书与职称证书须选填其中一项!",
    L0222:"当前免费条数还剩<span class='red'> {a} </span>条,确认继续操作将扣除<span class='red'> 1 </span>条,您确认继续吗?",
    L0223:"当前操作需扣除您<span class='red'> {p}元 </span>,您确认继续吗?",
    L0224:"确认查看",
    L0225:"当前操作将按<span class='red'> {p}元/项 </span>扣除您相应的金额,您确认继续吗?",
    L0226:"确认邀请",
    L0227:"确认投递",
    L0228:"确认中标",
    L0229:"您的余额已不足,是否立即去账户中心充值?",
    L0230:" 亲爱的职讯网用户:\n\t我们会每天关注您的建议并提供反馈，不断优化产品，为您更好的服务。\n\t请留下您详细的疑问或建议，谢谢！",
    L0231:"帐号不能为空",
    L0232:"请输入公司联系电话(区号-公司号码-分机号(分机号选填)",
    L0233:"公司电话不能为空",
    L0234:"长度不能超过6个汉字",
    L0235:"帐号不能为空",
    L0236:"日期只能为整数",
    L0237:"最多只能提前31天",
    L0238:"最多只能提前5周",
    L0239:"最多只能提前12个月",
    L0240:"提前天数不能为空",
    L0241:"提前周数不能为空",
    L0242:"提前月数不能为空",
    L0243:"未作任何修改",
    L0244:"不能为空",
    L0245:"须为整数",
    L0246:"登录帐号不能为空",
    L0247:"确认委托",
    L0248:"请输入不大于5位的整数或小数点位数不超过2位的小数!",    
    L0258:"<上一页",
    L0259:"下一页>",
    L0249:"个人简介是您对外形象展示的重要窗口，您可以就从业年限、行业经验、服务过的大客户、所在经济公司的实力等能提升个人专业度和价值的方面进行自我介绍。",
    L0250:"帐号格式错误",
    L0251:"兑换此套餐需使用您{score}积分!",
    L0252:"确认兑换",
    L0253:"套餐续费需花费您{score}积分!"    
};
/****************************** 共用模版 ******************************/
COMMONTEMP={
    /*输入框提示模板*/
    T0001:'<div class="tip"><span class="tri"></span><div class="msg"></div></div>',
    /*alert弹出框的确认按钮*/
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
    //我要竞标
    T0004:'<p class="blue"><em class="big_f">我要竞标</em></p><div class="area_cont inptxt"><textarea cols="" rows="" id="bidtxt"></textarea></div><div class="al_bt"><div class="dinput">电话: <input type="text" id="uem">邮箱: <input type="text" class="lst_inp" id="utel"></div><p class="red lf"></p><div class="btn3_cont rf"><div class="btn_common btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn blue" datacont="" id="bidbtn">发布</a></div></div><div class="clr"></div></div>',
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
    /*操作提示框（有确认按钮）*/
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
    //版本过低提示
//    T0012:'<div style="position: relative;height:210px;"><div class="browser_bg">'
//    +'<p class="red">您的浏览器版本太低了，为了让您获得更好的用户体验，请选择一款给力的浏览器吧！</p>'
//    +'<div class="browser_cont">'
//    +'<div class="img_chrome"><a href="http://www.google.com/chrome/" target="_blank" title="谷歌浏览器"></a></div>'
//    +'<div class="img_firfox"><a href="http://www.firefox.com.cn/download/" target="_blank" title="火狐浏览器"></a></div>'
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
    T0027:'<p class="alr_box"><span><input type="radio" value="2" id="resum_1" name="reum" checked/><label for="resum_1">兼职简历</label></span><span><input type="radio" id="resume_2"  value="1"name="reum" /><label for="resume_2">全职简历</label></span></p>',
    //提点意见
    T0028:'<p class="blue"><em class="big_f">想对</em><em class="u_nm">职讯</em><em class="big_f">说:</em></p><div class="area_cont msg_title zxtxt"><textarea cols="" rows="" id="zxmsgcont"></textarea></div><div class="al_bt"><p class="red lf"></p><div class="btn3_cont rf"><div class="btn_common btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn blue" datacont="" id="sendmsgtozx">发&nbsp;&nbsp;送</a></div></div><div class="clr"></div></div></div>',
    /*资质要求清空*/
    T0029:'<a href="javascript:;" class="blue emptyqual">清空</a>',
    /*信用认证图片上传*/
    T0030:'<div style="position:relative;margin:-3px 0 3px 0;"><img  class="ld" src="'+WEBROOT+'/zhixun/Theme/default/vocat/imgs/system/loading.gif" alt="名称"/><span class="lt">正在上传,请稍后</span></div>'    
}
/****************************** 常量配置 ******************************/
CONSTANT={
    C0001:'20',//任务列表/任务详细每页条数
    C0002:'15',//发布的任务列表/竞标的任务列表/发出的委托列表/收到的委托列表每页条数
    C0003:'6',
    C0004:'10',//任务详细页列表
    C0005:'20',//猎头管理员列表页
    //消息提醒
    M0001:'份投递来的简历',//ypresume猎头收到的简历应聘
    M0002:'份委托来的简历',//ragent简历委托
    M0003:'个委托来的职位',//jagent职位委托
    M0004:'个委托来的任务',//tagent任务委托
    M0005:'个系统消息',//system站内信
    M0006:'个简历邀请',//invite简历邀请
    M0007:'个职位委托被取消',//edjob取消委托职位
    M0008:'个简历委托被取消',//edresume取消委托简历
    M0009:'个用户消息',//user用户消息
    M00010:'个人才即将过生日',//birth人才生日提醒
    M00011:'个企业成立纪念日将到',//setup企业成立纪念日将到
    M00012:'个企业汇款日期将到',//remit企业汇款日期将到
    M00013:'个人才即将聘用到期',//employ人才聘用到期
    M00014:'份投递来的简历'//eypresume企业收到的简历应聘
};
/****************************** 查询配置 ******************************/
REFERS=[
    //设计施工一体化企业
    'http://219.142.101.69/CertificateServiceold/RegPeopleQuery.aspx?type=6',
    //建设工程勘察企业
    'http://219.142.101.69/CertificateServiceold/RegPeopleQuery_kc.aspx',
    //建设工程设计企业
    'http://219.142.101.69/CertificateServiceold/RegPeopleQuery.aspx?type=2',
    //工程监理企业
    'http://219.142.101.69/CertificateServiceold/RegPeopleQuery.aspx?type=4',
    ////工程建设项目招标代理机构
    'http://219.142.101.69/CertificateServiceold/RegPeopleQuery.aspx?type=5',
    //建筑业企业
    'http://219.142.101.69/CertificateServiceold/RegPeopleQuery.aspx?type=3',
    //外商投资城市规划服务企业
    'http://219.232.244.146/project/wfproject.aspx?type=4',
    //城市规划编制单位
    'http://219.232.244.146/project/wfproject.aspx?type=3',
    //工程造价咨询企业
    'http://www.ceca.org.cn/query/ifcorp_query.asp',
    //房地产开发企业
    'http://219.142.101.72/showcorpinfo/showcorpinfo.aspx',
    //全国建造师信息查询 - 一级注册建造师查询
    'http://jzsgl.coc.gov.cn/archisearch/cszcindex.aspx',
    //全国建造师信息查询 - 一级建造师临时执业证书人员查询
    'http://jzsgl.coc.gov.cn/archisearch/firstTemporary/cszcindex.aspx',
    //全国建造师信息查询 - 二级注册建造师查询
    'http://jzsgl.coc.gov.cn/archisearch/second/cszcindex.aspx',
    //全国建造师信息查询 - 二级建造师临时执业证书人员查询
    'http://jzsgl.coc.gov.cn/archisearch/secondTemporary/cszcindex.aspx',
    //注册房地产估价师
    'http://www.mohurd.gov.cn/yyxttz/200807/t20080725_176215.html',
    //注册建筑师
    'http://219.142.101.78/regist/reginfo.aspx?type=1x',
    //注册工程师
    'http://219.142.101.69/CertificateServiceold/RegPeopleQuery_kc.aspx',
    //注册监理工程师
    'http://jlgcs.cein.gov.cn/jlgcsSearch/index.aspx',
    //注册造价工程师
    'http://www.ceca.org.cn/query/ifengineer_query.aspx',
    //工程建设项目招标代理机构资格核准
    'http://219.142.101.186/SLBWebPublish/wfSLBMainInfo.aspx?type=3x',
    //建筑业企业资质核准
    'http://219.142.101.186/SLBWebPublish/wfSLBMainInfo.aspx?type=4',
    //监理企业资质核准
    'http://219.142.101.186/SLBWebPublish/wfSLBMainInfo.aspx?type=5',
    //建设工程勘察企业资质核准
    'http://219.142.101.186/SLBWebPublish/wfSLBMainInfo.aspx?type=1',
    //建设工程设计企业资质核准
    'http://219.142.101.186/SLBWebPublish/wfSLBMainInfo.aspx?type=2',
    //设计施工一体化资质核准
    'http://219.142.101.186/SLBWebPublish/wfSLBMainInfo.aspx?type=13'
    ];
/****************************** 资源文件名配置 ******************************/
SOURCENAME={
    /***** model *****/
    M0003:JSURLROOT+"models/account_m_1.0.js",
    M0004:JSURLROOT+"models/user_m_1.0.js",
    M0005:JSURLROOT+"models/message_m_1.0.js",
    M0006:JSURLROOT+"models/bill_m_1.0.js",
    M0007:JSURLROOT+"models/delegate_m_1.0.js",
    M0008:JSURLROOT+"models/pool_m_1.0.js",
    M0009:JSURLROOT+"models/resume_m_1.0.js",
    M0010:JSURLROOT+"models/jobs_m_1.0.js",
    M0011:JSURLROOT+"models/cert_m_1.0.js",
    M0012:JSURLROOT+"models/contacts_m_1.0.js",
    M0013:JSURLROOT+"models/recommend_m_1.0.js",
    M0014:JSURLROOT+"models/information_m_1.0.js",
    M0015:JSURLROOT+"models/tool_m_1.0.js",
    M0016:JSURLROOT+"models/cacrm_m_1.0.js",
    /***** controller *****/
    CT0001:JSURLROOT+"controllers/base_c_1.0.js",
    CT0002:JSURLROOT+"controllers/index_c_1.0.js",
    CT0003:JSURLROOT+"controllers/account_c_1.0.js",
    CT0006:JSURLROOT+"controllers/register_c_1.0.js",
    CT0013:JSURLROOT+"controllers/msglist_c_1.0.js",
    CT0014:JSURLROOT+"controllers/bill_c_1.0.js",
    CT0015:JSURLROOT+"controllers/deledetail_c_1.0.js",
    CT0018:JSURLROOT+"controllers/jobmanage_c_1.0.js",
    CT0020:JSURLROOT+"controllers/tmanage_c_1.0.js",
    CT0025:JSURLROOT+"controllers/tindex_c_1.0.js",
    CT0030:JSURLROOT+"controllers/package_c_1.0.js",
    CT0031:JSURLROOT+"controllers/promote_c_1.0.js",
    CT0032:JSURLROOT+"controllers/tresume_c_1.0.js",
    CT0033:JSURLROOT+"controllers/bringin_c_1.0.js",
    CT0034:JSURLROOT+"controllers/mycert_c_1.0.js",
    CT0035:JSURLROOT+"controllers/jobfullself_c_1.0.js",
    CT0036:JSURLROOT+"controllers/jobfull_c_1.0.js",
    CT0037:JSURLROOT+"controllers/agentdetail_c_1.0.js",
    CT0038:JSURLROOT+"controllers/aindex_c_1.0.js",
    CT0039:JSURLROOT+"controllers/eindex_c_1.0.js",
    CT0040:JSURLROOT+"controllers/tfindjob_c_1.0.js",
    CT0041:JSURLROOT+"controllers/comdetail_c_1.0.js",
    CT0042:JSURLROOT+"controllers/resume_detail_c_1.0.js",
    CT0043:JSURLROOT+"controllers/tgetagent_c_1.0.js",
    CT0044:JSURLROOT+"controllers/egetagent_c_1.0.js",
    CT0045:JSURLROOT+"controllers/comfindtal_c_1.0.js",
    CT0046:JSURLROOT+"controllers/tfcompany_c_1.0.js",
    CT0048:JSURLROOT+"controllers/getback_pwd_c_1.0.js",
    CT0050:JSURLROOT+"controllers/addfres_c_1.0.js",
    CT0051:JSURLROOT+"controllers/person_contacts_c_1.0.js",
    CT0053:JSURLROOT+"controllers/auresume_c_1.0.js",
    CT0054:JSURLROOT+"controllers/dynew_c_1.0.js",
    CT0055:JSURLROOT+"controllers/cpresume_c_1.0.js",
    CT0057:JSURLROOT+"controllers/jobpub_c_1.0.js",
    CT0059:JSURLROOT+"controllers/blog_c_1.0.js",
    CT0060:JSURLROOT+"controllers/tool_c_1.0.js",
    CT0061:JSURLROOT+"controllers/information_c_1.0.js",
    CT0062:JSURLROOT+"controllers/taldetail_c_1.0.js",
    CT0063:JSURLROOT+"controllers/bdindex_c_1.0.js",
    CT0064:JSURLROOT+"controllers/invite_c_1.0.js",
    CT0065:JSURLROOT+"controllers/guide_c_1.0.js",
    CT0100:JSURLROOT+"controllers/paytip_c_1.0.js",
    CT0101:JSURLROOT+"controllers/feedback_c_1.0.js",
    CT0102:JSURLROOT+"controllers/comlogin_c_1.0.js",
    CT0103:JSURLROOT+"controllers/setindex_c_1.0.js",
    CT0104:JSURLROOT+"controllers/manageagent_c_1.0.js",
    CT0106:JSURLROOT+"controllers/remind_c_1.0.js",
    CT0107:JSURLROOT+"controllers/tafindpos_c_1.0.js",
    /***** render *****/
    R0001:JSURLROOT+"renders/base_r_1.0.js",
    R0002:JSURLROOT+"renders/index_r_1.0.js",
    R0003:JSURLROOT+"renders/account_r_1.0.js",
    R0006:JSURLROOT+"renders/register_r_1.0.js",
    R0013:JSURLROOT+"renders/msglist_r_1.0.js",
    R0014:JSURLROOT+"renders/bill_r_1.0.js",
    R0015:JSURLROOT+"renders/deledetail_r_1.0.js",
    R0018:JSURLROOT+"renders/jobmanage_r_1.0.js",
    R0020:JSURLROOT+"renders/tmanage_r_1.0.js",
    R0025:JSURLROOT+"renders/tindex_r_1.0.js",
    R0030:JSURLROOT+"renders/package_r_1.0.js",
    R0031:JSURLROOT+"renders/promote_r_1.0.js",
    R0032:JSURLROOT+"renders/tresume_r_1.0.js",
    R0033:JSURLROOT+"renders/bringin_r_1.0.js",
    R0034:JSURLROOT+"renders/mycert_r_1.0.js",
    R0035:JSURLROOT+"renders/jobfullself_r_1.0.js",
    R0036:JSURLROOT+"renders/jobfull_r_1.0.js",
    R0037:JSURLROOT+"renders/agentdetail_r_1.0.js",
    R0038:JSURLROOT+"renders/aindex_r_1.0.js",
    R0039:JSURLROOT+"renders/eindex_r_1.0.js",
    R0040:JSURLROOT+"renders/tfindjob_r_1.0.js",
    R0041:JSURLROOT+"renders/comdetail_r_1.0.js",
    R0042:JSURLROOT+"renders/resume_detail_r_1.0.js",
    R0043:JSURLROOT+"renders/tgetagent_r_1.0.js",
    R0044:JSURLROOT+"renders/egetagent_r_1.0.js",
    R0045:JSURLROOT+"renders/comfindtal_r_1.0.js",
    R0046:JSURLROOT+"renders/tfcompany_r_1.0.js",
    R0048:JSURLROOT+"renders/getback_pwd_r_1.0.js",
    R0050:JSURLROOT+"renders/addfres_r_1.0.js",
    R0051:JSURLROOT+"renders/person_contacts_r_1.0.js",
    R0053:JSURLROOT+"renders/auresume_r_1.0.js",
    R0054:JSURLROOT+"renders/dynews_r_1.0.js",
    R0055:JSURLROOT+"renders/cpresume_r_1.0.js",
    R0057:JSURLROOT+"renders/jobpub_r_1.0.js",
    R0059:JSURLROOT+"renders/blog_r_1.0.js",
    R0060:JSURLROOT+"renders/tool_r_1.0.js",
    R0061:JSURLROOT+"renders/information_r_1.0.js",
    R0062:JSURLROOT+"renders/taldetail_r_1.0.js",
    R0063:JSURLROOT+"renders/bdindex_r_1.0.js",
    R0064:JSURLROOT+"renders/invite_r_1.0.js",
    R0065:JSURLROOT+"renders/remind_r_1.0.js",
//    R0101:JSURLROOT+"renders/avatar_r_1.0.js",已合并到L0005 jquery.imgareaselect.min.js中
    R0102:JSURLROOT+"renders/comlogin_r_1.0.js",
    R0103:JSURLROOT+"renders/setindex_r_1.0.js",
    R0104:JSURLROOT+"renders/manageagent_r_1.0.js",
    R0105:JSURLROOT+"renders/tafindpos_r_1.0.js",
    /***** lib *****/
    L0001:THEMEROOT+"vocat/config/temple.js",
    //L0002:CONURLROOT+"jquery.ui.core.js",已合并到L0003中
    L0003:THEMEROOT+"lib/jquery-datepicker/jquery.ui.datepicker.js",
    L0005:THEMEROOT+"lib/imgareaselect/jquery.imgareaselect.min.js",
    L0006:THEMEROOT+"lib/pagination/jquery.pagination.js",//分页js
    L0007:THEMEROOT+"lib/highcharts/highcharts.js",
    L0008:THEMEROOT+"lib/highcharts/exporting.js",
    L0013:THEMEROOT+"lib/select-hgs/select-core-hgs.js",
    //L0014:CONURLROOT+"select-data-hgs.js",已合并到L0013中
    L0015:THEMEROOT+"lib/card-hgs/card-hgs.js",
    L0016:THEMEROOT+"lib/card-hgs/bcard-hgs.js",
    L0017:THEMEROOT+"lib/slt-hgs/slt-core-hgs.js",
    L0018:THEMEROOT+"lib/boot-hgs/boot-hgs.js",
    L0019:THEMEROOT+"lib/share/shareto.js",
    L0020:THEMEROOT+"lib/jQuery-ptTimeSelect/jquery.ptTimeSelect.js",
    L0021:THEMEROOT+"lib/zeroclipboard/jquery.zclip.js",
    L0022:THEMEROOT+"lib/detail-login/detail-login.js",
    L0023:THEMEROOT+"lib/pub-func/pub-func_1.0.0.js"
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

/*图表定义*/
CHART=null;

