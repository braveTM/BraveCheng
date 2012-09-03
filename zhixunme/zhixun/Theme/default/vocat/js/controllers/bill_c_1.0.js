/*
 * 任务管理控制器
 */
var BillController={
    /*
     * 功能：初始化翻页插件
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     */
    a:function(t){
        var lan=LANGUAGE;
        $("#pagination").pagination(t, {
            callback: BillController.c,
            prev_text: lan.L0066,
            next_text: lan.L0067,
            items_per_page:CONSTANT.C0002,
            num_display_entries:9,
            current_page:0,
            num_edge_entries:1,
            link_to:"javascript:;"
        });
    },
    /*
     * 功能：获取账单详细数据
     * 参数：
     * 无
     */
    b:function(i){
        var that=billRender;
        BillController.d(i, that.a, that.b);
    },
    /*
     * 功能账单详细分页回调函数
     * 参数：
     * 无
     */
    c:function(i){
        var that=billRender;
        BillController.d(i, that.c, that.b);
        that.d();
    },
    /*
     * 功能：获取账单详细数据
     * 参数：
     * i:当前页
     * suc:成功获取数据时的方法
     * fail:失败获取数据时的方法
     */
    d:function(i,suc,fail){
        var a=$("#my_bill input:checked").attr("value");
        a=(a==""?"0":a);
        i+=1;
        var bl=new Bill();
        bl.GetBill(a, i, suc, fail);
    },
    /*
     * 功能：初始化账单详细类别选择时的列表数据刷新和翻页插件重新绑定
     * 参数：
     * i:当前页
     */
    e:function(){
        $("#my_bill input").click(function(){
            BillController.b(0);
            billRender.d();
        });
    },
    /*
     * 功能：初始化确认支付按钮
     * 初始化mod显示情况
     * 参数：
     * 无
     */
    g:function(){
        //初始化按钮效果
        baseController.BtnBind("div.mod div.btn5", "btn5", "btn5_hov", "btn5_click");
        baseController.BtnBind("div.mod div.btn4", "btn4", "btn4_hov", "btn4_click");
        $("div.recharge div.mod:eq(0)").removeClass("hidden");
    },
    /*
     * 功能：初始化确认支付按钮
     * 参数：
     * 无
     */
    h:function(){
        $("#money").trigger("blur");
        if($(".tip").length==0){
            var a=$("#money").val();
            var b=$("ul.cg li.cur_li").find("input[type='radio']:checked").val();
            if(a!=""&&b!=""){
                return true;
            }
            else{
                //event.preventDefault();
                return false;
            }
        }else{
            $("html,body").animate({scrollTop:$("#ipost_task").offset().top},500);
        }
        //event.preventDefault();
        return false;
    },
    /*
     * 功能：充值金额验证绑定
     * 参数：
     * 无
     */
    i:function(){
        $("#money").focus(function(){
            baseRender.a(this, LANGUAGE.L0071, "right" ,22);
        }).blur(function(){
            var msg='';
            var bl=true;
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                msg=LANGUAGE.L0072;
                bl=false;
            }
            else if(!/^(\-?)(\d+)$/.test(str)){
                msg=LANGUAGE.L0073;
                bl=false;
            }
            else if(parseInt(str,10)<5){
                msg=LANGUAGE.L0074;
                bl=false;
            }
            if(bl){
                baseRender.b(this);
            }
            else{
                baseRender.a(this, msg, "error" ,22);
            }
        });
    },
    /*
     *支付方式切换
     *参数：无
     *jack
     *2012-2-23
     */
    k:function(){
       $("ul.cg li").bind("click",function(){
           billRender.i(this);
       });
    },
    /*
     *功能：线下汇款初始化
     *参数：金额
     *money
     */
    l:function(){
        $("#gen_nm").bind("click",function(){
            $("#money").trigger("blur");
             if($(".tip").length==0){
                var a=$("#money").val().replace(new RegExp(" ","g"),"");
                var b=new Bill();
                b.PayOfflineHan(a,billRender.j,billRender.k);
            }else{
                $("html,body").animate({scrollTop:$("#ipost_task").offset().top},500);
            }
        });
    },
    /*
     * 功能：初始化任务管理页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(0);
        this.b(0);
        this.e();
        this.g();
        this.i();
        this.k();
        this.l();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="9"){
        //初始化页面js等
        BillController.IniPage();
    }
});
