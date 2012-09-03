/*
 * 人才首页控制器
 */
var EIndexController={
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
     * 功能：获取推荐人才列表
     * 参数：
     * 无
     */
    b:function(i){
        var that=eindexRender;
        EIndexController.d(i, that.b, that.c);
    },
    /*
     * 功能：推荐人才列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=eindexRender;
        EIndexController.d(i, that.d, that.c);
        that.a();
    },
    /*
     * 功能：获取推荐人才数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(i,suc,fail){
        var par=$("#talfilter");
        var c=par.find("span.filt_type a.red").attr("tp"),
        e=par.find("span.filt_role a.red").attr("rol");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var rec=new Recommend();
        rec.EGetRecTalents(i, CONSTANT.C0004, c, "0", e, "", "", suc, fail);
    },
    /*
     * 功能：猎头首页 推荐人才 排序方式点击事件绑定
     * 参数：
     * 无
     */
    e:function(){
        $("#talfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            EIndexController.b(0);
        });
    },
    /*
     * 功能：企业首页 推荐的人才 邀请简历
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
    /************************************* 推荐猎头 ****************************************/
    /*
     * 功能：初始化地区筛选
     * 参数：
     * 无
     */
    g:function(){
        var that=$("#from_area");
        that.data("pid","0");
        that.data("cid","0");
        that.hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"epslt",            //省市添加的父容器id
            pshow:true,       //是否显示地区选择
            lishow:true,    //是否显示不限省份
            sprov:false,       //是否只精确到省
            single:true,     //省是否为单选
            sure:eindexRender.l
        });
    },
    /*
     * 功能：获取猎头列表数据
     * 参数：
     * 无
     */
    h:function(i){
        var that=eindexRender;
        EIndexController.j(i,that.m, that.n);
    },
    /*
     * 功能：获取猎头列表分页回调函数
     * 参数：
     * 无
     */
    i:function(i){
        var that=eindexRender;
        EIndexController.j(i, that.o, that.n);
        that.a();
    },
    /*
     * 功能：获取猎头列表数据
     * 参数：
     * i：当前页
     * suc：成功获取数据时的方法
     * fail：失败获取数据时的方法
     */
    j:function(i,suc,fail){
        var par=$("#from_area");
        var b=$("#rolefilter span.filt_role a.red").attr("rel"),
        c=par.data("pid"),
        d=par.data("cid");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var rec=new Recommend();
        rec.GetRecAgent(0, b, c, d, i, CONSTANT.C0004, suc, fail);
    },
    /*
     * 功能：猎头性质条件筛选查询
     * 参数：
     * jack
     * 2012-2-12
     */
    k:function(){
        $("#rolefilter span.filt_role a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            EIndexController.h(0);
        });
    },
    /*
     * 功能：初始化委托职位按钮
     * 参数：
     * 无
     */
    l:function(obj){
        if($(obj).length>0){
            $(obj).bind("click",function(){
                var that=eindexRender;
                var aid=$(this).attr("rel");
                $("#recagent").data("aid",aid);
                var job=new Jobs();
                job.GetCDJobs(that.q, that.r);
            });
        }
    },
    /*
     * 功能：委托职位付费提示
     * 参数：
     * b：职位id
     */
    m:function(b){
        paytipController.CDeleJobTip(EIndexController.ma, [b], "#recagent a.position_delgate");
    },
    /*
     * 功能：委托职位
     * 参数：
     * b：职位id
     */
    ma:function(b){
        var a=$("#recagent").data("aid");
        var that=eindexRender;
        var jb=new Jobs();
        jb.DeleJobs(a, b[0], that.s, that.t);
    },
    /*
     * 功能：获取委托职位id后再委托职位
     * 参数：
     * 无
     */
    n:function(){
        var b=$("#cdres_list").find("li input[name='sjob']:checked").parent().attr("jid");
        EIndexController.m(b);
    },
    /*
     * 功能：初始化首页
     * 参数：无
     */
    IniPage:function(){
        baseRender.ae(0);
        this.b(0);
        this.e();
        this.g();
        this.h(0);
        this.k();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="34"){
        //初始化页面js等
        EIndexController.IniPage();
    }
});