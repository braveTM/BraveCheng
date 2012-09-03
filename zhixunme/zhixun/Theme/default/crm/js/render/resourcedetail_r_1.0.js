/*
 *CRM客户资源详细页面渲染
 */
var resourcedetailRender={
    /*******************************公共部分***********************************************/
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
    b:function(r){
        var that=r.obj;
        var txt=r.jtlname+" - "+r.jtname;
        that.val(txt);
        that.attr("cid",r.jtid);
        that.attr("gra",r.jtlid);
    },
    /*
     * 功能：添加所在地添加结果
     * 参数：
     * r:插件返回结果
     */
    c:function(r){
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
    /*******************************详细相关********************************************/
    /*
    * 功能：成功保存对应区域信息
    * 参数：
    * data:后台返回数据
    */
    aa:function(){
        var id=$("div").data("bid");
        var par= $(id).parent().parent().parent();
        var that=resourcedetailController;
        that.i($(id).parent().parent().prev());
        if(par.find("a.base_add")){
            par.find("a.base_add").addClass("base_edit");
            par.find("a.base_add").removeClass("base_add");
            par.find("a.base_edit").attr("title","修改");
            that.dd(par.find("a.base_edit"));
            par.find("a.base_edit").trigger("click");
        }else{
          par.find("a.base_edit").trigger("click");
        }
    },
    /*
    * 功能：信息保存失败
    * 参数：
    * data:后台返回数据
    */
    ab:function(data){
        alert(data.data);
    },
    /*
     * 功能：删除资质证书成功
     * 参数：
     * data:后台返回数据
     */
    ac:function(cur){
        var par=$("#myquals");
        var ob=$("div").data("obj");
        $(ob).parent().remove();
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
    ad:function(data){
        alert(data.data);
    },
    /*
     * 功能：添加资质证书成功
     * 参数：
     * data:后台返回数据证书id
     */
    ae:function(data){
        var pt= $("div").data("bd");
        var par=$("#myquals");
        var that=resourcedetailController;
        par.find("a.blue").fadeOut(100);
        par.find("#tqual").fadeOut(100,function(){
            var qpar=par.find("#tqual");
            var tmp=$("#myquals").data("newtmp").replace("{cid}",data.data);
            qpar.before(tmp);
            qpar.val("");
            var len=par.find("div.qualitem").length;
            that.dh(par.find("a.delqual").eq(len-1));
            that.di(par.find("a.addqual").eq(len-1));
            if(len==2){
                par.find("a.delqual:eq(0)").fadeIn(50);
            }else if(len==1){
                par.find("a.delqual:eq(0)").fadeOut();
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
    af:function(a,b){
        var tmp=TEMPLE.T00084;
        tmp=tmp.replace("{cert}",b);
        $("#myquals").data("newtmp",tmp);
    },
    /********************************企业详细相关*******************************************/
    /*
     * 功能：删除资质证书成功
     * 参数：
     * data:后台返回数据
     */
    ca:function(){
        var par=$("#myquals");
        par.find("a.delcq[rel='"+par.data("cid")+"']").parent().remove();
        if(par.find("div.qualitem").length==1){
            par.find("div.qualitem:eq(0) a.delcq ").fadeOut(50);
        }
        if($("#enter_cqual").css("display")=="none"){
            var apar=par.find("a.addcq");
            var add=apar.eq(apar.length-1);
            add.fadeIn(50);
        }
    },
    /*
     * 功能：异步失败
     * 参数：
     * data:后台返回数据
     */
    cb:function(data){
        alert(data.data);
    },
    /*
     * 功能：添加资质证书成功
     * 参数：
     * data:后台返回数据证书id
     */
    cc:function(data){
        var pt= $("div").data("bd");
        var par=$("#myquals");
        par.find("a.blue").fadeOut(100);
        par.find("#enter_cqual").fadeOut(100,function(){
            var qpar=par.find("#enter_cqual");
            var tmp=$("#myquals").data("newtmp").replace("{qid}",data.data).replace("{cid}",data.data);
            qpar.before(tmp);
            qpar.val("");
            var that=resourcedetailController;
            var len=par.find("div.qualitem").length;
            that.cd(par.find("a.delcq"));
            that.ce(par.find("a.addcq").eq(len-1));
            that.ch(par.find("a.updecq"));
            that.cl($(pt).parents("table.tb_cm"));
            if(len==2){
                par.find("a.delcq:eq(0)").fadeIn(50);
            }else if(len==1){
                par.find("a.delcq").hide();
            }
        });
    },
    /*
     * 功能：添加资质证书模板
     * 参数：
     * a：资质ID
     * b：证书名称
     */
    cd:function(b){
        var tmp=TEMPLE.C_T005;
        tmp=tmp.replace("{cert}",b);
        $("#myquals").data("newtmp",tmp);
    },
    /*
     *功能：更新企业资质操作成功
     *参数：无
     */
    ce:function(){
        var id=$("div").data("bd");
        resourcedetailController.cl($(id).parents("table.tb_cm"));
        $(id).parent().parent().find("a.updecq ").trigger("click");   
    },
    /*
     *功能：获取城市成功
     *参数：无
     */
    cf:function(data){
        var id=$("div").data("bd");
        var dt=data.data;
        var html="";
        $.each(dt,function(i,o){
            html+='<option value="'+o.id+'">'+o.name+'</option>';
        });
        $("#adr_city").empty();
        $("#adr_city").append(html); 
        if($("#adr_city").hasClass("hidden")&& $("#adr_city").prev().hasClass("hidden")){
            $("#adr_city").removeClass("hidden");
        }
        if($("#adr_reg").hasClass("hidden")&& $("#adr_reg").prev().hasClass("hidden")){
            $("#adr_reg").removeClass("hidden");
        }
        if($("#adr_city").prev().hasClass("hidden")){
            var val=$("#adr_city").prev().attr("val");
            $("#adr_city").find("option[value='"+val+"']").attr("selected",true);
        }else{
            $("#adr_city>option:eq(0)").attr("selected",true);
        }
        $("#adr_city").trigger('change');
    },
    /*
     *功能：获取区域成功
     *参数：无
     */
    ch:function(data){
        var id=$("div").data("bd");
        var dt=data.data;
        var html="";
        $.each(dt,function(i,o){
            html+='<option value="'+o.id+'">'+o.name+'</option>';
        });
        $("#adr_reg").empty();
        $("#adr_reg").append(html);
        $("#street").removeClass("hidden");
        if($("#adr_city").prev().hasClass("hidden")){
            var val=$("#adr_reg").prev().attr("val");
            $("#adr_reg").find("option[value='"+val+"']").attr("selected",true);
        }else{
            $("#adr_reg>option:eq(0)").attr("selected",true);
        }
        $("#adr_reg").trigger('change');
    },
    /*
     *功能：获取城镇成功
     *参数：无
     */
    ci:function(ret){
        var dt=ret.data;
        if(ret.ret&&dt!=""){
            var html="";
            $.each(dt,function(i,o){
                html+='<option value="'+o.id+'">'+o.name+'</option>';
            });
            if($("#adr_community").hasClass("hidden") && $("#adr_community").prev().hasClass("hidden")){
                $("#adr_community").removeClass("hidden");
            }
            $("#adr_community").empty();
            $("#adr_community").append(html);
            if($("#adr_city").prev().hasClass("hidden")){
                var val=$("#adr_community").prev().attr("val");
                $("#adr_community").find("option[value='"+val+"']").attr("selected",true);
            }else{
                $("#adr_community>option:eq(0)").attr("selected",true);
            }
            $("#adr_community").trigger('change');
        }
    },
    /*
     *功能：获取城市数据失败
     *参数：无
     */
    cg:function(ret){
        $("#street").val("").addClass("hidden");
        $("#adr_city").empty().addClass("hidden");
        $("#adr_reg").empty().addClass("hidden");
        $("#adr_community").empty().addClass("hidden");
    },
    /*
     *功能：获取区域数据失败
     *参数：无
     */
    tcg:function(ret){
        $("#adr_reg").empty().addClass("hidden");
        $("#adr_community").empty().addClass("hidden");
    },
    /*
     *功能：获取城镇数据失败
     *参数：无
     */
    cj:function(ret){
        $("#adr_community").empty().addClass("hidden");
    },
    /*
     *修改交易记录异步成功后执行
     *参数：data
     *    
     */
    ds:function(data){            
        var cthis=$("#rcord_detail").prev().prev().find("a.ad_rd.c"); //添加记录
        var note=$("#editext").val();        
        var cateid_text=$("#cateNow option:selected").text();
        var cateid=$("#cateNow");
        var notes;         
        var proid=0,proid_text='';
        var temp;        
        if(!$("#proNow").hasClass("hidden")){
            proid_text='-'+$("#proNow option:selected").text();
            proid=$("#proNow").val();
        }         
        if(cthis.length==0){                                                    
            cthis=$("#rcord_detail p.deal_recod a.edt_p.c");     //更新记录 
            notes=cthis.parent().prev();    
            notes.html(note); 
        }                      
        else{
            temp='<li><div class="dp lf"><span val="'+cateid.val()+'">'+cateid_text+'</span><span val="'+proid+'">'+proid_text+'</span>'
            +'</div><div class="d_rd lf"><p class="deal_recod"><span class="notes">'+note+'</span>'
            +'<span><a href="javascript:;" title="修改" class="edt_p" rel="'+data.data+'"></a>'
            +'</span></p></div><div class="clr"></div></li>';
            if(!$("#rcord_detail li").length){
                $("#rcord_detail").append(temp);
                $("#rcord_detail").prev().removeClass("hidden");
            }
            else
                $("#rcord_detail li").first().before(temp);
            var newrec=$("#rcord_detail li").first().find("a.edt_p");   //新加元素绑定对话框事件         
            var prams=resourcedetailController.va;                        
            newrec.GetManageData(prams);
        }        
        cthis.removeClass("c"); 
        $().SendRecoderSuc();
    },
    /*
      *功能：删除单条企业需求成功执行
      *参数：无
      */
    ck:function(){
        var ele= $("div").data("bn");
        var par=$(ele).parent().parent().parent();
        $(ele).parent().parent().remove();
        if(par.find("div.quire_item").length==1){
            par.find("div.quire_item:eq(0) a.delequire").remove();
            par.find("div.quire_item:eq(0) a.addquire").fadeIn();
        } 
        if($("#adn_quire").hasClass("hidden")){
            var apar=par.find("a.addquire");
            var add=apar.eq(apar.length-1);
            add.fadeIn(50);
        }
        resourcedetailController.gt();
    },
    /*
      *功能：更新单条企业需求数据成功执行
      *参数：无
      */
    cl:function(){
        var id=$("div").data("bid");
        resourcedetailController.i($(id).parent().prev());
        $(id).parent().find("a.upquire").trigger("click");
    },
    /*
      *功能：企业需求证书初始化
      *参数：无
      */
    cm:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){
            mname=" - "+r.majname;
        }
        var txt="";
        txt=r.cname+mname+" - "+r.regname+" - "+r.pcount+'人'; 
        that.val(txt);
        if(typeof(r.zid)=="undefined"){
            that.parent().find("input[name='rct']").val(r.maj);
        }else{
            that.parent().find("input[name='rct']").val(r.zid);
        }
        that.parent().find("input[name='regct']").val(r.reg);
        that.parent().find("input[name='nbm']").val(r.pcount);
        baseRender.b(that);
        $(that).parent().find("div.result").remove();
    },
    /*
      *功能：添加企业资质证书成功
      *参数：无
      */
    cn:function(data){
        alert('添加成功!');
        window.location.reload();
    //        var pt=$("div").data("bid");
    //        var par=$("div.list_quire");
    //        var tmp=$("div.list_quire").data("newtmp").replace("{demid1}",data.data).replace("{demid2}",data.data).replace("{demid3}",data.data);
    //        var qpar=$("#adn_quire");
    //        qpar.fadeOut(100,function(){
    //            qpar.next().fadeOut(100);
    //            qpar.before(tmp);
    //            qpar.find("input[type='text'],textarea").val("");
    //            var that=resourcedetailController;
    //                var len=par.find("div.quire_item ").length;
    //                that.cq(par.find("a.delequire"));
    //                that.cu(par.find("a.addquire").eq(len-1));
    //                that.cr(par.find("a.upquire"));
    //                that.i($(pt).parent().parent().prev());//保存页面数据
    //                that.gd("input.qquali");
    //                if(len==2){
    //                    par.find("a.delequire:eq(0)").fadeIn(50);
    //                }else if(len==1){
    //                    par.find("a.delequire").remove();
    //                }
    //         });
    },
    /*
      *功能：添加企业资质证书模板
      *参数：无
      */
    co:function(p,cert_name,xl,txt,utx,ftxt){
    //         var tmp=TEMPLE.C_T006;
    //         tmp=tmp.replace("{ct}",p.apt_id)
    //                .replace("{gt}",p.reg_info)
    //                .replace("{rd}",p.need_num)
    //                .replace("{cert}",cert_name)
    //                .replace("{len}",xl)
    //                .replace("{fee}",p.need_price)
    //                .replace("{year}",p.need_year)
    //                .replace("{sfee}",p.service_charge)
    //                .replace("{is_tax}",p.demand_is_tax)
    //                .replace("{tax_tex}",txt)
    //                .replace("{usage}",p.use)
    //                .replace("{usage_text}",utx)
    //                .replace("{_isful}",p.is_fulltime)
    //                .replace("{isful_text}",ftxt)
    //                .replace("{sub}",p.demand_notes)
    //                .replace("{sub1}",p.demand_notes);
    //            $("div.list_quire").data("newtmp",tmp);
    },
    /*
      *功能：添加注册企业人成功
      *参数：无
      */
    cp:function(){
        alert('添加成功!');
        window.location.reload();
    },
    /*
      *功能：更新企业注册人成功
      *参数：无
      */
    cq:function(data){
        var id=$("div").data("bid");
        var par=$(id).parent().prev();
        resourcedetailController.i(par);
        var ppar=par.parent();
        var vv=ppar.attr("name");
        var vvl=vv.substring(4);
        var inp=par.find("input[name='ref"+vvl+"']:checked").val();
        $("div").data("inval",inp);
        $(id).parent().find("a.up_regp").trigger("click"); 
    },
    /*
      *功能：删除企业注册人才成功执行
      *参数：无
      */
    cr:function(){
        var ele=$("div").data("bn");
        var par=$(ele).parent().parent().parent();
        $(ele).parent().parent().remove();
        if(par.find("div.reg_lisitem").length==1){
            par.find("div.reg_lisitem :eq(0) a.dele_regp").remove();
            par.find("div.reg_lisitem :eq(0) a.add_regp").fadeIn();
        } 
        if($("#reg_fm").hasClass("hidden")){
            var apar=par.find("a.add_regp");
            var add=apar.eq(apar.length-1);
            add.fadeIn(50);
        }
        resourcedetailController.gt();
    },
    /*
      *功能：注册人才资质回调
      *参数：无
      */
    cs:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){
            mname=" - "+r.majname;
        }
        var txt="";
        txt=r.cname+mname+" - "+r.regname;
        that.val(txt);
        that.data("zid",r.zid);
        that.data("mid",r.maj);
        if(!that.data("zid")){
            that.parent().find("input[name='rct']").val(r.maj);
        }else{
            that.parent().find("input[name='rct']").val(r.zid);
        }
        that.parent().find("input[name='regct']").val(r.reg);
        baseRender.b(that);
        $(that).parent().find("div.result").remove();
    },
    /********************************人才详细相关*******************************************/
    /*
      * 功能：人才证书修改成功
      * 参数：
      * data：后台返回数据
      */
    ta:function(data){
        var id=$("div").data("bid");
        var par= $(id).parent().parent().parent();
        var that=resourcedetailController;
        that.i($(id).parent().parent().prev());
        par.find("#qalertitem").trigger("click");
    },
    /*
      * 功能：人才基本信息修改失败
      * 参数：
      * data：后台返回数据
      */
    tb:function(data){
        alert(data.data);
    },
    /*
      * 功能：资质添加成功
      * 参数：
      * data：后台返回数据
      */
    tc:function(data){
        var that=resourcedetailRender;
        that.af($("#h_id").val(),$("#tqual").val());
        that.ae(data);
    },
    /*
     *功能：人才上传附件成功执行
     *参数：无
     */
    td:function(){                      
        var h=$("#upfile_hdetail");
        var notemsg=$("#upfile").next().next(".notemsg");                
        notemsg.html('文件上传成功!');
        setTimeout(function(){
            h.fadeOut(50,function(){
            location.reload();
        });
        },1500); 
    },
    /*
     *功能：企业上传附件成功执行
     *参数：无
     */
    te:function(){                      
        var c=$("#upfile_cdetail");       
        var notemsg=$("#upfile").next().next(".notemsg");              
        notemsg.html('文件上传成功!');                
        setTimeout(function(){
            c.fadeOut(50,function(){
            location.reload();
        });
        },1500);                        
    },
    /*
     *功能：人才上传附件失败执行
     *参数：无
     */
    tf:function(data){       
        var h=$("#upfile_hdetail");
        var notemsg=$("#upfile").next().next(".notemsg");               
        h.fadeOut('normal',function(){            
                alert(data);
        });            
        notemsg.html('');              
    },
    /*
     *功能：企业上传附件失败执行
     *参数：无
     */
    tg:function(data){
        var c=$("#upfile_cdetail");
        var notemsg=$("#upfile").next().next(".notemsg");            
        c.fadeOut('normal',function(){                
            alert(data);
        });
        notemsg.html('');    
    },
    /*
     *功能：删除附件成功执行
     *参数：无
     */
    th:function(){                
        $("#b_id").data("obj").remove();        
    },
    /*
     *功能：删除附件失败执行
     *参数：无
     */
    ti:function(){
        alert("文件删除失败!");
    },
    /*
     *功能：详细页导航标签hover效果
     *参数：无
     *author:joe 2012/7/18
     */
    tj:function(){
        $("#r_sd li").mouseover(function(){
            var spn=$(this).find("span");
            $(this).find("a,span").addClass("white");
            spn.removeClass("gray");            
            $(this).find("em").addClass("arrow_m_hov");       
            if(spn.hasClass("exist_c")){
                spn.addClass("exist_c_hov");
            }
        }).mouseout(function(){
            var spn=$(this).find("span");
            $(this).find("a,span").removeClass("white");
            spn.addClass("gray");
            $(this).find("em").removeClass("arrow_m_hov"); 
            spn.removeClass("exist_c_hov");
        });
        $("#r_sd").mouseenter(function(){
             $(this).parents("div.side_bx").animate({
                "width":"180px"
            });
        }).mouseleave(function(){
            $(this).parents("div.side_bx").animate({
                "width":"115px"
            });
        });
    }
};    
