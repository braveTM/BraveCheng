/* 
 * 企业登录页
 * 
 */
var comloginController={
    /*
     * 功能:登录框初始化
     * 参数：
     * 无
     */
    a:function(){        
        that=comloginRender.a();
        if($("#uname").val())
            $("#uname").next("span").fadeOut(1);
    },
     /*
     * 功能：input验证
     * 参数：obj输入框对象,msg错误提示
     * 无
     */
    aa:function(){
       $("#uname").focus(function(){
            $(this).css("border-color","#0171CA");
            $(this).removeClass("error");
            if($(this).next('span').length>0){
                $(this).next('span').remove();
            }
            if($("#upsd").val()!=""){
                if($("#auth").val()==""){
                    if($("#auth").hasClass("error")){
                        $("#err_msg").text(LANGUAGE.L0056);
                    }else{
                        $("#err_msg").text("");
                    }
                }else{
                    $("#err_msg").text("");
                }
            }else{
                if($("#upsd").hasClass("error")){
                   $("#err_msg").text(LANGUAGE.L0010);
                }
                else {
                if($("#auth").hasClass("error")){
                    $("#err_msg").text(LANGUAGE.L0056);
                }
                else{
                    $("#err_msg").text(""); 
                }
              }
            }
        }).blur(function(){
            var er=$("#err_msg");
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                $(this).css("border-color","#c00");
                $(this).addClass("error");
                var msg=LANGUAGE.L0231;
                er.text(msg);
            }
            else{
                $(this).val(str);
                $(this).css("border-color","#0171CA");
                if($("#upsd").val().replace(new RegExp(" ","g"),"")!=""){
                    er.text("");
                }
            }
        });
       $("#upsd").focus(function(){
            $(this).css("border-color","#0171CA");
            $(this).removeClass("error");
            if($(this).next('span').length>0){
                $(this).next('span').remove();
            }
           if($("#uname").val()!=""){
               if($("#auth").hasClass("error")){
                 $("#err_msg").text(LANGUAGE.L0056);
               }else{
                 $("#err_msg").text("");
               }
           }else{
               if($("#uname").hasClass("error")){
                   $("#err_msg").text(LANGUAGE.L0231); 
               }
               else if($("#auth").hasClass("error")){
                 $("#err_msg").text(LANGUAGE.L0056);
               } 
               else{
                 $("#err_msg").text("");
               }
           }
        }).blur(function(){
            var er=$("#err_msg");
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                $(this).css("border-color","#c00");
                $(this).addClass("error");
                var msg=LANGUAGE.L0010;
                er.text(msg);
            }
            else{
                $(this).val(str);
                $(this).css("border-color","#0171CA");
                if($("#uname").val().replace(new RegExp(" ","g"),"")!=""){
                    er.text("");
                }
            }
        });
          $("#auth").focus(function(){
            $(this).css("border-color","#0171CA");
            $(this).removeClass("error");
            if($(this).next('span').length>0){
                $(this).next('span').remove();
            }
           if($("#uname").val()!=""&&$("#upsd").val()!=""){
                $("#err_msg").text("");
            }
        }).blur(function(){
            var er=$("#err_msg");
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                $(this).css("border-color","#c00");
                $(this).addClass("error");
                var msg=LANGUAGE.L0056;
                er.text(msg);
            }
            else{
                $(this).val(str);
                $(this).css("border-color","#0171CA");
                if($("#uname").val().replace(new RegExp(" ","g"),"")!=""){
                    er.text("");
                }
            }
        });
    },
    /*
     * 功能：登录
     * 参数：
     * 无
     */
    d:function(){
        $("#login").click(function(){
             var str=$("#uname").val().replace(new RegExp(" ","g"),"");
            var str1=$("#upsd").val().replace(new RegExp(" ","g"),"");
            var str2=$("#auth").val().replace(new RegExp(" ","g"),"");
            if(str==""&&str1==""&&str2==""&&!$("#uname").hasClass("error")&&!$("#upsd").hasClass("error")&&$("#auth").hasClass("error")){
                $("#uname").focus().trigger("blur");  
            }else if(str==""){
                $("#uname").focus().trigger("blur");
            }else if(str1==""){
                $("#upsd").focus().trigger("blur");
            }else if(str2==""){
                $("#auth").focus().trigger("blur");
            }
            if($(this).parent().parent().find("input.error").length==0){
                var rem=0;
                if($("input[name='cache']").attr("checked")){
                    rem=1;
                }
                var uname=$("#uname").val();
                var pwd=$("#upsd").val();
                var auth=$("#auth").val();
                var u=$(this).attr("ru");
                var that=comloginRender;
//                var ac=new AccountCat();
                comloginController.Login(rem, uname, pwd, auth,that.b, that.c);
            }
        });
    },
    /*
     * 功能：登录输入提示
     * 参数：
     * t：错误类型
     */
    f:function(){
        $("div.login_box div.txt_cont span.tipmsg").click(function(){
            $(this).parent().find("input").trigger("focus");
        });
    },
    /*
     * 功能：回车登录
     * 参数：
     * t：错误类型
     */
    g:function(){
        $(document).keydown(function(event){
            var aid=document.activeElement.id;
            if(event.keyCode==13&&(aid=="uname"||aid=="upsd"||aid=="auth")){
                $("#login").trigger("click");
            }
        });
    },
     /*
     * 功能：验证码请求
     * 参数：     
     */
    h:function(){       
       $("#val_anoth,#img_anoth").click(function(){
            $("#img_anoth").attr("src",WEBROOT+"/lvcode?xy="+Math.random()+"");
        });
    },
     /*
     * 功能：企业登录
     * 参数：
     * rem: 是否记住登录
     * name：用户名
     * psw：密码
     * auth:验证码     
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象         
     */
   Login:function(rem,name,psw,auth,sf,ff){
        var s={
            url:WEBURL.ComLogin,
            params:"uname="+name+"&pword="+psw+"&verify="+auth+"&rem="+rem,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    },
    
    /*
     * 功能：初始化
     * 参数：
     * 无
     */
    IniPage:function(){
        this.a();
        this.d();
        this.f();
        this.g();
        this.h();
        this.aa();
    }
}
$().ready(function(){
    var that=comloginController;
    that.IniPage();    
});