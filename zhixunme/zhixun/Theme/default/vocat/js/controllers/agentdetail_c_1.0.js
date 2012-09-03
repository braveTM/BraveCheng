/*
 * 猎头详细页 控制器
 */
var agentdetailController={
    /*
     * 功能：初始化关注
     * 参数：
     * 无
     */
    a:function(){
        baseController.BtnBind("div.myfollow div.btn17", "btn17", "btn17_hov", "btn17_hov");         
        $("#add_focus").bind("click",function(){
            var a=$(this).attr("uid");
            var uname=$(this).attr("uname");
            var that=agentdetailRender;
            var msg=new Message();
            $(this).data("uid",a);
            $(this).data("uname",uname);
            msg.Add_FocusPerson(a,that.a,that.b);
        });
    },
    /*
     * 功能：取消关注
     * 参数：
     * 无
     */
    b:function(){
        $("#re_focus").unbind("click").bind("click",function(){
            var that=agentdetailRender;
            var uid=$(this).attr("uid");
            var uname=$(this).attr("uname");
            $(this).data("uid",uid);
            $(this).data("uname",uname);
            var msg="确定取消关注—"+uname;            
            baseController.InitialSureDialog("error",msg, "select",'确 定',function(){
                $("#select").unbind("click").bind("click",function(){
                    $("div.alr_opermsg_cover").fadeOut();
                    var m=new Message();
                    m.removeFocus(uid,that.s,that.t);                        
                });                  
            });                                   
        })
    },
    /*
     * 功能：初始化委托职位按钮
     * 参数：
     * 无
     */
    d:function(){
        if($("#deljob").length>0){
            $("#deljob").bind("click",function(){
                var b=$(this).attr("jid");
                var that=agentdetailRender;
                if(b!=""){
                    agentdetailController.e(b);
                }
                else{
                    var job=new Jobs();
                    job.GetCDJobs(that.e, that.f);
                }
            });
        }
    },
    /*
     * 功能：委托职位付费提示
     * 参数：
     * b：职位id
     */
    e:function(b){
        paytipController.CDeleJobTip(agentdetailController.ea, [b], "#deljob");
    },
    /*
     * 功能：委托职位
     * 参数：
     * b：职位id
     */
    ea:function(param){
        var a=$("#deljob").attr("uid");
        var that=agentdetailRender;
        var jb=new Jobs();
        jb.DeleJobs(a, param[0], that.d, that.b);
    },
    /*
     * 功能：获取委托职位id后再委托职位
     * 参数：
     * b：职位id
     */
    f:function(obj){
        var b=$("#cdres_list").find("li input[name='sjob']:checked").parent().attr("jid");
        agentdetailController.e(b);
    },
    /*
     *功能：人才委托简历
     * 参数：
     * 无
     *jack
     *2012-2-14
     */
    g:function(){
        $("#app_ftr").unbind("click").bind("click",function(){
            var aid=$(this).attr("uid");//猎头ID
            baseController.InitialSureDialog("error", LANGUAGE.L0195, "select", LANGUAGE.L0196,agentdetailRender.i);
            $("#select").unbind("click").bind("click",function(){
                var s=$("input[name='reum']:checked").length;
                if(s==0){
                    alert('请选择简历类型!');
                    $("div.sure_dialog").remove();
                    return false;
                }else{
                    var t1=$("input[name='reum']:checked").val();
                    paytipController.TDeleResTip(function(param){
                        var po=new Pool();
                        po.ApplyAgentResme(param[0],param[1],agentdetailRender.g,agentdetailRender.h);
                        $("div.sure_dialog").remove();
                    }, [aid,t1], "#app_ftr");
                }
            });
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
    h:function(t,id,func){
        var lan=LANGUAGE;
        $(id).pagination(t, {
            callback: func,
            prev_text: lan.L0258,
            next_text: lan.L0259,
            items_per_page:CONSTANT.C0003,
            num_display_entries:9,
            current_page:0,
            num_edge_entries:1,
            link_to:"javascript:;"
        });
    },
    /*
     * 功能：初始化分页插件调用
     * 参数：
     * author:joe
     * 
     */
    ha:function(){
        var jobcount=$("#pagination2").attr("rel")*1;
        var rescount=$("#pagination1").attr("rel")*1;
        var that=agentdetailController;
        if(jobcount>CONSTANT.C0003){
            that.h(jobcount,"#pagination2,#pt2",that.j);
        }
        if(rescount>CONSTANT.C0003){
            that.h(rescount,"#pagination1,#pt1",that.m);
        }
    },
    /*
     * 功能：初始化正在运作的职位
     * 参数：
     * 无
     */
    i:function(i){
        var that=agentdetailRender;
        agentdetailController.k(i, 1, that.j, that.k);
    },
    /*
     * 功能：正在运作的职位分页回调函数
     * 参数：
     * 无
     */
    j:function(i){
        var that=agentdetailRender;
        agentdetailController.k(i, 1, that.m, that.k);
        that.l();
    },
    /*
     * 功能：获取正在运作的职位列表数据|正在运作的简历列表数据
     * 参数：
     * i:当前页
     * type：职位查询：1，简历查询：2
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     * mender:joe 2012/7/10
     */
    k:function(i,type,suc,fail){
        var par=$("#talfilter"),
        a=par.attr("uid"),b;  
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        if(type==1){            
            b=$("#pt2").prev("span").find("a").not("a.blue").attr("tpy");            
            var job=new Jobs();
            job.GetARunningJob(a, b, i, 6, suc, fail);            
        }else if(type==2){                        
            b=$("#pt1").prev("span").find("a").not("a.blue").attr("tpy");;
            var res=new Resume();
            res.GetARunResumes(a, b, i, 6, suc, fail);
        }
    },
    /*
     * 功能：初始化正在运作的简历
     * 参数：
     * 无
     */
    l:function(i){
        var that=agentdetailRender;
        agentdetailController.k(i, 2, that.o, that.p);
    },
    /*
     * 功能：正在运作的简历分页回调函数
     * 参数：
     * 无
     */
    m:function(i){
        var that=agentdetailRender;
        agentdetailController.k(i, 2, that.q, that.p);
        that.l();
    },
    /*
     * 功能：正在运作的简历|正在运作的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    n:function(){
        var obj=$("#talfilter span.filt_role").find("a");        
        obj.click(function(){         
            $(this).parent().find("a").addClass("blue");
            $(this).removeClass("blue");            
            if($("#talfilter ul.filt_type li.cur_li a").attr("tp")=="0"){
                agentdetailController.l(0);//运作的简历
            }else{
                agentdetailController.i(0);//运作的职位
            }
        });
        $("#talfilter a:eq(0),#talfilter a:eq(1)").click(function(){
            if($(this).attr("tp")=="0")
                agentdetailRender.oa(0);
            if($(this).attr("tp")=="1")
                agentdetailRender.oa(1);
        });
    },
    /*
     * 功能：举报猎头绑定事件
     * 参数：
     * 无
     */
    o:function(){
        $("#report_a").bind("click",function(){
            var newtype=3;//举报类型会员
            var user_id=$(this).attr("uid")*1;
            var url=WEBURL.RerportSpam;
            url+='/'+newtype+'/'+user_id;
            var that=baseRender;                
            that.OpenWin(url,600,600);
        });
    },
     /*
     * 功能：猎头详细页 - 赞一下
     * 参数：
     * 
     * suc：成功回调方法
     * fail：失败回调方法
     */
    p:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var a=$(this).attr("uid");
            $("a.good:eq(0)").data("prise",this);
            var that=agentdetailRender;
            var info=new Message();
            info.agentPraise(a, that.u, that.v);            
        });
    },
    /*
     * 功能：分享绑定
     * 参数：
     * obj:分享图标对象
     * anthor:joe 2012/7/9
     */
//    q:function(obj){
//        $(obj).unbind("click").bind("click",function(){                        
//            var par=$(this);             
//            var sum=$("div.module_1 div.baseinfo").find("p").not("p.agent_url"),summary='';            
//            var pics=[];            
//            sum.each(function(){
//                summary+=$.trim($(this).find("span").text())+'\n';
//            });            
//            var pic=$("div.module_1").find("img.big");
//            pic.each(function(i,item){
//                pics.push(item.src);
//            })
//            pics=pics.join("|");
//            var type=par.attr("tp"),
//            tit=par.attr("tit"),
//            des=$("div.module_1").find("p.detail").text(),
//            ur=par.attr("ur");                 
//            if($(this).attr("tp")=="qzone"){
//                des=tit;
//            }
//            zxshare(type,[tit,ur,des,summary,pics]);
//        });
//    },
    /*
     * 功能：通过url定位简历|职位
     * 参数：     
     * anthor:joe 2012/7/12
     */
    r:function(){
        var url=location.href;
        var id=/#(job|res)$/.exec(url);   
        if(id)
            return id[1];
        else
            return false;
    },
    /*
     * 功能：简历｜职位url修改
     * 参数:
     * i:0 浏览简历 1 浏览职位
     * anthor:joe 2012/7/12
     */
    ra:function(i){
        var url=location.href;
        if(!i){
            location.href=url.replace("job","res");
        }
        else{
             location.href=url.replace("res","job");
        }
    },
    /*
     * 功能：通过url定位简历|职位
     * 参数：     
     * anthor:joe 2012/7/12
     */
    t:function(){
        var val=agentdetailController.r();
        if(val=="res"){
            $("#talfilter a:eq(0)").trigger("click");            
        }
        else{
            $("#talfilter a:eq(1)").trigger("click");
        }
    },    
    /*
     * 功能：初始化首页
     * 参数：
     * 无
     */
    IniPage:function(){
        this.a();
        this.b();
        this.d();
        this.g();
        this.n();
        this.o();
//        this.q("#share a.share");
        this.p($("#praise"));
        this.t();
        this.ha();        
    },
    /*
     * 功能：初始化未登录详细页
     * 参数：
     * 无
     */
    IniPage1:function(){
        this.n();     
        this.t();
        this.ha();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="59"){
        //初始化页面js等
        agentdetailController.IniPage();
    }
    if(PAGE=="109"){
        baseController.BtnBind("div.myfollow div.btn17", "btn17", "btn17_hov", "btn17_hov");
        agentdetailController.IniPage1();
    }
});
