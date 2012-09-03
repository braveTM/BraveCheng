/* 
 * 顶级命名空间HGS
 */
if(typeof(HGS)=="undefined"){
    HGS = new Object||{};
}
/* 
 * 页面标志，用以加载不同页面所对应的js文件等
 */
if(typeof(PAGE)=="undefined"){
    var PAGE="";
}
PAGE=$("#loader").html().replace(/[\n\r]/gm,'').replace(" ","");
/*
 * 页面资源加载方法统一管理
 */
var PAGE_INI={
    /*
     *首页 - Home_Index_index
     */
    load0:function(){
        HGS.Base.LoadIndexIndex();
    },
    /*
     *注册 - Home_Public_register
     */
    load2:function(){
        HGS.Base.LoadPublicRegister();
    },
    /*
     *登录 -多用户登录
     */
    load3:function(){
        HGS.Base.LoadIndexIndex();
    },
    /*
     *职位搜索页
     */
    load4:function(){
        HGS.Base.LoadFindPos();
    },
    /*
     *建筑部通讯录 - Home_Tool_contactbook
     */
    load5:function(){
        $().ready(function(){
            baseRender.ae(0);
            baseRender.za();
            $(".fa,.fb,.fc,.fd").click(function(){
                $('html,body').animate({
                    scrollTop:$('#jz_book').offset().top-60
                }, 400);
            });
            $("table.tb tr:even,table.ta tr:even,table.tc tr:even,table.tl tr:even").addClass("bg");
        });
    },
    /*
     *人事部门通讯录 - Home_Tool_pdmail
     */
    load6:function(){
        $().ready(function(){
            baseRender.ae(0);
            $("table.tb tr:even,table.ta tr:even,table.tc tr:even,table.tl tr:even").addClass("bg");
        });
    },
    /*
     *好友邀请 - Home_Invite_index
     */
    load7:function(){
        HGS.Base.LoadInvite_index();
    },
    /*
     *我的账单 - Home_Bill_index
     */
    load9:function(){
        HGS.Base.LoadBillIndex();
    },
    /*
     *我的消息 - Home_Message_msglist
     */
    load12:function(){
        HGS.Base.LoadMessageMsglist();
    },
    /*
     *我的消息详细 - Home_Message_detail
     */
    load13:function(){
        HGS.Base.LoadDelegateDetail();
    },
    /*
     *人才职讯推荐 - Home_Human_index
     */
    load22:function(){
        HGS.Base.LoadTalentIndex();
    },
    /*
     *后台用户资料修改 - Home_User_profiles
     */
    load23:function(){
        HGS.Base.LoadUserProfile();
    },
    /*
     *委托详细页 - Home_Delegate_detail
     */
    load24:function(){
        HGS.Base.LoadDelegateDetail();
    },
    /*
     *套餐操作页 - Home_User_package
     */
    load25:function(){
        HGS.Base.LoadPackageIndex();
    },
    /*
     *推广页 - Home_Promote_index
     */
    load28:function(){
        HGS.Base.LoadPromoteIndex();
    },
    /*
     *猎头/公司账户页面 - Home_User_aprofile
     */
    load29:function(){
        HGS.Base.LoadUserProfile();
    },
    /*
     *人才账户页面 - Home_User_tprofile
     */
    load30:function(){
        HGS.Base.LoadUserProfile();
    },
    /*
     *企业账户页面 - Home_User_eprofile
     */
    load31:function(){
        HGS.Base.LoadUserProfile();
    },
    /*
     *企业首页
     */
    load34:function(){
        HGS.Base.LoadCompanyIndex();
    },
    /*
     *猎头首页
     */
    load35:function(){
        HGS.Base.LoadMiddleManIndex();
    },
    /*
     *人才找猎头首页
     */
    load36:function(){
        HGS.Base.LoadTalentGetAgent();
    },
    /*
     *企业找人才
     */
    load37:function(){
        HGS.Base.LoadCompanyGetHumanIndex();
    },
    /*
     *人才找企业
     */
    load38:function(){
        HGS.Base.LoadHumanGetCompnayIndex();
    },
    /*
     *人才-找职位页
     */
    load39:function(){
        HGS.Base.LoadHumanFindJob();
    },
    /*
     *企业招聘页
     */
    load40:function(){
        HGS.Base.LoadPoolBringin();
    },
    /*
     *企业找猎头页
     */
    load41:function(){
        HGS.Base.LoadEnterGetAgent();
    },
    /*
     *人才管理页
     */
    load42:function(){
        HGS.Base.LoadPoolTManage();
    },
    /*
     *职位管理页
     */
    load43:function(){
        HGS.Base.LoadPoolJobmanage();
    },
    /*
     *我的账户中心
     */
    load44:function(){
        HGS.Base.LoadUserProfile();
    },
    /*人才注册*/
    load45:function(){
        HGS.Base.LoadPublicRegister();
    },
    /*猎头注册*/
    load46:function(){
        HGS.Base.LoadPublicRegister();
    },
    /*企业注册*/
    load47:function(){
        HGS.Base.LoadPublicRegister();
    },
    /*兼职职位详细页面（身份为自己）*/
    load49:function(){
        HGS.Base.LoadDetailJobFullSelf();
    },
    /*兼职简历详细页面*/
    load50:function(){
        HGS.Base.LoadTanlentResumeDetail();
    },
    /*企业详细页*/
    load51:function(){
        HGS.Base.LoadComDetail();
    },
    /*兼职职位详细页面（身份为他人）*/
    load54:function(){
        HGS.Base.LoadDetailJobFull();
    },
    /*全职职位详细页面（身份为他人）*/
    load55:function(){
        HGS.Base.LoadDetailJobFull();
    },
    /*人才简历页面*/
    load56:function(){
        HGS.Base.LoadTalentResume();
    },
    /*人才证书管理页面*/
    load57:function(){
        HGS.Base.LoadPoolMycert();
    },
    /*全职职位详细页面（身份为自己）*/
    load58:function(){
        HGS.Base.LoadDetailJobFullSelf();
    },
    /*猎头详细页*/
    load59:function(){
        HGS.Base.LoadDetailAgent();
    },
    /*全职简历详细页面*/
    /*兼职简历详细页面*/
    load60:function(){
        HGS.Base.LoadTanlentResumeDetail();
    },
    /*找回密码*/
    load63:function(){
        HGS.Base.LoadLookPwd();
    },
    /*设置密码*/
    load64:function(){
        HGS.Base.LoadLookPwd();
    },
    /*重新发送邮件*/
    load65:function(){
        HGS.Base.LoadLookPwd();
    },
    /*
     *创建新全职简历 - MiddleMan_createResumeIndex
     */
    load67:function(){
        HGS.Base.LoadMiddleManCreateResumeIndex();
    },
    /*我的人脉*/
    load68:function(){
        HGS.Base.LoadMyContacts();
    },
    /*猎头我要推广-Home_MiddleMan_promote*/
    load70:function(){
        HGS.Base.LoadAEPromote();
    },
    /*企业我要推广-Home_MiddleMan_promote*/
    load71:function(){
        HGS.Base.LoadAEPromote();
    },
    /*企业首页-Home_Company_home*/
    load72:function(){
        HGS.Base.LoadHomeHome();
    },
    /*猎头首页-Home_MiddleMan_home*/
    load73:function(){        
        HGS.Base.LoadHomeHome();
    },
    /*人才首页-Home_Human_home*/
    load74:function(){        
        HGS.Base.LoadHomeHome();
    },
    /*猎头 - 修改人才全职简历 -Home_MiddleMan_home*/
    load75:function(){
        HGS.Base.LoadMiddleManUResumeIndex();
    },
    /* 猎头 - 修改人才兼职简历 -Home_Human_home*/
    load76:function(){
        HGS.Base.LoadMiddleManUHCIndex();
    },
    /*猎头 - 创建兼职简历*/
    load83:function(){
        HGS.Base.LoadMiddleManCpresume();
    },
    /*猎头职位发布*/
    load85:function(){
        HGS.Base.LoadCompanyJob();
    },
    /*企业职位发布*/
    load86:function(){
        HGS.Base.LoadCompanyJob();
    },
    /*合同模板下载*/
    load87:function(){
        $().ready(function(){
            baseRender.ae(0);
            baseController.BtnBind("div.contract div.btn5", "btn5", "btn5_hov", "btn5_hov");
        });
    },
    /*市场行情*/
    load88:function(){
        HGS.Base.LoadMarketGuidence();
    },
    /*资讯 - 首页*/
    load89:function(){
        HGS.Base.LoadBlogInfo();
    },
    /*博客 - 发布心得*/
    load90:function(){
        HGS.Base.LoadBlogBlog();
    },
    /*博客 - 心得管理*/
    load91:function(){
        HGS.Base.LoadBlogBlog();
    },
    /*资讯 - 资讯列表页*/
    load92:function(){
        HGS.Base.LoadBlogInfo();
    },
    /*资讯 - 资讯详细页*/
    load93:function(){
        HGS.Base.LoadBlogInfo();
    },
    /*资讯 - 查询页*/
    load94:function(){
        HGS.Base.LoadToolRefer();
    },
    /*人才详细页*/
    load98:function(){
        HGS.Base.LoadDetailHuman();
    },
    /*举报页*/
//    load99:function(){
//        HGS.Base.LoadDetailHuman();
//    },
    /*意见反馈页*/
    load100:function(){
        HGS.Base.LoadFeedBack();  
    },
    /*企业登录*/
    load102:function(){
        HGS.Base.LoadComLogin();  
    },
    /*人才隐私设置*/
    load103:function(){
        HGS.Base.setIndex();  
    },
    /*企业隐私设置*/
    load104:function(){
        HGS.Base.setIndex();  
    },
    /*猎头隐私设置*/
    load105:function(){
        HGS.Base.setIndex();  
    },
    /*提醒设置页面*/
    load106:function(){
        HGS.Base.AgentRemind();
    },
    /*手机找回密码*/
    load107:function(){
        HGS.Base.LoadLookPwd();
    },
    /*注册激活页面重新发送*/
    load108:function(){
        HGS.Base.LoadLookPwd();
    },
    /*猎头未登录详细页*/
    load109:function(){        
        HGS.Base.unLoginAgentDetail();
    },
    /*人才未登录详细页*/
    load110:function(){
        HGS.Base.unLoginDetail();
    },
    /*企业未登录详细页*/
    load111:function(){
        HGS.Base.unLoginCompDetail();
    },
    /*全职职位未登录详细页*/
    load112:function(){
        HGS.Base.unLoginDetail();
    },
    /*兼职职位未登录详细页*/
    load113:function(){
        HGS.Base.unLoginDetail();
    },
    /*管理猎头*/
    load114:function(){
        HGS.Base.ManageAngent();
    },
    /*猎头 - 角色首页功能引导流程*/
    load115:function(){
        HGS.Base.LoadHomeGuide();
    },
    /*人才 - 角色首页功能引导流程*/
    load116:function(){
        HGS.Base.LoadHomeGuide();
    },
    /*企业 - 角色首页功能引导流程*/
    load117:function(){
        HGS.Base.LoadHomeGuide();
    },
    /*积分规则说明*/
    load118:function(){
       $().ready(function(){           
            baseRender.ae(0);           
            baseController.BtnBind("div.btn14", "btn14", "btn14_hov", "btn14_hov");
        });
    },
    /*猎头套餐*/
    load119:function(){
        HGS.Base.LoadPackageIndex();
    },
    /*未登录全职简历详细页*/
    load200:function(){
        HGS.Base.unLoginResumeDetail();
    },
    /*未登录兼职简历详细页*/
    load201:function(){
        HGS.Base.unLoginResumeDetail();
    }
};
/* 
 * 二级命名空间Base，主要包含所有基本方法
 */
HGS.Base=function(){
    /* 
     * 功能：模板生成
     * 参数：
     * id：string 模板的父容器id
     * varr：Array 所有变量的名称的数组
     * arr：Array 模板中变量对应项的数据
     * tmp：string 模板编号
     */
    function GenTemp(id,varr,arr,tmp){
        var dom = $("#"+id);        
        if(dom.hasClass("hgstemp")){
            dom.html('');
            var temp=tmp.toString().replace(/[\n\r]/gm,'');
            var t='';
            var html='';
            $.each(arr,function(i,item){
                if(!!item){
                    t=temp;                
                    $.each(varr,function(i,o){
                        t=t.replace(new RegExp("{"+o+"}","g"),item[o]);
                    });
                    html=html+t;
                }
            });
            dom.html(html);
        }
    }
    /*
     * 功能：混合模板生成
     * 参数：
     * id：string 模板的父容器id
     * varr：Array 多个模板所对应的所有变量的名称的数组,例如:var varr=[["",""],["","",""],...]
     * arr：Array 模板中变量对应项的数据（数组中需包含指定使用哪个模板的元素 temp -> 其值对应tmp里的指定项）
     * tmp：Array 模板数组,例如:var tmp=["temp1","temp2",...]
     */
    function GenMTemp(id,varr,arr,tmp){
        var dom = $("#"+id);
        if(dom.hasClass("hgstemp")){
            dom.html('');
            $.each(tmp,function(i,o){
                o=o.toString().replace(/[\n\r]/gm,'');
            });
            var t='';
            var num=0;
            var ivarr=null;
            var html='';
            $.each(arr,function(i,item){
                if(!!item){
                    num=item.temp;
                    t=tmp[num];
                    ivarr=varr[num];
                    $.each(ivarr,function(i,o){
                        t=t.replace(new RegExp("{"+o+"}","g"),item[o]);                    
                    });                
                    html=html+t;     
                }
            });
            dom.html(html);
        }
    }
    /* 功能：实现类的扩展
     * 参数：
     * Child：object 派生类
     * Parent：object 父类
     */
    //    function Extend(Child, Parent){
    //        var F = function(){};
    //        F.prototype = Parent.prototype;
    //        Child.prototype = new F();
    //        Child.prototype.constructor = Child;
    //        Child.superclass=Parent.prototype;
    //        if(Parent.prototype.constructor == Object.prototype.constructor){
    //            Parent.prototype.constructor = Parent;
    //        }
    //    }
    /* 功能：异步后台方法访问
     * 参数：
     * settings：object 异步配置项参数
     * 格式：var settings={
     *          url:"",         //必需配置项，后台方法访问路径，不能为空
     *          params:"",      //必需配置项，后台方法参数，可为 ""
     *          sucrender:null, //异步成功后页面渲染方法对象，可为null
     *          failrender:null //异步失败后页面渲染方法对象，可为null
     *      };
     * 无
     */
    function HAjax(settings,async){
        var res=null;
        if(async!=false){
            async=true;
        }
        $.ajax({
            async: async,
            type: "POST",
            url: settings.url+"",
            data: settings.params+"",
            dataType: "jsonp",
            jsonp: "jsoncallback",
            success: function (jsonp) {
                if(jsonp!=null&&jsonp!=""){
                    var r=eval(jsonp);                    
                    r.ret=typeof(r.ret)=="undefined"?false:r.ret;
                    if(async){
                        if(r.ret==true){
                            var sr=settings.sucrender;
                            if(typeof(sr)!="undefined"&&sr!=null){
                                sr(r);
                            }
                        }
                        else{
                            var fr=settings.failrender;
                            if(typeof(fr)!="undefined"&&fr!=null){
                                fr(r);
                            }
                        }
                    }
                    else{
                        res=r;
                    }
                }
            },
            error:function(jqXHR, textStatus, errorThrown){
            //alert(textStatus+","+jqXHR.responseText);
            }
        });
        if(async==false){
            return res;
        }
    }
    /* 功能：登录
     * 参数：
     * a：用户名
     * b：用户密码
     * c：是否记住登录状态
     * d：回调方法名
     * sf：退出成功执行方法
     * ff：退出失败执行方法
     * 返回值：true || false
     */
    function Login(a,b,c,d,sf,ff){
        var s={
            url:WEBURL.Login,
            params:"uname="+a+"&pword="+b+"&rem="+c+"&&func="+d,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    }
    /* 功能：退出
     * 参数：
     * sf：退出成功执行方法
     * ff：退出失败执行方法
     * 返回值：true || false
     */
    function Exit(sf,ff){
        var s={
            url:WEBURL.Exit,
            params:"",
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    }
    /* 功能：存储cookie
     * 参数：
     * c_name：cookie的名称
     * value：cookie的值
     * expiredays：cookie存储时间
     */
    function SetCookie(c_name,value,expiredays){
        var exdate=new Date()
        exdate.setDate(exdate.getDate()+expiredays)
        document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/";
    }
    /* 功能：读取cookie
     * 参数：
     * c_name：cookie的名称
     */
    function GetCookie(c_name){
        if(document.cookie.length>0){
            var c_start=document.cookie.indexOf(c_name + "=");
            var c_end='';
            if(c_start!=-1){
                c_start=c_start + c_name.length+1;
                c_end=document.cookie.indexOf(";",c_start);
                if (c_end==-1) c_end=document.cookie.length;
                return unescape(document.cookie.substring(c_start,c_end));
            }
        }
        return "";
    //     var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    //     if(arr != null) return unescape(arr[2]); return "";
    }
    /* 功能：删除cookie
     * 参数：
     * c_name：cookie的名称
     */
    function DelCookie(c_name){
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=HGS.Base.GetCookie(c_name);
        if(cval!=null) document.cookie= c_name + "="+cval+";expires="+exp.toGMTString()+";path=/";
    }
    /* 功能：动态加载页面资源文件（js和css）
     * 参数：
     * 无
     */
    function LoadPageSource(){
        var sn=SOURCENAME;
        In.add('f1',{
            path:sn.R0001,
            type:'js',
            charset:'utf-8',
            rely:['base']
        });
        In.add('f2',{
            path:sn.M0005,
            type:'js',
            charset:'utf-8',
            rely:['f1']
        });
        In.add('f3',{
            path:sn.CT0001,
            type:'js',
            charset:'utf-8',
            rely:['f2']
        });
        In('f1','f2','f3',function() {
            if(typeof(PAGE)=="undefined"){
                PAGE="";
                return;
            }
            var func=PAGE_INI["load"+PAGE];
            if(func!=null){
                func();
            }
        });
    }
    /* 功能：动态加载首页资源文件（js和css）- 首页 - Home_Index_index
     * 参数：
     * 无
     */
    function LoadIndexIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0003,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        //        In.add('p2',{
        //            path:sn.R0002,
        //            type:'js',
        //            charset:'utf-8',
        //            rely:['p1']
        //        });
        //        In.add('p3',{
        //            path:sn.CT0002,
        //            type:'js',
        //            charset:'utf-8',
        //            rely:['p2']
        //        });
        
        In.add('p4',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8'
        });
        In.add('p5',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8'
        });
        In.add('p6',{
            path:sn.M0012,
            type:'js',
            charset:'utf-8'
        });
        In.add('p7',{
            path:sn.M0013,
            type:'js',
            charset:'utf-8'
        });
        In.add('p8',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8'
        });
        In.add('p9',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8'
        });
        In.add('p10',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8'
        });
        In.add('p11',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8'
        });
        In('p1','p4','p5','p6','p7','p8','p9','p10','p11');
    }
    /*功能：@加载资源库->猎头公司页面资源文件-猎头/公司列表页-  Home_Lib_agent
     *参数：无
     *说明：@包括一些公共的js文件，样式等
     *最后修改时间：@2011.11.30
     *author：@jack
     */
    function LoadUserProfile(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0003,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0005,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p6',{
            path:sn.R0003,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p7',{
            path:sn.CT0003,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8'
        });
        In('p1','p2','p3','p4','p6','p7','p8');
    }
    /*
     *加载猎头/公司账户页面
     *参数：无
     *jack
     *2012.1.2
     */
    function LoadUserAgentprofile(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.R0032,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.CT0032,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In('p1','p2');
    }
    /*功能：动态加载注册页面Js Home_Public_register
     *参数：无
     *说明：无
     */
    function LoadPublicRegister(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0003,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8'
        });
        In.add('p3',{
            path:sn.L0005,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.R0006,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0006,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In('p1','p2','p3','p4','p5');
    }
    /*功能：动态加载后台我的消息列表页面Js Home_Message_msglist
     *参数：无
     *说明：无
     */
    function LoadMessageMsglist(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.R0013,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.CT0013,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In('p1','p2','p3','p4');
    }
    /*功能：动态加载后台首页 Home_Talent_Index
     *参数：无
     *说明：无
     */
    function LoadTalentIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0013,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p9',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p10',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p9']
        });
        In.add('p7',{
            path:sn.R0025,
            type:'js',
            charset:'utf-8',
            rely:['p10']
        });
        In.add('p8',{
            path:sn.CT0025,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In('p1','p2','p3','p4','p5','p6','p9','p10','p7','p8');
    }
    /*功能：动态加载后台我的账单页面Js Home_Bill_index
     *参数：无
     *说明：无
     */
    function LoadBillIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.R0014,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0014,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In('p1','p2','p3','p4','p5');
    }
    /*功能：动态加载后台我的套餐页面Js Home_Package_index
     *参数：无
     *说明：无
     */
    function LoadPackageIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.R0030,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.CT0030,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In('p1','p2','p3');
    }
    /*功能：动态加载后台推广页面Js Home_Promote_index
     *参数：无
     *说明：无
     */
    function LoadPromoteIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.R0031,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.CT0031,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In('p1','p2','p3','p4');
    }
    /*功能：动态加载委托详细页面Js Home_Delegate_detail
     *参数：无
     *说明：无
     */
    function LoadDelegateDetail(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0007,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.R0015,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.CT0015,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In('p1','p2','p3');
    }
    /*
     *加载人才简历 Home_Pool_tresume
     *参数：无
     *jack
     *2012-1-15
     */
    function LoadTalentResume(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0011,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0017,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.R0032,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.CT0032,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In('p1','p2','p3','p4','p5','p6','p7');
    }
    /*功能：动态加载猎头 - 私有人才全职简历修改页面Js Home_MiddleMan_updateResumeIndex
     *参数：无
     *说明：无
     */
    function LoadMiddleManUResumeIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0017,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.R0053,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.CT0053,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In('p1','p2','p3','p4','p5','p6','p7');
    }
    /*功能：动态加载猎头 - 私有人才兼职简历修改页面Js Home_MiddleMan_updateHCIndex
     *参数：无
     *说明：无
     */
    function LoadMiddleManUHCIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.R0053,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.CT0053,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In('p1','p2','p3','p4','p5','p6');
    }
    /*功能：动态加载猎头 - 职位管理库页面Js Home_Pool_jobmanage
     *参数：无
     *说明：无
     */
    function LoadPoolJobmanage(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0015,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0016,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In.add('p9',{
            path:sn.R0018,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In.add('p10',{
            path:sn.CT0018,
            type:'js',
            charset:'utf-8',
            rely:['p9']
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8','p9','p10');
    }
    /*功能：动态加载猎头 - 简历管理页面Js Home_MiddleMan_humanManageIndex
     *参数：无
     *说明：无
     */
    function LoadPoolTManage(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0015,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.L0016,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In.add('p9',{
            path:sn.R0020,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In.add('p10',{
            path:sn.CT0020,
            type:'js',
            charset:'utf-8',
            rely:['p9']
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8','p9','p10');
    }
    /*功能：动态加载猎头 - 简历管理-创建全职简历页面Js Home_MiddleMan_createResumeIndex
     *参数：无
     *说明：无
     */
    function LoadMiddleManCreateResumeIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.L0017,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.R0050,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In.add('p9',{
            path:sn.CT0050,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8','p9');
    }
    /*功能：动态加载猎头 - 简历管理-创建兼职简历页面Js Home_MiddleMan_cpresume
     *参数：无
     *说明：无
     */
    function LoadMiddleManCpresume(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.R0055,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.CT0055,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In('p1','p2','p3','p4','p5','p6');
    }
    /*功能：动态加载企业 - 招聘页面Js Home_Pool_bringin
     *参数：无
     *说明：无
     */
    function LoadHumanFindJob(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
         In.add('p7',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.R0040,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In.add('p6',{
            path:sn.CT0040,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In('p1','p2','p3','p4','p5','p6','p7');
    }
    /*功能：动态加载企业 - 发布新职位页面Js Home_Company_job
     *参数：无
     *说明：无
     */
    function LoadCompanyJob(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0017,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.R0057,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.CT0057,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8');
    }
    /*功能：动态加载企业 - 招聘页面Js Home_Pool_bringin
     *参数：无
     *说明：无
     */
    function LoadPoolBringin(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });        
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0016,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.R0033,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.CT0033,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8');
    }
    /*功能：动态加载人才 - 证书管理库页面Js Home_Pool_mycert
     *参数：无
     *说明：无
     */
    function LoadPoolMycert(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0011,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0003,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.R0034,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0034,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In('p1','p2','p3','p4','p5');
    }
    /*功能：动态加载职位详细页页面（带简历）Js Home_Detail_job_full_self
     *参数：无
     *说明：无
     */
    function LoadDetailJobFullSelf(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });    
        In.add('p9',{
            path:sn.M0012,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p8',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p9']
        }); 
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0019,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.R0035,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.CT0035,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In('p1','p9','p8','p2','p3','p4','p5','p6','p7');
    }
    /*功能：动态加载企业详细页Js Home_Detail_company
     *参数：无
     *说明：无
     */
    function LoadComDetail(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.R0041,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0041,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In('p1','p2','p3','p4','p5');
    }
    /*功能：动态加载人才详细页Js Home_Detail_company
     *参数：无
     *说明：无
     */
    function LoadDetailHuman(){
        var sn=SOURCENAME;
        In.add('p3',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8'            
        });
        In.add('p1',{
            path:sn.R0062,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.CT0062,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In('p1','p2','p3');
    }
    /*功能：动态加载职位详细页页面（不带简历）Js Home_Detail_job_full
     *参数：无
     *说明：无
     */
    function LoadDetailJobFull(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0012,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0015,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p10',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p9',{
            path:sn.L0019,
            type:'js',
            charset:'utf-8',
            rely:['p10']
        });
        In.add('p6',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p9']
        });
        In.add('p7',{
            path:sn.R0036,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.CT0036,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });       
        In('p1','p2','p3','p4','p5','p6','p7','p8','p9');
    }
    /*功能：动态加载猎头详细页Js Home_Detail_agent
     *参数：无
     *说明：无
     */
    function LoadDetailAgent(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p10',{
            path:sn.L0019,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p7',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p10']
        });
        In.add('p8',{
            path:sn.R0037,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In.add('p9',{
            path:sn.CT0037,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8','p9','p10');
    }
    /*功能：动态加载猎头首页Js Home_MiddleMan_agent
     *参数：无
     *说明：无
     */
    function LoadMiddleManIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0013,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p4',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p5',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.L0015,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In.add('p9',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In.add('p10',{
            path:sn.R0038,
            type:'js',
            charset:'utf-8',
            rely:['p9']
        });
        In.add('p11',{
            path:sn.CT0038,
            type:'js',
            charset:'utf-8',
            rely:['p10']
        });
        In('p1','p2','p4','p5','p6','p7','p8','p9','p10','p11');
    }
    /*功能：动态加载企业找人才Js Home_Company_getHumanIndex
     *参数：无
     *说明：无
     */
    function LoadCompanyGetHumanIndex(){
        var sn=SOURCENAME;
        
        
        In.add('p1',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0015,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.R0045,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In.add('p9',{
            path:sn.CT0045,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8','p9');
    }
    /*功能：动态加载人才找企业Js Home_Human_getCompanyIndex
     *参数：无
     *说明：无
     */
    function LoadHumanGetCompnayIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.R0046,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.CT0046,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In('p1','p2','p3','p4','p5','p6');
    }
    /*
     *动态加载人才找猎头页面  Home_Human_getAgentIndex
     *jack
     *2012-2-12
     */
    function LoadTalentGetAgent(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p7',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p8',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In.add('p5',{
            path:sn.R0043,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In.add('p6',{
            path:sn.CT0043,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In('p1','p2','p3','p4','p7','p8','p5','p6');
    }
    /*
     *动态加载企业找猎头页面  Home_Human_getAgentIndex
     *jack
     *2012-2-12
     */
    function LoadEnterGetAgent(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p4',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p5',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p9',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p10',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p9']
        });
        In.add('p7',{
            path:sn.R0044,
            type:'js',
            charset:'utf-8',
            rely:['p10']
        });
        In.add('p8',{
            path:sn.CT0044,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In('p1','p2','p4','p5','p6','p9','p10','p7','p8');
    }
    /*
     *功能：加载人才简历详细页面 Home_Detail_pjob_resudetail
     *jack
     *2012-2-11
     */
    function LoadTanlentResumeDetail(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.R0042,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.CT0042,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
          In.add('p7',{
            path:sn.L0015,
            type:'js',
            charset:'utf-8'
        });
        In.add('p8',{
            path:sn.L0016,
            type:'js',
            charset:'utf-8'
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8');
    }
    /*
     *找回密码
     *设置新密码
     *2012-2-17
     */
    function LoadLookPwd(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0003,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.R0048,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.CT0048,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In('p1','p2','p3');
    }
    /*功能：动态加载猎头首页Js Home_Company_index
     *参数：无
     *说明：无
     */
    function LoadCompanyIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.M0013,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.L0015,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In.add('p9',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p8']
        });
        In.add('p10',{
            path:sn.R0039,
            type:'js',
            charset:'utf-8',
            rely:['p9']
        });
        In.add('p11',{
            path:sn.CT0039,
            type:'js',
            charset:'utf-8',
            rely:['p10']
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8','p9','p10','p11');
    }
    /*
     *功能：加载我的人脉js文件-Home-Pool-mycontacts
     *参数：无
     *jack
     *2012-2-20
     */
    function LoadMyContacts(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.R0051,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0051,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In('p1','p2','p3','p4','p5');
    }

    /*
     *加载猎头我要推广页面 Home_MiddleMan_promote
     * 参数:无
     * jack
     * 2012-2-23
     */
    function LoadAEPromote(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0006,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.CT0100,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.R0031,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.CT0031,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In('p1','p2','p3','p4');
    }
    /*功能：动态加载资讯 - 首页Js Home_Blog_updateBlogIndex
     *参数：无
     *说明：无
     */
    function LoadBlogBlog(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0014,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.R0059,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0059,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In('p1','p2','p3','p4','p5');
    }
    /*功能：设置隐私页面
     *参数：无
     *说明：无
     */
    function setIndex(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.L0020,
            type:'js',
            charset:'utf-8',
            rely:['f3']     
        });
        In.add('p2',{
            path:sn.M0003,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.R0103,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.CT0103,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });    
        In('p1','p2','p3','p4');
    }
    /*功能：动态加载资讯 - 首页Js Home_Blog_updateBlogIndex
     *参数：无
     *说明：无
     */
    function LoadBlogInfo(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0014,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0019,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.R0061,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.CT0061,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In('p1','p2','p3','p4','p5','p6');
    }
    /*
     *功能：市场行情指导页面加载
     *参数：无
     *jack
     *2012-3-22
     */
    function LoadMarketGuidence(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0015,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.L0007,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0008,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In.add('p7',{
            path:sn.R0060,
            type:'js',
            charset:'utf-8',
            rely:['p6']
        });
        In.add('p8',{
            path:sn.CT0060,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });
        In('p1','p2','p3','p4','p5','p6','p7','p8');
    }
    /*
     *功能：市场行情指导页面加载
     *参数：无
     *jack
     *2012-3-22
     */
    function LoadToolRefer(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.R0060,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.CT0060,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In('p1','p2');
    }
    /*功能：动态加载资讯 - 角色首页Js Home_home
     *参数：无
     *说明：无
     */
    function LoadHomeHome(){
        var sn=SOURCENAME;
        var gd=$("#is_guide").val()=="1";
        if(gd){
            In.add('p6',{
                path:sn.L0013,
                type:'js',
                charset:'utf-8',
                rely:['f3']
            });
            In.add('p7',{
                path:sn.L0017,
                type:'js',
                charset:'utf-8',
                rely:['p6']
            });
            In.add('p8',{
                path:sn.L0005,
                type:'js',
                charset:'utf-8',
                rely:['p7']
            });
            In.add('p5',{
                path:sn.L0018,
                type:'js',
                charset:'utf-8',
                rely:['p8']
            });
        }
        In.add('p1',{
            path:sn.M0008,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.R0063,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.CT0063,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        if(gd){
            In('p6','p7','p8','p5','p1','p2','p3','p4');
        }else{
            In('p1','p2','p3','p4');
        }
    }
    /*功能：动态加载资讯 - 意见建议反馈页面 Public_feedback
     *参数：无
     *说明：无
     */
    function LoadFeedBack(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.CT0101,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In('p1');
    }
    /*功能：动态加载资讯 - 企业登录页面comlogin
     *参数：无
     *说明：无
     */
    function LoadComLogin(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.R0102,
            type:'js',
            charset:'utf-8', 
            rely:['f3']        
        });
        In.add('p2',{
            path:sn.CT0102,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In('p1','p2');
    }
    /*功能：动态加载 - 好友邀请页面Home_Invite_index
     *参数：无
     *说明：无
     */
    function LoadInvite_index(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.R0064,
            type:'js',
            charset:'utf-8', 
            rely:['f3']        
        });
        In.add('p2',{
            path:sn.CT0064,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0021,
            type:'js',
            charset:'utf-8'
        });
        In('p1','p2','p3');
    }
    /*功能：动态加载 - 猎头设置提醒页面Home_Middle_Man_remind
     *参数：无
     *说明：无
     */
    function AgentRemind(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0003,
            type:'js',
            charset:'utf-8'  
        });
        In.add('p2',{
            path:sn.R0065,
            type:'js',
            charset:'utf-8'  
        });
        In.add('p3',{
            path:sn.CT0106,
            type:'js',
            charset:'utf-8'
        });
        In('p1','p2','p3'); 
    }
    /*功能：未登录全职位详细页
     *参数：无
     *说明：无
     */
    function unLoginDetail(){
        var sn=SOURCENAME;  
        In.add('p1',{
            path:sn.L0019,
            type:'js',
            charset:'utf-8'            
        });
        In.add('p2',{
            path:sn.R0036,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.CT0036,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });  
        In.add('p4',{
            path:sn.L0022,
            type:'js',
            charset:'utf-8',
            rely:['p3']            
        });  
        In('p1','p2','p3','p4');                    
    }
    /*功能：未登录猎头详细页
     *参数：无
     *说明：无
     */
    function unLoginAgentDetail(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8'
        });
        In.add('p2',{
            path:sn.M0009,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p7',{
            path:sn.L0022,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p4',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p7']
        });           
        In.add('p5',{
            path:sn.R0037,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.CT0037,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });        
        In('p1','p2','p3','p4','p5','p6','p7');       
    }
    /*未登录企业详细加载*/
    function unLoginCompDetail(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.M0010,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.R0041,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0041,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In.add('p6',{
            path:sn.L0022,
            type:'js',
            charset:'utf-8',
            rely:['p5']
        });
        In('p1','p2','p3','p4','p5','p6');
    }
    function ManageAngent(){
        var sn=SOURCENAME;              
        In.add('p1',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In.add('p2',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.M0016,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.R0104,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });
        In.add('p5',{
            path:sn.CT0104,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });
        In('p1','p2','p3','p4','p5');    
    }
     /*功能：角色首页功能引导流程
     *参数：无
     *说明：无
     */
    function LoadHomeGuide(){        
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.CT0065,
            type:'js',
            charset:'utf-8',
            rely:['f3']
        });
        In('p1');       
    }
    /*功能：职位搜索
     *参数：无
     *说明：无
     */
    function LoadFindPos(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.L0006,
            type:'js',
            charset:'utf-8'          
        });
        In.add('p2',{
            path:sn.M0003,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
        In.add('p3',{
            path:sn.R0105,
            type:'js',
            charset:'utf-8',
            rely:['p2']
        });
        In.add('p4',{
            path:sn.L0013,
            type:'js',
            charset:'utf-8',
            rely:['p3']
        });  
        In.add('p5',{
            path:sn.CT0107,
            type:'js',
            charset:'utf-8',
            rely:['p4']
        });              
        In('p1','p2','p3','p4','p5');    
    }
    /*功能：未登录简历详细页
     *参数：无
     *说明：无
     */
    function unLoginResumeDetail(){
        var sn=SOURCENAME;
        In.add('p1',{
            path:sn.L0001,
            type:'js',
            charset:'utf-8'          
        });       
        In.add('p2',{
            path:sn.L0022,
            type:'js',
            charset:'utf-8',
            rely:['p1']
        });
         In('p1','p2');    
    }
    return{
        GenTemp:GenTemp,/*模板生成*/
        GenMTemp:GenMTemp,/*多模板生成*/
        //        Extend:Extend,
        HAjax:HAjax,/*异步公用方法*/
        Exit:Exit,/*退出*/
        Login:Login,/*弹出框方式登录*/
        SetCookie:SetCookie,/*设置cookie*/
        GetCookie:GetCookie,/*读取cookie*/
        DelCookie:DelCookie,/*删除cookie*/
        LoadUserProfile:LoadUserProfile,/*帐户设置*/
        setIndex:setIndex,/*隐私设置*/
        LoadIndexIndex:LoadIndexIndex,/*首页*/
        LoadPageSource:LoadPageSource,/*加载页面公用资源*/
        LoadTalentIndex:LoadTalentIndex,/*人才职讯推荐*/
        LoadPublicRegister:LoadPublicRegister,/*注册*/
        LoadMessageMsglist:LoadMessageMsglist,/*我的消息列表*/
        LoadBillIndex:LoadBillIndex,/*我的账单*/
        LoadDelegateDetail:LoadDelegateDetail,/*委托详细*/
        LoadPackageIndex:LoadPackageIndex,/*套餐操作*/
        LoadPromoteIndex:LoadPromoteIndex,/*推广页面*/
        LoadUserAgentprofile:LoadUserAgentprofile,/*猎头/公司账户页面*/
        LoadTalentResume:LoadTalentResume,/*人才简历*/
        LoadMiddleManUResumeIndex:LoadMiddleManUResumeIndex,/*猎头修改全职简历*/
        LoadMiddleManUHCIndex:LoadMiddleManUHCIndex,/*猎头修改兼职简历*/
        LoadPoolJobmanage:LoadPoolJobmanage,/*猎头-职位管理*/
        LoadHumanFindJob:LoadHumanFindJob,/*人才-找职位*/
        LoadCompanyJob:LoadCompanyJob,/*企业-发布新职位*/
        LoadPoolTManage:LoadPoolTManage,/*猎头-简历管理*/
        LoadMiddleManCreateResumeIndex:LoadMiddleManCreateResumeIndex,/*猎头-创建全职简历*/
        LoadMiddleManCpresume:LoadMiddleManCpresume,/*猎头-创建兼职简历*/
        LoadPoolBringin:LoadPoolBringin,/*企业-招聘*/
        LoadPoolMycert:LoadPoolMycert,/*人才-证书管理*/
        LoadDetailJobFullSelf:LoadDetailJobFullSelf,/*职位详细（带简历）*/
        LoadComDetail:LoadComDetail,/*企业详细页*/
        LoadDetailHuman:LoadDetailHuman,/*人才详细页*/
        LoadDetailJobFull:LoadDetailJobFull,/*职位详细（不带简历）*/
        LoadDetailAgent:LoadDetailAgent,/*猎头详细页*/
        LoadMiddleManIndex:LoadMiddleManIndex,/*猎头首页*/
        LoadCompanyGetHumanIndex:LoadCompanyGetHumanIndex,/*企业找人才*/
        LoadHumanGetCompnayIndex:LoadHumanGetCompnayIndex,/*人才找企业*/
        LoadCompanyIndex:LoadCompanyIndex,/*企业首页*/
        LoadTanlentResumeDetail:LoadTanlentResumeDetail,/*人才简历详细页面*/
        LoadTalentGetAgent:LoadTalentGetAgent,/*人才找猎头页面*/
        LoadEnterGetAgent:LoadEnterGetAgent,/*企业找猎头*/
        LoadLookPwd:LoadLookPwd,/*找回,设置新密码*/
        LoadMyContacts:LoadMyContacts,/*我的人脉*/
        LoadAEPromote:LoadAEPromote,/*猎头我要推广页*/
        LoadBlogBlog:LoadBlogBlog,/*博客相关页*/
        LoadMarketGuidence:LoadMarketGuidence,/*市场行情*/
        LoadBlogInfo:LoadBlogInfo,/*资讯相关页*/
        LoadToolRefer:LoadToolRefer,/*资讯查询页*/
        LoadHomeHome:LoadHomeHome,/*角色首页*/
        LoadFeedBack:LoadFeedBack,/*意见反馈*/
        LoadComLogin:LoadComLogin,/*企业登录*/
        LoadInvite_index:LoadInvite_index,/*好友邀请*/
        AgentRemind:AgentRemind,/*猎头设置提醒*/
        unLoginDetail:unLoginDetail, /*未登录详细加载*/
        unLoginAgentDetail:unLoginAgentDetail,/*未登录猎头详细加载*/
        unLoginCompDetail:unLoginCompDetail,/*未登录企业详细加载*/
        ManageAngent:ManageAngent,/*管理猎头*/
        LoadHomeGuide:LoadHomeGuide,/*角色首页功能引导流程*/
        LoadFindPos:LoadFindPos,/*职位搜索页*/
        unLoginResumeDetail:unLoginResumeDetail/*未登录简历页*/
    }
}();
