/*
 * 猎头创建兼职简历页面渲染器
 */
var cpresumeRender={
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
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        that.data("rid",r.reg);
        that.data("pid",r.prov);
        baseRender.b(that);
        cpresumeRender.e(that);
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
                sure:cpresumeRender.b
            });
            cpresumeRender.d(par.parent().find("a.delqual"));
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
                cpresumeRender.c(cslt.find("a.addqual"));
            }
            var sid="#tqselect"+cid.substring(5);
            var pid="#tqplace"+cid.substring(5);
            $(sid).remove();
            $(pid).remove();
            $(this).parent().parent().remove();
        });
    },
    /*
    *资质添加完成后显示添加或删除k
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
        that.data("ids",ids);
    },
    /*
     * 功能：添加兼职简历成功
     * 参数：
     * data：后台返回数据
     */
    h:function(data){
        var ob=$("div").data("obj");
        $(ob).css("cursor","default");
        document.body.style.cursor="default";      
         alert(LANGUAGE.L0118,'right','','',function(){
            location.href=WEBROOT+"/atm/1";             
         });         
    },
    /*
     * 功能：异步失败
     * 参数：
     * data：后台返回数据
     */
    i:function(data){
        alert(data.data);
    },
    /*
     * 功能：期望待遇事件绑定
     * 参数：
     * data：后台返回数据
     */
    j:function(){
        $("#expay").bind("change",function(){            
            if($(this).val()==12){
                $(this).next("input.defpay").removeClass("hidden");
            }
            else{
                $(this).nextAll("div.tip").remove();
                $(this).next("input.defpay").addClass("hidden").removeClass("red_border");
                $(this).next("input.defpay").val('')
            }
        })
    }
};
