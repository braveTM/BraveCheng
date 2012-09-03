/**CRM****/
/****人才资源管理页面控制器****/
var resourceController={
    /*
     * 功能：资源列表分页
     * 参数：
     * id：分页插件的父容器id
     * t：总共的条数
     */
    ap:function(t,id,func){
        var lan=LANGUAGE;
        $(id).pagination(t, {
            callback: func,
            prev_text: lan.L0066,
            next_text: lan.L0067,
            items_per_page:CONSTANT.C0004,
            num_display_entries:9,
            current_page:0,
            num_edge_entries:1,
            link_to:"javascript:;"
        });        
    },
    /*
     *功能：职称证书/证书插件初始化
     *参数：无
     *说明：2012-4-9
    */
    a:function(){
        $("#zsect").hgsSelect({
            type:'jobtitle',
            tid:"tslt",       //职称添加的父容器id
            sure:resourceRender.c,
            gcurl:CRMURL.GetZcType,
            zurl:CRMURL.GetZCname
        }); 
        $("#pqcect").hgsSelect({
            id:"pqselect",             //设置选择框父容器id
            pid:"pregplace",            //省市添加的父容器id
            pshow:false,       //是否显示地区选择
            single:true,       //省是否为单选
            sure:resourceRender.b,
            qurl:CRMURL.GetCertsTpe,
            murl:CRMURL.GetGertMajor
        });
        $("#cqt").hgsSelect({
            id:"pqselect"+1,             //设置选择框父容器id
            pid:"pregplace",            //省市添加的父容器id
            pshow:false,       //是否显示地区选择
            single:true,       //省是否为单选
            sure:resourceRender.cb,
            qurl:CRMURL.GetCertsTpe,
            murl:CRMURL.GetGertMajor
        });
    },
    /*
     *功能：地区插件初始化
     *参数：无
     *说明：2012-4-9
    */
    b:function(){
        $("#pce").hgsSelect({
            type:"place",//选择框类型
            pid:"place",//省id
            pshow:true,//是否显示省
            sprov:true,//是否只精确到省
            single:true,  //是否为单选
            sure:resourceRender.a,
            async:true,//是否异步获取数据
            isshowarea:false,//是否显示地区
            prvurl:CRMURL.GetCrmProvinces
        });
        $("#cplace").hgsSelect({
            type:"place",//选择框类型
            pid:"place"+1,//省id
            pshow:true,//是否显示省
            sprov:true,//是否只精确到省
            single:true,  //是否为单选
            sure:resourceRender.ca,
            async:true,//是否异步获取数据
            isshowarea:false,//是否显示地区
            prvurl:CRMURL.GetCrmProvinces
        });
    },
    /*
     *功能：初始化批量删除人才操作
     *参数：人才ID
     *说明：2012-4-22
    */
    c:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var len=$("input[name='ops']:checked").length;
            $("div").data("obj",$("input[name='ops']:checked"));
            if(len=="0" && $("table.hr_list tr").not("tr.bhead").length!="0"){
                alert('请先选择你要删除的内容');
            }else{
                var meg=confirm('确定删除？');
                    if(meg==true){
                    var ids=$("input[name='ditem']").val();
                    var that=resourceRender;
                    var res=new Resource();
                    res.DeleHumanReource(ids,that.da,that.db);
                }
            }
        });
    },
    /*
     *功能：初始化批量删除企业操作
     *参数：无
     *说明：2012-4-22
    */
    d:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var len=$("input[name='cnames']:checked").length;
            $("div").data("obj",$("input[name='cnames']:checked"));
            if(len=="0" && $("table.er_list tr").not("tr.bh").length!="0"){
                alert('请先选择你要删除的内容');
            }else{
                var mess=confirm('确定删除？');
                if(mess==true){
                    var ids=$("input[name='cdeletm']").val();
                    var that=resourceRender;
                    var res=new Resource();
                    res.DeleCompanyRes(ids,that.ea,that.eb);
                }
            }
        });
    },
    /*
     *功能：复选框点击事件处理
     *参数：无
     */
    e:function(){
        $("span.lt input[name='chos_all'],div.hr_hd input[name='nams']").bind("click",function(){
            resourceRender.e(this);
        });
        $("table.hr_list input[name='ops']").bind("click",function(){
            resourceRender.g(this);
        });
    },
    /*
     *功能：企业资源复选框点击事件处理
     *参数：无
     */
    ce:function(){
        $("span.ct input[name='eall'],div.cp_hd input[name='cm']").bind("click",function(){
            resourceRender.ce(this);
        });
        $("table.er_list input[name='cnames']").bind("click",function(){
            resourceRender.cg(this);
        });
    },
    /*
     *功能：动态改变表单奇数行的背景色
     *参数：无
     */
    f:function(){
        $("table.hr_list tr:even,table.er_list tr:even").addClass("bg");  
    },
    /*
     *功能：获取人才资源列表数据
     *参数：无
     */
    ag:function(i){
        var that=resourceRender;
        resourceController.j(i,that.h,that.i);
    },
    /*
     *获取人才资源分页回调函数
     *参数：无
     */
    h:function(i){
        var that=resourceRender;
        resourceController.j(i,that.j,that.i);
        that.bj();
    },
    /*
     *功能：异步获取人才资源列表数据
     *参数：
     *i：页面
     *size：每页显示数量
     *suc：
     *fail：
     */
    j:function(i,suc,fail){
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var re=new Resource();
        re.GetHumanList(i,10,suc,fail);
    },
    /*
     *功能：获取筛选后的人才资源列表
     *参数:无
     */
    k:function(i){
        var that=resourceRender;
        resourceController.m(i,that.k,that.ak);
    },
    /*
     *获取筛选人才资源分页回调函数
     *参数：无
     */
    l:function(i){
        var that=resourceRender;
        resourceController.m(i,that.j,that.ak);
    },
    /*
     *功能：异步获取筛选的人才资源列表数据
     *参数：
     *i：页面索引
     *size：每页显示数量
     *suc：成功执行函数
     *fail：失败执行函数
     */
    m:function(i,suc,fail){
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var a=$("span.htype").find("a.red").attr("rel"),//类型
        r="",//进度进度
        m="",//注册情况
        n="",//资质证书id
        o="",//报价
        b="",//关键词
        p=$("input[name='jtlid']").val(),//职称等级
        q=$("input[name='jtyid']").val(),//职称类别
        z=$("input[name='jtid']").val(),//职称名称
        s=$("#p1")[0].options[$("#p1")[0].selectedIndex].value,//阶段
        t=$("#perid1")[0].options[$("#perid1")[0].selectedIndex].value,//来源
        u= $("#pce").attr("pid");//省份
        if($("span.hm").hasClass("hidden")){
            r=0;
        }else{
            r=$("#p2")[0].options[$("#p2")[0].selectedIndex].value;
        }
        n=$("input[name='mid']").val();//资质证书ID
        m=$("input[name='rid']").val();//注册情况
        o=$("span.hpce a.red").attr("rel");
        b=$("#hkey").val();
        var re=new Resource();
        re.GetFilterHumanList(i,10,a,s,r,t,n,m,p,q,z,u,o,b,suc,fail);
    },
    /*
     *功能：初始化搜索获取筛选后的资源列表
     *参数：无
     */
    n:function(){
        $("#search").bind("click",function(){
            $("div").data("ele","#search");
            resourceController.k(0);
        });
        $("#csearch").bind("click",function(){
            $("div").data("ele","#csearch");
            resourceController.s(0);
        });
    },
    /*
     *功能：初始化阶段的选择/类型的选择
     *参数：无
     */
    o:function(){
        $("#p1").change(function(){
            var cv=$("#p1")[0].options[$("#p1")[0].selectedIndex].value;
            if(cv=="2"){
                $(this).next("span.pro").removeClass("hidden");
            }else{
                $(this).next("span.pro").addClass("hidden"); 
            }
        });
        $("#cp1").change(function(){
            var cv=$("#cp1")[0].options[$("#cp1")[0].selectedIndex].value;
            if(cv=="2"){
                $(this).next("span.pro").removeClass("hidden");
            }else{
                $(this).next("span.pro").addClass("hidden"); 
            }
        });
        $("span.htype a,span.ctype a").bind("click",function(){
            $(this).parent().find("a.red").removeClass("red");
            $(this).addClass("red");
        });
        $("span.hpce a,span.cpce a").bind("click",function(){
           $(this).parent().find("a.red").removeClass("red");
           $(this).addClass("red");
        });
    },
    /*
     *功能：获取企业资源列表数据
     *参数：无
     */
    p:function(i){
        var that=resourceRender;
        resourceController.r(i,that.l,that.m);
    },
    /*
     *获取企业资源分页回调函数
     *参数：无
     */
    q:function(i){
        var that=resourceRender;
        resourceController.r(i,that.n,that.m);
        that.bj();
    },
    /*
     *功能：异步获取企业资源列表数据
     *参数：
     *i：页面
     *size：每页显示数量
     *suc：
     *fail：
     */
    r:function(i,suc,fail){
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var re=new Resource();
        re.GetCompanresource(i,10,suc,fail);
    },
    /*
     *功能：获取筛选后的企业资源列表数据
     *参数:无
     */
    s:function(i){
        var that=resourceRender;
        resourceController.u(i,that.o,that.p);
    },
    /*
     *获取筛选后的人才资源分页回调函数
     *参数：无
     */
    t:function(i){
        var that=resourceRender;
        resourceController.u(i,that.n,that.p);
    },
    /*
     *功能：异步获取筛选的企业资源列表数据
     *参数：
     *i：页面索引
     *size：每页显示数量
     *suc：成功执行函数
     *fail：失败执行函数
     */
    u:function(i,suc,fail){
        if(typeof(i)=="undefined"){
            i=0;
        }
        i+=1;
        var a=$("span.ctype").find("a.red").attr("rel"),//类型
        r="",//进度进度
        m="",//注册情况
        n="",//专业ID
        o="",//报价
        s=$("#cp1")[0].options[$("#cp1")[0].selectedIndex].value,//阶段
        t=$("#csource")[0].options[$("#csource")[0].selectedIndex].value,//来源
        u= $("#cplace").attr("pid"),//省份
        v=$("#ckey").val();//关键字
        if($("span.cpro").hasClass("hidden")){
            r=0;
        }else{
            r=$("#cp2")[0].options[$("#cp2")[0].selectedIndex].value;
        }
        n=$("input[name='cmid']").val();//资质证书
        m=$("input[name='crid']").val();//注册情况
        o=$("span.cpce a.red").attr("rel");
        var re=new Resource();
        re.GetFilterCmpList(i,10,a,s,r,t,n,m,u,v,o,suc,fail);
    },
    /*
     *修改交易记录
     *参数：
     *id对话框父元素id
     *ajax成功后回调
     *
     */
    v:function(){            
        var prams=resourceController.va;            
        $("a.edt_p").GetManageData(prams);
    },
    /*
     *
     *添加|修改人才页面,请求参数获取
     *参数:me当前事件对象
     *返回prams对象
     */
    va:function(me){
        var that= resourceRender;                
        var status_id;
        var cate_id;
        var pro_id;
        var notes;
        var h_e_id;                                 
        var url,urlops={
            uphuman:CRMURL.UpHumanStatus,
            upenter:CRMURL.UpEnterStatus,
            addhuman:CRMURL.AddHumanStatus,
            addenter:CRMURL.AddEnterStatus
        };
        var id;            
        var prams={};        
        var rd=me.parent().parent().parent();        
        var rel=me.parent().parent();        
        var rectype=me.hasClass('ad_rd');        //rectype:true表示添加数据
        var h_e=rel.attr("rel");
        notes=me.parent().prev().text();
        var pubpram={};        
        if(me.hasClass("edt_p")){
            status_id=me.attr("rel")*1;                   
            h_e_id=rd.prevAll(".cbox").find(".chos").val();
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
                'sc':that.ss             
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
                    url=urlops.uphuman;
                    prams={                    
                        'human_id':h_e_id,
                        'status_id':status_id,
                        'url':url
                    };
                }
            }
            else if(h_e=='false'){//企业               
                pubpram.tosever={
                    'cate_id':cate_id,
                    'pro_id':pro_id
                }
                if(rectype){//企业添加                    
                    url=urlops.addenter;
                    prams={                   
                        'enter_id':h_e_id,
                        'url':url                    
                    }; 
                }else{//企业修改
                    url=urlops.upenter; 
                    prams={                  
                        'enter_id':h_e_id,
                        'status_id':status_id,
                        'url':url,
                        'notes':notes
                    };
                }
            }            
            var catepro=resourceController.vb(me);                        
            $.extend(prams,catepro);            
            $.extend(pubpram.tosever,prams);                  
            return pubpram;  
        }
    },
    /*
     *
     *添加|修改人才页面，阶段参数获取
     *参数:me当前事件对象
     *返回prams对象
     */
    vb:function(me){
        var rectype=me.hasClass('ad_rd');        //rectype:true表示添加数据
        var cate_id,pro_id=0;
        var parms;
        if(rectype){
            cate_id=me.parent().attr("cateid")*1;
            if(cate_id==2)
                pro_id=me.parent().prev().attr("proid")*1;          
        }
        else{
            cate_id=me.parent().next().attr("cateid")*1;
            if(cate_id==2)
               pro_id=me.parent().attr("proid")*1;         
        }
        if(cate_id==0)
            cate_id=1;
        parms={
            'cate_id':cate_id,
            'pro_id':pro_id
            }        
         return parms;
    },
    /*
    *功能：初始化遮罩选择框
    *参数：无
    *
    */
    ma:function(){
        var that=resourceRender;
        $("a.apr").hmark({
            id:"mk",
            type:"1",
            url:CRMURL.AddResourceHuman,
            param:function(){
                var par=$("#mk");
                var rname=par.find("input.rname").val();
                var rsource=par.find("#perid1").val();
                return "name="+rname+"&sour_id="+rsource;
            },
            checknul:function(){
                var tt="";
                var par=$("#mk");
               var rname=par.find("input.rname").val(); 
               if(rname==""){
                   tt="人才姓名不能为空";
               }else{
                   par.find("span.error").text("");
                   tt=true;
               }
               return tt;
            },
            suc:that.ba,
            fail:that.bc
        });
        $("a.adcmp").hmark({
            id:"cmk",
            type:"2",
            url:CRMURL.AddCompanyResource,
            param:function(){
                var par=$("#cmk");
                var rname=par.find("input.cname").val();
                var contr=par.find("input.contacter").val();
                var rsource=par.find("#perid2").val();
                return "name="+rname+"&sour_id="+rsource+"&contracter="+contr;
            },
            checknul:function(){
                var tt="";
                var par=$("#cmk");
               var rname=par.find("input.cname").val(); 
                var contr=par.find("input.contacter").val();
               if(rname==""){
                   tt="企业名称不能为空";
               }
               else if(contr==""){
                   tt="联系人姓名不能为空"; 
               }
               else{
                   par.find("span.error").text("");
                   tt=true;
               }
               return tt;
            },
            suc:that.bd,
            fail:that.bc
        });
    },
       /*
     *功能：导入cvs人才资源
     *参数：无
     *jack
     *2012-4-9
     */
    mb:function(){        
        var upfile=$("#hr_list").siblings(".h_md").find("a.import_human");
        var url=CRMURL.ImportCvsHuman;
        var url_xls=CRMURL.CvsHumanTempXls;
        var att_name='1';                   
        upfile.hmark({
            id:"import_hr",
            type:"4",
            p:{
                url:url,
                att_name:att_name,
                formid:'import_h',
                iframe_id:'Upfile_human_iframe',
                url_xls:url_xls,
                h_e:'人才'
            }
        });        
    },
     /*
     *功能：导入cvs企业资源
     *参数：无
     *jack
     *2012-4-9
     */
    mc:function(){        
        var upfile=$("#cmp_list").siblings(".h_md").find("a.impt_cr");                           
        var att_name='1';            
        var url=CRMURL.ImportCvsCompany; 
        var url_xls=CRMURL.CvsCompanyTempXls
        upfile.hmark({
            id:"import_cmp",
            type:"4",
            p:{
                url:url,
                att_name:att_name,
                formid:'import_c',
                iframe_id:'Upfile_company_iframe',
                url_xls:url_xls,
                h_e:'企业'
            }               
        });        
    },
    /*
     *功能：发送邮件初始化判断
     *参数：无
     */
     md:function(){
         var that=resourceRender;
        $("a.emil_all").hmark({
            id:"hmk",
            type:"3",
            url:CRMURL.SendHumanEmail,
            param:function(){
                var pid;
                var par=$("#hmk");
                var dd=par.find("div.slt_items a");
                $.each(dd,function(i,o){
                    pid=$(o).attr("rel");
                });
                $("input[name='ids']").val(pid);
                var tl=par.find("input.tbox").val();
                var ct=par.find("textarea.cin").val();
                return "ids="+$("input[name='ids']").val()+"&title="+tl+"&content="+ct;
            },
            iniSltFun:function(){
              var p1=$("input[name='ditem']").val().split(",");
              var p2=$("input[name='peoples']").val().split(",");
              var ret={};
              if(p1==""){
                  ret.ret=false;
              }else{
                 var dt=[];
                 $.each(p1,function(i,o){
                     var tmp={};
                     tmp.id=o;
                     tmp.name=p2[i];
                     dt[i]=tmp;
                 });
                 ret.ret=true;
                 ret.data=dt;
              }
              return ret;
            },
            delitBack:function(id){
                $("input[name='ops'][value='"+id+"']").trigger("click");
            },
            checknul:function(){
                var tt="";
                var par=$("#hmk");
                var tl=par.find("input.tbox").val();
                var ct=par.find("textarea.cin").val();
                if(tl==""){
                    tt="邮件主题不能为空";
                }else if(ct==""){
                    tt="邮件内容不能为空";
                }else{
                  par.find("span.error").text("");
                   tt=true; 
                }
                return tt;
            },
            suc:that.bg,
            fail:that.bc
        });
     },
        /*
     *功能：企业发送邮件初始化判断
     *参数：无
     */
     me:function(){
         var that=resourceRender;
        $("a.email_company").hmark({
            id:"cemail",
            type:"3",
            url:CRMURL.SendCompanyEmail,
            param:function(){
                var pid;
                var par=$("#cemail");
                var dd=par.find("div.slt_items a");
                $.each(dd,function(i,o){
                    if(i==0){
                        pid=$(o).attr("rel");
                    }else{
                         pid=","+$(o).attr("rel");
                    }
                });
                $("input[name='ids']").val(pid);
                var tl=par.find("input.tbox").val();
                var ct=par.find("textarea.cin").val();
                return "ids="+$("input[name='ids']").val()+"&title="+tl+"&content="+ct;
            },
            iniSltFun:function(){
              var p1=$("input[name='cdeletm']").val().split(",");
              var p2=$("input[name='cpeos']").val().split(",");
              var ret={};
              if(p1==""){
                  ret.ret=false;
              }else{
                 var dt=[];
                 $.each(p1,function(i,o){
                     var tmp={};
                     tmp.id=o;
                     tmp.name=p2[i];
                     dt[i]=tmp;
                 });
                 ret.ret=true;
                 ret.data=dt;
              }
              return ret;
            },
            delitBack:function(id){
                $("input[name='cnames'][value='"+id+"']").trigger("click");
            },
            checknul:function(){
                var tt="";
                var par=$("#cemail");
                var tl=par.find("input.tbox").val();
                var ct=par.find("textarea.cin").val();
                if(tl==""){
                    tt="邮件主题不能为空";
                }else if(ct==""){
                    tt="邮件内容不能为空";
                }else{
                  par.find("span.error").text("");
                   tt=true; 
                }
                return tt;
            },
            suc:that.bg,
            fail:that.bc
        });
     },
    /*
     *功能：初始化按钮
     *参数：无
     */
    mf:function(){
       baseController.BtnBind(".btn4", "btn4", "btn4_hov", "btn4_click"); 
    },
     /*
     *功能：资质清空选中框内容
     *参数：无
     */
    mg:function(obj){
        $(obj).unbind("click").bind("click",function(){
            $(this).parent().find("input[type='hidden']").val("");
            $(this).prev().val("");
            $(this).remove();
        });
    },
    /*
     *功能：地区清空选中区域
     *参数：无
     */
    mh:function(obj){
       $(obj).unbind("click").bind("click",function(){
            $(this).prev().val("");
            $(this).prev().attr("pid","");
            $(this).remove();
        });  
    },
     /*
     *功能：新窗口打开客户详细页面事件绑定
     *参数：无
     */
    mi:function(obj){
       $(obj).unbind("click").bind("click",function(e){
          e.preventDefault();
          var url=$(this).attr("href");
          var height= window.screen.height;
         resourceRender.OpenWin(url,880,height);
       });
    },
    /*
     *功能：初始化页面
     *参数：无
     *jack
     *2012-4-9
     */
    i:function(){
        baseRender.ae(3);
        this.a();
        this.c("a.dele_human");
        this.d("a.dele_company");
        this.b();
        this.e();
        this.ce();
        this.f();
        this.ag(0);
        this.o();
        this.n();
        this.p(0);
        this.ma();  
        this.mb();
        this.mc();
        this.ma();
        this.md();
        this.me();
        this.mf(); 
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    if(PAGE=="95"){
        resourceController.i();
    }
});
