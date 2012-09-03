/* 
 * 首页控制器
 */
var inviteController={
    /*
     *功能：邮件输入框keydown事件
     *参数：无
     */
    a:function(){
        var that=inviteController;
       $("#em_cont").keydown(function(e){
         if(e.keyCode=="13"){
           var x=that.e(this);
           var v1=$(this).val().replace(new RegExp(" ","g"),"");
           if(x!=false){
               var len=$("#plist").find("a").length;
               if(len=="10"){
                    alert('最多可同时添加10个收件人');
               }else{
                  if(len=="0"){
                        that.c(v1);
                        $("#em_cont").val(""); 
                  }
                 else{
                   var b=true;
                   $.each($("#plist").find("a"),function(i,o){
                      if(v1==$(o).text().replace(new RegExp(" ","g"),"")){
                          alert('邮箱地址重复');
                          b=false;
                          return false;
                      }
                   });
                   if(b){
                        that.c(v1);
                        $("#em_cont").val(""); 
                   }  
                  }
              } 
           }
         }
       });
    },
    /*
    *功能：手机号码输入框keydown事件
    *参数：无
    */
    aa:function(){
        var that=inviteController;
       $("#ph_cont").keydown(function(e){
         if(e.keyCode=="13"){
           var x=that.ae(this);
           var v1=$(this).val().replace(new RegExp(" ","g"),"");
           if(x!=false){
               var len=$("#clist").find("a").length;
               if(len=="10"){
                    alert('最多可同时添加10个号码');
               }else{
                  if(len=="0"){
                        that.ac(v1);
                        $("#ph_cont").val(""); 
                  }
                 else{
                   var b=true;
                   $.each($("#clist").find("a"),function(i,o){
                      if(v1==$(o).text().replace(new RegExp(" ","g"),"")){
                          alert('手机号码重复');
                          b=false;
                          return false;
                      }
                   });
                   if(b){
                        that.ac(v1);
                        $("#ph_cont").val(""); 
                   }  
                  }
              } 
           }
         }
       });  
    },
    /*
     *功能：初始化邀请按钮
     *参数：无
     */
    b:function(){
     var that=inviteController;
     /*邮箱邀请*/
      $("#email_invite").unbind("click").bind("click",function(){
          $("div").data("obj","#email_invite");
          var vp=$("#em_cont").val(),
               b=true,
           len=$("#plist").find("a").length,
           str=$("input[name='em_list']").val();
          if(vp==""){
              if(len=="0"){
                alert(LANGUAGE.L0002);
              }else{
                that.g(str);
              }
          }else if(vp!="" && len=="0"){
             var c=inviteController.e($("#em_cont"));
             if(c==true){
                that.g(vp);  
             }
          }else if(vp!="" && len!="0"){
             $("#em_cont").val("");
             that.g(str);
          }
      });  
      /*手机邀请*/
      $("#phone_invite").unbind("click").bind("click",function(){
          $("div").data("obj","#phone_invite");
          var vp=$("#ph_cont").val(),
               b=true,
           len=$("#clist").find("a").length,
           str=$("input[name='phone_list']").val();
          if(vp==""){
              if(len=="0"){
                alert(LANGUAGE.L0041);
              }else{
                that.ag(str);
              }
          }else if(vp!="" && len=="0"){
             var c=inviteController.ae($("#ph_cont"));
             if(c==true){
                that.ag(vp);  
             }
          }else if(vp!="" && len!="0"){
             $("#ph_cont").val("");
             that.ag(str);
          }
      });
    },
    /*
     *功能：生成收件人模板列表
     *参数：无
     */
    c:function(elem){
        var html='';
        html+='<a href="javascript:;" title="'+elem+'">'+elem+'</a>';
        $("#plist").append(html);
        var that=inviteController;
        that.f();
        that.d();
    },
    /*
     *功能：生成手机号码列表
     *参数：无
     */
    ac:function(elem){
       var html='';
        html+='<a href="javascript:;" title="'+elem+'">'+elem+'</a>';
        $("#clist").append(html); 
        var that=inviteController;
        that.af();
        that.ad();
    },
    /*
     *功能：绑定删除邮箱事件
     *参数：无
     */
    d:function(){
      $("div.items a").unbind("click").bind("click",function(){
          var msg=confirm('确定删除？');
          if(msg==true){
              $(this).remove();
              inviteController.f();
          }
      }); 
    },
     /*
     *功能：绑定删除手机号码事件
     *参数：无
     */
    ad:function(){
      $("div.items a").unbind("click").bind("click",function(){
          var msg=confirm('确定删除？');
          if(msg==true){
              $(this).remove();
              inviteController.af();
          }
      }); 
    },
    /*
     *功能：验证邮箱格式
     *参数：无
     */
    e:function(obj){
       var str=$(obj).val().replace(new RegExp(" ","g"),"");
        var b=true;
        var msg="";
        if(str==""){
            msg=LANGUAGE.L0002;
            b=false;
            alert(msg);
        }
        else if(!/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(str)){
            msg=LANGUAGE.L0003;
             b=false;
            alert(msg);
        }else{
           b=true;
        }  
        return b;
    },
    /*
     *功能：验证手机号码
     *参数：无
     */
    ae:function(obj){
       var str=$(obj).val().replace(new RegExp(" ","g"),"");
        var b=true;
        var msg="";
        if(str==""){
            msg=LANGUAGE.L0041;
            b=false;
            alert(msg);
        }
        else{ 
            var y=baseRender.d(str);
            if(y==false)
            {
                msg=LANGUAGE.L0040;
                b=false;
                alert(msg);
            }else{
                 b=true;
            }  
        }
        return b;  
    },
    /*
     *功能：初始化多个邮件收件人列表
     *参数：无
     */
    f:function(){
       var _obj=$("#plist a");
        var zk="";
        $.each(_obj,function(i,o){
            zk+=$(o).text()+",";
      });
        $("input[name='em_list']").val(zk);  
    },
     /*
     *功能：初始化多个手机号码列表
     *参数：无
     */
    af:function(){
       var _obj=$("#clist a");
        var zk="";
        $.each(_obj,function(i,o){
            zk+=$(o).text()+",";
      });
        $("input[name='phone_list']").val(zk);  
    },
    /*
     *功能：邮件邀请操作
     *参数：收件人邮箱
     */
    g:function(str){
       var that=inviteRender;
       var m=new Message();
       m.SendEmilInvitation(str,that.c,that.d);
    },
    /*
     *功能：短信邀请操作
     *参数：手机号码
     */
    ag:function(str){
        var that=inviteRender;
       var m=new Message();
       m.SendPhonelInvitation(str,that.c,that.d);
    },
    /*
     *功能：绑定按钮效果
     *参数：无
     */
    h:function(){
        baseController.BtnBind(".btn4", "btn4", "btn4_hov", "btn4_click");
    },
    /*
     *功能：复制链接
     *参数：无
     */
    ab:function(){
       $("a#fast_invite").zclip({
            path: THEMEROOT+'lib/zeroclipboard/ZeroClipboard.swf',
            copy: function(){
                return $('#cop_link').val();
            }
        });  
    },
    /*
     * 功能：初始化首页
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(0);
        this.a();
        this.b();
        this.h();
        this.aa();
        this.ab();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    if(PAGE=="7"){
        inviteController.IniPage();
    }
});
