/*
 * 猎头职位管理控制器
 */
var ComDetailController={
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
            items_per_page:CONSTANT.C0003,
            num_display_entries:9,
            current_page:0,
            num_edge_entries:1,
            link_to:"javascript:;"
        });
    },
    /*
     * 功能：获取职位列表数据
     * 参数：
     * 无
     */
    b:function(i){
        var that=comdetailRender;
        ComDetailController.d(i, that.a, that.b);
    },
    /*
     * 功能：职位列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=comdetailRender;
        ComDetailController.d(i, that.d, that.b);
        that.c();
    },
    /*
     * 功能：初始化分页插件调用
     * 参数：
     * author:joe
     * 
     */
    ca:function(){
        var jobcount=$("#pagination1").attr("rel")*1;        
        var that=ComDetailController;       
        if(jobcount>CONSTANT.C0003){
            that.a(jobcount,"#pagination1",that.c);
        }
    },
    /*
     * 功能：获取职位列表数据
     * 参数：
     * i:当前页
     * id：
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(i,suc,fail){
        var a=$("#talfilter span.filt_type a.red").attr("tp"),
            b=$("#cuid").attr("uid");
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var job=new Jobs();
        job.GetComPubJobs(b, 6, i, a, suc, fail);
    },
    /*
     * 功能：我发布的职位 排序方式点击事件绑定
     * 参数：
     * 无
     */
    f:function(){
        $("#talfilter a").click(function(){
            $(this).parent().find("a").removeClass("red");
            $(this).addClass("red");
            ComDetailController.b(0);
        });
    },
    /*
     * 功能：初始化关注
     * 参数：
     * 无
     */
    g:function(){
        baseController.BtnBind("div.myfollow div.btn17", "btn17", "btn17_hov", "btn17_hov");
        $("#add_focus").bind("click",function(){
            var a=$(this).attr("uid");
            var uname=$(this).attr("uname");
            var that=comdetailRender;
            var msg=new Message();
            $(this).data("uid",a);
            $(this).data("uname",uname);
            msg.Add_FocusPerson(a,that.f,that.g);
        });
    },
     /*
     * 功能：举报企业绑定事件
     * 参数：
     * 无
     */
    h:function(){
        $("#report_c").bind("click",function(){
            var newtype=3;//举报类型会员
            var user_id=$(this).attr("uid")*1;
            var url=WEBURL.RerportSpam;
                url+='/'+newtype+'/'+user_id;
            var that=baseRender;                
                that.OpenWin(url,600,600);
        });
    },
     /*
     * 功能：取消关注
     * 参数：
     * 无
     */
    i:function(){
        $("#re_focus").unbind("click").bind("click",function(){
            var that=comdetailRender;
            var uid=$(this).attr("uid");
            var uname=$(this).attr("uname");
            $(this).data("uid",uid);
            $(this).data("uname",uname);
            var msg="确定取消关注—"+uname;            
            baseController.InitialSureDialog("error",msg, "select",'确 定',function(){    
                    $("#select").unbind("click").bind("click",function(){
                        $("div.alr_opermsg_cover").fadeOut();
                        var m=new Message();
                        m.removeFocus(uid,that.h,that.i);                    
                    })                  
                });  
        })
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
//        this.b(0);
        this.ca();
        this.f();
        this.g();
        this.h();
        this.i();
    },
     /*
     * 功能：未登录状态初始化页面
     * 参数：
     * 无
     */
    IniPage1:function(){
//        this.b(0);    
        this.ca();
        this.f();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="51"){
        //初始化页面js等
        ComDetailController.IniPage();
    }
    if(PAGE=="111"){
        ComDetailController.IniPage1();
    }
});
