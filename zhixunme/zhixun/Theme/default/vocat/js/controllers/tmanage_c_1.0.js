/*
 * 猎头人才管理控制器
 */
var TManageController={
    /*
     * 功能：猎头代理的人才列表初始化
     * 参数：
     * 无
     */
    m:function(i){
        var that=tmanageRender;
        TManageController.o(i, 'atfilter', that.h, that.i);
    },
    /*
     * 功能：猎头代理的人才列表分页回调函数
     * 参数：
     * 无
     */
    n:function(i){
        var that=tmanageRender;
        TManageController.o(i, "atfilter", that.j, that.i);
        that.k();
    },
    /*
     * 功能：获取猎头代理的人才列表
     * 参数：
     * i:当前页
     * tid：筛选栏的父容器id
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    o:function(i,tid,suc,fail){
        var par=$("#"+tid);
        var a=par.find("span.filt_type a.red").attr("tp"),
        b=par.find("span.filt_status a.red").attr("st");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var resume=new Resume();
        resume.GetAHuman(b, a, i, 1, 1, suc, fail);
    },
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻页插件绑定id
     * func:翻页回调函数
     */
    p:function(t,id,func){
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
     * 功能：委托来的人才 排序方式点击事件绑定
     * 参数：
     * 无
     */
    q:function(){
        $("#atfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            TManageController.m(0);
        });
    },
    /*
     * 功能：猎头感兴趣的人才列表初始化
     * 参数：
     * 无
     */
    r:function(i){
        var that=tmanageRender;
        TManageController.t(i, 'iatfilter', that.m, that.n);
    },
    /*
     * 功能：猎头感兴趣的人才列表分页回调函数
     * 参数：
     * 无
     */
    s:function(i){
        var that=tmanageRender;
        TManageController.t(i, "iatfilter", that.o, that.n);
        that.k();
    },
    /*
     * 功能：获取猎头感兴趣的人才列表
     * 参数：
     * i:当前页
     * tid：筛选栏的父容器id
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    t:function(i,tid,suc,fail){
        var par=$("#"+tid);
        var a=par.find("span.filt_type a.red").attr("tp"),
        b=par.find("span.filt_ro a.red").attr("ro");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var resume=new Resume();
        resume.GetIAHuman(b, a, i, 1, 1, suc, fail);
    },
    /*
     * 功能：猎头感兴趣的人才 排序方式点击事件绑定
     * 参数：
     * 无
     */
    u:function(){
        $("#iatfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            TManageController.r(0);
        });
    },
    /*
     * 功能：猎头委托我的人才 立即公开求职
     * 参数：
     * 无
     */
    v:function(obj){
        $(obj).unbind("click").bind("click",function(){
            if(confirm("您确定要公开求职吗?")){
                var that=tmanageRender;
                var par=$(this).parent().parent().parent();
                $("#atlist").data("cur",par);
                var a=$(this).parent().parent().prev().find("a.jtitle").attr("rid");
                var res=new Resume();
                res.APubResume(a, that.q, that.s);
            }
        });
    },
    /*
     * 功能：猎头委托我的人才 立即结束求职
     * 参数：
     * 无
     */
    w:function(obj){
        $(obj).unbind("click").bind("click",function(){
            if(confirm("您确定要结束求职吗?")){
                var that=tmanageRender;
                that.u(this);
                var a=$(this).parent().parent().prev().find("a.jtitle").attr("rid");
                var res=new Resume();
                res.ACloseResume(a, null, that.s);
            }
        });
    },
    /*
     * 功能：猎头人才管理 可能感兴趣的人才 邀请简历
     * 参数：
     * 无
     */
    x:function(){
        $("#iatlist a.uoper").hgsShowJobCard({
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
    /*
     *获取猎头应聘来的的简历列表
     *jack
     *2012-2-17
     */
    ab:function(i){
        var that=tmanageRender;
        TManageController.ad(i, that.as, that.af);
    },
    /*
     * 功能：应聘来的简历列表分页回调函数
     * 参数：
     * 无
     */
    ac:function(i){
        var that=tmanageRender;
        TManageController.ad(i, that.bs, that.af);
        that.k();
    },
    /*
     * 功能：获取应聘来的简历列表数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    ad:function(i,suc,fail){
        var sent_status=$("span.ap_resu_sta").find("a.red").attr("rel"),
        job_category=$("span.ap_resu_type").find("a.red").attr("fl"),
        sender_role=$("span.ap_reg_condition").find("a.red").attr("rl");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var res=new Resume();
        res.GetAppliedReume(i,CONSTANT.C0004,job_category,sent_status,sender_role,suc,fail);
    },
    /*
     *功能：应聘来的简历处理状态来筛选数据
     *参数：无
     *jack
     *2012-2-18
     */
    ae:function(){
        $("#apr a").bind("click",function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            TManageController.ab(0);
        });
    },
    /*
     *功能：绑定查看简历事件
     *参数:
     *obj：投递简历id
     */
    ai:function(obj){
        var res=new Resume();
        var that=tmanageRender;
        obj.unbind("click").bind("click",function(){
            var sid,chec_now;
            if($(this).hasClass("jtitle")){
                var big=$(this).parent().parent().next().find("span.big");
                sid=big.attr("rel");
                chec_now=big.parent().next().find(".chec_now").parent();
            }else{
                sid=$(this).parent().parent().parent().prev().find("span.big").attr("rel");
                chec_now=$(this).parent();
            }          
            $("ul#applied_resume").data("obj",chec_now);        
            res.CheckAgentAppReume(sid,that.c_s,that.c_f);
        });
    },
    /*
     *功能：获取我所添加的简历列表
     *参数：无
     *jack
     *2012-2-20
     */
    get_aded:function(i){
        var that=tmanageRender;
        TManageController.get_added_reum(i,that.get_aded_suc,that.get_aded_fail);
    },
    /*
     *功能：获取我所添加的简历列表分页回调函数 
     *参数：无
     *jack
     *2012-2-20
     */
    page_call_aded:function(i){
        var that=tmanageRender;
        TManageController.get_added_reum(i,that.gen_aded_list,that.get_aded_fail);
        that.k();
    },
    /*
     *功能：异步获取添加的简历列表
     *参数：page：当前页
     *size：每页显示条数
     *status：求职状态
     *category：0 不限
     *2：未公开
     *3：已公开
     *suc:成功执行函数
     *fail:失败执行函数
     */
    get_added_reum:function(i,suc,fail){
        var satus=$("span.resu_sta").find("a.red").attr("rel"),
        category=$("span.resu_type").find("a.red").attr("fl");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var res=new Resume();
        res.GetAddedResumList(i,CONSTANT.C0004,category,satus,suc,fail);
    },
    /*
     *功能：我添加的简历筛选条件值判断
     *jack
     *2012-2-20
     */
    filter_judge:function(){
        $("#adr a").bind("click",function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            TManageController.get_aded(0);
        });
    },
    /*
     * 功能：猎头简历管理 委托来的简历 立即推广
     * 参数：
     * 无
     */
    aj:function(){
        $("#atlist a.unpro").hgsShowBCard({
            id:"promagentres",
            url:WEBURL.PromoteInfo,             //按钮点击访问路径
            durl:WEBURL.ResumePromote,            //获取插件初始化数据的路径
            getId:function(o){
                return $(o).parent().prev().find("a.jtitle").attr("rid");
            }, //获取推广信息的编号
            cback:function(o){
                baseRender.t_s(o);
            },//推广回调方法
            type:"2"             //信息类型（1：职位，2：简历，3：任务）
        });
    },
    /*
     * 功能：猎头简历管理 我添加的简历 立即推广
     * 参数：
     * 无
     */
    ak:function(){
        $("#added_resume a.prom").hgsShowBCard({
            id:"prompubres",
            url:WEBURL.PromoteInfo,             //按钮点击访问路径
            durl:WEBURL.ResumePromote,            //获取插件初始化数据的路径
            getId:function(o){
                return $(o).parent().prev().find("a.jtitle").attr("rid");
            }, //获取推广信息的编号
            cback:function(o){
                baseRender.t_s(o);
            },//推广回调方法
            type:"2"             //信息类型（1：职位，2：简历，3：任务）
        });
    },
    /*
     * 功能：猎头简历管理 创建简历 - 页面初始化
     * 参数：
     * 无
     */
    al:function(){
        $("table.tb input[readonly]").val("");
    },
    /*
     * 功能：猎头简历管理 委托来的简历 - 完成求职
     * 参数：
     * 无
     */
    am:function(){
        $("#atlist li div.oper a.comp").unbind("click").bind("click",function(){
            var id=$(this).attr("rid");
            $("#atlist").data("comid",id);
            var that=tmanageRender;
            var res=new Resume();
            res.AComResume(id, that.bh, that.bi);
        });
    },
    /*
     * 功能：猎头简历管理 委托来的简历 查看详细
     * 参数：
     * 无
     */
    an:function(){
        $("#atlist li div.oper a.ckjdetail").unbind("click").bind("click",function(){
            var that=tmanageRender;
            var res=new Resume();
            var a=$(this).attr("jid");
            $("#atlist").data("hid",a);
            res.ACheckRDetial(a, that.bj, that.bk);
        });
    },
    /*
     * 功能：猎头简历管理 我添加的简历 删除简历
     * 参数：human_id
     * 无
     */
    deleAdedresm:function(){
        $("ul#added_resume a.dele").unbind("click").bind("click",function(){
            var msg=confirm('确定删除？');
            var uid=$(this).attr("uid");
            var t=$(this).parents("li");
            $("div").data("obj",t);
            var that=tmanageRender;
            if(msg==true){
                var res=new Resume();
                res.DoDeleAdeResum(uid, that.cs, that.cf);
            }
        });
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(1);
        this.al();
        this.m(0);
        this.r(0);
        this.ab(0);
        this.get_aded(0);
        this.q();
        this.u();
        this.ae();
        this.filter_judge();
        this.deleAdedresm();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="42"){
        //初始化页面js等
        TManageController.IniPage();
    }
});
