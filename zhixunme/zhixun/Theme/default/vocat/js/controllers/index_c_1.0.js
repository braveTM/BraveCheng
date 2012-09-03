/* 
 * 首页控制器
 */

ENTERTIMER1=[],
ENTERTIMER2=[],
ENTERTIMER=null;
var indexController={
    /*
     *功能：初始化文本输入框
     *参数：无
     */
    a:function(){
        $("input,textarea").not("#inbox").val("");  
        if($.browser.mozilla){
            var inp=$("input[type='text'],textarea");
            $.each(inp,function(i,o){
                var a=$(o);
                a.val(a[0].defaultValue);
            });
        }
    },
    /*
     * 功能：验证用户名
     * 参数：
     * 无
     */
    b:function(){
        $("#uname").focus(function(){
            $(this).css("border-color","#0171CA");
            $(this).removeClass("error");
            if($(this).next('span').length>0){
                $(this).next('span').remove();
            }
            if($("#upsd").val()!=""){
                $("#err_msg").text("");
            }else{
                if($("#upsd").hasClass("error")){
                   $("#err_msg").text(LANGUAGE.L0010);
                }else{
                    $("#err_msg").text(""); 
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
        this.IBtnBind("div.btn6", "btn6", "btn6_hov", "btn6_click");
    },
    /*
     * 功能：按钮通用事件绑定
     * 参数：
     * id：按钮id(即div.btn的id)
     * btn_com：正常状态下按钮样式
     * btn_over：移入时按钮的样式
     * btn_click：点击时按钮的样式
     */
    IBtnBind:function(id,btn_com,btn_over,btn_click){
        $(id).unbind().bind({
            mouseenter:function(){
                indexRender.IBtnChangeBg(this,btn_com,btn_over);
            },
            mouseleave:function(){
                indexRender.IBtnChangeBg(this,btn_over,btn_com,btn_click);
            },
            click:function(){
                indexRender.IBtnChangeBg(this,btn_over,btn_click);
            }
        });
    },
    /*
     * 功能：验证密码
     * 参数：
     * 无
     */
    c:function(){
        $("#upsd").focus(function(){
            $(this).css("border-color","#0171CA");
            $(this).removeClass("error");
            if($(this).next('span').length>0){
                $(this).next('span').remove();
            }
            if($("#uname").val()!=""){
                $("#err_msg").text("");
            }else{
                if($("#uname").hasClass("error")){
                     $("#err_msg").text(LANGUAGE.L0231);
                }else{
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
        $("div.login_box").fadeIn();
    },
    /*
     * 功能：登录
     * 参数：
     * 无
     */
    d:function(){
        $("#login").click(function(){
            indexController.da(this);
        });
    },
    /*
     * 功能：登录
     * 参数：
     * 无
     */
    da:function(obj){
        var str=$("#uname").val().replace(new RegExp(" ","g"),"");
        var str1=$("#upsd").val().replace(new RegExp(" ","g"),"");
       if(str==""&&str1==""&&!$("#uname").hasClass("error")&&!$("#upsd").hasClass("error")){
          $("#uname").focus().trigger("blur");  
        }else if(str==""){
            $("#uname").focus().trigger("blur");
        }else if(str1==""){
            $("#upsd").focus().trigger("blur");
        }
        if($(obj).parent().parent().find("input.error").length==0){
            $("#err_msg").html('正在登录...');
            var rem=0;
            if($("input[name='cache']").attr("checked")){
                rem=1;
            }
            var uname=$("#uname").val();
            var pwd=$("#upsd").val();
            var u=$(obj).attr("ru");
            var that=indexRender;
            var ac=new AccountCat();
            ac.Login(rem, uname, pwd, u, that.c, that.d);
        }
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
            if(event.keyCode==13&&(aid=="uname"||aid=="upsd")){
                var that=$("#login");
                indexController.da(that);
            }
        });
    },
    /*
     * 功能：企业墙随机随机播放
     * 参数：
     * 无
     */
    h:function(){
        clearInterval(ENTERTIMER);
        ENTERTIMER=setInterval(function(){
            var par=$("#fenterprise");
            var cur=par.find("li.cur_li div.box_ct");
            if(cur.length==0){
                par.find("li:eq(0)").addClass("cur_li");
            }
            par.find("li.cur_li").removeClass("cur_li").find("div.box_ct")
            .animate({
                'opacity':'0'
            },500,function(){
                var mat=Math;
                var random=mat.floor(mat.random()*9);//获取0-10之间的随机整数
                par.find("li").removeClass("cur_li").find("div.box_ct").css("opacity","0");
                par.find("li:eq("+random+")").addClass("cur_li").find("div.box_ct").animate({
                    'opacity':'1'
                },500);
            });
        },2000);
    },
    /*
     * 功能：查看企业信息
     * 参数：
     * 无
     */
    i:function(){
        var tt=indexRender;
        $("#fenterprise li").each(function(index){
            $(this).hover(
                function(){
                    var _self = this;
                    clearTimeout(ENTERTIMER2[index]);
                    ENTERTIMER1[index] = setTimeout(function() {
                        tt.e(_self);
                    }, 400);
                },
                function(){
                    var _self = this;
                    clearTimeout(ENTERTIMER1[index]);
                    ENTERTIMER2[index] = setTimeout(function() {
                        tt.f(_self);
                    }, 400);
                }

                );
        });
    },
    /*
     *功能：大首页幻灯片
     *参数：无
     */
    j:function(){
        var currentIndex = 0,
        that=indexController,
        timeInterval = 5000,t=0;
        var timer=setInterval( function(){
            currentIndex=that.l(currentIndex);
        }, timeInterval);
        var ctroler=$("div.lp ul").find("li");
        ctroler.hover(function(){
            if(!$(this).hasClass("sel")){
                clearInterval(timer);
                clearTimeout(t);
                $(this).siblings("li").removeClass("sel");
                $(this).addClass("sel");                                                                
                var ind=$(this).attr("rel")*1-1;
                t=setTimeout("currentIndex=indexController.l("+ind+",800)",200);                       
                timer=0;
            }
            if(!timer){
                timer=setInterval( function(){
                    currentIndex=that.l(currentIndex);
                }, timeInterval);
            }        
    });     
    },
    /*
     *功能：动态添加背景
     *参数：无
     */
    k:function(){
        $("div.list_tl:even").addClass("tbg");
    },
    /*
     *功能：幻灯片放映
     *参数：无
     */
    l:function(currentIndex,t1){
        var slides =$("#py li" ),
        newIndex=currentIndex + 1 ,
        newSlide=slides.eq( newIndex );        
        t1=t1||1000;
        if (!newSlide.length){
            newSlide=slides.eq( 0 );
            newIndex=0;
        }
        if(t1==1000){
            slides.eq(currentIndex)
            .fadeOut(t1);
            newSlide.fadeIn(t1);
            indexController.m(newSlide);
        }else{
            var slid=$("#py li.cur");                        
            slid.fadeOut(t1,function(){
                slid.removeClass("cur");
                newSlide.addClass("cur");               
            });
             newSlide.fadeIn(t1);            
        }        
        currentIndex = newIndex;   
        return currentIndex;
    },
    /*
    *功能：索引切换
    *参数:obj当前元素
    */
    m:function(obj){
        var index=obj.attr("rel");   
        obj.siblings("li").removeClass("cur");
        obj.addClass("cur");                     
        $("div.lp ul").find("li").removeClass("sel");
        $(".s"+index).addClass("sel");
    },
    /*
     *功能：初始化职位搜索框
     *参数：无
     *新增
     *@jack 2012-7-20
     */
    n:function(){
        $("#inbox").focus(function(){
            if($(this).hasClass("gray")){
                $(this).val("").removeClass("gray");
            }
        }).keydown(function(e){
            if(e.keyCode=="13"){
             indexController.p();
            }
        }).blur(function(){
            var msg="请输入您要找的职位";
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                 $(this).addClass("gray").val(msg); 
            }
        });
    },
	  
     /*
     *功能：职位搜索框关键字传递
     *参数：无
     *新增
     *@jack 2012-7-23
     */
   o:function(){
       $("#spo").bind("click",function(e){           
           indexController.p();     
      });
   },
   /*
    *功能：处理搜索
    *参数：无
    *@jack 2012-7-24
   */
  p:function(){
         var str=$("#inbox").val().replace(new RegExp(" ","g"),"");
            if(str!=""&& !$("#inbox").hasClass("gray")){
                location.href=WEBROOT+"search_job?word="+str+"";
            }else{
                $("#inbox").trigger("focus");
            }
  },
    /*
     * 功能：初始化首页
     * 参数：
     * 无
     */
    IniPage:function(){
        this.a();
        this.b();
        this.c();
        this.d();
        this.f();
        this.g();
        //this.h();
        this.i();
        this.j();
        this.k();
        this.n();
        this.o();
    }
//baseRender.OperTipShow("操作失败！","error");
/*举例
        $("#id").bind("click",function(){
            //event.stopPropagation(); 该方法阻止事件传递，但不阻止元素默认事件，如<a>的跳转
            //return false;该方法阻止事件传递，同时也阻止元素的默认事件
            //event.preventDefault();相反的，该方法组织元素的默认事件，但不阻止事件传递
            indexController.func1();
        });
        */
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    PAGE=$("#loader").html().replace(/[\n\r]/gm,'').replace(" ","");
    //根据PAGE来初始化页面
    if(PAGE=="0"||PAGE=="3"){
        //初始化页面js等
        indexController.IniPage();
    }
});