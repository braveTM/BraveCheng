/*
 * 注册页面渲染器
 */
var registerRender={
    /*
     * 功能：添加资质显示添加结果
     * 参数：
     * r：插件返回结果
     * candice 2012-7-7
     * 无修改
     */
    a:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){
            mname=" - "+r.majname;
        }
        var txt=r.cname+mname+" - "+r.regname+" - "+r.provname;
        that.val(txt);
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        that.data("rid",r.reg);
        that.data("prov",r.prov);
    },
    /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r：插件返回结果
     * candice 2012-7-7
     * 无修改
     */
    b:function(r){
        var that=r.obj;
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+","+r.jtid;
        that.val(txt);
        that.data("ids", ids);
    },
    /*
     * 功能：异步验证提示
     * 参数：
     */
    e:function(data){
        baseRender.adgren("#u_emil");
        baseRender.ai("#u_emil");
    },
    /*
     * 功能：邮箱异步验证提示
     * 参数：无
     */
    f:function(){
        baseRender.addred("#u_emil");
        baseRender.a("#u_emil",LANGUAGE.L0004,"error");
    },
    /*
     * 功能：用户名异步验证提示
     * 参数：无
     */
    g:function(){
        baseRender.b("#uname");
        var u=$("#uname");
        u.attr("valide",u.val());
    },
    /*
     * 功能：用户名异步验证提示
     * 参数：无
     */
   h:function(data){
        baseRender.a("#uname",LANGUAGE.L0008,"error");
    },
    /*
     * 功能：注册成功
     * 参数：无
     */
   i:function(data){     
            location.href=data.data;                         
    },
     /*
     * 功能：注册失败
     * 参数：无
     */
    j:function(data){
        alert(data.data);
       $("#valid_img").attr("src",WEBROOT+"/rvcode?xy="+Math.random()+"");
       var ele=$("div.regis_page .regis_box_l .p3").find("div.u_n");
        $(ele).find("a.white").css("color","#fff");
        $(ele).removeClass("btn7").addClass("btn5");
       $(ele).find("a.white").css("cursor","default");
        document.body.style.cursor="default"; 
    },
    /*
     *功能：地区选择成功绑定数据
     *参数：无
    */
   l:function(r){
        $("input[name='t_prov']").val(r.prov);
        $("input[name='t_city']").val(r.city);
        $("#place").val(r.provname+"-"+r.cityname);
        baseRender.ai("#place");
   },
    /*
     *功能：注册方式选择
     *参数：无
     */
    m:function(_t){
        var that=$(_t);
        var index=that.index();
        var ct=that.parent().parent().parent().find("div.t_container");
        that.parent().find("li.cur_li").removeClass("cur_li");
        that.addClass("cur_li");
        ct.find(">div.show").addClass("hidden").removeClass("show");
        ct.find("div.t_item").eq(index).addClass("show").removeClass("hidden");
        var ele=ct.find("div.t_item");
        $.each(ele,function(i,o){
            if($(o).hasClass("hidden")){
               $(o).find("div.result,div.tip,div.error").remove();
               $(o).find("p.valid_tip").text("");
               $(o).find("p.mvalid").text("");
               $(o).find(".red_border").removeClass("red_border");
               $(o).find(".green_border").removeClass("green_border");
            }
        });
    },
   /*
    *功能：发送验证码到手机成功
    *参数：无
    */
   n:function(ret){
      if(ret.ret){
            $("#countDown").show(); 
            $("em.gtcode").addClass("hidden");
            setTimeout(registerController.ab,1000);
            $("#v_send").removeClass("btn_normal").addClass("btn_gray").attr("disabled", "disabled");
            $("#u_phone").addClass("text-none").attr("disabled","disabled"); $("em.gtcode").addClass("hidden");
            $("#v_send").removeClass("clicked");
        } 
   },
   /*
    *功能：发送失败
    *参数：无
    */
   o:function(ret){
       alert(ret.data);
   }
};
