/* 
 * 角色首页功能引导流程控制器
 */
var GuideController={
    /* 
     * 功能：引导流程控制
     * 参数：
     * 无
     */
    a:function(){
        var that=$("#rt_cover");
        if(that){
            var $that=GuideController;
            $that.c();
            $that.d();
            $("#pagin a").click(function(){
                if(that.hasClass("hasover")){
                    $that.c();
                    $that.d();
                    that.removeClass("hasover");
                }
                GuideController.b(this);
            });
        }
    },
    /* 
     * 功能：引导流程步骤控制
     * 参数：
     * 无
     */
    b:function(obj){
        var nw=$(obj);
        var that=$("#rt_cover");
        var old=nw.siblings("a.cur").index();
        var index=nw.index();
        var len=nw.siblings("a").length;
        nw.siblings("a").removeClass("cur");
        nw.addClass("cur");
        that.find("div.guide"+old).fadeOut();
        that.find("div.guide"+index).fadeIn();
        if(index==len+1){
            nw.siblings("span.lspan").html("再看一遍");
            nw.siblings("span.rspan").html("立即体验");
            var ct=GuideController;
            ct.e();
            ct.f();
            that.addClass("hasover");
        }else if(index==1){
            nw.siblings("span.lspan").html("");
            nw.siblings("span.rspan").html("下一个 >");
        }else if(index>1){
            nw.siblings("span.lspan").html("< 上一个");
            nw.siblings("span.rspan").html("下一个 >");
        }
    },
    /* 
     * 功能：上一个
     * 参数：
     * 无
     */
    c:function(){
        $("#pagin span.lspan").unbind("click").bind("click",function(){
            var index=$("#pagin a.cur").index();
            index=index-2;
            GuideController.b($("#pagin a:eq("+index+")"));
        });
    },
    /* 
     * 功能：下一个
     * 参数：
     * 无
     */
    d:function(){
        $("#pagin span.rspan").unbind("click").bind("click",function(){
            var index=$("#pagin a.cur").index();
            GuideController.b($("#pagin a:eq("+index+")"));
        });
    },
    /* 
     * 功能：再看一遍
     * 参数：
     * 无
     */
    e:function(){
        $("#pagin span.lspan").unbind("click").bind("click",function(){
            var that=GuideController;
            that.b($("#pagin a:eq(0)"));
            that.c();
            that.d();
        });
    },
    /* 
     * 功能：立即体验
     * 参数：
     * 无
     */
    f:function(){
        $("#pagin span.rspan").unbind("click").bind("click",function(){
            location.href=WEBROOT+"/";
        });
    },
    /* 
     * 功能：关闭引导流程
     * 参数：
     * 无
     */
    g:function(){
        $("#rt_close").click(function(){
            location.href=WEBROOT+"/";
        });
    },
    /* 
     * 功能：初始化猎头页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(0); 
        this.a();
        this.g();
    }
};
$().ready(function(){   
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }    
    //根据PAGE来初始化页面
    if(PAGE=="115"||PAGE=="116"||PAGE=="117"){
        //初始化页面js等
        GuideController.IniPage();
    }
});
