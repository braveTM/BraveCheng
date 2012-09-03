/*
 * 委托详细页控制器
 */
var DeleDetailController={
    /*
     * 功能：初始化联系方式
     * 参数：
     * 无
     */
    a:function(){
        $("#t_con_way input").click(function(){
            deledetailRender.a(this);
        });
    },
    /*
     * 功能：邮箱验证
     * 参数：
     * 无
     */
    b:function(){
        $("#t_cont_em").focus(function(){
            baseRender.a(this, LANGUAGE.L0001, "right");
        }).blur(function(){
            var str=$(this).val();
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0002;
                b=false;
            }
            else if(!/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(str)){
                msg=LANGUAGE.L0003;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.b(this);
            }
        });
    },
    /*
     * 功能：电话验证
     * 参数：
     * 无
     */
    c:function(){
        $("#t_cont_tel").focus(function(){
            baseRender.a(this, LANGUAGE.L0029, "right");
        }).blur(function(){
            var str=$(this).val();
            var msg="";
            var b=true;
            var tel=/^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/.test(str);
            var pho=/^1\d{10}$/.test(str);
            if(str==""){
                msg=LANGUAGE.L0030;
                b=false;
            }
            else if(!(tel||pho)){
                msg=LANGUAGE.L0031;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.b(this);
            }
        });
    },
    /*
     * 功能：QQ验证
     * 参数：
     * 无
     */
    d:function(){
        $("#t_cont_qq").focus(function(){
            baseRender.a(this, LANGUAGE.L0032, "right");
        }).blur(function(){
            var str=$(this).val();
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0033;
                b=false;
            }
            else if(!/^[1-9][0-9]{4,}/.test(str)){
                msg=LANGUAGE.L0034;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.b(this);
            }
        });
    },
    /*
     * 功能：初始化任务发布页按钮效果
     * 参数：
     * 无
     */
    e:function(){
        var that=baseController;
        that.BtnBind("#accept div.btn5", "btn5", "btn5_hov", "btn5_click");
        that.BtnBind("#refuse div.btn3", "btn3", "btn3_hov", "btn3_click");
    },
    /*
     * 功能：接受委托
     * 参数：
     * 无
     */
    f:function(){
        $("#accbtn,#refbtn").click(function(){
            var tid=$(this).attr("id");
            var that=deledetailRender;
            if(tid=="accbtn"){
                var ids="";
                var cont=$("#t_con_way input:checked");
                if(cont.length!=0){
                    $.each(cont,function(i,o){
                        if(i==0){
                            ids+="#"+$(o).attr("name");
                        }
                        else{
                            ids+=",#"+$(o).attr("name");
                        }
                    });
                }
                else{
                    var ck=$("#t_con_way input:eq(0)");
                    ck[0].checked=true;
                    that.a(ck);
                    ids+=",#"+ck.attr("name");
                }
                $(".tip").remove();
                $(ids).trigger("blur");
            }
            if($(".tip").length==0||tid=="refbtn"){
                var a=$(this).attr("did");
                var b=$("#t_cont_tel").val();
                var c=$("#t_cont_em").val();
                var d=$("#t_cont_qq").val();
                var e=$("#rep_content").val();
                var f=(tid=="accbtn"?"4":"3");
                var dl=new Delegate();
                dl.ReplyDele(a, b, c, d, e, f, that.b, that.c);
            }
        });
    },
    /*
     * 功能：初始化联系方式绑定
     * 参数：
     * 无
     */
    g:function(){
        var par=$("#t_con_way");
        var items=par.next().find("div.t_con_item input");
        $.each(items,function(i,o){
            var name=$(o).attr("id");
            var val=$(o).val();
            if(val!=""&&val!="暂无"){
                par.find("input[name*='"+name+"']").trigger("click");
            }else{
                $(o).val("");
            }
        });
    },
    /*
     * 功能：私信详细 - 回复标题初始化
     * 参数：
     * 无
     */
    h:function(){
        $("#rep_title").focus(function(){
            if($(this).val()==$(this).attr("cval")){
                $(this).val("");
                $(this).removeClass("syscolor");
            }
        }).blur(function(){
            if($(this).val()==""){
                $(this).val($(this).attr("cval"));
                $(this).addClass("syscolor");
            }else{
                if(!$(this).val().match("回复<")){
                    $(this).val("回复<"+$(this).val()+">");
                }
            }
        });
    },
    /*
     * 功能：私信详细 - 回复内容初始化
     * 参数：
     * 无
     */
    i:function(){
        $("#rep_content").focus(function(){
            if($(this).hasClass("red")){
                $(this).val("");
                $(this).removeClass("red");
            }
        }).blur(function(){
            if($(this).val()==""){
                $(this).val("回复内容不能为空!");
                $(this).addClass("red");
            }
        });
    },
    /*
     * 功能：私信详细 - 回复私信
     * 参数：
     * b：对方编号
     * c：对方名称
     * d：站内信标题
     * e：站内信内容
     */
//    j:function(){
//        $("#replaymsg").click(function(){
//            var cont=$("#rep_content");
//            cont.trigger("blue");
//            if(!cont.hasClass("red")){
//                var a=$(this).attr("uid"),
//                b=$(this).attr("uname"),
//                c=$("#rep_title").val(),
//                d=$("#rep_content").val();
//                var that=deledetailRender;
//                var ms=new Message();
//                ms.SendMessage(a, b, c, d, that.d, that.c);
//            }
//        });
//    },
    /*
     * 功能：私信详细 - 初始化回复标题内容
     * 参数：
     * b：对方编号
     * c：对方名称
     * d：站内信标题
     * e：站内信内容
     */
//    k:function(){
//        var cur=$("#rep_title");
//        var str=cur.val();
//        if(!str.match("回复<")){
//            cur.val("回复<"+str+">");
//            cur.attr("cval","回复<"+str+">");
//        }
//    },
    /*
     * 功能：初始化委托详细页
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(3);
        if($("div.replay_area").length>0){
            this.a();
            this.b();
            this.c();
            this.d();
            this.e();
            this.f();
            this.g();
        }
    },
    /*
     * 功能：初始化私信详细页
     * 参数：
     * 无
     */
    IniPage1:function(){
        baseRender.ae(0);
        //this.k();
        this.h();
        this.i();
        //this.j();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="24"){
        //初始化页面js等
        DeleDetailController.IniPage();
    }
    if(PAGE=="13"){
        //初始化页面js等
        DeleDetailController.IniPage1();
    }
});
