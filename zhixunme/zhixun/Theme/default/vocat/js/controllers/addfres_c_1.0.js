/*
 * 猎头简历添加控制器
 */
var AddFResController={
    /*********************************** 第一步 **********************************/
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
            sprov:false,//是否只精确到省
            single:true,  //是否为单选
            sure:addfresRender.a
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
    b:function(id,lan1,lan2,lan3,len){
        $(id).focus(function(){
            if(lan1!=""){
                baseRender.a(this, lan1, "right",0);
            }
        }).blur(function(){
            var msg='';
            var bl=true;
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                msg=lan2;
                bl=false;
            }
            else if(str.length>len&&lan3!=""){
                msg=lan3;
                bl=false;
            }
            if(bl){
                baseRender.ai(this,20);
            }
            else{
                baseRender.a(this, msg, "error",0);
            }
        });
    },
    /*
     * 功能：初始化所在地区验证
     * 参数：
     * 无
     */
    c:function(){
        var lan=LANGUAGE;
        this.b("#place", "", lan.L0158, "",30);
        this.b("#date", "", lan.L0212, "");
    //this.b("#explace", "", lan.L0160, "");
    //this.b("#qposition", lan.L0145, lan.L0146, lan.L0147,20);
    },
    /*
     * 功能：初始化生日
     * 参数：
     * 无
     */
    d:function(){
        $("#date").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            onSelect:function(){
                baseRender.ai("#date",20);
            }
        });
    },
    /*
     * 功能：初始化姓名验证
     * 参数：
     * 无
     */
    e:function(){
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
    f:function(){
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
     * 功能：邮箱验证
     * 参数：
     * 无
     */
    g:function(){
        $("#uemail").focus(function(){
            baseRender.a(this, LANGUAGE.L0001, "right" ,0);
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
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
                baseRender.a(this, msg, "error" ,0);
            }
            else{
                baseRender.ai(this,20);
            }
        });
    },
    /*
     * 功能：第一步 下一步
     * 参数：
     * 无
     */
    aa:function(){
        $("#onenext").unbind("click").bind("click",function(){
            var ids="#uname,#date,#phone,#place,#uemail";
            $(ids).trigger("blur");
            if($("div.addfres").find("div.tip").length==0){
                var a=$("#uname").val(),
                b=$("div.addtalents table.pinfo input[name='sex']:checked").val(),
                c=$("#date").val(),
                d=$("#place").data("prov"),
                e=$("#place").data("city"),
                f=$("#phone").val(),
                g=$("#uqq").val(),
                h=$("#uemail").val(),
                i=$("#uexp").val();
                var that=addfresRender;
                var res=new Resume();
                res.ACreatFResStep1(a, b, c, d, e, f, g, h, i, that.h, that.i);
            }
        });
    },
    /*********************************** 第二步 **********************************/
    /*
     * 功能：初始化第二步
     * 参数：
     * 无
     */
    ab:function(){
        var that=AddFResController;
        that.h();
       //that.i();
        that.j();
        that.k();
        that.l();
        that.fg();
        that.m();
        that.ac();
        that.o(1);
        that.n(2);
        $("#onenext").unbind("click").remove();
    },
    /*
     * 功能：初始化期望工作地点
     * 参数：
     * 无
     */
    h:function(){
        $("#explace").hgsSelect({
            type:"place",//选择框类型
            pid:"expplace",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:false,//是否只精确到省
            single:true,  //是否为单选
            sure:addfresRender.g
        });
    },
    /*
     * 功能：初始化期望待遇验证
     * 参数：
     * 无
     */
//    i:function(){
//        $("#expay").focus(function(){
//            baseRender.a(this, LANGUAGE.L0163, "right",35);
//        }).blur(function(){
//            var msg='';
//            var bl=true;
//            var str=$(this).val().replace(new RegExp(" ","g"),"");
//            if(str==""){
//                msg=LANGUAGE.L0164;
//                bl=false;
//            }
//            else if(!/^(\-?)(\d+)$/.test(str)){
//                msg=LANGUAGE.L0165;
//                bl=false;
//            }
//            else if(parseFloat(str,10)<0){
//                msg=LANGUAGE.L0166;
//                bl=false;
//            }
//            if(bl){
//                baseRender.ai(this,50);
//            }
//            else{
//                baseRender.a(this, msg, "error",35);
//            }
//        });
//    },
    /*
     * 功能：初始化资质证书
     * 参数：
     * 无
     */
    j:function(){
        $("#tqual").hgsSelect({
            id:"tqselect",
            pid:"tqplace",
            pshow:true,
            sprov:true,
            single:true,
            sure:addfresRender.b
        });
    },
    /*
     * 功能：初始化职称证
     * 参数：
     * 无
     */
    k:function(){
        $("#tjtitle").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"tjtitles",
            sure:addfresRender.f
        });
    },
    /*
     * 功能：资质证书验证、期望工作地点验证、职位名称验证
     * 参数：
     * 无
     */
    l:function(){
        var lan=LANGUAGE;
        //this.b("#tqual", "", lan.L0159, "");
        this.b("#explace", "", lan.L0155, "");
//        this.b("#qposition", "", lan.L0146, "");
        this.b("#mscname", lan.L0201, lan.L0202, "");
        this.b("#mmajname", lan.L0203, lan.L0204, "");
        this.r("#etime","#stime");
    },
    
    /*
     * 功能：招聘职位
     * 参数：
     * 无
     */
    fg:function(){
        $("#qposition").hgsSlt({
            id:"qjobslt",          //选择框id
            title:'职位',         //提示选择的是什么的类别
            tip:'至多可选择5个',  //右上侧提示语
            col_num:3,            //最大列数
            max_slt:5,            //最大选择个数
            single:false,         //是否为单选
            limit:false,           //是否显示不限
            sure:addfresRender.t   //确定提交选择结果的时候执行的方法
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
     * 功能：初始化学历时间
     * 参数：
     * 无
     */
    m:function(){
        $("#stime").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat:"yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            onSelect:function(){
                $("#etime").trigger("blur");
            }
        });
        $("#etime").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            onSelect:function(){
                $("#etime").trigger("blur");
            }
        });
    },
    /*
     * 功能：第二步
     * 参数：
     * 无
     */
    ac:function(){
        /* a：人才id
     * b：职位名称
     * c：工作地点省份编号
     * d：工作地点城市编号
     * e：期望待遇
     * f：职位描述
     * g：学历起始时间
     * h：学历终止时间
     * i：学校名称
     * j：专业名称
     * k：学历value值（1，2，3，4）
     * l：注册证书id集合（“,”分隔）
     * m：注册情况集合（“,”分隔）
     * n：注册地省份编号（“,”分隔）
     * o：职称证书id
     * p：职称证书级别
     * q：证书补充说明
     */
        $("#twonext").click(function(){
            var ids="#explace,#etime,#mscname,#mmajname";
            var bl=true;
            if($("#slt_pos").children().length==0){
                $("#jtip").removeClass("hidden").addClass("error");
                bl=false;
            }
            $(ids).trigger("blur");
            if($("div.addfres").find("div.tip").length==0&&bl){
                var ta=["",""];
                if($("#tjtitle").data("ids")){
                    ta=$("#tjtitle").data("ids").split(",");
                }
                var a=$(this).data("hid"),
                b=$("#qposition").attr("cids"),
                c=$("#explace").data("pid"),
                d=$("#explace").data("cid"),
                e=$("#expay")[0].options[$("#expay")[0].selectedIndex].value,
                e1=$("#defpay").val(), 
                f=$("#pos_des").val(),
                g=$("#stime").val(),
                h=$("#etime").val(),
                i=$("#mscname").val(),
                j=$("#mmajname").val(),
                k=$("#tdegree").val(),
                l="",
                m="",
                n="",
                o=ta[1],
                p=ta[0],
                q=$("#add_des").val();
                var slt=$("table.tb").not("table.pinfo").find("input.qual_select");
                if(e!=12){
                   e1=0; 
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
                        l+=","+tmp;
                        m+=","+$(o).data("rid");
                        n+=","+$(o).data("pid");
                    }
                    else if(i==0&&tmp!=""){
                        l+=tmp;
                        m+=$(o).data("rid");
                        n+=$(o).data("pid");
                    }
                });
                var that=addfresRender;
                var res=new Resume();
                res.ACreatFResStep2(a, b, c, d, e,e1,f, g, h, i, j, k, l, m, n, o, p, q, that.j, that.i);
            }
        });
    },
    /*********************************** 第三步 **********************************/
    /*
     * 功能：初始化第三步
     * 参数：
     * 无
     */
    ad:function(){
        var that=AddFResController;
        that.o(2);
        that.n(3);
        that.w();
        that.p();
        that.q();
        that.s();
        this.t();
        $("#twonext").unbind("click").remove();
        $("div.pb_op").fadeIn(100);
    },
    /*
     * 功能：初始化任职时间 初始化工程业绩起始时间
     * 参数：
     * 无
     */
    p:function(){
        $("#wstime").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat:"yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            onSelect:function(){
                $("#wetime").trigger("blur");
            }
        });
        $("#wetime").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            onSelect:function(){
                $("#wetime").trigger("blur");
            }
        });
        $("#pstime").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat:"yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            onSelect:function(){
                $("#petime").trigger("blur");
            }
        });
        $("#petime").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            onSelect:function(){
                $("#petime").trigger("blur");
            }
        });
    },
    /*
     * 功能：公司名称验证、行业名称验证、部门验证、职位验证、工作描述验证、项目名称验证、担任职位验证、工作内容验证
     * 参数：
     * 无
     */
    q:function(){
        var lan=LANGUAGE;
        this.b("#comname", lan.L0205, lan.L0188, "");
        this.b("#professname", lan.L0206, lan.L0190, "");
        this.b("#job_depart", lan.L0207, lan.L0186, "");
        this.b("#job_hold", lan.L0208, lan.L0173, "");
        this.b("#work_des", lan.L0209, lan.L0210, "");
        this.b("#proname", lan.L0193, lan.L0194, "");
        this.b("#proheld", lan.L0208, lan.L0173, "");
        this.b("#workcontent", lan.L0211, lan.L0192, "");
        this.r("#wetime","#wstime");
        this.r("#petime","#pstime");
    },
    /*
     * 功能：任职时间的验证、工程业绩起始时间的验证
     * 参数：
     * 无
     */
    r:function(id1,id2){
        $(id1).focus(function(){
            baseRender.b(this);
        }).blur(function(){
            var str1=$(this).val();
            var str2=$(id2).val();
            var msg="";
            var bl=true;
            if(str2==""){
                msg=LANGUAGE.L0213;
                bl=false;
            }else if(str1==""){
                msg=LANGUAGE.L0214;
                bl=false;
            }
            if(bl){
                baseRender.b(this);
            }else{
                baseRender.a(this, msg, "error",0);
            }
        });
        $(id2).focus(function(){
            baseRender.b($(id1));
        }).blur(function(){
            $(id1).trigger("blur");
        });
    },
    /*
     * 功能：保存工作经历 保存并添加更多工作经历
     * 参数：
     * 无
     */
    s:function(){
        $("#wsave,#wsaveadd").unbind("click").bind("click",function(){
            var ids="#job_depart,#wetime,#comname,#professname,#job_hold,#work_des";
            $(ids).trigger("blur");
            if($("#workexp").find("div.tip").length==0){
                var parm={
                    a:$("#job_depart").val(),
                    b:$("#wstime").val(),
                    c:$("#wetime").val(),
                    d:$("#comname").val(),
                    e:$("#professname").val(),
                    f:$("#comscale").val(),
                    g:$("#comchar").val(),
                    h:$("#job_hold").val(),
                    i:$("#work_des").val(),
                    j:$(this).data("rid"),
                    k:$("#comchar").find("option:selected").text(),
                    l:$("#comscale").find("option:selected").text()
                };
                var that=addfresRender;
                that.l(parm);
                var res=new Resume();
                var sf=that.m;
                if($(this).attr("type")==1){
                    sf=that.o;
                }
                res.AAddWExp(parm.a, parm.b, parm.c, parm.d, parm.e, parm.f, parm.g, parm.h, parm.i, parm.j, sf, that.n);
            }
        });
    },
    /*
     * 功能：保存工作经历 保存并添加更多工作经历
     * 参数：
     * 无
     */
    t:function(){
        $("#psave,#psaveadd").unbind("click").bind("click",function(){
            var ids="#proname,#petime,#proheld,#workcontent";
            $(ids).trigger("blur");
            if($("#projects").find("div.tip").length==0){
                var parm={
                    a:$("#proname").val(),
                    b:$("#proscale").val(),
                    c:$("#pstime").val(),
                    d:$("#petime").val(),
                    e:$("#proheld").val(),
                    f:$("#workcontent").val(),
                    g:$(this).data("rid"),
                    h:$("#proscale").find("option:selected").text()
                };
                var that=addfresRender;
                that.p(parm);
                var res=new Resume();
                var sf=that.q;
                if($(this).attr("type")==1){
                    sf=that.s;
                }
                res.AAddPExp(parm.a, parm.b, parm.c, parm.d, parm.e, parm.f, parm.g, sf, that.r);
            }
        });
    },
    /*********************************** 其他 **********************************/
    /*
     * 功能：展开指定步骤的表单
     * 参数：
     * 无
     */
    n:function(i){
        var steps=$("div.step"+i);
        steps.slideDown(400);
    },
    /*
     * 功能：收起指定步骤的表单
     * 参数：
     * 无
     */
    o:function(i){
        var steps=$("div.step"+i);
        steps.css("display","none");
    },
    /*
     * 功能：创建新全职简历
     * 参数：
     * 无
     */
    w:function(){
        baseController.BtnBind("div.tmanage div.addfres div.btn5", "btn5", "btn5_hov", "btn5_click");
        baseController.BtnBind("div.tmanage div.addfres div.btn8", "btn8", "btn8_hov", "btn8_click");
        $("#pubresnow").click(function(){
            var that=addfresRender;
            var a=$(this).data("rid");
            var res=new Resume();
            res.APubResume(a, that.k, that.i);
        });
        $("#savebtn").click(function(){
            addfresRender.k();
        });
    },
    /*
     * 功能：初始化期望待遇
     * 参数：
     * 无
     */
    ag:function(){
        addfresRender.u();
    },
     /*
     * 功能：初始化期望待遇验证
     * 参数：
     * 无
     */
    ah:function(){
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
     * 功能：初始化页面
     * 参数：
     * 无
     */
    IniPage:function(){
        baseRender.ae(1);
        /*第一步*/
        this.a();
        this.c();
        this.d();
        this.e();
        this.f();
        this.g();
        this.aa();
        this.ag();
        this.ah();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="67"){
        //初始化页面js等
        AddFResController.IniPage();
    }
});
