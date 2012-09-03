/*
* 功能：个人账户页面点击事件，数据获取成功、失败、处理
* 参数：无
* 说明：无
*/
var accountRender={
    /*
     *初始化企业性质
     *jack
     *2012-2-16
     */
    a:function(){
        var a=$("input[name='cpy_sex']").val();
        var b=$("#e_attr>option");
        $.each(b, function(i,o){
            if(a==$(o).val()){
               $(o).attr("selected",true);
            }
        });
        var c=$("input[name='pcquali']").val();
        var d=$("#comscale>option");
         $.each(d, function(i,o){
            if(c==$(o).val()){
               $(o).attr("selected",true);
            }
        });
    },
    /**
     * 初始化性别
     * @author yoyiorlee
     * @date 2012-12-05
     */
    h:function(){
        var v = $("#gender").val();
        var g = $(".p_gender");
        g.each(function(i,o){
            if($(this).attr('val')==v){
                $(this).attr("checked",true);
            }
        });
    },
    /**
     * 选择性别
     * @author yoyiorlee
     * @date 2012-12-05
     */
    k:function(o){
        $(o).parent().find(".p_gender").removeClass("sel");
        $(o).addClass("sel");
        $("#gender").val($(o).attr("val"));
    },
     /**
     *删除资质失败/保存基本资料失败/保存修改密码失败/执行
     * @author jack
     * @date 2012-12-09
     */
    fail:function(data){
        alert(data.data);
    },
    /*
     *功能：修改操作成功执行
     *参数：ret/返回值
     *说明：@jack
     *@2011.12.9
     */
    succ:function(){
        alert("操作成功","","","",function(){
            location.reload();
        });
    },
     /*
     *功能：发送验证码到手机成功
     *参数：ret/返回值
     *说明：@jack
     *@2011.12.9
     */
    sendsucc:function(ret){
        if(ret.ret){         
            $("#countDown").show(); 
            $("em.gtcode").addClass("hidden");
            setTimeout(accountController.InigetVerfy,1000);
            $("#v_send").removeClass("btn_normal").addClass("btn_gray").attr("disabled", "disabled");
            $("#n_pnum").addClass("text-none").attr("disabled","disabled"); 
            $("em.gtcode").addClass("hidden");
            $("#v_send").removeClass("clicked");
        }
    },
     /*
     *功能：发送验证码到手机失败
     *参数：无
     *说明：@jack
     *@2011.12.9
     */
    sendfail:function(ret){
        alert(ret.data);
    },
    /*
     *功能：保存手机号码失败
     *参数：无
     *@jack
     *@2011.12.11
     */
   savephfail:function(ret){
       alert(ret.data);
   },
     /*
     *功能：验证码错误
     *参数：无
     *@jack
     *@2011.12.11
     */
      /*
     * 功能：异步验证提示
     * 参数：
     * data:异步成功返回数据
     */
      Isemailavaible:function(data){
        baseRender.b("#email");
    },
      /*
     * 功能：异步验证提示
     * 参数：
     * data:异步成功返回数据
     */
    appsucc:function(data){
        var id=$("div").data("ele");
         baseRender.ai(id);
    },
     /*
     * 功能：邮箱异步验证提示（申请）
     * 参数：
     * data:异步失败返回数据
     */
    appfail:function(data){
         var id=$("div").data("ele");
        baseRender.a(id,LANGUAGE.L0004,"error");
    },
    /*
     * 功能：邮箱异步验证提示（修改）
     * 参数：
     * data:异步失败返回数据
     */
    Isnotemailavble:function(data){
        baseRender.a("#email",LANGUAGE.L0004,"error");
    },
    /*
     * 功能：昵称异步验证提示
     * 参数：无
     */
    nickright:function(){
        baseRender.ai("#nickname");
    },
    /*
     * 功能：昵称异步验证提示
     * 参数：
     * data:异步失败返回数据
     */
    nickerror:function(data){
        baseRender.a("#nickname",LANGUAGE.L0100,"error");
    },
     /*
     *功能:滚动到导航
     *参数:无
     *说明：@jack
     *@2011.12.11
     */
   f:function(){
       $("html,body").animate({scrollTop:$("#uceter").offset().top-60},300);
    },
      /*
     *功能:切换tab标签
     *参数:无
     *说明：@jack
     *@2011.12.11
     */
    stab:function(curr){
        $(curr).parent().parent().next(".v_cont").css("border-top", "2px solid #8bc2e6");
        $(curr).addClass("cur_p");
        $(curr).find("span.s_l").addClass("pointer");
        $(curr).parent().parent().next().children(".tab_ct").hide();
        var er=$(curr).attr("rel");
        if(er==""){
           $(curr).find("span.s_l").removeClass("pointer");
            $(curr).parent().parent().next().hide();
            $(curr).parent().parent().next(".v_cont").css("border-top","none");
        }else{
         $(curr).parent().parent().next(".v_cont").show();
         $("."+er).show();
        }
    },
    /*
     *功能:切换tab标签
     *参数:无
     *说明：@jack
     *@2011.12.11
     */
    tab:function(curr){
        $(curr).parent().parent().next(".va_cont").css("border-top", "2px solid #8bc2e6");
        $(curr).addClass("cur_p");
        $(curr).find("span.s_l").addClass("pointer");
        $(curr).parent().parent().next().children(".tab_c").hide();
        var er=$(curr).attr("rel");
        if(er==""){
           $(curr).find("span.s_l").removeClass("pointer");
            $(curr).parent().parent().next().hide();
            $(curr).parent().parent().next(".va_cont").css("border-top","none");
        }else{
          $(curr).parent().parent().next().show();
         $("."+er).show();
        }
    },
    /*
     *身份证复印件正面上传
     *jack
     *2012-2-2
     */
    upfront:function(_v){
        baseRender.b("#fd_cd");
        $(".fd").find("span.red").remove();
         $("#up_f1").next().remove();
          var fo=$("#fd_cd").val();
          var no=$("#bd_cd").val();
          var b=true;
          if(fo!=""&&no!=""){
              if(fo==no){
                  b=false;
                  $(_v).val("");
                  $(_v).next(".up_phot").addClass("hidden");
                  alert("图片重复,请重新选择");
                  $("input[name='front_side']").val("");
              }else{
                  b=true;
                  $("input[name='front_side']").val("");                 
              }
          }
          if(b){ 
              $(_v).next(".up_phot").removeClass("hidden");
              $("#up_f1").removeClass("hidden");
              return(b);
          }
    },
    /*
     *身份证复印件背面上传
     *jack
     *2012-2-2
     */
    upback:function(_v){ 
         baseRender.b("#bd_cd");
        $(".bd").find("span.red").remove();
         $("#up_f2").next().remove();
         var fo=$("#fd_cd").val();
          var no=$("#bd_cd").val();
          var b=true;
          if(fo!=""&&no!=""){
              if(fo==no){
                  b=false;
                 $(_v).val("");
                 $(_v).next(".up_phot").addClass("hidden");
                 alert("图片重复,请重新选择");
                 $("input[name='back_side']").val("");
              }else{
                 $("input[name='back_side']").val("");
                  b=true;                 
              }
          }
          if(b){
              $(_v).next(".up_phot").removeClass("hidden");
              $("#up_f2").removeClass("hidden");
              return(b) ;
          }
    },
    /*
     *处理正面上传
     *jack
     *2012-2-2
     */
    dofrontup:function(_v){
        baseRender.b("#fd_cd");
        try{
            var file = $("#fd_cd").val();
            if(avatarRender.f(file)){
               $("#up_f1").addClass("hidden");              
               $("#up_f1").after(COMMONTEMP.T0030);
               $('#form_upload_01').submit();
            }
        }catch(e){
            accountRender.upfail(e,_v);
        }
    },
     /*
     *处理背面上传
     *jack
     **2012-2-2
     */
    dobackup:function(_v){        
        baseRender.b("#bd_cd");
        try{
            var file = $("#bd_cd").val();
            if(avatarRender.f(file)){
               $("#up_f2").addClass("hidden");
               $("#up_f2").after(COMMONTEMP.T0030);
               $('#form_upload_02').submit();
            }
        }catch(e){
            accountRender.upfail(e,_v);
        }
    },
     /*
     *身份证复印件
     *上传成功
     */
    upsuccess:function(type,data){
        if(type=="1"){
           $("input[name='front_side']").val(data);
           $("#up_f1").next().remove();
           $("#up_f1").after("<div><span class='red'>上传成功</span></div>");
        }else{
         $("input[name='back_side']").val(data);
          $("#up_f2").next().remove();
          $("#up_f2").after("<div><span class='red'>上传成功</span></div>");
        }
    },
    /*
     *上传错误处理
     */
    upfail:function(e,s){
        if(typeof e == "undefined"){
            $(""+s).removeClass("hidden");
            alert("上传失败，刷新页面或稍后再试。");
        }else{
            alert(e);
        }
    }
};
