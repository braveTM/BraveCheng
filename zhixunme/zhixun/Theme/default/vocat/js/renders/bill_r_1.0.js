/*
 * 我的账单渲染器
 */
var billRender={
    /*
     * 功能：成功异步获取任务列表
     * 参数：
     * data：后台返回数据
     */
    a:function(data){
        var count=billRender.c(data);
        BillController.a(count);
    },
    /*
     * 功能：失败异步获取任务列表
     * 参数：
     * data：后台返回数据
     */
    b:function(data){
        BillController.a(0);
        $("#mybilllist").html("<li class='no-data'>暂无数据!</li>");
    },
    /*
     * 功能：成功异步获取任务列表
     * 参数：
     * data：后台返回数据
     */
    c:function(data){
        var dt=data.data;
        $.each(dt, function(i,o){
            if(o.type=="1"){
                o["class"]="green";
                o["zf"]="+";
            }
            else{
                o["class"]="red";
                o["zf"]="-";
            }
        });
        var count=data.count;
        var varr=['title','money','date','class','zf'];
        HGS.Base.GenTemp("mybilllist",varr,dt,TEMPLE.T00018);
        return count;
    },
    /*
     * 功能：定位到列表顶部
     * 参数：
     * data：后台返回数据
     */
    d:function(){
        $("html,body").animate({
            scrollTop:$("#ipost_task").offset().top-60
        },500);
    },
    /*
     * 功能：成功异步获取任务列表
     * 参数：
     * data：后台返回数据
     */
    f:function(){
        alert("suc");
    },
    /*
     * 功能：失败异步获取任务列表
     * 参数：
     * data：后台返回数据
     */
    g:function(){
        alert("suc");
    },
    /*
     *功能：支付方式切换
     *参数：无
     *jack
     *2012-2-23
     */
    i:function(_t){
         $("ul.cg li").find("input[type='radio']").removeAttr("checked");
        $("div.mod").addClass("hidden");
        $("ul.cg li").removeClass("cur_li").find("span.pointer").remove();
        $(_t).addClass("cur_li").append('<span class="pointer"></span>').find("input[type='radio']").attr("checked",'checked');
        var inde= $("ul.cg li.cur_li").index();
        $("div.mod:eq("+inde+")").removeClass("hidden");
    },
    /*
     *功能：成功生成汇款订单号并返回
     *参数：无
     *jack
     *2012-2-24
     */
    j:function(ret){
        var data=ret.data;
        $("div.g_n").remove();
        $("div.odr").removeClass("hidden");
        $("div.odr em.red").text(data);
    },
    /*
     *功能：失败返回错误信息
     *参数：无
     *jack
     *2012-2-24
     */
    k:function(ret){
        alert(ret.data);
    }
};