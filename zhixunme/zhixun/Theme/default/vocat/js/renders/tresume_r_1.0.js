/*
 *简历页面渲染
 *jack
 *2012-1-15
 */
var resumeRender={
    /*
     *(兼职/全职)保存个人基本信息成功
     *jack
     *2012-1-16
     */
    b:function(){
        var id=$("div").data("obd");
        var rc=resumeController;
        var par=$(id).parent().parent().prev().prev().find("table.tb_com");
        resumeController.ad(par);
        rc.ab($(id).parent().parent().prev().find("a.base_edit"));
        par.find("div.result").remove();
        par.parent().addClass("updatedata");
        par.find("span.red").remove();
        par.find("input[type='text'],textarea").attr("readonly",true);
        par.find("select,input[type='radio'],span.txthid").addClass("hidden");
        par.find("span.txtinfo,span.pt_com").removeClass("hidden");
        par.find("img.ui-datepicker-trigger").css("display","none");
        $(id).parent().parent().prev().removeClass("hidden");
        $(id).parent().parent().addClass("hidden");
    },
    /*
     *(全职)保存求职岗位成功
     *参数：无
     *jack
     *2012-2-8
     */
    jobPosition_suce:function(){
        $("#job_position").find("div.result").remove();
        $("#q_pos").css("display","none");
        $("#slt_pos a").unbind("click").addClass("undo");
        $("#job_position span#job_po").text($("#jobpo_save").data("n_m"));
        $("#job_position span#job_place").text($("#jobpo_save").data("n_pce"));
        $("#job_position span#jpo_pay").text($("#jobpo_save").data("n_py").replace(new RegExp(" ","g"),""));
        $("#job_position span#jpo_da").text($("#jobpo_save").data("n_desire"));
        $("#job_position table.tb_cert td.tl").find("span.red").remove();
        $("#job_position #q_pos,#job_position textarea,#job_position .job_pay,#job_position #q_area").addClass("hidden");
        $("#job_position table.tb_cert").find(".j_com").removeClass("hidden");
        $("#job_position table.tb_cert").find("span#jpo_da,span#jpo_pay").css("display","inline-block");
        $("#job_position #jobpo_edit").removeClass("hidden");
        $("#job_position #job_posv").addClass("hidden");
        $("#job_position table.tb_cert").addClass("cur");
        var temp='<span class="hd_com">万/年</span>';
        if($("#q_salary").val()!=0){            
            if(!$("#jpo_pay").next("span.j_com").length)
                $("#jpo_pay").after(temp);            
        }else{
            $("#jpo_pay").next("span.j_com").addClass("hidden");
        }            
        resumeRender.job_inida();
    },
    /*
     *(全职)保存个人学历成功
     *参数：无
     *jack
     *2012-2-8
     */
    eduSucc:function(){
        $("#person_edu  #q_edu>option").removeAttr("selected");
        $("#person_edu table.tb_cert td").find("div.result").remove();
        $("#person_edu span#per_bt").text($("#edu_save").data("nx"));
        $("#person_edu span#per_end").text($("#edu_save").data("ny"));
        $("#person_edu span#per_schname").text($("#edu_save").data("nsch"));
        $("#person_edu span#per_profession").text($("#edu_save").data("nmaj"));
        $("#person_edu span#per_degr").text($("#edu_save").data("nedu"));
        $("#person_edu table.tb_cert td.tl").find("span.red").remove();
        $("#person_edu table.tb_cert img.ui-datepicker-trigger").css("display","none");
        $("#person_edu table.tb_cert").find(".per_com").removeClass("hidden");
        $("#person_edu div.to").css("display","inline-block");
        $("#person_edu table.tb_cert input[type='text'],#person_edu table.tb_cert #q_edu").addClass("hidden");
        $("#person_edu #edu_edit").removeClass("hidden");
        $("#person_edu #peredu_save").addClass("hidden");
        if(!$("#person_edu table.tb_cert").addClass("cur")){
            $("#person_edu table.tb_cert").addClass("cur");
        }
        resumeRender.peredu_inidata();
    },
    /*
     *(全职)保存个人学历失败
     *参数：无
     *jack
     *2012-2-8
     */
    edufail:function(ret){
        $("#person_edu table.tb_cert td").find("div.result").remove();
        $("#person_edu span#per_bt").text($("#edu_save").data("nx"));
        $("#person_edu span#per_end").text($("#edu_save").data("ny"));
        $("#person_edu span#per_schname").text($("#edu_save").data("nsch"));
        $("#person_edu span#per_profession").text($("#edu_save").data("nmaj"));
        $("#person_edu span#per_degr").text($("#edu_save").data("nedu"));
        $("#person_edu table.tb_cert td.tl").find("span.red").remove();
        $("#person_edu table.tb_cert img.ui-datepicker-trigger").css("display","none");
        $("#person_edu table.tb_cert").find(".per_com").removeClass("hidden");
        $("#person_edu table.tb_cert input[type='text'],#person_edu table.tb_cert #q_edu").addClass("hidden");
        $("#person_edu #edu_edit").removeClass("hidden");
        $("#person_edu #peredu_save").addClass("hidden");
        resumeRender.peredu_inidata();
    },
    /*
     *(全职)保存求职岗位失败
     *参数：无
     *jack
     *2012-2-8
     */
    jobPosition_failed:function(ret){
        alert(ret.data);
    },
    /*
     *(兼职)保存个人基本信息失败
     *jack
     *2012-1-16
     */
    c:function(ret){
        alert(ret.data);
    },
    /*
     *(兼职)返回省份,城市赋值
     */
    d:function(data){
        $("input[name='pat_prov']").val(data.prov);
        $("input[name='pat_city']").val(data.city);
        $("#p_befrm").val(data.provname+"-"+data.cityname);
        baseRender.b("#p_befrm");
        baseRender.ai("#p_befrm");
    },
    /*
     *(全职)个人基本信息返回省份,城市赋值
     *jack
     *2012-2-8
     */
    fq_place:function(data){
        $("input[name='q_pro']").val(data.prov);
        $("input[name='q_city']").val(data.city);
        $("#q_bf").val(data.provname+"-"+data.cityname);
        baseRender.b("#q_bf");
        baseRender.ai("#q_bf");
    },
    /*
     *(全职)求职岗位地区选择返回省份城市
     *jack
     *2012-2-8
     */
    job_place:function(data){
        $("input[name='jobp_prov']").val(data.prov);
        $("input[name='jobp_city']").val(data.city);
        $("#q_area").val(data.provname+" - "+data.cityname);
        baseRender.b("#q_area");
        baseRender.ai("#q_area");
    },
    /*
     *(兼职)期望注册地多选省份
     *控件返回值绑定
     *参数
     *data
     */
    e:function(r){
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
        $("#p_area").val(txt);
        $("input[name='resum_pro']").val(ids);
        baseRender.b("#p_area");
        baseRender.ai("#p_area");
    },
    /*
     * 功能：(兼职)添加资质显示添加结果
     * 参数：
     * r:插件返回结果
     */
    f:function(r){
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
        resumeRender.k(that);
    },
    /*
     * 功能：(兼职)添加资质显示添加结果
     * 参数：
     * r:插件返回结果
     */
    fultime_f:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){
            mname=" - "+r.majname;
        }
        var txt=r.cname+mname+" - "+r.regname+"-"+r.provname;
        that.val(txt);
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        that.data("rid",r.reg);
        that.data("pid",r.prov);
        baseRender.b(that);
        resumeRender.fultime_k(that);
    },
    /*
    *(兼职)资质添加完成后显示添加或删除
    *参数：
    *obj
    */
    k:function(obj){
        var that=$(obj);
        var len=$("#pt_quali table.tb_cert").find("input.qual_select").length;
        var ish=$("#pt_quali table.tb_cert").find("a.addqual").length;
        var ih=that.parent().find("a.sq_qua").length;
        if(len==1&&ish==0){
            if(ih==0){
                that.after(COMMONTEMP.T0019);
            }
            this.v(that.parent().find("a.sq_qua"));
        }
    },
    /*
    *(全职)资质添加完成后显示添加或删除
    *参数：
    *obj
    */
    fultime_k:function(obj){
        var that=$(obj);
        var len=$("#zert_quali table.tb_cert").find("input.qual_select").length;
        var ish=$("#zert_quali table.tb_cert").find("a.addqual").length;
        var ih=that.parent().find("a.sq_qua").length;
        if(len==1&&ish==0){
            if(ih==0){
                that.after(COMMONTEMP.T0019);
            }
            this.fultime_v(that.parent().find("a.sq_qua"));
        }
    },
    /*
     *(兼职)资质添加后绑定保存功能
     *jack
     *2012-2-6
     */
    v:function(obj1){
        $(obj1).unbind("click");
        $(obj1).bind("click",function(){
            var that=$(this).parent().find("input.qual_select");
            resumeController.n(that);
        });
    },
    /*
     *(兼职)资质添加后绑定保存功能
     *jack
     *2012-2-6
     */
    fultime_v:function(obj1){
        $(obj1).unbind("click");
        $(obj1).bind("click",function(){
            var that=$(this).parent().find("input.qual_select");
            resumeController.fultime_n(that);
        });
    },

    /*
     * 功能：(兼职)添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    l:function(r){
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+","+r.jtypeid+","+r.jtid;
        $("#pt_quali #p_cert"). val(txt);
        baseRender.b("#p_cert");
        $("#pt_quali input[name='jtlid']").val(r.jtlid);//职称等级
        $("#pt_quali input[name='jtid']").val(r.jtid);//职称专业
        $("#pt_quali #p_cert").data("ids", ids);
    },
    /*
     * 功能：(全职)添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    fultime_l:function(r){
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+","+r.jtypeid+","+r.jtid;
        $("#zert_quali #q_cert"). val(txt);
        baseRender.b("#q_cert");
        $("#zert_quali input[name='jtlid']").val(r.jtlid);//职称等级
        $("#zert_quali input[name='jtid']").val(r.jtid);//职称专业
        $("#zert_quali #q_cert").data("ids", ids);
    },
    /*
     *(全职)修改求职岗位信息
     *参数：无
     *jack
     *2012-2-8
     */
    jobpo_m:function(){
        $("#job_position  #q_salary>option").removeAttr("selected");
        $("#job_position table.tb_cert td.tl").find("span.red").remove();
        $("#job_position table.tb_cert td.tl span").before("<span class='red'>* </span>");
        $("#job_position table.tb_cert").find(".hidden").not("#defpay1").removeClass("hidden");
        $("#job_position table.tb_cert").find(".j_com").addClass("hidden");
        $("#job_position table.tb_cert").find("span#jpo_da,span#jpo_pay").css("display","none");
        var sedv=$("#jpo_pay").text().replace(new RegExp(" ","g"),"");
        if($("#jpo_pay").attr("val")=='12'){//首次修改
            sedv="手动填写";
        }
        var sele=$("#q_salary>option");        
        var bl=true;
        $.each(sele,function(i,o){
            if(sedv==$(o).text().replace(new RegExp(" ","g"),"")){
                $(o).attr("selected",true);
                bl=false;
            }
        });
        if(bl){
            $("#q_salary>option[value='12']").attr("selected",true);
            $("#defpay1").removeClass("hidden").val(sedv);
        }
        $("#job_position #jobpo_edit").addClass("hidden");
        $("#job_position #job_posv").removeClass("hidden");
        $("#q_pos").css("display","inline-block");
        resumeController.fh("#q_pos");
        $("#slt_pos a").removeClass("undo");
        $("#q_salary").trigger("change");
    },
    /*
     *(全职)修改个人学历信息
     *参数：无
     *jack
     *2012-2-9
     */
    peredu_m:function(){
        $("#person_edu table.tb_cert").find(".hidden").removeClass("hidden");
        $("#person_edu div.to").css("display","inline-block");
        $("#person_edu table.tb_cert img.ui-datepicker-trigger").css("display","inline-block");
        $("#person_edu table.tb_cert").find(".per_com").addClass("hidden");
        $("#person_edu #edu_edit").addClass("hidden");
        var sedv=$("#per_degr").text();
        var sele=$("#q_edu>option");
        $.each(sele,function(i,o){
            if(sedv==$(o).text()){
                $(o).attr("selected",true);
            }
        });
        $("#person_edu #peredu_save").removeClass("hidden");
    },
    /*
     *(兼职)修改个人证书
     *参数：无
     *jack
     *2012-2-3
     */
    n:function(){
        $("#pt_quali  #job_salary>option").removeAttr("selected");
        $("#pt_quali .sv_ptqa").addClass("hidden");
        $("#sv_ptcert").removeClass("hidden");
        $("#pt_quali table.tb_cert").find(".hidden").not("tr.first").not("#defpay").removeClass("hidden");
        $("#pt_quali table.tb_cert").find(".hd_com").addClass("hidden");
        $("#pt_quali table.tb_cert").find("span#expec_in").css("display","none");
        var sedv=$("#p_sa").text().replace(new RegExp(" ","g"),"");
        if($("#p_sa").attr("val")=='12'){//首次修改
            sedv="手动填写";            
        }        
        var sele=$("#job_salary>option");
        var bl=true;
        $.each(sele,function(i,o){
            if(sedv==$(o).text().replace(new RegExp(" ","g"),"")){
                $(o).attr("selected",true);
                bl=false;
            }
        });        
        if(bl){
            $("#job_salary>option[value='12']").attr("selected",true);
            $("#defpay").removeClass("hidden").val(sedv);
        }
        $("#pt_quali .adn_cancle").bind("click", function(){
            resumeRender.u(this);
        });
        $("#job_salary").trigger("change");
    },
    /*
     *(全职)修改个人证书
     *参数：无
     *jack
     *2012-2-9
     */
    pcert_n:function(){
        $("#zert_quali #fjobct_edit").addClass("hidden");
        $("#fjob_cert").removeClass("hidden");
        $("#zert_quali table.tb_cert").find(".hidden").not("tr.first").removeClass("hidden");
        $("#zert_quali table.tb_cert").find(".f_com").addClass("hidden");
        $("#zert_quali table.tb_cert").find("span#fult_de").css("display","none");
        $("#zert_quali .adn_cancle").bind("click", function(){
            resumeRender.fultime_u(this);
        });
    },
    /*
     *(兼职)已有资质证书上点击添加资质证书
     *参数：无
     *jack
     *2012-2-3
     */
    o:function(_s){
        if($("#pt_quali table.tb_cert tr").hasClass("hidden")){
            $("#pt_quali .adn_qa").addClass("hidden");
            $("#pt_quali .adn_cancle").removeClass("hidden");
            $("#pt_quali table.tb_cert td input.qual_select").removeClass("hidden");
            var that=$("#qqual_select");
            var le=$("#pt_quali .qua_list").length-1;
            $("#pt_quali .qua_list:eq("+le+")").append(COMMONTEMP.T0021);
            $("#pt_quali .adn_cancle").bind("click", function(){
                resumeRender.u(this);
            });
            that.parent().find("a.addqual,a.sq_qua").remove();
            $("#pt_quali table.tb_cert").find("tr.hidden").removeClass("hidden");
        }
    },
    /*
     *(全职)已有资质证书上点击添加资质证书
     *参数：无
     *jack
     *2012-2-9
     */
    fultime_o:function(_s){
        if($("#zert_quali table.tb_cert tr.first").hasClass("hidden")){
            $("#zert_quali .adn_qa").addClass("hidden");
            $("#zert_quali .adn_cancle").removeClass("hidden");
            $("#pqual_select").parent().prev("td.tl").find("span").before("<span class='red'>* </span>");
            $("#zert_quali table.tb_cert td input.qual_select ").removeClass("hidden");
            var that=$("#pqual_select");
            var le=$("#zert_quali .qua_list").length-1;
            $("#zert_quali .qua_list:eq("+le+")").append(COMMONTEMP.T0021);
            $("#zert_quali .adn_cancle").bind("click", function(){
                resumeRender.fultime_u(this);
            });
            that.parent().find("a.addqual,a.sq_qua").remove();
            $("#zert_quali table.tb_cert").find("tr.hidden").removeClass("hidden");
        }
    },
    /*
     *(兼职)资质证书验证
     *jack
     *参数：无
     *2012-2-3
     */
    p:function(){
        var v=$("#pt_quali #qqual_select").val();
        if(v==""){
            baseRender.a("#qqual_select",LANGUAGE.L0151,"error");
        }
    },
    /*
     *(兼职)删除资质证书成功
     *jack
     *2012-2-5
     */
    r:function(ret){
        var g=$("#pt_quali .qua_list .d_cert").length;
        var ad=$("#pt_quali .adn_qa").length;
        var index=g-1;
        if(g==1&&ad==0){
            $("#pt_quali .qua_list:eq("+index+")").append(COMMONTEMP.T0020);
        }
        resumeController.m();
    },
    /*
     *(全职)删除资质证书成功
     *jack
     *2012-2-9
     */
    fultime_r:function(ret){
        var g=$("#zert_quali .qua_list .d_cert").length;
        var ad=$("#zert_quali .adn_qa").length;
        var index=g-1;
        if(g==1&&ad==0){
            $("#zert_quali .qua_list:eq("+index+")").append(COMMONTEMP.T0020);
        }
        resumeController.fultime_m();
    },
    /*
     *(兼职)更新个人证书成功
     *jack
     *2012-2-5
     */
    s:function(){
        $("#pt_quali span#r_cert").text($("#sv_cert").data("ncet"));//绑定新的职称证
        $("#pt_quali span#p_sa").text( $("#sv_cert").data("nsa"));//绑定新的薪资
        $("#pt_quali span#r_prov").text($("#sv_cert").data("nspro"));//绑定新的省份
        $("#pt_quali span#expec_in").text($("#sv_cert").data("nspcom"));//绑定新的补充说明
        $("#pt_quali .qua_list a.adn_cancle").remove();
        $("#pt_quali .qua_list a.adn_qa").removeClass("hidden");
        $("#pt_quali table.tb_cert td").find("div.result").remove();
        $("#pt_quali table.tb_cert td.ltd").find("span.red").remove();
        $("#pt_quali table.tb_cert").find(".hidden").removeClass("hidden");
        $("#pt_quali table.tb_cert").find("span#expec_in").css("display","inline-block");
        if(!$("#pt_quali table.tb_cert tr.first").hasClass("hidden")){
            $("#pt_quali table.tb_cert tr.first").addClass("hidden");
            $("#pt_quali table.tb_cert tr.first").find("input.qual_select").val("");
            $("#pt_quali table.tb_cert tr.first").find("a.sq_qua").remove();
        }
        $("#pt_quali table.tb_cert input[type='text'],#p_cmp,#sv_ptcert,#job_salary,.ut").addClass("hidden");
        $("#pt_quali .sv_ptqa").removeClass("hidden");
        var temp='<span class="hd_com">万/年</span>';
        if($("#job_salary").val()!=0){            
            if(!$("#p_sa").next("span.hd_com").length)
                $("#p_sa").after(temp);            
        }else{
            $("#p_sa").next("span.hd_com").remove();
        }            
        resumeController.o();
    },
    /*
     *(全职)更新个人证书成功
     *jack
     *2012-2-9
     */
    fultime_s:function(){
        $("#zert_quali span#fult_cert").text($("#fjob_csve").data("ncet"));//绑定新的职称证
        $("#zert_quali span#fult_de").text($("#fjob_csve").data("nspcom"));//绑定新的补充说明
        $("#zert_quali .qua_list a.adn_cancle").remove();
        $("#zert_quali .qua_list a.adn_qa").removeClass("hidden");
        $("#zert_quali table.tb_cert td").find("div.result").remove();
        $("#zert_quali table.tb_cert td.ltd").find("span.red").remove();
        $("#zert_quali table.tb_cert").find(".hidden").removeClass("hidden");
        $("#zert_quali table.tb_cert").find("span#fult_de").css("display","inline-block");
        if(!$("#zert_quali table.tb_cert tr.first").hasClass("hidden")){
            $("#zert_quali table.tb_cert tr.first").addClass("hidden");
            $("#zert_quali table.tb_cert tr.first").find("input.qual_select").val("");
            $("#zert_quali table.tb_cert tr.first").find("a.sq_qua").remove();
        }
        $("#zert_quali  table.tb_cert input[type='text'],#q_detail,#fjob_cert").addClass("hidden");
        $("#zert_quali #fjobct_edit").removeClass("hidden");
        resumeRender.fulcert_inidata();
    },
    /*
     *(兼职)更新个人证书失败
     *jack
     *2012-2-5
     */
    t:function(ret){
        alert(ret.data);
    },
    /*
     *(全职)更新个人证书失败
     *jack
     *2012-2-9
     */
    fult_t:function(ret){
        alert(ret.data);
    },
    /*
     *取消添加资质证书
     *jack
     *2012-2-6
     */
    u:function(){
        if($("#sv_ptcert").hasClass("hidden")){
            $(".sv_ptqa").removeClass("hidden");
        }
        baseRender.b("#qqual_select");
        $("#pt_quali table.tb_cert input.qual_select").data("ids", "");
        $("#pt_quali table.tb_cert input.qual_select").val("");
        $("#qqual_select").parent().prev("td.ltd").find("span.red").remove();
        $("#pt_quali input.qual_select").parent().prev().parent().not("tr.first").remove();
        $("#pt_quali table.tb_cert tr.first").addClass("hidden");
        $("#pt_quali .adn_cancle").remove();
        resumeController.m();
    },
    /*
     *取消添加资质证书
     *jack
     *2012-2-6
     */
    fultime_u:function(){
        if($("#fjob_cert").hasClass("hidden")){
            $("#fjobct_edit").removeClass("hidden");
        }
        baseRender.b("#pqual_select");
        $("#zert_quali table.tb_cert input.qual_select").data("ids", "");
        $("#zert_quali table.tb_cert input.qual_select").val("");
        $("#zert_quali #pqual_select").parent().prev("td.tl").find("span.red").remove();
        $("#zert_quali table.tb_cert tr.first").addClass("hidden");
        $("#zert_quali .adn_cancle").remove();
        resumeController.fultime_m();
    },
    /*
     *(兼职)保存资质证书成功
     *jack
     *2012-2-7
     */
    w:function(ret){
        $("#pt_quali .qua_list").find("a.adn_cancle").remove();
        $("#pt_quali table.tb_cert tr.first").addClass("hidden");
        $("#pt_quali table.tb_cert tr.first td.ltd").find("span.red").remove();
        var x=$("#qqual_select").val();
        var ft=$("#pt_quali .qua_list:eq(0)").find("span");
        if(!ft.hasClass("cer_name")){
            $("#pt_quali .qua_list:eq(0)").remove();
            if($("#sv_ptcert").hasClass("hidden")){
                $("#pt_quali .sv_ptqa ").removeClass("hidden");
            }
        }
        $("#pt_quali table.tb_cert tr.first").find("a.sq_qua").remove();
        $("#pt_quali table.tb_cert tr.first input.qual_select").val("");
        $("#pt_quali .had_qua").append("<div class='qua_list'><span class='tl'>资质证书 :</span><span class='cer_name'>"+x+"</span><a href='javascript:;' title='删除' rel='"+ret.data+"' class='blue d_cert'>删除</a></div>");
        resumeController.m();
    },
    /*
     *(全职)保存资质证书成功
     *jack
     *2012-2-7
     */
    fultime_w:function(ret){
        $("#zert_quali .qua_list").find("a.adn_cancle").remove();
        $("#zert_quali table.tb_cert tr.first").addClass("hidden");
        $("#zert_quali table.tb_cert tr.first td.tl").find("span.red").remove();
        var x=$("#pqual_select").val();
        var ft=$("#zert_quali .qua_list:eq(0)").find("span");
        if(!ft.hasClass("cer_name")){
            $("#zert_quali .qua_list:eq(0)").remove();
            if($("#fjob_cert").hasClass("hidden")){
                $("#zert_quali .sv_ptqa ").removeClass("hidden");
            }
        }
        $("#zert_quali table.tb_cert tr.first").find("a.sq_qua").remove();
        $("#zert_quali table.tb_cert tr.first input.qual_select").val("");
        $("#zert_quali .had_qua").append("<div class='qua_list'><span class='tl'>资质证书 :</span><span class='cer_name'>"+x+"</span><a href='javascript:;' title='删除' rel='"+ret.data+"' class='blue d_cert'>删除</a></div>");
        resumeController.fultime_m();
    },
    /*
     *(兼职)保存资质证书失败
     *jack
     *2012-2-7
     */
    x:function(ret){
        alert(ret.data);
    },
    /*
     *(兼职)初始资质证书
     *jack
     *2012-2-10
     */
    pct_han:function(){
        $("#pt_quali a.adn_qa").remove();
        var g=$("#pt_quali .qua_list").length;
        if(g==1){
            $("#pt_quali a.d_cert").addClass("hidden");
            $("#pt_quali .qua_list:eq(0)").append(COMMONTEMP.T0020);
        }else{
            var lep=g-1;
            $("#pt_quali a.d_cert").removeClass("hidden");
            $("#pt_quali .qua_list:eq("+lep+")").append(COMMONTEMP.T0020);
        }
    },
    /*
     *(兼职)保存证书情况
     *保存修改后页面数据
     *是否修改
     */
    y:function(){
        var zz=$("#p_cert").val();
        var sa=$("#job_salary")[0].options[$("#job_salary")[0].selectedIndex].text;
        if($("#defpay").val()!=""&&$("#job_salary").val()=="12"){
            sa=$("#defpay").val();
        }
        var sp=$("#p_area").val();
        var de=$("#p_cmp").val();
        if($("#job_salary").val()==12){
            sa=$("#defpay").val();
            $("#p_sa").attr("val",12);
        }
        else{
            $("#p_sa").attr("val",null);
        }
        $("#sv_cert").data("ncet",zz);//修改后的职称证书
        $("#sv_cert").data("nsa",sa);//修改后的薪资待遇
        $("#sv_cert").data("nspro",sp);//修改后的省份
        $("#sv_cert").data("nspcom",de);//修改后的补充说明
        var oldct= $("span#r_cert").data("rct");
        var newct= $("#sv_cert").data("ncet");
        var oldsa= $("span#p_sa").data("sar");
        var newsa= $("#sv_cert").data("nsa");
        var oldp= $("span#r_prov").data("prov");
        var newp=$("#sv_cert").data("nspro");
        var oldcom=$("span#expec_in").data("expec");
        var newcom=$("#sv_cert").data("nspcom");
        if(newct!=""&&newsa!=""&&newp!=""){
            if(oldct==newct&&oldsa==newsa&&oldp==newp&&oldcom==newcom){
                resumeRender.s();
            }else{
                resumeController.p();
            }
        }else{
            resumeController.p();
        }
    },
    /*
     *(全职)保存证书情况
     *保存修改后页面数据
     *是否修改
    */
    fucert_z:function(){
        var zz=$("#q_cert").val();
        var de=$("#q_detail").val();
        $("#fjob_csve").data("ncet",zz);//修改后的职称证书
        $("#fjob_csve").data("nspcom",de);//修改后的补充说明
        var oldct=$("span#fult_cert").data("rct");
        var newct=$("#fjob_csve").data("ncet");
        var oldcom=$("span#fult_de").data("complet");
        var newcom=$("#fjob_csve").data("nspcom");
        if(oldct==newct&&oldcom==newcom){
            resumeRender.fultime_s();
        }else{
            resumeController.fult_p();
        }
    },
    /*
     *(全职)保存求职岗位信息情况
     *保存修改后页面数据
     *是否修改
    */
    job_z:function(){
        var new_n=$("#slt_pos").html();
        var new_place=$("#q_area").val();
        var new_py=$("#q_salary")[0].options[$("#q_salary")[0].selectedIndex].text;
        if($("#defpay1").val()!=""&&$("#q_salary").val()=="12"){
            new_py=$("#defpay1").val();
        }
        var new_deire=$("#job_want").val().replace(new RegExp(" ","g"),"");
        $("#jobpo_save").data("n_m",new_n);
        $("#jobpo_save").data("n_pce",new_place);
        $("#jobpo_save").data("n_py",new_py);
        $("#jobpo_save").data("n_desire",new_deire);
        var o1=$("span#job_po").data("o_jname"),
        o2= $("#jobpo_save").data("n_m"),
        p1=$("span#job_place").data("o_jpy"),
        p2=$("#jobpo_save").data("n_pce"),
        q1=$("span#jpo_pay").data("o_py"),
        q2=$("#jobpo_save").data("n_py"),
        r1=$("span#jpo_da").data("o_jbdes"),
        r2= $("#jobpo_save").data("n_desire");
        if(o1!=""&&o2!=""&&p1!=""&&p2!=""&&q1!=""&&q2!=""){
            if(o1==o2&&p1==p2&&q1==q2&&r1==r2){
                resumeRender.jobPosition_suce();
            }else{
                resumeController.job_q();
            }
        }else{
            resumeController.job_q();
        }
    },
    /*
     *(全职)保存学历信息情况
     *保存修改后页面数据
     *是否修改
    */
    peredu_z:function(){
        var nx=$("#be_time").val();
        var ny=$("#end_time").val();
        var nsch=$("#q_scname").val();
        var nmaj=$("#q_majoy").val();
        var nedu=$("#q_edu")[0].options[$("#q_edu")[0].selectedIndex].text;
        $("#edu_save").data("nx",nx);
        $("#edu_save").data("ny",ny);
        $("#edu_save").data("nsch",nsch);
        $("#edu_save").data("nmaj",nmaj);
        $("#edu_save").data("nedu",nedu);
        var o1=$("span#per_bt").data("o_perbt"),
        n1= $("#edu_save").data("nx"),
        o2=$("span#per_end").data("o_perend"),
        n2=$("#edu_save").data("ny"),
        o3=$("span#per_schname").data("o_scnam"),
        n3=$("#edu_save").data("nsch"),
        o4=$("span#per_profession").data("o_permja"),
        n4=$("#edu_save").data("nmaj"),
        o5=$("span#per_degr").data("o_per_deg"),
        n5=$("#edu_save").data("nedu");
        if(o1==n1&&o2==n2&&o3==n3&&o4==n4&&o5==n5){
            resumeRender.eduSucc();
        }else{
            resumeController.peredu_q();
        }
    },
    /*
    *(兼职)保存初始页面数据
    *jack
    *2012-2-8
    */
    inisavedata:function(){
        /*(兼职)证书情况*/
        var sc= $("span#r_cert"),
        sp= $("span#p_sa"),
        sr= $("span#r_prov"),
        se= $("span#expec_in");
        sc.data("rct",sc.text());//职称证
        sp.data("sar",sp.text());//薪资待遇
        sr.data("prov",sr.text());//省份
        se.data("expec",se.text());//补充说明
    },
    /*
     *(全职)保存求职岗位基本情况
     *保存初始化数据
    */
    job_inida:function(){
        var  o_jobnam=$("#slt_pos"),
        o_jobpla=$("#job_place"),
        o_jobpy=$("#jpo_pay"),
        o_jobwt=$("#jpo_da");
        o_jobnam.data("o_jname",o_jobnam.html());
        o_jobpla.data("o_jpy",o_jobpla.text());
        o_jobpy.data("o_py",o_jobpy.text());
        o_jobwt.data("o_jbdes",o_jobwt.text());
        var a=o_jobnam.children().length;
        var b=o_jobpla.text();
        var c=o_jobpy.text();
        if(a==0||b==""||c==""){
            resumeRender.jobpo_m();
        }
    },
    /*
     *(全职)保存学历基本情况
     *保存初始化数据
    */
    peredu_inidata:function(){
        var o_edubt=$("span#per_bt"),
        o_edued=$("span#per_end"),
        o_eschname=$("span#per_schname"),
        o_edumajna=$("span#per_profession"),
        o_degree=$("span#per_degr");
        o_edubt.data("o_perbt",o_edubt.text());
        o_edued.data("o_perend",o_edued.text());
        o_eschname.data("o_scnam",o_eschname.text());
        o_edumajna.data("o_permja",o_edumajna.text());
        o_degree.data("o_per_deg",o_degree.text());
        var a=o_edubt.text();
        var b=o_edued.text();
        var c=o_eschname.text();
        var d=o_edumajna.text();
        var e=o_degree.text();
    },
    /*
    *(全职)初始资质证书处理
    *jack
    *2012-2-10
    *#zert_quali
    */
    fct_han:function(){
        $("#zert_quali a.adn_qa").remove();
        var g=$("#zert_quali .qua_list").length;
        if(g==1){
            $("#zert_quali a.d_cert").addClass("hidden");
            $("#zert_quali .qua_list:eq(0)").append(COMMONTEMP.T0020);
        }
        else{
            var lep=g-1;
            $("#zert_quali a.d_cert").removeClass("hidden");
            $("#zert_quali .qua_list:eq("+lep+")").append(COMMONTEMP.T0020);
        }
    },
    /*
     *(全职)保存证书基本情况
     *保存初始化数据
    */
    fulcert_inidata:function(){
        /*(全职)证书情况*/
        var sc=$("span#fult_cert"),
        sp=$("span#fult_de");
        sc.data("rct",sc.text());//职称证
        sp.data("complet",sp.text());//补充说明
       
    },
    /*
    *初始化工作经验数据处理
    *jack
    *2012-2-10
    */
    exper_hand:function(){
        $("#job_exper a.adexper").remove();
        var wv=$("#job_exper table.t_ce").length;
        if(wv==0){
            $("#job_exper .p_info").append(COMMONTEMP.T0023);
        }else{
            var le=wv-1;
            $("#job_exper table.t_ce:eq("+le+")").find("div.exp_deal").append(COMMONTEMP.T0023);
        }
    },
    /*
    *初始化工程业绩数据处理
    *jack
    *2012-2-10
    */
    project_hand:function(){
        var par=$("#had_progrs");
        par.find("a.adprs").remove();
        var wv=par.find("table.t_pf").length;
        if(wv==0){
            $("#job_perform .p_info").append(COMMONTEMP.T0025);
        }else{
            var le=wv-1;
            par.find("table.t_pf:eq("+le+")").find("div.prgs_deal").append(COMMONTEMP.T0025);
        }
    },
    /*
    *添加工作经验处理
    */
    adexp:function(){
        if($("#job_exper div.exp").hasClass("hidden")){
            $("#job_explist img.ui-datepicker-trigger").css("display","block");
            $("#job_exper a.adexper").addClass("hidden");
            $("#job_exper div.exp").removeClass("hidden");
            var le=$("#job_exper table.t_ce").length-1;
            if($("#job_exper table.t_ce").length==0){
                $("#job_exper div.p_info").append(COMMONTEMP.T0024);
            }else{
                $("#job_exper table.t_ce:eq("+le+")").find("div.exp_deal").append(COMMONTEMP.T0024);
            }
            $("#job_exper .canexper").bind("click", function(){
                resumeRender.exper_canle(this);
            });
        }
    },
    /*
    *添加工程业绩处理
    *jack
    *2012-2-10
    */
    adprogs:function(){
        if($("#job_perform div.perfane ").hasClass("hidden")){
            $("#job_perform a.adprs").addClass("hidden");
            $("#job_perform img.ui-datepicker-trigger").css("display","block");
            $("#job_perform a.prs_cancle").remove();
            $("#job_perform div.perfane").removeClass("hidden");
            var le=$("#job_perform table.tp").length-1;
            if($("#job_perform table.tp").length==0){
                $("#job_perform div.p_info").append(COMMONTEMP.T0026);
            }else{
                $("#job_perform table.tp:eq("+le+")").find("div.prgs_deal").append(COMMONTEMP.T0026);
            }
            $("#job_perform .prs_cancle").bind("click", function(){
                resumeRender.progs_canle(this);
            });
        }
    },
    /*
    *取消添加工作经验处理
    *jack
    *2012-2-10
    */
    exper_canle:function(){
        $("#job_depart,#exp_bdate,#exp_endate,#exp_cname,#exp_trade,#job_hold,#job_cont").val("");
        $("#job_exper").find("div.result").remove();
        baseRender.b("#exp_cname,#exp_trade,#exp_bdate,#exp_endate,#job_depart,#job_hold,#job_cont");
        $("#job_exper a.canexper").remove();
        $("#job_exper div.exp").addClass("hidden");
        resumeController.exper_ini();
    },
    /*
    *取消添加工程业绩处理
    *jack
    *2012-2-10
    */
    progs_canle:function(){
        $("#pjname,#pjstart,#pjstoped,#pjheld,#pjcontent").val("");
        $("#job_perform").find("div.result").remove();
        baseRender.b("#pjstart,#pjstoped,#pjstart,#pjstoped,#pjname,#pjheld,#pjcontent");
        $("#job_perform table.tb_cert td.tl").find("span.red").remove();
        $("#job_perform a.prs_cancle").remove();
        $("#job_perform div.perfane").addClass("hidden");
        resumeController.perfane_ini();
    },
    /*
    *(工作经验)删除处理
    *jack
    *2012-2-10
    */
    exp_cle:function(){
        $("#job_exper table.tb_cert").find("span.red").remove();
        $("#job_exper").find("a.adn_cancle").remove();
        if(!$("#job_exper div.qua_detail").hasClass("hidden")){
            $("#job_exper div.qua_detail").addClass("hidden");
        }
    },
    /*
    *(工程业绩)删除处理
    *jack
    *2012-2-10
    */
    deal_achiv:function(){
        $("#job_perform table.tb_cert").find("span.red").remove();
        $("#job_perform").find("a.prs_cancle").remove();
        if(!$("#job_perform div.perfane").hasClass("hidden")){
            $("#job_perform div.perfane").addClass("hidden");
        }
    },
    /*
    *
    *添加工作经验成功执行
    *jack
    *2012-2-10
    */
    ad_exp_suc:function(ret){
        $("#job_exper a.canexper").remove();
        $("#job_exper").find("div.result").remove();
        $("#job_exper table.tb_cert td").find("span.red").remove();
        $("#job_exper div.exp").addClass("hidden");
        var relid=ret.data,
        depart=$("#job_depart").val(),
        bdate=$("#exp_bdate").val(),
        edate=$("#exp_endate").val(),
        cnm=$("#exp_cname").val(),
        ctrade=$("#exp_trade").val(),
        cscal=$("#exp_sacle")[0].options[$("#exp_sacle")[0].selectedIndex].text,
        ctrre=$("#exp_attr")[0].options[$("#exp_attr")[0].selectedIndex].text,
        cpo=$("#job_hold").val(),
        cont=$("#job_cont").val();
        var html='<table class="experlis t_ce">'+
        '<tr><td class="tl"><span><b class="red">*</b>起始时间 :</span></td><td>'+bdate+'至'+edate+'</td></tr>'+
        '<tr><td class="tl"><span><b class="red">*</b>公司名称 :</span></td><td>'+cnm+'</td><td class="tl"><span><b class="red">*</b>行业 :</span></td><td>'+ctrade+'</td></tr>'+
        '<tr><td class="tl"><span><b class="red">*</b>公司规模 :</span></td><td>'+cscal+'</td><td class="tl"><span><b class="red">*</b>公司性质 :</span></td><td>'+ctrre+'</td></tr>'+
        '<tr><td class="tl"><span><b class="red">*</b>部门 :</span></td><td>'+depart+'</td><td class="tl"><span><b class="red">*</b>职位 :</span></td><td>'+cpo+'</td></tr>'+
        '<tr><td class="tl lop"><span><b class="red">*</b>工作内容 :</span></td><td><span class="work_detail">'+cont+'</span></td></tr>'+
        '<tr><td colspan="5"><div class="up_info exp_deal"><a href="javascript:;" title="" class="delexp blue" rel="'+relid+'">删除工作经验</a>'+
        '<a href="javascript:;" title="" class="blue adexper">添加工作经验</a></div></td></tr>'+
        '</table>';
        $("#job_exper #had_exper").append(html);
        resumeController.exper_ini();
        $("#job_depart,#exp_bdate,#exp_endate,#exp_cname,#exp_trade,#job_hold,#job_cont").val("");
    },
    /*
    *
    *添加工程业绩成功执行
    *jack
    *2012-2-10
    */
    adprogs_succ:function(ret){
        $("#job_perform").find("div.result").remove();
        $("#job_perform").find("a.prs_cancle").remove();
        $("#job_perform div.perfane").addClass("hidden");
        var relid=ret.data,
        pjname=$("#pjname").val(),
        stadate=$("#pjstart").val(),
        enddate=$("#pjstoped").val(),
        comscale=$("#pjscale")[0].options[$("#pjscale")[0].selectedIndex].text,
        tkpo=$("#pjheld").val(),
        workde=$("#pjcontent").val();
        var html='<table class="t_pf">'+
        '<tr><td class="tl"><span><b class="red">*</b>起始时间 :</span></td><td>'+stadate+'至'+enddate+'</td></tr>'+
        '<tr><td class="tl"><span><b class="red">*</b>项目名称 :</span></td><td>'+pjname+'</td></tr>'+
        '<tr><td class="tl"><span><b class="red">*</b>规模大小 :</span></td><td>'+comscale+'</td></tr>'+
        '<tr><td class="tl"><span><b class="red">*</b>担任职务 :</span></td><td>'+tkpo+'</td></tr>'+
        '<tr><td class="tl lop"><span><b class="red">*</b>工作内容 :</span></td><td><span class="work_detail">'+workde+'</span></td></tr>'+
        '<tr><td colspan="5"><div class="up_info prgs_deal"><a href="javascript:;" title="" class="dele_prgs blue" rel="'+relid+'">删除工程业绩</a>'+
        '<a href="javascript:;" title="" class="blue adprs">添加工程业绩</a></div></td></tr>'+
        '</table>';
        $("#job_perform #had_progrs").append(html);
        resumeController.perfane_ini();
        $("#pjname,#pjstart,#pjstoped,#pjheld,#pjcontent").val("");
    },
    /*
    *添加工程业绩失败
    *jack
    *2012-2-15
    */
    ad_exp_f:function(ret){
        alert(ret.data)
    },
    /*
    *删除工作经验成功执行
    *jack
    *2012-2-10
    */
    exp_s:function(){
        var g=$("#job_exper table.t_ce a.delexp").length;
        var ad=$("#job_exper a.adexper").length;
        var index=g-1;
        if(g==1&&ad==0){
            $("#job_exper table.t_ce :eq("+index+")").append(COMMONTEMP.T0023);
        }
        resumeController.exper_ini();
    },
    /*
    *删除工程业绩成功执行
    *jack
    *2012-2-10
    */
    pgs_s:function(){
        var g=$("#job_perform table.t_pf a.delexp").length;
        var ad=$("#job_perform a.adprs").length;
        var index=g-1;
        if(g==1&&ad==0){
            $("#job_perform table.t_pf:eq("+index+")").append(COMMONTEMP.T0025);
        }
        resumeController.perfane_ini();
    },
    /*
    *起始时间非空和大小比较
    *jack
    *2012-2-10
    */
    bdatejudage:function(s1,s2){
        var former=$(s1).val();
        var last=$(s2).val();
        if(former==""){
            baseRender.a(s1,LANGUAGE.L0181,"error",10);
        }
        else if(last==""){
            baseRender.a(s2,LANGUAGE.L0181,"error",10);
        }
        else if(former==last){
            baseRender.a(s1,LANGUAGE.L0183,"error",10);
        }
        else if(former>last){
            baseRender.a(s1,LANGUAGE.L0182,"error",10);
        }else{
            baseRender.b(s1);
            baseRender.b(s2);
        }
    },
    /*
    *选择功能公开求职方式发布简历
    *成功时执行
    *jack
    *2012-2-10
    */
    pub_part_sucss:function(ret){
        alert('操作成功',"","","",function(){
            location.reload();
        });
    },
    /*
    *选择发布简历失败
    *成功时执行
    *jack
    *2012-2-12
    */
    pub_fail:function(ret){
        alert(ret.data);
    },
    /*
    *兼职以公开求职方式发布了
    *jack
    *2012-2-11
    */
    iniPartPublish:function(){
        $("#pt_up,a.d_cert,a.adn_qa,#pt_qa,#fjobct_edit,a.adexper,a.adprs,a.delexp ,a.adprs,#edu_edit,#jobpo_edit,#ful_edit,a.dele_prgs,#edu_edit,#jobpo_edit").remove();
        /*结束求职*/
        $("#part_pub #end_pub").bind("click",function(){
            resumeController.pub_end_pub();
        });
    },
    /*
    *初始化全职被发布初始状态
    *jack
    *
    *2012-2-11
    */
    iniFultpub:function(){
        $("#pt_up,a.d_cert,a.adn_qa,#pt_qa,#fjobct_edit,a.adexper,a.adprs,a.delexp ,a.adprs,#edu_edit,#jobpo_edit,#ful_edit,a.dele_prgs,#edu_edit,#jobpo_edit").remove();
        /*结束求职*/
        $("#fut_pub #fend_app").unbind("click").bind("click",function(){
            resumeController.pub_end_pub();
        });
    },
    /*
    *初始化代理初始状态
    *jack
    *2012-2-15
    */
    iniDelegateStatus:function(){
        $("#pt_up,a.d_cert,a.adn_qa,#pt_qa,#fjobct_edit,a.adexper,a.adprs,a.delexp ,a.adprs,#edu_edit,#jobpo_edit,#ful_edit,a.dele_prgs,#edu_edit,#jobpo_edit").remove();
    },
    /*
    *代理失败执行
    *jack
    *2012-2-12
    */
    delegateFail:function(ret){
        alert(ret.data);
    },
    /*
    *代理成功执行
    *jack
    *2012-2-12
    */
    delegateSucc:function(ret){
        window.location.href=ret.data;
    },
    /*
    *解除委托代理锁成功执行
    *jack
    *2012-2-12
    */
    unlockSucc:function(ret){
        alert('解锁成功',"","","",function(){
            location.reload();
        });
    },
    /*
    *解除委托代理锁失败执行
    *jack
    *2012-2-12
    */
    unlockFail:function(ret){
        alert(ret.data);
    },
    /*
    *代理时鼠标滑过锁的状态
    *jack
    *2012-2-14
    */
    unlock_stas1:function(){
        $("div.tpro a.lock_pic").css("background-position","-69px 0");
    },
    /*
    *代理时鼠标滑过锁的状态
    *jack
    *2012-2-14
    */
    unlock_stas2:function(){
        $("div.tpro a.lock_pic").css("background-position","-130px 0");
    },
    /*
     * 功能：全职添加求职职位
     * 参数：
     * r:插件返回结果
     */
    qo:function(r){
        $("#slt_pos").html("").append(r.jhtml);
        if($("#jtip").css("display")!="none"){
            $("#jtip").css("display","none");
        }
        resumeController.fh(r.obj);
    },
    /****************************************************证书部分**************************************/
    /*
     * 功能：添加资质显示添加结果
     * 参数：
     * r:插件返回结果
     */
    c_a:function(r){
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
        that.data("prov",r.prov);
        baseRender.b(that);
        resumeRender.c_e(that);
    },
    /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    c_b:function(r){
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+"-"+r.jtypeid+"-"+r.jtid;
        $("#jtitle_selt").val(txt);
        $("#jtitle_selt").data("ids", ids);
    },
    /*
    *资质添加完成后绑定添加功能i
    */
    ct_c:function(obj){
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
                sure:resumeRender.c_a
            });
            resumeRender.c_d(par.parent().find("a.delqual"));
        });
    },
    /*
    *资质添加完成后绑定删除功能
    */
    c_d:function(obj){
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
                resumeRender.ct_c(cslt.find("a.addqual"));
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
    c_e:function(obj){
        var that=$(obj);
        var len=that.parent().parent().parent().find("input.qual_select").length;
        var ish=that.parent().parent().parent().find("a.addqual").length;
        if(len==1&&ish==0){
            that.after(COMMONTEMP.T0017);
            this.ct_c(that.parent().find("a.addqual"));
        }
        else if(len>1&&ish==0){
            that.parent().append("<span class='blue'>| </span>"+COMMONTEMP.T0017);
            this.ct_c(that.parent().find("a.addqual"));
        }
    },
    /*
    * 功能：上传证书
    * 参数：
    * obj：当前上传按钮
    */
    c_f:function(obj){
        try{
            var file = $(obj).val();
            if(resumeRender.c_g(file)){
                $('#form_upload').submit();
            }
        }catch(e){
            resumeRender.c_h(e)
        }
    },
    /*
    * 功能：是否是图片
    * @author yoyiorlee
    * @date 2012-12-07
    */
    c_g:function(file){
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
    c_h:function(e){
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
    c_l:function(obj){
        var that=$(obj).parent();
        if(that.find("a.asubmit").length==0){
            that.append('<a href="javascript:;" class="red asubmit">确定上传</a>');
        }
        $(obj).css("width","auto");
        resumeController.ct_d(obj);
    },
    /*
    * 功能：证书图片上传结果提示
    * 参数：
    * b：真值
    */
    c_m:function(b){
        if(b=="1"){
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
    c_n:function(data){
        alert("删除错误,请刷新页面再试!");
    },
    /*
     * 功能：添加资质证书成功
     * 参数：
     * data：后天返回数据
     */
    c_o:function(data){
        alert("添加成功!","","","",function(){
            location.reload();
        });
    },
    /*
     * 功能：添加资质证书失败
     * 参数：
     * data：后天返回数据
     */
    c_p:function(data){
        alert(data.data);
    },
    /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    c_q:function(r){
        var that=r.obj;
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+","+r.jtid;
        that.val(txt);
        that.data("ids", ids);
        resumeController.ct_m();
    },
    /*
     * 功能：显示修改职称证书选择框
     * 参数：
     * obj：当前修改按钮
     */
    c_r:function(obj){
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
    c_s:function(obj){
        var that=$(obj).parent();
        var tmp='<span class="gray">未认证</span><input type="file" name="file_tcert" class="files"/>';
        that.parent().append(tmp);
        that.parent().find("span.green").remove();
        that.find("a.opencont").unbind('click');
        that.find("a.opencont").text("修改").addClass("alter").removeClass("opencont");
        var ctr=resumeController;
        ctr.ct_ac($("#htit").parent().find("input[name='file_tcert']"));
        ctr.ct_la(that.find("a.alter"));
    },
    /*
     * 功能：期望待遇事件绑定
     * 参数：
     * data：后台返回数据
     */
    g:function(){
        var pval,fval;
        var pjob_s,fjob_s;                          
        $("#job_salary,#q_salary").bind("change",function(){
            pjob_s=$("#p_sa").text();
            fjob_s=$("#jpo_pay").text();                 
            pval=$("#p_sa").attr("val")*1;        
            fval=$("#jpo_pay").attr("val")*1;
            if($(this).attr("rel")=='pjob'&&pval==12){
                $(this).next("input.defpay").val(pjob_s);                     
            }
            else if($(this).attr("rel")=='fjob'&&fval==12){
                $(this).next("input.defpay").val(fjob_s);                       
            }                         
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
}


