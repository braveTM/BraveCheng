/*找回密码，设置新密码控制器*/
var SlpwdController={
    /*
     *初始化按钮效果
     */
    a:function(){
        baseController.BtnBind(".btn5", "btn5","btn5_hov","btn5_click");
    },
    /*
     *表单验证
     *验证邮箱，密码
     */
     b:function(){
         $("#loginnum").focus(function(){
            baseRender.b(this);
        }).blur(function(){
             var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            var that=slpwdRender;
            if(str==""){
                msg=LANGUAGE.L0246;
                b=false;
            }
            else if(/@/.test(str)){//邮箱验证
                if(!/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(str)){
                msg=LANGUAGE.L0250;
                b=false;
                }
            }else{//手机号验证                
                if(!baseRender.d(str)){
                    msg=LANGUAGE.L0250;
                    b=false;
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }else{
             baseRender.b(this);
            }
        });
         /*密码验证*/
         $("#n_pwd").focus(function(){
            baseRender.a(this, LANGUAGE.L0009, "right");
        }).blur(function(){
             var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            var len=str.length;
            if(len==0){
                msg=LANGUAGE.L0010;
                b=false;
            }
            else if(len>0&&len<6){
                msg=LANGUAGE.L0011;
                b=false;
            }
            else if(len>16){
                msg=LANGUAGE.L0012;
                b=false;
            }
            else if(!/^[A-Za-z0-9/!/@/#/$/%/^/&/*/_]{4,16}$/.test(str)){
                msg=LANGUAGE.L0013;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*重复密码*/
        $("#conf_pwd").focus(function(){
            baseRender.a(this, LANGUAGE.L0016, "right");
        }).blur(function(){
             var str=$(this).val().replace(new RegExp(" ","g"),"");
              $(this).val(str);
            var msg="";
            var b=true;
            var pstr=$("#n_pwd").val();
            var len=str.length;
            if(len==0){
                msg=LANGUAGE.L0010;
                b=false;
            }
            else if(str!=pstr){
                b=false;
                msg= LANGUAGE.L0017;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
     },
     /*
      *初始化保存效果
      *jack
      *2012-2-17
      */
     c:function(){
         var that=slpwdRender;
        $("#sen_eadr").click(function(){
            $("#email_addr,#loginnum").trigger("focus");
            $("#email_addr,#loginnum").trigger("blur");
            if($(".get_pd div.tip.error").length==0){
                $(this).css("color","#aaa");
                $(this).parent().removeClass("btn5").addClass("btn7");
                $(this).css("cursor","wait");
                var p=$("#loginnum").val();
                var ac=new AccountCat();
                ac.GetBackPwd(p,that.c,that.d);
            }
        });
        $("#save_npd").click(function(){
            var pwd=$('#n_pwd').val();
            var toke=$("input[name='toke']").val();
            $("#n_pwd,#conf_pwd").trigger("blur");
            var phone=HGS.Base.GetCookie("phone");    
            if($(".get_pd div.tip.error").length==0){
                var ac=new AccountCat();
                var param="pword="+pwd+"&token="+toke;
                if(phone){
                    toke=HGS.Base.GetCookie("token");
                    param="pword="+pwd+"&token="+toke+"&phone="+phone;
                }
                ac.SetNewPwd(param,that.e,that.d);
            }
        });
         $("#re_send").bind("click",function(){
            if($(this).hasClass("blue")){
                var email=$("#email").val();
                $(this).removeClass("blue");
                var ac=new AccountCat();
                ac.ResendFogEmail(email,that.f,that.d);
            }
        });  
     },
      /*
      *初始化登录帐号表单
      *jiang
      *2012-5-18
      */
     d:function(){
        $("#loginnum").focus(function(){
            if($(this).hasClass("gray")){
                $(this).removeClass("gray");
                $(this).val('');             
            }
        }).blur(function(){
            if(!$(this).val()){
                $(this).addClass("gray");      
                $(this).val('请输入您的登录邮箱或手机号');  
            }        
        });
    },
      /*获取email值
      *jiang
      *2012-5-18
      */
    f:function(){
         var num=HGS.Base.GetCookie("email");        
         if(!num.length)
            window.location.href=WEBROOT+'/error';
         else
            $("#email").val(num);            
    },
    /*
      *获取phone值
      *jiang
      *2012-5-18
      */
    g:function(){
         var num=HGS.Base.GetCookie("phone");        
         if(!num.length)
            window.location.href=WEBROOT+'/error';
         else
            $("#phone").val(num);           
    },
      /*
      *获取手机页提交验证码事件绑定
      *jiang
      *2012-5-18
      */
     h:function(){
        $("#indcode").unbind('click').bind("click",function(){
            var url=ACCOUNTURL.PswPhone;
            var token=$("#phone").parent().next().find("input.idcode").val();
            var phone=$("#phone").val();   
            var params="token="+token+"&phone="+phone;
            var that=slpwdRender;
            var settings = {
                url:url,
                params:params,
                sucrender:that.g,
                failrender:that.h
            };
            HGS.Base.HAjax(settings);           
        }) 
    },
     /*
      *60秒倒计时
      *jiang
      *参数:tim，倒计时开始时间
      *2012-5-18
      */
     i:function(tim){
       var sta;
       var nowt=$("#time");       
       $("#re_send").removeClass("blue");
       var t=function(){
           if(tim<=0){
               clearTimeout(sta);
               $("#re_send").addClass("blue");
               return;
           }
           tim--;
           nowt.text(tim);          
           sta=setTimeout(t,1000);  
       }
       t();
     },
      /*
      *重新发送手机验证码
      *jiang    
      *2012-5-18
      */
    j:function(){
        $("#re_send").unbind("click").bind("click",function(){
            if($(this).hasClass("blue")){
                var that=slpwdRender;
                var p=$("#phone").val();
                var ac=new AccountCat();
                ac.GetBackPwd(p,that.c,that.d);  
            }
        })         
    },
  /*
      *去邮箱看看链接设置
      *jiang    
      *2012-5-18
      */
     k:function(){
         var mails ={
                'sdo.com':'m.sdo.com',
                "163.com":"mail.163.com",
                "sina.com.cn":"mail.sina.com.cn",
                "sohu.com":"mail.sohu.com",
                "tom.com":"mail.tom.com",
                "sogou.com":"mail.sogou.com",
                "126.com":"mail.126.com",
                "10086.cn":"mail.10086.cn",
                "gmail.com":"www.gmail.com",
                "hotmail.com":"www.hotmail.com",
                "189.cn":"www.189.cn",
                "vip.qq.com":"mail.qq.com",
                "qq.com":"mail.qq.com",
                "foxmail.com":"mail.qq.com",
                "yahoo.com.cn":"mail.cn.yahoo.com",
                "eyou.com":"www.eyou.com",
                "yahoo.com":"mail.yahoo.com",
                "21cn.com":"mail.21cn.com",
                "188.com":"www.188.com",
                "yeah.net":"www.yeah.net",
                "wo.com.cn":"mail.wo.com.cn",
                "263.net":"www.263.net"
            };
            var e=HGS.Base.GetCookie("email"); 
            var mail = mails[e.replace(/.+@/,"")];
            if(typeof(mail)!="undefined"){
                var that=$("#toemail");
                that.attr("href","http://"+mail);
                that.parent().removeClass("hidden");
            }
     },
     /*
      *功能：注册成功->重新发送邮件
      *参数：无
      */
     l:function(){
        var that=slpwdRender;
        $("#re_send").bind("click",function(){
            if($(this).hasClass("blue")){
                var email=$("#email").val();
                $("div").data("bd","#re_send");
                $(this).hide();
                $("a.loading").css("display","inline-block");
                var ac=new AccountCat();
                ac.ReSendActiveLink(email,that.i,that.j);
            }
        });  
     },
    /*初始化页面数据*/
    IniPage:function(){
        this.a();/*按钮效果*/
        this.b();/*验证*/
        this.c();/*初始化保存事件*/
        this.d();
//        this.e();        
    },
    /*初始邮箱找回密码数据*/
    IniEmPsw:function(){
        this.a();/*按钮效果*/
        this.c();/*初始化保存事件*/
        this.f(); 
        this.i(60);
        this.k();
    },
    /*初始手机找回密码数据*/
    IniPhPsw:function(){
        this.a();/*按钮效果*/
        this.g();   
        this.h();
        this.i(60);
        this.j();
    },
    /*注册激活页面*/
    IniRsend:function(){
        this.l();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    var that=SlpwdController;
    //根据PAGE来初始化页面
    if(PAGE=="63"||PAGE=="64"){
        //初始化页面js等
        that.IniPage();
    }
    if(PAGE=="65"){
        that.IniEmPsw();
    }
    if(PAGE=="107"){
        that.IniPhPsw();
    }
    if(PAGE=="108"){
        that.IniRsend();
    }
    
});


