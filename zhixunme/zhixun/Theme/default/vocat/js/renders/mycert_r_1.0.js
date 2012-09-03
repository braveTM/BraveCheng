/*
 * 猎头职位管理页面渲染器
 */
var mycertRender={
    /*
     * 功能：添加资质显示添加结果
     * 参数：
     * r:插件返回结果
     */
    a:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){mname=" - "+r.majname;}
        var txt=r.cname+mname+" - "+r.regname+" - "+r.provname;
        that.val(txt);
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        that.data("rid",r.reg);
        that.data("prov",r.prov);
        baseRender.b(that);
        mycertRender.e(that);
    },
    /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    b:function(r){
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+"-"+r.jtypeid+"-"+r.jtid;
        $("#jtitle_selt").val(txt);
        $("#jtitle_selt").data("ids", ids);
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
            par.hgsSelect({
                    id:"tqselect"+num,     //设置选择框父容器id
                    pid:"tregplace"+num,    //省市添加的父容器id
                    pshow:true,        //是否显示地区选择
                    sprov:true,        //是否只精确到省
                    single:true,       //省是否为单选
                    sure:mycertRender.a
            });
            mycertRender.d(par.parent().find("a.delqual"));
        });
    },
    /*
    *资质添加完成后绑定删除功能
    */
    d:function(obj){
        $(obj).unbind("click");
        $(obj).bind("click",function(){
            var slt=$(this).parent().parent().parent();
            var len=slt.find("input.qual_select").length-1;
            var lid=slt.find("input.qual_select:eq("+len+")").attr("id");
            var cid=$(this).parent().find("input.qual_select").attr("id");
            if(lid==cid){
                var html=COMMONTEMP.T0017;
                var index=$(this).parent().parent().parent().find("input.qual_select").length;
                if(index>2){
                    html="<span class='blue'>| </span>"+html;
                }
                var cslt=slt.find("input.qual_select:eq("+(index-2)+")").parent();
                cslt.append(html);
                mycertRender.c(cslt.find("a.addqual"));
            }
            var sid="#tqselect"+cid.substring(5);
            var pid="#tregplace"+cid.substring(5);
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
            that.after(COMMONTEMP.T0017);
            this.c(that.parent().find("a.addqual"));
        }
        else if(len>1&&ish==0){
            that.parent().append("<span class='blue'>| </span>"+COMMONTEMP.T0017);
            this.c(that.parent().find("a.addqual"));
        }
    },
    /*
    * 功能：上传证书
    * 参数：
    * obj：当前上传按钮
    */
   f:function(obj){
       try{
            var file = $(obj).val();
            if(mycertRender.g(file)){
               $('#form_upload').submit();
            }
        }catch(e){
            mycertRender.h(e)
        }
   },
   /*
    * 功能：是否是图片
    * @author yoyiorlee
    * @date 2012-12-07
    */
    g:function(file){
        //验证是否是图片格式
        if(/^.*?\.(gif|png|jpg|jpeg|bmp)$/i.test(file)){
            return true;
        }
        alert("图片格式不正确，请选择图片。");
        return false;
    },
    /**
     * 错误处理
     * @author yoyiorlee
     * @date 2012-12-07
     */
    h:function(e){
        if(typeof e == "undefined"){
            alert("上传失败，刷新页面或稍后再试。");
        }else{
            alert(e);
        }
    },
    /*
    * 功能：显示图片名称和上传按钮
    * 参数：
    * obj：当前文件上传表单
    */
   l:function(obj){
       var that=$(obj).parent();
       if(that.find("a.asubmit").length==0){
           that.append('<a href="javascript:;" class="red asubmit">确定上传</a>');
       }
       $(obj).css("width","auto");
       MycertController.d(obj);
   },
    /*
    * 功能：证书图片上传结果提示
    * 参数：
    * b：真值
    */
   m:function(b){
       if(b){
           alert("上传成功!");
           var cur=$("#form_upload table a.cur_file");
           cur.prev().prev().text("文件已上传,待审核").css("color","#c00");
           cur.prev().remove();
           cur.parent().find("a.alter").remove();
           cur.remove();
       }else{
           alert("上传失败!");
       }
   },
    /*
     * 功能：删除资质证书失败
     * 参数：
     * data：后天返回数据
     */
   n:function(data){
       alert("删除错误,请刷新页面再试!");
   },
    /*
     * 功能：添加资质证书成功
     * 参数：
     * data：后天返回数据
     */
   o:function(data){
        alert("添加成功!","","","",function(){
            location.reload();
        });
   },
    /*
     * 功能：添加资质证书失败
     * 参数：
     * data：后天返回数据
     */
   p:function(data){
       alert(data.data);
   },
   /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    q:function(r){
        var that=r.obj;
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+","+r.jtid;
        that.val(txt);
        that.data("ids", ids);
        MycertController.m();
    },
   /*
     * 功能：显示修改职称证书选择框
     * 参数：
     * obj：当前修改按钮
     */
    r:function(obj){
        var that=$(obj).parent();
        var tname=that.parent().find("span.tname");
        tname.hide();
        that.find("a.alter").remove();
        that.find("#qtitle").val(tname.text()).fadeIn(200);
    },
   /*
     * 功能：解除认证成功
     * 参数：
     * obj：当前解除按钮
     */
    s:function(obj){
        var that=$(obj).parent();
        var tmp='<span class="gray">未认证</span><input type="file" name="file_tcert" class="files"/>';
        that.parent().append(tmp);
        that.parent().find("span.green").remove();
        that.find("a.opencont").unbind('click');
        that.find("a.opencont").text("修改").addClass("alter").removeClass("opencont");
        var ctr=MycertController;
        ctr.ac($("#htit").parent().find("input[name='file_tcert']"));
        ctr.la(that.find("a.alter"));
    }
};