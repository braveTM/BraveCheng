/*
 * 企业找人才
 */
var EfindtalentController={
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
     * 功能：获取可能感兴趣的人才列表数据
     * 参数：
     * 无
     */
    b:function(i){
        var that=comfindtalRender;
        EfindtalentController.d(i, that.a, that.b);
    },
    /*
     * 功能：可能感兴趣的人才列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=comfindtalRender;
        EfindtalentController.d(i, that.d, that.b);
        that.c();
    },
    /*
     * 功能：获取可能感兴趣的人才列表数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(i,suc,fail){
        var c=$("#talfilter span.filt_type a.red").attr("tp"),
        e=$("#talfilter span.filt_role a.red").attr("rol");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var pl=new Pool();
        pl.ComGetTalentList(i, c, "0", e, "", "", CONSTANT.C0004, suc, fail);
    },
    /*
     * 功能：可能感兴趣的人才 排序方式点击事件绑定
     * 参数：
     * 无
     */
    e:function(){
        $("#talfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            EfindtalentController.b(0);
        });
    },
    /*
     * 功能：可能感兴趣的人才 邀请简历
     * 参数：
     * 无
     */
    f:function(){
        $("#talentlist a.uoper").hgsShowJobCard({
            accurl:WEBURL.EInvitResume,
            dataurl:WEBURL.EGetCanInvitJob,
            getcat:function(o){
                var cat=$(o).parent().parent().prev().find("a.jtitle").prev().text();
                if(cat=="[兼职]"){
                    cat="2";
                }else{
                    cat="1";
                }
                return cat;
            },
            getrid:function(o){
                return $(o).parent().parent().prev().find("a.jtitle").attr("rid");
            }
        });
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(2);
        this.b(0);
        this.e();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="37"){
        //初始化页面js等
        EfindtalentController.IniPage();
    }
});
