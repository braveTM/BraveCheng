/*
 * 我的套餐控制器
 */
var packageController={
    /*
     * 功能：立即购买套餐
     * 参数：
     * 无
     */
    a:function(){
        $("#pac_items a.buynow").click(function(){
            var lan=LANGUAGE;
            var cur=this;
            var msg;
            if(PAGE==119)//猎头
              msg=lan.L0216.replace("{score}",$(this).parent().parent().find("div.mid_bg div.mid p.score span em.red").text());
            else
              msg=lan.L0216.replace("{score}",$(this).parent().parent().find("div.mid_bg div.mid p.score span").text());
            baseController.InitialSureDialog("error", msg, "suretobuy", lan.L0217);
            $("#suretobuy").unbind("click").bind("click",function(){
                if(!$(this).hasClass("clicked")){
                    $(this).addClass("clicked");
                    var a=$(cur).attr("pid");
                    var that=packageRender;
                    var bl=new Bill();
                    bl.BuyPackage(a, that.a, that.b);
                    $(this).parent().parent().parent().parent().parent().parent().fadeOut(200);
                }
            });
            $("#suretobuy").parent().parent().next().click(function(){
                $("#suretobuy").removeClass("clicked");
                $(cur).removeClass("clicked");
            });
        });
    },
    /*
     * 功能：套餐续费
     * 参数：
     * 无
     */
    b:function(){
        $("#pac_items a.renew,#fcharge_now").click(function(){
            var lan=LANGUAGE;
            var cur=this;
            var score;
            if(PAGE==119)//猎头
              score=$(this).parent().parent().find("div.mid_bg div.mid p.score span em.red").text();
            else
              score=$(this).parent().parent().find("div.mid_bg div.mid p.score span").text(); 
            score=(!!score?score:$(this).attr("score"));
            var msg=lan.L0218.replace("{score}",score);
            baseController.InitialSureDialog("error", msg, "suretorenew", lan.L0219);
            $("#suretorenew").unbind("click").bind("click",function(){
                if(!$(this).hasClass("clicked")){
                    $(this).addClass("clicked");
                    var that=packageRender;
                    var bl=new Bill();
                    bl.RenewPackage(that.c, that.b);
                    $(this).parent().parent().parent().parent().parent().parent().fadeOut(200);
                }
            });
            $("#suretorenew").parent().parent().next().click(function(){
                $("#suretorenew").removeClass("clicked");
                $(cur).removeClass("clicked");
            });
        });
    },
    /*
     * 功能：积分续费
     * 参数：
     * 无
     */
    ba:function(){
        $("#pac_items a.rechange").click(function(){
            var lan=LANGUAGE;
            var cur=this;
            var score=$(this).parent().parent().find("div.mid_bg div.mid p.score span em.red").text().replace("￥",'');
            score=(!!score?score:$(this).attr("score"));
            var msg=lan.L0253.replace("{score}",score);
            baseController.InitialSureDialog("error", msg, "rechange", lan.L0252);
            $("#rechange").unbind("click").bind("click",function(){
                if(!$(this).hasClass("clicked")){
                    $(this).addClass("clicked");
                    var that=packageRender;
                    var bl=new Bill();
                    bl.RechangePackage(that.c, that.ea);
                    $(this).parents("div.sure_dialog").fadeOut(200);
                }
            });
            $("#rechange").parent().parent().next().click(function(){
                $("#rechange").removeClass("clicked");
                $(cur).removeClass("clicked");
            });
        });
    },
    /*
     * 功能：显示套餐卡片
     * 参数：
     * 无
     */
    c:function(){
        var par=$("#pac_items");
        par.find("li.loading").remove();
        par.find("li").css("opacity","1");
    },
    /*
     * 功能：余额不足去充值
     * 参数：
     * 无
     */
    d:function(){
        baseController.InitialSureDialog("error", LANGUAGE.L0229, "chargescore", "立即充值");
        $("#chargescore").unbind("click").bind("click",function(){
            if(!$(this).hasClass("clicked")){
                $(this).addClass("clicked");
                location.href=WEBROOT+'/bill/';
            }
        });
        $("#chargescore").parent().parent().next().click(function(){
            $("#chargescore").removeClass("clicked");
        });
    },
    /*
     * 功能：套餐续费方式选择
     * 参数：
     * 无
     */
    e:function(){
        $("#filter_rec input[name=rechr]").click(function(){
            var index=$(this).attr("id").substring(5);
            var par=$("div.package div.pstat div.rechr_item");
            par.not("div.hidden").addClass("hidden");
            par.eq(index).removeClass("hidden");
        });
    },
    /*
     * 功能：套餐单项续费 - 立即续费
     * 参数：
     * 无
     */
    f:function(){
        $("#scharge_now").click(function(){
            var scr=$("#scr_use");
            scr.trigger("blur");
            if($("table.sin_rechr .error").length==0){
                var lan=LANGUAGE;
                var cur=this;
                var b=scr.val();
                var msg=lan.L0218.replace("{score}",parseInt(b,10)*parseInt(scr.next().next().find("em").text(),10));
                baseController.InitialSureDialog("error", msg, "suretorenew", lan.L0219);
                $("#suretorenew").unbind("click").bind("click",function(){
                    if(!$(this).hasClass("clicked")){
                        $(this).addClass("clicked");
                        var a=$("#schr_item").val();
                        var bl=new Bill();
                        var that=packageRender;
                        bl.RSChrRes(a, b, that.f, that.g);
                        $(this).parent().parent().parent().parent().parent().parent().fadeOut(200);
                    }
                });
                $("#suretorenew").parent().parent().next().click(function(){
                    $("#suretorenew").removeClass("clicked");
                    $(cur).removeClass("clicked");
                });
            }
        });
    },
    /*
     * 功能：套餐单项续费结果获取
     * 参数：
     * 无
     */
    g:function(){
        $("#scr_use").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            var msg='';
            var bl=true;
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                msg=LANGUAGE.L0244;
                bl=false;
            }
            else if(!/^(\-?)(\d+)$/.test(str)){
                msg=LANGUAGE.L0245;
                bl=false;
            }
            if(bl){
                baseRender.b(this);
                var a=$("#schr_item").val();
                var bol=new Bill();
                var that=packageRender;
                bol.GetSChrRes(a, str, that.d, that.e);
            }
            else{
                baseRender.a(this, msg, "error",10);
            }
        });
        $("#scr_use").bind("keyup",function(){
            var a=$("#schr_item").val(),
            b=$(this).val();
            if(!!b){
                var bl=new Bill();
                var that=packageRender;
                bl.GetSChrRes(a, b, that.d, that.e);
            }
        });
    },
    /*
     * 功能：套餐管理 - 单项续费
     * 参数：
     * 无
     */
    i:function(){
        $("#pac_items a.srenew").click(function(){
            baseRender.TabChange($("div.sm_tab ul li:eq(0)"));
            $("#filter_rec input[name=rechr]:eq(0)").trigger("click");
            $("html,body").animate({
                scrollTop:$("#filter_rec").offset().top-60
            },500);
        });
    },
    /*
     * 功能：套餐单项续费 - 续费项选择
     * 参数：
     * 无
     */
    j:function(){
        $("#schr_item").change(function(){
            $("#scr_use").nextAll("div.tip").remove();
            var a=$(this).val();
            var that=packageRender;
            var bl=new Bill();
            bl.GetSChrTips(a, that.h, null);
        });
        $("#schr_item").trigger("change");
    },
    /*
     * 功能：积分换购套餐
     * 参数：
     * @author:joe 2012/7/22
     */
    h:function(){
        $("#pac_items a.change").click(function(){
            var lan=LANGUAGE;
            var cur=this;
            var score=$(this).parent().parent().find("div.mid_bg div.mid p.score span em.red").text().replace("￥",'');
            var msg=lan.L0251.replace("{score}",score);
            baseController.InitialSureDialog("error", msg, "change", lan.L0252);
            $("#change").unbind("click").bind("click",function(){
                if(!$(this).hasClass("clicked")){
                    $(this).addClass("clicked");
                    var a=$(cur).attr("pid");
                    var that=packageRender;
                    var bl=new Bill();
                    bl.ChangePackage(a, that.i, that.j);
                    $(this).parents("div.sure_dialog").fadeOut(200);
                }
            });
            $("#change").parent().parent().next().click(function(){//取消兑换
                $("#change").removeClass("clicked");
                $(cur).removeClass("clicked");
            });
        })
    },
//     /*
//     * 功能：电话拨打通话分钟续费结果获取
//     * 参数：
//     * 无
//     */
//    h:function(){       
//        $("#phone_cz li").unbind("click").bind("click",function(){
//            chr($(this));
//        });
//        function chr(obj){
//            var a=$("#schr_item").val(),            
//            b=obj.find("input").val();
//            $("#scr_use").val(b);
////            if(!!b){
////                var bl=new Bill();
////                var that=packageRender;
////                bl.GetSChrRes(a, b, that.i, that.e);
////            }
//        }
//    },
    /* 功能：获取电话充值续费面值请求
     * 参数：
     * data：后台返回数据
     */
//    k:function(){
//        var bl=new Bill();
//        var that=packageRender;        
//        bl.GetFaceValue(that.j,that.k);
//    },
    /*
     * 功能：初始化首页
     * 参数：无
     * 无
     */
    iniPage:function(){
        baseRender.ae(0);
        this.c();
        this.a();
        this.b();        
        this.e();
        this.g();
        this.j();
        this.f();
        this.i();        
    },
    /*
     * 功能：初始化首页
     * 参数：无
     * 无
     */
    iniPage1:function(){
        this.ba();
        this.h();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="25"){
        //初始化页面js等
        packageController.iniPage();
    }
    if(PAGE=="119"){
        packageController.iniPage();
        packageController.iniPage1();
    }

});