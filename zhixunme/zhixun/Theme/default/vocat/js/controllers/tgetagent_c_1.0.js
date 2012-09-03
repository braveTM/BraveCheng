var TanGetAgentController={
    /*
     *初始化地区选择
     *jack
     *2012-2-12
     */
    iniArea:function(){
        $("#from_area").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"pslt",            //省市添加的父容器id
            pshow:true,       //是否显示地区选择
            sprov:false,       //是否只精确到省
            lishow:true,//是否显示不限省份
            single:true,     //省是否为单选
            sure:tgetAgentRender.a
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
        var that=tgetAgentRender;
        TanGetAgentController.d(i,that.b, that.c);
    },
    /*
     * 功能：获取猎头列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=tgetAgentRender;
        TanGetAgentController.d(i, that.d, that.c);
        that.h();
    },
    /*
     * 功能：获取猎头列表数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(p,suc,fail){
        var pid,cid;
        if(typeof(p)=="undefined"){
            p=0;
        }
        else{
            p=p+1;
        }
        var pol=new Pool();
        var t=$("div.tfagent .ops_filter span").find("a.red").attr("rel");
        pid=$("div.tfagent input[name='prov_id']").val();
        cid=$("div.tfagent input[name='city_id']").val();
        pol.TanGetAgentList(p,CONSTANT.C0004,t,pid,cid,suc,fail);
    },
    /*
     *功能：猎头性质条件筛选查询
     *jack
     *2012-2-12
     */
    e:function(p){
        $("div.tfagent div.ops_filter span a").click(function(){
            $("div.tfagent div.ops_filter span a").removeClass("red");
            $(this).addClass("red");
            TanGetAgentController.b(0);
        });
    },
    /*
     *功能：人才委托简历
     *参数：猎头id
     *兼职类型
     */
    g:function(_cur){
        var aid=$(_cur).attr("rel");
        var type=$("div.tfagent input[name='resuid']").val();
        $("div").data("type",type);
        if(type!=""){
            var po=new Pool();
            po.ApplyAgentResme(aid,type,tgetAgentRender.app_succ,tgetAgentRender.app_fail);
        }else{
            baseController.InitialSureDialog("error", LANGUAGE.L0195, "select", LANGUAGE.L0196,tgetAgentRender.g);
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
                        po.ApplyAgentResme(aid,t,tgetAgentRender.app_succ,tgetAgentRender.app_fail);
                        $("div.sure_dialog").remove();
                    }, null, _cur);
                }
            });
        }
    },
    /*
     *功能：初始化页面
     *jack
     *2012-2-12
     */
    iniPage:function(){
        baseRender.ae(4);
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
    if(PAGE=="36"){
        //初始化页面js等
        TanGetAgentController.iniPage();
    }

});


