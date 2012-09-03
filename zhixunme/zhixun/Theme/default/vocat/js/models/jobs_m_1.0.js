/*
 * 职位 - model类
 */
function Jobs(){
    //职位id
    this.id="id";
    //职位标题
    this.title="title";
    //证书使用地
    this.place="place";
    //人才证书使用地或企业工作地点
    this.location="location";
    //证书情况
    this.cert="cert";
    //收到简历数
    this.rcount="rcount";
    //收到简历数样式
    this.rclass="rclass";
    //职位发布者头像
    this.photo="u_photo";
    //职位发布者名字
    this.uname="u_name";
    //发布者是否已被当前用户关注
    this.follows="follow";
    //企业招聘人数
    this.count="count";
    //学历要求
    this.degree="degree";
    //招聘岗位
    this.pos="pos";
    //招聘企业
    this.company="company";
    //时间
    this.date="date";
    //手机认证
    this.pauth="phone_auth";
    //邮箱认证
    this.eauth="email_auth";
    //身份认证
    this.rauth="real_auth";
    //薪资
    this.salary="salary";
}
Jobs.prototype={
    /* 功能：猎头发布全职职位
     * 参数：
     * a：标题
     * b：职位名称
     * c：招聘类别（1：预招 2：热招）
     * d：招聘人数
     * e：资质证书编号（多个以,号隔开）
     * f：资质证书注册情况（多个以,号隔开）
     * g：职称证书编号
     * h：职称等级
     * i：省
     * j：薪资
     * j1：手动输入薪资
     * k：学历
     * l：工作经验
     * m：职位描述
     * n：类型（1：全职，2：兼职）
     * o：市
     * p;招聘企业
     * q:企业资质
     * r:企业性质
     * s:成立时间
     * t:企业规模
     * u:企业简介
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     * 修改(新增参数)：@jack 2012-7-12
     */
    APubFullPos:function(a,b,c,d,e,f,g,h,i,j,j1,k,l,m,n,o,p,q,r,s,t,u,sf,ff){
        var str="title="+a+"&job="+b+"&job_type="+c+"&count="+d+"&RCIS="+e+"&RCSS="+f+"&GCI="+g+"&GCC="+h+"&pid="
                    +i+"&salary="+j+"&treatment="+j1+"&degree="+k+"&exp="+l+"&description="+m+"&type="+n+"&cid="+o
                    +"&name="+p+"&company_qualification="+q+"&company_category="+r+"&company_regtime="+s+"&company_scale="+t+"&company_introduce="+u;
        var set={
            url:JOBURL.APubJob,
            params:str,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：猎头发布兼职职位
     * 参数：
     * a：标题
     * b：招聘类别（1：预招 2：热招）
     * c：资质证书编号（多个以,号隔开）
     * d：资质证书注册情况（多个以,号隔开）
     * e：资质证书个数（多个以,隔开）
     * f：职称证书编号
     * g：职称等级
     * h：地区要求（多个以,号隔开）
     * i：省份编号
     * j：城市编号
     * k：薪资
     * l：是否考取安全B证（0否，1是）
     * m：是否允许多证（0否，1是）
     * n：学历
     * o：工作经验
     * p：工作状态（1不限，2在职，3退休）
     * q：社保要求（1不限，2需缴纳，3不需缴纳）
     * r：类型（1：全职，2：兼职）
     * s: 职位描述
     * t:招聘企业
     * u:企业资质
     * v：企业性质
     * w:企业成立时间
     * x:企业规模
     * y:企业简介
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     * 修改：joe  2012/7/11
     * 修改(新增参数)：Jack  2012/7/12
     */
    APubOtherPos:function(a,b,c,d,e,f,g,h,i,j,k,k1,l,m,n,o,p,q,r,s,t,u,v,w,x,y,sf,ff){
        var str="title="+a+"&job_type="+b+"&RCIS="+c+"&RCSS="+d+"&RCCS="+e+"&GCI="+f+"&GCC="+g+"&place="
                    +h+"&pid="+i+"&cid="+j+"&salary="+k+"&treatment="+k1+"&safety_b="+l+"&muti="+m+"&degree="+n+"&exp="+o
                    +"&status="+p+"&social="+q+"&type="+r+"&description="+s+"&name="+t+"&company_qualification="+u+"&company_category="+v
                    +"&company_regtime="+w+"&company_scale="+x+"&company_introduce="+y;
        var set={
            url:JOBURL.APubJob,
            params:str,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：企业发布全职职位
     * 参数：
     * a：标题
     * b：职位名称
     * c：操作（1为发布，2为委托）
     * d：招聘人数
     * e：资质证书编号（多个以,号隔开）
     * f：资质证书注册情况（多个以,号隔开）
     * g：职称证书编号
     * h：职称等级
     * i：省
     * j：薪资
     * k：学历
     * l：工作经验
     * m：职位描述
     * n：类型（1：全职，2：兼职）
     * o：市
     * p:招聘类别（1：预招 2：热招）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     * 修改(新增参数)：Jack  2012/7/12
     */
    EPubFullPos:function(a,b,c,d,e,f,g,h,i,j,j1,k,l,m,n,o,p,sf,ff){
        var set={
            url:JOBURL.EPubJob,
            params:"title="+a+"&job="+b+"&do="+c+"&count="+d+"&RCIS="+e+"&RCSS="+f+"&GCI="+g+"&GCC="+h+"&pid="
                    +i+"&salary="+j+"&treatment="+j1+"&degree="+k+"&exp="+l+"&description="+m+"&type="+n+"&cid="+o+"&job_type="+p,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：企业发布兼职职位
     * 参数：
     * a：标题
     * b：操作（1为发布，2为委托）
     * c：资质证书编号（多个以,号隔开）
     * d：资质证书注册情况（多个以,号隔开）
     * e：资质证书个数（多个以,隔开）
     * f：职称证书编号
     * g：职称等级
     * h：地区要求（多个以,号隔开）
     * i：省份编号
     * j：城市编号
     * k：薪资
     * k1：薪资
     * l：是否考取安全B证（0否，1是）
     * m：是否允许多证（0否，1是）
     * n：学历
     * o：工作经验
     * p：工作状态（1不限，2在职，3退休）
     * q：社保要求（1不限，2需缴纳，3不需缴纳）
     * r：类型（1：全职，2：兼职）
     * s: 职位描述
     * t:招聘类别（1：预招 2：热招）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     * 修改(新增参数)：Jack  2012/7/12
     */
    EPubOtherPos:function(a,b,c,d,e,f,g,h,i,j,k,k1,l,m,n,o,p,q,r,s,t,sf,ff){
        var set={
            url:JOBURL.EPubJob,
            params:"title="+a+"&do="+b+"&RCIS="+c+"&RCSS="+d+"&RCCS="+e+"&GCI="+f+"&GCC="+g+"&place="
                    +h+"&pid="+i+"&cid="+j+"&salary="+k+"&treatment="+k1+"&safety_b="+l+"&muti="+m+"&degree="+n+"&exp="+o
                    +"&status="+p+"&social="+q+"&type="+r+"&description="+s+"&job_type="+t,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：猎头-我发布的职位列表获取
     * 参数：
     * a：类型（0不限，1全职，2兼职）
     * b：状态（0不限，1招聘中，2已结束）
     * c：第几页
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    AGetPubJobs:function(a,b,c,sf,ff){
        var set={
            url:JOBURL.AGetPubJobs,
            params:"type="+a+"&status="+b+"&page="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：企业-我发布的职位列表获取
     * 参数：
     * a：类型（0不限，1全职，2兼职）
     * b：状态（0不限，1招聘中，2已结束）
     * c：第几页
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    EGetPubJobs:function(a,b,c,sf,ff){
        var set={
            url:JOBURL.EGetPubJobs,
            params:"type="+a+"&status="+b+"&page="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：企业-我发布的职位列表获取
     * 参数：
     * a：类型（0不限，1全职，2兼职）
     * b：第几页
     * c：每页几条
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    EGetWCLJobs:function(a,b,c,sf,ff){
        var set={
            url:JOBURL.EGetWCLJob,
            params:"type="+a+"&page="+b+"&size="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：猎头-我发布的职位-立即结束招聘
     * 参数：
     * a：职位编号
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    AEndPubJobs:function(a,sf,ff){
        var set={
            url:JOBURL.AEndPubJobs,
            params:"id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：企业-立即结束招聘
     * 参数：
     * a：职位编号
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    EEndPubJobs:function(a,sf,ff){
        var set={
            url:JOBURL.EEndPubJobs,
            params:"id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：猎头 - 获取简历列表
     * 参数：
     * a：职位编号
     * b：第几页
     * c：type（1：人才，3：猎头）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    AGetResList:function(a,b,c,sf,ff){
        var set={
            url:JOBURL.AGetResList,
            params:"job="+a+"&page="+b+"&type="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：企业获取简历列表
     * 参数：
     * a：职位编号
     * b：第几页
     * c：type（1：人才，3：猎头）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    EGetResList:function(a,b,c,sf,ff){
        var set={
            url:JOBURL.EGetResList,
            params:"job="+a+"&page="+b+"&type="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：猎头-获取委托来的职位
     * 参数：
     * a：类型（0不限1全职2兼职）
     * b：状态（0不限1未公开2已公开3已结束）
     * c：第几页
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    AGetAgentList:function(a,b,c,sf,ff){
        var set={
            url:JOBURL.AGetAgentJobs,
            params:"type="+a+"&status="+b+"&page="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：猎头-委托来的职位-立即公开招聘
     * 参数：
     * a：职位编号
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    AOpenJobs:function(a,sf,ff){
        var set={
            url:JOBURL.AOpenJobs,
            params:"job_id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：猎头-获取可能感兴趣的职位
     * 参数：
     * a：类型（0不限1全职2兼职）
     * b：发布角色（0不限1猎头公司发布2企业发布）
     * c：注册情况（0不限1初始注册2变更注册）
     * d：第几页
     * e：每页条数
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    AGetIntrJobs:function(a,b,c,d,e,sf,ff){
        var set={
            url:JOBURL.AGetIntJobs,
            params:"job_category="+a+"&publisher_role="+b+"&register_case="+c+"&page="+d+"&size="+e,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：获取可委托的职位列表
     * 参数：
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    GetCDJobs:function(sf,ff){
        var set={
            url:JOBURL.GetCDJobs,
            params:"",
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：企业获取委托的职位列表
     * 参数：
     * a：类型（0不限1全职2兼职）
     * b：状态（0不限1委托中2已结束）
     * c：第几页
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    EGetAgentJobs:function(a,b,c,sf,ff){
        var set={
            url:JOBURL.EGetAgentJobs,
            params:"type="+a+"&status="+b+"&page="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：委托职位
     * 参数：
     * a：猎头id
     * b：职位id
     * sf：异步成功后执行的方法对象
     * ff：异步失败后执行的方法对象
     * 返回值：
     */
    DeleJobs:function(a,b,sf,ff){
        var s={
            url:JOBURL.DeleJobs,
            params:"aid="+a+"&jid="+b,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：立即终止委托
     * 参数：
     * a：职位id
     * sf：异步成功后执行的方法对象
     * ff：异步失败后执行的方法对象
     * 返回值：
     */
    EEndDeleJob:function(a,sf,ff){
        var s={
            url:JOBURL.EEndDelJob,
            params:"id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：获取人才感兴趣职位列表
     * 参数：
     * a：第几页
     * b：每页条数（暂未开放）
     * c：工作性质（1为全职，2为兼职）
     * d：发布人角色（1-人才，3-猎头）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 推荐职位列表
     */
    GetTInteJobs:function(a,b,c,d,sf,ff){
         var setting={
            url:JOBURL.TGetInteJob,
            params:"page="+a+"&size="+b+"&job_category="+c+"&publisher_role="+d,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：获取人才应聘过的职位列表
     * 参数：
     * a：第几页
     * b：每页条数（暂未开放）
     * c：工作性质（1为全职，2为兼职）
     * d：发布人角色（1-人才，3-猎头）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 推荐职位列表
     */
    GetTCDJobs:function(a,b,c,d,sf,ff){
         var setting={
            url:JOBURL.TGetCDJob,
            params:"page="+a+"&size="+b+"&job_category="+c+"&publisher_role="+d,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(setting);
    },
    /* 功能：指定企业发布的职位
     * 参数：
     * a：企业id
     * b：每页条数
     * c：第几页
     * d：类型
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    GetComPubJobs:function(a,b,c,d,sf,ff){
        var set={
            url:JOBURL.GetComPubJobs,
            params:"uid="+a+"&size="+b+"&page="+c+"&type="+d,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：企业 - 待处理的职位 - 立即发布
     * 参数：
     * a：职位id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    EPubJobs:function(a,sf,ff){
        var set={
            url:JOBURL.ERPubJob,
            params:"jid="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：猎头 - 委托来的职位 - 查看详细
     * 参数：
     * a：职位id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    ACheckJDetial:function(a,sf,ff){
        var set={
            url:JOBURL.ACheckJDetial,
            params:"job_id="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：猎头 -委托来的职位/我发布的职位 -暂停招聘
     *参数：
     *jid：职位ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    APauseJob:function(jid,sf,ff){
           var set={
            url:JOBURL.AInterRupJob,
            params:"jid="+jid,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
      /*
     *功能：猎头 -委托来的职位/我发布职位 -继续招聘
     *参数：
     *jid：职位ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    AContinueJob:function(jid,sf,ff){
           var set={
            url:JOBURL.AGoesonJob,
            params:"jid="+jid,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：企业 -我发布的职位 -暂停招聘
     *参数：
     *jid：职位ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    EePauseJob:function(jid,sf,ff){
           var set={
            url:JOBURL.EPaJob,
            params:"jid="+jid,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
      /*
     *功能：企业 -我发布职位 -继续招聘
     *参数：
     *jid：职位ID
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    EeContinueJob:function(jid,sf,ff){
           var set={
            url:JOBURL.EGoJob,
            params:"jid="+jid,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /*
     *功能：获取指定猎头正在运作的职位列表
     *参数：
     * a：猎头id
     * b：职位类型（1：全职，2：兼职）
     * c：第几页
     * d：条数
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    GetARunningJob:function(a,b,c,d,sf,ff){
           var set={
            url:JOBURL.GetARunningJob,
            params:"id="+a+"&type="+b+"&page="+c+"&size="+d,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：人才 - 获取意向职位
     * 参数：
     * a：发布角色（0不限1猎头公司发布2企业发布）
     * b：第几页
     * c：每页条数
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    TGetWantJobs:function(a,b,c,sf,ff){
        var set={
            url:JOBURL.TGetWantJobs,
            params:"type="+a+"&page="+b+"&size="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：职位搜索
     * 参数：
     * params:传递参数
     * role:1猎头，0人才
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    SearchJob:function(params,role,sf,ff){
        var set={
            url:WEBURL.ASearchJob,
            params:params,
            sucrender:sf,
            failrender:ff
        };
        if(role==0){
            set.url=WEBURL.HSearchJob;
        }
	HGS.Base.HAjax(set);
    }
}
