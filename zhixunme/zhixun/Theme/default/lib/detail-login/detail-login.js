/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 详细页登录
 */
var detailLogin={
    id:"detailogin",
    msg:"",
    cmsg:"您好，欢迎访问{name}，",
    lmsg:"登陆后浏览更多求职招聘信息!",    
    h1:"职讯网,专注于打造中国最专业的建筑职业平台,您可以在这里:",
    pos:'',  
    top:'',//登录框最初位置
    /*
    *功能:login　msg提示语获取
    *参数:id，
    *options
    */
    AddLogin:function(id){
        var that=detailLogin;
        var n=$("#"+that.id).find("div.login_lf").children("span");
        that.msg=n.text();
        that.pos=screen.height/2-200;//屏幕定位
        that.top=$("#"+detailLogin.id).offset().top+"px"; 
    },
   /*
    *　功能:提示语变换
    *　参数:i
    *  i:1 展开登录框
    *  i:0 关闭登录框
    *　author：joe 2012/7/9
    */
   ChangeNote:function(i){
       var name=$("#name").text();
       var that=detailLogin;
       var n=$("#"+that.id).find("div.login_lf").children("span");
       if(PAGE!=112&&PAGE!=113&&PAGE!=200&&PAGE!=201){//排除职位｜简历详细页
            if(i){             
                n.html(that.lmsg);
            }
            else{           
                n.html(that.msg);
            }
        }               
   },
//    显示全部login登录框
    slideLogin:function(){
        var v=$.browser.version;        
        var that=detailLogin;
        var top=that.pos; 
        that.ChangeNote(1);
        $("div.cards_cover_login").fadeIn(300,function(){
            if(v=="7.0"||v=="6.0")
                $("#"+that.id).find("div.des").show();
            $("#"+that.id).find("div.des").slideDown(600);
            $("#"+that.id).animate({
                    top:top+"px"          
                },600);
        });                    
    },    
    /*
    *功能:登录初始化
    *参数:退出登录框
    *options
    */
    slideOut:function(){
        var v=$.browser.version;
        var that=detailLogin;
        var top="46px";    
        if(v=="6.0"){
            top="246px";
        }
        $("#close").click(function(){
            $("div.cards_cover_login").fadeOut(300);
            $("#"+that.id).animate({
                top:top
            },600);
            if(v=="7.0"||v=="6.0"){
                $("#"+that.id).find("div.des").hide();      
            }                
            $("#"+that.id).find("div.des").slideUp(600);      
            that.ChangeNote(0);
        });        
    },
     /*
     * 功能：回车登录
     * 参数：
     * t：错误类型
     */
    KeyDownLogin:function(){
        $(document).keydown(function(event){            
            var aid=document.activeElement.id;
            if(event.keyCode==13&&(aid=="user"||aid=="psw")){
                var that=$("#log").parent();
                that.addClass("btn15_hov");
                detailLogin.login();
            }
        });
    },
   /*
    *功能:按键功能事件绑定
    *参数:
    *
    *修改：添加注册跳转页面cookie 2012/7/17
    */
   btnhref:function(){
       var that=HGS.Base,url=location.href;
       $("#detailogin div.login_rf div.hreg").bind("click",function(){
           that.SetCookie("reurl",url);
           location.href=WEBROOT+'/tregister/';
       });
        $("#remb").bind("click",function(){
           location.href=WEBROOT+'/forgot/';
       });
       $("#detailogin div.login_rf div.ereg").bind("click",function(){
           that.SetCookie("reurl",url);
           location.href=WEBROOT+'/aregister/';
       });
       $("#detailogin div.login_rf div.creg").bind("click",function(){
           that.SetCookie("reurl",url);
           location.href=WEBROOT+'/eregister/';
       });
       $("#rec,#rec1").bind("click",function(){
           if($("#rec").hasClass("sel")){
                $("#rec").addClass("auto");
                $("#rec").removeClass("sel");
                $("#rec").attr("rel","0");
           }else{
               $("#rec").addClass("sel");
               $("#rec").removeClass("auto");
               $("#rec").attr("rel","1");
           }           
       })
       $("#log").unbind("click").bind("click",detailLogin.login);       
   },
    /*
    *功能:表单事件绑定
    *参数:
    *
    */
   inputCheck:function(){
        $("#user").focus(function(){
            if($(this).val()=='电子邮箱/手机'){
                $(this).val('');                
            }
        }).blur(function(){
            if($(this).val()==''){
                $(this).val('电子邮箱/手机');
            }
        })                  
    },
    /*
    *功能:登录
    *参数:
    *
    */
    login:function(){
        var error=0;
        if($("#user").val()=='电子邮箱/手机'){
            error=1;
            alert("请填写帐号信息!");            
        }
        else if(!$("#psw").val()){
            error=1;
            alert("请输入密码!");
        }
        if(!error){          
            var a=$("#user").val();
            var b=$("#psw").val();
            var c=$("#rec").attr("rel");
            var s={
            url:WEBURL.Login,
            params:"uname="+a+"&pword="+b+"&rem="+c,
            sucrender:detailLogin.loginsuc,
            failrender:detailLogin.loginfail
            };
            HGS.Base.HAjax(s);
        }
    },
     /*
    *功能:登录成功
    *参数:
    *
    */
   loginsuc:function(){
       location.reload();
   },
     /*
    *功能:登录失败
    *参数:
    *
    */
   loginfail:function(data){
        if(data.data==3){
            var msg="你的帐户在短时间内密码输入错误5次，为保障您的帐户安全，请在5分钟后重新输入!";    
            baseController.InitialSureDialog("error",msg, "select",'找回密码',function(){
                $("#select").attr({
                    "href":WEBROOT+'/forgot/',
                    "target":"_blank"
                });                                                
            });
        }else{
            alert(data.data);       
        }
   },
    /*
    *功能:登录初始化
    *参数:obj触发遮罩对象
    *options
    */
     iniFun:function(obj){
         detailLogin.AddLogin();
         detailLogin.KeyDownLogin();
         baseController.BtnBind(".btn15","btn15","btn15_hov","btn15_hov");
         baseController.BtnBind(".btn14","btn14","btn14_hov","btn14_hov");
         detailLogin.btnhref();
         detailLogin.inputCheck();    
         detailLogin.slideOut();         
         obj=obj||$("div.layout2_l").find("p.blue");        
         HGS.Base.DelCookie("reurl");
     },
    /*
     * 功能:弹出登录框
     * 参数:
     * obj 触发登录框对象
     *
     */
     toslideLogin:function(obj){
         obj.unbind("click").bind("click",function(){
            detailLogin.slideLogin();
        });
     }
}
$().ready(function(){
     detailLogin.iniFun();
    if(PAGE=="112"||PAGE=="113"){//职位详细页(全职、兼职)        
         detailLogin.toslideLogin($("#add_focus,#report,,#ckcontact,#app_ftr"));
    }
    if(PAGE=="200"||PAGE=="201"){//简历详细页(全职、兼职)    
        detailLogin.toslideLogin($("#add_focus,#se_agphone,#inv_apl"));        
    }    
    if(PAGE=="110"){ //人才   
        $("#report_h,#add_focus").click(function(){
            detailLogin.slideLogin();
            return false;
        });  
    }
    if(PAGE=="111"){//企业  
        detailLogin.toslideLogin($("#add_focus,#report_c,,#report_h"));        
    }
    if(PAGE=="109"){//未登录猎头详细页       
        detailLogin.toslideLogin($("#add_focus,#report_a,#praise"));
        $("div.layout2_r a.torel,#downing").live("click",function(){
             detailLogin.slideLogin();
             return false;           
        });
    }    
})
