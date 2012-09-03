/*
 *企业、猎头我要推广页面控制器
 */
var promoteController={
    /*
     *初始化按钮
     *jack
     *2012-2-23
     */
    a:function(){
        baseController.BtnBind(".btn5", "btn5", "btn5_hov", "btn5_click");
        baseController.BtnBind(".btn4", "btn4", "btn4_hov", "btn4_click");
    },
    /*
     *功能：企业墙品牌推广
     *jack
     *2012-2-23
     */
    b:function(){
        $(".bn div.unhold").bind("mouseover",function(){
            promoteRender.a(this);
        });
        $(".bn div.unhold").bind("mouseout",function(){
            promoteRender.b(this);
        });
    },
    /*
     *功能：初始化购买推广位
     *参数：无
     *jack
     *2012-2-23
     */
    c:function(){
        var that=promoteRender;
        /*推广一*/
        $(".Ap a#atn").bind("click",function(){
            var  fid=$("input[name='iid']").val();
            var days=$("select#Bd")[0].options[$("select#Bd")[0].selectedIndex].value;
            var b=new Bill();
            b.BuyRecmmend(fid,days,that.b_s,that.b_f);
        });
        /*推广二*/
        $(".Ap a#atn_1,.Ep a#etn_1").bind("click",function(){
            var  fid=$("input[name='nid']").val();
            var days=$("select#bd1")[0].options[$("select#bd1")[0].selectedIndex].value;
            var b=new Bill();
            b.BuyRecmmend(fid,days,that.b_s,that.b_f);
        });
    },
    /*
     *企业推广方式三
     *参数：无
     *jack
     *2012-2-27
     */
    g:function(){
         var that=promoteRender;
        $(".Ep a#etn_2").bind("click",function(){
            if($("div.fee_tps span.show_info").hasClass("hidden")){
                alert('请先选择一个品牌位');
            }else{
                var id=$("input[name='number']").val();
                var days=$("select#bd2")[0].options[$("select#bd2")[0].selectedIndex].value;
                var b=new Bill();
              b.RobRecomPos(id,days,that.r_s,that.b_f);
            }
        });
    },
    /*
     *初始化品牌墙图片上传
     *参数：无
     *jack
     *2012-2-27
     */
    d:function(){
        /*上传头像*/
        $('input#file_name').unbind("change").bind('change',function(){
            promoteRender.e(this);
        });
    },
    /*
     *绑定点击事件
     *参数：无
     *jack
     *2012-2-27
     */
    e:function(){
        var len=$(".Ep .bn div.owned").length;
        if(len=="0"){
            $(".bn div.unhold").unbind("click").bind("click",function(){
                promoteRender.c(this);
            });
        }else{
             $(".bn div.unhold").unbind("click");
        }
    },
    /*
     *取消选择品牌位
     *参数：无
     *jack
     *2012-2-27
     */
    f:function(){
        $(".bn div.chosen").unbind("click").bind("click",function(){
            promoteRender.d(this);
        });
    },
    /*
     *初始化共用页面
     *参数：无
     */
    i:function(){
        baseRender.ae(0);
        this.a();
        this.b();/*推广位处理*/
        this.c();/*购买推广位*/
    },
    /*
     *初始化企业页面
     */
    Eini:function(){
        this.d();/*企业墙品牌上传*/
        this.e();/*企业推广墙点击*/
        this.g();/*企业推广方式三*/
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="70"||PAGE=="71"){
        //初始化页面js等
        promoteController.i();
    }
    if(PAGE=="71"){
        promoteController.Eini();
    }

});

