/*
 * 猎头职位管理控制器
 */
var MycertController={
    /*
     * 功能：初始化资质证书
     * 参数：
     * 无
     */
    a:function(){
        $("#tqual").hgsSelect({
            id:"tqselect",     //设置选择框父容器id
            pid:"tregplace",    //省市添加的父容器id
            pshow:true,        //是否显示地区选择
            sprov:true,        //是否只精确到省
            single:true,       //省是否为单选
            sure:mycertRender.a
        });
    },
    /*
     * 功能：初始化到期提醒
     * 参数：
     * 无
     */
    b:function(){
        $("#detime").datepicker({
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
     * 功能：文件上传
     * 参数：
     * 无
     */
    c:function(){
        /*上传证书图片*/
        var that=$('input.files');
        if(that.length>0){
            this.ac(that);
        }
    },
    /*
     * 功能：文件上传事件绑定
     * 参数：
     * obj：绑定对象
     */
    ac:function(obj){
        $(obj).bind('change',function(){
            mycertRender.l(this);
        });
    },
    /*
     * 功能：确定文件上传按钮事件绑定
     * 参数：
     * obj：当前文件上传表单
     */
    d:function(obj){
        var that=$(obj);
        that.parent().find("a.asubmit").unbind("click").bind("click",function(){
            that.parent().parent().find("a.asubmit").removeClass("cur_file");
            $(this).addClass("cur_file");
            $("#upfname").val(that.attr("name"));
            $("#upfcid").val($(this).parent().find("div").attr("cid"));
            mycertRender.f(that);
        });
    },
    /*
     * 功能：证书绑定初始化
     * 参数：
     * 无
     */
    e:function(){
        var that=$('#form_upload table td div a.delecert');
        if(that.length>0){
            that.bind('click',function(){
                mycertRender.l(this);
            });
        }
    },
    /*
     * 功能：证书删除事件绑定
     * 参数：
     * obj：当前绑定对象
     */
    f:function(obj){
        $(obj).bind('click',function(){
            var a=$(this).parent().attr("cid");
            $(this).parent().parent().parent().remove();
            var that=mycertRender;
            var ct=new Cert();
            ct.DeleTCert(a, null, that.n);
        });
    },
    /*
     * 功能：证书添加事件绑定
     * 参数：
     * 无
     */
    g:function(){
        $("#savebtn").bind('click',function(){
            $("#tqual").trigger("blur");
            var par=$("table.tb_cert");
            if(par.find("div.tip").length==0){
                var slt=par.find("input.qual_select");
                var a="",
                b="",
                c="";
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
                        a+=","+tmp;
                        b+=","+$(o).data("rid");
                        c+=","+$(o).data("prov");
                    }
                    else if(i==0&&tmp!=""){
                        a+=tmp;
                        b+=$(o).data("rid");
                        c+=$(o).data("prov");
                    }
                });
                var that=mycertRender;
                var ct=new Cert();
                ct.AddTCert(a, c, b, that.o, that.p);
            }
        });
    },
    /*
     * 功能：证书验证
     * 参数：
     * obj：当前绑定对象
     */
    h:function(){
        $("#tqual").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            MycertController.i(this,LANGUAGE.L0159);
        });
    },
    /*
     * 功能：资质类文本框验证
     * 参数：
     * 无
     */
    i:function(id,lan){
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
     * 功能：初始化页面按钮效果
     * 参数：
     * 无
     */
    j:function(){
        baseController.BtnBind("div.btn4", "btn4", "btn4_hov", "btn4_click");
    },
    /*
     * 功能：初始化职称证
     * 参数：
     * 无
     */
    k:function(){
        $("#qtitle").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"tqtitle",
            sure:mycertRender.q
        });
    },
    /*
     * 功能：修改职称证
     * 参数：
     * 无
     */
    l:function(){
        var that=$('#form_upload table td div a.alter');
        if(that.length>0){
            this.la(that);
        }
    },
    /*
     * 功能：修改职称证事件绑定
     * 参数：
     * obj：绑定对象
     */
    la:function(obj){
        $(obj).unbind("click").bind("click",function(){
            mycertRender.r(this);
        });
    },
    /*
     * 功能：添加职称证
     * 参数：
     * 无
     */
    m:function(){
        var ta=["",""];
        var tit=$("#qtitle"),
        a=tit.parent().parent().attr("cid");
        if(tit.data("ids")){
            ta=tit.data("ids").split(",");
        }
        var that=mycertRender;
        var ct=new Cert();
        ct.UpdateTTitle(a, ta[1], ta[0], null, that.p);
    },
    /*
     * 功能：解除职称认证
     * 参数：
     * 无
     */
    n:function(){
        var hti=$("#htit a.opencont");
        if(hti.length>0){
            hti.unbind("click").bind("click",function(){
                var that=mycertRender;
                that.s(this);
                var a=$("#htit").attr("cid");
                var ct=new Cert();
                ct.RemoveTitleCt(a, null, that.p);
            });
        }
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(0);
        this.j();
        this.a();
        //this.b();到期时间绑定
        this.c();
        this.h();
        this.g();
        this.l();
        this.k();
        this.n();
        this.f($("#form_upload table.tb td a.delecert"));
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="57"){
        //初始化页面js等
        MycertController.IniPage();
    }
});
