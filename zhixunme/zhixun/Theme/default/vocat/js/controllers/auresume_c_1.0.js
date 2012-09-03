/*
 *猎头简历修改页面控制器
 */
var auresumeController={
    /*********************************** 人才信息 **********************************//*
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
            sure:auresumeRender.b
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
            sure:auresumeRender.f
        });
    },
    /*
     * 功能：初始化所在地
     * 参数：
     * 无
     */
    fa:function(){
        $("#place").hgsSelect({
            type:"place",//选择框类型
            pid:"uplace",//省id
            pshow:true,//是否显示省
            sprov:false,//是否只精确到省
            single:true,  //是否为单选
            sure:auresumeRender.fa
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
    fb:function(id,lan1,lan2,lan3,len){
        $(id).focus(function(){
            if($(this).data("cedite")){
                if(lan1!=""){
                    baseRender.a(this, lan1, "right",0);
                }
            }
        }).blur(function(){
            if($(this).data("cedite")){
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
            }
        });
    },
    /*
     * 功能：初始化所在地区验证
     * 参数：
     * 无
     */
    fc:function(){
        var lan=LANGUAGE;
        var fun=this.fb;
        fun("#place", "", lan.L0158, "",30);
        fun("#date", "", lan.L0212, "");
    },
    /*
     * 功能：初始化生日
     * 参数：
     * 无
     */
    fd:function(){
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
            },
            beforeShow:function(){
                if(!$("#date").data("cedite")){
                    return false;
                }
            }
        });
    },
    /*
     * 功能：初始化姓名验证
     * 参数：
     * 无
     */
    fe:function(){
        $("#uname").focus(function(){
            if($(this).data("cedite")){
                baseRender.a(this, LANGUAGE.L0161, "right" ,0);
            }
        }).blur(function(){
            if($(this).data("cedite")){
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
            }
        });
    },
    /*
     * 功能：初始化手机验证
     * 参数：
     * 无
     */
    ff:function(){
        $("#phone").focus(function(){
            if($(this).data("cedite")){
                baseRender.a(this,LANGUAGE.L0039, "right", 0);
            }
        }).blur(function(){
            if($(this).data("cedite")){
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
            }
        });
    },
    /*
     * 功能：邮箱验证
     * 参数：
     * 无
     */
    fg:function(){
        $("#uemail").focus(function(){
            if($(this).data("cedite")){
                baseRender.a(this, LANGUAGE.L0001, "right" ,0);
            }
        }).blur(function(){
            if($(this).data("cedite")){
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
            }
        });
    },
    /*
     * 功能：保存人才信息
     * 参数：
     * 无
     */
    fh:function(){
        $("#onenext").unbind("click").bind("click",function(){
            var ids="#uname,#date,#phone,#place,#uemail";
            $(ids).trigger("blur");
            if($("div.fresalter div.addfres div.step1").find("div.tip").length==0){
                $("div#pr_num").data("bid","#onenext");
                var a=$(this).attr("hid"),
                b=$("#uname").val(),
                c=$("div.addtalents table.pinfo input[name='sex']:checked").val(),
                d=$("#date").val(),
                e=$("#place").attr("pid"),
                f=$("#place").attr("cid"),
                g=$("#phone").val(),
                h=$("#uqq").val(),
                i=$("#uemail").val(),
                j=$("#uexp").val();
                var that=auresumeRender;
                var res=new Resume();
                res.ASaveTInfo(a, b, c, d, e, f, g, h, i, j, that.fe, that.ff);
            }
        });
    },
    /*
     * 功能：初始化人才信息
     * 参数：
     * 无
     */
    pa:function(){
        var that=auresumeController;
        that.fa();
        that.fc();
        that.fd();
        that.fe();
        that.ff();
        that.fg();
        that.fh();
        that.pb();
    },
    /*
     * 功能：初始化全职简历修改页按钮效果
     * 参数：
     * 无
     */
    pb:function(){
        baseController.BtnBind("div.btn4", "btn4", "btn4_hov", "btn4_click")
    },
    /*********************************** 求职岗位 **********************************/
    /*
     * 功能：初始化求职岗位
     * 参数：
     * 无
     */
    fi:function(){
        var that=auresumeController;
        var lan=LANGUAGE;
        that.fj();
        //that.fk();
        //        that.fb("#qposition", lan.L0145, lan.L0146, lan.L0147,20);
        that.fb("#explace", "", lan.L0155, "");
        //that.pc();
        that.bd();
        that.ag();
    },
    /*
     * 功能：招聘职位
     * 参数：
     * 无
     */
    ag:function(){
        $("#qposition").hgsSlt({
            id:"qjobslt",          //选择框id
            title:'职位',         //提示选择的是什么的类别
            tip:'至多可选择5个',  //右上侧提示语
            col_num:3,            //最大列数
            max_slt:5,            //最大选择个数
            single:false,         //是否为单选
            limit:false,           //是否显示不限
            sure:auresumeRender.fw   //确定提交选择结果的时候执行的方法
        });
    },
    /*
     * 功能：删除已选职位
     * 参数：
     * cur：绑定对象
     */
    ah:function(cur){
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
     * 功能：初始化编辑状态下的职位选择
     * 参数：
     * obj：当前修改按钮
     */
    ai:function(obj){
        if($(obj).find("td.fpos").length>0){
            var that=$("#slt_pos_old");
            var ppar=$("#slt_pos");
            var par=$("#qposition");
            var html=that.html();
            ppar.html(html);
            par.attr("cids",that.attr("cids"));
            par.attr("pids",that.attr("pids"));
            par.attr("names",that.attr("names"));
            auresumeController.ah("#qposition");
        }
    },
    /*
     * 功能：重置非修改职位名称已选项
     * 参数：
     * obj：当前修改按钮
     */
    aj:function(obj){
        if($(obj).find("td.fpos").length>0){
            var that=$("#slt_pos_old");
            var par=$("#qposition");
            var ppar=$("#slt_pos");
            var html=ppar.html();
            that.html(html);
            that.attr("cids",par.attr("cids"));
            that.attr("pids",par.attr("pids"));
            that.attr("names",par.attr("names"));
        }
    },
    /*
     * 功能：初始化期望工作地点
     * 参数：
     * 无
     */
    fj:function(){
        $("#explace").hgsSelect({
            type:"place",//选择框类型
            pid:"expplace",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:false,//是否只精确到省
            single:true,  //是否为单选
            sure:auresumeRender.fd
        });
    },
    /*
     * 功能：初始化期望注册地
     * 参数：
     * 无
     */
    fk:function(){
        $("#explace").hgsSelect({
            type:"place",//选择框类型
            pid:"expplaces",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:true,//是否只精确到省
            single:false,  //是否为单选
            sure:auresumeRender.g
        });
    },
    /*
     * 功能：初始化期望待遇验证
     * 参数：
     * 无
     */
    //    fk:function(){
    //        $("#expay").focus(function(){
    //            if($(this).data("cedite")){
    //                baseRender.a(this, LANGUAGE.L0163, "right",35);
    //            }
    //        }).blur(function(){
    //            if($(this).data("cedite")){
    //                var msg='';
    //                var bl=true;
    //                var str=$(this).val().replace(new RegExp(" ","g"),"");
    //                if(str==""){
    //                    msg=LANGUAGE.L0164;
    //                    bl=false;
    //                }
    //                else if(!/^(\-?)(\d+)$/.test(str)){
    //                    msg=LANGUAGE.L0165;
    //                    bl=false;
    //                }
    //                else if(parseFloat(str,10)<0){
    //                    msg=LANGUAGE.L0166;
    //                    bl=false;
    //                }
    //                if(bl){
    //                    baseRender.ai(this,50);
    //                }
    //                else{
    //                    baseRender.a(this, msg, "error",35);
    //                }
    //            }
    //        });
    //    },
    /*
     * 功能：保存求职岗位
     * 参数：
     * 无
     */
    bd:function(){
        $("#savepos").unbind("click").bind("click",function(){
            var ids="#explace";
            var bl=true;
            if($("#slt_pos").children().length==0){
                $("#jtip").removeClass("hidden").addClass("error");
                bl=false;
            }
            $(ids).trigger("blur");
            if($("div.fresalter div.addfres div.step2").find("div.tip").length==0&&bl){
                $("div#pr_num").data("bid","#savepos");
                var a=$(this).attr("hid"),
                b=$(this).attr("intid"),
                c=$("#qposition").attr("cids"),
                d=$("#explace").attr("pid"),
                e=$("#explace").attr("cid"),
                f=$("#expay").val(),
                f1=$("#defpay").val(),
                g=$("#pos_des").val();
                 if(f!=12){
                   f1=0; 
                }
                var that=auresumeRender;
                var res=new Resume();
                res.ASaveGetPos(a, b, c, d, e, f, f1, g, that.fe, that.ff);
            }
        });
    },
    /*********************************** 学历 **********************************/
    pd:function(){
        var that=auresumeController;
        var lan=LANGUAGE;
        that.ft("#etime","#stime");
        that.fb("#mscname", lan.L0201, lan.L0202, "");
        that.fb("#mmajname", lan.L0203, lan.L0204, "");
        that.fo();
        that.be();
    },
    /*
     * 功能：初始化学历时间
     * 参数：
     * 无
     */
    fo:function(){
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
            },
            beforeShow:function(){
                if(!$("#stime").data("cedite")){
                    return false;
                }
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
            },
            beforeShow:function(){
                if(!$("#etime").data("cedite")){
                    return false;
                }
            }
        });
    },
    /*
     * 功能：学历保存
     * 参数：
     * 无
     */
    be:function(){
        $("#savedegree").unbind("click").bind("click",function(){
            var ids="#etime,#mscname,#mmajname";
            $(ids).trigger("blur");
            if($("div.fresalter div.addfres div.step2").find("div.tip").length==0){
                $("div#pr_num").data("bid","#savedegree");
                var a=$(this).attr("hid"),
                b=$(this).attr("intid"),
                c=$("#stime").val(),
                d=$("#etime").val(),
                e=$("#mscname").val(),
                f=$("#mmajname").val(),
                g=$("#tdegree").val();
                var that=auresumeRender;
                var res=new Resume();
                res.ASaveDegree(a, b, c, d, e, f, g, that.fe, that.ff);
            }
        });
    },
    /*********************************** 证书情况 **********************************/
    pf:function(){
        var that=auresumeController;
        var lan=LANGUAGE;
        that.d();
        that.e();
        that.fb("#tqual", "", lan.L0159, "");
        //that.fb("#tjtitle", "", lan.L0167, "");
        that.ca();
    },
    /*
     * 功能：证书情况修改按钮事件绑定
     * 参数：
     * 无
     */
    bk:function(){
        $("#qalertitem").unbind("click").bind("click",function(){
            var par=$(this).parent();
            var that=auresumeController;
            $(this).text("取消");
            par.removeClass("updatedata");
            that.bm();
            that.bb($(this).next().next());
            par.find("input[type='text'][class!='mselect'],textarea").attr("readonly",false);
            par.find("input[type='text'][class*='mselect']").css("cursor","pointer");
            var $that=$("#expay");
            if($that.val()!="12"){
                $that.prev().fadeOut(10);
            }
            var qpar=$("#myquals");
            var del=qpar.find("a.delqual");
            var apar=qpar.find("a.addqual");
            var add=apar.eq(apar.length-1);
            if(qpar.find("div.qualitem").length>1){
                del.fadeIn(100);
            }
            add.fadeIn(100);
            that.bn("#myquals a.delqual");
            that.bo("#myquals a.addqual");
            $("#expay").trigger("change");
        });
    },
    /*
     * 功能：证书情况取消按钮事件绑定
     * 参数：
     * 无
     */
    bm:function(){
        $("#qalertitem").unbind("click").bind("click",function(){
            var par=$(this).parent();
            var that=auresumeController;
            par.find("input[type='text'],textarea").attr("readonly",true);
            par.find("input[type='text'][class*='mselect']").css("cursor","inherit");
            par.find("div.tip,div.result").remove();
            $(this).text("修改");
            par.addClass("updatedata");
            var $that=$("#expay");
            if($that.val()!="12"){
                var curo=$that.find("option[value='"+$that.val()+"']");
                curo.attr("selected",true);
                $that.prev().text(curo.text());
                $that.prev().fadeIn(10);
            }
            that.bk();
            var qpar=$("#myquals");
            var del=qpar.find("a.delqual");
            var apar=qpar.find("a.addqual");
            var add=apar.eq(apar.length-1);
            var qual=par.find("#tqual");
            del.fadeOut(100);
            add.fadeOut(100);
            qual.fadeOut(100);
            qpar.find("a.blue").fadeOut(100);
        });
    },
    /*
     * 功能：资质证书 删除
     * 参数：
     * obj：当前绑定a标签
     */
    bn:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().parent().find("div.qualitem");
            var len=par.length;
            if(len==2){
                par.eq(0).find("a.delqual").fadeOut(200);
            }
            var a=$(this).attr("hid"),
            b=$(this).attr("cid");
            $("#myquals").data("cid",b);
            var that=auresumeRender;
            var res=new Resume();
            res.ADelRC(a, b, that.fq, that.fr);
        });
    },
    /*
     * 功能：资质证书 添加
     * 参数：
     * obj：当前绑定a标签
     */
    bo:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$("#myquals");
            var qual=par.find("#tqual");
            var cancel=par.find("a#cancelqual")
            qual.fadeIn(200);
            cancel.fadeIn(200);
            par.parent().removeClass("qualcont");
            $(this).fadeOut(100);
            var that=auresumeController;
            that.bp();
            that.bq();
        });
    },
    /*
     * 功能：资质证书 保存添加
     * 参数：
     * 无
     */
    bp:function(){
        $("a#savequal").unbind("click").bind("click",function(){
            //            var len=$(this).parent().parent().find("div.qualitem").length;
            //            if(len>1){
            //                par.eq(0).find("a.delequal").fadeOut(100);
            //            }
            var qual=$("#tqual");
            var tmp=""
            if(qual.data("zid")){
                tmp=qual.data("zid");
            }
            else{
                tmp=qual.data("mid");
            }
            var a=$(this).attr("hid"),
            b=tmp,
            c=qual.data("pid"),
            d=qual.data("rid");
            var that=auresumeRender;
            that.ft(a,qual.val());
            var res=new Resume();
            res.AAddRC(a, b, c, d, that.fs, that.fr);
        });
    },
    /*
     * 功能：资质证书 取消添加
     * 参数：
     * 无
     */
    bq:function(){
        $("a#cancelqual").unbind("click").bind("click",function(){
            var blue=$(this).parent().find("a.blue");
            var qual=$("#tqual");
            var add=qual.prev().find("a.addqual");
            blue.fadeOut(100);
            qual.fadeOut(100);
            add.fadeIn(100);
            qual.val("");
        });
    },
    /*
     * 功能：全职证书情况 保存
     * 参数：
     * 无
     */
    ca:function(){
        $("a#btnsavequal").unbind("click").bind("click",function(){
            //$("#tjtitle").trigger("blur");
            var jt=$("#tjtitle");
            var a=$(this).attr("hid"),
            b=0,
            c=jt.attr("cid"),
            d=jt.attr("gra"),
            e=$("#add_des").val();
            $("div#pr_num").data("bid","#btnsavequal");
            var res=new Resume();
            var that=auresumeRender;
            res.AUpdateCert(a, b, c, d, e, that.fe, that.fr);
        });
    },
    /*
     * 功能：兼职证书情况 保存
     * 参数：
     * 无
     */
    cb:function(){
        $("a#btnsavequal").unbind("click").bind("click",function(){
            var ids="#tjtitle,#explace";
            $(ids).trigger("blur");
            if($("div.tpro div.addfres div.step4 table.tb").find("div.tip").length==0){
                var jt=$("#tjtitle");
                var a=$(this).attr("hid"),
                b=$(this).attr("certid"),
                c=jt.attr("cid"),
                d=jt.attr("gra"),
                e=$("#add_des").val(),
                f=$("#expay").val(),
                f1=$("#defpay").val(),
                g=$("#explace").attr("pid");
                $("div#pr_num").data("bid","#btnsavequal");                 
                if(f!=12){                  
                   f1=0;                    
                }             
                var res=new Resume();
                var that=auresumeRender;
                res.AUpdatePCert(a, b, c, d, e, f, f1, g, that.fe, that.fr);
            }
        });
    },
    /*
     * 功能：简历修改 立即公开求职
     * 参数：
     * 无
     */
    cc:function(){
        var par=$("a#pubresnow");
        par.text("立即公开求职");
        par.unbind("click").bind("click",function(){
            var a=$(this).attr("rid");
            var res=new Resume();
            var that=auresumeRender;
            res.APubResume(a, that.fu, that.fr);
        });
    },
    /*
     * 功能：简历修改 立即结束求职
     * 参数：
     * 无
     */
    cd:function(){
        var par=$("a#pubresnow");
        par.text("立即结束求职");
        par.unbind("click").bind("click",function(){
            var a=$(this).attr("rid");
            var that=auresumeRender;
            var res=new Resume();
            res.ACloseResume(a, that.fv, that.fr);
        });
    },
    /*********************************** 工作经历 **********************************/
    /*
     * 功能：初始化工作经历
     * 参数：
     * 无
     */
    fq:function(){
        var that=auresumeController;
        var lan=LANGUAGE;
        that.fr();
        that.ft("#wetime","#wstime");
        that.fb("#comname", lan.L0205, lan.L0188, "");
        that.fb("#professname", lan.L0206, lan.L0190, "");
        that.fb("#job_depart", lan.L0207, lan.L0186, "");
        that.fb("#job_hold", lan.L0208, lan.L0173, "");
        that.fb("#work_des", lan.L0209, lan.L0210, "");
        that.fu();
        that.ph("div.step5 a.alters");
        that.pj("div.step5 a.sldown");
        that.qe("div.step5 a.deles");
        that.qa();
    },
    /*
     * 功能：初始化工作经历 - 添加
     * 参数：
     * 无
     */
    qa:function(){
        $("div.step5 a.additem").unbind("click").bind("click",function(){
            var par=$(this).parent().find("div.addwexp");
            var inp=$("#workexp").parent();
            var it=inp.parent().prev().find("a.alters");
            it.text("修改");
            it.prev().text("展开");
            var that=auresumeController;
            that.ph(it);
            that.pi(par,inp);
            var btn=$("#wsaveadd");
            btn.text("添加");
            btn.attr("type","2");
            that.bi(inp);
            par.slideDown(500);
            $(this).text("取消");
            that.qb();
        });
    },
    /*
     * 功能：初始化工作经历 - 取消添加
     * 参数：
     * 无
     */
    qb:function(){
        $("div.step5 a.additem").unbind("click").bind("click",function(){
            var par=$(this).parent().find("div.addwexp");
            par.slideUp(500)
            $(this).text("添加");
            auresumeController.qa();
        });
    },
    /*
     * 功能：初始化任职时间
     * 参数：
     * 无
     */
    fr:function(){
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
            },
            beforeShow:function(){
                if(!$("#wstime").data("cedite")){
                    return false;
                }
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
            },
            beforeShow:function(){
                if(!$("#wetime").data("cedite")){
                    return false;
                }
            }
        });
    },
    /*
     * 功能：保存工作经历 保存并添加更多工作经历
     * 参数：
     * 无
     */
    fu:function(){
        $("#wsaveadd").unbind("click").bind("click",function(){
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
                    j:$(this).attr("rid"),
                    k:$("#comchar").find("option:selected").text(),
                    l:$("#comscale").find("option:selected").text(),
                    m:$(this).attr("hid"),
                    n:$(this).parent().parent().parent().parent().attr("wxid")
                };
                var that=auresumeRender;
                //that.fi(parm);
                var res=new Resume();
                if($(this).attr("type")=="2"){
                    //添加工作经历
                    res.AAddWExp(parm.a, parm.b, parm.c, parm.d, parm.e, parm.f, parm.g, parm.h, parm.i, parm.j, that.fj, that.fk);
                }else{
                    //修改工作经历
                    res.AUpdateDegree(parm.m, parm.n, parm.a, parm.b, parm.c, parm.d, parm.e, parm.f, parm.g, parm.h, parm.i, that.fl, that.fk)
                }
            }
        });
    },
    /*
     * 功能：工作经历 - 修改
     * 参数：
     * 无
     */
    ph:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var cur=$(this);
            var par=cur.parent().next();
            var inp=$("#workexp").parent();
            var it=inp.parent().prev().find("a.alters");
            it.text("修改");
            it.prev().text("展开");
            var that=auresumeController;
            that.ph(it);
            that.pi(par,inp);
            that.pk(this);
            if(par.css("display")=="block"){
                par.css("display","none");
            }
            setTimeout(
                function(){
                    that.bg($(cur).parent().next(),"#workexp");
                },300);
            setTimeout(
                function(){
                    cur.prev().trigger("click");
                },510);
            var btn=$("#wsaveadd");
            btn.text("保存");
            btn.attr("type","1");
        });
    },
    /*
     * 功能：工作经历|工程业绩 - 修改添加按钮的页面效果
     * 参数：
     * fout：要添加到的父容器
     */
    pi:function(fout,inp){
        inp.parent().slideUp(500,function(){
            fout.parent().find("div.wpitem").children().css("display","block");
            fout.children().css("display","none");
            if(inp.css("display")=="none"){
                inp.css("display","block");
            }
            $("div.addfres").find("div.tip").remove();
            fout.append(inp);
            if(!fout.hasClass("addwexp")){
                if(fout.parent().hasClass("step5")){
                    auresumeController.qb();
                    $("div.step5 a.additem").trigger("click");
                }else{
                    auresumeController.qd();
                    $("div.step6 a.additem").trigger("click");
                }
            }
        });
    },
    /*
     * 功能：工作经历|工程业绩 - 展开
     * 参数：
     * obj：展开收起a按钮
     */
    pj:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().next();
            if(par.css("display")=="block"){
                par.slideUp(500);
                $(this).text("展开");
            }else{
                par.slideDown(500);
                $(this).text("收起");
            }
        });
    },
    /*
     * 功能：工作经历 - 取消修改
     * 参数：
     * 无
     */
    pk:function(obj){
        $(obj).text("取消修改");
        $(obj).unbind("click").bind("click",function(){
            var inp=$("#workexp").parent();
            var cur=$(this);
            cur.text("修改");
            inp.fadeOut(200,function(){
                inp.prev().fadeIn(300);
                if(inp.css("display")=="block"){
                    inp.css("display","none");
                }
                auresumeController.ph(obj);
                if(inp.parent().css("display")=="block"){
                    cur.prev().text("收起");
                }else{
                    cur.prev().text("展开");
                }
            });
        });
    },
    /*
     * 功能：工作经历|工程业绩 - 删除
     * 参数：
     * 无
     */
    qe:function(obj){
        $(obj).unbind("click").bind("click",function(){
            if(confirm("您确定要删除?")){
                var par=$(this).parent();
                var next=par.next();
                var inp=next.find("div.additems");
                var ppar=par.parent();
                if(inp.length>0){
                    inp.fadeIn(150,function(){
                        inp.appendTo(ppar.find("div.addwexp"));
                    });
                }
                var a=next.attr("wxid")||next.attr("gid"),
                b=$("#wsaveadd").attr("rid"),
                c=$("#wsaveadd").attr("hid");
                next.remove();
                par.remove();
                var res=new Resume();
                if(ppar.hasClass("step5")){
                    res.ADeleWExp(a, b, c, null, auresumeRender.ff);
                }else if(ppar.hasClass("step6")){
                    res.ADeleWGrade(c, a, b, null, auresumeRender.ff);
                }
            }
        });
    },
    /*********************************** 工程业绩 **********************************/
    /*
     * 功能：初始化工程业绩
     * 参数：
     * 无
     */
    pl:function(){
        var that=auresumeController;
        var lan=LANGUAGE;
        that.fs();
        that.ft("#petime","#pstime");
        that.fb("#proname", lan.L0193, lan.L0194, "");
        that.fb("#proheld", lan.L0208, lan.L0173, "");
        that.fb("#workcontent", lan.L0211, lan.L0192, "");
        that.pm("div.step6 a.alters");
        that.pj("div.step6 a.sldown");
        that.qe("div.step6 a.deles");
        that.fv();
        that.qc();
    },
    /*
     * 功能：初始化工程业绩 - 添加
     * 参数：
     * 无
     */
    qc:function(){
        $("div.step6 a.additem").unbind("click").bind("click",function(){
            var par=$(this).parent().find("div.addwexp");
            var inp=$("#projects").parent();
            var it=inp.parent().prev().find("a.alters");
            it.text("修改");
            it.prev().text("展开");
            var that=auresumeController;
            that.pm(it);
            that.pi(par,inp);
            var btn=$("#psaveadd");
            btn.text("添加");
            btn.attr("type","2");
            par.slideDown(600);
            that.bi(inp);
            $(this).text("取消");
            that.qd();
        });
    },
    /*
     * 功能：初始化工程业绩 - 取消添加
     * 参数：
     * 无
     */
    qd:function(){
        $("div.step6 a.additem").unbind("click").bind("click",function(){
            var par=$(this).parent().find("div.addwexp");
            par.slideUp(500)
            $(this).text("添加");
            auresumeController.qc();
        });
    },
    /*
     * 功能：工程业绩 - 修改
     * 参数：
     * 无
     */
    pm:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var cur=$(this);
            var par=cur.parent().next();
            var inp=$("#projects").parent();
            var it=inp.parent().prev().find("a.alters");
            it.text("修改");
            it.prev().text("展开");
            var that=auresumeController;
            that.pm(it);
            that.pi(par,inp);
            that.pn(this);
            if(par.css("display")=="block"){
                par.css("display","none");
            }
            setTimeout(
                function(){
                    that.bg($(cur).parent().next(),"#projects");
                },300);
            setTimeout(
                function(){
                    cur.prev().trigger("click");
                },510);
            var btn=$("#psaveadd");
            btn.text("保存");
            btn.attr("type","1");
        });
    },
    /*
     * 功能：工程业绩 - 取消修改
     * 参数：
     * 无
     */
    pn:function(obj){
        $(obj).text("取消修改");
        $(obj).unbind("click").bind("click",function(){
            var inp=$("#projects").parent();
            var cur=$(this);
            cur.text("修改");
            inp.fadeOut(200,function(){
                inp.prev().fadeIn(300);
                if(inp.css("display")=="block"){
                    inp.css("display","none");
                }
                auresumeController.pm(obj);
                if(inp.parent().css("display")=="block"){
                    cur.prev().text("收起");
                }else{
                    cur.prev().text("展开");
                }
            });
        });
    },
    /*
     * 功能：初始化工程业绩起始时间
     * 参数：
     * 无
     */
    fs:function(){
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
     * 功能：任职时间的验证、工程业绩起始时间的验证
     * 参数：
     * 无
     */
    ft:function(id1,id2){
        $(id1).focus(function(){
            if($(this).data("cedite")){
                baseRender.b(this);
            }
        }).blur(function(){
            if($(this).data("cedite")){
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
            }
        });
        $(id2).focus(function(){
            if($(this).data("cedite")){
                baseRender.b($(id1));
            }
        }).blur(function(){
            if($(this).data("cedite")){
                $(id1).trigger("blur");
            }
        });
    },
    /*
     * 功能：保存工程业绩 保存并添加更多工程业绩
     * 参数：
     * 无
     */
    fv:function(){
        $("#psaveadd").unbind("click").bind("click",function(){
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
                    g:$(this).attr("rid"),
                    h:$("#proscale").find("option:selected").text(),
                    i:$(this).attr("hid"),
                    j:$(this).parent().parent().parent().parent().attr("gid")
                };
                var that=auresumeRender;
                //that.p(parm);
                var res=new Resume();
                if($(this).attr("type")==2){
                    //添加工程业绩
                    res.AAddPExp(parm.a, parm.b, parm.c, parm.d, parm.e, parm.f, parm.g, that.fn, that.fo);
                }else{
                    //修改工程业绩
                    res.AUpdateWExp(parm.i, parm.j, parm.a, parm.b, parm.c, parm.d, parm.e, parm.f, that.fp, that.fo)
                }

            }
        });
    },
    /*********************************** 其他 **********************************/
    /*
     * 功能：除工作经历和工程业绩外的修改按钮事件绑定
     * 参数：
     * obj：当前绑定对象
     */
    fw:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent();
            var that=auresumeController;
            $(this).text("取消");
            par.removeClass("updatedata");
            that.fx(this);
            that.bb($(this).next().next());
            par.find("input[type='text'][class!='mselect'][class!='hasDatepicker'],textarea").attr("readonly",false);
            par.find("input[type='text'][class*='mselect']").css("cursor","pointer");
        });
    },
    /*
     * 功能：除工作经历和工程业绩外的取消按钮事件绑定
     * 参数：
     * obj：当前绑定对象
     */
    fx:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent();
            var that=auresumeController;
            par.find("input[type='text'],textarea").attr("readonly",true);
            par.find("input[type='text'][class*='mselect']").css("cursor","inherit");
            par.find("div.tip,div.result").remove();
            $(this).text("修改");
            par.addClass("updatedata");
            that.fw(this);
            that.bb($(this).next().next());
        });
    },
    /*
     * 功能：检验当前是否为可编辑状态
     * 参数：
     * 无
     */
    fy:function(){
        var that=auresumeController;
        $("div.fresalter div.addfres input[type='text'], div.fresalter div.addfres div.updatedata textarea").bind({
            focus:function(e){
                that.fz(this);
            },
            click:function(e){
                that.fz(this);
            }
        });
    },
    /*
     * 功能：检验当前是否为可编辑状态
     * 参数：
     * 无
     */
    fz:function(obj){
        var par=$(obj).parent().parent().parent().parent().parent();
        if(par.hasClass("tb")){
            par=par.parent();
        }
        var bl1=false;
        var bl2=true;
        if(par.hasClass("updatedata")){
            bl1=true;
            bl2=false;
        }
        if($(obj).hasClass("mselect")){
            $(obj).hgsSelect.defaults.stopevent=bl1;
        }else{
            $(obj).data("cedite",bl2);
        }
    },
    /*
     * 功能：保存当前值
     * 参数：
     * 无
     */
    ba:function(par){
        par=$(par);
        var txt=par.find("input[type='text'],textarea");//文本框
        var select=par.find("select");//下拉框
        var radio=par.find("input[type='radio']").parent();//单选框
        var salary=$("#expay").prev("span.txtinfo");
        var sval=salary.attr("val");
        var stext=salary.text();
        $.each(txt,function(i,o){
            $(o).data("curdata",$(o).val());
        });        
        $.each(select,function(i,o){
            var that=$(o);
            var cur=that.prev();
            cur.attr("val",that.val());            
            cur.text(that.find("option:selected").text());
        });   
        if(sval==12)
            salary.text(stext);
        $.each(radio,function(i,o){
            var that=$(o).find("input[type='radio']:checked");
            var cur=$(o).find("span.txtinfo");
            cur.attr("val",that.val());
            cur.text(that.next().text());
        });
        auresumeController.aj(par);
    },
    /*
     * 功能：初始化文本框
     * 参数：
     * 无
     */
    bb:function(par){
        par=$(par);
        var txt=par.find("input[type='text'],textarea");//文本框
        var select=par.find("select");//下拉框
        var radio=par.find("input[type='radio']").parent();//单选框
        $.each(txt,function(i,o){
            var that=$(o);
            that.val(that.data("curdata"));
        });
        $.each(select,function(i,o){
            var that=$(o);
            var cur=that.prev();
            that.find("option[value='"+cur.attr("val")+"']").attr("selected",true);
        });
        if(par.parent().hasClass("step2")){
            var pa=$("#expay");
            var svl=pa.val();
            if(svl=="12"&&$("#defpay").val()==""&&!pa.parents('div.step2').hasClass("updatedata")){
                $("#defpay").val(pa.prev().text()).removeClass("hidden");
            }else if(svl!="12"&&pa.parents('div.step2').hasClass("updatedata")){
                pa.prev().text(pa.find("option[value='"+svl+"']").text()).fadeIn(10);
            }else if(!pa.parents('div.step2').hasClass("updatedata")){
                pa.prev().fadeOut(10);
            }
        }
        $.each(radio,function(i,o){
            var that=$(o);
            var cur=that.find("span.txtinfo");
            that.find("input[type='radio'][value='"+cur.attr("val")+"']").attr("checked",true);
        });
        auresumeController.ai(par);
    },
    /*
     * 功能：初始化下拉框和单选框
     * 参数：
     * 无
     */
    bc:function(par){
        par=$(par);
        var select=par.find("select");//下拉框
        var radio=par.find("input[type='radio']").parent();//单选框
        $.each(select,function(i,o){
            var that=$(o);
            var cur=that.prev();
            that.find("option[value='"+cur.attr("val")+"']").attr("selected",true);
        });
        $.each(radio,function(i,o){
            var that=$(o);
            var cur=that.find("span.txtinfo");
            that.find("input[type='radio'][value='"+cur.attr("val")+"']").attr("checked",true);
        });
    },
    /*
     * 功能：工作经历|工程业绩保存当前值
     * 参数：
     * 无
     */
    bf:function(par,id){
        par=$(par);
        var cols=par.find("div.item");
        var txt=$(id).find("input[type='text'],textarea");//文本框
        var select=$(id).find("select");//下拉框
        $.each(txt,function(i,o){
            var name=$(o).attr("id");
            name="p."+name+",span."+name;
            var cur=cols.find(name);
            cur.text($(o).val());
        });
        $.each(select,function(i,o){
            var that=$(o);
            var name=that.attr("id");
            name="p."+name+",span."+name;
            var cur=cols.find(name);
            cur.attr("val",that.val());
            cur.text(that.find("option:selected").text());
        });
    },
    /*
     * 功能：工作经历|工程业绩初始化文本框
     * 参数：
     * 无
     */
    bg:function(par,id){
        par=$(par);
        var cols=par.find("div.item");
        var txt=$(id).find("input[type='text'],textarea");//文本框
        var select=$(id).find("select");//下拉框
        $.each(txt,function(i,o){
            var name=$(o).attr("id");
            name="p."+name+",span."+name;
            var cur=cols.find(name);
            $(o).val(cur.text());
        });
        $.each(select,function(i,o){
            var name=$(o).attr("id");
            name="p."+name+",span."+name;
            var cur=cols.find(name);
            $(o).find("option[value='"+cur.attr("val")+"']").attr("selected",true);
        });
    },
    /*
     * 功能：工作经历|工程业绩初始化下拉框和单选框
     * 参数：
     * 无
     */
    bh:function(par){
        par=$(par);
        $.each(par,function(i,o){
            var select=$(o).find("select");//下拉框
            var cols=$(o).find("div.item");
            $.each(select,function(i,o){
                var name=$(o).attr("id");
                name="p."+name+",span."+name;
                var cur=cols.find(name);
                $(o).find("option[value='"+cur.attr("val")+"']").attr("selected",true);
            });
        })
    },
    /*
     * 功能：工作经历|工程业绩清空表单
     * 参数：
     * par：表单id
     */
    bi:function(par){
        par=$(par);
        par.find("input[type='text'],textarea").val("");
        par.find("select option:eq(0)").attr("selected",true);
    },
    /*
     * 功能：初始化页面可编辑状态
     * 参数：
     * 无
     */
    bj:function(){
        if($("#showalert").val()=="3"){
            $("div.step a.alertitem,div.step a.additem,div.step a.alters,div.step a.deles").fadeIn(50);
            this.cc();
        }else{
            this.cd();
            $("div.step a.alertitem,div.step a.additem,div.step a.alters,div.step a.deles").css("display","none");
        }
    },
     /*
     * 功能：初始化期望待遇
     * 参数：
     * 无
     */
    c:function(){
        auresumeRender.h();
    },
     /*
     * 功能：初始化期望待遇验证
     * 参数：
     * 无
     */
    f:function(){
        $("#defpay").focus(function(){
            if(!$(this).parents("div.step").hasClass("updatedata"))
                baseRender.a(this, LANGUAGE.L0163, "right",30);
        }).blur(function(){
            if(!$(this).parents("div.step").hasClass("updatedata")){
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
            }            
        });
    },
    /*
     * 功能：在firefox下初始化文本框
     * 参数：
     * 无
     */
    IniInput:function(){
        if($.browser.mozilla){
            var inp=$("input[type='text'],textarea");
            $.each(inp,function(i,o){
                var a=$(o);
                a.val(a[0].defaultValue);
            });
        }
    },
    /*
     * 功能：初始化猎头全职修改页
     * 参数：无
     * 无
     */
    IniPage:function(){
        baseRender.ae(1);
        this.IniInput();
        this.bj();
        this.fy();
        this.pa();
        this.fi();
        this.pd();
        this.pf();
        this.fq();
        this.pl();
        this.fw("div.step a.alertitem[id!='qalertitem']");
        this.bc($("div.step a.alertitem").next().next());
        this.ba("div.step table.tb");
        this.bk();
        this.c();
        this.f();
    },
    /*
     * 功能：初始化猎头兼职修改页
     * 参数：无
     * 无
     */
    IniPage1:function(){
        baseRender.ae(1);
        this.IniInput();
        this.bj();
        this.fy();
        this.pa();
        this.e();
        this.fk();
        this.d();
        this.fb("#tjtitle", "", LANGUAGE.L0167, "");
        this.fw("div.step a.alertitem[id!='qalertitem']");
        this.bc($("div.step a.alertitem").next().next());
        this.ba("div.step table.tb");
        this.bk();
        this.cb();
        this.c();
        this.f();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="75"){
        //初始化页面js等
        auresumeController.IniPage();
    }
    if(PAGE=="76"){
        //初始化页面js等
        auresumeController.IniPage1();
    }

});
