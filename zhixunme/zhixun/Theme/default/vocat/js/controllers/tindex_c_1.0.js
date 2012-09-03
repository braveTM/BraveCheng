/*
 * 人才首页控制器
 */
var TIndexController={
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
     * 功能：获取推荐的职位列表
     * 参数：
     * 无
     */
    b:function(i){
        var that=tindexRender;
        TIndexController.d(i, that.b, that.c);
    },
    /*
     * 功能：推荐的职位列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=tindexRender;
        TIndexController.d(i, that.d, that.c);
        that.a();
    },
    /*
     * 功能：获取推荐的职位数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(i,suc,fail){
        var par=$("#jobfilter");
        var c=par.find("span.filt_type a.red").attr("tp"),
        e=par.find("span.filt_role a.red").attr("rol");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var rec=new Recommend();
        rec.EGetRecJobs(i, CONSTANT.C0004, c, "0", e, "", "", suc, fail);
    },
    /*
     * 功能：人才首页 推荐的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    e:function(){
        $("#jobfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            TIndexController.b(0);
        });
    },
    /*
     * 功能：人才首页 推荐的职位 投递简历
     * 参数：
     * 无
     */
    f:function(obj){
        var sr=$(obj);
        sr.unbind("click");
        sr.bind("click",function(){
            var a=$(this).parent().parent().prev().find("a.jtitle").attr("jid");
            var that=tindexRender;
            var res=new Resume();
            res.SendResume(a, that.f, that.g);
        });
    },
    /************************************* 推荐企业 ****************************************/
    /*
     * 功能：初始化地区筛选
     * 参数：
     * 无
     */
    g:function(){
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
            sure:tindexRender.h
        });
    },
    /*
     * 功能：初始化推荐企业列表
     * 参数：
     * 无
     */
    h:function(i){
        var that=tindexRender;
        TIndexController.j(i, that.i, that.j);
    },
    /*
     * 功能：推荐企业列表 分页回调函数
     * 参数：
     * 无
     */
    i:function(i){
        var that=tindexRender;
        TIndexController.j(i, that.k, that.j);
        that.a();
    },
    /*
     * 功能：获取推荐企业列表数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    j:function(i,suc,fail){
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
    /************************************* 推荐猎头 ****************************************/
    /*
     * 功能：初始化地区筛选
     * 参数：
     * 无
     */
    k:function(){
        var that=$("#from_area");
        that.data("pid","0");
        that.data("cid","0");
        that.hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"apslt",            //省市添加的父容器id
            pshow:true,       //是否显示地区选择
            lishow:true,    //是否显示不限省份
            sprov:false,       //是否只精确到省
            single:true,     //省是否为单选
            sure:tindexRender.l
        });
    },
    /*
     * 功能：获取猎头列表数据
     * 参数：
     * 无
     */
    l:function(i){
        var that=tindexRender;
        TIndexController.n(i,that.m, that.n);
    },
    /*
     * 功能：获取猎头列表分页回调函数
     * 参数：
     * 无
     */
    m:function(i){
        var that=tindexRender;
        TIndexController.n(i, that.o, that.n);
        that.a();
    },
    /*
     * 功能：可能感兴趣的企业列表数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    n:function(i,suc,fail){
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
     * 无
     */
    o:function(){
        $("#rolefilter span.filt_role a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            TIndexController.l(0);
        });
    },
    /*
     * 功能：人才委托简历
     * 参数：
     * _cur：绑定对象
     */
    p:function(_cur){
        var aid=$(_cur).attr("rel");
        var lan=LANGUAGE,
        that=tindexRender;
        baseController.InitialSureDialog("error", lan.L0195, "select", lan.L0196,that.s);
        $("#select").unbind("click").bind("click",function(){
            var s=$("input[name='reum']:checked").length;
            if(s==0){
                alert('请选择简历类型!');
                return false;
            }else{
                paytipController.TDeleResTip(function(){
                    var t=$("input[name='reum']:checked").val();
                    $("div").data("type",t);
                    var po=new Pool();
                    po.ApplyAgentResme(aid,t,that.q,that.r);
                    $("div.sure_dialog").remove();
                }, null, _cur);
                
            }
        });
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
        this.l(0);
        this.o();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="22"){
        //初始化页面js等
        TIndexController.IniPage();
    }

});