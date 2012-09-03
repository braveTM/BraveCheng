/*
 * 博客控制器
 */
var BlogController={
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻译插件绑定id
     * func:翻页回调函数
     */
    a:function(t,id,func){
        var lan=LANGUAGE;
        $(id).pagination(t, {
            callback: func,
            prev_text: lan.L0066,
            next_text: lan.L0067,
            items_per_page:CONSTANT.C0004,
            num_display_entries:9,
            current_page:0,
            num_edge_entries:1,
            link_to:"javascript:;"
        });
    },
    /*
     * 功能：获取猎头行业心得列表
     * 参数：
     * 无
     */
    b:function(i){
        var that=blogRender;
        BlogController.d(i, that.a, that.b);
    },
    /*
     * 功能：猎头行业心得列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=blogRender;
        BlogController.d(i, that.d, that.b);
        that.c();
    },
    /*
     * 功能：获取猎头行业心得列表数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(i,suc,fail){
        var a=$("#amfilter span.filt_status a.red").attr("st");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var info=new Information();
        info.AGetBlogs(i, CONSTANT.C0004, a, suc, fail);
    },
    /*
     * 功能：发布行业心得
     * 参数：
     * 无
     */
    e:function(){
        var base=baseController;
        base.BtnBind("div.blogpublish div.layout1_r div.btn5","btn5","btn5_hov","btn5_click");
        base.BtnBind("div.blogpublish div.layout1_r div.btn8","btn5","btn8_hov","btn8_click");
        $("#checknow,#savenow").click(function(){
            var a=$("#art_title").val(),
            b=$("#acontent").val().replace(/[\n\r]/gm,'<br/>').replace(new RegExp(" ","g"),"{nbsp}"),
            c=$(this).attr("st"),
            d=$("#art_src").val();
            var tar=$("#art_title");
            var bl=true;
            if(a==""){
                alert("标题不能为空!");
                bl=false;
            }else if(b==""){
                tar=$("#acontent");
                alert("内容不能为空!");
                bl=false;
            }
            if(!bl){
                $("html,body").animate({
                    scrollTop:tar.offset().top-70
                },500);
                tar.focus();
                return false;
            }
            var that=blogRender;
            var info=new Information();
            var id=$("#isbid").val();
            if(id==""){
                info.CreateBlog(a,b,c,d,that.f,that.g);
            }else{
                info.AUpdateBlog(id, a, b, c, d,that.f,that.g);
            }
        });
    },
    /*
     * 功能：猎头行业心得管理 - 条件筛选
     * 参数：
     * i:当前页
     */
    f:function(){
        $("#amfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            BlogController.b(0);
            blogRender.c();
        });
    },
    /*
     * 功能：猎头行业心得管理 - 删除
     * 参数：
     * 无
     */
    g:function(){
        $("#amlist li div.fv_cl a.dele").unbind("click").bind("click",function(){
            if(confirm(LANGUAGE.L0048)){
                var a=$(this).parent().attr("bid");
                $("#amlist").data("cur",a);
                var that=blogRender;
                var info=new Information();
                info.ADeleBlog(a,that.h,that.g);
            }
        });
    },
    /*
     * 功能：猎头行业心得管理 - 提交审核
     * 参数：
     * 无
     */
    h:function(){
        $("#amlist li div.fv_cl a.blue").unbind("click").bind("click",function(){
            var a=$(this).parent().attr("bid");
            $("#amlist").data("cur",a);
            var that=blogRender;
            var info=new Information();
            info.AValidateBlog(a,that.i,that.g);
        });
    },
    /*
     * 功能：猎头行业心得管理 - 提交审核
     * 参数：
     * 无
     */
    i:function(){
        var cont=$("#infocontent").val().replace(new RegExp("{nbsp}","g")," ").replace(new RegExp("<br/>","g"),"\n");
       $("#acontent").val(cont);
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(0);
    },
    /*
     * 功能：心得发布页
     * 参数：
     * 无
     */
    IniPage1:function(){
        baseRender.ae(0);
        this.i();
        this.e();
    },
    /*
     * 功能：心得管理页
     * 参数：
     * 无
     */
    IniPage2:function(){
        baseRender.ae(0);
        this.b(0);
        this.f();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    if(PAGE=="89"){
        BlogController.IniPage();
    }
    if(PAGE=="90"){
        BlogController.IniPage1();
    }
    if(PAGE=="91"){
        BlogController.IniPage2();
    }
});
