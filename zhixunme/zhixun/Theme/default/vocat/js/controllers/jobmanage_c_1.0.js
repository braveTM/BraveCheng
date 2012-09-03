/*
 * 猎头职位管理控制器
 */
var JobmanageController={
/*********职位搜索start*************/
    /*
    * 功能：初始化地区选择插件
    * 参数：无
    * author:joe 2012/7/27
    */
    a:function(){
        $("#place").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"pslt",            //省市添加的父容器id
            lishow:true,
            pshow:true,       //是否显示地区选择
            sprov:true,       //是否只精确到省
            single:true,       //省是否为单选
            sure:jobmanageRender.a
        })
    },    
    /*
    * 功能：初始化搜索框|筛选条件|高级搜索事件绑定
    * 参数：无
    * author:joe 2012/7/27
    */
    b:function(){
        var that=jobmanageRender;
        that.b();
        that.c();
        that.d();
        that.e();       
    },
    /*
     * 功能：翻页事件绑定
     * 参数：
     * id:分页插件的父容器id
     * author:joe
     */
    e:function(id){
        var p=$("#pagination");
        $("#prev").click(function(){
            if(!$(this).hasClass("gray")){
                p.find("a.prev").trigger("click");             
            }
        });
        $("#next").click(function(){
          if(!$(this).hasClass("gray")){
              p.find("a.next").trigger("click");             
          }
        });
    },
     /*
     * 功能：header翻页样式同步
     * 参数：
     * sp:当前页
     * author:joe
     */
    ea:function(sp){
        sp=sp||1;                
        var ep=$("#pagination").attr("ep");                   
        var pagehtm=sp+'/'+ep;
        $("#prev").next().html(pagehtm);   
        $("#prev,#next").removeClass("gray");
        if(sp==ep){//结束向后翻页
            $("#next").addClass("gray");
        }
        if(sp==1){//结束向前翻页
            $("#prev").addClass("gray");
        }
    },
    /*
     *功能：触发搜索事件绑定
     *参数：无
     *@author：joe
     */
    g:function(){
        var that=jobmanageRender;
        $("#advance").find("a").unbind("click").bind("click",function(){//高级搜索
            $(this).siblings("a.sel").removeClass("sel");
            $(this).addClass("sel");            
            JobmanageController.j(1);
        });
        $("#hotwords").find("a").unbind("click").bind("click",function(){//热门关键词
            $("#keywords").val($(this).text()).attr("rel",$(this).text());//区别搜索与条件筛选            
            that.l();
            JobmanageController.j(1);
        })
        that.f();//排序方式
    },
    /*
     *功能：搜索按键后提交
     *参数：无
     *@author：joe
     */
    h:function(){
        $("#search").unbind("click").bind("click",function(){
            if($("#keywords").val()=="请输入您要找的职位"){
                $("#keywords").trigger("focus") ;
            }else{
                jobmanageRender.l();
                JobmanageController.j();
            }
        })
        $(document).keydown(function(event){//回车搜索            
            var aid=document.activeElement.id;
            if(event.keyCode==13&&aid=="keywords"){
                $("#search").trigger("click");
            }
        });
    },
    /*
     * 功能：搜索参数获取
     * 参数：    
     * i:1  多条件搜索
     * page 当前页
     * author:joe 2012/7/27
     */
    i:function(i,page){
        var require_place=0,//要求地区
        salary=0,//待遇
        pub_date=0,//发布时间
        cert_type=2,//资质证书
        word,//关键词
        is_real_auth=2,//认证用户
        page=page||1,//当前页
        size=10,//每页条数
        order=0;//排序方式        
        var salarys=$("#advance").find("li.salary");
        var pubs=$("#advance").find("li.pub_date");
        var orders,up,down,params='';
        word=$("#keywords").val();   
        if(word=="请输入您要找的职位")
            word='';
        if(i==1){//多条件搜索
            word=$("#keywords").attr("rel");
            orders=$("#pos_list").find("a.sel");  
            require_place=$("#pid").val();
            salary=salarys.find("a.sel").attr("rel");
            pub_date=pubs.find("a.sel").attr("rel");            
            if(orders.hasClass("count")){//浏览数排序
                order=1;
            }
            else{
                up=orders.find("em.up_sel");
                down=orders.find("em.down_sel");
                if(up.length){
                    order=up.attr("rel");
                }
                else if(down.length){
                    order=down.attr("rel");
                }
            }
            if(!$("#cert").hasClass("cancel"))
                cert_type=1;
            if(!$("#authuser").hasClass("cancel"))
                is_real_auth=1;
        }        
        var paramsObj={
            require_place:require_place,
            salary:salary,
            pub_date:pub_date,
            cert_type:cert_type,
            word:word,
            is_real_auth:is_real_auth,
            page:page,
            size:size,
            order:order
        }        
        var i=0;
        $.each(paramsObj,function(o,item){            
            if(item!=0){
                if(i==0)
                    params=o+'='+item;
                else
                    params+='&'+o+'='+item;
                i++;
            }
        });
        return params;
    },
    /*
     * 功能：职位搜索
     * 参数：   
     * i:1  多条件搜索  
     * page:当前页
     * author:joe 2012/7/27
     */
    j:function(i,page,suc,fail){
        var params=JobmanageController.i(i,page);        
        var job=new Jobs();  
        var that=jobmanageRender;
        suc=suc||that.h;
        fail=fail||that.i;
        JobmanageController.m("findjoblist");
        job.SearchJob(params,1,suc,fail);
    },
    /*
     * 功能：职位搜索分页回调
     * 参数：
     * i:当前页
     * author:joe 2012/7/28
     */
    k:function(page){
        var that=jobmanageRender;        
        page=page+1;
        JobmanageController.j(1,page,that.j,that.i);        
        JobmanageController.ea(page);
        $("html,body").scrollTop(0); 
    },
    /*
     * 功能：职位搜索首次获取数据
     * 参数：
     * page:当前页
     * author:joe 2012/7/28
     */
    l:function(page){
        var that=jobmanageRender;
        JobmanageController.j(0,page,that.h,that.i);        
    },
     /*
     * 功能：加载等待状态
     * 参数：
     * id:加载区id          
     * 
     */
    m:function(id){
       var tmp=TEMPLE;
        $("#"+id).html(tmp.T00113);
        $("#pagination").hide();
    },
    /*********职位搜索end*************/
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
        var that=jobmanageRender;
        JobmanageController.r(i, "pubfilter", that.n, that.o);
    },
    /*
     * 功能：我发布的职位分页回调函数
     * 参数：
     * 无
     */
    q:function(i){
        var that=jobmanageRender;
        JobmanageController.r(i, "pubfilter", that.p, that.o);
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
        job.AGetPubJobs(a, b, i, suc, fail);
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
            JobmanageController.p(0);
        });
    },
    /*
     * 功能：我发布的职位/委托来的职位 完成招聘
     * 参数：
     * id：列表id
     */
    t:function(id){
        $(id+" div.oper a.comp").unbind("click");
        $(id+" div.oper a.comp").bind("click",function(){
            JobmanageController.aa(this);
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
                    var that=jobmanageRender;
                    that.t(this,id,cls);//初始化父容器
                    var a=$(this).parent().parent().find("p a.jtitle").attr("jid");
                    var job=new Jobs();
                    job.AGetResList(a, 1, "0", that.u, that.m);
                    res=$(this).parent().parent().parent().find("div.mlist_list");
                }
                res.slideDown(300);
            }
        });
    },
    /*
     * 功能：获取委托来的职位数据
     * 参数：
     * 无
     */
    v:function(i){
        var that=jobmanageRender;
        JobmanageController.x(i, that.w, that.x);
    },
    /*
     * 功能：委托来的职位分页回调函数
     * 参数：
     * 无
     */
    w:function(i){
        var that=jobmanageRender;
        JobmanageController.x(i, that.y, that.x);
        that.q();
    },
    /*
     * 功能：获取委托来的职位列表数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    x:function(i,suc,fail){
        var par=$("#agentfilter");
        var a=par.find("span.filt_type a.red").attr("tp"),
        b=par.find("span.filt_status a.red").attr("st");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var job=new Jobs();
        job.AGetAgentList(a, b, i, suc, fail);
    },
    /*
     * 功能：委托来的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    y:function(){
        $("#agentfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            JobmanageController.v(0);
        });
    },
    /*
     * 功能：委托来的职位 立即公开招聘
     * 参数：
     * id：列表id
     */
    z:function(id){
        $(id+" div.oper a.publicjob").unbind("click");
        $(id+" div.oper a.publicjob").bind("click",function(){
            if(confirm("您确定要公开该职位的招聘吗?")){
                var that=jobmanageRender;
                var a=$(this).parent().parent().prev().find("a.jtitle").attr("jid");
                $("div").data("obj",$(this));
                var job=new Jobs();
                job.AOpenJobs(a, that.ab, that.m);
            }
        });
    },
    /*
     * 功能:猎头 结束招聘
     * 参数：
     * obj：当前a标签
     */
    aa:function(obj){
        if(confirm(LANGUAGE.L0179)){
            var that=jobmanageRender;
            var a=$(obj).attr("rid");
            $("#apublist").data("obj",obj);
            var job=new Jobs();
            job.AEndPubJobs(a,that.s, that.m);
        }
    },
    /*
     *功能：我发布的职位/委托来的职位 暂停/继续招聘事件绑定
     *参数：
     *obj：当前所属对象
     */
    apa:function(id){
        $(id+" div.oper a.pausejob").unbind("click").bind("click",function(){
            JobmanageController.apause(this);
        });
        $(id+" div.oper a.continuejob").unbind("click").bind("click",function(){
            JobmanageController.acontinue(this);
        });
    },
    /*
     *功能：猎头 暂停招聘
     *参数：
     *obj：当前选中元素
     */
    apause:function(obj){
        var that=jobmanageRender;
        var a=$(obj).parent().parent().prev().find("a.jtitle").attr("jid");
        $("div").data("obj",obj);
        var job=new Jobs();
        job.APauseJob(a,that.afterpa, that.m);
    },
    /*
     *功能：猎头 继续招聘
     *参数：
     *obj：当前选中元素
     */
    acontinue:function(obj){
        var that=jobmanageRender;
        var a=$(obj).parent().parent().prev().find("a.jtitle").attr("jid");
        $("div").data("obj",obj);
        var job=new Jobs();
        job.AContinueJob(a,that.ab, that.m);
    },
    /*
     * 功能：获取可能感兴趣的职位数据
     * 参数：
     * 无
     */
    ab:function(i){
        var that=jobmanageRender;
        JobmanageController.ad(i, that.ac, that.ad);
    },
    /*
     * 功能：可能感兴趣的职位分页回调函数
     * 参数：
     * 无
     */
    ac:function(i){
        var that=jobmanageRender;
        JobmanageController.ad(i, that.ae, that.ad);
        that.q();
    },
    /*
     * 功能：获取可能感兴趣的职位列表数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    ad:function(i,suc,fail){
        var par=$("#intrfilter");
        var a=par.find("span.filt_type a.red").attr("tp"),
        b=par.find("span.filt_status a.red").attr("st"),
        c=par.find("span.filt_reg a.red").attr("re");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var job=new Jobs();
        job.AGetIntrJobs(a, b, c, i, CONSTANT.C0004, suc, fail);
    },
    /*
     * 功能：委托来的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    ae:function(){
        $("#intrfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            JobmanageController.ab(0);
        });
    },
    /*
     * 功能：猎头职位管理 可能感兴趣的职位||职位搜索 投递简历
     * 参数：
     * 无
     */
    af:function(){
        $("#intrjob a.uoper,#findjoblist a.uoper").hgsShowCard({
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
     * 功能：猎头职位管理 我发布的职位 立即推广
     * 参数：
     * 无
     */
    ag:function(){
        $("#apublist a.unpro").hgsShowBCard({
            id:"promipostjob",
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
     * 功能：猎头职位管理 委托来的职位 立即推广
     * 参数：
     * 无
     */
    ah:function(){
        $("#agentjob a.unpro").hgsShowBCard({
            id:"promagentjob",
            url:WEBURL.PromoteInfo,             //按钮点击访问路径
            durl:WEBURL.JobPromote,            //获取插件初始化数据的路径
            getId:function(o){
                return $(o).parent().prev().find("a.jtitle").attr("jid");
            },         //获取推广信息的编号
            cback:function(o){
                baseRender.t_s(o);
            },//推广回调方法
            type:"1"             //信息类型（1：职位，2：简历，3：任务）
        });
    },
    /*
     * 功能：猎头职位管理 发布职位 初始化
     * 参数：
     * 无
     */
    ai:function(){
        $("table.tb input[readonly]").val("");
    },
    /*
     * 功能：猎头职位管理 委托来的职位 查看详细
     * 参数：
     * 无
     */
    aj:function(){
        $("#agentjob li div.oper a.ckjdetail").unbind("click").bind("click",function(){
            var that=jobmanageRender;
            var jb=new Jobs();
            var a=$(this).attr("jid");
            jb.ACheckJDetial(a, that.ag, that.ah);
        });
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(2);
        this.a();
        this.b();        
        this.e();
        this.g();
        this.h();        
        this.l(0);
        this.ai();
        this.v(0);
        this.y();
        this.p(0);
        this.s();
        this.ab(0);
        this.ae();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="43"){
        //初始化页面js等
        JobmanageController.IniPage();
    }
});
