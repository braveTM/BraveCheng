/*
 * 猎头职位管理控制器
 */
var JobfullselfController={
    /*
     * 功能：初始化结束招聘按钮
     * 参数：
     * 无
     */
    a:function(){
        baseController.BtnBind("div.joblistdetail div.btn_par div.btn5", "btn5", "btn5_hov", "btn5_click");
        $("#closejob").bind("click",function(){
            if(confirm("您确定要结束该职位的招聘吗?")){
                var that=jobfullselfRender;
                var a=$("#fullid").attr("jid");
                var job=new Jobs();
                if($("#rt").val()=="3"){
                    job.AEndPubJobs(a, that.f, that.g);
                }else{
                    job.EEndPubJobs(a, that.f, that.g);
                }
            }
        });
    },
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
            items_per_page:CONSTANT.C0003,
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
        var that=jobfullselfRender;
        JobfullselfController.e(i, that.a, that.b);
    },
    /*
     * 功能：建立列表分页回调函数
     * 参数：
     * 无
     */
    d:function(i){
        var that=jobfullselfRender;
        JobfullselfController.e(i, that.d, that.b);
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
        var a=$("#fullid").attr("jid"),
            b=$("#resfilter span.filt_type a.red").attr("rl");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var job=new Jobs();
        if($("#rt").val()=="3"){
            job.AGetResList(a, i, b, suc, fail);
        }else{
            job.EGetResList(a, i, b, suc, fail);
        }
    },
    /*
     * 功能：收到的应聘简历 筛选
     * 参数：
     * 无
     */
    f:function(){
        $("#resfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            JobfullselfController.c(0);
        });
    },
    /*
     * 功能：查看更多职位信息
     * 参数：
     * 无
     */
    g:function(){
        $("#chmore a.m").toggle(function(){
            $(this).text("收起职位信息");
            $("#hd_item").slideDown();
        },function(){
            $(this).text("查看更多职位信息");
            $("#hd_item").slideUp();
        });
    },
     /*
     * 功能：分享绑定
     * 参数：
     * 无
     */
    h:function(obj){              
        $(obj).unbind("click").bind("click",function(){
            var par=$(this);
            var sum=$("div.module_1 div.item"),summary='';            
            sum.each(function(){
                summary+=$(this).find("p").text().trim()+'\n';
            });  
            var type=par.attr("tp"),
                 tit=par.attr("tit"),
                 ur=par.attr("ur");
            zxshare(type,[tit,ur,'',summary]);
        });
    },
     /*
     * 功能：初始化查看联系方式按钮
     * 参数：
     * 无
     */
    j:function(){    
        $("#ckcontact").bind("click",function(){
            var uid='&uid='+$(this).attr("uid");
            paytipController.checkCContactTip(JobfullselfController.ja,null,this,uid);
        });
    },
    /*
     * 功能：查看联系方式
     * 参数：
     * 无
     */
    ja:function(){
        var a=$("#ckcontact").attr("uid");
        var that=jobfullselfRender;
        var ct=new Contacts();
        ct.CheckContWay(a,2,that.i, that.j);
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        this.a();
        this.c(0);
        this.f();
        this.g();
        this.j();
        this.h("#share a.share");
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="58"||PAGE=="49"){
        //初始化页面js等
        JobfullselfController.IniPage();
    }
});
