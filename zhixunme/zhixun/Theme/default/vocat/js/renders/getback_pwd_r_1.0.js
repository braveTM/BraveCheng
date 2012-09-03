/*
 * 找回密码,设置新密码
 */
var slpwdRender={
   /*
     * 功能：异步验证提示
     * 参数：
     * data:异步成功返回数据
     */
    a:function(data){
        baseRender.ai("#email_addr");
    },
    /*
     * 功能：邮箱异步验证提示
     * 参数：
     * data:异步失败返回数据
     */
    b:function(data){
        baseRender.addred("#email_addr");
        baseRender.a("#email_addr",LANGUAGE.L0004,"error");
    },
    /*
     *发送邮件成功
     *jack
     *2012-2-17
     */
    c:function(data){              
        if(data.data.email){
            var email=data.data.email;        
            HGS.Base.SetCookie("email",email);
        }else{
            var phone=data.data.phone;
            HGS.Base.SetCookie("phone",phone);
        }
        var ele=$("div.get_pd  .t_wrap").find("div.get_pd ");
        $(ele).find("a.white").css("color","#fff");
        $(ele).removeClass("btn7").addClass("btn5");
       $(ele).find("a.white").css("cursor","default");
        document.body.style.cursor="default"; 
        window.location.href=data.data.url;
    },
     /*
     *发送邮件失败，返回错误信息
     *jack
     *2012-2-17
     */
    d:function(ret){
        alert(ret.data);
        var ele=$("div.get_pd  .t_wrap").find("div.act_em ");
        $(ele).find("a.white").css("color","#fff");
        $(ele).removeClass("btn7").addClass("btn5");
       $(ele).find("a.white").css("cursor","default");
        document.body.style.cursor="default"; 
    },
    /*
     *保存新密码成功
     *参数：无
     */
    e:function(){
        var msg="密码修改成功!";        
         alert(msg,"right",true,"",function(){
            HGS.Base.DelCookie("phone");
            HGS.Base.DelCookie("token");
            window.location.href=WEBROOT+'/';
        });  
    },
    /*
     *发送激活邮件成功
     *参数：无
     */
    f:function(){
        alert('发送成功！');
        SlpwdController.i(60);//倒计时
    },
    /*
     *提交手机验证码成功
     *参数：无
     */
    g:function(data){
        var d=data.data;
        var token=d.token;
        var num=HGS.Base.GetCookie("phone");    
            HGS.Base.SetCookie("token",token);                  
        window.location.href=WEBROOT+'/reset?phone='+Math.random();
    },
    /*
     *提交手机验证码失败
     *参数：无
     */
    h:function(data){
        alert("验证码提交失败!");
    },
    /*
     *功能：注册页面->发送激活邮件成功
     *参数：无
     */
    i:function(){
      var id= $("div").data("bd");
        $(id).show();
        $("a.loading").css("display","none");
        alert('发送成功！');   
    },
    /*
     *功能：注册页面->发送激活邮件失败
     *参数：无
     */
     j:function(data){
      var id= $("div").data("bd");
        $(id).show();
        $("a.loading").css("display","none");
      alert(data.data);
    }
};


