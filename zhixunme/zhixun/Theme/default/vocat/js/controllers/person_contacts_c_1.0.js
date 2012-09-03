/*我的人脉控制器*/
var personnetController={
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
            items_per_page:CONSTANT.C0004,
            num_display_entries:9,
            current_page:0,
            num_edge_entries:1,
            link_to:"javascript:;"
        });
    },
    /*
     *功能：获取我所关注的人的列表
     *参数：无
     *jack
     *2012-2-20
     */
    b:function(i){
       var that=personnetRender;
       personnetController.get_f_p(i,that.a,that.b);
    },
     /*
     *功能：获取我所关注的人的列表分页回调函数
     *参数：无
     *jack
     *2012-2-20
     */
    c:function(i){
       var that=personnetRender;
       personnetController.get_f_p(i,that.c,that.b);
       that.f();
    },
      /*
     *功能：异步获取我所关注的人的列表
     *参数：page:页数
     *size：每页条数
     *type：用户类型
     *suc:成功执行方法
     *fail：失败执行方法
     *jack
     *2012-2-20
     */
    get_f_p:function(i,suc,fail){
        if(typeof(i)=="undefined"){
        i=0;
        }
        i+=1;
        var p=new Pool();
        var type=$("div#typ_per span.t_p").find("a.red").attr("rel");
        p.GetFocusPersonList(type,i,CONSTANT.C0004,suc,fail);
    },
    /*
     *筛选数据过滤
     *jack
     *2012-2-21
     */
    d:function(){
       $("div#typ_per span.t_p a").bind("click",function(){
            $("div#typ_per span.t_p a").removeClass("red");
            $(this).addClass("red");
            personnetController.b(0);
       });
    },
    /*
     *获取人脉动态列表
     *参数：无
     *jack
     *2012-2-20
     */
    e:function(i){
        var that=personnetRender;
        personnetController.get_net_dynamic(i,that.ret_suc,that.ret_fail);
    },
    /*
     *获取人脉动态分页回调函数
     *参数：无
     *jack
     *2012-2-20
     */
    f:function(i){
       var that=personnetRender;
       personnetController.get_net_dynamic(i,that.gen_netList,that.ret_fail);
       that.f();
    },
    /*
     *异步获取人脉动态
     *参数：
     *i：当前页
     *suc，成功执行方法
     *fail：失败执行方法
     */
    get_net_dynamic:function(i,suc,fail){
      if(typeof(i)=="undefined"){i=0;}
      i+=1;
      var type='';
      type=$("div#network span.person_net").find("a.red").attr("rel");
      var po=new Pool();
      po.GetNetworkDynamicLis(i,CONSTANT.C0004,type,suc,fail);
    },
    /*
     *筛选条件来过滤人脉动态
     *参数：无
     *jack
     *2012-2-21
     */
    g:function(){
       $("div#network span.person_net a").bind("click",function(){
             $("div#network span.person_net a").removeClass("red");
             $(this).addClass("red");
             personnetController.e(0);
       });
    },
    /*
     *初始化页面加载
     */
    iniPage:function(){
        if($("#h_mycontact").length>0||$("#infoid").length>0){
            baseRender.ae(5);
        }else{
            baseRender.ae(4);
        }
        this.b(0);/*初始获取关注列表数据*/
        this.e(0);/*初始获取人脉动态数据*/
        this.d();/*初始化筛选条件*/
        this.g();/*初始化筛选条件*/
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="68"){
        //初始化页面js等
        personnetController.iniPage();
    }
});


