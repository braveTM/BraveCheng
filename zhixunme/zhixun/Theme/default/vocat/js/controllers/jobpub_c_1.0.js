/*
 * 职位发布控制器
 */
var JobpubController={
   
    /*
     * 功能：初始化资质要求
     * 参数：
     * 无
     */
    a:function(){
        $("#jqual_select").hgsSelect({
            id:"jqselect",//资质添加第一步id
            reglishow:true,//是否显示不限注册情况
            cshow:true,//是否显示招聘证书个数
            sure:jobpubRender.a
        });
        $("#qqual_select").hgsSelect({
            id:"qqselect",
            reglishow:true,
            sure:jobpubRender.f
        });
    },
    /*
     * 功能：初始化职称要求
     * 参数：
     * id：绑定对象id
     * tid：插件id
     * func：回调方法
     */
    b:function(){
        $("#jtitle_selt").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"jobtitles",
            sure:jobpubRender.b
        });
        $("#qtitle_selt").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"qjobtitles",
            sure:jobpubRender.g
        });
    },
    /*
     * 功能：初始化地区要求、工作地点要求
     * 参数：
     * 无
     */
    c:function(){
        $("#jpselect").hgsSelect({
            type:"place",//选择框类型
            pid:"place",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:true,//是否只精确到省
            single:false,  //是否为单选
            sure:jobpubRender.c
        });
        $("#qpselect").hgsSelect({
            type:"place",//选择框类型
            pid:"qplace",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:false,//是否只精确到省
            single:true,  //是否为单选
            sure:jobpubRender.h
        });
    },
    /*
     * 功能：初始化证书使用地要求
     * 参数：
     * 无
     */
    d:function(){
        $("#jupselect").hgsSelect({
            type:"place",//选择框类型
            pid:"uplace",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:false,//是否只精确到省
            single:true,  //是否为单选
            sure:jobpubRender.d
        });
    },
    /*
     * 功能：初始化兼职全职表单切换
     * 参数：
     * 无
     */
    e:function(){
        $("#jobtype input[name='intended']").click(function(){
            jobpubRender.e(this);
        });
    },
    /*
     * 功能：初始化验证
     * 参数：
     * id：验证对象
     * lan1：focus的提示
     * lan2：为空时的提示
     * lan3：长度超过时的提示
     * len：长度
     */
    f:function(id,lan1,lan2,lan3,len){
        $(id).focus(function(){
            baseRender.a(this, lan1, "right",0);
        }).blur(function(){
            var msg='';
            var bl=true;
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                msg=lan2;
                bl=false;
            }
            else if(str.length>len){
                msg=lan3;
                bl=false;
            }
            if(bl){
                baseRender.ai(this);
            }
            else{
                baseRender.a(this, msg, "error",0);
            }
        });
    },
    /*
     * 功能：招聘职位
     * 参数：
     * 无
     */
    fg:function(){
        $("#qposition").hgsSlt({
            id:"jobslt",          //选择框id
            title:'职位',         //提示选择的是什么的类别
            tip:'至多可选择1个',  //右上侧提示语
            col_num:3,            //最大列数
            //max_slt:5,            //最大选择个数
            single:true,         //是否为单选
            limit:true,           //是否显示不限
            sure:jobpubRender.o   //确定提交选择结果的时候执行的方法
        });
    },
    /*
     * 功能：删除已选职位
     * 参数：
     * cur：绑定对象
     */
    fh:function(cur){
        $("#slt_pos a").unbind("click").bind("click",function(){
            var that=$(cur);
            var cid=$(this).attr("cid");
            $(this).remove();
            var scids="",spids="",snames="",k=0;
            var cids=that.attr("cids").split(","),
            pids=that.attr("pids").split(","),
            names=that.attr("names").split(",");
            $.each(cids,function(i,o){
                if(o!=cid&&k>0){
                    scids+=","+o,
                    spids+=","+pids[i],
                    snames+=","+names[i];
                    k++;
                }else if(o!=cid&&k==0){
                    scids+=o,
                    spids+=pids[i],
                    snames+=names[i];
                    k++;
                }
            })
            $(cur).attr("cids",scids);
            $(cur).attr("pids",spids);
            $(cur).attr("names",snames);
        });
    },
    /*
     * 功能：初始化标题验证、招聘企业验证、招聘职位验证
     * 参数：
     * 无
     */
    g:function(){
        var lan=LANGUAGE;
        this.f("#jtit,#qtit", lan.L0139, lan.L0140, lan.L0141,30);
        this.fg();
    },
    /*
     * 功能：初始化招聘人数验证
     * 参数：
     * 无
     */
    h:function(){
        $("#percount").focus(function(){
            baseRender.a(this, LANGUAGE.L0148, "right",10);
        }).blur(function(){
            var msg='';
            var bl=true;
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                msg=LANGUAGE.L0149;
                bl=false;
            }
            else if(!/^(\-?)(\d+)$/.test(str)){
                msg=LANGUAGE.L0150;
                bl=false;
            }
            if(bl){
                baseRender.ai(this,30);
            }
            else{
                baseRender.a(this, msg, "error",10);
            }
        });
    },
    /*
     * 功能：初始化按钮效果
     * 参数：
     * 无
     */
    i:function(){
        baseController.BtnBind("div.pub_job div.btn5", "btn5", "btn5_hov", "btn5_click");
    },
    /*
     * 功能：初始化资质要求验证
     * 参数：
     * 无
     */
    j:function(){
        //        $("#jqual_select").focus(function(){
        //            baseRender.b(this);
        //        }).blur(function(){
        //            JobpubController.k(this,LANGUAGE.L0151);
        //        });
        $("#qpselect").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            JobpubController.k(this,LANGUAGE.L0155);
        });
        $("#jpselect").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            JobpubController.k(this,LANGUAGE.L0156);
        });
        $("#jupselect").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            JobpubController.k(this,LANGUAGE.L0157);
        });
    },
    /*
     * 功能：资质类文本框验证
     * 参数：
     * 无
     */
    k:function(id,lan){
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
     * 功能：企业发布全职职位
     * 参数：
     * parm：参数数组
     * [职位发布类型（1为发布，2为委托），
     * 成功回调函数，
     * 失败回调函数]
     * 修改：@jack 2012-7-12
     */
    l:function(parm,ele){
        var ids="#qtit,#percount,#qpselect";
        var jbl=true;
        if($("#slt_pos").children().length==0){
            $("#jtip").removeClass("hidden").addClass("error");
            jbl=false;
        }
       if(!$("table.tbful").find("input.defpay").hasClass("hidden")){
            ids+=",#defpay1";
        }
        $(ids).trigger("blur");
        if($("table.tb").not("table.tb_all").find("div.tip").length==0&&jbl){
             JobpubController.fl(parm,ele);
        }else{
            var that=jobpubRender;
            that.error();
        }
    },
    /*
     * 功能：企业发布全职职位
     * 参数：
     * parm：参数数组
     * [职位发布类型（1为发布，2为委托），
     * 成功回调函数，
     * 失败回调函数]
     * 修改：@jack 2012-7-12
     */
    fl:function(parm,ele){
        var type=parm[0],
        sf=parm[1],
        ff=parm[2];
        var ta=["",""];
        if($("#qtitle_selt").data("ids")){
            ta=$("#qtitle_selt").data("ids").split(",");
        }
        var slt=$("table.tb").not("table.tb_all").find("input.qual_select");
        var a=$("#qtit").val(),
        b=$("#qposition").attr("cids"),
        c=type,
        d=$("#percount").val(),
        e="",
        f="",
        g=ta[1],
        h=ta[0],
        i=$("#qpselect").data("prov"),
        j=$("#thepay").val(),
        j1=$("#defpay1").val(),
        k=$("#degree").val(),
        l=$("#exp").val(),
        m=$("#pos_des").val(),
        n="1",
        o=$("#qpselect").data("city"),
        p=$("input[name='qatg']:checked").val();
        if(j!=12){
            j1=0; 
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
                e+=","+tmp;
                f+=","+$(o).data("rid");
            }
            else if(i==0&&tmp!=""){
                e+=tmp;
                f+=$(o).data("rid");
            }
        });
        $("div").data("obj",ele);
        $(ele).css("cursor","wait");
        document.body.style.cursor = "wait";
        var job=new Jobs();
        job.EPubFullPos(a, b, c, d, e, f, g, h, i, j, j1, k, l, m, n, o, p,sf, ff);
    },
    /*
     * 功能：企业发布职位 直接发布按钮、猎头代理按钮初始化
     * 参数：无
     * 修改：@jack 2012-7-12
     */
    m:function(){
            baseController.BtnBind("div.pb_op div.btn5", "btn5", "btn5_hov", "btn5_click");
            baseController.BtnBind("div.pb_op div.btn8", "btn8", "btn8_hov", "btn8_click");
            var that=jobpubRender;      
            $("#epart_pub").bind("click",function(){ 
                JobpubController.n(["1", that.l, that.m],this); 
            });
             $("#efl_pub").bind("click",function(){;
                JobpubController.l(["1", that.l, that.m],this);
            });
             $("#part_agentpub").bind("click",function(){
                JobpubController.n(["2", that.ai, that.m],this);
            });
            $("#fl_agentpub").bind("click",function(){
                JobpubController.l(["2", that.ai, that.m],this);
            });
    },
    /*
     * 功能：企业发布兼职职位
     * 参数：
     * parm：参数数组
     * [职位发布类型（1为发布，2为委托），
     * 成功回调函数，
     * 失败回调函数]
     * 修改：@jack 2012-7-12
     */
    n:function(parm,ele){
        JobpubController.x();
        var ids="#jtit,#jqual_select,#jpselect,#jupselect";
        if(!$("table.tb_all").find("input.defpay").hasClass("hidden")){
            ids+=",#defpay";
        }
        $(ids).trigger("blur");
        if($("table.tb_all").find("div.tip").length==0){
                JobpubController.fn(parm,ele);
        }else{
            var that=jobpubRender;
            that.error();
        }
    },
    /*
     * 功能：企业发布兼职职位
     * 参数：
     * parm：参数数组
     * [职位发布类型（1为发布，2为委托），
     * 成功回调函数，
     * 失败回调函数]
     * 修改：@jack 2012-7-12
     */
    fn:function(parm,ele){
        var type=parm[0],
        sf=parm[1],
        ff=parm[2];
        var ta=["",""];
        if($("#jtitle_selt").data("ids")){
            ta=$("#jtitle_selt").data("ids").split(",");
        }
        var slt=$("table.tb_all").find("input.qual_select");
        var a=$("#jtit").val(),
        b=type,
        c="",
        d="",
        e="",
        f=ta[1],
        g=ta[0],
        h=$("#jpselect").data("ids"),
        i=$("#jupselect").data("prov"),
        aj=$("#jupselect").data("city"),
        j=(!!aj)?aj:"",
        k=$("#jthepay").val(),
        k1=$("#defpay").val(),
        l=$("table.tb_all").find("input[name='isb']:checked").val(),
        m=$("table.tb_all").find("input[name='acmult']:checked").val(),
        n=$("#jdegree").val(),
        o=$("#jexp").val(),
        p=$("table.tb_all").find("input[name='workstate']:checked").val(),
        q=$("table.tb_all").find("input[name='sprequire']:checked").val(),
        r="2",
        s=$("#pjob_des").val(),
        t=$("input[name='pcatg']:checked").val();
        if(k!=12){
            k1=0;
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
                c+=","+tmp;
                d+=","+$(o).data("rid");
                e+=","+$(o).data("count");
            }
            else if(i==0&&tmp!=""){
                c+=tmp;
                d+=$(o).data("rid");
                e+=$(o).data("count");
            }
        });
        $("div").data("obj",ele);
        $(ele).css("cursor","wait");
        document.body.style.cursor = "wait";
        var job=new Jobs();
        job.EPubOtherPos(a, b, c, d, e, f, g, h, i, j, k, k1, l, m, n, o, p, q, r, s,t,sf, ff);
    },
    /*
     * 功能：企业招聘 发布职位 初始化
     * 参数：无
     * 修改：@jack 2012-7-12
     */
    o:function(){
        $("div.jobmanage table.tb input[readonly],div.enterinvite table.tb_all input[readonly],div.enterinvite table.tbful input[readonly]").val("");
    },
    /*
     * 功能：猎头发布全职职位 表单验证
     * 参数：无
     * @更改时间:2012-7-12
     * @更改者:@jack
     */
    p:function(t){
        var ids="#qtit,#qenter,#percount,#qpselect";
        var bl=true;
        if($("#slt_pos").children().length==0){
            $("#jtip").removeClass("hidden").addClass("error");
            bl=false;
        }
        if(!$("table.tbful").find("input.defpay").hasClass("hidden")){
            ids+=",#defpay";
        }
        $(ids).trigger("blur");
        if($("table.tb").not("table.tb_all").find("div.tip").length==0&&bl){
              JobpubController.fp(t);
        }
        else{            
            var that=jobpubRender;
            that.error();
        }
    },
    /*
     * 功能：猎头发布全职职位
     * 参数：无
     * @更改时间:2012-7-12
     * @更改者:@jack
     */
    fp:function(ele){
        var ta=["",""];
        var qtit=$("#qtitle_selt");
        if(qtit.data("ids")){
            ta=qtit.data("ids").split(",");
        }
        var slt=$("table.tb").not("table.tb_all").find("input.qual_select");
        var a=$("#qtit").val(),
        b=$("#qposition").attr("cids"),
        c=$("input[name='catg']:checked").val(),
        d=$("#percount").val(),
        e="",
        f="",
        g=ta[1],
        h=ta[0],
        i=$("#qpselect").data("prov"),
        j=$("#thepay").val(),
        j1=$("#defpay").val(),
        k=$("#degree").val(),
        l=$("#exp").val(),
        m=$("#pos_des").val(),
        n="1",
        ao=$("#qpselect").data("city"),
        o=(!!ao)?ao:"",
        p=$("#qenter").val(),
        q=$("#fi_quali").val(),
        r=$("#fl_attr").val(),
        s=$("#fl_time").val(),
        t=$("#fl_comscale").val(),
        u=$("#fl_sde").val();
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
                e+=","+tmp;
                f+=","+$(o).data("rid");
            }
            else if(i==0&&tmp!=""){
                e+=tmp;
                f+=$(o).data("rid");
            }
        });
        $("div").data("obj",ele);
        $(ele).css("cursor","wait");
        document.body.style.cursor = "wait";
        var job=new Jobs();
        var that=jobpubRender;
        job.APubFullPos(a, b, c, d, e, f, g, h, i, j, j1, k, l, m, n, o,p,q,r,s,t,u, that.al, that.m);
    },
    /*
     * 功能：猎头立即发布按钮初始化
     * 参数：无
     * @更改时间:2012-7-12
     * @更改者:@jack
     */
    q:function(){
        var that=$("#agentpub");
        if(that.length==0){
            //初始化招聘企业验证
            this.s();
            $("#part_redpub").click(function(){
                JobpubController.r(this);
            });
            $("#fl_redpub").click(function(){
                JobpubController.p(this);  
            });
        }
    },
    /*
     * 功能：猎头发布兼职职位表单确认
     * 参数：无
     * @更改时间:2012-7-12
     * @更改者:@jack
     */
    r:function(t){
        JobpubController.x();
        var ids="#jtit,#jenter,#jpselect,#jqual_select,#jupselect";
        if(!$("table.tb_all").find("input.defpay").hasClass("hidden")){
            ids+=",#defpay1";
        }
        $(ids).trigger("blur");
        if($("table.tb_all").find("div.tip").length==0){
            JobpubController.fr(t);
        }
        else{
            var that=jobpubRender;
            that.error();
        }
    },
    /*
     * 功能：猎头发布兼职职位
     * 参数：无
     * @更改时间:2012-7-12
     * @更改者:@jack
     */
    fr:function(ele){        
        var ta=["",""];
        if($("#jtitle_selt").data("ids")){
            ta=$("#jtitle_selt").data("ids").split(",");
        }
        var slt=$("table.tb_all").find("input.qual_select");
        var a=$("#jtit").val(),
        b=$("input[name='pcatg']:checked").val(),
        c="",
        d="",
        e="",
        f=ta[1],
        g=ta[0],
        h=$("#jpselect").data("ids"),
        i=$("#jupselect").data("prov"),
        aj=$("#jupselect").data("city"),
        j=(!!aj)?aj:"",
        k=$("#jthepay").val(),
        k1=$("#defpay1").val(),
        l=$("table.tb_all").find("input[name='isb']:checked").val(),
        m=$("table.tb_all").find("input[name='acmult']:checked").val(),
        n=$("#jdegree").val(),
        o=$("#jexp").val(),
        p=$("table.tb_all").find("input[name='workstate']:checked").val(),
        q=$("table.tb_all").find("input[name='sprequire']:checked").val(),        
        r="2",
        s=$("#pjob_des").val(),
        t=$("#jenter").val(),
        u=$("#cquali").val(),
        v=$("#e_attr").val(),
        w=$("#fdate").val(),
        x=$("#comscale").val(),
        y=$("#sub_detail").val();
        if(k!=12){
            k1=0; 
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
                c+=","+tmp;
                d+=","+$(o).data("rid");
                e+=","+$(o).data("count");
            }
            else if(i==0&&tmp!=""){
                c+=tmp;
                d+=$(o).data("rid");
                e+=$(o).data("count");
            }
        }); 
        $("div").data("obj",ele);
        $(ele).css("cursor","wait");
        document.body.style.cursor = "wait";
        var job=new Jobs();
        var that=jobpubRender;
        job.APubOtherPos(a, b, c, d, e, f, g, h, i, j, k, k1, l, m, n, o, p, q, r,s,t,u,v,w,x,y,that.al, that.m);
    },
    /*
     * 功能：初始化招聘企业验证
     * 参数：无
     * @更改时间:2012-7-12
     * @更改者:@jack
     */
    s:function(){
        var lan=LANGUAGE;
        this.f("#jenter,#qenter", lan.L0142, lan.L0143, lan.L0144,30);
    },
    /*
     * 功能：初始化期望待遇
     * 参数：
     * 无
     */
    t:function(){
        jobpubRender.p();
    },
    /*
     * 功能：初始化期望待遇验证
     * 参数：
     * 无
     */
    u:function(){
        $("#defpay,#defpay1").focus(function(){
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
     * 功能：tab点击去掉错误提示
     * 参数：无
     * 说明：新增方法
     * @Author：Jack
     * @时间：2012-7-12
     */
    v:function(){
        $("div.sm_tab ul li").click(function(){
            var e=$("div.t_item.hidden");
            e.find("div.tip.error").remove();
            e.find("input.red_border").removeClass("red_border");
            if(!$("#jtip").hasClass("hidden")){
                e.find("#jtip").addClass("hidden");
            }
        });
    },
    /*
     * 功能：日起插件初始化
     * 参数：无
     * 说明：新增方法
     * @Author：Jack
     * @时间：2012-7-12
     */
    w:function(){
        $("#fdate,#fl_time").datepicker({
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
     * 功能：发布兼职职位初始化资质和职称证的二选一验证
     * 参数：无
     * 说明：注释方法取消注释+修改
     * @Author：Jack
     * @时间：2012-7-12
     */
    x:function(){
        $("#jqual_select").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            var msg='';
            var bl=true;
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            var str1=$("#jtitle_selt").val().replace(new RegExp(" ","g"),"");
            if(str==""&&str1==""){
                msg=LANGUAGE.L0221;
                bl=false;
            }
            if(!bl){
                baseRender.a(this, msg, "error",0);
            }
            else{
                baseRender.b(this);
            }
        });
    },
    /*
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae($("#utp").val());
        this.w();
        this.a();
        this.b();
        this.c();
        this.d();
        this.f();
        this.g();
        this.h();
        this.i();
        //this.t();
        this.j();
        this.m();
        this.o();
        this.q();
        this.e();
        this.t();
        this.u();
        this.v();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="85"||PAGE=="86"){
        //初始化页面js等
        JobpubController.IniPage();
    }
});
