/*
 *猎头简历修改页面渲染
 */
var auresumeRender={
    /*
     * 功能：所在地添加结果显示
     * 参数：
     * r:插件返回结果
     */
    a:function(r){
        var txt="";
        var ids=r.prov;
        var that=r.obj;
        if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname+" - "+r.cityname;
        }
        that.val(txt);
        baseRender.b(that);
        that.data("prov",ids);
        that.data("city",r.city);
    },
    /*
     * 功能：添加资质显示添加结果
     * 参数：
     * r:插件返回结果
     */
    b:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){
            mname=" - "+r.majname;
        }
        var txt=r.cname+mname+" - "+r.regname+" - "+r.provname;
        that.val(txt);
        if(typeof(r.zid)=="undefined"){
            r.zid="";
        }
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        that.data("rid",r.reg);
        that.data("pid",r.prov);
        baseRender.b(that);
        that.next().fadeIn(100);
        $(that).parent().find("div.result").remove();
    },
    /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    f:function(r){
        var that=r.obj;
        var txt=r.jtlname+" - "+r.jtname;
        $("#tjtitle").val(txt);
        that.attr("cid",r.jtid);
        that.attr("gra",r.jtlid);
    },
    /*
     * 功能：期望注册地添加结果显示
     * 参数：
     * r:插件返回结果
     */
    g:function(r){
        var txt="";
        var ids="";
        var that=r.obj;
        if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname;
            ids=r.prov;
        }
        that.val(txt);
        baseRender.b(that);
        that.attr("pid",ids);
    },
    /*
     * 功能：所在地添加结果显示
     * 参数：
     * r:插件返回结果
     */
    fa:function(r){
        var txt="";
        var ids=r.prov;
        var that=r.obj;
        if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname+" - "+r.cityname;
        }
        that.val(txt);
        baseRender.b(that);
        that.attr("pid",ids);
        that.attr("cid",r.city);
        baseRender.ai(that,20);
    },
    /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    fc:function(r){
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+","+r.jtid;
        $("#tjtitle").val(txt);
        $("#tjtitle").data("ids", ids);
        baseRender.ai(r.obj,20);
    },
    /*
     * 功能：期望工作地点添加结果显示
     * 参数：
     * r:插件返回结果
     */
    fd:function(r){
        var txt="";
        var pid="";
        var that=r.obj;
        if(r.nolmt){
            txt=r.noname;
            pid="0";
        }
        else{
            txt=r.provname+" - "+r.cityname;
            pid=r.prov;
        }
        that.val(txt);
        baseRender.b(that);
        that.attr("pid",pid);
        that.attr("cid",r.city);
    },
    /*
     * 功能：信息保存成功
     * 参数：
     * data:后台返回数据
     */
    fe:function(data){
        var id=$("div#pr_num").data("bid");                   
        auresumeController.ba($(id).parent().parent().prev());
        $(id).parent().parent().parent().find("a.alertitem").trigger("click");
        var that=$("#expay");
        if(that.val()=="12"){
            that.prev().fadeOut(10);
        }
    },
    /*
     * 功能：信息保存失败
     * 参数：
     * data:后台返回数据
     */
    ff:function(data){
        alert(data.data);
    },
    /*
     * 功能：全职简历添加第二步成功
     * 参数：
     * data:后台返回数据
     */
    fg:function(data){
        $("div.steptab2 span.gray").css("display","block");
        AddFResController.ad();
    },
    /*
     * 功能：全职简历立即公开简历
     * 参数：
     * data:后台返回数据
     */
    fh:function(data){
        alert("操作成功,去 我添加的简历 看看吧!","","","",function(){
            location.href=WEBROOT+"/atm/1";
        });
    },
    /*
     * 功能：生成工作经历模板
     * 参数：
     * data:添加的简历数据
     */
    //    fi:function(data){
    //        var temp=TEMPLE;
    //        var html=temp.T00084;
    //        html+=temp.T00078.replace('<p class="blue">工作经历{count}</p>',"");
    //        var par=$("div.fresalter div.addfres div.step5");
    //        var count=par.find("div.wpitem").length+1;
    //        html=html.replace("{count}",count).replace("{stime}",data.b).replace("{etime}",data.c).replace("{comname}",data.d)
    //        .replace("{proname}",data.e).replace("{comscale}",data.l).replace("{comchar}",data.k).replace("{depart}",data.a)
    //        .replace("{position}",data.h).replace("{wdes}",data.i);
    //        html='<div class="wpitem" wxid="">'+html+'</div>'
    //        $("#workexp").data("newtmp",html);
    //    },
    /*
     * 功能：添加工作经历成功
     * 参数：
     * data:添加的简历数据
     */
    fj:function(){
        alert("添加成功!","","","",function(){
            location.reload();
        });
    },
    /*
     * 功能：保存工作经历失败
     * 参数：
     * data:添加的简历数据
     */
    fk:function(data){
        alert(data.data);
    },
    /*
     * 功能：保存工作经历成功
     * 参数：
     * data:添加的简历数据
     */
    fl:function(){
        var par=$("#workexp");
        auresumeController.bf(par.parent().prev(),"#workexp");
        par.parent().parent().prev().find("a.alters").trigger("click");
    },
    //    /*
    //     * 功能：生成工程业绩模板
    //     * 参数：
    //     * data:添加的简历数据
    //     */
    //    fm:function(data){
    //        var tmp=TEMPLE.T00079;
    //        var par=$("div#project_cont");
    //        var count=par.find("div.detinfo").length+1;
    //        tmp=tmp.replace("{count}",count).replace("{proname}",data.a).replace("{proscale}",data.h).replace("{stime}",data.c).replace("{etime}",data.d)
    //        .replace("{propos}",data.e).replace("{workcont}",data.f);
    //        par.data("newtmp",tmp);
    //        var tb=$("#projects");
    //        tb.find("input[type='text'],textarea").val("");
    //        tb.find("div.result").remove();
    //    },
    /*
     * 功能：添加工程业绩成功
     * 参数：
     * data:添加的简历数据
     */
    fn:function(){
        alert("添加成功!","","","",function(){
            location.reload();
        });
    },
    /*
     * 功能：保存工程业绩失败
     * 参数：
     * data:添加的简历数据
     */
    fo:function(data){
        alert(data.data);
    },
    /*
     * 功能：保存工程业绩成功
     * 参数：
     * data:添加的简历数据
     */
    fp:function(){
        var par=$("#projects");
        auresumeController.bf(par.parent().prev(),"#projects");
        par.parent().parent().prev().find("a.alters").trigger("click");
    },
    /*
     * 功能：删除资质证书成功
     * 参数：
     * data:后台返回数据
     */
    fq:function(data){
        var par=$("#myquals");
        par.find("a.delqual[cid='"+par.data("cid")+"']").parent().remove();
        if(par.find("div.qualitem").length==1){
            par.find("div.qualitem:eq(0) a.delqual").fadeOut(50);
        }
        if($("#tqual").css("display")=="none"){
            var apar=par.find("a.addqual");
            var add=apar.eq(apar.length-1);
            add.fadeIn(50);
        }
    },
    /*
     * 功能：异步失败
     * 参数：
     * data:后台返回数据
     */
    fr:function(data){
        alert(data.data);
    },
    /*
     * 功能：添加资质证书成功
     * 参数：
     * data:后台返回数据
     */
    fs:function(data){
        var par=$("#myquals");
        par.find("a.blue").fadeOut(100);
        par.find("#tqual").fadeOut(100,function(){
            var qpar=par.find("#tqual");
            var tmp=par.data("newtmp").replace("{cid}",data.data);
            qpar.before(tmp);
            qpar.val("");
            var fp=par.find("div.qualitem:eq(0)");
            var that=auresumeController;
            if(fp.hasClass("noqual")){
                fp.remove();
            }
            var len=par.find("div.qualitem").length;
            that.bn(par.find("a.delqual").eq(len-1));
            that.bo(par.find("a.addqual").eq(len-1));
            if(len==2){
                par.find("a.delqual:eq(0)").fadeIn(50);
            }else if(len==1){
                par.find("a.delqual:eq(0)").css("display","none");
            }
        });
    },
    /*
     * 功能：添加资质证书模板
     * 参数：
     * a：人才id
     * b：证书id
     * c：证书名称
     */
    ft:function(a,b){
        var tmp=TEMPLE.T00084;
        tmp=tmp.replace("{cert}",b).replace("{hid}",a);
        $("#myquals").data("newtmp",tmp);
    },
    /*
     * 功能：立即公开简历成功
     * 参数：
     * data：后台返回数据
     */
    fu:function(data){
        $("div.step a.alertitem").trigger("click");
        alert("简历公开成功!");
        $("#showalert").val("4");
        auresumeController.bj();
    },
    /*
     * 功能：立即结束求职成功
     * 参数：
     * data：后台返回数据
     */
    fv:function(data){
        alert("结束求职成功!");
        var that=$("#pr_num span.red");
        if(that.length){
            that.fadeOut();
        }
        $("#showalert").val("3");
        auresumeController.bj();
    },
    /*
     * 功能：全职添加求职职位
     * 参数：
     * r:插件返回结果
     */
    fw:function(r){
        $("#slt_pos").html("").append(r.jhtml);
        if(!$("#jtip").hasClass("hidden")){
            $("#jtip").addClass("hidden");
        }
        auresumeController.ah(r.obj);
    },
    /*
     * 功能：期望待遇事件绑定
     * 参数：
     * data：后台返回数据
     */
    h:function(){
        var text,val;
        var salary=$("#expay").prev("span.txtinfo");
         text=salary.text();                
         val=salary.attr("val")*1;            
            $("#expay").bind("change",function(){                            
            if(val==12){                
                $(this).next("input.defpay").val(text);  
            }
            if($(this).val()==12){                               
                $(this).next("input.defpay").removeClass("hidden");                
            }
            else{
                $(this).nextAll("div.tip").remove();
                $(this).next("input.defpay").addClass("hidden").removeClass("red_border");
                $(this).next("input.defpay").val('');
            }
        })
    }
}


