/*
 *简历页面控制器
 *jack
 *2012-1-15
 */
var resumeController={
    /****************************公共部分的初始化*********************************************/
    
    /*
     * 功能：检验当前是否为可编辑状态
     * 参数：
     * 无
     */
    ba:function(){
        var that=resumeController;
        $("div.rcom table.tb_in input[type='text']").bind({
            focus:function(e){
                that.bb(this);
            },
            click:function(e){
                that.bb(this);
            }
        });
    },
    /*
     * 功能：检验当前是否为可编辑状态
     * 参数：
     * 无
     */
    bb:function(obj){
        var par=$(obj).parent().parent().parent().parent().parent();
        if(par.hasClass("tb_com")){
            par=par.parent();
        }
        var bl1=false;
        var bl2=true;
        if(par.hasClass("updatedata")){
            bl1=true;
            bl2=false;
        }
        if($(obj).hasClass("mselect")&&$(obj).hasClass("t_place")){
            $(obj).hgsSelect.defaults.stopevent=bl1;
        }else{
            $(obj).data("cedite",bl2);
        }
    },
     /*
     * 功能：在firefox下初始化文本框
     * 参数：
     * 无
     */
    aa:function(){
        if($.browser.mozilla){
            var inp=$("input[type='text'],textarea");
            $.each(inp,function(i,o){
                var a=$(o);
                a.val(a[0].defaultValue);
            });
        }
    },
     /*
    * 功能：初始化文本框
    * 参数：
    * 无
    */
    ab:function(obj){
        var par=$(obj).parent().prev().prev().find("table.tb_com");
        resumeController.ac(par);
    },
    /*
     *功能：页面数据初始化
     *参数：无
     */
    ac:function(par){
        var ele=$(par);
        var txt=ele.find("input[type='text']");//文本框
        var select=ele.find("select");//下拉框
        var radio=ele.find("input[type='radio']").parent().parent();//单选框
        $.each(txt,function(i,o){
            var that=$(o);
            that.val(that.data("curdata"));
        });
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
     * 功能：保存当前值
     * 参数：
     * 无
     */
    ad:function(par){
        par=$(par);
        var txt=par.find("input[type='text'],textarea");//文本框
        var select=par.find("select");//下拉框
        var radio=par.find("input[type='radio']").parent().parent();//单选框
        $.each(txt,function(i,o){
            $(o).data("curdata",$(o).val());
        });
        $.each(select,function(i,o){
            var that=$(o);
            var cur=that.prev();
            cur.attr("val",that.val());
            cur.text(that.find("option:selected").text());
        });
        $.each(radio,function(i,o){
            var that=$(o).find("input[type='radio']:checked");
            var cur=$(o).find("span.txtinfo");
            cur.attr("val",that.val());
            cur.text(that.next().text());
        });
    },
    /*
     * 功能：初始化下拉框和单选框
     * 参数：
     * 无
     */
    ae:function(par){
        par=$(par);
        var select=par.find("select");//下拉框
        var radio=par.find("input[type='radio']").parent().parent();//单选框
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
   /****************************************************简历部分**************************************/
    /*
     *初始化日期控件
     *jack
     *2012-1-15
     */
    a:function(){
        $("#p_date,#q_bth").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            beforeShow:function(){
                if(!$(this).data("cedite")){
                    return false;
                }
            }
        });
        $("#be_time,#end_time,#exp_bdate,#exp_endate,#pjstart,#pjstoped").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true
        });
    },
    /*
     *表单验证
     *jack
     *2012-1-15
     */
    b:function(){
      
        /*真实姓名格式验证*/
        $("#p_tname,#q_tname").focus(function(){
              if($(this).data("cedite")){
                baseRender.a(this, LANGUAGE.L0060, "right");
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
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
            }
        });
        /*QQ号码验证*/
        $("#p_qq,#q_pq").focus(function(){
              if($(this).data("cedite")){
            baseRender.b(this);
            baseRender.a(this, LANGUAGE.L0032, "right");
              }
        }).blur(function(){
              if($(this).data("cedite")){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            else{
                if(!/^(\-?)(\d+)$/.test(str)){
                        msg=LANGUAGE.L0034;
                        b=false;
                    }
                else{
                    baseRender.ai(this);
                }
            }
            if(!b){
                baseRender.addred(this);
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.b(this);
            }
              }
        });
        /*(求职岗位)职位名称*/
        $("#q_pos").hgsSlt({
            id:"qjobslt",          //选择框id
            title:'职位',         //提示选择的是什么的类别
            tip:'至多可选择5个',  //右上侧提示语
            col_num:3,            //最大列数
            max_slt:5,            //最大选择个数
            single:false,         //是否为单选
            limit:false,           //是否显示不限
            sure:resumeRender.qo   //确定提交选择结果的时候执行的方法
        });
        /*(工作经验,工程业绩)职位名称*/
        $("#job_hold,#pjheld").focus(function(){
            baseRender.a(this, LANGUAGE.L0184, "right");
        }).blur(function(){
             resumeController.name_valid(this, LANGUAGE.L0173);
        });
          /*(工作经验)部门名称*/
        $("#job_depart").focus(function(){
            baseRender.a(this, LANGUAGE.L0185, "right");
        }).blur(function(){
             resumeController.name_valid(this, LANGUAGE.L0186);
        });
          /*(工作经验)公司名称*/
        $("#exp_cname").focus(function(){
            baseRender.a(this, LANGUAGE.L0187, "right");
        }).blur(function(){
             resumeController.name_valid(this, LANGUAGE.L0188);
        });
          /*(工作经验)行业名称*/
        $("#exp_trade").focus(function(){
            baseRender.a(this, LANGUAGE.L0189, "right");
        }).blur(function(){
             resumeController.name_valid(this, LANGUAGE.L0190);
        });
          /*(工作经验工程业绩)工作内容*/
        $("#job_cont,#pjcontent").focus(function(){
            baseRender.a(this, LANGUAGE.L0191, "right");
        }).blur(function(){
                var msg='';
                var bl=true;
                var str=$(this).val().replace(new RegExp(" ","g"),"");
                $(this).val(str);
                if(str==""){
                    msg=LANGUAGE.L0192;
                    bl=false;
                }
                if(!bl){
                    baseRender.a(this, msg, "error");
                }
                else{
                    baseRender.ai(this);
                }
        });
         /*(工程业绩)项目名称*/
         $("#pjname").focus(function(){
            baseRender.a(this, LANGUAGE.L0193, "right");
        }).blur(function(){
             resumeController.name_valid(this, LANGUAGE.L0194);
        });
        /*(兼职补充说明)(全职求职意向)移除空格*/
        $("#p_cmp,#job_want,#job_cont,#pjcontent").blur(function(){
            $(this).val($(this).val().replace(new RegExp(" ","g"),""));
        });
        /*(全职)个人学历表单*/
       $("#q_scname").focus(function(){
            baseRender.a(this, LANGUAGE.L0175, "right");
        }).blur(function(){
             resumeController.name_valid(this, LANGUAGE.L0176);
        });
        /*专业名称*/
        $("#q_majoy").focus(function(){
            baseRender.a(this, LANGUAGE.L0200, "right");
        }).blur(function(){
            resumeController.name_valid(this, LANGUAGE.L0180);
        });
        $("#end_time,#be_time,#exp_bdate,#exp_endate,#pjstart,#pjstoped").click(function(){
             baseRender.b(this);
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
     *初始化地区选择插件
     *2012-1-15
     */
    c:function(){
         /*(兼职)地区选择(单选省份城市)*/
         $("#p_befrm").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"pslt",            //省市添加的父容器id
            pshow:true,       //是否显示地区选择
            sprov:false,       //是否只精确到省
            single:true,     //省是否为单选
           sure:resumeRender.d
        });
         /*(全职)地区选择(单选省份城市)*/
         $("#q_bf").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"pslt",            //省市添加的父容器id
            pshow:true,       //是否显示地区选择
            sprov:false,       //是否只精确到省
            single:true,     //省是否为单选
           sure:resumeRender.fq_place
        });
         /*(全职)求职岗位(单选省份城市)*/
         $("#q_area").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            pid:"pslt",            //省市添加的父容器id
            pshow:true,       //是否显示地区选择
            sprov:false,       //是否只精确到省
            single:true,    //省是否为单选
           sure:resumeRender.job_place
        });
        /*(全职)职称选择*/
         $("#q_cert").hgsSelect({
            type:'jobtitle',
            tid:"tslt",        //职称添加的父容器id
            sure:resumeRender.fultime_l
        });
         /*(全职)资质选择*/
        $("#pqual_select").hgsSelect({
                level:1,	   //当前选择框的层次,从1开始
                id:"pqselect",             //设置选择框父容器id
                pid:"pregplace",            //省市添加的父容器id
                pshow:true,       //是否显示地区选择
                sprov:true,       //是否只精确到省
                single:true,       //省是否为单选
                sure:resumeRender.fultime_f
        });
        /*(兼职)地区选择(多选省份)*/
         $("#p_area").hgsSelect({
           type:"place",//选择框类型
            pid:"place",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:true,//是否只精确到省
            single:false,  //是否为单选       
           sure:resumeRender.e
        });
         /*(兼职)资质选择*/
        $("#qqual_select").hgsSelect({
                level:1,	   //当前选择框的层次,从1开始
                id:"qqselect",             //设置选择框父容器id
                pid:"qregplace",            //省市添加的父容器id
                pshow:true,       //是否显示地区选择
                sprov:true,       //是否只精确到省
                single:true,       //省是否为单选
                sure:resumeRender.f
        });
         /*(兼职)职称选择*/
         $("#p_cert").hgsSelect({
            type:'jobtitle',    
            tid:"tslt",        //职称添加的父容器id
            sure:resumeRender.l
        });
    },
    /*
     *(兼职)个人信息修改
     *(全职)个人信息修改
     *(全职)个人证书修改
     */
    d:function(){
        var that=resumeRender;
        var rc=resumeController;
        /*(兼职/全职)个人信息修改*/
        $("a.base_edit").unbind("click").bind("click",function(){
            var par=$(this).parent().prev();
            par.removeClass("updatedata");
            par.find("input[type='text'],textarea").not("input.hasDatepicker,input.mselect,input.phone,input.email").removeAttr("readonly");
            par.find(".hidden").removeClass("hidden");
            par.find("span.txtinfo,span.pt_com").addClass("hidden");
            par.find("img.ui-datepicker-trigger").css("display","block");
            $(this).parent().addClass("hidden");
            $(this).parent().next().removeClass("hidden");
            rc.ab(this);
        });
        /*(兼职)个人证书修改*/
        $("#pt_qa").click(function(){
            that.n();
        });
        /*(全职)求职岗位修改*/
        $("#jobpo_edit").click(function(){
             that.jobpo_m();
        });
         /*(全职)个人学历修改*/
        $("#edu_edit").click(function(){
             that.peredu_m();
        });
         /*(全职)个人证书修改*/
        $("#fjobct_edit").click(function(){
             that.pcert_n();
        });
    },
    /*
     *(兼职)保存个人证书情况
     *(全职)保存求职岗位数据
     *(全职)保存个人学历
     *(全职)保存证书情况
     *jack
     *2012-2-3
     */
    g:function(){
       /*保存全职简历求职岗位*/
      $("#jobpo_save").click(function(){
          resumeRender.job_z();
      });
       /*保存全职简历个人学历*/
      $("#edu_save").click(function(){
          resumeRender.peredu_z();
      });
      /*保存全职证书情况*/
      $("#fjob_csve").click(function(){
          resumeRender.fucert_z();
      });
      /*保存兼职个人证书情况*/
      $("#sv_cert").click(function(){
          resumeRender.y();
      });
    },
    /*
     *(兼职)所在地验证事件绑定
     *初始化资质验证绑定
     */
    h:function(){
         $("#p_befrm,#p_area,#q_bf,#q_area").focus(function(){
             baseRender.b(this);
        }).blur(function(){
            resumeController.l(this,LANGUAGE.L0138);
        });
        baseController.BtnBind(".btn4", "btn4", "btn4_hov", "btn4_click");
        baseController.BtnBind(".btn5", "btn5", "btn5_hov", "btn5_click");
        baseController.BtnBind(".btn8", "btn8", "btn8_hov", "btn8_click");
    },
    /*
     *(兼职)所在地验证
     */
    l:function(id,lan){
         var msg='';
        var bl=true;
        var str=$(id).val().replace(new RegExp(" ","g"),"");
        if(str==""){
            msg=lan;
            bl=false;
        }
        if(!bl){
            baseRender.a(id, msg, "error",0);
        }
    },
    /*(全职)名称的验证*/
    name_valid:function(id,lan){
         var msg='';
        var bl=true;
        var str=$(id).val().replace(new RegExp(" ","g"),"");
        $(this).val(str);
        if(str==""){
            msg=lan;
            bl=false;
        }
     else if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(str)){
             msg=LANGUAGE.L0130;
             bl=false;
        }
        if(!bl){
            baseRender.a(id, msg, "error");
        }
        else{
            baseRender.ai(id);
        }
    },
    /*
     *(兼职)删除/添加资质证书事件绑定
     *参数：证书id
     *certificate_id
     */
    m:function(){
       resumeRender.pct_han();
       $("#pt_quali .d_cert").unbind("click").bind("click",function(){
          $("#qqual_select").parent().prev("td.ltd").find("span.red").remove();
          $("#pt_quali").find("a.adn_cancle").remove();
          if(!$("#pt_quali table.tb_cert tr.first").hasClass("hidden")){
            $("#pt_quali").find("tr.first").addClass("hidden");
          }
         var cid=$(this).attr("rel");
         var msg=confirm(LANGUAGE.L0048);
         if(msg==true){
             $(this).parent("div.qua_list").remove();
             var r=new Resume();
             r.DeleCert(cid,resumeRender.r);
         }
      });
    $("#pt_quali .adn_qa").unbind("click").bind("click",function(){
         resumeRender.o(this);
    });
    },
     /*
     *(全职)删除/添加资质证书事件绑定
     *参数：证书id
     *certificate_id
     */
    fultime_m:function(){
        resumeRender.fct_han();
       $("#zert_quali .d_cert").unbind("click").bind("click",function(){
           $("#pqual_select").parent().prev("td.tl").find("span.red").remove();
          $("#zert_quali").find("a.adn_cancle").remove();
          if(!$("#zert_quali table.tb_cert tr.first").hasClass("hidden")){
            $("#zert_quali").find("tr.first").addClass("hidden");
          }
         var cid=$(this).attr("rel");
         var msg=confirm(LANGUAGE.L0048);
         if(msg==true){
             var len=$("#zert_quali .qua_list").length;
             $(this).parent("div.qua_list").remove();
             var r=new Resume();
             r.DeleCert(cid,resumeRender.fultime_r);
             }
          });
        $("#zert_quali a.adn_qa").unbind("click").bind("click",function(){
             resumeRender.fultime_o(this);
        });
    },
    /*
     *(兼职)验证资质(提交保存按钮验证)
     *参数：无
     *jack
     *2012-2-3
     */
    j:function(){
       resumeRender.p(); 
    },
    /*
     *(兼职,全职)职称证验证
     */
    k:function(){
         $("#p_cert,#q_cert").focus(function(){
            baseRender.b(this);
        }).blur(function(){
             var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            if(!b){
                baseRender.a(this,msg,"error");
            }
        });
    },
    /*
     *(兼职)保存资质证书
     *jack
     *2012-2-7
     */
    n:function(_cur){
        var that=$(_cur);
        var o=that.data("rid");
        var r=that.data("pid");
        var m="";
        if(that.data("mid")){
            m=that.data("mid");
        }
        else{
            m=that.data("zid");
        }
        var sv=new Resume();
        sv.AddCert(m, r, o,resumeRender.w,resumeRender.x);
    },
    /*
     *(全职)保存资质证书
     *jack
     *2012-2-7
     */
    fultime_n:function(_cur){
        var that=$(_cur);
        var o=that.data("rid");
        var r=that.data("pid");
        var m="";
        if(that.data("mid")){
            m=that.data("mid");
        }
        else{
            m=that.data("zid");
        }
        var sv=new Resume();
        sv.AddCert(m, r, o,resumeRender.fultime_w,resumeRender.x);
    },
    /*
     *保存页面初始数据
     *jack
     *2012-2-8
     */
    o:function(){
       resumeRender.inisavedata();/*兼职证书*/
       resumeRender.job_inida();/*全职求职岗位*/
       resumeRender.peredu_inidata();/*全职学历信息*/
       resumeRender.fulcert_inidata();/*全职证书情况*/
    },
    /*
     *(兼职)保存修改后的证书情况
     *jack
     *2012-2-8
     */
    p:function(){
     $("#p_cert,#p_area,#job_salary").trigger("blur");
        var e=$("input[name='certid']").val();//职称证书对应资质证书ID
        var id;//职称证书
        var celev;//职称级别
         if($("#p_cert").val()!=""){
            id=$("input[name='jtid']").val();
            celev=$("input[name='jtlid']").val();
        }else{
            id=0;
            celev=0;
            e=0;
        }
       if($(".part_quali div.tip.error").length<=0){
            var p={
                certificate_id:e,//职称证书对应资质证书ID
                GC_id:id,//职称证书ID
                GC_class:celev,//职称证书等级
                certificate_remark:$("#p_cmp").val(),
                job_salary:$("#job_salary")[0].options[$("#job_salary")[0].selectedIndex].value,
                register_province_ids:$("input[name='resum_pro']").val(),
                treatment:$("#defpay").val()
            }
             if(p.job_salary!=12){
              p.treatment=0;
            }
           var s=new Resume();
           s.UpdateCert(p,resumeRender.s,resumeRender.t);
       }
    },
      /*
     *(全职)保存修改后的证书情况
     *jack
     *2012-2-9
     */
    fult_p:function(){
     $("#q_cert").trigger("blur");
        var e=$("input[name='q_certid']").val();//职称证书对应资质证书ID
        var id;//职称证书
        var celev;//职称级别
         if($("#q_cert").val()!=""){
            id=$("input[name='q_jtid']").val();
            celev=$("input[name='q_jtlid']").val();
        }else{
            id=0;
            celev=0;
            e=0;
        }
       if($(".bp_quali div.tip.error").length<=0){
            var p={
                certificate_id:e,//职称证书对应资质证书ID
                GC_id:id,//职称证书ID
                GC_class:celev,//职称证书等级
                certificate_remark:$("#q_detail").val()
            }
           var s=new Resume();
           s.UpdateFultimeCert(p,resumeRender.fultime_s,resumeRender.fult_t);
       }
    },
    /*
     *(兼职)保存修改后的个人基本信息
     *jack
     *2012-2-8
     */
    q:function(){
        var that=resumeRender;
        $("#sv_ptinfo").unbind("click").bind("click",function(){
            $("div").data("obd","#sv_ptinfo");
            $("#p_tname,#p_phone,#p_qq,#p_email,#p_befrm").trigger("blur");
            if($(".part_bpin div.tip.error").length==0){
                var p={
                    name:$("#p_tname").val(),
                    gender:$("input[name='sex']:checked").val(),
                    birth:$("#p_date").val(),
                    pid:$("input[name='pat_prov']").val(),
                    cid:$("input[name='pat_city']").val(),
                    phone:$("#p_phone").val(),
                    email:$("#p_email").val(),
                    qq:$("#p_qq").val(),
                    exp:$("#p_msel")[0].options[$("#p_msel")[0].selectedIndex].value
                }
                var r=new Resume();
                r.UpResPinfo(p,that.b,that.c);
                $("#p_phone,#p_email").removeClass("gray");
            }
       });
    },
    /*
     *(全职)保存修改后的个人基本信息
     *jack
     *2012-2-8
     */
    ful_q:function(){
      $("#ful_save").unbind("click").bind("click",function(){ 
         $("div").data("obd","#ful_save");
         $("#q_tname,#q_phone,#q_pq,#q_email,#q_bf").trigger("blur");
        if($(".bp_inf div.tip.error").length==0){
            var p={
                name:$("#q_tname").val(),
                gender:$("input[name='p_sex']:checked").val(),
                birth:$("#q_bth").val(),
                pid:$("input[name='q_pro']").val(),
                cid:$("input[name='q_city']").val(),
                phone:$("#q_phone").val(),
                email:$("#q_email").val(),
                qq:$("#q_pq").val(),
                exp:$("#q_se")[0].options[$("#q_se")[0].selectedIndex].value
            }
            var r=new Resume();
            r.UpResPinfo(p,resumeRender.b,resumeRender.c);
            $("#q_phone,#q_email").removeClass("gray");
        }
      });
    },
    /*
     *(全职)保存修改后的求职岗位信息
     */
    job_q:function(){
        var bl=true;
        if($("#slt_pos").children().length==0){
            $("#jtip").css("display","inline-block");
            $("#jtip").addClass("error");
            bl=false;
        }
        $("#q_area,#q_salay").trigger("blur");
        if($(".bp_position div.tip.error").length==0&&bl){
          var p={
              job_name:$("#q_pos").attr("cids"),
              job_province_code:$("input[name='jobp_prov']").val(),
              job_city_code:$("input[name='jobp_city']").val(),
              job_describle:$("#job_want").val(),
              job_salary:$("#q_salary")[0].options[$("#q_salary")[0].selectedIndex].value,
              treatment:$("#defpay1").val()
          }
          if(p.job_salary!=12){
              p.treatment=0;
          }
          var r=new Resume();
          r.JobpositionSave(p,resumeRender.jobPosition_suce,resumeRender.jobPosition_failed);
      }
    },
    /*
     *(全职)保存修改后的个人学历信息
     */
    peredu_q:function(){
        $("#q_scname,#q_majoy").trigger("blur");
        resumeRender.bdatejudage("#be_time","#end_time");
        if($(".edu div.tip.error").length==0){
            var p={
                study_startdate:$("#be_time").val(),
                study_enddate:$("#end_time").val(),
                school:$("#q_scname").val(),
                major_name:$("#q_majoy").val(),
                degree_name:$("#q_edu")[0].options[$("#q_edu")[0].selectedIndex].value
            }
            var r=new Resume();
            r.UpPereducation(p,resumeRender.eduSucc,resumeRender.edufail);
        }
    },
    /*
     *初始化工作经验数据
     *绑定删除添加工作经验事件
     *jack
     *2012-2-10
     */
    exper_ini:function(){
        resumeRender.exper_hand();
        /*添加事件绑定*/
        $("#job_exper a.adexper").unbind("click").bind("click",function(){
            resumeRender.adexp();
        });
        /*删除事件绑定*/
         $("#job_exper a.delexp ").unbind("click").bind("click",function(){
               resumeRender.exp_cle();
               var cid=$(this).attr("rel");
               var msg=confirm(LANGUAGE.L0048);
              if(msg==true){
                 $(this).parents("table.t_ce").remove();
                 var r=new Resume();
                 r.DeleWorkexp(cid,resumeRender.exp_s,resumeRender.exp_f);
          }
        });
    },
    /*
     *(兼职)保存工作经验
     *jack
     *2012-2-10
     */
    save_exper:function(){ /*保存工作经验*/
        $("#exper_save").click(function(){
            resumeRender.bdatejudage("#exp_bdate","#exp_endate");/*判断前后的时间对比和非空方法*/
            $("#exp_cname,#exp_trade,#job_depart,#job_hold,#job_cont").trigger("blur");
            if($(".bp_exper div.tip.error").length==0){
                var p={
                   department:$("#job_depart").val(),
                   work_startdate:$("#exp_bdate").val(),
                   work_enddate:$("#exp_endate").val(),
                   company_name:$("#exp_cname").val(),
                   company_industry:$("#exp_trade").val(),
                   company_scale:$("#exp_sacle")[0].options[$("#exp_sacle")[0].selectedIndex].value,
                   company_property:$("#exp_attr")[0].options[$("#exp_attr")[0].selectedIndex].value,
                   job_name:$("#job_hold").val(),
                   job_describle:$("#job_cont").val()
                }
                var resu=new Resume();
                resu.AddExper(p,resumeRender.ad_exp_suc,resumeRender.ad_exp_f);
            }
        });
    },
     /*
     *初始化工程业绩数据
     *绑定删除添加工程业绩事件
     *jack
     *2012-2-10
     */
    perfane_ini:function(){
        resumeRender.project_hand();
        /*添加事件绑定*/
        $("#job_perform a.adprs").unbind("click").bind("click",function(){
            resumeRender.adprogs();
        });
        /*删除事件绑定*/
         $("#job_perform a.dele_prgs").unbind("click").bind("click",function(){
              resumeRender.deal_achiv();
               var cid=$(this).attr("rel");
               var msg=confirm(LANGUAGE.L0048);
              if(msg==true){
                 $(this).parents("table.t_pf").remove();
                 var r=new Resume();
                 r.DelePojectAchive(cid,resumeRender.pgs_s,resumeRender.pgs_f);
         }
        });
    },
    /*
     *(兼职)保存工程业绩
     *jack
     *2012-2-10
     */
    save_perfance:function(){
        /*保存工程业绩*/
        $("#pjr_save").click(function(){
             resumeRender.bdatejudage("#pjstart","#pjstoped");/*判断前后的时间对比和非空方法*/
            $("#pjname,#pjheld,#pjcontent").trigger("blur");
            if($(".pgrs div.tip.error").length==0){
                var p={
                    name:$("#pjname").val(),
                    scale:$("#pjscale")[0].options[$("#pjscale")[0].selectedIndex].value,
                    start_date:$("#pjstart").val(),
                    end_date:$("#pjstoped").val(),
                    job_name:$("#pjheld").val(),
                    job_describle:$("#pjcontent").val()
                }
                var r=new Resume();
                r.AddProAchive(p,resumeRender.adprogs_succ,resumeRender.ad_fail);
            }
        });
    },
    /*
     *
     *发布方式选择初始化
     *说明cate：1全职
     *2兼职
     *status:2已公开，未委托
     *>2已委托
     *jack
     *2012-2-10
     */
    pubReume:function(){
        var cate=$("input[name='job_cat']").val();
        var status=$("input[name='job_sta']").val();
        if(cate==0||cate==""){
          resumeController.job_no_publish();
        }
        /*兼职简历被发布了*/
        else if(cate==2){
            if(status==2){
                resumeController.part_Publish_public();
            }else{
               resumeController.pub_delgate_Publish();
            }
        }
        /*全职简历被发布了*/
        else{
             if(status==2){
                resumeController. fjob_Publish_public();
            }else{
               resumeController.pub_delgate_Publish();
            }
        }
    },
    /*
     *兼职简历和全职简历均未被发布
     *jack
     *2012-2-10
     */
    job_no_publish:function(){
         /*兼职简历*/
           $("a#pub_presu").bind("click",function(){
                var r=new Resume();
                r.PubPartresume(2,resumeRender.pub_part_sucss,resumeRender.pub_fail);
           });
           $("#cho_presu").bind("click",function(){
                 var r=new Resume();
                 r.deleGateAgent(2,resumeRender.delegateSucc,resumeRender.delegateFail);
           });
           /*全职简历*/
           $("a#fjob_app").bind("click",function(){
                var r=new Resume();
                r.PubPartresume(1,resumeRender.pub_part_sucss,resumeRender.pub_fail);
           });
           $("#fjob_adel").bind("click",function(){
                 var r=new Resume();
                  r.deleGateAgent(1,resumeRender.delegateSucc,resumeRender.delegateFail);
           });

    },
     /*
     *全职简历以公开求职的方式发布了
     *jack
     *2012-2-10
     *
     */
    fjob_Publish_public:function(){
        resumeRender.iniFultpub();
    },
    /*
     *兼职简历以公开求职的方式发布了
     *jack
     *2012-2-10
     *
     */
    part_Publish_public:function(){
       resumeRender.iniPartPublish();
    },
    /*
     *简历以代理的的方式发布了
     *jack
     *2012-2-12
     */
    pub_delgate_Publish:function(){
        resumeRender.iniDelegateStatus();
         $("div.del_agent a.lock_pic").hover(function(){
             resumeRender.unlock_stas1();
        },function(){
              resumeRender.unlock_stas2();
        });
        $("div.del_agent a.lock_pic").bind("click",function(){
               var r=new Resume();
               r.UnLockResume(resumeRender.unlockSucc,resumeRender.unlockFail);
        });
    },
    /*
     *绑定简历结束公开求职方法
     *jack
     *2012-2-10
     */
    pub_end_pub:function(){
        var r=new Resume();
        r.EndPartresume(resumeRender.pub_part_sucss,resumeRender.pub_fail);
    },
   
 /****************************************************证书部分**************************************/
 /*
     * 功能：初始化资质证书
     * 参数：
     * 无
     */
    ct_a:function(){
        $("#tqual").hgsSelect({
            id:"tqselect",     //设置选择框父容器id
            pid:"tregplace",    //省市添加的父容器id
            pshow:true,        //是否显示地区选择
            sprov:true,        //是否只精确到省
            single:true,       //省是否为单选
            sure:resumeRender.c_a
        });
    },
    /*
     * 功能：证书初始化到期提醒
     * 参数：
     * 无
     */
    ct_b:function(){
        $("#detime").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true
        });
    },
    /*
     * 功能：证书文件上传
     * 参数：
     * 无
     */
    ct_c:function(){
        /*上传证书图片*/
        var that=$('input.files');
        if(that.length>0){
            this.ct_ac(that);
        }
    },
    /*
     * 功能：证书文件上传事件绑定
     * 参数：
     * obj：绑定对象
     */
    ct_ac:function(obj){
        $(obj).bind('change',function(){
            resumeRender.c_l(this);
        });
    },
    /*
     * 功能：确定证书文件上传按钮事件绑定
     * 参数：
     * obj：当前文件上传表单
     */
    ct_d:function(obj){
        var that=$(obj);
        that.parent().find("a.asubmit").unbind("click").bind("click",function(){
            that.parent().parent().find("a.asubmit").removeClass("cur_file");
            $(this).addClass("cur_file");
            $("#upfname").val(that.attr("name"));
            $("#upfcid").val($(this).parent().find("div").attr("cid"));
            resumeRender.c_f(that);
        });
    },
    /*
     * 功能：证书绑定初始化
     * 参数：
     * 无
     */
    ct_e:function(){
        var that=$('#form_upload table td div a.delecert');
        if(that.length>0){
            that.bind('click',function(){
                resumeRender.c_l(this);
            });
        }
    },
    /*
     * 功能：证书删除事件绑定
     * 参数：
     * obj：当前绑定对象
     */
    ct_f:function(obj){
        $(obj).bind('click',function(){
            var a=$(this).parent().attr("cid");
            $(this).parent().parent().parent().remove();
            var that=resumeRender;
            var ct=new Cert();
            ct.DeleTCert(a, null, that.c_n);
        });
    },
    /*
     * 功能：证书添加事件绑定
     * 参数：
     * 无
     */
    ct_g:function(){
        $("#savebtn").bind('click',function(){
            $("#tqual").trigger("blur");
            var par=$("table.tb_nt");
            if(par.find("div.tip").length==0){
                var slt=par.find("input.qual_select");
                var a="",
                b="",
                c="";
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
                        a+=","+tmp;
                        b+=","+$(o).data("rid");
                        c+=","+$(o).data("prov");
                    }
                    else if(i==0&&tmp!=""){
                        a+=tmp;
                        b+=$(o).data("rid");
                        c+=$(o).data("prov");
                    }
                });
                var that=resumeRender;
                var ct=new Cert();
                ct.AddTCert(a, c, b, that.c_o, that.c_p);
            }
        });
    },
    /*
     * 功能：证书验证
     * 参数：
     * obj：当前绑定对象
     */
    ct_h:function(){
        $("#tqual").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            resumeController.ct_i(this,LANGUAGE.L0159);
        });
    },
    /*
     * 功能：资质类文本框验证
     * 参数：
     * 无
     */
    ct_i:function(id,lan){
        var msg='';
        var bl=true;
        var str=$(id).val().replace(new RegExp(" ","g"),"");
        if(str==""){
            msg=lan;
            bl=false;
        }
        if(!bl){
            baseRender.a(id, msg, "error",0);
        }
        else{
            baseRender.b(id);
        }
    },
    /*
     * 功能：初始化职称证
     * 参数：
     * 无
     */
    ct_k:function(){
        $("#qtitle").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"tqtitle",
            sure:resumeRender.c_q
        });
    },
    /*
     * 功能：修改职称证
     * 参数：
     * 无
     */
    ct_l:function(){
        var that=$('#form_upload table td div a.alter');
        if(that.length>0){
            this.ct_la(that);
        }
    },
    /*
     * 功能：修改职称证事件绑定
     * 参数：
     * obj：绑定对象
     */
    ct_la:function(obj){
        $(obj).unbind("click").bind("click",function(){
            resumeRender.c_r(this);
        });
    },
    /*
     * 功能：添加职称证
     * 参数：
     * 无
     */
    ct_m:function(){
        var ta=["",""];
        var tit=$("#qtitle"),
        a=tit.parent().parent().attr("cid");
        if(tit.data("ids")){
            ta=tit.data("ids").split(",");
        }
        var that=resumeRender;
        var ct=new Cert();
        ct.UpdateTTitle(a, ta[1], ta[0], null, that.c_p);
    },
    /*
     * 功能：解除职称认证
     * 参数：
     * 无
     */
    ct_n:function(){
        var hti=$("#htit a.opencont");
        if(hti.length>0){
            hti.unbind("click").bind("click",function(){
                var that=resumeRender;
                that.c_s(this);
                var a=$("#htit").attr("cid");
                var ct=new Cert();
                ct.RemoveTitleCt(a, null, that.c_p);
            });
        }
    },
    /*
     * 功能：期望待遇事件绑定
     * 参数：
     * 无
     */
    ct_o:function(){
        resumeRender.g();
    },
    /*
     * 功能：初始化期望待遇验证
     * 参数：
     * 无
     */
    da:function(){
        $("#defpay,#defpay1").focus(function(){
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
     *功能：初始化手机号码/邮箱验证
     *参数：无
     */
    db:function(){
         /*邮箱验证*/
        $("#p_email,#q_email").focus(function(){
            if($(this).data("cedite")&&$(this).hasClass("n_email")){
                baseRender.a(this, LANGUAGE.L0001, "right" ,0);
            }
        }).blur(function(){
            if($(this).data("cedite")&&$(this).hasClass("n_email")){
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
        /*电话号码验证*/
         $("#p_phone,#q_phone").focus(function(){
            if($(this).data("cedite")&&$(this).hasClass("n_phone")){
                baseRender.a(this,LANGUAGE.L0039, "right", 0);
            }
        }).blur(function(){
            if($(this).data("cedite")&&$(this).hasClass("n_phone")){
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
     * 功能：初始化首页
     * 参数：无
     * 无
     */
    IniPage:function(){
        baseRender.ae(1);
        this.ba();
        this.aa();
        this.ae("div.rcom table.tb_com");
        this.ad("table.tb_com");
        this.a();/*日期控件初始化*/
        this.q();
        this.ful_q();
        this.b();/*初始化表单验证*/
        this.c();/*地区控件*/
        this.d();/*修改事件*/
        this.g();/*保存简历个人信息/证书情况(兼职)*/
        this.k();/*职称证书验证*/
        this.h();/*所在地验证*/
        this.m();/*资质证书删除/添加绑定(兼职)*/
        this.fultime_m();/*资质证书删除/添加绑定(全职)*/
        this.o();/*保存页面初始数据*/
        this.exper_ini();/*初始化工作经验*/
        this.save_exper();/*保存工作经验*/
        this.perfane_ini();/*初始化工程业绩*/
        this.save_perfance();/*保存工程业绩*/
        this.pubReume();/*公开求职*/
        this.ct_a();/*初始化资质证书*/
        //this.ct_b();到期时间绑定
        this.ct_c();
        this.ct_h();
        this.ct_g();
        this.ct_l();
        this.ct_k();
        this.ct_n();
        this.ct_f($("#form_upload table.tb td a.delecert"));
        this.ct_o();
        this.db();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    //根据PAGE来初始化页面
    if(PAGE=="56"){
        //初始化页面js等
        resumeController.IniPage();
    }
});
