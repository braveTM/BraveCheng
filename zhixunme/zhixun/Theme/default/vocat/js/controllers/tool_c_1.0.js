/*
 *市场行情指导控制器
 */
var ToolContrller={
    /************************************** 市场行情 **************************************/
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
     *初始化资质证书选择
     *参数：无
     *jack
     *2012-3-22
     */
    b:function(){
        $("#quali_select").hgsSelect({
            id:"pqselect",             //设置选择框父容器id
            pid:"pregplace",            //省市添加的父容器id
            pshow:false,       //是否显示地区选择
            regshow:false,
            sure:toolRender.a
        });
    },
    /*
     *功能:年份滑动效果/地区hover效果
     *参数:无
     *jack
     *2012-3-22
     */
    c:function(){
        ToolContrller.d("div.ys a","cuy");
        ToolContrller.d("div.provs a","cur_prov");
    },
    /*
     *功能:初始化年份滑动效果/地区hover效果
     *参数：无
     *jack：2012-3-24
     */
    d:function(obj,cls){
        $(obj).bind("click",function(){
            var _self=this;
            $(_self).parent().parent().find("."+cls).removeClass(cls);
            $(_self).addClass(cls);
        });
    },
    /*
     * 功能：市场行情-本月交易价
     * 参数：
     * 无
     */
    e:function(i){
        var that=toolRender;
        ToolContrller.g(i,that.b, that.c);
    },
    /*
     * 功能：市场行情-本月交易价分页回调函数
     * 参数：
     * 无
     */
    f:function(i){
        var that=toolRender;
        ToolContrller.g(i,that.d,that.c);
    },
    /*
     * 功能：获取市场行情-本月交易价列表数据
     * 参数：
     *pid:省份编号   
     *like:关键字
     *page:第几页
     *size:每页几条 
     */
    g:function(i,suc,fail){
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var pid;
        pid=$("div.marea").find("a.cur_prov").attr("rel");  
        var like=$("input#scont").val();
        var mark=new Tool();
        mark.GetDealPrice(pid,like,i,6,suc,fail);
    },
    /*
     *功能：筛选市场行情-交易价格
     *参数：无
     *2012-3-24
     */
    h:function(){
        $("div.marea a").click(function(){
            $(this).parent().parent().find("a.cur_prov").removeClass("cur_prov");
            $(this).addClass("cur_prov");
            ToolContrller.e(0);
        });
        $("#scont").keydown(function(e){
            if(e.keyCode=="13"){
                ToolContrller.e(0);
            }
        });
        $("#sbtn").bind("click",function(){
            ToolContrller.e(0);
        });
    },
    /*
     *功能：初始化走势
     *参数：无
     *2012-3-25
     */
    i:function(){
        var that=toolRender;
        var pid=$("div.yp").find("a.cur_prov").attr("rel");
        var year=$("div.ys").find("a.cuy").attr("rep");
        var cid;
        cid=$("input#zid").val();
        var m=new Tool();
        if(!$("div.ys").find("a.cuy").hasClass("pyears")){
            m.getRequestData(cid,pid,year,that.e,that.f);
        }else{
            m.getYearData(cid,pid,that.g,that.f);
        }
    },
    /*
     *功能：年度走势筛选条件
     *参数：无
     *2012-3-26
     */
    j:function(){
        $("div.yp a").bind("click",function(){
            $(this).parent().parent().find("a.cur_prov").removeClass("cur_prov");
            $(this).addClass("cur_prov");
            ToolContrller.i();
        });
        $("div.ys a").bind("click",function(){
            $(this).parent().find("a.cuy").removeClass("cuy");
            $(this).addClass("cuy");
            ToolContrller.i();
        });
    },
    /************************************** 资讯 - 查询页 **************************************/
    /*
     * 功能：显示不同的查询页
     * 参数：
     * 无
     */
    ra:function(index){
        var that=$("#iframeid"),
        load=$("#ref_loadding");
        var bl=$.browser.msie&&(index>18||index==15);
        if(bl){
            that.css("opacity","0");
        }else{
            that.css("display","none");
        }
        load.css("display","block");
        if(index==null){
            index=location.hash.replace("#","");
            if(index==""){
                index=0;
            }
        }
        var ref=REFERS[index];
        var cls=that.attr("curcls");
        var curcls="curcls"+index;
        that.removeClass(cls).addClass(curcls);
        if($.browser.msie&&$.browser.version=='8.0'){
            curcls+=" curcls"+index+"_8";
            that.addClass("curcls"+index+"_8");
        }
        that.attr("curcls",curcls);
        that.attr("src",ref);
    },
    /*
     * 功能：显示不同的查询页
     * 参数：
     * 无
     */
    rb:function(){
        $("#refs a.a_refer").click(function(){
            $(this).parent().find("a.red").removeClass("red");
            $(this).addClass("red");
            var index=$(this).attr("href").replace("#","");
            ToolContrller.ra(index);
        });
    },
    /*
     * 功能：初始化选项
     * 参数：
     * 无
     */
    rc:function(){
        var index=location.hash;
        if(index==""){
            index=$("#refs a:eq(0)").attr("href").replace("#","");
        }
        $("#refs a.a_refer[href*='"+index+"']").trigger("click");
    },
    /*
     * 功能：初始化选项
     * 参数：
     * 无
     */
    rd:function(){
        var that=$("#iframeid");
        that[0].onload=function(){
            var index=$("#refs a.red").attr("href").replace("#","");
            if($.browser.msie&&(index>18||index==15)){
                that.animate({
                    "opacity":"1"
                },300);
            }else{
                that.fadeIn(300);
            }
            $("#ref_loadding").fadeOut(200);
        }
    },
    /*
     * 功能：初始化选项
     * 参数：
     * 无
     */
    re:function(){
        $("#iframeid").remove();
        $("#ref_loadding").remove();
        $("#nolimit").fadeIn();
    },
    /*
     *市场行情
     */
    IniPage:function(){
        baseRender.ae(0);
        this.b();/*证书选择*/
        this.c();/*年份选择效果*/
        this.e(0);/*初始获取交易价*/
        this.h();
        this.i();
        this.j();
    },
    /*
     *资讯查询
     */
    IniPage1:function(){
        baseRender.ae(0);
        if(!$.browser.mozilla){
            this.rb();
            this.rc();
            this.rd();
        }else{
            this.re();
        }
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    if(PAGE=="88"){
        ToolContrller.IniPage();
    }
    if(PAGE=="94"){
        ToolContrller.IniPage1();
    }

});


