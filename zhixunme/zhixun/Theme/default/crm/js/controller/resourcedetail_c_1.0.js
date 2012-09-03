/*
 *CRM客户资源详细页面控制器
 *包含添加客户资源和修改客户资源js方法等
 */
var resourcedetailController={
    /*******************************公共部分***********************************************/
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
     * 功能：检验当前是否为可修改状态
     * 参数：
     * 无
     */
    a:function(){
        var that=resourcedetailController;
        $("div.comdetail div.base_info input[type='text'], div.comdetail div.base_info textarea").bind({
            focus:function(e){
                that.b(this);
            },
            click:function(e){
                that.b(this);
            }
        });
    },
    /*
     * 功能：检验当前是否为可修改状态
     * 参数：
     * 无
     */
    b:function(obj){
        var par=$(obj).parents(".mod");
        if(par.hasClass("tb_cm")){
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
     * 功能：日期初始化
     * 参数：
     * 无
     */
    d:function(){
        $("#sign_date,#end_date,#pay_date,#fd_date,#refund_date").datepicker({
            showOn: "both",
            buttonImage: THEMEROOT+'lib/jquery-datepicker/images/calendar-blue.gif',
            buttonImageOnly: true,
            yearRange:'1990:2050',
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
        $("#date").datepicker({
            showOn: "both",
            buttonImage: THEMEROOT+'lib/jquery-datepicker/images/calendar-blue.gif',
            buttonImageOnly: true,
            yearRange:'1970:2050',
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
    },
    /*
     *功能：姓名/企业名称初始化
     *参数：无
     */
    e:function(id,lan1,lan2){
        $(id).focus(function(){
            if($(this).data("cedite")){
                baseRender.a(this, lan1, "right" ,0);
            }
        }).blur(function(){
            if($(this).data("cedite")){
                var str=$(this).val().replace(new RegExp(" ","g"),"");
                $(this).val(str);
                var msg="";
                var b=true;
                if(str==""){
                    msg=lan2;
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
     * 功能：初始化所在地
     * 参数：
     * 无
     */
    f:function(){
        $("#place,#cm_belong").hgsSelect({
            type:"place",//选择框类型
            pid:"uplace",//省id
            pshow:true,//是否显示省
            sprov:false,//是否只精确到省
            single:true, //是否为单选
            sure:resourcedetailRender.c
        });
    },
    /*
     *功能：保存按钮样式初始化
     *参数：无
     */
    g:function(){
        baseController.BtnBind(".btn4", "btn4", "btn4_hov", "btn4_click");
//        baseController.BtnBind(".btn15", "btn15", "btn15_hov", "btn15_hov");
        resourcedetailRender.tj();
    },
    /*
    * 功能：初始化文本框
    * 参数：
    * 无
    */
    h:function(obj){
        var par=$(obj).parent().next().next();
        resourcedetailController.ha(par);
    },
    /*
     *功能：页面数据初始化
     *参数：无
     */
    ha:function(par){
        var ele=$(par);
        var txt=ele.find("input[type='text']");//文本框
        var select=ele.find("select");//下拉框
        var radio=ele.find("input[type='radio']").parent().parent();//单选框
        var area=ele.find("textarea.cin");
        $.each(area,function(i,o){
           var that=$(o);
           that.val(that.data("curdata"));
           that.prev().find("span").text(that.data("curdata"));
           that.prev().prev().find("span.fct").text( that.prev().prev().find("span").data("nct"));
           that.prev().prev().find("span.fctr").text( that.prev().prev().find("span").data("ncte"));
        });
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
    i:function(par){
        par=$(par);
        var txt=par.find("input[type='text'],textarea");//文本框
        var select=par.find("select");//下拉框
        var radio=par.find("input[type='radio']").parent().parent();//单选框
        var area=par.find("textarea.cin");
        $.each(area,function(i,o){
            var that=$(o);
            that.data("curdata",$(o).val());
            that.prev().find("span").data("curdata",$(o).val());
            that.prev().prev().find("span.fct").data("nct",$(o).val().substring(0,100));
            that.prev().prev().find("span.fctr").data("ncte",$(o).val());
        });
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
    j:function(par){
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
    /*
     * 功能：初始化资质证书
     * 参数：
     * 无
     */
    l:function(){
        $("#tqual").hgsSelect({
            id:"tqselect",
            pid:"tqplace",
            pshow:true,
            sprov:true,
            single:true,
            sure:resourcedetailRender.a,
            async:true,
            qurl:CRMURL.GetCertsTpe,
            murl:CRMURL.GetGertMajor,
            prvurl:CRMURL.GetAreaInfo
        });
    },
    /*
     * 功能：初始化职称证
     * 参数：
     * 无
     */
    m:function(){
        $("#tjtitle").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"tjtitles",
            sure:resourcedetailRender.b,
            gcurl:CRMURL.GetZcType,
            zurl:CRMURL.GetZCname
        });
    },
    /*
     *功能：初始化必填项验证
     *参数：无
     */
    o:function(){
        var t=resourcedetailController;
        t.e("#uname",LANGUAGE.L0161,LANGUAGE.L0068);  
        t.e("#ename",LANGUAGE.L0126,LANGUAGE.L0117);  
        t.e("#contacter",LANGUAGE.L0135,LANGUAGE.L0136);  
        t.e("#recname",LANGUAGE.L0126,LANGUAGE.L0117);  
    },
    /*
    * 功能：初始化操作/修改
    * 参数：无
    */
    dc:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().next().next();
            var that=resourcedetailController;
            $(this).text("取消");
            $(this).attr("title","取消");
            $(this).parent().parent().removeClass("updatedata");
            par.find("input[type='text'],textarea").not("input.mselect").not("input.hasDatepicker").removeAttr("readonly");
            par.find("img.ui-datepicker-trigger").css("display","inline-block");
            par.find(".hidden").not("#adr_reg").not("#adr_community").not("#adr_city").removeClass("hidden");
            par.find("#adr_pro>option:eq(0)").text("").text("请选择");
            par.find("#street").addClass("hidden");
            var reg=par.find("#adr_reg"),comm= par.find("#adr_community"),cty=par.find("#adr_city");
            if(reg.children().length>0&&!reg.parents("div.mod_1").hasClass('updatedata')){
                reg.removeClass("hidden");
            }
            if(comm.children().length>0&&!comm.parents("div.mod_1").hasClass('updatedata')){
                comm.removeClass("hidden");
            }
            if(cty.children().length>0&&!cty.parents("div.mod_1").hasClass('updatedata')){
                cty.removeClass("hidden");
                par.find("#street").removeClass("hidden");
            }
            if(par.find("span.pv_de").attr("val")!="0"){
               par.find("#adr_pro").trigger("change");
            }
            par.next().removeClass("hidden");
            par.find("span.txtinfo,div.csouce,span.pv_de,span.city_de,span.ar_de,span.cun,div.adr_deail1,span.short_brief,div.all_cnt").addClass("hidden");
            that.dd(this);
            that.h(this);
        });
    },
    /*
   *有数据的情况
   *功能：取消修改操作
   *参数：无
   */
    dd:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().next().next();
            var that=resourcedetailController;
            $(this).text("修改");
            $(this).attr("title","修改");
            $(this).parent().parent().addClass("updatedata");
            par.find(".red_border").removeClass("red_border");
            par.find("div.result,div.tip,div.error").remove();
            par.find("input[type='text'],textarea").not("input[class='mselect']").not("input[class='hasDatepicker']").attr("readonly","true");
            par.find("select,span.txthid,input[type='radio']").addClass("hidden");
            par.find("span.txtinfo,div.csouce,span.pv_de,span.city_de,span.ar_de,span.cun,div.adr_deail1").removeClass("hidden");
            var ele=par.find("textarea.comshort");
            if(ele.val()!=""){
                 par.find("span.short_brief").removeClass("hidden");
            }
            //省份区域操作处理
            if(par.find("#adr_pro")){
                var pb=par.find("#adr_pro").prev("span.pv_de").attr("val");//省份区域操作处理
                if(pb=="0"){
                    par.find("#adr_pro").prev("span.pv_de").text("");
                }
            }
            par.next().addClass("hidden");
            par.find("textarea.cin").addClass("hidden");
            par.find("img.ui-datepicker-trigger").css("display","none");
            that.dc(this); 
            that.h(this);
        });
    },
    /*
     *功能：无数据时初始化添加操作
     *参数：无
     */
    ndc:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().next().next();
            var that=resourcedetailController;
            $(this).parent().parent().removeClass("updatedata");
            $(this).text("取消");
            $(this).attr("title","取消");
            par.find("input[type='text'],textarea").not("input.mselect").not("input.hasDatepicker").removeAttr("readonly");
            par.find("img.ui-datepicker-trigger").css("display","inline-block");
            par.find(".hidden").not("#adr_reg").not("#adr_community").removeClass("hidden");
            par.find("span.txtinfo,div.csouce,span.pv_de,span.city_de,span.ar_de,span.cun,div.adr_deail1,span.short_brief,div.all_cnt").addClass("hidden");
            par.removeClass("hidden");
            par.next().removeClass("hidden");
            that.ndd(this);
            that.h(this);
        });
    },
     /*
     *功能：无数据时初始化取消添加操作
     *参数：无
     */
     ndd:function(obj){
       $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().next().next();
            var that=resourcedetailController;
            $(this).text("添加");
            $(this).attr("title","添加");
            $(this).parent().parent().addClass("updatedata");
            par.find(".red_border").removeClass("red_border");
            par.find("div.result,div.tip,div.error").remove();
            par.find("input[type='text'],textarea").not("input[class='mselect']").not("input[class='hasDatepicker']").attr("readonly","true");
            par.find("select,span.txthid,input[type='radio']").addClass("hidden");
            par.find("span.txtinfo,div.csouce,span.pv_de,span.city_de,span.ar_de,span.cun,div.adr_deail1").removeClass("hidden");
            par.next().addClass("hidden");
            par.find("textarea.cin").addClass("hidden");
            par.find("img.ui-datepicker-trigger").css("display","none");
            par.addClass("hidden");
            that.ndc(this);
            that.h(this);
        });  
    },
    /*
    *修改人才页面
    *参数：
    *id对话框父元素id
    *ajax成功后回调
    *parms获取参数对象
    */
    v:function(){                   
        var prams=resourcedetailController.va;            
        $("a.edt_p").GetManageData(prams);
    },
    /*
    *
    *添加|修改人才页面,请求参数获取
    *参数:me当前事件对象
    *返回prams对象
    */
    va:function(me){        
        var that= resourcedetailRender;                
        var status_id;
        var cate_id;
        var pro_id;
        var notes;                
        var h_e_id;        
        var url,urlops={
            'uphuman':CRMURL.UpHumanStatus,
            'upenter':CRMURL.UpEnterStatus,
            'addhuman':CRMURL.AddHumanStatus,
            'addenter':CRMURL.AddEnterStatus
        };        
        var hinfo;
        var prams={};
        var h_e='true';        
        var rectype=me.hasClass('ad_rd');        //rectype:1表示添加数据    
        hinfo=$("#bheader").next().children("div.base_info").children().first();          
        if(hinfo.attr("rel")=='false')
            h_e='false';
        if(me.hasClass("edt_p")){
            status_id=me.attr("rel")*1;                                          
            h_e_id=hinfo.val();  
            if(!hinfo.length)
                hinfo=$("#bheader").next().children("div.base_info").children("input[name='eid']");            
            var pubpram={
                'tosever':{
                    'cate_id':cate_id,
                    'pro_id':pro_id,
                    'notes':notes                
                },                                
                'id':'editCard',
                'rectype':rectype,
                'hore':h_e,
                'me':me,
                'sc':that.ds             
            };            
            if(h_e=='true'){//人才
                if(rectype){
                    url=urlops.addhuman;//人才添加记录                   
                    prams={                    
                        'human_id':h_e_id,
                        'url':url
                    };
                }
                else{ //人才修改
                    var rd=me.parent().parent().parent();
                    cate_id=rd.prev().children().first().attr("val")*1;
                    pro_id=rd.prev().children().last().attr("val")*1;                    
                    url=urlops.uphuman;
                    notes=me.parent().prev().text();   
                    pubpram.tosever={
                        'cate_id':cate_id,
                        'pro_id':pro_id,
                        'notes':notes
                    }
                    prams={                    
                        'human_id':h_e_id,
                        'status_id':status_id,
                        'url':url
                    };
                }
            }
            else if(h_e=='false'){//企业                              
                if(rectype){//企业添加
                    url=urlops.addenter;
                    prams={                   
                        'enter_id':h_e_id,
                        'url':url                    
                    }; 
                }else{//企业修改
                    var crd=me.parent().parent().parent();
                    cate_id=crd.prev().children().first().attr("val")*1;
                    pro_id=crd.prev().children().last().attr("val")*1;
                    notes=me.parent().prev().text();   
                    url=urlops.upenter; 
                    pubpram.tosever={
                        'cate_id':cate_id,
                        'pro_id':pro_id,
                        'notes':notes
                    }
                    prams={                  
                        'enter_id':h_e_id,
                        'status_id':status_id,
                        'url':url
                    };
                }
            }            
            $.extend(pubpram.tosever,prams);                                                                                                                                                       
            return pubpram;  
        }
    },
    /*
    * 功能：锚点定位
    * 参数：无
    */
    mdn:function(){
        $("#r_sd li").click(function(){
            var index=$(this).index();
            var ps=$("div.layout1_nl div.mtitle:eq("+index+")");
            $("html,body").animate({
                scrollTop:ps.offset().top-80
            },500);
        });
    },
    /*******************************修改人才资源********************************************/
    /****************人才基本信息区域****************/
    /*
    *功能：保存修改后的人才基本资料详细
    *参数：无
    */
    de:function(){
        $("#onenext").unbind("click").bind("click",function(){
           $("div").data("bid","#onenext");
            var ids="#uname";
            $(ids).trigger("focus").trigger("blur");
            if($("div.base_info div.area_basic").find("div.tip").length==0){
                var a=$("#h_id").val(),//人才ID
                b=$("#uname").val(),//姓名
                c=$("div.area_basic table.tb_cm input[name='sex']:checked").val(),//性别
                d=$("#custom_surce").val(),
                e=$("#date").val(),//生日
                f=$("#card_type").val(),//证件类型
                //                f="0",//证件类型
                g=$("#id_number").val(),//证件号
                h=$("#phone").val(),//电话
                i=$("#fix_phone").val(),//座机
                j=$("#uemail").val(),//邮箱
                k=$("#uqq").val(),//QQ
                l=$("#fax").val(),//传真
                m=$("#post_number").val(),//邮编
                n=$("#adr_pro").val(),//省
                o=$("#adr_city").val(),//城市
                p=$("#adr_reg").val(),//区
                q=$("#adr_community").val(),//镇
                r=$("#street").val(),
                s=$(this).attr("aid");//街
                n=(n==null?0:n);
                o=(o==null?0:o);
                p=(p==null?0:p);
                q=(q==null?0:q);
                var that=resourcedetailRender;
                var rs=new Resource();
                rs.TUpdateBase(a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, that.aa, that.tb);
            }
        });
    },
    /****************证书情况区域*********************/
    /* 添加和修改公用
    * 功能：资质证书初始化修改
    * 参数：无
    */
    df:function(){
        $("#qalertitem").unbind("click").bind("click",function(){
            var par=$(this).parent().next().next();
            var that=resourcedetailController;
            $(this).text("取消");
            $(this).attr("title","取消");
            par.parent().removeClass("updatedata");
            par.next().removeClass("hidden");
            that.dg();
            that.h($(this).parent().next().next());
            par.find("input[type='text'],textarea").not("input.mselect ").attr("readonly",false);
            par.find("input[type='text'][class*='mselect']").css("cursor","pointer");
            var qpar=$("#myquals");
            var del=qpar.find("a.delqual");
            var apar=qpar.find("a.addqual");
            var add=apar.eq(apar.length-1);
            if(qpar.find("div.qualitem").length>1){
                del.fadeIn(100);
            }else if(qpar.find("div.qualitem").length=="0"){
                qpar.find("input.qual_select").fadeIn();
            }
            add.fadeIn(100);
            that.h(this);
            that.dh("#myquals a.delqual");
            that.di("#myquals a.addqual");
        });
    },
    /*
     * 功能：资质证书情况取消按钮事件绑定
     * 参数：
     * 无
     */
    dg:function(){
        $("#qalertitem").unbind("click").bind("click",function(){
            var par=$(this).parent().next().next();
            var that=resourcedetailController;
            par.find("input[type='text'],textarea").attr("readonly",true);
            par.find("input[type='text'][class*='mselect']").css("cursor","inherit");
            par.find("div.tip,div.result").remove();
            $(this).text("修改");
            $(this).attr("title","修改");
            par.parent().addClass("updatedata");
            par.next().addClass("hidden");
            that.df();
            var qpar=$("#myquals");
            var del=qpar.find("a.delqual");
            var apar=qpar.find("a.addqual");
            var add=apar.eq(apar.length-1);
            var qual=par.find("#tqual");
            del.fadeOut(100);
            add.fadeOut(100);
            qual.fadeOut(100);
            that.h(this);
            qpar.find("a.blue").fadeOut(100);
        });
    },
    /*
     * 功能：资质证书 删除
     * 参数：
     * obj：当前绑定a标签
     */
    dh:function(obj){
        $(obj).unbind("click").bind("click",function(){
            $("div").data("obj",$(this));
            var par=$(this).parent().parent().find("div.qualitem");
            var len=par.length;
            if(len==2){
                par.eq(0).find("a.delqual").fadeOut(200);
            }
            var a="";
            var that=resourcedetailRender;
            var ele=$(this).attr("cid");
            var rs=new Resource();
            if(typeof(ele)=='undefined'){
                a=$(this).parent().find("input[name='certificate_id']").val();
                $("#myquals").data("cid",a);
                rs.TaDeOwnResource(a, that.ac, that.tb);
            }else{
                a=$(this).attr("cid");
                $("#myquals").data("cid",a);
               rs.TDeleQual(a, that.ac, that.tb);
            }
        });
    },
    /*
     * 功能：资质证书 添加
     * 参数：
     * obj：当前绑定a标签
     */
    di:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$("#myquals");
            var qual=par.find("#tqual");
            var cancel=par.find("#cancelqual");
            qual.fadeIn(200);
            cancel.fadeIn(200);
            $(this).fadeOut(100);
            var that=resourcedetailController;
            that.dj();
            that.dk();
        });
    },
    /*
     * 功能：资质证书 保存添加
     * 参数：
     * 无
     */
    dj:function(){
        $("a#savequal").unbind("click").bind("click",function(){
            $("div").data("bd","#savequal");
            var par=$("#tqual");
            var a="",
            b=$("#h_id").val(),
            c=par.data("rid"),
            d=par.data("pid");
            var mid=par.data("mid");
            var zid=par.data("zid");
            if(!!mid){
                a=mid;
            }
            else if(!!zid){
                a=zid;
            }
            var that=resourcedetailRender;
            var rs=new Resource();
            rs.TAddQual(a, b, c, d, that.tc, that.tb);
        });
    },
    /*
     * 功能：资质证书 取消添加
     * 参数：
     * 无
     */
    dk:function(){
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
     * 功能：保存修改后证书情况信息
     * 参数：无
     */
    dl:function(){
        $("#qualisv").bind("click",function(){
            $("div").data("bid","#qualisv");            
            if($("#savequal").css("display")=="none"){
                var a=$("#h_id").val(),
                b=$("#tjtitle").attr("cid"),
                c=$("#tjtitle").attr("gra"),
                d=$("#card_type").val(),
                e=$("#onenext").attr("aid"),
                f=$("#hprice").val();
                var that=resourcedetailRender;
                var rs=new Resource();
                rs.TUpdateTitle(a, b, c, d, e,f,that.ta,that.tb)
            }else{
                alert(LANGUAGE.L0238);
                return false;
            }
        });
    },
    /**************开户行区域*************/
    /*
     * 功能：保存修改后的开户行信息
     * 参数：无
     */
    dm:function(){
        $("#sv_bk").bind("click",function(){
            $("#acount_name,#bank_name,#acount_nm").trigger("focus");
            $("#acount_name,#bank_name,#acount_nm").trigger("blur");
            if($("div.area_bank div.error").length=="0"){
                var a=$("#h_id").val(),
                b=$(this).attr("bid"),
                c=$("#bank_name").val(),
                d=$("#acount_nm").val(),
                e=$("#acount_name").val();
                $("div").data("bid","#sv_bk");
                var that=resourcedetailRender;
                var rs=new Resource();
                rs.TUpdateBank(a, b, c, d, e, that.aa, that.tb);
            }
        });
    },
    /***************注册企业区域**********/
    /*
     * 功能：保存修改后的注册企业信息
     * 参数：无
     */
    dn:function(){
        $("#enter_sv").bind("click",function(){
          $("#recname").trigger("focus").trigger("blur");
          if($("div.base_info div.area_recmpy").find("div.tip").length==0){
                var a=$("#h_id").val(),
                b=$("#pay_date").val(),
                c=$("#pay_meth").val(),
                d=$("#end_date").val(),
                e=$("#agreement").val(),
                f=$("#sign_date").val(),
                g=$("#salry").val(),
                h=$("#person").val(),
                i=$("#cstreet").val(),
                j=$("#recname").val(),
                k=$("#card_type").val(),
                l=$("#onenext").attr("aid");
                $("div").data("bid","#enter_sv");
                var that=resourcedetailRender;
                var rs=new Resource();
                rs.TUpdateEmploy(a, b, c, d, e, f, g, h, i, j, k, l, that.aa, that.tb);
          }
        });
    },
    /***************人才备注区域**********/
    /*
     * 功能：保存修改后的备注信息
     * 参数：无
     */
    dp:function(){
        $("#sv_bak").bind("click",function(){
            var a=$("#h_id").val().replace(new RegExp(" ","g"),""),
            b=$("#bkup").val(),
            c=$("#card_type").val(),
            d=$("#onenext").attr("aid");
            $("div").data("bid","#sv_bak");
            var that=resourcedetailRender;
            var rs=new Resource();
            rs.TUpdateRemark(a, b, c, d, that.aa, that.tb);
        });
    },
    /*******************************修改企业资源********************************************/
    /*
    * 功能：更新的企业基本信息
    * 参数：无
    * @auth jack
    */
    ca:function(){
        $("#save_cbasic").bind("click",function(){
            var that=resourcedetailRender;
            if($("div.cbasic div.tip.error").length<=0){
                $("div").data("bid","#save_cbasic");
                var p={
                    enter_id:$("#ename").attr("eid"),
                    name:$("#ename").val(),
                    source_id:$("#custom_surce")[0].options[$("#custom_surce")[0].selectedIndex].value,
                    type_id:$("#cnature")[0].options[$("#cnature")[0].selectedIndex].value,
                    found_time:$("#fd_date").val(),
                    site:$("#website").val(),
                    brief:$("#ect").val()
                }
                var res=new Resource();
                res.UpdateEnterpriseBasic(p,that.aa,that.ab);
            }
        });  
    },
    /*
     *功能：绑定查看全部事件
     *参数：无
     *@author：Jack
     */
    ca_k:function(){
        var that=resourcedetailController;
      $("a.fold").unbind("click").bind("click",function(){
         $(this).parent().addClass("hidden");
         $(this).parent().next().removeClass("hidden");
         that.ca_f();
      });
    },
    /*
     *功能：收起全部事件绑定
     *参数：无
     */
    ca_f:function(){
        var that=resourcedetailController;
      $("a.unfold").unbind("click").bind("click",function(){
         $(this).parent().addClass("hidden");
         $(this).parent().prev().removeClass("hidden");
         that.ca_f();
      });
    },
    /******************企业资质区域******************/
    /*
    * 功能：企业资质初始化修改
    * 参数：无
    */
    cb:function(){
        $("#cqual").unbind("click").bind("click",function(){
            var par=$(this).parent().next().next();
            var that=resourcedetailController;
            $(this).text("取消");
            par.parent().removeClass("updatedata");
            par.next().removeClass("hidden");
            that.cc();
            var qpar=$("#myquals");
            var del=qpar.find("a.delcq");
            var apar=qpar.find("a.addcq");
            var upcq=qpar.find("a.updecq ");
            var add=apar.eq(apar.length-1);
            if(qpar.find("div.qualitem").length>1){
                del.fadeIn(100);
            }else if(qpar.find("div.qualitem").length==0){
                qpar.find("input.cert_box").fadeIn();
                qpar.find("a.blue").fadeIn();
                that.cf();
                that.cg();
            }
            add.fadeIn(100);
            upcq.fadeIn();
            that.ck($(this).parent().next().next());
            that.cd("#myquals a.delcq");
            that.ce("#myquals a.addcq");
        });
    },
    /*
     * 功能：资质证书情况取消按钮事件绑定
     * 参数：
     * 无
     */
    cc:function(){
        $("#cqual").unbind("click").bind("click",function(){
            var par=$(this).parent().next().next();
            var pqbox=par.find("input.cqbox");
            var pqitem=par.find("div.qualitem");
            var sqv=par.find("a.cmon");
            var up=par.find("a.updecq");
            $.each(up,function(i,o){
                if($(o).text()=="取消"){
                    $(o).text("修改");
                    resourcedetailController.ch($(o));
                }  
            });
            $.each(sqv,function(i,o){
                if(!$(o).hasClass("hidden")){
                    $(this).addClass("hidden");
                }  
            });
            $.each(pqitem,function(i,o){
                if(!$(o).hasClass("upsats")){
                    $(this).addClass("upsats");
                } 
            });
            $.each(pqbox,function(i,o){
                if($(o).attr("readonly",false)){
                    $(this).attr("readonly",true);
                } 
            });
            var that=resourcedetailController;
            par.find("div.tip,div.result").remove();
            $(this).text("修改");
            par.parent().addClass("updatedata");
            par.next().addClass("hidden");
            that.cb();
            var qpar=$("#myquals");
            var del=qpar.find("a.delcq");
            var apar=qpar.find("a.addcq");
            var upcq=qpar.find("a.updecq ");
            var add=apar.eq(apar.length-1);
            var qual=par.find("#enter_cqual");
            del.fadeOut(100);
            add.fadeOut(100);
            upcq.fadeOut(100);
            qual.fadeOut(100);
            that.ck($(this).parent().next().next());
            qpar.find("a.blue").fadeOut(100);
        });
    },
    /*
     * 功能：资质证书 删除
     * 参数：
     * obj：当前绑定a标签
     */
    cd:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().parent().find("div.qualitem");
            var len=par.length;
            if(len==2){
                par.eq(0).find("a.delcq").fadeOut(200);
            }
            var b=$(this).attr("rel");
            var name=$(this).parent().find("span").text();
            $("#myquals").data("cid",b);
            var that=resourcedetailRender;
            var res=new Resource();
            res.DeleEnterpriseQuali(b,name,that.ca,that.cb);
       
        });
    },
    /*
     * 功能：资质证书 添加
     * 参数：
     * obj：当前绑定a标签
     */
    ce:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$("#myquals");
            var qual=par.find("#enter_cqual");
            var cancel=par.find("#cancle_cqual");
            var sv=par.find("#sv_cq");
            qual.fadeIn(200);
            cancel.fadeIn(200);
            sv.fadeIn(200);
            $(this).fadeOut(100);
            var that=resourcedetailController;
            that.cf();
            that.cg();
        });
    },
    /*
     * 功能：资质证书 保存添加
     * 参数：
     * 无
     */
    cf:function(){
        $("a#sv_cq").unbind("click").bind("click",function(){
            $("div").data("bd","#sv_cq");
            var qual=$("#enter_cqual");
            var cqv=$("#enter_cqual").val();
            var that=resourcedetailRender;
            var enter=$("input[name='eid']").val();
            if(cqv==""){
               alert(LANGUAGE.L0237);
               return false;
            }else{
                that.cd(qual.val());
                var re=new Resource();
                re.DoAddEnterQuali(enter,cqv,that.cc,that.cb);
            }
        });
    },
    /*
     * 功能：资质证书 取消添加
     * 参数：
     * 无
     */
    cg:function(){
        $("a#cancle_cqual").unbind("click").bind("click",function(){
            var lm=$(this).parent().find("div.qualitem").length;
            if(lm=="0"){
               $("#cqual").trigger("click");
            }else{
                var blue=$(this).parent().find("a.blue");
                var qual=$("#enter_cqual");
                var add=qual.prev().find("a.addcq");
                blue.fadeOut(100);
                qual.fadeOut(100);
                add.fadeIn(100);
                qual.val("");
            }
        });
    },
    /*
    * 功能：单条数据企业资质初始化修改
    * 参数：无
    */
    ch:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent();
            var that=resourcedetailController;
            $(this).text("取消");
            that.ci(this);
            par.removeClass("upsats");
            par.find("input").attr("readonly",false);
            var apar=par.find("a.cmon");
            apar.removeClass("hidden");
            that.ck($(this).parents("table.tb_cm"));
            that.cj("a.sqv");
        });
    },
    /*
     * 功能：资质证书情况取消按钮事件绑定
     * 参数：
     * 无
     */
    ci:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent();
            var that=resourcedetailController;
            $(this).text("修改");
            that.ch(this);
            par.addClass("upsats");
            par.find("input").attr("readonly",true);
            var apar=par.find("a.cmon");
            apar.addClass("hidden");
            that.ck($(this).parents("table.tb_cm"));
        });
    },
    /*
     * 功能:更新单条数据事件绑定
     * 参数：无
     */
    cj:function(obj){
        $(obj).unbind("click").bind("click",function(){
            $("div").data("bd",this);
            var qual=$(this).parent().find("input.cqbox").val();
            var that=resourcedetailRender;
            var enter=$(this).parents("div.qualitem").find("a.updecq").attr("rel");
            if(qual==""){
                return false;
            }else{
                var re=new Resource();
                re.DoupEnterrequali(enter,qual,that.ce,that.cb);
            }
        }); 
    },
    /*
    * 功能：初始化数据
    * 参数：无
    */
    ck:function(obj){
        var par=$(obj);
        var txt=par.find("input[type='text']");//文本框
        $.each(txt,function(i,o){
            var that=$(o);
            that.val(that.data("curdata"));
        });
    },
    /*
    * 功能：保存初始数据
    * 参数：无
    */
    cl:function(obj){
        obj=$(obj);
        var txt=obj.find("input[type='text']");//文本框
        $.each(txt,function(i,o){
            $(o).data("curdata",$(o).val());
        });
    },
    /*
    * 联系人区域
    * 功能：加载省市区镇公用方法
    * 参数：ID
    */
    cm:function(){
        $("#adr_pro").change(function(){
            $("div").data("bd","#adr_pro");
            var ids=$("#adr_pro")[0].options[$("#adr_pro")[0].selectedIndex].value;
            var level=$(this).attr("level");
            var that=resourcedetailRender;
            var res=new Resource();
            res.GetAreaLis(ids,level,that.cf,that.cg);
        });
        $("#adr_city").change(function(){
            $("div").data("bd","#adr_city");
            var ids=$("#adr_city")[0].options[$("#adr_city")[0].selectedIndex].value;
            var level=$(this).attr("level");
            var that=resourcedetailRender;
            var res=new Resource();
            res.GetAreaLis(ids,level,that.ch,that.tcg);
        });
        $("#adr_reg").change(function(){
            $("div").data("bd","#adr_reg");
            var ids=$("#adr_reg")[0].options[$("#adr_reg")[0].selectedIndex].value;
            var level=$(this).attr("level");
            var that=resourcedetailRender;
            var res=new Resource();
            res.GetAreaLis(ids,level,that.ci,that.cj);
        });
    },
    /*
    * 功能：保存企联系人信息
    * 参数：无
    */
    cn:function(){
        $("#save_contacter").bind("click",function(){
            $("div").data("bid","#save_contacter");
            if($("div.contacter div.tip.error").length=="0"){
                var s=$("#adr_community");
                var adr="";//镇
                var apro=$("#adr_pro").val();//省
                var cty=$("#adr_city").val();//市
                var zone=$("#adr_reg").val();//区
                if(s.hasClass("hidden")){
                    adr='0';
                }else{
                    adr=$("#adr_community").val();
                    adr=(adr==null?0:adr);
                }
                apro=(apro==null?0:apro);
                cty=(cty==null?0:cty);
                zone=(zone==null?0:zone);
                var p={
                    enter_id:$("input[name='eid']").val(),
                    name:$("#contacter").val(),
                    mobile:$("#phone").val(),
                    email:$("#uemail").val(),
                    phone:$("#fix_phone").val(),
                    qq:$("#uqq").val(),
                    fax:$("#fax").val(),
                    zipcode:$("#post_number").val(),
                    province_id:apro,
                    city_id:cty,
                    region_id:zone,
                    community_id:adr,
                    address:$("#street").val()
                };
                var that=resourcedetailRender;
                var res=new Resource();
                res.DoUpContacter(p,that.aa,that.ab);
            }
        });
    },   
    /*
    * 企业需求区域
    * 功能：初始化企业修改区域操作
    * 参数：无
    */
    co:function(){
        $("#require_edit").unbind("click").bind("click",function(){
            var par=$(this).parent().parent();
            var that=resourcedetailController;
            $(this).text("取消");
            that.cp();
            that.h(this);
            var del=par.find("a.delequire");
            var addlen=par.find("a.addquire");
            var adq=addlen.eq(addlen.length-1);
            var upq=par.find("a.upquire");
            var dql=par.find("div.quire_item");
            if(dql.length>1){
                del.fadeIn(100);
            }else if(dql.length=="0"){
                par.find("#adn_quire").removeClass("hidden");
                par.find("div.b_next").removeClass("hidden");
            }
            adq.fadeIn(100);
            upq.fadeIn(100);
            that.cq("a.delequire");
            that.cr("a.upquire");
            that.cu("a.addquire");
        }); 
    },
    /*
    * 企业需求区域
    * 功能：初始化企业取消修改操作
    * 参数：无
    */
    cp:function(){
        $("#require_edit").unbind("click").bind("click",function(){
            var par=$(this).parent().parent();
            var that=resourcedetailController;
            var qpit=$(this).parent().next().next().find("div.quire_item");
            if(qpit.length=="0"){
                $(this).text("添加");
            }else{
                $(this).text("修改");
            }
            that.co();
            var del=par.find("a.delequire");
            var addlen=par.find("a.addquire");
            var adq=addlen.eq(addlen.length-1);
            var upq=par.find("a.upquire");
            if(par.find("div.quire_item").length>1){
                del.fadeOut(100);
            }
            var bl=qpit.find("a.blue");
            $.each(qpit,function(i,o){
                if(!$(o).hasClass("updatedata")){
                    $(o).find("a.upquire").text("").text("修改").trigger("click");
                    $(o).addClass("updatedata");  
                }
            });
            that.h(this);
            qpit.find("select").addClass("hidden");
            qpit.find("select").prev().removeClass("hidden");
            qpit.find("input[type='text'],textarea").attr("readonly",true).blur();
            if(!par.find("#adn_quire").hasClass("hidden")){
                par.find("#adn_quire").addClass("hidden");
                par.find("div.b_next").addClass("hidden");
                qpit.find("a.addquire").text("").text("添加");
            }
            bl.fadeOut(100);
            adq.fadeOut(100);
            upq.fadeOut(100);
        }); 
    },
    /*
    * 功能：绑定删除企业单条需求
    * 参数：无
    */
    cq:function(obj){
        $(obj).unbind("click").bind("click",function(){
            $("div").data("bn",$(this));
            var par=$(this).parent().parent().parent().find("div.quire_item");
            var len=par.length;
            if(len==2){
                par.eq(0).find("a.delequire").fadeOut(200);
            }
            var b=$(this).attr("rel");
            var that=resourcedetailRender;
            var res=new Resource();
            res.DeleEnterPriseRequire(b,that.ck,that.cl);
        });  
    },
    /*
    * 功能：绑定更新企业单条需求
    * 参数：无
    */
    cr:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().prev();
            var ctp=par.find(".requalis");
            var sv_cet=$(this).parent().find("a.svquire ");
            var that=resourcedetailController;
            $(this).text("取消");
            sv_cet.fadeIn();
            that.cs(this);
            that.ct("a.svquire");
            that.gb($(this).parent().prev());
            $(this).parent().parent().removeClass("updatedata");
            par.find("input[type='text'],textarea").not('input.mselect').removeAttr("readonly");
            par.find(".hidden").removeClass("hidden");
            par.find("span.txtinfo,div.csouce,div.adr_deail1").addClass("hidden");
        });  
    },
    /*
    * 功能：取消修改企业单条数据操作
    * 参数：无
    */
    cs:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().prev();
            var ctp=par.find(".requalis");
            var up_rct=ctp.find("a.up_hcert ");
            var sv_cet=$(this).parent().find("a.svquire");
            up_rct.fadeOut(100);
            sv_cet.fadeOut();
            var that=resourcedetailController;
            var qpit=$(this).parent().parent();
            var rd=qpit.find("input[type='radio']")
            rd.removeAttr("checked").addClass("hidden");
            $(this).text("修改");
            that.cr(this);
            that.gb($(this).parent().prev());
            $(this).parent().parent().addClass("updatedata");
            par.find("input[type='text'],textarea").not('input.mselect').attr("readonly",true);
            par.find("select,span.txthid,input[type='radio'],textarea.cin").addClass("hidden");
            par.find("span.txtinfo,div.csouce,div.adr_deail1").removeClass("hidden");
        });  
    },
    /*
    *功能：更新单条企业需求数据
    *参数：无
    */
    ct:function(obj){
        $(obj).unbind("click").bind("click",function(){
            $("div").data("bid",this);
            var _el=$(this).parent().prev();
            var enid=$("input[name='eid']").val();
            var did=$(this).attr("rel");
            var fl=_el.find("input.fl_tm:checked").val();
            var apt_id=_el.find("input[name='rct']").val();
            var redid=_el.find("input[name='regct']").val();
            var nbm=_el.find("input[name='nbm']").val();
            var fee=_el.find("input.fees").val();
            var sfee=_el.find("input.sfee").val();
            var year=_el.find("input.years").val();
            var is_tx=_el.find("input.tax:checked").val();
            var ob=_el.find("select.usage")[0];
            var use=ob.options[ob.selectedIndex].value;
            var mk=_el.find("textarea.cin").val();
            var that=resourcedetailRender;
            var p={
                enter_id:enid,
                demand_id:did,
                apt_id:apt_id,
                reg_info:redid,
                need_price:fee,
                need_year:year,
                need_num:nbm,
                is_fulltime:fl,
                service_charge:sfee,
                demand_is_tax:is_tx,
                use:use,//用途
                demand_notes:mk//需求备注
            }
            var res=new Resource();
            res.UpComRequire(p,that.cl,that.ab);
        });
    },
    /*
     *功能：初始化添加企业需求事件
     *参数：无
     */
    cu:function(obj){
       $(obj).unbind("click").bind("click",function(){
           var par=$(this).parent().parent().parent();
           var that=resourcedetailController;
           $(this).text("取消");
           that.cv(this);
           that.gb($(this).parent().parent().parent().find("#adn_quire"));
           par.find("#adn_quire").removeClass("hidden");
           par.find("div.b_next").removeClass("hidden");
        });
    },
    /*
     *功能：取消添加企业需求事件
     *参数：无
     */
    cv:function(obj){
        $(obj).unbind("click").bind("click",function(){
                var par=$(this).parent().parent().parent();
                var that=resourcedetailController;
                $(this).text("添加");
                that.cu(this);
                that.gb($(this).parent().parent().parent().find("#adn_quire"));
                par.find("#adn_quire").addClass("hidden");
                par.find("div.b_next").addClass("hidden");
                });
    },
    /*
     *功能：保存添加的企业需求
     *参数：无
     */
    cw:function(){
        $("#save_require").bind("click",function(){
            $("div").data("bid","#save_require");
            var _ele=$(this).parent().parent().prev();
            var fl=_ele.find("input[name='is_ful']:checked").val();
            var enid=$("input[name='eid']").val();
            var apt_id=_ele.find("input[name='rct']").val();
            var redid=_ele.find("input[name='regct']").val();
            var nbm=_ele.find("input[name='nbm']").val();
            var fee=_ele.find("#tohir_fee").val();
            var sfee=_ele.find("#sevr_fee").val();
            var year=_ele.find("#unit").val();
            var is_tx=_ele.find("input[name='tax']:checked").val();
            var ob=_ele.find("#usage")[0];
            var use=ob.options[ob.selectedIndex].value;
            var mk=_ele.find("textarea.cin").val();
            var that=resourcedetailRender;
            var p={
                enter_id:enid,
                apt_id:apt_id,
                reg_info:redid,
                need_price:fee,
                need_year:year,
                need_num:nbm,
                is_fulltime:fl,
                service_charge:sfee,
                demand_is_tax:is_tx,
                use:use,//用途
                demand_notes:mk//需求备注
            }
            var xlen=$(this).parent().parent().parent().find("div.quire_item").length;
            var tx_txt=$("input[name='tax']:checked").next().text();
            var ug_txt=$("#usage")[0].options[$("#usage")[0].selectedIndex].text;
            var ful_txt=$("input[name='is_ful']:checked").next().text();
            that.co(p,$("#carea_ct").val(),xlen,tx_txt,ug_txt,ful_txt);
            var res=new Resource();
            res.addEnterRequire(p,that.cn,that.cb);
        });
    },
    /*
     *注册人才区域
     *功能：初始化修改企业注册人才操作
     *参数：无
     */
    cx:function(){
      $("#repn_edit").unbind("click").bind("click",function(){
           var par=$(this).parent().parent();
            var that=resourcedetailController;
            $(this).text("取消");
            that.cy();
            that.h(this);
            var del=par.find("a.dele_regp");
            var addlen=par.find("a.add_regp");
            var adq=addlen.eq(addlen.length-1);
            var upq=par.find("a.up_regp");
            if(par.find("div.reg_lisitem").length>1){
                del.fadeIn(100);
            }else if(par.find("div.reg_lisitem").length=="0"){
              par.find("#reg_fm").removeClass("hidden");
              par.find("div.b_next").removeClass("hidden");
            }
            that.btn("input[name='refund']");
            adq.fadeIn(100);
            upq.fadeIn(100);
            that.cz("a.add_regp");//初始化添加
            that.ec("a.up_regp");//初始化修改
            that.ef("a.dele_regp");//初始化删除
      }); 
    },
    /*
     *注册人才区域
     *功能：初始化取消修改企业注册人才操作
     *参数：无
     */
    cy:function(){
      $("#repn_edit").unbind("click").bind("click",function(){
          var par=$(this).parent().parent();
            var that=resourcedetailController;
            if(par.find("div.reg_lisitem").length=="0"){
                $(this).text("添加");
            }else{
                $(this).text("修改");
            }
            that.cx();
            that.h(this);
            var del=par.find("a.dele_regp");
            var addlen=par.find("a.add_regp");
            var sv=par.find("a.svretan");
            var adq=addlen.eq(addlen.length-1);
            var upq=par.find("a.up_regp");
            if(par.find("div.reg_lisitem").length>1){
                del.fadeOut(100);
            }
            else if(!par.find("div.reg_lisitem").hasClass("updatedata")){
                par.find("div.reg_lisitem").addClass("updatedata");
            }
            var qpit=$(this).parent().next().next().find("div.reg_lisitem");
            var bl=qpit.find("a.blue");
            $.each(qpit,function(i,o){
                if(!$(o).hasClass("updatedata")){
                    $(o).addClass("updatedata");  
                }
            });
            if(qpit.length=="0"){
                var cv=$("input[name='refund']:checked").val();
                if(cv=="1"){
                   $("#reg_fm").find("tr.apd").removeClass("hidden"); 
                }else{
                    $("#reg_fm").find("tr.apd").addClass("hidden"); 
                }
            }
            $("a.up_regp").text("").text("修改");
            that.h(this);
            var rd=$(this).parent().next().next().find("input[type='radio'][name!='csex'][name!='refund']");
            rd.removeAttr("checked").addClass("hidden");
            qpit.find("span.txthid").addClass("hidden");
            $(this).parent().next().next().find("input[type='radio'][name!='csex'][name!='refund']:even").prev().removeClass("hidden");
            qpit.find("select").addClass("hidden");
            qpit.find("select").prev().removeClass("hidden");
            qpit.find("input[type='text'],textarea").attr("readonly",true).blur();
            if(!par.find("#reg_fm").hasClass("hidden")){
                par.find("#reg_fm").addClass("hidden");
                par.find("div.b_next").addClass("hidden");
                qpit.find("a.add_regp").text("").text("添加");
            }
            qpit.find("textarea.reson").addClass("hidden");
            qpit.find("div.adr_deail1").removeClass("hidden");
            adq.fadeOut(100);
            upq.fadeOut(100);
            sv.fadeOut(100);
      }); 
    },
    /*
     *功能：添加注册人才信息
     *参数：无
     */
    cz:function(obj){
      $(obj).unbind("click").bind("click",function(){
           var par=$(this).parent().parent().parent();
           var that=resourcedetailController;
           $(this).text("取消");
           that.ea(this);
           that.gb($(this).parent().parent().parent().find("#adn_quire"));
           par.find("#reg_fm").removeClass("hidden");
           par.find("div.b_next").removeClass("hidden");
      });
    },
     /*
     *功能：取消添加注册人才信息
     *参数：无
     */
    ea:function(obj){
        $(obj).unbind("click").bind("click",function(){
           var par=$(this).parent().parent().parent();
           var that=resourcedetailController;
           $(this).text("添加");
           that.cz(this);
           that.gb($(this).parent().parent().parent().find("#reg_fm"));
           par.find("#reg_fm").addClass("hidden");
           par.find("div.b_next").addClass("hidden");
      });
    },
     /*添加企业注册信息
    *功能：保存企业注册人才信息
    *参数：无
    */
   eb:function(){
     $("#save_regperon").unbind("click").bind("click",function(){
         var obj=$(this).parent().parent().prev();
         var eid=$("input[name='eid']").val();
         var nm=obj.find("#reg_name").val();
         var sex=obj.find("input[name='csex']:checked").val();
         var mony=obj.find("#hired_sary").val();
         var aid=obj.find("input[name='rct']").val();
         var rg=obj.find("input[name='regct']").val();
         var stm=obj.find("#sign_date").val();
         var ctime=obj.find("#contracter").val();
         var etime=obj.find("#end_date").val();
         var pme=obj.find("#pyment").val();
         var ptm=obj.find("#pay_date").val();
         var rtm="";
         var rmy="";
         var rsiger="";
         var rchger="";
         var rson="";
         var refud=obj.find("input[name='refund']:checked").val();
         if(refud=="1"){
             rtm=obj.find("#refund_date").val();
             rmy=obj.find("#refd_money").val();
             rsiger=obj.find("#signer").val();
             rchger=obj.find("#agenter").val();
             rson=obj.find("#reson").val();   
         }
         var p={ 
            enter_id:eid,
            name:nm,
            sex:sex,
            pay:mony,
            apt_id:aid,
            reg_info:rg,
            sign_time:stm,
            contract_period:ctime,
            expiration_time:etime,
            pay_way:pme,
            pay_time:ptm,
            is_refund:refud,
            refund_time:rtm,
            refund_money:rmy,
            refund_singor:rsiger,
            refund_signer:rchger,
            refund_reseaon:rson
         }
         var that=resourcedetailRender;
         var re=new Resource();
         re.AddNewRegPerson(p,that.cp,that.cb);
     });
   },
   /*
    *功能：初始化修改单条注册人才操作
    *参数：无
    */
   ec:function(obj){
     $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().prev();
            var vv=$(this).parent().parent().attr("name");
            var vvl=vv.substring(4);
            var tt=par.find("tr.apd");
            var tva=par.find("input[name='ref"+vvl+"']:checked").val();
            $("div").data("inval",tva);
            if(tt.length!="0"&&tva=="1"){
                tt.removeClass("hidden");
            }else{
              tt.addClass("hidden");  
            }
            var ctp=par.find(".regcert");
            var sv_cet=$(this).parent().find("a.svretan");
            var that=resourcedetailController;
            $(this).text("取消");
            that.btn("input.suc_y");
            sv_cet.fadeIn();
            that.ed(this);
            that.ee("a.svretan");
            that.gb($(this).parent().prev());
            $(this).parent().parent().removeClass("updatedata");
            par.find("input[type='text'],textarea").not('input.mselect').not("input.date").removeAttr("readonly");
            par.find(".hidden").not("tr.hidden").removeClass("hidden");
            par.find("span.txtinfo,div.csouce,div.adr_deail1").addClass("hidden");
        });    
   },
   /*
    *功能：初始化是否退款点击事件
    *参数：无
    */
   btn:function(obj){
       $(obj).unbind("click").bind("click",function(){
           var x="";
           var rel="";
           var pt=$(this).parents("div.reg_lisitem");
           if(pt.length!="0"){
            var id=pt.attr("name");
            var tm=TEMPLE.C_T007.replace("{ky}",id);
             x=$(this).parent().parent().parent().find("tr.apd");
             rel=$(this).val();
            if(x.length==0){
                $(this).parent().parent().parent().find("tr.apd").remove(); 
                    if(rel==1){
                        $(this).parent().parent().after(tm);
                        $("#"+id).datepicker({
                            showOn: "both",
                            buttonImage: THEMEROOT+'lib/jquery-datepicker/images/calendar-blue.gif',
                            buttonImageOnly: true,
                            yearRange:'1990:2050',
                            buttonText:'点击选择日期',
                            dateFormat: "yy-mm-dd",
                            changeMonth:true,
                            changeYear:true
                        });
                    }else{
                    x.find("input[type='text'],textarea").val("");
                    x.addClass("hidden");
                    }
            }else{
                if(rel==1){
                 x.removeClass("hidden");
                }else{
                    x.addClass("hidden");
                }
            }
           }else{
                x=$(this).parent().parent().parent().find("tr.apd");
                rel=$(this).val();  
                if(rel=="1"){
                    x.removeClass("hidden"); 
                }else{
                    x.addClass("hidden");
                }
           }
       });
   },
   /*
    *功能：取消修改单条注册人才数据操作
    *参数：无
   */
   ed:function(obj){
         $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().prev();
            var vv=$(this).parent().parent().attr("name");
            var vvl=vv.substring(4);
            var tt=par.find("tr.apd");
            var tva=par.find("input[name='ref"+vvl+"']:checked").val();
            if(tt.length!="0"&&$("div").data("inval")=="1"){
                tt.removeClass("hidden");
            }else{
              tt.addClass("hidden");  
            }
            var ctp=par.find(".regcert");
            var up_rct=ctp.find("a.up_regp ");
            var sv_cet=$(this).parent().find("a.svretan");
            up_rct.fadeOut(100);
            sv_cet.fadeOut();
            var that=resourcedetailController;
            var qpit=$(this).parent().parent();
            var rd=qpit.find("input[type='radio']")
            rd.removeAttr("checked").addClass("hidden");
            $(this).text("修改");
            that.ec(this);
            that.gb($(this).parent().prev());
            $(this).parent().parent().addClass("updatedata");
            par.find("input[type='text'],textarea").not('input.mselect').not("input.date").attr("readonly",true);
            par.find("select,span.txthid,input[type='radio'],textarea.cin").addClass("hidden");
            par.find("span.txtinfo,div.csouce,div.adr_deail1").removeClass("hidden");
        });  
  },
   /*
   *功能：保存更新企业注册人才信息
   *参数：无
   */
  ee:function(obj){
   $(obj).unbind("click").bind("click",function(){
            $("div").data("bid",this);
            var _el=$(this).parent().prev();;
            var rela=$(this).attr("rel");
            var nm=_el.find("input.reg_name").val();//名字
            var sex=_el.find("input[class='csex']:checked").val();//性别
            var mony=_el.find("input.hired_sary").val();
            var aid=_el.find("input[name='rct']").val();
            var rg=_el.find("input[name='regct']").val();
            var stm=_el.find("input.sign_date").val();
            var ctime=_el.find("input.contracter").val();
            var etime=_el.find("input.end_date").val();
            var pme=_el.find("input.pay").val();
            var ptm=_el.find("input.pay_date").val();
            var refud=_el.find("input[class='suc_y']:checked").val();
            var rtm="",
                rmy="",
                rsiger="",
                rchger="",
                rson="";
            if(refud=="1"){
                 rtm=_el.find("input.refund_date").val();
                 rmy=_el.find("input.refd_money").val();
                 rsiger=_el.find("input[class='signer']").val();
                 rchger=_el.find("input[class='agenter']").val();
                 rson=_el.find("textarea.reson").val();
            }
            var that=resourcedetailRender;
            var p={
                rc_id:rela,
                name:nm,
                sex:sex,
                pay:mony,
                apt_id:aid,
                reg_info:rg,
                sign_time:stm,
                contract_period:ctime,
                expiration_time:etime,
                pay_way:pme,
                pay_time:ptm,
                is_refund:refud,
                refund_time:rtm,
                refund_money:rmy,
                refund_singor:rsiger,
                refund_signer:rchger,
                refund_reseaon:rson

            }
            var res=new Resource();
            res.UpCompanyRetan(p,that.cq,that.ab);
     });
  },
    /*
    *功能：删除单条企业注册人才信息
    *参数：无
    */
    ef:function(obj){
        $(obj).unbind("click").bind("click",function(){
        $("div").data("bn",$(this));
        var par=$(this).parent().parent().parent().find("div.reg_lisitem ");
        var len=par.length;
        if(len==2){
            par.find("a.dele_regp").fadeOut(200);
        }
        var b=$(this).attr("rel");
        var that=resourcedetailRender;
        var res=new Resource();
        res.DeleComReTan(b,that.cr,that.cb);
    });  
    },
    /*
    *功能：多radio标签处理
    *参数：无
    */
    ga:function(obj){
        var rd=$(obj).find("input[type='radio']");
        rd.unbind("click").bind("click",function(){
            $(this).parent().find("input[type='radio']").attr("checked",false);
            if($(this).checked){
                $(this).attr("checked",false);
            } else{
                $(this).attr("checked",true);
            }
        });
    },
    /*
    *功能：初始化企业需求的页面初始数据
    *参数：无
    */
    gb:function(obj){
        var el=$(obj);
        resourcedetailController.ha(el);
    },
    /*
    *功能：初始化所有的(已有数据)资质证书选择框
    *参数：无
    */
    gd:function(obj){
        var pm=$(obj);
        $.each(pm,function(i,o){
            var num=$(o).attr("id").substring(5);
            var par=$(o);
            par.hgsSelect({
                id:"pqselect"+num,             //设置选择框父容器id
                cshow:true,                 //显示人数
                pshow:false,       //是否显示地区选择
                single:true,       //省是否为单选
                sure:resourcedetailRender.cm,
                qurl:CRMURL.GetCertsTpe,
                murl:CRMURL.GetGertMajor
            });
        });
    },
    /*
     *功能；初始化注册人数资质
     *参数: 无
     */
    gg:function(obj){
         var pm=$(obj);
        $.each(pm,function(i,o){
            var num=$(o).attr("id").substring(5);
            var par=$(o);
            par.hgsSelect({
                id:"pqselect"+num,             //设置选择框父容器id
                pshow:false,       //是否显示地区选择
                single:true,       //省是否为单选
                sure:resourcedetailRender.cs,
                qurl:CRMURL.GetCertsTpe,
                murl:CRMURL.GetGertMajor
            });
        }); 
    },
    /*
    *功能：初始化添加资质证书选择框
    *说明：企业需求和注册人才区域初始化
    *参数：无
    */
    ge:function(){
        /*企业注册人数无人数*/
         $("#regct").hgsSelect({
            id:"pqselect"+1,             //设置选择框父容器id
            pshow:false,       //是否显示地区选择
            single:true,       //省是否为单选
            sure:resourcedetailRender.cs,
            qurl:CRMURL.GetCertsTpe,
            murl:CRMURL.GetGertMajor
        }); 
        $("#carea_ct").hgsSelect({
            id:"pqselect",             //设置选择框父容器id
            cshow:true,                 //显示人数
            pshow:false,       //是否显示地区选择
            single:true,       //省是否为单选
            sure:resourcedetailRender.cm,
            qurl:CRMURL.GetCertsTpe,
            murl:CRMURL.GetGertMajor
        });  
    },
    /*
     *企业注册人区域
     *功能：初始化所有注册人的时间插件
     *参数：无
     */
    gf:function(obj){
       var pm=$(obj);
        $.each(pm,function(i,o){
            var num=$(o).attr("id").substring(5);
            var par=$(o);
            par.datepicker({
                showOn: "both",
                buttonImage: THEMEROOT+'lib/jquery-datepicker/images/calendar-blue.gif',
                buttonImageOnly: true,
                yearRange:'1990:2050',
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
        });
    },
    /***************企业备注区域**********/
    /*
     * 功能：保存修改后的备注信息
     * 参数：无
     */
    gp:function(){
        $("#csv_bak").bind("click",function(){
            var a=$("input[name='eid']").val(),
            b=$("#bkup").val();
            $("div").data("bid","#csv_bak");
            var that=resourcedetailRender;
            var rs=new Resource();
            rs.CUpdateRemark(a, b, that.aa, that.tb);
        });
    },     
    /*
     * 功能：人才详情文件上传
     * 参数：无
     */
    gq:function(){
        var upfile=$("div.mod_1.area_file").find("a.upfile");         
        var user_info=$("#bheader").next().children("div.base_info").children().first(); 
        var human_id=user_info.val();
        var att_name='未命名';        
        var identifier='123';        
           upfile.hmark({
                id:"upfile_hdetail",
                type:"5",
                retemp:{
                    url:CRMURL.Upfilehuman,
                    user_type:'human_id',
                    user_id:human_id,
                    att_name:att_name,
                    att_type_id:'att_type_id',
                    identifier:identifier,                    
                    formid:'upfile',
                    ftype:resourcedetailController.gr_a
                }       
            });
    },
     /*
     * 功能：企业详情文件上传
     * 参数：无
     */
    gr:function(){
        var upfile=$("div.mod_1.area_file").find("a.upfile");        
        var user_info=$("#bheader").next().children("div.base_info").children().first();
        var enter_id=user_info.val();
        var att_name='未命名';        
        var identifier='123';                       
            upfile.hmark({
                id:"upfile_cdetail",
                type:"5",
                retemp:{
                    url:CRMURL.UpfileCompany,
                    user_type:'enter_id',
                    user_id:enter_id,
                    att_name:att_name,
                    att_type_id:'att_type_id',
                    identifier:identifier,
                    formid:'upfile',
                    ftype:resourcedetailController.gr_a
                }                
            });
    },
    /*
     * 功能：详情页文件上传,文件类型获取
     * 参数：me当前事件发生按键
     */
    gr_a:function(me){
        return me.attr("rel")*1;
    },
     /*
     * 功能：详情页文件删除
     * 参数：无
     */
    gs:function(){
        var delbtn=$("div.area_file").children("table").find("a.dele_ct");        
        var url=CRMURL.DelCrmAtt;
        var att_id=null;
        var set={};
        var that=resourcedetailRender;
        var att_relation_id;
        delbtn.unbind().bind("click",function(){            
            var msg=confirm("是否要删除该文件?");
            att_relation_id=$(this).attr("rel")*1;
            if(msg==true){
                $("#b_id").data("obj",$(this).parent().parent());
                att_id=$(this).parent().prevAll("span.cd_name").attr("value")*1;            
                set={
                    url:url,
                    params:'att_id='+att_id+'&att_relation_id='+att_relation_id,
                    sucrender:that.th,
                    failrender:that.ti
                };
                HGS.Base.HAjax(set);
            }                            
        });
    },
    /*
     *功能：动态添加多条企业需求和注册人才样式
     *参数：无
     */
    gt:function(){
       var len=$("div.list_quire .quire_item").length;
       var l=len-1;
       if(fen==1){
          $("div.relis .quire_item:eq("+l+")").css("border-bottom","none"); 
       }
       if(len>1){
          $("div.list_quire .quire_item").css("border-bottom","1px dashed #ddd"); 
          $("div.list_quire .quire_item:eq("+l+")").css("border-bottom","none");
       }
       var fen=$("div.relis .reg_lisitem").length;
       var f=fen-1;
       if(fen==1){
          $("div.relis .reg_lisitem:eq("+f+")").css("border-bottom","none"); 
       }
       if(fen>1){
          $("div.relis .reg_lisitem").css("border-bottom","1px dashed #ddd"); 
          $("div.relis .reg_lisitem:eq("+f+")").css("border-bottom","none");
       }
    },
    /*
     *功能:验证企业详细基本信息网址|企业资质提示|企业座机格式|邮箱格式验证
     *参数：无
     */
    gu:function(){
     $("#website").focus(function(){
        if($(this).data("cedite")){
            baseRender.a(this,LANGUAGE.L0227,"right");
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
            else if(!/((?:\w{3,5}:\/\/)?(\w)+\.(\w)+\.(\w)+(?:\/?.*))/.test(str)){
                msg=LANGUAGE.L0228;
                b=false;
            }else{
                baseRender.b(this);
            }
            if(!b){
                baseRender.a(this, msg, "error", 0);
            }
           }
     });
      $("#enter_cqual").focus(function(){
         if($(this).data("cedite")){
            baseRender.a(this,LANGUAGE.L0229,"right",50);
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
            else if(/[a-zA-Z0-9\~\!\@\#\$\%\^\&\*\{\}]/.test(str)){
                msg=LANGUAGE.L0230;
                b=false;
            }
            else{
                baseRender.b(this);
            }
            if(!b){
                baseRender.a(this, msg, "error", 0);
            }
           }
     });
     /*手机验证*/
    $("#phone").focus(function(){
           if($(this).data("cedite")){
               baseRender.b(this);
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
                var x=baseRender.d(str);
                if(x==false)
                {
                    msg=LANGUAGE.L0040;
                    b=false;
                }
                else{
                    b=true;
                }
            }
            if(!b){
                baseRender.a(this, msg, "error", 0);
            }
           }
        });
     /*座机验证*/
      $("#fix_phone").focus(function(){
           if($(this).data("cedite")){
               baseRender.a(this,LANGUAGE.L0226,"right");
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
                if(!/^\d{3,4}-\d{7,8}(-\d{3,4})?$/.test(str))
                {
                  msg=LANGUAGE.L0040;
                   b=false;
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.b(this);
            }
        }
     }); 
      $("#fax").focus(function(){
           if($(this).data("cedite")){
               baseRender.a(this,LANGUAGE.L0226,"right");
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
                if(!/^\d{3,4}-\d{7,8}(-\d{3,4})?$/.test(str))
                {
                  msg=LANGUAGE.L0225;
                   b=false;
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }else{
                baseRender.b(this);
            }
        }
     }); 
     /*邮箱验证*/
    $("#uemail").focus(function(){
        if($(this).data("cedite")){
                baseRender.a(this, LANGUAGE.L0239, "right",0);
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
                else if(!/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(str)){
                    msg=LANGUAGE.L0240;
                    b=false;
                }
                if(!b){
                    baseRender.a(this, msg, "error");
                }else{
                    baseRender.b(this);
                }
            }
        });
    },
    /*
    *功能：验证开户名和开户行
    *参数：无
    */
    gv:function(id,lan1,lan2){
      $(id).focus(function(){
         if($(this).data("cedite")){
            baseRender.b(this);
            }
        }).blur(function(){
            if($(this).data("cedite")){
                var str=$(this).val().replace(new RegExp(" ","g"),"");
                $(this).val(str);
                var msg="";
                var b=true;
                if(str==""){
                    msg=lan2;
                    b=false;
                } 
                else if(/[^\u4E00-\u9FA5]/.test(str)){
                    msg=lan1;
                    b=false;
                }
                else{
                    baseRender.b(this);
                }
                if(!b){
                    baseRender.a(this, msg, "error", 0);
                }
            }
        });
    },
    /*
    *功能：验证人才开户行基本信息|文本输入框blur的效果细节修复
    *参数：无
    */
    gw:function(){
       var that=resourcedetailController;
       that.gv("#acount_name",LANGUAGE.L0231,LANGUAGE.L0234);
       that.gv("#bank_name",LANGUAGE.L0232,LANGUAGE.L0235);
       $("#acount_nm").focus(function(){
         if($(this).data("cedite")){
            baseRender.b(this);
            }
        }).blur(function(){
            if($(this).data("cedite")){
                var str=$(this).val().replace(new RegExp(" ","g"),"");
                $(this).val(str);
                var msg="";
                var b=true;
                if(str==""){
                    msg=LANGUAGE.L0236;
                    b=false;
                } 
                 else if(!/^\d{19}$/.test(str)){
                    msg=LANGUAGE.L0233;
                    b=false;
                }
                else{
                    baseRender.b(this);
                }
                if(!b){
                    baseRender.a(this, msg, "error", 0);
                }
            }
        });
    },
    /*
     *功能：补充说明、备注的移除空格处理操作
     *参数：无
     */
    gx:function(){
       $("#bkup,#ect,textarea.cin").blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
             $(this).val(str);
       });
    },
    /******************************************************************************************/
    /*
    * 功能：初始化修改人才页面
    * 参数：无
    * 2012-4-12
    */
    iniuphuman:function(){
        this.dc("div.mod_1 a.base_edit[id!='qalertitem']");
        this.ndc("div.mod_1 a.base_add[id!='qalertitem']");
        this.de();
        this.df();
        this.dj();
        this.dl();
        this.dm();
        this.dn();
        this.dp();
        this.v();
        this.cm();
        this.gq();  
        this.gw();
    },
    /*
    * 功能：初始化修改企业页面
    * 参数：无
    * 2012-4-12
    */
    iniupcompany:function(){
        this.dc("div.mod_1 a.base_edit[id!='cqual'][id!='repn_edit']");
        this.ndc("div.mod_1 a.base_add[id!='cqual'][id!='repn_edit']");
        this.ca();
        this.ca_k();
        this.cb("div.mod_1 #cqual");
        this.ch("div.area_cert a.updecq");
        this.cl("table.tb_cm");
        this.cm();
        this.cn();
        this.co();
        this.cw();
        this.cx();
        this.eb();
        this.ga("div.list_quire,div.relis");
        this.gd("input.qquali");
        this.gg("input.reg_pquali");
        this.ge();
        this.gf("input.date");
        this.gp();
        this.gr(); 
        this.gt();
    },
    /*
    * 功能：初始化公共页
    * 参数：无
    */
    pb:function(){
        baseRender.ae(3);
        this.IniInput();
        this.a();
        this.d();
        this.o();
        this.e();
        this.f();
        this.g();
        this.j($("div.mtitle").next().next());
        this.i("table.tb_cm");
        this.l();
        this.m();
        this.v();
        this.mdn();
        this.gs();
        this.gu();
        this.gx();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    var that=resourcedetailController;
    if(PAGE=="96"){
        that.pb();
        that.iniuphuman();//修改人才页面
    }
    else if(PAGE=="97"){
        that.pb();
        that.iniupcompany();//修改企业页面
    }
});


