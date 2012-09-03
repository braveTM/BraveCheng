/* 
 * 人才找企业页控制器
 */
var TfcompanyController={
    /*
     * 功能：初始化地区筛选
     * 参数：
     * 无
     */
    a:function(){
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
            sure:tfcompanyRender.a
        });
    },
    /*
     * 功能：获取可能感兴趣的企业列表
     * 参数：
     * 无
     */
    b:function(i){
        var that=tfcompanyRender;
        TfcompanyController.d(i, that.b, that.c);
    },
    /*
     * 功能：可能感兴趣的企业列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=tfcompanyRender;
        TfcompanyController.d(i, that.d, that.c);
        that.e();
    },
    /*
     * 功能：可能感兴趣的企业列表数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(i,suc,fail){
        var par=$("#plafilter");
        var c=par.data("pid"),
            d=par.data("cid");
        if(typeof(i)=="undefined"){i=0;}
        i+=1;
        var pl=new Pool();
        pl.TGetCompanyList(i, CONSTANT.C0004, c, d, suc, fail);
    },
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻译插件绑定id
     * func:翻页回调函数
     */
    e:function(t,id,func){
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
     * 功能：初始化人才找企业页
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(3);
        this.a();
        this.b();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="38"){
        //初始化页面js等
        TfcompanyController.IniPage();
    }
});