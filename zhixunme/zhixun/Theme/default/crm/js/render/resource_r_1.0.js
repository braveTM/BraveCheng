    /*
 *CRM
 *功能：人才资源管理页面渲染器
 */
var resourceRender={
    /*人才
     *功能：省份选择回调函数
     *参数：无
     */
    a:function(r){
        var that=r.obj;
         $(that).attr("pid",r.prov);
         $(that).val(r.provname);
        that.parent().append(COMMONTEMP.T0032);
        resourceController.mh("a.em_area");
    },
     /*企业
     *功能：省份选择回调函数
     *参数：无
     */
    ca:function(r){
        var that=r.obj;
         $(that).attr("pid",r.prov);
         $(that).val(r.provname);
        that.parent().append(COMMONTEMP.T0032);
        resourceController.mh("a.em_area");
    },
    /*人才
     *功能：资质证书选择回调函数
     *参数：无
     */
    b:function(r){
         var mname="";
        var that=$("#pqcect");
        if(r.majname!=""){mname=" - "+r.majname;}
        var txt=r.cname+mname+" - "+r.regname;
        that.val(txt);
        if(typeof(r.zid)=="undefined"){
          $("input[name='mid']").val(r.maj);
        }else{
           $("input[name='mid']").val(r.zid);  
        }
        $("input[name='rid']").val(r.reg);
         that.parent().find("a.empty").remove();
        that.parent().append(COMMONTEMP.T0031);
        resourceController.mg("a.empty");
    },
      /*企业
     *功能：资质证书选择回调函数
     *参数：无
     */
    cb:function(r){
        var mname="";
        var that=$("#cqt");
        if(r.majname!=""){mname=" - "+r.majname;}
        var txt=r.cname+mname+" - "+r.regname;
        that.val(txt);
        if(typeof(r.zid)=="undefined"){
            $("input[name='cmid']").val(r.maj);
        }else{
          $("input[name='cmid']").val(r.zid);
        }
        $("input[name='crid']").val(r.reg);
         that.parent().find("a.empty").remove();
        that.parent().append(COMMONTEMP.T0031);
        resourceController.mg("a.empty");
    },
    /*人才资源列表
     *功能：职称证书选择回调函数
     *参数：无
     */
    c:function(r){
       var that=r.obj;
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        that.val(txt);
        $("input[name='jtlid']").val(r.jtlid);//职称等级
        $("input[name='jtyid']").val(r.jtypeid);//类型
        $("input[name='jtid']").val(r.jtid);//职称专业
         that.parent().find("a.empty").remove();
        that.parent().append(COMMONTEMP.T0031);
        resourceController.mg("a.empty");
    },
    /*
     *人才资源
     *功能：全选复选框事件处理
     *参数：无
     */
    e:function(obj){
        var par="";
        var pall="";
        if($(obj).hasClass("all")){
            par=$(obj).parent().parent().next().next().next().find("td input[name='ops']")
            pall=$(obj).parent().parent().next().next().next().next("div.h_md").find("input[name='nams']"); 
        }else{
            par=$(obj).parents("div.hr_hd").prev("table.hr_list").find("td input[name='ops']");
            pall=$(obj).parents("div.hr_hd").prev("table.hr_list").prev().prev().prev().find("input[name='chos_all']");
        }
        if($(obj)[0].checked||$(pall).checked){
            par.attr("checked", true);
            pall.attr("checked", true);
            var ids=$("input[name='ops']:checked");
            var ck='';
           var names=$("input[name='ops']:checked").parent().next().find("a.blue");
            var cm='';
            $.each(ids,function(i,o){
                if(i==0){
                    ck+=$(o).val();
                }else{
                    ck+=','+$(o).val();
                }
            });
            $.each(names,function(i,o){
                if(i==0){
                    cm+=$(o).text();
                }else{
                    cm+=','+$(o).text();
                }
            });
        $("input[name='ditem']").val(ck);
        $("input[name='peoples']").val(cm);
        }
        else{
            par.attr("checked", false);
            pall.attr("checked", false);
            $("input[name='ditem']").val("");
        $("input[name='peoples']").val("");
        }
    },
    /*
     *人才资源
     *功能：单个复选框点击事件处理
     *参数:无
     */
    g:function(){
        var len1=$("table.hr_list input[name='ops']:checked").length;
        var len2=$("table.hr_list input[name='ops']").length;
        var ids=$("input[name='ops']:checked");
        var names=$("input[name='ops']:checked").parent().next().find("a.blue");
        var ck='';
        var cm='';
        $.each(ids,function(i,o){
            if(i==0){
                ck+=$(o).val();
            }else{
                ck+=','+$(o).val();
            }
        });
        $.each(names,function(i,o){
            if(i==0){
                cm+=$(o).text();
            }else{
                cm+=','+$(o).text();
            }
        });
        $("input[name='ditem']").val(ck);
        $("input[name='peoples']").val(cm);
        if(len1==len2){
             $("span.lt input[name='chos_all'],div.hr_hd input[name='nams']").attr("checked",true);
        }
        else{
           $("span.lt input[name='chos_all'],div.hr_hd input[name='nams']").attr("checked",false);
        }
    },
    /*
     *异步获取人才资源列表成功
     *参数：无
     */
    h:function(data){
       var rt=resourceController; 
        var count=resourceRender.j(data);
       rt.ap(count,"#pagination",rt.h);
    },
    /*
     *功能：异步获取人才资源数据失败
     *参数：无
     */
    i:function(){
      var rt=resourceController; 
      rt.ap(0,"#pagination",rt.h);
      $("#hr_list").html(TEMPLE.C_T002+'<tr class="no-data"><td colspan="7" class="red"><div class="emty">您暂时还未添加客户资源，请选择添加资源 或 批量导入资源<div class="tp"></div></div></td></tr>');
      $("#hr_list").parent().find("li.loading").parent().remove();
      rt.e();
      rt.f();
    },
    /*
     *功能：处理人才资源数据
     *参数：无
     */
    j:function(data){
        var count=data.count;
        var dt=data.data;         
        var resour=new Resource();
         var da=[];         
        $.each(dt, function(i,o){
            var jb=resour;
            var certs="";
            var cr="";
            var notes="";
            var jitem={};
            if(typeof(o.aptitude)=="undefined"){
                o.aptitude=[];
            }else if(o.aptitude==""){
                certs="";
            }
            else{
                $.each(o.aptitude,function(k,item){
                certs+='<p>'+(item)+'</p>';
              });
            }  
             if(typeof(o.certificate_copy)=="undefined"){
                o.certificate_copy=[];
            }else if(o.certificate_copy==""){
                cr="";
            }
            else{
                $.each(o.certificate_copy,function(k,item){
                cr+='<p>'+(item)+'</p>';
              });
            }  
            if(typeof(o.province)=="undefined"||o.province==""){
                o.province="";
            }
            if(o.status_notes==""){
               jitem[jb.period]="";
               notes+='<p rel="true" class="deal_recod"><span class="recode"></span><span cateid="'+o.cate_id+'">'
                    +'<a rel="'+o.status_id+'" title="修改" style="display:none" class="edt_p"></a><a title="添加新纪录" class="edt_p ad_rd"></a></span></p>';
            }else{
               notes+='<p rel="true" class="deal_recod"><span class="recode">'+o.status_notes+'</span><span proid="'+o.pro_id+'">'
                    +'<a rel="'+o.status_id+'" title="修改" class="edt_p"></a></span><span cateid="'+o.cate_id+'">'
                    +'<a title="添加新纪录" class="edt_p ad_rd"></a></span></p>';
                if(o.status_progress==""||typeof(o.status_progress)=="undefined"){
                    jitem[jb.period]=o.status_stage;
                }else{
                 jitem[jb.period]=o.status_stage+"-"+o.status_progress;
                }
            }                         
            jitem[jb.notes]=notes;
            jitem[jb.cert]=certs;
            jitem[jb.id]=o.id;
            jitem[jb.name]=o.name;
            jitem[jb.title]=o.title;
            jitem[jb.type]=o.fulltime;
            jitem[jb.province]=o.province;
            jitem[jb.mobile]=o.mobile;
            jitem[jb.qq]=o.qq;
            jitem[jb.source]=o.source;
            jitem[jb.money]=o.quote;  
            jitem["cer"]=cr;
            da[i]=jitem;
        });        
        var varr=['cer',resour.title,resour.notes,resour.period,resour.cert,resour.name,resour.id,resour.type,resour.province,resour.mobile,resour.qq,resour.source,resour.money];
        var mytmp=[];           
        mytmp=TEMPLE.C_T001;
        HGS.Base.GenTemp("hr_list",varr,da,mytmp);
        $("#hr_list tr:eq(0)").before(TEMPLE.C_T002);
        $("#hr_list").parent().find("li.loading").parent().remove();
        var that=resourceController;
        that.e();
        that.f();
        that.c("a.dele_human");
        that.v();    
        that.mi("#hr_list td.nd a.blue");
        return count;
    },
     /*
     *异步获取筛选人才资源列表成功
     *参数：无
     */
    k:function(data){
       var count=resourceRender.j(data);
        var rt=resourceController;
       rt.ap(count,"#pagination",rt.l);
       rt.e();
       rt.f();
    },
     /*
     *异步获取筛选人才资源列表失败
     *参数：无
     */
    ak:function(){
      var rt=resourceController;
       rt.ap(0,"#pagination",rt.l);
      $("#hr_list").html(TEMPLE.C_T002+"<tr class='no-data'><td colspan='7'>暂无相关数据!</td></tr>");
       $("#hr_list").parent().find("li.loading").parent().remove();
      rt.e();
      rt.f();
    },
    /**************企业资源列表数据获取****************/
     /*
     *异步获取企业资源列表成功
     *参数：无
     */
    l:function(data){
        var count=resourceRender.n(data);
        var rt=resourceController;
       rt.ap(count,"#pagination1",rt.q);
    },
    /*
     *功能：异步获取企业资源数据失败
     *参数：无
     */
    m:function(){
      var that=resourceController;
      that.ap(0,"#pagination1",that.q);
      $("#cmp_list").html(TEMPLE.C_T004+'<tr class="no-data"><td colspan="7" class="red"><div class="emty">您暂时还未添加客户资源，请选择添加资源 或 批量导入资源<div class="tp"></div></div></td></tr>');
       $("#cmp_list").parent().find("li.loading").parent().remove();
      that.ce();
      that.f();
    },
    /*
     *功能：处理企业资源数据
     *参数：无
     */
    n:function(data){
        var count=data.count;
        var dt=data.data;          
        var resour=new Resource();
         var da=[];
        $.each(dt, function(i,o){
            var jb=resour;
            var certs="";
            var notes="";
            var jitem={};
            if(typeof(o.demand)=="undefined"){
                o.demand=[];
            }else if(o.demand==""){
                certs="";
            }
            else{
                $.each(o.demand,function(k,item){
                 certs+='<div class="ct"><p><span class="red">['+item.fulltime+']</span>'+item.aptitude+'-'+item.number+'人 | <span class="red">¥'+item.price+' 万 /'+item.per_year+' 年·人</span><span class="uge">'+item.use+'</span></p></div>';
              });
            }  
            if(typeof(o.province)=="undefined"||o.province==""){
                o.province="";
            }
            if(o.status_notes==""){
               jitem[jb.period]="";                                             
            notes+='<p rel="false" class="deal_recod"><span class="recode"></span><span cateid="'+o.cate_id+'">'
                    +'<a rel="'+o.status_id+'" title="修改" style="display:none" class="edt_p"></a><a title="添加新纪录" class="edt_p ad_rd"></a></span></p>';
            }else{
               notes+='<p rel="false" class="deal_recod"><span class="recode">'+o.status_notes+'</span><span proid="'+o.pro_id+'">'
                    +'<a rel="'+o.status_id+'" title="修改" class="edt_p"></a></span><span cateid="'+o.cate_id+'">'
                    +'<a title="添加新纪录" class="edt_p ad_rd"></a></span></p>';                                        
                if(o.status_progress==""||typeof(o.status_progress)=="undefined"){
                    jitem[jb.period]=o.status_stage;
                }else{
                    jitem[jb.period]=o.status_stage+"-"+o.status_progress;
                }
            }           
            jitem[jb.notes]=notes;
            jitem[jb.cert]=certs;
            jitem[jb.id]=o.id;
            jitem[jb.name]=o.name;
            jitem[jb.type]=o.fulltime;
            jitem[jb.province]=o.province;
            jitem[jb.mobile]=o.mobile;
            jitem[jb.phone]=o.phone;
            jitem[jb.qq]=o.qq;
            jitem[jb.source]=o.source;
            jitem[jb.money]=o.quote;
            da[i]=jitem;
        });
        var varr=[resour.notes,resour.period,resour.cert,resour.name,resour.id,resour.type,resour.province,resour.phone,,resour.mobile,resour.qq,resour.source,resour.money];
        var mytmp=[];   
        mytmp=TEMPLE.C_T003;
        var ntp=TEMPLE.C_T004;
        HGS.Base.GenTemp("cmp_list",varr,da,mytmp);
        $("#cmp_list tr:eq(0)").before(ntp);
        $("#cmp_list").parent().find("li.loading").parent().remove();
        var that=resourceController;
        that.mi("#cmp_list td.nd a.blue");
        that.ce();
        that.f();
        that.v();
        that.d("a.dele_company");        
        return count;
    },
    /*
     *功能：异步获取筛选后的企业数据成功
     *参数：无
     */
    o:function(data){
       var count=resourceRender.n(data);
       var rt=resourceController;
       rt.ap(count,"#pagination1",rt.t);
    },
     /*
     *功能：异步获取筛选后的企业数据失败
     *参数：无
     */
    p:function(){
      var that=resourceController;
       that.ap(0,"#pagination1",that.t);
      $("#cmp_list").html(TEMPLE.C_T004+"<tr class='no-data'><td colspan='7'>暂无相关数据!</td></tr>");
      that.ce();
      that.f();
    },
     /*
      *企业资源
     *功能：全选复选框事件处理
     *参数：无
     */
    ce:function(obj){
        var par="";
        var pall="";
        if($(obj).hasClass("all")){
            par=$(obj).parent().parent().next().next().next().find("td input[name='cnames']")
            pall=$(obj).parent().parent().next().next().next().next().find("input[name='cm']"); 
        }else{
            par=$(obj).parents("div.cp_hd").prev("table.er_list").find("td input[name='cnames']");
            pall=$(obj).parents("div.cp_hd").prev("table.er_list").prev().prev().prev().find("input[name='eall']");
        }
        if($(obj)[0].checked||$(pall).checked){
            par.attr("checked", true);
            pall.attr("checked", true);
            var ids=$("input[name='cnames']:checked");
            var ck='';
            var cm='';
            var cnames=$("input[name='cnames']:checked").parent().next().find("a.blue");
            $.each(ids,function(i,o){
                if(i==0){
                    ck+=$(o).val();
                }else{
                    ck+=','+$(o).val();
                }
            });
             $.each(cnames,function(i,o){
                if(i==0){
                    cm+=$(o).text();
                }else{
                    cm+=','+$(o).text();
                }
            });
            $("input[name='cdeletm']").val(ck);
            $("input[name='cpeos']").val(cm);
        }
        else{
            par.attr("checked", false);
            pall.attr("checked", false);
            $("input[name='cdeletm']").val("");
            $("input[name='cpeos']").val("");
        }
    },
    /*
     *企业资源
     *功能：单个复选框点击事件处理
     *参数:无
     */
    cg:function(){
        var len1=$("table.er_list input[name='cnames']:checked").length;
        var len2=$("table.er_list input[name='cnames']").length;
       var ids=$("input[name='cnames']:checked");
       var ck='';
        var cm='';
        var cnames=$("input[name='cnames']:checked").parent().next().find("a.blue");
        $.each(ids,function(i,o){
            if(i==0){
                ck+=$(o).val();
            }else{
                ck+=','+$(o).val();
            }
        });
        $.each(cnames,function(i,o){
        if(i==0){
            cm+=$(o).text();
        }else{
            cm+=','+$(o).text();
        }
        });
        $("input[name='cdeletm']").val(ck);
        $("input[name='cpeos']").val(cm);
        if(len1==len2){
            $("span.ct input[name='eall'],div.cp_hd input[name='cm']").attr("checked",true);
        }
       else{
           $("span.ct input[name='eall'],div.cp_hd input[name='cm']").attr("checked",false);
       }
    },
    /*
     *功能：删除人才资源成功执行
     *参数：无
     */
    da:function(){
        var ele= $("div").data("obj");
        $("input[type='checkbox']:checked").attr("checked",false);
        $(ele).parent().parent().remove();
        $("input[name='ditem']").val("");
        $("input[name='peoples']").val();
        var rt=resourceController;
        var page=parseInt($("#pagination").find("span.current").not("span.prev,span.next").text(),10);
            page=page-1;
            if($("div").data("ele")){
                if($("table.hr_list>tr").not("tr.bhead").length=="0"){
                    page=0;
                    rt.k(0);
                }else{
                    rt.k(page);
                }
            }else{
                if($("table.hr_list>tr").not("tr.bhead").length=="0"){
                    page=0;
                    rt.ag(0);
                }else{
                    rt.ag(page);
                }
            }
        rt.f();
    },
     /*
     *功能：删除人才资源失败执行
     *参数：无
     */
    db:function(ret){
        alert(ret.data);
    },
    /*
     *遮罩层添加数据成功执行
     *参数：无
     */
      /*
     *功能：删除企业资源成功执行
     *参数：无
     */
    ea:function(){
        var ele= $("div").data("obj");
        $("input[type='checkbox']:checked").attr("checked",false);
        $(ele).parent().parent().remove();
        $("input[name='cdeletm']").val("");
        $("input[name='cpeos']").val("");
        var rt=resourceController;
        var page=parseInt($("#pagination").find("span.current").not("span.prev,span.next").text(),10);
            page=page-1;
            if($("div").data("ele")){
                if($("table.er_list>tr").not("tr.bh").length=="0"){
                    page=0;
                    rt.s(0);
                }else{
                    rt.s(page);
                }
            }else{
                if($("table.er_list>tr").not("tr.bh").length=="0"){
                    page=0;
                    rt.p(0);
                }else{
                    rt.p(page);
                }
            }
        rt.f();
    },
     /*
     *功能：删除企业资源失败执行
     *参数：无
     */
    eb:function(ret){
        alert(ret.data);
    },
     /*
     *修改交易记录异步成功后执行
     *参数：
     *    
     */
    ss:function(){        
        var cthis;
        if(!$("#hr_list").parent().hasClass("hidden")){
            cthis=$("#hr_list td.last a.ad_rd.c"); //人才添加记录            
            var i=null;
            if(!cthis.length){                                   //更新记录       
                i=1;
                cthis=$("#hr_list td.last a.edt_p.c");          
            }
        }        
        if(!$("#cmp_list").parent().hasClass("hidden")){            
            cthis=$("#cmp_list td.last a.ad_rd.c"); //企业添加记录        
            var i=null;
            if(!cthis.length){                                   //更新记录       
                i=1;
                cthis=$("#cmp_list td.last a.edt_p.c");           
            }
        }        
        var note=$("#editext").val();        
        var cateid=$("#cateNow option:selected").text();        
        var cate_id=cthis.parent().parent().parent().prev().find("p");         
        var notes=cthis.parent().prevAll(".recode");                        
        var proid='';
        cthis.prev().css("display","inline-block");
        if(!$("#proNow").hasClass("hidden")){
            proid='-'+$("#proNow option:selected").text();       
        }         
        cate_id.html(cateid+proid);            
        notes.html(note);        
        cthis.removeClass("c"); 
        $().SendRecoderSuc();
    },
    /*
     *功能：添加人才资源成功执行
     *参数：无
     */
    ba:function(data){
       $("#mk").fadeOut();
       window.location.href=WEBROOT+"/rhuman/"+data+"";
    },
    /*
     *功能：添加数据失败
     *参数：无
     */
    bc:function(data){
        alert(data);
    },
      /*
     *功能：添加企业资源成功执行
     *参数：无
     */
    bd:function(data){
        $("#cmk").fadeOut();
       window.location.href=WEBROOT+"/rcompany/"+data+"";
    },
        /*
     *功能：导入人才cvs资源成功执行
     *参数：无
     */
    be:function(msg){        
        $("#import_h").find(".notemsg").html("文件导入成功!");        
        $("#import_hr").fadeOut(1000);
        $("#import_h").find("notemsg").html("");
        alert(msg,"right",true,"",function(){
            location.reload();
        });        
     },   
     /*
     *功能：导入人才csv资源失败执行
     *参数：msg错误信息
     */
    bf:function(msg){
        if($("#error").hasClass("hidden"))
            $("#error").removeClass("hidden");
        $("#error").html(msg);
        $("#error").prevAll(".upfile_l").find(".notemsg").html('');
    },  
     /*
      *功能：发送邮件成功执行
      *参数：无
      */
     bg:function(){
         alert('发送成功');
     },
    /*功能：导入企业csv资源成功执行
     *参数：无
     */
    bh:function(msg){
        $("#import_c").find(".notemsg").html("文件导入成功!");        
        $("#import_cmp").fadeOut(1000);        
        $("#import_c").find("notemsg").html('');            
        alert(msg,"right",true,"",function(){
            location.reload();
        }); 
     },
    /*功能：导入企业cvs资源失败执行
     *参数：无
     */
    bi:function(msg){
        if($("#error").hasClass("hidden"))
            $("#error").removeClass("hidden");
        $("#error").html(msg);
        $("#error").prevAll(".upfile_l").find(".notemsg").html('');
    },
    /*功能：分页点击回到顶部
     *参数：
     */
    bj:function(){                      
        $("html,body").animate({scrollTop:0},500);
    },
    /*
     * 功能：打开一个新窗口
     * 参数：url:窗口链接,width,宽,height高
     * 无
     */
    OpenWin:function(url,width,ht){        
        var wscr=screen.width;
        var toolbar='no';
        var location='no';
        var directories='no';
        var status='no';
        var menubar='no';
        var scrollbars='yes';
        var resizable='no';
        var copyhistory='yes';      
        var height=ht;
        var left=(wscr-width)/2+'px';
        var fullscreen="1";
        var top=0+'px';
        var param='toolbar='+toolbar+', location='+location+', directories='+directories+','
        +'status='+status+',menubar='+menubar+', scrollbars='+scrollbars+','
        +'resizable='+resizable+', copyhistory='+copyhistory+','
        +'width='+width+', height='+height+',left='+left+'top='+top+',fullscreen='+fullscreen;        
        window.open(url,"_blank",param);    
	window.resizeTo(window.screen.availWidth,window.screen.availHeight);    
    }
};


