/*
 * 猎头创建兼职简历控制器
 */
var CpresumeController={
    /*
     * 功能：初始化所在地
     * 参数：
     * 无
     */
    a:function(){
        $("#place").hgsSelect({
            type:"place",//选择框类型
            pid:"uplace",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:false,//是否只精确到省
            single:true,  //是否为单选
            sure:cpresumeRender.a
        });
    },
    /*
     * 功能：资质类文本框验证
     * 参数：
     * 无
     */
    b:function(id,lan){
        var msg='';
        var bl=true;
        var str=$(id).val().replace(new RegExp(" ","g"),"");
        if(str==""){
            msg=lan;
            bl=false;
        }
        if(!bl){
            baseRender.a(id, msg, "error",0);
        }
        else{
            baseRender.b(id);
        }
    },
    /*
     * 功能：初始化地区验证、资质证书验证、期望注册地验证
     * 参数：
     * 无
     */
    c:function(){
        $("#tqual").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            CpresumeController.b(this,LANGUAGE.L0159);
        });
        $("#explace").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            CpresumeController.b(this,LANGUAGE.L0160);
        });
    },
    /*
     * 功能：初始化资质证书
     * 参数：
     * 无
     */
    d:function(){
        $("#tqual").hgsSelect({
            id:"tqselect",
            pid:"tqplace",
            pshow:true,
            sprov:true,
            single:true,
            sure:cpresumeRender.b
        });
    },
    /*
     * 功能：初始化职称证
     * 参数：
     * 无
     */
    e:function(){
        $("#tjtitle").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"tjtitles",
            sure:cpresumeRender.f
        });
    },
    /*
     * 功能：初始化期望注册地
     * 参数：
     * 无
     */
    f:function(){
        $("#explace").hgsSelect({
            type:"place",//选择框类型
            pid:"expplace",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:true,//是否只精确到省
            single:false,  //是否为单选
            sure:cpresumeRender.g
        });
    },
    /*
     * 功能：初始化生日
     * 参数：
     * 无
     */
    g:function(){
        $("#date").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true
        });
    },
    /*
     * 功能：初始化姓名验证
     * 参数：
     * 无
     */
    i:function(){
        $("#uname").focus(function(){
            baseRender.a(this, LANGUAGE.L0161, "right" ,0);
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
                baseRender.a(this, msg, "error", 0);
            }
            else{
                baseRender.ai(this,20);
            }
        });
    },
    /*
     * 功能：初始化手机验证
     * 参数：
     * 无
     */
    j:function(){
        $("#phone").focus(function(){
            baseRender.a(this,LANGUAGE.L0039, "right", 0);
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
                var y=baseRender.d(str);
                if(y==false)
                {
                    msg=LANGUAGE.L0040;
                    b=false;
                }
                else{
                    b=true;
                    baseRender.ai(this,20);
                }
            }
            if(!b){
                baseRender.a(this, msg, "error", 0);
            }
        });
    },
    /*
     * 功能：初始化期望待遇验证
     * 参数：
     * 无
     */
    k:function(){
        $("#defpay").focus(function(){
            baseRender.a(this, LANGUAGE.L0163, "right",30);
        }).blur(function(){
            var msg='';
            var bl=true;
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                msg=LANGUAGE.L0164;
                bl=false;
            }
            else if(!/(^(\-?)\d{1,5}\.\d{1,2}$)|(^(\-?)\d{1,5}$)/.test(str)){
                msg=LANGUAGE.L0248;
                bl=false;
            }
            else if(parseFloat(str,10)<0){
                msg=LANGUAGE.L0166;
                bl=false;
            }
            if(bl){
                baseRender.ai(this,50);
            }
            else{
                baseRender.a(this, msg, "error",30);
            }
        });
    },
    /*
     * 功能：创建新兼职简历
     * 参数：
     * 无
     */
    l:function(){
        baseController.BtnBind("div.tmanage div.addtalents div.btn5", "btn5", "btn5_hov", "btn5_click");
        baseController.BtnBind("div.tmanage div.addtalents div.btn8", "btn8", "btn8_hov", "btn8_click");
        $("#pubresnow,#savebtn").click(function(){
           $("div").data("obj",$(this));
            var ids="#uname,#phone,#place,#tqual,#explace";
            $(ids).trigger("blur");
            if($("div.addtalents").find("div.tip").length==0){
                var ta=["",""];
                if($("#tjtitle").data("ids")){
                    ta=$("#tjtitle").data("ids").split(",");
                }
                var a=$("#uname").val(),
                b=$("div.addtalents table.pinfo input[name='sex']:checked").val(),
                c=$("#date").val(),
                d=$("#place").data("prov"),
                e=$("#place").data("city"),
                f=$("#phone").val(),
                g=$("#uqq").val(),
                h=$("#uemail").val(),
                i=$("#uexp").val(),
                j="",
                k="",
                l="",
                m=ta[1],
                n=ta[0],
                o=$("#expay")[0].options[$("#expay")[0].selectedIndex].value,
                o1=$("#defpay").val(),                                
                p=$("#explace").data("ids"),
                q=$(this).attr("type"),
                r=$("#add_des").val();
                var slt=$("table.tb").not("table.pinfo").find("input.qual_select");
                if(o!=12){
                   o1=0; 
                }
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
                        j+=","+tmp;
                        k+=","+$(o).data("rid");
                        l+=","+$(o).data("pid");
                    }
                    else if(i==0&&tmp!=""){
                        j+=tmp;
                        k+=$(o).data("rid");
                        l+=$(o).data("pid");
                    }
                });
                $(this).css("cursor","wait");
               document.body.style.cursor = "wait";
                var that=cpresumeRender;
                var res=new Resume();
                res.ACreatPResume(a, b, c, d, e, f, g, h, i, j, k, l, m, n, o,o1,p, q, r, that.h, that.i);
            }
        });
    },
    /*
     * 功能：初始化期望待遇
     * 参数：
     * 无
     */
    m:function(){
        cpresumeRender.j();
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(1);
        this.a();
        this.c();
        this.d();
        this.e();
        this.f();
        this.g();
        this.i();
        this.j();
        this.k();
        this.l();
        this.m();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="83"){
        //初始化页面js等
        CpresumeController.IniPage();
    }
});
