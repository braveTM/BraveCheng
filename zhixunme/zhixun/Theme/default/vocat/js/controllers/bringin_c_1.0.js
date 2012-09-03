/*
 * 企业职位管理控制器
 */
var BringinController={
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻译插件绑定id
     * func:翻页回调函数
     */
    o:function(t,id,func){
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
     * 功能：获取我发布的职位数据
     * 参数：
     * 无
     */
    p:function(i){
        var that=bringinRender;
        BringinController.r(i, "pubfilter", that.n, that.o);
    },
    /*
     * 功能：我发布的职位分页回调函数
     * 参数：
     * 无
     */
    q:function(i){
        var that=bringinRender;
        BringinController.r(i, "pubfilter", that.p, that.o);
        that.q();
    },
    /*
     * 功能：获取我发布的职位列表数据
     * 参数：
     * i:当前页
     * tid：筛选栏的父容器id
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    r:function(i,tid,suc,fail){
        var par=$("#"+tid);
        var a=par.find("span.filt_type a.red").attr("tp"),
        b=par.find("span.filt_status a.red").attr("st");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var job=new Jobs();
        job.EGetPubJobs(a, b, i, suc, fail);
    },
    /*
     * 功能：我发布的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    s:function(){
        $("#pubfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            BringinController.p(0);
        });
    },
    /*
     * 功能：我发布的职位 立即结束招聘
     * 参数：
     * id：列表id
     */
    t:function(id){
        $(id+" div.oper a.comp").unbind("click");
        $(id+" div.oper a.comp").bind("click",function(){
            BringinController.v(this);
        });
    },
    /*
     * 功能：我发布的职位 收到的简历列表展示
     * 参数：
     * id：列表id
     * cls：是否为两列布局
     */
    u:function(id,cls){
        $("#"+id+" div.info p.rec_res span.red").unbind("click");
        $("#"+id+" div.info p.rec_res span.red").bind("click",function(){
            var res=$(this).parent().parent().parent().find("div.mlist_list");
            var len=res.length;
            if(len>0&&res.css("display")!="none"){
                res.slideUp(200);
            }else{
                if(len==0){
                    var that=bringinRender;
                    that.t(this,id,cls);//初始化父容器
                    var a=$(this).parent().parent().find("p a.jtitle").attr("jid");
                    var job=new Jobs();
                    job.EGetResList(a, 1, "0", that.u, that.m);
                    res=$(this).parent().parent().parent().find("div.mlist_list");
                }
                res.slideDown(300);
            }
        });
    },
    /*
     * 功能:企业 结束招聘
     * 参数：
     * obj：当前a标签
     */
    v:function(obj){
        if(confirm(LANGUAGE.L0179)){
            var that=bringinRender;
            var a=$(obj).attr("rid");
            $("div").data("obj",obj);
            var job=new Jobs();
            job.EEndPubJobs(a,that.s, that.m);
        }
    },
    /*
     *功能：企业-我发布的任务-暂停/继续公开招聘初始化
     *参数：
     *id：当前兵绑定元素
     */
    ebd:function(id){
        $(id+" div.oper a.pausejob").unbind("click").bind("click",function(){
            BringinController.epauseb(this);
        });
        $(id+" div.oper a.continuejob").unbind("click").bind("click",function(){
            BringinController.econtinueb(this);
        });
    },
    /*
     *功能：企业-我发布的职位-暂停公开招聘
     *参数：
     *obj：当前选中元素
     */
    epauseb:function(obj){
        var that=bringinRender;
        $("div").data("obj",obj);
        var a=$(obj).attr("rid");
        var job=new Jobs();
        job.EePauseJob(a,that.ppub,that.m);
    },
    /*
     *功能：企业-我发布的职位-继续公开招聘
     *参数：
     *obj：当前选中元素
     */
    econtinueb:function(obj){
        var that=bringinRender;
        $("div").data("obj",obj);
        var a=$(obj).attr("rid");
        var job=new Jobs();
        job.EeContinueJob(a,that.gopub, that.m);
    },
    /*
     * 功能：获取委托出去的职位数据
     * 参数：
     * 无
     */
    w:function(i){
        var that=bringinRender;
        BringinController.y(i, that.x, that.y);
    },
    /*
     * 功能：我委托出去的职位分页回调函数
     * 参数：
     * 无
     */
    x:function(i){
        var that=bringinRender;
        BringinController.y(i, that.z, that.y);
        that.q();
    },
    /*
     * 功能：获取委托出去的职位列表数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    y:function(i,suc,fail){
        var par=$("#delefilter");
        var a=par.find("span.filt_type a.red").attr("tp"),
        b=par.find("span.filt_status a.red").attr("st");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var job=new Jobs();
        job.EGetAgentJobs(a, b, i, suc, fail);
    },
    /*
     * 功能：我委托出去的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    z:function(){
        $("#delefilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            BringinController.w(0);
        });
    },
    /*
     * 功能：我委托出去的职位 立即终止委托
     * 参数：
     * 无
     */
    aa:function(){
        $("#delelist li a.closedele").unbind("click");
        $("#delelist li a.closedele").bind("click",function(){
            if(confirm(LANGUAGE.L0178)){
                var par=$(this).parent().parent();
                par.parent().slideUp(300);
                var that=bringinRender;
                var a=par.prev().find("a.jtitle").attr("jid");
                var jb=new Jobs();
                jb.EEndDeleJob(a, that.ab, that.m);
            }
        });
    },
    /*
     * 功能：获取待处理的职位数据
     * 参数：
     * 无
     */
    ab:function(i){
        var that=bringinRender;
        BringinController.ad(i, "jobboxfilter", that.ac, that.ad);
    },
    /*
     * 功能：待处理职位分页回调函数
     * 参数：
     * 无
     */
    ac:function(i){
        var that=bringinRender;
        BringinController.ad(i, "jobboxfilter", that.ae, that.ad);
        that.q();
    },
    /*
     * 功能：获取待处理的职位列表数据
     * 参数：
     * 无
     */
    ad:function(i,tid,suc,fail){
        var par=$("#"+tid);
        var a=par.find("span.filt_type a.red").attr("tp");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var job=new Jobs();
        job.EGetWCLJobs(a, i, CONSTANT.C0004, suc, fail);
    },
    /*
     * 功能：未处理的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    ae:function(){
        $("#jobboxfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            BringinController.ab(0);
        });
    },
    /*
     * 功能：未处理的职位 立即发布
     * 参数：
     * 无
     */
    af:function(){
        $("#jobboxlist div.oper a.publishjob").unbind("click").bind("click",function(){
            if(confirm(LANGUAGE.L0199)){
                var a=$(this).parent().parent().prev().find("a.jtitle").attr("jid");
                var that=bringinRender;
                $("#jobboxlist").data("cur",this);
                var job=new Jobs();
                job.EPubJobs(a, that.ag, that.m);
            }
        });
    },
    /*
     * 功能：猎头职位管理 我发布的职位 立即推广
     * 参数：
     * 无
     */
    ag:function(){
        $("#epublist a.unpro").hgsShowBCard({
            id:"compromipostjob",
            url:WEBURL.PromoteInfo,             //按钮点击访问路径
            durl:WEBURL.JobPromote,            //获取插件初始化数据的路径
            getId:function(o){
                return $(o).parent().prev().find("a.jtitle").attr("jid");
            },
            cback:function(o){
                baseRender.t_s(o);
            },//推广回调方法
            type:"1"             //信息类型（1：职位，2：简历，3：任务）
        });
    },
    /*
     * 功能：初始化应聘来的的简历列表数据
     * 参数：
     * i:当前页码
     */
    ah:function(i){        
        var that=bringinRender;        
        BringinController.aj(i,that.ns,that.nf);       
    },
    /*
     * 功能：应聘来的的简历分页回调数据
     * 参数：
     * i:当前页码
     */
    ai:function(i){        
        var that=bringinRender;        
        BringinController.aj(i,that.os,that.nf);
        that.q();
    },
    /*
     * 功能：获取应聘来的的简历列表数据
     * 参数：
     * i:当前页码
     * suc:异步成功后回调函数
     * fail:异步失败后回调函数
     */
    aj:function(i,suc,fail){
        var sent_status=$("span.ap_resu_sta").find("a.red").attr("rel"),
        job_category=$("span.ap_resu_type").find("a.red").attr("fl"),
        sender_role=$("span.ap_reg_condition").find("a.red").attr("rl");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var res=new Resume();        
        res.EGetAppliedReume(i,CONSTANT.C0004,job_category,sent_status,sender_role,suc,fail);
    },
    /*
     * 功能：应聘来的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    b:function(){
        $("#apr a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            BringinController.ah(0);
        });
    },
    /*
     *功能：绑定查看简历事件
     *参数:
     *sid：投递简历
     */
    ba:function(obj){
        var res=new Resume();
        var that=bringinRender;       
        obj.unbind("click").bind("click",function(e){
            var sid,chec_now;
            if($(this).hasClass("jtitle")){
                var big=$(this).parent().parent().next().find("span.big");
                sid=big.attr("rel");
                chec_now=big.parent().next();
            }else{
                sid=$(this).parent().prev().find("span.big").attr("rel");
                chec_now=$(this).parent();
            }                                  
            $("ul#applied_resume").data("obj",chec_now);                                 
            res.CheckAppReume(sid,that.p_c,that.p_f);
        });
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(1);
        this.p(0);
        this.ab(0);
        this.s();
        this.w(0);
        this.z();
        this.b();
        this.ah(0);
        this.ae();       
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="40"){
        //初始化页面js等
        BringinController.IniPage();
    }
});
