/*
 * 猎头人才管理页面渲染器
 */
var addfresRender={
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
        baseRender.ai(that,20);
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
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        that.data("rid",r.reg);
        that.data("pid",r.prov);
        baseRender.b(that);
        addfresRender.e(that);
    },
    /*
    *资质添加完成后绑定添加功能i
    */
    c:function(obj){
        $(obj).unbind("click");
        $(obj).bind("click",function(){
            var that=$(this).parent().find("input.qual_select");
            $(this).parent().find("span.blue").remove();
            $(this).remove();
            var html=that.parent().parent().html();
            var txt=that.parent().find("input.qual_select");
            var id=txt.attr("id");
            var val=txt.val();
            var num=id.substring(5);
            num=parseInt((num==""?0:num),10)+1;
            var nid=id.substring(0,5)+num;
            html=html.replace(id,nid).replace(val,"");
            html="<tr>"+html+"</tr>";
            that.parent().parent().after(html);
            var par=$("#"+nid);
            if(num==1){
                par.after(COMMONTEMP.T0016);
            }
            par.parent().prev().find("span.red").remove();
            par.hgsSelect({
                id:"tqselect"+num,
                pid:"tqplace"+num,
                pshow:true,
                sprov:true,
                single:true,
                sure:addfresRender.b
            });
            addfresRender.d(par.parent().find("a.delqual"));
        });
    },
    /*
    *资质添加完成后绑定删除功能j
    */
    d:function(obj){
        $(obj).unbind("click");
        $(obj).bind("click",function(){
            var slt=$(this).parent().parent().parent();
            var len=slt.find("input.qual_select").length-1;
            var lid=slt.find("input.qual_select:eq("+len+")").attr("id");
            var cid=$(this).parent().find("input.qual_select").attr("id");
            if(lid==cid){
                var html=COMMONTEMP.T0015;
                var index=$(this).parent().parent().parent().find("input.qual_select").length;
                if(index>2){
                    html="<span class='blue'>| </span>"+html;
                }
                var cslt=slt.find("input.qual_select:eq("+(index-2)+")").parent();
                cslt.append(html);
                addfresRender.c(cslt.find("a.addqual"));
            }
            var sid="#tqselect"+cid.substring(5);
            var pid="#tqplace"+cid.substring(5);
            $(sid).remove();
            $(pid).remove();
            $(this).parent().parent().remove();
        });
    },
    /*
    *资质添加完成后显示添加或删除
    *参数：
    *obj
    */
    e:function(obj){
        var that=$(obj);
        var len=that.parent().parent().parent().find("input.qual_select").length;
        var ish=that.parent().parent().parent().find("a.addqual").length;
        if(len==1&&ish==0){
            that.after(COMMONTEMP.T0015);
            this.c(that.parent().find("a.addqual"));
        }
        else if(len>1&&ish==0){
            that.parent().append("<span class='blue'>| </span>"+COMMONTEMP.T0015);
            this.c(that.parent().find("a.addqual"));
        }
    },
    /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    f:function(r){
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
    g:function(r){
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
        that.data("pid",pid);
        that.data("cid",r.city);
    },
    /*
     * 功能：全职简历添加第一步成功
     * 参数：
     * data:后台返回数据
     */
    h:function(data){
        $("div.steptab1 span.gray").css("display","block");
        AddFResController.ab();
        $("#twonext").data("hid",data.data.human_id);
        $("#pubresnow,#wsaveadd,#wsave,#psaveadd,#psave").data("rid",data.data.resume_id);
    },
    /*
     * 功能：全职简历添加第一步失败
     * 参数：
     * data:后台返回数据
     */
    i:function(data){
        alert(data.data);
    },
    /*
     * 功能：全职简历添加第二步成功
     * 参数：
     * data:后台返回数据
     */
    j:function(data){
        $("div.steptab2 span.gray").css("display","block");
        AddFResController.ad();
    },
    /*
     * 功能：全职简历立即公开简历
     * 参数：
     * data:后台返回数据
     */
    k:function(data){
        alert("操作成功,去 我添加的简历 看看吧!","","","",function(){
            location.href=WEBROOT+"/atm/1";
        });
    },
    /*
     * 功能：生成工作简历模板
     * 参数：
     * data:添加的简历数据
     */
    l:function(data){
        var tmp=TEMPLE.T00078;
        var par=$("div#wdegree_cont");
        var count=par.find("div.detinfo").length+1;
        tmp=tmp.replace("{count}",count).replace("{stime}",data.b).replace("{etime}",data.c).replace("{comname}",data.d)
        .replace("{proname}",data.e).replace("{comscale}",data.l).replace("{comchar}",data.k).replace("{depart}",data.a)
        .replace("{position}",data.h).replace("{wdes}",data.i);
        par.data("newtmp",tmp);
        var tb=$("#workexp");
        tb.find("input[type='text'],textarea").val("");
        tb.find("div.result").remove();
    },
    /*
     * 功能：保存并添加工作经历成功
     * 参数：
     * data:添加的简历数据
     */
    m:function(){
        var par=$("div#wdegree_cont");
        var tmp=par.data("newtmp");
        par.append(tmp);
        par.find(">div.hidden").slideDown(500).removeClass("hidden");
    },
    /*
     * 功能：保存工作经历失败
     * 参数：
     * data:添加的简历数据
     */
    n:function(data){
        $("div#wdegree_cont").data("newtmp","");
        alert(data.data);
    },
    /*
     * 功能：保存工作经历成功
     * 参数：
     * data:添加的简历数据
     */
    o:function(){
        var par=$("div#wdegree_cont");
        var tmp=par.data("newtmp");
        par.append(tmp);
        par.find(">div.hidden").slideDown(500).css("border-bottom","none");
        $("table#workexp").fadeOut(300,function(){
            $(this).remove();
            par.next().remove();
        });
    },
    /*
     * 功能：生成工程业绩模板
     * 参数：
     * data:添加的简历数据
     */
    p:function(data){
        var tmp=TEMPLE.T00079;
        var par=$("div#project_cont");
        var count=par.find("div.detinfo").length+1;
        tmp=tmp.replace("{count}",count).replace("{proname}",data.a).replace("{proscale}",data.h).replace("{stime}",data.c).replace("{etime}",data.d)
        .replace("{propos}",data.e).replace("{workcont}",data.f);
        par.data("newtmp",tmp);
        var tb=$("#projects");
        tb.find("input[type='text'],textarea").val("");
        tb.find("div.result").remove();
    },
    /*
     * 功能：保存并添加工程业绩成功
     * 参数：
     * data:添加的简历数据
     */
    q:function(){
        var par=$("div#project_cont");
        var tmp=par.data("newtmp");
        par.append(tmp);
        par.find(">div.hidden").slideDown(500).removeClass("hidden");
    },
    /*
     * 功能：保存工程业绩失败
     * 参数：
     * data:添加的简历数据
     */
    r:function(data){
        $("div#project_cont").data("newtmp","");
        alert(data.data);
    },
    /*
     * 功能：保存工程业绩成功
     * 参数：
     * data:添加的简历数据
     */
    s:function(){
        var par=$("div#project_cont");
        var tmp=par.data("newtmp");
        par.append(tmp);
        par.find(">div.hidden").slideDown(500).css("border-bottom","none");
        $("table#projects").fadeOut(300,function(){
            $(this).remove();
            par.next().remove();
        });
    },
    /*
     * 功能：全职添加求职职位
     * 参数：
     * r:插件返回结果
     */
    t:function(r){
        $("#slt_pos").html("").append(r.jhtml);
        if(!$("#jtip").hasClass("hidden")){
            $("#jtip").addClass("hidden");
        }
        AddFResController.fh(r.obj);
    },
    /*
     * 功能：期望待遇事件绑定
     * 参数：
     * data：后台返回数据
     */
    u:function(){
        $("#expay").bind("change",function(){            
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
};
