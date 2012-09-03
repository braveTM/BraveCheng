/*
 * 角色注册页面控制器
 */
var registerController={
    /*
     *验证码刷新
     *参数：无
     */
    a:function(){
        $("input,textarea").val("");
        $("#valid_img,#val_anoth").click(function(){
            $("#valid_img").attr("src",WEBROOT+"/rvcode?xy="+Math.random()+"");
        });
    },
    /*
     *功能：初始化选择注册方式
     *参数：无
     */
    b:function(){
        var t=$("div.reg_ops");
        if(t.length>0&&t.find("ul li").length>1){
            t.find("ul li").click(function(){
                registerRender.m(this);
            });
        }
        $("a.exchange").unbind("click").bind("click",function(){
            var th=$("div.reg_ops").find("ul li").eq(1);
            registerRender.m(th); 
        });
        baseController.BtnBind(".btn9", "btn9", "btn9_hov", "btn9_hov");
    },
    /*
     *功能：初始化地区选择插件
     *参数：无
    */
    c:function(){
        $("#place").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"pslt",            //省市添加的父容器id
            pshow:true,       //是否显示地区选择
            sprov:false,       //是否只精确到省
            single:true,       //省是否为单选
            sure:registerRender.l
        });
    },
    /*
     * 功能：表单验证
     * 参数：无
     */
    d:function(){
        /*地区验证*/
        $("#place").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0138;
                b=false;
            }
            if(!b){
                baseRender.a(this,msg,"error");
            }else{
                baseRender.ai(this);
            }
        });
        /*邮箱验证*/
        $("#u_emil").focus(function(){
            baseRender.a(this, LANGUAGE.L0001, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            var that=registerRender;
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
                if($(this).attr("valide")=="0"||$(this).attr("valide")!=str){
                    var ac=new AccountCat();
                    ac.EmailIsUnique(str, that.e, that.f);
                }
                else{
                    baseRender.ai(this);
                }
            }
        });
        /*真实姓名格式验证*/
        $("#u_tname,#ft_name").focus(function(){
            baseRender.a(this, LANGUAGE.L0060, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0068;
                b=false;
            } 
            else if(/[^\u4E00-\u9FA5]/.test(str)){
                msg=LANGUAGE.L0061;
                b=false;
            }else if(str.length>6){
                msg=LANGUAGE.L0234;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*企业名称验证*/
        $("#sub_name").focus(function(){
            baseRender.a(this, LANGUAGE.L0126, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0117;
                b=false;
            } 
            else if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(str)){
                msg=LANGUAGE.L0130;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*企业联系人格式验证*/
        $("#cont_p").focus(function(){
            baseRender.a(this, LANGUAGE.L0135, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0136;
                b=false;
            } 
            else if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(str)){
                msg=LANGUAGE.L0130;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*密码验证*/
        $("#u_pd,#ft_pd").focus(function(){
            baseRender.a(this, LANGUAGE.L0009, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            var len=str.length;
            if(len==0){
                msg=LANGUAGE.L0010;
                b=false;
            }
            else if(len>0&&len<6){
                msg=LANGUAGE.L0011;
                b=false;
            }
            else if(len>16){
                msg=LANGUAGE.L0012;
                b=false;
            }
            else if(!/^[A-Za-z0-9/!/@/#/$/%/^/&/*/_]{4,16}$/.test(str)){
                msg=LANGUAGE.L0013;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*重复密码*/
        $("#co_pd,#ftco_pd").focus(function(){
            baseRender.a(this, LANGUAGE.L0016, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            var pstr=$(this).parent().parent().parent().prev().find("input[type='password']").val(); 
            var len=str.length;
            if(len==0){
                msg=LANGUAGE.L0010;
                b=false;
            }
            else if(str!=pstr){
                b=false;
                msg= LANGUAGE.L0017;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*人才/经纪人电话号码验证*/
        $("#u_phone").focus(function(){
            baseRender.a(this,LANGUAGE.L0039, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0041;
                b=false;
            }
            else{
                var x=baseRender.d(str);
                if(x==false)
                {
                    msg=LANGUAGE.L0040;
                    b=false;
                }
                else{
                    b=true;
                    baseRender.ai(this);
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
         $("#s_phone").focus(function(){
            baseRender.a(this,LANGUAGE.L0039, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            else{
                var x=baseRender.d(str);
                if(x==false)
                {
                    msg=LANGUAGE.L0040;
                    b=false;
                }
                else{
                    b=true;
                    baseRender.ai(this);
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*固定电话验证*/
        $("#cphone").focus(function(){
            baseRender.a(this,LANGUAGE.L0232, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0233;
                b=false;
            }
            else{
                if(!/^\d{3,4}-\d{7,8}(-\d{3,4})?$/.test(str))
                {
                    msg=LANGUAGE.L0040;
                    b=false;
                }
                else{
                    b=true;
                    baseRender.ai(this);
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*个人介绍*/
        $("#u_detail").focus(function(){  
            baseRender.a(this,LANGUAGE.L0042, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            else if(str.length>140){
                msg=LANGUAGE.L0043;
                b=false;
            }
            //                else if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(str)){
            //                    msg=LANGUAGE.L0130;
            //                    b=false;
            //                }
            else{
                b=true;
                baseRender.ai(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*企业简介*/
        $("#sub_detail").focus(function(){  
            baseRender.a(this,LANGUAGE.L0137, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            else if(str.length>140){
                msg=LANGUAGE.L0043;
                b=false;
            }
            else{
                b=true;
                baseRender.ai(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*所属猎头公司*/
        $("#u_bagent").focus(function(){
            baseRender.a(this, LANGUAGE.L0129, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            else {
                if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(str)){
                    msg=LANGUAGE.L0130;
                    b=false;
                }
                else{
                    b=true; 
                    baseRender.ai(this);
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*验证码*/
        $("#u_valid,#pber").focus(function(){
            baseRender.b(this);
        });
        baseController.BtnBind(".btn5", "btn5", "btn5_hov", "btn5_click");
    },
    /*
     *功能：提交人才注册(电子邮箱注册)
     *参数：
     */
    e:function(){
        $("#u_next").bind("click",function(){
            $("#u_emil,#u_pd,#co_pd,#u_tname").trigger("blur");
            if($("input[name='aggree']").attr("checked")=="checked"){
                if($("#u_valid").val()==""){
                    baseRender.a("#u_valid",LANGUAGE.L0133,"error");
                }else if($("div.tip.error").length==0){
                    var ta=["",""],c="",d="",e="";
                    if($("#etitle_selt").data("ids")){
                        ta=$("#etitle_selt").data("ids").split(",");
                    }
                    var slt=$("#equal_select");
                    $.each(slt,function(i,o){
                        var tmp="";
                        var mid=$(o).data("mid");
                        var zid=$(o).data("zid");
                        if(!!mid){
                            tmp=mid;
                        }
                        else if(!!zid){
                            tmp=zid;
                        }
                        if(i>0&&tmp!=""){
                            c+=","+tmp;
                            d+=","+$(o).data("rid");
                            e+=","+$(o).data("prov");
                        }
                        else if(i==0&&tmp!=""){
                            c+=tmp;
                            d+=$(o).data("rid");
                            e+=$(o).data("prov");
                        }
                    });
                    var p={
                        a:ta[1],
                        b:ta[0],
                        c:c,
                        d:d,
                        e:e,
                        type:"1",
                        email:$("#u_emil").val(),
                        pword:$("#u_pd").val(),
                        name:$("#u_tname").val(),
                        verify:$("#u_valid").val()
                    }
                    $(this).css("color","#aaa");
                    $(this).parent().removeClass("btn5").addClass("btn7");
                    $(this).css("cursor","wait");
                    document.body.style.cursor = "wait";
                    var am=new AccountCat();
                    var th=registerRender;
                    am.TalentEmailRegister(p,th.i,th.j);
                }
            }else{
                alert(LANGUAGE.L0132);
            }
        });
    },
    /*
     *功能：人才注册(手机号码注册)
     *参数：无
     */
    aa:function(){
        $("#phone_next").click(function(){
            $("#ft_pd,#ftco_pd,#u_phone,#ft_name").trigger("blur");
            if($("input[name='rule']").attr("checked")=="checked"){
                if($("#pber").val()==""){
                    baseRender.a("#pber",LANGUAGE.L0133,"error");
                }else if($("div.tip.error").length==0){
                    var ta=["",""],c="",d="",e="";
                    if($("#jtitle_selt").data("ids")){
                        ta=$("#jtitle_selt").data("ids").split(",");
                    }
                    var slt=$("#jqual_select");
                    $.each(slt,function(i,o){
                        var tmp="";
                        var mid=$(o).data("mid");
                        var zid=$(o).data("zid");
                        if(!!mid){
                            tmp=mid;
                        }
                        else if(!!zid){
                            tmp=zid;
                        }
                        if(i>0&&tmp!=""){
                            c+=","+tmp;
                            d+=","+$(o).data("rid");
                            e+=","+$(o).data("prov");
                        }
                        else if(i==0&&tmp!=""){
                            c+=tmp;
                            d+=$(o).data("rid");
                            e+=$(o).data("prov");
                        }
                    });
                    var p={
                        a:ta[1],
                        b:ta[0],
                        c:c,
                        d:d,
                        e:e,
                        phone:$("#u_phone").val(),
                        pword:$("#ft_pd").val(),
                        name:$("#ft_name").val(),
                        code:$("#pber").val()
                    }
                    $(this).css("color","#aaa");
                    $(this).parent().removeClass("btn5").addClass("btn7");
                    $(this).css("cursor","wait");
                    document.body.style.cursor = "wait";
                    var am=new AccountCat();
                    var th=registerRender;
                    am.TalentMobileRegister(p,th.i,th.j);
                }
            }else{
                alert(LANGUAGE.L0132);
            }
        });
    },
    /*
     *初始化验证码发送状态(申请)
     *jack
     *2012-2-2
     */
    ab:function(){
        var time=$(".ftx-01").text();
        $(".ftx-01").text(time-1);
        if(time==1){
            $("#countDown").hide();
            $("em.gtcode").removeClass("hidden");
            $("#v_send").removeClass("btn_gray").addClass("btn_normal").removeAttr("disabled");
            $("#u_phone").removeClass("text-none").removeAttr("disabled");
            $("#v_send").removeClass("clicked");
        }else{
            setTimeout(registerController.ab,1000);
        }
    },
    /*
     *功能：发送验证码到手机
     *参数：无
     */
    ac:function(){
        $("#v_send").click(function(){
            if($("#v_send").attr("disabled")){
                return;
            }
            var pv=$("#u_phone").val();
            if(pv==""){
                baseRender.a("#u_phone",LANGUAGE.L0030,"error");
            }
            else{
                if(!$(this).hasClass("clicked")){
                    $(this).addClass("clicked");
                    $(".ftx-01").text(59);
                    var ac=new AccountCat();
                    var th=registerRender;
                    ac.SendRegisterNuber(pv,th.n,th.o);
                }
            }
        });  
    },
    /*
     * 功能：提交猎头注册
     */
    f:function(){
        $("#ag_nex").click(function(){
            $("#u_emil,#u_pd,#co_pd,#u_tname,#u_phone,#u_valid,#place").trigger("blur");
            if($("input[name='aggree']").attr("checked")=="checked"){
                if($("#u_valid").val()==""){
                    baseRender.a("#u_valid",LANGUAGE.L0133,"error");
                }else if($("div.tip.error").length<=0){
                    var p={
                        type:"3",
                        email:$("#u_emil").val(),
                        pword:$("#u_pd").val(),
                        phone:$("#u_phone").val(),
                        service:0,//服务类别
                        com:$("#u_bagent").val(),
                        summary:$("#u_detail").val(),
                        name:$("#u_tname").val(),
                        pid:$("input[name='t_prov']").val(),
                        cid:$("input[name='t_city']").val(),
                        verify:$("#u_valid").val()
                    }
                    $(this).css("color","#aaa");
                    $(this).parent().removeClass("btn5").addClass("btn7");
                    $(this).css("cursor","wait");
                    document.body.style.cursor = "wait";
                    var am=new AccountCat();
                    var th=registerRender;
                    am.AgentRegister(p, th.i,th.j);
                }
            }else{
                alert(LANGUAGE.L0132);
            }
        });
    },
    /*
     * 功能：提交企业注册
     * 参数：
     */
    g:function(){
        $("#en_next").click(function(){
            $("#u_emil,#u_pd,#co_pd,#sub_name,#s_phone,#cont_p,#place,#cphone").trigger("blur");
            if($("input[name='aggree']").attr("checked")=="checked"){
                if($("#u_valid").val()==""){
                    baseRender.a("#u_valid",LANGUAGE.L0133,"error");
                }else if($("div.tip.error").length<=0){
                    var p={
                        type:"2",
                        email:$("#u_emil").val(),
                        pword:$("#u_pd").val(),
                        phone:$("#s_phone").val(),
                        company_phone:$("#cphone").val(),
                        ca:$("#sub_attr")[0].options[$("#sub_attr")[0].selectedIndex].value,/*企业性质*/
                        summary:$("#sub_detail").val(),/*企业简介*/
                        name:$("#sub_name").val(),/*企业名称*/
                        cname:$("#cont_p").val(),/*联系人姓名*/
                        pid:$("input[name='t_prov']").val(),
                        cid:$("input[name='t_city']").val(),
                        verify:$("#u_valid").val()
                    }
                    $(this).css("color","#aaa");
                    $(this).parent().removeClass("btn5").addClass("btn7");
                    $(this).css("cursor","wait");
                    document.body.style.cursor = "wait";
                    var am=new AccountCat();
                    var th=registerRender;
                    am.EnterpriseRegister(p, th.i,th.j);
                }
            }else{
                alert(LANGUAGE.L0132);
            }
        });
    },
    /*
     * 功能：手机注册 - 资质证书、职称证书初始化
     * 参数：
     * 无
     * candice 2012-7-7
     * 无修改
     */
    h:function(){
        $("#jqual_select").hgsSelect({
            id:"tqselect",     //设置选择框父容器id
            pid:"tregplace",    //省市添加的父容器id
            pshow:true,        //是否显示地区选择
            sprov:true,        //是否只精确到省
            single:true,       //省是否为单选
            sure:registerRender.a
        });
        $("#jtitle_selt").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"jobtitles",
            sure:registerRender.b
        });
    },
    /*
     * 功能：邮箱注册 - 资质证书、职称证书初始化
     * 参数：
     * 无
     * candice 2012-7-7
     * 无修改
     */
    i:function(){
        $("#equal_select").hgsSelect({
            id:"eqselect",     //设置选择框父容器id
            pid:"eregplace",    //省市添加的父容器id
            pshow:true,        //是否显示地区选择
            sprov:true,        //是否只精确到省
            single:true,       //省是否为单选
            sure:registerRender.a
        });
        $("#etitle_selt").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"eobtitles",
            sure:registerRender.b
        });
    },
    /*
     * 功能：初始化公共页面
     * 参数：无
     */
    IniPage:function(){
        this.a();/*更换验证码*/
        this.c();/*地区选择*/
        this.d();/*表单*/
    },
    /*
     * 功能：初始化人才注册页面
     * 参数：无
     */
    IniTpage:function(){
        this.b();/*初始化tab*/
        this.e();/*邮箱方式注册*/
        this.aa();/*手机方式注册*/
        this.ab();/*初始发送状态*/
        this.ac();/*发送验证码到手机*/    
        this.h();
        this.i();
    },
    /*
     * 功能：初始化猎头注册页面
     * 参数： 无
     */
    iniApage:function(){
        this.f();/*提交猎头注册*/
    },
    /*
     * 功能：初始化企业注册页面
     * 参数：无
     */
    iniEpage:function(){
        this.g();/*提交企业注册*/
    }
};
$().ready(function(){
    var that=registerController;
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="2"||PAGE=="45"||PAGE=="46"||PAGE=="47"){
        //初始化页面js等
        that.IniPage();
    }
    if(PAGE=="45"){
        that.IniTpage();/*人才注册*/
    }
    if(PAGE=="46"){
        that.iniApage();/*猎头注册*/
    }
    if(PAGE=="47"){
        that.iniEpage();/*企业注册*/
    }
});