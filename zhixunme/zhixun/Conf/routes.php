<?php
return array(
    array('/^\d{1,11}\/{0,1}[a-zA-Z]*/i','Home/Detail/user','pg'),
    
    //-----------------首页-----------------
    array('index','Home/Index/index',''),                    //首页
    array('ftalents','Home/Index/talents',''),               //首页找人才
    array('fenterprise','Home/Index/enterprise',''),         //首页找企业
    array('get_talents','Home/Index/get_talents',''),        //获取首页人才列表
    array('get_enterprise','Home/Index/get_enterprise',''),  //获取首页企业列表

    //-----------------登录-----------------
    array('login','Home/Index/login',''),                    //登录页
    array('clogin','Home/Index/clogin',''),                  //企业登录页面
    array('do_login','Home/Public/do_login',''),             //登录操作
    array('logout','Home/Public/do_logout',''),              //退出操作
    array('lvcode','Home/Public/login_code',''),             //登录验证码
    array('user_exit','Home/User/logout'),                   //用户退出页面

    //-----------------注册-----------------
    array('register','Home/Public/register','rid'),          //注册页
    array('tregister','Home/Public/tregister','code'),       //人才注册页
    array('eregister','Home/Public/eregister','code'),       //企业注册页
    array('aregister','Home/Public/aregister','code'),       //经纪人注册页
    array('ucheck','Home/Public/do_ucheck',''),              //验证用户名合法性
    array('echeck','Home/Public/do_echeck',''),              //验证邮箱合法性
    array('do_register','Home/Public/do_register',''),       //注册操作
    array('rsucc','Home/Public/register_succ','code'),           //注册成功
    array('rvcode','Home/Public/register_code',''),          //注册验证码
    array('add_tcert','Home/Public/do_add_cert',''),         //添加注册证书临时信息
    array('update_tcert','Home/Public/do_update_cert',''),   //更新注册证书临时信息
    array('delete_tcert','Home/Public/do_delete_cert',''),   //删除注册证书临时信息
    array('wait_active','Home/Public/wait_active',''),       //等待邮箱激活页面
    array('do_reactive','Home/Public/do_reactive',''),       //重新发送激活邮件
    array('rsuc','Home/Public/phone_regsuc','phone'),           //注册成功
    array('rhome', 'Home/User/rhome'),                      //注册引导流程

    //-----------------忘记密码-----------------
    array('forgot','Home/Public/forgot','',''),                 //忘记密码页
    array('fgsuc','Home/Public/fgsuc','',''),                   //忘记密码邮件发送成功页
    array('fgphone','Home/Public/fgphone','',''),                     //手机验证页面
    array('reset','Home/Public/reset','token',''),              //重设密码页
    array('do_forgot','Home/Public/do_forgot','',''),           //忘记密码
    array('do_reset','Home/Public/do_reset','',''),             //重设密码
    array('do_phone','Home/Public/do_phone','',''),             //手机验证
    

    //-----------------文章页面-----------------
    array('about','Home/Public/about'),                         //关于职讯页面
    array('contactus','Home/Public/contact'),                   //联系我们页面
    array('agreement','Home/Public/agreement'),                 //服务协议页面
    array('rule','Home/Public/rule'),                           //积分规则页面
    array('joinus','Home/Public/joinus'),                       //招贤纳士页面
    array('privacy','Home/Public/privacy'),                     //隐私协议页面
    array('links','Home/Public/links'),                         //友情链接页面
    array('feedback','Home/Public/feedback'),                   //意见反馈页面
    array('advantages','Home/Public/advantages'),               //服务优势页面
    array('arule','Home/Public/arule'),                         //经纪人规范页面
    array('trule','Home/Public/trule'),                         //人才规范页面
    array('crule','Home/Public/crule'),                         //企业规范页面
    array('help','Home/Information/infoListIndex','','user_id=0&art_blog=2&class_id=13'),              //帮助中心
    array('funcop','Home/Public/funcop'),                       //功能对比页面
    array('scrule','Home/Public/scrule'),                       //功能对比页面

    //-----------------人脉---------------
    array('contacts','Home/Contacts/index','',''),              //我的人脉页面
    array('follow','Home/Contacts/do_follow','',''),            //关注
    array('unfollow','Home/Contacts/do_unfollow','',''),        //取消关注
    array('get_follows','Home/Contacts/get_follows','',''),     //获取关注列表
    array('get_follow_moving','Home/Contacts/get_follow_moving','',''), //获取关注人的动态列表

    //-----------------资源库---------------
    array('talents','Home/Lib/talents','',''),                  //人才库页面
    array('enterprise','Home/Lib/enterprise','',''),            //企业库页面
    array('agents','Home/Lib/agent','',''),                     //代理库页面
    array('subcontractor','Home/Lib/subcontractor','',''),      //分包商库页面
    array('get_labels','Home/Index/get_labels','',''),          //获取指定标签数据
    array('get_resources','Home/Lib/get_resources','',''),      //资源搜索
    array('get_guess','Home/Lib/get_guess','',''),              //猜你喜欢
    array('get_plabels','Home/Lib/get_plabels','',''),          //获取企业专业承包资质

    //-----------------账单-----------------
    array('bill','Home/Bill/index','',''),                      //账单页面
    array('get_bills','Home/Bill/get_bills','',''),             //获取账单记录
    array('do_recharge','Home/Bill/do_recharge','',''),         //充值
    array('do_package','Home/Bill/do_package','',''),           //购买套餐
    array('pay_callback','Home/Bill/pay_callback','',''),       //支付回调请求
    array('money_check','Home/Bill/do_money_check','',''),      //余额检测
    array('hk_order','Home/Bill/do_hk_order','',''),            //余额检测

    //-----------------付费-----------------
    array('do_pay_check','Home/Pay/do_pay_check','',''),        //操作扣费检测

    //-----------------委托-----------------
    array('delegate','Home/Delegate/index','tab,id',''),   //发布委托页面
    array('mdelegate','Home/Delegate/delemanage','',''),        //委托管理页面
    array('ddetail','Home/Delegate/detail','id',''),            //委托详细页面
    array('get_ipostd','Home/Delegate/get_ipostd','',''),       //获取用户发出的委托
    array('get_ireceive','Home/Delegate/get_ireceive','',''),   //获取用户收到的委托
    array('do_delegate','Home/Delegate/do_publish','',''),      //发布委托
    array('check_agent','Home/Delegate/do_acheck','',''),       //代理人检测
    array('delegate_reply','Home/Delegate/do_delegate_reply','',''),       //回复委托
    array('delesuc','Home/Delegate/delesuc','',''),             //委托成功
    array('get_cd_list','Home/Delegate/get_cd_list','',''),     //获取可以委托的委托列表
    array('get_dwcl','Home/Delegate/get_wcl_list','',''),       //获取未处理的委托列表
    array('delete_d','Home/Delegate/delete_delegate','',''),    //删除指定委托
    array('do_dtask','Home/Delegate/do_delegate','',''),        //委托代理


    //-----------------错误-----------------
    array('error','Home/Public/_error','',''),                   //错误页面
    array('perror','Home/Public/position_404','',''),                   //职位错误页面
    array('rerror','Home/Public/resume_404','',''),                   //简历错误页面

    //-----------------文章管理-----------------
    array('get_articles','Home/Article/get_articles','',''),    //获取文章列表
    array('get_news','Home/Article/get_news','',''),            //获取站内动态

    //-----------------用户-------------
    array('profiles','Home/User/profiles','',''),               //修改资料页面
    array('homepage','Home/User/home','',''),                   //用户主页
    array('tprofile','Home/User/tprofile','',''),               //人才修改资料页面
    array('eprofile','Home/User/eprofile','',''),               //企业修改资料页面
    array('aprofile','Home/User/aprofile','',''),               //经纪人修改资料页面
    array('sprofile','Home/User/sprofile','',''),               //分包商修改资料页面
    array('aperfect','Home/User/agent','',''),                  //代理完善资料页面
    array('sperfect','Home/User/subcontractor','',''),          //分包商完善资料页面
    array('eperfect','Home/User/enterprise','',''),             //企业完善资料页面
    array('tperfect','Home/User/talents','',''),                //人才完善资料页面
    array('ncheck','Home/User/do_ncheck','',''),                //昵称合法性检测
    array('do_change','Home/User/do_change','',''),             //修改密码
    array('add_label','Home/User/do_add_label','',''),          //添加用户标签
    array('delete_label','Home/User/do_delete_label','',''),    //删除用户标签
    array('do_tupdate','Home/User/do_tupdate','',''),           //修改人才用户资料
    array('do_eupdate','Home/User/do_eupdate','',''),           //修改企业用户资料
    array('do_aupdate','Home/User/do_aupdate','',''),           //修改代理用户资料
    array('do_supdate','Home/User/do_supdate','',''),           //修改分包商用户资料
    array('do_update','Home/User/do_update','',''),             //修改用户资料
    array('do_real_apply','Home/User/do_real_apply','',''),     //实名认证申请
    array('do_phone_apply','Home/User/do_phone_apply','',''),   //手机认证申请
    array('do_email_apply','Home/User/do_email_apply','',''),   //邮箱认证申请
    array('do_bank_apply','Home/User/do_bank_apply','',''),     //银行卡认证申请
    array('do_phone_verify','Home/User/do_phone_verify','',''), //手机认证审核
    array('everify','Home/User/everify','code',''),             //邮箱认证审核
    array('do_peapply', 'Home/User/do_person_apply', '', ''),   //个人认证申请
    array('do_enapply', 'Home/User/do_enterprise_apply', '', ''),//企业认证申请
    array('do_aperfect','Home/User/do_aperfect','',''),         //经纪人完善资料保存
    array('do_eperfect','Home/User/do_eperfect','',''),         //企业完善资料保存
    array('do_sperfect','Home/User/do_sperfect','',''),         //分包商完善资料保存
    array('do_tperfect','Home/User/do_tperfect','',''),         //人才完善资料保存
    array('get_contact', 'Home/User/get_contact', '', ''),      //获取用户联系方式
    array('get_resume_contact', 'Home/User/get_resume_contact', '', ''),      //获取简历的联系方式
    array('update_visit', 'Home/User/do_update_visit', '', ''),    //更新用户访问信息
    array('alluser','Home/User/user','id',''),                  //所有用户详细页面通用入口
    array('broker_remind','Home/MiddleMan/remind','',''),

    //-----------------后台-----------------
    array('manage','Home/User/index','',''),                    //后台首页面

    //-----------------站内信---------------
    array('messages','Home/Message/msglist','',''),             //站内信列表页面
    array('message','Home/Message/detail','id',''),             //站内信详细页面
    array('get_messages','Home/Message/get_messages','',''),    //获取消息列表
    array('send_message','Home/Message/do_send','',''),         //发送站内信
    array('mark_read','Home/Message/do_read','',''),            //标记为已读
    array('send_system','Home/Message/do_send_system','',''),   //系统留言

    //-----------------上传-----------------
    array('upload_photo','Home/Index/do_upload_photo','',''),   //上传用户头像
    array('upload_identify','Home/Index/do_upload_identify','',''),    //上传用户认证文件

    //-----------------服务-----------------
    array('member','Home/User/member','',''),                   //会员服务页面

    //-----------------通知-----------------
    array('notify','Special/Notify/send','uids,rids,tid,token,code',''),                //发送通知
    array('semail','Special/Notify/semail','email,tid,uid,code',''),                    //发送邮件
    array('nemail','Special/Notify/nemail','',''),                                      //普通邮件发送
    array('iresume','Special/Notify/invite_resume','jid,rid',''),                       //简历邀请通知

    //-----------------扫描-----------------
    array('task_scan','Special/Scan/task_scan','',''),          //扫描任务数据
    array('package_scan','Special/Scan/package_scan','',''),    //扫描套餐数据
    array('ttop_scan','Special/Scan/ttop_scan','',''),          //扫描任务置顶数据
    array('rsms','Special/Scan/sms_receive','',''),             //接收回复短信
    array('update_online','Special/Scan/update_online','',''),  //更新用户在线情况
    array('update_n_eactive','Special/Scan/update_n_eactive','',''),  //更新过期邮件激活记录
    array('promote_scan','Special/Scan/update_promote','',''),  //更新推广信息

    //-----------------EDM-----------------
    array('EDM_7d67da8cc39b142ce8cd104436086575','Home/EDM/aedm7d67da8cc39b142ce8cd104436086575','',''),//经纪人EDM
    array('EDM_51fccda61aa70238002c1778e09596b2','Home/EDM/hedm51fccda61aa70238002c1778e09596b2','',''),//人才EDM
    array('EDM_af71427a68f99bd3967dbf1f5990ef51','Home/EDM/cedmaf71427a68f99bd3967dbf1f5990ef51','',''),//企业EDM
    array('EDM_1178ce12406dd72dd4cc2cf0d0001d46','Home/EDM/adem1178ce12406dd72dd4cc2cf0d0001d46','',''),//经纪人EDM

    //-----------------套餐-----------------
    array('mpackage','Home/Package/index','',''),               //套餐管理
    //array('change_package','Home/Package/do_package','',''),    //更换套餐
    array('buy_package','Home/Package/do_buy_package','',''),              //购买套餐
    array('renewals_package','Home/Package/do_renewals_package','',''),    //套餐续费

    //-----------------短信-----------------
    array('duanxin','Special/Sms/index','',''),                 //发送手机短信

    //----------------推广-----------------
    array('promote','Home/Promote/index','',''),                            //推广页面
    array('get_promote_list','Home/Promote/get_promote_list','',''),        //获取推广位列表
    array('hold_promote','Home/Promote/do_hold_promote','',''),                //占用推广位
    array('do_promote_account','Home/Promote/do_promote_account','',''),    //购买账户推广
    array('do_promote_info','Home/Promote/do_promote_info','',''),          //购买信息推广
    array('get_job_promote','Home/Promote/get_job_promote','',''),          //获取职位推广信息
    array('get_resume_promote','Home/Promote/get_resume_promote','',''),    //获取简历推广信息
    array('get_task_promote','Home/Promote/get_task_promote','',''),        //获取任务推广信息

    //----------------提醒-----------------
    array('get_remind','Home/Remind/get_remind','',''),         //获取站内提醒

    //------------------测试-------------------
    array('createResumeTest','Home/Test/createResume','',''),
    array('getResumeTest','Home/Test/getResume','',''),
    array('humanRegisterTest','Home/Test/humanRegister','',''),
    array('companyRegisterTest','Home/Test/companyRegister','',''),
    array('createJobTest','Home/Test/createJob','',''),
    array('connectRE','Home/Test/connectRE','',''),

    //--------------------人才资料-------------------
    array('update_human', 'Home/Human/do_update'),                            //人才修改基本资料
    array('getResume','Home/HumanProfile/getResume','',''),
    array('doUpdateHuman','Home/HumanProfile/do_UpdateHuman','',''),
    array('doUpdateJobIntent','Home/HumanProfile/do_UpdateJobIntent','',''),
    array('doUpdateDegree','Home/HumanProfile/do_UpdateDegree','',''),
    array('doUpdateWorkExp','Home/HumanProfile/do_UpdateWorkExp','',''),
    array('doUpdatePA','Home/HumanProfile/do_UpdatePA','',''),
    array('getWorkExpList','Home/HumanProfile/get_WorkExpList','',''),
    array('getPAlist','Home/HumanProfile/get_PAlist','',''),
    array('getRClist','Home/HumanProfile/get_RClist','',''),
    array('getGClist','Home/HumanProfile/get_GClist','',''),
    array('addWorkExp','Home/HumanProfile/do_addWorkExp','',''),
    array('addPA','Home/HumanProfile/do_addPA','',''),
    array('addRC','Home/HumanProfile/do_addRC','',''),
    array('addGC','Home/HumanProfile/do_addGC','',''),
    array('deleteWorkExp','Home/HumanProfile/do_deleteWorkExp','',''),
    array('deletePA','Home/HumanProfile/do_deletePA','',''),
    array('deleteRC','Home/HumanProfile/do_deleteRC','',''),
    array('deleteGC','Home/HumanProfile/do_deleteGC','',''),
    array('getAllRCinfo','Home/HumanProfile/get_AllRCinfo','',''),
    array('getRCmajorList','Home/HumanProfile/get_RCmajorList','',''),
    array('getAllGCType','Home/HumanProfile/get_AllGCType','',''),
    array('getGCmajorList','Home/HumanProfile/get_GCmajorList','',''),
    array('doUpdateCertificateCase','Home/HumanProfile/do_UpdateCertificateCase','',''),
    array('getHangCardResume','Home/HumanProfile/get_HangCardResume','',''),
    array('doUpdateHangCardIntent','Home/HumanProfile/do_UpdateHangCardIntent','',''),
    array('setPrivacyHuman','Home/Human/setPrivacyHuman','',''),         //人才隐私
    

    //------------------企业-------------------
    array('metask', 'Home/Company/taskmanage'),                         //企业任务管理
    array('epromotion', 'Home/Company/promote'),                        //企业推广页面
    array('update_company', 'Home/Company/do_update'),                  //企业修改基本资料
    array('epub_job', 'Home/Company/do_pub_job','',''),                 //企业发布职位
    array('eent_job', 'Home/Company/do_delegate_job','',''),            //企业委托职位
    array('job_r_resume', 'Home/Company/get_ReceiveResumeByJob','',''),  //企业查看投递到指定职位的简历列表
    array('e_invite_resume', 'Home/Company/do_InviteResume','', ''),     //企业邀请简历
    array('e_end_rec', 'Home/Company/do_EndRecruitment','', ''),         //企业关闭职位
    array('get_epub_job', 'Home/Company/get_PubJob','', ''),             //企业查看发布的职位
    array('get_agent_job', 'Home/Company/get_DelegateJob','', ''),       //企业查看委托的职位
    array('e_get_recommend_human','Home/Company/get_RecommendHuman','',''),  //企业查看系统推荐的人才
    array('e_index','Home/Company/home','',''),                         //企业首页
    array('ehome','Home/Company/index','',''),                          //企业推荐页面
    array('efc','Home/Company/getHumanIndex','',''),                    //企业找人才页面
    array('efa','Home/Company/getAgentIndex','jid',''),                 //企业找经纪人页面
    array('recruitment','Home/Company/recruitmentIndex','',''),         //企业招聘页面
    array('e_get_agent_list','Home/Company/get_AgentList','',''),        //企业找经纪人
    array('e_get_interested_human','Home/Company/get_InterestedHuman','',''),  //企业查看感兴趣的人才
    array('get_cd_job','Home/Company/get_can_delegate_jobs','',''),     //企业查看可以委托的职位列表
    array('get_eci_job','Home/Company/get_can_invite_jobs','',''),      //企业查看可以邀请简历的职位列表
    array('end_delegate_job','Home/Company/do_end_delegate_job','',''), //企业结束职位代理
    array('get_wcl_job','Home/Company/get_wcl_job','',''),              //企业查看未处理的职位列表
    array('epub_ojob','Home/Company/do_publish_job','',''),             //企业发布职位
    array('e_upload_picture','Home/Company/do_upload_picture','',''),   //企业上传企业墙图片
    array('e_get_recommend_agent','Home/Company/get_RecommendAgent','',''),        //企业查看系统推荐的经纪人
    array('epubjob','Home/Company/job','',''),                          //企业发布职位页面
    array('epausejob','Home/Company/do_pause_job','',''),               //企业暂停职位
    array('e_restart_job','Home/Company/do_restart_job','',''),         //企业重新开始职位
    array('e_get_sent_resume','Home/Company/get_SentResume','',''),     //企业获取应聘来的简历
    array('setPrivacyCompany','Home/Company/setPrivacyCompany','',''),   //企业隐私
    array('e_read_sent_resume','Home/Company/do_readSentResume','',''),      //企业阅读应聘来的简历

    //------------------经纪人-------------------
    array('a_restart_job','Home/MiddleMan/do_restart_job','',''),           //经纪人重新开始职位
    array('apubjob','Home/MiddleMan/job','',''),                            //经纪人发布职位页面
    array('acpresume','Home/MiddleMan/cpresume','',''),                     //经纪人创建兼职简历页面
    array('a_add_r_index','Home/MiddleMan/createResumeIndex','',''),         //经纪人创建全职简历页面
    array('matask', 'Home/MiddleMan/taskmanage'),                           //经纪人任务管理
    array('apromotion', 'Home/MiddleMan/promote'),                          //经纪人推广页面
    array('update_agent', 'Home/MiddleMan/do_update'),                      //经纪人修改基本资料
    array('apub_job', 'Home/MiddleMan/do_pub_job','',''),                   //经纪人发布职位
    array('job_ar_resume', 'Home/MiddleMan/get_ReceiveResumeByJob','',''),   //经纪人查看投递到指定职位的简历列表
    array('a_invite_resume', 'Home/MiddleMan/do_InviteResume','', ''),       //经纪人邀请简历
    array('a_end_rec', 'Home/MiddleMan/do_EndRecruitment','', ''),           //经纪人关闭职位
    array('get_apub_job', 'Home/MiddleMan/get_PubJob','', ''),               //经纪人查看发布的职位
    array('get_agented_job', 'Home/MiddleMan/get_AgentedJob','', ''),        //经纪人查看收到委托的职位
    array('open_job', 'Home/MiddleMan/do_OpenJob','', ''),                   //经纪人公开职位
    array('a_get_interested_job','Home/MiddleMan/get_InterestedJob','',''),  //经纪人查看可能感兴趣的职位
    array('a_index','Home/MiddleMan/home','',''),                           //经纪人首页
    array('ahome','Home/MiddleMan/index','',''),                            //经纪人推荐页面
    array('atm','Home/MiddleMan/humanManageIndex','',''),                   //经纪人才管理页面
    array('apm','Home/MiddleMan/jobManageIndex','',''),                     //职位管理页面
    array('a_get_interested_human','Home/MiddleMan/get_InterestedHuman','',''), //经纪人查看可能感兴趣的人才
    array('a_get_recommend_human','Home/MiddleMan/get_RecommendHuman','',''),   //经纪人查看系统推荐的人才
    array('a_get_agent_human','Home/MiddleMan/get_DelegatedHuman','',''),   //经纪人查看他代理的人才列表
    array('a_open_job_intent','Home/MiddleMan/do_OpenJobIntent','',''),      //经纪人公开人才简历
    array('a_close_job_intent','Home/MiddleMan/do_CloseJobIntent','',''),    //经纪人关闭人才简历
    array('a_get_sent_job','Home/MiddleMan/get_SentJobByHuman','',''),       //经纪人查看他为委托他的人才投递的简历（应聘过的职位）
    array('a_sent_job','Home/MiddleMan/do_SendResumeToJob','',''),           //经纪人投递简历
    array('get_aci_job','Home/MiddleMan/get_can_invite_jobs','',''),        //经纪人查看可以邀请简历的职位列表
    array('a_get_recommend_job','Home/MiddleMan/get_RecommendJob','',''),    //经纪人查看系统推荐的职位
    array('a_get_own_human','Home/MiddleMan/get_OwnHuman','',''),            //经纪人查看拥有的人才列表
    array('a_get_sent_resume','Home/MiddleMan/get_SentResume','',''),        //经纪人查看应聘来的简历
    array('a_read_sent_resume','Home/MiddleMan/do_readSentResume','',''),      //经纪人阅读应聘来的简历
    array('a_get_private_resume','Home/MiddleMan/get_PrivateResume','',''),  //经纪人查看私有简历列表
    array('a_create_hc_resume','Home/MiddleMan/do_createPrivateHCresume','',''),                                                     //经纪人创建私有兼职简历
    array('a_create_resume_step1','Home/MiddleMan/do_createPrivateResumeStep1','',''),                                                     //经纪人创建私有简历第一步
    array('a_create_resume_step2','Home/MiddleMan/do_createPrivateResumeStep2','',''),                                                     //经纪人创建私有简历第二步
    array('a_add_p_a','Home/PrivateResume/do_addPA','',''), //经纪人添加工程业绩
    array('a_add_w_e','Home/PrivateResume/do_addWorkExp','',''), //经纪人添加工作经历
    array('a_update_r_index','Home/MiddleMan/updateResumeIndex','human_id',''),      //经纪人更新简历页面
    array('a_update_hc_index','Home/MiddleMan/updateHCIndex','human_id',''),         //经纪人更新兼职简历页面
    array('a_read_delegated_resume','Home/MiddleMan/do_readDelegatedResume','',''),   //经纪人阅读委托来的简历
    array('a_complete_delegated_resume','Home/MiddleMan/do_completeDelegatedResume','',''), //经纪人完成委托来的简历
    array('read_delegate_job','Home/MiddleMan/do_read_delegate_job','',''), //经纪人查看委托来的职位
    array('a_delete_private_resume','Home/MiddleMan/do_deletePrivateResume','',''),                             //经纪人删除私有简历
    array('apausejob','Home/MiddleMan/do_pause_job','',''),                             //经纪人暂停职位
    array('setPrivacyAgent','Home/MiddleMan/setPrivacyAgent','',''),                    //经纪人隐私

    array('a_update_human','Home/PrivateResume/do_UpdateHuman','',''),                  //经纪人修改人才信息
    array('a_update_hc','Home/PrivateResume/do_UpdateHangCardIntent','',''),         //经纪人修改挂证意向
    array('a_get_rc_list','Home/PrivateResume/get_RClist','',''),                    //经纪人获取注册证书
    array('a_add_rc','Home/PrivateResume/do_addRC','',''),                      //经纪人添加注册证书
    array('a_delete_work_exp','Home/PrivateResume/do_deleteWorkExp','',''),              //经纪人删除工作经历
    array('a_delete_p_a','Home/PrivateResume/do_deletePA','',''),                   //经纪人删除工程业绩
    array('a_delete_rc','Home/PrivateResume/do_deleteRC','',''),                   //经纪人删除注册证书
    array('a_update_job_intent','Home/PrivateResume/do_UpdateJobIntent','',''),            //经纪人修改求职意向
    array('a_update_degree','Home/PrivateResume/do_UpdateDegree','',''),               //经纪人修改学历
    array('a_update_cc','Home/PrivateResume/do_UpdateCertificateCase','',''),      //经纪人修改注册情况
    array('a_update_work_exp','Home/PrivateResume/do_UpdateWorkExp','',''),              //经纪人修改工作经历
    array('a_update_p_a','Home/PrivateResume/do_UpdatePA','',''),                   //经纪人修改工程业绩
    array('a_get_we_list','Home/PrivateResume/get_WorkExpList','',''),               //经纪人获取工作经历列表
    array('a_get_pa_list','Home/PrivateResume/get_PAlist','',''),                    //经纪人获取工程业绩列表

    array('apblog','Home/MiddleMan/createBlogIndex','',''),       //经纪人创建Blog页面
    array('a_update_blog_index','Home/MiddleMan/updateBlogIndex','id',''),        //经纪人更新Blog页面
    array('a_create_blog','Home/Blog/do_createBlog','',''),           //经纪人创建Blog
    array('a_update_blog','Home/Blog/do_updateBlog','',''),            //经纪人修改Blog
    array('a_delete_blog','Home/Blog/do_deleteBlog','',''),             //经纪人删除Blog
    array('a_ask_validate_blog','Home/Blog/do_askForValidateBlog','',''),  //经纪人申请审核Blog
    array('ablogs','Home/MiddleMan/adminBlogIndex','',''), //经纪人管理Blog页面
    array('a_get_blog_list','Home/Blog/get_ownBlogList','',''),           //经纪人获取Blog列表
    array('get_blog_list','Home/Blog/get_blogList','',''),              //获取Blog列表
    array('get_blogCreator_rank_list','Home/Blog/get_creatorRankList','',''),                                          //获取发布排行榜
    array('get_hot_blog_list','Home/Blog/get_HotBlogList','',''),       //获取本周或本月十大热文
    
    //------------------证书-------------------
    array('get_rcerts', 'Home/Certificate/get_register_cert', '', ''),      //获取注册证书列表
    array('get_rcert_major', 'Home/Certificate/get_rcert_major', '', ''),   //获取指定注册证书专业列表
    array('get_gcert_type', 'Home/Certificate/get_gcert_type', '', ''),     //获取职称证书类型列表
    array('get_gcerts', 'Home/Certificate/get_grade_cert', '', ''),         //获取指定职称类型下的专业列表

    //------------------详细页-------------------
    array('office', 'Home/Detail/job', 'id', ''),                               //职位详细页面
    array('agent', 'Home/Detail/agent', 'id', ''),                              //经纪人详细页面
    array('company', 'Home/Detail/company', 'id', ''),                          //企业详细页面
    array('dhuman', 'Home/Detail/human', 'id', ''),                             //人才详细页面
    array('get_company_jobs', 'Home/Detail/get_company_jobs', '', ''),          //获取指定企业发布的职位列表
    array('get_resume','Home/Detail/resume','human_id',''),                     //简历详细页面(human_id)
    array('dtask','Home/Detail/task','id',''),                                  //任务详细页面
    array('get_d_resume','Home/Detail/delegatedResume','delegate_resume_id',''),//委托简历详细页面
    array('get_s_resume','Home/Detail/sentResume','send_resume_id',''),         //应聘来的简历详细页
    array('get_running_job','Home/Detail/get_running_jobs','',''),              //获取运作的职位列表
    array('get_running_resume','Home/Detail/get_running_resumes','',''),        //获取运作的简历列表
    array('report','Home/Detail/report','newtype,report',''),

    //------------------------邀请注册--------------------
    array('invitation','Home/Invite/index','',''),                              //邀请注册页面
    
    //------------------------人才------------------------
    array('upload_cert','Home/Human/do_upload_cert','',''),                     //上传证书复印件
    array('remove_cert_ct','Home/Human/do_remove_certification','',''),         //解除人才证书认证
    array('update_gcert','Home/Human/do_update_gcert','',''),                   //更新人才职称证书
    array('add_gcert','Home/Human/do_add_gcert','',''),                         //添加人才职称证书
    array('delete_rcert','Home/Human/do_delete_rcert','',''),                   //删除人才资质证书
    array('add_rcert','Home/Human/do_add_rcert','',''),                         //添加人才资质证书
    array('end_delegate_resume','Home/Human/do_end_delegate_resume','',''),     //人才终止委托简历
    array('h_get_recommend_job','Home/Human/get_RecommendJob','',''),            //人才查看系统推荐的职位
    array('h_send_resume','Home/Human/do_SendResumeToJob','',''),                //人才投递简历
    array('h_open_resume','Home/Human/do_OpenResume','',''),                     //人才公开简历
    array('h_close_resume','Home/Human/do_CloseResume','',''),                   //人才关闭简历
    array('h_delegate_resume','Home/Human/do_DelegateResume','',''),             //人才将简历委托给经纪人
    array('h_get_sent_job','Home/Human/get_SentJob','',''),                      //人才查看应聘过的职位
    array('h_get_interested_job','Home/Human/get_InterestedJob','',''),          //人才查看感兴趣的职位
    array('h_get_interested_company','Home/Human/get_InterestedCompany','',''),  //人才查看感兴趣的企业
    array('h_get_agent_list','Home/Human/get_AgentList','',''),                  //人才找经纪人
    array('t_index','Home/Human/home','',''),                                   //人才首页
    array('thome','Home/Human/index','',''),                                    //人才推荐页面
    array('tfj','Home/Human/getJobIndex','',''),                                //人才找职位页面
    array('tfe','Home/Human/getCompanyIndex','',''),                            //人才找企业页面
    array('tfa','Home/Human/getAgentIndex','type',''),                          //人才找经纪人页面
    array('resume','Home/Human/resumeIndex','',''),                             //人才的简历页面
    array('certificate','Home/Human/certificateIndex','',''),                   //人才的证书页面
    array('check_resume','Home/Human/do_check_resume','',''),                   //检测人才简历完整性
    array('h_get_recommend_agent','Home/Human/get_RecommendAgent','',''),       //人才查看系统推荐的经纪人
    
    //------------------------工具------------------------
    array('contract','Home/Tool/contract','',''),                               //合同下载页面
    array('market','Home/Tool/market','',''),                                   //市场行情页面
    array('contract_download','Home/Tool/contract_download','id',''),             //合同下载
    array('refer','Home/Tool/refer','',''),                                     //查询页面
    array('contactbook','Home/Tool/contactbook','',''),                         //通讯录页面
    array('arefer','Home/Tool/arefer','',''),                                   //受理发证信息查询页面
    array('prefer','Home/Tool/prefer','',''),                                   //人员资格查询页面
    array('get_year_market','Home/Tool/get_year_market','',''),                 //获取年度行情统计数据
    array('get_market_current','Home/Tool/get_market_current','',''),           //获取本月行情数据
    array('get_year_market_compare','Home/Tool/get_year_market_compare','',''), //获取年度市场行情对比
    array('pdmail','Home/Tool/pdmail','',''),                                   //人事部通讯录页面
    
    //------------------------管理------------------------
    array('real_auth_notify','Aiiao/Audit/real_auth_notify','',''),              //实名认证通知
    array('cert_auth_notify','Aiiao/Audit/cert_auth_notify','',''),              //证书认证通知
    array('system_notify','Aiiao/Audit/system_notify','',''),                    //发送系统通知
    array('recharge_notify','Aiiao/Audit/recharge_notify','',''),                //充值通知
    array('blog_auth_notify','Aiiao/Audit/blog_auth_notify','',''),                //blog通知
    array('feedback_notify','Aiiao/Audit/feedback_notify','',''),                //反馈建议
    array('report_notify','Aiiao/Audit/report_notify','',''),                //举报通知
    array('package_notify','Aiiao/Audit/package_notify','',''),                //套餐通知
    array('user_close_notify','Aiiao/Audit/user_close_notify','',''),                //账号冻结
    array('user_open_notify','Aiiao/Audit/user_open_notify','',''),                //账号解禁
    array('send_resume','Aiiao/Audit/send_resume','',''),                //内部投递简历

    //---------------------------------资讯-----------------------------
    array('news','Home/Information/index','',''),    //资讯首页
    array('articles','Home/Information/infoListIndex','user_id,art_blog,class_id,page',''), //资讯列表页
    array('article','Home/Information/infoDetailIndex','is_blog,blog_id',''), //资讯详细页
    array('get_info_list','Home/Information/get_info_list','',''), //获取网站资讯列表
    //--------------------------------------推荐-----------------------------------
    array('get_recommend_job','Home/Recommend/get_job','',''),             //推荐职位
    array('get_recommend_resume','Home/Recommend/get_resume','',''),       //推荐简历
    array('get_recommend_agent','Home/Recommend/get_agent','',''),         //推荐经纪人
    array('get_recommend_company','Home/Recommend/get_company','',''),     //推荐企业
    array('change_recommend_human','Home/Recommend/get_human','',''),      //首页推荐人才换一换
    //--------------------------------------CRM-----------------------------------
    array('resource','Crm/CIndex/index','',''),      //CRM首页
    array('rhuman','Crm/CHuman/index','id',''),      //CRM人才详情
    array('rcompany','Crm/CCompany/index','id',''),      //CRM企业详情
    
    //-------------------------------------隐私----------------------
    array('do_package_min','Home/Public/do_package_min','',''),      //拨打接口
    array('do_call','Home/Public/do_call','passive_user_id',''),      //拨打认证和分钟数限制
    array('do_call_request','Home/Public/do_call_request','',''),      //回拨回调函数
    //-------------------------------------经纪公司----------------------
    array('broker','Home/BrokerFirms/index','',''),
    array('get_broker','Home/BrokerFirms/get_filter_broker_staff','',''),
    array('freeze','Home/BrokerFirms/do_freeze_user','',''),
    array('unfreeze','Home/BrokerFirms/do_unfreeze_user','',''),
    //-------------------------------------资质证书删除----------------------
    array('delete_certificate_copy','Crm/Chuman/delete_certificate_copy','',''),
    
    //---------------------------搜索-----------------------------------
    array('search_job','Home/Public/searchJob','super',''),  //搜索职位
    array('a_search_job','Home/MiddleMan/get_searchJob','',''), //经纪人搜索职位
    array('h_search_job','Home/Human/get_searchJob','',''), //人才搜索职位
    
    //---------------------------钩子-----------------------------------
    array('edm04115207', 'Home/Hook/aedm20120725hook')
);

?>

