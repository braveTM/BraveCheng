var EnterGetAgentController={
    /*
     **初始化地区选择
     *jack
     *2012-2-12
     */
    iniArea:function(){
        $("div.efagent #from_area").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"pslt",            //省市添加的父容器id
            pshow:true,       //是否显示地区选择
            lishow:true,//是否显示不限省份
            sprov:false,       //是否只精确到省
            single:true,     //省是否为单选
            sure:engetAgentRender.a
        });
    },
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻译插件绑定id
     * func:翻页回调函数
     * jack
     * 2012-2-12
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
     * 功能：获取猎头列表数据
     * 参数：
     * 无
     */
    b:function(i){
        var that=engetAgentRender;
        EnterGetAgentController.d(i,that.b, that.c);
    },
    /*
     * 功能：获取猎头列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=engetAgentRender;
        EnterGetAgentController.d(i, that.d, that.c);
        that.o();
    },
    /*
     * 功能：获取猎头列表数据
     * 参数：
     * i：当前页
     * suc：成功获取数据时的方法
     * fail：失败获取数据时的方法
     */
    d:function(p,suc,fail){
        var pid,cid;
        if(typeof(p)=="undefined"){
            p=0;
        }
        else{
            p +=1;
        }
        var pol=new Pool();
        var t=$("div.efagent div.el span").find("a.red").attr("rel");
        pid=$("div.efagent input[name='e_prov']").val();
        cid=$("div.efagent input[name='e_city']").val();
        pol.CompanyGetAgentList(p,CONSTANT.C0004,t,pid,cid,0,suc,fail);
    },
    /*
     *功能：猎头性质条件筛选查询
     * 参数：
     *jack
     *2012-2-12
     */
    e:function(p){
        $("div.efagent div.el span a").click(function(){
            $("div.efagent div.el span a").removeClass("red");
            $(this).addClass("red");
            EnterGetAgentController.b(0);
        });
    },
    /*
     * 功能：初始化委托职位按钮
     * 参数：
     * 无
     */
    g:function(obj){
        if($(obj).length>0){
            $(obj).bind("click",function(){
                var b=$("input#jid").val();
                var that=engetAgentRender;
                var aid=$(this).attr("rel");
                $("#e_agent_list").data("aid",aid);
                if(b!=""&&typeof(b)!="undefined"){
                    EnterGetAgentController.h(b);
                }
                else{
                    var job=new Jobs();
                    job.GetCDJobs(that.h, that.i);
                }
            });
        }
    },
    /*
     * 功能：委托职位付费提示
     * 参数：
     * b：职位id
     */
    h:function(b){
        paytipController.CDeleJobTip(EnterGetAgentController.ha, [b], "#e_agent_list a.position_delgate");
    },
    /*
     * 功能：委托职位
     * 参数：
     * b：职位id
     */
    ha:function(b){
        var a=$("#e_agent_list").data("aid");
        var that=engetAgentRender;
        var jb=new Jobs();
        jb.DeleJobs(a, b[0], that.k, that.j);
    },
    /*
     * 功能：获取委托职位id后再委托职位
     * 参数：
     * b：职位id
     */
    i:function(obj){
        var b=$("#cdres_list").find("li input[name='sjob']:checked").parent().attr("jid");
        EnterGetAgentController.h(b);
    },
    /*
     *功能：初始化页面
     *jack
     *2012-2-12
     */
    iniPage:function(){
        baseRender.ae(3);
        this.iniArea();/*初始化地区选择插件*/
        this.b(0);/*获取猎头列表*/
        this.e();/*条件筛选查询*/
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="41"){
        //初始化页面js等
        EnterGetAgentController.iniPage();
    }
});





