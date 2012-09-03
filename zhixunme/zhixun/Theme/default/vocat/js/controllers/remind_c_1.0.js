/*
 * 提醒设置页面控制器
 */
var remindController={
   /*
    *功能：初始化按钮和选择提醒设置单位事件
    *参数：无
    */
   a:function(obj){
     $(obj).unbind("click").bind("click",function(){
         var par=$(this).next().find("ul");
         par.slideDown(300); 
         par.find("li").unbind("click").bind("click",function(){
              $(this).parent().find(".cur").removeClass("cur");
              $(this).addClass("cur");
              var tt=$(this).text();
              $(this).parent().parent().prev().prev().text(tt);
                 $(this).parent().parent().prev().trigger("click");
         });
        remindController.b(this);
     }); 
   },
   /*
    *功能收起提醒设置单位
    *参数：无
    */
   b:function(obj){
       $(obj).unbind("click").bind("click",function(){
         $(this).next().find("ul").slideUp(300);
          remindController.a(this);
          $(this).prev().prev().trigger("blur");
       });
   },
   /*
    *功能：初始化按钮效果
    *参数：无
    */
   c:function(){
        baseController.BtnBind(".btn4", "btn4", "btn4_hov", "btn4_click");  
   },
   /*
    *功能：保存提醒设置方式
    *参数：无
    */
   d:function(){
     $("#rem_sv").bind("click",function(){
         $("input.inbox").trigger("blur");
         var cid1=$("p.pv1").attr("val");//企业汇款id
         var m1="";//提醒时间
         var b1="";//提醒时间单位
         var n1=$("input.ibox_1").val();
         var t1=$("input.ibox_1").next().text().replace(new RegExp(" ","g"),"");
         if(t1=="天"){
             t1="day";
         }else if(t1=="月"){
             t1="month";
         }else{
             t1="week";
         }
         var par=$("input[name='wd_1']:checked").length;
         if(par=="0"){
             m1="0";
             b1="0"+","+"0";
         }else if($("input[name='wd_1']:checked").val()=="0"){
             m1="now";
             b1="0"+","+"0";
         }else{
            m1="before";
            if(n1==""){
               b1="0"+","+"0";
            }else{
               b1=n1+","+t1;  
            }
         }
         var method1;
         if($("input[name='mthod_1']:checked").length=="0"){
             method1="0";
         }else{
            method1=$("input[name='mthod_1']:checked").val();
         }
         var cid2=$("p.pv2").attr("val");//企业汇款id
         var m2="";//提醒时间
         var b2="";//提醒时间单位
         var n2=$("input.ibox_2").val();
         var t2=$("input.ibox_2").next().text().replace(new RegExp(" ","g"),"");
         if(t2=="天"){
             t2="day";
         }else if(t2=="月"){
             t2="month";
         }else{
             t2="week";
         }
         var par1=$("input[name='wd_2']:checked").length;
         if(par1=="0"){
             m2="0";
             b2="0"+","+"0";
         }else if($("input[name='wd_2']:checked").val()=="0"){
             m2="now";
             b2="0"+","+"0";
         }else{
            m2="before";
            if(n2==""){
             b2="0"+","+"0";
            }else{
               b2=n2+","+t2;  
            }
         }
         var method2;
         if($("input[name='mthod_2']:checked").length=="0"){
             method2="0";
         }else{
            method2=$("input[name='mthod_2']:checked").val();
         }
         var cid3=$("p.pv3").attr("val");//企业汇款id
         var m3="";//提醒时间
         var b3="";//提醒时间单位
         var n3=$("input.ibox_3").val();
         var t3=$("input.ibox_3").next().text().replace(new RegExp(" ","g"),"");
         if(t3=="天"){
             t3="day";
         }else if(t3=="月"){
             t3="month";
         }else{
             t3="week";
         }
         var par2=$("input[name='wd_3']:checked").length;
         if(par2=="0"){
             m3="0";
             b3="0"+","+"0";
         }else if($("input[name='wd_3']:checked").val()=="0"){
             m3="now";
             b3="0"+","+"0";
         }else{
            m3="before";
            if(n3==""){
             b3="0"+","+"0";
            }else{
               b3=n3+","+t3;  
            }
         }
         var method3;
         if($("input[name='mthod_3']:checked").length=="0"){
             method3="0";
         }else{
            method3=$("input[name='mthod_3']:checked").val();
         }
         var cid4=$("p.pv4").attr("val");//企业汇款id
         var m4="";//提醒时间
         var b4="";//提醒时间单位
         var n4=$("input.ibox_4").val();
         var t4=$("input.ibox_4").next().text().replace(new RegExp(" ","g"),"");
         if(t4=="天"){
             t4="day";
         }else if(t4=="月"){
             t4="month";
         }else{
             t4="week";
         }
         var par3=$("input[name='wd_4']:checked").length;
         if(par3=="0"){
             m4="0";
             b4="0"+','+"0";
         }else if($("input[name='wd_4']:checked").val()=="0"){
             m4="now";
             b4="0"+','+"0";
         }else{
             m4="before";
            if(n4==""){
             b4="0"+','+"0";
            }else{
               b4=n4+","+t4;  
            }
         }
         var method4;
         if($("input[name='mthod_4']:checked").length=="0"){
             method4="0";
         }else{
            method4=$("input[name='mthod_4']:checked").val();
         }
         var notice=cid1+","+m1+","+b1+","+method1+";"+cid2+","+m2+","+b2+","+method2+";"+cid3+","+m3+","+b3+","+method3+";"+cid4+","+m4+","+b4+","+method4;
         var that=remindRender;
         var len2=$("input[type='radio']:checked").length;
         if(len2=="0"){
             alert(LANGUAGE.L0243);
             return false;
         }else{
            var rt=remindController;
            var ac=new AccountCat();
            var bl4=rt.f(4);
            var bl3=rt.f(3);
            var bl2=rt.f(2);
            var bl1=rt.f(1);
            if(bl1==true&&bl2==true&&bl3==true&&bl4==true&&$("div.error").length=="0"){
                ac.SveAgentRemind(notice,that.succ,that.fail);
            }
         }
     });  
   },
   /*
    *功能：初始化判断时间输入框
    *参数：无
    */
   e:function(){
     $.each($("input.inbox"),function(i,o){
         $(o).focus(function(){
             baseRender.b(this); 
        }).blur(function(){
            var msg=$(this).next().text().replace(new RegExp(" ","g"),""); 
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            var mg="";
            var bl=true;
          if($(this).prev().prev("input[type='radio']:checked").length!="0"){
            if(str==""){
                if(msg=="天"){
                mg=LANGUAGE.L0240;
                bl=false;   
                }else if(msg=="周"){
                mg=LANGUAGE.L0241;
                bl=false;  
                }else if(msg=="月"){
                mg=LANGUAGE.L0242;
                bl=false;
                }
            }
            else if(!/^(\-?)(\d+)$/.test(str)){
                mg=LANGUAGE.L0236;
                bl=false;
            }else if(msg=="天"){
                if(parseInt(str,10)>31){
                   mg=LANGUAGE.L0237;
                   bl=false;  
                }
            } else if(msg=="周"){
                if(parseInt(str,10)>5){
                   mg=LANGUAGE.L0238;
                   bl=false;  
                }
            } else if(msg=="月"){
                if(parseInt(str,10)>12){
                   mg=LANGUAGE.L0239;
                   bl=false;  
                }
            } 
            if(!bl){
                 baseRender.a(this, mg, "error");
            }
          }
        });
     });
   },
   /*
   *功能：验证各设置
   *参数：无
   */
   f:function(i){
    var bl=true;
    var x=$("input[name='wd_"+i+"']:checked");
    var y=$("input[name='mthod_"+i+"']:checked");
    var a=x.length;
    var b=y.length;
    var c=i-1;
    var tex=$("div.md_com:eq("+c+")").find("p.pv"+i+"").text();
    if(a=="0"&&b!="0"){
        bl=false;
        alert("请设置"+tex+"的提醒时间");
    }else if(a!="0"&&b=="0"){
        bl=false;
        alert("请设置"+tex+"的提醒方式");
    }else {
        bl=true;
    }
     return bl;
   },
   /*
    *功能：初始化页面状态
    *参数：无
    */
   ga:function(){
       var r=remindController;
       r.g(1);
       r.g(2);
       r.g(3);
       r.g(4);
   },
   /*
    *功能：初始化页面单选框
    *参数：无
    */
   g:function(key){
       var c1=$("#t_"+key+"").val();
       var p=$("input[name='wd_"+key+"']");
       var c2=$("#m_"+key+"").val();
       var m=$("input[name='mthod_"+key+"']");
       $.each(p,function(i,o){
          var pv=$(o).val();
          if(c1=="before"&&pv=="1"){
              $(o).attr("checked",true);
          }else if(c1=="now"&&pv=="0"){
             $(o).attr("checked",true);
          }
       });
       $.each(m, function(i,o){
           var mv=$(o).val();
           if(c2==mv){
               $(o).attr("checked",true);
           }
       });
       
   },
   /*
    *功能：初始化页面
    *参数：无
    */
   IniPage:function(){
       this.a("a.gt_m");
       this.c();
       this.d();
       this.e();
       this.ga();
   }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="106"){
        //初始化页面js等
        remindController.IniPage();
    }
});
