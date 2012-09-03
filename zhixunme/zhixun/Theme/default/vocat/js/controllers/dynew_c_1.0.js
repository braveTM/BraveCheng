/*
 * 用户控制器，页面涉及到用户操作的方法都在这里定义
 */
var dynewsController={
     /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     * id:翻页插件绑定id
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
     * 功能：初始化新闻动态列表
     * 参数：
     * 无
     */
    b:function(i){
        var that=dynewsRender;
        dynewsController.d(i ,that.a, that.c);
    },
    /*
     * 功能：新闻动态列表分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=dynewsRender;
        dynewsController.d(i ,that.b, that.c);
        that.k();
    },
     /*
     * 功能：获取猎头代理的人才列表
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
   d:function(i,suc,fail){
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var msg=new Message();
        msg.GetDynews(i, 6, suc, fail);
    },
    /*
     * 功能：初始化首页
     * 参数：无
     * 无
     */
    iniPage:function(){
        baseRender.ae(0);
        this.a();
        this.b(0);
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="77"){
        //初始化页面js等
        dynewsController.iniPage();
    }
});