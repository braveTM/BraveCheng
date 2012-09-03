/*
 * 企业职位管理页面渲染器
 */
var jobpubRender={
    /*
     * 功能：添加资质显示添加结果
     * 参数：
     * r:插件返回结果
     */
    a:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){
            mname=" - "+r.majname;
        }
        var txt=r.cname+mname+" - "+r.regname+" - "+r.pcount;
        that.val(txt);
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        that.data("rid",r.reg);
        that.data("count",r.pcount);
        baseRender.b(that);
        jobpubRender.k(that);
    },
    /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    b:function(r){
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+","+r.jtid;
        $("#jtitle_selt").val(txt);
        $("#jtitle_selt").data("ids", ids);
    },
    /*
     * 功能：添加地区显示添加结果
     * 参数：
     * r:插件返回结果
     */
    c:function(r){
        var txt="";
        var ids="";
        if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname;
            ids=r.prov;
        }
        $("#jpselect").val(txt);
        baseRender.b("#jpselect");
        $("#jpselect").data("ids",ids);
    },
    /*
     * 功能：添加证书使用地区显示添加结果
     * 参数：
     * r:插件返回结果
     */
    d:function(r){
        var txt="";
        var ids=r.prov;
        if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname+" - "+r.cityname;
        }
        $("#jupselect").val(txt);
        baseRender.b("#jupselect");
        $("#jupselect").data("prov",ids);
        $("#jupselect").data("city",r.city);
    },
    /*
     * 功能：兼职全职切换效果
     * 参数：
     * obj:当前
     */
    e:function(obj){
        var index=parseInt($(obj).attr("id").substring(8),10)-1;
        var tb=$(obj).parent().parent();
        tb.find("table").not(".hidden").addClass("hidden");
        tb.find("table:eq("+index+")").removeClass("hidden");
    },
    /*
     * 功能：全职添加资质显示添加结果
     * 参数：
     * r:插件返回结果
     */
    f:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){
            mname=" - "+r.majname;
        }
        var txt=r.cname+mname+" - "+r.regname;
        that.val(txt);
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        that.data("rid",r.reg);
        baseRender.b(that);
        jobpubRender.k(that);
    },
    /*
     * 功能：全职添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    g:function(r){
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+","+r.jtid;
        $("#qtitle_selt").val(txt);
        $("#qtitle_selt").data("ids", ids);
        baseRender.b("#qqual_select");
    },
    /*
     * 功能：全职添加地区显示添加结果
     * 参数：
     * r:插件返回结果
     */
    h:function(r){
        var txt="";
        var ids=r.prov;
        if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname+" - "+r.cityname;
        }
        $("#qpselect").val(txt);
        baseRender.b("#qpselect");
        $("#qpselect").data("prov",ids);
        $("#qpselect").data("city",r.city);
    },
    /*
    *功能：资质添加完成后绑定添加功能
    */
    i:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var that=$(this).parent().find("input.qual_select");
            $(this).parent().find("span.blue").remove();
            $(this).parent().find("a.emptyqual").remove();
            $(this).remove();
            var html=that.parent().parent().html();
            var txt=that.parent().find("input.qual_select");
            var id=txt.attr("id");
            var val=txt.val();
            var num=id.substring(12);
            num=parseInt((num==""?0:num),10)+1;
            var nid=id.substring(0,12)+num;
            html=html.replace(id,nid).replace(val,"");
            html="<tr>"+html+"</tr>";
            that.parent().parent().after(html);
            var par=$("#"+nid);
            if(num==1){
                par.after(COMMONTEMP.T0016);
            }
            par.parent().prev().find("span.red").remove();
            var sid=that.attr("id").substring(0,1);
            if(sid=="j"){
                par.hgsSelect({
                    id:"jqselect"+num,
                    reglishow:true,
                    cshow:true,
                    sure:jobpubRender.a
                });
            }
            else{
                par.hgsSelect({
                    id:"qqselect"+num,
                    reglishow:true,
                    sure:jobpubRender.f
                });
            }
            jobpubRender.j(par.parent().find("a.delqual"));
            par.trigger("click");
        });
    },
    /*
    *功能：资质添加完成后绑定删除功能
    */
    j:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var slt=$(this).parent().parent().parent();
            var len=slt.find("input.qual_select").length-1;
            var lid=slt.find("input.qual_select:eq("+len+")").attr("id");
            var cid=$(this).parent().find("input.qual_select").attr("id");
            if(lid==cid){
                var com=COMMONTEMP;
                var html=com.T0015;
                var index=$(this).parent().parent().parent().find("input.qual_select").length;
                if(index>2){
                    html="<span class='blue'>| </span>"+html;
                }else if(index==2){
                    html=com.T0029+"<span class='blue'> | </span>"+html;
                }
                var cslt=slt.find("input.qual_select:eq("+(index-2)+")").parent();
                cslt.append(html);
                jobpubRender.i(cslt.find("a.addqual"));
                if(index==2){
                    jobpubRender.n(cslt.find("a.emptyqual"));
                }
            }
            var sid="#"+cid.substring(0,1)+"qselect"+cid.substring(12);
            $(sid).remove();
            $(this).parent().parent().remove();
        });
    },
    /*
    *功能：资质添加完成后显示添加或删除
    *参数：
    *obj
    */
    k:function(obj){
        var that=$(obj);
        var len=that.parent().parent().parent().find("input.qual_select").length;
        var ish=that.parent().parent().parent().find("a.addqual").length;
        var com=COMMONTEMP;
        if(len==1&&ish==0){
            that.after(com.T0029+"<span class='blue'> | </span>"+com.T0015);
            this.i(that.parent().find("a.addqual"));
            this.n(that.parent().find("a.emptyqual"));
        }
        else if(len>1&&ish==0){
            that.parent().append("<span class='blue'>| </span>"+com.T0015);
            this.i(that.parent().find("a.addqual"));
        }
    },
    /*
    * 功能：企业立即发布职位成功
    * 参数：
    * data:异步成功返回数据
    */
    l:function(){   
        var el=$("div").data("obj");
        $(el).css("cursor","default");
        document.body.style.cursor = "default";     
        alert("操作成功!","","","",function(){
            location.href=WEBROOT+"/recruitment/";
        });
    },
    /*
    * 功能：猎头立即发布职位成功
    * 参数：
    * data:异步成功返回数据
    */
   al:function(){ 
        var el=$("div").data("obj");
        $(el).css("cursor","default");
        document.body.style.cursor = "default";     
       location.href=WEBROOT+"/apm/1";
   },
    /*
    * 功能：立即发布职位失败
    * 参数：
    * data:异步失败返回数据
    */
    m:function(data){  
        var el=$("div").data("obj");
        $(el).css("cursor","default");
        document.body.style.cursor = "default";    
        alert(data.data);
    },
    /*
    * 功能：清空资质要求
    * 参数：
    * obj：绑定对象
    */
    n:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().find("input[class*='qual_select']");
            par.val("");
            par.data("mid","");
            par.data("zid","");
            par.data("rid","");
            par.data("count","");
            par.parent().find(".blue").remove();
        });
    },
    /*
    * 功能：猎头代理发布职位成功
    * 参数：
    * data:异步成功返回数据
    */
    ai:function(data){
        document.body.style.cursor = "deafault";     
        location.href=data.data;
    },
    /*
     * 功能:错误定位
     * 参数:
     * obj:兼职tab,全职tab,error对象
     */
    error:function(){          
        if($("div").find(".error").length>0){
            var obj=null;
            obj=$("table.tb");       
            obj=obj.find(".error");            
            $("html,body").animate({
                scrollTop:obj.first().offset().top-obj.height()*3
            },500);
        }
    },
    /*
     * 功能：全职添加招聘职位
     * 参数：
     * r:插件返回结果
     */
    o:function(r){
        $("#slt_pos").html("").append(r.jhtml);
        if(!$("#jtip").hasClass("hidden")){
            $("#jtip").addClass("hidden");
        }
        JobpubController.fh(r.obj);
    },
    /*
     * 功能：期望待遇事件绑定
     * 参数：
     * data：后台返回数据
     */
    p:function(){
        $("#jthepay,#thepay").bind("change",function(){            
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