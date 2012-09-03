/*
 * 意见反馈页面控制器
 */
var feedbackController={
     /*
     * 功能：姓名/手机/邮箱格式验证
     *：参数：无
     */
    a:function(){
        $("#name").focus(function(){
            baseRender.a(this, LANGUAGE.L0089, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
               baseRender.b(this);
            } 
            else{
                baseRender.ai(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*电话号码验证*/
        $("#mobile").focus(function(){
            baseRender.a(this,LANGUAGE.L0039, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
               baseRender.b(this);
            }
            else{
                var x=baseRender.d(str);
                if(x==false)
                {
                    msg=LANGUAGE.L0040;
                    b=false;
                }
                else{
                    b=true;
                    baseRender.ai(this);
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
         $("#email").focus(function(){
            baseRender.a(this, LANGUAGE.L0001, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0002;
                b=false;
            }
            else if(!/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(str)){
                msg=LANGUAGE.L0003;
                b=false;
            }
            else{
               baseRender.ai(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
    },
    /*
     *功能：反馈内容验证
     *参数：无
     */
    b:function(){
      var tbox= $("#advice_box");
      $("#advice_box").focus(function(){
          if($(this).hasClass("gray")){
             $(this).removeClass("gray").val("")
          }else if($(this).hasClass("red")){
             $(this).removeClass("red").removeClass("red_border").val("");
          }
      }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");  
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
               msg=LANGUAGE.L0230;
               b=false;
            } 
            if(b==false){
               $(this).addClass("red_border");
           tbox.val(msg).addClass("red");
            }
      }); 
    },
    /*
    *功能：提交意见建议
    *参数：姓名：name
    *电话：phone
    *邮箱：email
    *类型：type
    *内容：content
    */
    c:function(){
      baseController.BtnBind(".btn20", "btn20", "btn20_hov", "btn20_hov");
      $("#sm_fdb").bind("click",function(){
          $("#email").trigger("blur");
          var tt=$("#advice_box");
          if(tt.hasClass("gray")||$(this).hasClass("red")){
            tt.addClass("red_border").removeClass("gray").addClass("red");
            return false;   
          }
         else if(!tt.hasClass("red_border")&&$("div.tip.error").length=="0"){
             var name=$("#name").val();
             var phone=$("#mobile").val();
             var email=$("#email").val();
             var type=$("input[name='st']:checked").val();
             var cont=tt.val();
             var m=new Message();
             var ba=baseRender;
             m.PostFeedBack(name,phone,email,type,cont,ba.post_suc,ba.post_fail);
          }
      });
    },
    /*
     * 功能：初始化页面
     * 参数：无
     */
    IniPage:function(){
        this.a();
        this.b();
        this.c();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="100"){
        feedbackController.IniPage();
    }
});
