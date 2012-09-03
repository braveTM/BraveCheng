/*
 *账户 - model类
 */
function AccountCat(){
}
//HGS.Base.Extend(User,BaseClass);
AccountCat.prototype={
    /* 功能：验证用户昵称是否唯一
     * 参数：
     * e: 昵称
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：true||false => 是否唯一
     */
    nickCheck:function(nick,sf,ff){
         var s={
            url:ACCOUNTURL.ValidNickname,
            params:"nick="+nick,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：验证用户邮箱是否唯一
     * 参数：
     * e: 邮箱字符串
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：true||false => 是否唯一
     */
    EmailIsUnique:function(e,sf,ff){
        var s={
            url:ACCOUNTURL.ValidateEmail,
            params:"email="+e,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：验证用户名是否唯一
     * 参数：
     * n: 用户名字符串
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：true||false => 是否唯一
     */
    UNameIsUnique:function(n,sf,ff){
        var s={
            url:ACCOUNTURL.ValidateUName,
            params:"uname="+n,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：人才电子邮箱注册
      email:邮箱 
      pword:密码
      name:姓名
     verify：验证码
     */
    TalentEmailRegister:function(p,sf,ff){
            var str ="type="+p.type+"&email="+p.email+"&pword="+p.pword+"&name="+p.name+"&verify="+p.verify
                +"&rid="+p.c+"&rp="+p.e+"&rc="+p.d+"&pid="+p.a+"&pc="+p.b;
            var s={
                url:ACCOUNTURL.Register,
                params:str,
                sucrender:sf,
                failrender:ff
            };
	HGS.Base.HAjax(s);
    },
    /*
     *猎头注册
     *参数 type:3 *email:邮箱
     *pword:密码 * phone:手机 
     *qq:QQ      * name:姓名
     *com:所属公司   *in:简介
     * pid;省份编号 *cid:城市编号 verify 验证码
     */
    AgentRegister:function(p,sf,ff){
         var str ="type="+p.type+"&email="+p.email+"&pword="+p.pword+"&phone="+p.phone+"&service="+p.service;
             str=str+"&name="+p.name+"&pid="+p.pid+"&cid="+p.cid+"&com="+p.com+"&in="+p.summary;
             str=str+"&verify="+p.verify;
        var s={
            url:ACCOUNTURL.Register,
            params:str,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /*
     *企业注册
     *参数：type:2 *email:邮箱
     *pword:密码 * phone:手机 
     *qq:QQ      * name:企业名称
     *ca:企业性质  
     *cname:联系人  *in:简介
     * pid;省份编号 *cid:城市编号verify 验证码
     */
    EnterpriseRegister:function(p,sf,ff){
         var str ="type="+p.type+"&email="+p.email+"&pword="+p.pword+"&phone="+p.phone+"&company_phone="+p.company_phone+"&ca="+p.ca;
             str=str+"&name="+p.name+"&cname="+p.cname+"&pid="+p.pid+"&cid="+p.cid+"&in="+p.summary;
             str=str+"&verify="+p.verify;
        var s={
            url:ACCOUNTURL.Register,
            params:str,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    /* 功能：登录
     * 参数：
     * r: 是否记住登录
     * n：用户名
     * p：密码
     * u：登录成功后的跳转路径
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：true||false => 是否唯一
     */
    Login:function(r,n,p,u,sf,ff){
        var s={
            url:WEBURL.Login,
            params:"uname="+n+"&pword="+p+"&rem="+r+"&url="+u,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
     /*
     * 账户/保存修改人才基本资料
     * author jack
     * date 2012-1-30
     * param p 提交参数
     * param s 成功方法
     * param f 失败方法
     * @修改：Jack 2012-7-17
     */
    uptalbasic:function(p,s,f){
        var str = "name="+p.name+"&gender="+p.gender+"&birth="+p.birth+"&pid="+p.pid+"&cid="+p.cid;
        str = str+"&qq="+p.qq+"&email="+p.email+"&phone="+p.phone;
        var o = {
            url:ACCOUNTURL.TalentBasic,
            params:str,
            sucrender:s,
            failrender:f
        };
	HGS.Base.HAjax(o);
    },
     /*
     * 账户/保存修改企业基本资料
     * author jack
     * date 2012-1-30
     * param p 提交参数
     * param s 成功方法
     * param f 失败方法
     * 修改 @jack 2012-7-13
     * @修改：Jack 2012-7-17
     */
    upcombasic:function(p,s,f){
        var str = "name="+p.name+"&ca="+p.ca+"&in="+p.summary+"&pid="+p.pid+"&cid="+p.cid+"&company_phone="+p.company_phone;
        str = str+"&qq="+p.qq+"&company_qualification="+p.company_qualification+"&company_regtime="+p.company_regtime+"&company_scale="+p.company_scale+"&email="+p.email+"&phone="+p.phone;
        var o = {
            url:ACCOUNTURL.EnterpriseBasic,
            params:str,
            sucrender:s,
            failrender:f
        };
	HGS.Base.HAjax(o);
    },
    /*
     * 账户/保存修改猎头基本资料
     * author jack
     * date 2012-1-30
     * param p 提交参数
     * param s 成功方法
     * param f 失败方法
     * @修改：Jack 2012-7-17
     */
    upagentbasic:function(p,s,f){
        var str = "name="+p.name+"&in="+p.summary+"&pid="+p.pid+"&cid="+p.cid+"&company="+p.company;
        str = str+"&qq="+p.qq+"&gender="+p.gender+"&email="+p.email+"&phone="+p.phone;
        var o = {
            url:ACCOUNTURL.AgentBasic,
            params:str,
            sucrender:s,
            failrender:f
        };
	HGS.Base.HAjax(o);
    },
       /*
     * 账户/保存修改后密码
     * 参数：新密码np，旧密码op
     * author jack
     * date 2012-12-09
     * param s 成功方法
     * param f 失败方法
     */
    updatepwd:function(q,s,f){
        var str="op="+q.op+"&np="+q.np;
        var setting = {
            url:ACCOUNTURL.SaveNewPwd,
            params:str,
            sucrender:s,
            failrender:f
        };
	HGS.Base.HAjax(setting);
    },
    
    /*
     * 账户/发送验证码
     * 参数：手机号码
     * author jack
     * date 2012-12-11
     * param s 成功方法
     * param f 失败方法
     */
    sendValidnum:function(phon,s,f){
         var set={
            url:ACCOUNTURL.GetValidNum,
            params:"phone="+phon,
            sucrender:s,
            failrender:f
        };
        HGS.Base.HAjax(set);
    },
    /*
     *功能：保存修改电话号码
     *参数：新的电话号码
     *说明：jack
     *2011.12.11
     *
     */
    setNphonenum:function(pv,s,f){
         var set={
            url:ACCOUNTURL.UpdatePhone,
            params:"code="+pv,
            sucrender:s,
            failrender:f
        };
        HGS.Base.HAjax(set);
    },
    /*
     *功能：申请邮箱认证
     *参数：邮箱地址
     *说明：@jack
     *2011.12.11
     */
    appVemail:function(email,s,f){
         var set={
            url:ACCOUNTURL.ApplyVemail,
            params:"email="+email,
            sucrender:s,
            failrender:f
        };
        HGS.Base.HAjax(set);
    },
     /*
     *功能：申请银行卡认证
     *参数：卡类型，卡号
     *说明：@jack
     *2011.12.11
     */
    appVbank:function(ctype,cnum,s,f){
          var set={
            url:ACCOUNTURL.ApplyVbank,
            params:"bid="+ctype+"&num="+cnum,
            sucrender:s,
            failrender:f
        };
        HGS.Base.HAjax(set);
    },
     /*
     *功能：申请实名认证
     *参数：姓名，证件号，复印件
     *说明：@jack
     *2011.12.12
     */
    appVrealName:function(rnam,rnum,fside,bside,photo,x,y,w,h,s,f){
          var set={
            url:ACCOUNTURL.ApplyTvname,
            params:"name="+rnam+"&num="+rnum+"&front="+fside+"&back="+bside,
            sucrender:s,
            failrender:f
        };
        HGS.Base.HAjax(set);
    },
    /*
     *功能：申请实名认证(企业)
     *参数：
     *说明：@jack
     *20112-2
     */
    appVeName:function(rnam,rnum,pic,code,s,f){
          var set={
            url:ACCOUNTURL.ApplyEvname,
            params:"name="+rnam+"&num="+rnum+"&pic="+pic+"&code="+code,
            sucrender:s,
            failrender:f
        };
        HGS.Base.HAjax(set);
    },
//      /*
//     * 账户/添加资质/添加服务类别
//     * author jack
//     * date 2012-12-09
//     * param s 成功方法
//     * param f 失败方法
//     */
//    addquali:function(label,s,f){
//        var settings = {
//            url:ACCOUNTURL.AddQuali,
//            params:"label="+label,
//            sucrender:s,
//            failrender:f
//        };
//	HGS.Base.HAjax(settings);
//    },
//     /*
//     * 账户/删除资质
//     * author jack
//     * date 2012-12-09
//     * param s 成功方法
//     * param f 失败方法
//     */
//    delequali:function(label,sf,ff){
//        var settings = {
//            url:ACCOUNTURL.DeleQuali,
//            params:"label="+label,
//            sucrender:sf,
//            failrender:ff
//        };
//	HGS.Base.HAjax(settings);
//    },
    /*
     *找回密码
     *jack
     *2012-2-17
     */
    GetBackPwd:function(p,sf,ff){
         var settings = {
            url:ACCOUNTURL.DoForgetPwd,
            params:"number="+p,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(settings);
    },
    /*
     *设置新密码
     *jack
     *2012-2-17
     */
    SetNewPwd:function(param,sf,ff){
         var settings = {
            url:ACCOUNTURL.DoSenewPwd,
            params:param,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(settings);
    },
    /*
     *重新发送激活邮件
     *参数：email 邮箱地址
     *sf：成功执行方法
     *ff：失败执行方法
     */
    ReSendActiveLink:function(email,sf,ff){
          var settings = {
            url:ACCOUNTURL.DoResendActive,
            params:"email="+email,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(settings);
    },
    /*
     *功能：人才选择手机注册
     *参数：
     *	pword:密码   
     *  phone:手机号码
     *  name:姓名    
     *  code:验证码	
     */
    TalentMobileRegister:function(p,sf,ff){
           var str ="phone="+p.phone+"&pword="+p.pword+"&name="+p.name+"&code="+p.code
               +"&rid="+p.c+"&rp="+p.e+"&rc="+p.d+"&pid="+p.a+"&pc="+p.b;
            var s={
                url:ACCOUNTURL.MobileRegister,
                params:str,
                sucrender:sf,
                failrender:ff
            };
	HGS.Base.HAjax(s);
    },
    /*
     *功能：人才手机注册获取验证码
     *参数：
     *手机：phone
     *sff：成功执行函数
     *ff：失败执行函数
     */
    SendRegisterNuber:function(phone,sf,ff){
         var s={
                url:ACCOUNTURL.SendValidNber,
                params:"phone="+phone,
                sucrender:sf,
                failrender:ff
            };
	HGS.Base.HAjax(s);
    },
    /*
     *功能：保存 人才头像操作
     *参数：
     *photo:人才头像
     *x
     *y
     *w
     *h
     *手机：phone
     *sf：成功执行函数
     *ff：失败执行函数
     */
    SvTalentPhoto:function(p,sf,ff){
        var str="photo="+p.photo+"&x="+p.x+"&y="+p.y+"&w="+p.w+"&h="+p.h;
         var s={
                url:ACCOUNTURL.ChangeTalentPhoto,
                params:str,
                sucrender:sf,
                failrender:ff
            };
	HGS.Base.HAjax(s);
    },
    /*
     *功能：保存企业头像操作
     *参数：
     *photo:人才头像
     *x
     *y
     *w
     *h
     *手机：phone
     *sf：成功执行函数
     *ff：失败执行函数
     */
    Company_PhotoSave:function(p,sf,ff){
        var str="photo="+p.photo+"&x="+p.x+"&y="+p.y+"&w="+p.w+"&h="+p.h;
         var s={
                url:ACCOUNTURL.ChangeEnterPhoto,
                params:str,
                sucrender:sf,
                failrender:ff
            };
	HGS.Base.HAjax(s);
    },
    /*
     *功能：保存猎头头像操作
     *参数：
     *photo:猎头头像
     *x
     *y
     *w
     *h          
     *sf：成功执行函数
     *ff：失败执行函数
     **athor:joe 2012/7/7
     */
    Midman_PhotoSave:function(p,sf,ff){
        var str="photo="+p.photo+"&x="+p.x+"&y="+p.y+"&w="+p.w+"&h="+p.h;
         var s={
                url:ACCOUNTURL.ChangeMidmanPhoto,
                params:str,
                sucrender:sf,
                failrender:ff
            };
	HGS.Base.HAjax(s);
    },
    /*
     *功能：保存猎头提醒设置页面设置
     *参数：
     *notice:提醒
     *wid：提醒方式ID
     *sf：请求成功执行
     *ff：请求失败执行
     */
    SveAgentRemind:function(notice,sf,ff){
         var s={
                url:ACCOUNTURL.RemindSet,
                params:"notice="+notice,
                sucrender:sf,
                failrender:ff
            };
	HGS.Base.HAjax(s); 
    },
    /*
     *功能:忘记密码重新发送邮件
     *参数：
     *email 注册邮箱地址
     *sf:成功执行
     *ff：失败执行
     */
    ResendFogEmail:function(email,sf,ff){
           var settings = {
            url:ACCOUNTURL.DoRensendEmial,
            params:"email="+email,
            sucrender:sf,
            failrender:ff
         };
        HGS.Base.HAjax(settings); 
   },
   /*
     *功能：人才保存隐私设置
     *参数：
     *a：隐私设置id
     *b：简历id
     *c：姓名
     *d：生日
     *e：电话方式
     *f：电话时长
     *g：联系方式隐私设置
     *负责人：candice
     *2012.6.28
     */
    saveHPrivacy:function(a,b,c,d,e,f,g,sf,ff){
          var set={
            url:ACCOUNTURL.SetPrivacyHuman,
            params:"human_privacy_id="+a+"&resume="+b+"&name="+c+"&birthday="+d
                +"&call_type="+e+"&call_time="+f+"&contact_way="+g,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(set);
    },
   /*
     *功能：企业保存隐私设置
     *参数：
     *a：隐私设置id
     *b：职位id
     *c：公司名称
     *d：联系人名字
     *e：电话方式
     *f：电话时长
     *g：联系方式隐私设置
     *负责人：candice
     *2012.6.28
     */
    saveCPrivacy:function(a,b,c,d,e,f,g,sf,ff){
          var set={
            url:ACCOUNTURL.SetPrivacyCompany,
            params:'company_privacy_id='+a+'&job='+b+'&company_name='+c
                +'&contact_name='+d+'&call_type='+e+"&call_time="+f+"&contact_way="+g,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(set);
    },
   /*
     *功能：猎头保存隐私设置
     *参数：
     *a：隐私设置id
     *b：职位id
     *c：公司名称
     *d：联系人名字
     *e：电话方式
     *f：电话时长
     *g：联系方式隐私设置
     *负责人：candice
     *2012.6.28
     */
    saveAPrivacy:function(a,b,c,d,e,f,g,sf,ff){
          var set={
            url:ACCOUNTURL.SetPrivacyAgent,
            params:'agent_privacy_id='+a+'&job='+b+'&resume='+c
                +'&name='+d+'&call_type='+e+"&call_time="+f+"&contact_way="+g,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(set);
    }
};
