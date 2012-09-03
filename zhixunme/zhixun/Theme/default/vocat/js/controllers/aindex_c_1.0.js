/*
 * 猎头首页控制器
 */
var AindexController={
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻译插件绑定id
     * func:翻页回调函数
     */
    b:function(t,id,func){
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
     * 功能：获取简历列表数据
     * 参数：
     * 无
     */
    c:function(i){
        var that=aindexRender;
        AindexController.e(i, that.a, that.b);
    },
    /*
     * 功能：建立列表分页回调函数
     * 参数：
     * 无
     */
    d:function(i){
        var that=aindexRender;
        AindexController.e(i, that.d, that.b);
        that.c();
    },
    /*
     * 功能：获取简历列表数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    e:function(i,suc,fail){
        var c=$("#talfilter span.filt_type a.red").attr("tp"),
        e=$("#talfilter span.filt_role a.red").attr("rol");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var rec=new Recommend();
        rec.AGetRecTalents(i, CONSTANT.C0004, c, "0", e, "", "", suc, fail);
    },
    /*
     * 功能：猎头首页 推荐人才 排序方式点击事件绑定
     * 参数：
     * 无
     */
    f:function(){
        $("#talfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            AindexController.c(0);
        });
    },
    /*
     * 功能：获取推荐的职位列表
     * 参数：
     * 无
     */
    g:function(i){
        var that=aindexRender;
        AindexController.i(i, that.f, that.g);
    },
    /*
     * 功能：推荐的职位列表分页回调函数
     * 参数：
     * 无
     */
    h:function(i){
        var that=aindexRender;
        AindexController.i(i, that.h, that.g);
        that.c();
    },
    /*
     * 功能：获取推荐的职位数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    i:function(i,suc,fail){
        var par=$("#jobfilter");
        var c=par.find("span.filt_type a.red").attr("tp"),
        e=par.find("span.filt_role a.red").attr("rol");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var rec=new Recommend();
        rec.AGetRecJobs(i, CONSTANT.C0004, c, "0", e, "", "", suc, fail);
    },
    /*
     * 功能：猎头首页 推荐的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    j:function(){
        $("#jobfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            AindexController.g(0);
        });
    },
    /*
     * 功能：猎头首页 推荐的职位 投递简历
     * 参数：
     * 无
     */
    k:function(){
        $("#joblist a.uoper").hgsShowCard({
            accurl:WEBURL.ASendResumes,
            dataurl:WEBURL.GetAResumes,
            getcat:function(o){
                var cat=$(o).parent().parent().prev().find("a.jtitle").prev().text();
                if(cat=="[兼职]"){
                    cat="2";
                }else{
                    cat="1";
                }
                return cat;
            },
            getjid:function(o){
                return $(o).parent().parent().prev().find("a.jtitle").attr("jid");
            }
        });
    },
    /*
     * 功能：猎头首页 推荐的人才 邀请简历
     * 参数：
     * 无
     */
    l:function(){
        $("#talentlist a.uoper").hgsShowJobCard({
            accurl:WEBURL.AInviteResumes,
            dataurl:WEBURL.AGetCanInvitJob,
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
    /************************************* 推荐企业 ****************************************/
    /*
     * 功能：初始化地区筛选
     * 参数：
     * 无
     */
    m:function(){
        var that=$("#plafilter");
        that.data("pid","0");
        that.data("cid","0");
        that.hgsSelect({
            type:"place",//选择框类型
            pid:"fplace",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:false,//是否只精确到省
            single:true,  //是否为单选
            sure:aindexRender.j
        });
    },
    /*
     * 功能：初始化推荐企业列表
     * 参数：
     * 无
     */
    n:function(i){
        var that=aindexRender;
        AindexController.p(i, that.k, that.l);
    },
    /*
     * 功能：推荐企业列表 分页回调函数
     * 参数：
     * 无
     */
    o:function(i){
        var that=aindexRender;
        AindexController.p(i, that.m, that.l);
        that.c();
    },
    /*
     * 功能：获取推荐企业列表数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    p:function(i,suc,fail){
        var par=$("#plafilter");
        var a=par.data("pid"),
        b=par.data("cid");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var rec=new Recommend();
        rec.GetRecCompany(a, b, i, CONSTANT.C0004, suc, fail);
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(0);
        //需权限控制的操作
        this.c(0);
        this.f();
        this.g(0);
        this.j();
        this.m();
        this.n(0);
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="35"){
        //初始化页面js等
        AindexController.IniPage();
    }
});
