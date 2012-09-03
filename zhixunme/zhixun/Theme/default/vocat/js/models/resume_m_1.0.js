/*
 * 简历 - model类
 */
function Resume(){
    this.rid="rid";
    //证书
    this.cert="cert";
    //日期
    this.date="date";
    //经验
    this.exp="exp";
    //是否被关注
    this.follow="follow";
    //用户名字
    this.u_name="u_name";
    //人才名字
    this.name="h_name";
    //用户头像
    this.u_photo="u_photo";
    //人才薪资
    this.salary="salary";
    //用户角色
    this.role="role";
    //用户邮箱认证
    this.email_auth="email_auth";
    //用户手机认证
    this.phone_auth="phone_auth";
    //用户实名认证
    this.real_auth="real_auth";
    //具体到市的地区
    this.place="place";
    //期望工作地点
    this.location="location";
    //薪资
    this.salary="salary";
    //求职岗位
    this.pos="pos";
    //人才id
    this.h_id="h_id";
    //投递简历ID
    this.send_resume_id="send_resume_id";
    //投递简历次数
    this.send_count="send_count";
    //应聘职位
    this.apply_job="apply_job";
}
Resume.prototype={
    /* 功能：更新兼职简历个人基本信息
     * 参数：
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    UpResPinfo:function(p,sf,ff){
         var str="name="+p.name+"&gender="+p.gender+"&birth="+p.birth+"&pid="+p.pid+"&cid="+p.cid+"&phone="+p.phone+"&email="+p.email;
             str=str+"&qq="+p.qq+"&exp="+p.exp;
         var setting={
            url:RESUMEUR.DoUpdatePersonInfo,
            params:str,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：(全职)更新简历求职岗位基本信息
     * 参数：
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    JobpositionSave:function(p,sf,ff){
        var str="job_name="+p.job_name+"&job_province_code="+p.job_province_code+"&job_city_code="+p.job_city_code;
        str=str+"&job_salary="+p.job_salary+"&treatment="+p.treatment+"&job_describle="+p.job_describle;
         var setting={
            url:RESUMEUR.DoUpJobPosition,
            params:str,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：(全职)添加个人工作经验信息
     * 参数：p
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    AddExper:function(p,sf,ff){
        var str="department="+p.department+"&work_startdate="+p.work_startdate+"&work_enddate="+p.work_enddate+"&company_name="+p.company_name;
        str=str+"&company_industry="+p.company_industry+"&company_scale="+p.company_scale+"&company_property="+p.company_property+"&job_name="+p.job_name+"&job_describle="+p.job_describle
         var setting={
            url:RESUMEUR.AdFuExperience,
            params:str,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：猎头创建全职简历 - 添加工作经历
     * 参数：
     * a：部门
     * b：开始日期
     * c：结束日期
     * d：公司名称
     * e：行业名称
     * f：公司规模
     * g：公司性质
     * h：职位名称
     * i：职位描述
     * j：简历id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：true | false
     */
    AAddWExp:function(a,b,c,d,e,f,g,h,i,j,sf,ff){
        var setting={
            url:RESUMEUR.AAddWExp,
            params:"department="+a+"&work_startdate="+b+"&work_enddate="+c+"&company_name="+d
                +"&company_industry="+e+"&company_scale="+f+"&company_property="+g+"&job_name="
                +h+"&job_describle="+i+"&resume_id="+j,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：猎头创建全职简历 - 添加工作经历
     * 参数：
     * a：项目名称
     * b：项目规模
     * c：开始时间
     * d：结束时间
     * e：担任职位
     * f：工作内容
     * g：简历id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：true | false
     */
    AAddPExp:function(a,b,c,d,e,f,g,sf,ff){
        var setting={
            url:RESUMEUR.AAddPExp,
            params:"name="+a+"&scale="+b+"&start_date="+c+"&end_date="+d+"&job_name="+e
                    +"&job_describle="+f+"&resume_id="+g,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
     /* 功能：(全职)删除个人工作经验信息
     * 参数：
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    DeleWorkexp:function(p,sf,ff){
         var setting={
            url:RESUMEUR.DodelExp,
            params:"work_exp_id="+p,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：(全职)删除个人工程业绩信息
     * 参数：
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    DelePojectAchive:function(p,sf,ff){
          var setting={
            url:RESUMEUR.DoDeleAchivement,
            params:"project_achievement_id="+p,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
     /* 功能：(全职)添加个人工程业绩信息
     * 参数：
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    AddProAchive:function(p,sf,ff){
        var str="name="+p.name+"&scale="+p.scale+"&start_date="+p.start_date+"&end_date="+p.end_date+"&job_name="+p.job_name;
        str =str+"&job_describle="+p.job_describle;
          var setting={
            url:RESUMEUR.DoAdAchive,
            params:str,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /*
     *(兼职/全职)
     *选择公开兼职简历方式
     *参数：类别
     *1全职2兼职
     */
    PubPartresume:function(p,sf,ff){
          var setting={
            url:RESUMEUR.DopubPart,
            params:"job_category="+p,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
     /*
     *(兼职/全职)
     *选择公开兼职简历方式
     *参数：类别
     *1全职2兼职
     */
    deleGateAgent:function(p,sf,ff){
            var setting={
            url:RESUMEUR.DoDeleGatePub,
            params:"job_category="+p,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
     /*
     *(兼职/全职)
     *选择结束简历方式
     *参数：无
     */
    EndPartresume:function(sf,ff){
         var setting={
            url:RESUMEUR.DoEndPart,
            params:"",
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /*
     *解除委托简历锁
     *jack
     *2012-2-12
     */
    UnLockResume:function(sf,ff){
     var setting={
                url:RESUMEUR.DoUnlockResum,
                params:"",
                sucrender:sf,
                failrender:ff
            };
            HGS.Base.HAjax(setting);
    },
    /*
     *查看兼职人才简历联系方式
     *参数：object_id:简历ID
     *object_type:类型：1
     *jack
     *2012-2-12
     */
    GetTaContact:function(id,type,sf,ff){
       var setting={
            url:WEBURL.GetContact,
            params:"object_id="+id+"&object_type="+type,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
     /* 功能：(全职)更新个人学历基本信息
     * 参数：
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    UpPereducation:function(p,sf,ff){
         var str="study_startdate="+p.study_startdate+"&study_enddate="+p.study_enddate+"&school="+p.school;
            str=str+"&major_name="+p.major_name+"&degree_name="+p.degree_name;
         var setting={
            url:RESUMEUR.DoUpPersonEdu,
            params:str,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：人才投递简历
     * 参数：
     * a：职位id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    SendResume:function(a,sf,ff){
        var setting={
            url:RESUMEUR.SendResume,
            params:"job_id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
     /* 功能：删除资质证书
     * 参数：证书id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    DeleCert:function(cid,s){
        var setting={
            url:RESUMEUR.DleCertificate,
            params:"certificate_id="+cid,
            sucrender:s
        };
	HGS.Base.HAjax(setting);
    },
     /* 功能：添加资质证书
     * 参数：RC_id:注册证书ID
            register_place:注册地省份编号
            register_case:注册情况
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    AddCert:function(rid,rp,rc,s,f){
        var setting={
            url:RESUMEUR.AddCerficate,
            params:"RC_id="+rid+"&register_place="+rp+"&register_case="+rc,
            sucrender:s,
            failrender:f
        };
	HGS.Base.HAjax(setting);
    },
     /* (兼职)功能：更新资质证书
      * p
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    UpdateCert:function(p,s,f){
        var str="certificate_id="+p.certificate_id+"&GC_id="+p.GC_id+"&GC_class="+p.GC_class+"&certificate_remark="+p.certificate_remark;
            str=str+"&job_salary="+p.job_salary+"&treatment="+p.treatment+"&register_province_ids="+p.register_province_ids;
         var setting={
            url:RESUMEUR.UpdateCertificate,
            params:str,
            sucrender:s,
            failrender:f
        };
	HGS.Base.HAjax(setting);
    },

      /* (全职)功能：更新资质证书
      * p
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    UpdateFultimeCert:function(p,s,f){
        var str="certificate_id="+p.certificate_id+"&GC_id="+p.GC_id+"&GC_class="+p.GC_class+"&certificate_remark="+p.certificate_remark;
         var setting={
            url:RESUMEUR.UpFultCert,
            params:str,
            sucrender:s,
            failrender:f
        };
	HGS.Base.HAjax(setting);
    },
      /* (兼职)功能：更新资质证书
      * p
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    GetCertiy:function(s,f){
         var setting={
            url:RESUMEUR.GetCerts,
            sucrender:s,
            failrender:f
        };
	HGS.Base.HAjax(setting);
    },
    /**
     * 功能：获取委托来的人才列表
     * s:委托状态（1-未公开，2-求职中）
     * t:工作性质（1-全职，2-兼职）
     * p:第几页
     * c:每页条数（此参数暂未开放）
     * r:注册情况（1-初始，2-变更，3-重新）（此参数暂未开放）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    GetAHuman:function(s,t,p,c,r,sf,ff){
        var set={
            url:RESUMEUR.AGetAgentedHuman,
            params:"delegate_state="+s+"&job_category="+t+"&page="+p+"&size="+CONSTANT.C0004,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /**
     * 功能：获取猎头感兴趣的人才列表
     * t:工作性质（1-全职，2-兼职）
     * p:第几页
     * c:每页条数（此参数暂未开放）
     * r:注册情况（1-初始，2-变更，3-重新）（此参数暂未开放）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    GetIAHuman:function(a,t,p,c,r,sf,ff){
        var set={
            url:RESUMEUR.AGetIHuman,
            params:"publisher_role="+a+"&job_category="+t+"&page="+p+"&size="+CONSTANT.C0004,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /**
     * 功能：猎头 - 公开简历
     * a：简历
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    APubResume:function(a,sf,ff){
        var set={
            url:RESUMEUR.APubResume,
            params:"resume_id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /**
     * 功能：猎头 - 结束求职
     * a：简历
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ACloseResume:function(a,sf,ff){
        var set={
            url:RESUMEUR.ACloseResume,
            params:"resume_id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *获取应聘来的简历列表
     *jack
     *2012-2-17
     *参数：page 页面索引
     *page_size 每页显示条数
     *job_category 简历类型
     *sent_status 投递状态
     *sender_role 投递角色
     */
    GetAppliedReume:function(page,page_size,job_category,sent_status,sender_role,sf,ff){
         var set={
            url:RESUMEUR.DogetAppResumeList,
            params:"page="+page+"&size="+page_size+"&job_category="+job_category+"&sent_status="+sent_status+"&sender_role="+sender_role,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
       /*
     *企业获取应聘来的简历列表
     *jack
     *2012-2-17
     *参数：page 页面索引
     *page_size 每页显示条数
     *job_category 简历类型
     *sent_status 投递状态
     *sender_role 投递角色
     */
    EGetAppliedReume:function(page,page_size,job_category,sent_status,sender_role,sf,ff){
         var set={
            url:RESUMEUR.EgetAppResumeList,
            //url:JOBURL.EGetResList,            
            params:"page="+page+"&size="+page_size+"&job_category="+job_category+"&sent_status="+sent_status+"&sender_role="+sender_role,            
            //params:"job="+5+"&page="+page,            
            sucrender:sf,
            failrender:ff
        };        
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头创建兼职简历
     *参数：
     * a：姓名
     * b：性别(0-女,1-男)
     * c：出生日期
     * d：省份编号
     * e：城市编号
     * f：联系人手机
     * g：联系人QQ
     * h：联系人邮箱
     * i：工作年限(1,2,3,4)
     * j：注册证书id（以","隔开）
     * k：注册情况（以","隔开）
     * l：注册地省份编号（以","隔开）
     * m：职称证书id
     * n：职称证书级别
     * o：期望待遇
     * o1:期望待遇手动输入
     * p：期望注册地id（以","隔开）
     * q：是否公开简历
     * r：补充说明
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ACreatPResume:function(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,o1,p,q,r,sf,ff){
         var set={
            url:RESUMEUR.ACreReume,
            params:"name="+a+"&gender="+b+"&birthday="+c+"&province_code="+d+"&city_code="+e
                    +"&contact_mobile="+f+"&contact_qq="+g+"&contact_email="+h+"&work_age="+i+"&RC_ids="+j
                    +"&RC_cases="+k+"&RC_provinces="+l+"&GC_id="+m+"&GC_class="+n+"&job_salary="+o
                    +"&treatment="+o1+"&register_province_ids="+p+"&is_public="+q+"&certificate_remark="+r,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
     /*
     *功能;企业立即查看应聘来的简历
     *参数：投递简历ID
     *jack
     *2012-2-18
     */
    CheckAppReume:function(s,sf,ff){
        var set={
            url:RESUMEUR.DoComChkSResume,
            params:"send_resume_id="+s,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
     /*
     *功能;经纪人立即查看应聘来的简历
     *参数：投递简历ID
     *jack
     *2012-2-18
     */
    CheckAgentAppReume:function(s,sf,ff){
        var set={
            url:RESUMEUR.DoCheckAppResume,
            params:"send_resume_id="+s,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：获取猎头添加的简历列表
     *参数：page：当前页
     *size：每页显示条数
     *status：求职状态
     *category：0 不限
     *2：未公开
     *3：已公开
     *suc:成功执行函数
     *fail:失败执行函数
    */
   GetAddedResumList:function(page,size,category,staus,sf,ff){
     var set={
                url:RESUMEUR.DoGetAddedResum,
                params:"page="+page+"&size="+size+"&category="+category+"&status="+staus,
                sucrender:sf,
                failrender:ff
            };
            HGS.Base.HAjax(set);
   },
    /*
     *功能：猎头创建全职简历第一步
     *参数：
     * a：姓名
     * b：性别(0-女,1-男)
     * c：出生日期
     * d：省份编号
     * e：城市编号
     * f：联系人手机
     * g：联系人QQ
     * h：联系人邮箱
     * i：工作年限(1,2,3,4)
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ACreatFResStep1:function(a,b,c,d,e,f,g,h,i,sf,ff){
         var set={
            url:RESUMEUR.ACRStep1,
            params:"name="+a+"&gender="+b+"&birthday="+c+"&province_code="+d+"&city_code="+e
                    +"&contact_mobile="+f+"&contact_qq="+g+"&contact_email="+h+"&work_age="+i,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头创建全职简历第二步
     *参数：
     * a：人才id
     * b：职位名称
     * c：工作地点省份编号
     * d：工作地点城市编号
     * e：期望待遇
     * e1：期望待遇
     * f：职位描述
     * g：学历起始时间
     * h：学历终止时间
     * i：学校名称
     * j：专业名称
     * k：学历value值（1，2，3，4）
     * l：注册证书id集合（“,”分隔）
     * m：注册情况集合（“,”分隔）
     * n：注册地省份编号（“,”分隔）
     * o：职称证书id
     * p：职称证书级别
     * q：证书补充说明
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ACreatFResStep2:function(a,b,c,d,e,e1,f,g,h,i,j,k,l,m,n,o,p,q,sf,ff){
         var set={
            url:RESUMEUR.ACRStep2,
            params:"human_id="+a+"&job_name="+b+"&job_province_code="+c+"&job_city_code="+d+"&job_salary="+e
                    +"&treatment="+e1+"&job_describle="+f+"&study_startdate="+g+"&study_enddate="+h+"&school="+i+"&major_name="+j
                    +"&degree_name="+k+"&RC_ids="+l+"&RC_cases="+m+"&RC_provinces="+n+"&GC_id="+o+"&GC_class="+p
                    +"&certificate_remark="+q,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 委托来的简历 - 完成求职
     *参数：
     * a：简历id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    AComResume:function(a,sf,ff){
         var set={
            url:RESUMEUR.AComResume,
            params:"resume_id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 委托来的简历 - 查看详细
     *参数：
     * a：简历id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ACheckRDetial:function(a,sf,ff){
         var set={
            url:RESUMEUR.ACheckRDetial,
            params:"rid="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头-我添加的简历-删除
     *参数：
     *human_id :人才id
     *sf:删除成功执行函数
     *ff:删除失败执行函数
     */
    DoDeleAdeResum:function(uid,sf,ff){
         var set={
            url:RESUMEUR.DeleAresm,
            params:"human_id="+uid,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 人才信息保存
     *参数：
     * a：人才id
     * b：姓名
     * c：性别
     * d：生日
     * e：所在地省份id
     * f：所在地市id
     * g：手机
     * h：qq
     * i：邮箱
     * j：工作年限
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ASaveTInfo:function(a,b,c,d,e,f,g,h,i,j,sf,ff){
         var set={
            url:RESUMEUR.ASaveTInfo,
            params:"human_id="+a+"&&name="+b+"&&gender="+c+"&&birthday="+d+"&&province_code="+e
                    +"&&city_code="+f+"&&contact_mobile="+g+"&&contact_qq="+h+"&&contact_email="+i+"&&work_age="+j,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 求职岗位保存
     *参数：
     * a：人才id
     * b：求职意向id
     * c：职位名称
     * d：期望工作地省份id
     * e：期望工作地市id
     * f：期望待遇
     * g：职位描述
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ASaveGetPos:function(a,b,c,d,e,f,f1,g,sf,ff){
         var set={
            url:RESUMEUR.ASaveGetPos,
            params:"human_id="+a+"&&job_intent_id="+b+"&&job_name="+c+"&&job_province_code="+d+"&&job_city_code="+e
                    +"&&job_salary="+f+"&&treatment="+f1+"&&job_describle="+g,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 学历保存
     *参数：
     * a：人才id
     * b：学历id
     * c：学历开始时间
     * d：学历结束时间
     * e：学校名称
     * f：专业名称
     * g：学历值
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ASaveDegree:function(a,b,c,d,e,f,g,sf,ff){
         var set={
            url:RESUMEUR.ASaveDegree,
            params:"human_id="+a+"&&degree_id="+b+"&&study_startdate="+c+"&&study_enddate="+d+"&&school="+e
                    +"&&major_name="+f+"&&degree_name="+g,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 修改工作经历
     *参数：
     * a：人才id
     * b：工作经历id
     * c：部门名称
     * d：工作经历开始时间
     * e：工作经历结束时间
     * f：公司名称
     * g：行业名称
     * h：公司规模
     * i：公司性质
     * j：职位
     * k：工作描述
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    AUpdateDegree:function(a,b,c,d,e,f,g,h,i,j,k,sf,ff){
         var set={
            url:RESUMEUR.AUpdateDegree,
            params:"human_id="+a+"&&id="+b+"&&department="+c+"&&work_startdate="+d+"&&work_enddate="+e
                    +"&&company_name="+f+"&&company_industry="+g+"&&company_scale="+h+"&&company_property="+i
                    +"&&job_name="+j+"&&job_describle="+k,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 修改工程业绩
     *参数：
     * a：人才id
     * b：工程业绩id
     * c：项目名称
     * d：规模大小
     * e：项目开始时间
     * f：项目结束时间
     * g：担任职位
     * h：工作内容
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    AUpdateWExp:function(a,b,c,d,e,f,g,h,sf,ff){
         var set={
            url:RESUMEUR.AUpdateWExp,
            params:"human_id="+a+"&&id="+b+"&&name="+c+"&&scale="+d+"&&start_date="+e
                    +"&&end_date="+f+"&&job_name="+g+"&&job_describle="+h,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 删除资质证书
     *参数：
     * a：人才id
     * b：证书id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ADelRC:function(a,b,sf,ff){
         var set={
            url:RESUMEUR.ADelRC,
            params:"human_id="+a+"&&certificate_id="+b,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 添加资质证书
     *参数：
     * a：人才id
     * b：证书id
     * c：注册地
     * d：注册情况
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    AAddRC:function(a,b,c,d,sf,ff){
         var set={
            url:RESUMEUR.AAddRC,
            params:"human_id="+a+"&&RC_id="+b+"&&register_place="+c+"&&register_case="+d,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 证书情况修改
     *参数：
     * a：人才id
     * b：资质证书id
     * c：职称证书id
     * d：职称级别
     * e：补充说明
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    AUpdateCert:function(a,b,c,d,e,sf,ff){
         var set={
            url:RESUMEUR.AUpdateCert,
            params:"human_id="+a+"&&certificate_id="+b+"&&GC_id="+c+"&&GC_class="+d+"&&certificate_remark="+e,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 兼职简历修改 - 证书情况修改
     *参数：
     * a：人才id
     * b：资质证书id
     * c：职称证书id
     * d：职称级别
     * e：补充说明
     * f：期望待遇
     * f1：期望待遇
     * g：期望注册地id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    AUpdatePCert:function(a,b,c,d,e,f,f1,g,sf,ff){
         var set={
            url:RESUMEUR.AUpdatePCert,
            params:"human_id="+a+"&&certificate_id="+b+"&&GC_id="+c+"&&GC_class="+d+"&&certificate_remark="+e
                    +"&&job_salary="+f+"&&treatment="+f1+"&&register_province_ids="+g,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 删除工作经历
     *参数：
     * a：工作经历id
     * b：简历id
     * c：人才id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ADeleWExp:function(a,b,c,sf,ff){
         var set={
            url:RESUMEUR.ADeleWExp,
            params:"work_exp_id="+a+"&&resume_id="+b+"&&human_id="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 - 全职简历修改 - 删除工程业绩
     *参数：
     * a：人才id
     * b：工程业绩id
     * c：简历id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    ADeleWGrade:function(a,b,c,sf,ff){
         var set={
            url:RESUMEUR.ADeleWGrade,
            params:"human_id="+a+"&&project_achievement_id="+b+"&&resume_id="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：获取指定猎头正在运作的简历
     *参数：
     * a：猎头id
     * b：职位类型（1：全职，2：兼职）
     * c：第几页
     * d：条数
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     */
    GetARunResumes:function(a,b,c,d,sf,ff){
         var set={
            url:RESUMEUR.GetARunResumes,
            params:"id="+a+"&type="+b+"&page="+c+"&size="+d,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    }
}
